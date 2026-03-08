@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-cream flex justify-center px-4 py-10">
    <div class="w-full max-w-2xl bg-white shadow-lg rounded-xl p-8 border border-mitti-secondary/40">
        <h2 class="text-2xl font-bold text-mitti-dark mb-6 text-center">🚴 Become a Delivery Partner</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('partner.register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Personal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-mitti-dark">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    @error('full_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="font-semibold text-mitti-dark">Father / Guardian Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}" class="w-full mt-1 px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="font-semibold text-mitti-dark">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" class="w-full mt-1 px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="font-semibold text-mitti-dark">Gender</label>
                    <select name="gender" class="w-full mt-1 px-4 py-2 border rounded-lg">
                        <option value="">Select</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            {{-- Profile Photo --}}
            <div class="mt-4">
                <label class="font-semibold text-mitti-dark">Profile Photo (face clearly visible)</label>
                <input type="file" name="profile_photo" class="w-full mt-1">
                @error('profile_photo')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            {{-- Address --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="font-semibold text-mitti-dark">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    @error('city')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="font-semibold text-mitti-dark">State</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    @error('state')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="font-semibold text-mitti-dark">Full Address (optional)</label>
                <textarea name="address" class="w-full mt-1 px-4 py-2 border rounded-lg" rows="2">{{ old('address') }}</textarea>
            </div>

            {{-- Vehicle & License --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="font-semibold text-mitti-dark">Vehicle Type</label>
                    <select name="vehicle_type" class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                        <option value="">Select Vehicle</option>
                        <option value="bike" {{ old('vehicle_type')=='bike' ? 'selected' : '' }}>Bike</option>
                        <option value="scooty" {{ old('vehicle_type')=='scooty' ? 'selected' : '' }}>Scooty</option>
                        <option value="cycle" {{ old('vehicle_type')=='cycle' ? 'selected' : '' }}>Cycle</option>
                    </select>
                    @error('vehicle_type')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="font-semibold text-mitti-dark">Driving License Number</label>
                    <input type="text" name="driving_license_number" value="{{ old('driving_license_number') }}" class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    @error('driving_license_number')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="font-semibold text-mitti-dark">Driving License (Front)</label>
                    <input type="file" name="driving_license_front" class="w-full mt-1" required>
                    @error('driving_license_front')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="font-semibold text-mitti-dark">Driving License (Back) — optional</label>
                    <input type="file" name="driving_license_back" class="w-full mt-1">
                    @error('driving_license_back')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Police verification (optional) --}}
            <div class="mt-4">
                <label class="font-semibold text-mitti-dark">Police Verification (optional)</label>
                <input type="file" name="police_verification" class="w-full mt-1">
                @error('police_verification')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            {{-- Submit --}}
            <div class="mt-6">
                <button type="submit" class="w-full bg-mitti-primary text-white py-3 rounded-lg text-lg font-semibold hover:bg-mitti-dark transition">
                    Submit Application
                </button>
            </div>

            <p class="text-center text-sm text-muted mt-4">After submission your application will be reviewed by admin.</p>
        </form>
    </div>
</div>
@endsection
