<x-admin-app-layout :title="'Permission Add'">

    <div class="card card-flash">


        <div class="card-body scroll-y mx-5 mx-xl-15 my-7">

            <form class="form" action="{{ route('admin.permission.store') }}" method="POST">
                @csrf

                <div class="fv-row mb-7">
                    <x-admin.label for="goup-name"
                        class="col-form-label fw-bold fs-6">{{ __('Group Name') }}
                    </x-admin.label>

                    <x-admin.input id="goup-name" type="text" name="group_name" :value="old('group_name')"
                        placeholder="Enter the permission Group name"></x-admin.input>
                </div>
                <div class="fv-row mb-7">
                    <x-admin.label for="permission-add-name"
                        class="col-form-label required fw-bold fs-6">{{ __('Permission Name') }} <i
                            class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                            data-bs-trigger="hover" data-bs-html="true"
                            data-bs-content="Permission name is required to be unique."></i>
                    </x-admin.label>

                    <x-admin.input id="permission-add-name" type="text" name="name" :value="old('name')"
                        placeholder="Enter the permission name" required></x-admin.input>
                </div>


                <div class="text-center pt-15">
                    <x-admin.button type="submit" class="primary">
                        {{ __('Submit') }}
                    </x-admin.button>
                </div>

            </form>

        </div>

    </div>
</x-admin-app-layout>
