<x-admin-app-layout :title="'Invoice Lists'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Income Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="mb-3">
                                        <x-admin.label for="from_date" class="form-label">From Date </x-admin.label>
                                        <input type="date" class="form-control form-control-solid" name="from_date" id="from_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="mb-3">
                                        <x-admin.label for="to_date" class="form-label">To Date </x-admin.label>
                                        <input type="date" class="form-control form-control-solid" name="to_date" id="to_date">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="table-responsive p-3 pt-1">
                                    <!-- Table -->
                                    <table class="table table-striped datatable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">SL</th>
                                                <th width="12%" class="text-center">Year</th>
                                                <th width="15%" class="text-center">Month</th>
                                                <th width="12%" class="text-center">Amount</th>
                                                <th width="10%" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ optional($invoice)->year }}</td>
                                                    <td class="text-center">{{ optional($invoice)->month }}</td>

                                                    <td class="text-center">{{ $invoice->total_amount }}</td>

                                                    <td class="text-end">

                                                        <a href="#"
                                                            class="btn btn-sm btn-warning text-white toltip mb-2"
                                                            data-tooltip="View">
                                                            <i class="fa-solid fa-expand"></i>
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
    </div>

    <div class="modal fade" id="excelImport" tabindex="-1" aria-labelledby="excelImportLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="excelImportLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <x-admin.label for="name" class="form-label">Select Excel File (.xlsx,.xls,.csv only): (
                                <a href="{{ asset('images/Demo Excel invoice Import.xlsx') }}" download=""
                                    class="fw-bold">Download</a> demo format Excel)</x-admin.label>
                            <x-admin.file-input class="form-control form-control-solid" :value="old('file')" id="file"
                                name="file" required></x-admin.file-input>
                        </div>
                        <x-admin.button type="submit" class="btn btn-white float-end">Submit</x-admin.button>
                    </form>
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
