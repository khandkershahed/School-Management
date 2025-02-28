<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="py-3 bg-light">
                <h5 class="text-center">Website Information</h5>
            </div>
        </div>
    </div>
    <div class="row p-3 align-items-center">
        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="site_name" class="form-label">{{ __('Website Name') }}
                </x-admin.label>
                <x-admin.input id="site_name" type="text" name="site_name" :value="old('site_name', optional($setting)->site_name)"
                    placeholder="Site Name"></x-admin.input>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="site_motto" class="form-label">{{ __('Site Slogan') }}
                </x-admin.label>

                <x-admin.input id="site_motto" type="text" name="site_motto" :value="old('site_motto', optional($setting)->site_motto)"
                    placeholder="Site Name"></x-admin.input>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="contact_email" class="form-label">{{ __('Contact Email') }}
                </x-admin.label>

                <x-admin.input id="contact_email" type="email" name="contact_email" :value="old('contact_email', optional($setting)->contact_email)"
                    placeholder="Contact email address"></x-admin.input>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="support_email" class="form-label">{{ __('Support Email') }}
                </x-admin.label>

                <x-admin.input id="support_email" type="email" name="support_email" :value="old('support_email', optional($setting)->support_email)"
                    placeholder="Support Email address"></x-admin.input>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="info_email" class="form-label">{{ __('Info Email') }}
                </x-admin.label>

                <x-admin.input id="info_email" type="email" name="info_email" :value="old('info_email', optional($setting)->info_email)"
                    placeholder="Info Email address"></x-admin.input>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="sales_email" class="form-label">{{ __('Sales Email') }}
                </x-admin.label>

                <x-admin.input id="sales_email" type="email" name="sales_email" :value="old('sales_email', optional($setting)->sales_email)"
                    placeholder="Sales Email address"></x-admin.input>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="phone_one" class="form-label">{{ __('Primary Phone') }}
                </x-admin.label>

                <x-admin.input id="phone_one" type="text" name="phone_one" :value="old('phone_one', optional($setting)->phone_one)"
                    placeholder="Primary phone"></x-admin.input>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="mb-3">
                <x-admin.label for="phone_two" class="form-label">{{ __('Alternative Phone') }}
                </x-admin.label>

                <x-admin.input id="phone_two" type="text" name="phone_two" :value="old('phone_two', optional($setting)->phone_two)"
                    placeholder="Alternative phone"></x-admin.input>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <x-admin.label for="address_line_one" class="form-label">{{ __('Address Line One') }}
                </x-admin.label>
                <textarea name="address_line_one" id="address_line_one" cols="1" rows="3" class="form-control"
                    placeholder="Enter Address Line One">{!! $setting ? $setting->address_line_one : '' !!}</textarea>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <x-admin.label for="address_line_two" class="form-label">{{ __('Address Line Two') }}
                </x-admin.label>
                <textarea name="address_line_two" id="address_line_two" cols="1" rows="3" class="form-control"
                    placeholder="Enter Address Line Two'">{!! $setting ? $setting->address_line_two : '' !!}</textarea>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <x-admin.label for="site_white_logo"
                    class="form-label">{{ __('Site Logo White (For Colorful Background)') }}
                </x-admin.label>

                <x-admin.file-input id="site_white_logo" name="site_white_logo" :source="asset('storage/' . optional($setting)->site_white_logo)"
                    :value="old('site_white_logo', optional($setting)->site_white_logo)"></x-admin.file-input>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <x-admin.label for="site_black_logo"
                    class="form-label">{{ __('Site Logo Colorful (For White Background)') }}
                </x-admin.label>

                <x-admin.file-input id="site_black_logo" name="site_black_logo" :source="asset('storage/' . optional($setting)->site_black_logo)"
                    :value="old('site_black_logo', optional($setting)->site_black_logo)"></x-admin.file-input>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <x-admin.label for="site_favicon" class="form-label">{{ __('Site Favicon') }}
                </x-admin.label>

                <x-admin.file-input id="site_favicon" type="file" name="site_favicon" :source="asset('storage/' . optional($setting)->site_favicon)"
                    :value="old('site_favicon', optional($setting)->site_favicon)"></x-admin.file-input>
            </div>
        </div>
    </div>
</div>
