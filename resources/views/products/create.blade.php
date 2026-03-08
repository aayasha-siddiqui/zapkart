@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6 bg-mitti-cream min-h-screen">

    <h1 class="text-3xl font-bold text-mitti-dark mb-8 text-center">Add New Product</h1>

    <div class="bg-white p-8 shadow-lg rounded-2xl">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @csrf

            {{-- Product Name --}}
            <div class="col-span-1">
                <label class="text-mitti-dark font-semibold mb-1 block">Product Name</label>
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Enter product name" 
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-mitti-primary focus:outline-none"
                    required
                >
            </div>
            

            {{-- Price --}}
            <div class="col-span-1">
                <label class="text-mitti-dark font-semibold mb-1 block">Price (₹)</label>
                <input 
                    type="number" 
                    step="0.01" 
                    name="price" 
                    placeholder="Enter price" 
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-mitti-primary focus:outline-none"
                    required
                >
            </div>

            {{-- Category --}}
            <div class="col-span-1">
                <label class="text-mitti-dark font-semibold mb-1 block">Category</label>
                <select 
                    name="category_id" 
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-mitti-primary focus:outline-none"
                    required
                >
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
    <label class="block text-sm font-medium">Quantity</label>
    <input type="number"
           name="qty"
           min="0"
           value="{{ old('qty', $product->qty ?? 0) }}"
           class="w-full border rounded px-3 py-2">
</div>


            {{-- Image Upload --}}
            <div class="col-span-1">
                <label class="text-mitti-dark font-semibold mb-1 block">Product Image</label>
                <input type="file" name="image" class="w-full text-gray-700">
            </div>

            {{-- Description --}}
            <div class="col-span-1 lg:col-span-2">
                <label class="text-mitti-dark font-semibold mb-1 block">Description</label>
                <textarea 
                    name="description" 
                    placeholder="Enter product description" 
                    rows="4" 
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-mitti-primary focus:outline-none resize-none"
                ></textarea>
            </div>

            {{-- Submit Button --}}
            <div class="col-span-1 lg:col-span-2 text-center">
                <button 
                    type="submit" 
                    class="bg-mitti-primary hover:bg-mitti-dark text-white font-semibold px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition"
                >
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
