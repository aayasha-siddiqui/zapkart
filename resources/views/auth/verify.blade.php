@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 border border-mitti-primary/20">

        {{-- Heading --}}
        <h2 class="text-3xl font-bold text-mitti-dark text-center mb-4">
            Verify OTP
        </h2>

        {{-- Status Message --}}
        @if(session('status'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-xl text-center">
                {{ session('status') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            {{-- OTP Field --}}
            <div>
                <label class="block text-mitti-dark font-medium mb-2">Enter OTP</label>
                <input 
                    type="text" 
                    name="code" 
                    maxlength="6"
                    placeholder="Enter 6-digit code"
                    class="w-full px-4 py-3 border border-mitti-primary/30 rounded-xl focus:ring-2 focus:ring-mitti-primary focus:outline-none tracking-widest text-center text-lg"
                    required
                >
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button 
                class="w-full bg-mitti-primary text-white py-3 rounded-xl text-lg font-semibold hover:bg-mitti-dark transition">
                Verify OTP
            </button>

        </form>

        {{-- Resend Link --}}
        <div class="text-center mt-6">
           
        </div>

    </div>

</div>
@endsection
