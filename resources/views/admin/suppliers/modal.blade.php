<div id="supplierModal"
     style="position:fixed; inset:0; background:rgba(0,0,0,0.45);
            display:none; align-items:center; justify-content:center; z-index:999;">

  <div class="bg-white rounded-xl p-6 w-[420px] relative shadow-xl">

    <h3 class="text-xl font-extrabold text-[#6b4f2c] mb-4">
      Add Supplier
    </h3>

    <button onclick="closeSupplierModal()"
            class="absolute right-4 top-4 text-xl">✕</button>

    <form method="POST" action="{{ route('admin.suppliers.add') }}" class="space-y-3">
      @csrf

      <input name="name" placeholder="Supplier Name" required class="input">
      <input name="business_name" placeholder="Business Name" required class="input">
      <input name="phone" placeholder="Phone" required class="input">
      <input name="email" placeholder="Email" required class="input">
      <input name="gst" placeholder="GST (optional)" class="input">
      <textarea name="address" placeholder="Address" class="input"></textarea>

      <button class="w-full bg-[#6b4f2c] text-white py-2 rounded font-semibold">
        Add Supplier
      </button>
    </form>

  </div>
</div>

<script>
function openSupplierModal(){
  document.getElementById('supplierModal').style.display = 'flex';
}
function closeSupplierModal(){
  document.getElementById('supplierModal').style.display = 'none';
}
</script>

<style>
.input{
  width:100%;
  padding:10px;
  border-radius:8px;
  border:1px solid #c2a27e;
}
</style>
