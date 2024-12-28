<x-admin-app-layout :title="'Email Configuration'">
    <div class="card shadow-sm">
        <!--begin::Form-->
        <form class="form" action="{{ route('admin.email.settings.updateOrCreate') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-title">Mail Settings</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light">
                        Action
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-lg-2 mb-7">
                        <x-admin.label for="mail_mailer"
                            class="col-form-label fw-bold fs-6 required">{{ __('Mailer') }}
                        </x-admin.label>

                        <x-admin.input id="mail_mailer" type="text" name="mail_mailer" :value="old('mail_mailer', optional($activeMailConfig)->mail_mailer)"
                            placeholder="Enter the Mailer" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_host"
                            class="col-form-label fw-bold fs-6 required">{{ __('Host') }}
                        </x-admin.label>

                        <x-admin.input id="mail_host" type="text" name="mail_host" :value="old('mail_host', optional($activeMailConfig)->mail_host)"
                            placeholder="Enter the Host" required></x-admin.input>
                    </div>

                    <div class="col-lg-2 mb-7">
                        <x-admin.label for="mail_port"
                            class="col-form-label fw-bold fs-6 required">{{ __('Port') }}
                        </x-admin.label>

                        <x-admin.input id="mail_port" type="number" name="mail_port" :value="old('mail_port', optional($activeMailConfig)->mail_port)"
                            placeholder="Enter the Port" required></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="mail_username"
                            class="col-form-label fw-bold fs-6 required">{{ __('Username') }}
                        </x-admin.label>

                        <x-admin.input id="mail_username" type="text" name="mail_username" :value="old('mail_username', optional($activeMailConfig)->mail_username)"
                            placeholder="Enter the Username" required></x-admin.input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 mb-7">
                        <x-admin.label for="mail_password"
                            class="col-form-label fw-bold fs-6 required">{{ __('Password') }}
                        </x-admin.label>
                        <x-admin.password-input id="mail_password" name="mail_password"
                            placeholder="Enter mail password" :value="old('mail_password', optional($activeMailConfig)->mail_password)" required />
                    </div>

                    <div class="col-lg-2 mb-7">
                        <x-admin.label for="mail_encryption" class="col-form-label fw-bold fs-6 required">
                            {{ __('Mail Encryption ') }}</x-admin.label>
                        <x-admin.select-option id="mail_encryption" name="mail_encryption" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="ssl"
                                {{ old('mail_encryption', optional($activeMailConfig)->mail_encryption) == 'ssl' ? 'selected' : '' }}>
                                SSL</option>
                            <option value="tls"
                                {{ old('mail_encryption', optional($activeMailConfig)->mail_encryption) == 'tls' ? 'selected' : '' }}>
                                TLS</option>
                        </x-admin.select-option>
                    </div>

                    <div class="col-lg-5 mb-7">
                        <x-admin.label for="mail_from_address"
                            class="col-form-label fw-bold fs-6 required">{{ __('From Address') }}
                        </x-admin.label>

                        <x-admin.input id="mail_from_address" type="email" name="mail_from_address"
                            :value="old('mail_from_address', optional($activeMailConfig)->mail_from_address)" placeholder="Enter the From Address" required></x-admin.input>
                    </div>

                    <div class="col-lg-2 mb-7">
                        <x-admin.label for="status" class="col-form-label required fw-bold fs-6">
                            {{ __('Select a Status ') }}</x-admin.label>
                        <x-admin.select-option id="status" name="status" data-hide-search="true"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="1" {{ optional($activeMailConfig)->status == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0" {{ optional($activeMailConfig)->status == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </x-admin.select-option>
                    </div>
                </div>
                <!--end::Form-->
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <x-admin.button type="submit" class="primary">
                        {{ __('Save Configuration') }}
                    </x-admin.button>
                </div>
                <!--end::Actions-->
            </div>
        </form>
    </div>
    <div class="card shadow-sm mt-5">
        <div class="card-header">
            <h3 class="card-title">Test Mail Configuration</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light">
                    Action
                </button>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Alerts-->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <!--end::Alerts-->
            <!--begin::Form-->
            <form class="form" action="{{ route('admin.send.test.mail') }}" method="POST">
                @csrf
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-lg-10">
                        <x-admin.label for="email"
                            class="col-form-label fw-bold fs-6 required">{{ __('Mail Address') }}
                        </x-admin.label>

                        <x-admin.input id="email" type="email" name="email"
                            placeholder="Enter the Mail Address" required></x-admin.input>
                    </div>

                    <div class="col-lg-2 mt-13">
                        <x-admin.button type="submit" class="primary">
                            {{ __('Send Test Email') }}
                        </x-admin.button>
                    </div>
                    <!--end::Actions-->
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
</x-admin-app-layout>
