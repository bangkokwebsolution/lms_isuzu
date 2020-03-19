
<?php
$this->breadcrumbs=array(
	'ระบบแกลลอร'=>array('index'),
	$model->id,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=> ($model->image)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->image), $model->image,array(
				"class"=>"thumbnail"
			)):'-',
		),
		array(
			'name'=>'gallery_type_id',
			'value'=> $model->gType->name_gallery_type,
		),
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
)); ?>
