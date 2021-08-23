<?php
$this->breadcrumbs=array(
	'รายชื่อสมาชิก'=>array('admin'),
	'เพิ่มสมาชิก'
);

/*$this->menu=array(
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);*/
?>
<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>
