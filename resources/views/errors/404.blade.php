@extends('auth.app')

@section('content')
<div class="card-body text-center">
    <!--begin::Title-->
    <h1 class="fw-bolder fs-2hx text-white mb-4">Oops!</h1>
    <!--end::Title-->
    <!--begin::Text-->
    <div class="fw-semibold fs-6 text-gray-300 mb-7">We can't find that page.</div>
    <!--end::Text-->

    <!--begin::Link-->
    <div class="mb-0">
        <a href="{{ url()->previous() }}" class="btn btn-sm error-btn">Back</a>
    </div>
    <!--end::Link-->
</div>
@endsection