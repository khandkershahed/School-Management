<x-admin-app-layout :title="'Order Report'">
    <style>
        thead {
            font-weight: bold;
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-dark align-items-center d-flex justify-content-between">
                    <h1 class="card-title text-white">Select Date To Generate Order Report</h1>
                    <div class="mb-0 d-flex align-items-center">
                        <div class="pe-3">
                            <input class="form-control form-control-solid w-100 rounded-2" placeholder="Pick date range"
                                id="kt_daterangepicker_2" />
                        </div>
                        {{-- <div>
                            <button class="btn btn-white rounded-2" id="printBtn">
                                <i class="fa-solid fa-print pe-3"></i>
                                Print
                            </button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body orderReportTable">
                    @include('admin.pages.orderManagement.partial.orderReportTable')
                </div>
            </div>
        </div>
    </div>
    @include('admin.pages.orderManagement.partial.invoice')
    @push('scripts')
        <script>
            function toggleSubtable(button) {
                // Get the closest row to the button
                var row = button.closest('tr');

                // Get the next sibling rows and toggle only the subtables
                var nextRow = row.nextElementSibling;
                var shouldShow = true;

                // Get the toggle-on and toggle-off elements
                var toggleOn = button.querySelector('.toggle-on');
                var toggleOff = button.querySelector('.toggle-off');

                // Ensure both toggle elements are found
                if (toggleOn && toggleOff) {
                    // Determine if we should show or hide the subtables
                    shouldShow = toggleOn.classList.contains('d-none');

                    while (nextRow) {
                        // If the next row is a subtable, toggle its visibility
                        if (nextRow.classList.contains('subtable')) {
                            if (shouldShow) {
                                nextRow.classList.remove('d-none');
                            } else {
                                nextRow.classList.add('d-none');
                            }
                        } else {
                            // Stop when we hit a non-subtable row
                            break;
                        }
                        nextRow = nextRow.nextElementSibling;
                    }

                    // Toggle the button icon visibility
                    if (shouldShow) {
                        toggleOn.classList.remove('d-none');
                        toggleOff.classList.add('d-none');
                    } else {
                        toggleOn.classList.add('d-none');
                        toggleOff.classList.remove('d-none');
                    }
                } else {
                    console.error('Toggle elements not found');
                }
            }
        </script>




        <script>
            $(function() {
                $('#kt_daterangepicker_2').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                }, function(start, end, label) {
                    fetchOrders(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                });
            });

            function fetchOrders(startDate, endDate) {
                $.ajax({
                    url: '{{ route('admin.orderReport') }}',
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        $('.orderReportTable').html(response);
                    }
                });
            }
        </script>
    @endpush
</x-admin-app-layout>
