<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<?php
$formNameModel = 'LogAdmin';
$titleName = 'Log การยืนยันการสมัครสมาชิก';

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
	$.appendFilter("LogAdmin[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $('#LogApprove_register_date').attr('readonly','readonly');
    $('#LogApprove_register_date').css('cursor','pointer');
    $('#LogApprove_register_date').datepicker();

    $('#LogApprove_confirm_date').attr('readonly','readonly');
    $('#LogApprove_confirm_date').css('cursor','pointer');
    $('#LogApprove_confirm_date').datepicker();

EOD
, CClientScript::POS_READY);
?>
    <!-- <div class="separator bottom form-inline small">
    <span class="pull-right">
        <label class="strong">แสดงแถว:</label>
        <?php echo $this->listPageShow($formNameModel);?>
    </span>
    </div> -->
    <div class="innerLR">
            <?php $this->widget('AdvanceSearchForm', array(
            'data'=>$model,
            'route' => $this->route,
            'attributes'=>array(
            //array('name'=>'status','type'=>'text'),
                // array('name'=>'register_status','type'=>'list','query'=>$model->getregisstatusList()),
                array('name'=>'position_id','type'=>'list','query'=>Position::getPositionListSearch()),
                array('name'=>'register_date','type'=>'text'),
                array('name'=>'confirm_date','type'=>'text'),
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
                        $.appendFilter("CourseOnline[news_per_page]");
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
            'header' => 'ลำดับ',
            // 'name' => 'cert_id',
            'sortable' => false,
            'htmlOptions' => array(
                'width' => '40px',
                'text-align' => 'center',
            ),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
            'header' => 'ชื่อ - นามสกุล',
            'name'=>'search_name',
            'type'=>'raw',
            'value'=>function($data){
                return $data->firstname . ' ' . $data->lastname;
            }
        ),
        array(
            'header' => 'ตำแหน่ง',
            'type'=>'raw',
            'value'=>function($data){
                return $data->position->position_title;
            }
        ),
        array(
            'header' => 'วันที่เข้าสมัคร',
           // 'name'=>'search_name',
            'type'=>'raw',
            'value'=>function($data){
                return Helpers::changeFormatDate($data->register_date,'datetime');
            }
        ),
        array(
            'header' => 'วันที่กดยืนยันการสมัคร',
            'type'=>'raw',
            'value'=>function($data){
                return Helpers::changeFormatDate($data->confirm_date,'datetime');
            }
        ),
        array(
           // 'header' => 'ผู้ที่กดยืนยัน',
            'name'=>'confirm_user',
            'filter'=>LogApprove::getNameAdmin(),
            // 'type'=>'raw',
            'value'=>function($data){
                 $criteria = new CDbCriteria;
                 $criteria->addCondition('user_id ="'.$data->confirm_user.'"');
                 $Profile_name = Profile::model()->find($criteria);
                return $Profile_name->firstname;
            }
        ),
       
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>
