<x-admin-app-layout :title="'Student Due Fee'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Due Fee Report</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <div class="container-fluid" id="printContainer">
                                <div style="padding-left:35px;padding-right:35px;">
                                    <div class="row">
                                        <div style="width:100%; padding:0px; margin:0px;">
                                            <table
                                                style=" width:100%; -webkit-print-color-adjust: exact !important; background-color: #f0f3f5 !important; border-radius: 10px; margin-bottom: 20px; padding: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:10%;text-align:center;">
                                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_color_no_bg.png'))) }}"
                                                                alt="" height="80px" width="80px">
                                                        </td>
                                                        <td style="width:80%;  text-align:center;">
                                                            <span style="text-align: center ;">
                                                                <div class="clearfix">&nbsp;</div>
                                                                <h3 class="text-muted" style="margin-top:10px;">
                                                                    <strong>Shamsul Hoque Khan School and
                                                                        College</strong>
                                                                </h3>
                                                                <h6 class="text-muted" style="margin-top:10px;">
                                                                    Paradogair, Matuail, Demra
                                                                    Dhaka-1362
                                                                </h6>
                                                                <h3 class="head-title ptint-title text-info"
                                                                    style="width: 100%;margin-top:10px;">
                                                                    <i class="fa fa-bar-chart"></i>
                                                                    <small> Due Fee Report</small>
                                                                </h3>
                                                                <div class="clearfix">&nbsp;</div>
                                                                {{-- <div>Academic Year: {{ old('year', $year) }}</div> --}}
                                                            </span>
                                                        </td>
                                                        <td style="width:10%;  text-align:center;"> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="table-responsive p-3 pt-1">
                                        <!-- Table -->
                                        <table class="table table-striped datatable" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">SL</th>
                                                    <th width="10%" class="text-center">Invoice Number</th>
                                                    <th width="10%" class="text-center">Date</th>
                                                    <th width="12%" class="text-center">Student ID</th>
                                                    <th width="13%" class="text-center">Student</th>
                                                    <th width="10%" class="text-center">Class</th>
                                                    <th width="10%" class="text-center">Month </th>
                                                    <th width="10%" class="text-center">Amount</th>
                                                    <th width="10%" class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoices as $invoice)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $invoice->invoice_number }}</td>
                                                        <td class="text-center">
                                                            {{ \Carbon\Carbon::parse($invoice->generated_at)->format('d-m-y') }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ optional($invoice->student)->student_id }}</td>
                                                        <td class="text-center">{{ optional($invoice->student)->name }}
                                                        </td>
                                                        <td class="text-center">{{ optional($invoice->student)->class }}
                                                        </td>
                                                        <td class="text-center">{{ $invoice->month }} ,
                                                            {{ $invoice->year }}</td>
                                                        <td class="text-center">{{ $invoice->total_amount }}</td>
                                                        <td class="text-center">
                                                            Due
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4 offset-4 text-center">
                                    <button class="btn btn-primary" onclick="printInvoice();" style="width: 150px;"><i
                                            class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function printInvoice() {
                // Hide everything except the print container
                var printContents = document.getElementById('printContainer').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;
                window.print();

                // Restore the original page content after printing
                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
</x-admin-app-layout>
