@extends('layouts.app')

@section('title', 'products')

@section('sub-title', 'generate barcodes')

@section('actions')
<a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary px-4 d-flex align-items-center">
    <i class="bi bi-caret-left-fill"></i>
    Back
</a>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/barcodes.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-custom">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title mb-0">Barcode Generator</h3>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="barcode-icon-container">
                            <i class="bi bi-upc-scan" style="font-size: 300px; opacity: 0.5; margin-bottom: 10px;"></i>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 py-3" style="margin-top: 30px;" id="generate_barcodes">
                        <i class="bi bi-upc me-2"></i>Generate Barcodes
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-custom">
                <div class="card-header">
                    <h3 class="card-title mb-0">Barcode Configuration</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="label_width">Label Width (mm)</label>
                                <input type="number" class="form-control" id="label_width" value="52" min="10"
                                    max="100">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="label_height">Label Height (mm)</label>
                                <input type="number" class="form-control" id="label_height" value="30" min="10"
                                    max="100">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="labels_per_row">Labels Per Row</label>
                                <input type="number" class="form-control" id="labels_per_row" value="1" min="1"
                                    max="10">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barcode_prefix">Prefix (Optional)</label>
                                <input type="text" class="form-control" id="barcode_prefix" placeholder="Enter prefix">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barcode_quantity">Quantity</label>
                                <input type="number" class="form-control" id="barcode_quantity" value="10" min="1"
                                    max="1000">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barcode_type">Barcode Type</label>
                                <select class="form-select" id="barcode_type">
                                    <option value="CODE128">Code 128</option>
                                    <option value="CODE39">Code 39</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barcode_size">Barcode Size</label>
                                <select class="form-select" id="barcode_size">
                                    <option value="1">Small</option>
                                    <option value="2" selected>Medium</option>
                                    <option value="3">Large</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-group w-100">
                                <button class="btn btn-success w-100" id="print_barcodes" disabled>
                                    <i class="bi bi-printer"></i> <span class="ms-1">Print Barcodes</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-group w-100">
                                <button class="btn btn-primary w-100" id="preview_barcodes" disabled>
                                    <i class="bi bi-eye text-dark"></i> <span class="ms-1">Preview Labels</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="barcodes_container" class="d-none mt-4">
                        <div class="mb-3 border-top pt-3">
                            <h4>Generated Barcodes</h4>
                        </div>
                        <div class="row" id="barcode_list">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Container -->
<div id="print_container" class="d-none">
    <div id="label_sheet" class="label-sheet"></div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Label Printing Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="label-sheet" id="preview_sheet"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="print_from_preview">Print</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.6/JsBarcode.all.min.js"
    integrity="sha512-k2wo/BkbloaRU7gc/RkCekHr4IOVe10kYxJ/Q8dRPl7u3YshAQmg3WfZtIcseEk+nGBdK03fHBeLgXTxRmWCLQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/js/generate_barcode.js') }}"></script>
@endsection