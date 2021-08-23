<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	$model->username,
);

?>
<?php 
	$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'employee_id',
		'username',
		// 'password',
		'email',
		'profile.firstname',
		'profile.lastname',
		'profile.firstname_en',
		'profile.lastname_en',
		'profile.employment_date',
        'profile.kind',
        'profile.organization_unit',
        'profile.abbreviate_code',
        'profile.location',
        'profile.group_name',
        'profile.shift',
        'profile.employee_class',
        'profile.position_description',
        'profile.sex',
		
		
		'create_at'
	),
)); ?>
