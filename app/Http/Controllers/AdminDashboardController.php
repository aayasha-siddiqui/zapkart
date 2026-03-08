<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Mail\PartnerNotificationMail;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Product;
use App\Models\SellerEarning;
use App\Mail\SupplierAddedMail;
use Carbon\Carbon;
use App\Mail\SupplierPaymentMail;
use App\Mail\SellerApprovedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\DeliveryPartner;
use App\Models\SellerRequest;
use App\Models\Supplier;
use App\Models\SupplierCategory;
use App\Models\SupplierProduct;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Mail\AdminNotificationMail;

class AdminDashboardController extends Controller

{
           public function index()
{
    // TOTAL ORDERS
    $totalOrders = Order::
    whereHas('items', function ($q) {
        $q->whereNull('seller_id');
    })->count();
    $totalProducts = Product::count();
$allCategories = Category::all();

$allProducts = Product::all();
$SellerRequests  = \App\Models\SellerRequest::where('status','approved')->count();
// 🔴 PENDING REQUEST COUNTS
$pendingSellerRequests  = \App\Models\SellerRequest::where('status','pending')->count();
$pendingPartnerRequests = \App\Models\DeliveryPartner::where('status','pending')->count();
$TotalSupplier = \App\Models\Supplier::count();

// 🔴 SUPPLIER PRODUCTS (pending approval / new)
$newSupplierProducts = \App\Models\SupplierProduct::where('status','available')->count();

// 🔴 SELLER ORDERS (commission)
$sellerOrderItems = \App\Models\OrderItem::whereNotNull('seller_id')
    ->whereHas('order', function ($q) {
        $q->where('status','placed');
    })->get();

$totalSellerOrders = $sellerOrderItems->count();

$totalCommission = SellerEarning::sum('admin_commission');


$latestSeller = SellerRequest::where('status', 'pending')->latest()->first();


    // STATUS COUNTS
 $deliveredOrders = Order::where('status', 'delivered')
    ->whereHas('items', function ($q) {
        $q->whereNull('seller_id');
    })
    ->count();

 $cancelledOrders = Order::where('status', 'cancelled')
    ->whereHas('items', function ($q) {
        $q->whereNull('seller_id');
    })
    ->count();

   $pendingOrders = Order::where('status', 'placed')
    ->whereHas('items', function ($q) {
        $q->whereNull('seller_id');
    })
    ->count();
$totalBuyerReview = 4.2; 

    // AMOUNTS
    $pendingPartners = DeliveryPartner::where('status', 'pending')->count();
$approvedPartners = DeliveryPartner::where('status', 'approved')->count();

    $totalRevenue    = Order::sum('total');
    $deliveredAmount = Order::where('status', 'delivered')->sum('total');
    $pendingAmount   = Order::where('status', 'placed')->sum('total');
    $cancelAmount    = Order::where('status', 'cancelled')->sum('total');
    $onlinePartners = DeliveryPartner::where('online_status', 'online')->count();
$offlinePartners = DeliveryPartner::where('online_status', 'offline')->count();

$latestPartner = DeliveryPartner::latest()->first();

    // ✅ TOTAL CATEGORIES
    $totalCategories = Category::count();

    // MONTHLY CHART DATA
    $months = [];
    $monthlyRevenue = [];
    $monthlyOrders = [];

    for ($i = 5; $i >= 0; $i--) {
        $monthName = now()->subMonths($i)->format('M');

        $months[] = $monthName;

        $monthlyRevenue[] = Order::whereMonth('created_at', now()->subMonths($i)->month)
            ->sum('total');

        $monthlyOrders[] = Order::whereMonth('created_at', now()->subMonths($i)->month)
            ->count();
    }
$buyers = User::where('role','shopkeeper')->get();
$totalBuyers = $buyers->count();

    // RECENT ORDERS
    $recentOrders = Order::with(['user', 'items'])
        ->latest()
        ->take(10)
        ->get();

    return view('admin.dashboard', compact(
        'totalOrders',
        'deliveredOrders',
        'cancelledOrders',
        'pendingOrders',
        'latestSeller',
        'TotalSupplier',
        'totalRevenue',
         'SellerRequests',
    'pendingPartnerRequests',
    'totalBuyerReview',
    'newSupplierProducts',
    'totalSellerOrders',
    'totalCommission',
        'deliveredAmount',
        'pendingAmount',
        'cancelAmount',
        'totalBuyers',
'buyers',

        'months',
        'monthlyRevenue',
        'monthlyOrders',
        'recentOrders',
        'totalCategories',
        'totalProducts',
        'allCategories',
        'allProducts',
        'pendingPartners',
'approvedPartners',
  'latestPartner',
  'onlinePartners',
    'offlinePartners'
    


         // 👈 NEW VARIABLE
    ));
}
public function bulkPayNow(Request $request)
{
    $selectedProducts = collect($request->products)
        ->filter(fn ($p) => isset($p['selected']))
        ->mapWithKeys(fn ($p, $id) => [$id => $p['qty'] ?? 1]);

    if ($selectedProducts->isEmpty()) {
        return back()->with('error', 'Please select at least one product');
    }

    $products = SupplierProduct::whereIn('id', $selectedProducts->keys())
        ->with('supplier')
        ->get();

    $grouped = $products->groupBy('supplier_id');

    foreach ($grouped as $supplierId => $supplierProducts) {

        $supplier = $supplierProducts->first()->supplier;
        $totalAmount = 0;

        foreach ($supplierProducts as $sp) {

            $qty = $selectedProducts[$sp->id];
            $totalAmount += $sp->price * $qty;

            // Supplier Category
            $sc = SupplierCategory::find($sp->supplier_category_id);

            // Main Category
           $category = Category::where('name', $sc->name)->first();

$category = Category::firstOrCreate(
    ['name' => $sc->name],
    ['image' => $sc->image]
);

            // Mark product paid
            $sp->update([
                'payment_status' => 'paid',
                'status'         => 'sold',
            ]);

            // Add to warehouse with quantity
            Product::create([
                'name'        => $sp->name,
                'price'       => $sp->price,
                'description' => $sp->description,
                'image'       => $sp->image,
                'category_id' => $category->id,
                'source'      => 'supplier',
                'supplier_id' => $sp->supplier_id,
                'qty'         => $qty,   // 🔥 IMPORTANT
            ]);
        }

        // Mail supplier
        Mail::to($supplier->email)->send(
            new SupplierPaymentMail($supplier, $supplierProducts, $totalAmount)
        );
    }

    return back()->with('success', 'Products purchased successfully');
}


public function storeSupplier(Request $request)
{
    $request->validate([
        'name'          => 'required',
        'business_name' => 'required',
        'phone'         => 'required',
        'email'         => 'required|email|unique:users',
    ]);

    // 1️⃣ Generate Supplier ID (Password bhi yahi hoga)
    $supplierCode = 'SUP-' . str_pad(Supplier::count() + 1, 4, '0', STR_PAD_LEFT);

    // 2️⃣ Create USER (Supplier login account)
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'password' => bcrypt($supplierCode), // ✅ PASSWORD = SUPPLIER ID
        'role'     => 'supplier',
    ]);

    // 3️⃣ Create SUPPLIER profile
    $supplier = Supplier::create([
        'supplier_code' => $supplierCode,
        'user_id'       => $user->id,
        'name'          => $request->name,
        'business_name' => $request->business_name,
        'phone'         => $request->phone,
        'email'         => $request->email,
        'address'       => $request->address,
        'gst'           => $request->gst,
        'status'        => 'active',
    ]);

    // 4️⃣ SEND EMAIL TO SUPPLIER (LOGIN DETAILS)
    Mail::to($supplier->email)->send(
        new SupplierAddedMail(
            $supplier->name,
            $supplier->email,
            $supplierCode // 👈 password
        )
    );

    return back()->with(
        'success',
        "Supplier added successfully. Login details sent to supplier email."
    );
}


