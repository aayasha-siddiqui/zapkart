
@extends('layouts.app')
@section('content')
<h2 class="text-2xl font-bold">Your Cart</h2>

<table class="w-full mt-4">
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
        <th>Remove</th>
    </tr>

    @foreach($cart as $id => $item)
    <tr>
        <td>{{ $item['name'] }}</td>
        <td>{{ $item['quantity'] }}</td>
        <td>{{ $item['price'] }}</td>
        <td>{{ $item['price'] * $item['quantity'] }}</td>

        <td>
            <a href="{{ route('cart.remove', $id) }}"
               class="text-red-500">Remove</a>
        </td>
    </tr>
    @endforeach
</table>

<a href="{{ route('checkout') }}"
   class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded">
   Checkout
</a>
@endsection