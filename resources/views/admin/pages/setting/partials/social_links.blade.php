<div class="row">
    <div class="col-lg-12">
        <div class="py-3 bg-light">
            <h5 class="text-center">Site Social Information</h5>
        </div>
    </div>
</div>
<div class="row p-3">
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2 required"><i class="fs-3 fa-solid fa-globe pe-2"></i>WebSite
                URL</x-admin.label>
            <x-admin.input type="url" name="website_url" value="{{ optional($setting)->website_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="WebSite URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2 required"><i
                    class="fs-3 fa-brands fa-facebook pe-2"></i>Facebook
                URL</x-admin.label>
            <x-admin.input type="url" name="facebook_url" value="{{ optional($setting)->facebook_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Facebook URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2"><i class="fs-3 fa-brands fa-twitter pe-2"></i>Twitter
                URL</x-admin.label>
            <x-admin.input type="url" name="twitter_url" value="{{ optional($setting)->twitter_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Twitter URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2"><i class="fs-3 fa-brands fa-instagram pe-2"></i>Instagram
                URL</x-admin.label>
            <x-admin.input type="url" name="instagram_url" value="{{ optional($setting)->instagram_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Instagram URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2"><i class="fs-3 fa-brands fa-youtube pe-2"></i>Youtube
                URL</x-admin.label>
            <x-admin.input type="url" name="youtube_url" value="{{ optional($setting)->youtube_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Youtube URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2 required"><i
                    class="fs-3 fa-brands fa-linkedin pe-2 "></i>{{ __('Linkedin URL') }}</x-admin.label>
            <x-admin.input type="url" name="linkedin_url" value="{{ optional($setting)->linkedin_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Linkedin URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2"><i
                    class="fs-3 fa-brands fa-whatsapp pe-2"></i>{{ __('Whats App URL') }}</x-admin.label>
            <x-admin.input type="url" name="whatsapp_url" value="{{ optional($setting)->whatsapp_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="What's App URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2"><i
                    class="fs-3 fa-brands fa-pinterest pe-2"></i>{{ __('Pinterest URL') }}</x-admin.label>
            <x-admin.input type="url" name="pinterest_url" value="{{ optional($setting)->pinterest_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Pinterest URL" />
        </div>
    </div>
    <div class="fv-row col-lg-4">
        <div class="mb-3">
            <x-admin.label class="fw-semibold fs-6 mb-2"><i
                    class="fs-3 fa-brands fa-tiktok pe-2"></i>{{ __('Tiktok URL') }}</x-admin.label>
            <x-admin.input type="url" name="youtube_url" value="{{ optional($setting)->youtube_url }}"
                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Youtube URL" />
        </div>
    </div>
</div>
