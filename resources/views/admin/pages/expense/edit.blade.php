<x-admin-app-layout>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <form method="POST" action="{{ route('admin.expense.update', $expense->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <x-admin.label for="reason" class="form-label">Expense Reason</x-admin.label>
                                <x-admin.input type="text" :value="old('reason', $expense->reason)" id="reason" name="reason"
                                    required></x-admin.input>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="sub_cat_id" class="form-label">Category Name</label>
                                <x-admin.select-option id="sub_cat_id" name="sub_cat_id" :allowClear="true">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('sub_cat_id', $expense->sub_cat_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </x-admin.select-option>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="account_id" class="form-label">Account</label>
                                <x-admin.select-option id="account_id" name="account_id" :allowClear="true">
                                    <option value="">-- Select Account --</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" @selected(old('account_id', optional($expense->expTransaction)->account_id) == $account->id)
                                            data-balance="{{ $account->availableBalance() }}">
                                            {{ $account->bank_name }}[{{ $account->account_number }}]
                                        </option>
                                    @endforeach
                                </x-admin.select-option>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <x-admin.label for="availableBalance" class="form-label">Available
                                    Balance</x-admin.label>
                                <input class="form-control form-control-solid" type="text"
                                    value="{{ old('availableBalance', optional($expense->expTransaction)->cashbookAccount->availableBalance()) }}"
                                    id="availableBalance" name="availableBalance" readonly></input>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <x-admin.label for="amount" class="form-label">Amount</x-admin.label>
                                <x-admin.input type="number" :value="old('amount', optional($expense->expTransaction)->amount)" id="amount" name="amount"
                                    required></x-admin.input>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <x-admin.label for="chequeNo" class="form-label">Cheque No</x-admin.label>
                                <x-admin.input type="text" :value="old('chequeNo', optional($expense->expTransaction)->cheque_no)" id="chequeNo" name="chequeNo"
                                    required></x-admin.input>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <x-admin.label for="voucherNo" class="form-label">Voucher No</x-admin.label>
                                <x-admin.input type="text" :value="old('voucherNo', optional($expense->expTransaction)->receipt_no)" id="voucherNo" name="voucherNo"
                                    required></x-admin.input>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <x-admin.label for="date" class="form-label">Date</x-admin.label>
                                <x-admin.input type="date" :value="old('date', $expense->date)" id="date" name="date"
                                    required></x-admin.input>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <x-admin.select-option id="status" name="status" :allowClear="true">
                                    <option value="active" @selected(old('status', $expense->status) == 'active')>Active</option>
                                    <option value="inactive" @selected(old('status', $expense->status) == 'inactive')>Inactive</option>
                                </x-admin.select-option>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <x-admin.label for="image" class="form-label">Image</x-admin.label>
                                <x-admin.file-input type="file" id="image" :source="asset('srorage/'.$expense->image)" name="image"></x-admin.file-input>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="note" class="form-label">Note</label>
                                <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                    placeholder="write your note here">{{ old('note', $expense->note) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <x-admin.button type="submit" class="">Update Expense <i
                            class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                </form>



            </div>
            <!-- /.row (main row) -->
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
                    $('#availableBalance').val(availableBalance);
                });
            });
        </script>
    @endpush
</x-admin-app-layout>
