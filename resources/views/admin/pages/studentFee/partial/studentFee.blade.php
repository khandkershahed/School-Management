<div class="card-body">
    <form action="{{ route('admin.student-fee.store') }}" method="post" id="paymentForm">
        @csrf
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="row mb-3">
                    <div class="col-12 mb-4">
                        <div class="border p-4 rounded" style="border-color: #eee;">
                            <h3 class="text-center text-primary mb-3">
                                <strong>Student Information</strong>
                            </h3>
                            <h5 class="text-center text-muted">
                                <strong>Student Name:</strong> {{ $student->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Student ID:</strong> {{ $student->student_id }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Medium:</strong> {{ optional($student)->medium }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Class:</strong> {{ $student->class }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Roll:</strong> {{ $student->roll }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Group:</strong> {{ $student->group }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Gender:</strong> {{ $student->gender }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Father's Name:</strong> {{ $student->guardian_name }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-2">
                        <div class="border p-3 rounded" style="border-color: #eee;">
                            <h6><strong>Father's Number:</strong> {{ $student->guardian_contact }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" id="paySlip">
                <h4 class="text-danger text-center">No fees selected.</h4>
            </div>
        </div>

        <!-- Paid Fees Section -->
        <div class="row mb-3">
            <h5 class="fw-bold text-center mb-3">Paid Fees</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Fee Name</th>
                        <th>Payment Status</th>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Paid at</th>
                    </thead>
                    <tbody>
                        @if ($studentpaidFees->count() > 0)
                            @foreach ($studentpaidFees as $paidFee)
                                <tr>
                                    <td>
                                        {{ optional($paidFee->fee)->name }} @if (optional($paidFee->fee)->fee_type == 'monthly')
                                            ({{ $paidFee->month }})
                                        @endif
                                    </td>
                                    <td>{{ $paidFee->status }}</td>
                                    <td>{{ $paidFee->invoice_number }}</td>
                                    <td>{{ optional($paidFee->fee)->amount }}</td>
                                    <td>{{ $paidFee->paid_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">
                                    <h6 class="text-center">No Paid Fees</h6>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ date('Y') }}">
        <input type="hidden" name="month" value="{{ date('F') }}">

        <!-- Due Fees Section -->
        <div class="row mb-5">
            <!-- Monthly Fees Section -->
            <div class="col-lg-12">
                <h5 class="fw-bold text-center mb-3">Monthly Fees</h5>
                <div class="row border bg-light-primary p-3 mb-2">
                    @foreach ($monthly_fees as $monthly_fee)
                        @php
                            $waiver = isset($waiversLookup[$monthly_fee->id]) ? $waiversLookup[$monthly_fee->id] : null;
                            $isMonthlyFee = $monthly_fee->fee_type === 'monthly';
                            $paidMonths = $monthly_fee->paidMonths($student->id);
                        @endphp
                        <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info">
                            <label class="form-check-label mt-2" for="fee_id_{{ $monthly_fee->id }}">
                                @if ($isMonthlyFee == false)
                                    <input class="form-check-input ms-3 mt-0 fee-checkbox" type="checkbox"
                                        name="fee_id[]" onchange="updatePaySlip()" value="{{ $monthly_fee->id }}"
                                        id="fee_id_{{ $monthly_fee->id }}"
                                        data-amount="{{ $waiver ? $monthly_fee->amount - $waiver->amount : $monthly_fee->amount }}"
                                        data-name="{{ $monthly_fee->name }}" data-type="{{ $monthly_fee->fee_type }}">
                                @endif
                                <span class="ps-3">{{ $monthly_fee->name }} &nbsp; : &nbsp; &nbsp;
                                    {{ $monthly_fee->amount }}</span>

                                <!-- Waiver Information -->
                                @if ($waiver)
                                    <span class="ms-2 text-info">Waived Amount: {{ $waiver->amount }}</span>
                                    <input type="hidden" name="waiver_amount[{{ $monthly_fee->id }}]"
                                        value="{{ $waiver->amount }}">
                                @endif
                            </label>
                        </div>

                        <!-- Monthly Fee Month Selection -->
                        @if ($isMonthlyFee)
                            <div class="month-selection mt-2" id="month-selection-{{ $monthly_fee->id }}">
                                <p class="mb-2 text-center"><strong>Select Months:</strong></p>
                                <div class="row">
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                        <div class="col-lg-2 mb-2">
                                            <div class="form-check ps-1">
                                                <label class="form-check-label mt-2"
                                                    for="month_{{ $monthly_fee->id }}_{{ $index + 1 }}">
                                                    <input class="form-check-input ms-3 mt-0 fee-checkbox"
                                                        type="checkbox" onchange="updatePaySlip()"
                                                        name="months[{{ $monthly_fee->id }}][]"
                                                        value="{{ $index + 1 }}"
                                                        id="month_{{ $monthly_fee->id }}_{{ $index + 1 }}"
                                                        data-amount="{{ $waiver ? $monthly_fee->amount - $waiver->amount : $monthly_fee->amount }}"
                                                        data-name="{{ $monthly_fee->name }}({{ $month }})"
                                                        data-type="{{ $monthly_fee->fee_type }}"
                                                        @if (in_array($index + 1, $paidMonths)) disabled checked @endif>
                                                    <span class="ps-2 pt-0">{{ $month }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Package Fees Section -->
            @if ($dueFees->count() > 0)
                <div class="col-lg-12 mt-5">
                    <h5 class="fw-bold text-center mb-3">Package Fees</h5>
                    <div class="row">
                        <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info">
                            <label class="form-check-label mt-2" for="packageCheck">
                                <input class="form-check-input ms-3 mt-0" type="checkbox" id="packageCheck"
                                    onchange="toggleFeeCheckboxes(this)">
                                <span class="ps-3">{{ $package_name }} &nbsp; : &nbsp; &nbsp;
                                    {{ $dueFees->sum('amount') }}</span>
                            </label>
                        </div>
                        @foreach ($dueFees as $fee)
                            @if (!empty($fee->fee_package))
                                @php
                                    $waiver = isset($waiversLookup[$fee->id]) ? $waiversLookup[$fee->id] : null;
                                @endphp
                                <div class="col-lg-4 col-md-6">
                                    <div
                                        class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-left text-info">
                                        <label class="form-check-label mt-2" for="fee_id_{{ $fee->id }}">
                                            <input class="form-check-input ms-3 mt-0 fee-checkbox fee-Package"
                                                type="checkbox" name="fee_id[]" onchange="updatePaySlip()"
                                                value="{{ $fee->id }}" id="fee_id_{{ $fee->id }}"
                                                data-amount="{{ $waiver ? $fee->amount - $waiver->amount : $fee->amount }}"
                                                data-name="{{ $fee->name }}" data-type="{{ $fee->fee_type }}">

                                            <span class="ps-3">{{ $fee->name }} &nbsp; : &nbsp; &nbsp;
                                                {{ $fee->amount }}</span>

                                            <!-- Waiver Information -->
                                            @if ($waiver)
                                                <span class="ms-2 text-info">Waived Amount:
                                                    {{ $waiver->amount }}</span>
                                                <input type="hidden" name="waiver_amount[{{ $fee->id }}]"
                                                    value="{{ $waiver->amount }}">
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif


            <!-- Other Fees Section -->
            <div class="col-lg-12 mt-5">
                <h5 class="fw-bold text-center mb-3">Other Fees</h5>
                <div class="row">
                    @foreach ($recurring_fees as $recurring_fee)
                        @php
                            $waiver = isset($waiversLookup[$recurring_fee->id])
                                ? $waiversLookup[$recurring_fee->id]
                                : null;
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info">
                                <label class="form-check-label mt-2" for="fee_id_{{ $recurring_fee->id }}">
                                    <input class="form-check-input ms-3 mt-0 fee-checkbox" type="checkbox"
                                        name="fee_id[]" onchange="updatePaySlip()" value="{{ $recurring_fee->id }}"
                                        id="fee_id_{{ $recurring_fee->id }}"
                                        data-amount="{{ $waiver ? $recurring_fee->amount - $waiver->amount : $recurring_fee->amount }}"
                                        data-name="{{ $recurring_fee->name }}"
                                        data-type="{{ $recurring_fee->fee_type }}">

                                    <span class="ps-3">{{ $recurring_fee->name }} &nbsp; : &nbsp; &nbsp;
                                        {{ $recurring_fee->amount }}</span>

                                    <!-- Waiver Information -->
                                    @if ($waiver)
                                        <span class="ms-2 text-info">Waived Amount: {{ $waiver->amount }}</span>
                                        <input type="hidden" name="waiver_amount[{{ $recurring_fee->id }}]"
                                            value="{{ $waiver->amount }}">
                                    @endif
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>




        <!-- Pay Now Button -->
        <div class="row">
            <div class="mb-3 d-flex justify-content-center">
                <a href="javascript:void(0)" class="btn btn-success" onclick="confirmPayment(event)">Pay Now</a>
            </div>
        </div>
    </form>
</div>

<!-- Scripts for dynamic updates -->
