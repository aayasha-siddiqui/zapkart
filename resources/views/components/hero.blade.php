<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- TAILWIND CDN -->
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
          light: "#E5C8A4"
        }
      }
    }
  }
}
</script>

<title>Zapkart</title>
</head>

<body class="bg-white">

<!-- ============================= -->
<!-- ✅ HERO SECTION (NO SCROLL) -->
<!-- ============================= -->
<section class="h-auto py-10 bg-mitti-cream/70 flex items-center">
  <div class="max-w-7xl mx-auto px-3 md:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

    <!-- LEFT TEXT -->
    <div class="space-y-7" data-animate="fade-up">
      
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-mitti-dark">
        Fresh groceries 
        <span class="text-mitti-primary">delivered fast</span><br class="hidden sm:block" />
        — with a smile.
      </h1>

      <p class="text-lg text-mitti-dark/70 max-w-xl">
        Zapkart brings everyday essentials, premium brands, instant deals — 
        all wrapped in a warm, earthy Mitti-style experience.
      </p>

      <!-- SEARCH BAR -->
      <form class="flex gap-2 w-full max-w-lg">
        <input
          type="text"
          placeholder="What do you need today?"
          class="flex-1 rounded-l-full px-5 py-3 border border-mitti-secondary/40 focus:outline-none bg-white shadow-sm"
        />
        <button
          class="bg-mitti-primary hover:bg-mitti-secondary text-white px-6 py-3 rounded-r-full font-semibold transition shadow"
        >
          Find
        </button>
      </form>

      <!-- ICON FEATURES -->
      <div class="flex items-center gap-4 mt-2">
        
        <div class="flex items-center gap-2 bg-white border border-mitti-light px-3 py-2 rounded-full shadow-sm">
          <div class="w-10 h-10 rounded-lg bg-mitti-primary/20 flex items-center justify-center">
            <svg class="w-6 h-6 text-mitti-primary" viewBox="0 0 24 24" fill="none">
              <path d="M3 12h18" stroke="currentColor" stroke-width="1.5"/>
            </svg>
          </div>
          <div class="text-sm">
            <div class="font-semibold text-mitti-dark">10–20 min</div>
            <div class="text-xs text-mitti-dark/60">Express delivery</div>
          </div>
        </div>

        <div class="flex items-center gap-2 bg-white border border-mitti-light px-3 py-2 rounded-full shadow-sm">
          <div class="w-10 h-10 rounded-lg bg-mitti-secondary/20 flex items-center justify-center">
            <svg class="w-6 h-6 text-mitti-secondary" viewBox="0 0 24 24" fill="none">
              <path d="M12 3v18" stroke="currentColor" stroke-width="1.5"/>
            </svg>
          </div>
          <div class="text-sm">
            <div class="font-semibold text-mitti-dark">Fresh Quality</div>
            <div class="text-xs text-mitti-dark/60">Sourced daily</div>
          </div>
        </div>

      </div>

      <!-- DOWNLOAD BUTTON -->
      
    </div>

    <!-- RIGHT IMAGE -->
    <div>

      <div class="rounded-3xl bg-white shadow-xl border border-mitti-secondary/30 p-5" data-animate="fade-left">
        
        <div class="rounded-2xl overflow-hidden shadow-lg">
          <img 
            src="images/hr1.jpg"
            class="w-full object-cover hover:scale-[1.03] transition duration-500"
          >
        </div>

        <!-- SMALL PROMO GRID -->
        <div class="grid grid-cols-2 gap-4 mt-5">

          <div class="bg-white rounded-xl border border-mitti-secondary/30 p-4 flex items-center gap-3 shadow-sm">
            <div class="w-12 h-12 rounded-lg bg-mitti-primary/20 flex items-center justify-center">
              <svg class="w-6 h-6 text-mitti-primary" viewBox="0 0 24 24" fill="none">
                <path d="M3 10h18" stroke="currentColor" stroke-width="1.5"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-mitti-dark text-sm">Deals</div>
              <div class="text-xs text-mitti-dark/60">Up to 40% off</div>
            </div>
          </div>

          <div class="bg-white rounded-xl border border-mitti-secondary/30 p-4 flex items-center gap-3 shadow-sm">
            <div class="w-12 h-12 rounded-lg bg-mitti-secondary/20 flex items-center justify-center">
              <svg class="w-6 h-6 text-mitti-secondary" viewBox="0 0 24 24" fill="none">
                <path d="M12 2v20" stroke="currentColor" stroke-width="1.5"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-mitti-dark text-sm">Fresh</div>
              <div class="text-xs text-mitti-dark/60">Weekly restocks</div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

<!-- ============================= -->
<!-- ✅ FEATURED CATEGORIES -->
<!-- ============================= -->
@php
$featuredOrder = [1,3,4,5,26,25,20,10,12]; // IDs in the order you want

$featuredCategories = \App\Models\Category::whereIn('id', $featuredOrder)
    ->orderByRaw("
        CASE id
        ".implode(' ', array_map(fn($id, $i) => "WHEN $id THEN $i", $featuredOrder, array_keys($featuredOrder)))."
        END
    ")
    ->get();
@endphp

<section class="w-full bg-[#f5f0e9] py-10">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-[24px] font-semibold text-[#282828] mb-1">
            Featured Categories
        </h2>
        <p class="text-[14px] text-gray-600 mb-8">
            Browse our curated collections for every style.
        </p>

        <!-- Swiper -->
        <div class="swiper categorySwiper">
            <div class="swiper-wrapper">
              @if(auth()->check() && auth()->user()->role === 'shopkeeper' && $featuredCategories->isEmpty())
    <p class="text-gray-500 text-center mt-6">
        No categories available. Products not assigned yet.
    </p>
@endif


                @foreach($featuredCategories as $cat)
                    <div class="swiper-slide group cursor-pointer">
                        <div class="overflow-hidden rounded-md aspect-[4/3] bg-white">
                            <img src="{{ category_image_url($cat->image) }}"
                                 alt="{{ $cat->name }}"
                                 class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110" />
                        </div>
                        <button class="mt-3 text-[13px] px-4 py-1.5 align-item-center ">
                           <a href="{{ route('category.products', $cat->id) }}" 
   class="inline-block px-4 py-2 text-sm md:text-base font-medium text-mitti-primary border border-mitti-primary hover:bg-mitti-primary hover:text-white transition-colors duration-200 rounded">
   Shop Now
</a>

                        </button>
                        
                        <!-- <p class="mt-1 text-[23px] text-mitti-primary-600 text-center">
                            {{ $cat->tagline }}
                        </p> -->
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
var swiper = new Swiper(".categorySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 1700,
        disableOnInteraction: false,
    },
    speed: 900,

    breakpoints: {
        // Mobile: 0px – 639px → 1 slide
        0: { 
            slidesPerView: 1 
        },

        // Tablet: 640px – 1023px → 1 slide
        640: { 
            slidesPerView: 1 
        },

        // Desktop/Laptop: 1024px+ → 4 slides
        1024: { 
            slidesPerView: 4,
            spaceBetween: 22 
        }
    }
});

</script>




<!-- ANIMATION -->
<script>
document.querySelectorAll("[data-animate]").forEach(el => {
  el.style.opacity = 0;
  el.style.transform = "translateY(20px)";
  setTimeout(() => {
    el.style.transition = "all 0.8s ease-out";
    el.style.opacity = 1;
    el.style.transform = "translateY(0)";
  }, 200);
});
</script>

</body>
</html>
