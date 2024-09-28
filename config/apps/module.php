<?php
return [
    'module' => [
        [
            'user_role' => [0, 1],
            'title' => 'Báo Cáo Và Thống Kê',
            'icon' => 'fa fa-chart-line',
            'route' => ['system.index', 'report.index', 'report.insert_report', 'report.update_report'],
            'subModule' => [
                [
                    'title' => 'Thống Kê',
                    'route' => 'system.index',
                    'route_action' => [],
                    'icon' => 'fa fa-square-poll-vertical',
                    'user_role' => [0, 1],
                ],
                [
                    'title' => 'Báo Cáo',
                    'route' => 'report.index',
                    'route_action' => ['report.insert_report', 'report.update_report'],
                    'icon' => 'fa fa-flag',
                    'user_role' => [0, 1],
                ]
            ]
        ],
        [
            'user_role' => [1],
            'title' => 'Người Dùng',
            'icon' => 'fa fa-user',
            'route' => ['user.index', 'user.add', 'user.edit', 'user.user_trash'],
            'subModule' => [
                [
                    'title' => 'Danh Sách',
                    'route' => 'user.index',
                    'route_action' => ['user.add', 'user.edit', 'user.user_trash'],
                    'icon' => 'fa fa-bars',
                    'user_role' => [1],
                ],
            ]
        ],
        [
            'user_role' => [0, 1],
            'title' => 'Kho',
            'icon' => 'fa fa-warehouse',
            'route' => [
                'warehouse.import',
                'warehouse.export',
                'check_warehouse.index',
                'inventory.index',
                'card_warehouse.index',
                'warehouse.create_import',
                'warehouse.create_export',
                'check_warehouse.create',
                'check_warehouse.edit',
            ],
            'subModule' => [
                [
                    'title' => 'Nhập Kho',
                    'route' => 'warehouse.import',
                    'route_action' => ['warehouse.create_import'],
                    'icon' => 'fa fa-download',
                    'user_role' => [0, 1],
                ],
                [
                    'title' => 'Xuất Kho',
                    'route' => 'warehouse.export',
                    'route_action' => ['warehouse.create_export'],
                    'icon' => 'fa fa-upload',
                    'user_role' => [0, 1],
                ],
                [
                    'title' => 'Tồn Kho',
                    'route' => 'inventory.index',
                    'route_action' => [],
                    'icon' => 'fa fa-box',
                    'user_role' => [0, 1],
                ],
                [
                    'title' => 'Kiểm Kho',
                    'route' => 'check_warehouse.index',
                    'route_action' => ['check_warehouse.create', 'check_warehouse.edit'],
                    'icon' => 'fa fa-archive',
                    'user_role' => [0, 1],
                ],
                [
                    'title' => 'Thẻ Kho',
                    'route' => 'card_warehouse.index',
                    'route_action' => [],
                    'icon' => 'fa fa-clipboard',
                    'user_role' => [0, 1],
                ]
            ]
        ],
        [
            'user_role' => [0, 1],
            'title' => 'Thiết Bị',
            'icon' => 'fa-solid fa-suitcase-medical',
            'route' => [
                'equipments.index',
                'equipments.equipments_group',
                'equipments.equipments_trash',
                'equipments.insert_equipments',
                'equipments.update_equipments',
                'equipments.equipments_group_trash',
                'equipments.update_equipments_group',
            ],
            'subModule' => [
                [
                    'title' => 'Danh Sách Thiết Bị',
                    'route' => 'equipments.index',
                    'route_action' => ['equipments.equipments_trash', 'equipments.insert_equipments', 'equipments.update_equipments'],
                    'icon' => 'fa fa-pump-medical',
                    'user_role' => [0, 1],
                ],
                [
                    'title' => 'Danh Sách Nhóm Thiết Bị',
                    'route' => 'equipments.equipments_group',
                    'route_action' => ['equipments.equipments_group_trash', 'equipments.update_equipments_group'],
                    'icon' => 'fa fa-notes-medical',
                    'user_role' => [0, 1],
                ]
            ]
        ],
        [
            'user_role' => [0, 1],
            'title' => 'Yêu Cầu Nhập Xuất',
            'icon' => 'fa fa-bell-concierge',
            'route' => [
                'material_request.import',
                'material_request.export',
                'material_request.import_trash',
                'material_request.create_import',
                'material_request.update_import',
                'material_request.export_trash',
                'material_request.create_export',
                'material_request.update_export',
            ],
            'subModule' => [
                [
                    'title' => 'Yêu Cầu Nhập',
                    'route' => 'material_request.import',
                    'route_action' => [
                        'material_request.import_trash',
                        'material_request.create_import',
                        'material_request.update_import',
                    ],
                    'icon' => 'fa fa-upload',
                    'user_role' => [0, 1],
                ],
                [
                    'title' => 'Yêu Cầu Xuất',
                    'route' => 'material_request.export',
                    'route_action' => [
                        'material_request.export_trash',
                        'material_request.create_export',
                        'material_request.update_export',
                    ],
                    'icon' => 'fa fa-download',
                    'user_role' => [0, 1],
                ],
            ]
        ],
        [
            'user_role' => [0, 1],
            'title' => 'Nhà Cung Cấp',
            'icon' => 'fa fa-truck',
            'route' => ['supplier.list', 'supplier.create', 'supplier.edit', 'supplier.trash'],
            'subModule' => [
                [
                    'title' => 'Nhà cung cấp ',
                    'route' => 'supplier.list',
                    'route_action' => ['supplier.create', 'supplier.edit', 'supplier.trash'],
                    'icon' => 'fa fa-address-book',
                    'user_role' => [0, 1],
                ],
            ]
        ],
        [
            'user_role' => [0, 1],
            'title' => 'Thông Báo',
            'icon' => 'fa fa-bell',
            'route' => [
                'notification.index',
                'notification.notification_type',
                'notification.notification_add',
                'notification.notification_edit',
                'notification.notification_trash',
                'notification.notification_type_edit',
                'notification.notification_type_trash',
            ],
            'subModule' => [
                [
                    'title' => 'Danh Sách',
                    'route' => 'notification.index',
                    'route_action' => [
                        'notification.notification_add',
                        'notification.notification_edit',
                        'notification.notification_trash',
                    ],
                    'icon' => 'fa fa-bars',
                    'user_role' => [0, 1],
                ],
            ],
        ],
    ]
];
