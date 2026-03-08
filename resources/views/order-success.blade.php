@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream py-12 px-4 sm:px-6 lg:px-8">

    @php
        $isPaid = $order->payment_status == 'paid';
        $canCancel = !in_array($order->status, ['delivered', 'cancelled']);
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="text-center">
            @if($isPaid)
            <h1 class="text-3xl font-bold text-green-600 mb-1">🎉 Payment Successful!</h1>
            <p class="text-gray-800 text-sm">Your order <strong>#{{ $order->order_number }}</strong> has been confirmed.</p>
            @else
            <h1 class="text-3xl font-bold text-blue-600 mb-1">✅ Order Placed!</h1>
            <p class="text-gray-800 text-sm">Your order <strong>#{{ $order->order_number }}</strong> is confirmed. Pay on delivery.</p>
            @endif
            <p class="text-lg font-semibold text-green-700 mt-4">
    📦 Tracking ID (AWB): 
    <span class="text-gray-900">{{ $order->awb }}</span>
</p>

        </div>

        {{-- Products List --}}
        <div class="bg-white border border-gray-300 overflow-hidden divide-y divide-gray-200">
            @foreach($order->items as $item)
            <div class="flex items-center p-3 gap-4">
                {{-- Image --}}
                <div class="w-20 h-20 flex-shrink-0 bg-gray-100 flex items-center justify-center">
                    <img src="{{ product_image_url($item->product->image ?? null) }}
" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                </div>

                {{-- Info --}}
                <div class="flex-1 flex flex-col justify-between">
                    <h3 class="font-semibold text-gray-900 hover:text-mitti-primary cursor-pointer">{{ $item->product->name }}</h3>
                    <p class="text-xs text-gray-600">Category: {{ $item->product->category->name }}</p>
                    <p class="text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                </div>

                {{-- Price --}}
                <div class="text-gray-900 font-semibold text-sm">
                    ₹{{ number_format($item->price * $item->quantity) }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <div class="bg-white border border-gray-300 p-4 flex justify-between text-gray-700 text-sm">
            <div class="space-y-1 w-full">
                <div class="flex justify-between"><span>Subtotal</span> <span>₹{{ number_format($order->subtotal) }}</span></div>
              <div class="flex justify-between"><span>Delivery</span> <span>₹{{ number_format($order->delivery_charges) }}</span></div>
  <div class="flex justify-between font-semibold text-gray-900 mt-1 text-sm"><span>Total</span> <span>₹{{ number_format($order->total) }}</span></div>
            </div>
        </div>

        {{-- Order Details --}}
        <div class="bg-white border border-gray-300 p-4 text-sm text-gray-700 space-y-1">
            <div class="flex justify-between"><span class="font-semibold">Order #</span> <span>{{ $order->order_number }}</span></div>
            <div class="flex justify-between"><span class="font-semibold">Placed On</span> <span>{{ $order->created_at->format('D, d M Y') }}</span></div>
            <div class="flex justify-between"><span class="font-semibold">Payment</span> <span>{{ strtoupper($order->payment_method) }}</span></div>
            <div class="flex justify-between"><span class="font-semibold">Payment Status</span>
                <span class="{{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($order->payment_status) }}</span>
            </div>
            <div class="flex justify-between"><span class="font-semibold">Delivery Date</span> <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}</span></div>
            <div class="flex justify-between"><span class="font-semibold">Status</span> <span>{{ ucfirst($order->status) }}</span></div>
            <div><span class="font-semibold">Address:</span> {{ $order->address }}</div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col md:flex-row gap-3">
            <a href="{{ route('track.direct', $order->awb) }}" class="flex-1 bg-mitti-primary hover:bg-mitti-secondary text-white py-2 text-center font-semibold transition">
                📦 Track Order
            </a>
            @if($canCancel)
            <form method="POST" action="{{ route('order.cancel', $order->id) }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 font-semibold transition">
                    ❌ Cancel Order
                </button>
            </form>
            @endif
        </div>
    </div>

</div>

{{-- Confetti --}}
@if($isPaid)
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    const myConfetti = confetti.create(document.createElement('canvas'), { resize: true, useWorker: true });
    myConfetti({ particleCount: 150, spread: 70, origin: { y: 0.6 } });
</script>
@endif
@endsection
