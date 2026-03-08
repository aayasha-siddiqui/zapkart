@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
<form method="POST" action="{{ route('password.set') }}" class="bg-white p-8 rounded shadow w-96">
@csrf
<h2 class="text-2xl font-bold mb-4">Set Password</h2>

<input type="password" name="password" placeholder="New Password"
class="w-full border p-3 mb-4 rounded">

<input type="password" name="password_confirmation" placeholder="Confirm Password"
class="w-full border p-3 mb-4 rounded">

<button class="w-full bg-indigo-600 text-white py-2 rounded">Save Password</button>
</form>
</div>
@endsection
