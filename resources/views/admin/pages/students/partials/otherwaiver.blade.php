<form action="{{ route('admin.fee-waiver.store') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th> <!-- Checkbox column -->
                    <th>Fee Name</th>
                    <th>Amount</th>
                    <th>Waived Amount</th>
                    <th>Waived Percentage</th> <!-- Optional Percentage Column -->
                </tr>
            </thead>
            <tbody>
                @foreach ($fees as $fee)
                    @php
                        // Check if there is a waiver for this student and fee
                        $waiver = \App\Models\StudentFeeWaiver::where('student_id', $student->id)
                            ->where('fee_id', $fee->id)
                            ->first();
                    @endphp
                    <tr>
                        <td>
                            <input class="form-check-input ms-3 fee-checkbox" type="checkbox" name="fee_id[]"
                                value="{{ $fee->id }}" id="fee_id_{{ $fee->id }}"
                                @if ($waiver) checked @endif>
                        </td>
                        <td>{{ $fee->name }}</td>
                        <td>{{ $fee->amount }}</td>
                        <td>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <x-admin.input type="number" step="0.01" placeholder="Waived Amount"
                                id="amount_{{ $fee->id }}" name="amount[{{ $fee->id }}]"
                                value="{{ old('amount.' . $fee->id, $waiver ? $waiver->amount : '') }}" required>
                            </x-admin.input>
                        </td>
                        <td>
                            <x-admin.input type="number" step="0.01" placeholder="Waived Percentage"
                                id="percentage_{{ $fee->id }}" name="percentage[{{ $fee->id }}]"
                                value="{{ old('percentage.' . $fee->id, $waiver ? $waiver->percentage : '') }}">
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Calculate waived amount based on percentage
        $('input[id^="percentage_"]').on('input', function() {
            var percentage = parseFloat($(this).val()) || 0;  // Get the percentage value
            var feeAmount = parseFloat($(this).closest('tr').find('td:eq(2)').text()) || 0;  // Get the fee amount
            var waivedAmount = (percentage * feeAmount) / 100;  // Calculate the waived amount

            $(this).closest('tr').find('input[id^="amount_"]').val(waivedAmount.toFixed(2));  // Set the waived amount
        });

        // Calculate waived percentage based on amount
        $('input[id^="amount_"]').on('input', function() {
            var waivedAmount = parseFloat($(this).val()) || 0;  // Get the waived amount
            var feeAmount = parseFloat($(this).closest('tr').find('td:eq(2)').text()) || 0;  // Get the fee amount
            var percentage = (waivedAmount * 100) / feeAmount;  // Calculate the percentage

            $(this).closest('tr').find('input[id^="percentage_"]').val(percentage.toFixed(2));  // Set the percentage
        });
    });
</script>
@endpush
