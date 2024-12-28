<x-admin-app-layout :title="'Experience List'">
    <div class="card card-flash">
        <!--begin::Card header-->
        <div class="card-header mt-6">
            <div class="card-title">
            </div>

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('admin.experiences.create') }}" class="btn btn-light-primary rounded-2">
                    <!--begin::Svg Icon | path: experiences/duotune/general/gen035.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                fill="currentColor" />
                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->Add Experience
                </a>
            </div>
        </div>
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="experiencesDT table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th>Sl</th>
                        <th>Starting Year</th>
                        <th>End Year</th>
                        <th>Role</th>
                        <th>Organization</th>
                        <th>Action</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-bold text-gray-600">

                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('.experiencesDT').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.experiences.index') }}",
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Display serial number starting from 1
                            },
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'starting_year',
                            name: 'starting_year'
                        },
                        {
                            data: 'end_year',
                            name: 'end_year'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'organization',
                            name: 'organization'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });
            });
        </script>
    @endpush
</x-admin-app-layout>
