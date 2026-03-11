@extends('admin.maindesign')
@section('vieworder')

<div class="container-fluid mt-4">
    <div class="card order-card shadow-sm" style="background-color: #102A53">
        <div class="card-header header-custom p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white"><i class="bi bi-receipt-cutoff me-2"></i> Order Management List</h4>
                <span class="badge bg-light text-dark fw-bold">Total: {{ $orders->count() }}</span>
            </div>
        </div>

        <div class="card-body bg-white p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary text-uppercase small fw-bold">
                            <th class="ps-4">Order ID</th>
                            <th>Customer & Address</th>
                            <th>Product List & Unit Price</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Total Amount</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            {{-- 1. ID --}}
                            <td class="ps-4  align-middle">
                                <span class="fw-bold text-dark">#{{ $order->id }}</span>
                                <div class="small text-muted">{{ $order->created_at->format('d/m/Y') }}</div>
                            </td>

                            {{-- 2. User Info --}}
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; border-radius: 50%;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                                        <div class="small text-muted"><i class="bi bi-telephone-fill me-1"></i>{{ $order->receiver_phone }}</div>
                                        <div class="small text-muted text-truncate" style="max-width: 200px;">
                                            <i class="bi bi-geo-alt-fill me-1"></i>{{ $order->receiver_address }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- 3. Products --}}
                            <td class=" align-middle">
                                <ul class="list-unstyled mb-0 align-middle">
                                    @foreach($order->items as $item)
                                    <li class="mb-1 border-bottom pb-1">
                                        <span class="text-dark">{{ $item->product->product_name }}</span>
                                        <div class="small text-muted">
                                            ${{ number_format($item->price, 2) }} x {{ $item->quantity }} 
                                            <span class="text-primary fw-bold ms-2">(${{ number_format($item->price * $item->quantity, 2) }})</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>

                            {{-- 4. Status --}}
                            <td class="text-center align-middle">
                                @if($order->status == 'pending')
                                    <span class="status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge badge-pill badge-success px-3 py-2" 
                                        style="font-size: 12px; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);">
                                        <i class="bi bi-check-all me-1"></i> Completed
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endif
                            </td>

                            {{-- 5. Total Amount --}}
                            <td class="text-end align-middle">
                                <h5 class="fw-bold text-danger mb-0">${{ number_format($order->total_amount, 2) }}</h5>  
                                <div class="mt-2">
                                    <form action="{{route('admin.change_status' , $order->id)}}" method="POST" class="d-flex align-items-center justify-content-end">
                                        @csrf
                                        {{-- ១. ថែមលក្ខខណ្ឌ disabled បើ status ជា completed --}}
                                        <select name="status" class="form-select form-select-sm me-1" style="width: auto;" 
                                            {{ $order->status == 'completed' ? 'disabled' : '' }}>
                                            
                                            <option value="{{ $order->status}}">{{ ucfirst($order->status) }}</option>
                                            @if($order->status != 'completed')
                                                <option value="pending">Pending</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="paid">Paid</option>
                                                <option value="completed">Completed</option>
                                            @endif
                                        </select>

                                        {{-- ២. លាក់ ឬ Disable ប៊ូតុង Submit បើ status ជា completed --}}
                                        @if($order->status != 'completed')
                                            <button type="submit" onclick="return confirm('Are you sure you want to change this order status?')" class="btn btn-sm btn-dark">
                                                Submit
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                <i class="bi bi-lock-fill"></i>
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.downloadpdf', $order->id) }}" class="btn btn-primary">
                                        Download PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="mb-3 opacity-50">
                                <h5 class="text-muted">No orders found at the moment.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection