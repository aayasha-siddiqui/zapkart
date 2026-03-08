var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1.2,
    spaceBetween: 20,
    autoplay: { delay: 2500 },
    loop: true,
    breakpoints: {
        768: { slidesPerView: 3 },
    },
});
