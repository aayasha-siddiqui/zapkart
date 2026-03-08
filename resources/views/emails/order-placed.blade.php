<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmed</title>
</head>
<body style="font-family: Arial; background:#f7f7f7; padding:20px;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<table width="600" style="background:#ffffff; padding:20px;">

<tr>
<td>
<h2 style="color:#2c3e50;">Hi {{ $order->user->name }},</h2>

<p>
Your order has been <strong>successfully placed</strong> 🎉  
You can track your order using the details below.
</p>

<hr>

<h3>📦 Order Summary</h3>

<p>
<strong>Order ID:</strong> {{ $order->order_number }} <br>
<strong>Tracking ID (AWB):</strong> {{ $order->awb ?? 'Will be assigned soon' }} <br>
<strong>Order Status:</strong> {{ ucfirst($order->status) }} <br>
<strong>Payment:</strong> {{ ucfirst($order->payment_method) }} ({{ ucfirst($order->payment_status) }})
</p>

<hr>

<h3>🚚 Delivery Partner</h3>

@if($order->partner)
    <p>
        <strong>Name:</strong> {{ $order->partner->full_name }} <br>
        <strong>Phone:</strong> {{ $order->partner->phone }} <br>
        <strong>Partner ID:</strong> {{ $order->partner->partner_code }}
    </p>
@else
    <p>Delivery partner will be assigned soon.</p>
@endif

<hr>

<h3>🧾 Items Ordered</h3>

<table width="100%" border="1" cellspacing="0" cellpadding="8">
<tr>
    <th align="left">Product</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Total</th>
</tr>

@foreach($order->items as $item)
<tr>
    <td>{{ $item->product->name ?? 'Product' }}</td>
    <td align="center">{{ $item->qty }}</td>
    <td align="center">₹{{ $item->price }}</td>
    <td align="center">₹{{ $item->total }}</td>
</tr>
@endforeach
</table>

<br>

<p>
<strong>Subtotal:</strong> ₹{{ $order->subtotal }} <br>
<strong>Delivery Charges:</strong> ₹{{ $order->delivery_charges }} <br>
<strong>Total Paid:</strong> <strong>₹{{ $order->total }}</strong>
</p>

<hr>

<h3>📍 Delivery Address</h3>

<p>
{{ $order->address_line }} <br>
{{ $order->city }} - {{ $order->pincode }}
</p>

<hr>

<h3>📡 Tracking Timeline</h3>

<p>
✔ Order Placed <br>
{{ $order->partner ? '✔ Partner Assigned' : '⏳ Partner Assignment Pending' }} <br>
⏳ Out for
