<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerRequest;
use App\Models\SellerEarning;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;

class SellerController extends Controller
{
    /* =========================
       USER SIDE
    ========================= */

    // Show Become Seller Form
    public function create()
    {
        $user = auth()->user();

        // Already seller
        if ($user->role === 'seller') {
            return redirect()->back()->with('error', 'You are already a seller.');
        }

        // Already requested
        $exists = SellerRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Your request is already pending.');
        }

        return view('user.seller_request.create');
    }

    // Store Seller Request
    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'gst' => 'nullable|string|max:50',
     
        ]);

        SellerRequest::create([
            'user_id' => auth()->id(),
            'business_name' => $request->business_name,
            'gst' => $request->gst,
           
            'status' => 'pending',
        ]);

       return redirect()->route('seller.request.status')
    ->with('success', 'Seller request sent to admin.');
    }
public function show(User $seller)
{
    // Safety
    if ($seller->role !== 'seller') {
        abort(404);
    }

    // Seller request / profile
    $sellerRequest = SellerRequest::where('user_id', $seller->id)->first();

    // Products
    $products = Product::with('category')
        ->where('seller_id', $seller->id)
        ->get();

    $totalProducts = $products->count();

    // Order Items (seller specific)
    $orderItems = OrderItem::with('order')
        ->where('seller_id', $seller->id)
        ->get();

    $totalOrders = $orderItems->count();

    $deliveredOrders = $orderItems->where('status', 'delivered')->count();

    $cancelledOrders = $orderItems
        ->filter(fn($i) => $i->order->status === 'cancelled')
        ->count();

    // Earnings
    $totalRevenue = SellerEarning::where('seller_id', $seller->id)->sum('total');

    $adminCommission = SellerEarning::where('seller_id', $seller->id)
        ->sum('admin_commission');

    $sellerEarning = SellerEarning::where('seller_id', $seller->id)
        ->sum('seller_amount');

    return view('admin.sellers.show', compact(
        'seller',
        'sellerRequest',
        'products',
        'orderItems',
        'totalProducts',
        'totalOrders',
        'deliveredOrders',
        'cancelledOrders',
        'totalRevenue',
        'adminCommission',
        'sellerEarning'
    ));
}

    /* =========================
       ADMIN SIDE
    ========================= */

    // View all seller requests
    public function index()
    {
        $requests = SellerRequest::with('user')
            ->latest()
            ->get();

        return view('admin.seller_requests.index', compact('requests'));
    }

    // Approve seller
    public function approve($id)
    {
        $request = SellerRequest::findOrFail($id);
        $request->update(['status' => 'approved']);

        $user = User::findOrFail($request->user_id);
        $user->update(['role' => 'seller']);

        return back()->with('success', 'Seller approved successfully.');
    }

    // Reject seller
    public function reject($id)
    {
        SellerRequest::where('id', $id)
            ->update(['status' => 'rejected']);

        return back()->with('error', 'Seller request rejected.');
    }

    /* =========================
       SELLER DASHBOARD
    ========================= */

    public function dashboard()
    {
        $sellerId = auth()->id();

        // Products
        $products = Product::with('category')
            ->where('seller_id', $sellerId)
            ->latest()
            ->get();

        $totalProducts = $products->count();

        // Order Items (seller specific)
        $orderItems = OrderItem::with(['order','product'])
            ->where('seller_id', $sellerId)
            ->get();

        $totalOrders = $orderItems->count();

        $delivered = $orderItems->filter(fn ($i) =>
            $i->status === 'delivered'
        )->count();

        $pending = $orderItems->filter(fn ($i) =>
            in_array($i->order->status, ['placed','accepted','picked','on_the_way'])
        )->count();

        $cancelled = $orderItems->filter(fn ($i) =>
            $i->order->status === 'cancelled'
        )->count();

        // Total Revenue (all)
        $totalRevenue = SellerEarning::where('seller_id', $sellerId)
            ->sum('seller_amount');

        $categories = Category::all();

        return view('seller.dashboard', compact(
            'products',
            'categories',
            'orderItems',
            'totalProducts',
            'totalOrders',
            'delivered',
            'pending',
            'cancelled',
            'totalRevenue'
        ));
    }

    /* =========================
       SELLER ORDER DELIVERY
    ========================= */

    public function markDelivered($id)
    {
        $item = OrderItem::with('order')
            ->where('id', $id)
            ->where('seller_id', auth()->id())
            ->firstOrFail();

        // Item delivered
        $item->update(['status' => 'delivered']);

        // Check if all items delivered
        $allDelivered = OrderItem::where('order_id', $item->order_id)
            ->where('status', '!=', 'delivered')
            ->doesntExist();

        if ($allDelivered) {
            $item->order->update(['status' => 'delivered']);
        }

        // COD earning (safe)
        if ($item->order->payment_method === 'cod') {

            $adminCommission = $item->total * 0.10;
            $sellerAmount   = $item->total * 0.90;

            SellerEarning::firstOrCreate(
                ['order_item_id' => $item->id],
                [
                    'seller_id' => $item->seller_id,
                    'order_id' => $item->order_id,
                    'total' => $item->total,
                    'admin_commission' => $adminCommission,
                    'seller_amount' => $sellerAmount,
                    'status' => 'pending'
                ]
            );
        }

        return back()->with('success', 'Order delivered successfully.');
    }
}
