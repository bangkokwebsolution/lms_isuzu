<div class="header-page parallax-window"  > <!-- data-parallax="scroll" -->
  <div class="container">
    <h1><?= $label->label_regis ?>
      <small class="pull-right">
        <ul class="list-inline list-unstyled">
          <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage ?></a></li>
        </ul>
      </small>
    </h1>
  </div>
</div>
<!-- Content -->
<?php
$form = $this->beginWidget('CActiveForm', array(
  'id' => 'registration-form',
  'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1'),
));
?>
<section class="content" id="about-us">
  <div class="container">
    <div class="well">
      <div class="detail">
        <center><h2><?php  echo $model->conditions_title; ?></h2></center>
        <?php  echo $model->conditions_detail; ?>
        <center>
          <div class="condition">
            <div class="form-group">
              <div class="radio radio-danger radio-inline">
                <input type="radio" name="status" id="accept" value="1">
                <label for="accept" class="bg-success text-success">
                  <?= $label->label_accept ?>
                </label>
              </div>
              <div class="radio radio-danger radio-inline">
                <input type="radio" name="status" id="reject" value="2">
                <label for="reject" class="bg-danger text-danger"><?= $label->label_reject ?>
                </label>
              </div>
            </div>
          </div>
          <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block')); ?> 
        </center>
      </div>
    </div>    
  </div>
</section>
<?php $this->endWidget();?>
<?php if(Yii::app()->user->hasFlash('CheckQues')){ 
    ?>
    <script>
        $(document).ready(function(){
            var url = '<?php echo Yii::app()->createUrl('registration/ShowForm'); ?>';
            var msg = '<?php echo Yii::app()->user->getFlash('CheckQues'); ?>';
            var cla = '<?php echo Yii::app()->user->getFlash('checkClass'); ?>';
            swal({
                title: "System",
                text: msg,
                type: cla,
                confirmButtonText: "OK",
            },
            function(){
                window.location.href = url;
            });
        });
    </script>
    <?php 
    Yii::app()->user->setFlash('CheckQues',null);
    Yii::app()->user->setFlash('checkClass',null);
} 
?>