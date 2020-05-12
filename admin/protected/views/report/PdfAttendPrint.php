<style type="text/css">
    body {
        font-family: 'kanit';
    }
        .btn-lesson-tr td{
             padding: 8px 8px;
             border-bottom:1px solid #bbc0c4;
             background-color: #bac9d3;
        }
        .lesson-trpd td{
            padding: 8px 12px;
            border-top:1px solid rgba(223, 219, 219, 0.22);    
        }

        .lesson-pd{
        padding-left: 15px !important;
    }
   
</style>
<div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> รายงายการเรียนรายวิชา</h4>
        </div>
        <?php 
            //Check Group User
            $course_cate = Category::model()->findAll(array('condition'=>'lang_id = 1'));
            $course_list = array();
            if($course_cate) {
                foreach($course_cate as $gen) {
                    $course_list[$gen->cate_id] = $gen->cate_title;
                }
            }
            $userModel = Users::model()->findByPk(Yii::app()->user->id);
            $state = in_array("1",json_decode($userModel->group));

         ?>
<div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
            <table class="table table-bordered toggleairasia-table" style="width: 100%; border: 3px;">
                <!-- Table heading -->
                <thead>


                    <tr style="background-color: #e476e8;">
                        <th  rowspan="2" style="vertical-align: middle; border: 0.5px solid #000;" class="center"><b>หลักสูตร/หัวข้อวิชา</b></th>
                        <th   rowspan="2" style="vertical-align: middle;border: 0.5px solid #000;" class="center"><b>สมัครเข้าเรียน</b></th>
                        <th  rowspan="2" style="vertical-align: middle;border: 0.5px solid #000;" class="center"><b>กำลังเรียน</b></th>
                        <th   rowspan="2" style="vertical-align: middle;border: 0.5px solid #000;" class="center"><b>เรียนจบ</b></th>
                        <!-- <th rowspan="2" style="vertical-align: middle;" class="center"><b>ผู้เรียนทั้งหมด</b></th> -->
                        <th  abbr=" " rowspan="2" style="vertical-align: middle;border: 0.5px solid #000;" class="center"><b>%การจบ</b></th>
                        <th  rowspan="2" style="vertical-align: middle;border: 0.5px solid #000;" class="center"><b>จำนวนผู้ที่เรียนหลักสูตร</b></th>

                        <th  colspan="2" style="vertical-align: middle;border: 0.5px solid #000;" class="center"><b>หมายเหตุ</b></th>
                    </tr>
                    <tr  style="background-color: #e476e8;">
                        <th  style="border: 0.5px solid #000;" class="center"><b>สอบผ่าน</b></th>
                        <!-- <th class="center"><b>พิมพ์ใบรับรอง</b></th> -->
                        <th  style="border: 0.5px solid #000;" class="center"><b>สอบไม่ผ่าน</b></th>
                    </tr>
                </thead>
                <!-- // Table heading END -->

                <!-- Table body -->
                <tbody>
                <!-- Table row -->
                
                <?php
                $net_regis_all = 0;
                $net_learning_all = 0;
                $net_pass_all = 0;
                $net_total_all = 0;
                $net_percent_pass_all = 0;
                $net_test_pass_all = 0;
                $net_test_fail_all = 0;
                $net_print_all = 0;

                if(empty($_GET['ReportUser']['course'])){ //ไม่ได้เลือกหลักสูตร

                    if(!empty($_GET['ReportUser']['course_type']) && $_GET['ReportUser']['course_type'] == 1){ //TMS
                           $course_cate = Category::model()->findByPk(1);
                           $course_list = array();
                           if($course_cate) {
                            $course_list[$course_cate->cate_id] = $course_cate->cate_title;
                        } 
                    }

                    foreach($course_list as $id => $name){
                        // $sqlCoursecate = " SELECT course_id from tbl_course_online where cate_id in ($id) and active='y'";
                        if(!empty($_GET['ReportUser']['course_type']) && $_GET['ReportUser']['course_type'] == 1){ //TMS
                            $course_search = $_GET['ReportUser']['course_type'];
                            $sqlCoursecate = "SELECT course_id from tbl_course_online where lang_id = 1 and 
                            active = 'y' and cate_id in ($course_search) ";
                        }else if($_GET['ReportUser']['course_type'] == 2){ //LMS
                            $sqlCoursecate = "SELECT course_id from tbl_course_online where lang_id = 1 and active = 'y' and cate_id not in ( 1 ) and cate_id in ( $id )";
                        }else{ //ทั้งหมด
                            $sqlCoursecate = "SELECT course_id from tbl_course_online where lang_id = 1 and active = 'y' and cate_id  in ( $id )";
                        }

                        if(!$state){
                            $sqlCoursecate .= ' and create_by = "'.Yii::app()->user->id.'"';
                        }
//                        $sqlCoursecate = " SELECT course_id from tbl_course_online where active='y'";         
                        $sqlCoursecate .= " order by sortOrder";

                        // $name_result = Yii::app()->db->createCommand($sqlname)->queryAll();
                        // foreach ($name_result as $index => $rs){
                        //         $name = $rs['cate_title'];
                        // }

                        $course = Yii::app()->db->createCommand($sqlCoursecate)->queryAll();
                        $loop_id_course = array();
                        foreach ($course as $index => $rs){
                            $loop_id_course[] = $rs['course_id'];
                        }
                        $course_data[$name] = implode(',',$loop_id_course);
                    }

                }else{ //เลือกหลักสูตร
                    // $course_search = $_GET['ReportUser']['course'];
                    // $sqlname = "SELECT cate_title from tbl_category where active = 'y' and cate_id in ($course_search) ";
                    if(!empty($_GET['ReportUser']['course_type']) && $_GET['ReportUser']['course_type'] == 1){ //TMS
                        $course_search = $_GET['ReportUser']['course_type'];
                        $sqlname = "SELECT cate_title from tbl_category where cate_id in ($course_search) ";
                        $sqlCoursecate = " SELECT course_id from tbl_course_online where lang_id = 1 and active = 'y' and cate_id in ($course_search) ";
                        // $sqlCoursecate .= " order by sortOrder";

                    }else{
                        $sqlname = "SELECT cate_title from tbl_category where active = 'y' AND cate_id = (SELECT cate_id FROM tbl_course_online 
                        WHERE course_id = ".($_GET['ReportUser']['course']).")";

                        $sqlCoursecate = " SELECT course_id from tbl_course_online where lang_id = 1 and active = 'y'";
                        // $sqlCoursecate .= " order by sortOrder";
                        if(!empty($_GET['ReportUser']['course'])){
                           $sqlname .= " AND cate_id = (SELECT cate_id FROM tbl_course_online 
                           WHERE course_id = ".($_GET['ReportUser']['course']).")";
                           $sqlCoursecate .= ' AND course_id = '.$_GET['ReportUser']['course'];
                        }

                    }
                        if(!$state){
                            $sqlCoursecate .= ' and tbl_course_online.create_by = "'.Yii::app()->user->id.' "';
                        }

                        $sqlCoursecate .= " order by sortOrder";

                        $name_result = Yii::app()->db->createCommand($sqlname)->queryAll();
                        foreach ($name_result as $index => $rs){
                                $name = $rs['cate_title'];
                        }
                        // $sqlCoursecate = " SELECT course_id from tbl_course_online where cate_id in ($course_search) ";
                        // $sqlCoursecate .= " order by sortOrder";
                        $course = Yii::app()->db->createCommand($sqlCoursecate)->queryAll();
                        $loop_id_course = array();
                        foreach ($course as $index => $rs){
                            $loop_id_course[] = $rs['course_id'];
                        }
                        $course_data[$name] = implode(',',$loop_id_course);
                }


                foreach($course_data as $title => $id){
                    if($id){
                    $data = "<tr style=\"background-color: #ffc156;\">
                    <td style='border: 0.5px solid #000;' colspan=\"8\" class=\"head-tr\"><center><b>".$title."</b></center></td>
                </tr>";
                $sqlCourse = " SELECT course_title,course_id from tbl_course_online where course_id in ($id) ";

                if(!$state){
                    $sqlCoursecate .= ' and tbl_course_online.create_by = "'.Yii::app()->user->id.' "';
                }

                $sqlCourse .= " order by sortOrder";
                
                $course = Yii::app()->db->createCommand($sqlCourse)->queryAll();
                $orderNumber = 1;
                
                $net_regis = 0;
                $net_learning = 0;
                $net_pass = 0;
                $net_total = 0;
                $net_percent_pass = 0;
                $net_test_pass = 0;
                $net_test_fail = 0;
                $net_print = 0;
                
                foreach ($course as $courseItem) { /** @var User $userItem */
                    $course_id = $courseItem['course_id'];
                    $sqllesson = " SELECT id,title from tbl_lesson where course_id = $course_id and lang_id = 1 and active = 'y'";

                    if(!$state){
                        $sqllesson .= ' and tbl_lesson.create_by = "'.Yii::app()->user->id.' "';
                    }
                    $lesson = Yii::app()->db->createCommand($sqllesson)->queryAll();
                    $result_regis = 0;      
                    $result_learning = 0;   
                    $result_pass = 0;       
                    $total = 0;             
                    $percent_pass = 0;      
                    $test_pass = 0;  
                    $test_fail = 0;       
                    $print = 0;       
                    $net_learn_pass = 0;  

                    $dataLesson = '';      
                        foreach ($lesson as $lessonItem) { /** @var User $userItem */
                            $lesson_id = $lessonItem['id'];
                            $lesson_title = $lessonItem['title'];

                            $sqlregis = " SELECT count(learn_id) as regis from tbl_learn where lesson_active='y' and lesson_id = $lesson_id and lesson_status is null";

                            $sqlregisAll = " SELECT user_id as regis from tbl_learn where lesson_active='y' and lesson_id = $lesson_id";

                            if(!empty($_GET['ReportUser']['generation'])){
                              $sqlregisWhere .= "   and user_id in((select user_id from tbl_profiles where generation = ".$_GET['ReportUser']['generation']."))";
                            }
                            //Divsion
                            if(!empty($_GET['ReportUser']['division_id'])){
                                $divisionInarray =  implode(",",$_GET['ReportUser']['division_id']);
                                $sqlregisWhere .= "   and user_id in((select user_id from tbl_users where division_id IN ( ".$divisionInarray." ) ))";
                            }
                            //Department
                            if(!empty($_GET['ReportUser']['department'])){
                                $departmentInarray =  implode(",",$_GET['ReportUser']['department']);
                                $sqlregisWhere .= "   and user_id in((select user_id from tbl_users where department_id IN ( ".$departmentInarray." ) ))";
                            }
                            //station
                            if(!empty($_GET['ReportUser']['station'])){
                                $stationInarray =  implode(",",$_GET['ReportUser']['station']);
                                $sqlregisWhere .= "   and user_id in((select user_id from tbl_users where station_id IN ( ".$stationInarray." ) ))";
                            }
                            //schedule
                            if(!empty($schedule_id)){
                                 $sqlregisWhere .= "   and user_id in((select user_id from tbl_auth_course where schedule_id = ".$schedule_id." ))";
                            }

                            if(!empty($_GET['ReportUser']['date_start']) && !empty($_GET['ReportUser']['date_end'])){
                              $sqlregisWhere .= "   and create_date between '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_start']))."' and '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_end']))."'";
                            }

                            $regisAll = Yii::app()->db->createCommand($sqlregisAll.$sqlregisWhere)->queryAll();
                            foreach ($regisAll as $key => $value) {
                                if(!in_array($value, $arrLearnLesson))$arrLearnLesson[] = $value['regis'];
                                if(!in_array($value, $arrLearnCourse))$arrLearnCourse[] = $value['regis'];
                            }
                            $userNotLearnLesson = count(array_diff($arrLearnCourseAll, $arrLearnLesson));
                            $regis = Yii::app()->db->createCommand($sqlregis.$sqlregisWhere)->queryAll();
                            $result_regis += $regis[0]['regis'];
     
                            $sqllearning = " SELECT count(learn_id) as learning from tbl_learn where lesson_active='y' and lesson_id = $lesson_id and (lesson_status = 'learning' or lesson_status is null)";

                            if(!empty($_GET['ReportUser']['generation'])){
                              $sqllearning .= "   and user_id in((select user_id from tbl_profiles where generation = ".$_GET['ReportUser']['generation']."))";
                            }

                            //Divsion
                            if(!empty($_GET['ReportUser']['division_id'])){
                                $divisionInarray =  implode(",",$_GET['ReportUser']['division_id']);
                                $sqllearning .= "   and user_id in((select user_id from tbl_users where division_id IN ( ".$divisionInarray." ) ))";
                            }
                            //Department
                            if(!empty($_GET['ReportUser']['department'])){
                                $departmentInarray =  implode(",",$_GET['ReportUser']['department']);
                                $sqllearning .= "   and user_id in((select user_id from tbl_users where department_id IN ( ".$departmentInarray." ) ))";
                            }
                            //station
                            if(!empty($_GET['ReportUser']['station'])){
                                $stationInarray =  implode(",",$_GET['ReportUser']['station']);
                                $sqllearning .= "   and user_id in((select user_id from tbl_users where station_id IN ( ".$stationInarray." ) ))";
                            }

                            //schedule
                            if(!empty($schedule_id)){
                                 $sqllearning .= "   and user_id in((select user_id from tbl_auth_course where schedule_id = ".$schedule_id." ))";
                            }

                            if(!empty($_GET['ReportUser']['date_start']) && !empty($_GET['ReportUser']['date_end'])){
                              $sqllearning .= "   and create_date between '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_start']))."' and '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_end']))."'";
                            }

                            // $sqllearningall = $sqllearning;

                            // $sqllearningall .= "and (lesson_status = 'learning' or lesson_status is null)";

                            // $sqllearning .= "and lesson_status = 'learning'";

                            $learning = Yii::app()->db->createCommand($sqllearning)->queryAll();
                            
                            $result_learning += $learning[0]['learning'];
                            $sqlpass = " SELECT count(learn_id) as pass from tbl_learn where lesson_active='y' and lesson_id = $lesson_id and lesson_status = 'pass'";
                            if(!empty($_GET['ReportUser']['generation'])){
                              $sqlpass .= "   and user_id in((select user_id from tbl_profiles where generation = ".$_GET['ReportUser']['generation']."))";
                            }

                            //Divsion
                            if(!empty($_GET['ReportUser']['division_id'])){
                                $divisionInarray =  implode(",",$_GET['ReportUser']['division_id']);
                                $sqlpass .= "   and user_id in((select user_id from tbl_users where division_id IN ( ".$divisionInarray." ) ))";
                            }
                            //Department
                            if(!empty($_GET['ReportUser']['department'])){
                                $departmentInarray =  implode(",",$_GET['ReportUser']['department']);
                                $sqlpass .= "   and user_id in((select user_id from tbl_users where department_id IN ( ".$departmentInarray." ) ))";
                            }
                            //station
                            if(!empty($_GET['ReportUser']['station'])){
                                $stationInarray =  implode(",",$_GET['ReportUser']['station']);
                                $sqlpass .= "   and user_id in((select user_id from tbl_users where station_id IN ( ".$stationInarray." ) ))";
                            }
                            //schedule
                            if(!empty($schedule_id)){
                                 $sqlpass .= "   and user_id in((select user_id from tbl_auth_course where schedule_id = ".$schedule_id." ))";
                            }

                            if(!empty($_GET['ReportUser']['date_start']) && !empty($_GET['ReportUser']['date_end'])){
                              $sqlpass .= "   and create_date between '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_start']))."' and '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_end']))."'";
                            }
                            $pass = Yii::app()->db->createCommand($sqlpass)->queryAll();
                            $result_pass += $pass[0]['pass'];

                            $net_learn_pass+= $pass[0]['pass'] ;


                            //Lesson score pass only
                            $sqlScore = " SELECT * from tbl_score where lesson_id = $lesson_id and type = 'post' and active = 'y' ";
                            if(!empty($_GET['ReportUser']['generation'])){
                              $sqlScore .= "   and user_id in((select user_id from tbl_profiles where generation = ".$_GET['ReportUser']['generation']."))";
                            }

                            //Divsion
                            if(!empty($_GET['ReportUser']['division_id'])){
                                $divisionInarray =  implode(",",$_GET['ReportUser']['division_id']);
                                $sqlScore .= "   and user_id in((select user_id from tbl_users where division_id IN ( ".$divisionInarray." ) ))";
                            }
                            //Department
                            if(!empty($_GET['ReportUser']['department'])){
                                $departmentInarray =  implode(",",$_GET['ReportUser']['department']);
                                $sqlScore .= "   and user_id in((select user_id from tbl_users where department_id IN ( ".$departmentInarray." ) ))";
                            }
                            //station
                            if(!empty($_GET['ReportUser']['station'])){
                                $stationInarray =  implode(",",$_GET['ReportUser']['station']);
                                $sqlScore .= "   and user_id in((select user_id from tbl_users where station_id IN ( ".$stationInarray." ) ))";
                            }
                            //schedule
                            if(!empty($schedule_id)){
                                $sqlScore .= "   and user_id in((select user_id from tbl_auth_course where schedule_id = ".$schedule_id." ))";
                            }

                            if(!empty($_GET['ReportUser']['date_start']) && !empty($_GET['ReportUser']['date_end'])){
                              $sqlScore .= "   and create_date between '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_start']))."' and '".date("Y-m-d H:i:s",strtotime($_GET['ReportUser']['date_end']))."'";
                            }
                            $sqlScore .= 'ORDER BY tbl_score.user_id,tbl_score.score_id';
                            $lessonScore = Yii::app()->db->createCommand($sqlScore)->queryAll();
                            $lesson_pass_test = 0;
                            $lesson_fail_test = 0;
                            $scoreCheck = array();
                            foreach ($lessonScore as $key => $value) {
                                $scoreCheck[$value['user_id']][] = $value['score_past'];
                            }
                            foreach ($scoreCheck as $key => $value) {
                               if(in_array("y",$value)){
                                    $lesson_pass_test++;
                                } else {
                                    $lesson_fail_test++;
                                }
                            }

                            //End Lesson score pass

                            $totalLesson = $learning[0]['learning']+$pass[0]['pass']; //User all regis by lesson
                            $percent_pass_lesson = 0;
                            if($totalLesson!=0){
                                $percent_pass_lesson = number_format($pass[0]['pass']*100/$totalLesson, 2, '.', '');
                            }
                            // var_dump($$regis[0]['pass']);
                            // var_dump($learning[0]['learning']);
                            // var_dump($pass[0]['pass']);
                            if(!empty($lessonItem['title'])){
                                $dataLesson .= '<tr>
                                <td style="border: 0.5px solid #000;" class="lesson-pd">'.$lessonItem['title'].'</td>
                                <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/RegisterCourse',array('id'=>$lessonItem['id'],'schedule_id' => $schedule_id)).'"><center>'.$totalLesson.'</center></a></td>
                                <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/CourseLearning',array('id'=>$lessonItem['id'],'schedule_id' => $schedule_id)).'"><center>'.$learning[0]['learning'].'</center></a></td>
                                <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/CoursePass',array('id'=>$lessonItem['id'],'schedule_id' => $schedule_id)).'"><center>'.$pass[0]['pass'].'</center></a></td>
                                <td style="border: 0.5px solid #000;"><center>'.$percent_pass_lesson.'</center></td>
                                 <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/CoursePass',array('id'=>$courseItem['course_id'],'schedule_id' => $schedule_id)).'"><center>'.$pass[0]['pass'].'</center></a></td>';
                                if(!empty($schedule_id)){
                                $dataLesson .= '<td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/NotLearn',array('id'=>$lessonItem['id'],'schedule_id' => $schedule_id,'type'=>'lesson')).'"><center>'.$userNotLearnLesson.'</center></a></td>';
                                }

                                $dataLesson .= '<td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/TestScore',array('id'=>$lessonItem['id'],'type'=>'pass','schedule_id' => $schedule_id)).'"><center>'.$lesson_pass_test.'</center></a></td>
                                <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/TestScore',array('id'=>$lessonItem['id'],'type'=>'fail','schedule_id' => $schedule_id)).'"><center>'.$lesson_fail_test.'</center></a></td>
                                </tr>'; 
                            }

                        }//End lesson loop
                    // var_dump("----------------");
                        $total = $result_regis+$result_learning+$result_pass;
                        $net_regis += $total;
                        $net_learning += $result_learning;
                        $net_pass += $result_pass;
                        $net_total += $total;
                        if($total!=0){
                        $percent_pass = number_format($result_pass*100/$total, 2, '.', '');
                        }
                        $period_start = ($_GET['ReportUser']['date_start'])?date('Y-m-d 00:00:00', strtotime($_GET['ReportUser']['date_start'])):null;
                        $period_end = ($_GET['ReportUser']['date_end'])?date('Y-m-d 23:59:59', strtotime($_GET['ReportUser']['date_end'])):null;
                        
                        //จำนวนพิมใบประกาศ
                        $startdate = ($period_start)?' and pclog_date >= "'. $period_start .'"':null;
                        $enddate = ($period_end)?' and pclog_date <= "'. $period_end .'"':null;
                        $gen_pass = ($_GET['ReportUser']['generation'])?' and generation = '.$_GET['ReportUser']['generation']:null;
                        //Division
                        if(!empty($_GET['ReportUser']['division_id'])){
                            $divisionInarray =  implode(",",$_GET['ReportUser']['division_id']);
                            $division_pass = ' and Users.division_id IN ('.$divisionInarray.')';
                        }

                        //Department
                        if(!empty($_GET['ReportUser']['department'])){
                            $departmentInarray =  implode(",",$_GET['ReportUser']['department']);
                            $department_pass = ' and Users.department_id IN ('.$departmentInarray.')';
                        }
                        //Station
                        if(!empty($_GET['ReportUser']['station'])){
                            $stationInarray =  implode(",",$_GET['ReportUser']['station']);
                            $station_pass = ' and Users.station_id IN ('.$stationInarray.')';
                        }

                        //schedule
                        if(!empty($schedule_id)){
                            $schedule_pass = "   and user_id in((select user_id from tbl_auth_course where schedule_id = ".$schedule_id." ))";
                        }

                        $print_data = PasscoursLog::model()->with('Course')->with('Profiles')->with('Users')->findAll(array(
                                                'condition' => 'passcours_cours = "' . $course_id . '"' . $startdate . $enddate.$gen_pass.$division_pass.$department_pass.$station_pass.$schedule_pass,
                                                'group' => 'pclog_target'
                                            ));
                        if($print_data){
                        $print = count($print_data);
                        }
                        $net_print += $print;
                        // end จำนวนพิมใบประกาศ
                        
                        //จำนวนสอบผ่าน
                        $startdate_test = ($period_start)?' and create_date >= "'. $period_start .'"':null;
                        $enddate_test = ($period_end)?' and create_date <= "'. $period_end .'"':null;
                        $gen_pass = ($_GET['ReportUser']['generation'])?' and generation = '.$_GET['ReportUser']['generation']:null;

                        //Division
                        if(!empty($_GET['ReportUser']['division_id'])){
                            $divisionInarray =  implode(",",$_GET['ReportUser']['division_id']);
                            $division_pass = ' and user.division_id IN ('.$divisionInarray.')';
                        }

                        //Department
                        if(!empty($_GET['ReportUser']['department'])){
                            $departmentInarray =  implode(",",$_GET['ReportUser']['department']);
                            $department_pass = ' and user.department_id IN ('.$departmentInarray.')';
                        }
                        //Station
                        if(!empty($_GET['ReportUser']['station'])){
                            $stationInarray =  implode(",",$_GET['ReportUser']['station']);
                            $station_pass = ' and user.station_id IN ('.$stationInarray.')';
                        }


                        //schedule
                        if(!empty($schedule_id)){
                            $schedule_course = "   and user.id in((select user_id from tbl_auth_course where schedule_id = ".$schedule_id." ))";
                        }

                        // $test_pass_data = Coursescore::model()->with('Profiles')->with('user')->findAll(array('condition' => 'score_past = "y" and course_id = "' . $course_id . '"' . $startdate_test . $enddate_test.$gen_pass.$division_pass.$department_pass.$station_pass,'group' => 't.user_id'
                        //                                                     ));
                        // if($test_pass_data){
                        // $test_pass = count($test_pass_data);
                        // }
                        // $net_test_pass += $test_pass;

                         $test_pass_data = Coursescore::model()->with('Profiles')->with('user')->findAll(array('condition' => 'active="y" and course_id = "' . $course_id . '"' . $startdate_test . $enddate_test.$gen_pass.$division_pass.$department_pass.$station_pass.$schedule_course));
                        $scoreCourseCheck = array();
                        foreach ($test_pass_data as $key => $value) {
                            $scoreCourseCheck[$value['user_id']][] = $value['score_past'];
                        }
                        foreach ($scoreCourseCheck as $key => $value) {
                            if(in_array("y",$value)){
                                $test_pass++;
                            } else {
                                $test_fail++;
                            }
                        }
                        $net_test_pass += $test_pass;
                        $net_test_fail += $test_fail;
                        
                        // end จำนวนสอบผ่าน

                        //จำนวนสอบไม่ผ่าน
                        // $startdate_test = ($period_start)?' and create_date >= "'. $period_start .'"':null;
                        // $enddate_test = ($period_end)?' and create_date <= "'. $period_end .'"':null;

                        // //Division
                        // if(!empty($_GET['ReportUser']['division_id'])){
                        //     $divisionInarray =  implode(",",$_GET['ReportUser']['division_id']);
                        //     $division_fail = ' and user.division_id IN ('.$divisionInarray.')';
                        // }

                        // //Department
                        // if(!empty($_GET['ReportUser']['department'])){
                        //     $departmentInarray =  implode(",",$_GET['ReportUser']['department']);
                        //     $department_fail = ' and user.department_id IN ('.$departmentInarray.')';
                        // }
                        // //Station
                        // if(!empty($_GET['ReportUser']['station'])){
                        //     $stationInarray =  implode(",",$_GET['ReportUser']['station']);
                        //     $station_fail = ' and user.station_id IN ('.$stationInarray.')';
                        // }

                        // $test_fail_data = Coursescore::model()->with('Profiles')->with('user')->findAll(array('condition' => 'score_past = "n" and course_id = "' . $course_id . '"' . $startdate_test . $enddate_test.$division_fail.$department_fail.$station_fail,'group' => 't.user_id'));

                        // if($test_fail_data){
                        // $test_fail = count($test_fail_data);
                        // }
                        // $net_test_fail += $test_fail;
                        // end จำนวนสอบไม่ผ่าน
                        
                // $data .= "<tr>
                //     <td>".$courseItem['course_title']."</td>
                //      <td><center>$total</center></td>
                //       <td><center>$result_learning</center></td>
                //        <td><center>$result_pass</center></td>
                //         <td><center>$total</center></td>
                //          <td><center>$percent_pass</center></td>
                //           <td><center>$test_pass</center></td>
                //            <td><center>$print</center></td>
                // </tr>
                
                // <!-- // Table row END -->";
                $userNotLearnCourse = count(array_diff($arrLearnCourseAll, $arrLearnCourse));
                $data .= '<tr>
                    <td style="border: 0.5px solid #000;"><button class="toggle-btn" id="tr'. $courseItem['course_id'].'">'.$courseItem['course_title'].'<span class="pull-right fa fa-caret-down"></span></button></td>';
                if(!empty($schedule_id)){
                    $data .= '<td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/RegisterCourseTms',array('id'=>$schedule_id)).'"><center>'.count($countAuth).'</center></a></td>
                     <td style="border: 0.5px solid #000;" colspan="3"><center></center></td>
                     <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/NotLearn',array('id'=>$schedule_id,'type'=>'course')).'"><center>'.$userNotLearnCourse.'</center></a></td>';
                } else {
                    $data .= '<td style="border: 0.5px solid #000;" colspan="4"><center></center></td>';
                }

                $data .= '
                 <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/CoursePassAll',array('id'=>$courseItem['course_id'],'schedule_id' => $schedule_id)).'"><center>'.$net_learn_pass.'</center></a></td>
                <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/TestCourseScore',array('id'=>$courseItem['course_id'],'type'=>'pass','schedule_id' => $schedule_id)).'"><center>'.$test_pass.'</center></a></td>
                          <td style="border: 0.5px solid #000;"><a href="'.$this->createUrl('report/TestCourseScore',array('id'=>$courseItem['course_id'],'type'=>'fail','schedule_id' => $schedule_id)).'"><center>'.$test_fail.'</center></a></td>
                </tr>
                
                <!-- // Table row END -->';

                // $data .= '<tr>
                //     <td><button class="toggle-btn" id="tr'. $courseItem['course_id'].'">'.$courseItem['course_title'].'<span class="pull-right fa fa-caret-down"></span></button></td>
                //      <td><center>'.$total.'</center></td>
                //       <td><center>'.$result_learning.'</center></td>
                //        <td><center>'.$result_pass.'</center></td>
                //          <td><center>'.$percent_pass.'</center></td>
                //           <td><center>'.$test_pass.'</center></td>
                //           <td><center>'.$test_fail.'</center></td>
                // </tr>
                
                // <!-- // Table row END -->';
                    //Lesson

                // var_dump("COURSE: ".$courseItem['course_id']);
                $data .= '<tbody id="tr'.$courseItem['course_id'].'" class="toggle">';
                $data .= $dataLesson;
                foreach ($lesson as $lessonItem) {
                    // if(!empty($lessonItem['title'])){
                    //     // var_dump($lessonItem['title']);
                    //     $data .= '<tr>
                    //             <td>'.$lessonItem['title'].'('.$lessonItem['id'].')'.'</td>
                    //             <td><center>1</center></td>
                    //             <td><center>1</center></td>
                    //             <td><center>1</center></td>
                    //             <td><center>1</center></td>
                    //             <td><center>1</center></td>
                    //             <td><center>1</center></td>
                    //         </tr>'; 
                    // }
                }
                $data .= '</tbody>';
                 }             
                        $net_regis_all += $net_total;
                        $net_learning_all += $net_learning;
                        $net_pass_all += $net_pass;
                        $net_total_all += $net_total;
                        $net_print_all += $net_print;

                        $net_test_pass_all += $net_test_pass;
                        $net_test_fail_all += $net_test_fail;

                        if($net_total!=0){
                            $net_percent_pass = number_format($net_pass*100/$net_total, 2, '.', '');
                        }
                //  $data .= "
                // <tr style=\"background-color: #d3caba;\">
                //     <td><center><b><u>รวม</u></b></center></td>
                //      <td><center><b><u>$net_regis</u></b></center></td>
                //       <td><center><b><u>$net_learning</u></b></center></td>
                //        <td><center><b><u>$net_pass</u></b></center></td>
                //         <td><center><b><u>$net_total</u></b></center></td>
                //          <td><center><b><u>$net_percent_pass</u></b></center></td>
                //           <td><center><b><u>$net_test_pass</u></b></center></td>
                //            <td><center><b><u>$net_print</u></b></center></td>
                // </tr>
                // ";

                // $data .= "
                // <tr style=\"background-color: #d3caba;\">
                //     <td><center><b><u>รวม</u></b></center></td>
                //      <td><center><b><u>$net_regis</u></b></center></td>
                //       <td><center><b><u>$net_learning</u></b></center></td>
                //        <td><center><b><u>$net_pass</u></b></center></td>
                //          <td><center><b><u>$net_percent_pass</u></b></center></td>
                //           <td><center><b><u>$net_test_pass</u></b></center></td>
                //           <td><center><b><u>$net_test_fail</u></b></center></td>
                // </tr>
                // ";
                 echo $data;
                    }
                }
                if($net_total_all!=0){
                    $net_percent_pass_all = number_format($net_pass_all*100/$net_total_all, 2, '.', '');
                }
                ?>
                
                <!-- <tr style="background-color: #e476e8;">
                    <td><center><b><u>รวมทั้งหมด</u></b></center></td>
                     <td><center><b><u><?=$net_regis_all?></u></b></center></td>
                      <td><center><b><u><?=$net_learning_all?></u></b></center></td>
                       <td><center><b><u><?=$net_pass_all?></u></b></center></td> -->
                        <!-- <td><center><b><u><?=$net_total_all?></u></b></center></td> -->
                         <!-- <td><center><b><u><?=$net_percent_pass_all?></u></b></center></td>
                          <td><center><b><u><?=$net_test_pass_all?></u></b></center></td>
                          <td><center><b><u><?=$net_test_fail_all?></u></b></center></td> -->
                           <!-- <td><center><b><u><?=$net_print_all?></u></b></center></td> -->
                <!-- </tr> -->
                </tbody>
                <!-- // Table body END -->
            </table>
            <!-- // Table END -->
        </div>
