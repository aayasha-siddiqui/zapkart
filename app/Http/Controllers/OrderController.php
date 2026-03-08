<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // show all orders of logged-in user
    public function index()
    {
        $orders = Order::with('items.product')
                    ->where('user_id', auth()->id())
                    ->get();

        return view('orders', compact('orders'));
    }

    // cancel order
    public function cancel($id)
    {
        $order = Order::where('id', $id)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        if ($order->status == 'placed') {
            $order->status = 'cancelled';
            $order->save();
        }

        return back()->with('success', 'Order cancelled successfully');
    }
}
