
<?php
$this->breadcrumbs=array(
	'Department'=>array('Department'),
	'เพิ่ม',
);
?>
<?php echo $this->renderPartial('_formDepartment', array(
	'model'=>$model,
	'formtext'=>'เพิ่ม'
)); ?>
