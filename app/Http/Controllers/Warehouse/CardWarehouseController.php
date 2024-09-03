<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardWarehouseController extends Controller
{
    protected $route = 'warehouse';

    public function index()
    {
        $title = "Thẻ kho";

        $items = collect([
            [
                'batch_number' => 'Batch001',
                'opening_stock' => 100,
                'stock_in' => 50,
                'stock_out' => 20,
                'closing_stock' => 130,
                'manufacture_date' => '2024-01-01',
                'expiry_date' => '2025-01-01',
                'supplier_name' => 'Supplier A',
                'warehouse_address' => '123 Warehouse St.',
                'notes' => 'First batch of products',
            ],
            [
                'batch_number' => 'Batch002',
                'opening_stock' => 200,
                'stock_in' => 30,
                'stock_out' => 40,
                'closing_stock' => 190,
                'manufacture_date' => '2024-02-01',
                'expiry_date' => '2025-02-01',
                'supplier_name' => 'Supplier B',
                'warehouse_address' => '456 Warehouse Ave.',
                'notes' => 'Second batch of products',
            ],
            [
                'batch_number' => 'Batch003',
                'opening_stock' => 150,
                'stock_in' => 70,
                'stock_out' => 30,
                'closing_stock' => 190,
                'manufacture_date' => '2024-03-01',
                'expiry_date' => '2025-03-01',
                'supplier_name' => 'Supplier C',
                'warehouse_address' => '789 Warehouse Blvd.',
                'notes' => 'Third batch of products',
            ],
            // Thêm nhiều dữ liệu mẫu khác nếu cần
        ]);

        return view("{$this->route}.card_warehouse.card", compact('title', 'items'));
    }
}
