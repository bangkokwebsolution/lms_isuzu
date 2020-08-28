<?php

$this->breadcrumbs=array(
	'ระบบจัดการติดต่อเรา'=>array('admin'),
	$model->name,
);
?>


<?php 

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'con_image',
			'type'=>'raw',
			'value'=> ($model->con_image)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->con_image), $model->con_image,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'name',
		'detail',
		array(
			'name'=>'start_date',
			'value'=> ClassFunction::datethaiTime($model->start_date)
		),
		array(
			'name'=>'end_date',
			'value'=> ClassFunction::datethaiTime($model->end_date)
		),
		'link',
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($model->create_date)
		),
		array(
			'name'=>'create_by',
			'value'=>$model->usercreate->username
		),
		array(
			'name'=>'update_date',
			'value'=> ClassFunction::datethaiTime($model->update_date)
		),
		array(
			'name'=>'update_by',
			'value'=>$model->userupdate->username
		),
		),
)); 
?>
