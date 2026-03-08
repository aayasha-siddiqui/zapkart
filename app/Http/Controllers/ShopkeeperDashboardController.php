<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
class ShopkeeperDashboardController extends Controller
{
    

public function dashboard(Request $request)
{
    $shopkeeperId = auth()->id();

    /* =========================
       FILTER INPUTS
    ========================= */
    $search   = $request->search;
    $category = $request->category;
    $month    = $request->month;

    /* =========================
       ASSIGNED PRODUCTS QUERY
    ========================= */
    $productsQuery = Product::whereIn('id', function ($q) use ($shopkeeperId) {
        $q->select('product_id')
          ->from('shopkeeper_products')
          ->where('shopkeeper_id', $shopkeeperId);
    })->with('category');

    // 🔍 SEARCH FILTER
    if ($search) {
        $productsQuery->where('name', 'ILIKE', "%{$search}%"); // pgsql safe
    }

    // 🏷 CATEGORY FILTER
    if ($category) {
        $productsQuery->where('category_id', $category);
    }

    // 📅 MONTH FILTER
    if ($month) {
        $productsQuery->whereMonth('created_at', $month);
    }

    $products = $productsQuery->latest()->get();
    $totalProducts = $products->count();

    /* =========================
       ORDERS
    ========================= */
    $ordersQuery = Order::where('user_id', $shopkeeperId);

    if ($month) {
        $ordersQuery->whereMonth('created_at', $month);
    }

    $orders = $ordersQuery->latest()->get();

    $totalOrders   = $orders->count();
    $pendingOrders = $orders->where('status','placed')->count();
    $totalPurchase = $orders->sum('total');
    $recentOrders  = $orders->take(5);

    /* =========================
       NEW ASSIGNED PRODUCTS
    ========================= */
    $newAssignedProducts = Product::whereIn('id', function ($q) use ($shopkeeperId) {
            $q->select('product_id')
              ->from('shopkeeper_products')
              ->where('shopkeeper_id', $shopkeeperId)
              ->where('created_at', '>=', now()->subDay());
        })
        ->latest()
        ->take(5)
        ->get();
          $chartDataRaw = Order::selectRaw(
            'COUNT(*) as count, EXTRACT(MONTH FROM created_at) as month'
        )
        ->where('user_id', $shopkeeperId)
        ->groupByRaw('EXTRACT(MONTH FROM created_at)')
        ->pluck('count', 'month');

    $monthsMap = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    $chartLabels = [];
    $chartData   = [];

    foreach ($chartDataRaw as $month => $count) {
        $chartLabels[] = $monthsMap[$month - 1];
        $chartData[]   = $count;
    }

    $newAssignedCount = $newAssignedProducts->count();

    /* =========================
       CATEGORY LIST (FOR FILTER)
    ========================= */
    $categories = DB::table('categories')->select('id','name')->get();

    return view('shopkeeper.dashboard', compact(
        'products',
        'totalProducts',
        'totalOrders',
        'pendingOrders',
        'totalPurchase',
        'recentOrders',
        'newAssignedProducts',
        'newAssignedCount',
        'categories',
   'chartLabels',
        'chartData'
    ));
}
}