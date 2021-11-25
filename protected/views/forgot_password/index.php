<?php 
include "themes/template2/include/css.php";
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $mail = 'Email';
    $text_email = 'This email does not exist in the system.';
    $cancel = 'Cancel';
    $ok = 'OK';
    $warn = 'Warning';
    $note='* Remark : For user who do not have both company e-mail or private e-mail for reset password please contact system administrator at ext.no 1210 or 1211';
} else {
    $mail = 'อีเมล';
    $warn = 'แจ้งเตือน';
    $text_email = 'ไม่มี อีเมล นี้อยู่ในระบบ';
    $ok = 'ตกลง';
    $cancel = 'ยกเลิก';
    $langId = Yii::app()->session['lang'];
    $note='* หมายเหตุ : สำหรับผู้ใช้ที่ไม่มีทั้งอีเมลบริษัทหรืออีเมลส่วนตัวสำหรับรีเซ็ตรหัสผ่าน โปรดติดต่อผู้ดูแลระบบที่เบอร์ต่อ 1210 หรือ 1211';
}  

if (Yii::app()->user->hasFlash('msg')) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
          title: "<?= $warn ?>",
          text: "<?= $text_email ?>",
          icon: "warning",
          buttons: ['<?= $cancel ?>','<?= $ok ?>'],
          dangerMode: true,
      })  
  </script>
  <?php 
  Yii::app()->user->setFlash('msg',null);
}

?>

<!-- <div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage  ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_Forgot_password  ?></li>
        </ol>
    </nav>
</div> 
-->




<body class="body-login">


<?php
if ($_GET["msg"]=="error") { 
?>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    swal({
      title: "<?= $warn ?>",
          text: "<?= $text_email ?>",
          icon: "warning",
          // buttons: ['<?= $ok ?>'],
          dangerMode: true,
    });
  </script>
<?php } ?>

    <div class="container">
        <div class="login-group row justify-content-center align-items-center">
            <div class="logo-head">
                <a href="">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo-imct.png" width="250px" class="logo-login">
                </a>
            </div>
            <section class="content" id="contact-us">
                <div class="container">
                    <?php
                    $form = $this->beginWidget('CActiveForm',array(
                        'action'=>Yii::app()->createUrl('/forgot_password/Sendpassword')
                    ));
                    ?>
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="form-group">
                                    <label for=""><?= $mail ?></label><br>
                                    <?php echo $form->textField($model, 'email', array('class' => 'form-control input-lg' , 'placeholder' => 'example@gmail.com' , 'required' => true)); ?>
                                    <?php echo $form->error($model, 'email'); ?>
                                </div>

                            </div>
                        </div>         
                        <div class="text-center">
                            <!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
                            <?php echo CHtml::submitButton( $label->label_button , array('class' => 'btn btn-warning btn-lg')); ?>
                        <br>    
                        <br>
                        <br>
                            <label for="" style="padding-left: 40px;padding-right: 40px"><font color="red">* Remark : For user who do not have both company e-mail or private e-mail for reset password please contact system administrator at ext.no 1210 or 1211 <br><br>* หมายเหตุ : สำหรับผู้ใช้ที่ไม่มีทั้งอีเมลบริษัทหรืออีเมลส่วนตัวสำหรับรีเซ็ตรหัสผ่าน โปรดติดต่อผู้ดูแลระบบที่เบอร์ต่อ 1210 หรือ 1211</font></label>
                            <br>
                        </div>
                    </div>

                    <?php $this->endWidget();
                    ?>
                </div>
            </section>
        </div>
    </div>
</div>
</body>