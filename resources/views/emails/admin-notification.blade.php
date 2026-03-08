<h2>{{ ucfirst(str_replace('_',' ', $type)) }}</h2>

@if($type == 'seller_request')
    <p>🧑‍💼 New Seller Request</p>
    <p>Name: {{ $data['name'] }}</p>
    <p>Email: {{ $data['email'] }}</p>

@elseif($type == 'partner_request')
    <p>🚚 New Delivery Partner Request</p>
    <p>Name: {{ $data['name'] }}</p>
    <p>City: {{ $data['city'] }}</p>

@elseif($type == 'supplier_product')
    <p>📦 Supplier Added Product</p>
    <p>Supplier: {{ $data['supplier'] }}</p>
    <p>Product: {{ $data['product'] }}</p>

@elseif($type == 'order')
    <p>🛒 New Order Placed (Seller Product)</p>

    <p>Order ID: {{ $data['order_number'] }}</p>
    <p>Seller: {{ $data['seller'] }}</p>
    <p>Order Amount: ₹{{ $data['total'] }}</p>

    <hr>

    <p><strong>Admin Commission (10%): ₹{{ $data['commission'] }}</strong></p>
@endif
