
<x-admin-app-layout :title="'Brand Edit'">
    <div class="card card-flash">
        <!--begin::Card header-->
        <div class="card-header mt-6">
            <div class="card-title"></div>

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('admin.brands.index') }}" class="btn btn-light-info">
                    <!--begin::Svg Icon | path: brands/duotune/general/gen035.svg-->
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
                    <!--end::Svg Icon-->Back to the list
                </a>
            </div>
        </div>
        <div class="card-body pt-0">
            <!--begin::Form-->
            <form class="form" action="{{ route('admin.brands.update', $brand->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="name"
                            class="col-form-label fw-bold fs-6 required">{{ __('Name') }}
                        </x-admin.label>

                        <x-admin.input id="name" type="text" name="name" :value="old('name', $brand->name)"
                            placeholder="Enter the Name" required></x-admin.input>
                    </div>

                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="url"
                            class="col-form-label fw-bold fs-6 required">{{ __('Url') }}
                        </x-admin.label>

                        <x-admin.input id="url" type="url" name="url" :value="old('url', $brand->url)"
                            placeholder="Enter the Url"></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="logo" class="col-form-label fw-bold fs-6 ">{{ __('Logo') }}
                        </x-admin.label>

                        <x-admin.file-input id="logo" name="logo" :source="asset('storage/'.$brand->logo)" :value="old('logo', $brand->logo)"></x-admin.file-input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="image"
                            class="col-form-label fw-bold fs-6 required">{{ __('Thumbnail Image') }}
                        </x-admin.label>

                        <x-admin.file-input id="image" name="image" :source="asset('storage/'.$brand->image)" :value="old('image', $brand->image)"></x-admin.file-input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="banner_image"
                            class="col-form-label fw-bold fs-6 ">{{ __('Banner Image') }}
                        </x-admin.label>

                        <x-admin.file-input id="banner_image" :source="asset('storage/'.$brand->banner_image)" :value="old('banner_image', $brand->banner_image)" name="banner_image"></x-admin.file-input>
                    </div>
                    <div class="col-lg-8 mb-7">
                        <x-admin.label for="description"
                            class="col-form-label fw-bold fs-6 ">{{ __('Description') }}
                        </x-admin.label>

                        <x-admin.textarea id="description" name="description">{{ old('description', $brand->description) }}</x-admin.textarea>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="status" class="col-form-label required fw-bold fs-6">
                            {{ __('Select a Status ') }}</x-admin.label>
                        <x-admin.select-option id="status" name="status" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="active" @selected($brand->status == 'active')>Active</option>
                            <option value="inactive" @selected($brand->status == 'inactive')>Inactive</option>
                        </x-admin.select-option>
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
    </div>
</x-admin-app-layout>
