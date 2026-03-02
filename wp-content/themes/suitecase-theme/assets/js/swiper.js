jQuery(document).ready(function($) {
    var swiper3Elements = document.querySelectorAll('.swiper-3');

    swiper3Elements.forEach(function(element) {
        new Swiper(element, {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: element.querySelector('.swiper-button-next'),
                prevEl: element.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                420: {
                    slidesPerView: 2
                }
            },
            pagination: {
                el: element.querySelector('.swiper-pagination'),
                clickable: true,
            },
        });
    });
    var swiper5Elements = document.querySelectorAll('.swiper-5');

    swiper5Elements.forEach(function(element) {
        new Swiper(element, {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: element.querySelector('.swiper-button-next'),
                prevEl: element.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                768: {
                    slidesPerView: 5
                },
                420: {
                    slidesPerView: 3
                }
            },
            pagination: {
                el: element.querySelector('.swiper-pagination'),
                clickable: true,
            },
        });
    });
});