@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream p-6 space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-mitti-dark">
            Seller Profile
        </h1>
        <p class="text-sm text-gray-500">
            {{ $seller->name }} ({{ $seller->email }})
        </p>
    </div>

    {{-- SELLER INFO --}}
    <div class="bg-white p-6 rounded-xl shadow grid md:grid-cols-3 gap-4">
        <div>
            <p class="text-xs text-gray-500">Business Name</p>
            <p class="font-semibold">{{ $sellerRequest->business_name ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">GST</p>
            <p class="font-semibold">{{ $sellerRequest->gst ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Joined</p>
            <p class="font-semibold">{{ $seller->created_at->format('d M Y') }}</p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Products</p>
            <p class="text-2xl font-bold text-mitti-primary">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Orders</p>
            <p class="text-2xl font-bold text-mitti-primary">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Delivered</p>
            <p class="text-2xl font-bold text-green-600">{{ $deliveredOrders }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Cancelled</p>
            <p class="text-2xl font-bold text-red-500">{{ $cancelledOrders }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Seller Earnings</p>
            <p class="text-2xl font-bold text-green-700">
                ₹{{ number_format($sellerEarning,2) }}
            </p>
        </div>
    </div>

    {{-- COMMISSION --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-3 text-mitti-dark">Commission Summary</h3>
        <p>Total Revenue: <strong>₹{{ number_format($totalRevenue,2) }}</strong></p>
        <p>Admin Commission: <strong class="text-red-500">₹{{ number_format($adminCommission,2) }}</strong></p>
        <p>Seller Payout: <strong class="text-green-600">₹{{ number_format($sellerEarning,2) }}</strong></p>
    </div>

    {{-- SELLER PRODUCTS --}}
    <div>
        <h3 class="text-xl font-semibold mb-3 text-mitti-dark">
            Seller Products
        </h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($products as $product)
                <div class="bg-white p-4 rounded shadow">
                    <p class="font-semibold">{{ $product->name }}</p>
                    <p class="text-xs text-gray-500">{{ $product->category->name ?? '' }}</p>
                    <p class="text-sm">₹{{ $product->price }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- SELLER ORDERS --}}
    <div>
        <h3 class="text-xl font-semibold mb-3 text-mitti-dark">
            Orders for Seller Products
        </h3>

        @foreach($orderItems as $item)
            <div class="bg-white p-4 rounded-xl shadow mb-2 flex justify-between">
                <div>
                    <p class="font-semibold">
                        Order #{{ $item->order->order_number }}
                    </p>
                    <p class="text-xs text-gray-500">
                        ₹{{ $item->total }} · {{ ucfirst($item->status) }}
                    </p>
                </div>
                <span class="text-xs text-gray-400">
                    {{ $item->order->created_at->format('d M Y') }}
                </span>
            </div>
        @endforeach
    </div>

</div>
@endsection
