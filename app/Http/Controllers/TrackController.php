<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackController extends Controller
{
    public function form()
    {
        return view('track.form');
    }

    public function track(Request $request)
    {
        $request->validate(['awb' => 'required']);
        $order = Order::where('awb', $request->awb)->first();
        if (!$order) return back()->with('error', 'Invalid Tracking ID');

        return view('track.result', $this->buildTracking($order));
    }

    public function direct($awb)
    {
        $order = Order::where('awb', $awb)->firstOrFail();
        return view('track.result', $this->buildTracking($order));
    }

    // -------------------------------------------------------------
    // 🔥 MAIN TRACKING LOGIC (FINAL FIXED)
    // -------------------------------------------------------------
    private function buildTracking($order)
    {
        // give random_offset only once
        if ($order->random_offset == null || $order->random_offset == 0) {
            $order->random_offset = rand(3, 30);
            $order->save();
        }

        // Important: hours passed + offset (FIX)
        $hoursPassed = now()->diffInHours($order->created_at);
        $progress = $hoursPassed + $order->random_offset;

        // Timeline stages (hour when stage unlocks)
        $stages = [
            ['label' => 'Placed',           'hour' => 0],
            ['label' => 'Confirmed',        'hour' => 5],
            ['label' => 'Packed',           'hour' => 12],
            ['label' => 'Shipped',          'hour' => 24],
            ['label' => 'In Transit',       'hour' => 36],
            ['label' => 'Out for Delivery', 'hour' => 48],
            ['label' => 'Delivered',        'hour' => 60],
        ];

        // decide which stage customer is on (FIX)
        $currentIndex = 0;
        foreach ($stages as $i => $s) {
            if ($progress >= $s['hour']) {
                $currentIndex = $i;
            }
        }
        $currentStatus = $stages[$currentIndex]['label'];

        // build timeline array for UI (FIX)
        $timeline = [];
        foreach ($stages as $i => $s) {
            $timeline[] = [
                'label' => $s['label'],
                'time'  => $order->created_at->copy()->addHours($s['hour'])->format('d M h:i A'),
                'done'  => $i <= $currentIndex,
            ];
        }

        // Route (Delhi start → 3–6 hubs → user address)
        $hubs = [
            "Delhi Hub",
            "Gurgaon Facility",
            "Noida Center",
            "Agra Warehouse",
            "Mathura Transit",
            "Ghazipur Delhi",
            "Kanpur Sort Center",
            "Jaipur Hub",
            "Lucknow Dispatch",
        ];

        shuffle($hubs);

        // create unique route
        $routeRaw = array_slice($hubs, 0, rand(3, 6));

        $route = array_merge(
            ["Delhi"],      // always start
            $routeRaw,      // random hubs
            [$order->address] // final
        );

        // mark which location completed based on stage (FIX)
        $routeCompletedUntil = min($currentIndex, count($route) - 1);

        $routeList = [];
        foreach ($route as $i => $place) {
            $routeList[] = [
                'place' => $place,
                'done'  => $i <= $routeCompletedUntil,
                'time'  => $order->created_at->copy()->addHours($i * 8)->format('d M h:i A'),
            ];
        }

        // Fake distance + ETA
        $distance = rand(5, 60);
        $etaDays = ($distance <= 20) ? 1 : 2;

        return [
            'order'     => $order,
            'status'    => $currentStatus,
            'timeline'  => $timeline,
            'routeList' => $routeList,
            'distance'  => $distance,
            'etaDays'   => $etaDays,
        ];
    }
}
