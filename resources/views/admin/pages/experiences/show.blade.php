<x-admin-app-layout :title="'Experience Details'">
    <div class="card card-flash">
        <!--begin::Card header-->
        <div class="card-header mt-6">
            <div class="card-title"></div>

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('admin.experiences.index') }}" class="btn btn-light-info rounded-2">
                    <!--begin::Svg Experience | path: experiences/duotune/general/gen035.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                fill="currentColor" />
                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Experience-->Back to the list
                </a>
            </div>
        </div>
        <div class="card-body pt-3">
            <!--begin::Details-->
            <dl class="row">
                <dt class="col-lg-4 mb-7"><i class="bi bi-chat-quote-fill"></i> {{ __('Quote') }}</dt>
                <dd class="col-lg-8 mb-7">{{ $experience->quote }}</dd>

                <dt class="col-lg-4 mb-7"><i class="bi bi-calendar-check-fill"></i> {{ __('Starting Year') }}</dt>
                <dd class="col-lg-8 mb-7">{{ $experience->starting_year }}</dd>

                <dt class="col-lg-4 mb-7"><i class="bi bi-calendar-x-fill"></i> {{ __('End Year') }}</dt>
                <dd class="col-lg-8 mb-7">{{ $experience->end_year }}</dd>

                <dt class="col-lg-4 mb-7"><i class="bi bi-person-fill"></i> {{ __('Role') }}</dt>
                <dd class="col-lg-8 mb-7">{{ $experience->role }}</dd>

                <dt class="col-lg-4 mb-7"><i class="bi bi-building"></i> {{ __('Organization') }}</dt>
                <dd class="col-lg-8 mb-7">{{ $experience->organization }}</dd>

                <dt class="col-lg-4 mb-7"><i class="bi bi-info-circle-fill"></i> {{ __('Short Description') }}</dt>
                <dd class="col-lg-8 mb-7">{{ $experience->short_description }}</dd>
            </dl>
            <!--end::Details-->
        </div>
    </div>
</x-admin-app-layout>
