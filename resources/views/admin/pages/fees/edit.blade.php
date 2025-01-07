<x-admin-app-layout :title="'Edit fee'">
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Edit fee</h4>
                                <a href="{{ route('admin.fees.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.fees.update', $fee->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name', $fee->name)" id="name"
                                                name="name" required></x-admin.input>
                                        </div>
                                    </div>



                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label">Amount <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="number" step="0.01" :value="old('amount', $fee->amount)"
                                                id="amount" name="amount" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium" class="form-label">Medium <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium" name="medium" :allowClear="true">
                                                <option value="">-- Select Medium --</option>
                                                <option value="Bangla" @selected(old('medium', $fee->medium) == 'Bangla')>Bangla</option>
                                                <option value="English" @selected(old('medium', $fee->medium) == 'English')>English</option>
                                                <option value="College" @selected(old('medium', $fee->medium) == 'College')>College</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            @php
                                                $classes = isset($fee->class) ? json_decode($fee->class, true) : [];
                                            @endphp
                                            <x-admin.label for="class_id" class="form-label">Class <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class[]" :allowClear="true" multiple required>
                                                <option value=""></option>
                                                <option value="nursery" @selected(is_array($classes) && in_array('nursery', $classes))>Nursery </option>
                                                <option value="1" @selected(is_array($classes) && in_array('1', $classes))>One </option>
                                                <option value="2" @selected(is_array($classes) && in_array('2', $classes))>Two</option>
                                                <option value="3" @selected(is_array($classes) && in_array('3', $classes))>Three </option>
                                                <option value="4" @selected(is_array($classes) && in_array('4', $classes))>Four </option>
                                                <option value="5" @selected(is_array($classes) && in_array('5', $classes))>Five </option>
                                                <option value="6" @selected(is_array($classes) && in_array('6', $classes))>Six </option>
                                                <option value="7" @selected(is_array($classes) && in_array('7', $classes))>Seven </option>
                                                <option value="8" @selected(is_array($classes) && in_array('8', $classes))>Eight </option>
                                                <option value="9" @selected(is_array($classes) && in_array('9', $classes))>Nine</option>
                                                <option value="10" @selected(is_array($classes) && in_array('10', $classes))>Ten </option>
                                                <option value="11" @selected(is_array($classes) && in_array('11', $classes))>First Year
                                                </option>
                                                <option value="12" @selected(is_array($classes) && in_array('12', $classes))>Second Year
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true"
                                                required>
                                                <option value="active" @selected(old('status', $fee->status) == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status', $fee->status) == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="fee_type" class="form-label">Fee Type <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="fee_type" name="fee_type" :allowClear="true" required>
                                                <option value="">-- Select Fee type --</option>
                                                <option value="yearly" @selected(old('fee_type', $fee->fee_type) == 'yearly')>Yearly</option>
                                                <option value="monthly" @selected(old('fee_type', $fee->fee_type) == 'monthly')>Monthly</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.button type="submit" class="">Edit fee
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
</x-admin-app-layout>
