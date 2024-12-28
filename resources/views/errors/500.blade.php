<x-admin-guest-layout :title="'500 Error'">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid">
            <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
                <a href="{{ url('/') }}" class="mb-10 pt-lg-10">
                    <img alt="Logo" src="{{ !empty(optional($setting)->site_logo_black) ? asset('storage/' . optional($setting)->site_logo_black) : asset('frontend/img/logo.png') }}" class="h-40px mb-5" />
                </a>
                <div class="pt-lg-10 mb-10">
                    <h1 class="fw-bolder fs-2qx text-gray-800 mb-10">500</h1>
                    <div class="fw-bold fs-3 text-muted mb-15">Server Error!
                        <br /> Please try again later.
                    </div>
                    <div class="text-center">
                        <a href="{{ url('/') }}" class="btn btn-lg btn-primary fw-bolder">Go to homepage</a>
                    </div>
                </div>
                <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                    style="background-image: url({{ asset('admin/assets/media/illustrations/sketchy-1/17.png') }})">
                </div>
            </div>
        </div>
    </div>
</x-admin-guest-layout>
