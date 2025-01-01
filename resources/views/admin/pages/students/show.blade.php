<x-admin-app-layout :title="'Student Details'">
    <section class="content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" width="130px"
                                    src="{{ optional($student)->image && file_exists(public_path('storage/' . $student->image)) ? asset('storage/' . $student->image) : asset('images/no_image.png') }}"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $student->name }}</h3>
                            <p class="text-center">Student ID : {{ $student->student_id }}</p>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Student Information</h3>
                        </div>

                        <div class="card-body">
                            <strong> Basic Info</strong>

                            <p class="text-muted">
                                Medium : {{ $student->medium }}; Class : {{ $student->class }}; Section :
                                {{ $student->section }}; Group : {{ $student->group }}; Roll : {{ $student->roll }};
                            </p>

                            <hr>
                            <strong></i> Guardian Information</strong>

                            <p class="text-muted">
                                Father's Name : {{ $student->guardian_name }}; <br>
                                Father's Contact Number : {{ $student->guardian_contact }};
                            </p>
                            <hr>
                            {{-- <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                            <p class="text-muted">Malibu, California</p>

                            <hr> --}}
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">Payment History</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">Set Waiver</button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
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
                                                    @if ($student->paidFees->count() > 0)
                                                        @foreach ($student->paidFees as $feeId)
                                                            <tr>
                                                                <td>{{ $fee->name }}</td>
                                                                <td>{{ $studentFee->status }}</td>
                                                                <td>{{ $studentFee->invoice_number }}</td>
                                                                <td>{{ $fee->amount }}</td>
                                                                <td>{{ $studentFee->paid_at }}</td>
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

                                    <!-- Due Fees Section -->
                                    <div class="row mb-5">
                                        <h5 class="fw-bold text-center mb-3">Due Fees</h5>
                                        @foreach ($dueFees as $fee)
                                            @php
                                                // Check if there's a waiver for this fee
                                                $waiver = isset($waiversLookup[$fee->id])
                                                    ? $waiversLookup[$fee->id]
                                                    : null;
                                            @endphp
                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info"
                                                    style="text-align: start !important;">
                                                    <label class="form-check-label" for="fee_id_{{ $fee->id }}">
                                                        {{-- <input class="form-check-input ms-3 fee-checkbox"
                                                            type="checkbox" name="fee_id[]" onchange="updatePaySlip()"
                                                            value="{{ $fee->id }}" id="fee_id_{{ $fee->id }}"
                                                            data-amount="{{ $fee->amount }}"
                                                            data-name="{{ $fee->name }}"> --}}
                                                        <span class="ps-3">{{ $fee->name }} &nbsp; : &nbsp;
                                                            &nbsp;
                                                            {{ $fee->amount }}</span>

                                                        <!-- Check if there's a waiver -->
                                                        @if ($waiver)
                                                            <span class="badge bg-warning ms-2">Waived:
                                                                {{ $waiver->amount }}</span>
                                                            <input type="hidden"
                                                                name="waiver_amount[{{ $fee->id }}]"
                                                                value="{{ $waiver->amount }}">
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                        <input type="hidden" name="amount" class="amount" value="">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    {{-- <form action="{{ route('admin.fee-waiver.store') }}" method="POST"
                                        class="form-horizontal">
                                        @csrf
                                        <div class="table-responsive mb-4">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <th></th>
                                                    <th>Fee Name</th>
                                                    <th>Amount</th>
                                                    <th>Waived Amount</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($fees as $fee)
                                                        <tr>
                                                            <td>
                                                                <input class="form-check-input ms-3 fee-checkbox"
                                                                    type="checkbox" name="fee_id[]"
                                                                    value="{{ $fee->id }}"
                                                                    id="fee_id_{{ $fee->id }}">
                                                            </td>
                                                            <td>{{ $fee->name }}</td>
                                                            <td>{{ $fee->amount }}</td>
                                                            <td>
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $student->id }}">
                                                                <x-admin.input type="number" step="0.01"
                                                                    placeholder="Waived Amount"
                                                                    id="amount_{{ $fee->id }}"
                                                                    name="amount[{{ $fee->id }}]"
                                                                    value="{{ old('amount.' . $fee->id) }}" required>
                                                                </x-admin.input>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form> --}}
                                    <form action="{{ route('admin.fee-waiver.store') }}" method="POST"
                                        class="form-horizontal">
                                        @csrf
                                        <div class="table-responsive mb-4">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <th></th>
                                                    <th>Fee Name</th>
                                                    <th>Amount</th>
                                                    <th>Waived Amount</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($fees as $fee)
                                                        @php
                                                            // Check if there is a waiver for this student and fee
                                                            $waiver = \App\Models\StudentFeeWaiver::where(
                                                                'student_id',
                                                                $student->id,
                                                            )
                                                                ->where('fee_id', $fee->id)
                                                                ->first();
                                                        @endphp

                                                        <tr>
                                                            <td>
                                                                <input class="form-check-input ms-3 fee-checkbox"
                                                                    type="checkbox" name="fee_id[]"
                                                                    value="{{ $fee->id }}"
                                                                    id="fee_id_{{ $fee->id }}"
                                                                    @if ($waiver) checked @endif>
                                                            </td>
                                                            <td>{{ $fee->name }}</td>
                                                            <td>{{ $fee->amount }}</td>
                                                            <td>
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $student->id }}">
                                                                <x-admin.input type="number" step="0.01"
                                                                    placeholder="Waived Amount"
                                                                    id="amount_{{ $fee->id }}"
                                                                    name="amount[{{ $fee->id }}]"
                                                                    value="{{ old('amount.' . $fee->id, $waiver ? $waiver->amount : '') }}"
                                                                    required>
                                                                </x-admin.input>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
</x-admin-app-layout>
