<form action="{{ route('admin.fee-waiver.store') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped">
            @php
                $packagewaiver = \App\Models\StudentFeeWaiver::where('student_id', $student->id)
                    ->where('fee_id', $package_fees->first()->id)
                    ->select('package_percentage', 'package_amount')
                    ->first();
            @endphp
            <thead>
                <tr>
                    <td>{{ $package }}</td>
                    <td>{{ $package_fees->sum('amount') }}</td>
                    <td>
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <x-admin.input type="number" step="0.01" placeholder="Waived Percentage"
                            data-amount="{{ $package_fees->sum('amount') }}" id="package_waived_percentage"
                            name="package_percentage" :value="optional($packagewaiver)->package_percentage" required>
                        </x-admin.input>
                    </td>
                    <td>
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <x-admin.input type="number" step="0.01" placeholder="Waived Amount"
                            id="package_waived_amount" name="package_amount" :value="optional($packagewaiver)->package_amount" required>
                        </x-admin.input>
                    </td>
                </tr>

                <tr>
                    {{-- <th></th> --}}
                    <th>Fee Name</th>
                    <th>Amount</th>
                    <th>Waived Percentage</th>
                    <th>Waived Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($package_fees as $package_fee)
                    @php
                        $waiver = \App\Models\StudentFeeWaiver::where('student_id', $student->id)
                            ->where('fee_id', $package_fee->id)
                            ->first();
                    @endphp
                    <tr>
                        {{-- <td>
                            <input class="form-check-input ms-3 fee-checkbox" type="checkbox" name="fee_id[]"
                                value="{{ $package_fee->id }}" id="fee_id_{{ $package_fee->id }}"
                                @if ($waiver) checked @endif>
                        </td> --}}
                        <td>{{ $package_fee->name }}</td>
                        <td>{{ $package_fee->amount }}</td>
                        <td>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="fee_id[]" value="{{ $package_fee->id }}"
                                id="fee_id_{{ $package_fee->id }}">
                            <input class="form-control form-control-solid waiver-percentage" type="number" readonly
                                step="0.01" placeholder="Waived Percentage" id="percentage_{{ $package_fee->id }}"
                                name="percentage[{{ $package_fee->id }}]" data-amount="{{ $package_fee->amount }}"
                                value="{{ old('percentage.' . $package_fee->id, $waiver ? $waiver->percentage : '') }}"
                                required>
                            </input>
                        </td>
                        <td>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="number" step="0.01" placeholder="Waived Amount" readonly
                                id="amount_{{ $package_fee->id }}" name="amount[{{ $package_fee->id }}]"
                                value="{{ old('amount.' . $package_fee->id, $waiver ? $waiver->amount : '') }}"
                                required class="form-control form-control-solid waiver-amount">
                            </input>
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

<!-- Add this JavaScript at the bottom of the page -->

@push('scripts')
    <script>
        $(document).ready(function() {
            // When the package waived percentage is updated
            $('#package_waived_percentage').on('input', function() {
                var packagePercentage = parseFloat($(this).val()) || 0;

                // Update all fee percentage fields with the package's waived percentage
                $('.waiver-percentage').each(function() {
                    $(this).val(packagePercentage.toFixed(
                        2)); // Set the same percentage for all fees
                    updateWaivedAmount($(
                        this)); // Update the waived amount based on the new percentage
                });

                // Recalculate the total waived amount
                calculateTotalWaivedAmount();
            });

            // When an individual fee's percentage is updated
            $('.waiver-percentage').on('input', function() {
                updateWaivedAmount($(this)); // Update the waived amount for this specific fee
                // Recalculate the total waived amount after updating a single fee
                calculateTotalWaivedAmount();
            });

            // Function to update the waived amount based on the percentage and fee amount
            function updateWaivedAmount(input) {
                var percentage = parseFloat(input.val()) ||
                    0; // Get the percentage value (either from package or individual fee)
                var feeAmount = parseFloat(input.data('amount')) ||
                    0; // Get the fee amount from data-amount attribute
                var waivedAmount = (feeAmount * percentage) / 100; // Calculate the waived amount

                // Set the calculated waived amount
                input.closest('tr').find('.waiver-amount').val(waivedAmount.toFixed(
                    2)); // Set the waived amount in the corresponding input
            }

            // Function to calculate the total waived amount for all fees in the package
            function calculateTotalWaivedAmount() {
                var totalWaivedAmount = 0;

                // Sum all the waived amounts
                $('.waiver-amount').each(function() {
                    totalWaivedAmount += parseFloat($(this).val()) || 0;
                });

                // Set the total waived amount in the package_waived_amount field
                $('#package_waived_amount').val(totalWaivedAmount.toFixed(2));
            }
        });
    </script>
@endpush
