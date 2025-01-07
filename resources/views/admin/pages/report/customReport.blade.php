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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Display General Errors -->
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('admin.report.customreport') }}" method="GET" class="filter-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="year" class="form-label">Academic Year<span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="year" name="year" :allowClear="true"
                                                required>
                                                <option value="">Select Academic Year</option>
                                                @for ($year = 2025; $year <= 2030; $year++)
                                                    <option value="{{ $year }}" @selected(date('Y', $year) == $year)>
                                                        Academic Year {{ $year }}
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

                                <div class="row mt-3">
                                    <div class="col-4 offset-4 text-center">
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 150px;">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <div class="row mt-3">
                                <div class="table-responsive p-3 pt-1">
                                    <table class="table table-striped datatable" style="width:100%">
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
                                                        <td class="text-center">{{ $income->year }}</td>
                                                    @else
                                                        <td class="text-center">N/A</td>
                                                    @endif

                                                    <td class="text-center">{{ number_format($income->amount, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align:end"><strong>Total Amount:
                                                    </strong></td>
                                                <td class="text-center">{{ number_format($totalAmount, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
