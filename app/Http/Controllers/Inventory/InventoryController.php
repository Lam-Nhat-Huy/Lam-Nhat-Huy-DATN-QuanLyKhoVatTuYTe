<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Equipment_types;
use App\Models\Equipments;
use App\Models\Units;
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

        $query = Equipments::with('inventories')->orderBy('created_at', 'desc');

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

        if (isset($quantity)) {
            $query->whereHas('inventories', function ($subQuery) use ($quantity) {
                if ($quantity === 'enough') {
                    $subQuery->where('current_quantity', '>=', 25);
                } elseif ($quantity === 'low') {
                    $subQuery->where('current_quantity', '<', 25);
                } elseif ($quantity === 'out_stock') {
                    $subQuery->where('current_quantity', '=', 0);
                }
            });
        }

        $initialEquipments = $query->paginate(10);

        $outOfStockCount = 0;
        $inStockCount = 0;
        $lowStockCount = 0;
        $totalInventories = [];

        foreach ($initialEquipments as $equipment) {
            $totalQuantity = $equipment->inventories->sum('current_quantity');
            $totalInventories[$equipment->code] = [
                'inventories' => $equipment->inventories,
                'total_quantity' => $totalQuantity,
            ];

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
