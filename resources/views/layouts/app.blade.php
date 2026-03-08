<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Zapkart — Fresh & Fun</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    

    <!-- Swiper (carousel) -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Tailwind theme config (custom colors) -->
    <script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          mitti: {
            primary: "#B68A60",
            secondary: "#C79D72",
            dark: "#5A3E2B",
            cream: "#F8F4EC",
          }
        }
      }
    }
  }
</script>


    <!-- External styles -->
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body class="bg-mitti-cream text-zkprimary font-sans antialiased">
    <!-- NAVBAR (glass + search inside) -->

<x-navbar/>
    <!-- MAIN -->
   
      <!-- HERO (100vh) -->
      <main class="pt-20 bg-mitti-cream">
    @yield('content')
  </main>
<!-- DOUBLE INFO SECTION (Exact Mitti Style) -->
<!-- PROMO SECTION (Exact Mitti Template Style) -->




      <!-- CATEGORIES GRID -->
     

      <!-- OFFERS / APP STRIP -->
      <!-- <section class="py-10 bg-gradient-to-r from-zkpeach/10 to-zkmint/10">
        <div
          class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6"
        >
          <div>
            <h3 class="font-semibold text-lg">
              Limited time: Free delivery on orders above ₹399
            </h3>
            <p class="text-sm text-zkmuted">
              Use code <span class="font-semibold text-zkmint">ZAPFREE</span> at
              checkout.
            </p>
          </div>

          <div class="flex gap-3">
            <a href="#" class="bg-white px-4 py-2 rounded-full shadow-sm"
              >Order Now</a
            >
            <a href="#" class="bg-white px-4 py-2 rounded-full shadow-sm"
              >Download App</a
            >
          </div>
        </div>
      </section>
    </main> -->

  <!-- ============================= -->
