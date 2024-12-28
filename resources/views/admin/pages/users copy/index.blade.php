<x-admin-app-layout :title="'Users List'">
    <div class="card">
        <div class="card-header border-0 align-items-center bg-dark">
            <div>
                <div class="card-title text-white">Manage Your Users</div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary rounded-1">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        Add User
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            <table class="table my-datatable align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                <thead>
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="ps-3">SL</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end min-w-100px pe-5">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-bold">
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="javascript:void(0)">
                                        <div class="symbol-label"
                                            style="background-color: {{ $user->profile_image ? 'transparent' : '#d3d3d3' }};">
                                            @if ($user->profile_image)
                                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                                    alt="{{ $user->name }}" class="w-100" />
                                            @else
                                                <span class="text-gray-800 text-hover-primary mb-1">
                                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="javascript:void(0)"
                                        class="text-gray-800 text-hover-primary mb-1">{{ $user->first_name }}
                                        {{ $user->last_name }}</a>
                                </div>
                            </td>
                            <td>
                                <span>{{ $user->email }}</span>
                            </td>
                            <td>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        id="status_toggle_{{ $user->id }}" @checked($user->status == 'active')
                                        data-id="{{ $user->id }}" />
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.user.show', $user->id) }}"
                                    class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-30px w-30px me-3">
                                    <i class="fa-solid fa-eye" title="User Details"></i>
                                </a>
                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                    class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-30px w-30px me-3">
                                    <i class="fa-solid fa-pen" title="User Edit"></i>
                                </a>
                                <a href="{{ route('admin.user.destroy', $user->id) }}"
                                    class="btn btn-sm btn-icon btn-danger btn-active-light-danger toggle h-30px w-30px delete">
                                    <i class="fa-solid fa-trash-alt" title="User Delete"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).on('change', '.status-toggle', function() {
                const id = $(this).data('id');
                const route = "{{ route('admin.user.toggle-status', ':id') }}".replace(':id', id);
                toggleStatus(route, id);
            });

            function toggleStatus(route, id) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Status updated successfully!');
                            table.ajax.reload(null, false); // Reload the DataTable
                        } else {
                            alert('Failed to update status.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while updating the status.');
                    }
                });
            }
        </script>
    @endpush
</x-admin-app-layout>
