$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
      input.attr("type", "text");
  } else {
      input.attr("type", "password");
  }
});

var showmodal = $(".in");
var modalactive = $("#user-report").find(showmodal);

$(".report-small a").click(function() {
    $(".contact-admin").addClass("showmascot");
});

$("#user-report .close").click(function() {
    $(".contact-admin").removeClass("showmascot");
});

$(document).ready(function() {
    $("#user-report").modal({
        show: false,
        backdrop: 'static'
    });
});

// (function ($) {
//   $(document).ready(function () {
//     $(window).scroll(function (e) {
//       var scrollTop = $(window).scrollTop();
//       var docHeight = $(document).height();
//       var winHeight = $(window).height();
//       var scrollPercent = (scrollTop) / (docHeight - winHeight);
//       var scrollPercentRounded = Math.round(scrollPercent * 100);

//       $('#scrollPercentLabel>span').html(scrollPercentRounded);

//       if (scrollPercentRounded  >= 95) {
//         $(".contact-admin").css("opacity", "1");
//         $(".contact-admin").css("pointer-events", "initial");
//       } else {
//         $(".contact-admin").css("opacity", "0");
//         $(".contact-admin").css("pointer-events", "none");
//       }

//     });
//   });
// })(jQuery);



$(window).scroll(function () {
  if ($(window).scrollTop() >= 300) {
    $(".main-header").addClass("fixed-header");
    $(".backtotop").css("opacity", "1");
  } else {
    $(".main-header").removeClass("fixed-header");
    $(".backtotop").css("opacity", "0");
  }
});

$(".backtotop").click(function () {
  $("html, body").animate({
      scrollTop: 0,
    },
    200
  );
});

$("#carousel-banner").slick({
  slidesToShow: 1,
  dots: true,
  speed: 300,
  autoplay: true,
  fade: true,
  cssEase: 'linear'
});

// $(".one-time").slick({
//   dots: true,
//   infinite: true,
//   speed: 300,
//   slidesToShow: 1,
//   adaptiveHeight: true,
// });

// $("#carousel-banner").owlCarousel({
//     items: 1,
//     animateOut: "fadeOut",
//     loop: false,
//     margin: 0,
//     autoplay:true,
//     autoplayTimeout:3000,
//     responsiveClass: true,
//     responsive: {
//       0: {
//         items: 1,
//       },
//       600: {
//         items: 1,
//       },
//       1000: {
//         items: 1,
//       },
//     },
//   });

$(".coursequestion-num").owlCarousel({
  margin: 0,
  loop: false,
  center: false,
  nav: true,
  dots: false,
  autoHeight: true,
  stagePadding: 40,
  responsive: {
    0: {
      items: 3,
      slideBy: 3,
    },
    500: {
      items: 5,
      slideBy: 5,
    },
    768: {
      items: 10,
      slideBy: 10,
    },
  },
});

$("#menu-index").owlCarousel({
  items: 5,
  animateOut: "fadeOut",
  loop: false,
  margin: 0,
  responsiveClass: true,
  responsive: {
    0: {
      items: 2,
    },
    600: {
      items: 2,
    },
    1000: {
      items: 5,
    },
  },
});

$(".course-main").owlCarousel({
  items: 4,
  animateOut: "fadeOut",
  loop: false,
  margin: 20,
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
    },
  },
});

$(".library-main").owlCarousel({
  items: 4,
  animateOut: "fadeOut",
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
    },
  },
});