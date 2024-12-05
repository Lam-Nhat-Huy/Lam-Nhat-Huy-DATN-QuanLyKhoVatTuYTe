<?php

namespace App\Http\Controllers\Warehouse;

use App\Exports\ReceiptsExport;
use App\Http\Controllers\Controller;
use App\Imports\ReceiptsImport;
use App\Models\Equipments;
use App\Models\Import_equipment_request_details;
use App\Models\Import_equipment_requests;
use App\Models\Inventories;
use App\Models\Inventory_checks;
use App\Models\Notifications;
use App\Models\Receipt_details;
use App\Models\Receipts;
use App\Models\Suppliers;
use App\Models\Users;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    protected $route = 'warehouse';

    protected $Notifications;

    public function __construct()
    {
        $this->Notifications = new Notifications();

        if ($this->Notifications->firstLockWarehouse() == 1) {
            return abort(403);
        }
    }

    public function import(Request $request)
    {
        $title = 'Nhập Kho';

        $allReceiptCount = Receipts::all()->count();

        $draftReceiptsCount = Receipts::where('status', 0)->count();

        $approvedReceiptsCount = Receipts::where('status', 1)->count();

        $tempReceiptsCount = Receipts::where('status', 3)->count();

        $suppliers = Suppliers::all();

        $users = Users::all();

        $kw = $request->input('kw');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $supplierCode = $request->input('spl');
        $status = $request->input('stt');
        $createdBy = $request->input('us');

        $receipts = Receipts::with(['supplier', 'user', 'details.equipments'])
            ->orderBy('created_at', 'desc')
            ->whereNull('deleted_at')
            ->when($startDate, function ($q) use ($startDate) {
                return $q->whereDate('receipt_date', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                return $q->whereDate('receipt_date', '<=', $endDate);
            });

        if (isset($kw)) {
            $receipts = $receipts->where(function ($q) use ($kw) {
                $q->where('code', 'LIKE', '%' . $kw . '%')
                    ->orWhere('receipt_no', 'LIKE', "%{$kw}%");
            });
        }

        if (isset($supplierCode)) {
            $receipts = $receipts->where('supplier_code', $supplierCode);
        }

        if (isset($status)) {
            $receipts = $receipts->where('status', $status);
        }

        if (isset($createdBy)) {
            $receipts = $receipts->where('created_by', $createdBy);
        }

        $receipts = $receipts->paginate(10);

        if (!empty($request->import_codes)) {

            if ($request->action_type === 'browse') {

                $getReceipt = Receipts::whereIn('code', $request->import_codes)->where('status', 0);

                $getReceipt->update(['status' => 1, 'browse_by' => session('user_code')]);

                $receiptDetails = Receipt_details::whereIn('receipt_code', $request->import_codes)->get();

                foreach ($receiptDetails as $item) {
                    // Tìm bản ghi inventory theo batch_number và equipment_code từ $item
                    $countQuantityInventoryWhere = Inventories::where('batch_number', $item->batch_number)
                        ->where('equipment_code', $item->equipment_code)
                        ->first();

                    // Nếu tìm thấy trong Inventories thì cộng số lượng
                    $current_quantity = $countQuantityInventoryWhere ? $countQuantityInventoryWhere->current_quantity + $item->quantity : $item->quantity;

                    // Cập nhật hoặc tạo mới Inventory
                    Inventories::updateOrCreate(
                        [
                            'batch_number' => $item->batch_number,
                            'equipment_code' => $item->equipment_code
                        ],
                        [
                            'code' => $countQuantityInventoryWhere ? $countQuantityInventoryWhere->code : 'TK' . $this->generateRandomString(8),
                            'batch_number' => $item->batch_number,
                            'current_quantity' => $current_quantity,
                            'import_code' => $item->receipt_code,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                toastr()->success('Duyệt phiếu chờ thành công');

                return redirect()->back();
            } elseif ($request->action_type === 'delete') {

                Receipts::whereIn('code', $request->import_codes)
                    ->where('created_by', session('user_code'))
                    ->whereNull('order_number')
                    ->where(function ($query) {
                        $query->where('status', 0)
                            ->orWhere('status', 3);
                    })
                    ->update(['deleted_by' => session('user_code')]);

                Receipts::whereIn('code', $request->import_codes)
                    ->where('created_by', session('user_code'))
                    ->whereNull('order_number')
                    ->where(function ($query) {
                        $query->where('status', 0)
                            ->orWhere('status', 3);
                    })
                    ->delete();

                toastr()->success('Hủy phiếu nhập thường của bạn thành công');

                return redirect()->back();
            }
        }

        if (!empty($request->no_browse_request)) {
            $reason_refuse = $request->reason_refuse;
            $user_request = $request->user_request;
            $email_user_request = $request->email_user_request;

            if (!empty($reason_refuse) && $reason_refuse === 'other') {
                $reason_refuse = $request->reason_refuse_other;
            }

            Receipts::where('code', $request->no_browse_request)
                ->where('status', 0)
                ->update([
                    'reason_refuse' => $reason_refuse,
                    'browse_by' => session('user_code'),
                    'status' => 5,
                ]);

            $contentNotification = '
                <p>Phiếu nhập kho với mã <a class="text-primary fw-bolder text-decoration-underline" href="' . route('warehouse.import') . '?kw=' . $request->no_browse_request . '">#' . $request->no_browse_request . '</a> được tạo bởi <a class="text-dark fw-bolder text-decoration-underline" href="' . route('user.index') . '?kw=' . $email_user_request . '">' . $user_request . '</a> đã bị <span class="text-danger fw-bolder">từ chối</span> bởi lý do <strong>' . $reason_refuse . '</strong>, vui lòng liên hệ đến ban quản lý kho để được xử lý.</p>
            ';

            Notifications::create([
                'code' => 'TB' . $this->generateRandomString(8),
                'content' => $contentNotification,
                'user_code' => session('user_code'),
            ]);

            toastr()->success('Đã từ chối phiếu nhập kho');

            return redirect()->back();
        }

        return view("{$this->route}.import_warehouse.import", [
            'title' => $title,
            'receipts' => $receipts,
            'suppliers' => $suppliers,
            'users' => $users,
            'draftReceiptsCount' => $draftReceiptsCount,
            'approvedReceiptsCount' => $approvedReceiptsCount,
            'allReceiptCount' => $allReceiptCount,
            'tempReceiptsCount' => $tempReceiptsCount
        ]);
    }

    public function importTrash(Request $request)
    {
        $title = 'Nhập Kho';

        $allReceiptCount = Receipts::onlyTrashed()->count();

        $draftReceiptsCount = Receipts::where('status', 0)->onlyTrashed()->count();

        $approvedReceiptsCount = Receipts::where('status', 1)->onlyTrashed()->count();

        $tempReceiptsCount = Receipts::where('status', 3)->onlyTrashed()->count();

        $suppliers = Suppliers::all();

        $users = Users::all();

        $receiptTrash = Receipts::with(['supplier', 'user', 'details.equipments'])
            ->where('created_by', session('user_code'))
            ->orderBy('deleted_at', 'desc')
            ->onlyTrashed()
            ->paginate(10);

        if (!empty($request->import_codes)) {

            if ($request->action_type === 'restore') {

                Receipts::whereIn('code', $request->import_codes)
                    ->where('created_by', session('user_code'))
                    ->onlyTrashed()
                    ->restore();

                toastr()->success('Khôi phục thành công');

                return redirect()->back();
            } elseif ($request->action_type === 'delete') {

                Receipts::whereIn('code', $request->import_codes)
                    ->where('created_by', session('user_code'))
                    ->onlyTrashed()
                    ->forceDelete();

                toastr()->success('Xóa vĩnh viễn thành công');

                return redirect()->back();
            }
        }

        if (!empty($request->restore_value)) {
            $receipt = Receipts::where('code', $request->restore_value)->onlyTrashed()->first();

            if ($receipt->status == 1) {
                $this->updateInventories($request->restore_value, '+');
            }

            $receipt->restore();

            toastr()->success('Khôi phục thành công');

            return redirect()->back();
        }

        if (!empty($request->delete_value)) {

            $receipt = Receipts::where('code', $request->delete_value)->onlyTrashed()->first();

            if ($receipt->order_number) {
                Import_equipment_requests::where('code', $receipt->order_number)->forceDelete();
            }

            $receipt->forceDelete();

            toastr()->success('Xóa vĩnh viễn thành công');

            return redirect()->back();
        }

        return view("{$this->route}.import_warehouse.trash", [
            'title' => $title,
            'receiptTrash' => $receiptTrash,
            'suppliers' => $suppliers,
            'users' => $users,
            'draftReceiptsCount' => $draftReceiptsCount,
            'approvedReceiptsCount' => $approvedReceiptsCount,
            'allReceiptCount' => $allReceiptCount,
            'tempReceiptsCount' => $tempReceiptsCount
        ]);
    }

    public function create_import(Request $request)
    {
        session()->forget(['ier', 'mapn']);

        if (isset($request->cd) && empty($request->type)) {

            $checkExportRequestCode = Receipts::where('order_number', $request->cd)->where('status', '!=', 5)->first();

            if ($checkExportRequestCode) {
                toastr()->info('Phiếu yêu cầu mua hàng này đã được tạo phiếu nhập và ở trạng thái chờ duyệt');
                return redirect()->route('equipment_request.import');
            }
        } elseif (!empty($request->type)) {
            $rs = Receipts::where('order_number', $request->cd)->first();
            session()->put('ier', $request->cd);
            session()->put('mapn', $rs->code);
        }

        $title = 'Tạo Phiếu Nhập Kho';

        $action = 'create';

        $suppliers = Suppliers::all();

        $users = Users::all();

        $getListIERD = '';

        $infoIER = '';

        $equipmentsWithStock = Equipments::all();

        if (
            !empty($request->equipment) &&
            !empty($request->price) &&
            !empty($request->batch_number) &&
            !empty($request->quantity)
        ) {
            $equipment = Equipments::where('code', $request->equipment)->first();

            if ($equipment) {
                return response()->json([
                    'success' => true,
                    'equipment_code' => $equipment->code,
                    'equipment_name' => $equipment->name,
                    'price' => $request->price,
                    'batch_number' => $request->batch_number,
                    'quantity' => $request->quantity,
                    'discount_rate' => $request->discount_rate ?? 0,
                    'vat' => $equipment->vat ?? 0,
                ]);
            }
        }

        if (isset($request->cd) && isset($request->type)) {
            $infoIER = Receipts::with(['supplier', 'user', 'details'])
                ->where('order_number', $request->cd)
                ->whereNull('deleted_at')
                ->first();

            $getListIERD = Receipt_details::where('receipt_code', $infoIER->code)->get();
        } elseif (isset($request->cd)) {
            $getListIERD = Import_equipment_request_details::where('import_request_code', $request->cd)->get();

            $infoIER = Import_equipment_requests::with(['suppliers', 'users', 'import_equipment_request_details'])
                ->where('code', $request->cd)
                ->whereNull('deleted_at')
                ->first();
        }

        return view("{$this->route}.import_warehouse.create_import", [
            'title' => $title,
            'suppliers' => $suppliers,
            'users' => $users,
            'equipmentsWithStock' => $equipmentsWithStock,
            'action' => $action,
            'getListIERD' => $getListIERD,
            'infoIER' => $infoIER,
        ]);
    }

    public function store_import(Request $request)
    {
        if (
            !empty($request->supplier_code) &&
            !empty($request->receipt_no) &&
            !empty($request->importEquipmentStatus) &&
            !empty($request->equipment_list)
        ) {
            $supplierCode = $request->supplier_code;
            $receiptNo = $request->receipt_no;
            $note = $request->note;
            $equipmentList = json_decode($request->equipment_list, true);

            $record = Receipts::create([
                'code' => 'PN' . $this->generateRandomString(8),
                'supplier_code' => $supplierCode,
                'note' => $note ?? '',
                'status' => $request->importEquipmentStatus == 4 ? 0 : $request->importEquipmentStatus,
                'receipt_no' => $receiptNo,
                'receipt_date' => now(),
                'receipt_type' => 'Nhập Từ Nhà Cung Cấp',
                'created_by' => session('user_code'),
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ]);

            if ($record) {
                foreach ($equipmentList as $equipment) {
                    Receipt_details::create([
                        'receipt_code' => $record->code,
                        'batch_number' => $equipment['batch_number'],
                        'quantity' => $equipment['quantity'],
                        'VAT' => $equipment['vat'],
                        'discount' => $equipment['discount_rate'],
                        'price' => $equipment['price'],
                        'equipment_code' => $equipment['equipment_code'],
                        'created_at' => now(),
                        'updated_at' => null,
                        'deleted_at' => null,
                    ]);
                }

                return response()->json(['success' => true, 'message' => 'Đã tạo phiếu nhập']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Vui lòng điền đẩy đủ các trường dữ liệu']);
    }

    // Tạo phiếu nhập bằng yêu cầu mua hàng
    public function import_equipment_request(Request $request)
    {
        // try {
        if (
            !empty($request->supplier_code) &&
            !empty($request->receipt_no) &&
            !empty($request->importEquipmentStatus) &&
            !empty($request->equipment_list)
        ) {
            $supplierCode = $request->supplier_code;
            $receiptNo = $request->receipt_no;
            $orderNumber = $request->order_number;
            $note = $request->note;
            $equipmentList = json_decode($request->equipment_list, true);

            if (!empty(session('ier'))) {
                Receipts::where('order_number', session('ier'))->forceDelete();
            }

            // Tạo phiếu nhập
            $record = Receipts::create([
                'code' => !empty(session('mapn')) ? session('mapn') : 'PN' . $this->generateRandomString(8),
                'supplier_code' => $supplierCode,
                'note' => $note ?? '',
                'status' => 0,
                'order_number' => $orderNumber,
                'receipt_no' => $receiptNo,
                'receipt_date' => now(),
                'receipt_type' => 'Nhập Từ Nhà Cung Cấp',
                'created_by' => session('user_code'),
                'created_at' => now(),
                'updated_by' => !empty(session('mapn')) ? session('user_code') : null,
                'updated_at' => !empty(session('mapn')) ? now() : null,
                'deleted_at' => null,
            ]);

            // Tạo chi tiết phiếu nhập
            if ($record) {
                foreach ($equipmentList as $equipment) {
                    Receipt_details::create([
                        'receipt_code' => $record->code,
                        'batch_number' => $equipment['batch_number'],
                        'quantity' => $equipment['quantity'],
                        'quantity_quote' => $equipment['quantityQuote'],
                        'deviation_quote' => $equipment['deviation_quote'],
                        'VAT' => $equipment['vat'],
                        'discount' => $equipment['discount_rate'],
                        'price' => $equipment['price'],
                        'equipment_code' => $equipment['equipment_code'],
                        'created_at' => now(),
                        'updated_at' => null,
                        'deleted_at' => null,
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Đã tạo phiếu nhập và đang chờ duyệt']);
        }

        return response()->json(['success' => false, 'message' => 'Vui lòng điền đẩy đủ các trường dữ liệu']);
        // } catch (\Throwable $th) {
        //     return response()->json(['success' => false, 'message' => $th->getMessage()]);
        // }
    }

    public function edit_import($code)
    {
        $title = 'Tạo Phiếu Nhập Kho';

        $action = 'update';

        $AllSupplier = Suppliers::orderBy('created_at', 'DESC')->get();

        $AllEquipment = Equipments::orderBy('created_at', 'DESC')->get();

        $equipmentDetail = Receipt_details::where('receipt_code', $code);

        $getList = $equipmentDetail->get();

        $checkList = $equipmentDetail->pluck('equipment_code')->toArray();

        $editForm = Receipts::with(['supplier', 'user', 'details.equipments'])
            ->where('code', $code)
            ->whereNull('deleted_at')
            ->first();

        return view("{$this->route}.import_warehouse.create_import", [
            'title' => $title,
            'suppliers' => $AllSupplier,
            'equipmentsWithStock' => $AllEquipment,
            'getList' => $getList,
            'checkList' => $checkList,
            'editForm' => $editForm,
            'action' => $action
        ]);
    }

    public function update_import(Request $request, $code)
    {
        if (
            !empty($request->supplier_code) &&
            !empty($request->receipt_no) &&
            !empty($request->importEquipmentStatus) &&
            !empty($request->equipment_list)
        ) {
            $supplierCode = $request->supplier_code;
            $receiptNo = $request->receipt_no;
            $note = $request->note;
            $equipmentList = json_decode($request->equipment_list, true);

            // Tìm các bản ghi không có mã trong $equipmentList và thuộc về receipt_code
            $equipmentToDelete = Receipt_details::whereNotIn('equipment_code', array_column($equipmentList, 'equipment_code'))
                ->where('receipt_code', $code)
                ->get();

            // Xóa các bản ghi tìm thấy
            if ($equipmentToDelete->isNotEmpty()) {
                $equipmentToDelete->each(function ($item) {
                    $item->forceDelete();
                });
            }

            $existingRequest = Receipts::where('code', $code);

            $record = $existingRequest->first();

            $existingRequest->update([
                'supplier_code' => $supplierCode,
                'note' => $note ?? $record->note,
                'receipt_no' => $receiptNo,
                'updated_by' => session('user_code'),
                'updated_at' => now(),
            ]);

            foreach ($equipmentList as $equipment) {
                Receipt_details::updateOrCreate(
                    [
                        'receipt_code' => $code,
                        'equipment_code' => $equipment['equipment_code']
                    ],
                    [
                        'quantity' => $equipment['quantity'],
                        'batch_number' => $equipment['batch_number'],
                        'quantity' => $equipment['quantity'],
                        'VAT' => $equipment['vat'],
                        'discount' => $equipment['discount_rate'],
                        'price' => $equipment['price'],
                        'created_at' => $record->receipt_date,
                        'updated_at' => null,
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'Cập nhật phiếu nhập thành công']);
        }

        return response()->json(['success' => false, 'message' => 'Vui lòng điền đẩy đủ các trường dữ liệu']);
    }

    public function checkReceiptNo(Request $request)
    {
        if (empty(session('ier'))) {
            $existingRN = Receipts::where('receipt_no', $request->receipt_no)
                ->where('code', '!=', $request->code)
                ->where('status', '!=', 5)
                ->first();

            if ($existingRN) {
                return response()->json([
                    'success' => true,
                    'message' => 'Số hóa đơn này đã tồn tại trên hệ thống'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Được phép tạo'
        ]);
    }

    public function checkOrderNumber(Request $request)
    {
        if (empty(session('ier'))) {
            $existingON = Receipts::where('order_number', $request->order_number)
                ->where('code', '!=', $request->code)
                ->where('status', '!=', 5)
                ->first();

            if ($existingON) {
                return response()->json([
                    'success' => true,
                    'message' => 'Số đơn đặt hàng đã tồn tại vì đã có người tạo phiếu nhập này trước đó.'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Được phép tạo'
        ]);
    }

    public function approve(Request $request)
    {
        if (!empty($request->browse_code)) {
            $existingRequest = Receipts::find($request->browse_code);

            $existingRequest->update([
                'status' => 1,
                'browse_by' => session('user_code'),
            ]);

            if (isset($existingRequest->order_number)) {
                Import_equipment_requests::where('code', $existingRequest->order_number)->update([
                    'status' => 4,
                ]);
            }

            $this->updateInventories($request->browse_code, '+');

            toastr()->success("Phiếu #$request->browse_code đã được duyệt");

            return redirect()->back();
        } else if (!empty($request->create_code)) {
            Receipts::find($request->create_code)->update([
                'status' => 0
            ]);

            toastr()->success("Phiếu tạm #$request->create_code đã được tạo và đang ở trạng thái chờ duyệt");

            return redirect()->back();
        }

        toastr()->success('Phiếu đã được duyệt trước đó.');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $receipt = Receipts::where('code', $request->delete_code)->first();

        if (!$receipt) {
            toastr()->error('Phiếu nhập không tồn tại.');
            return redirect()->back();
        }

        if ($receipt->status == 5) {
            $receipt->forceDelete();

            toastr('Đã xóa phiếu nhập');

            return redirect()->back();
        } elseif ($receipt->status == 0 && isset($receipt->order_number)) {
            $receipt->forceDelete();

            toastr('Đã xóa phiếu nhập');

            return redirect()->back();
        } elseif ($receipt->status == 1) {
            $canCancel = true;

            $latestInventoryCheck = Inventory_checks::latest('created_at')->first();

            if ($latestInventoryCheck && $latestInventoryCheck->created_at > $receipt->created_at) {
                toastr()->error('Không thể xóa phiếu nhập vì đã có lần kiểm kê kho sau thời điểm phiếu nhập này.');
                return redirect()->back();
            }

            $receiptDetails = $receipt->details;

            foreach ($receiptDetails as $detail) {
                $inventory = Inventories::where('equipment_code', $detail->equipment_code)
                    ->where('batch_number', $detail->batch_number)
                    ->first();

                if ($inventory && $detail->quantity > $inventory->current_quantity) {
                    $canCancel = false;
                    break;
                }
            }

            if ($canCancel) {
                Import_equipment_requests::where('code', $receipt->order_number)->update([
                    'status' => 1,
                ]);

                $this->updateInventories($request->delete_code, '-');

                $receipt->update([
                    'browse_by' => NULL,
                    'status' => 0,
                ]);

                toastr()->success('Phiếu nhập với mã #' . $request->delete_code . ' đã được trở về trạng thái chờ duyệt');

                toastr()->info('Phiếu yêu cầu nhập với mã <a href="' . route('equipment_request.import', ['kw' => $receipt->order_number]) . '">#' . $receipt->order_number . '</a> đã được trở về trạng thái chuẩn bị.');

                return redirect()->back();
            } else {
                toastr()->error('Không thể hủy phiếu nhập này vì đã có lần xuất số lô thiết bị trong danh sách.');
                return redirect()->back();
            }
        }

        $receipt->update([
            'deleted_by' => session('user_code'),
        ]);

        $receipt->delete();

        toastr()->success('Đã hủy phiếu nhập kho.');
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

    private function updateInventories($receipt_code, $operation)
    {
        // Insert inventories
        $receiptDetails = Receipt_details::where('receipt_code', $receipt_code)->get();

        foreach ($receiptDetails as $item) {
            // Tìm bản ghi inventory theo batch_number và equipment_code từ $item
            $countQuantityInventoryWhere = Inventories::where('batch_number', $item->batch_number)
                ->where('equipment_code', $item->equipment_code)
                ->first();

            // Nếu tìm thấy trong Inventories thì cộng số lượng
            if ($countQuantityInventoryWhere) {
                if ($operation === '+') {
                    $current_quantity = $countQuantityInventoryWhere->current_quantity + $item->quantity;
                } elseif ($operation === '-') {
                    $current_quantity = $countQuantityInventoryWhere->current_quantity - $item->quantity;
                }
            } else {
                // If inventory record is not found, set current quantity to the item's quantity
                $current_quantity = $item->quantity;
            }

            // Cập nhật hoặc tạo mới Inventory
            $inventoryCode = $countQuantityInventoryWhere ? $countQuantityInventoryWhere->code : 'TK' . $this->generateRandomString(8);

            Inventories::updateOrCreate(
                [
                    'batch_number' => $item['batch_number'],
                    'equipment_code' => $item['equipment_code']
                ],
                [
                    'code' => $inventoryCode,
                    'current_quantity' => $current_quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    function generateRandomString($length = 9)
    {
        $characters = '0123456789';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
