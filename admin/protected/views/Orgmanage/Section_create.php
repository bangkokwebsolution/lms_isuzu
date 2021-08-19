
<?php
$this->breadcrumbs=array(
	'Section'=>array('Section'),
	'เพิ่ม',
);
?>
<?php echo $this->renderPartial('_formSection', array(
	'model'=>$model,
	'formtext'=>'เพิ่ม'
)); ?>
