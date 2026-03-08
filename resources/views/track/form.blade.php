@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Track Your ZEPKART Order</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('track.search') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <label class="block text-sm font-medium">Courier</label>
        <input name="courier" value="ZEPKART" class="w-full border p-3 rounded" />

        <label class="block text-sm font-medium">Tracking ID (AWB)</label>
        <input name="awb" placeholder="Enter tracking id e.g. ZEP98322451" class="w-full border p-3 rounded" required />

        <div class="flex gap-2">
            <button class="bg-mitti-primary text-white px-4 py-2 rounded">Track</button>
            <a href="{{ url('/') }}" class="px-4 py-2 border rounded">Back to shop</a>
        </div>
    </form>
</div>
@endsection
