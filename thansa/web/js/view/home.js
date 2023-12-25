$(window).bind('load', function () {
    mobileMenu('.menu-hamburger');

    // banner index
    var swiperBannerIndex = new Swiper(".banner-index .mySwiper", {
        slidesPerView: 1,
        loop: true,
        autoplay: true,
        speed: 1000,
        touchRatio: 0.3,
        preloadImages: false,
        lazy: {
            loadPrevNext: true,
        },
        pagination: {
            el: ".banner-index .swiper-pagination",
            clickable: true
        },
    });

    // virtual tour slide
    var swiperVirtualTour = new Swiper(".virtual-tour-slide .mySwiper", {
        loop: true,
        slidesPerView: 1,
        speed: 1500,
        touchRatio: 0.4,
        preloadImages: false,
        lazy: {
            loadPrevNext: true,
        },
        breakpoints: {
            375: {
                spaceBetween: 15
            },
            768: {
                spaceBetween: 20
            },
        },
        navigation: {
            nextEl: ".virtual-tour-slide .swiper-button-next",
            prevEl: ".virtual-tour-slide .swiper-button-prev",
        },
    });

    // phân khu dự án
    var subdivisiongalleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        preloadImages: false,
        lazy: {
            loadPrevNext: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: false,
        loopedSlides: 100
    });

    // click active item 
    $('.zone-item').slice(0, 1).addClass('active');
    $('.zone-content').slice(0, 1).css('display', 'block');
    $('.slide-tab').slice(1).fadeOut();

    $('.zone-item').click(function () {
        // check active zone content => check active
        if (!$(this).hasClass('active')) {
            $('.zone-item').removeClass('active');
            $(this).addClass('active');
            $('.zone-content').slideUp();
            $(this).find('.zone-content').slideToggle();

            // tab content active
            let dataSubdivision = $(this).data('subdivision');
            let elementPick = $('.slide-tab');

            $(elementPick).fadeOut(1);
            $('#' + dataSubdivision).fadeIn();
        }
    })

    // slide client
    var swiperClient = new Swiper(".client-js .mySwiper", {
        loop: true,
        autoplay: false,
        speed: 1000,
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 15
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 24
            },
        },
        preloadImages: false,
        lazy: {
            loadPrevNext: true,
        },
        pagination: {
            el: ".client-js .swiper-pagination",
            clickable: true
        },
    });

    let thumbnails = false;
    if ($('.gallery-subtitle').length) {
        var gallerySubtitle = new Swiper('.gallery-subtitle .mySwiper', {
            loop: true,
            allowTouchMove: false,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            // navigation: {
            // 	nextEl: ".gallery-subtitle .swiper-button-next",
            // 	prevEl: ".gallery-subtitle .swiper-button-prev",
            // },
        });
        thumbnails = {swiper: gallerySubtitle}
    }
    if ($('.gallery-images').length) {
        var galleryImage = new Swiper('.gallery-images .mySwiper', {
            loop: true,
            slideToClickedSlide: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            thumbs: thumbnails,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 24
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 24
                }
            },
            on: {
                // section chính sách bán hàng - get src của slide active => ảnh to
                init: function () {
                    let getHref = $('.swiper-slide-active .gallery-image a').attr('href');
                    let getSrc = $('.swiper-slide-active .gallery-image img').attr('src');
                    let pushHref = $('.image-getsrc a');
                    let pushSrc = $('.image-getsrc img');

                    pushHref.attr('href', getHref);
                    pushSrc.attr('src', getSrc);
                },
                slideNextTransitionStart: function () {
                    let getHref = $('.swiper-slide-active .gallery-image a').attr('href');
                    let getSrc = $('.swiper-slide-active .gallery-image img').attr('src');
                    let pushHref = $('.image-getsrc a');
                    let pushSrc = $('.image-getsrc img');

                    pushHref.attr('href', getHref);
                    pushSrc.attr('src', getSrc);
                },
                slidePrevTransitionStart: function () {
                    let getHref = $('.swiper-slide-active .gallery-image a').attr('href');
                    let getSrc = $('.swiper-slide-active .gallery-image img').attr('src');
                    let pushHref = $('.image-getsrc a');
                    let pushSrc = $('.image-getsrc img');

                    pushHref.attr('href', getHref);
                    pushSrc.attr('src', getSrc);
                },
            },
        });
    }

    $('.gallery-subtitle .swiper-button-prev').click(function () {
        galleryImage.slidePrev();
    })
    $('.gallery-subtitle .swiper-button-next').click(function () {
        galleryImage.slideNext();
    })
});