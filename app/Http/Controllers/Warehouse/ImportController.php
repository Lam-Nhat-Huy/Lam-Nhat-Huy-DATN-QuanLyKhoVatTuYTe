<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Receipts;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected $route = 'warehouse';
    protected $inventories = [];
    protected $materials = [];
    protected $users = [];
    protected $departments = [];
    protected $exports = [];
    protected $exportDetails = [];

    public function __construct()
    {
        // Dữ liệu mẫu cho các bảng tồn kho
        $this->inventories = [
            ['code' => 'INV001', 'material_code' => 'MAT001', 'batch_code' => 'BATCH001', 'current_quantity' => 100, 'expiry_date' => '2021-12-01'],
            ['code' => 'INV002', 'material_code' => 'MAT001', 'batch_code' => 'BATCH002', 'current_quantity' => 60, 'expiry_date' => '2024-11-01'],
            ['code' => 'INV003', 'material_code' => 'MAT002', 'batch_code' => 'BATCH003', 'current_quantity' => 0, 'expiry_date' => '2025-01-01'],
            ['code' => 'INV004', 'material_code' => 'MAT002', 'batch_code' => 'BATCH004', 'current_quantity' => 1, 'expiry_date' => '2024-09-15'],
            ['code' => 'INV005', 'material_code' => 'MAT002', 'batch_code' => 'BATCH005', 'current_quantity' => 23, 'expiry_date' => '2024-09-15'],
        ];

        // Dữ liệu mẫu cho các bảng vật tư
        $this->materials = [
            ['code' => 'MAT001', 'name' => 'Vật tư A'],
            ['code' => 'MAT002', 'name' => 'Vật tư B'],
        ];

        // Dữ liệu phòng ban nơi xuất hàng tới
        $this->departments = [
            ['code' => 'DEPT001', 'name' => 'Phòng Cấp Cứu'],
            ['code' => 'DEPT002', 'name' => 'Phòng Phẫu Thuật'],
            ['code' => 'DEPT003', 'name' => 'Phòng Hồi Sức'],
            ['code' => 'DEPT004', 'name' => 'Phòng Dược'],
            ['code' => 'DEPT005', 'name' => 'Phòng Xét Nghiệm'],
        ];

        // Dữ liệu mẫu cho người tạo
        $this->users = [
            ['id' => 1, 'name' => 'Nguyễn Văn A'],
            ['id' => 2, 'name' => 'Trần Thị B'],
        ];
    }


    public function import()
    {
        $title = 'Nhập Kho';

        $receipts = Receipts::with(['supplier', 'user', 'details.equipments'])->get();

        return view("{$this->route}.import_warehouse.import", [
            'title' => $title,
            'receipts' => $receipts
        ]);
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
                'product_date' => '2022-01-01'
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

        return view("{$this->route}.import_warehouse.add_import", compact('title', 'receiptItems'));
    }

    public function store_import(Request $request)
    {
        $materialData = json_decode($request->input('materialData'), true);
        dd($materialData);
    }
}
