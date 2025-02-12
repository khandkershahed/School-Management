<x-admin-app-layout :title="'Student Data Edit'">
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Edit Student Data</h4>
                                <a href="{{ route('admin.students.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.students.update', $student->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name', $student->name)" id="name"
                                                name="name" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium" class="form-label">Medium <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium" name="medium" :allowClear="true">
                                                <option value="">-- Select Medium --</option>
                                                <option value="Bangla" @selected(old('medium', $student->medium) == 'Bangla')>Bangla</option>
                                                <option value="English" @selected(old('medium', $student->medium) == 'English')>English</option>
                                                <option value="College" @selected(old('medium', $student->medium) == 'College')>College</option>
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
                                                <option value="00" @selected(old('class', $student->class) == '00')>Nursery</option>
                                                <option value="0" @selected(old('class', $student->class) == '0')>KG</option>
                                                <option value="1" @selected(old('class', $student->class) == '1')>One</option>
                                                <option value="2" @selected(old('class', $student->class) == '2')>Two</option>
                                                <option value="3" @selected(old('class', $student->class) == '3')>Three</option>
                                                <option value="4" @selected(old('class', $student->class) == '4')>Four</option>
                                                <option value="5" @selected(old('class', $student->class) == '5')>Five</option>
                                                <option value="6" @selected(old('class', $student->class) == '6')>Six</option>
                                                <option value="7" @selected(old('class', $student->class) == '7')>Seven</option>
                                                <option value="8" @selected(old('class', $student->class) == '8')>Eight</option>
                                                <option value="9" @selected(old('class', $student->class) == '9')>Nine</option>
                                                <option value="10" @selected(old('class', $student->class) == '10')>Ten</option>
                                                <option value="11" @selected(old('class', $student->class) == '11')>First Year</option>
                                                <option value="12" @selected(old('class', $student->class) == '12')>Second Year
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="section" class="form-label">Section <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="section"
                                                name="section" :allowClear="true" required>
                                                <option value="">Select Section</option>

                                                @php
                                                    // $alphabetSections = range('A', 'N');
                                                    $customSections = [
                                                        'Magpie',
                                                        'Skylark',
                                                        'Kingfisher',
                                                        'Flamingo',
                                                        'Albatross',
                                                        'Lily',
                                                        'Magnolia',
                                                        'Gladiolus',
                                                        'Daisy',
                                                        'Aster',
                                                        'Rose',
                                                        'Sunflower',
                                                        'Marigold',
                                                    ];
                                                    // $sections = array_merge($alphabetSections, $customSections);
                                                @endphp

                                                @foreach ($customSections as $section)
                                                    <option value="{{ $section }}" @selected(old('section', $student->section) == $section)>
                                                        {{ $section }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="student_type" class="form-label">Student Type <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="student_type"
                                                name="student_type" :allowClear="true" required>
                                                <option value="">Select student type</option>
                                                <option value="old" @selected(old('student_type', $student->student_type) == 'old')>Old</option>
                                                <option value="new" @selected(old('student_type', $student->student_type) == 'new')>New</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="gender" class="form-label">Gender <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="gender"
                                                name="gender" :allowClear="true" required>
                                                <option value=""></option>
                                                <option value="Male" @selected(old('gender', $student->gender) == 'Male')>Male</option>
                                                <option value="Female" @selected(old('gender', $student->gender) == 'Female')>Female</option>
                                                <option value="Other" @selected(old('gender', $student->gender) == 'Other')>Other</option>
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
                                            <x-admin.label for="group" class="form-label">Group <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="group" name="group" :allowClear="true"
                                                required>
                                                <option value="Science" @selected(old('group', $student->group) == 'Science')>Science</option>
                                                <option value="Arts" @selected(old('group', $student->group) == 'Arts')>Arts</option>
                                                <option value="Commerce" @selected(old('group', $student->group) == 'Commerce')>Commerce
                                                </option>
                                                <option value="Day" @selected(old('group', $student->group) == 'Day')>Day</option>
                                                <option value="Morning" @selected(old('group', $student->group) == 'Morning')>Morning</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll No</x-admin.label>
                                            <x-admin.input type="number" :value="old('roll', $student->roll)" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <x-admin.label for="guardian_name" class="form-label">Guardian's
                                                    Name </x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_name" type="text"
                                                        name="guardian_name" :value="old('guardian_name', $student->guardian_name)" class="form-control"
                                                        autofocus>
                                                    </x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <x-admin.label for="guardian_contact" class="form-label">Contact
                                                    Number </x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_contact" type="text"
                                                        name="guardian_contact" :value="old('guardian_contact', $student->guardian_contact)"
                                                        class="form-control" autofocus>
                                                    </x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true"
                                                required>
                                                <option value="active" @selected(old('status', $student->status) == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status', $student->status) == 'inactive')>Inactive
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.textarea class="form-control text-area-input"
                                                placeholder="Write Here" id="address" name="address"
                                                rows="3">
                                                {{ old('address', $student->address) }}
                                            </x-admin.textarea>
                                        </div>
                                    </div>
                                </div>

                                <x-admin.button type="submit" class="btn btn-primary">Save Changes
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
