<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Equipments;
use App\Models\Inventories;
use App\Models\Receipts;
use App\Models\Users;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected $route = 'warehouse';
    protected $inventories = [];
    protected $equipments = [];
    protected $users = [];
    protected $departments = [];
    protected $exports = [];
    protected $exportDetails = [];

    public function __construct()
    {
        $this->inventories = Inventories::all();
        $this->equipments = Equipments::all();
        $this->departments = Departments::all();
        $this->users = Users::where('code',session('user_code'))->first();
    }

    public function export()
    {
        $title = 'Xuất Kho';

        return view("{$this->route}.export_warehouse.export", compact('title'));
    }

    public function create_export()
    {
        $title = 'Tạo Phiếu Xuất Kho';

        return view("{$this->route}.export_warehouse.add_export", ['equipments' => $this->equipments, 'inventories' => $this->inventories, 'users' => $this->users, 'departments' => $this->departments, 'title']);
    }

    // public function store_export(Request $request)
    // {
    //     // Decode the list of equipments and batches
    //     $equipmentList = json_decode($request->input('equipment_list'), true);

    //     foreach ($equipmentList as $equipment) {
    //         $equipment_code = $equipment['equipment_code'];
    //         $department_code = $equipment['department_code'];
    //         $created_by = $equipment['created_by'];
    //         $batches = $equipment['batches'];

    //         // Check if equipment exists
    //         $equipmentData = collect($this->equipments)->firstWhere('code', $equipment_code);
    //         if (!$equipmentData) {
    //             return redirect()->route('warehouse.create_export')->with('error', 'Thiết bị không tồn tại.');
    //         }

    //         // Check stock and process export
    //         foreach ($batches as $batch) {
    //             $batch_code = $batch['batch_code'];
    //             $quantity = $batch['quantity'];

    //             $inventory = collect($this->inventories)->firstWhere('batch_code', $batch_code);
    //             if (!$inventory || $inventory['current_quantity'] < $quantity) {
    //                 return redirect()->route('warehouse.create_export')->with('error', "Không đủ số lượng tồn kho để xuất từ lô $batch_code.");
    //             }
    //         }

    //         // Process export
    //         $export_code = 'EXP' . (count($this->exports) + 1);
    //         $export = [
    //             'code' => $export_code,
    //             'department_code' => $department_code,
    //             'note' => $equipment['note'],
    //             'price' => 0,
    //             'status' => 1,
    //             'export_at_date' => $equipment['export_at'],
    //             'created_by' => $created_by,
    //         ];
    //         $this->exports[] = $export;

    //         foreach ($batches as $batch) {
    //             $batch_code = $batch['batch_code'];
    //             $quantity = $batch['quantity'];

    //             foreach ($this->inventories as &$inv) {
    //                 if ($inv['batch_code'] === $batch_code) {
    //                     $inv['current_quantity'] -= $quantity;
    //                 }
    //             }

    //             $export_detail_code = 'EXD' . (count($this->exportDetails) + 1);
    //             $export_detail = [
    //                 'code' => $export_detail_code,
    //                 'export_code' => $export_code,
    //                 'batch_code' => $batch_code,
    //                 'equipment_code' => $equipment_code,
    //                 'quantity_int' => $quantity,
    //                 'created_by' => $created_by,
    //             ];
    //             $this->exportDetails[] = $export_detail;
    //         }
    //     }

    //     dd([
    //         'exports' => $this->exports,
    //         'export_details' => $this->exportDetails,
    //         'inventories' => $this->inventories,
    //     ]);

    //     return redirect()->route('warehouse.export')->with('success', 'Xuất kho thành công!');
    // }
}
