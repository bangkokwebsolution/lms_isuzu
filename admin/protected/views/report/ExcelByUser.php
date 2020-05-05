<?php

$strExcelFileName = "Export-Data-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");

        $search = $_GET['Report'];
        $textsearch = ($search['search']!=null)?'and email like "%'.$search['search'].'%" or profile.firstname like "%'.$search['search'].'%" or profile.lastname like "%'.$search['search'].'%"':null;
        //print_r($textsearch);
        $searchLesson = $search['lesson_id'];
        $searchCourse = $search['course_id'];

        $searchLessonArray = implode(',', $searchLesson);
        $sqlLessonQuery = ($searchLessonArray!='')?' and id in ('.$searchLessonArray.')':null;
        if(!empty($searchCourse)){
            $sqlCourseQuery = ' and courseonline.course_id = '.$searchCourse;
        }else{
            $sqlCourseQuery = null;
        }
        //generation
        $searchGeneration = $search['generation'];
        $gen = ($searchGeneration!='')?' and generation = "'. $searchGeneration . '"':null;

        //type_user
        $searchTyprUser = $search['type_user'];
        if( !empty($searchTyprUser)) {
                if($searchTyprUser == 1){ //General
                    $texttype .= " AND type_register != '3' ";
                }else if($searchTyprUser == 2){ //Staff
                    $texttype .= " AND type_register = '3' ";

                }
            }

        //Divsion
        if(!empty($search['division_id'])){
            $divisionInarray =  implode(",",$search['division_id']);
            $textsearch .= " and division_id IN ( ".$divisionInarray." )";
        }
            //Department
        if(!empty($search['department'])){
            $departmentInarray =  implode(",",$search['department']);
            $textsearch .= " and department_id IN ( ".$departmentInarray." )";
        }
            //Station
        if(!empty($search['station'])){
            $stationInarray =  implode(",",$search['station']);
            $textsearch .= " and station_id IN ( ".$stationInarray." )";
        }

        $schedule_id  = $search['schedule_id'];
        if(!empty($schedule_id) && $schedule_id != 'ทั้งหมด'){
            $modelSch  = Schedule::model()->findByAttributes(array('schedule_id'=> $schedule_id));
            //period_Schedule
            $period_start_schedule = ($modelSch->training_date_start)?date('Y-m-d 00:00:00', strtotime($modelSch->training_date_start)):null;
            $period_end_schedule = ($modelSch->training_date_end)?date('Y-m-d 23:59:59', strtotime($modelSch->training_date_end)):null;

            $startdate_schedule = ($period_start_schedule)?' and learn.create_date >= "'. $period_start_schedule .'"':null;
            $enddate_schedule = ($period_end_schedule)?' and learn.create_date <= "'. $period_end_schedule .'"':null;
        }

        //period
        $period_start = ($search['period_start'])?date('Y-m-d 00:00:00', strtotime($search['period_start'])):null;
        $period_end = ($search['period_end'])?date('Y-m-d 23:59:59', strtotime($search['period_end'])):null;
        
        $startdate = ($period_start)?' and learn.create_date >= "'. $period_start .'"':null;
        $enddate = ($period_end)?' and learn.create_date <= "'. $period_end .'"':null;

        $course_online = CourseOnline::model()->findAll(array(
            'condition' => 'courseonline.active = "y"' . $sqlCourseQuery,
            // 'join' => 'left join tbl_lesson on tbl_lesson.course_id = courseonline.course_id',
            'alias' => 'courseonline',
            'order' => 'courseonline.course_id ASC'
        ));
        $course_count = ($course_online)?count($course_online):0;
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
                    <h4 class="heading glyphicons show_thumbnails_with_lines">รายงานผู้เรียนรายบุคคล</h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2" class="center">อีเมลล์</th>
                            <th colspan="<?= $course_count?>" class="center">รายหลักสูตร</th>
                        </tr>
                        <tr>
                            <?php
                            $course_chk = [];
                            foreach($course_online as $i => $course) {
                                $course_chk[] = $course['course_id'];
                                    
                                    $cur_Lesson = Lesson::model()->findAll(array(
                                        'condition' => 'course_id ="' . $course['course_id'] . '" and active="y"' . $sqlLessonQuery,
                                        'order' => 'lesson_no ASC' 
                                    ));
                                    if($cur_Lesson) {
                                        foreach($cur_Lesson as $lesson) {
                                            ?>
                                            <th class="center"><?= $lesson['title'] ?></th>
                                        <?php
                                        }
                                    }
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1"' . $gen . $textsearch .$texttype,
                            ));
                            $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>false
                        ));
                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }
                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;
                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    
                                    $lern = Learn::model()->findAll(array(
                                    'condition' => 'course_id = "' . $course_chk[0] . '" AND lesson_active ="y" AND  user_id = "' . $user->id . '"'
                                ));
                                  if(count($lern) > 0){
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>

                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email ?></td>
                                        <?php
                                           if($course_online) {
                                                foreach($course_online as $course) {
                                                    $curLesson = Lesson::model()->findAll(array(
                                                        'condition' => 'lang_id = 1 and course_id ="' . $course['course_id'] . '" and active="y"' . $sqlLessonQuery,
                                                        'order' => 'lesson_no ASC' 
                                                    ));
                                                    if($curLesson) {
                                                        foreach($curLesson as $les) {
                                                            $statusLearn = Learn::model()->find(array(
                                                                'condition' => 'lesson_active = "y" and user_id = "' . $user['id'] . '" and lesson_id = "' . $les['id'] . '"' . $startdate . $enddate .$startdate_schedule .$enddate_schedule,
                                                                'alias' => 'learn'
                                                            ));
                                                            $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 'pass' => '<b style="color: blue;">ผ่าน</b>','notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
                                                            ?>
                                                            <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?> </td>
                                                            <?php
                                                        }
                                                    }else{ 
                                                        ?>
                                                        <td>
                                                            <strong>ไม่พบข้อมูล</strong>
                                                        </td>

                                                        <?php

                                                    }
                                                }
                                           }
                                        ?>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                }
                                }
                            } else {
                                ?>
                                <tr>
                                    <strong>ไม่พบข้อมูล</strong>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php 
                    // $this->widget('CLinkPager',array(
                    //                 'pages'=>$dataProvider->pagination
                    //                 )
                    //             );
                ?>
            </div>
        </div>