<?php
/* @var $this PopupController */
/* @var $model Popup */

$this->breadcrumbs=array(
	'ระบบติดต่อเรา'=>array('admin'),
	'เพิ่มผู้ติดต่อ',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'notsave'=>$notsave)); ?>