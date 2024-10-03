<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Equipment_types;
use App\Models\Equipments;
use App\Models\Inventories;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $route = 'inventory';

    public function index(Request $request)
    {
        $title = 'Tồn Kho';
        $equipmentType = Equipment_types::all();
        $totalEquipments = Equipments::with('inventories')->count();
        $equipments = Equipments::with('inventories')->orderBy('created_at', 'desc')->paginate(5);
        $totalInventories = [];

        foreach ($equipments as $equipment) {
            $totalQuantity = $equipment->inventories->sum('current_quantity');
            $totalInventories[$equipment->code] = [
                'inventories' => $equipment->inventories,
                'total_quantity' => $totalQuantity,
            ];
        }

        if ($request->ajax()) {
            return view('inventory.index', [
                'equipments' => $equipments,
                'inventories' => $totalInventories,
            ]);
        }

        return view("{$this->route}.inventory", [
            'inventories' => $totalInventories,
            'equipments' => $equipments,
            'equipmentType' => $equipmentType,
            'totalEquipments' => $totalEquipments,
            'title' => $title,
        ]);
    }
    public function filter(Request $request)
    {
        $title = 'Tồn kho';
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $category = $request->input('category');
        $expiry_date = $request->input('expiry_date');
        $quantity = $request->input('quantity');
        $search = $request->input('search');
        $equipments = Equipments::with('inventories');
        if (!empty($search)) {
            $equipments->where('name', 'LIKE', "%{$search}%");
        }
        if (!empty($start_date)) {
            $equipments->whereHas('inventories', function ($subQuery) use ($start_date) {
                $subQuery->whereDate('expiry_date', '>=', $start_date);
            });
        }
        if (!empty($end_date)) {
            $equipments->whereHas('inventories', function ($subQuery) use ($end_date) {
                $subQuery->whereDate('expiry_date', '<=', $end_date);
            });
        }
        if (!empty($category)) {
            $equipments->whereHas('equipmentType', function ($subQuery) use ($category) {
                $subQuery->where('code', $category);
            });
        }
        if (!empty($expiry_date)) {
            $now = now();
            $fiveMonthsLater = now()->addMonths(5);

            $equipments->whereHas('inventories', function ($subQuery) use ($expiry_date, $now, $fiveMonthsLater) {
                if ($expiry_date == 'valid') {
                    $subQuery->whereDate('expiry_date', '>', $fiveMonthsLater);
                } elseif ($expiry_date == 'expiring_soon') {
                    $subQuery->whereDate('expiry_date', '>', $now)
                        ->whereDate('expiry_date', '<=', $fiveMonthsLater);
                } elseif ($expiry_date == 'expired') {
                    $subQuery->whereDate('expiry_date', '<=', $now);
                }
            });
        }
        if (!empty($quantity)) {
            if ($quantity === 'enough') {
                $equipments->whereHas('inventories', function ($subQuery) {
                    $subQuery->where('current_quantity', '>=', 25);
                });
            } elseif ($quantity === 'low') {
                $equipments->whereHas('inventories', function ($subQuery) {
                    $subQuery->where('current_quantity', '<', 25);
                });
            } elseif ($quantity === 'out_stock') {
                $equipments->whereDoesntHave('inventories', function ($subQuery) {
                    $subQuery->where('current_quantity', '>', 0);
                });
            }
        }
        $equipments = $equipments->orderBy('created_at', 'desc')->paginate(5);
        $totalInventories = [];

        foreach ($equipments as $equipment) {
            if (!empty($expiry_date)) {
                $filteredInventories = $equipment->inventories->filter(function ($inventory) use ($expiry_date, $now, $fiveMonthsLater) {
                    if ($expiry_date == 'valid') {
                        return $inventory->expiry_date > $fiveMonthsLater;
                    } elseif ($expiry_date == 'expiring_soon') {
                        return $inventory->expiry_date > $now && $inventory->expiry_date <= $fiveMonthsLater;
                    } elseif ($expiry_date == 'expired') {
                        return $inventory->expiry_date <= $now;
                    }
                    return true;
                });
            } else {
                $filteredInventories = $equipment->inventories;
            }
            $totalQuantity = $filteredInventories->sum('current_quantity');
            $totalInventories[$equipment->code] = [
                'inventories' => $filteredInventories,
                'total_quantity' => $totalQuantity,
            ];
        }
        return view("{$this->route}.search", [
            'title' => $title,
            'inventories' => $totalInventories,
            'equipments' => $equipments,
            'totalEquipment' => Equipments::count()
        ]);
    }
}
