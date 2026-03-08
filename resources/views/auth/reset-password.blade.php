@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6">
            Reset Your Password
        </h2>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- Token --}}
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <input
                type="email"
                name="email"
                value="{{ request('email') }}"
                readonly
                class="w-full border p-3 mb-4 rounded">

            {{-- New Password --}}
            <input
                type="password"
                name="password"
                placeholder="New Password"
                required
                class="w-full border p-3 mb-4 rounded">

            {{-- Confirm Password --}}
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                required
                class="w-full border p-3 mb-6 rounded">

            <button class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold">
                Reset Password
            </button>
        </form>

    </div>
</div>
@endsection
