@extends('app')
@section('content')
<style>
    body {
        background-color: #f4f7f9;
    }
    .product-container {
        margin-top: 50px;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .product-image-section {
        background: #0F284E; /* ពណ៌ដែលអ្នកចូលចិត្ត */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }
    .product-image-section img {
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
        object-fit: cover;
    }
    .product-image-section img:hover {
        transform: scale(1.05);
    }
    .product-info-section {
        padding: 50px;
    }
    .price-tag {
        font-size: 2rem;
        color: #0f52b6;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .btn-generate {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
        padding: 15px 30px;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        color: white;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-generate:hover {
        box-shadow: 0 8px 15px rgba(40, 167, 69, 0.3);
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="container">
    <div class="row product-container">
        <div class="col-md-6 product-image-section">
            @if ($product->image)
                <img src="{{ asset('uploads/' . $product->image) }}" width="350px" height="350px" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('noimage/noimage.png') }}" width="350px" height="350px" alt="No Image">
            @endif
        </div>

        <div class="col-md-6 product-info-section">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Details</li>
                </ol>
            </nav>
            
            <h1 class="display-5 fw-bold mb-3" style="color: #333;">{{ $product->name }}</h1>
            <p class="text-muted mb-4" style="line-height: 1.8; font-size: 1.1rem;">
                {{ $product->description }}
            </p>

            <div class="price-tag">
                {{ number_format($product->price, 0) }} ៛
            </div>

            <hr class="my-4">

            <form action="{{ route('checkout', $product->id) }}" method="POST">
                @csrf
                <button class="btn btn-generate shadow-sm">
                    <i class="bi bi-qr-code-scan me-2"></i> Generate KHQR to Pay
                </button>
            </form>

            <div class="mt-4 d-flex align-items-center text-muted small">
                <div class="me-4"><i class="bi bi-shield-check text-success me-1"></i> Secure Payment</div>
                <div><i class="bi bi-truck text-primary me-1"></i> Fast Delivery</div>
            </div>
        </div>
    </div>
</div>
@endsection