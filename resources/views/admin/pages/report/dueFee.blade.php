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
                                @csrf
                                <div class="row">
                                    <!-- Class Filter -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class</x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true">
                                                <option value="">-- Select Class --</option>
                                                @foreach(['nursery', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $classOption)
                                                    <option value="{{ $classOption }}" @selected(old('class', $class) == $classOption)>
                                                        {{ ucfirst($classOption) }}
                                                    </option>
                                                @endforeach
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
                                        <button type="submit" class="btn btn-primary" style="width: 150px;">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <div class="container-fluid" id="printContainer">
                                <div style="padding-left:35px;padding-right:35px;">
                                    <div class="row">
                                        <div style="width:100%; padding:0px; margin:0px;">
                                            <table style=" width:100%; background-color: #f0f3f5 !important; border-radius: 10px; margin-bottom: 20px; padding: 20px 30px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:10%;text-align:center;">
                                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_color_no_bg.png'))) }}"
                                                                alt="" height="80px" width="80px">
                                                        </td>
                                                        <td style="width:80%; text-align:center;">
                                                            <h3 class="text-muted mb-3 pt-2"><strong>Shamsul Hoque Khan School and College</strong></h3>
                                                            <h6 class="text-muted mb-2">Paradogair, Matuail, Demra, Dhaka-1362</h6>
                                                            <h3 class="text-info mb-2 pb-2"><i class="fa fa-bar-chart"></i> Due Fee Report</h3>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row p-3 pt-1">
                                        <!-- Table -->
                                        <table class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">SL</th>
                                                    <th class="text-center">Fee</th>
                                                    <th class="text-center">Student ID</th>
                                                    <th class="text-center">Student Name</th>
                                                    <th class="text-center">Month</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $key => $student)
                                                    @foreach (array_merge($dueMonthlyFees[$student->id] ?? [], $dueYearlyFees[$student->id] ?? []) as $fee)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-center">{{ $fee->fee->name }}</td>
                                                            <td class="text-center">{{ $student->student_id }}</td>
                                                            <td class="text-center">{{ $student->name }}</td>
                                                            <td class="text-center">{{ $fee->month ?? 'Annual' }}</td>
                                                            <td class="text-center">{{ $fee->amount }}</td>
                                                            <td class="text-center">{{ $fee->status }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

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
