<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/chosen.min.css" />

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
$titleName = 'รายงานภาพรวมหลักสูตร';
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
    $('#Report_dateRang').daterangepicker();

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
            array('name'=>'type_register','type'=>'list','query'=>$listtype_user),
            // array('name'=>'department','type'=>'list','query'=>$listdepartment),
            // array('name'=>'position','type'=>'list','query'=>$listposition),            
            array('name'=>'period_start','type'=>'text'),
            array('name'=>'period_end','type'=>'text'),
    ),

    ));

?>

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> <?php echo $titleName; ?>
            </h4>
        </div>

<?php 
    if(!empty($_GET) && $_GET['Report']['course_id'] != null && $_GET['Report']['gen_id'] != null){   
        $search = $_GET['Report'];

        $course_online = CourseOnline::model()->findByPk($search["course_id"]);

        $lesson_online = Lesson::model()->findAll(array(
            "condition"=>"active='y' AND lang_id='1' AND course_id='".$search["course_id"]."'",
            "order"=>"title ASC"
        ));

        $gen_title = "";
        if($_GET['Report']['gen_id'] != 0){
            $gen_title = CourseGeneration::model()->findByPk($_GET['Report']['gen_id']);
            $gen_title = " รุ่น ".$gen_title->gen_title;
        }

        $statusArray = array(
            'learning'=>'<b style="color: green;">กำลังเรียน</b>', 
            'pass' => '<b style="color: blue;">เรียนสำเร็จ</b>',
            'notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>'
        );


        $criteria = new CDbCriteria;
        $criteria->with = array('pro', 'course', 'mem');

        if(isset($_GET['Report']['search']) && $_GET['Report']['search'] != null){
            $ex_fullname = explode(" ", $_GET['Report']['search']);

            if(isset($ex_fullname[0])){
                $pro_fname = $ex_fullname[0];
                $criteria->compare('pro.firstname_en', $pro_fname, true);
                $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');

                $criteria->compare('pro.firstname', $pro_fname, true, 'OR');
                $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                $criteria->compare('pro.lastname',$pro_lname,true);
                $criteria->compare('pro.lastname_en', $pro_lname, true, 'OR');
            }
        }

        $criteria->compare('superuser',0);
        $criteria->addCondition('user.id IS NOT NULL');

        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null) {
            $criteria->compare('t.course_id', $_GET['Report']['course_id']);
        }

        if(isset($_GET['Report']['gen_id']) && $_GET['Report']['gen_id'] != null) {
            $criteria->compare('t.gen_id', $_GET['Report']['gen_id']);
        }

        // if(isset($_GET['Report']['type_register']) && $_GET['Report']['type_register'] != null) {
        //     $criteria->compare('pro.type_employee', $_GET['Report']['type_register']);
        // }

        if(isset($_GET['Report']['department']) && $_GET['Report']['department'] != null) {
            $criteria->compare('user.department_id',$_GET['Report']['department']);
        }

        if(isset($_GET['Report']['position']) && $_GET['Report']['position'] != null) {
            $criteria->compare('user.position_id',$_GET['Report']['position']);
        }

        if(isset($_GET['Report']['period_start']) && $_GET['Report']['period_start'] != null) {
            $criteria->compare('start_date >= "' . date('Y-m-d 00:00:00', strtotime($_GET['Report']['period_start'])) . '"');
        }
        if(isset($_GET['Report']['period_end']) && $_GET['Report']['period_end'] != null) {
            $criteria->compare('start_date <= "' . date('Y-m-d 23:59:59', strtotime($_GET['Report']['period_end'])) . '"');
        }

        $user_Learn = LogStartcourse::model()->findAll($criteria);


        $user_chk = array();
        foreach ($user_Learn as $key => $val) {
            $user_chk[] = $val->user_id;
        }

        if(count($user_chk) == 0){
            $user_chk = array(0);
        } 

        $allUsers = User::model()->with('profile')->findAll(array(
            'condition' => 'status ="1" and user.id IN ('.implode(",",$user_chk).')',
            'order' => 'profile.firstname_en ASC'
        ));



        $num_register = count($allUsers);
        $num_pass = 0;
        $num_learning = 0;
        $num_notlearn = 0;
        $num_final_pass = 0;
        $num_final_notpass = 0;
        $num_per_pass = 0;


        $lesson_learning =[];
        $lesson_pass =[];
        // $lesson_per =[];
        $lesson_test_pass =[];
        $lesson_test_notpass =[];

        foreach ($lesson_online as $key_l => $value_l) {
            $lesson_pass[$value_l->id] = 0;
            $lesson_learning[$value_l->id] = 0;
            $lesson_test_pass[$value_l->id] = 0;
            $lesson_test_notpass[$value_l->id] = 0;
        }

        foreach ($allUsers as $key => $user) {
            $statusLearn =  Helpers::lib()->chk_status_course($course_online->course_id, $_GET['Report']['gen_id'], $user->id);

            if($statusLearn == "pass"){
                $num_pass++;
            }elseif($statusLearn == "learning"){
                $num_learning++;
            }else{
                $num_notlearn++;
            }

            $final_score = Coursescore::model()->find("course_id='".$course_online->course_id."' AND gen_id='".$_GET['Report']['gen_id']."' AND user_id='".$user->id."' AND type='post' AND active='y' ORDER BY score_id DESC");

            if($final_score){
                if($final_score->score_past == "y"){
                    $num_final_pass++;
                }elseif($final_score->score_past == "n"){
                    $num_final_notpass++;
                }
            }

            foreach ($lesson_online as $key_l => $value_l) {

                $statusLearn_lesson =  Helpers::lib()->chk_status_lesson($value_l->id, $_GET['Report']['gen_id'], $user->id);

                if($statusLearn_lesson == "pass"){
                    $lesson_pass[$value_l->id] = $lesson_pass[$value_l->id]+1;                    
                }elseif($statusLearn_lesson == "learning"){
                    $lesson_learning[$value_l->id] = $lesson_learning[$value_l->id]+1;
                }


                $test_score = Score::model()->find("lesson_id='".$value_l->id."' AND gen_id='".$_GET['Report']['gen_id']."' AND user_id='".$user->id."' AND type='post' AND active='y' ORDER BY score_id DESC"); 

                if($test_score){
                    if($test_score->score_past == "y"){
                        $lesson_test_pass[$value_l->id] = $lesson_test_pass[$value_l->id]+1;
                    }elseif($test_score->score_past == "n"){
                        $lesson_test_notpass[$value_l->id] = $lesson_test_notpass[$value_l->id]+1;                        
                    }
                }

            }


        }

        if($num_register != 0){
            $num_per_pass = ($num_pass*100)/$num_register;
            $num_per_pass = round($num_per_pass, 2);
        }


