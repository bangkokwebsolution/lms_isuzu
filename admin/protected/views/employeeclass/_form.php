<!-- innerLR -->
<style type="text/css">
  #upload-profileimg {
    width: 250px;
    height: 250px;
    padding-bottom: 25px;
}

figure figcaption {
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    margin-top: 10px;
}

.btn-uploadimg {
    font-size: 14px;
    padding: 10px 20px;
}

.clearfix {
    overflow: auto;
}
</style>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.css">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'EmpClass-form',
                 'enableClientValidation'=>true,
                 'clientOptions'=>array(
                     'validateOnSubmit'=>true
                 ),
                 'errorMessageCssClass' => 'label label-important',
                 'htmlOptions' => array('enctype' => 'multipart/form-data')
             )); ?>
             <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
             <div class="row">
              <?php echo $form->labelEx($model,'title'); ?>
              <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>250, 'class'=>'span8','required'=>'required')); ?>
              <?php echo $this->NotEmpty();?>
              <?php echo $form->error($model,'title'); ?>
          </div>

          <div class="row">
              <?php echo $form->labelEx($model,'descrpition'); ?>
              <?php echo $form->textField($model,'descrpition',array('rows'=>4, 'cols'=>40,'class'=>'span8','required'=>'required','maxlength'=>255)); ?>
              <?php echo $this->NotEmpty();?>
              <?php echo $form->error($model,'descrpition'); ?>
          </div>

          <br>
                                <!-- </div> -->
                            <!-- </div> -->
                         <div class="row buttons" style="margin-top: 10px">
                          <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                      </div>
                      <?php $this->endWidget(); ?>
                  </div><!-- form -->
              </div>
          </div>
      </div>
<!-- END innerLR -->
<script>
	$(function () {
		init_tinymce();
	});
	<?php 
	if(!empty($model->cms_url)){
		?>
		$(document).ready(function(){
			$('.urllink').show();
		});
		<?php
	}else{
        ?>
        $(document).ready(function(){
         $('.urllink').hide();
     });
        <?php
    }
    ?>
    function dotextbox(checkboxElem) {
     if (checkboxElem.checked) {
        $('.textarea').hide();
    } else {
        $('.textarea').show();
    }
}
function search(ele) {
  var val = document.getElementById("News_cms_url").value;
  if(val != ''){
   $('.urllink').show();  
} else {
   $('.urllink').hide();
}
}
</script>