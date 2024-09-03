<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    protected $route = 'warehouse';

    public function import()
    {
        $title = 'Nhập Kho';

        return view("{$this->route}.import_warehouse.import", compact('title'));
    }

    public function export()
    {
        $title = 'Xuất Kho';

        return view("{$this->route}.export_warehouse.export", compact('title'));
    }

    public function create_import()
    {
        $title = 'Tạo Phiếu Nhập Kho';

        $receiptItems = [
            [
                'material_id' => 'MAT001',
                'name' => 'Vật tư A',
                'quantity' => 100,
                'unit_price' => 15000,
                'batch_number' => 'BATCH001',
                'expiry_date' => '2024-12-31',
                'discount_rate' => 5,
                'vat_rate' => 10,
                'received_quantity' => 100,
                'received_date' => '2024-08-29',
                'unit' => 'Hộp',
                'product_date' => '2023-01-01'
            ],
            [
                'material_id' => 'MAT002',
                'name' => 'Vật tư B',
                'quantity' => 50,
                'unit_price' => 12000,
                'batch_number' => 'BATCH002',
                'expiry_date' => '2025-06-30',
                'discount_rate' => 0,
                'vat_rate' => 8,
                'received_quantity' => 200,
                'received_date' => '2024-08-29',
                'unit' => 'Cái',
                'product_date' => '2023-06-01'
            ]
        ];

        return view("{$this->route}.import_warehouse.create_import", compact('title', 'receiptItems'));
    }

    public function create_export()
    {
        $title = 'Tạo Phiếu Xuất Kho';


        return view("{$this->route}.export_warehouse.create_export", compact('title'));
    }

    public function store_export(Request $request)
    {
        dd($request->all());
    }

    public function store_import(Request $request)
    {
        dd($request->all());
    }

    public function inventory()
    {
        $title = 'Tồn Kho';

        return view("{$this->route}.inventory", compact('title'));
    }
}