public function suppliersList()
{
    $suppliers = Supplier::latest()->get();
    return view('admin.suppliers.dashboard', compact('suppliers'));
}
// 🟤 Seller Requests List
public function sellerRequests()
{
    $pending  = SellerRequest::where('status', 'pending')->with('user')->get();
    $approved = SellerRequest::where('status', 'approved')->with('user')->get();
    $rejected = SellerRequest::where('status', 'rejected')->with('user')->get();

    return view('admin.sellers.index', compact(
        'pending',
        'approved',
        'rejected'
    ));
}

public function showSupplier(Supplier $supplier)
{
    // ================= CATEGORIES + PRODUCTS =================
    $categories = SupplierCategory::where('supplier_id', $supplier->id)
        ->with(['products' => function ($q) {
            $q->latest();
        }])
        ->get();

    // ================= ALL PRODUCTS (FOR STATS) =================
    $allProducts = SupplierProduct::where('supplier_id', $supplier->id)->get();

    // ================= SOLD PRODUCTS (SEPARATE SECTION) =================
    $soldProducts = SupplierProduct::where('supplier_id', $supplier->id)
        ->where('status', 'sold')
        ->latest()
        ->get();

    // ================= STATS =================
    $stats = [
        'total'   => $allProducts->count(),
        'sold'    => $allProducts->where('status', 'sold')->count(),
        'pending' => $allProducts->where('payment_status', 'pending')->count(),
        'paid'    => $allProducts->where('payment_status', 'paid')->sum('price'),
    ];

    // ================= GRAPH DATA =================
    $graphData = [
        'labels' => ['Total', 'Purchased', 'Pending'],
        'values' => [
            $stats['total'],
            $stats['sold'],
            $stats['pending'],
        ],
    ];

    return view('admin.suppliers.show', compact(
        'supplier',
        'categories',
        'soldProducts',
        'stats',
        'graphData'
    ));
}



