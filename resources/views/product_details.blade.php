@extends('maindesign')
@section('product_detail')

<div class="detail-page-section">
    <div class="container">
        <div class="mb-4" data-aos="fade-right">
            <button onclick="goBack()" class="btn btn-sm" style="background-color:#153B7B;color:white">
                <i class="bi bi-chevron-left me-1"></i> BACK TO CATALOG
            </button>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="content-card p-4 p-md-5">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="product-img-box shadow-sm mb-3">
                                <img src="{{ $product->image ? asset('uploads/'.$product->image) : asset('noimage/noimage.png') }}" 
                                     class="img-fluid" style="max-height: 100%" alt="{{ $product->product_name }}">
                            </div>
                            <h6 class="fw-bold mt-4">Description:</h6>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <span class="badge mb-2" style="background: #e0e7ff; color: #4338ca;">Category: {{ $product->category }}</span>
                            <h1 class="h2 fw-bold mb-3">{{ $product->product_name }}</h1>
                            <h3 class="text-primary fw-bold mb-4">៛{{ number_format($product->price, 2) }}</h3>

                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="p-2 border rounded d-flex align-items-center bg-light">
                                        <i class="bi bi-shield-check me-2 text-success"></i>
                                        <span class="small fw-bold">1 Year Warranty</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 border rounded d-flex align-items-center bg-light">
                                        <i class="bi bi-truck me-2 text-primary"></i>
                                        <span class="small fw-bold">Fast Delivery</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-top">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="qty-box">
                                        <button onclick="changeQty(-1)"><i class="bi bi-dash"></i></button>
                                        <input type="text" id="qty" value="1" readonly>
                                        <button onclick="changeQty(1)"><i class="bi bi-plus"></i></button>
                                    </div>
                                    <button id="addToCartBtn" class="btn-cart flex-grow-1">
                                        <i class="bi bi-bag-plus-fill me-2"></i> ADD TO CART
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="review-card h-100 shadow-sm border-0">
                    <div class="p-4 border-bottom bg-light rounded-top">
                        <h5 class="mb-0 fw-bold">Customer Review</h5>
                        <p class="small text-muted mb-0">Share your feedback</p>
                    </div>
                    <div class="p-4">
                        @auth
                            @if(auth()->user()->email_verified_at)
                                <form id="reviewForm">
                                    @csrf
                                    <div class="star-rating mb-4">
                                        <input type="radio" name="rating" id="star5" value="5"><label for="star5" class="bi bi-star-fill"></label>
                                        <input type="radio" name="rating" id="star4" value="4"><label for="star4" class="bi bi-star-fill"></label>
                                        <input type="radio" name="rating" id="star3" value="3"><label for="star3" class="bi bi-star-fill"></label>
                                        <input type="radio" name="rating" id="star2" value="2"><label for="star2" class="bi bi-star-fill"></label>
                                        <input type="radio" name="rating" id="star1" value="1"><label for="star1" class="bi bi-star-fill"></label>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-input-pill" placeholder="Display Name" value="{{ auth()->user()->name }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <textarea class="form-input-pill" rows="4" placeholder="Your feedback..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">
                                        SUBMIT REVIEW <i class="bi bi-send-fill ms-2"></i>
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-patch-exclamation text-warning d-block mb-3" style="font-size: 3rem;"></i>
                                    <h6 class="fw-bold">Verification Required</h6>
                                    <p class="small text-muted mb-4">សូមផ្ទៀងផ្ទាត់អ៊ីមែលរបស់អ្នកជាមុនសិន ដើម្បីអាចផ្ដល់មតិយោបល់បាន។</p>
                                    <a href="{{ route('otp.view') }}" class="btn btn-primary px-4 rounded-pill fw-bold">Verify Email Now</a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-chat-dots text-muted d-block mb-3" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold">Want to review?</h6>
                                <p class="small text-muted mb-4">Please login to share your experience.</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-dark px-4 rounded-pill fw-bold">Login</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
    AOS.init({ duration: 800, once: true });

    function changeQty(amount) {
        let qtyInput = document.getElementById('qty');
        let currentQty = parseInt(qtyInput.value);
        let newQty = currentQty + amount;
        if(newQty >= 1) qtyInput.value = newQty;
    }
    function goBack(){
        window.history.back();
    }


    // Logic for Add to Cart with Verification Check
    $('#addToCartBtn').click(function(e){
        e.preventDefault();

        @guest
            Swal.fire({
                icon: 'warning',
                title: 'Login Required',
                text: 'Please login to add items to cart!',
                confirmButtonText: 'Login'
            }).then((r) => { if(r.isConfirmed) window.location.href="{{ route('login') }}"; });
            return;
        @endguest

        @auth
            @if(!auth()->user()->email_verified_at)
                Swal.fire({
                    icon: 'error',
                    title: 'Account Not Verified',
                    text: 'Please verify your email to place an order!',
                    showCancelButton: true,
                    confirmButtonText: 'Verify Now',
                    cancelButtonText: 'Later'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = "{{ route('verification.notice') }}";
                });
                return;
            @endif
        @endauth

        let productId = "{{ $product->id }}";
        let quantity = $('#qty').val();

        $.ajax({
            url: "{{ route('add_to_cart', $product->id) }}",
            method: "POST",
            data: { _token:"{{ csrf_token() }}", product_id:productId, quantity:quantity },
            success: function(res){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Added to Cart!',
                    showConfirmButton: false,
                    timer: 1000
                });
            }
        });
    });
</script>
@endsection