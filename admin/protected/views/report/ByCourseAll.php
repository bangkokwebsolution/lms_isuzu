<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<style>


    html {
        scroll-behavior: smooth;
    }

    .toggle{
        display: none; 
    }

    button.toggle-btn{ 
        display: block !important;
        width: 100%;
        border: none;
        color: #333;
        font-weight: 600;
        background-color: transparent;
        text-align: left;
        transition: all 0.25s ease;
    }
    button.toggle-btn:hover{
        color: red;
    }
    button.toggle-btn>span.fa{
        margin-top: 5px;
        margin-left: 1em;
    }
    .lesson-pd{
        padding-left: 15px !important;
    }
    .lesson-pd::before{
        content: "\f101";
        margin-right: 5px;
        font-family: 'fontawesome';
    }

    .chosen-with-drop .chosen-drop{
        z-index:1000!important;
        position:static!important;
    }
</style>


<?php
$titleName = 'รายงานการฝึกอบรมหลักสูตร';
$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

// Yii::app()->clientScript->registerScript('search', "
//     $('#SearchFormAjax').submit(function(){
//         return true;
//     });
// ");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');
    $('#Report_dateRang').daterangepicker({dateFormat: 'dd/mm/yy'});

EOD
, CClientScript::POS_READY);
?>

<script>
    $(document).ready(function(){

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


        $(".chosen").chosen();
        $(".widget-body").css("overflow","");

        $("#Report_period_start").datepicker({
                onSelect: function(selected) {
                  $("#Report_period_end").datepicker("option","minDate", selected)
              }
          });
        $("#Report_period_end").datepicker({            
                onSelect: function(selected) {
                 $("#Report_period_start").datepicker("option","maxDate", selected)
             }
         });     

        endDate();
        startDate();

        $("#Report_course_id").change(function(){
            var value = $("#Report_course_id option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetgenid"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_gen_id").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });


});
</script>


<div class="innerLR">

<?php

$userModel = Users::model()->findByPk(Yii::app()->user->id);
    $state = Helpers::lib()->getStatePermission($userModel);

    if($state){
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    }

    $listCourse = CHtml::listData($modelCourse,'course_id','course_title');

    $TypeEmployee = TypeEmployee::model()->findAll(array(
        'condition' => 'active = "y"',
        'order' => 'type_employee_name ASC'
    ));
    $listtype_user = CHtml::listData($TypeEmployee,'id','type_employee_name');

    // $department = Department::model()->findAll(array(
    //     'condition' => 'active = "y"',
    //     'order' => 'dep_title ASC'
    // ));
    // $listdepartment = CHtml::listData($department,'id','dep_title');


    // $position = Position::model()->findAll(array(
    //     'condition' => 'active = "y"',
    //     'order' => 'position_title ASC'
    // ));
    // $listposition = CHtml::listData($position,'id','position_title');

    if($_GET['Report']['course_id'] != ""){
        $arr_gen = CourseGeneration::model()->findAll(array(
            'condition' => 'course_id=:course_id AND active=:active ',
            'params' => array(':course_id'=>$_GET['Report']['course_id'], ':active'=>"y"),
            'order' => 'gen_title ASC',
        ));     

        if(empty($arr_gen)){
            $arr_gen[0] = "ไม่มีรุ่น";
        }else{
            $arr_gen = CHtml::listData($arr_gen,'gen_id','gen_title');
        }

    }else{
        $arr_gen[""] = "กรุณาเลือกหลักสูตร";
    }



    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'course_id','type'=>'list','query'=>$listCourse),
            array('name'=>'gen_id','type'=>'list','query'=>$arr_gen),   
            // array('name'=>'search','type'=>'text'),     
            // array('name'=>'type_register','type'=>'list','query'=>$listtype_user),
            // array('name'=>'department','type'=>'list','query'=>$listdepartment),
            // array('name'=>'position','type'=>'list','query'=>$listposition),            
            // array('name'=>'period_start','type'=>'text'),
            // array('name'=>'period_end','type'=>'text'),

    ),

    ));

?>

</div>
<?php 
    if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){
        $search = $_GET['Report'];
        
        $criteria = New CDbCriteria;
        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null) {
            $criteria->compare('t.course_id', $_GET['Report']['course_id']);
        }

        if(isset($_GET['Report']['gen_id']) && $_GET['Report']['gen_id'] != null) {
            $criteria->compare('t.gen_id', $_GET['Report']['gen_id']);
        }


        $user_Learn = LogStartcourse::model()->findAll($criteria);




