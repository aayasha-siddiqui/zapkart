@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-6 bg-mitti-cream">

    <h1 class="text-3xl font-bold mb-8 text-center text-mitti-dark">
        🛒 Your Shopping Cart
    </h1>

    @if($carts->count() > 0)
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ================= LEFT: CART ITEMS ================= --}}
        <div class="flex-1 space-y-6">

            @foreach($carts as $item)

            @php
                // ✅ CORRECT STOCK SOURCE
                if(auth()->user()->role === 'shopkeeper') {
                    $stock = DB::table('shopkeeper_products')
                        ->where('shopkeeper_id', auth()->id())
                        ->where('product_id', $item->product_id)
                        ->value('qty') ?? 0;
                } else {
                    // user → warehouse stock
                    $stock = $item->product->qty ?? 0;
                }
            @endphp

            <div class="relative flex items-center bg-white border border-mitti-light p-4 shadow-sm hover:shadow-md transition">

                {{-- REMOVE --}}
                <form method="POST" action="{{ route('cart.remove', $item->id) }}"
                      class="absolute top-2 right-2">
                    @csrf
                    <button class="text-mitti-dark hover:text-red-600 text-lg font-bold">
                        ×
                    </button>
                </form>

                {{-- IMAGE --}}
                <div class="flex-shrink-0 w-32 h-28 bg-mitti-cream flex items-center justify-center border border-mitti-light overflow-hidden">
                    <img src="{{ product_image_url($item->product->image) }}"
                         class="object-contain w-full h-full hover:scale-105 transition"
                         alt="{{ $item->product->name }}">
                </div>

                {{-- DETAILS --}}
                <div class="flex-1 ml-4 flex flex-col justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-mitti-dark">
                            {{ $item->product->name }}
                        </h3>

                        <p class="text-sm text-mitti-dark/70 mt-1">
                            Category:
                            <span class="text-mitti-primary font-medium">
                                {{ $item->product->category->name }}
                            </span>
                        </p>

                        {{-- STOCK TEXT --}}
                        @if($stock > 0)
                            <p class="text-xs text-green-600 font-semibold mt-1">
                                In Stock ({{ $stock }})
                            </p>
                        @else
                            <p class="text-xs text-red-600 font-semibold mt-1">
                                Out of Stock
                            </p>
                        @endif
                    </div>

                    {{-- QTY + PRICE --}}
                    <div class="mt-3 flex items-center justify-between flex-wrap gap-4">

                        {{-- QTY CONTROLS --}}
                        <div class="flex items-center gap-2">

                            {{-- DECREASE --}}
                            <form method="POST" action="{{ route('cart.decrease', $item->id) }}">
                                @csrf
                                <button class="px-3 py-1 bg-mitti-light hover:bg-mitti-secondary hover:text-white">
                                    −
                                </button>
                            </form>

                            <span class="px-4 py-1 border">
                                {{ $item->quantity }}
                            </span>

                            {{-- INCREASE --}}
                            @if($stock > $item->quantity)
                                <form method="POST" action="{{ route('cart.increase', $item->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-mitti-light hover:bg-mitti-secondary hover:text-white">
                                        +
                                    </button>
                                </form>
                            @else
                                <button disabled
                                    class="px-3 py-1 bg-gray-300 text-gray-500 cursor-not-allowed">
                                    +
                                </button>
                            @endif

                        </div>

                        {{-- PRICE --}}
                        <div class="text-right">
                            <p class="text-sm line-through text-mitti-dark/50">
                                ₹{{ ($item->product->price + 100) * $item->quantity }}
                            </p>
                            <p class="text-xl font-bold text-mitti-dark">
                                ₹{{ $item->product->price * $item->quantity }}
                            </p>
                            <span class="text-mitti-primary text-sm font-semibold">
                                25% off
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ================= RIGHT: SUMMARY ================= --}}
        <div class="w-full lg:w-96 bg-white border border-mitti-light p-6 shadow h-fit">

            <h2 class="text-xl font-bold mb-4 text-mitti-dark">
                Order Summary
            </h2>

            @foreach($carts as $item)
                <div class="flex justify-between py-2 border-b">
                    <p>{{ $item->product->name }} × {{ $item->quantity }}</p>
                    <p class="font-semibold">
                        ₹{{ $item->product->price * $item->quantity }}
                    </p>
                </div>
            @endforeach

            {{-- TOTAL --}}
            <div class="flex justify-between mt-4 pt-4 border-t">
                <p class="font-semibold">Total</p>
                <p class="text-lg font-bold">
                    ₹{{ number_format(
                        $carts->sum(fn($i) => $i->product->price * $i->quantity),
                        2
                    ) }}
                </p>
            </div>

            {{-- CHECKOUT --}}
            @if($carts->every(fn($i) =>
                (auth()->user()->role === 'shopkeeper'
                    ? DB::table('shopkeeper_products')
                        ->where('shopkeeper_id', auth()->id())
                        ->where('product_id', $i->product_id)
                        ->value('qty')
                    : $i->product->qty
                ) >= $i->quantity
            ))
                <a href="{{ route('checkout') }}"
                   class="mt-6 block bg-mitti-primary hover:bg-mitti-secondary text-white py-3 rounded text-center">
                    Proceed to Checkout
                </a>
            @else
                <button disabled
                    class="mt-6 w-full bg-gray-400 text-white py-3 rounded cursor-not-allowed">
                    Stock issue — cannot checkout
                </button>
            @endif

            <a href="{{ route('dashboard') }}"
               class="mt-4 block text-center text-mitti-dark hover:text-mitti-primary">
                ← Continue Shopping
            </a>

        </div>
    </div>

    @else
        {{-- EMPTY CART --}}
        <div class="text-center py-20">
            <p class="text-lg text-mitti-dark/70 mb-4">
                Your cart is empty 😔
            </p>
            <a href="{{ route('dashboard') }}"
               class="bg-mitti-primary hover:bg-mitti-secondary text-white px-6 py-2 rounded">
                Continue Shopping
            </a>
        </div>
    @endif

</div>
@endsection
