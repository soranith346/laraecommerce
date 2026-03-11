@extends('maindesign')
@section('index')


<section class="py-5">
    <div class="container slim-container">
        
        <div class="row mb-4 mb-md-5 text-center" data-aos="fade-up">
            <div class="col-12">
                <h6 class="text-primary fw-bold text-uppercase small mb-1" style="letter-spacing: 2px;">Fresh Arrivals</h6>
                <h2 class="fw-bold mb-3" style="color: var(--brand-dark);">LATEST PRODUCTS</h2>
                <div class="mx-auto" style="width: 40px; height: 3px; background: var(--brand-primary); border-radius: 10px;"></div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($latest_products as $index => $product)
            <div class="col" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                <div class="card product-card shadow-sm border-0 rounded-3">
                    
                    <div class="image-wrapper">
                        <img src="{{ $product->image ? asset('uploads/'.$product->image) : asset('noimage/noimage.png') }}" 
                             class="card-img-top" alt="{{ $product->product_name }}">
                        
                        <div class="image-overlay d-none d-md-flex">
                            <a href="{{ url('/product/'.$product->id) }}" class="btn btn-light btn-sm fw-bold rounded-pill px-3">
                                VIEW DETAILS
                            </a>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column text-center p-3">
                        <a href="{{ url('/product/'.$product->id) }}" class="p-title mb-2">
                            {{ $product->product_name }}
                        </a>
                        
                        <h5 class="fw-bold mb-3" style="color: var(--brand-primary);">
                            ៛{{ number_format($product->price, 2) }}
                        </h5>

                        <div class="mt-auto">
                            <a href="{{ route('product.show', $product->id) }}" 
                               class="btn btn-primary w-100 rounded-pill shadow-sm py-2 fw-bold border-0" 
                               style="background-color: var(--brand-dark);">
                                <i class="bi bi-cart3 me-2"></i>BUY NOW
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('allProduct') }}" class="btn btn-dark rounded-pill px-5 py-2 fw-bold shadow">
                SEE ALL PRODUCTS <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="pb-5" data-aos="fade-up">
    <div class="container slim-container">
        <div class="rounded-4 overflow-hidden shadow-sm border">
            <div class="ratio ratio-21x9 shadow-sm" style="min-height: 300px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125062.92383184617!2d104.82390885233076!3d11.57218671603525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513dc76a6be3%3A0x9c01010c20758972!2sPhnom%20Penh!5e0!3m2!1sen!2skh!4v1710000000000!5m2!1sen!2skh" 
                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({ 
            duration: 800, 
            once: true,
            disable: 'mobile'
        });
    });
</script>

@endsection