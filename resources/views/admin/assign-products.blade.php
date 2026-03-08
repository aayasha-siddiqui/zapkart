@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5efe7] py-10 px-4">

    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-lg border border-[#d2b48c] p-8">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-[#5a3e2b]">
                    Assign Products to Shopkeeper
                </h2>
                <p class="text-sm text-gray-500">
                    Enter quantity to assign products
                </p>
            </div>

            <a href="{{ route('admin.shopkeepers.create') }}"
               class="bg-[#6b4f2c] hover:bg-[#5a3e22] text-white px-5 py-2 rounded-full text-sm font-semibold shadow">
                + Add Buyer
            </a>
        </div>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.assign.products.store') }}">
            @csrf

            {{-- SHOPKEEPER --}}
           {{-- SHOPKEEPER --}}
<div class="mb-8">
    <label class="block mb-2 font-semibold text-[#5a3e2b]">
        Select Shopkeeper
    </label>

    <select id="shopkeeperSelect"
            name="shopkeeper_id"
            required
            class="w-full border border-[#c2a27e] rounded-lg p-3 mb-4">
        <option value="">-- Choose Shopkeeper --</option>
        @foreach($shopkeepers as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select>

    {{-- VIEW BUTTON --}}
    <button
        type="button"
        onclick="goToOverview()"
        class="w-full bg-[#6b4f2c] hover:bg-[#5a3e22]
               text-white py-2 rounded-full
               font-semibold transition">
        View
    </button>
</div>


            {{-- PRODUCTS --}}
            <h3 class="text-xl font-bold text-[#5a3e2b] mb-4">
                Assign Products (Qty > 0)
            </h3>

            @foreach($products->groupBy('category.name') as $category => $items)
            <div class="mb-6 border border-[#e0c9a6] rounded-xl p-4 bg-[#faf7f2]">

                <h4 class="font-semibold text-[#6b4f2c] mb-3 text-lg">
                    {{ $category }}
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($items as $product)

                    <div class="product-card flex justify-between items-center bg-white p-3 rounded-lg border transition">

                        <div>
                            <p class="font-medium text-[#5a3e2b]">
                                {{ $product->name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                ₹{{ number_format($product->price,2) }}
                            </p>
                        </div>

                        <input type="number"
                               name="products[{{ $product->id }}][qty]"
                               min="0"
                               placeholder="Qty"
                               class="qty-input w-24 border rounded px-2 py-1 text-sm text-center">
                    </div>

                    @endforeach
                </div>
            </div>
            @endforeach

            {{-- SUBMIT --}}
            <div class="text-center mt-8">
                <button
                    class="bg-[#6b4f2c] hover:bg-[#5a3e22] text-white px-10 py-3 rounded-full text-lg font-semibold shadow-lg transition">
                    Assign Products
                </button>
            </div>

        </form>
    </div>
</div>

{{-- JS --}}
<script>
function goToOverview() {
    const id = document.getElementById('shopkeeperSelect').value;

    if (!id) {
        alert('Please select a shopkeeper first');
        return;
    }

    window.location.href = `/admin/shopkeepers/overview`;
}
</script>


<script>
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('input', function () {
        const card = this.closest('.product-card');
        if (this.value > 0) {
            card.classList.add('ring','ring-green-400','scale-[1.02]');
        } else {
            card.classList.remove('ring','ring-green-400','scale-[1.02]');
        }
    });
});
</script>
@endsection
