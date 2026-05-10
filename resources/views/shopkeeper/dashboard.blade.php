@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream px-6 py-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-mitti-dark">
            Welcome, {{ auth()->user()->name }} 👋
        </h1>

        {{-- ALERT --}}
        @if($newAssignedCount > 0)
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold animate-pulse">
                🔔 {{ $newAssignedCount }} New Products Assigned
            </div>
        @endif
    </div>
    {{-- FILTER BAR --}}
<form method="GET" class="bg-white p-4 rounded-xl shadow flex flex-wrap gap-4 items-end">

    {{-- SEARCH --}}
    <div class="flex-1">
        <label class="text-xs text-gray-500">Search Product</label>
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Product name..."
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    {{-- CATEGORY --}}
    <div>
        <label class="text-xs text-gray-500">Category</label>
        <select name="category" class="border rounded px-3 py-2 text-sm">
            <option value="">All</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- MONTH --}}
    <div>
        <label class="text-xs text-gray-500">Month</label>
        <select name="month" class="border rounded px-3 py-2 text-sm">
            <option value="">All</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}"
                    {{ request('month') == $m ? 'selected' : '' }}>
                    {{ date('F', mktime(0,0,0,$m,1)) }}
                </option>
            @endfor
        </select>
    </div>

    {{-- BUTTONS --}}
    <div class="flex gap-2">
        <button class="bg-mitti-primary text-white px-4 py-2 rounded text-sm">
            Apply
        </button>

        <a href="{{ route('shopkeeper.dashboard') }}"
           class="border border-mitti-primary text-mitti-primary px-4 py-2 rounded text-sm">
            Reset
        </a>
    </div>

</form>


    {{-- TOP STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Total Orders</p>
            <p class="text-2xl font-bold text-mitti-primary">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Assigned Products</p>
            <p class="text-2xl font-bold text-mitti-primary">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Pending Orders</p>
            <p class="text-2xl font-bold text-red-500">{{ $pendingOrders }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Total Purchase</p>
            <p class="text-2xl font-bold text-green-600">₹{{ number_format($totalPurchase) }}</p>
        </div>

    </div>

    {{-- SMALL ANALYTICS --}}
    <div class="grid grid-cols-3 md:grid-cols-4 gap-6">

        {{-- MINI CHART --}}
        <div class="bg-white p-4 rounded-xl shadow">
            <h3 class="text-sm font-semibold text-mitti-dark mb-2">
                Monthly Orders
            </h3>
            <canvas id="orderMiniChart" height="120"></canvas>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="bg-white p-4 rounded-xl shadow space-y-3">
            <h3 class="text-sm font-semibold text-mitti-dark">
                Quick Actions
            </h3>

            <a href="{{ route('products.index') }}"
               class="block bg-mitti-primary text-white text-center py-2 rounded text-sm">
                🛒 View All Products
            </a>

            <a href="{{ route('orders') }}"
               class="block border border-mitti-primary text-mitti-primary text-center py-2 rounded text-sm">
                📦 My Orders
            </a>
        </div>

    </div>

    {{-- NEW ASSIGNED PRODUCTS --}}
    <div>
        <h3 class="text-lg font-semibold text-mitti-dark mb-3">
            Newly Assigned Products
        </h3>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @forelse($newAssignedProducts as $product)
                <div class="bg-white p-3 rounded-xl shadow relative border-2 border-red-400">
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                        NEW
                    </span>

                    <p class="font-semibold text-sm">{{ $product->name }}</p>
                    <p class="text-xs text-gray-500">
                        ₹{{ $product->price }}
                    </p>

                    <a href="{{ route('products.show', $product->id) }}"
                       class="text-xs text-mitti-primary mt-2 inline-block">
                        View →
                    </a>
                </div>
            @empty
                <p class="text-gray-500 text-sm">
                    No new products assigned.
                </p>
            @endforelse
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div>
        <h3 class="text-lg font-semibold text-mitti-dark mb-3">
            Recent Orders
        </h3>

        @forelse($recentOrders as $order)
            <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center mb-2">
                <div>
                    <p class="font-semibold text-sm">
                        #{{ $order->order_number }}
                    </p>
                    <p class="text-xs text-gray-500">
                        ₹{{ $order->total }} · {{ ucfirst($order->status) }}
                    </p>
                </div>

                <a href="{{ route('order.success', $order->id) }}"
                   class="text-xs text-mitti-primary">
                    View →
                </a>
            </div>
        @empty
            <p class="text-gray-500 text-sm">No orders yet.</p>
        @endforelse
    </div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('orderMiniChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            data: {!! json_encode($chartData) !!},
            borderColor: '#B68A60',
            backgroundColor: 'rgba(182,138,96,0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { display: false },
            y: { display: false }
        }
    }
});
</script>
@endsection
