<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class ShipRocketService
{
    private $token;

    public function __construct()
    {
        $this->token = $this->getToken();
    }

    /**
     * LOGIN & GET SHIPROCKET TOKEN
     */
    private function getToken()
    {
        $response = Http::post("https://apiv2.shiprocket.in/v1/external/auth/login", [
            "email" => "ayesha.api@gmail.com",
            "password" => "xxxxxxxxx"
        ]);

        $json = $response->json();

        // Debug if needed
        // dd($json);

        // If login failed
        if (!$response->successful()) {
            throw new Exception("Shiprocket login failed: " . json_encode($json));
        }

        // Some accounts return token as "token"
        if (isset($json['token'])) {
            return $json['token'];
        }

        // Some accounts return token inside "data"
        if (isset($json['data']['token'])) {
            return $json['data']['token'];
        }

        // If still missing → throw error
        throw new Exception("Shiprocket token missing: " . json_encode($json));
    }

    /**
     * CREATE ORDER IN SHIPROCKET
     */
    public function createOrder($order, $address)
    {
        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                "name"          => $item->product->name,
                "sku"           => $item->product->id,
                "units"         => $item->quantity,
                "selling_price" => $item->price,
            ];
        }

        $data = [
            "order_id"               => $order->order_number,
            "order_date"             => now()->toDateTimeString(),
            "pickup_location"        => "Default",

            "billing_customer_name"  => $address->name,
            "billing_address"        => $address->address_line,
            "billing_city"           => $address->city,
            "billing_pincode"        => $address->pincode,
            "billing_state"          => "Rajasthan",
            "billing_country"        => "IN",
            "billing_phone"          => $address->phone,

            "shipping_is_billing"    => true,

            "order_items"            => $items,

            "payment_method"         => $order->payment_method === "cod" ? "COD" : "Prepaid",
            "sub_total"              => $order->total,
        ];

        // SEND ORDER TO SHIPROCKET API
        $response = Http::withToken($this->token)
            ->post("https://apiv2.shiprocket.in/v1/external/orders/create/adhoc", $data);

        return $response->json();
    }
}
