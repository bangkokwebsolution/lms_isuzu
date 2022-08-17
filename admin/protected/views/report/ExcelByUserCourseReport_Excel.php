<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>

<?php

 $strExcelFileName = "ExcelByUserReport_Excel" . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");
 ?>


<div class="widget" id="export-table">
    <div class="widget-head">
        <div class="widget-head">

            <h4>Report Person <br> Data as of  <?= date("d-M-Y H:i:s") ?></h4>
        </div>
    </div>
    <div class="widget-body" style=" overflow-x: scroll;">
        <table class="table table-bordered table-striped" border="1">
            <thead>
                <tr>
                    <th colspan="19"></th>
                    <th colspan="4">Final Test</th>
                </tr>
                <tr>
                 <th>No.</th>
                 <th>Emp ID</th>
                 <th>Full name</th>
                 <th>Work Location</th>
                 <th>Employee Class</th>

                 <th>Training Type</th>
                 <th>Course Group</th>
                 <th>Course Number</th>
                 <th>Course Name</th>
                 <th>Lesson</th>


                 <th>Register Date</th>
                 <th>Training Status</th>
                 <th>Training Status %</th>
                 <th>Completed date</th>
                 <th>Print Certificate date</th>


                 <th>Pre-Test Score</th>
                 <th>Pre-Test %</th>

                 <th>Post-Test</th>
                 <th>Post-Test%</th>

                 <th>Score</th>
                 <th>Percent</th>
                 <th>Final Test Status</th>

                 <th>Evaluation</th>
             </tr>

            </thead>
            <tbody>
                <?php
                $report = $_GET['Report'];

                // var_dump($report);exit();



                        $model_result = [];
                        $lesson_model = [];
                        $model_count = 0;

                            if($report["course"]!= ""){
                                $sql_course="AND course_id='".$report["course"]."' ";
                            }else{
                                $sql_course="";
                            }

                            if($report["name"] != ""){
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
                                    $checkLessonPass = Helpers::lib()->checkLessonPass_Now($lessonListStatus,$valueLog->user_id);
                                    $checkLessonPass_Percent = Helpers::lib()->checkLessonPass_Percent($lessonListStatus,$valueLog->user_id, 0);

                                    if($checkLessonPass == 'notLearn'){
                                      $checkLessonPass = 'Not Learn';
                                    }elseif($checkLessonPass == 'pass'){
                                      $checkLessonPass = 'Completed';
                                    }elseif($checkLessonPass == 'learning'){
                                      $checkLessonPass = 'Learning';
                                    }


                                    $Training_Status = "Not Learn"; 
                                    $Completed_date = "";
                                    $Print_Certificate_date = "";
                                    $Evaluation = "Pending";
                                    $header_id = Helpers::lib()->chk_course_questionnaire($valueLog->course_id);

                                    $Passcours = Passcours::model()->find(array(
                                      'select'=>' passcours_user, passcours_date, passcours_id',
                                      'condition'=>'passcours_user="'.$valueLog->user_id.'" AND passcours_cours="'.$valueLog->course_id.'"  ',
                                      'order'=>'passcours_id DESC',
                                    )); 

                                    if($Passcours != null){ 
                                      if($header_id != null){
                                        if(Helpers::lib()->chk_course_questionnaire_do($header_id, $valueLog->course_id, $Passcours->passcours_user, "")){
                                    // ทำแบบสอบถามแล้ว
                                          $Evaluation = "Completed";
                                          $Training_Status = "Completed";
                                          $percent_course = "100";
                                          $Completed_date = date("d-M-Y", strtotime($Passcours->passcours_date));
                                        }
                                      }else{
                                        $Training_Status = "Completed";                                
                                        $percent_course = "100";
                                        $Completed_date = date("d-M-Y", strtotime($Passcours->passcours_date));
                                      }
                                    }

                                    $manage_lesson_pre = Manage::model()->find(array(
                                      'select'=>'group_id',
                                      'condition'=>'id="'.$lessonListStatus->id.'" AND active="y" AND type="pre" ',
                                      'order'=>'manage_id ASC'
                                    ));
                                    if($manage_lesson_pre){
                                      $lesson_pre_score = "Not Start";
                                      $lesson_pre_percent = "Not Start";
                                      $lesson_pre_status = "Not Start";
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
                                      $lesson_pre_status = "ไม่มีข้อสอบบทเรียน";
                                    }

                                    $manage_lesson_post = Manage::model()->findAll(array(
                                      'select'=>'group_id',
                                      'condition'=>'id="'.$lessonListStatus->id.'" AND active="y" AND type="post" ',
                                      'order'=>'manage_id ASC'
                                    ));

                                    if($manage_lesson_post){
                                      $lesson_post_score = "Not Start";
                                      $lesson_post_percent = "Not Start";
                                      $lesson_post_status = "Not Start";

                                      $lessonscore_post = Score::model()->find(array(
                                        'select'=>'score_number, score_total, score_past,course_id',
                                        'condition'=>'type="post" AND lesson_id="'.$lessonListStatus->id.'" AND user_id="'.$valueLog->user_id.'" AND course_id = '.$valueLog->course_id.'  AND active="y" ',
                                        'order'=>'score_id DESC'
                                      ));

                                      if($lessonscore_post){
                                        $lesson_post_score = $lessonscore_post->score_number."/".$lessonscore_post->score_total;

                                        $lesson_post_percent = number_format(($lessonscore_post->score_number*100)/$lessonscore_post->score_total, 2)." %";

                                        if($lessonscore_post->score_past == "y"){
                                          $lesson_post_status = "Passed";
                                        }else{
                                          $lesson_post_status = "Not Passed";
                                        }

                                      }
                                    }else{
                                      $lesson_post_score = "ไม่มีข้อสอบบทเรียน";
                                      $lesson_post_percent = "ไม่มีข้อสอบบทเรียน";
                                      $lesson_post_status = "ไม่มีข้อสอบบทเรียน";
                                    }
                                    $gen_id = null;
                                    if($gen_id == null){
                                      $lesson_model = Lesson::model()->findByPk($lessonListStatus->id);
                                      $gen_id = $lessonListStatus->courseonlines->getGenID($lessonListStatus->course_id);
                                    }

                                    $course_post_score = "ไม่มีข้อสอบหลักสูตร";
                                    $course_post_percent = "ไม่มีข้อสอบหลักสูตร";
                                    $course_post_status = "ไม่มีข้อสอบหลักสูตร";

                                    $manage_course_post = Coursemanage::model()->findAll(array(
                                      'select'=>'group_id',
                                      'condition'=>'id="'.$valueLog->course_id.'" AND active="y" AND type="course" ',
                                      'order'=>'manage_id ASC'
                                    ));

                                    if(!empty($manage_course_post)){
                                      $course_post_score = "Not Start";
                                      $course_post_percent = "Not Start";
                                      $course_post_status = "Not Start";


                                      $coursescore_post = Coursescore::model()->find(array(
                                        'select'=>'score_number, score_total, score_past,course_id',
                                        'condition'=>'type="post" AND course_id="'.$valueLog->course_id.'" AND user_id="'.$valueLog->user_id.'" AND active="y" ',
                                        'order'=>'score_number DESC'
                                      ));

                                      if($coursescore_post){
                                        $course_post_score = $coursescore_post->score_number."/".$coursescore_post->score_total;

                                        $course_post_percent = number_format(($coursescore_post->score_number*100)/$coursescore_post->score_total, 2)." %";

                                        if($coursescore_post->score_past == "y"){
                                          $course_post_status = "Passed";
                                        }else{
                                          $course_post_status = "Not Passed";
                                        }
                                      }
                                    }

                                    ?>
                                  <tr>
                                      <td><?= $start_count++ ?></td>
                                      <td><?= $valueLog->user->employee_id ?></td>
                                      <td><?= $valueLog->pro->fullname_en ?></td>
                                      <td><?= $valueLog->pro->location ?></td>
                                      <td><?= $valueLog->pro->EmpClass->title ?></td>
                                      <td><?= $lessonListStatus->courseonlines->cates->type->type_name ?></td>
                                      <td><?= $valueLog->course->cates->cate_title ?></td>
                                      <td><?= $valueLog->course->course_number ?></td>
                                      <td><?= $valueLog->course->course_title ?></td>
                                      <td><?= $lessonListStatus->title ?></td>
                                      <td><?= date("d-M-Y", strtotime($lessonListStatus->create_date)) ?></td>
                                      <td><?= $checkLessonPass ?></td>
                                      <td><?= Helpers::lib()->percent_CourseGen($valueLog->course_id, $gen_id,$valueLog->user_id) ?>%</td>
                                      <td><?= isset($Passcours->passcours_date) ? date("d-M-Y", strtotime(
                                        $Passcours->passcours_date)):'' ?></td>
                                      <td><?= isset($PasscoursLog->pclog_date) ? date('d-M-Y',strtotime($PasscoursLog->pclog_date)):'' ?></td>
                                      <td><?= $lesson_pre_score ?>&nbsp;</td>
                                      <td><?= $lesson_pre_percent ?></td>
                                      <td><?= $lesson_post_score ?>&nbsp;</td>
                                      <td><?= $lesson_post_percent ?></td>
                                      <td><?= $course_post_score ?>&nbsp;</td>
                                      <td><?= $course_post_percent ?></td>
                                      <td><?= $course_post_status ?></td>
                                      <td><?= $Evaluation ?></td>
                                  </tr>
                             <?php }
                              }


                          }
               ?>
            </tbody>
        </table>
    </div>
</div>
