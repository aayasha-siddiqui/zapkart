@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-4">Add Shopkeeper</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.shopkeepers.store') }}">
        @csrf

        <input name="name" placeholder="Shopkeeper Name"
               class="w-full border p-2 mb-3" required>

        <input name="email" type="email" placeholder="Email"
               class="w-full border p-2 mb-3" required>

        <input name="password" type="password" placeholder="Password"
               class="w-full border p-2 mb-3" required>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Create Shopkeeper
        </button>
    </form>

</div>
@endsection
