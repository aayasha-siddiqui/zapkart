<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;     // ⭐ Required for View::composer
use Illuminate\Support\Facades\Auth;     // ⭐ Required for Auth::check()
use App\Models\Wishlist;                 // ⭐ Required
use App\Models\Cart;                     // ⭐ Required

use App\Services\Sms\SmsServiceInterface;
use App\Services\Sms\LogSmsService;
use App\Services\Sms\TwilioSmsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SmsServiceInterface::class, function ($app) {
            $driver = config('sms.driver', env('SMS_DRIVER', 'log'));

            if ($driver === 'twilio') {
                return new TwilioSmsService();
            }

            return new LogSmsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ⭐ Global Wishlist + Cart Count for Navbar
        View::composer('*', function ($view) {
            $wishlistCount = 0;
            $cartCount = 0;

            if (Auth::check()) {
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
                $cartCount = Cart::where('user_id', Auth::id())->count();
            }

            $view->with('wishlistCount', $wishlistCount)
                 ->with('cartCount', $cartCount);
        });
    }
}
