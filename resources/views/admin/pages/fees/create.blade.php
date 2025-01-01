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
                            <form method="POST" action="{{ route('admin.fees.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name" name="name" required></x-admin.input>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="description" class="form-label">Description <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.textarea class="form-control" placeholder="Write Here" id="description" name="description" rows="3" required>
                                                {{ old('description') }}
                                            </x-admin.textarea>
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="amount" class="form-label">Amount <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="number" step="0.01" :value="old('amount')" id="amount" name="amount" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium_id" class="form-label">Medium <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium_id" name="medium_id" :allowClear="true" required>
                                                <option value="">-- Select Medium --</option>
                                                @foreach ($mediums as $medium)
                                                    <option value="{{ $medium->id }}" {{ old('medium_id') == $medium->id ? 'selected' : '' }}>
                                                        {{ $medium->name }}
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class_id" class="form-label">Class <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class" name="class[]" :allowClear="true" multiple
                                                required>
                                                <option value=""></option>
                                                <option value="nursery" @selected(old('class') == 'nursery')>Nursery</option>
                                                <option value="one" @selected(old('class') == 'one')>One</option>
                                                <option value="two" @selected(old('class') == 'two')>Two</option>
                                                <option value="three" @selected(old('class') == 'three')>Three</option>
                                                <option value="four" @selected(old('class') == 'four')>Four</option>
                                                <option value="five" @selected(old('class') == 'five')>Five</option>
                                                <option value="six" @selected(old('class') == 'six')>Six</option>
                                                <option value="seven" @selected(old('class') == 'seven')>Seven</option>
                                                <option value="eight" @selected(old('class') == 'eight')>Eight</option>
                                                <option value="nine" @selected(old('class') == 'nine')>Nine</option>
                                                <option value="ten" @selected(old('class') == 'ten')>Ten</option>
                                                <option value="first_year" @selected(old('class') == 'first_year')>First Year</option>
                                                <option value="second_year" @selected(old('class') == 'second_year')>Second Year</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
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
</x-admin-app-layout>
