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

        $receipts = Receipts::with(['supplier', 'user', 'details.equipments'])->paginate(10);

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

        return view("{$this->route}.import_warehouse.add_import", [
            'title' => $title,
            'inventories' => $inventories,
            'suppliers' => $suppliers,
            'users' => $users,
        ]);
    }

    public function store_import(Request $request)
    {
        // Lấy dữ liệu từ JSON materialData đã gửi từ form
        $materialData = json_decode($request->input('materialData'), true);

        $status = $request->input('status');

        if (empty($materialData)) {
            toastr()->error('Đã lưu phiếu nhập kho thất bại ');
            return redirect()->back();
        }

        // Lấy thông tin của phiếu nhập từ phần tử đầu tiên của materialData
        $receiptData = [
            'supplier_code' => $materialData[0]['supplier_code'],
            'receipt_date' => $materialData[0]['receipt_date'],
            'note' => $materialData[0]['note'],
            'created_by' => $materialData[0]['created_by'],
            'receipt_no' => $materialData[0]['receipt_no'] ?? null,
            'status' => $status
        ];

        // Lấy mã phiếu nhập cuối cùng từ cơ sở dữ liệu
        $lastReceipt = Receipts::orderBy('created_at', 'desc')->first();

        // Kiểm tra nếu có phiếu nhập trước đó
        if ($lastReceipt) {
            // Lấy số phía sau mã "REC" và tăng lên 1
            $lastReceiptNumber = intval(substr($lastReceipt->code, 3));
            $newReceiptNumber = $lastReceiptNumber + 1;
        } else {
            // Nếu không có phiếu nhập trước, bắt đầu với số 1
            $newReceiptNumber = 1;
        }

        // Tạo mã phiếu nhập mới với tiền tố "REC" và số mới (đảm bảo đủ 4 chữ số)
        $newReceiptCode = 'REC' . str_pad($newReceiptNumber, 4, '0', STR_PAD_LEFT);

        // Thêm mã phiếu nhập vào dữ liệu phiếu nhập (khóa chính là 'code')
        $receiptData['code'] = $newReceiptCode;

        // Lưu dữ liệu vào bảng receipts
        $receipt = Receipts::create($receiptData);

        // Kiểm tra nếu việc lưu thành công
        if (!$receipt) {
            toastr()->error('Lỗi khi lưu phiếu nhập kho.');
            return redirect()->back();
        }

        // Bây giờ lấy được `receipt_code` từ đối tượng phiếu nhập
        $receiptCode = $receipt->code;


        // Chuẩn bị dữ liệu cho bảng receipt_details
        $receiptDetailsData = [];

        foreach ($materialData as $material) {
            $receiptDetailsData[] = [
                'receipt_code' => $receiptCode,
                'equipment_code' => $material['equipment_code'],
                'batch_number' => $material['batch_number'],
                'expiry_date' => $material['expiry_date'],
                'price' => $material['price'],
                'quantity' => $material['quantity'],
                'discount' => $material['discount'],
                'VAT' => $material['VAT'],
            ];
        }

        // Lưu dữ liệu vào bảng receipt_details
        try {
            Receipt_details::insert($receiptDetailsData);
        } catch (\Exception $e) {
            toastr()->error('Lỗi khi lưu chi tiết phiếu nhập kho: ' . $e->getMessage());
            return redirect()->back();
        }

        // Cập nhật kho theo lô

        if ($status == 1) {
            foreach ($materialData as $material) {
                $this->updateInventoryByBatch($material, $receiptCode, $receipt->receipt_date);
            }
        }

        // Thông báo thành công
        if ($status == 1) {
            toastr()->success('Đã lưu phiếu nhập kho thành công với mã ' . $receiptCode);
        } else {
            toastr()->warning('Phiếu tạm đã được lưu với mã ' . $receiptCode);
        }

        return redirect()->route('warehouse.import');
    }

    // Hàm cập nhật số lượng tồn kho theo từng lô
    private function updateInventoryByBatch($material, $receiptCode, $receiptDate)
    {
        // Tìm lô hàng trong kho dựa vào mã thiết bị và số lô
        $inventory = Inventories::where('equipment_code', $material['equipment_code'])
            ->where('batch_number', $material['batch_number'])
            ->where('current_quantity', '>', 0)
            ->first();

        // dd($inventory);

        if ($inventory) {
            // Nếu lô hàng đã tồn tại, cộng thêm số lượng vào lô này
            $inventory->current_quantity += $material['quantity'];
            $inventory->save();
        } else {
            // Nếu chưa có, tạo mới record trong bảng inventories
            $newInventoryCode = 'INV' . str_pad(Inventories::count() + 1, 4, '0', STR_PAD_LEFT);
            // Nếu là lô mới, tạo bản ghi mới trong bảng inventories
            Inventories::create([
                'code' => $newInventoryCode,
                'equipment_code' => $material['equipment_code'],
                'batch_number' => $material['batch_number'],
                'current_quantity' => $material['quantity'],
                'import_code' => $receiptCode,
                'import_date' => $receiptDate,
                'expiry_date' => $material['expiry_date'],
            ]);
        }
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

    public function approve($code)
    {
        // Tìm phiếu nhập theo mã code
        $receipt = Receipts::where('code', $code)->first();

        // Kiểm tra trạng thái phiếu nhập (chỉ duyệt nếu trạng thái là 0)
        if ($receipt && $receipt->status == 0) {
            // Thay đổi trạng thái phiếu nhập từ 0 sang 1 (đã duyệt)
            $receipt->status = 1;
            $receipt->save();

            // Lấy tất cả các chi tiết phiếu nhập liên quan
            $receiptDetails = Receipt_details::where('receipt_code', $code)->get();

            // Cập nhật kho theo lô cho từng chi tiết phiếu nhập
            foreach ($receiptDetails as $detail) {
                $material = [
                    'equipment_code' => $detail->equipment_code,
                    'batch_number' => $detail->batch_number,
                    'expiry_date' => $detail->expiry_date,
                    'quantity' => $detail->quantity,
                ];

                // Gọi hàm cập nhật kho
                $this->updateInventoryByBatch($material, $receipt->code, $receipt->receipt_date);
            }

            toastr()->success('Đã duyệt phiếu nhập kho thành công với mã ' . $receipt->code);
            return redirect()->back();
        }

        toastr()->success('Phiếu đã được duyệt trước đó.');
        return redirect()->back();
    }

    public function searchImport(Request $request)
    {
        $title = 'Nhập Kho';

        // Lấy thông tin tìm kiếm từ form
        $query = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $supplierCode = $request->input('supplier_code');
        $createdBy = $request->input('created_by');

        // Tạo câu query tìm kiếm
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
}
