<x-admin-app-layout :title="'Product List'">
    {{-- <div class="row">
        <div class="col-xl-4 mx-auto">
            <div class="card card-flush shadow-sm">
                <div class="card-body p-0">
                    <div class="d-flex flex-stack justify-content-between">
                        <div class="d-flex align-items-center me-3 p-8 rounded-3 bg-dark">
                            <a href="javascript:void(0)">
                                <span class="bg-black rounded-3 p-3 me-3"><i
                                        class="fa-product text-white fa-product-hunt fs-3" aria-hidden="true"></i></span>
                            </a>
                            <div class="flex-grow-1">
                                <a href="#" class="text-white fs-5 fw-bold lh-0">Total Product
                                    <span class="text-white fw-semibold d-block fs-6 pt-4">{{ date('d-M-Y') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center pe-4">
                            <div>
                                <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">8,55</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card card-flush mt-10">
        <div class="card-header bg-dark align-items-center">
            <h3 class="card-title text-white">Product List</h3>
            <div>
                <a type="button" href="{{ route('admin.product.create') }}" class="btn btn-light-primary">
                    <i class="fa-solid fa-plus"></i> Create
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table my-datatable table-striped table-row-bordered gy-5 gs-7 border rounded">
                <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        {{-- <th width="10%">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_product_table .form-check-input" value="1" />
                            </div>
                        </th> --}}
                        <th width="5%">{{ __('Sl') }}</th>
                        <th width="10%">{{ __('Product Image') }}</th>
                        <th width="25%">{{ __('Product Name') }}</th>
                        <th width="15%" class="text-center">{{ __('Box Stock') }}</th>
                        <th width="15%" class="text-center">{{ __('Box Price') }}</th>
                        <th width="10%">{{ __('Product Status') }}</th>
                        <th width="10%" class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($products as $product) --}}
                    @foreach ($products as $product)
                        <tr>
                            {{-- <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td> --}}
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img class="w-50px h-50px" src="{{ asset('storage/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                    onerror="this.onerror=null; this.src='{{ asset('frontend/img/no-blogs.jpg') }}';">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td class="text-center">
                                @if ($product->box_stock > 0)
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="15"
                                            x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g>
                                                <path d="M448 330.07V112a8.011 8.011 0 0 0-4.42-7.16l-192-96a8.018 8.018 0 0 0-6.93-.1l-208
                                                    96A7.978 7.978 0 0 0 32 112v256a7.978 7.978 0 0 0 4.65 7.26l208 96a8 8 0 0 0 6.93-.1l51.92-25.97A95.99
                                                    95.99 0 1 0 448 330.07ZM331.38 66.63l-171.04 92.1-43.82-20.22L292.31 47.1ZM152
                                                    172.5v127.37l-40-17.15V154.04Zm95.86-147.62 26.77 13.38-174.32 90.64a8.133 8.133 0 0 0-1.81
                                                    1.29L59.09 112ZM240 451.5 48 362.88V124.5l48 22.16V288a8 8 0 0 0 4.85 7.35l56
                                                    24a7.866 7.866 0 0 0 3.15.65 8 8 0 0 0 8-8V179.89l72 33.23Zm7.86-252.38-69.35-32
                                                    170.37-91.74L422.11 112Zm50.64 230.69L256 451.06V212.94l176-88v195.8a96.021 96.021 0 0 0-133.5
                                                    109.07ZM392 488a80 80 0 1 1 80-80 80.093 80.093 0 0 1-80 80Z"
                                                    fill="#000000" opacity="1" data-original="#000000"
                                                    class="">
                                                </path>
                                                <path d="M426.343 386.343 384 428.687l-18.343-18.344a8 8 0 0 0-11.314 11.314l24 24a8 8 0 0 0
                                                    11.314 0l48-48a8 8 0 0 0-11.314-11.314Z" fill="#000000"
                                                    opacity="1" data-original="#000000" class="">
                                                </path>
                                            </g>
                                        </svg>
                                    </span>
                                    {{ $product->box_stock }}
                                @else
                                    <span title="No Box Stock">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40"
                                            x="0" y="0" viewBox="0 0 60 60" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g>
                                                <path
                                                    d="m42.878 43.706.828-.828 6.326-6.326a2.021 2.021 0 0 0 .566-1.724 1.96 1.96 0 0 0-1.029-1.456 12 12 0 0 0-16.2 16.2 1.958 1.958 0 0 0 1.457 1.028 2.024 2.024 0 0 0 1.724-.566l6.326-6.326ZM40 42v-7.169a9.793 9.793 0 0 1 2-.636v7.571l-.233.234Zm8.62-6.864L44 39.763v-5.741a9.849 9.849 0 0 1 4.62 1.114ZM38 35.995V42h-3.8a9.971 9.971 0 0 1 3.8-6.005Zm-2.86 12.643A9.918 9.918 0 0 1 34.022 44h5.748ZM20 12h4a3 3 0 0 0 0-6h-4a3 3 0 0 0 0 6Zm0-4h4a1 1 0 0 1 0 2h-4a1 1 0 0 1 0-2Z"
                                                    fill="#FF0000" opacity="1" data-original="#000000"
                                                    class=""></path>
                                                <path
                                                    d="M44 28V12.952a3 3 0 0 0-1.606-2.652L23.4.351a2.961 2.961 0 0 0-2.794 0L1.6 10.3A3 3 0 0 0 0 12.952V42a2 2 0 0 0 2 2h26a16 16 0 1 0 16-16ZM2 12.952a1 1 0 0 1 .534-.885l19.007-9.953a.978.978 0 0 1 .925 0l18.995 9.946a1.008 1.008 0 0 1 .539.888v15.191a15.741 15.741 0 0 0-2 .388V16a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v26H2ZM38 18H6v-2h32ZM6 20h32v2H6Zm7 11a1 1 0 0 0 1-1v-2h2v6h-6v-6h2v2a1 1 0 0 0 1 1Zm-3 5h2v2a1 1 0 0 0 2 0v-2h2v6h-6Zm8 6v-6h2v2a1 1 0 0 0 2 0v-2h2v6Zm8 0v-6a2 2 0 0 0-2-2h-6v-6a2 2 0 0 0-2-2h-6a2 2 0 0 0-2 2v14H6V24h32v5.178A16.026 16.026 0 0 0 28.139 42Zm18 16a14 14 0 1 1 14-14 14.015 14.015 0 0 1-14 14Z"
                                                    fill="#FF0000" opacity="1" data-original="#000000"
                                                    class=""></path>
                                                <path
                                                    d="M51.45 37.966 37.966 51.45a2.021 2.021 0 0 0-.566 1.724 1.96 1.96 0 0 0 1.029 1.456A11.921 11.921 0 0 0 44.008 56a12.444 12.444 0 0 0 1.3-.069 12 12 0 0 0 9.316-17.5 1.958 1.958 0 0 0-1.45-1.031 2.021 2.021 0 0 0-1.724.566Zm2.492 7.134a9.991 9.991 0 0 1-14.562 7.76l13.48-13.5a10.016 10.016 0 0 1 1.082 5.74Z"
                                                    fill="#FF0000" opacity="1" data-original="#000000"
                                                    class=""></path>
                                            </g>
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">£{{ $product->box_price }}</td>
                            <td>
                                <span class="badge {{ $product->status == 'published' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status == 'published' ? 'Published' : 'Unpublished' }}</span>
                            </td>
                            <td class="text-center">
                                {{-- <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                    data-bs-toggle="modal" data-bs-target="#faqViewModal_{{ $faq->id }}">
                                    <i class="fa-solid fa-expand"></i>
                                </a> --}}
                                <a href="{{ route('admin.product.edit', $product->id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.product.destroy', $product->id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 delete"
                                    data-kt-docs-table-filter="delete_row">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
                if (submitButton) {
                    submitButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        // Simulate form submission
                        setTimeout(function() {
                            submitButton.removeAttribute('data-kt-indicator');
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
                        }, 2000);
                    });
                }
            });
        </script>
    @endpush
</x-admin-app-layout>
