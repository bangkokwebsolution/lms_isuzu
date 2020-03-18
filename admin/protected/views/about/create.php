<?php
$this->breadcrumbs=array(
	'ระบบเกี่ยวกับเรา' => array('index'),
	'เพิ่มเกี่ยวกับเรา',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model' 	=> $model,
	'formtext' 	=> 'เพิ่มเกี่ยวกับเรา'
)); ?>