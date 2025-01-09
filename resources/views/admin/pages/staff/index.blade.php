<x-admin-app-layout :title="'Staffs List'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="card border-0 shadow-none">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-md-8 col-7">
                            <h5 class="text-center m-0 text-info">Staff Management</h5>
                        </div>
                        <div class="col-lg-3 col-md-4 col-5 text-center">
                            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary rounded-1">
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-plus"></i>
                                </span>
                                Add Staff
                            </a>
                        </div>
                    </div>
                </div>


                <div class="card-body table-responsive">
                    <table class="table table-striped fs-6 gy-5">
                        <thead>
                            <tr>
                                <th width="40%" class="text-start">Staff</th>
                                <th width="40%" class="text-start">Role</th>
                                <th width="20%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($staffs as $staff)
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="javascript:void(0)">
                                                <div class="symbol-label">
                                                    <img src="{{ !empty($staff->photo) && file_exists(public_path('storage/' . $staff->photo)) ? asset('storage/' . $staff->photo) : asset('https://ui-avatars.com/api/?name=' . urlencode($staff->name)) }}"
                                                        alt="{{ $staff->name }}" class="" width="50px"/>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="d-flex flex-column">
                                            <a href="javascript:void(0)"
                                                class="text-primary mb-1">{{ $staff->name }}</a>
                                            <span class="text-muted">{{ $staff->email }}</span>
                                        </div>

                                    </td>

                                    <td>
                                        @forelse ($staff->getRoleNames() as $role)
                                            <span class="badge bg-success fw-bolder">{{ $role }}</span>

                                        @empty
                                            <span class="badge bg-danger fw-bolder">No Role</span>
                                        @endforelse
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.staff.show', $staff->id) }}"
                                            class="px-2">
                                            <i class="text-warning fa-solid fa-expand"></i>
                                        </a>

                                        <a href="{{ route('admin.staff.edit', $staff->id) }}"
                                            class="px-2">
                                            <i class="text-info fa-solid fa-pencil"></i>
                                        </a>

                                        <a href="{{ route('admin.staff.destroy', $staff->id) }}"
                                            class="px-2 delete">
                                            <i class="text-danger fa-solid fa-trash-alt"></i>
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
</x-admin-app-layout>