?>

        <div class="widget-body div-table" style="overflow: auto;">
            <table class="table table-bordered toggleairasia-table">
                <thead>
                    <tr style="background-color: #e476e8;">
                        <!--<th rowspan="2" style="vertical-align: middle;" class="center"><b>หลักสูตร/หัวข้อวิชา</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>ผู้เรียนทั้งหมด</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>กำลังเรียน</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>เรียนผ่าน</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>%ที่เรียนจบ</b></th>
                        <th colspan="2" style="vertical-align: middle;" class="center"><b>ผลการเรียน</b></th>-->
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>Course/Subject</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>No. of student</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>On Process</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>Passed</b></th>
                        <th rowspan="2" style="vertical-align: middle;" class="center"><b>% Success</b></th>
                        <th colspan="2" style="vertical-align: middle;" class="center"><b>Result</b></th>
                    </tr>
                    <tr  style="background-color: #e476e8;">
                        <!--<th class="center"><b>จำนวนผ่าน</b></th>
                        <th class="center"><b>จำนวนไม่ผ่าน</b></th>-->
                        <th class="center"><b>Passed</b></th>
                        <th class="center"><b>Failed</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $course_online->course_title.$gen_title ?></td>
                        <td class="center"><?= $num_register ?></td>
                        <td class="center"><?= $num_learning ?></td>
                        <td class="center"><?= $num_pass ?></td>
                        <td class="center"><?= $num_per_pass ?> %</td>
                        <td class="center"><?= $num_final_pass ?></td>
                        <td class="center"><?= $num_final_notpass ?></td>
                    </tr>
                    <tr>
                        <!--<td colspan="7" style="background-color: #e3c9ff;"><b>รายบทเรียน</b></td>-->
                        <td colspan="7" style="background-color: #e3c9ff;"><b>Lession</b></td>
                    </tr>
                <?php
                foreach ($lesson_online as $key => $value) {
                    ?>
                    <tr>
                        <td colspan="2"><?= $value->title ?></td>
                        <td class="center"><?= $lesson_learning[$value->id] ?></td>
                        <td class="center"><?= $lesson_pass[$value->id] ?></td>
                        <td class="center"><?= round(($lesson_pass[$value->id]*100)/$num_register, 2) ?> %</td>
                        <td class="center"><?= $lesson_test_pass[$value->id] ?></td>
                        <td class="center"><?= $lesson_test_notpass[$value->id] ?></td>
                    </tr>


                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <br>
        <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
        <!-- <button type="button" id="btnExportPdf" class="btn btn-primary btn-icon glyphicons file"> <i></i>ExportPDF</button> -->
        <!-- <a href="<?= $this->createUrl('report/genPdfAttendPrint',array('ReportUser[generation]'=>$_GET['ReportUser']['generation'],
        'ReportUser[course]'=>$_GET['ReportUser']['course'],
        'ReportUser[date_start]'=>$_GET['ReportUser']['date_start'],
        'ReportUser[date_end]'=>$_GET['ReportUser']['date_end'],
        'ReportUser[course_type]'=>$_GET['ReportUser']['course_type'],
        'ReportUser[division_id]'=>$_GET['ReportUser']['division_id'],
        'ReportUser[department]'=>$_GET['ReportUser']['department'],
        'ReportUser[station]'=>$_GET['ReportUser']['station'])); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a> -->
    <?php } else { ?>
        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
        <h4>กรุณาเลือกหลักสูตรและรุ่น แล้วกดปุ่มค้นหา</h4>
        </div>
    <?php } ?>
    </div>

</div>

<?php


Yii::app()->clientScript->registerScript('export', "

  $(function(){
      $('#btnExport').click(function(e) {
        $('.toggle').css('display', 'table-row-group');
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()));
        e.preventDefault();
        $('.toggle').css('display', 'none');
      });
  });

", CClientScript::POS_END);

?>
