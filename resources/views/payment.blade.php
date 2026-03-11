@extends('app')
@section('content')
<style>
    .btn-custom-dark { background-color: #112A53; color: white !important; transition: all 0.3s ease; border: none; }
    .btn-custom-dark:hover { background-color: #1a3f7a; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(17, 42, 83, 0.3); }
    .payment-card { border-radius: 24px; background: white; border: none; }
    .qr-container { border-radius: 20px; background-color: #f8f9fa; border: 1px solid #eee; }
    .amount-display { background: #f0f4f8; border-radius: 15px; padding: 15px; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 text-center">
            <div class="card shadow-lg p-4 payment-card">
                
                {{-- Header --}}
                <div class="mb-4">
                    <i class="bi bi-shield-check text-primary" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-2 text-uppercase">Secure Checkout</h4>
                    {{-- ការពារ Error ដោយប្រើ ?? --}}
                    <p class="text-muted small">{{ $description ?? 'Order ID: #' . ($order->id) }}</p>
                </div>
                
                {{-- Price Display --}}
                <div class="amount-display mb-4">
                    <span class="text-muted small text-uppercase fw-semibold">Total to Pay</span>
                    <h2 class="text-primary fw-bold mb-0">
                        {{ number_format($amount ?? ($order->total_amount ?? 0), 2) }}៛
                    </h2>
                </div>

                {{-- QR Section --}}
                <div class="p-4 qr-container mb-4 shadow-sm bg-white">
                    @if(isset($qr))
                        <div class="animate__animated animate__zoomIn">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ $qr }}" 
                                 class="img-fluid border p-2 rounded-3 shadow-sm bg-white" alt="KHQR">
                            
                            <div class="mt-4">
                                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                <p class="text-primary small fw-bold mb-0 mt-2">Waiting for payment...</p>
                                <p class="text-muted x-small">Scan with any Mobile Banking App</p>
                            </div>
                            
                            <input type="hidden" id="md5_hash" value="{{ $md5 }}">
                        </div>
                    @else
                        {{-- បើមិនទាន់មាន QR ទេ ឱ្យគេចុចប៊ូតុងបង្កើត --}}
                        <form action="{{ route('checkout', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">
                                <i class="bi bi-qr-code-scan me-2"></i> GENERATE QR CODE
                            </button>
                        </form>
                    @endif
                </div>
                    
                {{-- Navigation --}}
                <div class="d-grid gap-2">
                    <a href="{{ route('index') }}" class="btn btn-custom-dark rounded-pill py-3 fw-bold">
                        <i class="bi bi-shop me-2"></i> BACK TO SHOP
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(isset($md5))
<script>
    $(document).ready(function() {
        const md5 = $('#md5_hash').val();
        const orderId = "{{ $order_id ?? 0 }}";
        const displayAmount = "{{ number_format($amount ?? 0, 2) }} ៛"; 

        const checkStatus = setInterval(function() {
            $.ajax({
                url: "{{ route('verify.transaction') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    md5: md5,
                    order_id: orderId
                },
                success: function(res) {
                    if(res.status === "success") {
                        clearInterval(checkStatus);
                        Swal.fire({
                            title: 'Payment Successful!',
                            html: `<div class="text-center"><h2 class="fw-bold text-success">${displayAmount}</h2><p>Order #${orderId} has been paid.</p></div>`,
                            icon: 'success',
                            confirmButtonText: 'View My Orders',
                            confirmButtonColor: '#112A53'
                        }).then(() => {
                            window.location.href = "{{ route('myorders') }}";
                        });
                    }
                }
            });
        }, 4000);
    });
</script>
@endif
@endsection