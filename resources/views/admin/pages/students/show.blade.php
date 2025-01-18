<x-admin-app-layout :title="'Student Details'">
    <section class="content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center mb-2">
                                <img class="profile-user-img img-fluid img-circle" width="100px"
                                    src="{{ optional($student)->image && file_exists(public_path('storage/' . $student->image)) ? asset('storage/' . $student->image) : asset('images/no_image.png') }}"
                                    alt="User profile picture">
                            </div>
                            <h4 class="profile-username text-center">{{ $student->name }}</h4>
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
                                Student Type: {{ ucfirst($student->student_type) }}
                            </p>

                            <hr>
                            <strong></i> Guardian Information</strong>

                            <p class="text-muted">
                                <strong>Father's Name :</strong>{{ $student->guardian_name }}; <br>
                                <strong>Father's Contact Number :</strong> {{ $student->guardian_contact }};
                            </p>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-md-9">
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
                                        aria-controls="pills-profile" aria-selected="false">Set Package Waiver</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-others-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-others" type="button" role="tab"
                                        aria-controls="pills-others" aria-selected="false">Set Others Waiver</button>
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
                                            <table class="table table-bordered datatable table-striped">
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
                                                                <td>{{ optional($feeId->fee)->name }}</td>
                                                                <td>{{ $feeId->status }}</td>
                                                                <td>{{ $feeId->invoice_number }}</td>
                                                                <td>{{ $feeId->amount }}</td>
                                                                <td>{{ $feeId->paid_at }}</td>
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

                                                        <span class="ps-3">{{ $fee->name }} &nbsp; : &nbsp;
                                                            &nbsp;
                                                            {{ $fee->amount }}</span>
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

                                    @include('admin.pages.students.partials.waiver')
                                </div>
                                <div class="tab-pane fade" id="pills-others" role="tabpanel"
                                    aria-labelledby="pills-others-tab">

                                    @include('admin.pages.students.partials.otherwaiver')
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>


</x-admin-app-layout>
