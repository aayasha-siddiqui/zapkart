@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-[#f5efe7] p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-3xl font-extrabold text-[#5a3e36]">
            Seller Dashboard
        </h1>

        <button onclick="openAddModal()"
            class="px-5 py-2 bg-[#c07a35] text-white rounded-full font-semibold shadow hover:bg-[#b46f2f] transition">
            ➕ Add Product
        </button>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
        <div class="stat-card">Products <b>{{ $totalProducts }}</b></div>
        <div class="stat-card">Orders <b>{{ $totalOrders }}</b></div>
        <div class="stat-card text-green-700">Delivered <b>{{ $delivered }}</b></div>
        <div class="stat-card text-yellow-600">Pending <b>{{ $pending }}</b></div>
        <div class="stat-card text-red-600">Cancelled <b>{{ $cancelled }}</b></div>
        <div class="stat-card bg-green-50 text-green-700">
            Earnings <br>
            <b>₹{{ number_format($totalRevenue,2) }}</b>
        </div>
    </div>

    <!-- CHART (SMALL & CENTERED) -->
    <!-- <div class="bg-white rounded-2xl shadow p-4 w-[260px] mx-auto mb-12">
        <canvas id="orderChart" height="30"></canvas>
    </div> -->

    <!-- PRODUCTS -->
    <h2 class="section-title">My Products</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 mb-12">

        <!-- ADD CARD -->
        <div onclick="openAddModal()"
            class="add-card">
            +
        </div>

        @foreach($products as $product)
        <div class="product-card">
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="h-32 w-full object-cover rounded-lg mb-3">

            <h3 class="font-bold text-sm">{{ $product->name }}</h3>
            <p class="text-xs text-gray-500">{{ $product->category->name }}</p>

            <p class="font-semibold text-green-600 mt-1">
                ₹{{ $product->price }}
            </p>

            <div class="flex justify-between mt-3 text-sm">
                <a href="{{ route('products.edit',$product->id) }}" class="text-blue-600">Edit</a>

                <form method="POST" action="{{ route('products.destroy',$product->id) }}">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- ORDERS -->
    <h2 class="section-title">My Orders</h2>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f3e9dd] text-[#5a3e36]">
                <tr>
                    <th class="p-3 text-left">Product</th>
                    <th class="p-3">Qty</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                <tr class="border-t">
                    <td class="p-3">{{ $item->product->name }}</td>
                    <td class="p-3 text-center">{{ $item->quantity }}</td>
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs
                            {{ $item->order->status === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $item->order->status }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        @if($item->status !== 'delivered')
                        <form method="POST" action="{{ route('seller.order.delivered',$item->id) }}">
                            @csrf
                            <button class="text-blue-600 text-xs">Mark Delivered</button>
                        </form>
                        @else
                        <span class="text-green-600 text-xs">✓ Done</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- ADD PRODUCT MODAL -->
<div id="addModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl w-[380px] shadow-xl">
        <h3 class="font-bold mb-4 text-lg">Add Product</h3>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <select name="category_id" class="input">
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

    <input type="number"
           name="qty"
           min="0"
           value="{{ old('qty', $product->qty ?? 0) }}"
           class="w-full border rounded px-3 py-2">
            <input name="name" class="input" placeholder="Product name">
            <input name="price" class="input" placeholder="Price">
            <input type="file" name="image" class="mb-4">

            <button class="btn-primary w-full">Save Product</button>
        </form>

        <button onclick="closeAddModal()" class="text-xs text-gray-500 mt-3">Close</button>
    </div>
</div>

<!-- STYLES -->
<style>
.stat-card{
    background:#fff;
    padding:14px;
    border-radius:14px;
    text-align:center;
    font-weight:600;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
}
.section-title{
    font-size:20px;
    font-weight:800;
    margin-bottom:12px;
    color:#5a3e36;
}
.product-card{
    background:#fff;
    padding:12px;
    border-radius:16px;
    box-shadow:0 3px 8px rgba(0,0,0,0.1);
}
.add-card{
    background:#fff;
    border:2px dashed #bbb;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
    cursor:pointer;
}
.input{
    width:100%;
    border:1px solid #ccc;
    padding:8px;
    margin-bottom:10px;
    border-radius:8px;
}
.btn-primary{
    background:#c07a35;
    color:white;
    padding:10px;
    border-radius:10px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('orderChart'),{
    type:'doughnut',
    data:{
        labels:['Delivered','Pending','Cancelled'],
        datasets:[{
            data:[{{ $delivered }},{{ $pending }},{{ $cancelled }}],
            backgroundColor:['#16a34a','#facc15','#dc2626']
        }]
    },
    options:{
        cutout:'70%',
        plugins:{legend:{display:false}}
    }
});

function openAddModal(){
    addModal.classList.remove('hidden');
    addModal.classList.add('flex');
}
function closeAddModal(){
    addModal.classList.add('hidden');
}
</script>

@endsection
