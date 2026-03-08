@extends('layouts.app')

@section('content')
<div style="padding: 10px;">

    <!-- ========================= -->
    <!--   HEADER SECTION          -->
    <!-- ========================= -->
    <h2 style="font-weight:800; font-size:22px; margin-bottom:8px;">Delivery Partners</h2>
    <p style="color:#7c726d; margin-bottom:22px;">Manage pending requests & active riders</p>


    <!-- ========================= -->
    <!--   PENDING REQUESTS ROW    -->
    <!-- ========================= -->
    <h3 style="font-size:17px; font-weight:700; margin-bottom:10px;">Pending Requests</h3>

    @if($pendingPartners->count() > 0)
    <div style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(320px,1fr));
        gap:16px;
        margin-bottom:28px;
    ">
        @foreach($pendingPartners as $p)
        <div style="
            background:#fff;
            border-radius:16px;
            padding:18px;
            border:1px solid #e0d4c5;
            box-shadow:0 10px 22px rgba(90,62,54,0.08);
        ">
            <!-- Header -->
            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                <div style="font-size:14px; font-weight:700;">
                    {{ $p->full_name }}
                </div>

                <span style="
                    background:#f7c26f;
                    padding:3px 10px;
                    border-radius:10px;
                    font-size:11px;
                    font-weight:700;
                    color:#7a4f01;
                ">
                    Pending
                </span>
            </div>

            <!-- Location -->
            <div style="font-size:13px; color:#333;">
                <strong>City:</strong> {{ $p->city }} <br>
                <strong>Vehicle:</strong> {{ strtoupper($p->vehicle_type) }}
            </div>

            <div style="height:1px; background:#eee; margin:12px 0;"></div>

            <!-- Buttons -->
            <div style="display:flex; gap:10px;">
                
                <form method="POST" action="{{ route('admin.partners.approve', $p->id) }}">
                    @csrf
                    <button style="
                        background:#2e7d32;
                        color:white;
                        border:none;
                        padding:8px 14px;
                        border-radius:10px;
                        cursor:pointer;
                        font-size:12px;
                        width:100px;
                    ">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.partners.reject', $p->id) }}">
                    @csrf
                    <button style="
                        background:#c62828;
                        color:white;
                        border:none;
                        padding:8px 14px;
                        border-radius:10px;
                        cursor:pointer;
                        font-size:12px;
                        width:100px;
                    ">Reject</button>
                </form>

            </div>

            <a href="{{ route('admin.partners.show', $p->id) }}" 
               style="font-size:12px; color:#8a6a52; margin-top:10px; display:inline-block;">
                View Details →
            </a>
        </div>
        @endforeach
    </div>
    @else
        <div style="
            padding:14px;
            background:#f7f0e7;
            border:1px dashed #b8a696;
            border-radius:12px;
            font-size:13px;
            color:#7c726d;
            margin-bottom:25px;
        ">
            No pending partner requests.
        </div>
    @endif



    <!-- ========================= -->
    <!--   APPROVED PARTNERS       -->
    <!-- ========================= -->
    <h3 style="font-size:17px; font-weight:700; margin-bottom:10px;">Approved Partners</h3>

    <div style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(300px,1fr));
        gap:16px;
    ">
        @foreach($approvedPartners as $p)
        <div style="
            background:#fff;
            border-radius:16px;
            padding:18px;
            border:1px solid #e0d4c5;
            box-shadow:0 10px 22px rgba(90,62,54,0.08);
        ">
            <div style="display:flex; justify-content:space-between;">
                <div style="font-size:14px; font-weight:700;">
                    {{ $p->full_name }}
                </div>

                <span style="
                    background:#b9e4c9;
                    padding:3px 10px;
                    border-radius:10px;
                    font-size:11px;
                    font-weight:700;
                    color:#0c5d26;
                ">
                    Approved
                </span>
            </div>

            <div style="margin-top:10px; font-size:13px;">
                <strong>City:</strong> {{ $p->city }} <br>
                <strong>Vehicle:</strong> {{ strtoupper($p->vehicle_type) }}
            </div>

            <a href="{{ route('admin.partners.show', $p->id) }}" 
               style="font-size:12px; color:#8a6a52; margin-top:12px; display:inline-block;">
                View Details →
            </a>
        </div>
        @endforeach
    </div>

</div>
@endsection
