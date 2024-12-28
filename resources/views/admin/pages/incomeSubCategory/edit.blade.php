<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-5">
                        <div class="card-header p-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-gray-800">Edit Income Subcategory</h4>
                                <a href="{{ route('admin.income-subcategory.index') }}" class="btn-common-one text-white"
                                    tabindex="0">
                                    <i class="fa-solid fa-arrow-left-long pe-3"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.income-subcategory.update', $subcategory->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name</x-admin.label>
                                            <x-admin.input type="text" class="form-control form-control-solid"
                                                :value="old('name', $subcategory->name)" id="name" name="name"
                                                required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="cat_id" class="form-label">Category Name</label>
                                            <x-admin.select-option id="cat_id" name="cat_id" :allowClear="true">
                                                <option value="">-- Select Category --</option>
                                                <!-- Default Option -->
                                                @foreach ($categorys as $category)
                                                    <option value="{{ $category->id }}" @selected(old('cat_id', $subcategory->cat_id) == $category->id)>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                                <option value="active"
                                                    {{ old('status', $subcategory->status) == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status', $subcategory->status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <x-admin.textarea id="note" name="note"
                                                :rows="2">{{ old('note', $subcategory->note) }}</x-admin.textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-admin.button type="submit" class="">Update Sub Category <i
                                        class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
