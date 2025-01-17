<x-admin-app-layout :title="'Monthly Due Report'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Monthly Due Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.report.monthlydue') }}" method="GET" class="filter-form">
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
                                                    <option value="kg" @selected(old('class', $class) == 'kg')>KG</option>
                                                    <option value="0" @selected(old('class', $class) == '0')>Nursery</option>
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
                                            <div class="col-lg-3 col-md-6">
                                                <x-admin.label for="from_month" class="form-label">From
                                                    Month</x-admin.label>
                                                <input type="month" class="form-control form-control-solid"
                                                    name="from_month" id="from_month"
                                                    value="{{ old('from_month', $fromMonth) }}">
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <x-admin.label for="to_month" class="form-label">To
                                                    Month</x-admin.label>
                                                <input type="month" class="form-control form-control-solid"
                                                    name="to_month" id="to_month"
                                                    value="{{ old('to_month', $toMonth) }}">
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
                                @if (count($monthly_dues) < 1 )
                                    <div class="alert alert-warning text-center">
                                        <strong>No data found for the selected filters.</strong>
                                    </div>
                                @else
                                    <div class="container-fluid mt-3" id="printContainer">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Student ID</th>
                                                            <th>Fee Type</th>
                                                            <th>Month</th>
                                                            <th>Due Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($monthly_dues as $monthly_due)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $monthly_due->student_id }}</td>
                                                                <td>{{ $monthly_due->fee_type }}</td>
                                                                <td>{{ implode(', ', $monthly_due->months) }}</td>
                                                                <td>{{ number_format($monthly_due->total_due_amount, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Total
                                                                    Amount:</strong></td>
                                                            <td>{{ number_format($grandTotalDueAmount, 2) }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-4 offset-4 text-center">
                                                <button class="btn btn-primary" onclick="printInvoice();"><i
                                                        class="fa fa-print"></i> Print</button>
                                            </div>
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
