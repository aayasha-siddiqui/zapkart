<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

use App\Models\SellerEarning;
use App\Mail\SellerOrderMail;
use App\Models\DeliveryPartner;
use App\Mail\AdminNotificationMail;
use App\Mail\PartnerNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;
use App\Models\User;



class CheckoutController extends Controller
{
  public function getStaticDistance($city, $pincode)
{
    $city = strtolower(trim($city));

    // Ganganagar city inside
    if ($city == 'ganganagar' || $city == 'sri ganganagar' || $pincode == "335001") {
        return 3; // 3 km
    }

    // Near by areas
    if (in_array($pincode, ["335002", "335003", "335004"])) {
        return 5; // 5 km
    }

    // Default
    return 8; // 8 km for far places
}



public function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371;

    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;

    $a = sin($dlat/2) * sin($dlat/2) +
         cos($lat1) * cos($lat2) *
         sin($dlon/2) * sin($dlon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    return $earthRadius * $c;
}

    public function index()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        $recommended = Product::latest()->take(5)->get();

        if ($carts->count() == 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        return view('checkout', compact('carts', 'recommended'));
    }

  public function placeOrder(Request $request)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'city' => 'required',
        'pincode' => 'required',
        'payment_method' => 'required'
    ]);

    $carts = Cart::with('product')
    ->where('user_id', auth()->id())
    ->get();
/* -----------------------------------------
   🔐 STOCK CHECK (SHOPKEEPER)
------------------------------------------*/
if (auth()->user()->role === 'shopkeeper') {

    foreach ($carts as $cart) {

        $stock = DB::table('shopkeeper_products')
            ->where('shopkeeper_id', auth()->id())
            ->where('product_id', $cart->product_id)
            ->value('qty');

        if ($stock === null || $stock < $cart->quantity) {
            return back()->with(
                'error',
                "Stock not available for {$cart->product->name}"
            );
            
        }
    }
}

// 🔐 SHOPKEEPER SAFETY CHECK
if (auth()->user()->role === 'shopkeeper') {

    $assignedProductIds = DB::table('shopkeeper_products')
        ->where('shopkeeper_id', auth()->id())
        ->pluck('product_id')
        ->toArray();

    foreach ($carts as $cart) {
        if (!in_array($cart->product_id, $assignedProductIds)) {
            return back()->with(
                'error',
                'You are not allowed to order unassigned products.'
            );
        }
    }
}


    $subtotal = $carts->sum(fn($item) => $item->product->price * $item->quantity);

    /* -----------------------------------------
       STATIC DISTANCE SYSTEM (NO API)
    ------------------------------------------*/
    $distance = $this->getStaticDistance($request->city, $request->pincode);

    // Delivery charges = ₹10 per km
    $delivery = $distance * 10;

    $total = $subtotal + $delivery;

    /* -----------------------------------------
       COD ORDER
    ------------------------------------------*/
    if ($request->payment_method == 'cod') {

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD' . time(),

            'name' => $request->name,
            'phone' => $request->phone,
            'address_line' => $request->address,
            'city' => $request->city,
            'pincode' => $request->pincode,

            'subtotal' => $subtotal,
            'delivery_charges' => $delivery,
            'total' => $total,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'status' => 'placed',
            'awb' => 'ZEP' . rand(10000000, 99999999),
        ]);

        foreach ($carts as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'seller_id' => $item->product->seller_id,
                'total' => $item->product->price * $item->quantity
            ]);
        }
// 🔻 STOCK MINUS (SHOPKEEPER)
if (auth()->user()->role === 'shopkeeper') {
    DB::table('shopkeeper_products')
        ->where('shopkeeper_id', auth()->id())
        ->where('product_id', $item->product_id)
        ->decrement('qty', $item->quantity);
}
else {
        Product::where('id', $item->product_id)
            ->decrement('qty', $item->quantity);
    }

        Cart::where('user_id', auth()->id())->delete();

// SEND MAIL
$order = Order::with(['items.product','user','partner'])->find($order->id);
Mail::to($order->user->email)->send(new OrderPlacedMail($order));
// reload order with relations
$order = Order::with(['items.product','user'])->find($order->id);

// 🔔 SEND MAIL TO ALL ONLINE + APPROVED PARTNERS
$partners = DeliveryPartner::where('status', 'approved')
    ->where('online_status', 'online')
    ->with('user')
    ->get();

foreach ($partners as $partner) {
    if ($partner->user && $partner->user->email) {
        Mail::to($partner->user->email)->send(
            new PartnerNotificationMail('new_order', $partner, $order)
        );
        foreach ($order->items as $item) {

    if ($item->seller_id) {

        $commission = $item->total * 0.10;

        Mail::to(env('ADMIN_EMAIL'))->send(
            new AdminNotificationMail(
                'Seller Product Order',
                [
                    'order_no'   => $order->order_number,
                    'seller_id'  => $item->seller_id,
                    'product'    => $item->product->name,
                    'total'      => $item->total,
                    'commission' => $commission
                ]
            )
        );
    }
}

    }
}




