@extends('layouts.app')

@section('content')
<h2>Login with phone</h2>
@if(session('status')) <div>{{ session('status') }}</div> @endif
<form method="POST" action="{{ route('login.phone.send') }}">
  @csrf
  <label>Phone</label>
  <input name="phone" value="{{ old('phone') }}" required>
  @error('phone') <div>{{ $message }}</div> @enderror
  <button type="submit">Send OTP</button>
</form>
@endsection
