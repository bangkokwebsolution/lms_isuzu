<?php
$title = 'รายงานผลการเรียนของหลักสูตร';
$currentModel = 'Report';

$this->breadcrumbs = array($title);

// Yii::app()->clientScript->registerScript('search', "
//     $('#SearchFormAjax').submit(function(){
//         return true;
//     });
// ");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');

EOD
, CClientScript::POS_READY);
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(function() {
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


      $("#Report_type_register").change(function(){
            var value = $("#Report_type_register option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetdepartment"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_department").html(data);
                            $("#Report_position").html('<option value="">ทั้งหมด</option>');
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });


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
                 $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Report/ajaxgetlesson"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_lesson_id").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });


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
<?php

    $userModel = Users::model()->findByPk(Yii::app()->user->id);
    $state = Helpers::lib()->getStatePermission($userModel);

    if($state){
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    }

    $listCourse = CHtml::listData($modelCourse,'course_id','course_title');


    if($state){
        $modelLesson = Lesson::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelLesson = Lesson::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    }

    $listLesson = CHtml::listData($modelLesson,'id','title');



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



    // $this->widget('AdvanceSearchForm', array(
    //     'data'=>$model,
    //     'route' => $this->route,
    //     'attributes'=>array(
    //         array('name'=>'course_id','type'=>'list','query'=>$listCourse),
    //         array('name'=>'gen_id','type'=>'list','query'=>$arr_gen),
    //         array('name'=>'lesson_id','type'=>'list','query'=>$listLesson),
    //         array('name'=>'search','type'=>'text'),

    // ),

    // ));


    ?>
    <div class="widget">

        <div class="widget-head">
            <h4 class="heading glyphicons search">
                <i></i> ค้นหา:
            </h4>
        </div>
        <?php
            $form = $this->beginWidget('CActiveForm',
                array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                )
            );
        ?>
        <div class="widget-body">
            <dl class="dl-horizontal">

                <div class="form-group">
                <dt><label>ชื่อ : </label></dt>
                <dd>
                    <input type="text" name="Report[name]" style="width: 50%;" value="<?php if(isset($_GET['Report']['name']) && $_GET['Report']['name'] != ""){ echo $_GET['Report']['name']; } ?>" required>
                </dd>
                </div>



            <div class="form-group">
                <dt></dt>
                <dd>
                    <button type="submit" class="btn btn-primary btn-icon glyphicons search">
                        <i></i> Search
                    </button>
                </dd>
            </div>


            </dl>
        </div>
    <?php $this->endWidget(); ?>
</div><!--innerLR-->
<?php


if(isset($_GET['Report']['name'])){

        $report = $_GET['Report'];


        // var_dump($report);exit();

?>

<div class="widget" id="export-table">
            <div class="widget-head">
                <div class="widget-head"></div>
            </div>

            <div class="widget-body div-table" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped" id="table_datatable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Emp ID</th>
                            <th>Full name</th>
                            <th>Work Location</th>
                            <th>Employee Class</th>

                            <th>Minor course type</th>
                            <th>Course Group</th>
                            <th>Course Number</th>
                            <th>Course Name</th>
                            <th>Lesson</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php



                        $model_result = [];
                        $lesson_model = [];
                        $model_count = 0;

                        if($report['name'] != ""){

                            $Report_course=$report['course'];

                            // if($Report_course!= ""){
                            //     $sql_course="AND course_id='".$Report_course."' ";
                            // }else{
                            //     $sql_course="";
                            // }

                            // $course_model = CourseOnline::model()->findAll(array(
                            //     'select'=>'course_id, course_title',
                            //     'condition'=>'active="y" AND lang_id="1" AND cate_id="'.$_GET['Report']['category'].'"'.$sql_course,
                            //     'order'=>'course_title ASC'
                            // ));

                            $course_model = CourseOnline::model()->findAll(array(
                                'select'=>'course_id, course_title',
                                'condition'=>'active="y" AND lang_id="1" ',
                                'order'=>'course_title ASC'
                            ));



                            if($report["lesson"] != ""){
                                $sql_lesson = " AND id='".$report["lesson"]."' ";
                                $lesson_id = $report["lesson"];
                            }else{
                                $sql_lesson = "";
                                $lesson_id = null;
                            }
                            $criteria = new CDbCriteria;
                            $criteria->with = array('course', 'user', 'user.profile');
                            $criteria->select = 't.course_id, t.user_id, t.id, t.create_date';
                            $criteria->compare('courseonline.active', "y");
                            if($report["name"] != ""){
                                $criteria->compare('concat(profile.firstname," ",profile.lastname," ",profile.firstname_en," ",profile.lastname_en)',$report["name"],true);
                                // $model_result = LogStartcourse::model()->findAll($criteria);
                                // var_dump($model_result);exit();

                            }
                            $criteria->order = "profile.firstname_en ASC";
                            $LogStartcourse = LogStartcourse::model()->findAll($criteria);
                            $start_count = 1;
                            foreach ($LogStartcourse as $keyLog => $valueLog) {
                                $lessonModel = Lesson::model()->findAllByAttributes(array(
                                    'active' => 'y',
                                    'lang_id' => '1',
                                    'course_id' => $valueLog->course_id
                                ));
                                $percent_learn_net = 0;
                                foreach ($lessonModel as $keyLesson => $lessonListStatus) {

                                   ?>
                                <tr>
                                    <td><?= $start_count++ ?></td>
                                    <td><?= $valueLog->user->employee_id ?></td>
                                    <td><?= $valueLog->pro->fullname_en ?></td>
                                    <td><?= $valueLog->pro->location ?></td>
                                    <td><?= $valueLog->pro->employee_class ?></td>
                                    <td><?= $lessonListStatus->courseonlines->cates->type->type_name ?></td>
                                    <td><?= $valueLog->course->cates->cate_title ?></td>
                                    <td><?= $valueLog->course->course_number ?></td>
                                    <td><?= $valueLog->course->course_title ?></td>
                                    <td><?= $lessonListStatus->title ?></td>
                                </tr>
                           <?php }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                *หากต้องการดูรายละเอียดกรุณากด Export Excel
            </div>
        </div>
<?php } ?>


<?php if($LogStartcourse > 0){ ?>

<a href="<?= $this->createUrl('Report/ExcelByUserCourseReport', array(

'Report[name]'=>$report["name"]
)); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i> Export Excel</a>

<?php } ?>

<script type="text/javascript">
    $('#table_datatable').DataTable({
                   "searching": true,
                });
</script>
