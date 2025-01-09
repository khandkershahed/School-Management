<x-admin-app-layout :title="'Role Add'">
<div class="app-content">
        <div class="container-fluid mt-3">
    <div class="card card-flush">
        <div class="card-header">
            <div class="card-title"></div>
            <div class="card-toolbar">

                <a href="{{ route('admin.role.index') }}" class="btn btn-light-info">

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

                    Back to the list
                </a>
            </div>
        </div>
        <form class="form" action="{{ route('admin.role.store') }}" method="POST">
            @csrf
            <div class="card-body d-flex flex-column scroll-y me-n7 pe-7">
                <div class="row fv-row mb-10">
                    <div class="col-lg-8 offset-lg-2">
                        <x-admin.label for="role-name"
                            class="col-form-label required fw-bold fs-6">{{ __('Role Name') }}</x-admin.label>
                        <x-admin.input id="role-name" type="text" class="form-control form-control-solid"
                            name="name" :value="old('name')" placeholder="Enter the Role name"></x-admin.input>
                    </div>
                </div>
                <div class="row fv-row">
                    <label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <tbody class="text-gray-600 fw-bold">
                                <tr>
                                    <td class="text-gray-800">Administrator Access
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Allows a full access to the system"></i>
                                    </td>
                                    <td>

                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                            <input class="form-check-input metronic_select_all" type="checkbox"
                                                value="" id="kt_roles_select_all" />
                                            <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                        </label>

                                    </td>
                                </tr>
                                @foreach ($permissionsByGroups as $group)
                                    <tr>
                                        <td class="text-gray-800">
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox"
                                                    value="" id="kt_roles_select_row" />
                                                <span class="form-check-label" for="kt_roles_select_row">{{ $group->group_name }}</span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @foreach ($permissions->where('group_name', $group->group_name) as $permission)
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $permission->name }}" name="permissions[]" />
                                                        <span class="form-check-label">{{ $permission->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end p-4 px-lg-12 py-lg-5">
                <x-admin.button type="submit" class="primary">
                    {{ __('Submit') }}
                </x-admin.button>
            </div>

        </form>

    </div>
     </div>
    </div>
</x-admin-app-layout>
