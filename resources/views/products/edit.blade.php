@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white shadow-lg p-8 rounded-2xl">
    <h1 class="text-2xl font-bold mb-6 text-center">Edit Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $product->name }}" class="w-full border-gray-300 rounded-lg p-2 border" required>
        <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full border-gray-300 rounded-lg p-2 border" required>
        <textarea name="description" class="w-full border-gray-300 rounded-lg p-2 border">{{ $product->description }}</textarea>

        <select name="category_id" class="w-full border-gray-300 rounded-lg p-2 border" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <div>
    <label class="block text-sm font-medium">Quantity</label>
    <input type="number"
           name="qty"
           min="0"
           value="{{ old('qty', $product->qty ?? 0) }}"
           class="w-full border rounded px-3 py-2">
</div>


        <div>
    <label>Current Image:</label>

    @php
        $img = $product->image;
        $src = Str::startsWith($img, ['http', 'https'])
                ? $img
                : (Str::startsWith($img, 'products/')
                    ? asset('storage/' . $img)
                    : asset($img));
    @endphp

    <img src="{{ product_image_url($product->image) }}" class="h-24 w-24 object-cover rounded-lg mb-2">
</div>


        <input type="file" name="image" class="w-full">
        <button type="submit" class="bg-[#36C7A6] text-white px-4 py-2 rounded-lg hover:bg-[#2fa78c] w-full">Update Product</button>
    </form>
     <a href="{{ route('products.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">Back to Products</a>

</div>
@endsection
