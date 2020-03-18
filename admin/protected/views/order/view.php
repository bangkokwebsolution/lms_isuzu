<?php
$this->breadcrumbs=array(
	'จัดการแจ้งชำระเงินสั่งซื้อของ'=>array('index'),
	$model->order_cost,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'checkcolspan'=>3,
	'checkItemShop'=>array(
		'table' => 'OrderDetail',
		'condition' => " order_id = '$model->order_id' ",
		'with' => 'shops',
		'text' => 'สินค้าที่สั่ง'
	),
	'attributes'=>array(
		array(
			'name'=>'order_file',
			'type'=>'raw',
			'value'=> ($model->order_file)?CHtml::link(CHtml::image(Yush::getUrl($model, Yush::SIZE_ORIGINAL, $model->order_file),'',array("class"=>"thumbnail")),Yush::getUrl($model, Yush::SIZE_ORIGINAL, $model->order_file),array("rel"=>"prettyPhoto")):'<font color="red">ยังไม่ได้ยืนยันการโอนเงิน</font>',
		),
		/*array(
			'name'=>'order_id',
			'value'=>sprintf("%06d",$model->order_id),
		),
		array(
			'name'=>'order_countnum',
			'value'=>number_format($model->order_countnum).' ชนิด',
		),
		array(
			'name'=>'order_countall',
			'value'=>number_format($model->order_countall).' รายการ',
		),*/
		array(
			'name'=>'user_id',
			'value'=>$model->NameUser,
		),
		array(
			'name'=>'order_bank',
			'type'=>'raw',
			'value'=>$model->NameBankCheck
		),
		array(
			'name'=>'order_cost',
			'value'=>number_format($model->order_cost),
		),
		array(
			'name'=>'order_date_add',
			'value'=>ClassFunction::datethai($model->order_date_add)
		),
		'order_date_time',
		array(
			'name'=>'order_ems',
			'type'=>'html',
			'value'=>$model->AddEMS
		),
		// array(
		// 	'name'=>'order_point',
		// 	'value'=>number_format($model->order_point),
		// ),
	),
));?>