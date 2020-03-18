<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับออดีโอ'=>array('FileAudio/index','id'=>$model->lesson_id),
	'เพิ่มชื่อออดีโอ',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>