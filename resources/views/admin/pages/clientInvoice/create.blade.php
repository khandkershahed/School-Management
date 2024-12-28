<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Client Invoice</h4>
                                <a href="{{ route('admin.client-invoice.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.client-invoice.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="client" class="form-label">Client</label>
                                            <x-admin.select-option id="client" name="client" :allowClear="true">
                                                <option value="">-- Select Client --</option>
                                                @foreach ($clients as $client)
                                                    <option value="Walking Customer">Walking Customer</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="clientInvoiceTotal" class="form-label"> Invoice
                                                Total</x-admin.label>
                                            <x-admin.input type="text" :value="old('clientInvoiceTotal')" id="clientInvoiceTotal"
                                                name="clientInvoiceTotal" required
                                                placeholder="28836.5"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="clientTotalPaid" class="form-label"> Total
                                                Paid</x-admin.label>
                                            <x-admin.input type="text" :value="old('clientTotalPaid')" id="clientTotalPaid"
                                                name="clientTotalPaid" required placeholder="35000"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="clientDue" class="form-label"> Total Due</x-admin.label>
                                            <x-admin.input type="text" :value="old('clientDue')" id="clientDue"
                                                name="clientDue" required placeholder="35000"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="invoice" class="form-label">Select Invoice</label>
                                            <x-admin.select-option id="invoice" name="invoice" :allowClear="true">
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
                                            <x-admin.label for="totalPayment" class="form-label"> Total
                                                Payment</x-admin.label>
                                            <x-admin.input type="text" :value="old('totalPayment')" id="totalPayment"
                                                name="totalPayment" required placeholder="35000"></x-admin.input>
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
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <x-admin.label for="chequeNo" class="form-label">Cheque No
                                                Balance</x-admin.label>
                                            <x-admin.input type="text" :value="old('chequeNo')" id="chequeNo"
                                                name="chequeNo" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <x-admin.label for="receiptNo" class="form-label">Receipt No
                                                Balance</x-admin.label>
                                            <x-admin.input type="text" :value="old('receiptNo')" id="receiptNo"
                                                name="receiptNo" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <x-admin.label for="date" class="form-label"> Date</x-admin.label>
                                            <x-admin.input type="date" :value="old('date')" id="date"
                                                name="date" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea class="form-control text-area-input" id="note" name="note" rows="3"
                                                placeholder="write your note here"></textarea>
                                        </div>
                                    </div>
                                    <!-- Switch for Send Email Notification -->
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Send Email Notification</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                id="sendEmailNotification" name="send_email_notification">
                                            <label class="form-check-label" for="sendEmailNotification">Enable</label>
                                        </div>
                                    </div>

                                    <!-- Switch for Send SMS Notification -->
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Send SMS Notification</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="sendSmsNotification"
                                                name="send_sms_notification">
                                            <label class="form-check-label" for="sendSmsNotification">Enable</label>
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
