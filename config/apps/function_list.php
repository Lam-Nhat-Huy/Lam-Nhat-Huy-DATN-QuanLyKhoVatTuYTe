<?php
return [
    'function_list' => [
        [
            'name' => 'Thống Kê',
            'route' => 'system.index',
        ],
        [
            'name' => 'Quản Lý Báo Cáo',
            'route' => 'report.index',
        ],
        [
            'name' => 'Thêm Báo Cáo',
            'route' => 'report.insert_report',
        ],
        [
            'name' => 'Quản Lý Người Dùng',
            'route' => 'user.index',
        ],
        [
            'name' => 'Thêm Người Dùng',
            'route' => 'user.add',
        ],
        [
            'name' => 'Quản Lý Nhập kho',
            'route' => 'warehouse.import',
        ],
        [
            'name' => 'Tạo Phiếu Nhập Kho',
            'route' => 'warehouse.create_import',
        ],
        [
            'name' => 'Quản Lý Xuất kho',
            'route' => 'warehouse.export',
        ],
        [
            'name' => 'Tạo Phiếu Xuất Kho',
            'route' => 'warehouse.create_export',
        ],
        [
            'name' => 'Quản Lý Tồn Kho',
            'route' => 'inventory.index',
        ],
        [
            'name' => 'Quản Lý Kiểm Kho',
            'route' => 'check_warehouse.index',
        ],
        [
            'name' => 'Tạo Phiếu Kiểm Kho',
            'route' => 'check_warehouse.create',
        ],
        [
            'name' => 'Quản Lý Thẻ Kho',
            'route' => 'card_warehouse.index',
        ],
        [
            'name' => 'Quản Lý Thiết Bị',
            'route' => 'equipments.index',
        ],
        [
            'name' => 'Thêm Mới Thiết Bị',
            'route' => 'equipments.insert_equipments',
        ],
        [
            'name' => 'Quản Lý Nhóm Thiết Bị',
            'route' => 'equipments.equipments_group',
        ],
        [
            'name' => 'Quản Lý Yêu Cầu Mua Hàng',
            'route' => 'material_request.import',
        ],
        [
            'name' => 'Tạo Phiếu Yêu Cầu Mua Hàng',
            'route' => 'material_request.create_import',
        ],
        [
            'name' => 'Quản Lý Yêu Cầu Xuất Kho',
            'route' => 'material_request.export',
        ],
        [
            'name' => 'Tạo Phiếu Yêu Cầu Xuất Kho',
            'route' => 'material_request.create_export',
        ],
        [
            'name' => 'Quản Lý Nhà Cung Cấp',
            'route' => 'supplier.list',
        ],
        [
            'name' => 'Thêm Mới Nhà Cung Cấp',
            'route' => 'supplier.create',
        ],
        [
            'name' => 'Quản Lý Thông Báo',
            'route' => 'notification.index',
        ],
        [
            'name' => 'Thêm Mới Thông Báo',
            'route' => 'notification.notification_add',
        ],
    ]
];
