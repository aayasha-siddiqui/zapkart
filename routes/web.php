    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\OtpController;  // EMAIL OTP CONTROLLER
    use App\Http\Controllers\Auth\ProfileController;
    use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\AdminAuthController;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\CheckoutController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\AdminDashboardController;
    use App\Http\Controllers\WishlistController;
    use App\Http\Controllers\SellerController;
    use App\Http\Controllers\PaymentController;
    use App\Http\Controllers\TrackController;    use App\Http\Controllers\SupplierController;   
Route::middleware('auth')->group(function () {

  

});
Route::delete('/supplier/product/{id}', [SupplierController::class, 'delete'])
    ->name('supplier.product.delete');


Route::get('/supplier/{id}/products', [ProductController::class,'supplierProducts'])
    ->name('supplier.products');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    
    */
//     Route::get('/admin/product/{id}/approve',
//  [AdminDashboardController::class,'approveProduct']
// )->name('admin.product.approve');

// Route::get('/admin/product/{id}/reject',
//  [AdminDashboardController::class,'rejectProduct']
// )->name('admin.product.reject');

Route::middleware(['auth','role:admin'])->group(function () {
  Route::post('/admin/product/{id}/buy',
    [AdminDashboardController::class,'buyProduct']
)->name('admin.product.buy');

Route::post('/admin/product/{id}/pay',
    [AdminDashboardController::class,'payNow']
)->name('admin.product.pay');
Route::post('/admin/product/bulk-pay',
    [AdminDashboardController::class,'bulkPayNow']
)->name('admin.product.bulkPay');

});

    Route::get('/admin/income', [AdminDashboardController::class, 'income'])
     ->name('admin.income');
Route::get('/admin/suppliers/{supplier}',
    [AdminDashboardController::class, 'showSupplier']
)->name('admin.suppliers.show');

    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/admin/orders', [AdminDashboardController::class, 'indexx'])
            ->name('admin.orders');

        Route::get('/admin/orders/{id}', [AdminDashboardController::class, 'show'])
            ->name('admin.orders.show');

        Route::post('/admin/orders/{id}/status', [AdminDashboardController::class, 'updateStatus'])
            ->name('admin.orders.updateStatus');

            
    });
Route::get('/partner/profile', [PartnerController::class, 'editProfile'])
    ->name('partner.profile')
    ->middleware(['auth']);

Route::post('/partner/profile/update', [PartnerController::class, 'updateProfile'])
    ->name('partner.profile.update')
    ->middleware(['auth']);
    Route::post('/partner/order/{id}/delivered', [PartnerController::class, 'delivered'])->name('partner.order.delivered');

   
    /*
    |--------------------------------------------------------------------------
    | USER ORDERS
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/my-orders', [OrderController::class, 'index'])->name('orders');
        Route::post('/cancel-order/{id}', [OrderController::class, 'cancel'])->name('order.cancel');
    });

    /*
    |--------------------------------------------------------------------------
    | TRACK
    |--------------------------------------------------------------------------
    */
    Route::get('/track', [TrackController::class, 'form'])->name('track.form');
    Route::post('/track', [TrackController::class, 'track'])->name('track.search');
    Route::get('/track/{awb}', [TrackController::class, 'direct'])->name('track.direct');

    /*
    |--------------------------------------------------------------------------
    | WISHLIST
    |--------------------------------------------------------------------------
    */
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------
    ------------------------------------------------------------
    */
    Route::get('/admin/sellers/{seller}', 
    [SellerController::class, 'show']
)->name('admin.sellers.show');

    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('order.place');
        Route::get('/order-success/{id}', [CheckoutController::class, 'success'])->name('order.success');
    
    });
    Route::post('/checkout/payment-success', [CheckoutController::class, 'paymentSuccess'])
            ->name('checkout.payment.success');

    Route::get('/check-login', function () {
        return auth()->id();
    });
use App\Http\Controllers\PartnerController;


Route::middleware('auth')->group(function () {

    // Partner Registration
    Route::get('/partner/register', [PartnerController::class, 'register'])->name('partner.register');
    Route::post('/partner/register', [PartnerController::class, 'submit'])->name('partner.register.submit');
    Route::get('/partner/status', [PartnerController::class, 'partnerStatus'])->name('partner.status');

    // Partner Dashboard
    Route::get('/partner/dashboard', [PartnerController::class, 'dashboard'])->name('partner.dashboard');

    // Partner online / offline
    Route::post('/partner/go-online', [PartnerController::class, 'toggleOnline'])->name('partner.toggleOnline');

    // Delivery Actions
    Route::post('/partner/order/{id}/accept', [PartnerController::class, 'acceptOrder'])->name('partner.order.accept');
    Route::post('/partner/order/{id}/picked', [PartnerController::class, 'pickedOrder'])->name('partner.order.picked');
    Route::post('/partner/order/{id}/on-the-way', [PartnerController::class, 'onTheWay'])->name('partner.order.onTheWay');
  Route::post('/partner/order/verify-otp/{id}', [PartnerController::class, 'verifyOtp'])
    ->name('partner.order.verifyOtp');
Route::get('/partner/profile', [PartnerController::class, 'editProfile'])
    ->name('partner.profile')
    ->middleware(['auth']);

Route::post('/partner/profile/update', [PartnerController::class, 'updateProfile'])
    ->name('partner.profile.update')
    ->middleware(['auth']);
    Route::post('/partner/order/{id}/delivered', [PartnerController::class, 'delivered'])->name('partner.order.delivered');
});
Route::put('/supplier/category/update/{id}',
 [SupplierController::class,'updateCategory'])->name('supplier.category.update');

