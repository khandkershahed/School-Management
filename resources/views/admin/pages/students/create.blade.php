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
                                    {{-- <div class="col-lg-3 col-md-6">
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
                                    </div> --}}
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium" class="form-label">Medium <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium" name="medium" :allowClear="true">
                                                <option value="">-- Select Medium --</option>
                                                <option value="Bangla" @selected(old('medium') == 'Bangla')>Bangla</option>
                                                <option value="English" @selected(old('medium') == 'English')>English</option>
                                                <option value="College" @selected(old('medium') == 'College')>College</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true" required>
                                                <option value=""></option>
                                                <option value="kg" @selected(old('class') == 'kg')>KG</option>
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
                                                <option value="12" @selected(old('class') == '12')>Second Year
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="section" class="form-label">Section <span class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="section" name="section" :allowClear="true" required>
                                                <option value="">Select Section</option>
                                                @foreach (range('A', 'N') as $section)
                                                    <option value="{{ $section }}" @selected(old('section') == $section)>{{ $section }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="student_type" class="form-label">Student Type <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="student_type"
                                                name="student_type" data-placeholder="Select Student Type" :allowClear="true" required>
                                                <option value="old" @selected(old('student_type') == 'old')>Old</option>
                                                <option value="new" @selected(old('student_type') == 'new')>New</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="gender" class="form-label">Gender <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="gender"
                                                name="gender" :allowClear="true" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male" @selected(old('gender') == 'Male')>Male</option>
                                                <option value="Female" @selected(old('gender') == 'Female')>Female</option>
                                                <option value="Other" @selected(old('gender') == 'Other')>Other</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="year" class="form-label">Year<span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="year" name="year" :allowClear="true"
                                                required>
                                                <option value="">Select Year</option>
                                                @for ($year = 2025; $year <= 2030; $year++)
                                                    <option value="{{ $year }}" @selected(old('year') == $year)>
                                                        {{ $year }}</option>
                                                @endfor
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="group" class="form-label">Group<span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="group" name="group" :allowClear="true"
                                                required>
                                                <option value="">Select Group</option>
                                                <option value="Science" @selected(old('group') == 'Science')>Science</option>
                                                <option value="Arts" @selected(old('group') == 'Arts')>Arts</option>
                                                <option value="Commerce" @selected(old('group') == 'Commerce')>Commerce
                                                </option>
                                                <option value="Day" @selected(old('group') == 'Day')>Day</option>
                                                <option value="Morning" @selected(old('group') == 'Morning')>Morning</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll No</x-admin.label>
                                            <x-admin.input type="number" :value="old('roll')" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="guardian_name" class="form-label">Father's
                                                    Name <span class="text-danger">*</span></x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_name" type="text"
                                                        name="guardian_name" :value="old('guardian_name')" class="form-control"
                                                        autofocus>
                                                    </x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="guardian_contact" class="form-label">Father's
                                                    Contact Number <span class="text-danger">*</span></x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_contact" type="text"
                                                        name="guardian_contact" :value="old('guardian_contact')"
                                                        class="form-control" autofocus>
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
                                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <x-admin.textarea class="form-control text-area-input"
                                                placeholder="Write Here" id="address" name="address"
                                                rows="3">
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
