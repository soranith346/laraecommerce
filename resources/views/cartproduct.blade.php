@extends('maindesign')

@section('viewcart_product')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-uppercase"><i class="bi bi-cart3 me-2"></i> Your Cart</h5>
                </div>
                <div class="card-body">
                    @if($productCart->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-muted">No products found in your cart.</p>
                            <a href="{{ url('/') }}" class="btn px-4 text-white fw-bold" style="background-color: #0F264B">Continue Shopping</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productCart as $cart)
                                    <tr id="tr_{{$cart->id}}">
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                @if($cart->product->image)
                                                    <img src="{{ asset('uploads/'.$cart->product->image) }}" class="rounded me-3" style="width:60px; height:60px; object-fit:cover;">
                                                @else
                                                    <img src="{{ asset('noimage/noimage.png') }}" class="rounded me-3" style="width:60px; height:60px; object-fit:cover;">
                                                @endif
                                                <span class="fw-bold">{{ $cart->product->product_name }}</span>
                                            </div>
                                        </td>
                                        <td>${{ number_format($cart->product->price, 2) }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                                {{ $cart->quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="deleteCart({{$cart->id}})">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- -------------- --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="top: 20px;">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Price</span>
                        <h4 class="fw-bold text-success mb-0">
                            ៛<span id="grand-total">{{ number_format($totalPrice, 2) }}</span>
                        </h4>
                    </div>
                    
                    <hr>

                    <form action="{{route('confirmOrder')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="receiver_phone" class="form-control" placeholder="012 345 678" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Delivery Address</label>
                            <textarea name="receiver_address" class="form-control" rows="3" placeholder="Street, House No, City..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold text-uppercase shadow-sm">
                            Confirm Order <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function deleteCart(id){
            if(confirm('Are you sure to delete this ?')){
                $.ajax({
                    type: "get",
                    url: "removecart/"+ id,
                    success: function (res) {
                        if(res.success) {
                            $("#" + res.tr).slideUp('slow', function() {
                                $(this).remove();
                                if ($('tbody tr').length == 0) location.reload();
                            });
                            $('#grand-total').text(res.newTotal);
                        }
                    }
                });
            }
        }
    </script>
@endpush
@endsection