Route::delete('/supplier/category/delete/{id}',
 [SupplierController::class,'deleteCategory'])->name('supplier.category.delete');

Route::put('/supplier/product/update/{id}',
 [SupplierController::class,'updateProduct'])->name('supplier.product.update');

Route::delete('/supplier/product/delete/{id}',
 [SupplierController::class,'deleteProduct'])->name('supplier.product.delete');


Route::get('/admin/order-detail/{order}', [AdminDashboardController::class, 'orderDetail'])
     ->name('admin.order.detail');

// Admin partner management routes
Route::middleware(['auth', 'role:admin'])->group(function (){

       Route::get('/admin/live-tracking', [AdminDashboardController::class, 'liveTracking'])
        ->name('admin.live.tracking');

    Route::get('/admin/live-tracking/data', [AdminDashboardController::class, 'liveTrackingData'])
        ->name('admin.live.tracking.data');
 Route::get('/admin/users', [AdminDashboardController::class, 'indexUser'])->name('admin.users.index');
    Route::get('/admin/users/{id}', [AdminDashboardController::class, 'showUser'])->name('admin.users.show');

    // Pending list
     Route::get('/partners/index', [AdminDashboardController::class, 'partnersIndex'])
        ->name('admin.partners.index');

    Route::get('/partners/pending', [AdminDashboardController::class, 'partnerPending'])
        ->name('admin.partners.pending');

    // Approved list
    Route::get('/partners/approved', [AdminDashboardController::class, 'partnerApproved'])
        ->name('admin.partners.approved');

    // Show single partner (used in views as admin.partners.show)
    Route::get('/partners/{id}', [AdminDashboardController::class, 'partnerShow'])
        ->name('admin.partners.show');

    // Approve partner
    Route::post('/partners/{id}/approve', [AdminDashboardController::class, 'partnerApprove'])
        ->name('admin.partners.approve');

    // Reject partner
    Route::post('/partners/{id}/reject', [AdminDashboardController::class, 'partnerReject'])
        ->name('admin.partners.reject');
        Route::post('/admin/partners/{id}/block', [AdminDashboardController::class,'partnerBlock'])->name('admin.partners.block');
Route::post('/admin/partners/{id}/unblock', [AdminDashboardController::class,'partnerUnblock'])->name('admin.partners.unblock');
Route::get('/admin/suppliers', [AdminDashboardController::class, 'suppliers']);
    Route::post('/admin/suppliers', [AdminDashboardController::class, 'storeSupplier']);

    Route::get('/admin/warehouse/stock', [AdminDashboardController::class, 'warehouseStock']);
    Route::post('/admin/warehouse/stock', [AdminDashboardController::class, 'storeWarehouseStock']);
    Route::post('/admin/suppliers/add', [AdminDashboardController::class, 'storeSupplier'])
    ->middleware('auth');
Route::get('/admin/suppliers', [AdminDashboardController::class, 'suppliersList'])
    ->name('admin.suppliers.list');

Route::post('/admin/suppliers/add', [AdminDashboardController::class, 'storeSupplier'])
    ->name('admin.suppliers.add');

});
Route::middleware(['auth'])->group(function () {

    Route::get('/suppliers/dashboard', function () {
        return view('suppliers.dashboard');
    })->name('suppliers.dashboard');

});
Route::middleware(['auth'])->group(function () {

    Route::get('/suppliers/dashboard', [SupplierController::class, 'dashboard'])
        ->name('suppliers.dashboard');

    Route::post('/supplier/category/add', [SupplierController::class, 'addCategory'])
        ->name('supplier.category.add');

    Route::post('/supplier/product/add', [SupplierController::class, 'addProduct'])
        ->name('supplier.product.add');

});


// Supplier Login
Route::get('/suppliers/login', function () {
    return view('suppliers.auth.login');
})->name('supplier.login.form');

Route::post('/supplier/login', [\App\Http\Controllers\Auth\AuthController::class, 'supplierLogin'])
    ->name('supplier.login');




