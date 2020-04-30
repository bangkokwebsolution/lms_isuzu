<script src='themes/vendors/jquery.sticky.js'></script>
<script src="themes/vendors/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="themes/vendors/bootstrap/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src='themes/vendors/bootstrap-select/bootstrap-select.min.js'></script>
<script src='themes/vendors/owlcarousel/owl.carousel.min.js'></script>
<script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
<script>
    $(function() {
        $('.selectpicker').selectpicker();
    });
</script>

<script>
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 300) {
            $('.main-header').addClass('fixed-header');
            $('.navbar-brand img').css('height', '60px');
            $('.backtotop').css("opacity", "1");

        } else {
            $('.main-header').removeClass('fixed-header');
            $('.navbar-brand img').css('height', '80px');
            $('.backtotop').css("opacity", "0");

        }
    });

    $(".backtotop").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 200);
    });
</script>
