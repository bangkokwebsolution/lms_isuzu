<script>
// 	$(document).ready(function(){
// 	    $("#Popup_start_date").datepicker({
// 	        // numberOfMonths: 2,
// 	        onSelect: function(selected) {
// 	          $("#Popup_end_date").datepicker("option","minDate", selected)
// 	        }
// 	    });
// 	    $("#Popup_end_date").datepicker({
// 	        // numberOfMonths: 2,
// 	        onSelect: function(selected) {
// 	           $("#Popup_start_date").datepicker("option","maxDate", selected)
// 	        }
// 	    }); 
// });

</script>


<!-- innerLR -->
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
								'id'=>'contactusNew-form',
						        'enableClientValidation'=>true,
						        'clientOptions'=>array(
						            'validateOnSubmit'=>true
						        ),
						        'errorMessageCssClass' => 'label label-important',
						        'htmlOptions' => array('enctype' => 'multipart/form-data')
							)); ?>
				<p class="note">ค่าที่มี <font color="red">*</font> จำเป็นต้องใส่ให้ครบ</p>

				<?php echo $form->errorSummary($model); ?>

				<div class="row">
					<?php echo $form->labelEx($model,'con_firstname'); ?>
					<?php echo $form->textField($model,'con_firstname',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_firstname'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_lastname'); ?>
					<?php echo $form->textField($model,'con_lastname',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_lastname'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_firstname_en'); ?>
					<?php echo $form->textField($model,'con_firstname_en',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_firstname_en'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_lastname_en'); ?>
					<?php echo $form->textField($model,'con_lastname_en',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_lastname_en'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_position'); ?>
					<?php echo $form->textField($model,'con_position',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_position'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_position_en'); ?>
					<?php echo $form->textField($model,'con_position_en',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_position_en'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_tel'); ?>
					<?php echo $form->textField($model,'con_tel',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_tel'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_email'); ?>
					<?php echo $form->textField($model,'con_email',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'con_email'); ?>
				</div>

				<div class="row">
				<?php
				if (!$model->isNewRecord) {
                $criteriapopup = new CDbCriteria;
                $criteriapopup->addCondition('id ='.$model->id);
                $contactusnew = contactusnew::model()->findAll($criteriapopup);
                 foreach ($contactusnew as $key => $value) {
                 	if ($value->con_image) {
                 	
                 	?>
                      <img src="<?= Yii::app()->request->baseUrl; ?>/../uploads/contactusnew/<?= $value->id; ?>/thumb/<?= $value->con_image; ?>">                                  
                 <?php } 
                  }
              }?>
              </div>
				<div class="row">
					<?php echo $form->labelEx($model,'con_image'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
					  	<div class="input-append">
					    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 
					    	'con_image'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					  	</div>
					</div>
					<?php echo $form->error($model,'con_image'); ?>
					<div class="row">
						<font color="#990000">
							* รูปภาพควรมีขนาด 266x266
						</font>
					</div>
					<?php if ($notsave == 1) { ?>
						<p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
						 <?php }else{} ?> 
				</div>
				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>

			<?php $this->endWidget(); ?>

			</div><!-- form -->
		</div>
	</div>
</div>