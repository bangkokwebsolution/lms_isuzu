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


$_GET['Report'] = $model;

if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null && $_GET['Report']['gen_id'] != null){

    $search = $_GET['Report'];

    $course_online = CourseOnline::model()->findByPk($search["course_id"]);

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

    if(isset($_GET['Report']['type_register']) && $_GET['Report']['type_register'] != null) {
        $criteria->compare('pro.type_employee', $_GET['Report']['type_register']);
    }

    if(isset($_GET['Report']['department']) && $_GET['Report']['department'] != null) {
        $criteria->compare('user.department_id',$_GET['Report']['department']);
    }

    if(isset($_GET['Report']['position']) && $_GET['Report']['position'] != null) {
        $criteria->compare('user.position_id',$_GET['Report']['position']);
    }

    if(isset($_GET['Report']['level']) && $_GET['Report']['level'] != null) {
        $criteria->compare('user.branch_id', $_GET['Report']['level']);
    }

    if(isset($_GET['Report']['period_start']) && $_GET['Report']['period_start'] != null) {
        $criteria->compare('start_date >= "' . date('Y-m-d 00:00:00', strtotime($_GET['Report']['period_start'])) . '"');
    }
    if(isset($_GET['Report']['period_end']) && $_GET['Report']['period_end'] != null) {
        $criteria->compare('start_date <= "' . date('Y-m-d 23:59:59', strtotime($_GET['Report']['period_end'])) . '"');
    }

    $user_Learn = LogStartcourse::model()->findAll($criteria);


    $user_chk = array();
    foreach ($user_Learn as $key => $val) {
        if(isset($_GET['Report']['status_learn']) && $_GET['Report']['status_learn'] != null){
            $statusLearn =  Helpers::lib()->chk_status_course($_GET['Report']['course_id'], $_GET['Report']['gen_id'], $val->user_id);

                if($_GET['Report']['status_learn'] == 1){ // ยังไม่เรียน
                    if($statusLearn == "notlearn"){
                        $user_chk[] = $val->user_id;
                    }
                }elseif($_GET['Report']['status_learn'] == 2){ //กำลังเรียน
                    if($statusLearn == "learning"){
                        $user_chk[] = $val->user_id;
                    }
                }elseif($_GET['Report']['status_learn'] == 3){ //เรียนสำเร็จ
                    if($statusLearn == "pass"){
                        $user_chk[] = $val->user_id;
                    }
                }
            }else{
                $user_chk[] = $val->user_id;
            }
        }

    if(count($user_chk) == 0){
        $user_chk = array(0);
    } 

    $allUsers = User::model()->with('profile')->findAll(array(
        'condition' => 'status ="1" and user.id IN ('.implode(",",$user_chk).')',
        'order' => 'profile.firstname_en ASC'
    ));




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
                    <h4 class="heading glyphicons show_thumbnails_with_lines">ค้นหาโดยใช้หลักสูตร</h4>
                </div>
            </div>
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ประเภทพนักงาน</th>                            
                            <th>Name - Surname</th>
                            <th>ชื่อ – นามสกุล</th>
                            <th>เลขบัตรประชาชน</th>
                            <th>เลขพาสปอร์ต</th>
                            <th>รหัสพนักงานออฟฟิศ</th>
                            <th>แผนก/ฝ่าย</th>
                            <th>ตำแหน่ง/แผนก</th>
                            <th>ระดับตำแหน่ง</th>
                            <th class="center">หลักสูตร</th>
                            <th class="center">สถานะ</th>
                            <th class="center">ผลการเรียน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>array(
                                'pageSize'=>25
                                ),
                        ));

                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }
                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                            $gen_title = "";
                            if($_GET['Report']['gen_id'] != 0){
                                $gen_title = CourseGeneration::model()->findByPk($_GET['Report']['gen_id']);
                                $gen_title = " รุ่น ".$gen_title->gen_title;
                            }

                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {

                                    ?>
                                   <tr>
                                        <td><?= $start_cnt+1?></td>
                                        <td><?= $user->profile->typeEmployee->type_employee_name; ?></td>
                                        <td><?= $user->profile->firstname_en . ' ' . $user->profile->lastname_en ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->profile->identification ?></td>
                                        <td><?php if($user->profile->type_employee == 1){ echo $user->username; } ?></td>
                                        <td><?php if($user->profile->type_employee == 2){ echo $user->username; } ?></td>
                                        <td><?= $user->department->dep_title ?></td>
                                        <td><?= $user->position->position_title ?></td>
                                        <td><?= $user->branch->branch_name ?></td>
                                        <td class="center"><?= $course_online->course_title.$gen_title ?></td>
                                        <?php
                                           if($course_online) {

                                            $statusLearn =  Helpers::lib()->chk_status_course($course_online->course_id, $_GET['Report']['gen_id'], $user->id);

                                                    ?>
                                        <td class="center">
                                         <?= $statusArray[$statusLearn]?>
                                         <?php 
                                         if($statusLearn == "learning"){
                                            echo Helpers::lib()->percent_CourseGen($course_online->course_id, $_GET['Report']['gen_id'], $user->id)." %";
                                        }
                                        ?>
                                        </td>

                                    <?php } ?>
                                    <td>
                                        <?php 
                                        $chk_final_score = Coursescore::model()->find("course_id='".$course_online->course_id."' AND gen_id='".$_GET['Report']['gen_id']."' AND user_id='".$user->id."' AND type='post' AND active='y' ORDER BY score_id DESC");

                                        if($chk_final_score){
                                            // echo $chk_final_score->score_id;
                                            if($chk_final_score->score_past == "y"){
                                                $passcourse = Passcours::model()->find("passcours_cours='".$course_online->course_id."' AND passcours_user='".$user->id."' AND gen_id='".$_GET['Report']['gen_id']."' ");

                                                echo "<center><b>ผ่าน</b></center> คะแนน ".$chk_final_score->score_number."/".$chk_final_score->score_total;
                                                echo "<br>วันที่เรียนจบ ".date("d/m/Y", strtotime($passcourse->passcours_date));
                                            }elseif($chk_final_score->score_past == "n"){
                                                echo "ไม่ผ่าน คะแนน ".$chk_final_score->score_number."/".$chk_final_score->score_total;
                                            }
                                        }

                                         ?>
                                        
                                    </td>
                                    </tr>
                                    <?php
                                    $start_cnt++;
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
                
            </div>
        </div>




<?php } ?>