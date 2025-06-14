@extends('auth.app')

@section('content')
<!--begin::Form-->
<form class="form w-100" method="POST">
    @csrf

    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-white fw-bolder my-4 display-6 orange-color">Password</h1>
        <!--end::Title-->
    </div>
    <!--begin::Heading-->

    <!--begin::Input group=-->
    <div class="fv-row mb-3">
        <!--begin::Password-->
        <input id="page_password" type="password" placeholder="Password" name="page_password" required
            class="form-control bg-transparent text-white" />
        <!--end::Password-->
    </div>
    <!--end::Input group=-->

    <!--begin::Submit button-->
    <div class="d-grid mb-5">
        <button type="submit" class="btn btn-primary error-btn indicator-label-custom">
            <!--begin::Indicator label-->
            <span class="indicator-label text-white">Unlock</span>
            <!--end::Indicator label-->
        </button>
    </div>
    <!--end::Submit button-->
</form>
<!--end::Form-->
@endsection