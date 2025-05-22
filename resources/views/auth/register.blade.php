@extends('auth.app')

@section('title', 'register')

@section('content')
<!--begin::Form-->
<form class="form w-100" id="kt_sign_up_form" action="{{ route('register') }}" method="post">
    @csrf
    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
        <!--end::Title-->
    </div>
    <!--begin::Heading-->

    <!--begin::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::Name-->
        <input type="text" placeholder="John Doe" name="name" class="form-control bg-transparent" autofocus required
            value="{{ old('name') }}" />
        <!--end::Name-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::Email-->
        <input type="email" placeholder="john.doe@gmail.com" name="email" value="{{ old('email') }}" required
            class="form-control bg-transparent" />
        <!--end::Email-->
    </div>
    <!--begin::Input group-->

    <!--begin::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::Phone-->
        <input type="tel" placeholder="01 234 567" name="phone" value="{{ old('phone') }}"
            class="form-control bg-transparent" required />
        <!--end::Phone-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group=-->
    <div class="fv-row mb-8" data-kt-password-meter="true">
        <!--begin::Wrapper-->
        <div class="mb-1">
            <!--begin::Input wrapper-->
            <div class="position-relative mb-3">
                <input class="form-control bg-transparent" type="password" placeholder="Password" name="password"
                    required autocomplete="off" />
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                    data-kt-password-meter-control="visibility">
                    <i class="bi bi-eye-slash fs-2"></i>
                    <i class="bi bi-eye fs-2 d-none"></i>
                </span>
            </div>
            <!--end::Input wrapper-->
            <!--begin::Meter-->
            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
            </div>
            <!--end::Meter-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Hint-->
        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.
        </div>
        <!--end::Hint-->
    </div>
    <!--end::Input group=-->
    <!--end::Input group=-->
    <div class="fv-row mb-8">
        <!--begin::Repeat Password-->
        <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" required
            class="form-control bg-transparent" />
        <!--end::Repeat Password-->
    </div>
    <!--end::Input group=-->
    <!--begin::Accept-->
    <div class="fv-row mb-8">
        <label class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }} required />
            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
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
                                <h2>Terms & Conditions</h2>
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
            </span>
        </label>
    </div>
    <!--end::Accept-->
    <!--begin::Submit button-->
    <div class="d-grid mb-10">
        {{-- <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
            <!--begin::Indicator label-->
            <span class="indicator-label">Sign up</span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button> --}}
        <button class="g-recaptcha btn btn-primary" data-sitekey="{{ config('services.recaptcha.key') }}"
            data-callback='onSubmit' data-action='submit'>
            <!--begin::Indicator label-->
            <span class="indicator-label">Sign up</span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--end::Submit button-->
    <!--begin::Sign up-->
    <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
        <a href="{{ route('login') }}" class="link-yellow fw-semibold">Sign in</a>
    </div>
    <!--end::Sign up-->
</form>
<!--end::Form-->
@endsection

@section('scripts')

{{-- reCAPTCHA --}}
<script src="https://www.google.com/recaptcha/api.js"></script>

<script>
    function onSubmit(token) {
            document.getElementById("kt_sign_up_form").submit();
        }
</script>
{{-- reCAPTCHA --}}

<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/custom/authentication/sign-up/general.js') }}"></script>
<!--end::Custom Javascript-->
@endsection