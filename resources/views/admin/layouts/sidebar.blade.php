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
                            'permissions' => ['view dashboard'], // Add permissions for this menu item
                            'routes' => [],
                        ],
                        [
                            'title' => 'Student Management',
                            'icon' => 'fa-solid fa-users text-info',
                            'permissions' => ['view student'], // Add permissions for this menu item
                            'routes' => [
                                'admin.students.index',
                                'admin.education-medium.index',
                                'admin.education-medium.create',
                                'admin.education-medium.edit',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Students List',
                                    'permissions' => ['view student'], // Permission for sub-menu
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
                            'permissions' => ['view fee'], // Add permissions for this menu item
                            'routes' => [
                                'admin.fees.index',
                                'admin.fees.create',
                                'admin.fees.edit',
                                'admin.student-fee.index',
                                'admin.student-fee.create',
                                'admin.student-fee.edit',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'All Fees',
                                    'permissions' => ['view fee'], // Permission for sub-menu
                                    'routes' => ['admin.fees.index', 'admin.fees.create', 'admin.fees.edit'],
                                    'route' => 'admin.fees.index',
                                ],
                                [
                                    'title' => 'Fee Waiver',
                                    'permissions' => ['view fee-waiver'], // Permission for sub-menu
                                    'routes' => [
                                        'admin.fee-waiver.index',
                                        'admin.fee-waiver.create',
                                        'admin.fee-waiver.edit',
                                    ],
                                    'route' => 'admin.fee-waiver.index',
                                ],
                                [
                                    'title' => 'Student Fee Collection',
                                    'permissions' => ['fee collection'], // Permission for sub-menu
                                    'routes' => [
                                        'admin.student-fee.index',
                                        'admin.student-fee.create',
                                        'admin.student-fee.edit',
                                    ],
                                    'route' => 'admin.student-fee.index',
                                ],
                                [
                                    'title' => 'Invoice List',
                                    'permissions' => ['view fee'], // Permission for sub-menu
                                    'routes' => ['admin.invoice.list'],
                                    'route' => 'admin.invoice.list',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Reports',
                            'icon' => 'fa-solid fa-chart-line text-info',
                            'permissions' => ['view report'], // Add permissions for this menu item
                            'routes' => [
                                'admin.fee-reports',
                                'admin.report.daily-transaction',
                                'admin.report.daily-netincome',
                                'admin.report.daily-ledger',
                                'admin.report.monthlydue',
                                'admin.report.examdue',
                                'admin.report.studentinvoice',
                                'admin.report.income',
                                'admin.report.duefee',
                                'admin.report.accountingbalance',
                                'admin.report.customreport',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'Daily Transaction Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.daily-transaction'],
                                    'route' => 'admin.report.daily-transaction',
                                ],
                                [
                                    'title' => 'Daily Net Income',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.daily-netincome'],
                                    'route' => 'admin.report.daily-netincome',
                                ],
                                [
                                    'title' => 'Ledger Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.daily-ledger'],
                                    'route' => 'admin.report.daily-ledger',
                                ],
                                [
                                    'title' => 'Student Monthly Due Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.monthlydue'],
                                    'route' => 'admin.report.monthlydue',
                                ],
                                [
                                    'title' => 'Student Exam Due Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.examdue'],
                                    'route' => 'admin.report.examdue',
                                ],
                                [
                                    'title' => 'Student Invoice Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.studentinvoice'],
                                    'route' => 'admin.report.studentinvoice',
                                ],
                                [
                                    'title' => 'Accounting Balance Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.accountingbalance'],
                                    'route' => 'admin.report.accountingbalance',
                                ],
                                // [
                                //     'title' => 'Due Fee Report',
                                //     'permissions' => ['view report'], // Permission for sub-menu
                                //     'routes' => ['admin.report.duefee'],
                                //     'route' => 'admin.report.duefee',
                                // ],
                                [
                                    'title' => 'Custom Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.customreport'],
                                    'route' => 'admin.report.customreport',
                                ],
                                [
                                    'title' => 'Income Report',
                                    'permissions' => ['view report'], // Permission for sub-menu
                                    'routes' => ['admin.report.income'],
                                    'route' => 'admin.report.income',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Staff Management',
                            'icon' => 'fa-solid fa-users text-info',
                            'permissions' => ['view staff'], // Add permissions for this menu item
                            'routes' => [
                                'admin.staff.index',
                                'admin.staff.create',
                                'admin.staff.edit',
                                'admin.role.index',
                                'admin.role.create',
                                'admin.role.edit',
                                'admin.permission.index',
                                'admin.permission.create',
                                'admin.permission.edit',
                            ],
                            'subMenu' => [
                                [
                                    'title' => 'All Staffs',
                                    'permissions' => ['view staff'], // Permission for sub-menu
                                    'routes' => ['admin.staff.index', 'admin.staff.create', 'admin.staff.edit'],
                                    'route' => 'admin.staff.index',
                                ],
                                [
                                    'title' => 'Role Manage',
                                    'permissions' => ['view role'], // Permission for sub-menu
                                    'routes' => ['admin.role.index', 'admin.role.create', 'admin.role.edit'],
                                    'route' => 'admin.role.index',
                                ],
                                [
                                    'title' => 'Permissions',
                                    'permissions' => ['view permission'], // Permission for sub-menu
                                    'routes' => [
                                        'admin.permission.index',
                                        'admin.permission.create',
                                        'admin.permission.edit',
                                    ],
                                    'route' => 'admin.permission.index',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Setup',
                            'icon' => 'fa-solid fa-gear text-info',
                            'permissions' => ['view setup'], // Add permissions for this menu item
                            'routes' => ['admin.settings.index', 'admin.email-settings.index', 'admin.database.backup'],
                            'subMenu' => [
                                [
                                    'title' => 'Website Setting',
                                    'permissions' => ['update setting'], // Permission for sub-menu
                                    'routes' => ['admin.settings.index'],
                                    'route' => 'admin.settings.index',
                                ],
                                [
                                    'title' => 'Database Backup',
                                    'permissions' => ['download backup'], // Permission for sub-menu
                                    'routes' => ['admin.database.backup'],
                                    'route' => 'admin.database.backup',
                                ],
                            ],
                        ],
                    ];
                @endphp

                @foreach ($menuItems as $item)
                    @can($item['permissions'])
                        <!-- Check permission dynamically for menu item -->
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
                                        @can($subItem['permissions'])
                                            <!-- Check permission dynamically for sub-menu -->
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
                                                            @can($subSubItem['permissions'])
                                                                <!-- Check permission for nested sub-menu -->
                                                                <li class="nav-item">
                                                                    <a href="{{ isset($subSubItem['route']) ? route($subSubItem['route']) : 'javascript:void(0)' }}"
                                                                        class="nav-link">
                                                                        <i class="nav-icon fa-solid fa-circle"></i>
                                                                        <p>{{ $subSubItem['title'] }}</p>
                                                                    </a>
                                                                </li>
                                                            @endcan
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endcan
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endcan
                @endforeach
            </ul>
        </nav>

        <div class="logout-btn-wrapper">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <a href="" class="btn-common-one mx-3 text-white" tabindex="0"
                    onclick="event.preventDefault();
                    this.closest('form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2" class="h-6 w-6" width="25px" height="25px">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </a>
            </form>
        </div>
    </div>
</aside>
