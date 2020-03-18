<?php
$titleName = 'ระบบส่งเมล์ '.$title_group;
$formNameModel = 'Mailgroup';
$this->breadcrumbs = array(
	'ระบบส่งเมล์'=>array('//Mailgroup/admin'),
	'จัดการ Group mail'
);


Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Question[news_per_page]", "news_per_page");
EOD
	, CClientScript::POS_READY);
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right" style="margin-left: 10px;">
					<a class="btn btn-primary btn-icon glyphicons circle_plus"
					   href="<?php echo Yii::app()->createUrl("/mailgroup/create")?>"><i></i> สร้างกลุ่มอีกเมล์</a>
                </span>
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>'mailgroup-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Mailgroup.*", "Mailgroup.Delete", "Mailgroup.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						'group_name',
//						array(
//							'header'=>'ส่งอีเมล์',
//							'value'=>'CHtml::link("ส่งอีเมล์ (".count($data->mailuser).")", array(
//					      		"Maildetail/create",
//					      		"gid"=>"$data->id"
//					      		), array(
//								"class"=>"btn btn-primary btn-icon"
//						    )); ',
//							'type'=>'raw',
//							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
//							'headerHtmlOptions'=>array('style'=>'text-align: center'),
//						),
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton(
								array("Mailgroup.*", "Mailgroup.Update", "Mailgroup.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("Mailgroup.*", "Mailgroup.View") )'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("Mailgroup.*", "Mailgroup.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("Mailgroup.*", "Mailgroup.Delete") )'
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Mailgroup.*", "Mailgroup.Delete", "Mailgroup.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php
				echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"));
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>



