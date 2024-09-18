<?php

namespace App\Http\Controllers\MaterialRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialRequestController extends Controller
{
    protected $route = 'material_request';

    // Nhập

    public function import_material_request()
    {
        $title = 'Yêu Cầu Nhập Kho';

        $AllMaterialRequest = [
            [
                'id' => 1,
                'material_request_code' => 'HD001',
                'supplier_id' => 1,
                'user_create' => 'Lữ Phát Huy - KT - BS231',
                'date_of_entry' => '30/08/2024',
                'status' => 1
            ],
            [
                'id' => 2,
                'material_request_code' => 'HD002',
                'supplier_id' => 2,
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
            [
                'id' => 3,
                'material_request_code' => 'HD002',
                'supplier_id' => 2,
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
            [
                'id' => 4,
                'material_request_code' => 'HD002',
                'supplier_id' => 2,
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
            [
                'id' => 5,
                'material_request_code' => 'HD002',
                'supplier_id' => 2,
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
        ];

        return view("{$this->route}.import_material_request.index", compact('title', 'AllMaterialRequest'));
    }

    public function import_material_request_trash()
    {
        $title = 'Yêu Cầu Nhập Kho';

        $AllMaterialRequestTrash = [
            [
                'id' => 1,
                'material_request_code' => 'HD001',
                'supplier_id' => 1,
                'user_create' => 'Lữ Phát Huy - KT - BS231',
                'date_of_entry' => '30/08/2024',
                'status' => 1
            ],
            [
                'id' => 2,
                'material_request_code' => 'HD002',
                'supplier_id' => 2,
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
        ];

        return view("{$this->route}.import_material_request.trash", compact('title', 'AllMaterialRequestTrash'));
    }

    public function create_import_material_request()
    {
        $title = 'Yêu Cầu Nhập Kho';

        $title_form = 'Tạo Phiếu Yêu Cầu Nhập Kho';

        $action = 'create';

        $AllSuppiler = [
            [
                'id' => 1,
                'name' => 'CTY ABC',
            ],
            [
                'id' => 2,
                'name' => 'CTY DEF',
            ],
        ];

        $AllMaterial = [
            [
                'id' => 1,
                'material_code' => 'VT001',
                'material_name' => 'Băng Gạc',
                'description' => 'Thùng x 100 Gói',
                'quantity' => 12,
                'expiry' => '2025-2-15',
            ],
            [
                'id' => 2,
                'material_code' => 'VT002',
                'material_name' => 'Bình Oxy Y Tế',
                'description' => 'Bình 5 Lít',
                'quantity' => 35,
                'expiry' => '2024-9-5',
            ],
        ];

        return view("{$this->route}.import_material_request.form", compact('title', 'title_form', 'action', 'AllSuppiler', 'AllMaterial'));
    }

    public function store_import_material_request() {}

    public function update_import_material_request()
    {
        $title = 'Yêu Cầu Nhập Kho';

        $title_form = 'Cập Nhật Phiếu Yêu Cầu Nhập Kho';

        $action = 'update';

        $AllSuppiler = [
            [
                'id' => 1,
                'name' => 'CTY ABC',
            ],
            [
                'id' => 2,
                'name' => 'CTY DEF',
            ],
        ];

        $AllMaterial = [
            [
                'id' => 1,
                'material_code' => 'VT001',
                'material_name' => 'Băng Gạc',
                'description' => 'Thùng x 100 Gói',
                'quantity' => 12,
                'expiry' => '2025-2-15',
            ],
            [
                'id' => 2,
                'material_code' => 'VT002',
                'material_name' => 'Bình Oxy Y Tế',
                'description' => 'Bình 5 Lít',
                'quantity' => 35,
                'expiry' => '2024-9-5',
            ],
        ];

        return view("{$this->route}.import_material_request.form", compact('title', 'title_form', 'action', 'AllMaterial', 'AllSuppiler'));
    }

    public function edit_import_material_request() {}

    // Xuất

    public function export_material_request()
    {
        $title = 'Yêu Cầu Xuất Kho';

        return view("{$this->route}.export_material_request.index", compact('title'));
    }

    public function export_material_request_trash()
    {
        $title = 'Yêu Cầu Xuất Kho';

        return view("{$this->route}.export_material_request.trash", compact('title'));
    }

    public function create_export_material_request()
    {
        $title = 'Yêu Cầu Xuất Kho';

        $title_form = 'Tạo Phiếu Yêu Cầu Xuất Kho';

        $action = 'create';

        return view("{$this->route}.export_material_request.form", compact('title', 'title_form', 'action'));
    }

    public function store_export_material_request() {}

    public function update_export_material_request()
    {
        $title = 'Yêu Cầu Xuất Kho';

        $title_form = 'Cập Nhật Phiếu Yêu Cầu Xuất Kho';

        $action = 'update';

        return view("{$this->route}.export_material_request.form", compact('title', 'title_form', 'action'));
    }

    public function edit_export_material_request() {}
}
