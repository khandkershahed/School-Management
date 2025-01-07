<x-admin-app-layout :title="'Create fee'">
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create fee</h4>
                                <a href="{{ route('admin.fees.index') }}" class="btn-common-one text-white" tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="feeForm" method="POST" action="{{ route('admin.fees.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name" name="name" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label">Amount <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="number" step="0.01" :value="old('amount')" id="amount" name="amount" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium" class="form-label">Medium <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium" name="medium" :allowClear="true" required>
                                                <option value="">-- Select Medium --</option>
                                                <option value="Bangla" @selected(old('medium') == 'Bangla')>Bangla</option>
                                                <option value="English" @selected(old('medium') == 'English')>English</option>
                                                <option value="College" @selected(old('medium') == 'College')>College</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class_id" class="form-label">Class <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class" name="class[]" :allowClear="true" multiple required>
                                                <option value=""></option>
                                                <option value="0" @selected(old('class') == '0')>Nursery</option>
                                                <option value="1" @selected(old('class') == '1')>One</option>
                                                <option value="2" @selected(old('class') == '2')>Two</option>
                                                <option value="3" @selected(old('class') == '3')>Three</option>
                                                <option value="4" @selected(old('class') == '4')>Four</option>
                                                <option value="5" @selected(old('class') == '5')>Five</option>
                                                <option value="6" @selected(old('class') == '6')>Six</option>
                                                <option value="7" @selected(old('class') == '7')>Seven</option>
                                                <option value="8" @selected(old('class') == '8')>Eight</option>
                                                <option value="9" @selected(old('class') == '9')>Nine</option>
                                                <option value="10" @selected(old('class') == '10')>Ten</option>
                                                <option value="11" @selected(old('class') == '11')>First Year</option>
                                                <option value="12" @selected(old('class') == '12')>Second Year</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="fee_type" class="form-label">Fee Type <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="fee_type" name="fee_type" :allowClear="true" required>
                                                <option value="">-- Select Fee type --</option>
                                                <option value="yearly" @selected(old('fee_type') == 'yearly')>Yearly</option>
                                                <option value="monthly" @selected(old('fee_type') == 'monthly')>Monthly</option>
                                                <option value="recurring" @selected(old('fee_type') == 'recurring')>Recurring</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="status" class="form-label">Status <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true" required>
                                                <option value="active" @selected(old('status') == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.button type="submit" class="">Create fee
                                                <i class="fa-regular fa-floppy-disk ps-2"></i>
                                            </x-admin.button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Validation Script -->

</x-admin-app-layout>
