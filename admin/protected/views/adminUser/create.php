<?php

$this->breadcrumbs=array(
	UserModule::t('Users')=>array('General'),
	UserModule::t('Create'),
);

// $this->menu=array(
//     array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
//     array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//     array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
// );
?>
<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>
