<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="Kicc0lvC9D2U58MVrSrxiyRlxKK5CQwg4apuB3Tc" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link href="{{ asset('frontend/img/favicon.png') }}" rel="apple-touch-icon-precomposed" />
    <link href="{{ asset('frontend/img/favicon.png') }}" rel="shortcut icon" type="image/png" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>NeezPackages</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Jost:400,500,600,700&amp;display=swap&amp;ver=1607580870">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/home-14.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/sidebar.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
            font-family: Inter, Helvetica, "sans-serif";
            height: 100%;
            width: 100%;
        }

        .center-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* Full viewport height */
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

        .center-content {
            background-color: #ffffff;
            max-width: 600px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        a:hover {
            color: #009ef7;
        }
    </style>
</head>

<body id="kt_body" class="app-blank">
    <div class="row justify-content-center align-items-center">
        <div class="card bg-white p-0 card-print">
            <div class="card-header bg-white border-0 p-5">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="pb-5">
                            <img class="text-right" width="150px"
                                src="{{ !empty(optional($setting)->site_logo_black) ? asset('storage/' . optional($setting)->site_logo_black) : asset('frontend/img/logo.png') }}"
                                alt=""
                                onerror="this.onerror=null;this.src='https://neezpackages.com/frontend/img/logo.png';">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h1 class="text-right mb-0">Invoice</h1>
                    </div>
                    <div class="col-lg-4">
                        <div
                            style="background-color: #e1ecff; clip-path: polygon(90% 0, 100% 50%, 90% 99%, 0% 100%, 0 53%, 0% 0%);">
                            <p class="mb-0 p-3"><span class="text-dark">Invoice No:</span>
                                #{{ $order->order_number }}</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        {{-- <p class="mb-0 p-3 text-right">Date: {{ $order->created_at->format('d/m/Y') }}</p> --}}
                        <p class="mb-0 p-3 text-right">Date: {{ $order->created_at->format('d M, Y') }}</p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-6">
                        <div>
                            <span class="font-weight-bold">Invoice To:</span>
                            <p class="mb-0">{{ optional($order->user)->first_name }}</p>
                            <p class="mb-0">{{ optional($order->user)->phone }}</p>
                            <p class="mb-0">{{ optional($order->user)->email }}</p>
                            <p class="mb-0">{{ $order->billing_address }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-right">
                            <span class="font-weight-bold">Shipping From:</span>
                            <p class="mb-0">NeezPackages</p>
                            <p class="mb-0">{{ $setting->primary_phone }}</p>
                            <p class="mb-0">{{ $setting->contact_email }}</p>
                            <p class="mb-0">{{ $setting->address_line_one }}</p>
                            <p class="mb-0">{{ $setting->address_line_two }}</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-lg-12">
                        <h4>Order Information:</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr style="background-color: #e1ecff;">
                                        <th width="5%">Sl.</th>
                                        <th width="10%">Img</th>
                                        <th width="35%">Product Description</th>
                                        <th width="15%">Price</th>
                                        <th width="10%" class="text-center">Qty</th>
                                        <th width="15%" class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <span>{{ $loop->iteration }}</span>
                                            </td>
                                            <td>
                                                <span>
                                                    <img width="50px" height="50px" style="border-radius: 5px;"
                                                        src="{{ asset('storage/' . optional($item->product)->thumbnail) }}"
                                                        alt=""
                                                        onerror="this.onerror=null;this.src='{{ asset('frontend/img/no-product.jpg') }}';">
                                                </span>
                                            </td>
                                            <td>
                                                <span>{{ Str::limit(optional($item->product)->name, 30) }}</span>
                                            </td>
                                            <td>
                                                <span><span
                                                        class="text-info">(£)</span>{{ optional($item)->quantity * optional($item)->price }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span>{{ optional($item)->quantity }}</span>
                                            </td>
                                            <td class="text-right">
                                                <span>
                                                    <span class="text-info">(£)</span>
                                                    {{ optional($item)->quantity * optional($item)->price }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="">
                                        <td colspan="5" class="text-right">
                                            <span>Subtotal</span>
                                        </td>
                                        <td class="text-right">
                                            <span><span class="text-info">(£)</span>{{ $order->sub_total }}</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td colspan="5" class="text-right">
                                            <span>VAT (0%)</span>
                                        </td>
                                        <td class="text-right">
                                            <span><span class="text-info">(£)</span>0.00</span>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td colspan="5" class="text-right">
                                            <span>Shipping Charge</span>
                                        </td>
                                        <td class="text-right">
                                            <span><span
                                                    class="text-info">(£)</span>{{ $order->shippingCharge->price }}</span>
                                        </td>
                                    </tr>
                                    <tr class="invoice_table">
                                        <td colspan="5" class="text-right">
                                            <span class="font-weight-bold">Grand Total</span>
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            <span><span
                                                    class="text-info">(£)</span>{{ number_format($order->total_amount, 2) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 pt-3">
                    <div class="col-lg-12">
                        <p class="text-center">
                            <i class="fa-solid fa-file"></i> <strong>NOTE:</strong> This is a
                            computer-generated receipt and does not require a physical signature.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer p-4 text-center border-0" style="background-color: #e1ecff;">
                © NeezPackages, LTD 2024.
            </div>
        </div>
    </div>
    <script src="{{ asset('frontend/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/bootstrap4/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/sidebar.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
</body>

</html>
