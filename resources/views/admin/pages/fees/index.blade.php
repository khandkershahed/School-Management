<x-admin-app-layout :title="'Manage Fees'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Fees</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">

                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Print Table">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                    <a href="{{ route('admin.fees.create') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive p-3 pt-1">
                                <!-- Table -->
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">Sl</th>
                                            <th width="25%" class="text-center">Name</th>
                                            <th width="25%" class="text-center">Description</th>
                                            <th width="15%" class="text-center">Medium</th>
                                            <th width="15%" class="text-center">Class</th>
                                            <th width="10%" class="text-center">Amount</th>
                                            <th width="10%" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fees as $fee)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $fee->name }}</td>
                                                <td class="text-center">{{ $fee->description }}</td>
                                                <td class="text-center">{{ optional($fee->medium)->name }}</td>
                                                <td class="text-center">{{ optional($fee)->class }}</td>
                                                <td class="text-center">{{ number_format($fee->amount, 2) }}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.fees.edit', $fee->id) }}" class="btn btn-sm btn-primary toltip mb-2"
                                                        data-tooltip="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="{{ route('admin.fees.destroy', $fee->id) }}" class="btn btn-sm btn-danger toltip mb-2 delete"
                                                        data-tooltip="Delete">
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
    </div>
</x-admin-app-layout>
