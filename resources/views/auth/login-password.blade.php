@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
<form method="POST" action="{{ route('login.password') }}" class="bg-white p-8 rounded shadow w-96">
@csrf
<h2 class="text-2xl font-bold mb-4">Login</h2>

<input type="email" name="email" value="{{ $email }}" readonly
class="w-full border p-3 mb-4 rounded">

<input type="password" name="password" placeholder="Password"
class="w-full border p-3 mb-4 rounded">

<button class="w-full bg-green-600 text-white py-2 rounded">Login</button>
</form>
</div>
@endsection
