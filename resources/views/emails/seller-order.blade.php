<!DOCTYPE html>
<html>
<body style="font-family: Arial">

<h2>Hello {{ $seller->name }},</h2>

<p>
🛒 You have received a <strong>new order</strong> for your products.
</p>

<p>
<strong>Order ID:</strong> {{ $order->order_number }} <br>
<strong>Tracking ID:</strong> {{ $order->awb }}
</p>

<h3>📦 Ordered Products</h3>

<table width="100%" border="1" cellpadding="8">
<tr>
    <th>Product</th>
    <th>Qty</th>
    <th>Price</th>
</tr>

@foreach($items as $item)
<tr>
    <td>{{ $item->product->name }}</td>
    <td align="center">{{ $item->quantity }}</td>
    <td align="center">₹{{ $item->price }}</td>
</tr>
@endforeach
</table>

<p>
Please prepare the items for dispatch.
</p>

<p>
Regards,<br>
<strong>{{ config('app.name') }}</strong>
</p>

</body>
</html>
