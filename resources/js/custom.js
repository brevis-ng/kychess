import Swiper, { Autoplay, Navigation, Pagination } from 'swiper';
Swiper.use([Autoplay, Navigation, Pagination]);

$(function () {
    // Slider
    const swiper = new Swiper('.swiper', {
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        speed: 1000,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        }
    });

    // Top button
    window.onscroll = function() {
        scrollFunc();
    };
    function scrollFunc() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            $('#topBtn').show();
        } else {
            $('#topBtn').hide();
        }
    }

    // To Top Botton
    $('#topBtn').on('click', function scrollToTop() {
        var position = document.body.scrollTop || document.documentElement.scrollTop;
        if (position) {
            window.scrollBy(0, -50);
            requestAnimationFrame(scrollToTop);
        }
        return true;
    });
});