// group items by seller
$sellerItems = $order->items->groupBy('seller_id');

foreach ($sellerItems as $sellerId => $items) {

    if (!$sellerId) continue;

    $seller = User::find($sellerId);

    Mail::to($seller->email)->send(
        new SellerOrderMail($seller, $items, $order)
    );
}


return response()->json([
    "success" => true,
    "redirect" => route('order.success', $order->id)
]);

    }

    /* -----------------------------------------
       ONLINE PAYMENT
    ------------------------------------------*/
    if (strtolower(trim($request->payment_method)) == "online") {

        $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $razorpayOrder = $api->order->create([
            'receipt' => 'rcpt_' . time(),
            'amount' => $total * 100,
            'currency' => 'INR'
        ]);

        session([
            'checkout_data' => [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'pincode' => $request->pincode,

                'total' => $total,
                'subtotal' => $subtotal,
                'delivery' => $delivery,
                'razorpay_order_id' => $razorpayOrder['id']
            ]
        ]);

        return response()->json([
            "success" => true,
            "online" => true,
            "order_id" => $razorpayOrder['id'],
            "amount" => $total * 100,
            "key" => env('RAZORPAY_KEY')
        ]);
    }
}




    public function paymentSuccess(Request $request)
    {
        $data = session('checkout_data');
        if (!$data)
            return response()->json(['success' => false, 'message' => 'Session expired!']);

        // CREATE ORDER
        $order = Order::create([
            'user_id' => auth()->id(),


            'order_number' => 'ORD' . time(),

            // ADDRESS SNAPSHOT SAVE
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address_line' => $data['address'],
            'city' => $data['city'],
            'pincode' => $data['pincode'],

            'subtotal' => $data['subtotal'],
            'delivery_charges' => $data['delivery'],
            'total' => $data['total'],
            'payment_method' => 'online',
            'payment_status' => 'paid',
            'status' => 'placed',
            'razorpay_order_id' => $data['razorpay_order_id'],
            'razorpay_payment_id' => $request->razorpay_payment_id ?? null,
            'awb' => 'ZEP' . rand(10000000, 99999999),
        ]);

        // ORDER ITEMS
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        foreach ($carts as $item) {

    // ✅ orderItem ko variable me store karo
    $orderItem = OrderItem::create([
        'order_id'   => $order->id,
        'product_id' => $item->product_id,
        'quantity'   => $item->quantity,
        'seller_id'  => $item->product->seller_id,
        'price'      => $item->product->price,
        'total'      => $item->product->price * $item->quantity
    ]);
    // 🔻 STOCK MINUS (SHOPKEEPER)
if (auth()->user()->role === 'shopkeeper') {
    DB::table('shopkeeper_products')
        ->where('shopkeeper_id', auth()->id())
        ->where('product_id', $item->product_id)
        ->decrement('qty', $item->quantity);
}
else {
        Product::where('id', $item->product_id)
            ->decrement('qty', $item->quantity);
    }


    // ✅ ab variable exist karta hai
    if ($orderItem->seller_id) {

        $adminCommission = $orderItem->total * 0.10;
        $sellerAmount   = $orderItem->total * 0.90;

        SellerEarning::create([
            'seller_id'        => $orderItem->seller_id,
            'order_id'         => $order->id,
            'order_item_id'    => $orderItem->id,
            'total'            => $orderItem->total,
            'admin_commission' => $adminCommission,
            'seller_amount'    => $sellerAmount,
            'status'           => 'pending'
        ]);
    
    }
        }

        // CLEAR
        Cart::where('user_id', auth()->id())->delete();
        session()->forget('checkout_data');
// 🔔 SEND ORDER CONFIRMATION MAIL (ONLINE)
$order = Order::with([
    'items.product',
    'user',
    'partner'
])->find($order->id);

Mail::to($order->user->email)->send(
    new OrderPlacedMail($order)
);
// 🔔 SEND MAIL TO DELIVERY PARTNERS (ONLINE PAYMENT)
$partners = DeliveryPartner::where('status', 'approved')
    ->where('online_status', 'online')
    ->with('user')
    ->get();

foreach ($partners as $partner) {
    if ($partner->user && $partner->user->email) {
        Mail::to($partner->user->email)->send(
            new PartnerNotificationMail('new_order', $partner, $order)
        );
    }
}


        return response()->json([
            'success' => true,
            'redirect' => route('order.success', $order->id)
        ]);
    }


    public function success($id)
    {
  $order = Order::with(['items.product.category'])->findOrFail($id);

        return view('order-success', compact('order'));
    }
}