?><div class="innerLR">
    <div class="widget" id="export-table33">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $titleName ?></h4>
                </div>
         <div class="widget-body" >
            <table id="table_datatable" class="table table-bordered table-striped"  >
                <thead>
                    <tr>
                        <th  style="vertical-align: middle;" class="center"><b>No.</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Minor course type</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Subminor course type</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Course Name</b></th>
                        <!-- <th  style="vertical-align: middle;" class="center"><b>Gen</b></th> -->
                        <th  style="vertical-align: middle;" class="center"><b>Group</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Employee</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Name</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Organization unit</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Abbreviate code</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Employee class</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Position desc.</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Learning Status</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>Completed Date</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no =1; 
                    foreach ($user_Learn as $keyL => $valueL) {
                        if (!isset($valueL->user)) {
                            continue;
                        }
                        // if(isset($search['gen_id']) && $search['gen_id'] !=''){
                        //     if($search['gen_id'] != $valueL->course->getGenID($valueL->course_id)){ continue; }
                        // }
                        $status_course_gen = Helpers::lib()->StatusCourseGen($valueL->course_id, $valueL->course->getGenID($valueL->course_id),$valueL->user_id);

                        if ($status_course_gen == "notLearn") {
                            $lessonStatusStr = 'Not start';
                        } else if ($status_course_gen == "learning") {
                            $lessonStatusStr = 'In progress';
                        } else if ($status_course_gen == "pass") {
                            $lessonStatusStr =  'Completed';
                        }

                        $passcourse = Passcours::model()->find(array( 
                            'condition' => 'gen_id=:gen_id AND passcours_cours=:course_id AND passcours_user=:user_id',
                            'params' => array(':gen_id'=>$valueL->course->getGenID($valueL->course_id), ':course_id'=>$valueL->course_id, ':user_id'=>$valueL->user_id),
                        ));
                     ?>
                        <tr>
                            <td class="center"><?= $no++ ?></td>
                            <td class="center"><?= isset($valueL->course->cates->type->type_name)? $valueL->course->cates->type->type_name :"" ?></td>
                            <td class="center"><?= $valueL->course->course_number ?></td>
                            <td><?= $valueL->course->course_title ?></td>
                            <!-- <td class="center"><?= isset($valueL->gen->gen_title) ? $valueL->gen->gen_title : '-' ?></td> -->
                            <td class="center"><?= $valueL->pro->group_name ?></td>
                            <td class="center"><?= $valueL->mem->employee_id ?></td>
                            <td class="center"><?= !empty($valueL->pro->Fullname_en) ? $valueL->pro->Fullname_en : $valueL->pro->Fullname ?></td>
                            <td class="center"><?= $valueL->pro->organization_unit ?></td>
                            <td class="center"><?= $valueL->mem->orgchart->title ?></td>
                            <td class="center"><?= $valueL->pro->EmpClass->title ?></td>
                            <td class="center"><?= $valueL->pro->position_description ?></td>
                            <td class="center"><?= $lessonStatusStr ?></td>
                            <td class="center"><?= isset($passcourse)? $passcourse->passcours_date :'' ?></td>
                        </tr>
                    <?php 

                } ?>
                </tbody>
            </table>
            
            *หากต้องการดูรายละเอียดกรุณากด Export Excel
            <br>
            <a href="<?= $this->createUrl('report/ExcelByCourseAll',array(
            'Report[course_id]'=>$_GET['Report']['course_id'],
            'Report[gen_id]'=>$_GET['Report']['gen_id'])); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>Export Excel</a>
        </div>
    </div>
</div>
    <?php } else { ?>
       <div class="innerLR">
        <div class="widget" style="margin-top: -1px;">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines">
                    <i></i> </h4>
                </div>
                <div class="widget-body">

                    <h3 class="text-success">กรุณาป้อนข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3>

                </div>
            </div>
        </div>
    <?php } ?>

<script type="text/javascript">
    $('#table_datatable').DataTable({"searching": true,});

    // $(document).ready(function() {
    //     $('#table_datatable').DataTable( {
    //         "scrollX": true,
    //         "searching": true,
    //         'responsive': true
    //     } );
    // } );


</script>
