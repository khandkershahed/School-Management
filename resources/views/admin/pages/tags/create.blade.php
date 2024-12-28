<x-admin-app-layout :title="'Tags Add'">
    <div class="card card-flash">
        <!--begin::Modal body-->
        <div class="card-body scroll-y mx-5 mx-xl-15 my-7">
            <!--begin::Form-->
            <form class="form" action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="name" class="col-form-label fw-bold fs-6 required">{{ __('Name') }}
                        </x-admin.label>

                        <x-admin.input id="name" type="text" name="name" :value="old('name')"
                            placeholder="Enter the Name" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="status" class="col-form-label required fw-bold fs-6">
                            {{ __('Select a Status ') }}</x-admin.label>
                        <x-admin.select-option id="status" name="status" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-admin.select-option>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="description" class="col-form-label fw-bold fs-6">{{ __('Description') }}
                        </x-admin.label>

                        <x-admin.input id="description" type="text" name="description" :value="old('description')"
                            placeholder="Enter the Description"></x-admin.input>
                    </div>
                </div>
                <div class="text-center pt-15">
                    <x-admin.button type="submit" class="primary">
                        {{ __('Submit') }}
                    </x-admin.button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal body-->
    </div>
</x-admin-app-layout>
