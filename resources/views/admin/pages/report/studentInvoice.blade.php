<x-admin-app-layout :title="'Invoice Report'">
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
                            <!-- Filter Form -->
                            <form action="{{ route('admin.report.studentinvoice') }}" method="GET" class="filter-form">
                                @csrf
                                <div class="row">
                                    <!-- Class Filter -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class</x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true">
                                                <option value=""></option>
                                                <option value="0" @selected(old('class') == '0')>Nursery</option>
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

                                    <!-- Student Filter -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="student_id" class="form-label">Student</x-admin.label>
                                            <x-admin.select-option id="student_id" name="student_id" :allowClear="true">
                                                <option value="">-- Select Student --</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                                        {{ $student->name }} [{{ $student->student_id }}]
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-4 offset-4 text-center">
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 150px;">Filter</button>
                                    </div>
                                </div>
                                <!-- Submit Filter Button -->
                                <div class="container-fluid" id="printContainer">
                                    <div style="padding-left:35px;padding-right:35px;">
                                        <div class="row">
                                            <div style="width:100%; padding:0px; margin:0px;">
                                                <table
                                                    style=" width:100%; -webkit-print-color-adjust: exact !important; background-color: #f0f3f5 !important; border-radius: 10px; margin-bottom: 20px; padding: 10px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:10%;text-align:center;">
                                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_color_no_bg.png'))) }}"
                                                                    alt="" height="80px" width="80px">
                                                            </td>
                                                            <td style="width:80%;  text-align:center;">
                                                                <span style="text-align: center ;">
                                                                    <div class="clearfix">&nbsp;</div>
                                                                    <h3 class="text-muted" style="margin-top:10px;">
                                                                        <strong>Shamsul Hoque Khan School and College</strong>
                                                                    </h3>
                                                                    <h6 class="text-muted" style="margin-top:10px;">
                                                                        Paradogair, Matuail, Demra
                                                                        Dhaka-1362
                                                                    </h6>
                                                                    <h3 class="head-title ptint-title text-info"
                                                                        style="width: 100%;margin-top:10px;">
                                                                        <i class="fa fa-bar-chart"></i>
                                                                        <small> Student Invoice Report</small>
                                                                    </h3>
                                                                    <div class="clearfix">&nbsp;</div>
                                                                    {{-- <div>Academic Year: {{ old('year', $year) }}</div> --}}
                                                                </span>
                                                            </td>
                                                            <td style="width:10%;  text-align:center;"> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Invoices Table -->
                                        <div class="row mt-3">
                                            <div class="table-responsive p-3 pt-1">
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" class="text-center">SL</th>
                                                            <th width="15%" class="text-center">Academic Year</th>
                                                            <th width="15%" class="text-center">Student</th>
                                                            <th width="12%" class="text-center">Class</th>
                                                            <th width="12%" class="text-center">Net Amount</th>
                                                            <th width="12%" class="text-center">Paid</th>
                                                            <th width="12%" class="text-center">Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($invoices as $invoice)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="text-center">
                                                                    {{ $invoice->year . ' - ' . $invoice->month }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ optional($invoice->student)->name }}</td>
                                                                <td class="text-center">
                                                                    {{ optional($invoice->student)->class }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ number_format($invoice->total_amount, 2) }}</td>
                                                                <td class="text-center">
                                                                    {{ number_format($invoice->total_amount, 2) }}</td>
                                                                {{-- <td class="text-center">{{ number_format($invoice->paid_amount ?? 0, 2) }}</td> --}}
                                                                <td class="text-center">
                                                                    {{ number_format($invoice->total_amount - ($invoice->paid_amount ?? 0), 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" style="text-align:end"><strong>Total
                                                                    Balance:
                                                                </strong></td>
                                                            <td class="text-center">
                                                                {{ number_format($total_balance, 2) }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Pagination -->
                                    {{-- <div class="row mt-3">
                                        <div class="col-12">
                                            {{ $invoices->links() }}
                                        </div>
                                    </div> --}}
                                </div>
                            </form>

                            <div class="row mt-3">
                                <div class="col-4 offset-4 text-center">
                                    <button class="btn btn-primary" onclick="printInvoice();" style="width: 150px;"><i
                                            class="fa fa-print"></i> Print</button>
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
            function printInvoice() {
                // Hide everything except the print container
                var printContents = document.getElementById('printContainer').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;
                window.print();

                // Restore the original page content after printing
                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
</x-admin-app-layout>
