@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">

    <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('partner.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="block font-semibold">Full Name</label>
        <input type="text" name="full_name" value="{{ $partner->full_name }}"
               class="w-full border p-2 rounded mb-3" required>

        <label class="block font-semibold">Father Name</label>
        <input type="text" name="father_name" value="{{ $partner->father_name }}"
               class="w-full border p-2 rounded mb-3">

        <label class="block font-semibold">City</label>
        <input type="text" name="city" value="{{ $partner->city }}"
               class="w-full border p-2 rounded mb-3" required>

        <label class="block font-semibold">State</label>
        <input type="text" name="state" value="{{ $partner->state }}"
               class="w-full border p-2 rounded mb-3" required>

        <label class="block font-semibold">Address</label>
        <textarea name="address" class="w-full border p-2 rounded mb-3">{{ $partner->address }}</textarea>

        <label class="block font-semibold">Vehicle Type</label>
        <select name="vehicle_type" class="w-full border p-2 rounded mb-3" required>
            <option value="bike" {{ $partner->vehicle_type == 'bike' ? 'selected' : '' }}>Bike</option>
            <option value="scooty" {{ $partner->vehicle_type == 'scooty' ? 'selected' : '' }}>Scooty</option>
            <option value="cycle" {{ $partner->vehicle_type == 'cycle' ? 'selected' : '' }}>Cycle</option>
        </select>

        <label class="block font-semibold">Profile Photo</label>
        <input type="file" name="profile_photo" class="w-full border p-2 rounded mb-4">

        @if($partner->profile_photo)
            <img src="{{ asset('storage/'.$partner->profile_photo) }}" width="100" class="rounded mb-3">
        @endif

        <button class="w-full bg-orange-600 text-white py-2 rounded">
            Update Profile
        </button>
    </form>

</div>

@endsection
