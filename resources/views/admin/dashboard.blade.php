<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Admin Dashboard — ZEPKART</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
:root{
  --bg:#f3e9dd;
  --bg-soft:#f7f0e7;
  --card:#ffffff;
  --panel:#e8d8c4;
  --border:#e1d2c3;

  --mitti-dark:#5a3e36;
  --mitti-mid:#8a6a52;
  --mitti-soft:#c7a17a;
  --mitti-cream:#f3e9dd;

  --muted:#7c726d;
  --accent:#c07a35;

  --success:#2e7d32;
  --danger:#c62828;
  --warning:#d8952a;
}

*{box-sizing:border-box;}
html,body{
  height:100%;
  margin:0;
  font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;
  background:var(--bg);
  color:var(--mitti-dark);
}
body{
  -webkit-font-smoothing:antialiased;
}

/* helpers */
.muted{color:var(--muted);}
.badge{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:3px 8px;
  border-radius:999px;
  font-size:11px;
  font-weight:600;
}

/* layout */
.container{
  display:flex;
  min-height:100vh;
  transition:all .3s ease;
}

/* SIDEBAR */
.sidebar{
  width:260px;
  background:linear-gradient(180deg,#f9f2e9,#f0dfcd);
  border-right:1px solid rgba(90,62,54,0.08);
  padding:22px 18px 20px;
  position:relative;
  display:flex;
  flex-direction:column;
  gap:16px;
  transition:transform .3s ease, box-shadow .3s ease;
}
.brand{
  display:flex;
  align-items:center;
  gap:12px;
  margin-bottom:6px;
}
.logo{
  width:46px;
  height:46px;
  border-radius:16px;
  background:radial-gradient(circle at 10% 0%,#f9f5f1 0,#c07a35 40%,#5a3e36 100%);
  box-shadow:0 8px 18px rgba(90,62,54,0.30);
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
  font-weight:800;
  font-size:18px;
}
.brand-text-main{
  font-weight:800;
  letter-spacing:.06em;
  text-transform:uppercase;
  font-size:15px;
  color:var(--mitti-dark);
}
.brand-text-sub{
  font-size:12px;
  color:var(--muted);
}
.sidebar-section-title{
  margin:12px 4px 4px;
  font-size:11px;
  text-transform:uppercase;
  letter-spacing:.15em;
  color:var(--muted);
}

/* nav */
nav{margin-top:4px;}
.nav-link{
  display:flex;
  align-items:center;
  gap:10px;
  padding:9px 10px;
  border-radius:10px;
  color:var(--mitti-dark);
  font-weight:600;
  font-size:13px;
  text-decoration:none;
  margin-bottom:4px;
  position:relative;
  transition:all .18s ease;
}
.nav-link span.icon{
  width:26px;
  height:26px;
  border-radius:10px;
  background:rgba(192,122,53,0.12);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:15px;
}
.nav-link:hover{
  background:linear-gradient(90deg,rgba(192,122,53,0.14),rgba(243,233,221,0.9));
  transform:translateX(2px);
}
.nav-link.active{
  background:linear-gradient(90deg,#c07a35,#e9c29a);
  color:#fff;
  box-shadow:0 8px 18px rgba(141,98,57,0.35);
}
.nav-link.active span.icon{
  background:rgba(249,245,241,0.25);
}
.nav-link button{
  background:none;
  border:none;
  padding:0;
  margin:0;
  width:100%;
  text-align:left;
  font:inherit;
  color:inherit;
  cursor:pointer;
}

/* sidebar footer small hint */
.sidebar-footer{
  margin-top:auto;
  padding:10px;
  border-radius:12px;
  background:rgba(255,255,255,0.7);
  border:1px dashed rgba(90,62,54,0.18);
  font-size:11px;
  color:var(--muted);
}

/* MAIN */
.main{
  flex:1;
  padding:18px 24px 22px;
  transition:all .3s ease;
}

/* TOPBAR */
.topbar{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:14px;
  margin-bottom:18px;
  flex-wrap:wrap;
}
.topbar-left{
  display:flex;
  align-items:center;
  gap:12px;
}
#menuBtn{
  background:rgba(243,233,221,0.8);
  border:1px solid rgba(192,122,53,0.3);
  padding:7px 9px;
  border-radius:10px;
  cursor:pointer;
  font-size:18px;
  display:none;
}
#menuBtn:hover{
  background:#f0dfcd;
}
.topbar-title{
  font-size:21px;
  font-weight:800;
  color:var(--mitti-dark);
}
.topbar-subtitle{
  font-size:12px;
  color:var(--muted);
}

.search{
  flex:1;
  max-width:520px;
}
.search input{
  width:100%;
  padding:10px 12px 10px 32px;
  border-radius:999px;
  border:1px solid rgba(192,122,53,0.25);
  background:#f9f4ee;
  outline:none;
  font-size:13px;
  color:var(--mitti-dark);
  box-shadow:0 3px 8px rgba(90,62,54,0.12) inset;
  background-image:url("data:image/svg+xml,%3Csvg width='14' height='14' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='11' cy='11' r='6' stroke='%238a6a52' stroke-width='1.5'/%3E%3Cpath d='M16 16L20 20' stroke='%238a6a52' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat:no-repeat;
  background-position:10px 50%;
}
.search input::placeholder{
  color:rgba(124,114,109,0.8);
  font-size:12px;
}

.profile{
  display:flex;
  align-items:center;
  gap:10px;
}
.profile-text{
  text-align:right;
}
.profile-name{
  font-weight:700;
  font-size:13px;
  color:var(--mitti-dark);
}
.profile-role{
  font-size:11px;
  color:var(--muted);
}
.avatar{
  width:40px;
  height:40px;
  border-radius:50%;
  background:radial-gradient(circle at 30% 0%,#f9f5f1 0,#c07a35 35%,#5a3e36 100%);
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
  font-weight:700;
  font-size:14px;
  box-shadow:0 5px 14px rgba(90,62,54,0.45);
}

/* DASHBOARD GRID */
.top-grid{
  display:grid;
  grid-template-columns: minmax(0,1.7fr) minmax(0,1.1fr);
  gap:18px;
  margin-bottom:20px;
}

/* STAT CARDS */
.cards{
  display:grid;
  grid-template-columns:repeat(3, minmax(0,1fr));
  gap:12px;
}
.card{
  background:var(--card);
  padding:14px 14px 12px;
  border-radius:16px;
  border:1px solid rgba(209,188,161,0.55);
  box-shadow:0 12px 22px rgba(90,62,54,0.08);
  display:flex;
  flex-direction:column;
  gap:8px;
  position:relative;
  overflow:hidden;
  isolation:isolate;
  transition:transform .18s ease, box-shadow .2s ease, border-color .2s ease;
}
.card::before{
  content:"";
  position:absolute;
  inset:-30%;
  background:radial-gradient(circle at 0 0,rgba(255,255,255,0.85) 0,transparent 55%),
             radial-gradient(circle at 120% 0,rgba(192,122,53,0.15) 0,transparent 55%);
  opacity:.9;
  z-index:-1;
}
.card:hover{
  transform:translateY(-3px);
  box-shadow:0 16px 28px rgba(90,62,54,0.12);
  border-color:rgba(192,122,53,0.75);
}
.card-top{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:8px;
}
.card-icon{
  width:32px;
  height:32px;
  border-radius:12px;
  background:rgba(192,122,53,0.12);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:18px;
}
.card-label{
  font-size:12px;
  text-transform:uppercase;
  letter-spacing:.14em;
  color:var(--muted);
}
.card-num{
  font-weight:800;
  font-size:22px;
  margin-top:2px;
  color:var(--mitti-dark);
}
.card-footer{
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:11px;
  color:var(--muted);
}
.card-footer span.strong{
  font-weight:600;
  color:var(--mitti-mid);
}

/* small tiles */
.tile-grid{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:10px;
  margin-top:14px;
}
.tile{
  background:linear-gradient(135deg,#f9f1e6,#fff);
  padding:10px 11px;
  border-radius:14px;
  border:1px solid rgba(209,188,161,0.75);
  box-shadow:0 6px 14px rgba(90,62,54,0.10);
  display:flex;
  flex-direction:column;
  gap:3px;
  transition:transform .16s ease, box-shadow .18s ease, border-color .18s ease;
}
.tile:hover{
  transform:translateY(-2px);
  box-shadow:0 10px 20px rgba(90,62,54,0.14);
  border-color:rgba(192,122,53,0.9);
}
.tile-label{
  font-size:11px;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:var(--muted);
}
.tile-value{
  font-weight:800;
  font-size:17px;
  color:var(--mitti-dark);
}
.tile-sub{
  font-size:11px;
  color:var(--muted);
}

/* chart card */
.chart-card{
  padding:15px 15px 12px;
  border-radius:16px;
  background:linear-gradient(180deg,#fff,#f4e6d6);
  border:1px solid rgba(209,188,161,0.85);
  box-shadow:0 14px 26px rgba(90,62,54,0.16);
  display:flex;
  flex-direction:column;
  gap:10px;
}
.chart-header{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:8px;
}
.chart-title{
  font-weight:800;
  font-size:15px;
  color:var(--mitti-dark);
}
.chart-sub{
  font-size:12px;
  color:var(--muted);
}
.chart-figure{
  text-align:right;
}
.chart-figure-main{
  font-weight:800;
  font-size:18px;
}
.chart-figure-sub{
  font-size:11px;
  color:var(--muted);
}
.chart-legend-inline{
  display:flex;
  flex-wrap:wrap;
  gap:8px;
  margin-top:4px;
}
.chart-pill{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:4px 8px;
  border-radius:999px;
  font-size:11px;
  background:rgba(255,255,255,0.8);
  border:1px solid rgba(209,188,161,0.7);
}
.chart-pill-dot{
  width:8px;
  height:8px;
  border-radius:999px;
}
.chart-container{
  position:relative;
  width:100%;
  height:220px;
}

/* latest order section */
.section{
  margin-top:4px;
}
.section-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:8px;
}
.section-title{
  margin:0;
  font-size:16px;
  font-weight:800;
  color:var(--mitti-dark);
}
.section-link{
  font-size:12px;
  color:var(--muted);
  text-decoration:none;
}
.section-link:hover{
  color:var(--accent);
}

/* order notification card */
.order-card{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:13px 14px;
  margin-top:8px;
  background:#fff;
  border-radius:14px;
  box-shadow:0 10px 22px rgba(90,62,54,0.14);
  border-left:4px solid var(--accent);
  border-right:1px solid rgba(209,188,161,0.7);
  border-top:1px solid rgba(209,188,161,0.7);
  border-bottom:1px solid rgba(209,188,161,0.7);
  cursor:pointer;
  text-decoration:none;
  color:inherit;
  position:relative;
  overflow:hidden;
  transition:transform .18s ease, box-shadow .18s ease, background .18s ease;
}
.order-card::before{
  content:"";
  position:absolute;
  inset:0;
  background:linear-gradient(90deg,rgba(192,122,53,0.10),transparent);
  opacity:0;
  transition:opacity .2s ease;
}
.order-card:hover{
  transform:translateY(-2px);
  box-shadow:0 14px 26px rgba(90,62,54,0.20);
}
.order-card:hover::before{opacity:1;}
.order-info{
  display:flex;
  flex-direction:column;
  gap:2px;
}
.order-id{
  font-weight:700;
  font-size:14px;
  color:var(--mitti-dark);
}
.order-meta{
  font-size:12px;
  color:var(--muted);
}
.order-meta span.dot{
  display:inline-block;
  width:4px;
  height:4px;
  border-radius:50%;
  background:rgba(124,114,109,0.6);
  margin:0 5px;
}
.order-right{
  display:flex;
  align-items:center;
  gap:10px;
}

/* statuses */
.status{
  padding:4px 9px;
  border-radius:999px;
  font-weight:600;
  font-size:11px;
  display:inline-flex;
  align-items:center;
  gap:6px;
}
.status-dot{
  width:7px;
  height:7px;
  border-radius:50%;
}
.status.placed{
  background:rgba(216,149,42,0.10);
  color:#8b650e;
  border:1px solid rgba(216,149,42,0.45);
}
.status.placed .status-dot{
  background:var(--warning);
}
.status.delivered{
  background:rgba(46,125,50,0.10);
  color:#13591a;
  border:1px solid rgba(46,125,50,0.45);
}
.status.delivered .status-dot{
  background:var(--success);
}
.status.cancelled{
  background:rgba(198,40,40,0.10);
  color:#7d1111;
  border:1px solid rgba(198,40,40,0.45);
}
.status.cancelled .status-dot{
  background:var(--danger);
}
.status.unknown{
  background:#eee;
  color:#555;
  border:1px solid #ddd;
}
.status.unknown .status-dot{
  background:#999;
}

.order-amount{
  font-size:14px;
  font-weight:700;
  color:var(--mitti-mid);
}
/* MOBILE SIDEBAR CLOSE BUTTON (add only this) */
.closeSidebarBtn{
  display:none;                /* hidden on desktop */
  position:absolute;
  top:12px;
  right:12px;
  background:rgba(192,122,53,0.10);
  border:1px solid rgba(192,122,53,0.25);
  color:var(--mitti-dark);
  font-size:18px;
  width:36px;
  height:36px;
  border-radius:10px;
  cursor:pointer;
  z-index:60;
  align-items:center;
  justify-content:center;
  display:inline-flex;
}
.closeSidebarBtn:hover{
  background:rgba(192,122,53,0.18);
}

/* show cross only on mobile where menu appears */
@media (max-width:900px){
  .closeSidebarBtn{
    display:inline-flex;
  }
}

.order-tag{
  font-size:10px;
  text-transform:uppercase;
  letter-spacing:.18em;
  color:var(--muted);
  text-align:right;
}

.empty-box{
  margin-top:10px;
  padding:11px 12px;
  border-radius:12px;
  background:var(--bg-soft);
  border:1px dashed rgba(124,114,109,0.5);
  font-size:12px;
  color:var(--muted);
}

/* responsive */
@media (max-width:1100px){
  .top-grid{
    grid-template-columns: minmax(0,1.4fr) minmax(0,1.1fr);
  }
}
@media (max-width:980px){
  .top-grid{
    grid-template-columns:1fr;
  }
}
@media (max-width:900px){
  .container{position:relative;}
  .sidebar{
    position:fixed;
    left:0;
    top:0;
    bottom:0;
    z-index:40;
    transform:translateX(-100%);
    box-shadow:0 18px 40px rgba(90,62,54,0.45);
  }
  .sidebar.open{
    transform:translateX(0);
  }
  #menuBtn{
    display:inline-flex;
  }
  .main{
    padding:16px 14px 18px;
  }
}
@media (max-width:640px){
  .topbar{
    align-items:flex-start;
  }
  .profile{
    gap:8px;
  }
  .search{
    order:3;
    width:100%;
    max-width:none;
  }
  .cards{       
    grid-template-columns:1fr;
  }
  .tile-grid{
    grid-template-columns:1fr 1fr;
  }
  .order-card{   
    flex-direction:column;
    align-items:flex-start;
    gap:8px;
  }
  .order-right{
    width:100%;
    justify-content:space-between;
  }
}
</style>
</head>

<body>
<div class="container">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <!-- add this inside the sidebar, immediately after: <aside class="sidebar"> -->
<button class="closeSidebarBtn" id="closeSidebarBtn" aria-label="Close sidebar">✕</button>

    <div class="brand">
      <div class="logo">ZP</div>
      <div>
        <div class="brand-text-main">ZEPKART</div>
        <div class="brand-text-sub">Admin Control Center</div>
      </div>
    </div>

    <div class="sidebar-section-title">Overview</div>
    <nav>

      <a href="{{ route('admin.dashboard') }}"
         class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="icon">🏠</span>
        <span>Dashboard</span>
      </a>
<a href="{{ route('admin.income') }}"
   class="nav-link {{ request()->routeIs('admin.income') ? 'active' : '' }}">
    <span class="icon">💹</span>
    <span>Income Report</span>
</a>
<a href="{{ route('admin.suppliers.list') }}"
   class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
    <span class="icon">🏭</span>
    <span>Suppliers</span>
</a>
<a href="{{ route('seller-requests') }}"
   class="nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
    <span class="icon">🧑‍💼</span>
    <span>Sellers</span>
</a>
<a href="{{ route('admin.assign.products') }}"
   class="nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
    <span class="icon">🧑‍💼</span>
    <span>Buyers</span>
</a>


      <a href="{{ route('products.index') }}"
         class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <span class="icon">📦</span>
        <span>Products</span>
      </a>

     
      <a href="{{ route('categories.all') }}"
         class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <span class="icon">🗂</span>
        <span>Category</span>
      </a>

      <a href="{{ route('admin.orders') }}"
         class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <span class="icon">🧾</span>
        <span>Orders</span>
      </a>

      <a href="{{ route('admin.users.index') }}"
         class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <span class="icon">👥</span>
        <span>Users</span>
      </a>
     

<a href="{{ route('admin.partners.index') }}"
   class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
    <span class="icon">🛵</span>
    <span>Manage Partners</span>
</a>

      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <div class="nav-link">
          <span class="icon">⏏️</span>
          <button type="submit">Logout</button>
        </div>
      </form>
    </nav>

    <div class="sidebar-footer">
      Tip: Keep an eye on the <strong>latest order card</strong> to track new activity in real-time.
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main">
    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-left">
        <button id="menuBtn">☰</button>
        <div>
          <div class="topbar-title">Dashboard</div>
          <div class="topbar-subtitle">Quick overview of orders & revenue</div>
        </div>
      </div>

      <div class="profile">
        <div class="search">
          <input placeholder="Search orders, users, products..." />
        </div>
        <div class="profile-text">
          <div class="profile-name">{{ auth()->user()->name ?? 'Admin' }}</div>
          <div class="profile-role">Admin</div>
        </div>
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}</div>
      </div>
    </div>

    <!-- TOP GRID -->
    <div class="top-grid">
      <!-- LEFT SIDE: CARDS + TILES -->
       
      <div>
        <!-- DELIVERY PARTNER TOP SUMMARY -->


        
        <div class="cards ">
          
          <!-- Total Orders -->
          <div class="tile">
            <div class="card-top">
              <div>
                <div class="card-label">Total Orders</div>
                <div class="card-num">{{ $totalOrders }}</div>
              </div>
              <div class="card-icon">📊</div>
            </div>
            <div class="card-footer">
              <span class="strong">All-time total</span>
              <span>{{ now()->format('d M Y') }}</span>
            </div>
          </div>
<div class="tile">
  <div class="tile-label">Seller Requests</div>
  <div class="tile-value">{{ $SellerRequests }}</div>
  <div class="tile-sub">Ṭotal sellers</div>
</div>

<div class="tile">
  <div class="tile-label">Total Suppliers</div>
  <div class="tile-value">{{ $TotalSupplier}}</div>
  <div class="tile-sub">Our Suppliers</div>
</div>

<div class="tile">
  <div class="tile-label">Supplier Products</div>
  <div class="tile-value">{{ $newSupplierProducts }}</div>
  <div class="tile-sub">New</div>
</div>

<div class="tile">
  <div class="tile-label">Seller Orders</div>
  <div class="tile-value">{{ $totalSellerOrders }}</div>
  <div class="tile-sub">
    Commission ₹{{ number_format($totalCommission,2) }}
  </div>
</div>

          <!-- Delivered Orders -->
          <div class=" tile">
            <div class="card-top">
              <div>
                <div class="card-label">Delivered</div>
                <div class="card-num">{{ $deliveredOrders ?? 0 }}</div>
              </div>
              <div class="card-icon">✅</div>
            </div>
            <div class="card-footer">
              <span class="strong">₹{{ number_format($deliveredAmount ?? 0,2) }}</span>
              <span>Delivered value</span>
            </div>
          </div>
<!-- TOTAL BUYERS CARD -->
<div class="card tile" onclick="openBuyerModal()" style="cursor:pointer;">
    <div class="card-top">
      <div>
        <div class="card-label">Total Buyers</div>
        <div class="card-num">{{ $totalBuyers }}</div>
      </div>
      <div class="card-icon">🧑‍💼</div>
    </div>
    <div class="card-footer">
      <span class="strong">All Buyers</span>
      <span>View</span>
    </div>
</div>

<!-- TOTAL BUYER REVIEW CARD -->
<div class="card tile" onclick="openBuyerModal()" style="cursor:pointer;">
    <div class="card-top">
      <div>
        <div class="card-label">Buyers Review</div>
        <div class="card-num">{{ $totalBuyerReview }}</div>
      </div>
      <div class="card-icon">⭐</div>
    </div>
    <div class="card-footer">
      <span class="strong">Overall Rating</span>
      <span>View Buyers</span>
    </div>
</div>

          <!-- Total Revenue -->
          <div class="card tile ">
            <div class="card-top">
              <div>
                <div class="card-label">Total Revenue</div>
                <div class="card-num">₹{{ number_format($totalRevenue ?? 0,2) }}</div>
              </div>
              <div class="card-icon">💰</div>
            </div>
            <div class="card-footer">
              <span class="strong">Pending + Delivered</span>
              <span>In all statuses</span>
            </div>
          </div>

        </div>
        

        <!-- Tiles -->
        <div class="tile-grid">
          <div class="tile">
            <div class="tile-label">Pending Orders</div>
            <div class="tile-value">{{ $pendingOrders ?? 0 }}</div>
            <div class="tile-sub">Awaiting processing</div>
          </div>

          <div class="tile">
            <div class="tile-label">Cancelled Orders</div>
            <div class="tile-value">{{ $cancelledOrders ?? 0 }}</div>
            <div class="tile-sub">Removed by customer/admin</div>
          </div>
<!-- Total Categories -->
<!-- Categories -->
 
  <div class="tile">
            <div class="card-top">
              <div>
                <div class="card-label">Online Riders</div>
                <div class="card-num">{{ $onlinePartners ?? 0 }}</div>
              </div>
              <div class="card-icon">🟢</div>
            </div>
            <div class="card-footer">
            <a href="{{ route('admin.live.tracking') }}">
    <span class="strong">Live Now</span>
</a>

              
              <span>{{ now()->format('d M Y') }}</span>
            </div>
          </div>

<div class="tile">
    <div class="tile-label">Delivery Partners</div>
    <div class="tile-value">{{ $approvedPartners }}</div>
    
    <div class="card-footer"> <a href="{{ route('admin.partners.index') }}" style="font-size:11px; text-decoration:none;"> <span class="strong">Manage Partners </span></a>
             </div>
</div>

<div class="card tile" onclick="openCategoryModal()" style="cursor:pointer;">
    <div class="card-top">
      <div>
        <div class="card-label">Total Categories</div>
        <div class="card-num">{{ $totalCategories ?? 0 }}</div>
      </div>
      <div class="card-icon">🗂</div>
    </div>
    <div class="card-footer">
      <span class="strong">Manage Categories</span>
      <span>Click to view/add</span>
    </div>
</div>
<!-- Total Products -->
<div class="card tile" onclick="openProductModal()" style="cursor:pointer;">
    <div class="card-top">
      <div>
        <div class="card-label">Total Products</div>
        <div class="card-num">{{ $totalProducts }}</div>
      </div>
      <div class="card-icon">📦</div>
    </div>
    <div class="card-footer">
      <span class="strong">Manage Products</span>
      <span>Add / View</span>
    </div>
</div>



          <div class="tile">
            <div class="tile-label">Pending Amount</div>
            <div class="tile-value">₹{{ number_format($pendingAmount ?? 0,2) }}</div>
            <div class="tile-sub">Due on completion</div>
          </div>

          <div class="tile">
            <div class="tile-label">Cancelled Amount</div>
            <div class="tile-value">₹{{ number_format($cancelAmount ?? 0,2) }}</div>
            <div class="tile-sub">Lost revenue</div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDE: CHART -->
      <aside class="chart-card">
        <div class="chart-header">
          <div>
            <div class="chart-title">Earnings & Orders</div>
            <div class="chart-sub">Revenue vs Orders (Monthly)</div>
            <div class="chart-legend-inline">
              <div class="chart-pill">
                <span class="chart-pill-dot" style="background:#c07a35;"></span>
                <span>Revenue</span>
              </div>
              <div class="chart-pill">
                <span class="chart-pill-dot" style="background:#8a6a52;"></span>
                <span>Orders</span>
              </div>
            </div>
          </div>
          <div class="chart-figure">
            <div class="chart-figure-main">
              ₹{{ number_format($totalRevenue ?? 0,0) }}
            </div>
            <div class="chart-figure-sub">
              Latest month: ₹{{ number_format(($monthlyRevenue[0] ?? 0),0) }}
            </div>
          </div>
        </div>

        <div class="chart-container">
          <canvas id="earningsChart"></canvas>
        </div>
      </aside>
    </div>

    <!-- LATEST ORDER SECTION -->
    <div class="section">
      <div class="section-header">
        <h3 class="section-title">Latest Order</h3>
        <a href="{{ route('admin.orders') }}" class="section-link">See all orders →</a>
      </div>

      @if($recentOrders && count($recentOrders) > 0)
        @php $order = $recentOrders->first(); @endphp
        <a href="{{ route('admin.orders.show', $order->id) }}" class="order-card">
          <div class="order-info">
            <div class="order-id">
              Order #{{ $order->order_number ?? $order->id }}
            </div>
            <div class="order-meta">
              {{ $order->user->name ?? 'Guest' }}
              <span class="dot"></span>
              {{ $order->created_at->format('d M, Y · H:i') }}
            </div>
          </div>

          <div class="order-right">
            @php
              $status = strtolower($order->status ?? 'unknown');
            @endphp
            <div class="status {{ $status }}">
              <span class="status-dot"></span>
              <span>{{ ucfirst($order->status) }}</span>
            </div>

            <div style="text-align:right;">
              <div class="order-amount">₹{{ number_format($order->total,2) }}</div>
              <div class="order-tag">Latest activity</div>
            </div>
          </div>
        </a>
      @else
        <div class="empty-box">
          No recent orders yet. Once the first order comes in, you’ll see a live notification here.
        </div>
      @endif
    </div>
    <!-- LATEST PARTNER REQUEST -->
<div class="section" style="margin-top:30px;">
    <div class="section-header">
        <h3 class="section-title">Latest Partner Request</h3>
        <a href="{{ route('admin.partners.pending') }}" class="section-link">
            View All Requests →
        </a>
    </div>

    @if($latestPartner)
    <a href="{{ route('admin.partners.show', $latestPartner->id) }}" class="order-card" style="border-left:4px solid #8a6a52;">
        
        <div class="order-info">
            <div class="order-id">
                {{ $latestPartner->full_name }}
            </div>

            <div class="order-meta">
                {{ $latestPartner->city }}, {{ $latestPartner->state }}
                <span class="dot"></span>
                Applied: {{ $latestPartner->created_at->format('d M, Y · H:i') }}
            </div>
        </div>

        <div class="order-right">
            <div class="status placed">
                <span class="status-dot"></span>
                <span>Pending</span>
            </div>

            <div style="text-align:right;">
                <div class="order-amount" style="color:#8a6a52; font-weight:700;">
                    {{ strtoupper($latestPartner->vehicle_type) }}
                </div>
                <div class="order-tag">New Request</div>
            </div>
        </div>

    </a>
    @else
    <div class="empty-box">
        No new partner applications yet.
    </div>
    @endif
</div><!-- LATEST SELLER REQUEST -->
<div class="section" style="margin-top:30px;">
    <div class="section-header">
        <h3 class="section-title">Latest Seller Request</h3>
        <a href="{{ route('seller-requests') }}" class="section-link">
            View All Requests →
        </a>
    </div>

    @if($latestSeller)
    <a href="{{ route('seller-requests', $latestSeller->id) }}"
       class="order-card" style="border-left:4px solid #c62828;">

        <div class="order-info">
            <div class="order-id">
                {{ $latestSeller->name }}
            </div>

            <div class="order-meta">
                {{ $latestSeller->email }}
                <span class="dot"></span>
                Applied: {{ $latestSeller->created_at->format('d M, Y · H:i') }}
            </div>
        </div>

        <div class="order-right">
            <div class="status placed">
                <span class="status-dot"></span>
                <span>Pending</span>
            </div>

            <div class="order-tag">New Seller</div>
        </div>

    </a>
    @else
    <div class="empty-box">
        No new seller requests.
    </div>
    @endif
</div>


  </main>
</div>

<script>
  // Sidebar toggle for mobile
  const menuBtn = document.getElementById('menuBtn');
  const sidebar = document.querySelector('.sidebar');
  if(menuBtn && sidebar){
    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
  }

  // Chart
  const chartEl = document.getElementById('earningsChart');
  if (chartEl) {
    const ctx = chartEl.getContext('2d');

    const months = @json($months ?? []);
    const revenueData = @json($monthlyRevenue ?? []);
    const ordersData = @json($monthlyOrders ?? []);

    const revenueGradient = ctx.createLinearGradient(0,0,0,220);
    revenueGradient.addColorStop(0,'rgba(192,122,53,0.85)');
    revenueGradient.addColorStop(1,'rgba(243,233,221,0.15)');

    const ordersGradient = ctx.createLinearGradient(0,0,0,220);
    ordersGradient.addColorStop(0,'rgba(138,106,82,0.9)');
    ordersGradient.addColorStop(1,'rgba(243,233,221,0.12)');

    new Chart(ctx,{
      type:'bar',
      data:{
        labels:months,
        datasets:[
          {
            label:'Revenue',
            data:revenueData,
            backgroundColor:revenueGradient,
            borderColor:'#c07a35',
            borderWidth:1,
            borderRadius:6,
            barPercentage:0.6
          },
          {
            label:'Orders',
            data:ordersData,
            type:'line',
            tension:0.35,
            borderColor:'#8a6a52',
            pointBackgroundColor:'#8a6a52',
            pointRadius:3,
            pointHitRadius:8,
            yAxisID:'y'
          }
        ]
      },
      options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
          legend:{
            display:false
          },
          tooltip:{
            callbacks:{
              label:function(context){
                if (context.dataset.label === 'Revenue') {
                  const v = context.parsed.y || 0;
                  return ' Revenue: ₹' + v.toLocaleString();
                } else {
                  const v = context.parsed.y || 0;
                  return ' Orders: ' + v.toLocaleString();
                }
              }
            }
          }
        },
        scales:{
          x:{
            grid:{display:false},
            ticks:{
              font:{family:'Inter', size:11},
              color:'#7c726d'
            }
          },
          y:{
            grid:{
              color:'rgba(209,188,161,0.55)',
              drawBorder:false
            },
            ticks:{
              beginAtZero:true,
              font:{family:'Inter', size:11},
              color:'#7c726d'
            }
          }
        }
      }
    });
  }
  
  // add this after your existing sidebar toggle code
