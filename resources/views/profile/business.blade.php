@extends('layouts.app')

@section('title', 'business')

@section('actions')
<a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary px-4 d-flex align-items-center">
    <i class="bi bi-caret-left-fill"></i>
    Back
</a>
@endsection

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xxl-8">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="mx-5 my-auto">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ asset($business->logo) }}" alt="business logo" />
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                </div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{
                                            ucwords($business->name) }}</a>
                                        <a href="#">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                        fill="white" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2 gap-4">
                                        <a href="mailto:{{ $business->email }}"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->{{ $business->email }}
                                        </a>
                                        <a href="tel:{{ $business->phone }}"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-telephone-fill"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->{{ $business->phone }}
                                        </a>
                                        @if ($business->website)
                                        <a href="{{ $business->website }}" target="_blank"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-browser-chrome"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M16 8a8 8 0 0 1-7.022 7.94l1.902-7.098a3 3 0 0 0 .05-1.492A3 3 0 0 0 10.237 6h5.511A8 8 0 0 1 16 8M0 8a8 8 0 0 0 7.927 8l1.426-5.321a3 3 0 0 1-.723.255 3 3 0 0 1-1.743-.147 3 3 0 0 1-1.043-.7L.633 4.876A8 8 0 0 0 0 8m5.004-.167L1.108 3.936A8.003 8.003 0 0 1 15.418 5H8.066a3 3 0 0 0-1.252.243 2.99 2.99 0 0 0-1.81 2.59M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->{{ ucwords($business->name) }}
                                        </a>
                                        @endif
                                        @if ($business->google_maps_link)
                                        <a href="{{ $business->google_maps_link }}" target="_blank"
                                            class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->Google Maps
                                        </a>
                                        @endif
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-4">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px p-2 m-2">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <i class="bi bi-stack"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="fs-2 fw-bold" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $business->categories->count() }}">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">Categories</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px p-2 m-2">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <i class="bi bi-box-seam-fill"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="fs-2 fw-bold" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $business->products->count() }}">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">Products</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px p-2 m-2">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <i class="bi bi-bag-fill"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="fs-2 fw-bold" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $business->orders->count() }}">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">Orders</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px p-2 m-2">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <i class="bi bi-cash-coin"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="fs-2 fw-bold" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $business->reports->count() }}">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">Reports</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px p-2 m-2">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <i class="bi bi-person-fill"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="fs-2 fw-bold" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $business->clients->count() }}">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">Clients</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-100px p-2 m-2">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                    <i class="bi bi-truck"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="fs-2 fw-bold" data-kt-countup="true"
                                                    data-kt-countup-value="{{ $business->suppliers->count() }}">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">Supplier</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab"
                                href="#kt_tab_pane_1">Overview</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#kt_tab_pane_2">Edit Business</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#kt_tab_pane_3">Operating Hours</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#kt_tab_pane_4">Menu</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#kt_tab_pane_5">Users</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab"
                                href="#kt_tab_pane_6">Settings</a>
                        </li>
                    </ul>
                    <!--begin::Navs-->
                </div>
            </div>
            <!--end::Navbar-->

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                    <div class="card user-info-card p-8">
                        <h4 class="card-title mb-4">Business Overview</h4>

                        <div class="user-info">
                            <div class="user-info-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Type:</span>
                                <span>{{ $business->type }}</span>
                            </div>
                            <div class="user-info-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Name:</span>
                                <span>{{ $business->name }}</span>
                            </div>
                            <div class="user-info-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Email:</span>
                                <span>{{ $business->email }}</span>
                            </div>
                            <div class="user-info-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Phone Number:</span>
                                <span>{{ $business->phone }}</span>
                            </div>
                            <div class="user-info-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Address:</span>
                                <span>{{ $business->address }}</span>
                            </div>
                            <div class="user-info-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Tax:</span>
                                <span>{{ ucwords($business->tax->name) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    <div class="card user-info-card p-8">
                        <h4 class="card-title mb-4">Edit Business</h4>
                        <form action="{{ route('business.update') }}" method="POST" enctype="multipart/form-data"
                            class="form">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $business->name }}" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">Tax</label>
                                        <select name="tax_id" class="form-select" data-control="select2" required
                                            data-placeholder="Select an option">
                                            <option value=""></option>
                                            @foreach ($taxes as $tax)
                                            <option value="{{ $tax->id }}" {{ $business->tax_id==$tax->id ? 'selected' :
                                                '' }}>{{ ucwords($tax->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $business->email }}" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required form-label">Phone Number</label>
                                        <input type="tel" class="form-control" name="phone"
                                            value="{{ $business->phone }}" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" name="website"
                                            value="{{ $business->website }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Google Maps</label>
                                        <input type="text" class="form-control" name="google_maps_link"
                                            placeholder="Enter Google Maps Link..."
                                            value="{{ $business->google_maps_link }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required form-label">Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $business->address }}" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-4 form-label">Logo</label>
                                        <div class="col-8">
                                            <div class="image-input image-input-empty" data-kt-image-input="true">
                                                <div class="image-input-wrapper w-100px h-100px"
                                                    style="background-image: url({{ asset($business->logo) }})">
                                                </div>
                                                <label
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click" title="Change image">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                </label>
                                                <span
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click" title="Cancel image">
                                                    <i class="fa fa-close"></i>
                                                </span>
                                                <span
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click" title="Remove image">
                                                    <i class="fa fa-close"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Business</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                    <div class="card user-info-card p-8">
                        <h4 class="card-title mb-4">Operating Hours</h4>
                        <form action="{{ route('business.operating_hours.update') }}" method="POST"
                            enctype="multipart/form-data" class="form">
                            @csrf

                            <div class="row my-4">
                                <div class="col-3 text-center fw-bold fs-5">Day</div>
                                <div class="col-3 text-center fw-bold fs-5">Open</div>
                                <div class="col-3 text-center fw-bold fs-5">Opening Hour</div>
                                <div class="col-3 text-center fw-bold fs-5">Closing Hour</div>
                            </div>

                            @foreach ($operating_hours as $operating_hour)
                            <div class="row my-2">
                                <div class="col-3 text-center my-auto">
                                    <input type="hidden" name="day[]" value="{{ $operating_hour->day }}">
                                    <span>{{ $operating_hour->day }}</span>
                                </div>
                                <div class="col-3 my-auto">
                                    <select name="open[]" class="form-select" data-control="select2" required>
                                        <option value="true" {{ $operating_hour->open ? 'selected' : '' }}>Open</option>
                                        <option value="false" {{ !$operating_hour->open ? 'selected' : '' }}>Closed
                                        </option>
                                    </select>
                                </div>
                                <div class="col-3 my-auto">
                                    <select name="opening_hour[]" class="form-select" data-placeholder="Closed"
                                        data-control="select2">
                                        <option value=""></option>
                                        @foreach ($hours as $hour)
                                        <option value="{{ $hour }}" {{ $hour==$operating_hour->opening_hour ? 'selected'
                                            : ''
                                            }}>
                                            {{ $hour }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 my-auto">
                                    <select name="closing_hour[]" class="form-select" data-placeholder="Closed"
                                        data-control="select2">
                                        <option value=""></option>
                                        @foreach ($hours as $hour)
                                        <option value="{{ $hour }}" {{ $hour==$operating_hour->closing_hour ? 'selected'
                                            : ''
                                            }}>
                                            {{ $hour }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endforeach

                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Operating Hours</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                    <div class="row gap-5">
                        <div class="col-md-3">
                            <div class="card user-info-card p-8 mb-4">
                                <form action="{{ route('business.menu.toggle') }}" method="get"
                                    enctype="multipart/form-data" class="mb-3">
                                    @csrf

                                    <div class="form-group">
                                        <h3>Menu</h3>
                                        <button type="submit"
                                            class="btn btn-lg btn-secondary btn-toggle {{ $business->menu_activated ? 'active' : '' }}"
                                            data-toggle="button" aria-pressed="false" autocomplete="off">
                                            <div class="handle"></div>
                                        </button>
                                    </div>
                                </form>

                                <form action="{{ route('business.orders.toggle') }}" method="get"
                                    enctype="multipart/form-data" class="mb-3">
                                    @csrf

                                    <div class="form-group">
                                        <h3>Menu Orders</h3>
                                        <button type="submit"
                                            class="btn btn-lg btn-secondary btn-toggle {{ $business->ordering_activated ? 'active' : '' }}"
                                            data-toggle="button" aria-pressed="false" autocomplete="off">
                                            <div class="handle"></div>
                                        </button>
                                    </div>
                                </form>

                                <form action="{{ route('business.delivery.toggle') }}" method="get"
                                    enctype="multipart/form-data" class="mb-3">
                                    @csrf

                                    <div class="form-group">
                                        <h3>Delivery</h3>
                                        <button type="submit"
                                            class="btn btn-lg btn-secondary btn-toggle {{ $business->delivery_activated ? 'active' : '' }}"
                                            data-toggle="button" aria-pressed="false" autocomplete="off">
                                            <div class="handle"></div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card user-info-card p-8">
                                <form action="{{ route('business.delivery.update') }}" method="POST"
                                    enctype="multipart/form-data" class="mb-3">
                                    @csrf

                                    <label for="delivery" class="form-label mb-4">Delivery Fee</label>

                                    <div class="row px-4">
                                        <div class="col p-0">
                                            <input type="number" name="delivery" value="{{ $business->delivery }}"
                                                min="0" step="any" class="form-control" required>
                                        </div>
                                        <div class="col p-0">
                                            <button type="submit" class="btn btn-primary mx-2">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card col-md-4 user-info-card p-8 mb-auto">
                            <div class="d-flex justify-content-center align-content-center mb-4">
                                {!! QrCode::size(200)->generate(route('menu', $business->name)) !!}
                            </div>
                            <a href="{{ route('qrcode.download', $business->id) }}"
                                class="btn btn-primary mt-5">Download QR
                                Code</a>
                        </div>
                        <div class="card col-md-4 user-info-card p-8 mb-auto">
                            <div class="d-flex justify-content-center align-content-center">
                                <img src="{{ asset($business->banner ?? 'assets/images/menu/menu-hero.jpg') }}"
                                    class="img-fluid rounded ">
                            </div>

                            <form action="{{ route('business.banner_upload') }}" method="post" class="mt-4"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label class="required form-label">Banner</label>
                                    <input type="file" class="form-control" name="banner" required />
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Update Banner</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                    <div class="card col-md-4 user-info-card p-8">
                        <h4 class="card-title mb-4">Users</h4>
                        <p class="card-text text-muted my-5">
                        <ul>
                            @foreach ($business->users as $user)
                            <li>{{ ucwords($user->name) }} ({{ ucwords($user->role) }})</li>
                            @endforeach
                        </ul>
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">
                    <div class="card offset-md-2 col-md-8 user-info-card p-8">
                        <h4 class="card-title mb-4">Deactivate Account</h4>
                        <p class="card-text text-muted text-center my-5">
                            Once your account is deactivated, you will delete your subscriptions and cannot be
                            recovered.
                        </p>
                        <div class="text-end mt-5">
                            <a href="#" class="btn btn-danger w-md-25">Deactivate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->
</div>
<!--end::Content wrapper-->
@endsection