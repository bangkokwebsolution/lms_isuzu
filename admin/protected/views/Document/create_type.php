
<?php
$this->breadcrumbs=array(
	'ระบบประเภทอกสาร'=>array('index'),
	'เพิ่มประเภทอกสาร',
);
?>
<?php echo $this->renderPartial('form_type', array(
	'model'=>$model,
	'file'=>$file,
	'formtext'=>'เพิ่มประเภทอกสาร'
)); ?>
