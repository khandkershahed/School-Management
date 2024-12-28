<x-admin-app-layout :title="'Accounts List'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Balance Adjustments</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    {{-- <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Export To Excel">
                                        <i class="fa-solid fa-file-csv"></i>
                                    </button> --}}
                                    <a href="{{ route('admin.account.balances.pdf') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Download PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Print Table">
                                        <i class="fa-solid fa-print"></i>
                                        <span class="tooltiptext">Print</span>
                                    </button>
                                    <a href="{{ route('admin.balance-adjustment.create') }}"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">Sl</th>
                                            <th width="15%" class="text-center">Bank Name</th>
                                            <th width="20%" class="text-center">Account Number</th>
                                            <th width="10%" class="text-center">Amount</th>
                                            <th width="10%" class="text-center">Type</th>
                                            <th width="15%" class="text-center">Date</th>
                                            {{-- <th width="7%" class="text-center">Status</th> --}}
                                            <th width="10%" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($balances as $balance)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $balance->cashbookAccount->bank_name }}</td>
                                                <td class="text-center">{{ $balance->cashbookAccount->account_number }}</td>
                                                <td class="text-center">{{ $balance->amount }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $balance->type == '1' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $balance->type == '1' ? 'Add Balance' : 'Remove Balance' }}</span>
                                                </td>
                                                <td class="text-center">{{ optional($balance->date) ? \Carbon\Carbon::parse($balance->date)->format('jS M, Y') : '' }}</td>
                                                {{-- <td class="text-center">
                                                    <span class="badge {{ $balance->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $balance->status == 'active' ? 'Active' : 'InActive' }}</span>
                                                </td> --}}
                                                <td class="text-end">
                                                    <a href="{{ route('admin.balance-adjustment.edit',$balance->slug) }}" class="btn btn-sm btn-primary toltip"
                                                        data-tooltip="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="{{ route('admin.balance-adjustment.destroy',$balance->slug) }}" class="btn btn-sm btn-danger toltip delete"
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
