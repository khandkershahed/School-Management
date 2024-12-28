<x-admin-app-layout :title="'FAQ LIst'">
    <div class="card">
        <div class="card-header bg-info align-items-center d-flex justify-content-between">
            <div>
                <h1 class="mb-0 text-center w-100 text-white">Manage All Faqs</h1>
            </div>
            <div>
                <a href="{{ route('admin.faq.create') }}" class="btn btn-light-primary rounded-2">
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
                    Create Faq
                </a>
            </div>
        </div>
        <div class="card-body py-0">
            <table class="table my-datatable table-striped table-row-bordered gy-5 gs-7">
                <thead class="bg-light-danger">
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th class="" width="5%">Sl</th>
                        <th class="" width="20%">Category Name</th>
                        <th class="" width="45%">Order Number</th>
                        <th class="" width="20%">Status</th>
                        <th class="" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($faqs)
                        @foreach ($faqs as $faq)
                            <tr class="odd">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $faq->faqCategory ? $faq->faqCategory->name : 'No Category' }}
                                </td>
                                <td>
                                    {{ $faq->order }}
                                </td>
                                <td>
                                    <span class="badge {{ $faq->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $faq->status == 'active' ? 'Active' : 'InActive' }}</span>
                                </td>
                                <td class="d-flex justify-content-between align-items-center">
                                    <a href="#"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                        data-bs-toggle="modal" data-bs-target="#faqViewModal_{{ $faq->id }}">
                                        <i class="fa-solid fa-expand"></i>
                                    </a>
                                    <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.faq.destroy', $faq->id) }}"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 delete"
                                        data-kt-docs-table-filter="delete_row">
                                        <i class="fa-solid fa-trash-can-arrow-up"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- View Modal --}}
    @foreach ($faqs as $faq)
        <div class="modal fade" id="faqViewModal_{{ $faq->id }}" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0 border-0 shadow-sm">
                    <div class="modal-header p-2 rounded-0">
                        <h5 class="modal-title ps-5">View Faq</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container px-0">
                            <div class="card border rounded-0">
                                <p class="badge badge-info custom-badge">Info</span>
                                <div class="card-body p-1 px-2">
                                    <div class="row">
                                        <div class="col-lg-12 mb-5">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-5">
                                                    <p class="fw-bold" title="Country Name">Category :</p>
                                                </div>
                                                <div class="col-lg-8 col-sm-6">
                                                    <p> {{ $faq->faqCategory ? $faq->faqCategory->name : 'No Category' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-5">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-5">
                                                    <p class="fw-bold">Question :</p>
                                                </div>
                                                <div class="col-lg-8 col-sm-6">
                                                    <p>{{ $faq->question }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-5">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-5">
                                                    <p class="fw-bold">Answer :</p>
                                                </div>
                                                <div class="col-lg-8 col-sm-6">
                                                    <p>
                                                        {{ $faq->answer }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-5">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-5">
                                                    <p class="fw-bold">Status :</p>
                                                </div>
                                                <div class="col-lg-8 col-sm-6">
                                                    <p>
                                                        <span
                                                            class="badge {{ $faq->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $faq->status == 1 ? 'active' : 'inactive' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-admin-app-layout>
