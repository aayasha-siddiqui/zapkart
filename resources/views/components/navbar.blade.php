<style>
:root{
  --mitti-dark: #3b2a21;
  --mitti-primary: #c07a35;
  --mitti-secondary: #d7bfa6;
  --muted: #8b8b8b;
  --cream: #f5efe6;
}

/* ===================== PROFILE ===================== */
.profile{
  display:flex; align-items:center; gap:10px;
}
.avatar{
  width:40px; height:40px; border-radius:50%;
  background:radial-gradient(circle at 30% 0%,#f9f5f1 0,#c07a35 35%,#5a3e36 100%);
  display:flex; align-items:center; justify-content:center;
  color:#fff; font-weight:700; font-size:14px;
  box-shadow:0 5px 14px rgba(90,62,54,0.45);
}

/* ===================== HAMBURGER ===================== */
.hamburger {
    display:none;
    flex-direction:column;
    gap:5px;
    cursor:pointer;
}
.hamburger span {
    width:26px;
    height:3px;
    background:var(--mitti-dark);
    border-radius:6px;
    transition:.3s;
}

/* ===================== MOBILE MENU ===================== */
.mobile-menu {
    display:none;
    background:var(--cream);
    border-bottom:1px solid var(--mitti-secondary);
    padding:15px;
}
.mobile-menu.show { display:block; }

.mobile-item {
    padding:12px;
    margin-bottom:8px;
    border-radius:12px;
    background:white;
    border:1px solid var(--mitti-secondary);
    display:flex; align-items:center; gap:10px;
    font-weight:600;
    color:var(--mitti-dark);
    text-decoration:none;
}

/* MOBILE SEARCH */
.mobile-search { display:flex; gap:10px; margin-bottom:10px; }
.mobile-search input{
    flex:1;
    padding:10px;
   ;
    border:1px solid var(--mitti-secondary);
    border-radius:999px;
}
#menuToggle {
    margin-left: 10px;
    margin-right: 4px;
}
/* Mobile Search Adjusted */
#mobileSearch {
    margin-top: 12px !important; /* search thoda neeche */
}

/* Mobile Menu below search */
#mobileMenu {
    margin-top: 70px !important; /* menu search bar ke niche aaye */
}


/* ===================== RESPONSIVE BREAKPOINT ===================== */
@media(max-width: 800px){
    .hide-mobile { display:none !important; }
    .hamburger { display:flex; }
}

</style>

<!-- ===================== HEADER ===================== -->
<header class="fixed top-0 w-full z-50 shadow bg-mitti-cream/90 backdrop-blur-md border-b border-mitti-secondary/40">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 flex items-center justify-between h-20">

        <!-- BRAND -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-mitti-primary flex items-center justify-center shadow-md">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M3 6h18M7 6v14a2 2 0 002 2h6a2 2 0 002-2V6"
                          stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span class="text-xl font-extrabold text-mitti-dark">Zapkart</span>
        </a>

        <!-- DESKTOP SEARCH -->
        <div class="hidden md:flex flex-1 justify-center px-6 hide-mobile">
            <form action="{{ route('products.search') }}"
                  method="GET"
                  class="flex items-center gap-2 w-full max-w-2xl bg-white border border-mitti-secondary/40 rounded-full shadow px-4 py-2">
                <svg class="w-5 h-5 text-mitti-dark/60" viewBox="0 0 24 24" fill="none">
                    <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <input type="search" name="query" value="{{ request('query') }}"
                       placeholder="Search products..."
                       class="w-full text-sm bg-transparent focus:outline-none text-mitti-dark"/>
                <button type="submit"
                        class="ml-2 bg-mitti-primary hover:bg-mitti-secondary text-white px-4 py-2 rounded-full text-sm font-semibold">
                    Search
                </button>
            </form>
        </div>
       

        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-3">

            {{-- ================= ADMIN NAVIGATION (DESKTOP) ================= --}}
            @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-mitti-secondary/20 text-sm font-semibold text-mitti-dark">🏠 Dashboard</a>
                <a href="{{ route('products.index') }}" class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-white border">📦 Products</a>
                <a href="{{ route('categories.all') }}" class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-white border">🏷 Brand</a>
               <a href="{{ route('admin.partners.index') }}"
   class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-white border {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
    <span class="icon">🛵</span>
    <span> Partners</span>
</a>     <a href="{{ route('admin.orders') }}" class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-white border">🧾 Orders</a>
                <a href="{{ route('admin.users.index') }}" class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-white border">👥 Users</a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-mitti-primary text-white">Logout</button>
                </form>
            @endif
            @endauth

            {{-- ============= GUEST (DESKTOP) ============= --}}
            @guest
            <a href="{{ route('categories.index') }}" class="hidden md:inline-block hide-mobile bg-mitti-secondary/20 px-4 py-2 rounded-full">🏠 Dashboard</a>
          
                <a href="{{ route('products.index') }}" class="hidden md:inline-block hide-mobile bg-white border px-4 py-2 rounded-full">📦 Products</a>
                <a href="{{ route('auth.form') }}" class="hidden md:inline-block hide-mobile px-4 py-2 rounded-full bg-mitti-primary text-white">Sign In</a>
            @endguest

            {{-- ============= USER (DESKTOP) ============= --}}
            @auth
            @if(auth()->user()->role === 'user' || auth()->user()->role === 'driver'|| auth()->user()->role === 'seller'|| auth()->user()->role === 'supplier'|| auth()->user()->role === 'seller'|| auth()->user()->role === 'shopkeeper')
                <a href="{{ route('categories.index') }}" class="hidden md:inline-block hide-mobile bg-mitti-secondary/20 px-4 py-2 rounded-full">🏠 Dashboard</a>
                <a href="{{ route('categories.all') }}" class="hidden md:inline-block hide-mobile bg-white border px-4 py-2 rounded-full">🏷 Categories</a>
                <a href="{{ route('products.index') }}" class="hidden md:inline-block hide-mobile bg-white border px-4 py-2 rounded-full">📦 Products</a>
<a href="{{ route('partner.register') }}" class="hidden md:inline-block hide-mobile px-2 py-2 rounded-full bg-white border">
🚴 
</a>
                <a href="{{ route('wishlist.index') }}" class="hidden md:flex hide-mobile relative items-center gap-1 bg-white border px-3 py-2 rounded-full">
                    ❤️
                    @if(isset($wishlistCount) && $wishlistCount > 0)
                    <span class="absolute -top-1 -right-1 bg-mitti-primary text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ $wishlistCount }}
                    </span>
                    @endif
                </a>

                <a href="{{ route('cart.index') }}" class="hidden md:flex hide-mobile relative items-center gap-1 bg-white border px-3 py-2 rounded-full">
                    🛒
                    @if(isset($cartCount) && $cartCount > 0)
                    <span class="absolute -top-1 -right-1 bg-mitti-primary text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>

                <a href="{{ route('orders') }}" class="hidden md:inline-block hide-mobile bg-white border px-4 py-2 rounded-full">📄 Orders</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hidden md:inline-block hide-mobile bg-mitti-primary text-white px-4 py-2 rounded-full">Logout</button>
                </form>

                <div class="profile-text">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}</div>
                </div>
            @endif
            @endauth

            <!-- MOBILE HAMBURGER -->
            <div class="hamburger md:hidden" id="menuToggle">
                <span></span><span></span><span></span>
            </div>

        </div>
    </div>
