
<?php
$this->breadcrumbs=array(
	'Division'=>array('Division'),
	'แก้ไข',
);
?>
<?php echo $this->renderPartial('_formDivision', array(
	'model'=>$model,
	'formtext'=>'แก้ไข'
)); ?>
