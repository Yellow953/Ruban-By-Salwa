@extends('layouts.app2')

@section('title', 'Verify Email')

@section('content')
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Body-->
        <div class="d-flex flex-center w-lg-50 p-10" style="margin: auto">
            <!--begin::Card-->
            <div class="card login-card-custom rounded-3 w-md-400px">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/images/yellowpos_black_transparent_bg.png') }}" class="w-50" alt="">
                    </div>

                    <!--begin::Title-->
                    <h1 class="fw-bolder fs-2hx mb-4">Verify Email!</h1>
                    <!--end::Title-->

                    <!--begin::Text-->
                    <div class="fw-semibold fs-6 text-dark-500 mb-7">Please Verify Your Email to Proceed...</div>
                    <!--end::Text-->

                    <!--begin::Action-->
                    <div class="fs-6 mb-8">
                        <span class="fw-semibold text-gray-500">Did’t receive an email?</span>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary mx-5 fw-bold">{{ __('Try Again...')
                                }}</button>
                        </form>
                    </div>
                    <!--end::Action-->

                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
@endsection
