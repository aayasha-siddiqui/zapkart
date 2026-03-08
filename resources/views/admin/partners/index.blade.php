@extends('layouts.app')
@section('content')

<style>

:root{
    --p:#B68A60;
    --dark:#4b3525;
    --light:#F5EFE7;
    --bg:#FAF7F2;

    --success:#27ae60;
    --danger:#e74c3c;
    --pending:#f1c40f;
    --muted:#8c8f94;
}

/* PAGE */
.page {
    padding:32px;
    background:var(--bg);
    min-height:100vh;
    font-family:Inter, sans-serif;
}

/* TOP BAR */
.top-flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

.page-title {
    font-size:30px;
    font-weight:900;
    color:var(--dark);
}

/* SEARCH BAR */
.search-bar{
    background:white;
    padding:10px 18px;
    border-radius:30px;
    width:280px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}
.search-bar input{
    border:none;
    outline:none;
    font-size:14px;
    width:100%;
}

/* LIVE TRACKING BTN */
.live-btn{
    background:#00A36C;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    font-weight:700;
    text-decoration:none;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

/* SUMMARY BOXES */
.summary{
    display:flex;
    gap:16px;
    margin-top:30px;
    flex-wrap:wrap;
}
.summary-box{
    background:white;
    padding:18px 24px;
    border-radius:14px;
    box-shadow:0 4px 14px rgba(0,0,0,0.06);
    border-left:6px solid var(--p);
    min-width:160px;
}
.summary-title{
    font-size:13px;
    color:var(--muted);
}
.summary-value{
    font-size:26px;
    font-weight:900;
    margin-top:4px;
    color:var(--dark);
}

/* SECTION TITLE */
.section-title{
    font-size:22px;
    font-weight:800;
    color:var(--p);
    margin-top:35px;
    margin-bottom:16px;
}

/* DRIVER CARD GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));
    gap:22px;
}

/* DRIVER CARD */
.driver-card{
    background:white;
    padding:22px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    border:1px solid #eee;
    transition:0.25s;
}
.driver-card:hover{
    transform:translateY(-4px);
    box-shadow:0 16px 32px rgba(0,0,0,0.15);
}

/* AVATAR */
.avatar{
    width:70px;
    height:70px;
    border-radius:14px;
    overflow:hidden;
    background:var(--p);
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-size:24px;
    font-weight:800;
}
.avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* INFO */
.name{
    font-size:19px;
    font-weight:800;
    color:var(--dark);
}
.meta{
    margin-top:6px;
    font-size:13px;
    color:var(--muted);
    line-height:18px;
}

/* BADGE */
.badge{
    padding:7px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
}
.badge.pending{ background:#fff8d6; color:#856404; }
.badge.approved{ background:#d7fbe9; color:#145a32; }
.badge.rejected{ background:#ffd3d3; color:#a12222; }

/* BUTTONS */
.btn{
    padding:8px 15px;
    border-radius:8px;
    font-size:13px;
    font-weight:700;
    border:none;
    cursor:pointer;
    width:100%;
}
.btn-success{ background:var(--success); color:white; }
.btn-danger{ background:var(--danger); color:white; }
.btn-outline{
    border:1px solid var(--p);
    color:var(--p);
    background:white;
}

.card-actions{
    display:flex;
    flex-direction:column;
    gap:8px;
    width:120px;
}

.info-area{
    display:flex;
    gap:18px;
    align-items:flex-start;
}

</style>

<div class="page">

    <!-- TOP AREA -->
    <div class="top-flex">
        <h1 class="page-title">Manage Drivers</h1>

        <div style="display:flex; gap:14px;">
            <div class="search-bar">
                <input id="driver-search" placeholder="Search drivers...">
            </div>

            <a href="{{ route('admin.live.tracking') }}" class="live-btn">🚚 Live Tracking</a>
        </div>
    </div>



    <!-- SUMMARY -->
    <div class="summary">
        <div class="summary-box">
            <div class="summary-title">Pending</div>
            <div class="summary-value">{{ $pending->count() }}</div>
        </div>

        <div class="summary-box">
            <div class="summary-title">Approved</div>
            <div class="summary-value">{{ $approved->count() }}</div>
        </div>

        <div class="summary-box">
            <div class="summary-title">Rejected</div>
            <div class="summary-value">{{ $rejected->count() }}</div>
        </div>
    </div>



    <!-- PENDING SECTION -->
    @if($pending->count() > 0)
    <h3 class="section-title">⏳ Pending Requests</h3>

    <div class="grid">
        @foreach($pending as $d)
        <div class="driver-card">

            <div class="info-area">

                <div class="avatar">
                    @if($d->profile_photo)
                        <img src="{{ asset('storage/'.$d->profile_photo) }}">
                    @else
                        {{ strtoupper(substr($d->full_name, 0, 1)) }}
                    @endif
                </div>

                <div style="flex:1;">
                    <div class="name">{{ $d->full_name }}</div>
                    <div class="meta">
                        Email: {{ $d->user->email ?? 'N/A' }} <br>
                        Phone: {{ $d->phone }} <br>
                        Applied: {{ $d->created_at->format('d M Y') }}
                    </div>
                </div>

                <div class="card-actions">
                    <span class="badge pending">Pending</span>

                    <form method="POST" action="{{ route('admin.partners.approve',$d->id) }}">
                        @csrf
                        <button class="btn btn-success">Approve</button>
                    </form>
                    

                    <form method="POST" action="{{ route('admin.partners.reject',$d->id) }}">
                        @csrf
                        <button class="btn btn-danger">Reject</button>
                    </form>
                </div>

            </div>

        </div>
        @endforeach
    </div>
    @endif




    <!-- APPROVED SECTION -->
    @if($approved->count() > 0)
    <h3 class="section-title">✅ Approved Drivers</h3>

    <div class="grid">
        @foreach($approved as $d)
        <div class="driver-card">

            <div class="info-area">

                <div class="avatar">
                    @if($d->profile_photo)
                        <img src="{{ asset('storage/'.$d->profile_photo) }}">
                    @else
                        {{ strtoupper(substr($d->full_name, 0, 1)) }}
                    @endif
                </div>

                <div style="flex:1;">
                    <div class="name">{{ $d->full_name }}</div>
                    <div class="meta">
                        Email: {{ $d->user->email }} <br>
                        
                        Joined: {{ $d->updated_at->format('d M Y') }}
                    </div>
                </div>

                <div class="card-actions">
                    <span class="badge approved">Approved</span>

                    <a href="{{ route('admin.partners.show',$d->id) }}" class="btn btn-outline">View</a>

                    <form method="POST" action="{{ route('admin.partners.block',$d->id) }}">
                        @csrf
                        <button class="btn btn-danger">Block</button>
                    </form>
                </div>

            </div>

        </div>
        @endforeach
    </div>
    @endif

</div>

@endsection