public function sellerApprove($id)
{
    $request = SellerRequest::findOrFail($id);
    $request->status = 'approved';
    $request->save();

    $user = User::find($request->user_id);
    $user->role = 'seller';
    $user->save();
    Mail::to(env('ADMIN_EMAIL'))->send(
    new AdminNotificationMail(
        'Seller Approved',
        [
            'seller_name' => $user->name,
            'email'       => $user->email
        ]
    )
);


    // 🔔 MAIL
    Mail::to($user->email)->send(new SellerApprovedMail($user));

    return back()->with('success', 'Seller approved successfully!');
}
// 🔴 Reject Seller
public function sellerReject($id)
{
    $request = SellerRequest::findOrFail($id);
    $request->status = 'rejected';
    $request->save();

    return back()->with('error', 'Seller request rejected.');
}

public function partnersIndex()
{
    $pending  = DeliveryPartner::where('status', 'pending')->get();
    $approved = DeliveryPartner::where('status', 'approved')->get();
    $blocked  = DeliveryPartner::where('status', 'blocked')->get();
    $rejected = DeliveryPartner::where('status', 'rejected')->get();

    return view('admin.partners.index', compact(
        'pending',
        'approved',
        'blocked',
        'rejected'
    ));
}
public function liveTrackingData()
{
    $partners = DeliveryPartner::with([
        'activeOrders:id,partner_id,order_number,status,total,delivery_charges,awb',
        'completedOrders:id,partner_id,order_number,status,total,delivery_charges,awb'
    ])
    ->select('id','full_name','partner_code','online_status','latitude','longitude','location_updated_at')
    ->get();

    $data = $partners->map(function($p){

        return [
            'partner_name'     => $p->full_name,
            'partner_code'     => $p->partner_code,
            'online_status'    => $p->online_status,

            'latitude'         => $p->latitude,
            'longitude'        => $p->longitude,
            'updated_at'       => $p->location_updated_at,

            'total_active_orders'    => $p->activeOrders->count(),
            'total_completed_orders' => $p->completedOrders->count(),

            // ACTIVE ORDERS
            'active_orders' => $p->activeOrders->map(function($o){
                return [
                    'order_number'      => $o->order_number,
                    'awb'               => $o->awb,
                    'status'            => $o->status,
                    'total'             => $o->total,
                    'delivery_charges'  => $o->delivery_charges
                ];
            }),

            // COMPLETED ORDERS
            'completed_orders' => $p->completedOrders->map(function($o){
                return [
                    'order_number'      => $o->order_number,
                    'awb'               => $o->awb,
                    'status'            => $o->status,
                    'total'             => $o->total,
                    'delivery_charges'  => $o->delivery_charges
                ];
            }),
        ];
    });

    return response()->json($data);
}



public function liveTracking()
{
    $activeOrders = Order::whereIn('status', [
        'accepted','picked','on_the_way'
    ])->with('partner')->get();

    return view('admin.live-tracking', compact('activeOrders'));
}

