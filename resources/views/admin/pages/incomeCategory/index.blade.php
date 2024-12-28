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
                                    <h4 class="mb-0">Manage Income Categories</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    
                                    <a href="{{ route('admin.income-category.create') }}"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
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
                                                <a href="{{ route('admin.income-category.edit',$category->slug ) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                {{-- <a href="javascript:void(0)" class="btn btn-sm btn-warning text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal{{ $category->id }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a> --}}
                                                <a href="{{ route('admin.income-category.destroy', $category->id) }}"
                                                    class="btn btn-sm btn-danger delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
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
</x-admin-app-layout>
