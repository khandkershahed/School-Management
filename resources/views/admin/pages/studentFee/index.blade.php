<x-admin-app-layout :title="'Student Fees'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none mb-5">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Student Fees</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="filterForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name"
                                                name="name" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium_id" class="form-label">Medium <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="medium_id" name="medium_id" :allowClear="true"
                                                required>
                                                <option value="">-- Select Medium --</option>
                                                @foreach ($mediums as $medium)
                                                    <option value="{{ $medium->id }}"
                                                        {{ old('medium_id') == $medium->id ? 'selected' : '' }}>
                                                        {{ $medium->name }}
                                                    </option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option id="class" name="class" :allowClear="true"
                                                required>
                                                <option value=""></option>
                                                @foreach (range(1, 12) as $class)
                                                    <option value="{{ $class }}" @selected(old('class') == $class)>
                                                        {{ $class }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.input type="text" :value="old('roll')" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3 d-flex justify-content-center">
                                            <a href="javascript:void(0)" onclick="fetchFilteredData(event)"
                                                class="btn btn-primary">Check
                                                <i class="fa-regular fa-floppy-disk ps-2"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="card border-0 shadow-none" id="studentFeeContainer">
                        <!-- This will be populated by the AJAX response -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function updatePaySlip() {
                let totalAmount = 0;
                let selectedFees = [];

                // Debugging: log to see if checkboxes are being selected
                console.log('Checkbox clicked');

                // Loop through all selected checkboxes
                $('.fee-checkbox:checked').each(function() {
                    let feeAmount = parseFloat($(this).data('amount')); // Get the fee amount from the checkbox
                    let feeName = $(this).data('name'); // Get the fee name from the label

                    // Add this fee to the selected fees array
                    selectedFees.push({
                        name: feeName,
                        amount: feeAmount
                    });

                    // Add the fee amount to the total
                    totalAmount += feeAmount;
                });

                let paySlipHtml = '';

                if (selectedFees.length > 0) {
                    paySlipHtml += '<div class="card shadow-none mb-5"><div class="card-body"><h4 class="text-center mb-3">Payment Receipt</h4>';

                    // Start a no-border table to align names and amounts
                    paySlipHtml += '<table class="table table-borderless">';
                    selectedFees.forEach(function(fee) {
                        paySlipHtml += `
                <tr>
                    <td style="text-align: left;">${fee.name}</td>
                    <td style="text-align: right;">${fee.amount}</td>
                </tr>
            `;
                    });

                    // Add total amount row at the bottom
                    paySlipHtml += `
            <tr style-"border-top: 1px solid black !important;">
                <td style="text-align: right;"><strong>Total</strong></td>
                <td style="text-align: right;"><strong>${totalAmount}</strong></td>
            </tr> </div></div>
        `;

                    paySlipHtml += '</table>';
                } else {
                    paySlipHtml = '<p>No fees selected.</p>';
                }

                // Update the paySlip div with the generated HTML
                $('#paySlip').html(paySlipHtml);
            }

            $(document).ready(function() {
                updatePaySlip();
            });
        </script>
        <script>
            function fetchFilteredData(e) {
                e.preventDefault(); // Prevent form submission
                var formData = $('#filterForm').serialize(); // Serialize the form data

                // Log form data to check if it's being sent correctly
                // console.log("Sending form data: ", formData);

                $.ajax({
                    url: '{{ route('admin.student.filter') }}', // Your route here
                    method: 'GET',
                    data: formData, // Send serialized form data
                    success: function(response) {
                        // Log the response from the server for debugging
                        // console.log("Response received: ", response);

                        // Check if the response is empty
                        if (response.trim() === '') {
                            alert('No data found.');
                        } else {
                            // Update the container with the new data
                            $('#studentFeeContainer').html(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Log any error in the request
                        console.error("Error in AJAX request:", status, error);
                        alert('Error fetching data');
                    }
                });
            }
        </script>
    @endpush
</x-admin-app-layout>
