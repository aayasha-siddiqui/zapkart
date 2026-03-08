@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream py-12 px-4 sm:px-6 lg:px-8">

    <h1 class="text-3xl font-bold text-mitti-dark mb-2">My Orders</h1>
    <p class="text-sm text-mitti-dark/70 mb-8">
        View all your orders, check status, and track deliveries here.
    </p>

    @forelse($orders as $order)
    <div class="bg-white border border-mitti-light p-6 mb-8 shadow-md hover:shadow-lg transition">

        <!-- Order Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="space-y-1">
                <p class="text-mitti-dark text-sm">
                    Order <a href="#" class="text-mitti-primary font-semibold">#{{ $order->order_number }}</a>
                </p>
                 <p class="text-md font-semibold text-green-500 mt-4">
    📦 Tracking ID (AWB): 
    <span class="text-gray-900">{{ $order->awb }}</span>
</p>
                <p class="text-xs text-mitti-dark/60">Placed On: {{ $order->created_at->format('D, d M Y') }}</p>
                <p class="text-xs text-mitti-dark/60">
                    Payment Method: <span class="font-semibold">{{ strtoupper($order->payment_method) }}</span>
                </p>
                <p class="text-xs text-mitti-dark/60">
                    Payment Status: 
                    @if($order->payment_status == 'paid')
                        <span class="text-green-600 font-semibold">Paid</span>
                    @else
                        <span class="text-red-500 font-semibold">Pending</span>
                    @endif
                </p>
            </div>

            <a href="{{ route('track.direct', $order->awb) }}" class="mt-4 md:mt-0 bg-mitti-primary hover:bg-mitti-secondary text-white px-5 py-2 rounded-full font-semibold text-sm transition">
                TRACK ORDER
            </a>
        </div>

        <div class="border-b border-mitti-light my-4"></div>

        <!-- Order Items -->
        @foreach($order->items as $item)
        <div class="flex flex-col md:flex-row gap-4 mb-6 items-center bg-mitti-cream/50 p-3 rounded-md">
            
            <!-- Product Image -->
            <div class="flex-shrink-0 w-28 h-28 bg-white flex items-center justify-center overflow-hidden border border-mitti-light">
                <img src="{{ product_image_url($item->product->image ?? null) }}
" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
            </div>

            <!-- Product Details -->
            <div class="flex-1 flex flex-col justify-between">
                <h3 class="font-semibold text-mitti-dark hover:text-mitti-primary cursor-pointer">{{ $item->product->name }}</h3>
                <p class="text-mitti-dark/70 text-sm mt-1">By: {{ $item->product->brand ?? $item->product->category->name }}</p>

                <div class="flex gap-6 mt-2 text-sm text-mitti-dark/70">
                    <p>Size: {{ $item->size ?? '-' }}</p>
                    <p>Qty: {{ $item->quantity }}</p>
                </div>

                <p class="font-bold text-mitti-dark mt-2 text-base">
                    Rs. {{ number_format($item->price * $item->quantity) }}
                </p>
            </div>

            <!-- Status & Delivery -->
            <div class="text-right mt-3 md:mt-0 min-w-[140px]">
                <p class="text-sm font-semibold text-mitti-dark/70">Order Status</p>
                <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded {{ $order->status == 'delivered' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ ucfirst($order->status) }}
                </span>

                <p class="text-sm font-semibold text-mitti-dark/70 mt-2">Delivery Expected</p>
                <p class="font-bold text-mitti-dark">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d F Y') }}</p>
            </div>
        </div>
        @endforeach

        <!-- Cancel + Total -->
        <div class="flex flex-col md:flex-row justify-between items-center border-t border-mitti-light pt-4 mt-2 gap-3">
            @if($order->status == 'placed')
            <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                @csrf
                <button class="text-sm text-red-600 hover:text-red-700 font-semibold">
                    ✖ Cancel Order
                </button>
            </form>
            @else
                <span class="text-sm text-gray-400">Cannot cancel</span>
            @endif

            <p class="text-lg md:text-xl font-bold text-mitti-dark mt-2 md:mt-0">
                Total: Rs. {{ number_format($order->total) }}
            </p>
        </div>

    </div>
    @empty
    <p class="text-center text-mitti-dark/60 mt-10">You have no orders yet.</p>
    @endforelse

</div>
@endsection
