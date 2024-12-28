<x-frontend-app-layout :title="'Reset Password'">
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

        .divider-text {
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
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf
                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="ps-form--review w-75">
                                    <div class="ps-form__group">
                                        <x-input-label class="form-label form__label" for="email"
                                            :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email"
                                            name="email" :value="old('email', $request->email)" required autofocus
                                            autocomplete="username" />
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
                                    <div class="ps-form__group">
                                        <x-input-label class="ps-form__label form-label" for="password_confirmation"
                                            :value="__('Confirmation Password')" />
                                        <div class="input-group">
                                            <x-text-input class="form-control form-control-solid ps-form__input"
                                                type="password_confirmation" id="password_confirmation"
                                                name="password_confirmation" required
                                                autocomplete="new-password_confirmation" />
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                            <div class="input-group-append">
                                                <a class="fa fa-eye-slash toogle-password"
                                                    href="javascript:void(0);"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <button class="btn btn-primary w-100 p-3 text-white display-4 rounded-3"
                                            type="submit">
                                            Reset Password
                                        </button>
                                    </div>
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
