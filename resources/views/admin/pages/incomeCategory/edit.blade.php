<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Edit Income Category</h4>
                                <a href="{{ route('admin.income-category.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.income-category.update', $category->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name</x-admin.label>
                                            <x-admin.input type="text" class="form-control form-control-solid"
                                                :value="old('name', $category->name)" id="name" name="name"
                                                required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active" @selected($category->status == 'active')>Active
                                                </option>
                                                <option value="inactive" @selected($category->status == 'inactive')>Inactive
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <x-admin.textarea id="note" name="note"
                                                :rows="2">{{ old('note', $category->note) }}</x-admin.textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Update Category <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
