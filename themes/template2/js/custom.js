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
  $("html, body").animate(
    {
      scrollTop: 0,
    },
    200
  );
});


$("#carousel-banner").owlCarousel({
    items: 1,
    animateOut: "fadeOut",
    loop: true,
    margin: 0,
    autoplay:true,
    autoplayTimeout:3000,
    // autoplay:true,
    // autoplayTimeout:1000,
    // autoplayHoverPause:true
    // nav: true,
    // navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      },
    },
  });

  $(".coursequestion-num").owlCarousel({
    margin: 0,
    loop: false,
    center:false,
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
      }
    }
  });

  
$("#menu-index").owlCarousel({
    items: 5,
    animateOut: "fadeOut",
    loop: false,
    margin: 0,
    // nav: true,
    // navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
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
  // nav: true,
  // navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
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
