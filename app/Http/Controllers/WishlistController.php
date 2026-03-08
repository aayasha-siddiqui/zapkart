<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with('product')
                    ->where('user_id', Auth::id())
                    ->get();

        return view('wishlist.index', compact('wishlist'));
    }


    public function add($id)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Login required');
        }

        // Check if product exists
        $product = Product::findOrFail($id);

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
                          ->where('product_id', $id)
                          ->first();

        if ($exists) {
            return back()->with('info', 'Already in wishlist');
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $id
        ]);

        return back()->with('success', 'Added to wishlist');
    }


    public function remove($id)
    {
        $item = Wishlist::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->first();

        if ($item) {
            $item->delete();
        }

        return back()->with('success', 'Removed from wishlist');
    }
}
