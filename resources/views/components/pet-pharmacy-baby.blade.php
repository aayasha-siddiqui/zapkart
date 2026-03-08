<!-- ============================= -->
<!-- ⭐ SUPER RESPONSIVE PRODUCT SLIDER -->
<!-- ============================= -->
<section class="w-full bg-[#F5EFE6] py-12">
    <div class="max-w-7xl mx-auto px-4">

        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-[26px] font-bold text-mitti-dark">
                    ₹100 – ₹200 Price Products
                </h2>
                <p class="text-[14px] text-gray-600">
                    Handpicked items just for you.
                </p>
            </div>
        </div>

        <div class="relative">

            <!-- LEFT HOVER -->
            <div class="hover-left absolute left-0 top-0 h-full w-[8%] z-30 hidden md:block"></div>

            <!-- RIGHT HOVER -->
            <div class="hover-right absolute right-0 top-0 h-full w-[8%] z-30 hidden md:block"></div>

            <!-- Swiper -->
            <div class="swiper productSwiper">
                <div class="swiper-wrapper">

                    @foreach($products as $product)
                    <div class="swiper-slide">

                        <a href="{{ route('products.show', $product->id) }}"
                           class="block border-2 border-[#D7BFA6] rounded-2xl bg-white p-4 
                                  shadow-md hover:shadow-xl hover:-translate-y-1 
                                  transition duration-300">

                            <!-- IMAGE WRAPPER -->
                            <div class="product-img">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}">
                            </div>

                            <h3 class="text-lg font-semibold text-mitti-dark mt-3">
                                {{ $product->name }}
                            </h3>

                            <p class="text-mitti-primary text-xl font-bold mt-1">
                                ₹{{ $product->price }}
                            </p>

                        </a>

                    </div>
                    @endforeach

                </div>
            </div>

        </div>

    </div>
</section>

<!-- Swiper CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
var swiper = new Swiper(".productSwiper", {
    loop: true,
    spaceBetween: 18,
    autoplay: {
        delay: 1600,
        disableOnInteraction: false,
    },
    speed: 850,

    /* ⭐ Only 350px devices → 1 card */
    breakpoints: {
        0: { slidesPerView: 1 },          // extra small phones (up to 350px)
        350: { slidesPerView: 1.3 },      // slightly bigger phones
        480: { slidesPerView: 1.7 },      // normal phones
        640: { slidesPerView: 2 },        // small tablets
        768: { slidesPerView: 3 },        // tablets
        1024: { slidesPerView: 4 },       // desktops
        1440: { slidesPerView: 5 },       // wide screens
    }
});


/* Hover next-prev */
document.querySelector(".hover-left")?.addEventListener("mouseenter", () => {
    swiper.slidePrev();
});
document.querySelector(".hover-right")?.addEventListener("mouseenter", () => {
    swiper.slideNext();
});
</script>

<style>
/* IMAGE PERFECT SIZE */
.product-img {
    width: 100%;
    height: 240px;
    border-radius: 14px;
    overflow: hidden;
    background: #e9dfd2;
    box-shadow: inset 0 0 10px rgba(161, 134, 95, 0.4);
}

@media (min-width: 768px) {
    .product-img { height: 260px; }
}

.product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: 0.5s ease;
}

.product-img img:hover {
    transform: scale(1.12);
}

/* Hover zones only on desktops */
.hover-left, .hover-right {
    cursor: pointer;
}

.hover-left:hover {
    background: linear-gradient(to right, rgba(215,191,166,0.25), transparent);
}

.hover-right:hover {
    background: linear-gradient(to left, rgba(215,191,166,0.25), transparent);
}
</style>
