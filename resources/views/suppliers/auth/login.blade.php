@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-mitti-primary/20 overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-mitti-primary/10 px-8 py-6 text-center">
            <h2 class="text-3xl font-extrabold text-mitti-dark">
                Supplier Login
            </h2>
            <p class="text-sm text-mitti-dark/70 mt-2">
                Login to manage products & warehouse supply
            </p>
        </div>

        {{-- FORM --}}
        <div class="px-8 py-8">
            <form method="POST" action="{{ route('supplier.login') }}" class="space-y-6">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label class="block text-mitti-dark font-medium mb-2">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        required
                        placeholder="supplier@example.com"
                        class="w-full px-4 py-3 rounded-xl border border-mitti-primary/30 
                               focus:ring-2 focus:ring-mitti-primary 
                               focus:outline-none text-mitti-dark"
                    >
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="block text-mitti-dark font-medium mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        placeholder="Enter your password"
                        class="w-full px-4 py-3 rounded-xl border border-mitti-primary/30 
                               focus:ring-2 focus:ring-mitti-primary 
                               focus:outline-none text-mitti-dark"
                    >
                </div>

                {{-- LOGIN BUTTON --}}
                <button 
                    type="submit"
                    class="w-full bg-mitti-primary text-white py-3 rounded-xl 
                           font-semibold text-lg hover:bg-mitti-dark transition">
                    Login as Supplier
                </button>
            </form>
        </div>

        {{-- FOOTER --}}
        <div class="bg-mitti-cream px-8 py-4 text-center text-sm text-mitti-dark/70">
            © {{ date('Y') }} Zapkart Supplier Panel
        </div>

    </div>

</div>
@endsection
