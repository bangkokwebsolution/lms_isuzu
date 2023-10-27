<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/chosen.min.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>

<style>
    html {
        scroll-behavior: smooth;
    }

    .toggle {
        display: none;
    }

    button.toggle-btn {
        display: block !important;
        width: 100%;
        border: none;
        color: #333;
        font-weight: 600;
        background-color: transparent;
        text-align: left;
        transition: all 0.25s ease;
    }

    button.toggle-btn:hover {
        color: red;
    }

    button.toggle-btn>span.fa {
        margin-top: 5px;
        margin-left: 1em;
    }

    .lesson-pd {
        padding-left: 15px !important;
    }

    .lesson-pd::before {
        content: "\f101";
        margin-right: 5px;
        font-family: 'fontawesome';
    }

    .chosen-with-drop .chosen-drop {
        z-index: 1000 !important;
        position: static !important;
    }
</style>


<?php
$titleName = 'รายงานวิเคราะห์คำตอบรายคำถาม';
$formNameModel = 'Report';

$this->breadcrumbs = array($titleName);


Yii::app()->clientScript->registerScript(
    'updateGridView',
    <<<EOD
    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');
    $('#Report_dateRang').daterangepicker({dateFormat: 'dd/mm/yy'});

EOD,
    CClientScript::POS_READY
);
?>

