<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <title>Ruban By Salwa | Return Items - Order #{{ $order->order_number }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" class="app-default">
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                    <!--begin::Toolbar container-->
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <!--begin::Title-->
                            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Return Items - Order #{{ $order->order_number }}</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="{{ route('orders') }}" class="text-muted text-hover-primary">Orders</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">Return Items</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <a href="{{ route('orders.show', $order) }}"
                                class="btn btn-sm btn-secondary my-1 d-flex align-items-center">
                                <i class="bi bi-caret-left-fill"></i>
                                Back to Order
                            </a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body">
                                <form action="{{ route('orders.process-return', $order) }}" method="POST" id="return-form">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                            <thead>
                                                <tr class="fw-bold text-muted">
                                                    <th class="min-w-150px">Product</th>
                                                    <th class="min-w-100px text-end">Original Quantity</th>
                                                    <th class="min-w-100px text-end">Return Quantity</th>
                                                    <th class="min-w-100px text-end">Unit Price</th>
                                                    <th class="min-w-100px text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-50px me-5">
                                                                <span class="symbol-label"
                                                                    style="background-image:url({{ asset($item->product->image) }});"></span>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <span class="text-dark fw-bold">{{ $item->product->name }}</span>
                                                                @if ($item->variant_details != [] && $item->variant_details != "[]")
                                                                <span class="text-muted">
                                                                    @php
                                                                    $variants = json_decode($item->variant_details);
                                                                    @endphp
                                                                    @foreach($variants as $variant)
                                                                    <span>{{ $variant->value }}</span>
                                                                    @if (!$loop->last)
                                                                    ,
                                                                    @endif
                                                                    @endforeach
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">{{ $item->quantity - $item->returned_quantity }}</td>
                                                    <td class="text-end">
                                                        <input type="number" name="return_quantities[{{ $item->id }}]" 
                                                            class="form-control form-control-solid text-end return-quantity" 
                                                            min="0" max="{{ $item->quantity - $item->returned_quantity }}" value="0"
                                                            data-unit-price="{{ $item->unit_price }}"
                                                            data-original-quantity="{{ $item->quantity - $item->returned_quantity }}">
                                                    </td>
                                                    <td class="text-end">{{ $currency->symbol }}{{ number_format($item->unit_price, 2) }}</td>
                                                    <td class="text-end item-total">{{ $currency->symbol }}0.00</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="fw-bold text-muted">
                                                    <td colspan="4" class="text-end">Total Return Amount:</td>
                                                    <td class="text-end" id="total-return-amount">{{ $currency->symbol }}0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="text-end mt-5">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i>
                                            Process Return
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content container-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <!--end:::Main-->
    </div>
    <!--end::App-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const returnQuantities = document.querySelectorAll('.return-quantity');
            const currencySymbol = '{{ $currency->symbol }}';

            function updateTotals() {
                let totalAmount = 0;
                returnQuantities.forEach(input => {
                    const quantity = parseInt(input.value) || 0;
                    const unitPrice = parseFloat(input.dataset.unitPrice);
                    const itemTotal = quantity * unitPrice;
                    const row = input.closest('tr');
                    const totalCell = row.querySelector('.item-total');
                    totalCell.textContent = currencySymbol + itemTotal.toFixed(2);
                    totalAmount += itemTotal;
                });
                document.getElementById('total-return-amount').textContent = currencySymbol + totalAmount.toFixed(2);
            }

            returnQuantities.forEach(input => {
                input.addEventListener('input', function() {
                    const max = parseInt(this.dataset.originalQuantity);
                    const value = parseInt(this.value);
                    if (value > max) {
                        this.value = max;
                    }
                    if (value < 0) {
                        this.value = 0;
                    }
                    updateTotals();
                });
            });

            document.getElementById('return-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const hasReturns = Array.from(returnQuantities).some(input => parseInt(input.value) > 0);
                if (!hasReturns) {
                    alert('Please select at least one item to return.');
                    return;
                }
                this.submit();
            });
        });
    </script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html> 