@extends('layouts.app')

@section('content')

<div class="topbar">
    <div class="topbar-left">
        <div>
            <div class="topbar-title">Pending Delivery Partners</div>
            <div class="topbar-subtitle">Review & Approve Rider Applications</div>
        </div>
    </div>
</div>

<div class="card" style="padding:18px; border-radius:16px;">
    <h3 style="font-size:18px; font-weight:700; margin-bottom:10px;">Pending Requests</h3>

    @if($partners->count() == 0)
        <div class="empty-box">No pending partner applications right now.</div>
    @else
        <table style="width:100%; border-collapse:collapse; margin-top:10px;">
            <thead>
                <tr style="text-align:left; background:#f7f0e7;">
                    <th style="padding:10px;">Name</th>
                    <th style="padding:10px;">City</th>
                    <th style="padding:10px;">Vehicle</th>
                    <th style="padding:10px;">Status</th>
                    <th style="padding:10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partners as $p)
                    <tr style="border-bottom:1px solid #e4d7c7;">
                        <td style="padding:10px;">{{ $p->full_name }}</td>

                        <td style="padding:10px;">{{ $p->city }}</td>

                        <td style="padding:10px; text-transform:capitalize;">
                            {{ $p->vehicle_type }}
                        </td>

                        <td style="padding:10px;">
                            <span class="badge" style="background:#f6dcb8; color:#8a6a52;">
                                ⏳ Pending
                            </span>
                        </td>

                        <td style="padding:10px;">
                            <a href="{{ route('admin.partners.show', $p->id) }}"
                               class="badge"
                               style="background:#c07a35; color:#fff; cursor:pointer;">
                               View →
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>

@endsection
