<x-admin-app-layout :title="'Email-settings Add'">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-5">
                    <div class="card-header p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="text-gray-800">Create Email Setting</h4>
                            <a href="{{ route('admin.email-settings.index') }}" class="btn-common-one text-white"
                                tabindex="0">
                                <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('admin.email-settings.store') }}" method="POST">
                            @csrf
                            <!--begin::Input group-->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_mailer" class="form-label">{{ __('Mailer') }}
                                        </x-admin.label>
                                        <x-admin.input id="mail_mailer" type="text" name="mail_mailer"
                                            :value="old('mail_mailer')" placeholder="Enter the Mailer" required></x-admin.input>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_host" class="form-label">{{ __('Host') }}
                                        </x-admin.label>
                                        <x-admin.input id="mail_host" type="text" name="mail_host" :value="old('mail_host')"
                                            placeholder="Enter the Host" required></x-admin.input>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_port" class="form-label">{{ __('Port') }}
                                        </x-admin.label>
                                        <x-admin.input id="mail_port" type="number" name="mail_port" :value="old('mail_port')"
                                            placeholder="Enter the Port" required></x-admin.input>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_username" class="form-label">{{ __('Username') }}
                                        </x-admin.label>
                                        <x-admin.input id="mail_username" type="text" name="mail_username"
                                            :value="old('mail_username')" placeholder="Enter the Username" required></x-admin.input>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_password" class="form-label">{{ __('Password') }}
                                        </x-admin.label>
                                        <x-admin.password-input id="mail_password" name="mail_password"
                                            placeholder="Enter mail password" :value="old('mail_password')" required />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_encryption" class="form-label">
                                            {{ __('Mail Encryption ') }}</x-admin.label>
                                        <x-admin.select-option id="mail_encryption" name="mail_encryption"
                                            data-hide-search="true" data-placeholder="Select an option">
                                            <option></option>
                                            <option value="ssl"
                                                {{ old('mail_encryption') == 'ssl' ? 'selected' : '' }}>
                                                SSL</option>
                                            <option value="tls"
                                                {{ old('mail_encryption') == 'tls' ? 'selected' : '' }}>
                                                TLS</option>
                                        </x-admin.select-option>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_from_address"
                                            class="form-label">{{ __('From Address') }}
                                        </x-admin.label>
                                        <x-admin.input id="mail_from_address" type="email" name="mail_from_address"
                                            :value="old('mail_from_address')" placeholder="Enter the From Address"
                                            required></x-admin.input>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="mail_from_name" class="form-label">{{ __('From Name') }}
                                        </x-admin.label>
                                        <x-admin.input id="mail_from_name" type="text" name="mail_from_name"
                                            :value="old('mail_from_name')" placeholder="Enter the From Name"
                                            required></x-admin.input>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <x-admin.label for="status" class="form-label">
                                            {{ __('Select a Status ') }}</x-admin.label>
                                        <x-admin.select-option id="status" name="status" data-hide-search="true"
                                            data-placeholder="Select an option">
                                            <option></option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </x-admin.select-option>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-admin.button type="submit">Save Email<i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
