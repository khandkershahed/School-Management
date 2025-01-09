
    <div class="card-header d-flex justify-content-center">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0"> {{ __('Update Password') }} </h3>
        </div>
    </div>
    <form class="form" method="post" action="{{ route('admin.password.update') }}">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="row">
                <div class="mb-10 col-lg-4">
                    <x-admin.label class="required form-label"
                        for="current_password">{{ __('Current Password') }}</x-admin.label>
                    <x-admin.input type="password" id="current_password" name="current_password"
                        class="form-control mb-2" placeholder="Current password" required
                        autocomplete="current-password"></x-admin.input>
                </div>
                <div class="mb-10 col-lg-4">
                    <x-admin.label class="required form-label"
                        for="password">{{ __('New Password') }}</x-admin.label>
                    <x-admin.input type="password" id="password" name="password" class="form-control mb-2"
                        placeholder="Enter your new password" required autocomplete="new-password"></x-admin.input>
                </div>
                <div class="mb-10 col-lg-4">
                    <x-admin.label class="required form-label"
                        for="password_confirmation">{{ __('Confirm Password') }}</x-admin.label>
                    <x-admin.input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control mb-2" placeholder="Enter your new password again" required
                        autocomplete="new-password"></x-admin.input>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end py-3 px-3">
            <x-admin.button type="submit" class="primary">
                {{ __('Submit') }}
            </x-admin.button>
        </div>
    </form>
