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
                                'admin.students.index',
                                'admin.education-medium.index',
                                'admin.education-medium.create',
                                'admin.education-medium.edit',
                            ],
                            'subMenu' => [
                                // [
                                //     'title' => 'Education Medium',
                                //     'routes' => [
                                //         'admin.education-medium.index',
                                //         'admin.education-medium.create',
                                //         'admin.education-medium.edit',
                                //     ],
                                //     'route' => 'admin.education-medium.index',
                                // ],
                                [
                                    'title' => 'Students List',
                                    'routes' => [
                                        'admin.students.index',
                                        'admin.students.create',
                                        'admin.students.edit',
                                    ],
                                    'route' => 'admin.students.index',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Fee Management',
                            'icon' => 'fa-solid fa-wallet text-info',
                            'routes' => [
                                'admin.fees.index',
                                'admin.fees.create',
                                'admin.fees.edit',
                                'admin.student-fee.index',
                                'admin.student-fee.create',
                                'admin.student-fee.edit',
                                'admin.fee-waiver.index',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'All Fees',
                                    'routes' => [
                                        'admin.fees.index',
                                        'admin.fees.create',
                                        'admin.fees.edit',
                                    ],
                                    'route' => 'admin.fees.index',
                                ],
                                [
                                    'title' => 'Fee Waiver',
                                    'routes' => [
                                        'admin.fee-waiver.index',
                                        'admin.fee-waiver.create',
                                        'admin.fee-waiver.edit',
                                    ],
                                    'route' => 'admin.fee-waiver.index',
                                ],
                                [
                                    'title' => 'Student Fee Collection',
                                    'routes' => [
                                        'admin.student-fee.index',
                                        'admin.student-fee.create',
                                        'admin.student-fee.edit',
                                    ],
                                    'route' => 'admin.student-fee.index',
                                ],
                                // [
                                //     'title' => 'Incomes List',
                                //     'routes' => ['admin.income.index', 'admin.income.create', 'admin.income.edit'],
                                //     'route' => 'admin.income.index',
                                // ],
                            ],
                        ],



                        [
                            'title' => 'Reports',
                            'icon' => 'fa-solid fa-wallet text-info',
                            'routes' => [
                                'admin.fee-reports',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Report Dashboard',
                                    'routes' => [
                                        'admin.fee-reports',
                                    ],
                                    'route' => 'admin.fee-reports',
                                ],

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
                                // [
                                //     'title' => 'Email Setting',
                                //     'routes' => ['admin.email-settings.index'],
                                //     'route' => 'admin.email-settings.index',
                                // ],

                                [
                                    'title' => 'Database Backup',
                                    'routes' => ['admin.database.backup'],
                                    'route' => 'admin.database.backup',
                                ],
                                // [
                                //     'title' => 'Profile Setting',
                                //     // 'routes' => ['admin.email-settings.index'],
                                //     // 'route' => 'admin.email-settings.index',
                                // ],
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
