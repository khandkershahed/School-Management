<x-admin-app-layout :title="'Accounts List'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Your Privacy Policy</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Export To Excel">
                                        <i class="fa-solid fa-file-csv"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Download PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Print Table">
                                        <i class="fa-solid fa-print"></i>
                                        <span class="tooltiptext">Print</span>
                                    </button>
                                    <a href="{{ route('admin.privacy-policy.create') }}"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Table -->
                            <table class="table table-striped datatable" style="width:100%">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th width="5%">SL</th>
                                        <th width="37%">Title</th>
                                        <th width="12%">Version</th>
                                        <th width="13%">Effective Date</th>
                                        <th width="13%">Expiration Date</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($policys as $key => $policy)
                                        <tr class="fw-bold text-gray-400 text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $policy->title }}</td>
                                            <td>{{ $policy->version }}</td>
                                            <td>{{ Carbon\Carbon::parse($policy->effective_date)->format('D,d M Y') }}
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($policy->expiration_date)->format('D,d M Y') }}
                                            </td>
                                            <td>
                                                @if ($policy->status == 'active')
                                                    <span class="badge badge-light-success">Active</span>
                                                @else
                                                    <span class="badge badge-light-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.privacy-policy.edit', $policy->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="{{ route('admin.privacy-policy.destroy', $policy->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm me-1 delete"
                                                    data-kt-docs-table-filter="delete_row">
                                                    <i class="fas fa-trash-alt"></i>
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
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {


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
            });
        </script>
    @endpush
</x-admin-app-layout>
