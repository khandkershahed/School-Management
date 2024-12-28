<x-admin-app-layout :title="'Product Edit'">
    <style>
        .image-input-empty {
            background-image: url({{ asset('admin/assets/media/svg/files/blank-image.svg') }});
        }

        /* Custom Multi file upload */
        .img-thumb {
            border: 2px solid none;
            border-radius: 3px;
            padding: 1px;
            cursor: pointer;
            width: 70px;
            height: 60px;
            border-radius: 0.475rem;
        }


        .img-thumb-wrapper {
            display: inline-block;
            margin: 1rem 1rem 0 0;
        }


        .remove {
            display: block;
            background: #cf054f;
            border: 1px solid none;
            color: white;
            text-align: center;
            cursor: pointer;
            font-size: 12px;
            padding: 2px 5px;
        }


        .remove:hover {
            background: white;
            color: black;
        }


        .dropzone-field {
            border: 1px dashed #009ef7;
            display: flex;
            flex-wrap: wrap;
            /* Allow multiple images in a row */
            align-items: center;
            border-radius: 4px;
            padding: 10px 5px;
            justify-content: center;
        }


        #files {
            display: none;
        }


        .custom-file-upload {
            border: 0px solid #ccc;
            padding: 6px 12px;
            cursor: pointer;
            background-color: transparent;
        }


        .custom-file-upload i {
            margin-right: 5px;
        }

        /* Custom Multi file upload */
    </style>
    <div id="kt_app_content_container" class="app-container container-xxl">
        <form id="kt_ecommerce_add_product_form" method="post" action="{{ route('admin.product.update', $product->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="gap-7 gap-lg-10 mb-7  col-4">
                    {{-- Status Card Start --}}
                    <div class="card card-flush py-4 mb-6">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Status</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <x-admin.select-option id="kt_ecommerce_add_product_status_select"
                                class="form-select mb-2" data-control="select2" data-hide-search="true" name="status"
                                data-placeholder="Select an option">
                                <option></option>
                                <option value="published" @selected($product->status == 'published')>Published</option>
                                <option value="draft" @selected($product->status == 'draft')>Draft</option>
                                <option value="inactive" @selected($product->status == 'inactive')>Inactive</option>
                            </x-admin.select-option>
                            <div class="text-muted fs-7">Set the product status.</div>
                        </div>
                    </div>
                    {{-- Status Card End --}}
                    {{-- Category Card Start --}}
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Category</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="fv-row">
                                <x-admin.label for="brand_id" class="col-form-label required fw-bold fs-6">
                                    {{ __('Select Brand') }}</x-admin.label>
                                <x-admin.select-option id="brand_id" class="form-select mb-2" name="brand_id"
                                    data-control="select2" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected($brand->id == $product->brand_id)>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </x-admin.select-option>
                            </div>
                            <div class="fv-row">
                                <x-admin.label for="category_id" class="col-form-label required fw-bold fs-6">
                                    {{ __('Select Category') }}</x-admin.label>
                                <x-admin.select-option id="category_id" class="form-control select mb-2"
                                    name="category_id[]" multiple multiselect-search="true"
                                    multiselect-select-all="true" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true">
                                    @php
                                        $categoryIds = is_string($product->category_id)
                                            ? json_decode($product->category_id, true) // Convert JSON string to array
                                            : $product->category_id;
                                    @endphp

                                    @if (count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ in_array($category->id, $categoryIds) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif

                                </x-admin.select-option>
                            </div>
                            <div class="fv-row">
                                <x-admin.label for="color" class="col-form-label required fw-bold fs-6">
                                    {{ __('Add Color') }}
                                </x-admin.label>
                                <!-- Input element for Tagify -->
                                <input class="form-control d-flex align-items-center" name="color"
                                    :value="old('color', $product - > color)" id="kt_tagify_color" />
                            </div>
                        </div>
                    </div>
                    {{-- Category Card End --}}
                </div>
                <div class="gap-7 gap-lg-10 col-8">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_general">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_media">Media</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_advanced">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_package">Package</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_price">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_meta">Meta Options</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                {{-- General Info --}}
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>General</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="mb-5 fv-row">
                                            <x-admin.label class="form-label">Product Name</x-admin.label>
                                            <x-admin.input type="text" name="name" class="form-control mb-2"
                                                placeholder="Product name recommended" :value="old('name', $product->name)">
                                            </x-admin.input>
                                            <div class="text-muted fs-7">
                                                A product name is and recommended to be unique.
                                            </div>
                                        </div>
                                        <div class="mb-5 fv-row">
                                            <x-admin.label class="form-label">Tags</x-admin.label>
                                            <input class="form-control" name="tags" id="product_Tags"
                                                value="{{ old('tags', $product->tags) }}" />
                                        </div>
                                        <div class="mb-5 fv-row">
                                            <x-admin.label class="form-label">Short Description</x-admin.label>
                                            <x-admin.textarea id="short_description" name="short_description"
                                                placeholder="Add Product Short Description" class="form-control mb-2"
                                                cols="30"
                                                rows="3">{!! old('short_description', $product->short_description) !!}</x-admin.textarea>
                                        </div>
                                        <div class="mb-5 fv-row">
                                            <x-admin.label class="form-label">Product Overview</x-admin.label>
                                            <textarea name="overview" class="ckeditor">{!! old('overview', $product->overview) !!}</textarea>
                                            <div class="text-muted fs-7">
                                                Add product overview here.
                                            </div>
                                        </div>
                                        <div class="mb-5 fv-row">
                                            <x-admin.label class="form-label">Product Description</x-admin.label>
                                            <textarea name="description" class="ckeditor">{!! old('description', $product->description) !!}</textarea>
                                            <div class="text-muted fs-7">
                                                Add product description here.
                                            </div>
                                        </div>
                                        <div class="mb-5 fv-row">
                                            <x-admin.label class="form-label">Product
                                                Specification</x-admin.label>
                                            <textarea name="specification" class="ckeditor">{!! old('specification', $product->specification) !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_media" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                {{-- Inventory --}}
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Media</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label class="form-label">Thumbnail Image</label>
                                                <div class="image-input image-input-empty" data-kt-image-input="true"
                                                    style="background-image: url({{ asset('storage/' . $product->thumbnail) }}); width: auto; background-size: contain;
                                                    background-position: center;
                                                    border: 1px solid #009ae5;">
                                                    <div class="image-input-wrapper w-100px h-70px"
                                                        style="background-size: contain; background-position: center">
                                                    </div>

                                                    <label
                                                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        data-bs-dismiss="click" title="Change avatar">
                                                        <i class="bi bi-pencil-fill fs-7"></i>

                                                        <input type="file" name="thumbnail"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="avatar_remove" />
                                                    </label>

                                                    <span
                                                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        data-bs-dismiss="click" title="Cancel avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>

                                                    <span
                                                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        data-bs-dismiss="click" title="Remove avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>
                                                </div>
                                                <div class="invalid-feedback"> Please Enter Thumbnail Image. </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <label class="form-label">Multi Image</label>
                                                <div class="dropzone-field">
                                                    <label for="files" class="custom-file-upload">
                                                        <div class="d-flex align-items-center">
                                                            <p class="mb-0"><i
                                                                    class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            </p>
                                                            <h5 class="mb-0">Drop files here or click to upload.
                                                                <br>
                                                                <span class="text-muted"
                                                                    style="font-size: 10px">Upload 10 File</span>
                                                            </h5>
                                                        </div>
                                                    </label>
                                                    <input type="file" id="files" name="multi_img[]" multiple
                                                        class="form-control" style="display: none;" />
                                                </div>

                                                <!-- Display existing images -->
                                                <div class="existing-images">
                                                    @foreach ($product->multiImages as $image)
                                                        <div class="img-thumb-wrapper card shadow">
                                                            <img class="img-thumb"
                                                                src="{{ asset('storage/' . $image->photo) }}"
                                                                title="{{ $image->photo }}" />
                                                            <br />
                                                            <a href="{{ route('admin.multiimage.destroy', $image->id) }}"
                                                                class="remove delete">Remove</a>
                                                            {{-- <span class="remove">Remove</span> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                {{-- Inventory --}}
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Inventory</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 row">
                                        <div class="mb-10 fv-row col-6">
                                            <x-admin.label class="form-label">SKU Code</x-admin.label>
                                            <x-admin.input type="text" name="sku_code"
                                                class="form-control mb-2" placeholder="SKU Number"
                                                :value="old('sku_code', $product->sku_code)"></x-admin.file-input>
                                                <div class="text-muted fs-7">Enter the product SKU.</div>
                                        </div>
                                        <div class="mb-10 fv-row col-6">
                                            <x-admin.label class="form-label">MF Code</x-admin.label>
                                            <x-admin.input type="text" name="mf_code" class="form-control mb-2"
                                                placeholder="MF Number" :value="old('mf_code', $product->mf_code)"></x-admin.file-input>
                                                <div class="text-muted fs-7">Enter the product MF.</div>
                                        </div>

                                        <div class="mb-10 fv-row col-12">
                                            <x-admin.label class="form-label">Barcode</x-admin.label>
                                            <x-admin.input type="text" name="barcode_id"
                                                class="form-control mb-2" placeholder="Barcode Number"
                                                :value="old('barcode_id', $product->barcode_id)"></x-admin.file-input>
                                                <div class="text-muted fs-7">
                                                    Enter the product barcode number.
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_price" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                {{-- Pricing --}}
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Box Pricing</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 row">
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Box Contains</x-admin.label>
                                            <x-admin.input type="number" name="box_contains" id="box_contains"
                                                class="form-control mb-2" placeholder="how much in a box"
                                                :value="old('box_contains', $product->box_contains)"></x-admin.file-input>
                                                <div class="text-muted fs-7">How much product in a box.</div>
                                        </div>
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Box Price</x-admin.label>
                                            <x-admin.input type="number" name="box_price" id="box_price"
                                                class="form-control mb-2" placeholder="how much the box price"
                                                :value="old('box_price', $product->box_price)"></x-admin.file-input>
                                                <div class="text-muted fs-7">How much box price.</div>
                                        </div>
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Box Discount Price</x-admin.label>
                                            <x-admin.input type="number" name="box_discount_price"
                                                id="box_discount_price" class="form-control mb-2"
                                                placeholder="how much the box discount price"
                                                :value="old('box_discount_price', $product->box_discount_price)"></x-admin.file-input>
                                                <div class="text-muted fs-7">How much box discount price.</div>
                                        </div>
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Unit Price</x-admin.label>
                                            <x-admin.input type="number" name="unit_price" id="unit_price"
                                                class="form-control mb-2" placeholder="how much the unit price"
                                                :value="old('unit_price', $product->unit_price)" readonly></x-admin.file-input>
                                                <div class="text-muted fs-7">How much unit price.</div>
                                        </div>
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Unit Discount</x-admin.label>
                                            <x-admin.input type="number" name="unit_discount_price"
                                                id="unit_discount" class="form-control mb-2"
                                                placeholder="how much the unit discount price" :value="old('unit_discount_price', $product->unit_discount_price)"
                                                readonly></x-admin.file-input>
                                                <div class="text-muted fs-7">How much unit discount price.</div>
                                        </div>
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Box Stock</x-admin.label>
                                            <x-admin.input type="number" name="box_stock" id="box_stock"
                                                class="form-control mb-2" placeholder="how much the box stock"
                                                :value="old('box_stock', $product->box_stock)"></x-admin.file-input>
                                                <div class="text-muted fs-7">How much box stock. Eg: 50</div>
                                        </div>
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Vat</x-admin.label>
                                            <x-admin.input type="number" name="vat" id="vat"
                                                class="form-control mb-2" placeholder="how much the vat"
                                                :value="old('vat',$product->vat)"></x-admin.file-input>
                                                <div class="text-muted fs-7">How much box vat. Eg: 5%</div>
                                        </div>
                                        <div class="mb-5 fv-row col-4">
                                            <x-admin.label class="form-label">Tax</x-admin.label>
                                            <x-admin.input type="number" name="tax" id="tax"
                                                class="form-control mb-2" placeholder="how much the tax "
                                                :value="old('tax',$product->tax)"></x-admin.file-input>
                                                <div class="text-muted fs-7">How much tax Eg: 5%</div>
                                        </div>
                                        <div class="fv-row col-4 mt-10">
                                            <div class="form-check">
                                                <input class="form-check-input" name="is_refurbished" type="checkbox"
                                                    value="1" id="is_refurbished" @checked($product->is_refurbished == '1') />
                                                <x-admin.label class="form-check-label" for="is_refurbished">
                                                    Is Refurbished
                                                </x-admin.label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_package" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                {{-- Shipping Card Start --}}
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Package Details</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="fv-row row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <x-admin.label class="form-label">Weight
                                                            (gm)</x-admin.label>
                                                        <x-admin.input type="number" name="weight"
                                                            id="weight" class="form-control mb-2"
                                                            placeholder="1.5" :value="old('weight', $product->weight)"></x-admin.input>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <x-admin.label class="form-label">Length
                                                            (cm)</x-admin.label>
                                                        <x-admin.input type="number" name="length"
                                                            id="length" class="form-control mb-2" placeholder="15"
                                                            :value="old('length', $product->length)"></x-admin.file-input>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <x-admin.label class="form-label">Width
                                                            (cm)</x-admin.label>
                                                        <x-admin.input type="number" name="width"
                                                            id="width" class="form-control mb-2" placeholder="10"
                                                            :value="old('width', $product->width)"></x-admin.file-input>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <x-admin.label class="form-label">Height
                                                            (cm)</x-admin.label>
                                                        <x-admin.input type="number" name="height"
                                                            id="height" class="form-control mb-2" placeholder="9"
                                                            :value="old('height', $product->height)"></x-admin.file-input>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <p id="dimensionPreview">Length(0") X Width(0") X Height(0")
                                                        </p> <!-- Dimension preview -->
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <img class="img-fluid w-100"
                                                        src="{{ asset('frontend/img/box_size.png') }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Shipping Card End --}}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_meta" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                {{-- Meta Options --}}
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Meta Options</h2>
                                        </div>
                                    </div>
                                    {{-- @dd($product->meta_title) --}}
                                    <div class="card-body pt-0">
                                        <div class="mb-10">
                                            <div class="mb-5 fv-row">
                                                <x-admin.label class="form-label">Product Meta
                                                    Title</x-admin.label>
                                                <x-admin.input class="form-control" type="text"
                                                    name="meta_title" placeholder="Meta Title"
                                                    :value="old('meta_title', $product->meta_title)"></x-admin.input>
                                            </div>
                                            <div class="text-muted fs-7">
                                                Add Product Meta Title.
                                            </div>
                                        </div>
                                        <div class="mb-10">
                                            <div class="mb-5 fv-row">
                                                <x-admin.label class="form-label">Meta
                                                    Description</x-admin.label>
                                                <textarea name="meta_description" class="ckeditor">{!! old('meta_description', $product->meta_description) !!}</textarea>
                                                <div class="text-muted fs-7">
                                                    Add Meta Meta details.
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="mb-5 fv-row">
                                                <x-admin.label class="form-label">Meta Tag
                                                    Keywords</x-admin.label>
                                                <input class="form-control" name="meta_keywords"
                                                    placeholder="Meta tag keywords" id="product_meta_keyword"
                                                    value="{{ old('meta_keywords', $product->meta_keywords) }}" />
                                                <div class="text-muted fs-7">
                                                    Add product Meta tag keywords.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-10">
                        <a href="{{ route('admin.product.index') }}" class="btn btn-danger me-5">
                            Back To Product List
                        </a>
                        {{-- <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-white">
                            <span class="indicator-label"> Save Changes </span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button> --}}
                        <button type="submit" class="btn btn-white">
                            <span class="indicator-label"> Save Changes </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // The DOM elements you wish to replace with Tagify
                var input1 = document.querySelector("#product_Tags");
                var input2 = document.querySelector("#product_meta_tags");
                var input3 = document.querySelector("#product_meta_keyword");

                // Initialize Tagify components on the above inputs
                new Tagify(input1);
                new Tagify(input2);
                new Tagify(input3);
            });



            // Product dimension box
            document.addEventListener('DOMContentLoaded', function() {
                const lengthInput = document.getElementById('length');
                const widthInput = document.getElementById('width');
                const heightInput = document.getElementById('height');

                const dimensionPreview = document.getElementById('dimensionPreview');

                function updatePreview() {
                    const length = lengthInput.value || 0;
                    const width = widthInput.value || 0;
                    const height = heightInput.value || 0;

                    dimensionPreview.textContent = `Length(${length}") X Width(${width}") X Height(${height}")`;
                }

                // Attach the event listener to each input field
                lengthInput.addEventListener('input', updatePreview);
                widthInput.addEventListener('input', updatePreview);
                heightInput.addEventListener('input', updatePreview);
            });
            // Define color mapping
            var colorMapping = {
                'Red': '#FF5733',
                'Green': '#33FF57',
                'Blue': '#3357FF',
                'Yellow': '#FFFF33',
                'Purple': '#A933FF',
                'Orange': '#FF8C33',
                'Pink': '#FF33B5',
                'Brown': '#8C4C33',
                'Gray': '#BEBEBE',
                'Black': '#000000',
                'White': '#FFFFFF',
                'Cyan': '#00FFFF',
                'Magenta': '#FF00FF',
                'Lime': '#00FF00',
                'Teal': '#008080',
                'Olive': '#808000',
                'Navy': '#000080',
                'Maroon': '#800000',
                'Silver': '#C0C0C0',
                'Gold': '#FFD700',
                'Coral': '#FF7F50',
                'Indigo': '#4B0082',
                'Turquoise': '#40E0D0',
                'Salmon': '#FA8072'
            };

            // Convert colorMapping to an array of objects for Tagify dropdown
            var colorArray = Object.keys(colorMapping).map(key => ({
                value: key,
                color: colorMapping[key]
            }));

            // Initialize Tagify on the input element
            var tagify = new Tagify(document.querySelector('#kt_tagify_color'), {
                delimiters: null,
                templates: {
                    tag: function(tagData) {
                        const color = colorMapping[tagData.value] || '#cccccc'; // Default color if not found
                        try {
                            return `<tag title='${tagData.value}' contenteditable='false' spellcheck="false"
                    class='tagify__tag ${tagData.class ? tagData.class : ""}' ${this.getAttributes(tagData)}
                    style="background-color: ${color}; border: none; display: flex; align-items: center; padding: 0;">
                        <x title='remove tag' class='tagify__tag__removeBtn'></x>
                        <div class="d-flex align-items-center" style="width: 25px; height: 25px; background-color: ${color}; border-radius: 4px; margin-right: 8px;"></div>
                        <span class='tagify__tag-text'>${tagData.value}</span>
                    </tag>`;
                        } catch (err) {
                            console.error('Error in tag template:', err);
                        }
                    },

                    dropdownItem: function(tagData) {
                        const color = colorMapping[tagData.value] || '#cccccc'; // Default color if not found
                        try {
                            return `<div ${this.getAttributes(tagData)} class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                    style="background-color: white; color: black; display: flex; align-items: center; padding: 4px 8px;">
                        <div style="width: 25px; height: 25px; background-color: ${color}; border-radius: 4px; margin-right: 8px;"></div>
                        <span>${tagData.value}</span>
                    </div>`;
                        } catch (err) {
                            console.error('Error in dropdown item template:', err);
                        }
                    }
                },
                // Remove whitelist to allow all colors to be shown in dropdown
                enforceWhitelist: false,
                // Display dropdown items based on the colorMapping array
                whitelist: colorArray,
                dropdown: {
                    enabled: 1, // Show the dropdown as the user types
                    classname: 'extra-properties' // Custom class for the suggestions dropdown
                }
            });

            // Show all color options when the input is clicked
            var inputElement = document.querySelector('#kt_tagify_color');

            inputElement.addEventListener('click', function() {
                tagify.dropdown.show.call(tagify);
            });

            // Add the first 2 tags and make them readonly
            // var tagsToAdd = tagify.settings.whitelist.slice(0, 2);
            // tagify.addTags(tagsToAdd);



            // Product Pricing
            function calculatePrices() {
                const boxContains = parseFloat(document.getElementById('box_contains').value) || 0;
                const boxPrice = parseFloat(document.getElementById('box_price').value) || 0;
                const boxDiscountPrice = parseFloat(document.getElementById('box_discount_price').value) || 0;

                const unitPrice = boxContains ? (boxPrice / boxContains).toFixed(2) : 0;
                const unitDiscount = boxContains ? (boxDiscountPrice / boxContains).toFixed(2) : 0;

                document.getElementById('unit_price').value = unitPrice;
                document.getElementById('unit_discount').value = unitDiscount;
            }

            document.getElementById('box_contains').addEventListener('input', calculatePrices);
            document.getElementById('box_price').addEventListener('input', calculatePrices);
            document.getElementById('box_discount_price').addEventListener('input', calculatePrices);

            // Product Multiimage Submit
            var uploadedDocumentMap = {}; // Assuming you have this variable defined somewhere

            var myDropzone = new Dropzone("#product_multiimage", {
                url: "{{ route('admin.product.store') }}",
                paramName: "multi_image", // The name that will be used to transfer the file
                uploadMultiple: true,
                parallelUploads: 10,
                maxFiles: 10,
                maxFilesize: 10, // MB
                addRemoveLinks: true,
                accept: function(file, done) {
                    console.log(file);
                    $('#kt_ecommerce_add_product_form').append(
                        '<input type="hidden" name="document[ value="{{ old('document') }}"]" value="' + file
                        .file + '">');
                    done();
                },
                method: "post",
            });

            document.getElementById('kt_ecommerce_add_product_form').addEventListener('submit', function(event) {
                var formData = new FormData(this);
                console.log(formData);
            });
            // textEditor
            class CKEditorInitializer {
                constructor(className) {
                    this.className = className;
                }

                initialize() {
                    const elements = document.querySelectorAll(this.className);
                    elements.forEach(element => {
                        ClassicEditor
                            .create(element)
                            .then(editor => {
                                console.log('CKEditor initialized:', editor);
                            })
                            .catch(error => {
                                console.error('CKEditor initialization error:', error);
                            });
                    });
                }
            }

            // Example usage:
            const ckEditorInitializer = new CKEditorInitializer('.ckeditor');
            ckEditorInitializer.initialize();
        </script>
    @endpush
</x-admin-app-layout>
