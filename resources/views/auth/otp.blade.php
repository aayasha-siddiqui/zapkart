@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-mitti-cream">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-4 text-mitti-dark">
            OTP Verification
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-2 rounded mb-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <input type="email"
                   name="email"
                   value="{{ $email }}"
                   readonly
                   class="w-full border p-3 mb-4 rounded">

            <input type="text"
                   name="code"
                   placeholder="Enter OTP"
                   class="w-full border p-3 mb-4 rounded"
                   required>

            <button class="w-full bg-mitti-primary text-white py-3 rounded-xl">
                Verify OTP
            </button>
        </form>

    </div>
    
</div>
@endsection
