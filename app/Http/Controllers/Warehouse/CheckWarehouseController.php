<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckWarehouseController extends Controller
{
    protected $route = 'check_warehouse';

    public function index()
    {
        $title = 'Kiểm Kho';

        // Sample data for index view
        $inventoryChecks = [
            [
                'code' => 'CHK123',
                'time' => '2024-09-01 10:00:00',
                'balance_date' => '2024-09-01',
                'actual_quantity' => 150,
                'total_actual' => 500,
                'total_difference' => 50,
                'increased_difference' => 20,
                'decreased_difference' => 30,
                'note' => 'Note Example',
            ],
        ];

        return view("{$this->route}.check", compact('title', 'inventoryChecks'));
    }

    public function create()
    {
        $title = 'Tạo Phiếu Kiểm Kho';
        return view("{$this->route}.create", compact('title'));
    }

    public function store(Request $request)
    {
        // Validate and save the data here
        // Example:
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'time' => 'required|date',
            'balance_date' => 'required|date',
            'actual_quantity' => 'required|integer',
            'total_actual' => 'required|integer',
            'total_difference' => 'required|integer',
            'increased_difference' => 'required|integer',
            'decreased_difference' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        // Here you would save the data to the database
        // InventoryCheck::create($validated);

        // After saving, redirect to the index page
        return redirect()->route('check_warehouse.index');
    }
}

