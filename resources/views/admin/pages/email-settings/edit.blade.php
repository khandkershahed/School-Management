<x-admin-app-layout :title="'Email-Settings Edit'">
    <div class="card card-flash">
        <!--begin::Modal body-->
        <div class="card-body scroll-y mx-5 mx-xl-15 my-7">
            <!--begin::Form-->
            <form class="form" action="{{ route('admin.email-settings.update', $emailSetting) }}" method="POST">
                @csrf
                @method('PUT')
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_mailer"
                            class="col-form-label fw-bold fs-6 required">{{ __('Mailer') }}
                        </x-admin.label>

                        <x-admin.input id="mail_mailer" type="text" name="mail_mailer" :value="old('mail_mailer', $emailSetting->mail_mailer)"
                            placeholder="Enter the Mailer" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_host"
                            class="col-form-label fw-bold fs-6 required">{{ __('Host') }}
                        </x-admin.label>

                        <x-admin.input id="mail_host" type="text" name="mail_host" :value="old('mail_host', $emailSetting->mail_host)"
                            placeholder="Enter the Host" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_port"
                            class="col-form-label fw-bold fs-6 required">{{ __('Port') }}
                        </x-admin.label>

                        <x-admin.input id="mail_port" type="number" name="mail_port" :value="old('mail_port', $emailSetting->mail_port)"
                            placeholder="Enter the Port" required></x-admin.input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_username"
                            class="col-form-label fw-bold fs-6 required">{{ __('Username') }}
                        </x-admin.label>

                        <x-admin.input id="mail_username" type="text" name="mail_username" :value="old('mail_username', $emailSetting->mail_username)"
                            placeholder="Enter the Username" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_password"
                            class="col-form-label fw-bold fs-6 required">{{ __('Password') }}
                        </x-admin.label>
                        <x-admin.password-input id="mail_password" name="mail_password"
                            placeholder="Enter mail password" :value="old('mail_password', $emailSetting->mail_password)" required />
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_encryption" class="col-form-label fw-bold fs-6 required">
                            {{ __('Mail Encryption ') }}</x-admin.label>
                        <x-admin.select-option id="mail_encryption" name="mail_encryption" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="ssl"
                                {{ old('mail_encryption', $emailSetting->mail_encryption) == 'ssl' ? 'selected' : '' }}>
                                SSL</option>
                            <option value="tls"
                                {{ old('mail_encryption', $emailSetting->mail_encryption) == 'tls' ? 'selected' : '' }}>
                                TLS</option>
                        </x-admin.select-option>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_from_address"
                            class="col-form-label fw-bold fs-6 required">{{ __('From Address') }}
                        </x-admin.label>

                        <x-admin.input id="mail_from_address" type="email" name="mail_from_address"
                            :value="old('mail_from_address', $emailSetting->mail_from_address)" placeholder="Enter the From Address" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_from_name"
                            class="col-form-label fw-bold fs-6 required">{{ __('From Name') }}
                        </x-admin.label>

                        <x-admin.input id="mail_from_name" type="text" name="mail_from_name" :value="old('mail_from_name', $emailSetting->mail_from_name)"
                            placeholder="Enter the From Name" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="status" class="col-form-label required fw-bold fs-6">
                            {{ __('Select a Status ') }}</x-admin.label>
                        <x-admin.select-option id="status" name="status" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="1" {{ $emailSetting->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $emailSetting->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </x-admin.select-option>
                    </div>
                </div>
                <div class="text-center pt-15">
                    <x-admin.button type="submit" class="primary">
                        {{ __('Submit') }}
                    </x-admin.button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal body-->
    </div>
</x-admin-app-layout>
