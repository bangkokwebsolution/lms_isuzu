
<?php
$this->breadcrumbs=array(
	'ระบบเอกสาร'=>array('index'),
	'เพิ่มเอกสาร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'file'=>$file,
	'formtext'=>'เพิ่มเอกสาร'
)); ?>
