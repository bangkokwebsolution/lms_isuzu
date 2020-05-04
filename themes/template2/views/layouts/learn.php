<?php 
$session = new CHttpSession;
$session->open();
$http = new CHttpRequest;
Yii::app()->user->returnUrl = $http->getUrl();
/*if ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '112.121.150.4' && $_SERVER['HTTP_HOST'] != '127.0.0.1') {
  if($_SERVER['HTTPS'] != 'on'){
    $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header('Location:'.$redirect);
  }
} */
?>
<!doctype html>
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]>
<html lang="en" class="no-js"> <![endif]-->
<html lang="en">

<head>

    <!-- Basic -->
   <?php if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            $this->pageTitle = 'Thoresen e-Learning';
        }else{
            $langId = Yii::app()->session['lang'];
            $this->pageTitle = 'ระบบการเรียนรู้โทรีเซน e-Learning';
        }
      ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap_learn.min.css"  crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/owl.carousel.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/owl.theme.default.min.css" type="text/css" media="screen">

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jasny-bootstrap.min.css" type="text/css" media="screen">

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.min.css" type="text/css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/sweetalert/dist/sweetalert.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/input.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/slicknav.css" media="screen">
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/lottie.js"></script>




    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/../template/vendors/bootstrap-select/bootstrap-select.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/../template/vendors/fontawesome/fontawesome.css" media="screen" />
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/../template/vendors/sweetalert/sweetalert2.css" crossorigin="anonymous">
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/../template/vendors/sweetalert/sweetalert2.min.js"></script>


   <!--  <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
   <!--  <?php include("themes/template2/include/css.php"); ?> -->
</head>

<body>
  <!-- <div id="loader">
    <div class="spinner">
      <div class="dot1"></div>
      <div class="dot2"></div>
    </div>
  </div> -->
    <!-- <a class="contact-admin" data-toggle="modal" href="#user-report">
        <div id="mascot-contact"></div>
    </a>

    <?php
    $mascot_path = Yii::app()->createUrl('/themes/template2/animation/mascot-contact/mascot-contact.json');
    ?>
    <script>
        var animation = bodymovin.loadAnimation({
            container: document.getElementById('mascot-contact'),
            renderer: 'svg',
            autoplay : true,
            loop: true,
            path: '<?php echo $mascot_path; ?>'
        });
    </script> -->

    <?php include("themes/template2/include/header.php"); ?>
<?php echo $content; ?>


    <?php include("themes/template2/include/footer.php"); ?>

<?php
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;
$cs->scriptMap = array(
    //'jquery.js' => $themePath.'/js/scorm/jquery.min.js',
    'jquery.js' => $themePath.'/js/library/jquery-1.11.0.min.js',
//    'jquery.yii.js' => Yii::app()->request->baseUrl.'/js/jquery.min.js',
    );
$cs->registerCoreScript('jquery')
->registerCoreScript('jquery.ui', CClientScript::POS_END)
->registerScriptFile($themePath.'/js/library/bootstrap.min.js',CClientScript::POS_END)
->registerScriptFile($themePath.'/js/library/jquery.owl.carousel.js',CClientScript::POS_END)
->registerScriptFile($themePath.'/js/library/jquery.appear.min.js',CClientScript::POS_END)
->registerScriptFile($themePath.'/js/library/perfect-scrollbar.min.js',CClientScript::POS_END)
->registerScriptFile($themePath.'/js/audiojs/audio.min.js')
->registerScriptFile($themePath.'/js/library/jquery.easing.min.js',CClientScript::POS_END)
->registerScriptFile($themePath.'/js/library/jquery.easing.min.js',CClientScript::POS_END)

//scortm_insert_lerm
->registerScriptFile($themePath.'/js/Lib/sscompat.js')
->registerScriptFile($themePath.'/js/Lib/sscorlib.js')
->registerScriptFile($themePath.'/js/Lib/ssfx.Core.js')

->registerScriptFile($themePath.'/js/Lib/API_BASE.js')
->registerScriptFile($themePath.'/js/Lib/API.js')
->registerScriptFile($themePath.'/js/Lib/API_1484_11.js')

->registerScriptFile($themePath.'/js/Lib/Controls.js')
->registerScriptFile($themePath.'/js/Lib/LocalStorage.js')
->registerScriptFile($themePath.'/js/Lib/Player.js')

->registerScriptFile($themePath.'/sweetalert/dist/sweetalert.min.js', CClientScript::POS_END);
//->registerScriptFile($themePath.'/js/script.js',CClientScript::POS_END);
/*->registerScriptFile($themePath.'/js/scorm/jquery.blockUI.js')
->registerScriptFile($themePath.'/js/scorm/jquery-ui.min.js');
->registerScriptFile($themePath.'/js/scorm/popup.js')
->registerScriptFile($themePath.'/js/scorm/treemenu.js')
->registerScriptFile($themePath.'/js/scorm/prototype.js')
->registerScriptFile($themePath.'/js/scorm/JSCookMenu.js')
->registerScriptFile($themePath.'/js/scorm/plugins.js');*/
?>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jquery-validation/dist/jquery.validate.js"></script>

<!-- <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"></script> -->

</body>

</html>