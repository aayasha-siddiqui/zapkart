<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /* =====================
       ADMIN DASHBOARD
    ===================== */
    public function dashboard()
    {
        $today = now()->toDateString();

        $shopkeeperOrders = Order::whereNotNull('shopkeeper_id');

        return view('admin.dashboard', [
            'todaysOrders' => (clone $shopkeeperOrders)
                ->whereDate('created_at', $today)
                ->count(),

            'todaysRevenue' => (clone $shopkeeperOrders)
                ->whereDate('created_at', $today)
                ->sum('total'),

            'totalShopkeepers' => User::where('role','shopkeeper')->count(),

            'totalAssignedProducts' => DB::table('shopkeeper_products')->count(),

            'recentOrders' => (clone $shopkeeperOrders)
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    /* =====================
       ASSIGN PRODUCTS FORM
    ===================== */
    public function assignProductsForm()
    {
        $shopkeepers = User::where('role','shopkeeper')->get();
        $products = Product::with('category')->get();

        return view('admin.assign-products', compact('shopkeepers','products'));
    }

    /* =====================
       SAVE ASSIGNED PRODUCTS
    ===================== */
    public function assignProductsStore(Request $request)
    {
        $request->validate([
            'shopkeeper_id' => 'required|exists:users,id',
            'products'      => 'required|array',
        ]);

        // purane assignments delete
       // purane assignments delete
DB::table('shopkeeper_products')
    ->where('shopkeeper_id', $request->shopkeeper_id)
    ->delete();

// naye assignments
foreach ($request->products as $productId => $data) {

    // qty empty ho to skip
    if (empty($data['qty'])) {
        continue;
    }

    DB::table('shopkeeper_products')->insert([
        'shopkeeper_id' => $request->shopkeeper_id,
        'product_id'    => $productId,      // ✅ KEY is product id
        'qty'           => (int) $data['qty'], // ✅ qty value
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);
}


        return back()->with('success','Products assigned successfully');
    }
}
