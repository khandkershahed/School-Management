<x-admin-app-layout>
    <style>
        td {
            vertical-align: middle;
        }
    </style>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl">
            <div class="card card-flush">
                <form id="bulk-delete-form" action="{{ route('admin.categories.bulk-delete') }}" method="POST">
                    @csrf
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5 bg-dark rounded-2">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <button type="submit" id="bulkDelete" class="btn btn-danger"
                                    style="display:none;">Delete
                                    Selected</button>
                            </div>
                            <span class="ms-4 text-white">Manage Your Categories</span>
                        </div>
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-white"><i
                                    class="fa-solid fa-plus"></i> Add Category</a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table my-datatable table-striped table-row-bordered gy-5 gx-5 border rounded">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th width="10%">
                                            <div class="form-check form-check-sm form-check-solid">
                                                <input class="form-check-input metronic_select_all" type="checkbox"
                                                    id="select-all" />
                                            </div>
                                        </th>
                                        <th width="10%">{{ __('category.Sl') }}</th>
                                        <th width="30%">{{ __('category.Parent') }}</th>
                                        <th width="20%">{{ __('category.Name') }}</th>
                                        <th width="10%">{{ __('category.Status') }}</th>
                                        <th width="20%" class="text-end pe-5">{{ __('category.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-sm form-check-solid">
                                                    <input class="form-check-input bulkDelete-checkbox" type="checkbox"
                                                        name="categories[]" value="{{ $category->id }}" />
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $category->parent_id ? $category->parent->name : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $category->name }}
                                            </td>
                                            <td>
                                                <div
                                                    class="badge {{ $category->status == 'active' ? 'badge-light-success' : 'badge-light-danger' }}">
                                                    {{ $category->status == 'active' ? 'Active' : 'InActive' }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.destroy', $category->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 delete"
                                                    data-kt-docs-table-filter="delete_row">
                                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @foreach ($category->children as $child)
                                            <tr>
                                                <td>
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input bulkDelete-checkbox"
                                                            type="checkbox" name="categories[]"
                                                            value="{{ $child->id }}" />
                                                    </div>
                                                </td>

                                                <td>
                                                    {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $child->parent->name ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    -- {{ $child->name }}
                                                </td>
                                                <td>
                                                    <div
                                                        class="badge {{ $child->status == 'active' ? 'badge-light-success' : 'badge-light-danger' }}">
                                                        {{ $child->status == 'active' ? 'Active' : 'InActive' }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.categories.show', $child->id) }}"
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.categories.edit', $child->id) }}"
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="{{ route('admin.categories.destroy', $child->id) }}"
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 delete"
                                                        data-kt-docs-table-filter="delete_row">
                                                        <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).on('change', '.status-toggle', function() {
                const id = $(this).data('id');
                const route = "{{ route('admin.categories.toggle-status', ':id') }}".replace(':id', id);
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
