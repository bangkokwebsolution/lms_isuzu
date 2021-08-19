
<?php
$this->breadcrumbs=array(
	'Group'=>array('Group'),
	'เพิ่ม',
);
?>
<?php echo $this->renderPartial('_formGroup', array(
	'model'=>$model,
	'formtext'=>'เพิ่ม'
)); ?>
