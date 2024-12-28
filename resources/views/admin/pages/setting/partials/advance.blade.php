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
            <input class="form-check-input" type="checkbox" value="1" name="user_verification"
                id="user_verification" {{ old('user_verification', optional($setting)->user_verification) == '1' ? 'checked' : '' }} />
            <x-admin.label class="form-check-label pt-0 pt-lg-2 ps-3" for="user_verification">
                User Verification Checking
            </x-admin.label>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="mb-10">
            <x-admin.label class="form-label">Minimum Order Amount(Min: 0)</x-admin.label>
            <x-admin.input type="number" name="minimum_order_amount" id="minimum_order_amount"
                min="0" class="form-control mb-2" placeholder="User Minimum Order Amount"
                :value="old('minimum_order_amount', optional($setting)->minimum_order_amount)">
            </x-admin.file-input>
        </div>
    </div>
</div>
