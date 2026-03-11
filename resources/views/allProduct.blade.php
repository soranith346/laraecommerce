@extends('maindesign')
@section('content')
<div class="container py-5">
    <div class="text-center mb-5" data-aos="fade-down">
        <h2 class="font-weight-bold" style="letter-spacing: 2px;">OUR COLLECTIONS</h2>
        <div class="mx-auto" style="width: 80px; height: 3px; background: #007bff;"></div>
    </div>

    @foreach($productsByCategory as $categoryName => $products)
        <div class="category-block mb-5" data-aos="fade-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-uppercase font-weight-bold category-title m-0" style="color: #2c3e50;">
                    {{ $categoryName ?: 'Other Products' }}
                </h3>
                <span class="badge badge-pill badge-light border px-3 py-2">{{ $products->count() }} Items</span>
            </div>

            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm product-card">
                            <div class="img-container p-3" style="background-color: #112A53">
                                @if($product->image)
                                    <img src="{{ asset('uploads/' . $product->image) }}" class="img-fluid"  style="max-height: 100%; object-fit: contain; border-radius: 5px; " alt="{{ $product->product_name }}">
                                @else
                                    <div class="text-center text-muted">
                                        <img src="{{asset('noimage/noimage.png')}}" alt="">
                                    </div>
                                @endif

                                <div class="view-detail-overlay">
                                    <a href="{{ url('/product/'.$product->id) }}" class="btn btn-light btn-sm rounded-pill px-4 btn-view-detail shadow">
                                        <i class="fas fa-eye mr-1"></i> View Detail
                                    </a>
                                </div>
                            </div>

                            <div class="card-body text-center d-flex flex-column">
                                <h6 class="card-title font-weight-bold text-truncate">{{ $product->product_name }}</h6>
                                <p class="text-primary font-weight-bold h5 mb-3">៛{{ number_format($product->price, 2) }}</p>
                                
                                <div class="mt-auto">
                                    <a href="{{ route('product.show', $product->id) }}" class="btn text-white btn-block rounded-pill py-2 shadow-sm"​ style="background-color: #112A53">
                                        <i class="fas fa-shopping-cart mr-2"></i>Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
    });
</script>
@endsection