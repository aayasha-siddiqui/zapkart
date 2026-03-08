@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    @php
        $totalOrders = $user->orders->count();
        $totalSpent = $user->orders->sum('total');
        $lastOrder = $user->orders->sortByDesc('created_at')->first();
    @endphp

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-mitti-dark">User Details</h1>
            <p class="text-sm text-mitti-muted">Profile & order history</p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="text-sm px-3 py-1 rounded border border-mitti-soft text-mitti-dark hover:bg-mitti-cream transition">
            ← Back to Users
        </a>
    </div>

    <!-- Top: User Info + Stats -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-mitti-soft">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <!-- User Info -->
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-xl bg-mitti-mid text-white flex items-center justify-center text-xl font-semibold">
                    {{ strtoupper(substr($user->name,0,2)) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-mitti-dark mb-1">
                        {{ $user->name }}
                    </h2>
                    <p class="text-sm text-mitti-muted mb-1">
                        <span class="font-semibold">Email:</span>
                        {{ $user->email ?: '-' }}
                    </p>
                    <p class="text-xs text-mitti-muted">
                        Joined: {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 w-full md:w-auto">
                <div class="bg-mitti-cream rounded-lg px-4 py-3 border border-mitti-soft">
                    <p class="text-xs text-mitti-muted uppercase tracking-wide">Total Orders</p>
                    <p class="text-lg font-bold text-mitti-dark">{{ $totalOrders }}</p>
                </div>
                <div class="bg-mitti-cream rounded-lg px-4 py-3 border border-mitti-soft">
                    <p class="text-xs text-mitti-muted uppercase tracking-wide">Total Spent</p>
                    <p class="text-lg font-bold text-mitti-dark">
                        ₹{{ number_format($totalSpent, 2) }}
                    </p>
                </div>
                <div class="bg-mitti-cream rounded-lg px-4 py-3 border border-mitti-soft">
                    <p class="text-xs text-mitti-muted uppercase tracking-wide">Last Order</p>
                    <p class="text-sm font-semibold text-mitti-dark">
                        @if($lastOrder)
                            {{ $lastOrder->created_at->format('d M Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Orders -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-mitti-soft">
        <h2 class="text-lg font-semibold text-mitti-dark mb-4">
            Orders by {{ $user->name }}
        </h2>

        <div class="overflow-x-auto rounded-lg border border-mitti-soft">
            <table class="min-w-full bg-white">
                <thead class="bg-mitti-mid text-white">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold">Order No</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold">Total</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold">Items</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->orders as $order)
                    <tr class="border-b border-mitti-soft hover:bg-mitti-cream transition">
                        <td class="px-4 py-2 text-sm font-semibold">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="text-mitti-accent hover:underline">
                                {{ $order->order_number ?? $order->id }}
                            </a>
                        </td>

                        <td class="px-4 py-2 text-sm font-medium text-mitti-dark">
                            ₹{{ number_format($order->total ?? 0, 2) }}
                        </td>

                        <td class="px-4 py-2 text-sm">
                            @php $s = strtolower($order->status); @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $s == 'placed' ? 'bg-mitti-warning text-mitti-dark' :
                                   ($s == 'delivered' ? 'bg-mitti-success text-white' :
                                   ($s == 'cancelled' ? 'bg-mitti-danger text-white' :
                                   'bg-gray-400 text-white')) }}">
                                {{ ucfirst($s) }}
                            </span>
                        </td>

                        <td class="px-4 py-2 text-sm text-mitti-dark">
                            {{ $order->items->count() }} Product(s)
                        </td>

                        <td class="px-4 py-2 text-sm text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="bg-mitti-mid hover:bg-mitti-dark text-white px-3 py-1 rounded shadow transition">
                                View →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-mitti-muted text-sm">
                            No orders found for this user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