public function partnerPending()
    {
        $partners = DeliveryPartner::where('status', 'pending')->get();
        return view('admin.partners.pending', compact('partners'));
    }


    // 2️⃣ Show Approved Partners
    public function partnerApproved()
    {
        $partners = DeliveryPartner::where('status', 'approved')->get();
        return view('admin.partners.approved', compact('partners'));
        
    }


    // 3️⃣ View Partner Details
   public function partnerShow($id)
{
    $partner = DeliveryPartner::with('user')->findOrFail($id);

    // ACTIVE ORDER (not delivered/cancelled)
    $activeOrder = Order::where('partner_id', $partner->id)
        ->whereNotIn('status', ['delivered', 'cancelled'])
        ->latest()
        ->first();
          $pendingOrders   = $partner->orders()->whereIn('status', ['accepted','picked','on_the_way'])->get();
  

    // COMPLETED ORDERS
    $completedOrders = Order::where('partner_id', $partner->id)
        ->where('status', 'delivered')
        ->latest()
        ->get();
       

    // CANCELLED ORDERS
    $cancelledOrders = Order::where('partner_id', $partner->id)
        ->where('status', 'cancelled')
        ->latest()
        ->get();
        $totalRides = $partner->orders()->count();  

    // TOTAL EARNINGS
    $totalEarnings = Order::where('partner_id', $partner->id)
        ->where('status', 'delivered')
        ->sum('delivery_charges');

    return view('admin.partners.show', compact(
        'partner',
        'activeOrder',
        'completedOrders',
        'cancelledOrders',
        'totalEarnings',
        'totalRides',
        'pendingOrders'
        
    ));
}

    // 4️⃣ Approve Partner
    public function partnerApprove($id)
    {
        $partner = DeliveryPartner::with('user')->findOrFail($id);

    // Update partner status
    $partner->status = 'approved';
    $partner->save();

    // Update user role
    if ($partner->user) {
        $partner->user->role = 'driver';
        $partner->user->save();
    }


        Mail::to(env('ADMIN_EMAIL'))->send(
    new AdminNotificationMail(
        'New Partner Approved',
        [
            'partner_name' => $partner->full_name,
            'phone'        => $partner->phone,
            'status'       => 'Approved'
        ]
    )
);

        // update user role
        $user = User::find($partner->user_id);
        $user->role = 'driver';
        $user->save();
Mail::to($partner->user->email)->send(
    new PartnerNotificationMail('rejected', $partner)
);

        return back()->with('success', 'Partner Approved Successfully!');
    }


    // 5️⃣ Reject Partner
    public function partnerReject($id)
    {
        $partner = DeliveryPartner::findOrFail($id);

        $partner->status = 'rejected';
        $partner->save();
        Mail::to(env('ADMIN_EMAIL'))->send(
    new AdminNotificationMail(
        'Partner Rejected',
        [
            'partner_name' => $partner->full_name,
            'phone'        => $partner->phone
        ]
    )
);

Mail::to($partner->user->email)->send(
    new PartnerNotificationMail('rejected', $partner)
);

        return back()->with('error', 'Partner rejected.');
    }
  



    public function income(Request $request)
    {
        /* ------------------------
           DATE FILTER
        ------------------------ */
        $from = $request->from ? Carbon::parse($request->from) : now()->subMonth();
        $to   = $request->to   ? Carbon::parse($request->to)   : now();

        /* ------------------------
           ALL ORDERS TOTAL
        ------------------------ */
        $allOrdersTotal = OrderItem::whereHas('order', function ($q) use ($from,$to) {
            $q->whereBetween('created_at',[$from,$to]);
        })->sum('total');

        /* ========================
           SELLER PRODUCTS
        ======================== */

        // Delivered
        $sellerDelivered = OrderItem::whereNull('seller_id')
            ->whereHas('order', fn($q) =>
                $q->where('status','delivered')
                  ->whereBetween('created_at',[$from,$to])
            )->sum('total');

        // Pending
        
        $sellerPending = OrderItem::whereNull('seller_id')
            ->whereHas('order', fn($q) =>
                $q->where('status','placed')
                  ->whereBetween('created_at',[$from,$to])
            )->sum('total');

        // Cancelled
        $sellerCancelled = OrderItem::whereNull('seller_id')
            ->whereHas('order', fn($q) =>
                $q->where('status','cancelled')
                  ->whereBetween('created_at',[$from,$to])
            )->sum('total');

        /* ------------------------
           SELLER COMMISSION
        ------------------------ */
        $adminCommission = SellerEarning::whereBetween('created_at',[$from,$to])
            ->sum('admin_commission');

        $sellerPayout = SellerEarning::whereBetween('created_at',[$from,$to])
            ->sum('seller_amount');

        /* ========================
           ADMIN PRODUCTS
        ======================== */

        $adminDelivered = OrderItem::whereNull('seller_id')
            ->whereHas('order', fn($q) =>
                $q->where('status','delivered')
                  ->whereBetween('created_at',[$from,$to])
            )->sum('total');

        $adminPending = OrderItem::whereNull('seller_id')
            ->whereHas('order', fn($q) =>
                $q->where('status','placed')
                  ->whereBetween('created_at',[$from,$to])
            )->sum('total');

        $adminCancelled = OrderItem::whereNull('seller_id')
            ->whereHas('order', fn($q) =>
                $q->where('status','cancelled')
                  ->whereBetween('created_at',[$from,$to])
            )->sum('total');

        /* ------------------------
           SUPPLIER PURCHASE (B2B)
        ------------------------ */
        $supplierPurchase = Product::where('source','supplier')
            ->whereBetween('created_at',[$from,$to])
            ->sum('price');

        /* ------------------------
           MONTHLY GRAPH (ALL ORDERS)
        ------------------------ */
        $months = [];
        $monthlyTotals = [];

        for ($i=5; $i>=0; $i--) {
            $m = now()->subMonths($i);
            $months[] = $m->format('M');

            $monthlyTotals[] = OrderItem::whereHas('order', fn($q) =>
                $q->whereMonth('created_at',$m->month)
                  ->whereYear('created_at',$m->year)
            )->sum('total');
        }

        return view('admin.income', compact(
            'from','to',
            'allOrdersTotal',

            'sellerDelivered','sellerPending','sellerCancelled',
            'adminCommission','sellerPayout',

            'adminDelivered','adminPending','adminCancelled',
            'supplierPurchase',

            'months','monthlyTotals'
        ));
    }





