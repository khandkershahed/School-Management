<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Adjustment</h4>
                                <a href="{{ route('admin.balance-adjustment.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST"
                                action="{{ route('admin.balance-adjustment.update', $balanceAdjustment->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Use PUT method for updates -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label for="account_id" class="form-label">Account</label>
                                            <x-admin.select-option id="account_id" name="account_id" :allowClear="true">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" @selected(old('account_id', $balanceAdjustment->account_id) == $account->id)
                                                        data-balance="{{ $account->availableBalance() }}">
                                                        {{ $account->bank_name }}[{{ $account->account_number }}]
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <x-admin.select-option id="type" name="type" :allowClear="true">
                                                <option value="1" @selected(old('type', $balanceAdjustment->type) == 1)>Add Balance</option>
                                                <option value="0" @selected(old('type', $balanceAdjustment->type) == 0)>Remove Balance
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="availableBalance" class="form-label">Available
                                                Balance</x-admin.label>
                                            <input class="form-control form-control-solid" type="text"
                                                value="{{ old('availableBalance', $account->availableBalance()) }}"
                                                id="availableBalance" name="availableBalance" readonly></input>
                                            @error('availableBalance')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label">Amount</x-admin.label>
                                            <x-admin.input type="text" :value="old('amount', $balanceAdjustment->amount)" id="amount"
                                                name="amount" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label">Date</x-admin.label>
                                            <x-admin.input type="date" :value="old('date', $balanceAdjustment->transaction_date)" id="date"
                                                name="date" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active" @selected(old('status', $balanceAdjustment->status) == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status', $balanceAdjustment->status) == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                                placeholder="Write your note here">{{ old('note', $balanceAdjustment->note) }}</textarea>
                                            @error('note')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Update Balance
                                    <i class="fa-regular fa-floppy-disk ps-2"></i>
                                </x-admin.button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#account').on('change', function(e) {
                    const selectedOption = $(this).find('option:selected');
                    const availableBalance = selectedOption.data('balance');
                    // alert(availableBalance);
                    $('#availableBalance').val(availableBalance);
                });
            });
        </script>
    @endpush
</x-admin-app-layout>
