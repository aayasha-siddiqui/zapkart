@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-3xl bg-white p-10 rounded-3xl shadow-xl">
        <h1 class="text-3xl font-bold text-mitti-dark mb-8 text-center">Edit Category</h1>

        <form action="{{ route('categories.update', $category->id) }}" 
              method="POST" enctype="multipart/form-data" 
              class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-mitti-dark font-semibold mb-2">Category Name</label>
                <input type="text" name="name" value="{{ $category->name }}" 
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-mitti-primary focus:outline-none"
                       required>
            </div>

            {{-- Tagline --}}
            <div>
                <label class="block text-mitti-dark font-semibold mb-2">Tagline</label>
                <input type="text" name="tagline" value="{{ $category->tagline }}" 
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-mitti-primary focus:outline-none">
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-mitti-dark font-semibold mb-2">Image</label>
                <input type="file" name="image" 
                       class="w-full border border-gray-300 rounded-xl px-3 py-2 text-gray-700">
            </div>

            {{-- Existing Image --}}
            @if($category->image)
            <div class="flex justify-center">
                <img src="{{ asset('images/' . $category->image) }}" 
                     class="w-32 h-32 object-cover rounded-xl border border-gray-200">
            </div>
            @endif

            {{-- Submit --}}
            <div class="text-center">
                <button type="submit" 
                        class="bg-mitti-primary hover:bg-mitti-dark text-white font-semibold px-8 py-3 rounded-2xl shadow-md hover:shadow-lg transition">
                    Update Category
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
