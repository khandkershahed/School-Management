<x-admin-app-layout :title="'Student Due Fee'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Due Fee Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.report.duefee') }}" method="GET" class="filter-form">
                                <div class="row">
                                    <!-- Class Filter -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class</x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true">
                                                <option value="">Select Class</option>
                                                <option value="00" @selected(old('class') == '00')>Nursery</option>
                                                <option value="0" @selected(old('class') == '0')>KG</option>
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
                                                    <option value="{{ $student->id }}" @selected(old('student_id', $student_id) == $student->id)>
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
                            </form>

                            <!-- Only show table if there are students and fees to display -->
                            @if ($students->isNotEmpty())
                                <div class="container-fluid mt-3" id="printContainer">
                                    <div style="padding-left:35px;padding-right:35px;">
                                        <div class="row">
                                            <div style="width:100%; padding:0px; margin:0px;">
                                                <table
                                                    style=" width:100%; background-color: #f0f3f5 !important; border-radius: 10px; margin-bottom: 20px; padding: 20px 30px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:10%;text-align:center;">
                                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_color_no_bg.png'))) }}"
                                                                    alt="" height="80px" width="80px">
                                                            </td>
                                                            <td style="width:80%; text-align:center;">
                                                                <div class="clearfix">&nbsp;</div>
                                                                <h4 class="text-muted" style="margin-top:10px;">
                                                                    <strong>Shamsul Hoque Khan School and
                                                                        College</strong>
                                                                </h4>
                                                                <h6 class="text-muted" style="margin-top:10px;">
                                                                    Paradogair, Matuail, Demra
                                                                    Dhaka-1362
                                                                </h6>
                                                                <h5 class="head-title ptint-title text-info"
                                                                    style="width: 100%;margin-top:10px;">
                                                                    <i class="fa fa-bar-chart"></i>
                                                                    <small> Student Due Fees Report</small>
                                                                </h5>
                                                                <div class="clearfix">&nbsp;</div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row p-3 pt-1">
                                            <!-- Table -->
                                            <table class="table table-striped" id="datatable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        {{-- <th class="text-center">SL</th> --}}
                                                        <th style="font-size: 0.7rem;" class="text-center">Fee</th>
                                                        <th style="font-size: 0.7rem;" class="text-center">Student ID</th>
                                                        <th style="font-size: 0.7rem;" class="text-center">Student Name</th>
                                                        <th style="font-size: 0.7rem;" class="text-center">Month</th>
                                                        <th style="font-size: 0.7rem;" class="text-center">Amount</th>
                                                        <th style="font-size: 0.7rem;" class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($students as $student)
                                                        <!-- Display Due Monthly Fees -->
                                                        @foreach ($dueMonthlyFees[$student->id] ?? [] as $fee)
                                                            <tr>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $fee['fee']->name }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $student->student_id }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $student->name }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">
                                                                    {{ $fee['fee']->fee_type === 'monthly' ? $fee['fee']->month : 'Annual' }}
                                                                </td>
                                                                <td style="font-size: 0.7rem;" class="text-center">
                                                                    {{ number_format($fee['amount'], 2) }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $fee['status'] }}</td>
                                                            </tr>
                                                        @endforeach

                                                        <!-- Display Due Yearly Fees -->
                                                        @foreach ($dueYearlyFees[$student->id] ?? [] as $fee)
                                                            <tr>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $fee['fee']->name }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $student->student_id }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $student->name }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">
                                                                    {{ $fee['fee']->fee_type === 'yearly' ? 'Annual' : '' }}
                                                                </td>
                                                                <td style="font-size: 0.7rem;" class="text-center">
                                                                    {{ number_format($fee['amount'], 2) }}</td>
                                                                <td style="font-size: 0.7rem;" class="text-center">{{ $fee['status'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">
                                    <p>No data available. Please apply filters to see the report.</p>
                                </div>
                            @endif

                            <div class="row my-3">
                                <div class="col-4 offset-4 text-center">
                                    <button class="btn btn-primary" onclick="printInvoice();" style="width: 150px;">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-admin-app-layout>
