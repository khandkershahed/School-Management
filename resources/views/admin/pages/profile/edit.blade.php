<x-admin-app-layout :title="$user->name . ' Profile Update'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row gx-2">

                <div class="col-lg-2">

                    <div class="card mb-5 mb-xl-8">

                        <div class="card-body">


                            <div class="d-flex flex-center flex-column text-center">

                                <div class="symbol symbol-100px symbol-circle mb-3">
                                    <img src="{{ !empty(Auth::guard('admin')->user()->photo) && file_exists(public_path('storage/' . Auth::guard('admin')->user()->photo)) ? asset('storage/' . Auth::guard('admin')->user()->photo) : asset('https://ui-avatars.com/api/?name=' . urlencode(Auth::guard('admin')->user()->name)) }}"
                                        alt="{{ Auth::guard('admin')->user()->name }}" width="200px"/>
                                </div>


                                <a href="#" class="fw-bolder mb-3">{{ $user->name }}</a>


                                <div class="mb-3">
                                    @foreach ($user->getRoleNames() as $role)
                                        <div class="badge bg-primary d-inline">{{ $role }}
                                        </div>
                                    @endforeach

                                </div>

                            </div>



                            <div class="d-flex flex-stack py-3">
                                <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse"
                                    data-bs-target="#user_collapse_details_{{ $user->id }}" role="button"
                                    aria-expanded="false" aria-controls="user_collapse_details_{{ $user->id }}">
                                    Profile Details
                                    <span class="ms-2 rotate-180">

                                        <span class="svg-icon svg-icon-3">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>

                                    </span>
                                </div>
                            </div>

                            <div class="separator"></div>

                            <div class="collapse show" id="user_collapse_details_{{ $user->id }}">
                                <div class="pb-5 fs-6">
                                    @if (!empty($user->username))
                                        <div class="fw-bolder mt-2">User Name</div>
                                        <div class="text-gray-600">{{ $user->username }}</div>
                                    @endif


                                    @if (!empty($user->email))
                                        <div class="fw-bolder mt-2">Email</div>
                                        <div class="text-gray-600">
                                            <a href="#"
                                                class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                                        </div>
                                    @endif


                                    @if (!empty($user->address) || !empty($user->country))
                                        <div class="fw-bolder mt-2">Address</div>
                                        <div class="text-gray-600">{{ $user->address }}</div>
                                        <div class="text-gray-600">{{ $user->city }},{{ $user->country }}</div>
                                    @endif


                                    <div class="fw-bolder mt-2">Language</div>
                                    <div class="text-gray-600">English</div>


                                    @if (!empty($user->created_at))
                                        <div class="fw-bolder mt-2">Account Created At</div>
                                        <div class="text-gray-600">{{ $user->created_at->format('D, d M Y') }}</div>
                                    @endif

                                </div>
                            </div>


                        </div>

                    </div>


                </div>


                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-custom nav-tabs nav-line-tabs border-0 mb-8">

                                <li class="nav-item">
                                    <a class="nav-link text-active-primary active rounded-2" data-bs-toggle="tab"
                                        href="#kt_user_view_overview_tab">Overview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary rounded-2" data-kt-countup-tabs="true"
                                        data-bs-toggle="tab" href="#kt_user_view_overview_security">Security</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary rounded-2" data-bs-toggle="tab"
                                        href="#kt_user_view_overview_events_and_logs_tab">Account Deactivate/Delete</a>
                                </li>
                            </ul>
                        </div>




                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                                @include('admin.pages.profile.partials.update-profile-information-form')
                            </div>

                            <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">
                                @include('admin.pages.profile.partials.update-password-form')
                            </div>

                            <div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                                @include('admin.pages.profile.partials.delete-user-form')
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-app-layout>
