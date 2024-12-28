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
                                <h2 class="ps-form__title mb-0">Forgot your password?</h2>
                                <p class="pt-5">No problem. Just let us know your email address <br> and we will email you a password
                                    reset link that will allow</p>
                            </div>
                        </div>
                    </div>
                    <div class="row pl-5">
                        <div class="col-lg-12 px-0 pl-5">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="ps-form--review w-75">
                                    <div class="ps-form__group">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-100 bg-light" type="email"
                                            name="email" :value="old('email')" required autofocus style="padding: 25px !important;"/>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <div class="mt-5">
                                        <button class="btn btn-primary w-100 p-3 text-white display-4 rounded-3"
                                            type="submit">
                                            Email Password Reset Link
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




{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
