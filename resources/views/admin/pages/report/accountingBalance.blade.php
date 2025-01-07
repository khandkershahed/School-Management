<x-admin-app-layout :title="'Accounting Balance Report'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Accounting Balance Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.report.accountingbalance') }}" method="GET"
                                class="filter-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="year" class="form-label">Academic Year<span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="year" name="year" :allowClear="true"
                                                required>
                                                <option value="">Select Academic Year</option>
                                                @for ($year = 2023; $year <= 2027; $year++)
                                                    <option value="{{ $year }}" @selected(old('year', $year) == $year)>
                                                        Academic Year {{ $year }}</option>
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

                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="from_date" class="form-label">From Date </x-admin.label>
                                            <input type="date" class="form-control form-control-solid"
                                                name="from_date" id="from_date"
                                                value="{{ old('from_date', $from_date) }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="to_date" class="form-label">To Date </x-admin.label>
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
                                                <th width="23%" class="text-center">Group by Data</th>
                                                <th width="23%" class="text-center">Income</th>
                                                <th width="23%" class="text-center">Expense</th>
                                                <th width="23%" class="text-center">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($incomes as $income)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>

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
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">{{ number_format($income->amount, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" style="text-align:end"><strong>Total Amount:
                                                    </strong></td>
                                                <td class="text-center"><strong>{{ number_format($totalAmount, 2) }}
                                                    </strong></td>
                                                <td class="text-center"><strong>0 </strong></td>
                                                <td class="text-center"><strong>{{ number_format($totalAmount, 2) }}
                                                    </strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="text-right font-weight-bold">
                                        <p>Total Amount: {{ number_format($totalAmount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
