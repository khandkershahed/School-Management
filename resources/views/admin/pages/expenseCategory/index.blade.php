<x-admin-app-layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Expense Categories</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    {{-- <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Export To Excel">
                                        <i class="fa-solid fa-file-csv"></i>
                                    </button> --}}
                                    <a href="{{ route('admin.expCategories.pdf') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Download PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Print Table">
                                        <i class="fa-solid fa-print"></i>
                                        <span class="tooltiptext">Print</span>
                                    </button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Table -->
                            <table class="table table-striped datatable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categorys as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->code }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $category->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $category->status == 'active' ? 'Active' : 'InActive' }}</span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $category->id }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                {{-- <a href="javascript:void(0)" class="btn btn-sm btn-warning text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $category->id }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a> --}}
                                                <a href="{{ route('admin.expense-category.destroy', $category->id) }}"
                                                    class="btn btn-sm btn-danger delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                                <div class="modal fade" id="editCategoryModal{{ $category->id }}"
                                                    tabindex="-1" aria-labelledby="editCategoryModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark text-white">
                                                                <h5 class="modal-title" id="editCategoryModalLabel">Edit
                                                                    Category</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" enctype="multipart/form-data"
                                                                    action="{{ route('admin.expense-category.update', $category->id) }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="name"
                                                                            class="form-label">Name</label>
                                                                        <x-admin.input type="text"
                                                                            class="form-control form-control-solid"
                                                                            :value="old('name', $category->name)" id="name"
                                                                            name="name" required></x-admin.input>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <x-admin.label for="note"
                                                                            class="form-label">Note</x-admin.label>
                                                                        {{-- <textarea class="form-control form-control-solid" id="note" name="note" rows="3">{{ old('note',$category->note) }}</textarea> --}}
                                                                        <x-admin.textarea id="note" name="note"
                                                                            :rows="2">{{ old('note', $category->note) }}</x-admin.textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <x-admin.label for="status"
                                                                            class="form-label">Status</x-admin.label>
                                                                        <x-admin.select-option
                                                                            class="form-select form-select-solid"
                                                                            id="status" name="status">
                                                                            <option value="active"
                                                                                @selected($category->status == 'active')>Active
                                                                            </option>
                                                                            <option value="inactive"
                                                                                @selected($category->status == 'inactive')>Inactive
                                                                            </option>
                                                                        </x-admin.select-option>
                                                                    </div>
                                                                    <x-admin.button type="submit"
                                                                        class="btn btn-white">Edit
                                                                        Category</x-admin.button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.expense-category.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <x-admin.label for="name" class="form-label">Name</x-admin.label>
                            <x-admin.input type="text" class="form-control form-control-solid" :value="old('name')"
                                id="name" name="name" required></x-admin.input>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control form-control-solid" id="note" name="note"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <x-admin.select-option id="status" name="status" :allowClear="true">
                                <option value="active" @selected(old('status') == 'active')>Active</option>
                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                            </x-admin.select-option>
                        </div>
                        <x-admin.button type="submit" class="btn btn-white">Add Category</x-admin.button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