<script>
    $(document).ready(function() {

        function startDate() {
            $('#passcoursStartDateBtn').datepicker({
                dateFormat: 'yy/mm/dd',
                showOtherMonths: true,
                selectOtherMonths: true,
                onSelect: function() {
                    $("#passcoursEndDateBtn").datepicker("option", "minDate", this.value);
                },
            });
        }

        function endDate() {
            $('#passcoursEndDateBtn').datepicker({
                dateFormat: 'yy/mm/dd',
                showOtherMonths: true,
                selectOtherMonths: true,
            });
        }


        $(".chosen").chosen();
        $(".widget-body").css("overflow", "");

        $("#Report_period_start").datepicker({
            onSelect: function(selected) {
                $("#Report_period_end").datepicker("option", "minDate", selected)
            }
        });
        $("#Report_period_end").datepicker({
            onSelect: function(selected) {
                $("#Report_period_start").datepicker("option", "maxDate", selected)
            }
        });

        endDate();
        startDate();

        $("#Report_course_id").change(function() {
            var value = $("#Report_course_id option:selected").val();
            if (value != "") {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetLessonId"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if (data != "") {
                            $("#Report_lesson_id").html(data);
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

    if ($state) {


        $criteria = new CDbCriteria;
        $criteria->with = array('cates');
        $criteria->compare('categorys.active', 'y');

        $criteria->compare('courseonline.active', 'y');
        $criteria->compare('courseonline.parent_id', 0);
        $criteria->addCondition('approve_status > 0');
        $criteria->order = 'sortOrder ASC';
        $course_list = ApproveCourse::model()->findAll($criteria);

        $org_arr = array();
        foreach ($course_list as $keyP => $valueP) {
            // $check_course_list = helpers::ChkCourse($valueP->course_id);
            // if ($check_course_list != 'pass') {
            //     continue;
            // }

            $org_arr[] = $valueP->course_id;
        }

        if (count($org_arr) == 0) {
            $modelCourse = CourseOnline::model()->findAll(array('condition' => "active = 'y' AND lang_id = 1 AND 
            course_id IN (0) "));
        } else {
            if (in_array("1", json_decode($userModel->group)) or in_array("7", json_decode($userModel->group)) or in_array("15", json_decode($userModel->group))) {

                $modelCourse = CourseOnline::model()->findAll(array('condition' => "active = 'y' AND lang_id = 1 "));
            } else {
                $modelCourse = CourseOnline::model()->findAll(array('condition' => "active = 'y' AND lang_id = 1 AND 
                course_id IN (" . implode(',', $org_arr) . ") "));
            }
        }
    } else {
        $modelCourse = CourseOnline::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND create_by = "' . $userModel->id . '"'));
    }
    $listCourse = CHtml::listData($modelCourse, 'course_id', 'course_title');

    $TypeEmployee = TypeEmployee::model()->findAll(array(
        'condition' => 'active = "y"',
        'order' => 'type_employee_name ASC'
    ));

    $listtype_user = CHtml::listData($TypeEmployee, 'id', 'type_employee_name');

    if ($_GET['Report']['course_id'] != "") {

        $arr_lesson = Lesson::model()->findAll([
            'condition' => 'course_id=:course_id AND active=:active AND lang_id = 1 ',
            'params' => array(':course_id' => $_GET['Report']['course_id'], ':active' => "y"),
            'order' => 'id ASC',
        ]);

        if (empty($arr_lesson)) {
            $arr_lesson[0] = "ไม่มีบทเรียน";
        } else {
            $arr_lesson = CHtml::listData($arr_lesson, 'lesson_id', 'title');
        }
    } else {
        $arr_lesson[""] = "กรุณาเลือกหลักสูตร";
    }

    $this->widget('AdvanceSearchForm', array(
        'data' => $model,
        'route' => $this->route,
        'attributes' => array(
            array('name' => 'course_id', 'type' => 'list', 'query' => $listCourse),
            array('name' => 'lesson_id', 'type' => 'list', 'query' => $arr_lesson),
        ),

    ));

    if ($_GET['Report']['course_id'] != null) {
        $course = CourseOnline::model()->findByPk($_GET['Report']['course_id']);
        $Cmanage_pre = Coursemanage::model()->find(["condition" => "id = $course->course_id AND active ='y' AND type='pre'"]);
        $Cmanage_post = Coursemanage::model()->find(["condition" => "id = $course->course_id AND active ='y' AND type='course'"]);
        $Coursequestion = [];

        if (!empty($Cmanage_post)) {
            $Coursequestion = Coursequestion::model()->findAll(["condition" => "group_id = $Cmanage_post->group_id "]);
        }

        $logstart = LogStartcourse::model()->findAll(["condition" => "course_id = $course->course_id"]);
    }
    ?>

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> <?php echo $titleName; ?>
            </h4>
        </div>
        <div class="widget-body div-table">
            <?php if ($_GET['Report']['course_id'] != null) { ?>
                <table class="table table-bordered table-striped" id="table_datatable">
                    <thead>
                        <tr>
                            <td colspan="11"></td>
                            <?php if (!empty($Cmanage_pre)) { ?>
                                <td class="center" colspan="2">Pre-Test</td>
                            <?php  } ?>
                            <?php if (!empty($Cmanage_post)) { ?>
                                <td class="center" colspan="2">Post-Test</td>
                            <?php  } ?>
                            <?php if (!empty($Coursequestion)) { ?>
                                <td class="center" colspan="<?= count($Coursequestion) ?>">จำนวนครั้งที่ตอบผิด (No. of Wrong Answer)</td>
                            <?php  } ?>
                        </tr>
                        <tr>
                            <td class="center">Course Name</td>
                            <td class="center">Gen</td>
                            <td class="center">Group</td>
                            <td class="center">Employee Code</td>
                            <td class="center">Name</td>
                            <td class="center">Surname</td>
                            <td class="center">Department</td>
                            <td class="center">Organization Unit</td>
                            <td class="center">Abbreviate Code</td>
                            <td class="center">Employee Class</td>
                            <td class="center">Type</td>
                            <?php if (!empty($Cmanage_pre)) { ?>
                                <td class="center">Score</td>
                                <td class="center">Percent</td>
                            <?php  } ?>
                            <?php if (!empty($Cmanage_post)) { ?>
                                <td class="center">Score</td>
                                <td class="center">Percent</td>
                            <?php  } ?>
                            <?php
                            $ques_i = 1;
                            foreach ($Coursequestion as $key_cq => $val_cq) { ?>
                                <td class="center">Q<?= $ques_i++ ?></td>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($logstart as $log => $val_log) {
                            $ScoreLog = HelperCourseQuest::lib()->getScoreLog($val_log);
                        ?>
                            <tr>
                                <td class="left"><?= $course->course_title ?></td>
                                <td class="center"><?= $val_log->gen_id ?></td>
                                <td class="center"><?= $val_log->pro->group_name ?></td>
                                <td class="center"><?= $val_log->mem->employee_id ?></td>
                                <td class="center"><?= $val_log->pro->firstname ?></td>
                                <td class="center"><?= $val_log->pro->lastname ?></td>
                                <td class="center">-</td>
                                <td class="center"><?= $val_log->pro->organization_unit ?></td>
                                <td class="center"><?= $val_log->pro->abbreviate_code ?></td>
                                <td class="center"><?= $val_log->pro->employee_class ?></td>
                                <td class="center"><?= HelperCourseQuest::lib()->getTypeRefer($ScoreLog); ?></td>
                                <?php if (!empty($Cmanage_pre)) {
                                    $score_log_pre = HelperCourseQuest::lib()->getScores($val_log, "pre");
                                ?>
                                    <td class="center"><?= $score_log_pre["score"] ?></td>
                                    <td class="center"><?= $score_log_pre["percent"] ?></td>
                                <?php  } ?>
                                <?php if (!empty($Cmanage_post)) {
                                    $score_log_post = HelperCourseQuest::lib()->getScores($val_log, "post");
                                ?>
                                    <td class="center"><?= $score_log_post["score"] ?></td>
                                    <td class="center"><?= $score_log_post["percent"] ?></td>
                                <?php  } ?>
                                <?php
                                foreach ($Coursequestion as $key_cq => $val_cq) { ?>
                                    <td class="center"><?= HelperCourseQuest::lib()->getAnswers($ScoreLog, $val_cq->ques_id) ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h4>กรุณาเลือกหลักสูตรและบทเรียน แล้วกดปุ่มค้นหา</h4>
            <?php } ?>
        </div>
        <div style="padding:10px;">
            <?php
            if (!empty($_GET['Report']['course_id'])) {
                echo '<a class="btn btn-primary" target="-blank" href="' . Yii::app()->createUrl('ReportExcel/AnswerAnalyze', array('Report' => ["course_id" => $_GET['Report']['course_id']])) . '">Export Excel</a>';
            }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#table_datatable').DataTable({
        "searching": true,
        scrollX: true
    });
</script>