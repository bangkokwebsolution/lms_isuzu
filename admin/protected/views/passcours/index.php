<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>

<?php
$titleName = 'ระบบReport ผู้ผ่านการเรียน';
$formNameModel = 'Passcours';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
	$('#export').click(function(){
	   	window.location = '". $this->createUrl('//Passcours/ReportPass')  . "?' + $(this).parents('form').serialize() + '&export=true';
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
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
	$.appendFilter("Passcours[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<script type="text/javascript">
    $(function() {

    	$(".chosen").chosen();
    	$(".widget-body").css("overflow","");
        // $('#courseSelectMulti').select2();
        endDate();
        startDate();
    });
    function startDate() {
        $('#passcoursStartDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function() {
                $("#passcoursEndDateBtn").datepicker("option","minDate", this.value);
            },
        });
    }
    function endDate() {
        $('#passcoursEndDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
        });
    }
</script>
<div class="innerLR">
	<div class="widget">
	<?php 
	// $this->renderPartial('search',array(
	// 			'model'=>$model,
	// 		)); 
	// $Generation = Generation::model()->findAll();
	// $listGeneration = CHtml::listData($Generation,'id_gen','name');

	$userModel = Users::model()->findByPk(Yii::app()->user->id);
	$state = Helpers::lib()->getStatePermission($userModel);
	if(!$state){
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1 and cate_id != 1 and create_by = "'.Yii::app()->user->id.'"',
			'order' => 'course_id DESC'
    )); //LMS Only
	}else{
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1 and cate_id != 1',
			'order' => 'course_id DESC'
    )); //LMS Only
	}

	$type_user[1] = 'บุคคลทั่วไป';
	$type_user[2] = 'พนักงาน';
	
    $listCourse = CHtml::listData($CourseOnline,'course_id','course_title');

    $divisiondata = Division::model()->getDivisionListNew(); 
    $departmentdata = Department::model()->getDepartmentListNew();
    $stationdata = Station::model()->getStationList();

	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			// array('name'=>'generation','type'=>'list','query'=>$listGeneration),
			array('name'=>'passcours_cours','type'=>'list','query'=>$listCourse),
			array('name'=>'search','type'=>'text'),
			array('name'=>'type_register','type'=>'list','query'=>$type_user),
			//array('name'=>'division_id','type'=>'listMultiple','query'=>$divisiondata),
			array('name'=>'department','type'=>'listMultiple','query'=>$departmentdata),
			//array('name'=>'station','type'=>'listMultiple','query'=>$stationdata),
			array('name'=>'period_start','type'=>'text'),
			array('name'=>'period_end','type'=>'text'),
	),
	));
			?>
	</div><!-- search-form -->
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<?php if(!empty($_GET)){ ?>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<!--span class="pull-left">
					<?php echo CHtml::tag('button',array(
						'class' => 'btn btn-primary btn-icon glyphicons print',
						'id'=> 'export',
					),'<i></i>ออกรายงาน'); ?>
				</span-->
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php


				$this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->passcourscheck()->highsearch(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Passcours[news_per_page]");	
						InitialSortTable();
						$("#passcours_date").datepicker({
						   	"dateFormat": "dd/mm/yy",
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
							'header' => 'ชื่อ - สกุล',
							'name'=>'passcours_user',
							'filter'=>CHtml::activeTextField($model,'user_name'),
							'type' => 'raw',
							'value'=>'$data->NameUser',
						    'htmlOptions' => array(
						    	'width'=>'120',
						  	),
						),
						array(
							'header' => 'รหัสบัตรประชาชน',
							'type' => 'raw',
							'value' => function($data) {
								return $data->user->identification;
							},
						),
						array(
							'header' => 'ประเภทสมาชิก',
							'type' => 'html',
							'value' => function($data) {
								return $data->Profiles->Type->name;
							},
						),
						// array(
						// 	'header' => 'ที่อยู่',
						// 	'type' => 'html',
						// 	'value' => function($data) {
						// 		return $data->Profiles->address;
						// 	},
						// 	'htmlOptions' => array(
						// 		'width' => '200',
						// 	),
						// ),
						// array(
						// 	'header' => 'จังหวัด',
						// 	'type' => 'html',
						// 	'value' => function($data) {
						// 		return $data->Profiles->Province->pv_name_th;
						// 	},
						// ),
						// array(
						// 	'header' => 'ประเภทธุรกิจ',
						// 	'type' => 'html',
						// 	'value' => function($data) {
						// 		return $data->Profiles->Province->pv_name_th;
						// 	},
						// ),
						array(
							'header' => 'e-mail',
							'type' => 'html',
							'value' => function($data) {
								return $data->user->email;
							},
						),
						// array(
						// 	'header' => 'โทรศัพท์',
						// 	'type' => 'html',
						// 	'value' => function($data) {
						// 		$html = '<span class="glyphicons iphone btn-icon"><i></i>' . $data->Profiles->phone . '</span>';
						// 		if($data->Profiles->fax !=null ) {
						// 			$html .= '<span class="glyphicons iphone btn-icon"><i></i>' . $data->Profiles->fax . '</span>';
						// 		}
						// 		return $html;
						// 	},
						// 	'htmlOptions' => array(
						// 		'width' => '100',
						// 	),
						// ),
						array(
							'name'=>'passcours_cours',
							'filter'=>CHtml::activeTextField($model,'cours_name'),
							'type' => 'raw',
							'value' => function($data) {
								$text_gen = "";
								if($data->gen_id != 0){
									$text_gen = " รุ่น ".$data->gen->gen_title;
								}


								return $data->CourseOnlines->course_title;
							},
							// 'value'=>'$data->CourseOnlines->course_title',
						),
						array(
							'name'=>'gen_id',
							'type' => 'raw',
							'value' => function($data) {
								$text_gen = "";
								if($data->gen_id != 0){
									$text_gen = "รุ่น ".$data->gen->gen_title;
								}


								return $text_gen;
							},
							// 'value'=>'$data->CourseOnlines->course_title',
						),
						// array(
						// 	'header'=>'ฝ่าย',
						// 	'type' => 'raw',
						// 	'value'=>'$data->user->division->div_title',
						// 	'htmlOptions' => array(
						// 		'width' => '100',
						// 	),
						// ),
						array(
							'header'=>'แผนก',
							'type' => 'raw',
							'value'=>'$data->user->department->dep_title',
							'htmlOptions' => array(
								'width' => '100',
							),
						),
						array(
							'header'=>'ตำแหน่ง',
							'type' => 'raw',
							'value'=>'$data->user->position->position_title',
							'htmlOptions' => array(
								'width' => '100',
							),
						),
						// array(
						// 	'header'=>'สถานี',
						// 	'type' => 'raw',
						// 	'value'=>'$data->user->station->station_title',
						// 	'htmlOptions' => array(
						// 		'width' => '100',
						// 	),
						// ),
						array(
							'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data->passcours_date, 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						    	'model'=>$model,
						        'attribute'=>'passcours_date',
						        'htmlOptions' => array(
						        	'id' => 'passcours_date',
						        ),  
						        'options' => array(
						        	'mode'=>'focus',
						        	'dateFormat'=>'dd/mm/yy',
						            'showOn' => 'focus', 
						            'showOtherMonths' => true,
						            'selectOtherMonths' => true,
						            'yearRange' => '-5+10', 
						            'changeMonth' => true,
						            'changeYear' => true,
						            'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
						           	'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
						           		'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
						)), true)),
						array(
							'header'=>'พิมพ์ใบผ่านการอบรม',
							'name'=>'list_print',
							'filter'=>false,
							'type'=>'raw',
							// 'value'=>'$data->PrintCertificate',
							'value'=>function($data){
								$certIdModel = CertificateNameRelations::model()->find(array('condition' => 'course_id = '.$data->passcours_cours));
								if(empty($certIdModel)){
									return 'ไม่มีใบประกาศนียบัตร';
								}else{
									return $data->PrintCertificate;
								}
								
							},
						),
						array(
							'header'=>'บันทึกใบผ่านการประกาศนียบัตร',
							'name'=>'list_print',
							'filter'=>false,
							'type'=>'raw',
							// 'value'=>'$data->SaveFile',
							'value'=>function($data){
								$certIdModel = CertificateNameRelations::model()->find(array('condition' => 'course_id = '.$data->passcours_cours));
								if(empty($certIdModel)){
									return 'ไม่มีใบประกาศนียบัตร';
								}else{
									return $data->SaveFile;
								}
								
							},
						),
					),
				)); ?>
			</div>
		</div>
		<?php } else { ?>
        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
        <h4>กรุณาเลือกหลักสูตร หรือข้อมูลที่ต้องการ แล้วกด ปุ่มค้นหา</h4>
        </div>
    <?php } ?>
	</div>
</div>
