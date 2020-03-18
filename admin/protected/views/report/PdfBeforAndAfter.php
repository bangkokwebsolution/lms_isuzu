<?php
        $searchBox = trim($_GET['Report']['search']);
        $textsearch = ($searchBox!=null)?'and ( email like "%'.$searchBox.'%" or profile.firstname like "%'.$searchBox.'%" or profile.lastname like "%'.$searchBox.'%")':null;
        $searchCourse = $_GET['Report']['course_id'];
        // $searchCourseArray = implode(',', $searchCourse);
        // $sqlCourseQuery = ($searchCourseArray!='')?' and course_id in ('.$searchCourseArray.')':'';
        if(!empty($searchCourse)){
            $sqlCourseQuery = ' and course_id in ('.$searchCourse.')';
        }

        //generation
        $searchGeneration = $search['generation'];
        $gen = ($searchGeneration!='')?' and generation = "'. $searchGeneration . '"':'';

        //Divsion
        if(!empty($_GET['Report']['division_id'])){
            $divisionInarray =  implode(",",$_GET['Report']['division_id']);
            $sqlDivision = " and division_id IN ( ".$divisionInarray." )";
        }
            //Department
        if(!empty($_GET['Report']['department_id'])){
            $departmentInarray =  implode(",",$_GET['Report']['department_id']);
            $sqlDepartment = " and department_id IN ( ".$departmentInarray." )";
        }
            //Station
        if(!empty($_GET['Report']['station'])){
            $stationInarray =  implode(",",$_GET['Report']['station']);
            $sqlStation = " and station_id IN ( ".$stationInarray." )";
        }

        //period
        // $period_start = ($search['period_start'])?date('Y-m-d 00:00:00', strtotime($search['period_start'])):'';
        // $period_end = ($search['period_end'])?date('Y-m-d 23:59:59', strtotime($search['period_end'])):'';
        
        // $startdate = ($period_start)?' and learn.create_date >= "'. $period_start .'"':'';
        // $enddate = ($period_end)?' and learn.create_date <= "'. $period_end .'"':'';

        $period_start = ($_GET['Report']['period_start'])?date('Y-m-d 00:00:00', strtotime($_GET['Report']['period_start'])):null;
        $period_end = ($_GET['Report']['period_end'])?date('Y-m-d 23:59:59', strtotime($_GET['Report']['period_end'])):null;
        
        $startdate = ($period_start)?' and create_date >= "'. $period_start .'"':null;
        $enddate = ($period_end)?' and create_date <= "'. $period_end .'"':null;

        $course_online = CourseOnline::model()->findAll(array(
            'condition' => 'active = "y" and lang_id = 1 and status = "1"' . $sqlCourseQuery,
            'order' => 'course_id ASC'
        ));
        $course_count = ($course_online)?count($course_online):0;

    ?>
<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>
	<!-- END HIGH SEARCH -->
        <div class="widget" id="export-table">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' รายงานการสอบ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #ddd;" rowspan="3">ลำดับ</th>
                            <th style="border: 1px solid #ddd;" rowspan="3">ชื่อ-นามสกุล</th>
                            <th style="border: 1px solid #ddd;" rowspan="3">เลขประจำตัวพนักงาน</th>
                             <?php
                                foreach($course_online as $course) {
                                 $lesson_count = Lesson::model()->findAll([
                                    'condition' => 'course_id = '.$course['course_id'].' and active = "y" and lang_id = 1',
                                    'order' => 'lesson_no ASC' 
                                         ]);
                                 
                                   ?>
                            <th  style="writing-mode: tb-rl; border: 1px solid #ddd;" colspan="<?php echo (count($lesson_count)*2+1)+$course->cate_amount+1;?>" class="center"><?= $course['course_title'] ?></th>
                            <?php
                                }

                            ?>
                        </tr>
                        <tr>
                          <?php
                            
                            foreach ($course_online as $course) {
                                ?>
                             <th style="writing-mode: tb-rl; border: 1px solid #ddd;" rowspan = "2">วันที่สอบจบ</th>
                                <?php
                                 $lesson = Lesson::model()->findAll(array(

                                    'condition' => 'course_id = '.$course['course_id'].' and active = "y" and lang_id = 1','order'=>'id',
                                    'order' => 'lesson_no ASC' ));

                                 foreach ($lesson as $l) {

                                    
                                     # code...
                                    ?>

                                     <th style="writing-mode: tb-rl; border: 1px solid #ddd;" colspan = "2"><?=$l['title']?></th>


                                     <?php
                                 }
                               ?>
                                 <th style="writing-mode: tb-rl; border: 1px solid #ddd;" colspan = "<?= $course->cate_amount+1 ?>"  rowspan = "2">สอบวัดผล</th>

                            <?php

                                 }
                                 ?>
