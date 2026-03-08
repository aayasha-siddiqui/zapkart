<div class="py-12 bg-mitti-cream">
    <div class="max-w-7xl mx-auto px-6 text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-mitti-dark mb-2">
            Shop by Categories
        </h2>
        <p class="text-mitti-dark/70 text-lg">
            Explore our handpicked categories and find your favorites.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($categories as $cat)
            <div class="group bg-white rounded-xl shadow-md overflow-hidden border border-mitti-light flex flex-col items-center transition hover:shadow-xl hover:scale-105 duration-300">
                
                <a href="{{ route('category.products', $cat->id) }}" class="w-full h-40 flex items-center justify-center overflow-hidden">
                     <img src="{{ category_image_url($cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110">
                 </a>

                <div class="p-4 flex flex-col items-center text-center">
                    <h3 class="text-mitti-dark font-semibold text-sm md:text-base mb-1 group-hover:text-mitti-primary transition">
                        {{ $cat->name }}
                    </h3>
                    <p class="text-gray-500 text-xs md:text-sm mb-3">
                        {{ $cat->tagline }}
                    </p>
                    <a href="{{ route('category.products', $cat->id) }}" 
   class="inline-block px-4 py-2 text-sm md:text-base font-medium text-mitti-primary border border-mitti-primary hover:bg-mitti-primary hover:text-white transition-colors duration-200 rounded">
   Shop Now
</a>

                </div>

            </div>
        @endforeach
    </div>
</div>
