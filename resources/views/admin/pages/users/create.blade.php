<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Create Users</h4>
                                <a href="{{ route('admin.user.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.user.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name</x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name"
                                                name="name" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <x-admin.label for="email" class="form-label">Email</x-admin.label>
                                            <x-admin.input type="email" :value="old('email')" id="email"
                                                name="email" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <!-- form -->
                                            <div class="form-group">
                                                <x-admin.label for="login-mobile"
                                                    class="font-weight-bold text-dark">Contact Number</x-admin.label>
                                                <div class="input-group input-group-sm">
                                                    <x-admin.input id="mobile" type="tel" name="mobile"
                                                        :value="old('email')" class="form-control" autofocus
                                                        required></x-admin.input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="company" class="form-label">Company
                                                Name</x-admin.label>
                                            <x-admin.input type="company" :value="old('company')" id="company"
                                                name="company" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="taxRegistrationNumber" class="form-label">Tax
                                                Registration Number</x-admin.label>
                                            <x-admin.input type="taxRegistrationNumber" :value="old('taxRegistrationNumber')"
                                                id="taxRegistrationNumber" name="taxRegistrationNumber"
                                                required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <x-admin.label for="image" class="form-label">Image</x-admin.label>
                                            <x-admin.input type="file" :value="old('image')" id="image"
                                                name="image" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control text-area-input" id="address" name="address" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Create Client<i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
