@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-8">

{{-- ================= SUCCESS MODAL ================= --}}
@if(session('success'))
<div id="successModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-96 text-center shadow-xl animate-bounce">
        <h2 class="text-2xl font-bold text-green-600 mb-2">🎉 Congratulations!</h2>
        <p class="text-sm text-gray-600 mb-4">
            Products successfully purchased and added to warehouse.
        </p>
        <button onclick="closeModal()"
                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Continue
        </button>
    </div>
</div>
@endif

{{-- ================= SUPPLIER COMPACT CARD ================= --}}
<div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold">{{ $supplier->business_name }}</h2>
        <p class="text-sm text-gray-500">
            {{ $supplier->name }} • {{ $supplier->phone }}
        </p>
    </div>
    <div class="text-sm text-gray-600">
        GST: {{ $supplier->gst_number }}
    </div>
</div>

{{-- ================= STATS OVERVIEW ================= --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">Total Products</p>
        <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
    </div>

    <div class="bg-green-50 p-5 rounded-xl shadow">
        <p class="text-sm text-green-700">Purchased</p>
        <p class="text-2xl font-bold text-green-700">{{ $stats['sold'] }}</p>
    </div>

    <div class="bg-yellow-50 p-5 rounded-xl shadow">
        <p class="text-sm text-yellow-700">Pending</p>
        <p class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</p>
    </div>

    <div class="bg-blue-50 p-5 rounded-xl shadow">
        <p class="text-sm text-blue-700">Total Paid</p>
        <p class="text-2xl font-bold text-blue-700">
            ₹{{ number_format($stats['paid'],2) }}
        </p>
    </div>

</div>

{{-- ================= BAR GRAPH ================= --}}
<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-bold mb-4">Purchase Overview</h3>

    <div class="relative h-64 md:h-72 w-55">
        <canvas id="supplierChart"></canvas>
    </div>
</div>

</div>

{{-- ================= PRODUCTS ================= --}}
<form method="POST" action="{{ route('admin.product.bulkPay') }}">
@csrf

@foreach($categories as $cat)
<div class=" m-5 bg-white rounded-xl shadow p-5 space-y-4">

    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold">{{ $cat->name }}</h3>
        <span class="text-sm text-gray-500">
            {{ $cat->products->where('status','available')->count() }} Available
        </span>
    </div>

    <div class=" m-4 grid grid-cols-2 md:grid-cols-4 gap-4">

        @foreach($cat->products->where('status','available') as $p)
        <div class="border rounded-lg p-3 hover:shadow">

            <img src="{{ asset('storage/'.$p->image) }}"
                 class="h-32 w-full object-cover rounded mb-2">

            <p class="text-sm font-semibold">{{ $p->name }}</p>
            <p class="text-green-700 font-bold text-sm">
                ₹{{ number_format($p->price,2) }}
            </p>

            <label class="flex items-center gap-2 text-xs mt-2">
    <input type="checkbox"
           name="products[{{ $p->id }}][selected]"
           value="1"
           data-price="{{ $p->price }}"
           class="product-check accent-green-600"
           onchange="updateTotal()">
    Select Product
</label>

<input type="number"
       name="products[{{ $p->id }}][qty]"
       min="1"
       value="1"
       class="qty-input mt-2 w-full border rounded px-2 py-1 text-sm"
       onchange="updateTotal()">


        </div>
        @endforeach

    </div>
</div>
@endforeach

{{-- ================= SOLD PRODUCTS ================= --}}
<div class=" m-4 bg-white rounded-xl shadow p-5">
    <h3 class="text-xl font-bold mb-4">Purchased Products</h3>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @forelse($soldProducts as $p)
        <div class="opacity-70 border rounded-lg p-3">
            <img src="{{ asset('storage/'.$p->image) }}"
                 class="h-24 w-full object-cover rounded mb-2">
            <p class="text-xs font-semibold">{{ $p->name }}</p>
            <span class="text-green-700 text-xs font-bold">✔ Purchased</span>
        </div>
        @empty
        <p class="text-sm text-gray-500">No products purchased yet.</p>
        @endforelse
    </div>
</div>

{{-- ================= PAYMENT SUMMARY ================= --}}
<div class="fixed bottom-6 right-6 bg-white shadow-xl rounded-xl p-4 w-72">
    <p class="text-sm">
        Selected Items: <b id="selectedCount">0</b>
    </p>
    <p class="text-lg font-bold mb-3">
        Total ₹<span id="totalAmount">0</span>
    </p>
    <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
        Buy Selected
    </button>
</div>

</form>
</div>

{{-- ================= JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const checks = document.querySelectorAll('.product-check');
const totalEl = document.getElementById('totalAmount');
const countEl = document.getElementById('selectedCount');
document.querySelectorAll('.qty-input').forEach(qty => {
    qty.addEventListener('input', updateTotal);
});

function updateTotal() {
    let total = 0, count = 0;

    document.querySelectorAll('.product-check').forEach(cb => {
        if (cb.checked) {
            const box = cb.closest('.border');
            const qtyInput = box.querySelector('.qty-input');

            const qty = qtyInput ? parseInt(qtyInput.value || 1) : 1;
            const price = parseFloat(cb.dataset.price);

            total += price * qty;
            count++;
        }
    });

    document.getElementById('totalAmount').innerText = total.toFixed(2);
    document.getElementById('selectedCount').innerText = count;
}

// 🔥 page load pe sab bind karo
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.product-check').forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    document.querySelectorAll('.qty-input').forEach(qty => {
        qty.addEventListener('input', updateTotal);
    });

});

checks.forEach(cb => cb.addEventListener('change', updateTotal));


const graphData = @json($graphData);
new Chart(document.getElementById('supplierChart'), {
    type: 'bar',
    data: {
        labels: graphData.labels,
        datasets: [{
            label: 'Products',
            data: graphData.values,
        }]
    }
});

function closeModal(){
    document.getElementById('successModal')?.remove();
}
</script>
@endsection
