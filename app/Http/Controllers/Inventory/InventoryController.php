<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Equipments;
use App\Models\Inventories;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $route = 'inventory';

    public function index()
    {
        $title = 'Tồn Kho';
        $equipments = Equipments::with('inventories')->get();
        $totalInventories = [];

        foreach ($equipments as $equipment) {
            $totalQuantity = $equipment->inventories->sum('current_quantity');
            $totalInventories[$equipment->code] = [
                'inventories' => $equipment->inventories,
                'total_quantity' => $totalQuantity,
            ];
        }
        return view("{$this->route}.inventory", [
            'inventories' => $totalInventories,
            'equipments' => $equipments,
            'title' => $title,
        ]);
    }
}
