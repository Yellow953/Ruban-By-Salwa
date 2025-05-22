<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>YellowPOS | {{ ucwords(View::yieldContent('title')) }}</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/yellowpos_favicon.png') }}" />

    {{-- Font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url("{{ asset('assets/images/yellow_gradient_bg.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .login-card-custom {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
    <!--end::Page bg image-->

    {{-- Custom Styling --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank">
    @yield('content')

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
<!--end::Body-->

</html>