
<?php
$this->breadcrumbs=array(
	'ระบบประเภทอกสาร'=>array('index'),
	'แก้ไขประเภทอกสาร',
);
?>
<?php echo $this->renderPartial('form_type', array(
	'model'=>$model,
	'file'=>$file,
	'formtext'=>'แก้ไขเประเภทอกสาร'
)); ?>
