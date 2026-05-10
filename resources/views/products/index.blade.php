@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-6 bg-mitti-cream">

    {{-- ================= HEADER ================= --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-mitti-dark">
            All Products
        </h1>

        {{-- ADMIN ADD PRODUCT --}}
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}"
               class="bg-mitti-primary text-white px-5 py-2 rounded-full font-semibold hover:bg-mitti-secondary">
                + Add Product
            </a>
        @endif
    </div>

    {{-- ================= PRODUCTS GRID ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @foreach($products as $product)

        @php
            // 🔒 STOCK LOGIC (ONE SOURCE OF TRUTH)
            if(auth()->check() && auth()->user()->role === 'shopkeeper') {
                $stock = DB::table('shopkeeper_products')
                    ->where('shopkeeper_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->value('qty') ?? 0;
            } else {
                $stock = $product->qty ?? 0;
            }
        @endphp

        <div class="bg-white shadow-md hover:shadow-xl transition p-4 relative flex flex-col rounded-xl">

            {{-- DISCOUNT BADGE --}}
            <div class="absolute top-3 left-3 bg-mitti-primary text-white text-xs font-bold px-3 py-1 rounded-full z-10">
                25% OFF
            </div>

            {{-- OUT OF STOCK BADGE --}}
            @if($stock <= 0)
                <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full z-10">
                    OUT OF STOCK
                </div>
            @endif

            {{-- IMAGE --}}
            <a href="{{ route('products.show', $product->id) }}">
                <div class="w-full aspect-square bg-mitti-cream rounded-2xl overflow-hidden flex items-center justify-center">
                    <img src="{{ product_image_url($product->image) }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                         alt="{{ $product->name }}">
                </div>
            </a>

            {{-- NAME + WISHLIST --}}
            <div class="flex justify-between items-start mt-3">
                <a href="{{ route('products.show', $product->id) }}">
                    <h3 class="text-lg font-semibold text-mitti-dark hover:text-mitti-primary">
                        {{ $product->name }}
                    </h3>
                </a>

                {{-- WISHLIST (ONLY USER + SHOPKEEPER) --}}
                @if(auth()->check() && in_array(auth()->user()->role, ['user','shopkeeper']))
                    <a href="{{ route('wishlist.add', $product->id) }}"
                       class="text-mitti-primary hover:text-red-500 text-xl">
                        ♥
                    </a>
                @endif
            </div>

            {{-- PRICE --}}
            <div class="mt-2">
                <div class="flex items-center gap-2">
                    <span class="text-lg font-bold text-mitti-dark">
                        ₹{{ number_format($product->price,2) }}
                    </span>
                    <span class="text-sm line-through text-mitti-dark/50">
                        ₹{{ number_format($product->price + 100,2) }}
                    </span>
                </div>

                {{-- STOCK TEXT --}}
                <p class="text-xs mt-1">
                    @if($stock > 5)
                        <span class="text-green-600 font-semibold">In Stock</span>
                    @elseif($stock > 0)
                        <span class="text-yellow-600 font-semibold">
                            Only {{ $stock }} left
                        </span>
                    @else
                        <span class="text-red-600 font-semibold">
                            Out of Stock
                        </span>
                    @endif
                </p>
            </div>

            {{-- CATEGORY --}}
            <p class="text-xs text-mitti-dark/70 mt-1">
                Category:
                <span class="font-medium text-mitti-primary">
                    {{ $product->category->name ?? 'N/A' }}
                </span>
            </p>

            {{-- ================= ACTION BUTTONS ================= --}}
            @if(auth()->check() && in_array(auth()->user()->role, ['user',
                'seller',
                'supplier',
                'driver',
                'shopkeeper']))
                <div class="mt-4 flex gap-2">

                    @if($stock > 0)
                        {{-- ADD TO CART --}}
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full bg-mitti-primary hover:bg-mitti-secondary text-white py-2 font-semibold text-sm rounded">
                                Add to Cart
                            </button>
                        </form>

                        {{-- BUY NOW --}}
                        <form method="POST" action="{{ route('buy-now', $product->id) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full border border-mitti-primary text-mitti-primary hover:bg-mitti-primary hover:text-white py-2 font-semibold text-sm rounded">
                                Buy Now
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="w-full bg-gray-300 text-gray-600 py-2 font-semibold text-sm rounded cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif

                </div>
            @endif

            {{-- ================= ADMIN / SUPPLIER CONTROLS ================= --}}
            @if(auth()->check() && in_array(auth()->user()->role, ['admin','supplier']))
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('products.edit', $product->id) }}"
                       class="flex-1 bg-mitti-primary hover:bg-mitti-secondary text-white py-2 text-center rounded font-semibold text-sm">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full border border-mitti-primary text-mitti-primary hover:bg-mitti-primary hover:text-white py-2 rounded font-semibold text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            @endif

        </div>
        @endforeach

    </div>
</div>

@endsection
