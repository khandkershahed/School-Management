<x-admin-app-layout :title="'Category Add'">
    <div class="card card-flash">
        <div class="card-header mt-6">
            <div class="card-title"></div>
            <div class="card-toolbar">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light-info">
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
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="parent_id"
                            class="col-form-label fw-bold fs-6">{{ __('Select a parent Category') }}</x-admin.label>
                        <x-admin.select-option id="parent_id" name="parent_id" data-hide-search="false"
                            data-placeholder="Select an option">
                            <option></option>
                            {!! $categoriesOptions !!}
                        </x-admin.select-option>
                    </div>

                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="name"
                            class="col-form-label required fw-bold fs-6">{{ __('Category Name') }}</x-admin.label>
                        <x-admin.input id="name" type="text" name="name" placeholder="Enter the name" :value="old('name')"></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="logo" class="col-form-label fw-bold fs-6 ">{{ __('Icon') }}
                        </x-admin.label>

                        <x-admin.file-input id="logo" name="logo" :value="old('logo')"></x-admin.file-input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="image"
                            class="col-form-label fw-bold fs-6">{{ __('Thumbnail Image') }}
                        </x-admin.label>

                        <x-admin.file-input id="image" name="image" :value="old('image')"></x-admin.file-input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="banner_image"
                            class="col-form-label fw-bold fs-6 ">{{ __('Banner Image') }}
                        </x-admin.label>

                        <x-admin.file-input id="banner_image" :value="old('banner_image')" name="banner_image"></x-admin.file-input>
                    </div>
                    <div class="col-lg-8 mb-7">
                        <x-admin.label for="description" class="col-form-label fw-bold fs-6 ">{{ __('Description') }}
                        </x-admin.label>

                        <x-admin.textarea id="description" name="description"></x-admin.textarea>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="status" class="col-form-label required fw-bold fs-6">
                            {{ __('Select a Status ') }}</x-admin.label>
                        <x-admin.select-option id="status" name="status" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </x-admin.select-option>
                    </div>
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