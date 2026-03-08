@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Login with Email</h2>

    @if(session('status'))
        <p class="text-green-600 mb-3">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('login.phone.send') }}">
        @csrf

        <label class="font-semibold">Email</label>
        <input name="email" type="email" required
               class="w-full border p-2 rounded mb-3">

        <button class="w-full bg-green-600 text-white p-2 rounded">
            Send OTP
        </button>
    </form>

</div>
@endsection
