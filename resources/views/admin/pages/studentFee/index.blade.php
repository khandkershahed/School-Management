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


                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="roll" class="form-label">Roll </x-admin.label>
                                            <x-admin.input type="text" :value="old('roll')" id="roll"
                                                name="roll" required></x-admin.input>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <x-admin.label for="guardian_contact" class="form-label">Guardian's Number
                                            </x-admin.label>
                                            <x-admin.input type="number" :value="old('guardian_contact')" id="guardian_contact"
                                                name="guardian_contact" required></x-admin.input>
                                        </div>
                                    </div>
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
                            document.getElementById('name').value = student.name;
                            document.getElementById('roll').value = student.roll;
                            document.getElementById('guardian_contact').value = student.guardian_contact;
                        } else {
                            alert('No Data Found for the provided Student ID. Try again with the correct ID');
                            // alert(data.message);
                            // alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // alert('No Data Found for the provided Student ID. Try again with the correct ID');
                    });
            });
        </script>
        <script>
            // Refined updatePaySlip function
            function updatePaySlip() {
                let selectedFees = [];
                let totalAmount = 0;

                // Loop through all the fee checkboxes (both yearly and monthly)
                $('.fee-checkbox').each(function() {
                    if ($(this).prop('checked') && !$(this).prop('disabled')) {
                        let feeAmount = parseFloat($(this).data('amount')); // Get the fee amount
                        let feeName = $(this).data('name'); // Get the fee name
                        let feeId = $(this).val(); // Get the fee ID
                        let feeType = $(this).data('type'); // Get the fee type (monthly or yearly)

                        // Add the selected fee to the list
                        selectedFees.push({
                            name: feeName,
                            amount: feeAmount,
                            feeId: feeId,
                            type: feeType
                        });

                        // Add the amount to the total
                        totalAmount += feeAmount;
                    }
                });

                // Generate the updated Pay Slip HTML
                let paySlipHtml = '';
                if (selectedFees.length > 0) {
                    paySlipHtml +=
                        '<div class="card-body"><h4 class="text-center mb-3">Payment Receipt</h4>';

                    paySlipHtml += '<table class="table table-borderless">';
                    selectedFees.forEach(function(fee) {
                        // Display the fee name and amount for each selected fee
                        paySlipHtml +=
                            `<tr><td style="text-align: left;">${fee.name}</td><td style="text-align: right;">${fee.amount}</td></tr>`;
                    });

                    // Add a total row
                    paySlipHtml +=
                        `<tr style="border-top: 1px solid black;"><td style="text-align: right;"><strong>Total</strong></td><td style="text-align: right;"><strong>${totalAmount}</strong></td></tr></div>`;

                    paySlipHtml += '</table>';
                } else {
                    paySlipHtml =
                        '<div class="d-flex align-items-center justify-content-center"><h4 class="text-danger text-center">No fees selected.</h4></div>';
                }

                // Update the Pay Slip
                $('#paySlip').html(paySlipHtml);
                $('.amount').val(totalAmount); // Update hidden amount input with the total
            }

            // Add event listener to the fee checkboxes
            $('.fee-checkbox').on('change', function() {
                updatePaySlip();
            });
        </script>
        <script>
            function confirmPayment(event) {
                // This function can be expanded to confirm the payment, show a confirmation popup, etc.
                alert('Payment Confirmation Process');
                document.getElementById('paymentForm').submit();
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
                        if (response.error) {
                            alert('No Data Found for the provided Student ID. Try again with the correct ID');
                            // alert(response.error);
                        } else {
                            $('#studentFeeContainer').html(response);

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error in AJAX request:", status, error);
                        // alert('No Data Found for the provided Student ID. Try again with the correct ID');
                    }
                });
            }
        </script>
        {{-- <script>
            function confirmPayment(event) {
                event.preventDefault();

                var form = document.getElementById("paymentForm");
                var payURL = form.getAttribute("action");
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
                                            // First, trigger both PDF downloads
                                            autoPrintReceipt(data.studentPdfUrl, "student_receipt.pdf");
                                            autoPrintReceipt(data.officePdfUrl, "office_receipt.pdf");
                                            // downloadFile(data.studentPdfUrl, "student_receipt.pdf");
                                            // downloadFile(data.officePdfUrl, "office_receipt.pdf");

                                            setTimeout(function() {
                                                location
                                                    .reload(); // Reload the page after a brief delay
                                            }, 10000);
                                        });


                                } else {
                                    Swal.fire("Error!", data.message);
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
            // function downloadFile(url, filename) {
            //     const a = document.createElement("a");
            //     a.href = url;
            //     // a.download = filename;
            //     a.print = filename;
            //     a.click();
            // }
            // function downloadFile(url, filename) {
            //     // Create an invisible iframe to trigger printing
            //     const iframe = document.createElement("iframe");
            //     iframe.style.position = "absolute";
            //     iframe.style.width = "0";
            //     iframe.style.height = "0";
            //     iframe.style.border = "none";
            //     document.body.appendChild(iframe);

            //     iframe.src = url;

            //     // Once the PDF is loaded in the iframe, trigger the print dialog
            //     iframe.onload = function() {
            //         iframe.contentWindow.print(); // Trigger print dialog
            //     };

            //     // Trigger download of the PDF (optional, if you still want to download the file)
            //     const a = document.createElement("a");
            //     a.href = url;
            //     a.download = filename;
            //     a.click();
            // }

            function autoPrintReceipt(pdfUrl, fileName) {
                // Log the PDF URL for debugging purposes
                console.log("PDF URL: ", pdfUrl);

                // Create an invisible iframe to load the PDF and trigger printing
                const iframe = document.createElement("iframe");
                iframe.style.position = "absolute";
                iframe.style.width = "0";
                iframe.style.height = "0";
                iframe.style.border = "none";
                document.body.appendChild(iframe);

                // Set the iframe source to the PDF URL
                iframe.src = pdfUrl;

                // Add a small delay before printing (to ensure the PDF is fully loaded)
                iframe.onload = function() {
                    // Set a slight delay before printing to make sure everything is ready
                    setTimeout(function() {
                        try {
                            iframe.contentWindow.print(); // Trigger the browser's print dialog
                        } catch (err) {
                            console.error("Printing failed: ", err);
                        }
                    }, 300); // Delay of 500ms; adjust if necessary
                };
            }
        </script> --}}
        {{-- <script>
            function confirmPayment(event) {
                event.preventDefault();

                var form = document.getElementById("paymentForm");
                var payURL = form.getAttribute("action");
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
                                            // Trigger the PDF downloads and print
                                            autoPrintReceipt(data.studentPdfUrl, "student_receipt.pdf");
                                            autoPrintReceipt(data.officePdfUrl, "office_receipt.pdf");
                                            setTimeout(function() {
                                                location
                                            .reload(); // Reload the page after a brief delay
                                            }, 5000);
                                        });
                                } else {
                                    Swal.fire("Error!", data.message);
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

            function autoPrintReceipt(pdfUrl, fileName) {
                // Log the PDF URL for debugging purposes
                console.log("PDF URL: ", pdfUrl);

                // Open the PDF in a new window (trigger the print dialog)
                const printWindow = window.open(pdfUrl, '_blank');

                printWindow.onload = function() {
                    setTimeout(function() {
                        try {
                            printWindow.print();
                        } catch (err) {
                            console.error("Printing failed: ", err);
                        }
                    }, 500);
                };
            }
        </script> --}}
        <script>
            function confirmPayment(event) {
                event.preventDefault();

                var form = document.getElementById("paymentForm");
                var payURL = form.getAttribute("action");
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
                                            // Trigger the PDF downloads and print
                                            studentPrintReceipt(data.studentPdfUrl, "student_receipt.pdf");
                                            oficePrintReceipt(data.officePdfUrl, "office_receipt.pdf");

                                            // Reload the page after a brief delay
                                            setTimeout(function() {
                                                location.reload();
                                            }, 8000); // 6 seconds to ensure the print dialogs were triggered
                                        });
                                } else {
                                    Swal.fire("Error!", data.message);
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

            // function autoPrintReceipt(pdfUrl, fileName) {
            //     // Log the PDF URL for debugging purposes
            //     console.log("PDF URL: ", pdfUrl);

            //     // Open the PDF in a new window (trigger the print dialog)
            //     const printWindow = window.open(pdfUrl, '_blank');

            //     printWindow.onload = function() {
            //         // Small delay before triggering the print dialog
            //         setTimeout(function() {
            //             try {
            //                 printWindow.print(); // Trigger the print dialog for the opened window
            //             } catch (err) {
            //                 console.error("Printing failed: ", err);
            //             }
            //         }, 500); // Allow a slight delay for the PDF to load
            //     };
            // }
            function studentPrintReceipt(pdfUrl, fileName) {
                console.log("PDF URL: ", pdfUrl);

                // Open the PDF in a new window (trigger the print dialog)
                const printWindow = window.open(pdfUrl, '_blank');

                printWindow.onload = function() {
                    // Small delay before triggering the print dialog
                    setTimeout(function() {
                        try {
                            printWindow.print(); // Trigger the print dialog for the opened window
                        } catch (err) {
                            console.error("Printing failed: ", err);
                        }
                    }, 500); // Allow a slight delay for the PDF to load
                };
            }

            function oficePrintReceipt(pdfUrl, fileName) {
                    console.log("PDF URL: ", pdfUrl);

                    // Open the PDF in a new window (trigger the print dialog)
                    const printWindow = window.open(pdfUrl, '_blank');

                    printWindow.onload = function() {
                        // Small delay before triggering the print dialog
                        setTimeout(function() {
                            try {
                                printWindow.print(); // Trigger the print dialog for the opened window
                            } catch (err) {
                                console.error("Printing failed: ", err);
                            }
                        }, 500); // Allow a slight delay for the PDF to load
                    };
            }
        </script>

        <script>
            function toggleFeeCheckboxes(checkbox) {
                var isChecked = checkbox.checked;
                var feeCheckboxes = document.querySelectorAll('.fee-Package');
                feeCheckboxes.forEach(function(feeCheckbox) {
                    feeCheckbox.checked = isChecked;
                });
                if (isChecked) {
                    feeCheckboxes.forEach(function(feeCheckbox) {
                        feeCheckbox.dispatchEvent(new Event('change'));
                    });
                }
                updatePaySlip();
            }
        </script>
    @endpush
</x-admin-app-layout>
