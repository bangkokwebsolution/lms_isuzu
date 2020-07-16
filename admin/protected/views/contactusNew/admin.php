<?php
$titleName = 'ระบบติดต่อเรา';
$formNameModel = 'ContactusNew';

// $this->breadcrumbs=array($titleName);
// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').toggle();
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#ContactusNew-grid').yiiGridView('update', {
// 		data: $(this).serialize()
// 	});
// 	return false;
// });
// ");
// Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
// 	$.updateGridView = function(gridID, name, value) {
// 	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
// 	    $.fn.yiiGridView.update(gridID, {data: $.param(
// 	        $("#"+gridID+" input, #"+gridID+" .filters select")
// 	    )});
// 	}
// 	$.appendFilter = function(name, varName) {
// 	    var val = eval("$."+varName);
// 	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
// 	}
// 	$.appendFilter("PopUp[news_per_page]", "news_per_page");
// EOD
// , CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'con_firstname','type'=>'text'),
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
			<div class="overflow-table" style="overflow:visible !important;">
			<?php $this->widget('AGridView', array(
				'id'=>'ContactusNew-grid',
				'dataProvider'=>$model->ContactusNewcheck()->search(),
				'filter'=>$model,
				'rowCssClassExpression'=>'"items[]_{$data->id}"',
				// 'afterAjaxUpdate'=>'function(id, data){
				// 		$.appendFilter("CourseOnline[news_per_page]");
				// 		InitialSortTable();	
				//         jQuery("#course_date").datepicker({
				// 		   	"dateFormat": "dd/mm/yy",
				// 		   	"showAnim" : "slideDown",
				// 	        "showOtherMonths": true,
				// 	        "selectOtherMonths": true,
				//             "yearRange" : "-5+10", 
				// 	        "changeMonth": true,
				// 	        "changeYear": true,
				//             "dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
				//             "monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
				//                 "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
				// 	   })
				// 	}',
				'columns'=>array(					
					array(
						'header'=>'รูปภาพ',
						'type'=>'raw',
						'value'=> 'Controller::ImageShowIndex($data,$data->con_image)',
						'htmlOptions'=>array('width'=>'110')
					),
					array(
						'name'=>'con_firstname',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"con_firstname")'
					),
					array(
						'name'=>'con_lastname',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"con_lastname")'
					),
					array(
						'name'=>'con_position',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"con_position")'
					),
					array(
						'name'=>'con_tel',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"con_tel")'
					),
					array(
						'name'=>'con_email',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"con_email")'
					),
								// array(
					// 	'name'=>'detail',
					// 	'type'=>'html',
					// 	'value'=>'UHtml::markSearch($data,"detail")'
					// ),
					
					// array(
					// 		'type'=>'raw',
					// 		'value'=>function($val){
					// 			if($val->active == 'n'){
					// 				return CHtml::link("ปิด",array("/PopUp/active","id"=>$val->id), array("class"=>"btn btn-danger"));
					// 			} else {
					// 				return CHtml::link("เปิด",array("/PopUp/active","id"=>$val->id), array("class"=>"btn btn-danger"));
					// 			}
					// 		},
					// 		'header' => 'เปิด/ปิด การแสดงผล',
					// 		'htmlOptions'=>array('style'=>'text-align: center;width:100px;'),
					// 		'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:100px;'),
					// 	),
					// array(
     //                    'header'=>'ภาษา',
     //                    'value' => function($val) {
     //                       	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
     //                       	$width = (count($lang)*100) + 20;
					//         foreach ($lang as $key => $value) {
					//     		$menu = Popup::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
					//     		$str = ' (เพิ่ม)';
					//     		$class = "btn btn-icon";
					//     		$link = array("/PopUp/create","lang_id"=>$value->id,"parent_id"=>$val->id);
					//     		if($menu || $key == 0){
					//     			$id = $menu ? $menu->id : $val->id;
					//     			$str = ' (แก้ไข)';
					//     			$class = "btn btn-success btn-icon";
					//     			$link = array("/PopUp/update","id"=>$id,"lang_id" =>$value->id,"parent_id"=>$val->id);
					//     		}
					//             $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;'));
					//         }
					//         return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
     //                	},
		   //                  'type'=>'raw',
		   //                  'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
		   //              ),
					array(
							'type'=>'html',
							'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
							'header' => 'ย้าย',
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
					/*
					'pic_file',
					'create_date',
					'create_by',
					'update_date',
					'update_by',
					'active',
					*/
					array(            
						'class'=>'AButtonColumn',
						'visible'=>Controller::PButton( 
							array("ContactusNew.*", "ContactusNew.View", "ContactusNew.Update", "ContactusNew.Delete") 
						),
						'buttons' => array(
							'view'=> array( 
								// 'visible'=>'Controller::PButton( array("ContactusNew.*", "ContactusNew.View") )' 
							),
							'update'=> array( 
								'visible'=>'Controller::PButton( array("ContactusNew.*", "ContactusNew.Update") )' 
							),
							'delete'=> array( 
								'visible'=>'Controller::PButton( array("ContactusNew.*", "ContactusNew.Delete") )' 
							),
						),
					),
				),
			)); ?>
			</div>
		</div>
	</div>
</div>
