
<?php
$this->breadcrumbs=array(
	'ระบบหมวดหลักสูตร'=>array('index'),
	'เพิ่มหมวดหลักสูตร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'file'=>$file,
	'formtext'=>'แก้ไขหมวดหมู่',
	'imageShow'=>$imageShow
)); ?>
