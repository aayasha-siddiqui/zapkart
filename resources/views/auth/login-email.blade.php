@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center">
<form method="POST" action="{{ route('login.submit') }}" class="bg-white p-8 rounded shadow w-96">
@csrf
<h2 class="text-2xl font-bold mb-4">Login / Register</h2>
<input name="email" type="email" required placeholder="Enter email"
class="w-full border p-3 mb-4 rounded">
<button class="w-full bg-blue-600 text-white py-2 rounded">Continue</button>
</form>
</div>
@endsection
