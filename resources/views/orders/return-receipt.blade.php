<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <title>Return Receipt - Order #{{ $order->order_number }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 5mm;
                font-size: 12px;
            }
            .no-print {
                display: none;
            }
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 2px;
                text-align: left;
            }
            .divider {
                border-top: 1px dashed #000;
                margin: 5px 0;
            }
        }
    </style>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" class="print-content-only app-default">
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!-- begin::Invoice 3-->
                        <div class="card">
                            <!-- begin::Body-->
                            <div class="card-body py-20">
                                <!-- begin::Wrapper-->
                                <div class="mw-lg-950px mx-auto w-100">
                                    <!-- begin::Header-->
                                    <div class="d-flex justify-content-between flex-row mb-19">
                                        <div>
                                            <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">Return Receipt</h4>
                                            <div class="flex-root d-flex flex-column mt-4">
                                                <span class="text-muted fw-bold">Original Order Number</span>
                                                <span class="fs-5">#{{ $order->order_number }}</span>
                                            </div>
                                            <div class="flex-root d-flex flex-column mt-4">
                                                <span class="text-muted fw-bold">Return Date</span>
                                                <span class="fs-5">{{ now()->format('Y-m-d H:i:s') }}</span>
                                            </div>
                                        </div>
                                        @if ($order->client_id)
                                        <div>
                                            <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">Client</h4>
                                            <div class="flex-root d-flex flex-column mt-4">
                                                <span class="text-muted fw-bold">Name</span>
                                                <span class="fs-5">{{ ucwords($order->client->name) }}</span>
                                            </div>
                                            <div class="flex-root d-flex flex-column mt-4">
                                                <span class="text-muted fw-bold">Phone</span>
                                                <span class="fs-5">{{ $order->client->phone }}</span>
                                            </div>
                                            <div class="flex-root d-flex flex-column mt-4">
                                                <span class="text-muted fw-bold">Email</span>
                                                <span class="fs-5">{{ $order->client->email }}</span>
                                            </div>
                                            <div class="flex-root d-flex flex-column mt-4">
                                                <span class="text-muted fw-bold">Address</span>
                                                <span class="fs-5">{{ $order->client->address }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        <!--end::Logo-->
                                        <div class="text-sm-end">
                                            <!--begin::Logo-->
                                            <a href="#" class="d-block mw-150px ms-sm-auto">
                                                <img alt="Logo" src="{{ asset($business->logo) }}" class="w-50" />
                                            </a>
                                            <!--end::Logo-->
                                            <!--begin::Text-->
                                            <div class="text-sm-end fw-semibold fs-4 mt-7">
                                                <div class="text-dark">Ruban By Salwa</div>
                                                <div>{{ $business->phone }}</div>
                                                <div>{{ $business->address }}</div>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="pb-12">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column gap-7 gap-md-10">
                                            <!--begin:Return summary-->
                                            <div class="d-flex justify-content-between flex-column">
                                                <!--begin::Table-->
                                                <div class="table-responsive border-bottom mb-9">
                                                    <table class="table table-bordered border-secondary align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                        <thead>
                                                            <tr class="fs-6 fw-bold text-dark">
                                                                <th class="min-w-100px fs-3">Products</th>
                                                                <th class="text-end fs-3">Return QTY</th>
                                                                <th class="text-end fs-3">Unit Price</th>
                                                                <th class="text-end fs-3">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fw-semibold text-gray-600">
                                                            @foreach ($returnedItems as $item)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="symbol symbol-50px me-5">
                                                                            <span class="symbol-label" style="background-image:url({{ asset($item['product']->image) }});"></span>
                                                                        </div>
                                                                        <div class="d-flex flex-column">
                                                                            <span class="text-dark fw-bold">{{ $item['product']->name }}</span>
                                                                            @if ($item['variant_details'])
                                                                            <span class="text-muted">
                                                                                @foreach(json_decode($item['variant_details']) as $variant)
                                                                                <span>{{ $variant->value }}</span>
                                                                                @if (!$loop->last), @endif
                                                                                @endforeach
                                                                            </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">{{ $item['return_quantity'] }}</td>
                                                                <td class="text-end">{{ $currency->symbol }}{{ number_format($item['unit_price'], 2) }}</td>
                                                                <td class="text-end">{{ $currency->symbol }}{{ number_format($item['return_amount'], 2) }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="text-dark fw-bold text-end">
                                                                <td colspan="3">Total Return Amount</td>
                                                                <td class="text-dark fs-3 fw-bolder text-end">
                                                                    {{ $currency->symbol }}{{ number_format($totalReturnAmount, 2) }}
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!--end::Table-->
                                            </div>
                                            <!--end:Return summary-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!-- end::Wrapper-->
                            </div>
                            <!-- end::Body-->
                        </div>
                        <!-- end::Invoice 1-->
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
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html> 