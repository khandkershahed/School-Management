<x-admin-app-layout :title="'Exam Due Report'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Exam Due Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.report.examdue') }}" method="GET" class="filter-form">
                                <div class="container-fluid">
                                    <div style="padding-left:35px;padding-right:35px;">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <x-admin.label for="group" class="form-label">Group<span
                                                        class="text-danger">*</span></x-admin.label>
                                                <x-admin.select-option id="group" name="group" :allowClear="true"
                                                    required>
                                                    <option value="">Select Group</option>
                                                    <option value="Science" @selected(old('group', $group) == 'Science')>Science
                                                    </option>
                                                    <option value="Arts" @selected(old('group', $group) == 'Arts')>Arts</option>
                                                    <option value="Commerce" @selected(old('group', $group) == 'Commerce')>Commerce
                                                    </option>
                                                    <option value="Day" @selected(old('group', $group) == 'Day')>Day</option>
                                                    <option value="Morning" @selected(old('group', $group) == 'Morning')>Morning
                                                    </option>
                                                </x-admin.select-option>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <x-admin.label for="class" class="form-label">Class <span
                                                        class="text-danger">*</span></x-admin.label>
                                                <x-admin.select-option class="form-control-solid" id="class"
                                                    name="class" :allowClear="true" required>
                                                    <option value="">Select Class</option>
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
                                                    <option value="11" @selected(old('class', $class) == '11')>First Year
                                                    </option>
                                                    <option value="12" @selected(old('class', $class) == '12')>Second Year
                                                    </option>
                                                </x-admin.select-option>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <x-admin.label for="fee_id" class="form-label">Exam Fee<span
                                                        class="text-danger">*</span></x-admin.label>
                                                <x-admin.select-option class="form-control-solid" id="fee_id"
                                                    name="fee_id" :allowClear="true" required>
                                                    <option value="">Select Exam Fee</option>
                                                    @foreach ($filter_fees as $fee)
                                                        <option value="{{ $fee->id }}"
                                                            @selected(old('fee_id', $fee_id) == $fee->id)>
                                                            {{ $fee->name }}</option>
                                                    @endforeach
                                                </x-admin.select-option>
                                            </div>
                                        </div>
                                        <div class="row my-3 align-items-center justify-content-center">
                                            <div class="col-4 text-center">
                                                <button type="submit" class="btn btn-primary"
                                                    style="width: 150px;">Filter</button>
                                            </div>
                                            <div class="col-4 text-center">
                                                <a href="{{ route('admin.report.monthlydue') }}" class="btn btn-primary"
                                                    style="width: 150px;">Clear Filter</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @if (isset($class) && $class !== null)
                                @if (count($monthly_dues) < 1)
                                    <div class="alert alert-warning text-center">
                                        <strong>No data found for the selected filters.</strong>
                                    </div>
                                @else
                                    <div class="container-fluid mt-3" id="printContainer">
                                        <div style="padding-left:35px;padding-right:35px;">
                                            <div class="row">
                                                <div style="width:100%; padding:0px; margin:0px;">
                                                    <table
                                                        style="width:100%; -webkit-print-color-adjust: exact !important; background-color: #f0f3f5 !important; border-radius: 10px; margin-bottom: 20px; padding: 10px;">
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

                                                                            <small> Exam Fees Due Report</small>
                                                                        </h5>
                                                                        <div class="clearfix">&nbsp;</div>
                                                                    </span>
                                                                </td>
                                                                <td style="width:10%;text-align:center;border:0px;">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <table class="table table-striped" id="datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Student ID</th>
                                                                <th>Fee Type</th>
                                                                <th>Due Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($monthly_dues as $monthly_due)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $monthly_due['student_id'] }}</td>
                                                                    <td>{{ $monthly_due['fee_type'] }}</td>
                                                                    <td>{{ number_format($monthly_due['total_due_amount'], 2) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3" class="text-end"><strong>Total
                                                                        Amount:</strong></td>
                                                                <td>{{ number_format($grandTotalDueAmount, 2) }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4 offset-4 text-center">
                                            <button class="btn btn-primary" onclick="printInvoice();"><i
                                                    class="fa fa-print"></i> Print</button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-warning text-center">
                                    <strong>You have to input filters.</strong>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
