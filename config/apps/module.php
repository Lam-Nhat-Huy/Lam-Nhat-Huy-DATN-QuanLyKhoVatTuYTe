<?php
return [
    'module' => [
        [
            'user_role' => [],
            'title' => 'Báo Cáo Và Thống Kê',
            'icon' => 'fa fa-chart-line',
            'route' => ['system.index', 'report.index', 'report.insert_report', 'report.update_report'],
            'subModule' => [
                [
                    'title' => 'Thống Kê',
                    'route' => 'system.index',
                    'route_action' => [],
                    'icon' => 'fa fa-square-poll-vertical',
                    'user_role' => []
                ],
                [
                    'title' => 'Báo Cáo',
                    'route' => 'report.index',
                    'route_action' => ['report.insert_report', 'report.update_report'],
                    'icon' => 'fa fa-flag',
                    'user_role' => []
                ]
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Người Dùng',
            'icon' => 'fa fa-user',
            'route' => ['user.index', 'user.add', 'user.edit'],
            'subModule' => [
                [
                    'title' => 'Danh Sách',
                    'route' => 'user.index',
                    'route_action' => ['user.add', 'user.edit'],
                    'icon' => 'fa fa-list',
                    'user_role' => []
                ],
            ]
        ],
        [
            'user_role' => [],
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
                    'user_role' => []
                ],
                [
                    'title' => 'Xuất Kho',
                    'route' => 'warehouse.export',
                    'route_action' => ['warehouse.create_export'],
                    'icon' => 'fa fa-upload',
                    'user_role' => []
                ],
                [
                    'title' => 'Tồn Kho',
                    'route' => 'inventory.index',
                    'route_action' => [],
                    'icon' => 'fa fa-box',
                    'user_role' => []
                ],
                [
                    'title' => 'Kiểm Kho',
                    'route' => 'check_warehouse.index',
                    'route_action' => ['check_warehouse.create', 'check_warehouse.edit'],
                    'icon' => 'fa fa-archive',
                    'user_role' => []
                ],
                [
                    'title' => 'Thẻ Kho',
                    'route' => 'card_warehouse.index',
                    'route_action' => [],
                    'icon' => 'fa fa-clipboard',
                    'user_role' => []
                ]
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Vật Tư',
            'icon' => 'fa-solid fa-suitcase-medical',
            'route' => [
                'material.index',
                'material.material_group',
                'material.material_trash',
                'material.insert_material',
                'material.update_material',
                'material.material_group_trash',
                'material.update_material_group',
            ],
            'subModule' => [
                [
                    'title' => 'Danh Sách Vật Tư',
                    'route' => 'material.index',
                    'route_action' => ['material.material_trash', 'material.insert_material', 'material.update_material'],
                    'icon' => 'fa fa-pump-medical',
                    'user_role' => []
                ],
                [
                    'title' => 'Danh Sách Nhóm Vật Tư',
                    'route' => 'material.material_group',
                    'route_action' => ['material.material_group_trash', 'material.update_material_group'],
                    'icon' => 'fa fa-notes-medical',
                    'user_role' => []
                ]
            ]
        ],
        [
            'user_role' => [],
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
                    'user_role' => []
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
                    'user_role' => []
                ],
            ]
        ],
        [
            'user_role' => [],
            'title' => 'Nhà Cung Cấp',
            'icon' => 'fa fa-truck',
            'route' => ['supplier.list', 'supplier.create', 'supplier.edit', 'supplier.trash'],
            'subModule' => [
                [
                    'title' => 'Nhà cung cấp ',
                    'route' => 'supplier.list',
                    'route_action' => ['supplier.create', 'supplier.edit', 'supplier.trash'],
                    'icon' => 'fa fa-address-book',
                    'user_role' => []
                ],
            ]
        ],
        [
            'user_role' => [],
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
                    'title' => 'Danh Sách Thông Báo',
                    'route' => 'notification.index',
                    'route_action' => [
                        'notification.notification_add',
                        'notification.notification_edit',
                        'notification.notification_trash',
                    ],
                    'icon' => 'fa fa-bell',
                    'user_role' => []
                ],
                [
                    'title' => 'Loại Thông Báo',
                    'route' => 'notification.notification_type',
                    'route_action' => [
                        'notification.notification_type_edit',
                        'notification.notification_type_trash',
                    ],
                    'icon' => 'fa fa-list',
                    'user_role' => []
                ],
            ],
            [
                'title' => 'Tồn Kho',
                'route' => 'warehouse.inventory',
                'route_action' => [],
                'icon' => 'fas fa-clipboard-list',
                'user_role' => []
            ]
        ],
    ]
];
