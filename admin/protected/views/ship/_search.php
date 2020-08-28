<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ship_name'); ?>
		<?php echo $form->textField($model,'ship_name',array('size'=>60,'maxlength'=>255,'class'=>'span6')); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'ship_name_en'); ?>
		<?php echo $form->textField($model,'ship_name_en',array('size'=>60,'maxlength'=>255,'class'=>'span6')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons search'),'<i></i> ค้นหา'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->