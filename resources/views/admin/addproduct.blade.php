@extends('admin.maindesign')
@section('addProduct')

{{-- Success Alert Logic from your old code --}}
@if(session('success'))
@push('scripts')
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Product Added!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    width: '320px',
    padding: '12px',
});
</script>
@endpush
@endif

<style>
    /* Styling to match your screenshot */
    .form-header-banner {
        background-color: #112A53;
        color: white;
        padding: 15px 25px;
        border-radius: 15px 15px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-card-custom {
        background-color: white;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 30px;
    }

    .btn-view-all {
        border: 1px solid rgba(255,255,255,0.5);
        background: rgba(255,255,255,0.1);
        color: white;
        padding: 6px 15px;
        border-radius: 6px;
        font-size: 0.85rem;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-view-all:hover {
        background: white;
        color: #112A53;
    }

    .form-label {
        font-weight: 700;
        color: #333;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 15px;
    }

    .btn-save-custom {
        background-color: #112A53;
        color: white;
        padding: 10px 30px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save-custom:hover {
        background-color: #1a4b9e;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            {{-- Header Banner - Matches your Category Screen --}}
            <div class="form-header-banner">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-plus-circle me-2"></i> Add New Product
                </h5>
                <a href="{{ route('admin.view_product') }}" class="btn-view-all">
                    <i class="bi bi-grid-3x3-gap me-1"></i> View All Products
                </a>
            </div>

            {{-- Main Form Card --}}
            <div class="form-card-custom">
                <form action="{{ route('admin.storeProduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control" placeholder="Enter product name" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Display Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1">Show</option>
                                        <option value="0">Hide</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Enter description..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Product Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category }}">
                                                {{ $category->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Brand Name</label>
                                    <input type="text" name="brand" class="form-control" placeholder="Enter brand">
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 ps-md-4">
                            <div class="mb-4">
                                <label class="form-label">Stock</label>
                                <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Product Image</label>
                                <div class="border rounded p-4 text-center bg-light shadow-sm">
                                    <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                                    <input type="file" name="image" class="form-control mt-3">
                                    <p class="small text-muted mt-2 mb-0">Select high-quality product image</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button like your Category screen --}}
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-save-custom shadow">
                            <i class="bi bi-check-circle-fill"></i> Save Product
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection