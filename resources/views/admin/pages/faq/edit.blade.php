<x-admin-app-layout :title="'FAQ Edit'">
    <div class="card card-flush">
        <div class="card-body p-1">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card border">
                        <div class="card-header align-items-center p-1 gap-2 gap-md-5">
                            <div class="container px-0">
                                <div class="row">
                                    <div class="col-lg-8 col-sm-12 text-lg-center text-sm-center">
                                        <div class="card-title table_title">
                                            <h2 class="text-center">FAQ Category Table</h2>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 text-lg-end text-sm-center">
                                        <button type="button" class="btn btn-sm btn-light-success rounded-0"
                                            data-kt-menu-placement="bottom-end" data-bs-toggle="modal"
                                            data-bs-target="#faqAddModal">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-striped table-hover align-middle rounded-0 table-row-bordered border fs-6 g-5"
                                    id="kt_datatable_example_1">
                                    <thead class="table_header_bg">
                                        <tr class="text-center text-gray-900 fw-bolder fs-7 text-uppercase">
                                            <th width="10%">Sl</th>
                                            <th width="45%">Name</th>
                                            <th width="20%">Status</th>
                                            <th width="25%">Action</th>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600 text-center">
                                        @if ($faq_categories)
                                            @foreach ($faq_categories as $faq_category)
                                                <tr class="odd">
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        {{ $faq_category->name }}
                                                    </td>
                                                    <td>
                                                        {{ ucfirst($faq_category->status) }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <a href="#"
                                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#faqEditModal_{{ $faq_category->id }}">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </a>
                                                            <a href="{{ route('admin.faq-category.destroy', $faq_category->id) }}"
                                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 delete"
                                                                data-kt-docs-table-filter="delete_row">
                                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card border">
                        <div class="card-header justify-content-center align-items-center">
                                <h2 class="text-center mb-0">FAQ Edit Form</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.faq.update',$faq->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="row mb-5">
                                <div class="col-lg-7 mb-7">
                                    <x-admin.label for="category_id" class="col-form-label required fw-bold fs-6">
                                        {{ __('FAQ category ') }}</x-admin.label>
                                    <x-admin.select-option id="category_id" name="category_id"
                                        data-hide-search="true" data-placeholder="Select an option">
                                        <option></option>
                                        @foreach ($faq_categories as $faq_category)
                                            @if ($faq_category->status == 'active')
                                                <option value="{{ $faq_category->id }}" @selected($faq_category->id == $faq->category_id)>{{ $faq_category->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </x-admin.select-option>
                                </div>
                                <div class="col-lg-5 mb-7">
                                    <x-admin.label for="order"
                                        class="col-form-label fw-bold fs-6 required">{{ __('Order') }}
                                    </x-admin.label>

                                    <x-admin.input id="order" type="number" name="order" :value="old('order',$faq->order)"
                                        placeholder="Eg: 1,2,3,4,5" required></x-admin.input>
                                </div>
                                <div class="col-lg-12 mb-7">
                                    <x-admin.label for="question"
                                        class="col-form-label fw-bold fs-6 required">{{ __('Question') }}
                                    </x-admin.label>

                                    <x-admin.textarea id="question" row="3" name="question" :value="old('question',$faq->question)"
                                        placeholder="Enter Question"
                                        required>{{ old('question',$faq->question) }}</x-admin.textarea>
                                </div>
                                <div class="col-lg-12 mb-7">
                                    <x-admin.label for="answer"
                                        class="col-form-label fw-bold fs-6 required">{{ __('Answer') }}
                                    </x-admin.label>

                                    <x-admin.textarea id="answer" row="5" name="answer" :value="old('answer',$faq->answer)"
                                        placeholder="Enter answer" required>{{ old('answer',$faq->answer) }}</x-admin.textarea>
                                </div>
                                <div class="col-lg-4 mb-7">
                                    <x-admin.label for="status" class="col-form-label required fw-bold fs-6">
                                        {{ __('Select a Status ') }}</x-admin.label>
                                    <x-admin.select-option id="status" name="status" data-hide-search="true"
                                        data-placeholder="Select an option">
                                        <option></option>
                                        <option value="active" @selected($faq->status == 'active')>Active</option>
                                        <option value="inactive" @selected($faq->status == 'inactive')>Inactive</option>
                                    </x-admin.select-option>
                                </div>
                            </div>
                            <div class="text-end">
                                <x-admin.button type="submit" class="primary">
                                    {{ __('Submit') }}
                                </x-admin.button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="faqAddModal" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0 border-0 shadow-sm">
                <div class="modal-header p-2 rounded-0">
                    <h5 class="modal-title ps-5">Add Faq Category</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
                <form class="form" action="{{ route('admin.faq-category.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col-lg-12 mb-7">
                            <x-admin.label for="name"
                                class="col-form-label fw-bold fs-6 required">{{ __('Name') }}
                            </x-admin.label>

                            <x-admin.input id="name" type="text" name="name" :value="old('name')"
                                placeholder="Enter the Name" required></x-admin.input>
                        </div>
                        <div class="col-lg-12 mb-7">
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
                    <div class="modal-footer p-2">
                        <x-admin.button type="submit" class="primary">
                            {{ __('Submit') }}
                        </x-admin.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    @foreach ($faq_categories as $faq_category)
        <div class="modal fade" id="faqEditModal_{{ $faq_category->id }}" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-0 border-0 shadow-sm">
                    <div class="modal-header p-2 rounded-0">
                        <h5 class="modal-title ps-5">Edit Faq Category</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                    </div>
                    <form action="{{ route('admin.faq-category.update', $faq_category->id) }}"
                        class="needs-validation" method="post" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="col-lg-12 mb-7">
                                <x-admin.label for="name"
                                    class="col-form-label fw-bold fs-6 required">{{ __('Name') }}
                                </x-admin.label>

                                <x-admin.input id="name" type="text" name="name" :value="old('name', $faq_category->name)"
                                    placeholder="Enter the Name" required></x-admin.input>
                            </div>
                            <div class="col-lg-12 mb-7">
                                <x-admin.label for="status" class="col-form-label required fw-bold fs-6">
                                    {{ __('Select a Status ') }}</x-admin.label>
                                <x-admin.select-option id="status" name="status" data-hide-search="true"
                                    data-placeholder="Select an option">
                                    <option></option>
                                    <option value="active" @selected($faq_category->status == 'active')>Active</option>
                                    <option value="inactive" @selected($faq_category->status == 'inactive')>Inactive</option>
                                </x-admin.select-option>
                            </div>
                        </div>
                        <div class="modal-footer p-2">
                            <x-admin.button type="submit" class="primary">
                                {{ __('Submit') }}
                            </x-admin.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- View Modal --}}

</x-admin-app-layout>
