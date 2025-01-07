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
                                                <td class="text-center">{{ optional($invoice->student)->student_id }}</td>
                                                <td class="text-center">{{ optional($invoice->student)->name }}</td>
                                                <td class="text-center">{{ optional($invoice->student)->class }}</td>
                                                <td class="text-center">{{ $invoice->month }} , {{ $invoice->year }}</td>
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
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
