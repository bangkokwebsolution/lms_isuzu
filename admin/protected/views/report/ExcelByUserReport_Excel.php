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
                    <th colspan="18"></th>
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
                            $course_model = CourseOnline::model()->findAll(array(
                                'select'=>'course_id, cate_id, course_title',
                                'condition'=>'active="y" AND lang_id="1" '.$sql_course,
                                'order'=>'course_title ASC'
                            ));

                            if($report["lesson"] != ""){        
                                $sql_lesson = " AND id='".$report["lesson"]."' ";
                                $lesson_id = $report["lesson"];
                            }else{
                                $sql_lesson = "";
                                $lesson_id = null;
                            }

                            

                            foreach ($course_model as $key => $value) {



                                $training_type = "";

                                if($value->cates->type->type_name != ""){
                                    $training_type = $value->cates->type->type_name;
                                }

                                $report["course"] = $value->course_id;

                                
                                
                                $result_list = Helpers::lib()->query_report_training($report, $value->course_id, $lesson_id);                               

                                $lesson_list= Lesson::model()->findAll(array(
                                    'select'=>'id, title',
                                    'condition'=>'course_id="'.$value->course_id.'" AND active="y" AND lang_id=1 '.$sql_lesson,
                                    'order'=>'title ASC'
                                )); 

                                $model_count = $model_count+count($result_list);
                                
                                $model_result = $result_list;
                                $lesson_model = $lesson_list;


                        foreach($model_result as $i => $list) {

                        if($list->mem->del_status == 0){
                            $status_name = "Active";
                        }else{
                            $status_name = "Resign";
                        }

                        $course_post_score = "ไม่มีข้อสอบหลักสูตร";
                        $course_post_percent = "ไม่มีข้อสอบหลักสูตร";
                        $course_post_status = "ไม่มีข้อสอบหลักสูตร";

                        $manage_course_post = Coursemanage::model()->findAll(array(
                            'select'=>'group_id',
                            'condition'=>'id="'.$report["course"].'" AND active="y" AND type="course" ',
                            'order'=>'manage_id ASC'
                        ));

                        if(!empty($manage_course_post)){
                            $course_post_score = "Not Start";
                            $course_post_percent = "Not Start";
                            $course_post_status = "Not Start";


                            $coursescore_post = Coursescore::model()->find(array(
                                'select'=>'score_number, score_total, score_past',
                                'condition'=>'type="post" AND course_id="'.$report["course"].'" AND user_id="'.$list->user_id.'" AND active="y" ',
                                'order'=>'score_id DESC'
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




                        /////////////////////// Check Status Learn Course //////////
                        $Training_Status = "Not Learn"; 
                        $Completed_date = "";
                        $Print_Certificate_date = "";
                        $Evaluation = "Pending";



                        // $percent_course = Helpers::lib()->percent_CourseGen($report["course"], $list->user_id, $list->id);


                        $header_id = Helpers::lib()->chk_course_questionnaire($report["course"]); // มีแบบสอบถามไหม

                        $Passcours = Passcours::model()->find(array(
                            'select'=>' passcours_user, passcours_date, passcours_id',
                            'condition'=>'passcours_user="'.$list->user_id.'" AND passcours_cours="'.$report["course"].'"  ',
                            'order'=>'passcours_id DESC',
                        )); 

                        if($Passcours != null){ 
                            if($header_id != null){
                                if(Helpers::lib()->chk_course_questionnaire_do($header_id, $report["course"], $Passcours->passcours_user, "")){
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

                        if($Training_Status == "Completed"){
                            $PasscoursLog = PasscoursLog::model()->find(array(
                                'select'=>'pclog_id, pclog_date',
                                'condition'=>'pclog_target="'.$Passcours->passcours_id.'" '
                            ));

                            if($PasscoursLog != null){
                                $Print_Certificate_date = date("d-M-Y", strtotime($PasscoursLog->pclog_date));
                            }
                        }



                        if($Training_Status == "Not Learn"){

                            $score_course = Coursescore::model()->find(array(
                                'select'=>'user_id',
                                'condition'=>"user_id='".$list->user_id."' AND active='y' AND type='pre' AND course_id='".$report["course"]."' ",
                                // 'group'=>'user_id'

                            ));

                            $score_lesson = Score::model()->find(array(
                                'select'=>'user_id',
                                'condition'=>"user_id='".$list->user_id."' AND active='y' AND type='pre' AND course_id='".$report["course"]."' ",
                                // 'group'=>'user_id'
                            ));

                            $statusLearn = Learn::model()->find(array(
                                'select'=>'user_id',
                                'condition'=>' user_id="'.$list->user_id.
                                '" AND course_id ="'. $report["course"] . 
                                '" ',
                                // 'group'=>'user_id'                
                            ));


                            if($score_course != "" || $score_lesson != "" || $statusLearn != "" ){
                                $Training_Status = "Learning";   
                            }

                        }




                        foreach ($lesson_model as $k_lesson => $val_lesson) {

                            $lesson_pre_score = "ไม่มีข้อสอบ";
                            $lesson_pre_percent = "ไม่มีข้อสอบ";
                            $lesson_pre_status = "ไม่มีข้อสอบ";

                            $lesson_post_score = "ไม่มีข้อสอบ";
                            $lesson_post_percent = "ไม่มีข้อสอบ";
                            $lesson_post_status = "ไม่มีข้อสอบ";

                            $manage_lesson_pre = Manage::model()->find(array(
                                'select'=>'group_id',
                                'condition'=>'id="'.$val_lesson->id.'" AND active="y" AND type="pre" ',
                                'order'=>'manage_id ASC'
                            ));

                            if($manage_lesson_pre){
                                $lesson_pre_score = "Not Start";
                                $lesson_pre_percent = "Not Start";
                                $lesson_pre_status = "Not Start";

                                $lessonscore_pre = Score::model()->find(array(
                                    'select'=>'score_number, score_total, score_past',
                                    'condition'=>'type="post" AND lesson_id="'.$val_lesson->id.'" AND user_id="'.$list->user_id.'"  AND active="y" ',
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
                            }

                            $manage_lesson_post = Manage::model()->findAll(array(
                                'select'=>'group_id',
                                'condition'=>'id="'.$val_lesson->id.'" AND active="y" AND type="post" ',
                                'order'=>'manage_id ASC'
                            ));

                            if($manage_lesson_post){
                                $lesson_post_score = "Not Start";
                                $lesson_post_percent = "Not Start";
                                $lesson_post_status = "Not Start";
                                
                                $lessonscore_post = Score::model()->find(array(
                                    'select'=>'score_number, score_total, score_past',
                                    'condition'=>'type="pre" AND lesson_id="'.$val_lesson->id.'" AND user_id="'.$list->user_id.'"  AND active="y" ',
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
                            }

                                        

                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        
                                        <td><?= $list->mem->employee_id ?></td>
                                        <td>
                                            <?= $list->mem->profile->firstname_en . ' ' . $list->mem->profile->lastname_en ?>
                                        </td>
                                        <td><?= $list->mem->profile->location ?></td>
                                        <td><?= $list->mem->profile->employee_class ?></td>

                                        <td><?= $training_type ?></td>
                                        <td><?= $list->course->cates->cate_title ?></td>
                                        <td><?= $list->course->course_title ?></td>
                                        <td><?= $val_lesson->title ?></td>


                                        <td><?= date("d-M-Y", strtotime($list->create_date)) ?></td>
                                        <td><?= $Training_Status ?></td>
                                        <td><?= $percent_course ?> %</td>
                                        <td><?= $Completed_date ?></td>
                                        <td><?= $Print_Certificate_date ?></td>

                                        <td><?= $lesson_post_score ?>&nbsp;</td>
                                        <td><?= $lesson_post_percent ?></td>
                                        <!-- <td><?= $lesson_post_status ?></td> -->
                                        
                                        <td><?= $lesson_pre_score ?>&nbsp;</td>
                                        <td><?= $lesson_pre_percent ?></td>
                                        <!-- <td><?= $lesson_pre_status ?></td> -->

                                        

                                        <td><?= $course_post_score ?>&nbsp;</td>
                                        <td><?= $course_post_percent ?></td>
                                        <td><?= $course_post_status ?></td>

                                        <td><?= $Evaluation ?></td>





                                    </tr>
                                    <?php
                                    $start_cnt++;
                                    } // lesson
                                }
             
           }
       }


               ?>
            </tbody>
        </table>
    </div>
</div>