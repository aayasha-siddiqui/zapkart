@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded shadow max-w-lg w-full">
        @if($partner)
            <h2 class="text-xl font-bold mb-4">Application Status: {{ strtoupper($partner->status) }}</h2>
            <p>Partner Code: {{ $partner->partner_code ?? '—' }}</p>
            <p>Submitted on: {{ $partner->created_at->format('d M, Y') }}</p>
            @if($partner->status == 'rejected')
                <p class="text-red-600 mt-4">Your application was rejected. Please contact support or re-apply.</p>
            @endif
        @else
            <p>No application found. <a href="{{ route('partner.register') }}" class="text-mitti-primary">Apply now</a></p>
        @endif
    </div>
</div>
@endsection
