@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5efe7] p-6">

    <h1 class="text-3xl font-extrabold text-[#5a3e36] text-center mb-10">
        Shopkeepers Overview
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @foreach($shopkeepers as $s)
        <div class="bg-white rounded-2xl shadow-lg p-6 transition hover:-translate-y-1">

            {{-- NAME --}}
            <h2 class="text-xl font-bold text-[#5a3e36]">
                {{ $s->name }}
            </h2>

            {{-- STATS --}}
            <div class="grid grid-cols-2 gap-4 my-4 text-center">
                <div class="bg-green-100 rounded p-3">
                    <p class="text-xs">Total Orders</p>
                    <p class="text-lg font-bold text-green-700">
                        {{ $s->totalOrders }}
                    </p>
                </div>
                <div class="bg-blue-100 rounded p-3">
                    <p class="text-xs">Total Qty</p>
                    <p class="text-lg font-bold text-blue-700">
                        {{ $s->totalQty }}
                    </p>
                </div>
            </div>

            {{-- VIEW BUTTON --}}
            <button
                onclick="toggleDetails({{ $s->id }})"
                class="w-full bg-[#6b4f2c] hover:bg-[#5a3e22]
                       text-white py-2 rounded-full font-semibold">
                View
            </button>

            {{-- DETAILS --}}
            <div id="details-{{ $s->id }}"
                 class="hidden mt-5 animate-slide">

                <table class="w-full text-sm border rounded-lg">
                    <thead class="bg-[#ede0d4]">
                        <tr>
                            <th class="p-2 text-left">Product</th>
                            <th class="p-2 text-center">Purchased Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($s->products as $p)
                        <tr class="border-t">
                            <td class="p-2">{{ $p->name }}</td>
                            <td class="p-2 text-center font-semibold">
                                {{ $p->total_qty }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2"
                                class="p-3 text-center text-gray-400">
                                No orders found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
        @endforeach

    </div>
</div>

{{-- JS --}}
<script>
function toggleDetails(id) {
    document
        .getElementById('details-' + id)
        .classList.toggle('hidden');
}
</script>

{{-- ANIMATION --}}
<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-slide {
    animation: slideDown 0.4s ease-in-out;
}
</style>
@endsection
