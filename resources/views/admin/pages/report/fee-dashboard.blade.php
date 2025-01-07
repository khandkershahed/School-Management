<x-admin-app-layout :title="'Reports'">
    <style>
        /* General Styling for the Card */
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 30px;
        }

        /* Section Titles Styling */
        h3, h4 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        h6 {
            font-size: 1.25rem;
            font-weight: 500;
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        table th {
            background-color: #f2f2f2;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Filters Section */
        .form-control {
            height: 40px;
            font-size: 1rem;
        }

        /* Margin Adjustments */
        .mt-5 {
            margin-top: 3rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mr-3 {
            margin-right: 1rem;
        }

        .ml-3 {
            margin-left: 1rem;
        }

        /* Custom Row Adjustments */
        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-md-3 {
            padding-left: 0;
            padding-right: 0;
        }

        /* Align filter form components */
        .filter-form {
            margin-top: 20px;
        }

        /* Space between report sections */
        .report-section {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .text-info {
            color: #17a2b8;
        }

        .text-primary {
            color: #007bff;
        }

        .text-success {
            color: #28a745;
        }
    </style>

    <section class="app-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar (If you need it, you can add it here) -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center text-info">Fee Collection Dashboard</h3>
                        </div>

                        <div class="card-body">
                            <!-- Filters Section -->
                            <form action="{{ route('admin.fee-reports') }}" method="GET" class="filter-form">
                                @csrf
                                <div class="row">
                                    <!-- Medium Filter (Bangla/English/College) -->
                                    <div class="col-md-3">
                                        <label for="medium">Medium</label>
                                        <select class="form-control" name="medium" id="medium">
                                            <option value="">Select Medium</option>
                                            <option value="Bangla" {{ request('medium') == 'Bangla' ? 'selected' : '' }}>Bangla</option>
                                            <option value="English" {{ request('medium') == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="College" {{ request('medium') == 'College' ? 'selected' : '' }}>College</option>
                                        </select>
                                    </div>

                                    <!-- Date Filter -->
                                    <div class="col-md-3">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" name="date" id="date" value="{{ request('date') }}">
                                    </div>

                                    <!-- Class Filter -->
                                    <div class="col-md-3">
                                        <label for="class">Class</label>
                                        <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true" required>
                                                <option value=""></option>
                                                <option value="0" @selected(request('class') == '0')>Nursery</option>
                                                <option value="1" @selected(request('class') == '1')>One</option>
                                                <option value="2" @selected(request('class') == '2')>Two</option>
                                                <option value="3" @selected(request('class') == '3')>Three</option>
                                                <option value="4" @selected(request('class') == '4')>Four</option>
                                                <option value="5" @selected(request('class') == '5')>Five</option>
                                                <option value="6" @selected(request('class') == '6')>Six</option>
                                                <option value="7" @selected(request('class') == '7')>Seven</option>
                                                <option value="8" @selected(request('class') == '8')>Eight</option>
                                                <option value="9" @selected(request('class') == '9')>Nine</option>
                                                <option value="10" @selected(request('class') == '10')>Ten</option>
                                                <option value="11" @selected(request('class') == '11')>First Year</option>
                                                <option value="12" @selected(request('class') == '12')>Second Year
                                                </option>
                                            </x-admin.select-option>
                                    </div>

                                    <!-- Month/Year Filter -->
                                    <div class="col-md-3">
                                        <label for="month">Month</label>
                                        <input type="month" class="form-control" name="month" id="month" value="{{ request('month') }}">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Reports Section -->
                            <div class="mt-5">
                                <!-- Date Wise Collection Report -->
                                <div class="report-section">
                                    <h4 class="text-center text-primary">Date-wise Collection</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Medium</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dateWiseCollection as $row)
                                                <tr>
                                                    <td>{{ $row->paid_at }}</td>
                                                    <td>{{ $row->medium }}</td>
                                                    <td>{{ $row->total_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Class Wise Collection Report -->
                                <div class="report-section">
                                    <h4 class="text-center text-primary">Class-wise Collection</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($classWiseCollection as $row)
                                                <tr>
                                                    <td>
                                                        @foreach ($row->class as $class)
                                                            {{ $class }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $row->total_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Month/Year-wise Collection Report -->
                                <div class="report-section">
                                    <h4 class="text-center text-primary">Month/Year-wise Collection</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Year</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monthYearWiseCollection as $row)
                                                <tr>
                                                    <td>{{ $row->month }}</td>
                                                    <td>{{ $row->year }}</td>
                                                    <td>{{ $row->total_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Total Collection Report -->
                                <div class="text-center">
                                    <h4 class="text-center">Total Collection</h4>
                                    <h6 class="text-center"><strong>Total Amount Collected: </strong>{{ $totalCollection }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin-app-layout>
