@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto mt-10 mb-10 bg-white shadow-xl rounded-xl border border-mitti-cream overflow-hidden">

    {{-- HEADER --}}
    <div class="p-6 border-b bg-mitti-cream">
        <h1 class="text-2xl font-bold text-mitti-dark">
            {{ $viewProduct['name'] }}
        </h1>

        <div class="flex items-center gap-2 mt-1">
            <span class="text-yellow-500 text-sm">★★★★☆</span>
            <span class="text-xs text-gray-500">(4.2 Ratings)</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

        {{-- IMAGE --}}
        <div class="bg-[#F5EFE6] rounded-lg border flex items-center justify-center h-[320px]">
            <img id="zoomImage"
                 src="{{ product_image_url($viewProduct['image']) }}"
                 class="max-h-full max-w-full object-contain transition-transform duration-300 cursor-zoom-in">
        </div>

        {{-- RIGHT SIDE --}}
        <div>

            {{-- PRICE --}}
            <p class="text-3xl font-bold text-[#36C7A6] mb-2">
                ₹{{ $viewProduct['price'] }}
            </p>

            <p class="text-sm text-gray-500 mb-4">
                Inclusive of all taxes
            </p>

            {{-- CATEGORY --}}
            <p class="text-sm mb-2">
                Category:
                <span class="font-semibold text-mitti-primary">
                    {{ $viewProduct['category'] }}
                </span>
            </p>

            {{-- SUPPLIER --}}
            <p class="text-sm mb-4">
    Sold by:
    @if($viewProduct['supplier_id'])
        <a href="{{ route('supplier.products', $viewProduct['supplier_id']) }}"
           class="font-semibold text-mitti-primary hover:underline">
            {{ $viewProduct['supplier_name'] }}
        </a>

    @elseif($viewProduct['seller_id'])
        <span class="font-semibold text-mitti-primary">
            {{ $viewProduct['seller_name'] }}
        </span>

    @else
        <span class="font-semibold">
            Zapkart Official
        </span>
    @endif
</p>


            {{-- DESCRIPTION --}}
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                {{ $viewProduct['description'] }}
            </p>

            {{-- USER ACTIONS --}}
            @if(auth()->check() && auth()->user()->role === 'user')
                <div class="flex gap-3 mb-6">

                    <form method="POST" action="{{ route('cart.add', $viewProduct['raw_id']) }}">
                        @csrf
                        <button class="px-6 py-3 bg-mitti-primary text-white rounded-lg font-semibold hover:bg-mitti-secondary transition">
                            Add to Cart
                        </button>
                    </form>

                    <form method="POST" action="{{ route('buy-now', $viewProduct['raw_id']) }}">
                        @csrf
                        <button class="px-6 py-3 border border-mitti-primary text-mitti-primary rounded-lg font-semibold hover:bg-mitti-primary hover:text-white transition">
                            Buy Now
                        </button>
                    </form>

                </div>
            @endif

            {{-- 🔥 ADMIN ACTIONS (FIXED) --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="flex gap-3 pt-4 border-t">

                    <a href="{{ route('products.edit', $viewProduct['raw_id']) }}"
                       class="flex-1 bg-mitti-dark text-white py-2.5 rounded-lg text-center font-semibold hover:bg-black transition">
                        Edit Product
                    </a>

                    <form method="POST" action="{{ route('products.destroy', $viewProduct['raw_id']) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button class="w-full border border-red-500 text-red-500 py-2.5 rounded-lg font-semibold hover:bg-red-500 hover:text-white transition">
                            Delete Product
                        </button>
                    </form>

                </div>
            @endif

        </div>
    </div>

    {{-- FOOTER --}}
    <div class="p-4 bg-mitti-cream text-center">
        <a href="{{ route('products.index') }}"
           class="text-sm text-gray-600 hover:underline">
            ← Back to Products
        </a>
    </div>

</div>

@endsection
