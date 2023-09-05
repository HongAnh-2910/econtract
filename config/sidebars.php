<?php
return [
    'menu_sidebars' => [
        [
            'name'       => 'Tổng quan',
            'icon'       => 'fa-image',
            'key'        => 'dashboard',
            'route'      => 'dashboard',
            'permission' => 'pass'
        ],
        [
            'name'       => 'Kho tài liệu',
            'icon'       => 'fa-folder',
            'key'        => 'dashboard_document',
            'route'      => 'web.folders.index',
            'permission' => 'permission.documents'
        ],
        [
            'name'       => 'Quản lý hợp đồng',
            'icon'       => 'fa-file',
            //            'route'    => 'contract.index',
            'key'        => 'dashboard_contract',
            'permission' => 'permission.contracts',
            'children'   => [
                [
                    'name'       => 'Hợp đồng nội bộ',
                    'key'        => 'dashboard_contract_local',
                    'icon'       => 'contact_icon',
                    'route'      => 'web.contracts.index',
                    'permission' => 'permission.contracts',
                ],
                [
                    'name'       => 'Hợp đồng khách hàng',
                    'key'        => 'dashboard_contract_customer',
                    'icon'       => 'contact_icon',
                    'route'      => 'web.contracts.indexCompany',
                    'permission' => 'permission.contracts',
                ]
            ]
        ],
        [
            'name'       => 'Quản lý khách hàng',
            'icon'       => 'fa-users',
            'key'        => 'dashboard_customer',
            'route'      => 'web.customers.list',
            'permission' => 'permission.customers',
        ],
        [
            'name'       => 'Đơn từ',
            'icon'       => 'fa-clipboard',
            'key'        => 'dashboard_application',
            'route'      => 'web.applications.index',
            'permission' => 'permission.letters',
        ],
        [
            'name'       => 'Quản lý phòng ban',
            'icon'       => 'fa-building',
            'key'        => 'dashboard_department',
            'route'      => 'web.departments.list',
            'permission' => 'permission.departments',
        ],
        [
            'name'       => 'Quản lý nhân sự',
            'icon'       => 'fa-address-card',
            'key'        => 'human-resource_list',
            'route'      => 'web.human-resources.list',
            'permission' => 'permission_human-resource',
        ],
        [
            'name'       => 'Quản lý cài đặt',
            'icon'       => 'fa-cog',
            'key'        => 'dashboard_setting',
            'route'      => 'web.profile.index',
            'permission' => 'pass',
        ]
    ],
    'menu_profile'  => [
        [
            'name'       => 'Quản lý tài khoản',
            'icon'       => 'fa-user',
            'key'        => 'profile',
            'route'      => 'web.profile.index',
            'permission' => 'pass',
        ],
        [
            'name'       => 'Đổi mật khẩu',
            'icon'       => 'fa-key',
            'key'        => 'profile_password',
            'permission' => 'pass',
            'route'      => 'web.profile.password'
        ],
        [
            'name'       => 'Danh sách thành viên',
            'icon'       => 'fa-user',
            'key'        => 'profile_list',
            'route'      => 'web.profile.list',
            'permission' => 'permission.members',
        ],
        [
            'name'       => 'Danh sách chữ ký',
            'icon'       => 'fa-edit',
            'key'        => 'profile_signature',
            'route'      => 'web.signature-list.index',
            'permission' => 'pass',
        ],
        [
            'name'       => 'Thanh toán',
            'icon'       => 'fa-envelope',
            'key'        => 'profile_payment',
            'route'      => 'web.profile.payment',
            'permission' => 'pass',
        ],
    ]
];
