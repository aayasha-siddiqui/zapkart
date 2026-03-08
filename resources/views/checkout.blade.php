@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream py-12 px-4 sm:px-6 lg:px-8">

    {{-- PAGE TITLE --}}
    <h1 class="text-3xl sm:text-4xl font-semibold text-center text-mitti-dark mb-10 tracking-tight">
        🛒 Your Shopping Cart
    </h1>

    <div class="flex flex-col lg:flex-row gap-10 max-w-7xl mx-auto">

        {{-- LEFT: CART ITEMS --}}
        <div class="flex-1 space-y-6">

            @foreach($carts as $item)
            <div class="flex items-center gap-5 bg-white border border-mitti-light p-4 rounded-lg shadow-sm hover:shadow-md transition relative">

                {{-- Wishlist Heart --}}
                <!-- <button class="absolute top-3 right-3 text-mitti-dark hover:text-red-500 transition cursor-pointer" title="Add to Wishlist">
                    ♥
                </button> -->

                {{-- Product Image --}}
                <div class="w-28 h-28 flex items-center justify-center rounded-lg overflow-hidden bg-mitti-cream cursor-pointer group" onclick="openImageModal('{{ asset($item->product->image) }}')">
                    <img src="{{ product_image_url($item->product->image ?? null) }}
" alt="{{ $item->product->name }}" class="object-contain h-24 group-hover:scale-105 transition duration-300">
                </div>

                {{-- Product Info --}}
                <div class="flex-1">
                    <h3 class="text-mitti-dark font-medium text-base sm:text-lg hover:text-mitti-primary cursor-pointer transition">
                        {{ $item->product->name }}
                    </h3>
                    <p class="text-mitti-dark/70 text-sm mt-1">Category: {{ $item->product->category->name }}</p>
                    <p class="mt-2 font-semibold text-mitti-dark text-base sm:text-lg">₹{{ $item->product->price * $item->quantity }}</p>
                    <p class="text-xs text-mitti-dark/50 mt-1">Limited Stock!</p>
                </div>

                {{-- Quantity Controls --}}
                <div class="flex flex-col items-center gap-1">
                    <form method="POST" action="{{ route('cart.increase', $item->id) }}">@csrf
                        <button class="w-9 h-9 rounded-full bg-mitti-primary text-white flex items-center justify-center hover:bg-mitti-secondary shadow transition text-lg">+</button>
                    </form>
                    <span class="text-mitti-dark font-medium text-sm">{{ $item->quantity }}</span>
                    <form method="POST" action="{{ route('cart.decrease', $item->id) }}">@csrf
                        <button class="w-9 h-9 rounded-full bg-red-400 text-white flex items-center justify-center hover:bg-red-500 shadow transition text-lg">-</button>
                    </form>
                </div>

            </div>
            @endforeach

            <p class="text-sm text-mitti-dark/70 mt-1">🛡 Free Delivery on orders above ₹500</p>

            {{-- Checkout Button --}}
            <button id="openCheckoutModal" class="mt-5 w-full bg-mitti-primary hover:bg-mitti-secondary text-white font-semibold py-3 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                🚀 Proceed to Checkout
            </button>

            {{-- Recommended Products --}}
            @if(isset($recommended) && $recommended->count() > 0)
            <div class="mt-10">
                <h2 class="text-xl font-semibold text-mitti-dark mb-4">✨ Recommended for you</h2>
                <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                    @foreach($recommended as $rec)
                    <div class="bg-white border border-mitti-light rounded-lg shadow-sm p-3 min-w-[150px] flex-shrink-0 group hover:shadow-md transition">
                        <div class="w-full h-28 flex items-center justify-center overflow-hidden rounded-lg cursor-pointer" onclick="openImageModal('{{ asset($rec->image) }}')">
                            <img src="{{ product_image_url($rec->image) }}" class="object-contain h-24 group-hover:scale-105 transition duration-300">
                        </div>
                        <h3 class="text-mitti-dark font-medium text-sm mt-2 truncate">{{ $rec->name }}</h3>
                        <p class="text-mitti-primary font-semibold text-sm">₹{{ $rec->price }}</p>
                        <button class="mt-2 w-full border border-mitti-primary text-mitti-primary hover:bg-mitti-primary hover:text-white py-1 rounded transition text-xs font-semibold">Add to Cart</button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT: ORDER SUMMARY --}}
        <div class="w-full lg:w-96 bg-white border border-mitti-light rounded-lg shadow-sm hover:shadow-md transition p-6 sm:p-8 sticky top-20">
            <h2 class="text-xl font-semibold mb-4 text-mitti-dark text-center">📝 Order Summary</h2>

            <div class="divide-y divide-mitti-light">
                @foreach($carts as $item)
                <div class="flex justify-between py-2 hover:bg-mitti-cream rounded transition px-2">
                    <p class="text-mitti-dark text-sm sm:text-base">{{ $item->product->name }} x {{ $item->quantity }}</p>
                    <p class="font-semibold text-mitti-primary text-sm sm:text-base">₹{{ $item->product->price * $item->quantity }}</p>
                </div>
                @endforeach
            </div>

            @php
                $subtotal = $carts->sum(fn($i) => $i->product->price * $i->quantity);
                $delivery = 25;
                $total = $subtotal + $delivery;
            @endphp

            <div class="mt-4 space-y-2 text-sm sm:text-base">
                <div class="flex justify-between text-mitti-dark font-medium">
                    <span>Items ({{ $carts->sum('quantity') }})</span>
                    <span>₹{{ $subtotal }}</span>
                </div>
                <div class="flex justify-between text-mitti-dark font-medium">
                    <span>Estimated Delivery</span>
                    <span>{{ \Carbon\Carbon::now()->addDays(3)->format('d M, Y') }}</span>
                </div>
                <div class="flex justify-between text-mitti-dark font-medium">
                    <span>Delivery</span>
                    <span>₹{{ $delivery }}</span>
                </div>
                <div class="flex justify-between font-bold text-mitti-primary text-base sm:text-lg border-t pt-2">
                    <span>Total</span>
                    <span>₹{{ $total }}</span>
                </div>
                <p class="mt-2 text-xs text-mitti-dark/50">💳 Secure Payment. Free delivery on orders above ₹500.</p>
                <p class="text-xs text-mitti-dark/50">🎁 Apply promo codes at checkout to save more!</p>
            </div>

            <p class="mt-3 text-xs text-center text-mitti-dark/50">100% Safe & Trusted Checkout.</p>
        </div>
    </div>

    {{-- IMAGE MODAL --}}
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center opacity-0 pointer-events-none z-50 p-4 overflow-auto transition-opacity duration-300">
        <div class="relative w-full max-w-md bg-white rounded-lg p-4">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-mitti-dark text-2xl font-bold hover:text-mitti-primary">&times;</button>
            <img id="modalImage" src="" class="w-full rounded-lg object-contain">
        </div>
    </div>

    {{-- CHECKOUT MODAL --}}
    <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-start justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-50 pt-5">
        <div class="bg-white rounded-lg p-6 sm:p-8 w-full max-w-md relative transform scale-95 transition-transform duration-300 shadow-lg">
            <button id="closeModal" class="absolute top-3 right-3 text-mitti-dark text-3xl font-bold hover:text-mitti-primary">&times;</button>
            <h2 class="text-2xl font-semibold text-mitti-dark mb-4 text-center">🏠 Delivery Details</h2>

            <form id="checkoutForm" action="{{ route('order.place') }}" method="POST" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Full Name" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-mitti-primary" required>
                <input type="text" name="phone" placeholder="Phone Number" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-mitti-primary" required>
                
                <input type="text" name="city" placeholder="City" class="w-full border p-2 rounded-lg" required>
