<x-admin-app-layout :title="'Brand Management'">
    <div class="row">
        <div class="col-xl-4 mx-auto">
            <div class="card card-flush shadow-sm">
                <div class="card-body p-0">
                    <div class="d-flex flex-stack justify-content-between ">
                        <div class="d-flex align-items-center me-3 p-8 rounded-3 bg-success">
                            <a href="javascript:void(0)">
                                <span class="bg-black rounded-3 p-3 me-3"><i class="fa-solid text-white fa-copyright fs-3"
                                        aria-hidden="true"></i></span>
                            </a>
                            <div class="flex-grow-1">
                                <a href="javascript:void(0)">
                                </a>
                                <a href="#" class="text-black fs-5 fw-bold lh-0">Total Brand
                                    <span class="text-black fw-semibold d-block fs-6 pt-4">{{ date('d-M-Y') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center pe-4">
                            <div>
                                <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ $brands->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-flush mt-10">
        <div class="card-header bg-success align-items-center">
            <h3 class="card-title">Brands List</h3>
            <div>
                <a class="btn btn-sm btn-light-primary rounded-0" href="{{ route('admin.brands.create') }}">
                    <i class="fa-solid fa-plus pe-2" aria-hidden="true"></i>
                    Add
                </a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table my-datatable table-striped table-row-bordered gy-5 gs-7 border rounded">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                        <th width="10%">SL No.</th>
                        <th width="25%">Logo</th>
                        <th width="35%">Name</th>
                        <th width="15%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($brands as $brand)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="w-65px" src="{{ asset('storage/' . $brand->logo) }}"
                                    alt="{{ $brand->name }}"></td>
                            <td>{{ ucfirst($brand->name) }}</td>
                            <td>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input status-toggle" type="checkbox"
                                        id="status_toggle_{{ $brand->id }}" @checked($brand->status == 'active')
                                        data-id="{{ $brand->id }}" />
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.brands.destroy', $brand->id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 delete"
                                    data-kt-docs-table-filter="delete_row">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
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
                const route = "{{ route('admin.brands.toggle-status', ':id') }}".replace(':id', id);
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
