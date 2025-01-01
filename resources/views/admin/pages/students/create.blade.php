<x-admin-app-layout :title="'Student Create'">
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Student</h4>
                                <a href="{{ route('admin.students.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.students.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name"
                                                name="name" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium_id" class="form-label">Medium <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium_id" name="medium_id" :allowClear="true">
                                                <option value="">-- Select medium --</option>
                                                <!-- Default Option -->
                                                @foreach ($mediums as $medium)
                                                    <option value="{{ $medium->id }}"
                                                        {{ old('medium_id') == $medium->id ? 'selected' : '' }}>
                                                        {{ $medium->name }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium_id" class="form-label">Medium <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium_id" name="medium_id" :allowClear="true">
                                                <option value="">-- Select Medium --</option>
                                                <!-- Default Option -->
                                                @foreach ($mediums as $medium)
                                                    <option value="{{ $medium->id }}"
                                                        {{ old('medium_id') == $medium->id ? 'selected' : '' }}>
                                                        {{ $medium->name }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class" name="class" :allowClear="true"
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
                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="section" class="form-label">Section <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="section" name="section" :allowClear="true"
                                                required>
                                                <option value=""></option>
                                                <option value="nursery" @selected(old('class') == 'a')>A</option>
                                                <option value="one" @selected(old('class') == 'b')>B</option>
                                                <option value="two" @selected(old('class') == 'c')>C</option>
                                                <option value="three" @selected(old('class') == 'd')>D</option>
                                                <option value="four" @selected(old('class') == 'e')>E</option>
                                                <option value="five" @selected(old('class') == 'f')>F</option>
                                                <option value="six" @selected(old('class') == 'g')>G</option>
                                                <option value="seven" @selected(old('class') == 'h')>H</option>
                                                <option value="eight" @selected(old('class') == 'i')>I</option>
                                                <option value="nine" @selected(old('class') == 'j')>J</option>
                                                <option value="ten" @selected(old('class') == 'k')>K</option>
                                                <option value="first_year" @selected(old('class') == 'l')>L</option>
                                                <option value="second_year" @selected(old('class') == 'm')>M</option>
                                                <option value="second_year" @selected(old('class') == 'n')>N</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="gender" class="form-label">Gender <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="gender" name="gender" :allowClear="true"
                                                required>
                                                <option value=""></option>
                                                <option value="male" @selected(old('class') == 'male')>Male</option>
                                                <option value="female" @selected(old('class') == 'female')>Female</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="group" class="form-label">Group <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="group" name="group" :allowClear="true"
                                                required>
                                                <option value="science" @selected(old('group') == 'science')>Science</option>
                                                <option value="arts" @selected(old('group') == 'arts')>Arts</option>
                                                <option value="commerce" @selected(old('group') == 'commerce')>Commerce</option>
                                                <option value="day" @selected(old('group') == 'day')>Day</option>
                                                <option value="morning" @selected(old('group') == 'morning')>Morning</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll No</x-admin.label>
                                            <x-admin.input type="text" :value="old('roll')" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="guardian_name" class="font-weight-bold text-dark">Father's
                                                    Name <span class="text-danger">*</span></x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_name" type="text" name="guardian_name"
                                                        :value="old('guardian_name')" class="form-control" autofocus>
                                                    </x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="guardian_contact" class="font-weight-bold text-dark">Father's
                                                    Contact Number <span class="text-danger">*</span></x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_contact" type="text" name="guardian_contact"
                                                        :value="old('guardian_contact')" class="form-control" autofocus>
                                                    </x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label">Image</x-admin.label>
                                            <x-admin.file-input type="file" :value="old('image')" id="image"
                                                name="image" required></x-admin.file-input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true"
                                                required>
                                                <option value="active" @selected(old('status') == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <x-admin.textarea class="form-control text-area-input"
                                                placeholder="Write Here" id="address" name="address" rows="3">
                                                {{ old('address') }}
                                            </x-admin.textarea>
                                        </div>
                                    </div>

                                </div>
                                <x-admin.button type="submit" class="">Create student
                                    <i class="fa-regular fa-floppy-disk ps-2"></i>
                                </x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