const closeSidebarBtn = document.getElementById('closeSidebarBtn');

if (closeSidebarBtn) {
  closeSidebarBtn.addEventListener('click', () => {
    // remove open class (same behavior as overlay/ESC)
    sidebar.classList.remove('open');
  });
}

</script>
<!-- Category Modal -->
<div id="categoryModal" 
     style="
        position:fixed; inset:0; background:rgba(0,0,0,0.45); 
        display:none; align-items:center; justify-content:center; z-index:999;
     ">
    
  <div style="
        width:420px; background:#fff; border-radius:16px; padding:20px; 
        box-shadow:0 10px 30px rgba(0,0,0,0.25);
        position:relative;
     ">

      <h3 style="margin:0 0 10px; font-size:20px; font-weight:800;">Manage Categories</h3>

      <!-- Close Button -->
      <button onclick="closeCategoryModal()" 
              style="
                position:absolute; right:20px; top:20px; 
                background:#eee; border:none; font-size:18px;
                width:30px; height:30px; border-radius:50%; cursor:pointer;
              ">✕</button>

      <hr style="margin:12px 0;">

      <!-- Existing Categories List -->
      <h4 style="margin:8px 0; font-size:14px;">Existing Categories</h4>
      <ul style="max-height:150px; overflow:auto; margin:0; padding-left:18px;">
        @forelse($allCategories ?? [] as $cat)
          <li style="margin:4px 0; font-size:13px;">{{ $cat->name }}</li>
        @empty
          <li>No categories yet.</li>
        @endforelse
      </ul>

      <hr style="margin:12px 0;">

      <!-- Form to Add Category -->
      <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <label style="font-size:13px;">Add New Category</label>
        <input type="text" name="name" required
               placeholder="Category name"
               style="
                 width:100%; padding:8px 10px; margin-top:5px;
                 border-radius:8px; border:1px solid #ccc;
               ">

        <button type="submit"
                style="
                  margin-top:12px; width:100%; padding:10px; border:none;
                  background:#c07a35; color:white; font-weight:700;
                  border-radius:8px; cursor:pointer;
                ">
          Add Category
        </button>
      </form>
  </div>
