@foreach ($orders as $order)
    <div class="modal fade" id="printInovice{{ $order->id }}" tabindex="-1"
        aria-labelledby="printInovice{{ $order->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row" id="invoiceContent{{ $order->id }}">
                        <div class="card card-print">
                            <div class="card-body">
                                <div class="mx-auto w-100">
                                    <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                                        <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">INVOICE</h4>

                                        <div class="text-sm-end">
                                            <a href="#" class="d-block mw-150px ms-sm-auto">
                                                <img alt="Logo" src="{{ !empty($site->site_logo_white) && file_exists(public_path('storage/settings/' . $site->site_logo_white)) ? asset('storage/settings/' . $site->site_logo_white) : asset('frontend/img/logo.png') }}"
                                                    class="w-100">
                                            </a>

                                            <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                                                <div>
                                                    {{ $setting->address_line_one }}
                                                    @if ($setting->address_line_two)
                                                        , {{ $setting->address_line_two }}
                                                    @endif
                                                </div>

                                                <div>{{ $setting->primary_phone }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column gap-7 gap-md-10">
                                        <div class="fw-bold fs-2">
                                            Dear {{ $order->user->first_name }} <span
                                                class="fs-6">({{ $order->user->email }} )</span>,<br>
                                            <span class="text-muted fs-5">Here are your order details. Thank you for
                                                your purchase.</span>
                                        </div>

                                        <div class="separator"></div>

                                        <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Order ID</span>
                                                <span class="fs-5">#{{ $order->order_number }}</span>
                                            </div>

                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Date</span>
                                                <span class="fs-5">{{ $order->created_at->format('d M, Y') }}</span>
                                            </div>

                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Invoice ID</span>
                                                <span class="fs-5">#{{ $order->order_number }}</span>
                                            </div>

                                            {{-- <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Shipment ID</span>
                                                <span class="fs-5">#SHP-0025410</span>
                                            </div> --}}
                                        </div>

                                        <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Billing Address</span>
                                                <span class="fs-6">
                                                    {{ $order->billing_address }}
                                                </span>
                                            </div>

                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Shipping Address</span>
                                                <span class="fs-6">
                                                    {{ $order->shipping_address }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between flex-column">
                                            <div class="table-responsive border-bottom mb-9">
                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                    <thead>
                                                        <tr class="border-bottom fs-6 fw-bold text-muted">
                                                            <th class="min-w-175px pb-2 ps-5">Products</th>
                                                            <th class="min-w-70px text-end pb-2">SKU</th>
                                                            <th class="min-w-80px text-end pb-2">QTY</th>
                                                            <th class="min-w-100px text-end pb-2 pe-5">Total</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="fw-semibold text-gray-600">
                                                        @foreach ($order->orderItems as $item)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <a href="{{ route('product.details', optional($item->product)->slug) }}"
                                                                            class="symbol symbol-50px">
                                                                            <span class="symbol-label"
                                                                                style="background-image:url({{ asset('storage/' . optional($item->product)->thumbnail) }});"></span>
                                                                        </a>

                                                                        <div class="ms-5">
                                                                            <div class="fw-bold">
                                                                                {{ optional($item->product)->name }}
                                                                            </div>
                                                                            {{-- <div class="fs-7 text-muted">Delivery Date:
                                                                                14/08/2024</div> --}}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ optional($item)->product->sku_code }} </td>
                                                                <td class="text-end">
                                                                    {{ optional($item)->quantity }}
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ optional($item)->quantity * optional($item)->price }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="3" class="text-end">
                                                                Subtotal
                                                            </td>
                                                            <td class="text-end">
                                                                £ {{ optional($order)->sub_total }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-end">
                                                                VAT (0%)
                                                            </td>
                                                            <td class="text-end">
                                                                £ 0.00
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"
                                                                class="fs-3 text-gray-900 fw-bold text-end">
                                                                Grand Total
                                                            </td>
                                                            <td class="text-gray-900 fs-3 fw-bolder text-end">
                                                                £ {{ optional($order)->total_amount }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-4 text-center border-0" style="background-color: #e1ecff;">
                                © NeezPackages, LTD 2024.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="">
                        {{-- <a href="{{ asset('storage/'.$order->invoice) }}" class="btn btn-primary print p-3">
                            <i class="fa-solid fa-print"></i> Print Invoice
                        </a> --}}
                        <button class="btn btn-primary ml-3 p-3" onclick="downloadInvoice()">
                            <i class="fa-solid fa-file-download"></i> Download Invoice
                        </button>
                        <button class="btn btn-danger ml-3 p-3" data-bs-dismiss="modal" aria-label="close"> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


@push('scripts')
    <script>
        function downloadInvoice() {
            const invoice = document.querySelector('.card-print'); // Select the invoice element
            html2pdf(invoice, {
                margin: 10,
                filename: `Invoice-${Date.now()}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            });
        }
    </script>
@endpush
{{-- <script>
    function printInvoice() {
        const printContents = document.querySelector('.card-print').innerHTML;
        const originalContents = document.body.innerHTML;

        const printWindow = window.open('', '', 'height=800,width=600');
        printWindow.document.write('<html><head><title>Print Invoice</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script> --}}
