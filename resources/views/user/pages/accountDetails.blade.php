<x-frontend-app-layout :title="'Your Accounts Details'">
    <div class="breadcrumb-wrap">
        <div class="banner b-top bg-size bread-img">
            <img class="bg-img bg-top" src="img/banner-p.jpg" alt="banner" style="display: none;">
            <div class="container-lg">
                <div class="breadcrumb-box">
                    <div class="title-box3 text-center">
                        <h1>
                            <span class="text-info">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            <br>Welcome To Your Dashboard
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ps-account">
        <section class="user-dashboard py-8">
            <div class="container">
                <div class="row g-3 g-xl-4 tab-wrap">
                    <div class="col-lg-4 col-xl-3 sticky">
                        <!-- Sidebar here -->
                        @include('user.layouts.sidebar')
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        <div class="dashboard-tab bg-white p-5">
                            <div class="title-box3">
                                <h3>Your Accounts Details</h3>
                                <p>
                                    Manage and review your personal account information. Here, you can view and update
                                    essential details related to your profile, including your contact information,
                                    account settings, and security preferences
                                </p>
                            </div>
                            <div class="row g-0 option-wrap">
                                <div class="col-sm-12 col-xl-12">
                                    <div class="ps-checkout__content">
                                        <form action="{{ route('profile.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="row">
                                                <div class="col-12 col-lg-12">
                                                    <div class="ps-checkout__form">
                                                        <div class="row">
                                                            <!-- Account Information Section -->
                                                            <div class="col-12">
                                                                <h4>Account Information</h4>
                                                                <hr>
                                                            </div>
                                                            <div class="col-4 col-md-4">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">First name
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="first_name"
                                                                        value="{{ old('first_name', Auth::user()->first_name) }}"
                                                                        type="text" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Last name
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="last_name"
                                                                        value="{{ old('last_name', Auth::user()->last_name) }}"
                                                                        type="text" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Phone <span
                                                                            class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="phone"
                                                                        value="{{ old('phone', Auth::user()->phone) }}"
                                                                        type="text" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Company Name
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="company_name"
                                                                        value="{{ old('company_name', Auth::user()->company_name) }}"
                                                                        type="text" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Company
                                                                        Registration Number</label>
                                                                    <input class="form-control"
                                                                        name="company_registration_number"
                                                                        value="{{ old('company_registration_number', Auth::user()->company_registration_number) }}"
                                                                        type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Company VAT
                                                                        Number</label>
                                                                    <input class="form-control"
                                                                        name="company_vat_number"
                                                                        value="{{ old('company_vat_number', Auth::user()->company_vat_number) }}"
                                                                        type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Website
                                                                        Address</label>
                                                                    <input class="form-control" name="website_address"
                                                                        value="{{ old('website_address', Auth::user()->website_address) }}"
                                                                        type="text">
                                                                </div>
                                                            </div>

                                                            <!-- Billing Information Section -->
                                                            <div class="col-12 mt-4">
                                                                <h4>Billing Information</h4>
                                                                <hr>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">House/Block/Road
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control mb-3" name="address_one"
                                                                        value="{{ old('address_one', Auth::user()->address_one) }}"
                                                                        type="text"
                                                                        placeholder="House number and street name"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 col-md-3">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Postcode
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="zipcode"
                                                                        value="{{ old('zipcode', Auth::user()->zipcode) }}"
                                                                        type="text" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 col-md-3">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">State
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="state"
                                                                        value="{{ old('state', Auth::user()->state) }}"
                                                                        type="text" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 col-md-3">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">City/Country
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="address_two"
                                                                        value="{{ old('address_two', Auth::user()->address_two) }}"
                                                                        type="text" required>
                                                                </div>
                                                            </div>

                                                            <!-- Login Information Section -->
                                                            <div class="col-12 mt-4">
                                                                <h4>Login Information</h4>
                                                                <hr>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="ps-checkout__label">Email address
                                                                        <span class="text-danger">*</span> </label>
                                                                    <input class="form-control" name="email"
                                                                        value="{{ old('email', Auth::user()->email) }}"
                                                                        type="email" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div>
                                                                    <label class="ps-checkout__label pb-2">Password
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <input id="password-field" type="password"
                                                                        class="form-control" name="password"
                                                                        value="*****">
                                                                    <div class="input-group-append">
                                                                        <button id="toggle-password"
                                                                            class="bg-warning border-0 text-white" type="button">
                                                                            <i id="password-icon"
                                                                                class="fa fa-eye"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-4">
                                                                <input type="submit" value="Save Changes"
                                                                    class="updatebutton btn btn-primary w-100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script>
            document.getElementById('toggle-password').addEventListener('click', function() {
                var passwordField = document.getElementById('password-field');
                var passwordIcon = document.getElementById('password-icon');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }
            });
        </script>
    @endpush
</x-frontend-app-layout>
