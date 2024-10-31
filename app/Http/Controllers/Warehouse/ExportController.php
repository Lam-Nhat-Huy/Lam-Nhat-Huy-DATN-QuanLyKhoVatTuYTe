<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Equipments;
use App\Models\Export_details;
use App\Models\Exports;
use App\Models\Inventories;
use App\Models\Suppliers;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    protected $route = 'warehouse';

    public function export(Request $request)
    {
        $allDepartment = Departments::all();

        $allSupplier = Suppliers::all();

        $users = Users::all();

        $allExportCount = Exports::all()->count();

        $draftExportsCount = Exports::where('status', 0)->count();

        $approvedExportsCount = Exports::where('status', 1)->count();

        $tempExportsCount = Exports::where('status', 3)->count();

        $kw = $request->input('kw');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $supplierCode = $request->input('spl');
        $departmentCode = $request->input('dpm');
        $status = $request->input('stt');
        $createdBy = $request->input('us');
        $exportType = $request->input('ept');

        $exports = Exports::orderBy('created_at', 'desc')
            ->withoutTrashed()
            ->when($startDate, function ($q) use ($startDate) {
                return $q->whereDate('export_date', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                return $q->whereDate('export_date', '<=', $endDate);
            });

        if (isset($kw)) {
            $exports = $exports->where(function ($q) use ($kw) {
                $q->where('code', 'LIKE', '%' . $kw . '%')
                    ->orWhere('receipt_no', 'LIKE', "%{$kw}%");
            });
        }

        if (isset($supplierCode)) {
            $exports = $exports->where('supplier_code', $supplierCode);
        }

        if (isset($departmentCode)) {
            $exports = $exports->where('department_code', $departmentCode);
        }

        if (isset($status)) {
            $exports = $exports->where('status', $status);
        }

        if (isset($createdBy)) {
            $exports = $exports->where('created_by', $createdBy);
        }

        if (isset($exportType)) {
            $exports = $exports->where('export_type', $exportType);
        }

        $exports = $exports->paginate(10);

        if (!empty($request->import_codes)) {

            if ($request->action_type === 'delete') {

                Exports::whereIn('code', $request->import_codes)->where('status', 0)->orWhere('status', 3)->delete();

                toastr()->success('Hủy Phiếu Thành Công');

                return redirect()->back();
            }
        }

        return view("{$this->route}.export_warehouse.export", [
            'users' => $users,
            'allDepartment' => $allDepartment,
            'allSupplier' => $allSupplier,
            'exports' => $exports,
            'allExportCount' => $allExportCount,
            'draftExportsCount' => $draftExportsCount,
            'approvedExportsCount' => $approvedExportsCount,
            'tempExportsCount' => $tempExportsCount,
        ]);
    }

    public function exportTrash(Request $request)
    {
        $allExportCount = Exports::onlyTrashed()->count();

        $draftExportsCount = Exports::where('status', 0)->onlyTrashed()->count();

        $approvedExportsCount = Exports::where('status', 1)->onlyTrashed()->count();

        $tempExportsCount = Exports::where('status', 3)->onlyTrashed()->count();

        $exportTrash = Exports::orderBy('created_at', 'desc')
            ->onlyTrashed()
            ->paginate(10);

        if (!empty($request->restore_value)) {
            // Tìm phiếu xuất đã bị xóa tạm thời
            $restore_update = Exports::withTrashed()->where('code', $request->restore_value)->first();

            if ($restore_update) {
                // Cập nhật trạng thái và khôi phục phiếu
                $restore_update->update([
                    'status' => 0, // Cập nhật status về 0 (chờ duyệt)
                ]);

                // Khôi phục nếu phiếu này đã bị soft delete
                if ($restore_update->trashed()) {
                    $restore_update->restore();
                }

                toastr()->success('Phiếu xuất đã được khôi phục');
            } else {
                toastr()->error('Không tìm thấy phiếu xuất để khôi phục');
            }

            return redirect()->back();
        }


        if (!empty($request->delete_value)) {
            Exports::where('code', $request->delete_value)->forceDelete();

            toastr()->success('Xóa vĩnh viễn thành công');

            return redirect()->back();
        }

        if (!empty($request->import_codes)) {

            if ($request->action_type === 'restore') {
                Exports::withTrashed()
                    ->whereIn('code', $request->import_codes)
                    ->where(function ($query) {
                        $query->where('status', 0)
                            ->orWhere('status', 3);
                    })
                    ->restore();

                toastr()->success('Phiếu xuất đã được khôi phục và trở về trạng thái chờ duyệt');

                return redirect()->back();
            } else if ($request->action_type === 'delete') {

                Exports::whereIn('code', $request->import_codes)->where('status', 0)->orWhere('status', 3)->forceDelete();

                toastr()->success('Xóa vĩnh viễn phiếu thành công');

                return redirect()->back();
            }
        }

        return view("{$this->route}.export_warehouse.trash", [
            'exportTrash' => $exportTrash,
            'allExportCount' => $allExportCount,
            'draftExportsCount' => $draftExportsCount,
            'approvedExportsCount' => $approvedExportsCount,
            'tempExportsCount' => $tempExportsCount,
        ]);
    }

    public function create_export(Request $request)
    {
        $action = 'create';

        $allDepartment = Departments::orderBy('created_at', 'DESC')->get();

        $allSupplier = Suppliers::orderBy('created_at', 'DESC')->get();

        $equipmentsWithStock = Equipments::all();

        $getBatchWithQuantity = Inventories::select('batch_number', 'equipment_code', DB::raw('SUM(current_quantity) as total_quantity'))
            ->groupBy('batch_number', 'equipment_code')
            ->get();

        $equipmentBatches = [];

        foreach ($getBatchWithQuantity as $inventory) {
            $equipmentBatches[$inventory->equipment_code][] = [
                'batch_number' => $inventory->batch_number,
                'total_quantity' => $inventory->total_quantity,
            ];
        }

        $jsonEquipmentBatches = json_encode($equipmentBatches);

        if (
            !empty($request->equipment) &&
            !empty($request->batch_number) &&
            !empty($request->quantity)
        ) {
            $equipment = Equipments::with('units')->where('code', $request->equipment)->first();
            $currentQuantity = Inventories::where('equipment_code', $request->equipment)->where('batch_number', $request->batch_number)->first();

            if ($equipment) {
                return response()->json([
                    'success' => true,
                    'equipment_code' => $equipment->code,
                    'equipment_name' => $equipment->name,
                    'unit_name' => $equipment->units->name,
                    'equipment_current_quantity' => $currentQuantity->current_quantity,
                    'batch_number' => $request->batch_number,
                    'quantity' => $request->quantity,
                ]);
            }
        }

        $checkList = json_encode([]);

        return view("{$this->route}.export_warehouse.create_export", [
            'action' => $action,
            'checkList' => $checkList,
            'allSupplier' => $allSupplier,
            'allDepartment' => $allDepartment,
            'equipmentsWithStock' => $equipmentsWithStock,
            'jsonEquipmentBatches' => $jsonEquipmentBatches,
        ]);
    }

    public function store_export(Request $request)
    {
        if (
            !empty($request->department_code) &&
            !empty($request->supplier_code) &&
            !empty($request->reason) &&
            !empty($request->export_type) &&
            !empty($request->export_date) &&
            !empty($request->exportStatus) &&
            !empty($request->equipment_list)
        ) {
            $departmentCode = $request->department_code;
            $supplierCode = $request->supplier_code;
            $reason = $request->reason;
            $exportType = $request->export_type;
            $note = $request->note;
            $equipmentList = json_decode($request->equipment_list, true);

            $record = Exports::create([
                'code' => 'PX' . $this->generateRandomString(8),
                'note' => $note ?? '',
                'status' => $request->exportStatus == 4 ? 0 : $request->exportStatus,
                'export_date' => now(),
                'export_type' => $exportType,
                'department_code' => $departmentCode == 1 ? NULL : $departmentCode,
                'supplier_code' => $supplierCode == 1 ? NULL : $supplierCode,
                'reason' => $reason == 1 ? NULL : $reason,
                'created_by' => session('user_code'),
                'created_at' => now(),
                'deleted_at' => null,
            ]);

            if ($record) {
                foreach ($equipmentList as $equipment) {
                    Export_details::create([
                        'export_code' => $record->code,
                        'equipment_code' => $equipment['equipment_code'],
                        'quantity' => $equipment['quantity'],
                        'batch_number' => $equipment['batch_number'],
                        'created_at' => now(),
                        'updated_at' => null,
                        'deleted_at' => null,
                    ]);
                }

                return response()->json(['success' => true, 'message' => 'Đã tạo phiếu xuất']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Vui lòng điền đẩy đủ các trường dữ liệu']);
    }

    // Tạo phiếu xuất bằng yêu cầu xuất kho
    public function export_equipment_request(Request $request) {}

    public function edit_export($code)
    {
        $action = 'update';

        $editExport = Exports::find($code);

        $allDepartment = Departments::orderBy('created_at', 'DESC')->get();

        $equipmentsWithStock = Equipments::all();

        $getBatchWithQuantity = Inventories::select('batch_number', 'equipment_code', DB::raw('SUM(current_quantity) as total_quantity'))
            ->groupBy('batch_number', 'equipment_code')
            ->get();

        $equipmentBatches = [];

        foreach ($getBatchWithQuantity as $inventory) {
            $equipmentBatches[$inventory->equipment_code][] = [
                'batch_number' => $inventory->batch_number,
                'total_quantity' => $inventory->total_quantity,
            ];
        }

        $jsonEquipmentBatches = json_encode($equipmentBatches);

        $checkList = Export_details::where('export_code', $code)->pluck('batch_number')->toArray();

        $checkList = json_encode($checkList);

        return view("{$this->route}.export_warehouse.create_export", [
            'action' => $action,
            'editExport' => $editExport,
            'checkList' => $checkList,
            'allDepartment' => $allDepartment,
            'equipmentsWithStock' => $equipmentsWithStock,
            'jsonEquipmentBatches' => $jsonEquipmentBatches,
        ]);
    }

    public function update_export(Request $request, $code)
    {
        if (
            !empty($request->department_code) &&
            !empty($request->export_type) &&
            !empty($request->export_date) &&
            !empty($request->exportStatus) &&
            !empty($request->equipment_list)
        ) {
            $departmentCode = $request->department_code;
            $exportType = $request->export_type;
            $note = $request->note;
            $equipmentList = json_decode($request->equipment_list, true);

            // Tìm các bản ghi không có mã trong $equipmentList và thuộc về receipt_code
            $batchToDelete = Export_details::whereNotIn('batch_number', array_column($equipmentList, 'batch_number'))
                ->where('export_code', $code)
                ->get();

            // Xóa các bản ghi tìm thấy
            if ($batchToDelete->isNotEmpty()) {
                $batchToDelete->each(function ($item) {
                    $item->forceDelete();
                });
            }

            $existingRequest = Exports::where('code', $code);

            $record = $existingRequest->first();

            $existingRequest->update([
                'department_code' => $departmentCode,
                'note' => $note ?? $record->note,
                'export_type' => $exportType,
                'updated_at' => now(),
            ]);

            foreach ($equipmentList as $equipment) {
                Export_details::updateOrCreate(
                    [
                        'export_code' => $code,
                        'batch_number' => $equipment['batch_number']
                    ],
                    [
                        'quantity' => $equipment['quantity'],
                        'equipment_code' => $equipment['equipment_code'],
                        'quantity' => $equipment['quantity'],
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'Cập nhật phiếu xuất thành công']);
        }

        return response()->json(['success' => false, 'message' => 'Vui lòng điền đẩy đủ các trường dữ liệu']);
    }

    public function approve(Request $request)
    {
        if (!empty($request->browse_code)) {
            Exports::find($request->browse_code)->update([
                'status' => 1,
            ]);

            $this->updateInventories($request->browse_code, '-');

            toastr()->success("Phiếu #$request->browse_code đã được duyệt");

            return redirect()->back();
        } else if (!empty($request->create_code)) {
            Exports::find($request->create_code)->update([
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
        $export = Exports::where('code', $request->delete_code)->first();

        if ($export->status == 1) {
            $this->updateInventories($request->delete_code, '+');

            $export->forceDelete();

            toastr()->success('Đã xóa phiếu xuất kho.');

            return redirect()->back();
        }

        $export->delete();

        toastr()->success('Đã hủy phiếu nhập kho.');
        return redirect()->back();
    }

    private function updateInventories($export_code, $operation)
    {
        // Insert inventories
        $receiptDetails = Export_details::where('export_code', $export_code)->get();

        foreach ($receiptDetails as $item) {
            // Tìm bản ghi inventory theo batch_number và equipment_code từ $item
            $countQuantityInventoryWhere = Inventories::where('batch_number', $item->batch_number)
                ->where('equipment_code', $item->equipment_code)
                ->first();

            // Nếu tìm thấy trong Inventories thì cộng số lượng
            if ($operation === '+') {
                $current_quantity = $countQuantityInventoryWhere->current_quantity + $item->quantity;
            } elseif ($operation === '-') {
                $current_quantity = $countQuantityInventoryWhere->current_quantity - $item->quantity;
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
