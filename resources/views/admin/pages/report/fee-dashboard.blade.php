<x-admin-app-layout :title="'Reports'">
    <section class="app-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center text-info">Fee Collection Dashboard</h3>
                        </div>

                        <div class="card-body">
                            <!-- Filters Section -->
                            <form action="{{ route('admin.fee-reports') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <!-- Medium Filter (Bangla/English/College) -->
                                    <div class="col-md-3">
                                        <label for="medium">Medium</label>
                                        <select class="form-control" name="medium" id="medium">
                                            <option value="">Select Medium</option>
                                            <option value="Bangla"
                                                {{ request('medium') == 'Bangla' ? 'selected' : '' }}>Bangla</option>
                                            <option value="English"
                                                {{ request('medium') == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="College"
                                                {{ request('medium') == 'College' ? 'selected' : '' }}>College</option>
                                        </select>
                                    </div>

                                    <!-- Date Filter -->
                                    <div class="col-md-3">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" name="date" id="date"
                                            value="{{ request('date') }}">
                                    </div>

                                    <!-- Class Filter -->
                                    <div class="col-md-3">
                                        <label for="class">Class</label>
                                        <input type="text" class="form-control" name="class" id="class"
                                            value="{{ request('class') }}" placeholder="Class">
                                    </div>

                                    <!-- Month/Year Filter -->
                                    <div class="col-md-3">
                                        <label for="month">Month</label>
                                        <input type="month" class="form-control" name="month" id="month"
                                            value="{{ request('month') }}">
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
                                <div class="mb-4">
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
                                <div class="mb-4">
                                    <h4 class="text-center text-primary">Class-wise Collection</h4>
                                    <h4>Class-wise Collection</h4>
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
                                <div class="mb-4">
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
