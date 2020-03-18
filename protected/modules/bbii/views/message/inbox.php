<?php
/* @var $this MessageController */
/* @var $model BbiiMessage */
/* @var $count Array */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Inbox'),
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'ข้อความเข้า') .' ('. $count['inbox'] .')', 'url'=>array('message/inbox'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ข้อความที่ส่ง') .' ('. $count['outbox'] .')', 'url'=>array('message/outbox'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'เพิ่มข้อความใหม่'), 'url'=>array('message/create'), 'linkOptions'=>array('class'=>'btn btn-primary'))
);
?>
<style>
	.grid-view{
		padding: 0 !important;
	}
</style>
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i class="fa fa-fw fa-comments-o"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">เว็บบอร์ด</h3>
                <p class="text-white text-subhead" style="font-size: 1.6rem;">เว็บบอร์ดของหลักสูตร</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<div class="page-section">
		<div class="row">
			<div class="col-md-12" style="padding-bottom: 15px;">

				<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>

			</div>
			<div class="col-md-8 col-lg-9">

	<!--<div class="progress"><div class="progressbar" style="width:<?php echo ($count['inbox'] < 100)?$count['inbox']:100; ?>%"> </div></div>-->

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'inbox-grid',
		'dataProvider'=>$model->search(),
		'rowCssClassExpression'=>'($data->read_indicator)?"":"unread"',
		'template' => '{items}{pager}',
		'htmlOptions'=>array(
			'class'=>'panel panel-default',
		),
		'itemsCssClass'=>'table v-middle',
		'columns'=>array(
			array(
				'name'=>'sendfrom',
				'value'=>'$data->sender->member_name'
			),
			'subject',
			array(
				'name' => 'create_time',
				'value' => 'DateTimeCalculation::long($data->create_time)',
			),
			array(
				'name' => 'type',
				'value' => '($data->type)?Yii::t("bbii", "notification"):Yii::t("bbii", "message")',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view}{reply}{delete}',
				'buttons' => array(
					'view' => array(
						'url'=>'$data->id',
						'imageUrl'=>$this->module->getRegisteredImage('view.png'),
						'click'=>'js:function() { viewMessage($(this).attr("href"), "' . $this->createAbsoluteUrl('message/view') .'");return false; }',
					),
					'reply' => array(
						'url'=>'array("reply", "id"=>$data->id)',
						'label'=>Yii::t('BbiiModule.bbii','Reply'),
						'imageUrl'=>$this->module->getRegisteredImage('reply.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
					'delete' => array(
						'imageUrl'=>$this->module->getRegisteredImage('delete.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
				)
			),
		),
	)); ?>

				<br/>
			</div>




			<?php
			//right Menu
			echo $this->renderPartial('_right'); ?>


		</div>
	</div>
</div>