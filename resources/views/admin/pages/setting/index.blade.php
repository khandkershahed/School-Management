<x-admin-app-layout :title="'Website Setting'">
    <div class="container-fluid py-3" id="columns-container">
        <div class="row">
            <div class="col-lg-2">
                <div class="custom-fixed-top">
                    <div class="d-flex flex-column flex-md-row rounded border bg-white">
                        @include('admin.pages.setting.partials.tab_trigger')
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="card">
                    <form class="form card-body pt-0 px-0" action="{{ route('admin.settings.updateOrCreate') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="tab-content bg-white" id="myTabContent">
                                <div class="tab-pane fade active show" id="generalInfo" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 general_info_container">
                                            @include('admin.pages.setting.partials.general_info')
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="footer" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 footer_container">
                                            @include('admin.pages.setting.partials.footer')
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="businessHours" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 business_hours_container">
                                            @include('admin.pages.setting.partials.business_hours')
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade" id="companies" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 company_container">
                                            @include('admin.pages.setting.partials.companies')
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="tab-pane fade" id="services" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 service_container">
                                            {{-- @include('admin.pages.setting.partials.services') --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="products" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 product_container">
                                            {{-- @include('admin.pages.setting.partials.products') --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="galleries" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 gallery_container">
                                            {{-- @include('admin.pages.setting.partials.galleries') --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="banner" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 banner_container">
                                            {{-- @include('admin.pages.setting.partials.banner') --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="testimonials" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 testimonial_container">
                                            {{-- @include('admin.pages.setting.partials.testimonials') --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="seo" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 seo_container">
                                            @include('admin.pages.setting.partials.seo')
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="socialLinks" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 social_links_container">
                                            @include('admin.pages.setting.partials.social_links')
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="privacy" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 privacy_container">
                                            {{-- @include('admin.pages.setting.partials.privacy') --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="terms" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 terms_container">
                                            {{-- @include('admin.pages.setting.partials.terms') --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="fonts" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 fonts_container">
                                            {{-- @include('admin.pages.setting.partials.fonts') --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade" id="kt_vtab_pane_15" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12 terms_container">
                                                @include('admin.pages.setting.partials.terms')
                                            </div>
                                        </div>
                                </div> --}}
                                <div class="tab-pane fade" id="advance" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 advance_container">
                                            @include('admin.pages.setting.partials.advance')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="setting" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 setting_container">
                                            {{-- @include('admin.pages.setting.partials.setting') --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-btn-info">
                                <div class="mt-1 me-3">
                                    <x-admin.button type="submit" class="primary">
                                        {{ __('Save Settings ') }}
                                    </x-admin.button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-admin-app-layout>
