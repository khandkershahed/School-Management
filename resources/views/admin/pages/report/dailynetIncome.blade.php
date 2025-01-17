<x-admin-app-layout :title="'Daily Net Income'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Daily Net Income</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.report.daily-netincome') }}" method="GET"
                                class="filter-form">
                                <div class="container-fluid">
                                    <div style="padding-left:35px;padding-right:35px;">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4">
                                                <div class="mb-3">
                                                    <x-admin.label for="date" class="form-label"> Select a Date
                                                    </x-admin.label>
                                                    <input type="date" class="form-control form-control-solid"
                                                        name="date" id="date" value="{{ old('date', $date) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-3 align-items-center justify-content-center">
                                            <div class="col-4 text-center">
                                                <button type="submit" class="btn btn-primary"
                                                    style="width: 150px;">Filter</button>
                                            </div>
                                            <div class="col-4 text-center">
                                                <a href="{{ route('admin.report.daily-netincome') }}"
                                                    class="btn btn-primary" style="width: 150px;">Clear Filter</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @if (isset($date) && $date !== null)
                                @if (isset($invoices) && $invoices->isNotEmpty())
                                    <div class="alert alert-warning text-center">
                                        <strong>No data found for the selected date ({{ $date }})</strong>
                                    </div>
                                @else
                                    <div class="container-fluid mt-3" id="printContainer">
                                        <div style="padding-left:35px;padding-right:35px;">
                                            <div class="row">
                                                <div style="width:100%; padding:0px; margin:0px;">
                                                    <table
                                                        style="width:100%; -webkit-print-color-adjust: exact !important; background-color: #f0f3f5 !important; border-radius: 10px; margin-bottom: 20px; padding: 10px;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width:10%;text-align:center;border:0px;">
                                                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_color_no_bg.png'))) }}"
                                                                        alt="" height="80px" width="80px">
                                                                </td>
                                                                <td style="width:80%;text-align:center;border:0px;">
                                                                    <span style="text-align: center;">
                                                                        <div class="clearfix">&nbsp;</div>
                                                                        <h4 class="text-muted"
                                                                            style="margin:10px; font-size:20px">
                                                                            <strong>Shamsul Hoque Khan School and
                                                                                College</strong>
                                                                        </h4>
                                                                        <h6 class="text-muted"
                                                                            style="margin:5px; font-size:12px">
                                                                            Paradogair, Matuail, Demra Dhaka-1362
                                                                        </h6>
                                                                        <h5 class="head-title ptint-title text-info"
                                                                            style="width:100%;margin:10px; font-size:24px; text-decoration:underline">
                                                                            {{-- <i class="fa fa-bar-chart"></i> --}}
                                                                            <small> Daily Net Income
                                                                                ({{ $date }})</small>
                                                                        </h5>
                                                                        <div class="clearfix">&nbsp;</div>
                                                                    </span>
                                                                </td>
                                                                <td style="width:10%;text-align:center;border:0px;">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="table-responsive p-3 pt-1">
                                                    <table class="table table-striped" id="datatable"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%" class="text-center">SL</th>
                                                                <th width="30%" class="text-center">Invoice Number
                                                                </th>
                                                                <th width="21%" class="text-center">Income</th>
                                                                <th width="18%" class="text-center">Expense</th>
                                                                <th width="26%" class="text-center">Net Income</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($invoices as $invoice)
                                                                <tr>
                                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                                    <td class="text-center">
                                                                        {{ $invoice->invoice_number }}</td>
                                                                    <td class="text-center">
                                                                        {{ number_format($invoice->total_amount, 2) }}
                                                                    </td>
                                                                    <td class="text-center">0</td>
                                                                    <!-- You can update this if there are any actual expenses -->
                                                                    <td class="text-center">
                                                                        {{ number_format($invoice->total_amount, 2) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="4" style="text-align:end"><strong>Total
                                                                        Amount: </strong></td>
                                                                <td class="text-center">
                                                                    {{ number_format($invoices->sum('total_amount'), 2) }}
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-4 offset-4 text-center">
                                            <button class="btn btn-primary" onclick="printInvoice();"
                                                style="width: 150px;">
                                                <i class="fa fa-print"></i> Print
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-warning text-center">
                                    <strong>You have to select a date</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
