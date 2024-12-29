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
                                            <x-admin.input type="text" :value="old('name',$student->name)" id="name"
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
                                                        {{ old('medium_id',$student->medium_id) == $medium->id ? 'selected' : '' }}>
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
                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="class" name="class" :allowClear="true"
                                                required>
                                                <option value=""></option>
                                                <option value="1" @selected(old('class',$student->class) == '1')>i</option>
                                                <option value="2" @selected(old('class',$student->class) == '2')>ii</option>
                                                <option value="3" @selected(old('class',$student->class) == '3')>iii</option>
                                                <option value="4" @selected(old('class',$student->class) == '4')>iv</option>
                                                <option value="5" @selected(old('class',$student->class) == '5')>v</option>
                                                <option value="6" @selected(old('class',$student->class) == '6')>vi</option>
                                                <option value="7" @selected(old('class',$student->class) == '7')>vii</option>
                                                <option value="8" @selected(old('class',$student->class) == '8')>viii</option>
                                                <option value="9" @selected(old('class',$student->class) == '9')>ix</option>
                                                <option value="10" @selected(old('class',$student->class) == '10')>x</option>
                                                <option value="11" @selected(old('class',$student->class) == '11')>xi</option>
                                                <option value="12" @selected(old('class',$student->class) == '12')>xii</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll No</x-admin.label>
                                            <x-admin.input type="text" :value="old('roll',$student->roll)" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="guardian_name" class="font-weight-bold text-dark">Guardian
                                                    Name <span class="text-danger">*</span></x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_name" type="text" name="guardian_name"
                                                        :value="old('guardian_name',$student->guardian_name)" class="form-control" autofocus>
                                                    </x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="guardian_contact" class="font-weight-bold text-dark">Guardian
                                                    Contact Number <span class="text-danger">*</span></x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="guardian_contact" type="text" name="guardian_contact"
                                                        :value="old('guardian_contact',$student->guardian_contact)" class="form-control" autofocus>
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
                                                <option value="active" @selected(old('status',$student->status) == 'active')>Active</option>
                                                <option value="inactive" @selected(old('status',$student->status) == 'inactive')>Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label">Image</x-admin.label>
                                            <x-admin.file-input type="file" :value="old('image')" id="image"
                                                name="image" required></x-admin.file-input>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <x-admin.textarea class="form-control text-area-input"
                                                placeholder="Write Here" id="address" name="address" rows="3">
                                                {{ old('address',$student->address) }}
                                            </x-admin.textarea>
                                        </div>
                                    </div>

                                </div>
                                <x-admin.button type="submit" class="">Edit student
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
