jQuery(document).ready(function($){
    var swiper = new Swiper(".block__gallery",
        {
            slidesPerView: 3,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                1600: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 2
                },
                420: {
                    slidesPerView: 1
                }
            }
        }
    );
});
