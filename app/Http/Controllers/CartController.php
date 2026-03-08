<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /* =========================
       SHOW CART
    ==========================*/
    public function index()
    {
        $carts = Cart::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        return view('cart', compact('carts'));
    }

    /* =========================
       GET STOCK (ROLE BASED)
    ==========================*/
    private function getStock(Product $product)
    {
        if (auth()->user()->role === 'shopkeeper') {
            return DB::table('shopkeeper_products')
                ->where('shopkeeper_id', auth()->id())
                ->where('product_id', $product->id)
                ->value('qty') ?? 0;
        }

        // user / seller / admin → warehouse
        return $product->qty ?? 0;
    }

    /* =========================
       ADD TO CART
    ==========================*/
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $stock   = $this->getStock($product);

        if ($stock <= 0) {
            return back()->with('error', 'Product is out of stock');
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity >= $stock) {
                return back()->with('error', 'Stock limit reached');
            }

            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    /* =========================
       INCREASE QTY
    ==========================*/
    public function increase($id)
    {
        $cart    = Cart::findOrFail($id);
        $product = Product::findOrFail($cart->product_id);
        $stock   = $this->getStock($product);

        if ($cart->quantity >= $stock) {
            return back()->with('error', 'Stock not available');
        }

        $cart->increment('quantity');
        return back();
    }

    /* =========================
       DECREASE QTY
    ==========================*/
    public function decrease($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }

        return back();
    }

    /* =========================
       BUY NOW
    ==========================*/
    public function buyNow($id)
    {
        $product = Product::findOrFail($id);
        $stock   = $this->getStock($product);

        if ($stock <= 0) {
            return back()->with('error', 'Product is out of stock');
        }

        Cart::where('user_id', auth()->id())->delete();

        Cart::create([
            'user_id'    => auth()->id(),
            'product_id' => $id,
            'quantity'   => 1,
        ]);

        return redirect()->route('checkout');
    }

    /* =========================
       REMOVE
    ==========================*/
    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return back()->with('success', 'Product removed from cart!');
    }
}
