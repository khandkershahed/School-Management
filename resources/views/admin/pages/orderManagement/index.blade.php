<x-admin-app-layout :title="'Order Report'">
    <div class="row">
        <div class="col-xl-4 mx-auto">
            <div class="card card-flush shadow-sm">
                <div class="card-body p-0">
                    <div class="d-flex flex-stack justify-content-between">
                        <div class="d-flex align-items-center me-3 p-8 rounded-3 bg-dark">
                            <a href="javascript:void(0)">
                                <span class="bg-black rounded-3 p-3 me-3"><i
                                        class="fa-brands fa-product-hunt fs-3 text-white" aria-hidden="true"></i></span>
                            </a>
                            <div class="flex-grow-1">
                                <a href="#" class="text-white fs-5 fw-bold lh-0">Total Order
                                    <span class="text-white fw-semibold d-block fs-6 pt-4">{{ date('d M Y') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center pe-4">
                            <div>
                                <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ $orders->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mx-auto">
            <div class="card card-flush shadow-sm">
                <div class="card-body p-0">
                    <div class="d-flex flex-stack justify-content-between">
                        <div class="d-flex align-items-center me-3 p-8 rounded-3 bg-dark">
                            <a href="javascript:void(0)">
                                <span class="bg-black rounded-3 p-3 me-3"><i
                                        class="fa-solid fa-clock-rotate-left fs-3 text-white"
                                        aria-hidden="true"></i></span>
                            </a>
                            <div class="flex-grow-1">
                                <a href="#" class="text-white fs-5 fw-bold lh-0">Total Order Pending
                                    <span class="text-white fw-semibold d-block fs-6 pt-4">{{ date('d M Y') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center pe-4">
                            <div>
                                <span
                                    class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ $pendingOrdersCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mx-auto">
            <div class="card card-flush shadow-sm">
                <div class="card-body p-0">
                    <div class="d-flex flex-stack justify-content-between">
                        <div class="d-flex align-items-center me-3 p-8 rounded-3 bg-dark">
                            <a href="javascript:void(0)">
                                <span class="bg-black rounded-3 p-3 me-3"><i class="fa-solid fa-truck text-white fs-3"
                                        aria-hidden="true"></i></span>
                            </a>
                            <div class="flex-grow-1">
                                <a href="#" class="fs-5 fw-bold lh-0 text-white">Total Order Delivered
                                    <span class="text-white fw-semibold d-block fs-6 pt-4">{{ date('d M Y') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center pe-4">
                            <div>
                                <span
                                    class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ $deliveredOrdersCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-8">
        <div class="card-header bg-dark align-items-center d-flex justify-content-between">
            <div>
                <h1 class="mb-0 text-center w-100 text-white">Manage Your Orders</h1>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table my-datatable table-striped table-row-bordered gy-5 gs-7 border rounded">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 text-center">
                        <th>Sl</th>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Created At</th>
                        <th>Price</th>
                        <th>QTY</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="text-center">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <a href="javascript:void(0)">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td><span class="text-info fw-bold">£</span>{{ $order->total_amount }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>
                                @if ($order->payment_status == 'unpaid')
                                    <span class="badge py-3 px-4 fs-7 badge-danger">Unpaid</span>
                                @elseif ($order->payment_status == 'paid')
                                    <span class="badge py-3 px-4 fs-7 badge-light-success">Paid</span>
                                @endif
                            </td>
                            <td>
                                @if ($order->status == 'pending')
                                    <span class="badge py-3 px-4 fs-7 badge-light-primary">Pending</span>
                                @elseif ($order->status == 'processing')
                                    <span class="badge py-3 px-4 fs-7 badge-light-warning">Processing</span>
                                @elseif ($order->status == 'shipped')
                                    <span class="badge py-3 px-4 fs-7 badge-light-success">Shipped</span>
                                @elseif ($order->status == 'delivered')
                                    <span class="badge py-3 px-4 fs-7 badge-light-success">Delivered</span>
                                @elseif ($order->status == 'cancelled')
                                    <span class="badge py-3 px-4 fs-7 badge-light-dangered">Cancelled</span>
                                @elseif ($order->status == 'returned')
                                    <span class="badge py-3 px-4 fs-7 badge-light-dangered">Returned</span>
                                @endif
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                    data-bs-toggle="modal" data-bs-target="#printInovice{{ $order->id }}">
                                    <i class="fa-solid fa-print"></i>
                                </button>
                                <a href="{{ route('admin.orderDetails', $order->id) }}"
                                    class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px">
                                    <i class="fa-solid fa-eye" title="Order Details"></i>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#changeDeliveryStatus"
                                    class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px">
                                    <i class="fa-solid fa-cog" title="Order Details"></i>
                                </a>
                                {{-- <a href="javascript:void(0)">
                                    <button
                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px">
                                        <i class="fa-solid fa-file-download"></i>
                                    </button>
                                </a> --}}
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                                    data-kt-docs-datatable-subtable="expand_row">
                                    <span class="svg-icon fs-3 m-0 toggle-off">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                    <span class="svg-icon fs-3 m-0 toggle-on">
                                        <i class="fa-solid fa-minus"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                        @foreach ($order->orderItems as $item)
                            <tr data-kt-docs-datatable-subtable="subtable_template" class="d-none bg-light">
                                <td colspan="3">
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="#" class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                                alt="" data-kt-docs-datatable-subtable="template_image" />
                                        </a>
                                        <div class="d-flex flex-column text-muted">
                                            <a href="#" class="text-gray-900 text-hover-primary fw-bold"
                                                data-kt-docs-datatable-subtable="template_name">Product name</a>
                                            <div class="fs-7" data-kt-docs-datatable-subtable="template_description">
                                                {{ $item->product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="text-gray-900 fs-7">Cost</div>
                                    <div class="text-muted fs-7 fw-bold"
                                        data-kt-docs-datatable-subtable="template_cost">£ {{ $item->price }}</div>
                                </td>
                                <td class="text-end">
                                    <div class="text-gray-900 fs-7">Qty</div>
                                    <div class="text-muted fs-7 fw-bold"
                                        data-kt-docs-datatable-subtable="template_qty">{{ $item->quantity }}</div>
                                </td>
                                <td class="text-end">
                                    <div class="text-gray-900 fs-7">Total</div>
                                    <div class="text-muted fs-7 fw-bold"
                                        data-kt-docs-datatable-subtable="template_total">£ {{ $item->subtotal }}
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="changeDeliveryStatus" tabindex="-1" aria-labelledby="changeDeliveryStatusLabel"
        aria-hidden="true">
        <div class="modal-dialog        ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeDeliveryStatusLabel">Change Delvery Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="kt_ecommerce_add_product_form" method="post" action=""
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-0">
                            <div>
                                <div class="text-muted fs-7">Change The Delivery Status</div>
                                <x-admin.select-option id="kt_ecommerce_add_product_status_select"
                                    class="form-select mb-2" data-control="select2" data-hide-search="true"
                                    name="delivery_status" data-placeholder="Select an option">
                                    <option></option>
                                    <option value="Processing">Processing</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="en_route">En Route</option>
                                    <option value="deliver">Deliver</option>
                                </x-admin.select-option>
                            </div>
                            <div class="mt-4">
                                <x-admin.label class="form-label">Delivery Tracking Id</x-admin.label>
                                <x-admin.input type="text" name="delivery_id" class="form-control mb-2"
                                    placeholder="Add Product Delivery ID By Royel Mail">
                                </x-admin.input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.pages.orderManagement.partial.invoice')
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Toggle subtable visibility
                $('button[data-kt-docs-datatable-subtable="expand_row"]').on('click', function() {
                    var $row = $(this).closest('tr'); // Get the closest row
                    var $subtable = $row.nextUntil(
                        'tr:not([data-kt-docs-datatable-subtable="subtable_template"])'
                    ); // Get all subsequent subtable rows

                    // Toggle subtable visibility
                    $subtable.toggleClass('d-none');

                    // Update toggle button icon
                    $(this).find('.toggle-on, .toggle-off').toggle();
                });
            });
        </script>
        <!-- Your existing HTML content here -->
    @endpush
</x-admin-app-layout>
