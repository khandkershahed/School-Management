<x-admin-app-layout :title="'Page Banner Create'">
    <div class="card card-flash">

        <div class="card-header mt-6 bg-dark">
            <div class="card-title">
                <h1 class="text-white">Banner Create</h1>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.banner.index') }}" class="btn btn-light-info rounded-2">

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

            <form class="form" action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row my-10">
                    <div class="col-lg-4">
                        <x-admin.label for="name"
                            class="col-form-label fw-bold fs-6 required">{{ __('Page Name') }}
                        </x-admin.label>
                        <x-admin.select-option id="page_name" name="page_name" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="home_slider">Home Page Slider</option>
                            <option value="home_slider_bottom_first">Home Page Slider Bottom First</option>
                            <option value="home_slider_bottom_second">Home Page Slider Bottom Second</option>
                            <option value="home_slider_bottom_third">Home Page Slider Bottom Third</option>
                            <option value="user">User Panel</option>
                            <option value="cart">Cart Page</option>
                            <option value="checkout">Checkout Page</option>
                            <option value="faq">FAQ</option>
                            <option value="terms">Terms & Condition</option>
                            <option value="privacy">Privacy Policy</option>
                        </x-admin.select-option>
                    </div>
                    {{-- <div class="col-lg-4">
                        <x-admin.label for="image" class="col-form-label fw-bold fs-6 required">{{ __('Image') }}
                        </x-admin.label>
                        <x-admin.file-input id="image" type="file" name="image"></x-admin.file-input>
                    </div> --}}
                    <div class="col-lg-4">
                        <x-admin.label for="bg_image" class="col-form-label fw-bold fs-6 required">{{ __('Background Image') }}
                        </x-admin.label>
                        <x-admin.file-input id="bg_image" type="file" name="bg_image"></x-admin.file-input>
                    </div>
                    <div class="col-lg-4">
                        <x-admin.label for="title" class="col-form-label fw-bold fs-6 ">{{ __('Title') }}
                        </x-admin.label>

                        <x-admin.input id="title" type="text" name="title" placeholder="Enter the Title"
                            :value="old('title')"></x-admin.input>
                    </div>
                    <div class="col-lg-4">
                        <x-admin.label for="subtitle" class="col-form-label fw-bold fs-6 ">{{ __('Subtitle') }}
                        </x-admin.label>

                        <x-admin.input id="subtitle" type="text" name="subtitle" placeholder="Enter the Subtitle"
                            :value="old('subtitle')"></x-admin.input>
                    </div>
                    <div class="col-lg-4">
                        <x-admin.label for="banner_link" class="col-form-label fw-bold fs-6 ">{{ __('Banner Link') }}
                        </x-admin.label>

                        <x-admin.input id="banner_link" type="text" name="banner_link" placeholder="Enter the Banner_Link"
                            :value="old('banner_link')"></x-admin.input>
                    </div>
                    <div class="col-lg-3">
                        <x-admin.label for="badge" class="col-form-label fw-bold fs-6 ">{{ __('Badge') }}
                        </x-admin.label>

                        <x-admin.input id="badge" type="text" name="badge" placeholder="Enter the Badge"
                            :value="old('badge')"></x-admin.input>
                    </div>
                    <div class="col-lg-3">
                        <x-admin.label for="button_name" class="col-form-label fw-bold fs-6 ">{{ __('Button Name') }}
                        </x-admin.label>

                        <x-admin.input id="button_name" type="text" name="button_name"
                            placeholder="Enter the Button Name" :value="old('button_name')"></x-admin.input>
                    </div>
                    <div class="col-lg-3">
                        <x-admin.label for="button_link" class="col-form-label fw-bold fs-6 ">{{ __('Button Link') }}
                        </x-admin.label>

                        <x-admin.input id="button_link" type="url" name="button_link"
                            placeholder="Enter the Button Link" :value="old('button_link')"></x-admin.input>
                    </div>
                    <div class="col-lg-3">
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
                <div class="text-end pt-15">
                    <x-admin.button type="submit" class="primary">
                      {{ __('Submit') }} <i class="fa-solid fa-check ps-3"></i>
                    </x-admin.button>
                </div>

            </form>

        </div>
    </div>
</x-admin-app-layout>
