<?php
/* @var $this Mange_divisionController */
/* @var $data TblDivision */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('div_title')); ?>:</b>
	<?php echo CHtml::encode($data->div_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dep_code')); ?>:</b>
	<?php echo CHtml::encode($data->dep_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />


</div>