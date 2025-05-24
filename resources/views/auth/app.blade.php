<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ruban By Salwa</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    {{-- Font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url("{{ asset('assets/images/login-bg.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
    <!--end::Page bg image-->

    {{-- Custom Styling --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank">
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!--begin::Body-->
            <div class="d-flex flex-center w-lg-50 p-10" style="margin: auto">
                <!--begin::Card-->
                <div class="card login-card-custom w-md-400px">
                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-column px-10 py-5">
                        <!--begin::Wrapper-->
                        @yield('content')
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
<!--end::Body-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }
    });
</script>

</html>