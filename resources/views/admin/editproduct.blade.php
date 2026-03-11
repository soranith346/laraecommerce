@extends('admin.maindesign')
@section('editproduct')

<form action="{{ route('admin.updateProduct' , $product->id ) }}" method="POST" class="container mt-4" enctype="multipart/form-data">
    @csrf

    <div class="card shadow p-4">
        <h4 class="mb-4 text-primary">បន្ថែមផលិតផលថ្មី</h4>

        <!-- Product Name -->
        <div class="mb-3">
            <label class="form-label">ឈ្មោះផលិតផល</label>
            <input type="text" name="product_name" class="form-control" placeholder="បញ្ចូលឈ្មោះផលិតផល" value="{{$product->product_name}}" required>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label class="form-label">ប្រភេទផលិតផល</label>
            <select name="category" class="form-control" required>
                <option value="">-- ជ្រើសរើសប្រភេទ --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category }}"
                        {{ $product->category == $category->category ? 'selected' : '' }}>
                        {{ $category->category }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">ការពិពណ៌នា</label>
            <textarea name="description" class="form-control" rows="4" placeholder="បញ្ចូលការពិពណ៌នា"> {{ $product->description }}</textarea>
        </div>

        <!-- Quantity -->
        <div class="mb-3">
            <label class="form-label">ចំនួនស្តុក</label>
            <input type="number" name="quantity" class="form-control" value="{{$product->quantity}}" placeholder="បញ្ចូលចំនួនស្តុក" required>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label class="form-label">តម្លៃ ($)</label>
            <input type="number" step="0.01" name="price" value="{{$product->price}}" class="form-control" placeholder="បញ្ចូលតម្លៃផលិតផល" required>
        </div>

        <!-- Brand -->
        <div class="mb-3">
            <label class="form-label">ម៉ាក</label>
            <input type="text" name="brand" value="{{$product->brand}}" class="form-control" placeholder="បញ្ចូលម៉ាកផលិតផល (optional)">
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label class="form-label">រូបភាពផលិតផល</label>
            <img src="{{ asset('uploads/' . $product->image) }}" width="120" class="mb-2">
            <input type="file" name="image" class="form-control">
        </div>
        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">ស្ថានភាព</label>
            <select name="status" class="form-control">
                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>
                    បង្ហាញ
                </option>
                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>
                    មិនបង្ហាញ
                </option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">រក្សាទុក</button>
        </div>

    </div>
</form>
@endsection