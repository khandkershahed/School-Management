<x-admin-app-layout :title="'Banner'">
    <div class="card shadow-sm">
        <!--begin::Form-->
        <form class="form" action="{{ route('admin.banner.updateOrCreate') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-title">Banner</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light">
                        Action
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Alerts-->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <!--end::Alerts-->
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="image" class="col-form-label fw-bold fs-6 ">{{ __('Brand Logo') }}
                        </x-admin.label>

                        <x-admin.input id="image" type="file" name="image"
                            :value="old('image', optional($banner->first())->image)"></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="badge" class="col-form-label fw-bold fs-6 ">{{ __('Badge') }}
                        </x-admin.label>

                        <x-admin.input id="badge" type="text" name="badge" placeholder="Enter the Badge"
                            :value="old('badge', optional($banner->first())->badge)"></x-admin.input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="title" class="col-form-label fw-bold fs-6 ">{{ __('Title') }}
                        </x-admin.label>

                        <x-admin.input id="title" type="text" name="title" placeholder="Enter the Title"
                            :value="old('title', optional($banner->first())->title)"></x-admin.input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="quote" class="col-form-label fw-bold fs-6 ">{{ __('Quote') }}
                        </x-admin.label>

                        <x-admin.input id="quote" type="text" name="quote" placeholder="Enter the Quote"
                            :value="old('quote', optional($banner->first())->quote)"></x-admin.input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="button_name" class="col-form-label fw-bold fs-6 ">{{ __('Button Name') }}
                        </x-admin.label>

                        <x-admin.input id="button_name" type="text" name="button_name"
                            placeholder="Enter the Button Name" :value="old('button_name', optional($banner->first())->button_name)"></x-admin.input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="button_link" class="col-form-label fw-bold fs-6 ">{{ __('Button Link') }}
                        </x-admin.label>

                        <x-admin.input id="button_link" type="url" name="button_link"
                            placeholder="Enter the Button Link" :value="old('button_link', optional($banner->first())->button_link)"></x-admin.input>
                    </div>
                </div>
                <!--end::Form-->
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <x-admin.button type="submit" class="primary">
                        {{ __('Submit') }}
                    </x-admin.button>
                </div>
                <!--end::Actions-->
            </div>
        </form>
    </div>
</x-admin-app-layout>