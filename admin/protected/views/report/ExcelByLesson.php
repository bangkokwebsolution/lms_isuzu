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

    $criteria->compare('user.superuser', 0);

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

    if(isset($_GET['Report']['period_start']) && $_GET['Report']['period_start'] != null) {
        $criteria->compare('start_date >= "' . date('Y-m-d 00:00:00', strtotime($_GET['Report']['period_start'])) . '"');
    }
    if(isset($_GET['Report']['period_end']) && $_GET['Report']['period_end'] != null) {
        $criteria->compare('start_date <= "' . date('Y-m-d 23:59:59', strtotime($_GET['Report']['period_end'])) . '"');
    }

    $user_Learn = LogStartcourse::model()->findAll($criteria);

    $user_chk = array();
    foreach ($user_Learn as $key => $val) {
        if($val->user_id != ""){
            $user_chk[] = $val->user_id;
        }
    }

    if(count($user_chk) == 0){
        $user_chk = array(0);
    } 

    $allUsers = User::model()->with('profile')->findAll(array(
        'condition' => 'status ="1" and user.id IN ('.implode(",", $user_chk).')',
        'order' => 'profile.firstname_en ASC'
    ));


    if(isset($_GET['Report']['lesson_id']) && $_GET['Report']['lesson_id'] != null) {

     $lesson_online = Lesson::model()->findAll("active='y' AND id='".$_GET['Report']['lesson_id']."' AND course_id='".$search["course_id"]."'");

 }else{
  $lesson_online = Lesson::model()->findAll(array(
    "condition"=>"active='y' AND lang_id='1' AND course_id='".$search["course_id"]."'",
    "order"=>"title ASC"
));
}

$gen_title = "";
if($_GET['Report']['gen_id'] != 0){
    $gen_title = CourseGeneration::model()->findByPk($_GET['Report']['gen_id']);
    $gen_title = " รุ่น ".$gen_title->gen_title;
}




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
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> ค้นหาโดยใช้บทเรียน</h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ประเภทพนักงาน</th>                            
                            <th rowspan="2">Name - Surname</th>
                            <th rowspan="2">แผนก/ฝ่าย</th>
                            <th rowspan="2">ตำแหน่ง/แผนก</th>
                            <th class="center" colspan="<?= count($lesson_online)+1 ?>">หลักสูตร <?= $course_online->course_title.$gen_title ?></th>
                        </tr>
                        <tr>
                            <?php foreach($lesson_online as $lesson) { ?>
                                <th class="center"><?= $lesson->title ?></th>
                            <?php } ?>
                            <th class="center">Percent</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        if(!empty($allUsers)){
                            
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

                            if($dataProvider->getData()) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $user->profile->typeEmployee->type_employee_name; ?></td>
                                        <td><?= $user->profile->firstname_en . ' ' . $user->profile->lastname_en ?></td>
                                        <td><?= $user->department->dep_title ?></td>
                                        <td><?= $user->position->position_title ?></td>
                                        <?php
                                           if($lesson_online) {
                                                foreach($lesson_online as $lesson) {
                                                    $statusLearn_course =  Helpers::lib()->chk_status_course($course_online->course_id, $_GET['Report']['gen_id'], $user->id);

                                                        ?>
                                                        <td class="center" <?php if($statusLearn_course != "learning"){ echo 'colspan="'.count($lesson_online).'"'; } ?>>
                                                            <?php 
                                                            if($statusLearn_course != "learning"){
                                                                echo $statusArray[$statusLearn_course];
                                                            }else{
                                                                $statusLearn_lesson =  Helpers::lib()->chk_status_lesson($lesson->id, $_GET['Report']['gen_id'], $user->id);
                                                                echo $statusArray[$statusLearn_lesson];
                                                            }
                                                             ?>
                                                        </td>
                                                        <?php
                                                        if($statusLearn_course != "learning"){
                                                            break;
                                                        }
                                                }
                                           }
                                        ?>
                                        <td class="center">
                                            <?php 
                                            if($statusLearn_course != "pass"){
                                                echo Helpers::lib()->percent_CourseGen($course_online->course_id, $_GET['Report']['gen_id'], $user->id)." %"; 
                                            }else{
                                                echo "-";
                                            }
                                            ?>
                                        </td>
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
                    <?php } ?>
                    </tbody>
                </table>






                
            </div>
        </div>





<?php }  ?>