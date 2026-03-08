@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 bg-mitti-cream">

    <h1 class="text-3xl font-bold text-mitti-dark mb-6">❤️ Your Wishlist</h1>

    @if(count($wishlist) == 0)
        <div class="text-center py-20">
            <p class="text-xl text-mitti-dark/60 mb-4">Your wishlist is empty.</p>
            <a href="/shop" class="px-6 py-2 bg-mitti-primary text-white font-semibold transition hover:bg-mitti-secondary">
                Start Shopping
            </a>
        </div>
    @else

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($wishlist as $item)
        <div class="border border-mitti-light bg-white p-4 flex flex-col">

            <!-- Product Image -->
            <div class="w-full h-48 bg-mitti-cream flex items-center justify-center border border-mitti-light overflow-hidden">
                <img src="{{ product_image_url($item->product->image ?? null) }}
" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
            </div>

            <!-- Product Name & Price -->
            <h2 class="text-lg font-semibold text-mitti-dark mt-3">{{ $item->product->name }}</h2>
            <p class="text-mitti-dark font-bold mt-1">₹{{ $item->product->price }}</p>

            <!-- Action Buttons: Add to Cart + Remove -->
            <div class="mt-4 flex gap-2">

                <!-- Add to Cart (Filled) -->
                <form method="POST" action="{{ route('cart.add', $item->product->id) }}" class="flex-1">
                    @csrf
                    <button type="submit" 
                        class="w-full bg-mitti-primary hover:bg-mitti-secondary text-white py-2 font-semibold text-sm transition">
                        Add to Cart
                    </button>
                </form>

                <!-- Remove (Outlined) -->
                <a href="{{ route('wishlist.remove', $item['id']) }}" 
                   class="flex-1 w-full text-center border border-mitti-primary text-mitti-primary hover:bg-mitti-primary hover:text-white py-2 font-semibold text-sm transition">
                    Remove
                </a>

            </div>

        </div>
        @endforeach

    </div>

    @endif

</div>
@endsection
