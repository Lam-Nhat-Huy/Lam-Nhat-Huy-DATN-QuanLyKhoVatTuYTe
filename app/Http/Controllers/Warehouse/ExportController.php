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
    //     // Decode the list of materials and batches
    //     $materialList = json_decode($request->input('material_list'), true);

    //     foreach ($materialList as $material) {
    //         $material_code = $material['material_code'];
    //         $department_code = $material['department_code'];
    //         $created_by = $material['created_by'];
    //         $batches = $material['batches'];

    //         // Check if material exists
    //         $materialData = collect($this->materials)->firstWhere('code', $material_code);
    //         if (!$materialData) {
    //             return redirect()->route('warehouse.create_export')->with('error', 'Vật tư không tồn tại.');
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
    //             'note' => $material['note'],
    //             'price' => 0,
    //             'status' => 1,
    //             'export_at_date' => $material['export_at'],
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
    //                 'material_code' => $material_code,
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
