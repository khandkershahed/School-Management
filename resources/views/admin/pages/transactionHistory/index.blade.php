<x-admin-app-layout :title="'Expence'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Transaction History</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    {{-- <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Export To Excel">
                                        <i class="fa-solid fa-file-csv"></i>
                                    </button> --}}
                                    <a href="{{ route('admin.transactions.pdf') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Download PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Print Table">
                                        <i class="fa-solid fa-print"></i>
                                        <span class="tooltiptext">Print</span>
                                    </button>
                                    {{-- <a href="{{ route('admin.transaction-history.create') }}"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-end align-items-center mb-3 bg-light p-3">
                                <h6 class="me-5">Filter Transactions From-To</h6>
                                <div>
                                    <input class="form-control me-3" name='range' id='datefilter' />
                                </div>
                                <div>
                                    <button type="button" class="ms-3 btn btn-sm btn-secondary" id="clear-filter">Clear
                                        Filter</button>
                                </div>
                            </div>

                            <div class="p-3 pt-1">
                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped datatable text-center" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">Sl</th>
                                                <th width="20%" class="text-center">Reason</th>
                                                <th width="10%" class="text-center">Date</th>
                                                <th width="10%" class="text-center">Type</th>
                                                <th width="10%" class="text-center">Account</th>
                                                <th width="10%" class="text-center">Amount</th>
                                                <th width="5%" class="text-center">Status</th>
                                                <th width="10%" class="text-end">Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-body">
                                            @foreach ($transactions as $i => $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->reason }}</td>
                                                    <td>{{ $data->transaction_date ? \Carbon\Carbon::parse($data->transaction_date)->format('d M, Y') : '' }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $data->type == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $data->type == 1 ? __('Credit') : __('Debit') }}
                                                        </span>
                                                    </td>
                                                    <td>{{ optional($data->cashbookAccount)->bank_name . '[' . optional($data->cashbookAccount)->account_number . ']' ?? '' }}
                                                    </td>
                                                    <td>{{ number_format($data->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $data->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $data->status == 'active' ? __('Active') : __('In Active') }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">{{ $data->user->name ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($transactions->isEmpty())
                                                <tr>
                                                    <td colspan="8">{{ __('No Data') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize datepicker or date range picker (e.g., flatpickr, jQuery UI Datepicker)
                $('#datefilter').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    autoUpdateInput: false, // We will manually update the input field
                    opens: 'left', // Optional: Adjust the dropdown position
                });

                // When the user selects a date range
                $('#datefilter').on('apply.daterangepicker', function(ev, picker) {
                    // Set the selected date range in the input field
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                        'YYYY-MM-DD'));
                    let startDate = picker.startDate.format('YYYY-MM-DD');
                    let endDate = picker.endDate.format('YYYY-MM-DD');
                    fetchFilteredData(startDate, endDate);
                });

                // "Clear Filter" button click handler
                $('#clear-filter').click(function() {
                    // Reset the date filter input
                    $('#datefilter').val('');
                    // Fetch all data (no filter applied)
                    fetchFilteredData('', '');
                });

                function fetchFilteredData(startDate, endDate) {
                    $.ajax({
                        url: '{{ route('admin.transactions.filter') }}', // Add your route here
                        method: 'GET',
                        data: {
                            start_date: startDate,
                            end_date: endDate,
                        },
                        success: function(response) {
                            // Update the table body with the filtered data
                            $('#data-body').html(response);
                        },
                        error: function() {
                            alert('Error fetching data');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-admin-app-layout>
