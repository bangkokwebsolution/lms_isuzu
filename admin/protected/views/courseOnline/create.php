
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตรนิสิต/นักศึกษา'=>array('index'),
	'เพิ่มหลักสูตรนิสิต/นักศึกษา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มหลักสูตรสนิสิต/นักศึกษา'
)); ?>
