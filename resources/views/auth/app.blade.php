<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <title>YellowPOS | {{ ucwords(View::yieldContent('title')) }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/yellowpos_favicon.png') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '610421585302151');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=610421585302151&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>
<!--end::Head-->

<body id="kt_body" class="app-blank custom_scroller">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-0 p-md-10 order-2 order-lg-1">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-300px w-lg-500px p-0 p-md-10">
                        <div class="d-md-none d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/yellowpos_black_transparent_bg.png') }}" alt="logo"
                                class="mb-10" width="150" height="150">
                        </div>

                        @include('layouts._flash')

                        @yield('content')
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
                <!--begin::Footer-->
                <div class="d-flex justify-content-center fw-semibold fs-base gap-5 my-5">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_terms" class="link-yellow">Terms</a>
                    <!--begin::Modal - Create App-->
                    <div class="modal fade" id="kt_modal_terms" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-900px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="text-primary">Terms & Conditions</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body py-lg-10 px-lg-10">
                                    <p class="text-center">Last Updated: Aug 15, 2024</p>

                                    <h3 class="mb-3 text-primary">1. Introduction</h3>
                                    <p>Welcome to YellowPOS ("we", "our", "us"). These Terms and
                                        Conditions ("Terms") govern your use of our online Point of Sale (POS)
                                        application ("Service"). By accessing or using our Service, you agree to be
                                        bound by these Terms. If you do not agree with these Terms, you may not use
                                        the Service.</p>

                                    <h3 class="mb-3 text-primary">2. Eligibility</h3>
                                    <p>You must be at least 18 years old and capable of entering into a legally
                                        binding agreement to use our Service. By using the Service, you represent
                                        and warrant that you meet these requirements.</p>

                                    <h3 class="mb-3 text-primary">3. Account Registration</h3>
                                    <p>To access certain features of the Service, you must create an account. You
                                        agree to provide accurate, current, and complete information during the
                                        registration process and to update this information to keep it accurate,
                                        current, and complete. You are responsible for safeguarding your account
                                        credentials and for all activities that occur under your account.</p>

                                    <h3 class="mb-3 text-primary">4. Use of the Service</h3>
                                    <ul>
                                        <li><strong>License:</strong> We grant you a limited, non-exclusive,
                                            non-transferable license to use the Service in accordance with these
                                            Terms.</li>
                                        <li><strong>Prohibited Conduct:</strong> You agree not to use the Service
                                            for any unlawful purpose or in any way that disrupts, damages, or
                                            interferes with the Service. You must not attempt to gain unauthorized
                                            access to the Service or its related systems.</li>
                                        <li><strong>Data Integrity:</strong> You are responsible for the accuracy,
                                            quality, and legality of your data and the means by which you acquire
                                            it. We are not liable for any data loss or inaccuracies in the data you
                                            input into the Service.</li>
                                    </ul>

                                    <h3 class="mb-3 text-primary">5. Fees and Payments</h3>
                                    <ul>
                                        <li><strong>Subscription Plans:</strong> Certain features of the Service may
                                            require you to purchase a subscription plan. The pricing, features, and
                                            terms of these plans are outlined on our website and may change from
                                            time to time.</li>
                                        <li><strong>Payment Terms:</strong> Payments for subscription plans are due
                                            in advance and are non-refundable, except as required by law. You
                                            authorize us to charge your payment method for the agreed-upon fees.
                                        </li>
                                    </ul>

                                    <h3 class="mb-3 text-primary">6. Privacy Policy</h3>
                                    <p>Your use of the Service is also governed by our <a target="_blank"
                                            href="https://yellowtech.dev/privacy_policy"
                                            class="text-decoration-underline">Privacy Policy</a>, which explains how
                                        we collect, use, and protect your information. By using the Service, you
                                        consent to the practices described in the Privacy Policy.</p>

                                    <h3 class="mb-3 text-primary">7. Intellectual Property</h3>
                                    <p>All content, trademarks, and data on the Service, including but not limited
                                        to software, text, graphics, logos, icons, designs, and the selection and
                                        arrangement thereof, are the property of YellowPOS or its
                                        licensors. You may not copy, distribute, reproduce, or use any part of the
                                        Service without our prior written permission.</p>

                                    <h3 class="mb-3 text-primary">8. Limitation of Liability</h3>
                                    <p>To the fullest extent permitted by law, YellowPOS and its
                                        affiliates, officers, employees, agents, and licensors shall not be liable
                                        for any indirect, incidental, special, consequential, or punitive damages,
                                        or any loss of profits or revenues, whether incurred directly or indirectly,
                                        or any loss of data, use, goodwill, or other intangible losses, resulting
                                        from:</p>
                                    <ul>
                                        <li>Your use or inability to use the Service;</li>
                                        <li>Any unauthorized access to or use of our servers and/or any personal
                                            information stored therein;</li>
                                        <li>Any interruption or cessation of transmission to or from the Service;
                                        </li>
                                        <li>Any bugs, viruses, trojan horses, or the like that may be transmitted to
                                            or through our Service by any third party;</li>
                                        <li>Any errors or omissions in any content or for any loss or damage
                                            incurred as a result of the use of any content posted, emailed,
                                            transmitted, or otherwise made available through the Service.</li>
                                    </ul>

                                    <h3 class="mb-3 text-primary">9. Indemnification</h3>
                                    <p>You agree to indemnify and hold harmless YellowPOS, its affiliates,
                                        and their respective officers, directors, employees, and agents from any
                                        claims, losses, damages, liabilities, including legal fees, arising out of
                                        your use or misuse of the Service, violation of these Terms, or violation of
                                        any rights of another.</p>

                                    <h3 class="mb-3 text-primary">10. Termination</h3>
                                    <p>We reserve the right to suspend or terminate your access to the Service at
                                        any time, without notice or liability, for any reason, including if you
                                        breach these Terms. Upon termination, your right to use the Service will
                                        immediately cease, and any outstanding balances will remain due.</p>

                                    <h3 class="mb-3 text-primary">11. Modifications to the Service and Terms</h3>
                                    <p>We may modify the Service or these Terms at any time. Any changes to these
                                        Terms will be posted on our website or communicated to you via email. Your
                                        continued use of the Service after any such changes constitutes your
                                        acceptance of the new Terms.</p>

                                    <h3 class="mb-3 text-primary">12. Governing Law</h3>
                                    <p>These Terms shall be governed and construed in accordance with the laws of
                                        Lebanon, without regard to its conflict of law principles. Any
                                        legal action or proceeding arising under these Terms will be brought
                                        exclusively in the courts located in Lebanon.</p>

                                    <h3 class="mb-3 text-primary">13. Entire Agreement</h3>
                                    <p>These Terms, together with our Privacy Policy, constitute the entire
                                        agreement between you and YellowPOS regarding your use of the
                                        Service and supersede any prior agreements between you and us.</p>

                                    <h3 class="mb-3 text-primary">14. Contact Information</h3>
                                    <p>If you have any questions about these Terms, please contact us at:</p>
                                    <address>
                                        <strong>YellowPOS</strong><br>
                                        Lebanon, Beirut<br>
                                        <a href="mailto:yellow.tech.953@gmail.com">yellow.tech.953@gmail.com</a>
                                    </address>
                                </div>
                                <!--end::Modal body-->
                                <div class="card-footer text-center py-4">
                                    <small>&copy; {{ date('Y') }} YellowPOS. All rights reserved.</small>
                                </div>
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - Create App-->
                    <a href="{{ route('welcome') }}#pricing" class="link-yellow">Pricing</a>
                    <a href="mailto:yellow.tech.953@gmail.com" class="link-yellow">Contact Us</a>
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Body-->
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2 pb-5"
                style="background-image: url({{ asset('assets/images/auth-bg.png') }})">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center pt-0 pb-5 px-5 px-md-15 w-100">
                    <!--begin::Logo-->
                    <a href="#" class="d-none d-md-block mb-0">
                        <img alt="Logo" src="{{ asset('assets/images/yellowpos_yellow_transparent_bg.png') }}"
                            class="h-100px h-lg-200px" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Image-->
                    <img class="mx-auto w-275px w-md-50 w-xl-350px my-10 my-md-0"
                        src="{{ asset('assets/images/banner.png') }}" />
                    <!--end::Image-->
                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block text-yellow fs-2qx fw-bolder text-center mb-7">Quick, Reliable, and
                        Innovative</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="d-none d-lg-block text-yellow fs-paragraph text-center">Streamline your store
                        operations with our advanced POS system,
                        designed for speed, accuracy, and enhanced customer
                        satisfaction.
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Aside-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
    </script>

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

    @yield('scripts')
</body>

</html>