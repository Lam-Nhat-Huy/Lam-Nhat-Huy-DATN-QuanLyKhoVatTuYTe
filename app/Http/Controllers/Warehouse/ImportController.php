<?php

namespace App\Http\Controllers\Warehouse;

use App\Exports\ReceiptsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImportRequest;
use App\Imports\ReceiptsImport;
use App\Models\Equipments;
use App\Models\Inventories;
use App\Models\Receipt_details;
use App\Models\Receipts;
use App\Models\Suppliers;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    protected $route = 'warehouse';

    public function import()
    {
        $title = 'Nhập Kho';

        $receipts = Receipts::with(['supplier', 'user', 'details.equipments'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);


        $allReceiptCount = Receipts::all()->count();

        $draftReceiptsCount = Receipts::where('status', 0)->count();

        $approvedReceiptsCount = Receipts::where('status', 1)->count();

        $suppliers = Suppliers::all();

        $users = Users::all();

        return view("{$this->route}.import_warehouse.import", [
            'title' => $title,
            'receipts' => $receipts,
            'suppliers' => $suppliers,
            'users' => $users,
            'draftReceiptsCount' => $draftReceiptsCount,
            'approvedReceiptsCount' => $approvedReceiptsCount,
            'allReceiptCount' => $allReceiptCount
        ]);
    }

    public function create_import()
    {
        $title = 'Tạo Phiếu Nhập Kho';

        $inventories = Equipments::all();

        $suppliers = Suppliers::all();

        $users = Users::all();

        $equipmentsWithStock = Equipments::all();

        return view("{$this->route}.import_warehouse.create_import", [
            'title' => $title,
            'inventories' => $inventories,
            'suppliers' => $suppliers,
            'users' => $users,
            'equipmentsWithStock' => $equipmentsWithStock
        ]);
    }

    public function store_import(Request $request)
    {
        $equipmentData = json_decode($request->input('equipmentData'), true);
        $status = $request->input('status');

        if (empty($equipmentData)) {
            toastr()->error('Đã lưu phiếu nhập kho thất bại ');
            return redirect()->back();
        }

        foreach ($equipmentData as $equipment) {
            $existingInventory = Inventories::where('batch_number', $equipment['batch_number'])
                ->where('equipment_code', $equipment['equipment_code'])
                ->first();

            if ($existingInventory) {
                toastr()->error('Số lô ' . $equipment['batch_number'] . ' đã tồn tại cho thiết bị ' . $equipment['equipment_code']);
                return redirect()->back();
            }
        }

        $receiptData = [
            'supplier_code' => $equipmentData[0]['supplier_code'],
            'receipt_date' => $equipmentData[0]['receipt_date'],
            'note' => $equipmentData[0]['note'],
            'created_by' => $equipmentData[0]['created_by'],
            'receipt_no' => $equipmentData[0]['receipt_no'] ?? null,
            'status' => $status
        ];

        $newReceiptCode = 'PN' . $this->generateRandomString();
        $receiptData['code'] = $newReceiptCode;

        $receipt = Receipts::create($receiptData);

        if (!$receipt) {
            toastr()->error('Lỗi khi lưu phiếu nhập kho.');
            return redirect()->back();
        }

        $receiptCode = $receipt->code;
        $receiptDetailsData = [];

        foreach ($equipmentData as $equipment) {
            $receiptDetailsData[] = [
                'receipt_code' => $receiptCode,
                'equipment_code' => $equipment['equipment_code'],
                'batch_number' => $equipment['batch_number'],
                'expiry_date' => $equipment['expiry_date'],
                'price' => $equipment['price'],
                'quantity' => $equipment['quantity'],
                'discount' => $equipment['discount'],
                'VAT' => $equipment['VAT'],
                'manufacture_date' => $equipment['product_date'],
            ];
        }

        try {
            Receipt_details::insert($receiptDetailsData);
        } catch (\Exception $e) {
            toastr()->error('Lỗi khi lưu chi tiết phiếu nhập kho: ' . $e->getMessage());
            return redirect()->back();
        }

        if ($status == 1) {
            foreach ($equipmentData as $equipment) {
                $this->updateInventoryByBatch($equipment, $receiptCode, $receipt->receipt_date);
            }
        }

        toastr()->success('Đã lưu phiếu nhập kho thành công với mã ' . $receiptCode);
        return redirect()->route('warehouse.import');
    }

    public function checkBatchNumber($batch_number, $equipment_code)
    {
        // Kiểm tra xem số lô đã tồn tại chưa
        $existingInventory = Inventories::where('batch_number', $batch_number)
            ->first();

        // Trả về phản hồi dưới dạng JSON
        if ($existingInventory) {
            return response()->json(['exists' => true], 200);
        }

        return response()->json(['exists' => false], 200);
    }

    private function updateInventoryByBatch($equipment, $receiptCode, $receiptDate)
    {
        $inventory = Inventories::where('equipment_code', $equipment['equipment_code'])
            ->where('batch_number', $equipment['batch_number'])
            ->where('current_quantity', '>', 0)
            ->first();

        if ($inventory) {
            $inventory->current_quantity += $equipment['quantity'];
            $inventory->save();
        } else {
            $newInventoryCode = 'TK' . $this->generateRandomString();

            $payload = [
                'code' => $newInventoryCode,
                'equipment_code' => $equipment['equipment_code'],
                'batch_number' => $equipment['batch_number'],
                'current_quantity' => $equipment['quantity'],
                'import_code' => $receiptCode,
                'import_date' => $receiptDate,
                'expiry_date' => $equipment['expiry_date'],
                'manufacture_date' => $equipment['product_date'],
            ];

            Inventories::create($payload);
        }
    }

    public function approve($code)
    {
        $receipt = Receipts::where('code', $code)->first();

        if ($receipt && $receipt->status == 0) {
            $receipt->status = 1;
            $receipt->save();

            $receiptDetails = Receipt_details::where('receipt_code', $code)->get();

            foreach ($receiptDetails as $detail) {
                $equipment = [
                    'equipment_code' => $detail->equipment_code,
                    'batch_number' => $detail->batch_number,
                    'expiry_date' => $detail->expiry_date,
                    'quantity' => $detail->quantity,
                    'product_date' => $detail->manufacture_date,
                ];

                $this->updateInventoryByBatch($equipment, $receipt->code, $receipt->receipt_date);
            }

            toastr()->success('Đã duyệt phiếu nhập kho thành công với mã ' . $receipt->code);
            return redirect()->back();
        }

        toastr()->success('Phiếu đã được duyệt trước đó.');
        return redirect()->back();
    }

    public function getEquipmentData($code)
    {
        $equipment = Equipments::where('code', $code)->first();

        if ($equipment) {
            return response()->json([
                'price' => $equipment->price,
                'batch_number' => $equipment->batch_number,
                'product_date' => $equipment->product_date,
                'expiry_date' => $equipment->expiry_date
            ]);
        }

        return response()->json(null, 404);
    }

    public function searchImport(Request $request)
    {
        $title = 'Nhập Kho';

        $query = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $supplierCode = $request->input('supplier_code');
        $createdBy = $request->input('created_by');

        $receipts = Receipts::where(function ($q) use ($query) {
            $q->where('code', 'LIKE', "%{$query}%")
                ->orWhere('receipt_no', 'LIKE', "%{$query}%");
        })
            ->when($startDate, function ($q) use ($startDate) {
                return $q->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                return $q->whereDate('created_at', '<=', $endDate);
            })
            ->when($supplierCode, function ($q) use ($supplierCode) {
                return $q->where('supplier_code', $supplierCode);
            })
            ->when($createdBy, function ($q) use ($createdBy) {
                return $q->where('created_by', $createdBy);
            })
            ->get();

        return view("{$this->route}.import_warehouse.search", [
            'title' => $title,
            'receipts' => $receipts
        ]);
    }

    public function delete($code)
    {
        $receipt = Receipts::where('code', $code)->first();

        if (!$receipt) {
            toastr()->error('Không tìm thấy phiếu nhập kho.');
            return redirect()->back();
        }

        if ($receipt->status == 1) {
            toastr()->error('Không thể xóa phiếu đã được duyệt.');
            return redirect()->back();
        }

        Receipt_details::where('receipt_code', $code)->delete();

        $receipt->delete();

        toastr()->success('Đã xóa phiếu nhập kho thành công.');
        return redirect()->back();
    }

    public function exportExcel()
    {
        return Excel::download(new ReceiptsExport, 'receipts_sample.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx|max:10240', // tối đa 10MB
        ]);

        Excel::import(new ReceiptsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Dữ liệu đã được nhập thành công!');
    }

    function generateRandomString($length = 9)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}