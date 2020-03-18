<?php
/* @var $this List_newsController */
/* @var $model News */

$this->breadcrumbs=array(
	'News'=>array('index'),
	$model->cms_id=>array('view','id'=>$model->cms_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Create News', 'url'=>array('create')),
	array('label'=>'View News', 'url'=>array('view', 'id'=>$model->cms_id)),
	array('label'=>'Manage News', 'url'=>array('admin')),
);
?>

<h1>Update News <?php echo $model->cms_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>