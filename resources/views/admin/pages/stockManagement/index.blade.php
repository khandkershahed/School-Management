<x-admin-app-layout :title="'Stock Management'">
    <style>
        td {
            height: 50px;
            vertical-align: middle;
        }
    </style>
    <div class="card card-flush mt-10">
        <div class="card-header bg-dark align-items-center">
            <h3 class="card-title text-white">Product Stock Availability</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table my-datatable table-striped table-row-bordered gy-5 gs-7 border rounded">
                <thead>
                    <tr class="fw-bold fs-6 text-center text-gray-800 px-7">
                        <th width="5%">ID</th>
                        <th width="8%">Image</th>
                        <th width="43%">Product Name</th>
                        <th width="10%">QTY</th>
                        <th width="12%">Price</th>
                        <th width="12%">Created</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="symbol symbol-50px me-3">
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class=""
                                        alt="">
                                </div>
                            </td>
                            <td class="text-start">{{ $product->name }}</td>

                            <td class="text-center">
                                @if (!empty($product->box_stock) && $product->box_stock > 0)
                                    <span class="badge bg-success">
                                        {{ $product->box_stock }} In Stock</span>
                                @else
                                    <span class="badge bg-danger">Out Of
                                        Stock</span>
                                @endif
                            </td>
                            <td>
                                @if (!empty($product->box_discount_price))
                                    <div class="">
                                        <span class="ps-product__price sale">£{{ $product->box_discount_price }}</span>
                                        <span class="ps-product__del">£{{ $product->box_price }}</span>
                                    </div>
                                @else
                                    <div class="">
                                        <span class="ps-product__price sale">£{{ $product->box_price }}</span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#stockMethodsEdit-{{ $product->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <div class="modal fade" id="stockMethodsEdit-{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="stockMethodsEditLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="stockMethodsEditLabel">Stock
                                                    Methods
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form" method="POST"
                                                    action="{{ route('admin.stock.update', $product->id) }}"
                                                    autocomplete="off" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-lg-3 mb-7">
                                                            <div class="">
                                                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                                                    data-kt-image-input="true">
                                                                    <div class="image-input-wrapper w-100px h-100px">
                                                                        <img class="w-100px h-100px" src="{{ asset('storage/' . $product->thumbnail) }}"
                                                                            alt="">
                                                                    </div>
                                                                    <label
                                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                        data-kt-image-input-action="change"
                                                                        data-bs-toggle="tooltip" title="Change avatar">
                                                                        <i class="fa-solid fa-pencil fs-7">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                        <input type="file" name="thumbnail"
                                                                            accept=".png, .jpg, .jpeg" />
                                                                        <input type="hidden" name="thumbnail_remove" />
                                                                    </label>
                                                                </div>
                                                                <div class="text-muted fs-7">
                                                                    Set the product thumbnail image. Only *.png, *.jpg
                                                                    and
                                                                    *.jpeg image
                                                                    files are accepted
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 mb-7">
                                                            <x-admin.label class="form-label">Product
                                                                Name</x-admin.label>
                                                            <x-admin.input type="text" name="name"
                                                                class="form-control mb-2"
                                                                placeholder="Product name recommended"
                                                                :value="old('name', $product->name)">
                                                            </x-admin.input>
                                                        </div>
                                                        {{-- <div class="mb-7 col-4">
                                                            <x-admin.label class="form-label">Box
                                                                Contains</x-admin.label>
                                                            <x-admin.input type="number" name="box_contains"
                                                                id="box_contains" class="form-control mb-2 box_contains"
                                                                placeholder="how much in a box"
                                                                :value="old('box_contains', $product->box_contains)"></x-admin.file-input>
                                                                <div class="text-muted fs-7">How much product in a box.
                                                                </div>
                                                        </div> --}}
                                                        {{-- <div class="mb-7 col-4">
                                                            <x-admin.label class="form-label">Box
                                                                Price</x-admin.label>
                                                            <x-admin.input type="number" name="box_price"
                                                                id="box_price" class="form-control mb-2 box_price"
                                                                placeholder="how much the box price"
                                                                :value="old('box_price', $product->box_price)"></x-admin.file-input>
                                                                <div class="text-muted fs-7">How much box price.</div>
                                                        </div>
                                                        <div class="mb-7 col-4">
                                                            <x-admin.label class="form-label">Box Discount
                                                                Price</x-admin.label>
                                                            <x-admin.input type="number" name="box_discount_price"
                                                                id="box_discount_price" class="form-control mb-2 box_discount_price"
                                                                placeholder="how much the box discount price"
                                                                :value="old(
                                                                    'box_discount_price',
                                                                    $product->box_discount_price,
                                                                )"></x-admin.file-input>
                                                                <div class="text-muted fs-7">How much box discount
                                                                    price.</div>
                                                        </div>
                                                        <div class="mb-7 col-4">
                                                            <x-admin.label class="form-label">Unit
                                                                Price</x-admin.label>
                                                            <x-admin.input type="number" name="unit_price"
                                                                id="unit_price" class="form-control mb-2"
                                                                placeholder="how much the unit price" :value="old('unit_price', $product->unit_price)"
                                                                readonly></x-admin.file-input>
                                                                <div class="text-muted fs-7">How much unit price.</div>
                                                        </div>
                                                        <div class="mb-7 col-4">
                                                            <x-admin.label class="form-label">Unit
                                                                Discount</x-admin.label>
                                                            <x-admin.input type="number"
                                                                name="unit_discount_price" id="unit_discount"
                                                                class="form-control mb-2"
                                                                placeholder="how much the unit discount price"
                                                                :value="old('unit_discount_price',
                                                                    $product->unit_discount_price)" readonly></x-admin.file-input>
                                                                <div class="text-muted fs-7">How much unit discount
                                                                    price.</div>
                                                        </div> --}}
                                                        <div class="mb-7 mt-5 col-lg-6">
                                                            <x-admin.label class="form-label">Box
                                                                Stock</x-admin.label>
                                                            <x-admin.input type="number" name="box_stock"
                                                                id="box_stock" class="form-control mb-2"
                                                                placeholder="how much the box stock"
                                                                :value="old('box_stock', $product->box_stock)"></x-admin.file-input>
                                                                <div class="text-muted fs-7">How much box stock. Eg: 50
                                                                </div>
                                                        </div>
                                                    </div>

                                                    <button id="kt_docs_formvalidation_text_submit" type="submit"
                                                        class="btn btn-white">
                                                        <span class="indicator-label">
                                                            Update Stock
                                                        </span>
                                                        <span class="indicator-progress">
                                                            Please wait... <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            // Define form element
            const form = document.getElementById('kt_docs_formvalidation_text');

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'text_input': {
                            validators: {
                                notEmpty: {
                                    message: 'Text input is required'
                                }
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Submit button handler
            const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
            submitButton.addEventListener('click', function(e) {
                // Prevent default button action
                e.preventDefault();

                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {
                        console.log('validated!');

                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            setTimeout(function() {
                                // Remove loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;

                                // Show popup confirmation
                                Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });

                                //form.submit(); // Submit form
                            }, 2000);
                        }
                    });
                }
            });
        </script>
    @endpush
    @push('scripts')
        <script>
            function calculatePrices() {
                const boxContains = parseFloat(document.querySelector('box_contains').value) || 0;
                const boxPrice = parseFloat(document.querySelector('box_price').value) || 0;
                const boxDiscountPrice = parseFloat(document.querySelector('box_discount_price').value) || 0;

                const unitPrice = boxContains ? (boxPrice / boxContains).toFixed(2) : 0;
                const unitDiscount = boxContains ? (boxDiscountPrice / boxContains).toFixed(2) : 0;

                document.getElementById('unit_price').value = unitPrice;
                document.getElementById('unit_discount').value = unitDiscount;
            }

            document.getElementById('box_contains').addEventListener('input', calculatePrices);
            document.getElementById('box_price').addEventListener('input', calculatePrices);
            document.getElementById('box_discount_price').addEventListener('input', calculatePrices);
        </script>
    @endpush
</x-admin-app-layout>
