<?php
$strExcelFileName = "Report_Overview_Traini-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");

if(isset($_GET['Report'])){   
    $search = $_GET['Report'];
    $criteria = new CDbCriteria;
    $criteria->compare('active','y');
    $criteria->compare('parent_id',0);
    $criteria->compare('lang_id',1);
    if(isset($search['course_id'])){
        $criteria->compare('course_id',$search['course_id']);
    }
    $course_online = CourseOnline::model()->findAll($criteria);

    $lesson_online = Lesson::model()->findAll(array(
        "condition"=>"active='y' AND lang_id='1' AND course_id='".$search["course_id"]."'",
        "order"=>"title ASC"
    ));

    $gen_title = "";
    if($_GET['Report']['gen_id'] != 0){
        $gen_title = CourseGeneration::model()->findByPk($_GET['Report']['gen_id']);
        $gen_title = $gen_title->gen_title;
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

        // if(isset($_GET['Report']['period_start']) && $_GET['Report']['period_start'] != null) {
        //     $criteria->compare('start_date >= "' . date('Y-m-d 00:00:00', strtotime($_GET['Report']['period_start'])) . '"');
        // }
        // if(isset($_GET['Report']['period_end']) && $_GET['Report']['period_end'] != null) {
        //     $criteria->compare('start_date <= "' . date('Y-m-d 23:59:59', strtotime($_GET['Report']['period_end'])) . '"');
        // }

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
            <h4 class="heading glyphicons show_thumbnails_with_lines">รายงานภาพรวมของหลักสูตร</h4>
        </div>
    </div>
    <div class="widget-body" style=" overflow-x: scroll;">
        <table class="table table-bordered table-striped" border='1'>
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle;" class="center"><b>No.</b></th>
                    <th rowspan="2" style="vertical-align: middle;" class="center"><b>Minor course type</b></th>
                    <th rowspan="2" style="vertical-align: middle;" class="center"><b>Subminor course type</b></th>
                    <th rowspan="2" style="vertical-align: middle;" class="center"><b>Course Name</b></th>
                    <th rowspan="2" style="vertical-align: middle;" class="center"><b>Gen</b></th>
                    <th rowspan="2" style="vertical-align: middle;" class="center"><b>Course Status</b></th>
                    <th rowspan="2" style="vertical-align: middle;" class="center"><b>Total Learner</b></th>
                    <th colspan="3" style="vertical-align: middle;" class="center"><b>Not Finish</b></th>
                    <th colspan="2" style="vertical-align: middle;" class="center"><b>Completed</b></th>
                </tr>
                <tr>
                        <!--<th class="center"><b>จำนวนผ่าน</b></th>
                            <th class="center"><b>จำนวนไม่ผ่าน</b></th>-->
                            <th class="center"><b>Not Start</b></th>
                            <th class="center"><b>Ongoing</b></th>
                            <th class="center"><b>(Percent)</b></th>
                            <th style="vertical-align: middle;" class="center"><b>Completed</b></th>
                            <th style="vertical-align: middle;" class="center"><b>(Percent)</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no =1; 
                        foreach ($course_online as $keyC => $valueC) { 
                            $criteria = New CDbCriteria;
                            $criteria->compare('course_id',$valueC->course_id);
                            $criteria->compare('active','y');
                            if(isset($search['gen_id']) && $search['gen_id'] != 0){
                                $criteria->compare('gen_id',$search['gen_id']);
                            }
                            $generation = CourseGeneration::model()->findAll($criteria);

                            $lesson_online = Lesson::model()->findAll(array(
                                "condition"=>"active='y' AND lang_id='1' AND course_id='".$valueC->course_id."'","order"=>"title ASC"
                            ));
                            if(!empty($generation)){
                                foreach ($generation as $keyG => $valueG) {
                                    $criteria = new CDbCriteria;
                                    $criteria->with = array('pro', 'course', 'mem');
                                    $criteria->compare('superuser',0);
                                    $criteria->addCondition('user.id IS NOT NULL');
                                    $criteria->compare('t.gen_id', $valueG->gen_id);
                                    $criteria->compare('t.course_id',$valueC->course_id);
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
                                        $statusLearn =  Helpers::lib()->chk_status_course($valueC->course_id, $valueG->gen_id, $user->id);

                                        if($statusLearn == "pass"){
                                            $num_pass++;
                                        }elseif($statusLearn == "learning"){
                                            $num_learning++;
                                        }else{
                                            $num_notlearn++;
                                        }

                                        $final_score = Coursescore::model()->find("course_id='".$valueC->course_id."' AND gen_id='".$valueG->gen_id."' AND user_id='".$user->id."' AND type='post' AND active='y' ORDER BY score_id DESC");

                                        if($final_score){
                                            if($final_score->score_past == "y"){
                                                $num_final_pass++;
                                            }elseif($final_score->score_past == "n"){
                                                $num_final_notpass++;
                                            }
                                        }

                                        foreach ($lesson_online as $key_l => $value_l) {

                                            $statusLearn_lesson =  Helpers::lib()->chk_status_lesson($value_l->id, $valueG->gen_id, $user->id);

                                            if($statusLearn_lesson == "pass"){
                                                $lesson_pass[$value_l->id] = $lesson_pass[$value_l->id]+1;                    
                                            }elseif($statusLearn_lesson == "learning"){
                                                $lesson_learning[$value_l->id] = $lesson_learning[$value_l->id]+1;
                                            }


                                            $test_score = Score::model()->find("lesson_id='".$value_l->id."' AND gen_id='".$valueG->gen_id."' AND user_id='".$user->id."' AND type='post' AND active='y' ORDER BY score_id DESC"); 

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
                                    <tr>
                                        <td class="center"><?= $no++ ?></td>
                                        <td class="center"><?= isset($valueC->cates->type->type_name)? $valueC->cates->type->type_name :"" ?></td>
                                        <td class="center"><center><?= $valueC->course_number ?></center></td>
                                        <td><?= $valueC->course_title ?></td>
                                        <td class="center"><center><?= $valueG->gen_title != ''? $valueG->gen_title : '-' ?></center></td>
                                        <td class="center"><center><?= date('Y-m-d H:i:s') >= $valueC->course_date_start && date('Y-m-d H:i:s') <= $valueC->course_date_end ? 'Open':'Closed' ?></center></td>
                                        <td class="center"><?= $num_register ?></td>
                                        <td class="center"><?= $num_notlearn ?></td>
                                        <td class="center"><?= $num_learning ?></td>
                                        <?php $sumUser =  100*($num_learning+$num_notlearn)/$num_register ; 
                                        ?>
                                        <td class="center"><?=  number_format($sumUser)!='nan' ? round($sumUser, 2) : 0 ?> %</td><!-- กำลังเรียน % -->
                                        <!-- <td class="center"><?= $num_final_notpass ?></td> เรียนไม่ผ่าน -->
                                        <td class="center"><?= $num_pass ?></td>
                                        <td class="center"><?= $num_per_pass ?> %</td>
                                    </tr>
                                <?php    }
                            }else{  
                                $criteria = new CDbCriteria;
                                $criteria->with = array('pro', 'course', 'mem');
                                $criteria->compare('superuser',0);
                                $criteria->addCondition('user.id IS NOT NULL');
                                $criteria->compare('t.gen_id',0);
                                $criteria->compare('t.course_id',$valueC->course_id);
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
                                    $statusLearn =  Helpers::lib()->chk_status_course($valueC->course_id, 0, $user->id);

                                    if($statusLearn == "pass"){
                                        $num_pass++;
                                    }elseif($statusLearn == "learning"){
                                        $num_learning++;
                                    }else{
                                        $num_notlearn++;
                                    }

                                    $final_score = Coursescore::model()->find("course_id='".$valueC->course_id."' AND gen_id = 0 AND user_id='".$user->id."' AND type='post' AND active='y' ORDER BY score_id DESC");

                                    if($final_score){
                                        if($final_score->score_past == "y"){
                                            $num_final_pass++;
                                        }elseif($final_score->score_past == "n"){
                                            $num_final_notpass++;
                                        }
                                    }

                                    foreach ($lesson_online as $key_l => $value_l) {

                                        $statusLearn_lesson =  Helpers::lib()->chk_status_lesson($value_l->id, 0, $user->id);

                                        if($statusLearn_lesson == "pass"){
                                            $lesson_pass[$value_l->id] = $lesson_pass[$value_l->id]+1;                    
                                        }elseif($statusLearn_lesson == "learning"){
                                            $lesson_learning[$value_l->id] = $lesson_learning[$value_l->id]+1;
                                        }


                                        $test_score = Score::model()->find("lesson_id='".$value_l->id."' AND gen_id = 0 AND user_id='".$user->id."' AND type='post' AND active='y' ORDER BY score_id DESC"); 

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
                                <tr>
                                    <td class="center"><?= $no++ ?></td>
                                    <td class="center"><?= isset($valueC->cates->type->type_name)? $valueC->cates->type->type_name :"" ?></td>
                                    <td  class="center"><center><?= $valueC->course_number ?></center></td>
                                    <td><?= $valueC->course_title ?></td>
                                    <td class="center"><center><?= $gen_title != ''? $gen_title : '-' ?></center></td>
                                    <td class="center"><center><?= date('Y-m-d H:i:s') >= $valueC->course_date_start && date('Y-m-d H:i:s') <= $valueC->course_date_end ? 'Open':'Closed' ?></center></td>
                                    <td class="center"><?= $num_register ?></td>
                                    <td class="center"><?= $num_notlearn ?></td>
                                    <td class="center"><?= $num_learning ?></td>
                                    <?php $sumUser =  100*($num_learning+$num_notlearn)/$num_register ; 
                                    ?>
                                    <td class="center"><?=  number_format($sumUser)!='nan' ? round($sumUser, 2) : 0 ?> %</td><!-- กำลังเรียน % -->
                                    <!-- <td class="center"><?= $num_final_notpass ?></td> เรียนไม่ผ่าน -->
                                    <td class="center"><?= $num_pass ?></td>
                                    <td class="center"><?= $num_per_pass ?> %</td>
                                </tr>
                            <?php  }
                        } ?>
                    </tbody>
                </table>
                
            </div>
        </div>

