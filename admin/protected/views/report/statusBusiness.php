<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$titleName = 'รายงานผู้เรียนเฉพาะผู้ประกอบการ';
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
<div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
    <?php $this->renderPartial('search',array(
                'model'=>$model,
            )); ?>
    </div><!-- search-form -->
    <?php //var_dump($model); ?>
    <?php
    if($model->nameIdenSearch != '' || $model->course != '' || $model->generation != '' || $model->date_start != '' || $model->date_end != '') {
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE occupation='ธุรกิจส่วนตัว/เจ้าของกิจการ' AND status='1'";
        if($model->nameIdenSearch != ''){
            $search = explode(" ",$model->nameIdenSearch);
            $searchCount = count($search);
            foreach ($search as $key => $searchText) {
                $sqlUser .= "AND (username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%')";
                if($searchCount != $key+1){
                    $sqlUser .= " OR ";
                }
            }
        }

        if($model->generation != ''){
                $sqlUser .= " AND tbl_profiles.generation = '".$model->generation."' ";
        }

        if(($model->date_start != '') && ($model->date_end != '')){
                $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
                $endDate = date("Y-m-d H:i:s", strtotime($model->date_end));
                    if($startDate == $endDate){
                        $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
                    }
                $sqlUser .= " AND tbl_users.create_at between '".$startDate."' and '".$endDate."' ";
        }

        if($model->course != ''){
            $criteria=new CDbCriteria;
            $criteria->addInCondition('course_id', $model->course);
            $criteria->addCondition('active="y"');
            $criteria->order = 'sortOrder';
            $course = CourseOnline::model()->findAll($criteria);
        } else {
            $course = CourseOnline::model()->findAll(array('condition' => 'active = "y"','order'=>'sortOrder'));
        }

        $user = Yii::app()->db->createCommand($sqlUser)->queryAll();

        // var_dump($user);exit();
        if (!empty($user)) {
            ?>
            <div class="div-table">

                    <div class="widget" style="margin-top: -1px;">
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines">
                                <i></i>  รายงานผู้เรียนเฉพาะผู้ประกอบการ
                            </h4>
                        </div>
                        <div class="widget-body" style=" overflow-x: scroll;">
                            <!-- Table -->
                            <table class="table table-bordered table-striped">

                                <!-- Table heading -->
                                <thead>
                                <tr>
                                    <th rowspan="2" class="center">ลำดับ</th>
                                    <th rowspan="2" class="center">ชื่อนามสกุล</th>
                                    <th rowspan="2" class="center">เลขบัตรประชาชน</th>
            <?php
            foreach ($course as $key => $courseItem) {

                $lesson = Lesson::model()->findAll(array(
                    'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"',
                    'order' => 'title'
                ));
                if(count($lesson) > 0) {
            ?>
                                    <th colspan="<?= count($lesson) ?>" class="center"><?php echo $courseItem->course_title; ?></th>
            <?php
                }

            }
            ?>
                                </tr>
                                <tr>
            <?php
            foreach ($course as $key => $courseItem) {

                $lesson = Lesson::model()->findAll(array(
                    'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"',
                    'order' => 'title'
                ));

                if(count($lesson) > 0) {
            ?>
                                <?php foreach ($lesson as $key => $value) { ?>
                                    <th class="center"><?php echo $value->title; ?></th>
                                <?php } ?>
           <?php
                }

            }
            ?>
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
                                $i = 1;
                                foreach ($user as $key => $value) {
                                    /** @var Lesson $lessonItem */
                                    ?>
                                    <!-- Table row -->
                                    <tr>
                                        <!--<td class="center"><?php echo $orderNumber++; ?></td>-->
                                        <td class="center"><?php echo $i; ?></td>
                                        <td class="center"><?php echo $value['firstname'] . " " . $value['lastname']; ?></td>
                                        <td class="center" style='mso-number-format:\@;'><?php echo $value['bookkeeper_id'];?></td>
                                        <?php
            foreach ($course as $key => $courseItem) {

                $lesson = Lesson::model()->findAll(array(
                    'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"',
                    'order' => 'title'
                ));

                if(count($lesson) > 0) {
            ?>
                                        <?php foreach ($lesson as $data) { ?>
                                        <td class="center">
                                        <?php
                                            $learnStatus = Helpers::lib()->checkLessonPassByIdDate($data, $value['id'], $model->date_start,$model->date_end);
                                            echo $statusArray[$learnStatus];
                                        ?>
                                        </td>
                                        <?php } ?>
                                                 <?php
                }

            }
            ?>
                                    </tr>
                                    <!-- // Table row END -->
                                    <?php $i++;
                                }
                                ?>
                                </tbody>
                                <!-- // Table body END -->

                            </table>
                            <!-- // Table END -->

                        </div>

                    </div>

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
                <h3 class="text-success">กรุณากรอกข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3>
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
