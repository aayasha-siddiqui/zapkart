<h2>Hello {{ $partner->full_name }}</h2>

{{-- APPROVED --}}
@if($type === 'approved')
    <p>🎉 <b>Congratulations!</b></p>
    <p>Your delivery partner request has been <b>approved</b>.</p>

    <p><b>Partner ID:</b> {{ $partner->partner_code }}</p>
    <p>You can now login and start accepting orders.</p>

    <a href="{{ url('/login') }}">Login Now</a>

{{-- REJECTED --}}
@elseif($type === 'rejected')
    <p>❌ Your delivery partner request has been <b>rejected</b>.</p>
    <p>You may re-apply after some time.</p>

{{-- NEW ORDER --}}
@elseif($type === 'new_order')
    <p>🚚 <b>New Order Available</b></p>

    <p><b>Order No:</b> {{ $order->order_number }}</p>
    <p><b>Delivery Address:</b> {{ $order->address_line }}, {{ $order->city }}</p>
    <p><b>Delivery Charges:</b> ₹{{ $order->delivery_charges }}</p>

    <p>Please login to accept this order.</p>

    <a href="{{ url('/partner/dashboard') }}">Go to Dashboard</a>
@endif