<!-- 🌿 MITTI THEME FOOTER -->
<!-- ============================= -->
<footer class="bg-mitti-dark text-white pt-14 pb-8">

  <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-10">

    <!-- LOGO + ABOUT -->
    <div>
      <h2 class="text-2xl font-bold tracking-wide text-mitti-light">Zapkart</h2>
      <p class="mt-4 text-sm text-mitti-light/80 leading-6 max-w-xs">
        Fresh groceries, fast delivery, premium quality — bringing comfort
        and convenience to your doorstep in true Mitti style.
      </p>

      <!-- SOCIAL ICONS -->
      <div class="flex gap-3 mt-5">
        <a href="#" class="w-9 h-9 bg-mitti-primary/30 text-white flex items-center justify-center rounded-full hover:bg-mitti-primary transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M22 12a10 10 0 1 0-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.7-3.9 1.1 0 2.2.2 2.2.2v2.4H15c-1.2 0-1.6.8-1.6 1.6V12H16l-.4 3h-2.2v7A10 10 0 0 0 22 12"/>
          </svg>
        </a>

        <a href="#" class="w-9 h-9 bg-mitti-primary/30 text-white flex items-center justify-center rounded-full hover:bg-mitti-primary transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 3c1.7 0 1.9 0 2.6.04.7.03 1.1.15 1.36.25.34.13.58.3.84.56.26.26.43.5.56.84.1.26.22.66.25 1.36C13 7 13 7.3 13 9s0 2-.04 2.6c-.03.7-.15 1.1-.25 1.36a2.3 2.3 0 0 1-.56.84c-.26.26-.5.43-.84.56-.26.1-.66.22-1.36.25C9 13 8.7 13 7 13s-2 0-2.6-.04c-.7-.03-1.1-.15-1.36-.25a2.3 2.3 0 0 1-.84-.56 2.3 2.3 0 0 1-.56-.84c-.1-.26-.22-.66-.25-1.36C2 11 2 10.7 2 9s0-2 .04-2.6c.03-.7.15-1.1.25-1.36.13-.34.3-.58.56-.84.26-.26.5-.43.84-.56.26-.1.66-.22 1.36-.25C5 3 5.3 3 7 3h1zm0-1H7C5.3 2 5 2 4.3 2.04c-.8.04-1.4.17-1.9.36-.5.2-.9.46-1.3.85-.4.4-.65.8-.85 1.3-.19.5-.32 1.1-.36 1.9C2 7 2 7.3 2 9c0 1.7 0 2 .04 2.7.04.8.17 1.4.36 1.9.2.5.46.9.85 1.3.4.4.8.65 1.3.85.5.19 1.1.32 1.9.36C5 16 5.3 16 7 16h1c1.7 0 2 0 2.7-.04.8-.04 1.4-.17 1.9-.36.5-.2.9-.46 1.3-.85.4-.4.65-.8.85-1.3.19-.5.32-1.1.36-1.9.04-.7.04-1 .04-2.7s0-2-.04-2.7c-.04-.8-.17-1.4-.36-1.9-.2-.5-.46-.9-.85-1.3-.4-.4-.8-.65-1.3-.85-.5-.19-1.1-.32-1.9-.36C11 2 10.7 2 9 2z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm0 4A1.5 1.5 0 1 1 8 6a1.5 1.5 0 0 1 0 3z"/>
            <circle cx="12.5" cy="3.5" r="1"/>
          </svg>
        </a>

        <a href="#" class="w-9 h-9 bg-mitti-primary/30 text-white flex items-center justify-center rounded-full hover:bg-mitti-primary transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="currentColor" viewBox="0 0 16 16">
            <path d="M5.026 15c6.038 0 9.341-5 9.341-9.334v-.425A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518A3.301 3.301 0 0 0 15.555 2.1a6.533 6.533 0 0 1-2.084.792A3.286 3.286 0 0 0 7.875 6.03 9.324 9.324 0 0 1 1.112 2.1 3.286 3.286 0 0 0 2.13 6.765 3.323 3.323 0 0 1 .64 6.293v.041a3.286 3.286 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 2.96 2.96 0 0 1-.614-.059 3.283 3.283 0 0 0 3.067 2.28A6.588 6.588 0 0 1 .78 13.58 6.32 6.32 0 0 1 0 13.533a9.344 9.344 0 0 0 5.026 1.466"/>
          </svg>
        </a>
      </div>

    </div>

    <!-- QUICK LINKS -->
    <div>
      <h3 class="text-lg font-semibold text-mitti-light mb-4">Quick Links</h3>

      <ul class="space-y-2 text-sm text-mitti-light/80">
        <li><a href="#" class="hover:text-mitti-light transition">Home</a></li>
        <li><a href="#" class="hover:text-mitti-light transition">Shop</a></li>
        <li><a href="#" class="hover:text-mitti-light transition">Offers</a></li>
        <li><a href="#" class="hover:text-mitti-light transition">About Us</a></li>
        <li><a href="#" class="hover:text-mitti-light transition">Contact</a></li>
       @if(auth()->check())

    @if(auth()->user()->role === 'user')
       <li> <a href="/become-seller"
           class="hover:text-mitti-light transition">
            Become a Seller
        </a></li>
    
    @endif

    @if(auth()->user()->role === 'seller')
       <li> <a href="/seller/dashboard"
           class="hover:text-mitti-light transition">
            Seller Dashboard
        </a></li>
       
    @endif

@endif
  
      </ul>
    </div>

    <!-- CUSTOMER SUPPORT -->
    <div>
      <h3 class="text-lg font-semibold text-mitti-light mb-4">Customer Service</h3>

      <ul class="space-y-2 text-sm text-mitti-light/80">
        <li><a href="#" class="hover:text-mitti-light transition">Track Order</a></li>
        <li><a href="{{ route('supplier.login.form') }}"class="hover:text-mitti-light transition">Login as Vendor</a>
</li>
        <li><a href="#" class="hover:text-mitti-light transition">FAQ</a></li>
        <li><a href="#" class="hover:text-mitti-light transition">Refund Policy</a></li>
        <li><a href="#" class="hover:text-mitti-light transition">Privacy Policy</a></li>
      </ul>
    </div>

    <!-- CONTACT INFO -->
    <div>
      <h3 class="text-lg font-semibold text-mitti-light mb-4">Contact</h3>

      <p class="text-sm text-mitti-light/80 leading-6">
        📍 123 Street, Mumbai, India  
        📞 +91 98765 43210  
        ✉️ support@zapkart.com
      </p>

      <div class="mt-4">
        <a href="#" class="inline-block bg-mitti-primary px-5 py-2 rounded-full text-sm font-semibold hover:bg-mitti-secondary transition">
          Chat with Support
        </a>
      </div>
    </div>

  </div>

  <!-- COPYRIGHT -->
  <div class="text-center text-sm text-mitti-light/60 mt-12 pt-6 border-t border-white/20">
    © 2025 Zapkart. All rights reserved.
  </div>

</footer>

    <!-- External script -->
    <script src="js/script.js"></script>
  </body>
</html>
