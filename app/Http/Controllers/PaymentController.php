<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Fetch the payment from Razorpay
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if ($payment['status'] == 'captured') {
            // Find the order using razorpay_order_id
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if ($order) {
                // Update payment_status and store payment_id
                $order->update([
                    'payment_status' => 'paid',  // Correct field
                    'payment_id' => $payment->id,
                    'status' => 'placed',        // Keep order status as placed
                ]);

                // Return JSON response for AJAX redirect
                return response()->json([
                    'success' => true,
                    'redirect' => route('order.success', $order->id)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found!'
                ]);
            }
        }

        // Payment failed
        return response()->json([
            'success' => false,
            'message' => 'Payment failed!'
        ]);
    }
}