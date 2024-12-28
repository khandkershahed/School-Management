<x-admin-app-layout :title="'Contact Message List'">

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-fluid">
            <div class="card card-flush">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="kt_datatable_example table table-hover align-middle table-row-dashed fs-6 gy-5"
                            id="kt_datatable_example">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    {{-- <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_message_table .form-check-input"
                                                value="1" />
                                        </div>
                                    </th> --}}
                                    <th width="5%" class="text-center">Sl</th>
                                    <th width="15%" class="text-center">Name</th>
                                    <th width="20%" class="text-center">Email</th>
                                    <th width="5%" class="text-center">Message</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center fw-bold text-gray-600">
                                @forelse ($contacts as $contact)
                                    <tr>
                                        {{-- <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                            </div>
                                        </td> --}}
                                        <td>
                                            <span class="fw-bolder"> {{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bolder"> {{ $contact->name }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bolder"> {{ $contact->email }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bolder"> {{ $contact->message }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.contacts.destroy', $contact->id) }}"
                                                class="menu-link px-3 delete">
                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                            </a>
                                            {{-- <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <div class="menu-item px-3">
                                                    <a href="{{ route('admin.contact.show', $contact->id) }}"
                                                        class="menu-link px-3">Show</a>
                                                </div>
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.contacts.edit', $contact->id) }}"
                                                            class="menu-link px-3">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.contacts.destroy', $contact->id) }}"
                                                            class="menu-link px-3 delete">
                                                            <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </a> --}}
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
