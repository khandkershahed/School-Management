<x-admin-app-layout :title="'Account Today Report List'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Today Report</h4>
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
                            <div class="row gx-3 p-3">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Opening Stock</h6><br>By purchase price:</td>
                                                <td class="text-end">$0</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Opening Stock</h6><br>By sale price:</td>
                                                <td class="text-end">$0</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Purchase:</h6></td>
                                                <td class="text-end">$196573.00</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Expense:</h6></td>
                                                <td class="text-end">$21000.00</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Payroll:</h6></td>
                                                <td class="text-end">$22100.00</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Loan Interest:</h6></td>
                                                <td class="text-end">$0</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Asset Depreciation:</h6></td>
                                                <td class="text-end">$0</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Sell Discount:</h6></td>
                                                <td class="text-end">$561.75</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Sell Return:</h6></td>
                                                <td class="text-end">$14980.00</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0 table-striped">
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Closing Stock</h6><br>By purchase price:</td>
                                                <td class="text-end">$65681.80</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Closing Stock</h6><br>By sale price:</td>
                                                <td class="text-end">$81700.00</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Sales:</h6></td>
                                                <td class="text-end">$131075.00</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Purchase Return:</h6></td>
                                                <td class="text-end">$20860.00</td>
                                            </tr>
                                            <tr>
                                                <td><h6 class="fw-bold mb-0">Total Purchase Discount:</h6></td>
                                                <td class="text-end">$700.00</td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered mb-0 table-striped mt-5">
                                            <tr class="p-3">
                                                <td><h6 class="fw-bold mb-0">Gross Profit</h6></td>
                                                <td class="text-end fw-bold">-$24818.81</td>
                                            </tr>
                                            <tr class="p-3">
                                                <td><h6 class="fw-bold mb-0">Net Profit</h6></td>
                                                <td class="text-end fw-bold">-$24818.81</td>
                                            </tr>
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
</x-admin-app-layout>