<!-- <?php
                            for($i = 1;$i<=count($course_online);$i++){
                                $lesson = Lesson::model()->findAll([
                                    'condition' => 'course_id = '.$i,
                                    'order' => 'lesson_no ASC' ]);
                               
                                // var_dump($l_count);exit();


                                for($j = 0;$j<count($lesson);$j++){
                                
                             
                                   ?>
                           
                                <th style="writing-mode: tb-rl;" colspan = "2"><?=$lesson[$j]['title']?></th>
                                

                                   <?php

                                 }
                                 ?>
                                 <th style="writing-mode: tb-rl;" rowspan = "2">สอบวัดผล</th>

                            <?php

                                 }
                                 ?> -->

                            
                             
                        </tr>
                        <tr>
                        <?php
                        foreach($course_online as $course) {

                            $lesson_online = lesson::model()->findAll(array(
                                'condition' => 'course_id = '. $course['course_id'].' and active = "y" and lang_id = 1','order'=>'lesson_no ASC'
                            ));

                            // var_dump(count($lesson_online));
                            

                                foreach($lesson_online as $lesson) {
                                   ?>
                           
                             
                                    <td style="border: 1px solid #ddd;">ก่อนเรียน</td>
                                    <td style="border: 1px solid #ddd;">หลังเรียน</td>
                                     
                                
                                
                                   <?php
                                }

                            }
                            ?>
                     
                           </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                            // $allUsers = User::model()->with('profile')->findAll(array(
                            //     'condition' => 'status ="1" and del_status != "1" ' . $gen . $textsearch .
                            //     $sqlDivision .$sqlDepartment .$sqlStation,
                            // ));
                            if($course_online[0]->cate_id == 1){
                                //TMS
                                $criteria=new CDbCriteria;
                                $criteria->join = ' INNER JOIN tbl_auth_course as au ON (user.id = au.user_id) ';
                                // $criteria->join = ' INNER JOIN tbl_profiles as profile ON (user.id = profile.user_id) ';
                                $criteria->addCondition('status ="1" and del_status != "1" ' . $gen . $textsearch .
                                    $sqlDivision .$sqlDepartment .$sqlStation);
                                $criteria->compare('au.course_id',$_GET['Report']['course_id']);
                                if(!empty($_GET['Report']['schedule_id']) && $_GET['Report']['schedule_id'] != 'ทั้งหมด')$criteria->compare('au.schedule_id',$_GET['Report']['schedule_id']);
                                $allUsers = User::model()->findAll($criteria);
                            } else {
                                $allUsers = User::model()->with('profile')->findAll(array(
                                    'condition' => 'status ="1" and del_status != "1" ' . $gen . $textsearch .
                                    $sqlDivision .$sqlDepartment .$sqlStation,
                                ));
                            }

                             $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>array(
                                'pageSize'=>3000
                                ),
                        ));
                            // $getPages = $_GET['page'];
                            // if($getPages = $_GET['page']!=0 ){
                            //     $getPages = $_GET['page'] -1;
                            // }
                            // $start_cnt = $dataProvider->pagination->pageSize * $getPages;
                            $start_cnt = 0;
                            if($dataProvider->getData()) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    // var_dump($user->pic_cardid2);
                                    // if(!empty($user->learns)){
                                    ?>
                                    <tr>
                                        <td style="border: 1px solid #ddd; text-align: center;"><?= $start_cnt+1 ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $user->profile->firstname . ' ' . $user->profile->lastname. ' '. $user['bookkeeper_id']?></td>
                                        <td style="border: 1px solid #ddd; text-align: center;">
                                            <?= (empty($user->pic_cardid2))? 'ไม่พบข้อมูล':$user->pic_cardid2; ?>
                                        </td>
                                        <?php
                                           // if($lesson_online) {
                                             foreach ($course_online as $rs_course) {
                                                 $lesson_online = Lesson::model()->findAll(array(
                                                 'condition' => 'active = "y"' . $sqlLessonQuery . "  and lang_id = 1 and course_id = ".$rs_course['course_id'],
                                                'order' => 'lesson_no ASC',
           
                                                    ));

                                                 $score_course = Coursescore::model()->find(array(
                                                    'order' => 'score_id DESC ',
                                                    'condition' => 'user_id = '.$user['id'].' and course_id = '.$rs_course['course_id'].' and active = "y"'.$startdate_schedule.$enddate_schedule.$startdate.$enddate
                                                ));

                                                ?>

                                                <td style="border: 1px solid #ddd; text-align: center;">
                                                    <?php
                                                    if(!empty($score_course->create_date)){
                                                        echo  Helpers::lib()->changeFormatDate($score_course->create_date);
                                                    }else{
                                                        echo  "<b style='color:red';>ยังไม่ได้สอบ</b>";
                                                    }
                                                    ?>
                                                </td>

                                                <?php

                                                foreach($lesson_online as $lesson) {
                                                    $score_pre->score_number = 0;
                                                    $score_pre->score_total = 0;
                                                    $percent_pre_lesson = 0;

                                                    // Param date
                                                    $schedule_id = $_GET['Report']['schedule_id'];
                                                    if(!empty($schedule_id)  && $schedule_id != 'ทั้งหมด'){
                                                        $modelSch  = Schedule::model()->findByAttributes(array('schedule_id'=> $schedule_id));

                                                       $period_start_schedule = ($modelSch->training_date_start)?date('Y-m-d 00:00:00', strtotime($modelSch->training_date_start)):null;
                                                       $period_end_schedule = ($modelSch->training_date_end)?date('Y-m-d 23:59:59', strtotime($modelSch->training_date_end)):null;

                                                       $startdate_schedule = ($period_start_schedule)?' and create_date >= "'. $period_start_schedule .'"':null;
                                                       $enddate_schedule = ($period_end_schedule)?' and create_date <= "'. $period_end_schedule .'"':null;
                                                   }
                                                   
                                                    // $score_pre = Score::model()->find(array(
                                                    //     'condition' => 'user_id ="'.$user['id'].'" and lesson_id ="'. $lesson['id'] .'"' ." and type = 'pre' and active = 'y'"
                                                    
                                                    // ));

                                                    $score_pre = Score::model()->find(array(
                                                        'condition' => 'user_id ="'.$user['id'].'" and lesson_id ="'. $lesson['id'] .'"' .' and type = "pre" and active = "y"'.$startdate_schedule.$enddate_schedule.$startdate.$enddate
                                                    
                                                    ));

                                                    $havePretest = Helpers::lib()->checkHavePreTestInManage($lesson['id']);
                                                    if(isset($score_pre)){
                                                        if($score_pre->score_past=='y'){
                                                            $color = "green";
                                                            $past_text = "ผ่าน";
                                                        }
                                                        else{
                                                            $color = "red";
                                                            $past_text = "ไม่ผ่าน";
                                                        }
                                                        $text_score_pre = $score_pre->score_number.'/'.$score_pre->score_total.'<br><b style="color:'.$color.';">'.round((($score_pre->score_number/$score_pre->score_total)*100),2).'%<br>'.   $past_text.'</b>';
                                                    }else if($havePretest) {
                                                        $text_score_pre = "<b style='color:red';>ยังไม่ได้สอบ</b>";
                                                    } else {
                                                        $text_score_pre = "<b style='color:red';>-</b>";
                                                        
                                                    }
                                                    $havePosttest = Helpers::lib()->checkHavePostTestInManage($lesson['id']);
                                                    $score_post = Score::model()->find(array(
                                                        'condition' => 'user_id ="'.$user['id'].'" and lesson_id ="'. $lesson['id'] .'"' ." and type = 'post' and active = 'y'".$startdate_schedule.$enddate_schedule.$startdate.$enddate,
                                                        'order' => 'score_id desc'
                                                    
                                                    ));

                                                    if(isset($score_post)){
                                                        if($score_post->score_past=='y'){
                                                            $color = "green";
                                                            $past_text = "ผ่าน";
                                                        }
                                                        else{
                                                            $color = "red";
                                                            $past_text = "ไม่ผ่าน";
                                                        }
                                                        $text_score_post = $score_post->score_number.'/'.$score_post->score_total.'<br><b style="color:'.$color.';">'.round((($score_post->score_number/$score_post->score_total)*100),2).'%<br>'.   $past_text.'</b>';
                                                    } else if($havePosttest){
                                                        $text_score_post = "<b style='color:red';>ยังไม่ได้สอบ</b>";
                                                    } else {
                                                        $text_score_post = "<b style='color:red';>-</b>";
                                                    }
                                       

                                                    ?>
                                                    <td style="border: 1px solid #ddd; text-align: center; " class="center"><?=$text_score_pre?>
                                                    </td>
                                                    <td style="border: 1px solid #ddd; text-align: center;" class="center"><?=$text_score_post?>
                                                    </td>
                                                    <?php
                                                }

                                                // $score_course = Coursescore::model()->find(array(
                                                //         'condition' => 'user_id = '.$user['id'].' and course_id = '.$rs_course['course_id'].' and active = "y"'.$startdate_schedule.$enddate_schedule.$startdate.$enddate
                                                //          ));
                                                // course_id = ".$rs_course['course_id']

                                           
                                                $count_course = Coursegrouptesting::model()->find(array(
                                                        'condition' => 'course_id = '.$rs_course['course_id'].''
                                                         ));

                                                if($count_course->QuesCount == 0 && !isset($score_course->score_past)){

                                                   $text_score_course = "<b style='color:red';>ไม่มีข้อสอบ</b>";
                                               }else{

                                                if(isset($score_course->score_past)){
                                                    if($score_course->score_past=='y'){
                                                        $color = "green";
                                                        $past_text = "ผ่าน";
                                                    }
                                                    else{
                                                        $color = "red";
                                                        $past_text = "ไม่ผ่าน";
                                                    }

                                                    $text_score_course = $score_course->score_number.'/'.$score_course->score_total.'<br><b style="color:'.$color.';">'.round((($score_course->score_number/$score_course->score_total)*100),2).'%<br>'.   $past_text.'</b>';
                                                }else{

                                                   $text_score_course = "<b style='color:red';>ยังไม่ได้สอบ</b>";
                                               }
                                           }

                                                // var_dump($score_course->score_past);exit();
                                                ?>
                                                 <td style="border: 1px solid #ddd; text-align: center;" class="center"><?=$text_score_course?>
                                                    </td>

                                                        <?php
                                                    $score_course_count = Coursescore::model()->findAll(array(
                                                        'limit' => $course->cate_amount,
                                                        'order' => 'score_id ASC ',
                                                        'condition' => 'user_id = '.$user['id'].' and course_id = '.$rs_course['course_id'].' and active = "y"'.$startdate_schedule.$enddate_schedule.$startdate.$enddate
                                                    ));
                                                    for ($i=0; $i < $course->cate_amount ; $i++) { 

                                                            if(!empty($score_course_count )){
                                                            if($score_course_count[$i] != null){ ?>
                                                         <td style="border: 1px solid #ddd; text-align: center; " class="center"> ครั้งที่ <?= $i+1 ?> <br> <?= $score_course_count[$i]->score_number.'/'.$score_course_count[$i]->score_total ?></td>
                                                            <?php }else{ ?>
                                                          <td style="border: 1px solid #ddd; text-align: center; " class="center"> ครั้งที่ <?= $i+1 ?><br> <b style='color:red';>-</b> </td>      
                                                          <?php  }

                                                          }else{ ?>
                                                            <td style="border: 1px solid #ddd; text-align: center; " class="center"><b style='color:red';>-</b> </td> 
                                                          <?php } ?>

                                                   <?php }
                                                        ?>

                                                 <?php
                                            // }
                                           }
                                        ?>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                // }
                            } 
                        }//End loop user
                                ?>

                    </tbody>
                </table>
              
            </div>
        </div>