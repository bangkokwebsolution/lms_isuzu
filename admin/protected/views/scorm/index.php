<?php
require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
$titleName = 'Scorm';
$formNameModel = 'Sco';

$this->breadcrumbs=array($titleName);
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
	$.appendFilter("VirtualClassroom[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'name','type'=>'text'),
			//array('name'=>'course_point','type'=>'text'),
		),
	));?>
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
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("VirtualClassroom[news_per_page]");
						InitialSortTable();	
				        jQuery("#course_date").datepicker({
						   	"dateFormat": "dd/mm/yy",
						   	"showAnim" : "slideDown",
					        "showOtherMonths": true,
					        "selectOtherMonths": true,
				            "yearRange" : "-5+10", 
					        "changeMonth": true,
					        "changeYear": true,
				            "dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
				            "monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
				                "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
					   })
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("VirtualClassroom.*", "VirtualClassroom.Delete", "VirtualClassroom.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"name")'
						),
						array(
							'header'=>'เรียน',
							'type'=>'raw',
							'value'=>function($data){
								$scormUrl = Yush::getUrl($data, Yush::SIZE_THUMB);

								return "
								<a href='javascript:runSCO".$data->id."();'>เรียน</a>
								<script>
								function runSCO".$data->id."() {
									var SCOInstanceID = ".$data->id.";
									var Page = '".$scormUrl."/".$data->playpage."';
									SCOwin = window.open('".Yii::app()->baseUrl."/../player/rte.php?SCOInstanceID='+SCOInstanceID+'&Page='+Page,'SCOwin');
									SCOwin.focus();
								}
								</script>
								";
							}
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("VirtualClassroom.*", "VirtualClassroom.View", "VirtualClassroom.Update", "VirtualClassroom.Delete") 
							),
							'template'=>'{update}{delete}',
							'buttons' => array(
								// 'view'=> array( 
								// 	'visible'=>'Controller::PButton( array("VirtualClassroom.*", "VirtualClassroom.View") )' 
								// ),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("VirtualClassroom.*", "VirtualClassroom.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("VirtualClassroom.*", "VirtualClassroom.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("VirtualClassroom.*", "VirtualClassroom.Delete", "VirtualClassroom.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
