<x-admin-app-layout :title="'Staff Add'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="card card-flash">
                <div class="card-header">
                    <h5 class="text-center text-info">
                        Staff Add
                    </h5>
                </div>
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('admin.staff.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <x-admin.label for="name"
                                    class="required fw-bold fs-6 mb-2">{{ __('Full Name') }}</x-admin.label>
                                <x-admin.input id="name" type="text" class="form-control-solid mb-3 mb-lg-0"
                                    name="name" :value="old('name')" placeholder="Enter Full name"></x-admin.input>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <x-admin.label for="email"
                                    class="required fw-bold fs-6 mb-2">{{ __('Email') }}</x-admin.label>
                                <x-admin.input id="email" type="email" class="form-control-solid mb-3 mb-lg-0"
                                    name="email" :value="old('email')" placeholder="example@domain.com"></x-admin.input>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <x-admin.label for="username"
                                    class="fw-bold fs-6 mb-2">{{ __('User Name') }}</x-admin.label>
                                <x-admin.input id="username" type="text" class="form-control-solid mb-3 mb-lg-0"
                                    name="username" :value="old('username')" placeholder="Enter User name"></x-admin.input>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <x-admin.label for="designation"
                                    class="fw-bold fs-6 mb-2">{{ __('Designation') }}</x-admin.label>
                                <x-admin.input id="designation" type="text" class="form-control-solid mb-3 mb-lg-0"
                                    name="designation" :value="old('designation')" placeholder="Designation"></x-admin.input>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <x-admin.label for="photo"
                                    class="fw-bold fs-6 mb-2">{{ __('Photo') }}</x-admin.label>
                                <x-admin.file-input id="photo" type="file"
                                    class="form-control-solid mb-3 mb-lg-0" name="photo" :value="old('photo')"
                                    placeholder="example@domain.com"></x-admin.file-input>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <x-admin.label for="password"
                                    class="required fw-bold fs-6 mb-2">{{ __('Password') }}</x-admin.label>
                                <x-admin.input id="password" type="password" class="form-control-solid mb-3 mb-lg-0"
                                    name="password" :value="old('password')" placeholder="Enter Password"></x-admin.input>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <x-admin.label for="password_confirmation"
                                    class="required fw-bold fs-6 mb-2">{{ __('Confirm Password') }}</x-admin.label>
                                <x-admin.input id="password_confirmation" type="password"
                                    class="form-control-solid mb-3 mb-lg-0" name="password_confirmation"
                                    placeholder="Confirm the password"></x-admin.input>
                            </div>

                            <div class="mb-3">
                                <label class="required fw-bold fs-6 mb-2">Role</label>
                                @foreach ($roles as $role)
                                    <div class="d-flex fv-row">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <x-admin.checkbox id="role-name-{{ $role->id }}" type="checkbox"
                                                name="roles[]" :value="$role->name"></x-admin.checkbox>
                                            <x-admin.label for="role-name-{{ $role->id }}"
                                                class="form-check-label ms-2 mt-1">{{ $role->name }}</x-admin.label>
                                        </div>
                                    </div>
                                    <div class='separator separator-dashed my-5'></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-center pt-15">
                            <x-admin.button type="submit" class="primary">
                                {{ __('Submit') }}
                            </x-admin.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.staff.store') }}">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select name="roles[]" id="role" multiple
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline js-example-basic-multiple">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div> --}}
</x-admin-app-layout>
