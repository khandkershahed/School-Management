<x-admin-app-layout :title="'Catalogue'">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-dark align-items-center d-flex justify-content-between">
                    <div>
                        <h1 class="mb-0 text-center w-100 text-white">Manage Your Catalogue</h1>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="btn btn-white rounded-2" data-bs-toggle="modal"
                            data-bs-target="#catalogueAddModal">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                        fill="currentColor" />
                                    <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                        transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                    <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            Add Catalogue
                        </a>
                    </div>
                </div>
                <div class="card-body py-0">
                    <table class="table my-datatable table-striped table-row-bordered gy-5 gs-7">
                        <thead class="bg-light-danger">
                            <tr class="fw-semibold fs-6 text-gray-800">
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Attachment</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catalogues as $catalogue)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $catalogue->title }}</td>
                                    <td>
                                        <div>
                                            <img width="100px" class="img-fluid"
                                                src="{{ asset('storage/'.$catalogue->image) }}" alt="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ asset('storage/'.$catalogue->attachment) }}" download="">Download</a>
                                        </div>
                                    </td>
                                    <td>{{ $catalogue->url }}</td>
                                    <td>
                                        <span class="badge {{ $catalogue->status == 'active' ? 'bg-primary' : 'bg-danger' }}">
                                            {{ ucfirst($catalogue->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#catalogueEditModal{{ $catalogue->id }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#catalogueEditModal{{ $catalogue->id }}">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Catalogue Modal --}}
    <div class="modal fade" id="catalogueAddModal" tabindex="-1" aria-labelledby="catalogueAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="catalogueAddLabel">Create Catalogue</h5>
                    <button class="btn btn-white btn-sm ps-4 pe-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.catalogue.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 mb-7">
                                <x-admin.label for="product_id"
                                    class="col-form-label required fw-bold fs-6">{{ __('Select Product') }}</x-admin.label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Select an option"
                                    data-allow-clear="true" multiple="multiple" id="product_id" name="product_id[]"
                                    data-hide-search="false" data-placeholder="Select an option">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-7">
                                <x-admin.label for="category_id"
                                    class="col-form-label required fw-bold fs-6">{{ __('Select Category') }}</x-admin.label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Select an option"
                                    data-allow-clear="true" multiple="multiple" id="category_id" name="category_id[]"
                                    data-hide-search="false" data-placeholder="Select an option">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-7">
                                <x-admin.label for="brand_id"
                                    class="col-form-label required fw-bold fs-6">{{ __('Select Brand') }}</x-admin.label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Select an option"
                                    data-allow-clear="true" multiple="multiple" id="brand_id" name="brand_id[]"
                                    data-hide-search="false" data-placeholder="Select an option">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-8 mb-7">
                                <x-admin.label for="title"
                                    class="col-form-label required fw-bold fs-6">{{ __('Title') }}</x-admin.label>
                                <x-admin.input id="title" type="text" name="title"
                                    placeholder="Enter the title" :value="old('title')"></x-admin.input>
                            </div>
                            <div class="col-lg-4 mb-7">
                                <x-admin.label for="status"
                                    class="col-form-label fw-bold fs-6">{{ __('Status') }}</x-admin.label>
                                <select class="form-select" name="status" data-control="select2"
                                    data-placeholder="Select an option">
                                    <option></option>
                                    <option value="active">active</option>
                                    <option value="inactive">inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-7">
                                <x-admin.label for="image"
                                    class="col-form-label fw-bold fs-6">{{ __('Image') }}</x-admin.label>
                                <x-admin.file-input id="image" name="image"
                                    :value="old('image')"></x-admin.file-input>
                            </div>
                            <div class="col-lg-4 mb-7">
                                <x-admin.label for="attachment"
                                    class="col-form-label fw-bold fs-6">{{ __('Attachment (PDF)') }}</x-admin.label>
                                    <input class="form-control" type="file" name="attachment" id="attachment" value="{{ old('attachment') }}">
                                {{-- <x-admin.file-input id="attachment" name="attachment"
                                    :value="old('attachment')"></x-admin.file-input> --}}
                            </div>
                            <div class="col-lg-4 mb-7">
                                <x-admin.label for="url"
                                    class="col-form-label fw-bold fs-6">{{ __('URL') }}</x-admin.label>
                                <x-admin.input id="url" type="url" name="url"
                                    placeholder="Enter the URL" :value="old('url')"></x-admin.input>
                            </div>
                            <div class="col-xl-12">
                                <div class="text-end">
                                    <x-admin.button type="submit" class="dark">
                                        {{ __('Submit') }}
                                    </x-admin.button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Catalogue Modals --}}
    @foreach ($catalogues as $catalogue)
        <div class="modal fade" id="catalogueEditModal{{ $catalogue->id }}" tabindex="-1" aria-labelledby="catalogueEditLabel{{ $catalogue->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white" id="catalogueEditLabel{{ $catalogue->id }}">Edit Catalogue</h5>
                        <button class="btn btn-white btn-sm ps-4 pe-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.catalogue.update', $catalogue->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="product_id{{ $catalogue->id }}"
                                        class="col-form-label required fw-bold fs-6">{{ __('Select Product') }}</x-admin.label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-close-on-select="false" data-placeholder="Select an option"
                                        data-allow-clear="true" multiple="multiple" id="product_id{{ $catalogue->id }}" name="product_id[]"
                                        data-hide-search="false" data-placeholder="Select an option">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ in_array($product->id, json_decode($catalogue->product_id)) ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="category_id{{ $catalogue->id }}"
                                        class="col-form-label required fw-bold fs-6">{{ __('Select Category') }}</x-admin.label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-close-on-select="false" data-placeholder="Select an option"
                                        data-allow-clear="true" multiple="multiple" id="category_id{{ $catalogue->id }}" name="category_id[]"
                                        data-hide-search="false" data-placeholder="Select an option">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, json_decode($catalogue->category_id)) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="brand_id{{ $catalogue->id }}"
                                        class="col-form-label required fw-bold fs-6">{{ __('Select Brand') }}</x-admin.label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-close-on-select="false" data-placeholder="Select an option"
                                        data-allow-clear="true" multiple="multiple" id="brand_id{{ $catalogue->id }}" name="brand_id[]"
                                        data-hide-search="false" data-placeholder="Select an option">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ in_array($brand->id, json_decode($catalogue->brand_id)) ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-8 mb-7">
                                    <x-admin.label for="title{{ $catalogue->id }}"
                                        class="col-form-label required fw-bold fs-6">{{ __('Title') }}</x-admin.label>
                                    <x-admin.input id="title{{ $catalogue->id }}" type="text" name="title"
                                        placeholder="Enter the title" :value="$catalogue->title"></x-admin.input>
                                </div>
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="status{{ $catalogue->id }}"
                                        class="col-form-label fw-bold fs-6">{{ __('Status') }}</x-admin.label>
                                    <select class="form-select" name="status" data-control="select2"
                                        data-placeholder="Select an option">
                                        <option value="active" {{ $catalogue->status == 'active' ? 'selected' : '' }}>active</option>
                                        <option value="inactive" {{ $catalogue->status == 'inactive' ? 'selected' : '' }}>inactive</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="image{{ $catalogue->id }}"
                                        class="col-form-label fw-bold fs-6">{{ __('Image') }}</x-admin.label>
                                    <x-admin.file-input id="image{{ $catalogue->id }}" name="image"
                                        :value="$catalogue->image"></x-admin.file-input>
                                </div>
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="attachment{{ $catalogue->id }}"
                                        class="col-form-label fw-bold fs-6">{{ __('Attachment (PDF)') }}</x-admin.label>
                                        <input class="form-control" type="file" name="attachment" id="attachment" value="{{ old('attachment',$catalogue->attachment) }}">
                                    {{-- <x-admin.file-input id="attachment{{ $catalogue->id }}" name="attachment"
                                        :value="$catalogue->attachment"></x-admin.file-input> --}}
                                </div>
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="url{{ $catalogue->id }}"
                                        class="col-form-label fw-bold fs-6">{{ __('URL') }}</x-admin.label>
                                    <x-admin.input id="url{{ $catalogue->id }}" type="url" name="url"
                                        placeholder="Enter the URL" :value="$catalogue->url"></x-admin.input>
                                </div>
                                <div class="col-xl-12">
                                    <div class="text-end">
                                        <x-admin.button type="submit" class="dark">
                                            {{ __('Update') }}
                                        </x-admin.button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</x-admin-app-layout>
