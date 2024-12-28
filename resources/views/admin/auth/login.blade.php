<x-admin-guest-layout :title="'Admin Login'">
    <style>
        .login-btns {
            background-color: #2486d0 !important;
            border: 0;
            padding: 10px;
            color: white;
            width: 100%;
        }

        .input-group {
            width: 400px;
        }

        .icons-eye {
            right: -30px !important;
        }

        .login-form {
            width: 100% !important;
            border: 1px solid #eee;
            border-radius: 5px;
        }
    </style>
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-xl-6 col-lg-6 d-lg-block d-sm-none" style="background-color: #fff;">
                <div>
                    <img class="img-fluid w-100" src="{{ asset('images/animated-banner.gif') }}" alt=""
                        style="width: 600px;">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 d-flex jutify-content-center align-items-center" style="">
                <div class="d-flex justify-content-center flex-column align-items-center w-100">
                    <a href="{{ route('admin.dashboard') }}" class="brand-link">
                        <img src="{{ !empty($site->site_black_logo) && file_exists(public_path('storage/webSetting/' . $site->site_black_logo)) ? asset('storage/webSetting/' . $site->site_black_logo) : asset('images/logo-color.png') }}"
                            alt="AdminLTE Logo" class="brand-image" style="width: 200px;" />
                    </a>
                    <div>
                        <p class="text-center pt-4 fw-bold fs-4">Your Admin Account</p>
                        <p class="text-center " style="color: #2486d0;">Login To Continue</p>
                    </div>
                    <div class="row mt-3 bg-white p-4 py-5 rounded-3">
                        {{-- <form action="{{ route('admin.login') }}" method="POST" id="kt_sign_in_form">
                            @csrf
                            <div class="input-group mb-3">
                                <x-admin.input type="email" name="email" class="form-control form-control-solid" id="passwordField"
                                    placeholder="Email" :value="old('email')" autocomplete="off"></x-admin.input>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope" style="color: #2486d0;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <x-admin.input type="password" name="password" class="form-control form-control-solid"
                                    placeholder="Password" :value="old('password')" autocomplete="off" onclick="togglePasswordVisibility()"></x-admin.input>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span id="eyeIcon" class="fa-solid fa-eye fs-2"
                                            style="color: #2486d0;font-size: 25px !important;"></span>
                                        <span class="fa-solid fa-eye d-none"
                                            style="color: #2486d0; font-size: 25px !important;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input id="remember_me" type="checkbox" value="1"
                                            class="form-check-input me-3" name="remember">
                                        <label for="remember_me"
                                            class="form-check-label">{{ __('Remember me') }}</label>

                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form> --}}
                        <form action="{{ route('admin.login') }}" method="POST" id="kt_sign_in_form">
                            @csrf
                            <div class="input-group mb-4">
                                <div class="form-floating">
                                    <input type="email" name="email"
                                        class="form-control form-control-solid login-form @error('email')is-invalid @enderror"
                                        placeholder="Enter your email address" value="{{ old('email') }}"
                                        autocomplete="off" />
                                    <label for="loginEmail"
                                        class="form-label fs-6 fw-bolder text-dark">{{ __('Email') }}</label>
                                </div>
                                <div class="input-group-text"> <span class="bi bi-envelope"
                                        style="color: #2486d0;"></span>
                                </div>
                                @error('email')
                                    <div class="error invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-group mb-4">
                                <div class="form-floating">

                                    <input type="password" name="password" id="passwordField"
                                        class="form-control form-control-lg form-control-solid login-form @error('password')is-invalid @enderror"
                                        placeholder="Enter your password" autocomplete="off" />
                                    <span
                                        class="btn btn-sm btn-icon border-0 bg-none shadow-none rounded-0 position-absolute translate-middle top-50 end-0 me-2 icons-eye"
                                        style="@error('password')top: 34% !important; @enderror"
                                        data-kt-password-meter-control="visibility"
                                        onclick="togglePasswordVisibility()">
                                        <i id="eyeIcon" class="fa-solid fa-eye fs-2"
                                            style="color: #2486d0;font-size: 25px !important;"></i>
                                        <i class="fa-solid fa-eye d-none"
                                            style="color: #2486d0; font-size: 25px !important;"></i>
                                    </span>
                                    <label for="passwordField"
                                        class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Password') }}</label>
                                    @error('password')
                                        <div class="error invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="input-group-text"> <span class="bi bi-lock-fill"
                                        style="color: #2486d0;"></span> </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-inline-flex align-items-center">
                                    <div class="form-check">
                                        <input id="remember_me" type="checkbox" value="1"
                                            class="form-check-input me-3" name="remember">
                                        <label for="remember_me"
                                            class="form-check-label">{{ __('Remember me') }}</label>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid gap-2">
                                        <button type="submit"
                                            class="btn btn-primary me-2 rounded-1 border-0 py-2 mt-4">
                                            <span class="indicator-label fw-bold fs-5"> {{ __('Sign In') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function togglePasswordVisibility() {
                const passwordField = document.getElementById('passwordField');
                const eyeIcon = document.getElementById('eyeIcon');
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    passwordField.type = 'password';
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            }
        </script>
    @endpush
</x-admin-guest-layout>
