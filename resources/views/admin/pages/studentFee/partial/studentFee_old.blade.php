{{-- <div class="card-body">
    <form action="{{ route('admin.student-fee.store') }}" method="post">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ date('Y') }}">
        <input type="hidden" name="month" value="{{ date('m') }}">
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="row mb-5">
                    <div class="col-12 mb-5">
                        <h5 class="text-center">
                            <strong>Student Name :</strong> {{ $student->name }}
                        </h5>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-6 mb-4">
                        <h6><strong>Student ID :</strong> {{ $student->student_id }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Medium :</strong>
                            {{ optional($student)->medium }}</h6>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                    <h6><strong>Class :</strong> {{ $student->class }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Roll :</strong> {{ $student->roll }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Group :</strong> {{ $student->group }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Gender :</strong> {{ $student->gender }}</h6>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Father's Name :</strong> {{ $student->guardian_name }}</h6>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Father's Number :</strong> {{ $student->guardian_contact }}</h6>
                    </div>
                </div>

                <div class="row">
                    @foreach ($fees as $fee)
                        <div class="col-lg-4 col-md-6">
                            <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info"
                                style="text-align: start !important;">
                                <label class="form-check-label" for="fee_id_{{ $fee->id }}">
                                    <input class="form-check-input ms-3 fee-checkbox" type="checkbox" name="fee_id[]"
                                        onchange="updatePaySlip()" value="{{ $fee->id }}"
                                        id="fee_id_{{ $fee->id }}" data-amount="{{ $fee->amount }}"
                                        data-name="{{ $fee->name }}">
                                    <span class="ps-3">{{ $fee->name }} &nbsp; : &nbsp; &nbsp;
                                        {{ $fee->amount }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4" id="paySlip">
                <!-- This will be updated dynamically -->
                <h4 class="text-danger text-center">No fees selected.</h4>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 d-flex justify-content-center">
                <x-admin.button type="submit" class="primary">
                    {{ __('Pay Now') }}
                </x-admin.button>
            </div>
        </div>
    </form>
</div> --}}


{{-- <div class="card-body">
    <form action="{{ route('admin.student-fee.store') }}" method="post">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ date('Y') }}">
        <input type="hidden" name="month" value="{{ date('M') }}">
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="row mb-5">
                    <div class="col-12 mb-5">
                        <h5 class="text-center">
                            <strong>Student Name :</strong> {{ $student->name }}
                        </h5>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-6 mb-4">
                        <h6><strong>Student ID :</strong> {{ $student->student_id }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Medium :</strong>
                            {{ optional($student)->medium }}</h6>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                        <h6><strong>Class :</strong> {{ $student->class }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Roll :</strong> {{ $student->roll }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Group :</strong> {{ $student->group }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Gender :</strong> {{ $student->gender }}</h6>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Father's Name :</strong> {{ $student->guardian_name }}</h6>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Father's Number :</strong> {{ $student->guardian_contact }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" id="paySlip">
                <!-- This will be updated dynamically -->
                <h4 class="text-danger text-center">No fees selected.</h4>
            </div>
        </div>
        <div class="row mb-5">
            <h5 class="fw-bold text-center">Paid Fees</h5>
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

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h5 class="fw-bold text-center">Due Fees</h5>
            @foreach ($fees as $fee)
                @php
                    // Check if there's a waiver for this fee
                    $waiver = isset($waiversLookup[$fee->id]) ? $waiversLookup[$fee->id] : null;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info"
                        style="text-align: start !important;">
                        <label class="form-check-label" for="fee_id_{{ $fee->id }}">
                            <input class="form-check-input ms-3 fee-checkbox" type="checkbox" name="fee_id[]"
                                onchange="updatePaySlip()" value="{{ $fee->id }}"
                                id="fee_id_{{ $fee->id }}" data-amount="{{ $fee->amount }}"
                                data-name="{{ $fee->name }}">
                            <span class="ps-3">{{ $fee->name }} &nbsp; : &nbsp; &nbsp;
                                {{ $fee->amount }}</span>

                            <!-- Check if there's a waiver -->
                            @if ($waiver)
                                <span class="badge bg-warning ms-2">Waived: {{ $waiver->amount }}</span>
                                <input type="hidden" name="waiver_amount[{{ $fee->id }}]"
                                    value="{{ $waiver->amount }}">
                            @endif
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="mb-3 d-flex justify-content-center">
                <x-admin.button type="submit" class="primary">
                    {{ __('Pay Now') }}
                </x-admin.button>
            </div>
        </div>
    </form>
</div> --}}


<div class="card-body">
    <form action="{{ route('admin.student-fee.store') }}" method="post">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ date('Y') }}">
        <input type="hidden" name="month" value="{{ date('M') }}">
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="row mb-5">
                    <div class="col-12 mb-5">
                        <h5 class="text-center">
                            <strong>Student Name :</strong> {{ $student->name }}
                        </h5>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-6 mb-4">
                        <h6><strong>Student ID :</strong> {{ $student->student_id }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Medium :</strong> {{ optional($student)->medium }}</h6>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                        <h6><strong>Class :</strong> {{ $student->class }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Roll :</strong> {{ $student->roll }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Group :</strong> {{ $student->group }}</h6>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Gender :</strong> {{ $student->gender }}</h6>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Father's Name :</strong> {{ $student->guardian_name }}</h6>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 mb-4">
                        <h6><strong>Father's Number :</strong> {{ $student->guardian_contact }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" id="paySlip">
                <!-- This will be updated dynamically -->
                <h4 class="text-danger text-center">No fees selected.</h4>
            </div>
        </div>

        <!-- Paid Fees Section -->
        <div class="row mb-5">
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
                        @if ($paidFees->count() > 0)
                            @foreach ($paidFees as $feeId)
                                @php
                                    $fee = \App\Models\Fee::find($feeId);
                                    $studentFee = \App\Models\StudentFee::where('student_id', $student->id)
                                        ->where('fee_id', $feeId)
                                        ->first();
                                @endphp
                                @if ($fee && $studentFee)
                                    <tr>
                                        <td>{{ $fee->name }}</td>
                                        <td>{{ $studentFee->status }}</td>
                                        <td>{{ $studentFee->invoice_number }}</td>
                                        <td>{{ $fee->amount }}</td>
                                        <td>{{ $studentFee->paid_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                        <td colspan="5">
                            <h6 class="text-center">No Paid Fees</h6>
                        </td>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Due Fees Section -->
        <div class="row mb-5">
            <h5 class="fw-bold text-center mb-3">Due Fees</h5>
            @foreach ($dueFees as $fee)
                @php
                    // Check if there's a waiver for this fee
                    $waiver = isset($waiversLookup[$fee->id]) ? $waiversLookup[$fee->id] : null;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info"
                        style="text-align: start !important;">
                        <label class="form-check-label" for="fee_id_{{ $fee->id }}">
                            <input class="form-check-input ms-3 fee-checkbox" type="checkbox" name="fee_id[]"
                                onchange="updatePaySlip()" value="{{ $fee->id }}" id="fee_id_{{ $fee->id }}"
                                data-amount="{{ ($waiver) ? $waiver->amount  : $fee->amount }}" data-name="{{ $fee->name }}">
                            <span class="ps-3" @if($waiver)style="text-decoration: line-through;"@endif >{{ $fee->name }} &nbsp; : &nbsp; &nbsp;
                                {{ $fee->amount }}</span>

                            <!-- Check if there's a waiver -->
                            @if ($waiver)
                                <span class="ms-2">Waived Amount: {{ $waiver->amount }}</span>
                                <input type="hidden" name="waiver_amount[{{ $fee->id }}]"
                                    value="{{ $waiver->amount }}">
                            @endif
                        </label>
                    </div>
                </div>
            @endforeach
            <input type="hidden" name="amount" class="amount" value="">
        </div>

        <div class="row"> 
            <div class="mb-3 d-flex justify-content-center">
                <x-admin.button type="submit" class="primary">
                    {{ __('Pay Now') }}
                </x-admin.button>
            </div>
        </div>
    </form>
</div>
