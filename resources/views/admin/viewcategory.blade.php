@extends('admin.maindesign')
@section('viewcategory')

{{-- Success Alerts --}}
@if(session('delete_success') || session('update_success'))
@push('scripts')
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Success!',
        text: "{{ session('delete_success') ?? session('update_success') }}",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        width: '320px',
    });
</script>
@endpush
@endif

<style>
    /* Header Blue - Matching Product List Image */
    .header-custom {
        background-color: #3b71ca !important; 
        border-radius: 4px 4px 0 0;
        border: none;
    }

    /* Table Header Styling */
    .table thead th {
        border-bottom: 1px solid #dee2e6;
        padding: 15px 10px;
    }

    /* Action Buttons (Square Outline style) */
    .btn-action-outline {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #f8d7da; 
        border-radius: 4px;
        transition: 0.2s;
        text-decoration: none;
    }

    .btn-action-outline:hover {
        background-color: #dc3545;
        color: #fff !important;
    }

    /* Search Button */
    .btn-search-custom {
        background-color: #102A53;
        color: white;
        border-radius: 0 4px 4px 0;
        padding: 0 20px;
        font-weight: 600;
    }

    /* Status Badges */
    .status-active {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-inactive {
        background-color: #f8d7da;
        color: #842029;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
    }
</style>

<div class="container-fluid mt-4">
    <div class="card shadow-lg border-0">
        
        {{-- Blue Header --}}
        <div class="card-header header-custom p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white"><i class="bi bi-tag-fill me-2"></i> Category Management List</h5>
                <span class="badge bg-white text-dark py-1 px-2">Total: {{ $category->total() }}</span>
            </div>
        </div>
        
        {{-- Card Body with Navy Background --}}
        <div class="card-body p-3" style="background-color: #112A53">

            {{-- Search Bar + Add Button Row (Floating White Box) --}}
            <div class="p-3 d-flex justify-content-between align-items-center bg-white shadow-sm mb-3" style="border-radius: 8px;">
                <form action="{{ route('admin.searchCategory') }}" method="GET" class="d-flex">
                    <div class="input-group" style="width: 350px; border: 1px solid #ced4da; border-radius: 4px; overflow: hidden;">
                        <input type="text" name="search" class="form-control border-0" placeholder="Search category..." value="{{ request('search') }}">
                        <button class="btn btn-search-custom" type="submit">Search</button>
                    </div>
                </form>

                <a href="{{ route('admin.addcategory') }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold shadow-sm" style="background-color: #3b71ca; border: none; border-radius: 5px;">
                    <i class="bi bi-plus-circle-fill me-1"></i> Add Category
                </a>
            </div>

            {{-- Category Table (White Box) --}}
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table align-middle mb-0 table-hover">
                    <thead>
                        <tr class="text-secondary text-uppercase small fw-bold"> 
                            <th class="ps-4">ID</th>
                            <th>Category Details</th>
                            <th>Description</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($category as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-dark align-middle">#{{ $item->id }}</td>

                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    {{-- Image Logic --}}
                                    @if($item->image)
                                        <img src="{{ asset('uploads/'.$item->image) }}"
                                             width="48" height="48"
                                             class="rounded border me-3 object-fit-cover shadow-sm">
                                    @else
                                        <img src="{{asset('noimage/noimage.png')}}" width="48" height="48" class="rounded border me-3 shadow-sm">
                                    @endif
                                    
                                    {{-- Name & Sub-ID --}}
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $item->category }}</div>
                                        <small class="text-muted">Ref: CAT-{{ $item->id }}</small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-muted small align-middle">
                                {{ Str::limit($item->description, 60) }}
                            </td>

                            <td class="text-center align-middle">
                                @if($item->status == '1')
                                    <span class="status-active">Active</span>
                                @else
                                    <span class="status-inactive">Inactive</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.editCategory', $item->id) }}"
                                       class="btn-action-outline edit bg-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="{{ route('admin.deleteCategory', $item->id) }}"
                                       class="btn-action-outline delete btn-delete bg-danger text-white" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 bg-white">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="60" class="mb-2 opacity-50">
                                <p class="text-muted">Product not found</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            <div class="mt-3 px-2">
                {{ $category->links() }}
            </div>

        </div>
    </div>
</div>

@endsection