<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'Language'=>array('admin'),
	$model->id,
);

?>

<h1>View Language #<?php echo $model->id; ?></h1>

<?php $this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'language',
		'status'
	),
)); ?>
