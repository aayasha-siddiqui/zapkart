@extends('layouts.app')

@section('title', 'Become a Seller')

@section('content')
<div class="min-h-screen bg-[#f5efe7] flex items-center justify-center px-4">

    <div class="w-full max-w-3xl bg-white border border-[#d6c2a8] rounded-2xl shadow-lg overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-[#6b4f2c] to-[#8b6a43] p-6 text-center">
            <h2 class="text-3xl font-extrabold text-white">
                Become a Seller
            </h2>
            <p class="text-[#f5efe7] mt-2 text-sm">
                Start selling your products directly to customers
            </p>
        </div>

        {{-- CONTENT --}}
        <div class="p-8 space-y-6">

            {{-- SUCCESS / ERROR --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded-lg border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded-lg border border-red-300">
                    {{ session('error') }}
                </div>
            @endif

            {{-- INFO BOX --}}
            <div class="bg-[#faf7f2] border border-[#e1d2bf] rounded-xl p-5">
                <h3 class="text-lg font-bold text-[#6b4f2c] mb-2">
                    Why become a seller?
                </h3>
                <ul class="list-disc pl-5 text-[#5a4632] text-sm space-y-1">
                    <li>Add and manage your own products</li>
                    <li>Track orders and earnings</li>
                    <li>Get direct payments to your account</li>
                    <li>Grow your business online</li>
                </ul>
            </div>

            {{-- FORM --}}
            <form method="POST" action="/become-seller" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @csrf

                {{-- BUSINESS NAME --}}
                <div class="md:col-span-2">
                    <label class="block text-[#6b4f2c] font-semibold mb-1">
                        Business Name
                    </label>
                    <input
                        type="text"
                        name="business_name"
                        placeholder="Enter your shop or brand name"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-[#c2a27e] focus:outline-none focus:ring-2 focus:ring-[#c2a27e]"
                    >
                </div>

                {{-- GST --}}
                <div>
                    <label class="block text-[#6b4f2c] font-semibold mb-1">
                        GST Number (optional)
                    </label>
                    <input
                        type="text"
                        name="gst"
                        placeholder="Enter GST number if available"
                        class="w-full px-4 py-3 rounded-lg border border-[#c2a27e] focus:outline-none focus:ring-2 focus:ring-[#c2a27e]"
                    >
                </div>

                
                {{-- SUBMIT --}}
                <div class="md:col-span-2 pt-4">
                    <button
                        type="submit"
                        class="w-full bg-[#6b4f2c] text-white py-3 rounded-xl font-bold text-lg hover:bg-[#8b6a43] transition shadow-md"
                    >
                        Submit Seller Request
                    </button>

                    <p class="text-center text-sm text-[#7a644a] mt-3">
                        After approval, you can add products from your dashboard
                    </p>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
