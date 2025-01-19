<x-admin-guest-layout :title="'Admin Login'">
    <style>
        .login-btns {
            background-color: #2486d0 !important;
            border: 0;
            padding: 10px;
            color: white;
            width: 100%;
        }

        /* .input-group {
            width: 400px;
        } */

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
            {{-- <div class="col-xl-6 col-lg-6 d-none d-lg-block ">
                <div>
                    <img class="img-fluid w-100" src="{{ asset('images/animated-banner.gif') }}" alt=""
                        style="width: 600px;">
                </div>
            </div> --}}
            <div class="col-xl-6 col-lg-6 d-flex jutify-content-center align-items-center offset-lg-3 mt-lg-5"
                style="">
                <div class="d-flex justify-content-center flex-column align-items-center w-100">
                    <a href="{{ route('admin.dashboard') }}" class="brand-link">
                        <img src="{{ !empty($site->site_black_logo) && file_exists(public_path('storage/webSetting/' . $site->site_black_logo)) ? asset('storage/webSetting/' . $site->site_black_logo) : asset('images/logo_color_no_bg.png') }}"
                            alt="FMS-SHKSC" class="brand-image" style="width: 120px;" />
                    </a>
                    <div>
                        <h2 class="text-center my-4" style="color: #2486d0;">FMS-SHKSC</h2>
                    </div>
                    <div class="row bg-white p-4 py-5 rounded-3">

                        <form action="{{ route('admin.login') }}" method="POST" id="kt_sign_in_form">
                            @csrf
                            <div class="input-group mb-4">
                                <div class="form-floating">
                                    <input type="email" name="email" style="width: 300px"
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

                                    <input type="password" name="password" id="passwordField" style="width: 300px"
                                        class="form-control form-control-lg form-control-solid login-form @error('password')is-invalid @enderror"
                                        placeholder="Enter your password" autocomplete="off" />

                                    <label for="passwordField"
                                        class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Password') }}</label>
                                    @error('password')
                                        <div class="error invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="input-group-text">
                                    <span class="fa-solid fa-eye" style="color: #2486d0;" id="eyeIcon"
                                        onclick="togglePasswordVisibility()">
                                    </span>
                                </div>
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
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
</x-admin-guest-layout>