</header>


<!-- ===================== MOBILE MENU ===================== -->
<div id="mobileMenu" class="mobile-menu md:hidden">

    <!-- MOBILE SEARCH -->
    <form method="GET" action="{{ route('products.search') }}" class="mobile-search">
        <input type="text" name="query" placeholder="Search..." value="{{ request('query') }}">
        <button class="px-4 py-2 text-white bg-mitti-primary rounded-full">Go</button>
    </form>

    {{-- ================= ADMIN MENU ================= --}}
    @auth
    @if(auth()->user()->role === 'admin')
        <a class="mobile-item" href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a class="mobile-item" href="{{ route('products.index') }}">📦 Products</a>
            <a href="{{ route('admin.partners.index') }}"
   class="mobile-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
    <span class="icon">🛵</span>
    <span> Partners</span>
</a>   
        <a class="mobile-item" href="{{ route('categories.all') }}">🗂 Category</a>
        <a class="mobile-item" href="{{ route('admin.orders') }}">🧾 Orders</a>
        <a class="mobile-item" href="{{ route('admin.users.index') }}">👥 Users</a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="mobile-item bg-mitti-primary text-white">Logout</button>
        </form>
    @endif
    @endauth

    {{-- ================= USER MENU ================= --}}
    @auth
    @if(auth()->user()->role === 'user')
        <a class="mobile-item" href="{{ route('categories.index') }}">🏠 Dashboard</a>
        <a class="mobile-item" href="{{ route('categories.all') }}">🏷 Brand</a>
        <a class="mobile-item" href="{{ route('products.index') }}">📦 Products</a>
        <a class="mobile-item" href="{{ route('wishlist.index') }}">❤️ Wishlist</a>
        <a class="mobile-item" href="{{ route('cart.index') }}">🛒 Cart</a>
        <a class="mobile-item" href="{{ route('orders') }}">📄 Orders</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="mobile-item bg-mitti-primary text-white">Logout</button>
        </form>
    @endif
    @endauth

    {{-- ================= GUEST MENU ================= --}}
    @guest
        <a class="mobile-item" href="{{ route('products.index') }}">📦 Products</a>
        <a class="mobile-item" href="{{ route('auth.form') }}">❤️ Wishlist</a>
        <a class="mobile-item" href="{{ route('auth.form') }}">📄 Orders</a>
        <a class="mobile-item bg-mitti-primary text-white text-center" href="{{ route('auth.form') }}">Sign In</a>
    @endguest
</div>

<!-- ===================== JS TOGGLE ===================== -->
<script>
document.getElementById("menuToggle").onclick = function() {
    document.getElementById("mobileMenu").classList.toggle("show");
};
</script>
