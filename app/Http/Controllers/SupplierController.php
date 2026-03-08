<?php
namespace App\Http\Controllers;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\SupplierCategory;
use App\Models\SupplierProduct;
use App\Models\Supplier;
class SupplierController extends Controller
{
    // 🔹 SUPPLIER DASHBOARD
public function dashboard()
{
    $supplier = Supplier::where('user_id', auth()->id())->firstOrFail();

    $totalCategories = SupplierCategory::where('supplier_id', $supplier->id)->count();

    $totalProducts = SupplierProduct::where('supplier_id', $supplier->id)->count();

    $soldProducts = SupplierProduct::where('supplier_id', $supplier->id)
        ->where('status', 'sold')
        ->count();

    $availableProducts = SupplierProduct::where('supplier_id', $supplier->id)
        ->where('status', 'available')
        ->count();

    $totalEarnings = SupplierProduct::where('supplier_id', $supplier->id)
        ->where('status', 'sold')
        ->sum('price');

    // Monthly sales (for chart)
    $monthlySales = SupplierProduct::selectRaw(
        "EXTRACT(MONTH FROM created_at) as month, SUM(price) as total"
    )
    ->where('supplier_id', $supplier->id)
    ->where('status', 'sold')
    ->groupByRaw("EXTRACT(MONTH FROM created_at)")
    ->orderByRaw("EXTRACT(MONTH FROM created_at)")
    ->pluck('total', 'month');


    $categories = SupplierCategory::where('supplier_id', $supplier->id)->get();
    $products   = SupplierProduct::where('supplier_id', $supplier->id)->latest()->get();

    return view('suppliers.dashboard', compact(
        'supplier',
        'totalCategories',
        'totalProducts',
        'soldProducts',
        'availableProducts',
        'totalEarnings',
        'categories',
        'products',
        'monthlySales'
    ));
}
 // 🔹 ADD CATEGORY
   public function addCategory(Request $request)
{
    $request->validate([
        'name'  => 'required',
        'image' => 'nullable|image'
    ]);

    $supplier = Supplier::where('user_id', auth()->id())->firstOrFail();

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('categories', 'public');
    }

    SupplierCategory::create([
        'supplier_id' => $supplier->id,
        'name'        => $request->name,
        'image'       => $imagePath,
       
    ]);

    return back()->with('success', 'Category sent for admin approval');
}


    // 🔹 ADD PRODUCT
   

public function addProduct(Request $request)
{
    $supplier = Supplier::where('user_id', auth()->id())->firstOrFail();

    $request->validate([
        'name' => 'required',
            'qty'   => 'required|integer|min:1',   // ✅
        'price' => 'required|numeric',
        'supplier_category_id' => 'required|exists:supplier_categories,id',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    $product = SupplierProduct::create([
        'supplier_id' => $supplier->id,
        'supplier_category_id' => $request->supplier_category_id,
        'name' => $request->name,
        'price' => $request->price,
        'qty'   => $request->qty,   // ✅ STOCK SAVE
        'description' => $request->description,
        'image' => $imagePath,
        'status' => 'available',
    ]);

    // 🔔 ADMIN MAIL
    Mail::to(env('ADMIN_EMAIL'))->send(
        new AdminNotificationMail(
    'supplier_product',
    [
        'supplier' => $supplier->name,
        'product'  => $product->name,
        'price'    => $product->price,
    ]

        )
    );

    return back()->with('success', 'Product added & admin notified');
}


public function updateCategory(Request $request,$id){
 SupplierCategory::where('id',$id)
   ->update(['name'=>$request->name]);
   Mail::to(env('ADMIN_EMAIL'))->send(
    new AdminNotificationMail(
        'New Supplier Product Added',
        [
            'supplier' => $supplier->name,
            'product'  => $product->name,
            'price'    => $product->price
        ]
    )
);
        

 return back()->with('success','Category updated');
}
private function categoryLocked($supplierCategoryId)
{
    return Product::where('category_id', $supplierCategoryId)->exists();
}

public function deleteCategory($id){
 SupplierCategory::where('id',$id)->delete();
 return back()->with('success','Category deleted');
}

// PRODUCT
public function updateProduct(Request $request,$id){
 SupplierProduct::where('id',$id)->update([
   'name'=>$request->name,
   'price'=>$request->price
 ]);
 return back()->with('success','Product updated');
}
public function delete($id)
{
    $supplier = Supplier::where('user_id', auth()->id())->firstOrFail();

    $product = SupplierProduct::where('id', $id)
                ->where('supplier_id', $supplier->id) // 🔒 security
                ->firstOrFail();

    // image delete (optional)
    if ($product->image) {
        \Storage::disk('public')->delete($product->image);
    }

    $product->delete(); // ✅ correct delete

    return back()->with('success', 'Product deleted successfully!');
}

}
