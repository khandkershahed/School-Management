<x-admin-app-layout>
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Education Medium</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">

                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addMediumModal"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Table -->
                            <table class="table table-striped datatable" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th width="15%">ID(To use for excel)</th>
                                        <th width="35%">Name</th>
                                        <th width="25%">Status</th>
                                        <th width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($mediums as $medium)
                                        <tr>
                                            <td>{{ $medium->id }}</td>
                                            <td>{{ $medium->name }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $medium->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $medium->status == 'active' ? 'Active' : 'InActive' }}</span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editMediumModal{{ $medium->id }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <a href="{{ route('admin.education-medium.destroy', $medium->id) }}"
                                                    class="btn btn-sm btn-danger delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                                <div class="modal fade" id="editMediumModal{{ $medium->id }}"
                                                    tabindex="-1" aria-labelledby="editMediumModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark text-white">
                                                                <h5 class="modal-title" id="editMediumModalLabel">Edit
                                                                    Department</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" enctype="multipart/form-data"
                                                                    action="{{ route('admin.education-medium.update', $medium->id) }}">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="name"
                                                                            class="form-label">Name</label>
                                                                        <x-admin.input type="text"
                                                                            class="form-control form-control-solid"
                                                                            :value="old('name', $medium->name)" id="name"
                                                                            name="name" required></x-admin.input>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <x-admin.label for="note"
                                                                            class="form-label">Note</x-admin.label>
                                                                        {{-- <textarea class="form-control form-control-solid" id="note" name="note" rows="3">{{ old('note',$medium->note) }}</textarea> --}}
                                                                        <x-admin.textarea id="note" name="note"
                                                                            :rows="2">{{ old('note', $medium->note) }}</x-admin.textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <x-admin.label for="status"
                                                                            class="form-label">Status</x-admin.label>
                                                                        <x-admin.select-option
                                                                            class="form-select form-select-solid"
                                                                            id="status" name="status">
                                                                            <option value="active"
                                                                                @selected($medium->status == 'active')>Active
                                                                            </option>
                                                                            <option value="inactive"
                                                                                @selected($medium->status == 'inactive')>Inactive
                                                                            </option>
                                                                        </x-admin.select-option>
                                                                    </div>
                                                                    <x-admin.button type="submit"
                                                                        class="btn btn-white">Edit
                                                                        Medium</x-admin.button>
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

    <!-- Add New Medium Modal -->
    <div class="modal fade" id="addMediumModal" tabindex="-1" aria-labelledby="addMediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="addMediumModalLabel">Add New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.education-medium.store') }}"
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
                        <x-admin.button type="submit" class="btn btn-white">Add Medium</x-admin.button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
