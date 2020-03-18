<?php
$this->breadcrumbs=array(
//	'จัดอันดับวิดีโอ'=>array('FilePdf/index','id'=>$model->lesson_id),
	'จัดการ PDF',
);
?>

<?php echo $this->renderPartial('_form', array('id'=>$id,'model'=>$model)); ?>