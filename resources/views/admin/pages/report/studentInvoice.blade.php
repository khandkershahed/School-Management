<x-admin-app-layout :title="'Invoice Lists'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Student Invoice List</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="mb-3">
                                        <x-admin.label for="class" class="form-label">Class </x-admin.label>
                                        <x-admin.select-option class="form-control-solid" id="class"
                                            name="class" :allowClear="true" required>
                                            <option value=""></option>
                                            <option value="nursery" @selected(old('class') == 'nursery')>Nursery</option>
                                            <option value="1" @selected(old('class') == '1')>One</option>
                                            <option value="2" @selected(old('class') == '2')>Two</option>
                                            <option value="3" @selected(old('class') == '3')>Three</option>
                                            <option value="4" @selected(old('class') == '4')>Four</option>
                                            <option value="5" @selected(old('class') == '5')>Five</option>
                                            <option value="6" @selected(old('class') == '6')>Six</option>
                                            <option value="7" @selected(old('class') == '7')>Seven</option>
                                            <option value="8" @selected(old('class') == '8')>Eight</option>
                                            <option value="9" @selected(old('class') == '9')>Nine</option>
                                            <option value="10" @selected(old('class') == '10')>Ten</option>
                                            <option value="11" @selected(old('class') == '11')>First Year</option>
                                            <option value="12" @selected(old('class') == '12')>Second Year
                                            </option>
                                        </x-admin.select-option>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <x-admin.label for="student_id" class="form-label">Student</x-admin.label>
                                        <x-admin.select-option id="student_id" name="student_id" :allowClear="true">
                                            <option value="">-- Select Student --</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->student_id }}" @selected(old('student_id') == $student->student_id)>{{ $student->name }}[{{ $student->student_id }}]</option>
                                            @endforeach
                                        </x-admin.select-option>
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
                                                <th width="15%" class="text-center">Student</th>
                                                <th width="12%" class="text-center">Class</th>
                                                <th width="13%" class="text-center">Amount</th>
                                                <th width="12%" class="text-center">Invoice Number</th>
                                                <th width="12%" class="text-center">Status </th>
                                                <th width="10%" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ optional($invoice->student)->year }}</td>
                                                    <td class="text-center">{{ optional($invoice->student)->name }}</td>
                                                    <td class="text-center">{{ optional($invoice->student)->class }}
                                                    </td>
                                                    {{-- <td class="text-center">
                                                        {{ \Carbon\Carbon::parse($invoice->generated_at)->format('d-m-y') }}
                                                    </td> --}}
                                                    <td class="text-center">{{ $invoice->total_amount }}</td>
                                                    <td class="text-center">
                                                        Paid
                                                        {{-- <span
                                                            class="badge {{ $invoice->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $invoice->status == 'active' ? 'Active' : 'InActive' }}</span> --}}
                                                    </td>
                                                    <td class="text-center">{{ $invoice->invoice_number }}</td>
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
