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
            'route' => ['warehouse.import', 'warehouse.export'],
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
    ]
];
