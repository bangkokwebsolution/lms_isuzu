
<?php
$this->breadcrumbs=array(
	'Group'=>array('Group'),
	'แก้ไข',
);
?>
<?php echo $this->renderPartial('_formGroup', array(
	'model'=>$model,
	'formtext'=>'แก้ไข'
)); ?>
