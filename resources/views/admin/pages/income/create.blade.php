<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Income</h4>
                                <a href="{{ route('admin.income.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.income.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.label for="reason" class="form-label">Income
                                                Reason</x-admin.label>
                                            <x-admin.input type="text" :value="old('reason')" id="reason"
                                                name="reason" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="sub_cat_id" class="form-label">Category Name</label>
                                            <x-admin.select-option id="sub_cat_id" name="sub_cat_id" :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected(old('sub_cat_id') == $category->id)>{{ $category->name }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="account_id" class="form-label">Account</label>
                                            <x-admin.select-option id="account_id" name="account_id" :allowClear="true" required>
                                                <option value="">-- Select Account --</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)
                                                        data-balance="{{ $account->availableBalance() }}">
                                                        {{ $account->bank_name }}[{{ $account->account_number }}]
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="availableBalance" class="form-label"> Available
                                                Balance</x-admin.label>
                                            <input class="form-control form-control-solid " type="text"
                                                value="{{ old('availableBalance') }}" id="availableBalance"
                                                name="availableBalance" readonly></input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label"> Amount
                                                Balance</x-admin.label>
                                            <x-admin.input type="number" :value="old('amount')" id="amount"
                                                name="amount" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="chequeNo" class="form-label"> Cheque No
                                                Balance</x-admin.label>
                                            <x-admin.input type="text" :value="old('chequeNo')" id="chequeNo"
                                                name="chequeNo" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="voucherNo" class="form-label"> Voucher
                                                No</x-admin.label>
                                            <x-admin.input type="text" :value="old('voucherNo')" id="voucherNo"
                                                name="voucherNo" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label"> Date</x-admin.label>
                                            <x-admin.input type="date" :value="old('date')" id="date"
                                                name="date" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active" @selected(old('status') == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label"> Image</x-admin.label>
                                            <x-admin.input type="file" :value="old('image')" id="image"
                                                name="image" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                                placeholder="write your note here">{{ old('note') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Save Income <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
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
                $('#account_id').on('change', function(e) {
                    const selectedOption = $(this).find('option:selected');
                    const availableBalance = selectedOption.data('balance');
                    // alert(availableBalance);
                    $('#availableBalance').val(availableBalance);
                });
            });
        </script>
    @endpush
</x-admin-app-layout>
