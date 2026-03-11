@extends('admin.maindesign')
@section('viewproduct')

{{-- Update Alert --}}
@if(session('update_success'))
@push('scripts')
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Update !',
    text: "{{ session('update_success') }}",
    showConfirmButton: false,
    zIndex: 100,
    timer: 2000,
    timerProgressBar: true,
    width: '320px',
    padding: '12px',
    showClass: { popup: 'animate__animated animate__fadeInDown' },
});
</script>
@endpush
@endif

{{-- Delete Alert --}}
@if(session('delete_success'))
@push('scripts')
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Deleted !',
    text: "{{ session('delete_success') }}",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    width: '320px',
    padding: '12px',
    showClass: { popup: 'animate__animated animate__fadeInDown' },
});
</script>
@endpush
@endif
<div class="container-fluid mt-4">
    <div class="card order-card-custom shadow-sm">
        
        <div class="card-header header-custom p-3" style="background-color: #3B71CA">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white"><i class="bi bi-box-seam-fill me-2"></i> Product Management List</h4>
                <span class="badge bg-light text-dark fw-bold">Items: {{ $product->total() }}</span>
            </div>
        </div>
        
        <div class="card-body main-bg" style="background-color: #112A53">

            <div class="p-3 d-flex justify-content-between align-items-center bg-white shadow-sm mb-3" style="border-radius: 8px;">
                <form action="{{ route('admin.searchproduct') }}" method="GET" class="d-flex">
                    <div class="input-group" style="width: 350px; border: 1px solid #ced4da; border-radius: 4px; overflow: hidden;">
                        <input type="text" name="search" class="form-control border-0" placeholder="Search product..." value="{{ request('search') }}">
                        <button class="btn btn-search-custom text-white" style="background-color: #112A53" type="submit">Search</button>
                    </div>
                </form>

                <a href="{{ route('admin.add_product') }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold shadow-sm" style="background-color: #3b71ca; border: none; border-radius: 5px;">
                    <i class="bi bi-plus-circle-fill me-1"></i> Add Product
                </a>
            </div>

            {{-- Product Table --}}
            <div class="table-responsive" >
                <table class="table align-middle mb-0">
                    <thead>
                        <tr class="text-secondary text-uppercase small fw-bold">
                            <th class="ps-4">ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th class="text-center">Stock</th>
                            <th>Price</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    
                    @if($product->isEmpty())
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="60" class="mb-2 opacity-50">
                                    <p class="text-muted">Product not found</p>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @foreach ($product as $products)
                            <tr>
                                <td class="ps-4 fw-bold text-dark align-middle">#{{ $products->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($products->image)
                                            <img src="{{ asset('uploads/'.$products->image) }}" width="60px" height="60px" class="prod-img me-3">
                                        @else
                                            <img src="{{ asset('noimage/noimage.png') }}" width="60px" height="60px" class="prod-img me-3">
                                        @endif 
                                        <div>
                                            <div class="fw-bold text-dark">{{ $products->product_name }}</div>
                                            <div class="text-muted small" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $products->description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-light text-primary border ">{{ $products->category }}</span>
                                </td>
                                
                                <td class="text-muted align-middle">
                                    {{ $products->brand }}
                                </td>

                                <td class="text-center align-middle">
                                    <span class="fw-bold {{ $products->quantity < 5 ? 'text-danger' : 'text-dark' }}">
                                        {{ $products->quantity }}
                                    </span>
                                </td>
                                <td class="align-middle"><span class="fw-bold text-success">${{ number_format($products->price, 2) }}</span></td>
                               <td class="text-center align-middle">
                                    @if($products->status == '1' || $products->status == 'Available')
                                        <span class="status-active">Active</span>
                                    @else
                                        <span class="status-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 align-middle">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.editProduct', $products->id) }}" class="btn-action-circle btn-edit-prod" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('admin.deleteProduct', $products->id) }}" class="btn-action-circle btn-delete-prod btn-delete" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-3 border-top">
                {{ $product->links() }}
            </div>

        </div>
    </div>
</div>

@endsection