</div>
<!-- Product Modal -->
<!-- PRODUCT MODAL -->
<div id="productModal"
     style="position:fixed; inset:0; background:rgba(0,0,0,0.45);
            display:none; align-items:center; justify-content:center; z-index:999;">

  <div style="width:430px; background:#fff; border-radius:18px; padding:22px; 
              box-shadow:0 10px 30px rgba(0,0,0,0.25); position:relative;">

      <!-- HEADER -->
      <h3 style="margin:0 0 10px; font-size:20px; font-weight:800;">Add Product</h3>

      <button onclick="closeProductModal()" 
              style="position:absolute; right:20px; top:20px;
              background:#eee; border:none; font-size:18px;
              width:30px; height:30px; border-radius:50%; cursor:pointer;">✕</button>

      <!-- EXISTING PRODUCTS -->
      <h4 style="margin:10px 0 8px; font-size:14px; font-weight:700;">Existing Products</h4>

      <ul style="max-height:160px; overflow-y:auto; margin:0; padding:0;">

        @forelse($allProducts as $product)
        <li style="
            list-style:none;
            margin:6px 0;
            padding:8px 10px;
            background:#f9f4ee;
            border-radius:12px;
            display:flex;
            align-items:center;
            gap:12px;
            border:1px solid rgba(192,122,53,0.25);
        ">
            <div style="display:flex; flex-direction:column; line-height:1.2;">
                <span style="font-size:14px; font-weight:700; color:#5a3e36;">
                    {{ $product->name }}
                </span>
                <span style="font-size:12px; color:#8a6a52;">
                    ₹{{ number_format($product->price, 2) }}
                </span>
            </div>
        </li>
        @empty
        <li style="list-style:none; color:#777;">No products yet.</li>
        @endforelse

      </ul>

      <hr style="margin:18px 0;">


      <!-- ADD PRODUCT FORM -->
      <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" 
            style="display:flex; flex-direction:column; gap:15px;">
        @csrf

        <!-- ROW 1 -->
        <div style="display:flex; gap:12px;">

            <!-- CATEGORY -->
            <div style="flex:1; display:flex; flex-direction:column; gap:5px;">
                <label style="font-size:13px; font-weight:600;">Category</label>
                <select 
                    name="category_id" 
                    required
                    style="
                        padding:10px;
                        border-radius:10px;
                        border:1px solid rgba(192,122,53,0.35);
                        background:#f9f4ee;
                        font-size:13px;
                    "
                >
                    <option value="">Select</option>
                    @foreach($allCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- PRODUCT NAME -->
            <div style="flex:1; display:flex; flex-direction:column; gap:5px;">
                <label style="font-size:13px; font-weight:600;">Product Name</label>
                <input 
                    type="text" 
                    name="name" 
                    required
                    placeholder="Enter name"
                    style="
                        padding:10px; 
                        border-radius:10px; 
                        border:1px solid rgba(192,122,53,0.35);
                        background:#fff8f2;
                        font-size:13px;
                    "
                >
            </div>

        </div>

        <!-- ROW 2 -->
        <div style="display:flex; gap:12px;">

            <!-- PRICE -->
            <div style="flex:1; display:flex; flex-direction:column; gap:5px;">
                <label style="font-size:13px; font-weight:600;">Price (₹)</label>
                <input 
                    type="number" 
                    name="price" 
                    required
                    placeholder="Enter price"
                    style="
                        padding:10px; 
                        border-radius:10px; 
                        border:1px solid rgba(192,122,53,0.35);
                        background:#fff8f2;
                        font-size:13px;
                    "
                >
            </div>

            <!-- IMAGE -->
            <div style="flex:1; display:flex; flex-direction:column; gap:5px;">
    <label style="font-size:13px; font-weight:600;">Image</label>

    <div style="
        width:100%;
        height:42px;
        border:1px solid rgba(192,122,53,0.35);
        border-radius:10px;
        background:#fff;
        display:flex;
        align-items:center;
        padding:0 10px;
        overflow:hidden;
    ">
        <input 
            type="file" 
            name="image" 
            accept="image/*"
            required
            style="
                border:none;
                width:100%;
                font-size:13px;
                cursor:pointer;
            "
        >
    </div>
</div>


        </div>

        <!-- SUBMIT -->
        <button 
            type="submit"
            style="
                width:100%;
                padding:12px;
                background:#c07a35;
                color:white;
                font-weight:700;
                border-radius:10px;
                cursor:pointer;
                font-size:14px;
                border:none;
            "
        >
            Add Product
        </button>

      </form>

  </div>
</div>
<div id="buyerModal"
     style="position:fixed; inset:0; background:rgba(0,0,0,0.5); display:none; z-index:999;">

  <div style="
      position:absolute;
      top:50%; left:50%;
      transform:translate(-50%,-50%);
      width:380px;
      max-height:420px;
      background:#fff;
      border-radius:16px;
      padding:16px;
  ">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-lg font-bold">All Buyers</h3>
            <button onclick="closeBuyerModal()" class="text-xl">✕</button>
        </div>

        <!-- BUYERS LIST -->
        <div class="space-y-2 overflow-y-auto max-h-[320px]">
            @foreach($buyers as $buyer)
                <div class="border rounded p-2">
                    <strong>{{ $buyer->name }}</strong><br>
                    <small class="text-gray-500">{{ $buyer->email }}</small>
                </div>
            @endforeach
        </div>

    </div>
</div>

<script>
  function openProductModal(){
    document.getElementById('productModal').style.display = 'flex';
}
function closeProductModal(){
    document.getElementById('productModal').style.display = 'none';
}
function openBuyerModal(){
    document.getElementById('buyerModal').style.display = 'flex';
}
function closeBuyerModal(){
    document.getElementById('buyerModal').style.display = 'none';
}
function openCategoryModal(){
   document.getElementById('categoryModal').style.display = 'flex';
}

function closeCategoryModal(){
   document.getElementById('categoryModal').style.display = 'none';
}
</script>

</body>
</html>

