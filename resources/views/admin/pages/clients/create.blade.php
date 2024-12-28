<x-admin-app-layout :title="'Client Create'">
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Client</h4>
                                <a href="{{ route('admin.clients.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.clients.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name"
                                                name="name" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="email" class="form-label">Email <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="email" :value="old('email')" id="email"
                                                name="email" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="phone" class="font-weight-bold text-dark">Contact
                                                    Number <span class="text-danger">*</span></x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="phone" type="text" name="phone"
                                                        :value="old('phone')" class="form-control" autofocus>
                                                    </x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="company_name" class="form-label">Company
                                                Name</x-admin.label>
                                            <x-admin.input type="company_name" :value="old('company_name')" id="company_name"
                                                name="company_name"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true"
                                                required>
                                                <option value="active" @selected(old('status') == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="tax_registration_number" class="form-label">Tax
                                                Registration No</x-admin.label>
                                            <x-admin.input type="text" :value="old('tax_registration_number')" id="tax_registration_number"
                                                name="tax_registration_number" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label">Image</x-admin.label>
                                            <x-admin.file-input type="file" :value="old('image')" id="image"
                                                name="image" required></x-admin.file-input>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <x-admin.textarea class="form-control text-area-input"
                                                placeholder="Write Here" id="address" name="address" rows="3">
                                                {{ old('address') }}
                                            </x-admin.textarea>
                                        </div>
                                    </div>



                                    <div class="row mt-3 mb-5">
                                        <div class="col-lg-3 col-6">
                                            <label class="form-check form-switch d-flex align-items-center">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                    name="isSendEmail" checked="checked" />
                                                </div>
                                                <div class="my-auto">
                                                    <span class="form-check-label fw-semibold text-muted">
                                                        Send Welcome Email
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 col-6">
                                            <label class="form-check form-switch d-flex align-items-center">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                    name="isSendSMS" checked="checked" />
                                                </div>
                                                <div class="my-auto">
                                                    <span class="form-check-label fw-semibold text-muted">
                                                        Send Welcome SMS
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                        {{-- <div class="form-group col-12 d-flex flex-wrap">
                                            <div class="pr-5">
                                                <label class="vue-js-switch">
                                                    <input type="checkbox" class="v-switch-input">
                                                    <div class="v-switch-core"
                                                        style="width: 50px; height: 22px; background-color: rgb(191, 203, 217); border-radius: 11px;">
                                                        <div class="v-switch-button"
                                                            style="width: 16px; height: 16px; transition: transform 300ms; transform: translate3d(3px, 3px, 0px);">
                                                        </div>
                                                    </div> <!---->
                                                </label>
                                                Send Welcome Email
                                            </div>
                                        </div>
                                        <div class="form-group col-12 d-flex flex-wrap">
                                            <div class="pr-5">
                                                <label class="vue-js-switch">
                                                    <input type="checkbox" class="v-switch-input">
                                                    <div class="v-switch-core"
                                                        style="width: 50px; height: 22px; background-color: rgb(191, 203, 217); border-radius: 11px;">
                                                        <div class="v-switch-button"
                                                            style="width: 16px; height: 16px; transition: transform 300ms; transform: translate3d(3px, 3px, 0px);">
                                                        </div>
                                                    </div> <!---->
                                                </label>
                                                Send Welcome SMS
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Create Client
                                    <i class="fa-regular fa-floppy-disk ps-2"></i>
                                </x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
