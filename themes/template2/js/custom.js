$(window).scroll(function () {
if ($(window).scrollTop() >= 300) {
    $('.main-header').addClass('fixed-header');
    $('.backtotop').css("opacity", "1");

} else {
    $('.main-header').removeClass('fixed-header');
    $('.backtotop').css("opacity", "0");

}
});

$(".backtotop").click(function () {
$("html, body").animate({
    scrollTop: 0
}, 200);
});

$('.course-main').owlCarousel({
items: 4,
animateOut: 'fadeOut',
loop: false,
margin: 20,
// nav: true,
// navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
responsiveClass: true,
responsive: {
    0: {
        items: 3,
    },
    600: {
        items: 3,
    },
    1000: {
        items: 4,
    }
}
});


$('.library-main').owlCarousel({
items: 4,
animateOut: 'fadeOut',
loop: false,
margin: 20,
nav: false,
responsiveClass: true,
responsive: {
    0: {
        items: 1,
    },
    600: {
        items: 3,
    },
    1000: {
        items: 4,
    }
}
});