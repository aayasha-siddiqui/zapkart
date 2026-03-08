@extends('layouts.app')
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

/* BACKGROUND */
.bg-mitti-mid{background:var(--mitti-mid);}
.bg-mitti-cream{background:var(--mitti-cream);}
.bg-mitti-warning{background:var(--mitti-warning);}
.bg-mitti-success{background:var(--mitti-success);}
.bg-mitti-danger{background:var(--mitti-danger);}

/* BORDER */
.border-mitti-soft{border-color:var(--mitti-soft);}
</style>

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-mitti-dark">Orders Management</h1>
    </div>

    <!-- Search + Filter Bar -->
    <div class="flex flex-wrap items-center gap-3 mb-4">

        <!-- Search -->
        <input id="searchInput"
            type="text"
            placeholder="Search by order number, user name or email..."
            class="px-4 py-2 border rounded-lg shadow-sm w-72 focus:ring-mitti-mid focus:border-mitti-mid"
            value="{{ $search ?? '' }}"
        />

        <!-- Status Filter -->
        <select id="statusFilter"
            class="px-3 py-2 border rounded-lg shadow-sm focus:ring-mitti-mid focus:border-mitti-mid">
            <option value="all" {{ ($status ?? '') == 'all' ? 'selected' : '' }}>All Status</option>
            <option value="placed" {{ ($status ?? '') == 'placed' ? 'selected' : '' }}>Placed</option>
            <option value="delivered" {{ ($status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ ($status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

    </div>

    <!-- Orders Table -->
    <div class="overflow-x-auto rounded-lg shadow border border-mitti-soft">
        <table id="ordersTable" class="min-w-full bg-white">
            <thead class="bg-mitti-mid text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Order No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">User</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Total</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Items</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                <tr class="border-b border-mitti-soft hover:bg-mitti-cream transition">
                    <td class="px-4 py-3 font-semibold">
                        {{ $order->order_number ?? $order->id }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="font-semibold text-mitti-dark">{{ $order->user->name ?? 'Guest' }}</div>
                        <div class="text-xs text-mitti-muted">{{ $order->user->email ?? '-' }}</div>
                    </td>

                    <td class="px-4 py-3 font-medium text-mitti-dark">
                        ₹{{ number_format($order->total ?? 0, 2) }}
                    </td>

                    <td class="px-4 py-3">
                        @php $s = strtolower($order->status); @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $s == 'placed' ? 'bg-mitti-warning text-mitti-dark' :
                               ($s == 'delivered' ? 'bg-mitti-success text-white' :
                               ($s == 'cancelled' ? 'bg-mitti-danger text-white' :
                               'bg-gray-400 text-white')) }}">
                            {{ ucfirst($s) }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-mitti-dark">
                        {{ $order->items->count() }} Product(s)
                    </td>

                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="bg-mitti-mid hover:bg-mitti-dark text-white px-3 py-1 rounded shadow transition">
                            View →
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>

<!-- SEARCH + FILTER JS -->
<script>
function applyFilters(){
    const search = document.getElementById("searchInput").value;
    const status = document.getElementById("statusFilter").value;

    const url = new URL(window.location.href);
    url.searchParams.set("search", search);
    url.searchParams.set("status", status);

    window.location.href = url.toString();
}

document.getElementById("searchInput").addEventListener("keyup", function(){
    clearTimeout(window._searchTimer);
    window._searchTimer = setTimeout(applyFilters, 300);
});

document.getElementById("statusFilter").addEventListener("change", applyFilters);
</script>

@endsection
