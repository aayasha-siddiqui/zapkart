@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-10">

{{-- ================= PAGE TITLE ================= --}}
<h1 class="text-3xl md:text-4xl font-extrabold text-[#6b4f2c] text-center">
    🚚 Delivery Partner Dashboard
</h1>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white rounded-2xl p-6 shadow hover:shadow-xl transition">
        <p class="text-sm text-gray-500">Total Rides</p>
        <p class="text-3xl font-black text-[#c07a35]">{{ $totalRides }}</p>
    </div>

    <div class="bg-green-50 rounded-2xl p-6 shadow hover:shadow-xl transition">
        <p class="text-sm text-green-700">Completed</p>
        <p class="text-3xl font-black text-green-700">
            {{ count($completedOrders) }}
        </p>
    </div>

    <div class="bg-yellow-50 rounded-2xl p-6 shadow hover:shadow-xl transition">
        <p class="text-sm text-yellow-700">Pending</p>
        <p class="text-3xl font-black text-yellow-700">
            {{ count($pendingOrders) }}
        </p>
    </div>

    <div class="bg-red-50 rounded-2xl p-6 shadow hover:shadow-xl transition">
        <p class="text-sm text-red-700">Cancelled</p>
        <p class="text-3xl font-black text-red-700">
            {{ count($cancelledOrders) }}
        </p>
    </div>

</div>

{{-- ================= TOP SECTION ================= --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- PARTNER CARD --}}
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl p-6">
        <div class="flex flex-col md:flex-row gap-6 items-center">

            <img src="{{ asset('storage/'.$partner->driving_license_front) }}"
                 class="w-36 h-36 rounded-2xl object-cover border-4 border-[#f5efe7]">

            <div class="flex-1 space-y-3">
                <h2 class="text-2xl font-extrabold">
                    {{ $partner->full_name }}
                </h2>

                <span class="inline-block px-4 py-1 rounded-full text-sm font-bold
                    {{ $partner->status === 'approved' ? 'bg-green-100 text-green-700' :
                       ($partner->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                       'bg-red-100 text-red-700') }}">
                    {{ ucfirst($partner->status) }}
                </span>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
                    <p><b>Father:</b> {{ $partner->father_name }}</p>
                    <p><b>DOB:</b> {{ $partner->dob }}</p>
                    <p><b>Gender:</b> {{ ucfirst($partner->gender) }}</p>
                    <p><b>City:</b> {{ $partner->city }}</p>
                    <p><b>Vehicle:</b> {{ ucfirst($partner->vehicle_type) }}</p>
                    <p><b>License:</b> {{ $partner->driving_license_number }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- EARNINGS --}}
    <div class="bg-gradient-to-br from-[#fff3d6] to-[#ffe8b5]
                rounded-3xl shadow-xl p-6 flex flex-col justify-center text-center">
        <p class="text-lg font-bold text-[#6b4f2c]">
            Total Earnings
        </p>
        <p class="text-4xl font-black text-[#c07a35] mt-2">
            ₹{{ number_format($totalEarnings,2) }}
        </p>
    </div>

</div>

{{-- ================= ACTIVE DELIVERY ================= --}}
@if($activeOrder)
<div class="bg-white rounded-3xl shadow-xl p-6 space-y-4">
    <h2 class="text-2xl font-extrabold text-[#6b4f2c]">
        🚚 Active Delivery
    </h2>

    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div>
            <p class="font-bold">Order #{{ $activeOrder->order_number }}</p>
            <p class="text-sm text-gray-600">
                Customer: {{ $activeOrder->user->name ?? 'N/A' }}
            </p>
            <p class="text-sm text-gray-600">
                Address: {{ $activeOrder->address ?? '—' }}
            </p>
        </div>

        <div class="text-right">
            <p class="font-bold text-yellow-700">
                {{ ucfirst($activeOrder->status) }}
            </p>
            <p class="text-lg font-extrabold">
                ₹{{ $activeOrder->total }}
            </p>
        </div>
    </div>
</div>
@endif

{{-- ================= ORDER SECTIONS ================= --}}
@php
$sections = [
    ['✔ Completed Deliveries', $completedOrders, 'green'],
    ['⌛ Pending Deliveries', $pendingOrders, 'yellow'],
    ['❌ Cancelled Deliveries', $cancelledOrders, 'red'],
];
@endphp

@foreach($sections as [$title, $orders, $color])
<h2 class="text-2xl font-extrabold text-[#6b4f2c] mt-10">
    {{ $title }}
</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
@forelse($orders as $order)
    <div class="bg-white rounded-2xl p-5 shadow hover:shadow-xl transition">
        <p class="font-bold">Order #{{ $order->order_number }}</p>
        <p class="text-sm text-{{ $color }}-700 font-semibold">
            {{ ucfirst($order->status ?? $title) }}
        </p>
        <p class="text-sm text-gray-600">
            Date: {{ $order->created_at->format('d M Y') }}
        </p>
        @if(isset($order->delivery_charges))
        <p class="font-bold mt-2">
            ₹{{ $order->delivery_charges }}
        </p>
        @endif
    </div>
@empty
    <p class="text-gray-500">No records found.</p>
@endforelse
</div>
@endforeach

</div>
@endsection
