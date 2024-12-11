<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Equipment_types;
use App\Models\Equipments;
use App\Models\Units;
use DB;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $route = 'inventory';

    public function index(Request $request)
    {
        $title = 'Tồn Kho';
        $equipmentType = Equipment_types::all();
        $units = Units::all();
        $totalEquipments = Equipments::with('inventories')->count();

        $query = Equipments::select([
            'equipments.*',
            DB::raw('(SELECT SUM(current_quantity) 
                      FROM inventories 
                      WHERE inventories.equipment_code = equipments.code 
                      AND inventories.deleted_at IS NULL) as total_quantity')
        ])
            ->with(['inventories', 'receipt_detail', 'export_detail'])
            ->orderBy('created_at', 'desc');

        $category = $request->input('category');
        $quantity = $request->input('quantity');
        $unit = $request->input('unit');
        $search = $request->input('search');

        if (isset($category)) {
            $query->where('equipment_type_code', $category);
        }

        if (isset($unit)) {
            $query->where('unit_code', $unit);
        }

        if (isset($search)) {
            $query->where('code', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%");
        }

        // Điều chỉnh bộ lọc số lượng
        if (isset($quantity)) {
            $query->where(function ($subQuery) use ($quantity) {
                if ($quantity === 'enough') {
                    $subQuery->where(DB::raw('(SELECT SUM(current_quantity) 
                                                FROM inventories 
                                                WHERE inventories.equipment_code = equipments.code 
                                                AND inventories.deleted_at IS NULL)'), '>=', 20);
                } elseif ($quantity === 'low') {
                    $subQuery->where(DB::raw('
                                            (SELECT SUM(current_quantity) 
                                            FROM inventories 
                                            WHERE inventories.equipment_code = equipments.code 
                                            AND inventories.deleted_at IS NULL
                                            )'), '>', 1)
                        ->where(DB::raw('
                                            (SELECT SUM(current_quantity) 
                                            FROM inventories 
                                            WHERE inventories.equipment_code = equipments.code 
                                            AND inventories.deleted_at IS NULL
                                            )'), '<=', 10);
                } elseif ($quantity === 'out_stock') {
                    $subQuery->where(DB::raw('(SELECT SUM(current_quantity) 
                                                FROM inventories 
                                                WHERE inventories.equipment_code = equipments.code 
                                                AND inventories.deleted_at IS NULL)'), '=', 0);
                }
            });
        }

        $initialEquipments = $query->paginate(30);

        $outOfStockCount = 0;
        $inStockCount = 0;
        $lowStockCount = 0;
        $totalInventories = [];

        foreach ($initialEquipments as $equipment) {
            // Đếm tổng số lượng nhập và xuất
            $totalIncoming = $equipment->receipt_detail->sum('quantity');  // Tổng số lượng nhập
            $totalOutgoing = $equipment->export_detail->sum('quantity');  // Tổng số lượng xuất

            // Tính tồn kho = tổng nhập - tổng xuất
            $totalQuantity = $totalIncoming - $totalOutgoing;

            $totalInventories[$equipment->code] = [
                'inventories' => $equipment->inventories, // Có thể giữ lại nếu cần thông tin chi tiết về các phiếu nhập, xuất
                'total_quantity' => $totalQuantity,
            ];

            // Đếm số lượng theo tình trạng tồn kho
            if ($totalQuantity < 1) {
                $outOfStockCount++;
            } elseif ($totalQuantity <= 10) {
                $lowStockCount++;
            } else {
                $inStockCount++;
            }
        }

        return view("{$this->route}.inventory", [
            'inventories' => $totalInventories,
            'equipments' => $initialEquipments,
            'equipmentType' => $equipmentType,
            'totalEquipments' => $totalEquipments,
            'outOfStockCount' => $outOfStockCount,
            'inStockCount' => $inStockCount,
            'lowStockCount' => $lowStockCount,
            'units' => $units,
            'title' => $title,
        ]);
    }
}
