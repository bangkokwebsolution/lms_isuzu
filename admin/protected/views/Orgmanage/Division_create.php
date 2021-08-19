
<?php
$this->breadcrumbs=array(
	'Division'=>array('Division'),
	'เพิ่ม',
);
?>
<?php echo $this->renderPartial('_formDivision', array(
	'model'=>$model,
	'formtext'=>'เพิ่ม'
)); ?>
