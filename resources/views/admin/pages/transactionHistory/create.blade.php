<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Transaction History</h4>
                                <a href="{{ route('admin.transaction-history.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.transaction-history.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.label for="reason" class="form-label">Expense
                                                Reason</x-admin.label>
                                            <x-admin.input type="text" :value="old('reason')" id="reason"
                                                name="reason" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="subCategory" class="form-label">Category Name</label>
                                            <x-admin.select-option id="subCategory" name="subCategory"
                                                :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                <option value="Office Rent">Office Rent</option>
                                                <option value="Office Stationary">Office Stationary</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="subCategory" class="form-label">Account</label>
                                            <x-admin.select-option id="subCategory" name="subCategory"
                                                :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                <option value="Cash[CASH-0001]">Cash[CASH-0001]</option>
                                                <option value="Dutch Bangla Bank[DBBL-0003]">Dutch Bangla
                                                    Bank[DBBL-0003]</option>
                                                <option value="Islami Bank Bangladesh Ltd[IBBL-0002]">Islami Bank
                                                    Bangladesh Ltd[IBBL-0002]</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="availableBalance" class="form-label"> Available
                                                Balance</x-admin.label>
                                            <x-admin.input type="text" :value="old('availableBalance')" id="availableBalance"
                                                name="availableBalance" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label"> Amount
                                                Balance</x-admin.label>
                                            <x-admin.input type="text" :value="old('amount')" id="amount"
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
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label"> Image</x-admin.label>
                                            <x-admin.input type="file" :value="old('image')" id="image"
                                                name="image" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                                placeholder="write your note here"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Save Expence <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
