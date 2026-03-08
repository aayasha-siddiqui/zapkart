@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 bg-mitti-cream">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-4xl font-extrabold text-mitti-dark tracking-wide">Explore Categories</h1>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('categories.create') }}" class="bg-mitti-primary hover:bg-mitti-dark text-white font-semibold px-6 py-2 rounded-xl shadow-md transition-all duration-300">
            + Add Category
        </a>
        @endif
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        @foreach($categories as $cat)
        <div class="relative group rounded-3xl overflow-hidden shadow-xl bg-white border border-mitti-primary/20 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">

            <!-- Image with overlay -->
            <div class="relative h-56 w-full overflow-hidden">
                <img src="{{ category_image_url($cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-mitti-dark/60 via-mitti-dark/10 to-transparent"></div>

                <!-- Category Title on Image -->
                <h3 class="absolute bottom-3 left-4 text-2xl font-extrabold text-white drop-shadow-lg tracking-wide">
                    {{ $cat->name }}
                </h3>
            </div>

            <!-- Card Content -->
            <div class="p-5">

                <p class="text-mitti-dark/70 mb-4 text-sm leading-relaxed">
                    {{ $cat->tagline ?? 'Fresh & high-quality products curated for you!' }}
                </p>

                <!-- Buttons -->
                @if(auth()->user()->role === 'admin')
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3">
                        <a href="{{ route('categories.edit', $cat->id) }}" class="flex-1 text-center bg-mitti-primary-outline border border-mitti-primary text-mitti-primary hover:bg-mitti-primary hover:text-white px-3 py-2 rounded-lg font-semibold transition-all duration-300">
                            Edit
                        </a>

                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full border border-mitti-primary text-mitti-primary hover:bg-mitti-primary py-2 hover:text-white  rounded-lg font-semibold transition-all duration-300">
                                Delete
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('category.products', $cat->id) }}" class="bg-mitti-primary hover:bg-mitti-dark text-white w-full px-5 py-2 rounded-lg shadow-md font-semibold text-center transition-all duration-300">
                        Explore
                    </a>
                </div>

                @else
                <a href="{{ route('category.products', $cat->id) }}" class="block bg-mitti-primary-outline border border-mitti-primary text-mitti-primary hover:bg-mitti-primary hover:text-white text-center px-5 py-2 rounded-lg shadow font-semibold transition-all duration-300">
                    Shop Now
                </a>
                @endif

            </div>

        </div>
        @endforeach
    </div>
    <!-- Pagination -->
<div class="mt-12 flex justify-center">
    {{ $categories->links() }}
</div>

    
</div>
@endsection
