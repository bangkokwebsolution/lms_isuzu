<?php
$titleName = 'แบบประเมิน';
$formNameModel = 'Questionnaire';
$this->breadcrumbs = array(
	'ระบบแบบประเมิน'
);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

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
	$.appendFilter("Questionnaire[news_per_page]", "news_per_page");
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
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$header->search(),
					'filter'=>$header,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Questionnaire[news_per_page]");	
						InitialSortTable();
					}',
					'columns'=>array(
						// array(
						// 	'visible'=>Controller::DeleteAll(
						// 		array("Questionnaire.*", "Questionnaire.Delete", "Questionnaire.MultiDelete")
						// 	),
						// 	'class'=>'CCheckBoxColumn',
						// 	'id'=>'chk',
						// ),
						array(
							'name'=>'name_ques',
							'type'=>'html',
							'value'=>'CHtml::decode(UHtml::markSearch($data,"survey_name"))'
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Questionnaire.*", "Questionnaire.View", "Questionnaire.Update", "Questionnaire.Delete") 
							),
							'template'=>'{update} {delete}',
							'buttons' => array(
								// 'view'=> array( 
								// 	'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.View") )' 
								// ),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Questionnaire.*", "Questionnaire.Delete", "Questionnaire.MultiDelete")) ) : ?>
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
