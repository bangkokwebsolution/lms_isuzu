
<?php
$this->breadcrumbs=array(
	'ระบบสไลด์รูปภาพ'=>array('index'),
	$model->imgslide_link,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'imgslide_picture',
			'type'=>'raw',
			'value'=> ($model->imgslide_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->imgslide_picture), $model->imgslide_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'imgslide_title',
		'imgslide_detail',
		'imgslide_link',
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
