'use strict';

$(document).ready(function () {

    $(window).on('load', function () {
        $('.owl-carousel').owlCarousel({
            margin: 10,
            autoplay: false,
            loop: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsiveClass: false,
            responsive: {
                0: {
                    items: 1,
                },
                320: {
                    items: 1,
                    margin: 20,
                },
                540: {
                    items: 2,
                },
                600: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                1000: {
                    items: 6,
                },
                1024: {
                    items: 6,
                },
                2256: {
                    items: 6,
                },
            },
        });
    });

    window.livewireLoadOwel = function ($owl) {
        $owl.owlCarousel({
            margin: 10,
            autoplay: false,
            loop: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsiveClass: false,
            responsive: {
                0: {
                    items: 1,
                },
                320: {
                    items: 1,
                    margin: 20,
                },
                540: {
                    items: 2,
                },
                600: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                1000: {
                    items: 6,
                },
                1024: {
                    items: 6,
                },
                2256: {
                    items: 6,
                },
            },
        });
    };

});
