<?php
include "themes/template2/include/css.php";
?>
<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
    <div class="container">
        <h1>ลืมรหัสผ่าน / Forgot password
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>">หน้าแรก</a></li>/
                    <li><a href="#">ลืมรหัสผ่าน</a></li>
                </ul>
            </small>
        </h1>
    </div>
    <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</div>
<!-- Content -->
<style>
    .header-page {
        margin: 0px;
    }
</style>
<section class="content" id="contact-us">
    <div class="container">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl('/forgot_password/Repassword')
        ));
        ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group">
                        <label for="">ตั้งรหัสผ่านใหม่ / Reset Password</label><br>
                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-lg', 'required' => true)); ?>
                        <?php echo $form->error($model, 'password'); ?>

                        <label for="">ยืนตั้งรหัสผ่านใหม่ / Confirm Reset Password</label><br>
                        <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control input-lg', 'required' => true)); ?>
                        <?php echo $form->error($model, 'verifyPassword'); ?>

                        <?php echo $form->hiddenField($users, 'id', array('class' => 'form-control input-lg', 'hidden')); ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
                <?php echo CHtml::submitButton('ยืนยัน / Confirm', array('class' => 'btn btn-warning btn-lg')); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group" style="padding-right:15px;padding-left:15px;font-size:18px;">
                <b>ข้อแนะนำในการตั้งรหัสผ่าน</b><br>
                1.การตั้งรหัสผ่านควรจะมีจำนวน 6 ตัวอักษรขึ้นไป<br>
                2.ไม่ควรใช้ข้อมูลส่วนตัว หรือข้อมูลที่คาดเดาได้ง่าย เช่น วันเดือนปีเกิดหรือเลขที่บัตรประชาชน มาตั้งรหัสผ่าน<br>
                3.รายงานต่อเจ้าหน้าที่ดูแลระบบทันที เมื่อผู้ใช้งาน (user) คาดว่าชื่อผู้ใช้และรหัสผ่านของตนเองถูกผู้อื่นนำไปใช้งานโดยไม่ได้รับอนุญาต พร้อมกับเปลี่ยนรหัสผ่านโดยทันที<br>
                <br>
                <b>Tips for setting up a password</b><br>
                1. Password should be set more than 6 digits<br>
                2. To avoid using personal data or it can be guessed easily ex. birthday or identity card number to set own password<br>
                3. To report system administrator immediately if users found out that someone log-in the system without permission and<br>
                please change the password immediately
            </div>
        </div>
        <?php $this->endWidget();
        ?>
    </div>
</section>