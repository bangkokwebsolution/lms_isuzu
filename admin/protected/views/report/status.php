<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
 <!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<style>
    /*th {*/
        /*background-color: #5b2d90;*/
/*        color: white;*/
    /*}*/
</style>
<?php
$titleName = 'รายงานสถานะการเรียนของผู้เรียน';
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
    /**  */
    $userModel = Users::model()->findByPk(Yii::app()->user->id);
    $state = in_array("1",json_decode($userModel->group));

    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
//            array('name'=>'company_id','type'=>'list','query'=>Company::getCompanyList()),
//            array('name'=>'division_id','type'=>'list','query'=>Division::getDivisionList()),
//            array('name'=>'position_id','type'=>'list','query'=>Position::getPositionList()),
            array('name'=>'nameSearch','type'=>'text'),
//            array('name'=>'course','type'=>'list','query'=>$model->courseList),
            array('name'=>'dateRang','type'=>'text'),

            //array('name'=>'course_point','type'=>'text'),
        ),
    ));?>

    <?php

    if($model->nameSearch != '') {
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' AND ";
        $search = explode(" ",$model->nameSearch);
        $searchCount = count($search);
        $sqlUser .= "(";
        foreach ($search as $key => $searchText) {
            $sqlUser .= "(username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%')";
            if($searchCount != $key+1){
                $sqlUser .= " OR ";
            }
        }
        $sqlUser .= ")";

        $user = Yii::app()->db->createCommand($sqlUser)->queryAll();

        if (!empty($user)) {
            if(Yii::app()->user->isSuperuser == false) {
                // $userObj = Yii::app()->getModule('user')->user();
                // $model->typeOfUser = $userObj->authitem_name;
                // $owner_id = $userObj->id;
            }
            if(!$state){
                $course = CourseOnline::model()->findAll(array('condition' => 'active = "y" and lang_id = 1 and status = 1 and create_by = "'.Yii::app()->user->id.'"','order'=>'sortOrder'));
            }else{
                $course = CourseOnline::model()->findAll(array('condition' => 'active = "y" and lang_id = 1 and status = 1','order'=>'sortOrder'));
            }
            // $course = CourseOnline::model()->findAll(array('condition' => 'active = "y" and lang_id = 1 and status = 1','order'=>'sortOrder'));
            ?>
            <div class="div-table">
            <?php
            foreach ($course as $key => $courseItem) {
                if(!$state) {
                    $lesson = Lesson::model()->findAll(array(
                        'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.Yii::app()->user->id.'" and lang_id = 1',
                        'order' => 'lesson_no ASC'
                    ));
                }else{

                    $lesson = Lesson::model()->findAll(array(
                        'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"  and lang_id = 1',
                        'order' => 'lesson_no ASC'
                    ));


                }

                $chk_null_learn = [];
                foreach ($lesson as $key_chk => $val) {
                    $chk_null_learn[] = $val->id;
                }

                $criteria = new CDbCriteria();
                $criteria->compare('course_id',$courseItem->course_id);
                $criteria->compare('user_id',$user[0][user_id]);
                $criteria->compare('active',"y");
                $criteria->addInCondition('lesson_id', $chk_null_learn);
                $chk_learn = Learn::model()->findAll($criteria);


                if(count($lesson) > 0) {
                     if(count($chk_learn) > 0) {

                    ?>
                    <div class="widget" style="margin-top: -1px;">
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines">
                                <i></i> <?php echo $courseItem->course_title . " | " . $user[0][firstname] . " " . $user[0][lastname]; ?>
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
                                    <th class="center" style="width: 200px;background-color: #5b2d90;color: white;">สถานะการทำแบบทดสอบ</th>
                                </tr>
                                </thead>
                                <!-- // Table heading END -->

                                <!-- Table body -->
                                <tbody>
                                <?php


                                $orderNumber = 1;
                                $statusArray = array(
                                    'pass' => '<div style="color: green;"><strong>ผ่าน</strong></div>',
                                    'learning' => '<div style="color: #0000ff;"><strong>กำลังเรียน</strong></div>',
                                    'notLearn' => '<div style="color: red;"><strong>ไม่ได้เข้าเรียน</strong></div>',
                                );
                                foreach ($lesson as $lessonItem) {

                                $lern = Learn::model()->findAll(array(
                                    'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND lesson_id ="' . $lessonItem->id . '"  and user_id = "' . $user[0][user_id] . '"'
                                ));

                                if(count($lern) > 0){

                                    /** @var Lesson $lessonItem */
                                    ?>
                                    <!-- Table row -->
                                    <tr>
                                        <!--<td class="center"><?php echo $orderNumber++; ?></td>-->
                                        <td ><?php echo $lessonItem->title; ?></td>
                                        <td class="center"><?php 
                                        $learnStatus = Helpers::lib()->checkLessonPassById($lessonItem, $user[0]['id'], $model->dateRang);
                                        echo $statusArray[$learnStatus];
                                        ?></td>
                                        <td class="center"><?php echo Helpers::lib()->CheckTestCount($learnStatus, $lessonItem->id, true); ?></td>
                                    </tr>
                                    <!-- // Table row END -->
                                <?php } 

                            }?>



                                </tbody>
                                <!-- // Table body END -->

                            </table>
                            <!-- // Table END -->

                        </div>

                    </div>
                    <?php
                    }
                }
            }
            ?>
            </div>
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
            <?php
        }else{
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
    }else{
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
