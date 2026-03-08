@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5efe7] p-6 space-y-8">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#5a3e36]">Income Report</h1>
            <p class="text-sm text-gray-500">Complete business & seller performance overview</p>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="flex gap-2">
            <input type="date" name="from" value="{{ request('from') }}"
                   class="border rounded-lg px-3 py-2 text-sm">
            <input type="date" name="to" value="{{ request('to') }}"
                   class="border rounded-lg px-3 py-2 text-sm">
            <button class="bg-[#5a3e36] text-white px-5 rounded-lg hover:opacity-90">
                Filter
            </button>
        </form>
    </div>

    {{-- ================= TOP STATS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- ALL ORDERS --}}
        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-xs text-gray-500 uppercase">All Orders Total</p>
            <p class="text-2xl font-bold text-[#5a3e36]">₹{{ number_format($allOrdersTotal,2) }}</p>
        </div>

        {{-- ADMIN COMMISSION --}}
        <div class="bg-gradient-to-r from-[#c07a35] to-[#a45c1a] text-white rounded-2xl p-5 shadow">
            <p class="text-xs uppercase opacity-90">Admin Commission (10%)</p>
            <p class="text-2xl font-extrabold">₹{{ number_format($adminCommission,2) }}</p>
        </div>

        {{-- SELLER PAYOUT --}}
        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-xs text-gray-500 uppercase">Seller Payout (90%)</p>
            <p class="text-2xl font-bold text-green-600">₹{{ number_format($sellerPayout,2) }}</p>
        </div>

        {{-- SUPPLIER PURCHASE --}}
        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-xs text-gray-500 uppercase">Supplier Purchase (B2B)</p>
            <p class="text-2xl font-bold text-red-500">₹{{ number_format($supplierPurchase,2) }}</p>
        </div>

    </div>

    {{-- ================= ORDER BREAKDOWN ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Seller Delivered</p>
            <p class="text-xl font-bold text-green-600">₹{{ number_format($sellerDelivered,2) }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Seller Pending</p>
            <p class="text-xl font-bold text-yellow-500">₹{{ number_format($sellerPending,2) }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-sm text-gray-500">Seller Cancelled</p>
            <p class="text-xl font-bold text-red-500">₹{{ number_format($sellerCancelled,2) }}</p>
        </div>

    </div>

    {{-- ================= CHARTS ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- BAR --}}
        <div class="bg-white rounded-2xl p-5 shadow lg:col-span-2">
            <h3 class="font-bold text-[#5a3e36] mb-3">Monthly Order Value</h3>
            <canvas id="barChart"></canvas>
        </div>

        {{-- PIE --}}
        <div class="bg-white rounded-2xl p-5 shadow">
            <h3 class="font-bold text-[#5a3e36] mb-3">Seller Order Status</h3>
            <canvas id="pieChart"></canvas>
        </div>

    </div>

</div>

{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* BAR CHART */
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [{
            data: @json($monthlyTotals),
            backgroundColor: 'rgba(192,122,53,0.85)',
            borderRadius: 12
        }]
    },
    options: {
        plugins: { legend: { display: false }},
        scales: { y: { beginAtZero: true }}
    }
});

/* PIE CHART */
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Delivered','Pending','Cancelled'],
        datasets: [{
            data: [
                {{ $sellerDelivered }},
                {{ $sellerPending }},
                {{ $sellerCancelled }}
            ],
            backgroundColor: [
                'rgba(40,167,69,0.85)',
                'rgba(255,193,7,0.85)',
                'rgba(220,53,69,0.85)'
            ]
        }]
    }
});
</script>
@endsection
