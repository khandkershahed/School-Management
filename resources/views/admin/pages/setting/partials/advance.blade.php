<div class="row">
    <div class="col-lg-12">
        <div class="py-3 bg-light">
            <h5 class="text-center">Advance Information</h5>
        </div>
    </div>
</div>
<div class="row align-items-center p-5">
    <div class="col-xl-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="maintenance_mode"
                id="maintenance_mode" {{ old('maintenance_mode', optional($setting)->maintenance_mode) == '1' ? 'checked' : '' }} />
            <x-admin.label class="form-check-label pt-0 pt-lg-2 ps-3" for="maintenance_mode">
                Maintenance Mode
            </x-admin.label>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="mb-10">
            <x-admin.label class="form-label">Maintenance Message</x-admin.label>
            <x-admin.input type="text" name="maintenance_message" id="maintenance_message"
                min="0" class="form-control mb-2" placeholder="Maintenance Message"
                :value="old('maintenance_message', optional($setting)->maintenance_message)">
            </x-admin.file-input>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3">
            <x-admin.label for="additional_script" class="form-label">{{ __('Additional Script') }}
            </x-admin.label>
            <textarea name="additional_script" id="additional_script" cols="1" rows="3" class="form-control"
                placeholder="Enter Additional Script'">{!! $setting ? $setting->additional_script : '' !!}</textarea>
        </div>
    </div>
</div>
