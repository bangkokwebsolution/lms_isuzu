<?php
  include "themes/template2/include/css.php";
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $langRe = 'en';
    $this->pageTitle = 'IMCT e-Learning';
} else {
    $langId = Yii::app()->session['lang'];
    $langRe = 'th';
    $this->pageTitle = 'ระบบจัดการ IMCT e-Learning';
}
if ($_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $keyrecaptcha = '6LdxRgocAAAAADrcEFCe2HcHeETOZdREexT52B6R'; //localhost
    $checkcap = '';
} else {
    $keyrecaptcha = '6LfcdBIcAAAAAI4VoG-z95NHdZL6XUIAvfxctrRn'; //servertest
    $checkcap = 'disabled';
}
if (Yii::app()->user->id != null) {

        $this->redirect(array('site/index'));
        exit();
}

 ?>
<?php 

$msg = Yii::app()->user->getFlash('msg');
$icon = Yii::app()->user->getFlash('icon');
?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>


<script src='https://www.google.com/recaptcha/api.js?hl=<?= $langRe ?>'></script>
<style>
    header,
    footer {
        display: none;
    }
</style>

<script>
         // กำหนดปุ่มเป็น disable ไว้ ต้องทำ reCHAPTCHA ก่อนจึงกดได้
        function makeaction() {
         document.getElementById('submit').disabled = false;
        }
</script>

<body class="body-login">
  
<?php
if (!empty($msg)) { 
?>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    swal({
      title: "Warning",
      text: "<?= $msg ?>",
      icon: "<?= $icon  ?>",
      dangerMode: true,
    });
  </script>
<?php } ?>

    <div class="container">
      <form action="<?php echo $this->createUrl('login/index') ?>" method="POST" role="form" name='loginform'>
        <div class="login-group row justify-content-center align-items-center">
            <div class="col-sm-6 col-md-5 text-center">
                <div class="logo-head">
                    <a href="">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo-imct.png" width="250px" class="logo-login">
                    </a>
                </div>
                <div class="login-content">
                    <div class="login-form">
                        <h3> <?= $label->label_header_login ?> </h3>
                        <div class="form-group">
                            <label class="pull-left" for=""><?= $label->label_header_username ?></label>
                            <input type="text" class="form-control" placeholder='<?= $label->label_header_username ?>' name="UserLogin[username]" value="<?php echo Yii::app()->request->cookies['cookie_name']->value; ?>" required>
                        </div>


                        <div class="form-group password-group">
                            <label class="pull-left" for=""><?= $label->label_header_password ?></label>
                            <input type="password" id="password-field" class="form-control" placeholder='<?= $label->label_header_password ?>' name="UserLogin[password]" required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                         <div style="margin-top: 5px" class="g-recaptcha" data-callback="makeaction" data-sitekey="<?php echo $keyrecaptcha; ?>"></div>
                            <span class="pull-left" style="margin-top: 5px">
                                    <a class="btn-forgot" href="<?php echo $this->createUrl('Forgot_password/index') ?>"><?= $label->label_header_forgotPass ?></a>
                                    <!-- <a href="< ?php echo $this->createUrl('/registration/ShowForm'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?= $label->label_header_regis ?></a> -->
                            </span>
                        <div class="login-btn login-form">
                           <button type="submit" class="btn btn-submit login-main" {{$checkcap}} id="submit" name="submit"><?= $label->label_header_yes ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
    </div>
    </div>
</body>
<script type="text/javascript">
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
      input.attr("type", "text");
      return;
  } else {
      input.attr("type", "password");
      return;
  }
});
</script>