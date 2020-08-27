<script>
	$(document).ready(function(){
	    $("#Popup_start_date").datepicker({
	        // numberOfMonths: 2,
	        onSelect: function(selected) {
	          $("#Popup_end_date").datepicker("option","minDate", selected)
	        }
	    });
	    $("#Popup_end_date").datepicker({
	        // numberOfMonths: 2,
	        onSelect: function(selected) {
	           $("#Popup_start_date").datepicker("option","maxDate", selected)
	        }
	    }); 
});

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
								'id'=>'popup-form',
						        'enableClientValidation'=>true,
						        'clientOptions'=>array(
						            'validateOnSubmit'=>true
						        ),
						        'errorMessageCssClass' => 'label label-important',
						        'htmlOptions' => array('enctype' => 'multipart/form-data')
							)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

				<?php echo $form->errorSummary($model); ?>

				<div class="row">
					<?php echo $form->labelEx($model,'name'); ?>
					<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'name'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'detail'); ?>
					<?php echo $form->textArea($model,'detail',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'detail'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'start_date'); ?>
					<?php echo $form->textField($model,'start_date', array('autocomplete' => 'off' )); ?>
			        <?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'start_date'); ?>
				</div>
				
				<div class="row">
					<?php echo $form->labelEx($model,'end_date'); ?>
					<?php echo $form->textField($model,'end_date', array('autocomplete' => 'off' )); ?>
			        <?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'end_date'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'link'); ?>
					<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'link'); ?>
				</div>
				<div class="row">
				<?php
				if (!$model->isNewRecord) {
                $criteriapopup = new CDbCriteria;
                $criteriapopup->addCondition('id ='.$model->id);
                $popup = Popup::model()->findAll($criteriapopup);
                 foreach ($popup as $key => $value) {
                 	if ($value->pic_file) {
                 	
                 	?>
                      <img src="<?= Yii::app()->request->baseUrl; ?>/../uploads/popup/<?= $value->id; ?>/thumb/<?= $value->pic_file; ?>">                                  
                 <?php } 
                  }
              }?>
              </div>
				<div class="row">
					<?php echo $form->labelEx($model,'pic_file'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
					  	<div class="input-append">
					    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 
					    	'pic_file'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					  	</div>
					</div>
					<?php echo $form->error($model,'pic_file'); ?>
					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 900X500 Pixel
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