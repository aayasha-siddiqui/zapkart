@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5efe7] p-6">

{{-- ================= HEADER ================= --}}
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-[#5a3e36]">
            Welcome, {{ $supplier->name }}
        </h1>
        <p class="text-sm text-gray-500">
            Supplier Dashboard Overview
        </p>
    </div>

    <div class="flex gap-3">
        <button onclick="openCategoryModal()"
            class="bg-[#c07a35] text-white px-5 py-2 rounded-full shadow hover:opacity-90">
            + Add Category
        </button>

        <button onclick="openProductModal()"
            class="bg-[#5a3e36] text-white px-5 py-2 rounded-full shadow hover:opacity-90">
            + Add Product
        </button>
    </div>
</div>

{{-- ================= STATS ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

    <div onclick="openAllCategoriesModal()"
     class="bg-white p-5 rounded-2xl shadow cursor-pointer hover:shadow-lg">
    <p class="text-sm text-gray-500">Categories</p>
    <p class="text-3xl font-bold text-[#5a3e36]">{{ $totalCategories }}</p>
</div>

<div onclick="openAllProductsModal()"
     class="bg-white p-5 rounded-2xl shadow cursor-pointer hover:shadow-lg">
    <p class="text-sm text-gray-500">Products</p>
    <p class="text-3xl font-bold text-[#5a3e36]">{{ $totalProducts }}</p>
</div>


    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-sm text-gray-500">Available</p>
        <p class="text-3xl font-bold text-green-600">{{ $availableProducts }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-sm text-gray-500">Sold</p>
        <p class="text-3xl font-bold text-red-500">{{ $soldProducts }}</p>
    </div>

    <div class="bg-gradient-to-r from-[#5a3e36] to-[#c07a35] p-5 rounded-2xl shadow text-white">
        <p class="text-sm opacity-80">Total Earnings</p>
        <p class="text-3xl font-bold">₹{{ number_format($totalEarnings,2) }}</p>
    </div>
</div>

{{-- ================= GRAPH ================= --}}
<div class="bg-white p-6 rounded-2xl shadow mb-10">
    <h2 class="text-lg font-bold text-[#5a3e36] mb-4">
        Monthly Earnings
    </h2>
    <canvas id="salesChart" height="100"></canvas>
</div>

{{-- ================= PRODUCTS ================= --}}
<h2 class="text-xl font-bold text-[#5a3e36] mb-4">
    My Products
</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
@forelse($products as $p)
    <div class="bg-white rounded-2xl shadow p-4 relative
        {{ $p->status === 'sold' ? 'opacity-70' : '' }}">

        <img src="{{ asset('storage/'.$p->image) }}"
            class="h-40 w-full object-cover rounded-xl mb-3">

        <h3 class="font-semibold text-sm">{{ $p->name }}</h3>

        <p class="text-xs text-gray-500 mb-1">
            {{ optional($p->category)->name }}
        </p>

        <p class="font-bold text-[#5a3e36] mb-2">
            ₹{{ number_format($p->price,2) }}
        </p>

        @if($p->status === 'sold')
            <span class="absolute top-3 right-3 bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full">
                Sold
            </span>
        @else
            <span class="absolute top-3 right-3 bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">
                Available
            </span>
        @endif
    </div>
@empty
    <p class="text-gray-500">No products added yet.</p>
@endforelse
</div>

{{-- ================= CATEGORY MODAL ================= --}}
<div id="categoryModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-96 rounded-2xl p-6">
        <h2 class="text-xl font-bold mb-4">Add Category</h2>

        <form method="POST" action="{{ route('supplier.category.add') }}" enctype="multipart/form-data">
            @csrf

            <input name="name" required
                class="border p-2 w-full rounded mb-3"
                placeholder="Category name">

            <input type="file" name="image" class="mb-3">

            <button class="bg-[#c07a35] text-white w-full py-2 rounded-full">
                Save Category
            </button>
        </form>

        <button onclick="closeCategoryModal()"
            class="mt-3 text-sm text-gray-500 w-full">
            Cancel
        </button>
    </div>
</div>

{{-- ================= PRODUCT MODAL ================= --}}
<div id="allCategoriesModal"
 class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

 <div class="bg-white w-[500px] rounded-2xl p-6">
   <h2 class="text-xl font-bold mb-4">All Categories</h2>

   @foreach($categories as $cat)

@php
$locked = \App\Models\Product::where('category_id',$cat->id)->exists();
@endphp

<div class="flex justify-between items-center border-b py-2">
    <span>{{ $cat->name }}</span>

    @if(!$locked)
        <div class="flex gap-3">
            <!-- EDIT -->
            <button onclick="openEditCategory({{ $cat->id }}, '{{ $cat->name }}')">
                ✏️
            </button>

            <!-- DELETE -->
            <form method="POST"
                action="{{ route('supplier.category.delete',$cat->id) }}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Delete category?')">🗑</button>
            </form>
        </div>
    @else
        <span class="text-xs text-gray-400 font-semibold">
            In Use 🔒
        </span>
    @endif
</div>
@endforeach


   {{-- EDIT FORM --}}
   <form id="editCategoryForm"
     method="POST"
     class="hidden mt-4">
     @csrf
     @method('PUT')

     <input id="editCategoryName"
       name="name"
       class="border p-2 w-full rounded mb-3">

     <button class="bg-[#c07a35] text-white w-full py-2 rounded-full">
       Update Category
     </button>
   </form>

   <button onclick="closeAllCategoriesModal()"
     class="mt-3 text-sm text-gray-500 w-full">Close</button>
 </div>
</div>
<div id="allProductsModal"
 class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

 <div class="bg-white w-[500px] rounded-2xl p-6">
   <h2 class="text-xl font-bold mb-4">All Products</h2>

   @foreach($products as $p)
<div class="flex justify-between items-center border-b py-2">
    <span>{{ $p->name }}</span>

    @if($p->status === 'available')
        <div class="flex gap-3">
            <!-- EDIT -->
            <button onclick="openEditProduct(
                {{ $p->id }},
                '{{ $p->name }}',
                '{{ $p->price }}'
            )">✏️</button>

            <!-- DELETE -->
            <form method="POST"
                  action="{{ route('supplier.product.delete',$p->id) }}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Delete product?')">🗑</button>
            </form>
        </div>
    @else
        <span class="text-xs text-red-500 font-semibold">
            Sold 🔒
        </span>
    @endif
</div>
@endforeach

   {{-- EDIT FORM --}}
   <form id="editProductForm"
     method="POST"
     class="hidden mt-4">
     @csrf
     @method('PUT')

     <input id="editProductName"
       name="name"
       class="border p-2 w-full rounded mb-2">

     <input id="editProductPrice"
       name="price"
       class="border p-2 w-full rounded mb-3">

     <button class="bg-[#5a3e36] text-white w-full py-2 rounded-full">
       Update Product
     </button>
   </form>

   <button onclick="closeAllProductsModal()"
     class="mt-3 text-sm text-gray-500 w-full">Close</button>
 </div>
</div>

<div id="productModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-96 rounded-2xl p-6">
        <h2 class="text-xl font-bold mb-4">Add Product</h2>

        <form method="POST" action="{{ route('supplier.product.add') }}" enctype="multipart/form-data">
            @csrf

            <select name="supplier_category_id" required
                class="border p-2 w-full rounded mb-3">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <input name="name" required
                class="border p-2 w-full rounded mb-3"
                placeholder="Product name">

            <input name="price" required
                class="border p-2 w-full rounded mb-3"
                placeholder="Price">
                <div class="mb-4">
    
    <input type="number"
           name="qty"
           min="1"
           placeholder="quantity"
           required
           class="border p-2 w-full rounded mb-3">
</div>


            <input type="file" name="image" class="mb-3">

            <button class="bg-[#5a3e36] text-white w-full py-2 rounded-full">
                Save Product
            </button>
        </form>

        <button onclick="closeProductModal()"
            class="mt-3 text-sm text-gray-500 w-full">
            Cancel
        </button>
    </div>
</div>

</div>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function openAllCategoriesModal(){
 document.getElementById('allCategoriesModal').classList.remove('hidden');
 document.getElementById('allCategoriesModal').classList.add('flex');
}
function closeAllCategoriesModal(){
 document.getElementById('allCategoriesModal').classList.add('hidden');
}

function openEditCategory(id,name){
 let form=document.getElementById('editCategoryForm');
 form.classList.remove('hidden');
 form.action='/supplier/category/update/'+id;
 document.getElementById('editCategoryName').value=name;
}

// PRODUCTS
function openAllProductsModal(){
 document.getElementById('allProductsModal').classList.remove('hidden');
 document.getElementById('allProductsModal').classList.add('flex');
}
function closeAllProductsModal(){
 document.getElementById('allProductsModal').classList.add('hidden');
}

function openEditProduct(id,name,price){
 let form=document.getElementById('editProductForm');
 form.classList.remove('hidden');
 form.action='/supplier/product/update/'+id;
 document.getElementById('editProductName').value=name;
 document.getElementById('editProductPrice').value=price;
}
</script>

<script>
function openCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('categoryModal').classList.add('flex');
}
function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}

function openProductModal() {
    document.getElementById('productModal').classList.remove('hidden');
    document.getElementById('productModal').classList.add('flex');
}
function closeProductModal() {
    document.getElementById('productModal').classList.add('hidden');
}

new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlySales->keys()) !!},
        datasets: [{
            label: 'Earnings ₹',
            data: {!! json_encode($monthlySales->values()) !!},
            backgroundColor: '#c07a35'
        }]
    }
});
</script>
@endsection
