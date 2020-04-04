<?php
$this->breadcrumbs=array(
	'จัดการสาขา'=>array('index'),
	'แก้ไขสาขา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขสาขา'
)); ?>
