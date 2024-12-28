<aside class="app-sidebar bg-body-secondary" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}"
            class="brand-link text-center d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/logo-color.png') }}" alt="AdminLTE Logo" class="brand-image" />
        </a>
    </div>
    <div class="sidebar-wrapper main-sidebar position-relative"> <!-- Added position-relative -->
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @php
                    $menuItems = [
                        [
                            'title' => 'Dashboard',
                            'icon' => 'fa-solid fa-home text-info',
                            'route' => 'admin.dashboard',
                            'routes' => [],
                        ],
                        [
                            'title' => 'Student Management',
                            'icon' => 'fa-solid fa-users text-info',
                            'routes' => [
                                'admin.clients.index',
                                'admin.education-medium.index',
                                'admin.education-medium.create',
                                'admin.education-medium.edit',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Education Medium',
                                    'routes' => [
                                        'admin.education-medium.index',
                                        'admin.education-medium.create',
                                        'admin.education-medium.edit',
                                    ],
                                    'route' => 'admin.education-medium.index',
                                ],
                                [
                                    'title' => 'Students List',
                                    'routes' => [
                                        'admin.clients.index',
                                        'admin.education-medium.index',
                                        'admin.education-medium.create',
                                        'admin.education-medium.edit',
                                    ],
                                    'route' => 'admin.clients.index',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Incomes',
                            'icon' => 'fa-solid fa-wallet text-info',
                            'routes' => [
                                'admin.income.index',
                                'admin.income.create',
                                'admin.income.edit',
                                'admin.income-category.index',
                                'admin.income-category.create',
                                'admin.income-category.edit',
                                'admin.income-subcategory.index',
                                'admin.income-subcategory.create',
                                'admin.income-subcategory.edit',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Income Category',
                                    'routes' => [
                                        'admin.income-category.index',
                                        'admin.income-category.create',
                                        'admin.income-category.edit',
                                    ],
                                    'route' => 'admin.income-category.index',
                                ],
                                [
                                    'title' => 'Income Sub Category',
                                    'routes' => [
                                        'admin.income-subcategory.index',
                                        'admin.income-subcategory.create',
                                        'admin.income-subcategory.edit',
                                    ],
                                    'route' => 'admin.income-subcategory.index',
                                ],
                                [
                                    'title' => 'Incomes List',
                                    'routes' => ['admin.income.index', 'admin.income.create', 'admin.income.edit'],
                                    'route' => 'admin.income.index',
                                ],
                            ],
                        ],

                        // [
                        //     'title' => 'Payments',
                        //     'icon' => 'fa-solid fa-receipt text-info',
                        //     'routes' => [
                        //         'admin.client-invoice.index',
                        //         'admin.client-invoice.create',
                        //         'admin.client-invoice.edit',
                        //         'admin.client-non-invoice.index',
                        //         'admin.client-non-invoice.create',
                        //         'admin.client-non-invoice.edit',
                        //         'admin.payroll.index',
                        //         'admin.payroll.create',
                        //         'admin.payroll.edit',
                        //     ],
                        //     'subMenu' => [
                        //         [
                        //             'title' => 'Client Invoice',
                        //             'routes' => [
                        //                 'admin.client-invoice.index',
                        //                 'admin.client-invoice.create',
                        //                 'admin.client-invoice.edit',
                        //             ],
                        //             'route' => 'admin.client-invoice.index',
                        //         ],
                        //         [
                        //             'title' => 'Client Non Invoice',
                        //             'routes' => [
                        //                 'admin.client-non-invoice.index',
                        //                 'admin.client-non-invoice.create',
                        //                 'admin.client-non-invoice.edit',
                        //             ],
                        //             'route' => 'admin.client-non-invoice.index',
                        //         ],
                        //         [
                        //             'title' => 'Payroll',
                        //             'routes' => ['admin.payroll.index', 'admin.payroll.create', 'admin.payroll.edit'],
                        //             'route' => 'admin.payroll.index',
                        //         ],
                        //     ],
                        // ],

                        [
                            'title' => 'Employees',
                            'icon' => 'fa-solid fa-users text-info',
                            'routes' => [
                                'admin.employeee-department.index',
                                'admin.employeee-department.create',
                                'admin.employeee-department.edit',
                                'admin.employee.index',
                                'admin.employee.create',
                                'admin.employee.edit',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Departments',
                                    'routes' => ['admin.employeee-department.index'],
                                    'route' => 'admin.employeee-department.index',
                                ],
                                [
                                    'title' => 'Employee List',
                                    'routes' => ['admin.employee.index'],
                                    'route' => 'admin.employee.index',
                                ],
                            ],
                        ],

                        [
                            'title' => 'Reports',
                            'icon' => 'fa-solid fa-file text-info',
                            'routes' => [
                                'admin.balance-sheet.index',
                                'admin.balance-sheet.create',
                                'admin.balance-sheet.edit',
                                'admin.today-report.index',
                                'admin.today-report.create',
                                'admin.today-report.edit',
                                'admin.summary-report.index',
                                'admin.summary-report.create',
                                'admin.summary-report.edit',
                                'admin.expense-report.index',
                                'admin.expense-report.create',
                                'admin.expense-report.edit',
                                'admin.client-receivable.index',
                                'admin.client-receivable.create',
                                'admin.client-receivable.edit',
                                'admin.client-payable.index',
                                'admin.client-payable.create',
                                'admin.client-payable.edit',
                                'admin.sales-user.index',
                                'admin.sales-user.create',
                                'admin.sales-user.edit',
                                'admin.collection-report.index',
                                'admin.collection-report.create',
                                'admin.collection-report.edit',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Balance Sheet',
                                    'routes' => [
                                        'admin.balance-sheet.index',
                                        'admin.balance-sheet.create',
                                        'admin.balance-sheet.edit',
                                    ],
                                    'route' => 'admin.balance-sheet.index',
                                ],
                                [
                                    'title' => 'Today Report',
                                    'routes' => [
                                        'admin.today-report.index',
                                        'admin.today-report.create',
                                        'admin.today-report.edit',
                                    ],
                                    'route' => 'admin.today-report.index',
                                ],
                                [
                                    'title' => 'Summary Report',
                                    'routes' => [
                                        'admin.summary-report.index',
                                        'admin.summary-report.create',
                                        'admin.summary-report.edit',
                                    ],
                                    'route' => 'admin.summary-report.index',
                                ],
                                [
                                    'title' => 'Expense Report',
                                    'routes' => ['admin.expense-report.index'],
                                    'route' => 'admin.expense-report.index',
                                ],
                                // [
                                //     'title' => 'Client Receivable Report',
                                //     'routes' => [
                                //         'admin.client-receivable.index',
                                //         'admin.client-receivable.create',
                                //         'admin.client-receivable.edit',
                                //     ],
                                //     'route' => 'admin.client-receivable.index',
                                // ],
                                // [
                                //     'title' => 'Client Payable Report',
                                //     'routes' => [
                                //         'admin.client-payable.index',
                                //         'admin.client-payable.create',
                                //         'admin.client-payable.edit',
                                //     ],
                                //     'route' => 'admin.client-payable.index',
                                // ],
                                // [
                                //     'title' => 'Sales By User Report',
                                //     'routes' => [
                                //         'admin.sales-user.index',
                                //         'admin.sales-user.create',
                                //         'admin.sales-user.edit',
                                //     ],
                                //     'route' => 'admin.sales-user.index',
                                // ],
                                // [
                                //     'title' => 'Collection By User Report',
                                //     'routes' => [
                                //         'admin.collection-report.index',
                                //         'admin.collection-report.create',
                                //         'admin.collection-report.edit',
                                //     ],
                                //     'route' => 'admin.collection-report.index',
                                // ],
                            ],
                        ],

                        [
                            'title' => 'Setup',
                            'icon' => 'fa-solid fa-gear text-info',
                            'routes' => [
                                'admin.settings.index',
                                'admin.email-settings.index',
                                'admin.email-settings.index',
                                'admin.database.backup',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Website Setting',
                                    'routes' => ['admin.settings.index'],
                                    'route' => 'admin.settings.index',
                                ],
                                [
                                    'title' => 'Email Setting',
                                    'routes' => ['admin.email-settings.index'],
                                    'route' => 'admin.email-settings.index',
                                ],

                                [
                                    'title' => 'Database Backup',
                                    'routes' => ['admin.database.backup'],
                                    'route' => 'admin.database.backup',
                                ],
                                [
                                    'title' => 'Profile Setting',
                                    // 'routes' => ['admin.email-settings.index'],
                                    // 'route' => 'admin.email-settings.index',
                                ],
                            ],
                        ],
                    ];
                    // if (Auth::guard('admin')->user()->account_role == '0') {
                    //     $menuItems[8]['subMenu'][] = [
                    //         'title' => 'Admin Setting',
                    //         'routes' => ['admin.admin-managemnet.index'],
                    //         'route' => 'admin.admin-managemnet.index',
                    //     ];
                    // }
                @endphp

                @foreach ($menuItems as $item)
                    <li class="nav-item {{ Route::is(...$item['routes'] ?? []) ? 'menu-open' : '' }}">
                        <a href="{{ isset($item['route']) ? route($item['route']) : 'javascript:void(0)' }}"
                            class="nav-link {{ Route::is($item['route'] ?? '') ? 'active' : '' }}">
                            <i class="nav-icon {{ $item['icon'] ?? 'fa-solid fa-gauge-simple-high' }}"></i>
                            <p>
                                {{ $item['title'] }}
                                @if (!empty($item['subMenu']))
                                    <i class="nav-arrow fa-solid fa-chevron-right"></i>
                                @endif
                            </p>
                        </a>
                        @if (!empty($item['subMenu']))
                            <ul class="nav nav-treeview">
                                @foreach ($item['subMenu'] as $subItem)
                                    <li
                                        class="nav-item {{ Route::is(...$subItem['routes'] ?? []) ? 'menu-open' : '' }}">
                                        <a href="{{ isset($subItem['route']) ? route($subItem['route']) : 'javascript:void(0)' }}"
                                            class="nav-link {{ Route::is($subItem['route'] ?? '') ? 'active' : '' }}">
                                            <i
                                                class="nav-icon {{ $subItem['icon'] ?? 'fa-solid fa-arrow-right-long' }}"></i>
                                            <p>
                                                {{ $subItem['title'] }}
                                                @if (!empty($subItem['subMenu']))
                                                    <i class="nav-arrow fa-solid fa-chevron-right"></i>
                                                @endif
                                            </p>
                                        </a>
                                        @if (!empty($subItem['subMenu']))
                                            <ul class="nav nav-treeview">
                                                @foreach ($subItem['subMenu'] as $subSubItem)
                                                    <li class="nav-item">
                                                        <a href="{{ isset($subSubItem['route']) ? route($subSubItem['route']) : 'javascript:void(0)' }}"
                                                            class="nav-link">
                                                            <i class="nav-icon fa-solid fa-circle"></i>
                                                            <p>{{ $subSubItem['title'] }}</p>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="logout-btn-wrapper">
            <a href="" class="btn-common-one mx-3 text-white" tabindex="0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2" class="h-6 w-6" width="25px" height="25px">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </a>
        </div>
    </div>
</aside>
