@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            
            <h1 class="text-2xl font-bold text-mitti-dark">
                Order #{{ $order->order_number ?? $order->id }}
            </h1>
            
            <p class="text-sm text-mitti-muted">
                Placed on {{ $order->created_at->format('d M Y, h:i A') }}
            </p>
            
        </div>

        <a href="{{ route('admin.orders') }}"
           class="text-sm px-3 py-1 rounded border border-mitti-soft text-mitti-dark hover:bg-mitti-cream transition">
            ← Back to Orders
        </a>
         <a href="{{ route('track.direct', $order->awb) }}" class="mt-4 md:mt-0 bg-mitti-primary hover:bg-mitti-secondary text-white px-5 py-2 rounded-full font-semibold text-sm transition">
                TRACK ORDER
            </a>
    </div>

    <!-- Status Badge -->
    @php $s = strtolower($order->status); @endphp
    <div class="mb-6">
        <span class="px-3 py-1 rounded-full text-xs font-semibold
            {{ $s == 'placed' ? 'bg-mitti-warning text-mitti-dark' :
               ($s == 'delivered' ? 'bg-mitti-success text-white' :
               ($s == 'cancelled' ? 'bg-mitti-danger text-white' :
               'bg-gray-400 text-white')) }}">
            {{ ucfirst($s) }}
        </span>
    </div>

    <!-- Customer Information -->   
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-mitti-soft">
        <h2 class="text-lg font-semibold text-mitti-dark mb-3">Customer Information</h2>

        <p class="text-sm text-mitti-dark"><strong>Name:</strong> {{ $order->name }}</p>
        <p class="text-sm text-mitti-dark mt-1">
            <strong>Address:</strong>
            {{ $order->address ?? $order->address_line }}, {{ $order->city }} - {{ $order->pincode }}
        </p>
        <p class="text-sm text-mitti-dark mt-1"><strong>Phone:</strong> {{ $order->phone }}</p>
    </div>

    <!-- Order Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-mitti-cream border border-mitti-soft rounded-lg p-4">
            <p class="text-xs text-mitti-muted uppercase">Items Count</p>
            <p class="text-xl font-bold text-mitti-dark">{{ $order->items->count() }}</p>
        </div>

        <div class="bg-mitti-cream border border-mitti-soft rounded-lg p-4">
            <p class="text-xs text-mitti-muted uppercase">Total Amount</p>
            <p class="text-xl font-bold text-mitti-dark">
                ₹{{ number_format($order->total, 2) }}
            </p>
        </div>

        <div class="bg-mitti-cream border border-mitti-soft rounded-lg p-4">
            <p class="text-xs text-mitti-muted uppercase">Payment Method</p>
            <p class="text-xl font-bold text-mitti-dark">
                {{ $order->payment_method ?? 'COD' }}
            </p>
        </div>
    </div>

    <!-- Ordered Items -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-mitti-soft">
        <h2 class="text-lg font-semibold text-mitti-dark mb-4">Ordered Products</h2>

     @foreach($order->items as $item)
<div class="flex items-center gap-4 border-b border-mitti-soft py-4">

    <img src="{{ product_image_url($item->product->image ?? null) }}"
         class="w-20 h-20 object-cover rounded">

    <div>
        <p class="font-semibold text-mitti-dark text-lg">
            {{ $item->product->name ?? 'Deleted Product' }}
        </p>

        <p class="text-sm text-mitti-muted">
            Qty: {{ $item->quantity }}
        </p>

        <p class="text-sm text-mitti-accent font-semibold">
            ₹{{ number_format($item->price, 2) }}
        </p>
    </div>

</div>
@endforeach

    </div>

    <!-- Payment Breakdown -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-mitti-soft">
        <h2 class="text-lg font-semibold text-mitti-dark mb-4">Payment Summary</h2>

        <p class="text-sm text-mitti-dark">
            <strong>Subtotal:</strong> ₹{{ number_format($order->subtotal ?? 0, 2) }}
        </p>
        <p class="text-sm text-mitti-dark mt-1">
            <strong>Delivery Charges:</strong> ₹{{ number_format($order->delivery_charges ?? 0, 2) }}
        </p>
        <p class="text-lg font-bold text-mitti-dark mt-3">
            <strong>Total:</strong> ₹{{ number_format($order->total ?? 0, 2) }}
        </p>
    </div>

    <!-- Update Status -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-mitti-soft">
        <h2 class="text-lg font-semibold text-mitti-dark mb-4">Update Order Status</h2>

        <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
              method="POST"
              class="flex gap-4 items-center">
            @csrf

            <select name="status"
                class="border border-mitti-soft px-3 py-2 rounded focus:ring-mitti-mid focus:border-mitti-mid">
                <option value="placed" {{ $order->status == 'placed' ? 'selected' : '' }}>Placed</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button class="bg-mitti-mid hover:bg-mitti-dark text-white px-4 py-2 rounded shadow transition">
                Update Status
            </button>
        </form>
    </div>

</div>
@endsection
<style>
:root{
  --mitti-dark:#5a3e36;
  --mitti-mid:#8a6a52;
  --mitti-accent:#c07a35;
  --mitti-soft:#e8d8c4;
  --mitti-cream:#f3e9dd;
  --mitti-warning:#d8952a;
  --mitti-success:#2e7d32;
  --mitti-danger:#c62828;
  --mitti-muted:#7c726d;
}

/* TEXT */
.text-mitti-dark{color:var(--mitti-dark);}
.text-mitti-muted{color:var(--mitti-muted);}
.text-mitti-accent{color:var(--mitti-accent);}

/* BACKGROUND */
.bg-mitti-mid{background:var(--mitti-mid);}
.bg-mitti-cream{background:var(--mitti-cream);}
.bg-mitti-warning{background:var(--mitti-warning);}
.bg-mitti-success{background:var(--mitti-success);}
.bg-mitti-danger{background:var(--mitti-danger);}

/* BORDER */
.border-mitti-soft{border-color:var(--mitti-soft);}
</style>
