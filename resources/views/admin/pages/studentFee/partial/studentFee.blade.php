<div class="card-body">
    <form action="{{ route('admin.student-fee.store') }}" method="post">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ date('Y') }}">
        <input type="hidden" name="month" value="{{ date('m') }}">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="table-responsive p-3 pt-1">
                        <table class="table no-border border-0" style="width:70%">
                            <tbody>
                                <tr>
                                    <td class="text-center"><strong>Student Name :</strong> {{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Medium :</strong>
                                        {{ optional($student->medium)->name }}
                                    </td>
                                    <td class="text-start"><strong>Class :</strong> {{ $student->class }}</td>
                                    <td class="text-start"><strong>Roll :</strong> {{ $student->roll }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    @foreach ($fees as $fee)
                        <div class="col-lg-4 col-md-6">
                            <div class="form-check ps-0 border bg-light-primary p-3 rounded-2 text-center text-info"
                                style="text-align: start !important;">
                                <label class="form-check-label" for="fee_id_{{ $fee->id }}">
                                    <input class="form-check-input ms-3 fee-checkbox" type="checkbox" name="fee_id[]" onchange="updatePaySlip()"
                                        value="{{ $fee->id }}" id="fee_id_{{ $fee->id }}" data-amount="{{ $fee->amount }}" data-name="{{ $fee->name }}">
                                    <span class="ps-3">{{ $fee->name }} &nbsp; : &nbsp; &nbsp;
                                        {{ $fee->amount }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3" id="paySlip">
                <!-- This will be updated dynamically -->
                <p>No fees selected.</p>
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
</div>


