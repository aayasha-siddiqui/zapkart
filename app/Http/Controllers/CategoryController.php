<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB; // ⬅️ add at top

class CategoryController extends Controller

{
public function index()
{
    // SHOPKEEPER → sirf assigned product wali categories
    if (auth()->check() && auth()->user()->role === 'shopkeeper') {

        // pehle assigned product IDs
        $assignedProductIds = DB::table('shopkeeper_products')
            ->where('shopkeeper_id', auth()->id())
            ->pluck('product_id');

        // un products ki categories
        $categories = Category::whereIn('id', function ($q) use ($assignedProductIds) {
                $q->select('category_id')
                  ->from('products')
                  ->whereIn('id', $assignedProductIds);
            })
            ->get();

        // optional: sirf unhi products ko dikhana
        $products = Product::whereIn('id', $assignedProductIds)->get();

    }
    // USER / ADMIN → normal flow
    else {
        $categories = Category::take(28)->get();
        $products   = Product::whereBetween('price', [100, 200])->get();
    }

    return view('dashboard', compact('categories','products'));
}


    // See all categories
  public function all()
{
    // SHOPKEEPER → sirf assigned product wali categories
    if (auth()->check() && auth()->user()->role === 'shopkeeper') {

        $assignedProductIds = DB::table('shopkeeper_products')
            ->where('shopkeeper_id', auth()->id())
            ->pluck('product_id');

        $categories = Category::whereIn('id', function ($q) use ($assignedProductIds) {
                $q->select('category_id')
                  ->from('products')
                  ->whereIn('id', $assignedProductIds);
            })
            ->paginate(12); // ✅ get() ki jagah paginate()

        return view('categories.all', compact('categories'));
    }

    // USER / ADMIN
    $categories = Category::paginate(12);
    return view('categories.all', compact('categories'));
}


    // public function index()
    // {
    //     $categories = Category::with('products')->get();
    //      return view('dashboard', compact('categories'));
    // }

    /**
     * Show category create form
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'tagline'  => 'nullable|string',
            'image'    => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.all')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update category
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'tagline'  => 'nullable|string',
            'image'    => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.all')
            ->with('success', 'Category updated successfully!');
    }
    

    /**
     * Delete category
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}