<div class="card-body">
    <form action="{{ route('admin.student-fee.store') }}" method="post" id="paymentForm">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ date('Y') }}">
        <input type="hidden" name="month" value="{{ date('M') }}">
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="row mb-3">
                    <div class="col-12 mb-4">
                        <div class="border p-4 rounded" style="border-color: #eee;">
                            <h3 class="text-center text-primary mb-5">
                                <strong>Student Information</strong>
                            </h3>
                            <h5 class="text-center text-muted">
                                <strong>Student Name:</strong> {{ $student->name }}
                            </h5>
                        </div>
                    </div>
                    <!-- Other student details like student ID, class, etc. -->
                </div>
            </div>
            <div class="col-lg-4" id="paySlip">
                <h4 class="text-danger text-center">No fees selected.</h4>
            </div>
        </div>

        <!-- Paid Fees Section -->
        <div class="row mb-3">
            <h5 class="fw-bold text-center mb-3">Paid Fees</h5>
            <!-- Table for displaying paid fees -->
        </div>

        <!-- Due Fees Section -->
        <div class="row mb-5">
            <h5 class="fw-bold text-center mb-3">Due Fees</h5>
            @foreach ($dueFees as $fee)
                @php
                    $waiver = isset($waiversLookup[$fee->id]) ? $waiversLookup[$fee->id] : null;
                    $isMonthlyFee = $fee->fee_type === 'monthly';
                    $paidMonths = $fee->paidMonths($student->id);
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info">
                        <label class="form-check-label mt-2" for="fee_id_{{ $fee->id }}">
                            @if ($isMonthlyFee == false)
                                <input class="form-check-input ms-3 mt-0 fee-checkbox" type="checkbox" name="fee_id[]"
                                    onchange="updatePaySlip()" value="{{ $fee->id }}"
                                    id="fee_id_{{ $fee->id }}"
                                    data-amount="{{ $waiver ? $fee->amount - $waiver->amount : $fee->amount }}"
                                    data-name="{{ $fee->name }}" data-type="{{ $fee->fee_type }}">
                            @endif
                            <span class="ps-3">{{ $fee->name }} &nbsp; : &nbsp; &nbsp; {{ $fee->amount }}</span>

                            <!-- Waiver Information -->
                            @if ($waiver)
                                <span class="ms-2 text-info">Waived Amount: {{ $waiver->amount }}</span>
                                <input type="hidden" name="waiver_amount[{{ $fee->id }}]"
                                    value="{{ $waiver->amount }}">
                            @endif
                        </label>
                    </div>

                    <!-- Monthly Fee Month Selection -->
                    @if ($isMonthlyFee)
                        <div class="month-selection mt-2" id="month-selection-{{ $fee->id }}">
                            <p class="mb-2 text-center"><strong>Select Months:</strong></p>
                            <div class="row">
                                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                    <div class="col-4 mb-2">
                                        <div class="form-check ps-1">
                                            <label class="form-check-label mt-2"
                                                for="month_{{ $fee->id }}_{{ $index + 1 }}">
                                                <input class="form-check-input ms-3 mt-0 fee-checkbox" type="checkbox"
                                                    onchange="updatePaySlip()" name="months[{{ $fee->id }}][]"
                                                    value="{{ $index + 1 }}"
                                                    id="month_{{ $fee->id }}_{{ $index + 1 }}"
                                                    data-amount="{{ $waiver ? $fee->amount - $waiver->amount : $fee->amount }}"
                                                    data-name="{{ $fee->name }}({{ $month }})"
                                                    data-type="{{ $fee->fee_type }}"
                                                    @if (in_array($index + 1, $paidMonths)) disabled checked @endif>
                                                <span class="ps-2 pt-0">{{ $month }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
            <input type="hidden" name="amount" class="amount" value="0">
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

