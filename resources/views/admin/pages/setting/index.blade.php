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


                                <div class="tab-pane fade" id="socialLinks" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 social_links_container">
                                            @include('admin.pages.setting.partials.social_links')
                                        </div>
                                    </div>
                                </div>

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