/* USER */
Route::middleware('auth')->group(function () {
    Route::get('/become-seller', [SellerController::class, 'create']);
    Route::post('/become-seller', [SellerController::class, 'store']);
});
Route::middleware(['auth','role:seller'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])
        ->name('seller.dashboard');
});
Route::post('/seller/{id}/delivered',
    [SellerController::class,'markDelivered']
)->name('seller.order.delivered');

/* ADMIN */

Route::get('/admin/seller-requests', [AdminDashboardController::class, 'sellerRequests'])->name('seller-requests');;

Route::post('/admin/seller-approve/{id}', [AdminDashboardController::class, 'sellerApprove']);
Route::post('/admin/seller-reject/{id}', [AdminDashboardController::class, 'sellerReject']);
Route::get('/seller-request-status', function () {
    return view('user.seller_request.status');
})->name('seller.request.status');


// Route::post('/forgot-password', [OtpController::class,'forgotPassword'])->name('password.forgot');
// Route::post('/reset-password', [OtpController::class,'resetPassword'])->name('password.reset');

    /*
    |--------------------------------------------------------------------------
    | PAYMENT
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | HOME / PRODUCTS
    |--------------------------------------------------------------------------
    */
    Route::get('/', [CategoryController::class, 'index'])
        
        ->name('dashboard');

    Route::get('/category/{id}', [ProductController::class, 'showByCategory'])->name('category.products');
    Route::get('/categories', [CategoryController::class, 'all'])->name('categories.all');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [CartController::class,'index'])->name('cart.index');
        Route::post('/cart/add/{id}', [CartController::class,'addToCart'])->name('cart.add');
        Route::post('/cart/increase/{id}', [CartController::class,'increase'])->name('cart.increase');
        Route::post('/cart/decrease/{id}', [CartController::class,'decrease'])->name('cart.decrease');
        Route::post('/cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');
        Route::post('/buy-now/{id}', [CartController::class, 'buyNow'])->name('buy-now');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN LOGIN
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS CRUD
    |--------------------------------------------------------------------------
    */
    // CATEGORY ALL PAGE (ADMIN VIEW)
    Route::get('/categories/all', [CategoryController::class, 'all'])->name('categories.all');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | OTP LOGIN (EMAIL VERSION)
    |--------------------------------------------------------------------------
    */

    // --- OTP LOGIN (EMAIL ONLY) ---
    // Route::get('/choose-login', function() {
    //     return view('auth.choose-login');
    // })->name('choose.login');

    // Route::get('/login/email', [OtpController::class, 'showEmailForm'])->name('login.email');
    // Route::post('/login/email/send', [OtpController::class, 'sendEmailOtp'])->name('login.email.send');

    // Route::get('/login/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    // Route::post('/login/verify', [OtpController::class, 'verify'])->name('otp.verify');




Route::get('/auth', [OtpController::class,'showForm'])->name('auth.form');

Route::post('/login', [OtpController::class,'login'])->name('login.submit');

Route::post('/register/send-otp', [OtpController::class,'sendOtp'])->name('register.sendOtp');

Route::post('/register/verify', [OtpController::class,'verifyOtpAndRegister'])
    ->name('register.verify');

    Route::post('/forgot-password', [OtpController::class,'forgotPassword'])
    ->name('password.forgot');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');
Route::post('/logout', [OtpController::class,'logout'])->name('logout');

Route::post('/admin/logout', [AdminAuthController::class,'logout'])
    ->name('admin.logout');


Route::post('/reset-password', [OtpController::class,'resetPassword'])
    ->name('password.update');
    use App\Http\Controllers\Admin\ShopkeeperController;

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {

    Route::get('/shopkeepers/create', [ShopkeeperController::class,'create'])
        ->name('admin.shopkeepers.create');
         Route::get('/shopkeepers/show', [ShopkeeperController::class,'index'])
        ->name('admin.shopkeepers.show');

    Route::post('/shopkeepers/store', [ShopkeeperController::class,'store'])
        ->name('admin.shopkeepers.store');

});
Route::get(
    '/admin/shopkeepers/overview',
    [ShopkeeperController::class, 'overviewAll']
)->name('admin.shopkeepers.overview');


use App\Http\Controllers\ShopkeeperDashboardController;

Route::middleware(['auth','role:shopkeeper'])->group(function () {

    Route::get('/shopkeeper/dashboard',
        [ShopkeeperDashboardController::class,'dashboard'])
        ->name('shopkeeper.dashboard');

});


Route::middleware(['auth','role:admin'])->group(function () {


    Route::get('/admin/assign-products', [AdminController::class,'assignProductsForm'])
        ->name('admin.assign.products');

    Route::post('/admin/assign-products', [AdminController::class,'assignProductsStore'])
        ->name('admin.assign.products.store');
});

    
    /*
    |--------------------------------------------------------------------------
    | PROFILE COMPLETE
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('profile/complete', [ProfileController::class, 'showCompleteForm'])->name('profile.complete.form');
        Route::post('profile/complete', [ProfileController::class, 'complete'])->name('profile.complete');
        
    });