private function spark($base)
{
    return [
        round($base * 0.6, 2),
        round($base * 0.7, 2),
        round($base * 0.65,2),
        round($base * 0.8, 2),
        round($base * 0.9, 2),
        round($base, 2),
    ];
}



public function orderDetail($orderNumber)
{
    $order = Order::with(['items.product', 'user', 'partner'])
        ->where('order_number', $orderNumber)
        ->firstOrFail();

    // ETA (2 days default)
    $etaDays = 2;
    $eta = now()->addDays($etaDays)->format('d M Y');

    $timeline = [
        ['label' => 'Placed', 'done' => true, 'time' => $order->created_at->format('d M h:i A')],
        ['label' => 'Accepted', 'done' => $order->accepted_at != null, 'time' => optional($order->accepted_at)->format('d M h:i A')],
        ['label' => 'Picked', 'done' => in_array($order->status, ['picked','on_the_way','delivered']), 'time' => optional($order->picked_at)->format('d M h:i A')],
        ['label' => 'On the Way', 'done' => in_array($order->status, ['on_the_way','delivered']), 'time' => optional($order->on_the_way_at)->format('d M h:i A')],
        ['label' => 'Delivered', 'done' => $order->status === 'delivered', 'time' => optional($order->delivered_at)->format('d M h:i A')],
    ];

    return response()->json([
        'order' => [
            'order_number' => $order->order_number,
            'tracking_id'  => $order->awb,
            'status'       => $order->status,
            'total'        => $order->total,
            'address'      => $order->address_line,
            'customer'     => $order->user->name,
            'partner'      => $order->partner->full_name ?? 'Not Assigned',
            'eta'          => $eta
        ],
        'items' => $order->items->map(fn($i) => [
            'name' => $i->product->name,
            'qty' => $i->qty,
        ]),
        'timeline' => $timeline,
    ]);
}




        public function indexx(Request $request)
{
    $search = $request->input('search');
    $status = $request->input('status');

    $orders = Order::with('user')
        ->when($search, function($q) use ($search) {
            $q->where('order_number', 'like', "%$search%")
              ->orWhereHas('user', function($q) use ($search) {
                  $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
              });
        })
        ->when($status && $status !== 'all', function($q) use ($status) {
            $q->where('status', $status);
        })
        ->orderBy('id','DESC')
        ->paginate(10);

    return view('admin.orders.index', compact('orders', 'search', 'status'));
}


        // Single order detail
        public function show($id)
        {
            $order = Order::with(['user', 'items.product'])->findOrFail($id);
            $order = Order::with('user.address', 'items.product')->find($id);

            return view('admin.orders.show', compact('order'));
        }

        // Update order status
        public function updateStatus(Request $request, $id)
        {
            $request->validate([
                'status' => 'required|in:placed,cancelled,delivered'
            ]);

            $order = Order::findOrFail($id);
            $order->status = $request->status;
            $order->save();

            return redirect()->back()->with('success', 'Order status updated!');
        }
        public function indexUser(Request $request)
{
    $search = $request->input('search');

    $users = User::withCount('orders')
        ->when($search, function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);

    return view('admin.users.index', compact('users', 'search'));
}


        // Show single user details + orders
        public function showUser($id)
        {
            $user = User::with('orders.items.product')->findOrFail($id);
            return view('admin.users.show', compact('user'));
        }

    }