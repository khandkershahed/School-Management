
<x-admin-app-layout> 
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Transfer</h4>
                                <a href="{{ route('admin.balance-transfer.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.balance-transfer.update', $balanceTransfer->slug) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Use PUT method for updates -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="transferReason" class="form-label">Transfer Reason</x-admin.label>
                                            <x-admin.input type="text" :value="old('transferReason', $balanceTransfer->reason)" id="transferReason" name="transferReason" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label for="from_account_id" class="form-label">From Account</label>
                                            <x-admin.select-option id="from_account_id" name="fromAccount" :allowClear="true" readonly>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" @selected(old('fromAccount', $balanceTransfer->debitTransaction->account_id) == $account->id) data-balance="{{ $account->availableBalance() }}">
                                                        {{ $account->bank_name }}[{{ $account->account_number }}]
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label for="toAccount" class="form-label">To Account</label>
                                            <x-admin.select-option id="toAccount" name="toAccount" :allowClear="true" readonly>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" @selected(old('toAccount', $balanceTransfer->creditTransaction->account_id) == $account->id) data-balance="{{ $account->availableBalance() }}">
                                                        {{ $account->bank_name }}[{{ $account->account_number }}]
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="availableBalance" class="form-label">Available Balance</x-admin.label>
                                            <input class="form-control form-control-solid" type="text" value="{{ old('availableBalance') }}" id="availableBalance" name="availableBalance" readonly>
                                            @error('availableBalance')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label">Amount</x-admin.label>
                                            <x-admin.input type="number" :value="old('amount', $balanceTransfer->amount)" id="amount" name="amount" required readonly></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label">Date</x-admin.label>
                                            <x-admin.input type="date" :value="old('date', $balanceTransfer->date)" id="date" name="date" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active" @selected(old('status', $balanceTransfer->status) == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status', $balanceTransfer->status) == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3" placeholder="Write your note here">{{ old('note', $balanceTransfer->note) }}</textarea>
                                            @error('note')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Update Transfer <i class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
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
                // Initialize Select2
                // $('#account_id').select2();

                // Listen for the Select2 select event
                $('#from_account_id').on('change', function(e) {
                    const selectedOption = $(this).find('option:selected');
                    const availableBalance = selectedOption.data('balance');
                    // alert(availableBalance);
                    $('#availableBalance').val(availableBalance);
                });
            });
        </script>
    @endpush
</x-admin-app-layout>
