<x-admin-app-layout :title="'Account Balance Sheet'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Balance Sheet</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Export To Excel">
                                        <i class="fa-solid fa-file-csv"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light toltip"
                                        data-tooltip="Download PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light" onclick="printTable()">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Back To Home">
                                        <i class="fa-solid fa-arrow-left-long"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body printBody">
                            <div class="row gx-0 p-3">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            {{-- Logo Area --}}
                                            <div class="d-flex justify-content-between align-items-center py-4">
                                                <div>
                                                    <a href="{{ route('admin.dashboard') }}" class="brand-link">

                                                        <img src="{{ optional($setting)->site_logo_black && file_exists(public_path('storage/' . $setting->site_logo_black)) ? asset('storage/' . $setting->site_logo_black) : asset('images/logo-color.png') }}"
                                                            alt="{{ optional($setting)->site_title }}" class="brand-image" width="150px" />
                                                    </a>
                                                    <p class="pt-3">{{ optional($setting)->site_title }}
                                                    </p>
                                                </div>
                                                <div class="text-end">
                                                    <p><b>Phone:</b> {{ optional($setting)->primary_phone }}</p>
                                                    <p><b>Email:</b> {{ optional($setting)->support_email }}</p>
                                                    <p><b>Address:</b> {{ optional($setting)->address_line_one }} <br>
                                                        {{ optional($setting)->address_line_two }}</p>
                                                </div>
                                            </div>
                                            {{-- Logo Area End --}}
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="row gx-0">
                                                <div class="col-lg-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered mb-0">
                                                            <tbody>
                                                                <tr class="table-info border-0">
                                                                    <td colspan="3" class="text-center"><strong
                                                                            class="text-uppercase">Income</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Total Security/Asset=></td>
                                                                    <td class="text-end">{{ $assets }}</td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td>2</td>
                                                                    <td>Inventory Value=></td>
                                                                    <td class="text-end">$65681.80</td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Client's Dues=></td>
                                                                    <td class="text-end">{{ $clientTotalDue }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Bank Balance=></td>
                                                                    <td class="text-end">{{ $bankBalance }}</td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered mb-0">
                                                            <tbody>
                                                                <tr class="table-info border-0">
                                                                    <td colspan="3" class="text-center"><strong
                                                                            class="text-uppercase">Liability</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Payable =></td>
                                                                    <td class="text-end">{{ $clientTotalDue }}</td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td>2</td>
                                                                    <td>Bank Loan=></td>
                                                                    <td class="text-end">$190454.60</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Bank Loan=></td>
                                                                    <td class="text-end">$190454.60</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Bank Loan=></td>
                                                                    <td class="text-end">$190454.60</td>
                                                                </tr> --}}

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered mb-0">
                                                            <tbody>
                                                                <tr class="table-primary border-0">
                                                                    <td colspan="3">Total Income=></td>
                                                                    <td class="text-end">{{ $businessTotal }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered mb-0">
                                                            <tbody>
                                                                <tr class="table-primary border-0">
                                                                    <td colspan="3">Total Liability=></td>
                                                                    <td class="text-end">{{ $liabilities }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="table text-center table-bordered mb-0">
                                                            <tbody>
                                                                <tr class="text-center">
                                                                    <h6 class="p-3 text-center">Total Liability & Total
                                                                        Income
                                                                        <br> (Income - Liabilities) :
                                                                        ({{ $businessTotal }} - {{ $liabilities }})
                                                                    </h6>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr class="text-center table-info border-0 fw-bold">
                                                                    <h5 class="p-3 text-center">Total Asset :
                                                                        {{ $totalAsset }}</h5>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
