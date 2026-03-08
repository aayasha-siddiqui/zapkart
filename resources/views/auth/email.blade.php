@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-20 bg-white p-8 rounded shadow">

    <h2 class="text-2xl font-bold mb-4">Login With Email</h2>

    @if(session('status'))
        <div class="text-green-600 mb-2">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login.email.send') }}">
        @csrf

        <label class="font-semibold">Email</label>
        <input type="email" name="email" class="w-full p-2 border rounded mb-2" required>

        @error('email')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700 mt-4">
            Send OTP
        </button>
    </form>
</div>
@endsection