<textarea name="address" placeholder="Full Address" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-mitti-primary" required></textarea>
                <input type="text" name="pincode" placeholder="Pincode" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-mitti-primary" required>
                <select name="payment_method" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-mitti-primary">
                    <option value="cod">Cash on Delivery</option>
                    <option value="online">Online Payment</option>
                </select>
                <button type="submit" id="placeOrderBtn" class="w-full mt-3 bg-mitti-primary hover:bg-mitti-secondary text-white py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    ✅ Place Order Now
                </button>
            </form>
        </div>
    </div>
@auth
LOGGED IN USER ID: {{ auth()->id() }}
@endauth

@guest
YOU ARE NOT LOGGED IN
@endguest

</div>

<script>
    // Checkout modal
    const checkoutModal = document.getElementById('checkoutModal');
    const openCheckoutBtn = document.getElementById('openCheckoutModal');
    const closeCheckoutBtn = document.getElementById('closeModal');

    openCheckoutBtn.addEventListener('click', () => {
        checkoutModal.classList.remove('opacity-0','pointer-events-none');
        checkoutModal.classList.add('opacity-100');
        checkoutModal.querySelector('div').classList.remove('scale-95');
        checkoutModal.querySelector('div').classList.add('scale-100');
    });
    closeCheckoutBtn.addEventListener('click', () => {
        checkoutModal.classList.add('opacity-0','pointer-events-none');
        checkoutModal.classList.remove('opacity-100');
        checkoutModal.querySelector('div').classList.add('scale-95');
        checkoutModal.querySelector('div').classList.remove('scale-100');
    });
    window.addEventListener('click', e => { if(e.target === checkoutModal) {closeCheckoutBtn.click();} });

    // Image modal
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    function openImageModal(src){
        modalImage.src = src;
        imageModal.classList.remove('opacity-0','pointer-events-none');
        imageModal.classList.add('opacity-100');
    }
    function closeImageModal(){
        imageModal.classList.add('opacity-0','pointer-events-none');
        imageModal.classList.remove('opacity-100');
    }
    window.addEventListener('click', e => { if(e.target === imageModal) closeImageModal(); });
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.getElementById("checkoutForm").addEventListener("submit", function (e) {
    e.preventDefault(); // FORM ko normal submit hone se roka

    let formData = new FormData(this);

   fetch("{{ route('order.place') }}", {
    method: "POST",
    credentials: "same-origin",
    headers: {
        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
    },
    body: formData
})

    .then(res => res.json())
    .then(res => {

        // ---------------- COD ----------------
        if(res.success && !res.online){
            window.location.href = res.redirect;
            return;
        }

        // ---------------- ONLINE PAYMENT ----------------
        if(res.online){
            var options = {
                "key": res.key,
                "amount": res.amount,
                "currency": "INR",
                "name": "Mitti Grocery",
                "order_id": res.order_id,
                "handler": function (response){

                fetch("{{ route('checkout.payment.success') }}", {
    method: "POST",
    credentials: "same-origin",
    headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Content-Type": "application/x-www-form-urlencoded"
    },
    body: new URLSearchParams({
        razorpay_payment_id: response.razorpay_payment_id,
        razorpay_order_id: response.razorpay_order_id,
        razorpay_signature: response.razorpay_signature
    })
})

                    .then(r => r.json())
                    .then(result => {
                        window.location.href = result.redirect;
                    });
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }
    });
});
</script>

@endsection
