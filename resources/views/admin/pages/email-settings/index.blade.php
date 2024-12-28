<x-admin-app-layout :title="'Email-settings List'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Your Expences</h4>
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
                                    </button>
                                    <a href="{{ route('admin.active.mail.configuration') }}"
                                        class="btn btn-outline-light toltip" data-tooltip="Setting">
                                        <i class="fa-solid fa-hammer"></i>
                                        <i class="fa-solid fa-gear"></i>
                                    </a>
                                    <a href="{{ route('admin.email-settings.create') }}"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table datatable w-100">
                                <thead>
                                    <tr>
                                        <th width="10%" class="text-center">Mailer</th>
                                        <th width="15%" class="text-center">Host</th>
                                        <th width="8%" class="text-center">Port</th>
                                        <th width="20%" class="text-center">Username</th>
                                        <th width="10%" class="text-center">Encryption</th>
                                        <th width="15%" class="text-center">From Address</th>
                                        <th width="12%" class="text-center">From Name</th>
                                        <th width="5%" class="text-center">Status</th>
                                        <th width="5%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center text-capitalize">
                                    {{-- Content Are Dynamic --}}
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
                var table = $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.email-settings.index') }}",
                    columns: [
                        // {
                        //     data: 'checkbox',
                        //     name: 'checkbox',
                        //     orderable: false,
                        //     searchable: false
                        // },
                        {
                            data: 'mail_mailer',
                            name: 'mail_mailer'
                        },
                        {
                            data: 'mail_host',
                            name: 'mail_host'
                        },
                        {
                            data: 'mail_port',
                            name: 'mail_port'
                        },
                        {
                            data: 'mail_username',
                            name: 'mail_username'
                        },
                        {
                            data: 'mail_encryption',
                            name: 'mail_encryption'
                        },
                        {
                            data: 'mail_from_address',
                            name: 'mail_from_address'
                        },
                        {
                            data: 'mail_from_name',
                            name: 'mail_from_name'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                return `
                                    <div class="form-check form-switch form-check-custom form-check-solid d-flex justify-content-center">
                                        <input class="form-check-input status-toggle" type="checkbox" id="status_toggle_${row.id}" ${data == 1 ? 'checked' : ''} data-id="${row.id}" />
                                    </div>
                                `;
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                $(document).on('change', '.status-toggle', function() {
                    const id = $(this).data('id');
                    const route = "{{ route('admin.email-settings.toggle-status', ':id') }}".replace(':id', id);
                    toggleStatus(route, id);
                });
            });
        </script>
    @endpush
</x-admin-app-layout>
