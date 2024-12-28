<x-frontend-app-layout :title="'Your Order History'">
    <div class="breadcrumb-wrap">
        <div class="banner b-top bg-size bread-img">
            <img class="bg-img bg-top" src="img/banner-p.jpg" alt="banner" style="display: none;">
            <div class="container-lg">
                <div class="breadcrumb-box">
                    <div class="title-box3 text-center">
                        <h1>
                            <span class="text-info">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            <br>Welcome To Your Dashboard
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ps-account">
        <section class="user-dashboard py-8">
            <div class="container">
                <div class="row g-3 g-xl-4 tab-wrap">
                    <div class="col-lg-4 col-xl-3 sticky">
                        <!-- Sidebar here -->
                        @include('user.layouts.sidebar')
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <h4>Order History & Track Order</h4>
                                    <p class="mb-5">
                                        Click the 'Track' button to check the status of your order delivery.
                                    </p>
                                </div>
                                <table class="table table-striped order-history-table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Amount</th>
                                            <th>Track</th>
                                            <th>Payment Status</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example Row -->
                                        @foreach ($orders as $order)
                                            <tr class="text-start">
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->created_at->format('d M, Y') }}</td>
                                                <td>{{ $order->quantity }}</td>
                                                <td><span class="text-info fw-bold">£</span>{{ $order->total_amount }}
                                                </td>
                                                <td>
                                                    <a href="https://www.royalmail.com/track-your-item#/tracking-results/{{ Delivery_ID }}"
                                                        class="btn btn-sm btn-warning" target="_blank">Track</a>
                                                </td>
                                                <td>
                                                    @if ($order->payment_status == 'unpaid')
                                                        <span
                                                            class="badge p-2 rounded-3 fs-7 badge-danger">Unpaid</span>
                                                    @elseif ($order->payment_status == 'paid')
                                                        <span class="badge p-2 rounded-3 fs-7 badge-success">Paid</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order->status == 'pending')
                                                        <span
                                                            class="badge p-2 rounded-3 fs-7 badge-primary">Pending</span>
                                                    @elseif ($order->status == 'processing')
                                                        <span
                                                            class="badge p-2 rounded-3 fs-7 badge-warning">Processing</span>
                                                    @elseif ($order->status == 'shipped')
                                                        <span
                                                            class="badge p-2 rounded-3 fs-7 badge-success">Shipped</span>
                                                    @elseif ($order->status == 'delivered')
                                                        <span
                                                            class="badge p-2 rounded-3 fs-7 badge-success">Delivered</span>
                                                    @elseif ($order->status == 'cancelled')
                                                        <span
                                                            class="badge p-2 rounded-3 fs-7 badge-dangered">Cancelled</span>
                                                    @elseif ($order->status == 'returned')
                                                        <span
                                                            class="badge p-2 rounded-3 fs-7 badge-dangered">Returned</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#showInvoice-{{ $order->id }}">
                                                        <i class="fa-solid fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Additional rows go here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    @foreach ($orders as $order)
        <div class="modal fade" id="showInvoice-{{ $order->id }}" data-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="showInvoiceLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showInvoiceLabel">Order Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        @include('frontend.layouts.invoice')
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-frontend-app-layout>
