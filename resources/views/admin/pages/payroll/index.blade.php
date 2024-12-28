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
                                    <h4 class="mb-0">Employee Payroll</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Export To Excel">
                                        <i class="fa-solid fa-file-csv"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Download PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Print Table">
                                        <i class="fa-solid fa-print"></i>
                                        <span class="tooltiptext">Print</span>
                                    </button>
                                    <a href="{{ route('admin.payroll.create') }}"
                                        class="btn btn-outline-light toltip" data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3 bg-light p-3">
                                    <h6>Filter Accounts From-To</h6>
                                    <div>
                                        <input class="form-control" name='range' id='cal' />
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 pt-1">
                                <!-- Table -->
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">Sl</th>
                                            <th width="15%" class="text-center">Emp Name</th>
                                            <th width="10%" class="text-center">Emp ID</th>
                                            <th width="15%" class="text-center">Designation</th>
                                            <th width="10%" class="text-center">Salary Month</th>
                                            <th width="10%" class="text-center">Total Paid</th>
                                            <th width="10%" class="text-center">Account</th>
                                            <th width="10%" class="text-center">Salary Date</th>
                                            <th width="5%" class="text-center">Status</th>
                                            <th width="10%" class="text-end">Action</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Paki Wolf</td>
                                            <td class="text-center">AE-2</td>
                                            <td class="text-center">Marketing Manager</td>
                                            <td class="text-center">February</td>
                                            <td class="text-center">$9800.00</td>
                                            <td class="text-center">CASH-0001</td>
                                            <td class="text-center">17th Oct, 2024</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    Active</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary  toltip"
                                                    data-tooltip="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-warning text-white toltip"
                                                    data-tooltip="View">
                                                    <i class="fa-solid fa-expand"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger toltip"
                                                    data-tooltip="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
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
