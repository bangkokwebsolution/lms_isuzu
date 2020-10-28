<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>

<?php
$titleName = 'ข้อมูลการฝึกอบรมของพนักงานรายบุคคล';

$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');
	$('#Report_dateRang').daterangepicker();

EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">

<?php 

    // $userModel = Users::model()->findByPk(Yii::app()->user->id);
    // $state = in_array("1",json_decode($userModel->group));

    $userModel = Users::model()->findByPk(Yii::app()->user->id);
    $state = Helpers::lib()->getStatePermission($userModel);



    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'nameSearch','type'=>'text'),
            array('name'=>'dateRang','type'=>'text'),
        ),
    ));?>

    <?php


    if($model->nameSearch != '') {
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' AND superuser='0' AND ";
        $search = explode(" ",$model->nameSearch);
        $searchCount = count($search);
        $sqlUser .= "(";


        $sqlUser .= "(";
        if(isset($search[0])){
            $sqlUser .= " ( firstname LIKE '%" . trim($search[0]) . "%' OR firstname_en LIKE '%" . trim($search[0]) . "%' ) ";
        }
         if(isset($search[1])){
            $sqlUser .= " AND ( lastname LIKE '%" . trim($search[1]) . "%' OR lastname_en LIKE '%" . trim($search[1]) . "%' ) ";
        }

        $sqlUser .= ")";



        // foreach ($search as $key => $searchText) {
        //     // username LIKE '%" . trim($searchText) . "%' OR
        //     $sqlUser .= "( firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%' OR firstname_en LIKE '%" . trim($searchText) . "%' OR lastname_en LIKE '%" . trim($searchText) . "%')";
        //     if($searchCount != $key+1){
        //         $sqlUser .= " OR ";
        //     }
        // }
        $sqlUser .= ")";

        $user = Yii::app()->db->createCommand($sqlUser)->queryAll();

        // var_dump($sqlUser);
        // var_dump($user);
        //  exit();



        if (!empty($user)) {
            ?>
                    <h3>
                        ชื่อ : <?php echo $user[0][firstname] . " " . $user[0][lastname]; ?>
                    </h3>
                    <br>
                <?php

            if(!$state){
                $course = CourseOnline::model()->findAll(array('condition' => 'active = "y" and lang_id = 1 and status = 1 and create_by = "'.Yii::app()->user->id.'"','order'=>'course_title'));
            }else{
                $course = CourseOnline::model()->findAll(array('condition' => 'active = "y" and lang_id = 1 and status = 1','order'=>'course_title'));
            }


            ?>
            <div class="div-table">
            <?php
            $no_course = 1;
            foreach ($course as $key => $courseItem) {

                if(!$state) {
                    $lesson = Lesson::model()->findAll(array(
                        'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.Yii::app()->user->id.'" and lang_id = 1',
                        'order' => 'title ASC'
                    ));
                }else{

                    $lesson = Lesson::model()->findAll(array(
                        'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"  and lang_id = 1',
                        'order' => 'title ASC'
                    ));


                }

                $chk_null_learn = [];
                foreach ($lesson as $key_chk => $val) {
                    $chk_null_learn[] = $val->id;
                }

                $criteria = new CDbCriteria();
                $criteria->compare('course_id',$courseItem->course_id);
                $criteria->compare('user_id',$user[0][user_id]);
                $criteria->compare('lesson_active',"y");
                $criteria->addInCondition('lesson_id', $chk_null_learn);
                $chk_learn = Learn::model()->findAll($criteria);


                if(count($lesson) > 0) {
                     if(count($chk_learn) > 0) {

                    ?>
                    <div class="widget" style="margin-top: -1px;">
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines">
                                <i></i> <?php echo $no_course.".) หลักสูตร ".$courseItem->course_title; $no_course++; // . " | " . $user[0][firstname] . " " . $user[0][lastname] ?>
                            </h4>
                        </div>
                        <div class="widget-body">
                            <!-- Table -->
                            <table class="table table-bordered table-striped">

                                <!-- Table heading -->
                                <thead>
                                <tr>
                                    <!--                                <th class="center" style="width: 80px;">ลำดับ</th>-->
                                    <th style="min-width: 120px;background-color: #5b2d90;color: white;" class="center">หัวข้อ</th>
                                    <th class="center" style="width: 100px;background-color: #5b2d90;color: white;">สถานะการเรียน</th>
                                    <th class="center" style="width: 200px;background-color: #5b2d90;color: white;">ผลการเรียน</th>
                                </tr>
                                </thead>
                                <!-- // Table heading END -->

                                <!-- Table body -->
                                <tbody>
                                <?php


                                $orderNumber = 1;
                                $statusArray = array(
                                    'pass' => '<div style="color: green;"><strong>เรียนสำเร็จ</strong></div>',
                                    'learning' => '<div style="color: #0000ff;"><strong>กำลังเรียน</strong></div>',
                                    'notLearn' => '<div style="color: red;"><strong>ยังไม่เรียน</strong></div>',
                                );

                                $course_gen = CourseGeneration::model()->findAll(array(
                                        'condition' => 'course_id=:course_id AND active=:active ',
                                        'params' => array(':course_id'=>$courseItem->course_id, ':active'=>"y"),
                                        'order' => 'gen_title ASC',
                                    ));

                                    if(empty($course_gen)){
                                        $course_gen[]->gen_id = 0;
                                    }
                                    foreach ($course_gen as $key => $genn) {
                                        $text_gen = "";
                                        if($genn->gen_id != 0){
                                            $text_gen = "<b> รุ่น ".$genn->gen_title."</b>";
                                        }


                                foreach ($lesson as $lessonItem) {
                                    


                                        $lern = Learn::model()->findAll(array(
                                            'condition' => 'gen_id="'.$genn->gen_id.'" AND course_id = "' . $courseItem->course_id . '" AND lesson_active ="y" AND lesson_id ="' . $lessonItem->id . '"  and user_id = "' . $user[0][user_id] . '"'
                                        ));

                                        // if(count($lern) > 0){

                                            /** @var Lesson $lessonItem */
                                            ?>
                                            <!-- Table row -->
                                            <tr>
                                                <td ><?php echo $lessonItem->title.$text_gen; ?></td>
                                                <td class="center">
                                                    <?php 
                                                    $learnStatus = Helpers::lib()->checkLessonPassById($lessonItem, $user[0]['id'], $model->dateRang);
                                                    echo $statusArray[$learnStatus];
                                                    ?>
                                                </td>
                                                <td class="center">
                                                    <?php echo Helpers::lib()->CheckTestCount($learnStatus, $lessonItem->id, true, true, $user[0][user_id]); ?>
                                                </td>
                                            </tr>
                                            <!-- // Table row END -->
                                        <?php //}                         
                           

 
                            } // lesson


                            $score_final = Coursescore::model()->find("course_id='".$courseItem->course_id."' AND user_id='".$user[0][user_id]."' AND gen_id='".$genn->gen_id."' AND type='post' AND active='y' ORDER BY score_id DESC");

                            $passcourse = Passcours::model()->find("passcours_cours='".$courseItem->course_id."' AND passcours_user='".$user[0][user_id]."' AND gen_id='".$genn->gen_id."' ");

                             ?>
                            <tr>
                                <td colspan="3" style="background-color: #d687ff54;">
                                    <font size="5">ผลการเรียน: </font>
                                    <font size="4">
                                    <?php 
                                    if($score_final != ""){
                                        echo '<font color="green">'."ผ่าน </font> |คะแนน ".$score_final->score_number."/".$score_final->score_total;

                                        if($passcourse != ""){
                                            echo " | วันที่เรียนจบ ".date("d/m/Y", strtotime($passcourse->passcours_date));


                                            echo " | ";
                                            $passcourse_log = PasscoursLog::model()->find("pclog_target='".$passcourse->passcours_id."' AND pclog_userid='".$user[0][user_id]."' AND gen_id='".$genn->gen_id."' ");
                                            if($passcourse_log != ""){
                                                echo '<font color="green">'."พิมพ์ใบประกาศนียบัตรแล้ว </font>";
                                            }else{
                                                echo "ยังไม่พิมพ์ใบประกาศนียบัตร";                                                
                                            }
                                        }

                                    }else{
                                        echo '<font color="red">'."ไม่ผ่าน".'</font> | <font color="orange">กำลังเรียน ';
                                        echo Helpers::lib()->percent_CourseGen($courseItem->course_id, $genn->gen_id, $user[0][user_id])." % </font>";
                                    }

                                     ?>
                                     </font>
                                </td>
                            </tr>

                            <?php

                             } // gen
                            ?>



                                </tbody>
                                <!-- // Table body END -->

                            </table>
                            <!-- // Table END -->

                        </div>

                    </div>
                    <hr>
                    <br>
                    <?php
                    } // if(count($chk_learn) > 0) {
                        
                } // // if(count($lesson) > 0) {
                
                     
            } // foreach
            ?>
            </div>
            <!-- <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button> -->
            <?php
        }else{ // if (!empty($user)) {
            ?>
            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                </div>
                <div class="widget-body">
                    <!-- Table -->
                    <h3 style="color: red;">ไม่พบข้อมูล</h3>
                    <!-- // Table END -->
                </div>
            </div>
    <?php
        }
    }else{ //  if($model->nameSearch != '') {
        ?>
        <div class="widget" style="margin-top: -1px;">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines">
                    <i></i> </h4>
            </div>
            <div class="widget-body">
                <!-- Table -->
                <h3 class="text-success">กรุณาใส่ ชื่อ - นามสกุล แล้วกด ปุ่มค้นหา</h3>
                <!-- // Table END -->
            </div>
        </div>
        <?php
    }

Yii::app()->clientScript->registerScript('export', "

  $(function(){
      $('#btnExport').click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()));
        e.preventDefault();
      });
      $('.div-table a').attr('href','#');
  });

", CClientScript::POS_END);
    ?>
</div>
<script>
    $(document).ready(function(){
        
        $(".chosen").chosen();
        
});
</script>
