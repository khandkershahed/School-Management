<x-admin-app-layout :title="'Order Details'">
    <div class="d-flex flex-column flex-column-fluid mt-5">
        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                                Dashboard </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.order-management.index') }}" class="text-muted text-hover-primary">
                                Order List </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            Order Details (#{{ $order->order_number }}) </li>
                    </ul>
                    <h5 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Order Details (#{{ $order->order_number }})
                    </h5>

                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row mb-10">
                    <div class="col-xl-4">
                        <div class="card card-flush py-4 flex-row-fluid">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Order Details (#{{ $order->order_number }})</h4>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                        <tbody class="fw-semibold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-calendar fs-2 me-2"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                        Date Created
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end">{{ $order->created_at->format('d M , Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-wallet fs-2 me-2">
                                                        </i>
                                                        Payment Method
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end">
                                                    {{ ucfirst($order->payment_method) }}
                                                    <img src="https://preview.keenthemes.com/metronic8/demo1/assets/media/svg/card-logos/visa.svg"
                                                        class="w-50px ms-2">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-truck fs-2 me-2"></i>
                                                        Shipping Method
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end">
                                                    {{ optional($order->shippingCharge)->title }}({{ optional($order->shippingCharge)->price }})
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card card-flush py-4  flex-row-fluid">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Customer Details</h4>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">

                                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                        <tbody class="fw-semibold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-profile-circle fs-2 me-2">
                                                        </i>
                                                        Customer
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <a href="#" class="text-gray-600 text-hover-primary">
                                                            {{ optional($order->user)->first_name }}
                                                            {{ optional($order->user)->last_name }}
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-sms fs-2 me-2">
                                                        </i>
                                                        Email
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end">
                                                    <a href="mailto:{{ optional($order->user)->email }}"
                                                        class="text-gray-600 text-hover-primary">
                                                        {{ optional($order->user)->email }} </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-phone fs-2 me-2"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                        Phone
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end">{{ optional($order->user)->phone }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card card-flush py-4  flex-row-fluid">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Shipping Address</h4>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                        <tbody class="fw-semibold text-gray-600">
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-devices fs-2 me-2"></i>
                                                        Invoice
                                                        <span class="ms-1" data-bs-toggle="tooltip"
                                                            aria-label="View the invoice generated by this order."
                                                            data-bs-original-title="View the invoice generated by this order."
                                                            data-kt-initialized="1">
                                                            <i class="fa-solid fa-information-5 text-gray-500 fs-6"></i>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end"><a
                                                        href="https://preview.keenthemes.com/metronic8/demo1/apps/invoices/view/invoice-3.html"
                                                        class="text-gray-600 text-hover-primary">#{{ $order->order_number }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-truck fs-2 me-2"></i>
                                                        Shipping Address
                                                        <span class="ms-1" data-bs-toggle="tooltip"
                                                            aria-label="View the shipping manifest generated by this order."
                                                            data-bs-original-title="View the shipping manifest generated by this order."
                                                            data-kt-initialized="1">
                                                            <i
                                                                class="fa-solid fa-information-5 text-gray-500 fs-6"></i>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-end"><a href="#"
                                                        class="text-gray-600 text-hover-primary">{{ $order->shipping_address }}</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        {{-- <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                            <div class="card card-flush py-4 flex-row-fluid position-relative">
                                <div
                                    class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                    <i class="ki-solid ki-two-credit-cart" style="font-size: 14em">
                                    </i>
                                </div>
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Billing Address</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    {{ $order->billing_address }}
                                </div>
                            </div>
                            <div class="card card-flush py-4 flex-row-fluid position-relative">
                                <div
                                    class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                    <i class="ki-solid ki-delivery" style="font-size: 13em">
                                    </i>
                                </div>
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Shipping Address</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    {{ $order->shipping_address }}
                                </div>
                            </div>
                        </div> --}}
                        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Order #{{ $order->order_number }}</h2>
                                </div>
                                {{-- <div class="card-title">
                                    <a href="javascript:void(0)" class="btn btn-sm fw-bold btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#printInovice"> <i
                                            class="fa-solid fa-print"></i> Print Or Download </a>
                                </div> --}}
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <thead>
                                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                <th width="5%" class="ps-5">Sl</th>
                                                <th width="10" class="">Image</th>
                                                <th width="45" class="">Product Description</th>
                                                <th width="10%" class="">SKU</th>
                                                <th width="10%" class="">Qty</th>
                                                <th width="10%" class="text-end">Unit Price</th>
                                                <th width="10%" class="text-end pe-5">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td class="ps-5">1</td>
                                                    <td>
                                                        <span>
                                                            <img width="50px" height="50px"
                                                                style="border-radius: 5px;"
                                                                src="{{ asset('storage/' . optional($item->product)->thumbnail) }}"
                                                                alt="">
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span>{{ Str::limit(optional($item->product)->name, 30) }}</span>
                                                    </td>

                                                    <td>
                                                        <span>{{ optional($item->product)->sku_code }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ optional($item)->quantity }}</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="text-info">(£)</span>{{ optional($item)->price }}
                                                    </td>
                                                    <td class="text-end pe-5">
                                                        <span class="text-info">(£)</span>{{ optional($item)->quantity * optional($item)->price }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr style="background-color: #eeeeee94;">
                                                <td colspan="6" class="text-end">
                                                    Subtotal
                                                </td>
                                                <td class="text-end pe-5">
                                                    (£){{ $order->sub_total }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #eeeeeead;">
                                                <td colspan="6" class="text-end">
                                                    VAT (0%)
                                                </td>
                                                <td class="text-end pe-5">
                                                    $0.00
                                                </td>
                                            </tr>
                                            <tr style="background-color: #eeeeeed8;">
                                                <td colspan="6" class="text-end">
                                                    Shipping Rate
                                                </td>
                                                <td class="text-end pe-5">
                                                    (£){{ $order->shipping_charge }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #eee;">
                                                <td colspan="6" class="fs-3 text-gray-900 text-end">
                                                    Grand Total
                                                </td>
                                                <td class="text-gray-900 fs-3 fw-bolder text-end pe-5">
                                                    (£){{ $order->total_amount }}
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
    {{-- Print Invoice Modal  --}}
    <!-- Modal -->
    {{-- @include('admin.pages.orderManagement.partial.invoice') --}}
    {{-- Print Invoice Modal End --}}
    {{-- view order Modal  --}}
    <!-- Modal -->
    <div class="modal fade" id="vieworderInovice" tabindex="-1" aria-labelledby="vieworderInoviceLabel"
        aria-hidden="true">
        <div class="modal-dialog        ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Worder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Print Invoice Modal End --}}
</x-admin-app-layout>
