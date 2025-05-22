@extends('auth.app')

@section('title', 'setup')

@section('content')
<form action="{{ route('setup.save') }}" method="POST" enctype="multipart/form-data" class="form">
    @csrf
    <div class="card-head">
        <h1 class="text-center text-primary">New Business</h1>
    </div>
    <div class="card-body">
        <p class="form-label text-center mb-10">
            Please create a new Business in order to proceed
        </p>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required form-label">Business Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Name..."
                        value="{{ old('name') }}" required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label required">Type</label>
                    <select name="type" class="form-select" data-control="select2" required
                        data-placeholder="Select an option">
                        <option value=""></option>
                        @foreach ($types as $type)
                        <option value="{{ $type }}" {{ old('type')==$type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label required">Tax</label>
                    <select name="tax_id" class="form-select" data-control="select2" required
                        data-placeholder="Select an option">
                        <option value=""></option>
                        @foreach ($taxes as $tax)
                        <option value="{{ $tax->id }}" {{ old('tax_id')==$tax->id ? 'selected' :
                            '' }}>{{ ucwords($tax->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="required form-label">Business Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter Email..."
                        value="{{ old('email') }}" required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="required form-label">Business Phone Number</label>
                    <input type="tel" class="form-control" name="phone" placeholder="Enter Phone Number..."
                        value="{{ old('phone') }}" required />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="text" class="form-control" name="website" placeholder="Enter Website..."
                        value="{{ old('website') }}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Google Maps</label>
                    <input type="text" class="form-control" name="google_maps_link"
                        placeholder="Enter Google Maps Link..." value="{{ old('google_maps_link') }}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label required">Business Address</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Enter Address..."
                        required>{{ old('address') }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-4 form-label">Logo</label>
                    <div class="col-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-empty" data-kt-image-input="true">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-100px h-100px"
                                style="background-image: url({{ asset('assets/images/no_img.png') }})"></div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Change image">
                                <i class="fa fa-pen"></i>

                                <!--begin::Inputs-->
                                <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Remove image">
                                <i class="fa fa-close"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Remove image">
                                <i class="fa fa-close"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer pt-0">
        <div class="d-flex align-items-center justify-content-around">
            <button type="reset" class="btn btn-danger clear-btn py-2 px-4 ms-3">Clear</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection