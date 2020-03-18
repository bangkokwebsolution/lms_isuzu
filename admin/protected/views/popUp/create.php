<?php
/* @var $this PopupController */
/* @var $model Popup */

$this->breadcrumbs=array(
	'ระบบจัดการป๊อปอัพ'=>array('admin'),
	'เพิ่มป๊อปอัพ',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มป๊อปอัพ','notsave'=>$notsave)); ?>