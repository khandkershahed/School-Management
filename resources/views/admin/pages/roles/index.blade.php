<x-admin-app-layout :title="'Roles List'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">

                @foreach ($roles as $role)
                    <div class="col-md-4">
                        <div class="card card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ $role->name }}</h2>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="fw-bolder text-gray-600 mb-5">Total users with this role:
                                    {{ count($role->users) }}
                                </div>
                                <div class="d-flex flex-column text-gray-600 overflow-scroll scrollbar-hidden-y" style="height: 350px">
                                    <div class="row">
                                        @foreach ($role->permissions as $permission)
                                        <div class="col-6 d-flex align-items-center py-2">
                                            <span class="bullet bg-primary me-3"></span>{{ $permission->name }}
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer flex-wrap pt-0">
                               <a href="{{ route('admin.role.edit', $role->id) }}"
                                    class="btn btn-light btn-active-light-primary my-1">Edit Role</a>
                            </div>

                        </div>

                    </div>
                @endforeach




                <div class="col-md-4">
                    <div class="card h-md-100">
                        <div class="card-body d-flex flex-center justify-content-center">
                            <a href="{{ route('admin.role.create') }}"
                                class="btn btn-primary">Add New Role
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-admin-app-layout>
