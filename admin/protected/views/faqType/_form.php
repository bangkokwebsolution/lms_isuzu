<?php
/* @var $this FaqTypeController */
/* @var $model FaqType */
/* @var $form CActiveForm */
?>

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
					'id'=>'faqtype-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <font color="red">*</font> จำเป็นต้องใส่ให้ครบ</p>

				<div class="row">
					<?php echo $form->labelEx($model,'faq_type_title_TH'); ?>
					<?php echo $form->textField($model,'faq_type_title_TH',array('size'=>60,'maxlength'=>250,'class'=>'span8')); ?>
					
					<?php echo $form->error($model,'faq_type_title_TH'); ?>
				</div>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->