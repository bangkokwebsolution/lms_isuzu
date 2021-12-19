<?php 
include "themes/template2/include/css.php";
?>
<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
    <div class="container">
        <h1>ลืมรหัสผ่าน
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
<section class="content" id="contact-us">
    <div class="container">
        <?php
        $form = $this->beginWidget('CActiveForm',array(
            'action'=>Yii::app()->createUrl('/forgot_password/Repassword')
        ));
        ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group">
                        <label for="">Reset Password</label><br>
                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-lg' , 'required' => true)); ?>
                        <?php echo $form->error($model, 'password'); ?>

                         <label for="">Confirm Reset Password</label><br>
                        <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control input-lg' , 'required' => true)); ?>
                        <?php echo $form->error($model, 'verifyPassword'); ?>

                        <?php echo $form->hiddenField($users, 'id', array('class' => 'form-control input-lg','hidden')); ?>
                    </div>
                </div>
            </div>         
            <div class="text-center">
                <!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
                <?php echo CHtml::submitButton('Confirm', array('class' => 'btn btn-warning btn-lg')); ?>
            </div>
        </div>
        <?php $this->endWidget();
        ?>
    </div>
</section>