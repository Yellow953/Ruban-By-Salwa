@extends('layouts.app')

@section('title', 'purchases')

@section('sub-title', 'new')

@section('actions')
<a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary px-4 d-flex align-items-center">
    <i class="bi bi-caret-left-fill"></i>
    Back
</a>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 order-2 order-md-1">
            <div class="card border-custom my-4 mt-md-0 shadow-sm radius-10px">
                <img src="{{ asset('assets/images/sales_order.png') }}" alt="Sales Order" class="img-fluid">
            </div>

            <div class="card border-custom p-4 my-4 mt-md-0 shadow-sm products-container">
                <h2 class="text-center text-primary my-4">Products</h2>

                <div class="d-flex p-4 mb-4">
                    <input type="text" id="searchInput" name="search" placeholder="Search By Name or Barcode ..."
                        class="form-control me-2">
                    <button type="submit" id="searchBtn" class="btn btn-sm btn-primary px-4 ms-2">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <div id="no-results" class="text-muted text-center d-none">No matching products found.</div>
                <div id="products" class="px-5 max-h-400px">
                    @foreach ($products as $product)
                    <div class="product-row row" data-name="{{ strtolower($product->name) }}"
                        data-barcodes="{{ $product->barcodes->pluck('barcode') }}">
                        <div class="col-9 pb-2 my-auto">
                            {{ $product->name }} <br>
                            @foreach ($product->barcodes->pluck('barcode') as $index => $barcode)
                            {{ $index == 0 ? "(" : "" }}
                            {{ $barcode }} {{ $index != ($product->barcodes->count() - 1) ? " , " : "" }}
                            {{ $index == ($product->barcodes->count() - 1) ? ")" : "" }}
                            @endforeach
                        </div>
                        <div class="col-3 pb-2 my-auto text-end">
                            <button class="btn btn-sm btn-success px-4"
                                onclick="addProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->price ?? 0 }})">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <hr>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-8 order-1 order-md-2">
            <form action="{{ route('purchases.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card border-custom p-4 my-4 mt-md-0 shadow-sm">
                    <h2 class="text-center text-primary my-4">New Purchase</h2>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="invoice_number" class="col-form-label">Invoice Number
                                    *</label>

                                <input id="invoice_number" type="text" placeholder="Enter Invoice Number" required
                                    class="form-control" name="invoice_number" value="{{ old('invoice_number') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchase_date" class="col-form-label">Purchase Date *</label>

                                <input id="purchase_date" type="date" required class="form-control" name="purchase_date"
                                    value="{{ old('purchase_date') ?? date('Y-m-d') }}">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="notes" class="col-form-label">Notes</label>

                                <textarea id="notes" placeholder="Enter any Notes" rows="3" class="form-control"
                                    name="notes">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-4 form-label">Image</label>
                                <div class="col-8">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-empty" data-kt-image-input="true">
                                        <!--begin::Image preview wrapper-->
                                        <div class="image-input-wrapper w-100px h-100px"
                                            style="background-image: url({{ asset('assets/images/no_img.png') }})">
                                        </div>
                                        <!--end::Image preview wrapper-->

                                        <!--begin::Edit button-->
                                        <label
                                            class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Change image">
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
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Remove image">
                                            <i class="fa fa-close"></i>
                                        </span>
                                        <!--end::Cancel button-->

                                        <!--begin::Remove button-->
                                        <span
                                            class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Remove image">
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

                <div class="card border-custom p-4 mb-4 shadow-sm">
                    <h2 class="text-center text-primary my-4">Items</h2>

                    <div class="py-4 px-5">
                        <div class="row">
                            <div class="col-4 fs-5 fw-bold">Product</div>
                            <div class="col-3 fs-5 fw-bold">Quantity</div>
                            <div class="col-3 fs-5 fw-bold">Cost</div>
                            <div class="col-2 fs-5 fw-bold">Remove</div>
                        </div>
                        <div id="product-items" class="my-4"></div>
                    </div>
                </div>

                <div class="card border-custom mb-4 shadow-sm">
                    <div class="d-flex align-items-center justify-content-around py-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const productItems = [];

    function addProduct(id, name) {
        productItems.push({ id, name });

        updateproductItemsUI();
    }

    function removeProduct(index) {
        productItems.splice(index, 1);

        updateproductItemsUI();
    }

    function updateproductItemsUI() {
        const productItemsContainer = document.getElementById('product-items');
        productItemsContainer.innerHTML = '';

        if (productItems.length === 0) {
            productItemsContainer.innerHTML = '<p class="text-center text-muted">No products added yet...</p>';
            return;
        }

        productItems.forEach((product, index) => {
            const itemRow = document.createElement('div');
            itemRow.className = 'row mb-2';

            itemRow.innerHTML = `
                <input type="hidden" name="items[${index}][product_id]" value="${product.id}">
                <div class="col-4 my-auto">
                    ${product.name}
                </div>
                <div class="col-3 my-auto">
                    <input type="number" name="items[${index}][quantity]" value="1" min="0" step="any" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="col-3 my-auto">
                    <input type="number" min="0" step="any" name="items[${index}][cost]" class="form-control" required>
                </div>
                <div class="col-2 my-auto text-center">
                    <button class="btn btn-sm btn-danger px-4" onclick="removeProduct(${index})">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;

            productItemsContainer.appendChild(itemRow);
        });
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const productRows = document.querySelectorAll('.product-row');
        let visibleCount = 0;

        productRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const barcodes = JSON.parse(row.getAttribute('data-barcodes') || '[]');

            const nameMatch = name.includes(query);
            const barcodeMatch = barcodes.some(barcode =>
                barcode.toLowerCase().includes(query)
            );

            row.style.display = (nameMatch || barcodeMatch) ? 'flex' : 'none';
            if (nameMatch || barcodeMatch) visibleCount++;
        });

        document.getElementById('no-results').classList.toggle('d-none', visibleCount > 0);
    });
</script>
@endsection