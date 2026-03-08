@extends('layouts.app')
@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-mitti-dark">
            Welcome, {{ $partner->full_name }}
        </h2>

        <span class="px-4 py-1 rounded-full text-white text-sm 
            {{ $partner->online_status == 'online' ? 'bg-green-600' : 'bg-red-600' }}">
            {{ $partner->online_status == 'online' ? 'Online' : 'Offline' }}
        </span>
        <span class="px-4 py-1 rounded-full text-dark text-sm bg-green-600 ">
           <a href="{{ route('partner.profile') }}" class="btn btn-warning">
    Edit Profile
</a>
        </span>
        

    </div>
    

    {{-- ONLINE / OFFLINE CARD --}}
    <div class="bg-white rounded-2xl shadow-lg p-5 border border-mitti-light">
        <h3 class="text-lg font-semibold text-mitti-dark mb-1">Availability Status</h3>
        <p class="text-gray-600">
            Your current status is:
            <strong class="{{ $partner->online_status == 'online' ? 'text-green-600' : 'text-red-600' }}">
                {{ $partner->online_status == 'online' ? '🟢 Online' : '🔴 Offline' }}
            </strong>
        </p>


        <form action="{{ route('partner.toggleOnline') }}" method="POST" class="mt-4">
            @csrf
            <button 
                class="px-5 py-2 font-medium rounded-lg transition text-white
                {{ $partner->online_status == 'online' 
                    ? 'bg-red-600 hover:bg-red-700' 
                    : 'bg-green-600 hover:bg-green-700' }}">
                {{ $partner->online_status == 'online' ? 'Go Offline' : 'Go Online' }}
            </button>
        </form>
    </div>

    {{-- ACTIVE ORDERS --}}
    <div>
        <h3 class="text-xl font-bold text-mitti-dark mb-3">🚚 Active Deliveries</h3>

        @if($activeOrders->count() > 0)
            @foreach($activeOrders as $order)
            <div class="bg-white rounded-2xl shadow-lg p-5 border border-mitti-light mb-4">

                <p class="text-lg font-semibold text-mitti-primary">Order #{{ $order->order_number }}</p>

                <div class="text-gray-700 mt-2 space-y-1">
                    <p><strong>Customer Name:</strong> {{ $order->name }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>

                    <p><strong>Address:</strong>  
                        {{ $order->address_line }},
                        {{ $order->city }} - {{ $order->pincode }}
                    </p>

                    <p><strong>Your Delivery Charge:</strong>
                        <span class="font-bold text-green-600">₹{{ $order->delivery_charges }}</span>
                    </p>

                    <p><strong>Status:</strong>
                        <span class="px-3 py-1 rounded-full text-white text-sm
                            @if($order->status=='accepted') bg-yellow-600
                            @elseif($order->status=='picked') bg-blue-600
                            @elseif($order->status=='on_the_way') bg-indigo-600
                            @else bg-green-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </p>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="mt-4">
                    @if($order->status=='accepted')
                        <form method="POST" action="{{ route('partner.order.picked', $order->id) }}">
                            @csrf
                            <button class="w-full bg-mitti-primary hover:bg-mitti-dark text-white px-4 py-2 rounded-lg">
                                Mark as Picked
                            </button>
                        </form>

                    @elseif($order->status=='picked')
                        <form method="POST" action="{{ route('partner.order.onTheWay', $order->id) }}">
                            @csrf
                            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                                Mark as On The Way
                            </button>
                        </form>

                    @elseif($order->status=='on_the_way')
                        <form method="POST" action="{{ route('partner.order.delivered', $order->id) }}">
                            @csrf
                            <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                Mark as Delivered
                            </button>
                        </form>
                    @endif
                </div>
@if($order->status == 'on_the_way')
<form action="{{ route('partner.order.verifyOtp', $order->id) }}" method="POST">
    @csrf
    <input type="text" name="otp" placeholder="Enter 6-digit OTP" required
        class="border p-2 rounded w-32">
    <button class="bg-green-600 text-white px-3 py-1 rounded">
        Verify OTP
    </button>
</form>
@endif

            </div>
            @endforeach
        @else
            <p class="text-gray-500">No active orders at the moment.</p>
        @endif
    </div>

    {{-- NEW ORDERS --}}
    <div>
        <h3 class="text-xl font-bold text-mitti-dark mb-3">🆕 New Delivery Requests</h3>

        @if($newOrders->count() > 0)
            @foreach($newOrders as $order)
            <div class="bg-white rounded-2xl shadow-lg border border-mitti-light p-5 mb-4">
                <p class="text-lg font-bold text-mitti-primary">Order #{{ $order->order_number }}</p>

                <div class="text-gray-700 mt-2 space-y-1">
                    <p><strong>Customer:</strong> {{ $order->name }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>

                    <p><strong>Delivery Address:</strong>
                        {{ $order->address_line }},
                        {{ $order->city }} - {{ $order->pincode }}
                    </p>

                    <p><strong>Delivery Charge:</strong>
                        <span class="text-green-600 font-bold">₹{{ $order->delivery_charges }}</span>
                    </p>

                    <p><strong>Order Total:</strong> ₹{{ $order->total }}</p>
                </div>

                @if(is_null($order->partner_id))
    <form action="{{ route('partner.order.accept', $order->id) }}" method="POST" class="mt-4">
        @csrf
        <button class="w-full bg-mitti-primary hover:bg-mitti-dark text-white px-4 py-2 rounded-lg">
            Accept Delivery
        </button>
    </form>
@else
    <button class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed mt-4" disabled>
        Already Accepted
    </button>
@endif

            </div>
            @endforeach
        @else
            <p class="text-gray-500 text-center">No new orders right now.</p>
        @endif
    </div>

</div>

@endsection
