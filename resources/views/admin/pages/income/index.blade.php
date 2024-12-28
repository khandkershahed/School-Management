<x-admin-app-layout :title="'Income'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Manage Your Income</h4>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">


                                    <a href="{{ route('admin.income.create') }}" class="btn btn-outline-light toltip"
                                        data-tooltip="Create New"> Create
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">Sl</th>
                                            {{-- <th width="5%" class="text-center">Image</th> --}}
                                            <th width="20%" class="text-center">Income Reason</th>
                                            <th width="10%" class="text-center">Category</th>
                                            <th width="15%" class="text-center">Sub Category</th>
                                            <th width="10%" class="text-center">Amount</th>
                                            <th width="10%" class="text-center">Account</th>
                                            <th width="10%" class="text-center">Date</th>
                                            <th width="5%" class="text-center">Status</th>
                                            <th width="10%" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($incomes as $income)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                {{-- <td class="text-center">
                                                    <div>
                                                        <img width="50px" src="{{ asset('images/no_image.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </td> --}}
                                                <td class="text-center">{{ optional($income)->reason }}</td>
                                                <td class="text-center">{{ optional($income->incomeCategory)->name }}
                                                    [{{ optional($income->incomeCategory)->code }}]</td>
                                                <td class="text-center">{{ optional($income->incomeSubCategory)->name }}
                                                    [{{ optional($income->incomeSubCategory)->code }}]</td>
                                                <td class="text-center">{{ optional($income)->amount }}</td>
                                                <td class="text-center">
                                                    {{ optional($income->incomeTransaction)->cashbookAccount->bank_name }}[{{ optional($income->incomeTransaction)->cashbookAccount->account_number }}]
                                                </td>
                                                <td class="text-center">
                                                    {{ optional($income) ? \Carbon\Carbon::parse($income->date)->format('jS M, Y') : '' }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $income->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $income->status == 'active' ? 'Active' : 'InActive' }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.income.edit', optional($income)->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#showIncome_{{ optional($income)->id }}"
                                                        class="btn btn-sm btn-warning text-white">
                                                        <i class="fa-solid fa-expand"></i>
                                                    </a>
                                                    <a href="{{ route('admin.income.destroy', optional($income)->id) }}"
                                                        class="btn btn-sm btn-danger delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
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
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    @foreach ($incomes as $income)
    <div class="modal fade" id="showIncome_{{ optional($income)->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg rounded-0" role="document">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="modalTitleId">
                        {{ optional($income)->reason }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12 px-0">
                                    <div class="card">
                                        <div class="card-header">
                                            {{-- Logo Area --}}
                                            <div class="d-flex justify-content-between align-items-center my-4">
                                                <div>
                                                    <h3 class="fw-bold mb-4 light-text-color">Invoice</h3>
                                                    <div class="d-flex align-items-center">
                                                        {{-- <div class="me-5">
                                                            <p class="mb-0 fw-semibold light-text-color">Invoice Number
                                                            </p>
                                                            <p class="mb-0">0001</p>
                                                        </div> --}}
                                                        <div class="">
                                                            <p class="mb-0 fw-semibold light-text-color">Date Of Issue
                                                            </p>
                                                            <p class="mb-0">{{ optional($income) ? \Carbon\Carbon::parse($income->date)->format('jS M, Y') : '' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.dashboard') }}" class="brand-link">

                                                        <img src="http://127.0.0.1:8000/images/logo-color.png"
                                                            alt="AMS" class="brand-image" width="150px" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row my-5">
                                                <div class="col-lg-4">
                                                    <p class="mb-0 fw-semibold light-text-color">Billed To</p>
                                                    <div class="pt-2">
                                                        <p class="mb-0">Khandaker Shahed</p>
                                                        <p class="mb-0">123, Ring Road</p>
                                                        <p class="mb-0">Mohammadpur, Dhaka, </p>
                                                        <p class="mb-0">Bangladesh, 1216</p>
                                                        <p class="mb-0">+88 01576614451</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <p class="mb-0 fw-semibold light-text-color text-center">Company
                                                        Info</p>
                                                    <div class="pt-2 text-center">
                                                        <p class="mb-0">NGen It</p>
                                                        <p class="mb-0">123, Ring Road</p>
                                                        <p class="mb-0">Mohammadpur, Dhaka, </p>
                                                        <p class="mb-0">Bangladesh, 1216</p>
                                                        <p class="mb-0">+88 01576614451</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <p class="mb-0 fw-semibold light-text-color text-end">Billed From
                                                    </p>
                                                    <div class="pt-2 text-end">
                                                        <p class="mb-0">NGen It</p>
                                                        <p class="mb-0">123, Ring Road</p>
                                                        <p class="mb-0">Mohammadpur, Dhaka, </p>
                                                        <p class="mb-0">Bangladesh, 1216</p>
                                                        <p class="mb-0">+88 01576614451</p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Logo Area End --}}
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="row gx-0 align-items-center">
                                                <div class="col-lg-12 invoice_bg">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0 light-bg-color mb-4"
                                                            style="border-bottom: 2px solid #5D7079 !important;">
                                                            <thead class="border-0">
                                                                <th class="invoice_bg p-3 text-start">Sl.</th>
                                                                <th class="invoice_bg p-3">Description</th>
                                                                <th class="invoice_bg p-3">Unit Cost</th>
                                                                <th class="invoice_bg p-3">Rate</th>
                                                                <th class="invoice_bg p-3 text-end">Amount</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="p-3 invoice_bg border-0 text-start">
                                                                        <small class="light-text-color">1</small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0">
                                                                        <small class="light-text-color">
                                                                            Your Items Name
                                                                        </small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0">
                                                                        <small class="light-text-color">
                                                                            $190454.60
                                                                        </small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0">
                                                                        <small class="light-text-color">$190</small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0 text-end">
                                                                        <small class="light-text-color">
                                                                            $1905546
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="p-3 invoice_bg border-0 text-start">
                                                                        <small class="light-text-color">2</small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0">
                                                                        <small class="light-text-color">
                                                                            Your Items Name
                                                                        </small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0">
                                                                        <small class="light-text-color">
                                                                            $190454.60
                                                                        </small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0">
                                                                        <small class="light-text-color">$190</small>
                                                                    </td>
                                                                    <td class="p-3 invoice_bg border-0 text-end">
                                                                        <small class="light-text-color">
                                                                            $1905546
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table mb-4 light-bg-color">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="invoice_bg border-0" colspan="3">
                                                                        <h6 class="light-text-color">Terms</h6>
                                                                    </td>
                                                                    <td class="invoice_bg border-0">
                                                                        <small class="light-text-color">Sub
                                                                            Total
                                                                        </small>
                                                                    </td>
                                                                    <td class="invoice_bg border-0 text-end">
                                                                        $0.00
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="invoice_bg border-0" colspan="3">
                                                                        <small class="light-text-color">
                                                                            Please pay the invoice bill by MM/DD/YYYY
                                                                        </small>
                                                                    </td>
                                                                    <td class="invoice_bg border-0">
                                                                        <small class="light-text-color">
                                                                            Discount
                                                                        </small>
                                                                    </td>
                                                                    <td class="invoice_bg border-0 text-end">
                                                                        $0.00
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="invoice_bg border-0" colspan="3">
                                                                        <small class="light-text-color"></small>
                                                                    </td>
                                                                    <td class="invoice_bg border-0">
                                                                        <small class="light-text-color">
                                                                            Tax rate
                                                                        </small>
                                                                    </td>
                                                                    <td class="invoice_bg border-0 text-end"> 0%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="invoice_bg border-0" colspan="3">
                                                                        <small class="light-text-color"></small>
                                                                    </td>
                                                                    <td class="invoice_bg border-0">
                                                                        <small class="light-text-color">Tax</small>
                                                                    </td>
                                                                    <td class="invoice_bg border-0 text-end">
                                                                        $0.00
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="invoice_bg border-0" colspan="3">
                                                                        <small class="light-text-color"></small>
                                                                    </td>
                                                                    <td class="invoice_bg border" colspan="2">
                                                                        <h5 class="light-text-color text-center">
                                                                            Grand Total <br> $0.00
                                                                        </h5>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row gx-0 align-items-end">
                                                <div class="col-lg-6">
                                                    <div class="p-4">
                                                        <p class="mb-0 fw-semibold light-text-color">BANK ACCOUNT
                                                            DETAILS:</p>
                                                        <div class="pt-2">
                                                            <p class="mb-1 fw-semibold">Account Holder: <span
                                                                    class="ps-2 fw-normal">Khandaker
                                                                    Shahed</span>
                                                            </p>
                                                            <p class="mb-1 fw-semibold">Account Number: <span
                                                                    class="ps-2 fw-normal">26458426</span></p>
                                                            <p class="mb-1 fw-semibold">ABA RTN: <span
                                                                    class="ps-2 fw-normal">206073150</span></p>
                                                            <p class="mb-1 fw-semibold">Wire RTN: <span
                                                                    class="ps-2 fw-normal">206073150 </span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="text-end p-4">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Ryan-Signature.png"
                                                            alt="Managing director signature" style="width: 130px;">
                                                        <div class="mt-2">
                                                            <span style="border-top: 1px solid #5D7079;">Managing
                                                                Director (MD)</span>
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
                <div class="modal-footer border-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-end align-items-center">
                                <button class="btn-common-one border-0 me-2"><i
                                        class="fa-solid fa-file-arrow-down pe-2"></i> Download</button>
                                <button class="btn-common-one border-0"><i
                                        class="fa-solid fa-print pe-2"></i>Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
    <!-- Optional: Place to the bottom of scripts -->
    {{-- <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("modalId"),
            options,
        );
    </script> --}}

</x-admin-app-layout>
