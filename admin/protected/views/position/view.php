
<?php
$this->breadcrumbs=array(
	'จัดการตำแหน่ง'=>array('index'),
	$model->position_title,
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'company_id',
			'value'=> $model->company->company_title
		),
		'position_title',
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($model->create_date)
		),
		'active',
		),
)); 
?>
