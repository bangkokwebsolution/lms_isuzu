<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.isotope.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.slicknav.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/parallax.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/vendors/fresco-2.3.0/js/fresco.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/vendors/owlcarousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jasny-bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/video.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/knob/jquery.knob.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.textillate.js"></script>

<script>
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 300) {
            $('.main-header').addClass('fixed-header');
            $('.backtotop').css("opacity", "1");

        } else {
            $('.main-header').removeClass('fixed-header');
            $('.backtotop').css("opacity", "0");

        }
    });

    $(".backtotop").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 200);
    });
</script>

<script>
    $('.course-main').owlCarousel({
        items: 4,
        animateOut: 'fadeOut',
        loop: false,
        margin: 20,
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
</script>