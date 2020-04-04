
<?php
$this->breadcrumbs=array(
	'จัดการสาขา'=>array('index'),
	'เพิ่มสาขา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มสาขา'
)); ?>
