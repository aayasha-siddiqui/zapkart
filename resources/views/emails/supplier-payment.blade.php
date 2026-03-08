<h2>Payment Successful</h2>

<p>Hello {{ $supplier->name }},</p>

<p>
Admin has successfully purchased products from you.
Payment has been completed.
</p>

<h4>Purchased Products:</h4>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>

    @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>₹{{ $product->price }}</td>
            <td>{{ $product->qty ?? 1 }}</td>
            <td>₹{{ $product->price * ($product->qty ?? 1) }}</td>
        </tr>
    @endforeach
</table>

<p><b>Total Amount Paid:</b> ₹{{ $totalAmount }}</p>

<p>
Thank you for doing business with Zapkart.
</p>

<p>Regards,<br>Zapkart Team</p>
