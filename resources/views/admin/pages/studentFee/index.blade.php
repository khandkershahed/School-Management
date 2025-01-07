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
                                    <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">
                                        <div class="mb-3">
                                            <x-admin.label for="student_id" class="form-label">Student
                                                ID</x-admin.label>
                                            <x-admin.input type="text" :value="old('student_id')" id="student_id"
                                                name="student_id"></x-admin.input>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="name" class="form-label">Name </x-admin.label>
                                            <x-admin.input type="text" :value="old('name')" id="name"
                                                name="name" readonly></x-admin.input>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="medium_id" class="form-label">Medium</x-admin.label>
                                            <x-admin.select-option id="medium" name="medium"
                                                data-placeholder="select an option" :allowClear="true">
                                                <option value=""></option>
                                                <option value="Bangla">Bangla</option>
                                                <option value="English">English</option>
                                                <option value="College">College</option>
                                            </x-admin.select-option>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="class" class="form-label">Class </x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="class"
                                                name="class" data-placeholder="select an option" :allowClear="true"
                                                required>
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
                                    </div> --}}

                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll </x-admin.label>
                                            <x-admin.input type="text" :value="old('roll')" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="guardian_contact" class="form-label">Father's Number
                                            </x-admin.label>
                                            <x-admin.input type="number" :value="old('guardian_contact')" id="guardian_contact"
                                                name="guardian_contact" required></x-admin.input>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-3 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="section" class="form-label">Section <span
                                                    class="text-danger">*</span></x-admin.label>
                                            <x-admin.select-option class="form-control-solid" id="section"
                                                name="section" data-placeholder="select an option" :allowClear="true"
                                                required>
                                                <option value=""></option>
                                                @foreach (range('A', 'N') as $section)
                                                    <option value="{{ $section }}" @selected(old('section') == $section)>
                                                        {{ $section }}</option>
                                                @endforeach
                                            </x-admin.select-option>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-12 mt-3">
                                        <div class="mb-3 d-flex justify-content-center">
                                            <a href="javascript:void(0)" id="checkBtn" class="btn btn-primary">Check
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
            document.getElementById('checkBtn').addEventListener('click', function(event) {
                event.preventDefault();
                const studentId = document.getElementById('student_id').value;

                if (!studentId) {
                    alert('Please enter a student ID.');
                    return;
                }

                fetch("{{ route('admin.fetch.student.data') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            student_id: studentId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const student = data.student;

                            // Populate fields with student data
                            document.getElementById('name').value = student.name;
                            document.getElementById('roll').value = student.roll;
                            document.getElementById('guardian_contact').value = student.guardian_contact;

                            // // Enable and populate the 'medium' select
                            // const mediumSelect = document.getElementById('medium');
                            // mediumSelect.disabled = false;
                            // mediumSelect.value = student.medium;

                            // // Enable and populate the 'class' select
                            // const classSelect = document.getElementById('class');
                            // classSelect.disabled = false;
                            // // Set selected values for multiple select if necessary
                            // classSelect.value = student.class;

                            // // Enable and populate the 'section' select
                            // const sectionSelect = document.getElementById('section');
                            // sectionSelect.disabled = false;
                            // sectionSelect.value = student.section;

                            // Array.from(mediumSelect.options).forEach(option => {
                            //     if (option.value === student.medium) {
                            //         option.selected = true;
                            //     }
                            // });

                            // Array.from(classSelect.options).forEach(option => {
                            //     if (option.value === student.class) {
                            //         option.selected = true;
                            //     }
                            // });

                            // Array.from(sectionSelect.options).forEach(option => {
                            //     if (option.value === student.section) {
                            //         option.selected = true;
                            //     }
                            // });

                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('There was an error fetching the data.');
                    });
            });
        </script>
        <script>
            // Function to update the Pay Slip dynamically
            function updatePaySlip() {
                let totalAmount = 0;
                let selectedFees = [];

                // Loop through all selected checkboxes
                $('.fee-checkbox').each(function() {
                    let feeAmount = parseFloat($(this).data('amount')); // Get the fee amount from the checkbox
                    let feeName = $(this).data('name'); // Get the fee name from the label
                    let feeId = $(this).val(); // Get the ID of the selected fee
                    let feeType = $(this).data('type'); // Get fee type (monthly or yearly)

                    // If the fee is monthly, toggle the visibility of the month selection
                    if (feeType === 'monthly') {
                        let monthSelection = $('#month-selection-' + feeId);

                        // Check if the checkbox is checked
                        if ($(this).prop("checked")) {
                            monthSelection.show(); // Show the months div if the checkbox is checked
                        } else {
                            monthSelection.hide(); // Hide the months div if the checkbox is unchecked
                        }

                        // Add the monthly fee amount to the selected fees array
                        selectedFees.push({
                            name: feeName,
                            amount: feeAmount,
                            feeId: feeId,
                            type: feeType
                        });

                        // Add the fee amount to the total
                        totalAmount += feeAmount;

                    } else {
                        // For non-monthly fees, add the fee amount to the selected fees array and total immediately
                        selectedFees.push({
                            name: feeName,
                            amount: feeAmount,
                            feeId: feeId,
                            type: feeType
                        });

                        totalAmount += feeAmount;
                    }
                });

                // Generate the HTML for the Pay Slip
                let paySlipHtml = '';

                if (selectedFees.length > 0) {
                    paySlipHtml +=
                        '<div class="card shadow-none mb-5"><div class="card-body"><h4 class="text-center mb-3">Payment Receipt</h4>';

                    // Start a no-border table to align names and amounts
                    paySlipHtml += '<table class="table table-borderless">';
                    selectedFees.forEach(function(fee) {
                        // If the fee is a monthly fee, show the months selection
                        if (fee.type === 'monthly') {
                            let monthSelection = $('#month-selection-' + fee.feeId);

                            // Only show the selected months (if any)
                            let selectedMonths = [];
                            monthSelection.find('input:checked').each(function() {
                                selectedMonths.push($(this).next('label').text().trim());
                            });

                            paySlipHtml += `
                <tr>
                    <td style="text-align: left;">${fee.name}</td>
                    <td style="text-align: right;">${fee.amount}</td>
                </tr>`;

                            if (selectedMonths.length > 0) {
                                paySlipHtml += `
                    <tr>
                        <td colspan="2" style="text-align: left; padding-left: 20px;"><strong>Selected Months:</strong> ${selectedMonths.join(', ')}</td>
                    </tr>`;
                            }
                        } else {
                            // For non-monthly fees, just display the name and amount
                            paySlipHtml += `
                <tr>
                    <td style="text-align: left;">${fee.name}</td>
                    <td style="text-align: right;">${fee.amount}</td>
                </tr>`;
                        }
                    });

                    // Add total amount row at the bottom
                    paySlipHtml += `
                        <tr style="border-top: 1px solid black;">
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
                $('.amount').val(totalAmount); // Update the hidden amount input
            }
        </script>

        <script>
            $(document).ready(function() {
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
        <script>
            function confirmPayment(event) {
                event.preventDefault(); // Prevent the form from submitting immediately

                // Get the form and action URL
                var form = document.getElementById("paymentForm");
                var payURL = form.getAttribute("action");

                // Show the SweetAlert confirmation
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Pay Now!",
                    cancelButtonText: "No, cancel!",
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-success",
                    },
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // If confirmed, send the form via AJAX
                        var formData = new FormData(form); // Gather the form data
                        fetch(payURL, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content')
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("Paid!", "Your payment has been processed successfully.", "success")
                                        .then(() => {
                                            // Trigger both PDF downloads
                                            downloadFile(data.studentPdfUrl, "student_receipt.pdf");
                                            downloadFile(data.officePdfUrl, "office_receipt.pdf");
                                        });
                                } else {
                                    Swal.fire("Error!", "There was an issue with your payment.", "error");
                                }
                            })
                            .catch(error => {
                                Swal.fire("Error!", "An error occurred while processing the payment.", "error");
                            });
                    } else {
                        Swal.fire("Cancelled", "Your payment has been cancelled :)", "error");
                    }
                });
            }

            // Function to trigger file download
            function downloadFile(url, filename) {
                const a = document.createElement("a");
                a.href = url;
                a.download = filename;
                a.click();
            }
        </script>
    @endpush
</x-admin-app-layout>
