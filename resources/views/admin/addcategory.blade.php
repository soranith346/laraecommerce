@extends('admin.maindesign')
@section('add_category')

<form action="{{ route('admin.storeCategory') }}" method="POST" class="container mt-4" enctype="multipart/form-data">
    @csrf
    @if(session('success'))
    @push('scripts')
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Add To Category !',
        text: "Category created successfully",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,

        width: '320px',
        padding: '12px',

        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
    });
    </script>
    @endpush
    @endif

    <style>
        /* Container and Card Style */
        .card.form-card {
            border-radius: 15px;
            border: none;
            overflow: hidden;
            background-color: #ffffff !important; /* Force Pure White Background */
        }

        /* Header Style matching View List */
        .card-header-custom {
            background-color: #102A53;
            color: white;
            padding: 20px;
            border: none;
        }

        /* Form Labels - Sharp Black */
        .form-label {
            font-weight: 700;
            color: #000000 !important; 
            margin-bottom: 8px;
        }

        /* Input Controls - White Background & Black Text */
        .form-control, .form-select {
            background-color: #ffffff !important;
            color: #000000 !important; /* User typed text is black */
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        /* Input Placeholder color */
        .form-control::placeholder {
            color: #6c757d !important;
        }

        .form-control:focus {
            border-color: #102A53;
            box-shadow: 0 0 0 0.2rem rgba(16, 42, 83, 0.1);
            color: #000000 !important;
        }

        /* Button Styles */
        .btn-save {
            background-color: #102A53;
            border: none;
            padding: 12px;
            font-weight: bold;
            border-radius: 8px;
            transition: 0.3s;
            color: white !important;
        }

        .btn-save:hover {
            background-color: #1a4b9e;
            transform: translateY(-2px);
        }

        .btn-view-list {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-view-list:hover {
            background-color: white;
            color: #102A53;
        }

        /* Input Icons */
        .input-group-text {
            background-color: #f8f9fa !important;
            color: #000000 !important;
            border: 1px solid #ced4da;
        }
    </style>

    <div class="card form-card shadow-lg">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-plus-circle-dotted me-2"></i>Add New Category</h4>
            <a href="{{ route('admin.viewcategory') }}" class="btn-view-list">
                <i class="bi bi-list-task me-1"></i> View All Categories
            </a>
        </div>

        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="category_name" 
                           class="form-control" 
                           placeholder="Enter category name" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Display Status</label>
                    <select name="status" class="form-select">
                        <option value="1">Show</option>
                        <option value="0">Hide</option>
                    </select>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter description..."></textarea>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Category Image</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-image"></i></span>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>

                <div class="col-12 text-end mt-2">
                    <hr class="text-muted opacity-25 mb-4">
                    <button type="submit" class="btn btn-primary btn-save px-5">
                        <i class="bi bi-check-circle me-1"></i> Save Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection