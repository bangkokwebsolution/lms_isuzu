<?php if (Yii::app()->user->hasFlash('msg')) {  ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    swal({
      title: "แจ้งเตือน",
      text: "<?= Yii::app()->user->getFlash('msg'); ?>",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })  
</script>
<?php 
Yii::app()->user->setFlash('msg',null);
} 
?>

<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
    <div class="container">
        <h1><?= $label->label_Forgot_password  ?>
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage  ?></a></li>/
                    <li><a href="#"><?= $label->label_Forgot_password  ?></a></li>
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
            'action'=>Yii::app()->createUrl('/forgot_password/Sendpassword')
        ));
        ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group">
                        <label for="">Email</label><br>
                        <?php echo $form->textField($model, 'email', array('class' => 'form-control input-lg' , 'placeholder' => 'example@gmail.com' , 'required' => true)); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                </div>
            </div>         
            <div class="text-center">
                <!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
                <?php echo CHtml::submitButton( $label->label_button , array('class' => 'btn btn-warning btn-lg')); ?>
            </div>
        </div>

        <?php $this->endWidget();
        ?>
    </div>
</section>