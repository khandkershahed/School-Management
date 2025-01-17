<x-admin-app-layout :title="'Custom Report'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Custom Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Display Validation Errors -->
                            <form action="{{ route('admin.report.customreport') }}" method="GET" class="filter-form">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="year" class="form-label">Academic Year<span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="year" name="year" :allowClear="true"
                                                required>
                                                <option value="">Select Academic Year</option>
                                                @for ($academic_year = 2025; $academic_year <= 2030; $academic_year++)
                                                    <option value="{{ $academic_year }}" @selected($academic_year == date('Y') || $academic_year == $year)>
                                                        Academic Year {{ $academic_year }}
                                                    </option>
                                                @endfor
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="group_by" class="form-label">Group by Data <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="group_by"
                                                name="group_by" :allowClear="true" required>
                                                <option value="">Select</option>
                                                <option value="daily" @selected(old('group_by', $group_by) == 'daily')>Daily</option>
                                                <option value="monthly" @selected(old('group_by', $group_by) == 'monthly')>Monthly</option>
                                                <option value="yearly" @selected(old('group_by', $group_by) == 'yearly')>Yearly</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="fee_id" class="form-label">Fee Type<span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="fee_id"
                                                name="fee_id" :allowClear="true" required>
                                                <option value="">Select Fee Type</option>
                                                @foreach ($fees as $fee)
                                                    <option value="{{ $fee->id }}" @selected(old('fee_id', $fee_id) == $fee->id)>
                                                        {{ $fee->name }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="from_date" class="form-label">From Date</x-admin.label>
                                            <input type="date" class="form-control form-control-solid"
                                                name="from_date" id="from_date"
                                                value="{{ old('from_date', $from_date) }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="to_date" class="form-label">To Date</x-admin.label>
                                            <input type="date" class="form-control form-control-solid" name="to_date"
                                                id="to_date" value="{{ old('to_date', $to_date) }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row my-3 align-items-center justify-content-center">
                                    <div class="col-4 text-center">
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 150px;">Filter</button>
                                    </div>
                                    <div class="col-4 text-center">
                                        <a href="{{ route('admin.report.customreport') }}" class="btn btn-primary"
                                            style="width: 150px;">Clear Filter</a>
                                    </div>
                                </div>
                            </form>

                            <!-- Display Results Only If Data Is Available -->
                            @if (isset($incomes) && $incomes->isNotEmpty())
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
                                                                        <small> Custom Report</small>
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
                                        <div class="row mt-3">
                                            <div class="table-responsive p-3 pt-1">
                                                <table class="table table-striped" id="datatable" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" class="text-center">SL</th>
                                                            <th width="30%" class="text-center">Fee Type</th>
                                                            <th width="20%" class="text-center">Group by Data</th>
                                                            <th width="20%" class="text-center">Income</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($incomes as $income)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="text-center">{{ $income->fee_name }}</td>

                                                                @if ($group_by == 'daily')
                                                                    <td class="text-center">{{ $income->day }}</td>
                                                                @elseif ($group_by == 'monthly')
                                                                    <td class="text-center">{{ $income->month }}</td>
                                                                @elseif ($group_by == 'yearly')
                                                                    <td class="text-center">Academic Year - {{ $income->year }}</td>
                                                                @else
                                                                    <td class="text-center">N/A</td>
                                                                @endif

                                                                <td class="text-center">
                                                                    {{ number_format($income->amount, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" style="text-align:end"><strong>Total
                                                                    Amount:
                                                                </strong></td>
                                                            <td class="text-center">
                                                                {{ number_format($totalAmount, 2) }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-4 offset-4 text-center">
                                        <button class="btn btn-primary" onclick="printInvoice();"
                                            style="width: 150px;"><i class="fa fa-print"></i> Print</button>
                                    </div>
                                </div>
                            {{-- @else
                                <h6 class="mt-5 text-center text-warning">No data available. Please apply filters.</h6> --}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-app-layout>
