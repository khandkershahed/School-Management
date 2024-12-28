<x-admin-app-layout :title="'Staff Edit'">

    <div class="card card-flash">
        <div class="card-body scroll-y mx-5 mx-xl-15 my-7">
            <form class="form" method="POST" action="{{ route('admin.staff.update',$staff->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="name"
                            class="required fw-bold fs-6 mb-2">{{ __('Full Name') }}</x-admin.label>
                        <x-admin.input id="name" type="text" class="form-control-solid mb-3 mb-lg-0"
                            name="name" :value="old('name',$staff->name)" placeholder="Enter Full name"></x-admin.input>
                    </div>
                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="email"
                            class="required fw-bold fs-6 mb-2">{{ __('Email') }}</x-admin.label>
                        <x-admin.input id="email" type="email" class="form-control-solid mb-3 mb-lg-0"
                            name="email" :value="old('email',$staff->email)" placeholder="example@domain.com"></x-admin.input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="username"
                            class="fw-bold fs-6 mb-2">{{ __('User Name') }}</x-admin.label>
                        <x-admin.input id="username" type="text" class="form-control-solid mb-3 mb-lg-0"
                            name="username" :value="old('username',$staff->username)" placeholder="Enter User name"></x-admin.input>
                    </div>

                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="designation"
                            class="fw-bold fs-6 mb-2">{{ __('Designation') }}</x-admin.label>
                        <x-admin.input id="designation" type="text" class="form-control-solid mb-3 mb-lg-0"
                            name="designation" :value="old('designation',$staff->designation)" placeholder="Designation"></x-admin.input>
                    </div>
                    <div class="col-lg-4 mb-7">
                        <x-admin.label for="photo"
                            class="fw-bold fs-6 mb-2">{{ __('Photo') }}</x-admin.label>
                        <x-admin.file-input id="photo" type="file" class="form-control-solid mb-3 mb-lg-0" :source="asset('storage/'.$staff->photo)"
                            name="photo" :value="old('photo')" placeholder="example@domain.com"></x-admin.file-input>
                    </div>
                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="password"
                            class="required fw-bold fs-6 mb-2">{{ __('Password') }}</x-admin.label>
                        <x-admin.input id="password" type="password" class="form-control-solid mb-3 mb-lg-0"
                            name="password" placeholder="Enter Password"></x-admin.input>
                    </div>
                    <div class="col-lg-6 mb-7">
                        <x-admin.label for="password_confirmation"
                            class="required fw-bold fs-6 mb-2">{{ __('Confirm Password') }}</x-admin.label>
                        <x-admin.input id="password_confirmation" type="password"
                            class="form-control-solid mb-3 mb-lg-0" name="password_confirmation"
                            placeholder="Confirm the password"></x-admin.input>
                    </div>

                    <div class="mb-7">

                        <label class="required fw-bold fs-6 mb-5">Role</label>
                        @foreach ($roles as $role)
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid">
                                    <x-admin.checkbox id="role-name-{{ $role->id }}" type="checkbox"
                                        name="roles[]" :value="$role->name"></x-admin.checkbox>
                                    <x-admin.label for="role-name-{{ $role->id }}"
                                        class="form-check-label">{{ $role->name }}</x-admin.label>
                                </div>
                            </div>
                            <div class='separator separator-dashed my-5'></div>
                        @endforeach
                    </div>
                </div>
                <div class="text-center pt-15">
                    <x-admin.button type="submit" class="primary">
                        {{ __('Save Changes') }}
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>

</x-admin-app-layout>
