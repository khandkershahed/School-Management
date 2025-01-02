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
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name </x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name"
                                                name="name"></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="student_id" class="form-label">Student ID
                                            </x-admin.label>
                                            <x-admin.input type="text" :value="old('student_id')" id="student_id"
                                                name="student_id"></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium_id" class="form-label">Medium</x-admin.label>
                                            <x-admin.select-option id="medium" name="medium" :allowClear="true">
                                                <option value="">-- Select Medium --</option>
                                                <option value="Bangla" @selected(old('medium') == 'Bangla')>Bangla</option>
                                                <option value="English" @selected(old('medium') == 'English')>English</option>
                                                <option value="College" @selected(old('medium') == 'College')>College</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class </x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" :allowClear="true" multiple required>
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
                                                <option value="12" @selected(old('class') == '12')>Second Year
                                                </option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll </x-admin.label>
                                            <x-admin.input type="text" :value="old('roll')" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3 d-flex justify-content-center">
                                            <a href="javascript:void(0)"
                                            {{-- <a href="javascript:void(0)" onclick="fetchFilteredData(event)" --}}
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
                    paySlipHtml +=
                        '<div class="card shadow-none mb-5"><div class="card-body"><h4 class="text-center mb-3">Payment Receipt</h4>';

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
                    paySlipHtml =
                        '<div class="d-flex align-items-center justify-content-center"><h4 class="text-danger text-center">No fees selected.</h4></div>';
                }

                // Update the paySlip div with the generated HTML
                $('#paySlip').html(paySlipHtml);
                $('.amount').val(totalAmount);

            }

            $(document).ready(function() {
                updatePaySlip();
            });
        </script>
        <script>
            // function fetchFilteredData(e) {
            //     e.preventDefault(); // Prevent form submission
            //     var formData = $('#filterForm').serialize(); // Serialize the form data

            //     $.ajax({
            //         url: '{{ route('admin.student.filter') }}', // Your route here
            //         method: 'GET',
            //         data: formData, // Send serialized form data
            //         success: function(response) {
            //             // Check if the response contains an error message
            //             if (response.error) {
            //                 // Show the alert if the student is not found
            //                 alert(response.error);
            //             } else {
            //                 // Update the container with the new data
            //                 $('#studentFeeContainer').html(response);
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             // Log any error in the request
            //             console.error("Error in AJAX request:", status, error);
            //             alert('Error fetching data');
            //         }
            //     });
            // }
            $(document).ready(function() {
                // Make sure the click event for "Check" works even after new data is loaded.
                // Using event delegation to handle clicks on dynamically injected content
                $(document).on('click', '.btn-primary', function(e) {
                    e.preventDefault(); // Prevent form submission
                    fetchFilteredData(e);
                });

                updatePaySlip();
            });

            function fetchFilteredData(e) {
                e.preventDefault(); // Prevent form submission
                var formData = $('#filterForm').serialize(); // Serialize the form data

                $.ajax({
                    url: '{{ route('admin.student.filter') }}', // Your route here
                    method: 'GET',
                    data: formData, // Send serialized form data
                    success: function(response) {
                        // Check if the response contains an error message
                        if (response.error) {
                            // Show the alert if the student is not found
                            alert(response.error);
                        } else {
                            // Update the container with the new data
                            $('#studentFeeContainer').html(response);

                            // Ensure the event listener for the "Check" button is still functional after AJAX update
                            // No need to do anything extra here since we are using event delegation
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
