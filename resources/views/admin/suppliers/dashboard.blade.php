@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5efe7] p-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-4xl font-extrabold text-[#5a3e2b] tracking-wide">
            Suppliers
        </h1>

        <button onclick="openSupplierModal()"
            class="px-6 py-2 rounded-full bg-[#6b4f2c] text-white
                   font-semibold shadow-lg hover:bg-[#5a3e22]
                   transition transform hover:scale-105">
            + Add Supplier
        </button>
    </div>

    {{-- ================= SEARCH ================= --}}
    <div class="mb-5">
        <input type="text" id="searchInput"
            placeholder="🔍 Search supplier by name, business, phone..."
            class="w-full md:w-1/3 px-4 py-2 rounded-xl border
                   focus:ring focus:ring-[#6b4f2c] outline-none shadow">
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-[#d2b48c]
                overflow-hidden animate-fade-in">

        <table class="w-full text-sm">
            <thead class="bg-[#f5efe7] text-[#6b4f2c] text-sm">
                <tr>
                    <th class="p-4 text-left">Supplier ID</th>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Business</th>
                    <th class="p-4 text-left">Phone</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">GST</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody id="supplierTable">
                @forelse($suppliers as $s)
                <tr class="border-t transition
                           hover:bg-[#faf7f2]
                           hover:scale-[1.01]">
                    <td class="p-4 font-bold text-[#5a3e2b]">
                        {{ $s->supplier_code }}
                    </td>
                    <td class="p-4">{{ $s->name }}</td>
                    <td class="p-4">{{ $s->business_name }}</td>
                    <td class="p-4">{{ $s->phone }}</td>
                    <td class="p-4">{{ $s->email }}</td>
                    <td class="p-4">{{ $s->gst ?? '-' }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $s->status === 'active'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </td>
                    <td class="p-4">
                        <a href="{{ route('admin.suppliers.show', $s->id) }}"
                           class="px-4 py-1.5 rounded-full text-sm
                                  bg-[#6b4f2c] text-white
                                  hover:bg-[#5a3e22]
                                  transition shadow hover:shadow-xl">
                            View Products
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8"
                        class="p-6 text-center text-gray-400">
                        No suppliers found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@include('admin.suppliers.modal')
@endsection
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#supplierTable tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';
    });
});
</script>
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in {
    animation: fadeIn 0.6s ease-in-out;
}
</style>
