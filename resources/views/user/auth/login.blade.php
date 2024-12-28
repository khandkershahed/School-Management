<x-frontend-app-layout :title="'Login'">
    <style>
        body {
            background-color: #eee;
        }

        .row-equal-height {
            display: flex;
        }

        .column-equal-height {
            display: flex;
            flex-direction: column;
        }

        .login-imge {
            height: 880px;
            width: 100%;
            object-fit: cover;
        }

        .home-logo {
            width: 200px;
        }

        .login-divider {}

        .devider {
            background: #eee;
            height: 2px;
            position: relative;
            top: -3px;
        }
        .divider-text{
            position: relative;
            bottom: -10px;
            z-index: 5;
            background: white;
            width: 100px;
            margin: auto;
        }
    </style>
    <div class="ps-account my-5 py-5">
        <div class="container">
            <div class="row row-equal-height my-5 align-items-center gx-5 bg-white">
                <div class="col-12 col-md-6 bg-white column-equal-height">
                    <div class="row pl-5">
                        <div class="col-lg-12 pl-5">
                            <div class="pb-5">
                                <a href="{{ route('home') }}" class="">
                                    <img class="img-fluid home-logo"
                                        src="{{ !empty(optional($setting)->site_logo_black) ? asset('storage/' . optional($setting)->site_logo_black) : asset('frontend/img/logo.png') }}"
                                        alt="">
                                </a>
                            </div>
                            <div class="mb-5">
                                <h2 class="ps-form__title mb-0">Welcome Back!</h2>
                                <p>Enter To Get Unlimited Access & Data</p>
                            </div>
                        </div>
                    </div>
                    <div class="row pl-5">
                        <div class="col-lg-12 px-0 pl-5">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="ps-form--review w-75">
                                    <div class="ps-form__group">
                                        <x-input-label class="form-label form__label" for="email"
                                            :value="__('Email')" />
                                        <x-text-input id="email"
                                            class="form-control form-control-solid ps-form__input" type="email"
                                            name="email" :value="old('email')" required autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <div class="ps-form__group">
                                        <x-input-label class="ps-form__label form-label" for="password"
                                            :value="__('Password')" />
                                        <div class="input-group">
                                            <x-text-input class="form-control form-control-solid ps-form__input"
                                                type="password" id="password" name="password" required
                                                autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            <div class="input-group-append">
                                                <a class="fa fa-eye-slash toogle-password"
                                                    href="javascript:void(0);"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ps-form__submit">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check ml-0">
                                                <input class="form-check-input" type="checkbox" id="remember_me"
                                                    name="remember">
                                                <label class="form-check-label" for="remember_me">Remember me</label>
                                            </div>
                                            <div>
                                                @if (Route::has('password.request'))
                                                    <a class="ps-account__link text-primary mt-0"
                                                        href="{{ route('password.request') }}">Forgot your password
                                                        ?</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <button class="btn btn-primary w-100 p-3 text-white display-4 rounded-3"
                                            type="submit">
                                            Log in
                                        </button>
                                    </div>
                                    {{-- <div class="login-divider text-center pt-3">
                                        <p class="mb-0 pb-0 divider-text">Or Login With</p>
                                        <p class="devider mb-0 pb-0"></p>
                                    </div> --}}

                                    {{-- <div class="mt-5">
                                        <button class="btn btn-outline-primary w-100 p-3 display-4 rounded-3">
                                          <i class="fa fa-google-plus"></i>  Sign Up With Google
                                        </button>
                                    </div> --}}
                                    @if (Route::has('password.request'))
                                        <p class="text-center"><span class="ps-5 text-center">
                                                Don't Have Account
                                                <a class="ps-account__link text-primary" href="{{ route('register') }}">
                                                    Create New Accounts
                                                </a>
                                            </span></p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 column-equal-height px-0">
                    <div>
                        <img class="img-fluid login-imge" src="{{ asset('frontend/img/bg-login.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-app-layout>
