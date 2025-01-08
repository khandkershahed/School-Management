<x-admin-app-layout :title="'Invoice Lists'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Invoice List</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive p-3 pt-1">
                                <!-- Table -->
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL</th>
                                            <th width="10%" class="text-center">Invoice Number</th>
                                            <th width="10%" class="text-center">Date</th>
                                            <th width="12%" class="text-center">Student ID</th>
                                            <th width="13%" class="text-center">Student</th>
                                            <th width="10%" class="text-center">Class</th>
                                            <th width="10%" class="text-center">Month </th>
                                            <th width="10%" class="text-center">Amount</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="10%" class="text-end">Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $invoice->invoice_number }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($invoice->generated_at)->format('d-m-y') }}
                                                </td>
                                                <td class="text-center">{{ optional($invoice->student)->student_id }}
                                                </td>
                                                <td class="text-center">{{ optional($invoice->student)->name }}</td>
                                                <td class="text-center">{{ optional($invoice->student)->class }}</td>
                                                <td class="text-center">{{ $invoice->month }} , {{ $invoice->year }}
                                                </td>
                                                <td class="text-center">{{ $invoice->total_amount }}</td>
                                                <td class="text-center">
                                                    Paid
                                                </td>
                                                <td class="text-end">

                                                    <a href="{{ asset('storage/' . $invoice->invoice) }}" download=""
                                                        class="btn btn-sm btn-warning text-white toltip mb-2"
                                                        data-tooltip="Download Invoice">
                                                        <i class="fa-solid fa-file-download"></i>
                                                    </a>
                                                    <a href="#"
                                                        class="btn btn-sm btn-warning text-white toltip mb-2"
                                                        data-tooltip="View">
                                                        <i class="fa-solid fa-expand"></i>
                                                    </a>
                                                    <div class="modal fade" id="excelImport" tabindex="-1"
                                                        aria-labelledby="excelImportLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-dark text-white">
                                                                    <h5 class="modal-title" id="excelImportLabel">Import
                                                                        Excel</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                </div>
                                                                <div class="modal-footer">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.invoice.destroy', $invoice->invoice_number) }}"
                                                        class="btn btn-sm btn-danger toltip mb-2 delete"
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



    @push('scripts')
        <script>
            // Multi Select Date Picker
            var dates = [];
            $(document).ready(function() {
                $("#cal").daterangepicker();
                $("#cal").on("apply.daterangepicker", function(e, picker) {
                    e.preventDefault();
                    const obj = {
                        key: dates.length + 1,
                        start: picker.startDate.format("MM/DD/YYYY"),
                        end: picker.endDate.format("MM/DD/YYYY"),
                    };
                    dates.push(obj);
                    showDates();
                });
                $(".remove").on("click", function() {
                    removeDate($(this).attr("key"));
                });
            });

            function showDates() {
                $("#ranges").html("");
                $.each(dates, function() {
                    const el =
                        "<li>" +
                        this.start +
                        "-" +
                        this.end +
                        "<button class='remove' onClick='removeDate(" +
                        this.key +
                        ")'>-</button></li>";
                    $("#ranges").append(el);
                });
            }

            function removeDate(i) {
                dates = dates.filter(function(o) {
                    return o.key !== i;
                });
                showDates();
            }
        </script>
    @endpush
</x-admin-app-layout>
