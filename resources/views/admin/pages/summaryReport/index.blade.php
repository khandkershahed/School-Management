<x-admin-app-layout :title="'Account Manage Summary Report'">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Summary Report</h4>
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
                        <div class="card-body">
                            <div class="row gx-0 p-3">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="month" class="form-label">Month</label>
                                                        <x-admin.select-option id="month" name="month"
                                                            :allowClear="true">
                                                            <option value="">-- Select Category --</option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </x-admin.select-option>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="year" class="form-label">Year</label>
                                                        <x-admin.select-option id="year" name="year"
                                                            :allowClear="true">
                                                            <option value="">-- Select Category --</option>
                                                            <option value="2020">2020</option>
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                        </x-admin.select-option>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <x-admin.button type="submit" class="">View Report <i
                                                            class="fa-regular fa-floppy-disk ps-2"></i></x-admin.button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card printBody">
                                        <div class="card-header">
                                            {{-- Logo Area --}}
                                            <div class="d-flex justify-content-between align-items-center py-4">
                                                <div>
                                                    <a href="{{ route('admin.dashboard') }}" class="brand-link">
                                                        <img src="{{ asset('images/logo-color.png') }}"
                                                            alt="AdminLTE Logo" class="brand-image" width="150px" />
                                                    </a>
                                                    <p class="pt-3">Ultimate Sales, Inventory <br>
                                                        Accounting Management System
                                                    </p>
                                                </div>
                                                <div class="text-end">
                                                    <p><b>Phone:</b> 0170000000</p>
                                                    <p><b>Email:</b> support@codeshape.net</p>
                                                    <p><b>Address:</b> Ground Floor, Road# 24, House# 339 <br> New DOHS,
                                                        Mohakhali, Dhaka - 1206, Bangladesh</p>
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
                                                                    <td class="text-end">$250000.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Inventory Value=></td>
                                                                    <td class="text-end">$65681.80</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Client's Dues=></td>
                                                                    <td class="text-end">$109495.25</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Bank Balance=></td>
                                                                    <td class="text-end">$424878.08</td>
                                                                </tr>
                                                                <tr class="table-primary border-0">
                                                                    <td colspan="2">Total Income=></td>
                                                                    <td class="text-end">$850055.13</td>
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
                                                                    <td>Supplier's Dues=></td>
                                                                    <td class="text-end">$128109.00</td>
                                                                </tr>
                                                                <tr>
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
                                                                </tr>
                                                                <tr class="table-primary border-0">
                                                                    <td colspan="2">Total Liability=></td>
                                                                    <td class="text-end">$318563.60</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="50%">Total Liability & Total Income
                                                                        <br> (Income -
                                                                        Liabilities)
                                                                    </td>
                                                                    <td width="50%" class="text-end"
                                                                        colspan="2">($850055.13 -
                                                                        $318563.60)</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr class="table-info border-0 fw-bold">
                                                                    <td>Total Asset:</td>
                                                                    <td class="text-end" colspan="2">$850055.13
                                                                    </td>
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
