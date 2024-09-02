<?php

namespace App\Http\Controllers\OrderRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderRequestController extends Controller
{
    protected $route = 'order_request';

    public function index()
    {
        $title = 'Yêu Cầu Đặt Hàng';

        $AllOrderRequest = [
            [
                'id' => 1,
                'order_request_code' => 'HD001',
                'supplier_id' => 1,
                'user_create' => 'Lữ Phát Huy - KT - BS231',
                'date_of_entry' => '30/08/2024',
                'status' => 1
            ],
            [
                'id' => 2,
                'order_request_code' => 'HD002',
                'supplier_id' => 2,
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
        ];

        return view("{$this->route}.index", compact('title', 'AllOrderRequest'));
    }

    public function insert_order_request()
    {
        $title = 'Yêu Cầu Đặt Hàng';

        $title_form = 'Thêm Yêu Cầu Đặt Hàng';

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

        return view("{$this->route}.form", compact('title', 'title_form', 'action', 'AllSuppiler', 'AllMaterial'));
    }

    public function order_request_trash()
    {
        $title = 'Yêu Cầu Đặt Hàng';

        $AllOrderRequestTrash = [
            [
                'id' => 1,
                'order_request_code' => 'HD001',
                'supplier_id' => 1,
                'user_create' => 'Lữ Phát Huy - KT - BS231',
                'date_of_entry' => '30/08/2024',
                'status' => 1
            ],
            [
                'id' => 2,
                'order_request_code' => 'HD002',
                'supplier_id' => 2,
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
        ];

        return view("{$this->route}.trash", compact('title', 'AllOrderRequestTrash'));
    }

    public function create() {}

    public function update_order_request()
    {
        $title = 'Yêu Cầu Đặt Hàng';

        $title_form = 'Cập Nhật Yêu Cầu Đặt Hàng';

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

        return view("{$this->route}.form", compact('title', 'title_form', 'action', 'AllMaterial', 'AllSuppiler'));
    }

    public function edit() {}
}
