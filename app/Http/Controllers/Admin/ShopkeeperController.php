<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ShopkeeperController extends Controller
{
    // =========================
    // ADMIN: SHOPKEEPER OVERVIEW
    // =========================
  public function overviewAll()
{
    $shopkeepers = DB::table('users')
        ->where('role', 'shopkeeper')
        ->get();

    foreach ($shopkeepers as $shopkeeper) {

        // total orders (rows)
        $shopkeeper->totalOrders = DB::table('shopkeeper_products')
            ->where('shopkeeper_id', $shopkeeper->id)
            ->count();

        // total purchased qty
        $shopkeeper->totalQty = DB::table('shopkeeper_products')
            ->where('shopkeeper_id', $shopkeeper->id)
            ->sum('qty');

        // product-wise detail
        $shopkeeper->products = DB::table('shopkeeper_products')
            ->join('products', 'products.id', '=', 'shopkeeper_products.product_id')
            ->where('shopkeeper_products.shopkeeper_id', $shopkeeper->id)
            ->select(
                'products.name',
                DB::raw('SUM(shopkeeper_products.qty) as total_qty')
            )
            ->groupBy('products.name')
            ->get();
    }

    return view('admin.shopkeepers.overview', compact('shopkeepers'));
}





    // =========================
    // CREATE SHOPKEEPER
    // =========================
    public function create()
    {
        return view('admin.shopkeepers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'shopkeeper',
        ]);

        return back()->with('success','Shopkeeper created successfully');
    }

    // =========================
    // SHOPKEEPER DASHBOARD
    // =========================
    public function dashboard()
    {
        $shopkeeperId = auth()->id();

        $products = Product::whereIn('id', function ($q) use ($shopkeeperId) {
            $q->select('product_id')
              ->from('shopkeeper_products')
              ->where('shopkeeper_id', $shopkeeperId);
        })
        ->with('category')
        ->get();

        return view('shopkeeper.dashboard', [
            'products'       => $products,
            'totalProducts'  => $products->count(),
            'totalOrders'    => Order::where('shopkeeper_id',$shopkeeperId)->count(),
        ]);
    }
}
