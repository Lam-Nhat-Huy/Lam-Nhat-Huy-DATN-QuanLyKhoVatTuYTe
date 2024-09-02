<?php
return [
    'module' => [
        [
            'user_role' => [],
            'title' => 'Báo Cáo Và Thống Kê',
            'icon' => 'fa fa-chart-line',
            'route' => ['system.index', 'report.index'],
            'subModule' => [
                [
                    'title' => 'Thống Kê',
                    'route' => 'system.index',
                    'icon' => 'fa fa-square-poll-vertical',
                    'user_role' => []
                ],
                [
                    'title' => 'Báo Cáo',
                    'route' => 'report.index',
                    'icon' => 'fa fa-flag',
                    'user_role' => []
                ]
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Kho',
            'icon' => 'fa fa-warehouse',
            'route' => ['warehouse.import', 'warehouse.export', 'warehouse.check'],
            'subModule' => [
                [
                    'title' => 'Nhập Kho',
                    'route' => 'warehouse.import',
                    'icon' => 'fa fa-download',
                    'user_role' => []
                ],
                [
                    'title' => 'Xuất Kho',
                    'route' => 'warehouse.export',
                    'icon' => 'fa fa-upload',
                    'user_role' => []
                ],
                [
                    'title' => 'Kiểm Kho',
                    'route' => 'check_warehouse.index',
                    'icon' => 'fa fa-archive',
                    'user_role' => []
                ]
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Nhắn Tin',
            'icon' => 'fa fa-inbox',
            'route' => ['chat.list', 'chat.contact'],
            'subModule' => [
                [
                    'title' => 'Nhắn Tin',
                    'route' => 'chat.list',
                    'icon' => 'fa fa-message',
                    'user_role' => []
                ],
                [
                    'title' => 'Danh Bạ',
                    'route' => 'chat.contact',
                    'icon' => 'fa fa-address-book',
                    'user_role' => []
                ]
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Vật Tư',
            'icon' => 'fa-solid fa-suitcase-medical',
            'route' => ['material.index', 'material.material_group'],
            'subModule' => [
                [
                    'title' => 'Danh Sách Vật Tư',
                    'route' => 'material.index',
                    'icon' => 'fa fa-pump-medical',
                    'user_role' => []
                ],
                [
                    'title' => 'Danh Sách Nhóm Vật Tư',
                    'route' => 'material.material_group',
                    'icon' => 'fa fa-notes-medical',
                    'user_role' => []
                ]
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Yêu Cầu Đặt Hàng',
            'icon' => 'fa fa-bell-concierge',
            'route' => ['order_request.index'],
            'subModule' => [
                [
                    'title' => 'Danh Sách Yêu Cầu',
                    'route' => 'order_request.index',
                    'icon' => 'fa fa-rectangle-list',
                    'user_role' => []
                ],
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Thông Báo',
            'icon' => 'fa fa-bell',
            'route' => ['notification.index', 'notification.notification_type'],
            'subModule' => [
                [
                    'title' => 'Danh Sách Thông Báo',
                    'route' => 'notification.index',
                    'icon' => 'fa fa-bell',
                    'user_role' => []
                ],
                [
                    'title' => 'Loại Thông Báo',
                    'route' => 'notification.notification_type',
                    'icon' => 'fa fa-list',
                    'user_role' => []
                ],
            ]
        ],
    ]
];
