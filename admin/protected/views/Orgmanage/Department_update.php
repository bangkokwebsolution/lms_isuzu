
<?php
$this->breadcrumbs=array(
	'Department'=>array('Department'),
	'แก้ไข',
);
?>
<?php echo $this->renderPartial('_formDepartment', array(
	'model'=>$model,
	'formtext'=>'แก้ไข'
)); ?>
