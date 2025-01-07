<x-admin-app-layout :title="'Invoice Report'">
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
                                @csrf
                                <div class="row">
                                    <!-- Class Filter -->
                                    <div class="col-lg-3 col-md-4">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class</x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true">
                                                <option value=""></option>
                                                <option value="nursery" @selected(old('class') == 'nursery')>Nursery</option>
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
                                                <option value="12" @selected(old('class') == '12')>Second Year</option>
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
                                                    <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                                        {{ $student->name }} [{{ $student->student_id }}]
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit Filter Button -->
                                <div class="row mt-3">
                                    <div class="col-4 offset-4 text-center">
                                        <button type="submit" class="btn btn-primary" style="width: 150px;">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Invoices Table -->
                            <div class="row mt-3">
                                <div class="table-responsive p-3 pt-1">
                                    <table class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">SL</th>
                                                <th width="15%" class="text-center">Academic Year</th>
                                                <th width="15%" class="text-center">Student</th>
                                                <th width="12%" class="text-center">Class</th>
                                                <th width="12%" class="text-center">Net Amount</th>
                                                <th width="12%" class="text-center">Paid</th>
                                                <th width="12%" class="text-center">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">
                                                        {{ $invoice->year . ' - ' . $invoice->month }}
                                                    </td>
                                                    <td class="text-center">{{ optional($invoice->student)->name }}</td>
                                                    <td class="text-center">{{ optional($invoice->student)->class }}</td>
                                                    <td class="text-center">{{ number_format($invoice->total_amount, 2) }}</td>
                                                    <td class="text-center">{{ number_format($invoice->total_amount, 2) }}</td>
                                                    {{-- <td class="text-center">{{ number_format($invoice->paid_amount ?? 0, 2) }}</td> --}}
                                                    <td class="text-center">
                                                        {{ number_format($invoice->total_amount - ($invoice->paid_amount ?? 0), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="text-align:end"><strong>Total Balance: </strong></td>
                                                <td class="text-center">{{ number_format($total_balance, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                            <!-- Pagination -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    {{ $invoices->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
