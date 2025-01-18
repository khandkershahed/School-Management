<x-admin-app-layout :title="'Invoice Report'">
    <style>
        th,
        td {
            font-size: 0.8rem;
        }
    </style>
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
                                <div class="row">
                                    <!-- Class Filter -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class</x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true" onchange="this.form.submit()">
                                                <option value=""></option>
                                                <option value="00" @selected(old('class', $class) == '00')>Nursery</option>
                                                <option value="0" @selected(old('class', $class) == '0')>KG</option>
                                                <option value="1" @selected(old('class', $class) == '1')>One</option>
                                                <option value="2" @selected(old('class', $class) == '2')>Two</option>
                                                <option value="3" @selected(old('class', $class) == '3')>Three</option>
                                                <option value="4" @selected(old('class', $class) == '4')>Four</option>
                                                <option value="5" @selected(old('class', $class) == '5')>Five</option>
                                                <option value="6" @selected(old('class', $class) == '6')>Six</option>
                                                <option value="7" @selected(old('class', $class) == '7')>Seven</option>
                                                <option value="8" @selected(old('class', $class) == '8')>Eight</option>
                                                <option value="9" @selected(old('class', $class) == '9')>Nine</option>
                                                <option value="10" @selected(old('class', $class) == '10')>Ten</option>
                                                <option value="11" @selected(old('class', $class) == '11')>First Year</option>
                                                <option value="12" @selected(old('class', $class) == '12')>Second Year
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
                                                    <option value="{{ $student->id }}" @selected(old('student_id', $student_id) == $student->id)>
                                                        {{ $student->name }} [{{ $student->student_id }}]
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3 align-items-center justify-content-center">
                                    <div class="col-4 text-center">
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 150px;">Filter</button>
                                    </div>
                                    <div class="col-4 text-center">
                                        <a href="{{ route('admin.report.studentinvoice') }}" class="btn btn-primary"
                                            style="width: 150px;">Clear Filter</a>
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
                                                            <td style="width:10%;text-align:center;border:0px;">
                                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_color_no_bg.png'))) }}"
                                                                    alt="" height="80px" width="80px">
                                                            </td>
                                                            <td style="width:80%;text-align:center;border:0px;">
                                                                <span style="text-align: center;">
                                                                    <div class="clearfix">&nbsp;</div>
                                                                    <h4 class="text-muted"
                                                                        style="margin:10px; font-size:20px">
                                                                        <strong>Shamsul Hoque Khan School and
                                                                            College</strong>
                                                                    </h4>
                                                                    <h6 class="text-muted"
                                                                        style="margin:5px; font-size:12px">
                                                                        Paradogair, Matuail, Demra Dhaka-1362
                                                                    </h6>
                                                                    <h5 class="head-title ptint-title text-info"
                                                                        style="width:100%;margin:10px; font-size:24px; text-decoration:underline">

                                                                        <small> Student Invoice Report</small>
                                                                    </h5>
                                                                    <div class="clearfix">&nbsp;</div>
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
                                            <table class="table table-striped" id="datatable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th width="2%"
                                                            class="text-center">SL</th>
                                                        <th width="15%"
                                                            class="text-center">Year</th>
                                                        <th width="22%"
                                                            class="text-center">Student</th>
                                                        <th width="15%"
                                                            class="text-center">Student ID</th>
                                                        <th width="9%"
                                                            class="text-center">Class</th>
                                                        <th width="13%"
                                                            class="text-center">Net Amount</th>
                                                        <th width="12%"
                                                            class="text-center">Paid</th>
                                                        <th width="12%"
                                                            class="text-center">Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoices as $invoice)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}</td>
                                                            <td class="text-center">
                                                                {{ $invoice->year . ' - ' . $invoice->month }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ optional($invoice->student)->name }}</td>
                                                            <td class="text-center">
                                                                {{ optional($invoice->student)->student_id }}</td>
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
                                                        <td colspan="7" style="text-align:end"><strong>Total
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
                            </form>

                            <div class="row mt-3">
                                <div class="col-4 offset-4 text-center">
                                    <button class="btn btn-primary" onclick="printInvoice();"
                                        style="width: 150px;"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-app-layout>
