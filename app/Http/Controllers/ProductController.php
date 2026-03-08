<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /* =========================
       SHOW ALL PRODUCTS
    ==========================*/
   public function index()
{
    // SHOPKEEPER → only assigned products
    if (auth()->check() && auth()->user()->role === 'shopkeeper') {

        $products = Product::whereIn('id', function ($q) {
                $q->select('product_id')
                  ->from('shopkeeper_products')
                  ->where('shopkeeper_id', auth()->id());
            })
            ->with('category')
            ->latest()
            ->get();

    }
    // SELLER → apne products
    elseif (auth()->check() && auth()->user()->role === 'seller') {

        $products = Product::where('seller_id', auth()->id())
            ->latest()
            ->get();

    }
    // ADMIN + USER → all products
    else {
        $products = Product::latest()->get();
    }

    return view('products.index', compact('products'));
}


    /* =========================
       SEARCH PRODUCTS
    ==========================*/
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->latest()
            ->get();

        $wishlistProducts = [];
        if (auth()->check()) {
            $wishlistProducts = Wishlist::where('user_id', auth()->id())
                ->pluck('product_id')
                ->toArray();
        }

        return view('products.index', compact('products', 'wishlistProducts'));
    }

    /* =========================
       CREATE PRODUCT (ADMIN)
    ==========================*/
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /* =========================
       STORE PRODUCT (ADMIN)
    ==========================*/
    public function store(Request $request)
{
    $data = $request->validate([
        'name'        => 'required|string',
        'price'       => 'required|numeric',
        'description' => 'nullable|string',
        'image'       => 'nullable|image',
         'qty'         => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    if (auth()->user()->role === 'seller') {
        // 🔥 SELLER PRODUCT
        $data['seller_id']   = auth()->id();
        $data['supplier_id'] = null;

        
    } else {
        // 🔥 ADMIN PRODUCT
        $data['seller_id']   = null;
        $data['supplier_id'] = null;
        
    }

    Product::create($data);

    return redirect()->route('products.index')
        ->with('success', 'Product saved successfully');
}


    /* =========================
       SHOW SINGLE PRODUCT
    ==========================*/
  public function show(Product $product)
{
    $product->load(['category', 'supplier', 'seller']);


    $viewProduct = [
        'raw_id'        => $product->id,
        'name'          => $product->name,
        'price'         => $product->price,
        'image'         => $product->image,
        
        'description'   => $product->description,
        'category'      => $product->category->name ?? '',
        'supplier_id'   => $product->supplier_id,
        'supplier_name' => $product->supplier->name ?? '',
        'seller_id'     => $product->seller_id,
    'seller_name'   => $product->seller->name ?? '', // ✅ FIXED
    ];

    return view('products.show', compact('viewProduct'));
}


    /* =========================
       EDIT PRODUCT
    ==========================*/
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /* =========================
       UPDATE PRODUCT
    ==========================*/
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /* =========================
       DELETE PRODUCT
    ==========================*/
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    /* =========================
       PRODUCTS BY CATEGORY
    ==========================*/
    public function showByCategory($id)
    {
        $category = Category::findOrFail($id);

        $products = Product::where('category_id', $id)
            ->with('category')
            ->latest()
            ->get();

        $wishlistProducts = [];
        if (auth()->check()) {
            $wishlistProducts = Wishlist::where('user_id', auth()->id())
                ->pluck('product_id')
                ->toArray();
        }

        return view('products.index', compact(
            'products',
            'category',
            'wishlistProducts'
        ));
    }

    /* =========================
       SUPPLIER PRODUCTS (ADMIN VIEW)
    ==========================*/
    public function supplierProducts($supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);

        $products = Product::where('supplier_id', $supplierId)
            ->with('category')
            ->latest()
            ->get();

        return view('products.supplier', compact('supplier', 'products'));
    }
}
