@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Verify OTP</h2>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        <label class="font-semibold">Enter OTP</label>
        <input name="code" required class="w-full border p-2 rounded mb-3">

        <button class="w-full bg-blue-600 text-white p-2 rounded">
            Verify
        </button>
    </form>

</div>
@endsection
