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



                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label">Amount <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="number" step="0.01" :value="old('amount', $fee->amount)"
                                                id="amount" name="amount" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium_id" class="form-label">Medium <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium_id" name="medium_id" :allowClear="true"
                                                required>
                                                <option value="">-- Select Medium --</option>
                                                @foreach ($mediums as $medium)
                                                    <option value="{{ $medium->id }}"
                                                        {{ old('medium_id', $fee->medium_id) == $medium->id ? 'selected' : '' }}>
                                                        {{ $medium->name }}
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
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
                                                <option value="one" @selected(is_array($classes) && in_array('one', $classes))>One </option>
                                                <option value="two" @selected(is_array($classes) && in_array('two', $classes))>Two</option>
                                                <option value="three" @selected(is_array($classes) && in_array('three', $classes))>Three </option>
                                                <option value="four" @selected(is_array($classes) && in_array('four', $classes))>Four </option>
                                                <option value="five" @selected(is_array($classes) && in_array('five', $classes))>Five </option>
                                                <option value="six" @selected(is_array($classes) && in_array('six', $classes))>Six </option>
                                                <option value="seven" @selected(is_array($classes) && in_array('seven', $classes))>Seven </option>
                                                <option value="eight" @selected(is_array($classes) && in_array('eight', $classes))>Eight </option>
                                                <option value="nine" @selected(is_array($classes) && in_array('nine', $classes))>Nine</option>
                                                <option value="ten" @selected(is_array($classes) && in_array('ten', $classes))>Ten </option>
                                                <option value="first_year" @selected(is_array($classes) && in_array('first_year', $classes))>First Year </option>
                                                <option value="second_year" @selected(is_array($classes) && in_array('second_year', $classes))>Second Year</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
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
