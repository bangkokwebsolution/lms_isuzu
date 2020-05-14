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

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $label->label_course; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_Forgot_password  ?></li>
        </ol>
    </nav>
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