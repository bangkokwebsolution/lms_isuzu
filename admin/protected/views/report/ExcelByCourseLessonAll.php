<?php
$strExcelFileName = "Report_Training_Course-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");

if (isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != '') {
    $search = $_GET['Report'];

    $criteria = new CDbCriteria;
    if (isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null) {
        $criteria->compare('t.course_id', $_GET['Report']['course_id']);
    }

    if (isset($_GET['Report']['gen_id']) && $_GET['Report']['gen_id'] != null) {
        $criteria->compare('t.gen_id', $_GET['Report']['gen_id']);
    }
    $course_online = CourseOnline::model()->findByPk($search['course_id']);

    $user_Learn = LogStartcourse::model()->findAll($criteria);
}
?>
<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>
<!-- END HIGH SEARCH -->
<div class="widget hidden" id="export-table">
    <div class="widget-head">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">รายงานการฝึกอบรมหลักสูตร <?= $course_online->course_title ?></h4>
        </div>
    </div>
    <div class="widget-body" style=" overflow-x: scroll;">
        <table class="table table-bordered table-striped" border='1'>
            <thead>
                <tr>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>No.</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Minor course type</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Subminor course type</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Course Name</b></th>

                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Lesson Name</b></th>

                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Gen</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Group</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Employee</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Name</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Organization unit</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Abbreviate code</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Employee class</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Position desc.</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Learning Status</b></th>
                    <th rowspan="3" style="vertical-align: middle;" class="center"><b>Completed Date</b></th>
                    
                    <th colspan="2" style="vertical-align: middle;" class="center">Lesson</th>
                    <th colspan="7" style="vertical-align: middle;" class="center">Course</th>
                    
                </tr>

                <tr>
                    <th rowspan="2">Pre Test Score</th>
                    <th rowspan="2">Pre Test %</th>

                    <th colspan="3">Pre Test</th>
                    <th colspan="4">Final Test</th>
                </tr>

                <tr>
                    <th style="vertical-align: middle;" class="center">Score</th>
                    <th style="vertical-align: middle;" class="center">Percent</th>
                    <th style="vertical-align: middle;" class="center">Pre Test Status</th>
                    
                    <th style="vertical-align: middle;" class="center">Score</th>
                    <th style="vertical-align: middle;" class="center">Percent</th>
                    <th style="vertical-align: middle;" class="center">Final Test Status</th>
                    <th style="vertical-align: middle;" class="center">Evaluation</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($user_Learn as $keyL => $valueL) {
                    if (!isset($valueL->user)) {
                        continue;
                    }
                    // if(isset($search['gen_id']) && $search['gen_id'] !=''){
                    //     if($search['gen_id'] != $valueL->course->getGenID($valueL->course_id)){ continue; }
                    // }


                    //lesson
                    $lessonModel = Lesson::model()->findAllByAttributes(array(
                        'active' => 'y',
                        'lang_id' => '1',
                        'course_id' => $valueL->course_id
                        ),array('order'=>'id')
                    );

                    $percent_learn_net = 0;
                        foreach ($lessonModel as $keyLesson => $lessonListStatus) {
                                    $checkLessonPass = Helpers::lib()->checkLessonPass_Now($lessonListStatus,$valueL->user_id);
                                    $checkLessonPass_Percent = Helpers::lib()->checkLessonPass_Percent($lessonListStatus,$valueL->user_id, 0);

                                    // if($checkLessonPass == 'notLearn'){
                                    //   $checkLessonPass = 'Not Learn';
                                    // }elseif($checkLessonPass == 'pass'){
                                    //   $checkLessonPass = 'Completed';
                                    // }elseif($checkLessonPass == 'learning'){
                                    //   $checkLessonPass = 'Learning';
                                    // }

                                    

                                    $manage_lesson_pre = Manage::model()->find(array(
                                        'select'=>'group_id',
                                        'condition'=>'id="'.$lessonListStatus->id.'" AND active="y" AND type="pre" ',
                                        'order'=>'manage_id ASC'
                                      ));

                                      if($manage_lesson_pre){
                                        $lesson_pre_score = "Not Start";
                                        $lesson_pre_percent = "Not Start";
                                     

                                        $lessonscore_pre = Score::model()->find(array(
                                          'select'=>'score_number, score_total, score_past',
                                          'condition'=>'type="pre" AND lesson_id="'.$lessonListStatus->id.'" AND user_id="'.$valueLog->user_id.'"  AND active="y" ',
                                          'order'=>'score_id DESC'
                                        ));
  
  
                                        if($lessonscore_pre){
                                          $lesson_pre_score = $lessonscore_pre->score_number."/".$lessonscore_pre->score_total;
  
                                          $lesson_pre_percent = number_format(($lessonscore_pre->score_number*100)/$lessonscore_pre->score_total, 2)." %";
  
                                          if($lessonscore_pre->score_past == "y"){
                                            $lesson_pre_status = "Passed";
                                          }else{
                                            $lesson_pre_status = "Not Passed";
                                          }
  
                                        }
                                      }else{
                                        $lesson_pre_score = "ไม่มีข้อสอบบทเรียน";
                                        $lesson_pre_percent = "ไม่มีข้อสอบบทเรียน";
                                 
                                      }
                        
                    //lesson 


                    $status_course_gen = Helpers::lib()->StatusCourseGen($valueL->course_id, $valueL->course->getGenID($valueL->course_id), $valueL->user_id);

                    if ($status_course_gen == "notLearn") {
                        $lessonStatusStr = 'Not start';
                    } else if ($status_course_gen == "learning") {
                        $lessonStatusStr = 'On process';
                    } else if ($status_course_gen == "pass") {
                        $lessonStatusStr =  'Completed';
                    }

                    $passcourse = Passcours::model()->find(array(
                        'condition' => 'gen_id=:gen_id AND passcours_cours=:course_id AND passcours_user=:user_id',
                        'params' => array(':gen_id' => $valueL->gen_id, ':course_id' => $valueL->course_id, ':user_id' => $valueL->user_id),
                    ));
                    //---------------คะแนนหลักสูตร-----------------//
                    $Evaluation = "Pending";
                    $header_id = Helpers::lib()->chk_course_questionnaire_report($valueL->course_id);
                    if ($passcourse != null) {
                        if ($header_id != null) {
                            if (Helpers::lib()->chk_course_questionnaire_do($header_id, $valueL->course_id, $passcourse->passcours_user, "")) {
                                // ทำแบบสอบถามแล้ว
                                $Evaluation = "Completed";
                                $Training_Status = "Completed";
                                $percent_course = "100";
                                $Completed_date = date("d-M-Y", strtotime($passcourse->passcours_date));
                            }
                        } else {
                            $Training_Status = "Completed";
                            $percent_course = "100";
                            $Completed_date = date("d-M-Y", strtotime($passcourse->passcours_date));
                        }
                    }


                    $course_post_score = "ไม่มีข้อสอบหลักสูตร";
                    $course_post_percent = "ไม่มีข้อสอบหลักสูตร";
                    $course_post_status = "ไม่มีข้อสอบหลักสูตร";

                    $course_pre_score = "ไม่มีข้อสอบหลักสูตร";
                    $course_pre_percent = "ไม่มีข้อสอบหลักสูตร";
                    $course_pre_status = "ไม่มีข้อสอบหลักสูตร";

                    $manage_course_post = Coursemanage::model()->findAll(array(
                        'select' => 'group_id',
                        'condition' => 'id="' . $valueL->course_id . '" AND active="y" AND type="course" ',
                        'order' => 'manage_id ASC'
                    ));

                    if (!empty($manage_course_post)) {
                        $course_post_score = "Not Start";
                        $course_post_percent = "Not Start";
                        $course_post_status = "Not Start";


                        $coursescore_post = Coursescore::model()->find(array(
                            'select' => 'score_number, score_total, score_past,course_id',
                            'condition' => 'type="post" AND course_id="' . $valueL->course_id . '" AND user_id="' . $valueL->user_id . '" AND active="y" ',
                            'order' => 'score_id DESC'
                        ));

                        if ($coursescore_post) {
                            $course_post_score = $coursescore_post->score_number . "/" . $coursescore_post->score_total;

                            $course_post_percent = number_format(($coursescore_post->score_number * 100) / $coursescore_post->score_total, 2) . " %";

                            if ($coursescore_post->score_past == "y") {
                                $course_post_status = "Passed";
                            } else {
                                $course_post_status = "Not Passed";
                            }
                        }

                        $course_pre_score = "Not Start";
                        $course_pre_percent = "Not Start";
                        $course_pre_status = "Not Start";


                        $coursescore_pre = Coursescore::model()->find(array(
                            'select' => 'score_number, score_total, score_past,course_id',
                            'condition' => 'type="pre" AND course_id="' . $valueL->course_id . '" AND user_id="' . $valueL->user_id . '" AND active="y" ',
                            'order' => 'score_id DESC'
                        ));

                        if ($coursescore_pre) {
                            $course_pre_score = $coursescore_pre->score_number . "/" . $coursescore_pre->score_total;

                            $course_pre_percent = number_format(($coursescore_pre->score_number * 100) / $coursescore_pre->score_total, 2) . " %";

                            if ($coursescore_pre->score_past == "y") {
                                $course_pre_status = "Passed";
                            } else {
                                $course_pre_status = "Not Passed";
                            }
                        }
                    }
                ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td class="center"><?= isset($valueL->course->cates->type->type_name) ? $valueL->course->cates->type->type_name : "" ?></td>
                        <td class="center"><?= $valueL->course->course_number ?></td>

                        <td><?= $valueL->course->course_title ?></td>
                        <td class="center"><?= $lessonListStatus->title ?></td><!--Lesson-->
                        
                        
                        <td class="center"><?= isset($valueL->gen->gen_title) ? $valueL->gen->gen_title : '-' ?></td>
                        <td class="center"><?= $valueL->pro->group_name ?></td>
                        <td class="center"><?= $valueL->mem->employee_id ?></td>
                        <td class="center"><?= $valueL->pro->fullname ?></td>
                        <td class="center"><?= $valueL->pro->organization_unit ?></td>
                        <td class="center"><?= $valueL->mem->orgchart->title ?></td>
                        <td class="center"><?= $valueL->pro->EmpClass->title ?></td>
                        <td class="center"><?= $valueL->pro->position_description ?></td>
                        <td class="center"><?= $lessonStatusStr ?></td>
                        <td class="center"><?= isset($passcourse) ? $passcourse->passcours_date : '' ?></td>

                        <td><?php echo $lesson_pre_score ?>&nbsp;<?php echo $lessonListStatus->id ?></td>
                        <td><?php echo $lesson_pre_percent ?></td>

                        <td class="center"><?= $course_pre_score ?>&nbsp;</td>
                        <td class="center"><?= $course_pre_percent ?></td>
                        <td class="center"><?= $course_pre_status ?></td>

                        <td class="center"><?= $course_post_score ?>&nbsp;</td>
                        <td class="center"><?= $course_post_percent ?></td>
                        <td class="center"><?= $course_post_status ?></td>
                        <td class="center"><?= $Evaluation ?></td>
                    </tr>
                <?php
                        }//foreach lesson
                } 
                
                ?>
            </tbody>
        </table>

    </div>
</div>