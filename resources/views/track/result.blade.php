@extends('layouts.app')

@section('content')
<style>
/* --- ANIMATIONS --- */
@keyframes pulseDot {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.4); opacity: 0.6; }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes truckMove {
    0% { transform: translateX(0px); }
    100% { transform: translateX(40px); }
}

.progress-truck {
    animation: truckMove 1.5s ease-in-out infinite alternate;
}

/* Scroll Fade */
.fade-card {
    transition: .4s ease;
}
.fade-card:hover {
    transform: translateY(-3px);
    box-shadow: 0px 8px 16px rgba(0,0,0,0.15);
}
</style>

<div class="max-w-4xl mx-auto p-6">

    <!-- HEADER PANEL -->
    <div class="bg-white shadow-lg rounded-xl p-6 fade-card">
        <h2 class="text-3xl font-bold text-mitti-primary mb-3">
            🚚 Real-Time Order Tracking
        </h2><div class="mt-3 p-3 bg-yellow-50 border border-yellow-300 rounded">
    <h3 class="font-bold text-lg">🔐 Delivery OTP</h3>

    @if($order->status == 'accepted' || $order->status == 'picked' || $order->status == 'on_the_way')
        <p class="text-xl font-bold text-green-700">
            {{ $order->delivery_otp }}
        </p>
        <p class="text-sm text-gray-600">Share this OTP with the delivery partner.</p>

    @elseif($order->status == 'delivered')
        <p class="text-green-600 font-semibold">Order already delivered</p>

    @else
        <p class="text-gray-500">OTP will be generated after the partner accepts the order.</p>
    @endif
</div>


        <p class="text-gray-700 text-lg font-semibold">
            Tracking ID: <span class="text-black">{{ $order->awb }}</span>
        </p>

        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <p class="text-sm text-gray-600">Order No: <b>{{ $order->order_number }}</b></p>
            <p class="text-sm text-gray-600">Placed: <b>{{ $order->created_at->format('d M Y, h:i A') }}</b></p>
            <p class="text-sm text-gray-600">Will Deliver To: <b>  {{ $order->address_line }},</b></p>
            <p class="text-sm text-gray-600">ETA: <b>{{ $etaDays }} Day(s)</b></p>
        </div>

        <div class="flex justify-end mt-4">
            <button id="copyBtn" data-awb="{{ $order->awb }}"
                class="bg-mitti-primary px-4 py-2 text-white rounded-full shadow hover:bg-mitti-secondary transition">
                Copy Tracking ID
            </button>
        </div>
    </div>

    <!-- CURRENT STATUS -->
    <div class="bg-white shadow-lg rounded-xl p-6 mt-6 fade-card">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600">Current Status</p>
                <h2 class="text-3xl font-bold text-green-600 mt-1">{{ $status }}</h2>

                <p class="text-sm text-gray-600 mt-2">
                    Distance Left: <b>{{ $distance }} km</b>
                </p>
                <p class="text-xs text-gray-400">Updated: {{ now()->format('d M Y, h:i A') }}</p>
            </div>

            <!-- Truck Animation -->
            <img src="https://cdn-icons-png.flaticon.com/512/679/679720.png"
                 class="w-20 h-20 opacity-90 progress-truck" />
        </div>
    </div>

    <!-- SHIPMENT TIMELINE -->
    <div class="bg-white shadow-lg rounded-xl p-6 mt-6 fade-card">
        <h3 class="text-xl font-bold mb-4">📦 Shipment Timeline</h3>

        <div class="space-y-6">
            @foreach($timeline as $t)
            <div class="flex items-start gap-4">

                <!-- Dot -->
                <div class="flex flex-col items-center">
                    <div class="w-5 h-5 rounded-full
                        {{ $t['done'] ? 'bg-green-600 animate-pulse' : 'bg-gray-300' }}"
                        style="{{ $t['done'] ? 'animation: pulseDot 1.2s infinite;' : '' }}">
                    </div>

                    @if(!$loop->last)
                    <div class="w-1 h-10
                        {{ $t['done'] ? 'bg-green-300' : 'bg-gray-200' }}">
                    </div>
                    @endif
                </div>

                <!-- Text -->
                <div>
                    <p class="font-semibold text-lg {{ $t['done'] ? 'text-green-700' : 'text-gray-800' }}">
                        {{ $t['label'] }}
                    </p>
                    <p class="text-xs text-gray-500">{{ $t['time'] }}</p>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    <!-- ROUTE PROGRESS -->
    <div class="bg-white shadow-lg rounded-xl p-6 mt-6 fade-card">
        <h3 class="text-xl font-bold mb-4">🗺 Route Progress</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            @foreach($routeList as $loc)
            <div class="p-4 border rounded-xl shadow-sm fade-card
                {{ $loc['done'] ? 'bg-green-50 border-green-300' : 'bg-gray-50' }}">

                <p class="font-semibold text-lg text-mitti-dark">
                    {{ $loc['place'] }}
                </p>

                <p class="text-xs text-gray-500 mt-1">
                    {{ $loc['time'] }}
                </p>

                @if($loc['done'])
                <span class="text-green-600 text-xs font-bold block mt-1">✓ Completed</span>
                @else
                <span class="text-gray-400 text-xs block mt-1">Pending</span>
                @endif
            </div>
            @endforeach

        </div>
    </div>

</div>

<script>
// Copy AWB Button
document.getElementById('copyBtn')?.addEventListener('click', function () {
    const code = this.dataset.awb;
    navigator.clipboard.writeText(code).then(() => {
        this.textContent = "Copied!";
        setTimeout(() => (this.textContent = "Copy Tracking ID"), 1500);
    });
});
</script>

@endsection
