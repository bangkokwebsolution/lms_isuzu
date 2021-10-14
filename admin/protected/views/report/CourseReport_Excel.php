<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>

<?php 

 $strExcelFileName = "CourseReport_Excel" . ".xls";
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
            <!-- <h4>Course Report</h4>
            <font color="white">รายงาน รายงาน รายงาน รายงาน รายงาน รายงาน รายงาน</font>
            <br>
            <br>
            <h4>Data as of <?= date("d-M-Y H:i:s") ?></h4> -->
            <h4>Course Report <br> Data as of  <?= date("d-M-Y H:i:s") ?></h4>
        </div>
    </div> 
    <div class="widget-body" style=" overflow-x: scroll;">
        <table class="table table-bordered table-striped" border="1">
            <thead>
                <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Minor Course Type</th>
                            <th rowspan="2">Course Group</th>
                            <th rowspan="2">Course Number</th>
                            <th rowspan="2">Course Name</th>
                            <th rowspan="2">Lesson Number</th>
                            <th rowspan="2">Lesson</th>
                            <th rowspan="2">Course Created Date</th>
                            <th rowspan="2">Course Created By</th>
                            <th rowspan="2">Lasted Edit Date</th>
                            <th rowspan="2">Lasted Edit by</th>
                            <th rowspan="2">Video</th>
                            <th rowspan="2">PDF</th>
                            <th rowspan="2">SCORM</th>
                            <th rowspan="2">Audio</th>
                            <th rowspan="2">Youtube</th>

                            <th colspan="2 ">Pre-Test</th>
                            <th colspan="2">Post-Test</th>

                            <th rowspan="2">Evaluation Form</th>

                            <!-- <th colspan="4">Evaluation score</th> -->
                        </tr>
                        <tr>
                            <th>ALL Exams</th>
                            <th>Used  Exams</th>
                            <!-- <th>Status</th> -->

                            <th>ALL Exams</th>
                            <th>Used  Exams</th>
                            <!-- <th>Status</th> -->

                            <!-- <th>Content</th>
                            <th>Instructor</th>
                            <th>Material</th>
                            <th>Average score</th> -->

                        </tr>
            </thead>
            <tbody>
                <?php
                $report = $_GET['Report'];

                $criteria = new CDbCriteria;
                $criteria->with = array('courseonlines', 'courseonlines.usercreate', 'courseonlines.cates');

                $criteria->compare('categorys.active', "y");
                $criteria->compare('courseonline.active', "y");
                $criteria->compare('lesson.active', "y");

                $criteria->compare('categorys.lang_id', 1);
                $criteria->compare('courseonline.lang_id', 1);
                $criteria->compare('lesson.lang_id', 1);

                // if($report["department"] != ""){        
                //     $criteria->compare('user.department_id', $report["department"]);
                // }

                // if($report["employee_status"] != ""){        
                //     $criteria->compare('user.del_status', $report["employee_status"]);
                // }

                if($report["category"] != ""){        
                    $criteria->compare('courseonline.cate_id', $report["category"]);
                }

                if($report["course"] != ""){        
                    $criteria->compare('courseonline.course_id', $report["course"]);
                }

                if($report["lesson"] != ""){        
                    $criteria->compare('lesson.id', $report["lesson"]);
                }

                if($report["start_date"] != "" && $report["end_date"] != ""){
                    $criteria->addCondition("lesson.create_date>='".$report["start_date"]." 00:00:00"."'");
                    $criteria->addCondition("lesson.create_date<='".$report["end_date"]." 23:59:59"."'");
                }

                $criteria->order = "categorys.cate_title ASC, courseonline.course_title ASC, lesson.title ASC";
                $model_result = Lesson::model()->findAll($criteria);
                $model_count = count($model_result);

                if($model_count > 0) {
                    foreach($model_result as $i => $list) { // วน lesson

                        $evaluation_form = "No";
                        $evaluation_model = CourseTeacher::model()->with('q_header')->findAll(array(
                            'select'=>'t.id, t.survey_header_id',
                            'condition'=>'t.course_id="'.$list->course_id.'" AND q_header.active="y"'
                        ));
                        if(count($evaluation_model) > 0){
                            $evaluation_form = "Yes";
                        }

                        $evaluation_content = 0;
                        $evaluation_instructor  = 0;
                        $evaluation_facilitation  = 0;
                        $evaluation_total  = 0;

                        $evaluation_fix = CourseTeacher::model()->find(array(
                            'select'=>'id',
                            'condition'=>'course_id="'.$list->course_id.'" AND survey_header_id="43"'
                        ));

                        if($evaluation_fix != ""){
                            $max_choice_val = 5;
                            $QQuestAnsCourse = QQuestAnsCourse::model()->findALl(array(
                                'select'=>'id',
                                'condition'=>'course_id="'.$list->course_id.'" AND header_id="43"'
                            ));

                            $arr_qa = [];
                            foreach ($QQuestAnsCourse as $kq => $vq) {
                                $arr_qa[] = $vq->id;
                            }

                            //////////////////////////////////////////////

                            $QOptionChoices = QOptionChoices::model()->findALl(array(
                                'select'=>'option_choice_id',
                                'condition'=>'question_id="80" ' // content
                            ));
                            $arr_ch = [];
                            foreach ($QOptionChoices as $kq => $vq) {
                                $arr_ch[] = $vq->option_choice_id;
                            }

                            $criteria = new CDbCriteria;
                            $criteria->addIncondition('quest_ans_id', $arr_qa);
                            $criteria->addIncondition('choice_id', $arr_ch);
                            $criteria->select = 'answer_id, answer_numeric';
                            $QAnswersCourse = QAnswersCourse::model()->findAll($criteria);

                            foreach ($QAnswersCourse as $key_a => $value_a) {
                                $evaluation_content = $evaluation_content+$value_a->answer_numeric;
                            }

                            if($evaluation_content > 0 && count($QAnswersCourse) > 0){
                                $evaluation_content = ($evaluation_content*100)/(count($QAnswersCourse)*$max_choice_val);
                            }

                            //////////////////////////////////////////////

                            $QOptionChoices = QOptionChoices::model()->findALl(array(
                                'select'=>'option_choice_id',
                                'condition'=>'question_id="81" ' // instructor
                            ));
                            $arr_ch = [];
                            foreach ($QOptionChoices as $kq => $vq) {
                                $arr_ch[] = $vq->option_choice_id;
                            }

                            $criteria = new CDbCriteria;
                            $criteria->addIncondition('quest_ans_id', $arr_qa);
                            $criteria->addIncondition('choice_id', $arr_ch);
                            $criteria->select = 'answer_id, answer_numeric';
                            $QAnswersCourse = QAnswersCourse::model()->findAll($criteria);

                            foreach ($QAnswersCourse as $key_a => $value_a) {
                                $evaluation_instructor = $evaluation_instructor+$value_a->answer_numeric;
                            }

                            if($evaluation_instructor > 0 && count($QAnswersCourse) > 0){
                                $evaluation_instructor = ($evaluation_instructor*100)/(count($QAnswersCourse)*$max_choice_val);
                            }

                            //////////////////////////////////////////////

                            $QOptionChoices = QOptionChoices::model()->findALl(array(
                                'select'=>'option_choice_id',
                                'condition'=>'question_id="82" ' // facilitation
                            ));
                            $arr_ch = [];
                            foreach ($QOptionChoices as $kq => $vq) {
                                $arr_ch[] = $vq->option_choice_id;
                            }

                            $criteria = new CDbCriteria;
                            $criteria->addIncondition('quest_ans_id', $arr_qa);
                            $criteria->addIncondition('choice_id', $arr_ch);
                            $criteria->select = 'answer_id, answer_numeric';
                            $QAnswersCourse = QAnswersCourse::model()->findAll($criteria);

                            foreach ($QAnswersCourse as $key_a => $value_a) {
                                $evaluation_facilitation = $evaluation_facilitation+$value_a->answer_numeric;
                            }

                            if($evaluation_facilitation > 0 && count($QAnswersCourse) > 0){
                               $evaluation_facilitation = ($evaluation_facilitation*100)/(count($QAnswersCourse)*$max_choice_val);
                            }

                            ///////////////////////////////////////////////

                            if(($evaluation_content+$evaluation_instructor+$evaluation_facilitation) > 0){
                                $evaluation_total = ($evaluation_content+$evaluation_instructor+$evaluation_facilitation)/3;
                            }

                        } // if($evaluation_fix)  



                        //////////////////////////// จบ แบบสอบถาม ///////////////



                        $text_vdo = "No";
                        $text_pdf = "No";
                        $text_scorm = "No";
                        $text_audio = "No";
                        $text_youtube = "No";

                        if($list->type == "vdo"){
                            $text_vdo = "Yes";
                        }elseif($list->type == "pdf"){
                            $text_pdf = "Yes";                                        
                        }elseif($list->type == "scorm"){
                            $text_scorm = "Yes";                                        
                        }elseif($list->type == "audio"){
                            $text_audio = "Yes";                                        
                        }elseif($list->type == "youtube"){
                            $text_youtube = "Yes";                                        
                        }

                        $all_pre = 0;
                        $use_pre = 0;
                        $all_post = 0;
                        $use_post = 0;

                        $manage_model = Manage::model()->findAll(array(
                            'select'=>'type, group_id, manage_row',
                            'condition'=>'id="'.$list->id.'" AND active="y"'
                        ));
                        
                        foreach ($manage_model as $k_manage => $v_manage) {
                            $question_model = Question::model()->findAll(array(
                                'select'=>'ques_id',
                                'condition'=>'group_id="'.$v_manage->group_id.'" AND active="y"'
                            ));

                            if($v_manage->type == "pre"){
                                $all_pre = $all_pre+count($question_model);
                                $use_pre = $use_pre+$v_manage->manage_row;
                            }elseif($v_manage->type == "post"){
                                $all_post = $all_post+count($question_model);
                                $use_post = $use_post+$v_manage->manage_row;
                            }
                        }

                        $status_pre = "No";
                        $status_post = "No";

                        if($all_pre > 0 || $use_pre > 0){
                            $status_pre = "Yes";
                        }
                        if($all_post > 0 || $use_post > 0){
                            $status_post = "Yes";
                        }

                        ?>
                        <tr>
                            <td><?= $start_cnt+1 ?></td>
                            <td><?= $list->courseonlines->cates->type->type_name ?></td>
                            <td><?= $list->courseonlines->cates->cate_title ?></td>
                            <td><?= $list->courseonlines->course_number ?></td>
                            <td><?= $list->courseonlines->course_title ?></td>
                            <td><?= $list->lesson_number ?></td>
                            <td><?= $list->title ?></td>
                            <td><?= date("d-M-Y", strtotime($list->courseonlines->create_date)) ?></td>
                            <td><?= $list->courseonlines->usercreate->employee_id ?></td>
                            <td><?= date("d-M-Y", strtotime($list->courseonlines->update_date)) ?></td>
                            <td><?= $list->courseonlines->userupdate->employee_id ?></td>

                            <td><?= $text_vdo ?></td>
                            <td><?= $text_pdf ?></td>
                            <td><?= $text_scorm ?></td>
                            <td><?= $text_audio ?></td>
                            <td><?= $text_youtube ?></td>
                            
                            <td><?= $all_pre ?></td>
                            <td><?= $use_pre ?></td>
                            <!-- <td><?= $status_pre ?></td> -->

                            <td><?= $all_post ?></td>
                            <td><?= $use_post ?></td>
                            <!-- <td><?= $status_post ?></td> -->

                            <td><?= $evaluation_form ?></td>

                            <!-- <td><?= number_format($evaluation_content,2) ?> %</td>
                            <td><?= number_format($evaluation_instructor,2) ?> %</td>
                            <td><?= number_format($evaluation_facilitation,2) ?> %</td>
                            <td><?= number_format($evaluation_total,2) ?> %</td> -->
                        </tr>
                        <?php
                        $start_cnt++;
                    }
                } else {
                    ?>
                    <tr>
                       <td colspan="100"><strong>ไม่พบข้อมูล</strong></td>
                   </tr>
               <?php } ?>
            </tbody>
        </table>
    </div>
</div>