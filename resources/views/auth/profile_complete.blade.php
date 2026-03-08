@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mitti-cream py-12 px-4">
    
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-2xl p-8 border border-mitti-primary/20">
        
        <h2 class="text-3xl font-bold text-mitti-dark mb-6 text-center">
            Complete Your Profile
        </h2>

        <form method="POST" action="{{ route('profile.complete') }}" class="space-y-6">
            @csrf

            {{-- Name Field --}}
            <div>
                <label class="block text-mitti-dark font-medium mb-2">Full Name</label>
                <input 
                    name="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                    class="w-full px-4 py-3 border border-mitti-primary/30 rounded-xl focus:ring-2 focus:ring-mitti-primary focus:outline-none"
                    placeholder="Enter your name"
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button 
                type="submit"
                class="w-full bg-mitti-primary text-white py-3 rounded-xl text-lg font-semibold hover:bg-mitti-dark transition">
                Save & Continue
            </button>

        </form>
    </div>
</div>
@endsection
