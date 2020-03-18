<?php
$this->breadcrumbs=array(
	'ระบบเกี่ยวกับเรา' => array('index'),
	'แก้ไขเกี่ยวกับเรา',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model' 	=> $model,
	'formtext' 	=> 'แก้ไขเกี่ยวกับเรา'
)); ?>