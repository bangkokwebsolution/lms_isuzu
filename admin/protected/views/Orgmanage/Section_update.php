
<?php
$this->breadcrumbs=array(
	'Section'=>array('Section'),
	'แก้ไข',
);
?>
<?php echo $this->renderPartial('_formSection', array(
	'model'=>$model,
	'formtext'=>'แก้ไข'
)); ?>
