<x-admin-app-layout :title="'Permissions List'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="card card-flush">
                <div class="card-header mt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" data-kt-permissions-table-filter="search"
                                class="form-control form-control-solid w-250px ps-15"
                                placeholder="Search Permissions" />
                        </div>
                    </div>

                    <div class="card-toolbar">
                        <a href="{{ route('admin.permission.create') }}" class="btn btn-primary rounded-2">
                            <i class="fas fa-plus me-2"></i> Add Permission
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Name</th>
                                    <th class="min-w-250px">Assigned to</th>
                                    <th class="min-w-125px">Created Date</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="fw-bold text-gray-600">
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            @foreach ($permission->roles as $role)
                                                @php
                                                    $badgeColors = [
                                                        'bg-primary',
                                                        'bg-secondary',
                                                        'bg-success',
                                                        'bg-danger',
                                                        'bg-warning',
                                                        'bg-info',
                                                        'bg-dark',
                                                    ];
                                                    $badgeColor = $badgeColors[array_rand($badgeColors)];
                                                @endphp
                                                <span
                                                    class="badge {{ $badgeColor }} fs-7 m-1">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $permission->created_at }}</td>
                                        <td class="text-end">

                                            <a href="{{ route('admin.permission.edit', $permission->id) }}"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                <span class="svg-icon svg-icon-3">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="{{ route('admin.permission.destroy', $permission->id) }}"
                                                class="btn btn-icon btn-active-light-danger w-30px h-30px delete">
                                                <span class="svg-icon svg-icon-3">
                                                    <i class="fas fa-trash-alt"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
