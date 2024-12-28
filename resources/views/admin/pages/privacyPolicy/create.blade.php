<x-admin-app-layout :title="'Privacy Policy Add'">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-5">
                    <div class="card-header p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="text-gray-800">Privacy & Policy Page</h4>
                            <a href="{{ route('admin.privacy-policy.index') }}" class="btn-common-one text-white"
                                tabindex="0">
                                <i class="fa-solid fa-plus pe-3"></i>
                                Create
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <form class="form" action="{{ route('admin.privacy-policy.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.label for="title" class="form-label">Title</x-admin.label>
                                            <x-admin.input id="title" type="text" name="title"
                                                :value="old('title')" placeholder="Enter the Title"
                                                required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="effective_date" class="form-label">Effective
                                                Date</x-admin.label>
                                            <x-admin.input type="date" name="effective_date"
                                                class="form-control @error('effective_date') is-invalid @enderror"
                                                placeholder="Effective Date"
                                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ old('effective_date') }}"></x-admin.input>

                                            @error('effective_date')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="expiration_date" class="form-label">Expiration
                                                Date</x-admin.label>
                                            <x-admin.input type="date" name="expiration_date"
                                                class="form-control @error('expiration_date') is-invalid @enderror"
                                                placeholder="Expiration Date"
                                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ old('expiration_date') }}"></x-admin.input>

                                            @error('expiration_date')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="version" class="form-label">Version
                                            </x-admin.label>
                                            <x-admin.input id="version" type="text" name="version"
                                                :value="old('version')" placeholder="Enter the version"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="status" class="form-label">Select a Status
                                            </x-admin.label>
                                            <x-admin.select-option id="status" name="status" data-hide-search="true"
                                                data-placeholder="Select an option">
                                                <option></option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <x-admin.label for="content" class="form-label">Terms & Conditon Content
                                        </x-admin.label>
                                        <textarea name="content" class="ckeditor w-100 @error('content') is-invalid @enderror">{!! old('content') !!}</textarea>
                                        <div class="text-muted fs-7">
                                            Add terms content here.
                                        </div>
                                        @error('content')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <x-admin.button type="submit">Save Privacy<i
                                            class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
