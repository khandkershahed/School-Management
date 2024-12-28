<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Payroll</h4>
                                <a href="{{ route('admin.payroll.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.payroll.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="employee" class="form-label">Employee</label>
                                            <x-admin.select-option id="employee" name="employee" :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                <option value="Walking Customer">Walking Customer</option>
                                                <option value="Ruth Miles">Ruth Miles</option>
                                                <option value=" Reed Montoya"> Reed Montoya</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="salaryMonth" class="form-label">Salary Month</label>
                                            <x-admin.select-option id="salaryMonth" name="salaryMonth"
                                                :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="mobileBill" class="form-label"> Mobile
                                                Bill</x-admin.label>
                                            <x-admin.input type="text" :value="old('mobileBill')" id="mobileBill"
                                                name="mobileBill" required
                                                placeholder="Enter Mobile Bill"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="foodBill" class="form-label">Food Bill</x-admin.label>
                                            <x-admin.input type="text" :value="old('foodBill')" id="foodBill"
                                                name="foodBill" required placeholder="Enter Food Bill"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="bonus" class="form-label">Bonus</x-admin.label>
                                            <x-admin.input type="text" :value="old('bonus')" id="bonus"
                                                name="bonus" required placeholder="Enter Bonus"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="commission"
                                                class="form-label">Commission</x-admin.label>
                                            <x-admin.input type="text" :value="old('commission')" id="commission"
                                                name="commission" required
                                                placeholder="Enter commission"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="festivalBonus" class="form-label">Festival
                                                Bonus</x-admin.label>
                                            <x-admin.input type="text" :value="old('festivalBonus')" id="festivalBonus"
                                                name="festivalBonus" required
                                                placeholder="Enter festivalBonus"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="travelAllowance" class="form-label">Travel
                                                Allowance(TA)</x-admin.label>
                                            <x-admin.input type="text" :value="old('travelAllowance')" id="travelAllowance"
                                                name="travelAllowance" required
                                                placeholder="Enter travelAllowance"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="others" class="form-label">Others</x-admin.label>
                                            <x-admin.input type="text" :value="old('others')" id="others"
                                                name="others" required placeholder="Enter others"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="advance" class="form-label">Advance</x-admin.label>
                                            <x-admin.input type="text" :value="old('advance')" id="advance"
                                                name="advance" required placeholder="Enter advance"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="totalSalary" class="form-label">Total
                                                Salary</x-admin.label>
                                            <x-admin.input type="text" :value="old('totalSalary')" id="totalSalary"
                                                name="totalSalary" required
                                                placeholder="Enter totalSalary"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
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
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="availableBalance" class="form-label">Available
                                                Balance</x-admin.label>
                                            <x-admin.input type="text" :value="old('availableBalance')" id="availableBalance"
                                                name="availableBalance" required
                                                placeholder="Enter availableBalance"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label">Image</x-admin.label>
                                            <x-admin.input type="file" :value="old('image')" id="image"
                                                name="image" required placeholder="Enter image"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <x-admin.label for="chequeNo" class="form-label">Cheque No</x-admin.label>
                                            <x-admin.input type="text" :value="old('chequeNo')" id="chequeNo"
                                                name="chequeNo" required placeholder="Enter chequeNo"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <x-admin.label for="salaryDate" class="form-label">Salary
                                                Date</x-admin.label>
                                            <x-admin.input type="date" :value="old('salaryDate')" id="salaryDate"
                                                name="salaryDate" required
                                                placeholder="Enter salaryDate"></x-admin.input>
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
                                </div>
                                <x-admin.button type="submit" class="">Save Invoice <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
