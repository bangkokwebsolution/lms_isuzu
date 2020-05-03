
<?php
$title = 'รายงานผู้เรียนตามรายหลักสูตร';
$currentModel = 'Report';
// require_once('mpdf/mpdf.php');
ob_start();



$this->breadcrumbs = array($title);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');

EOD
, CClientScript::POS_READY);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(function() {
        // $('#courseSelectMulti').select2();
        $(".chosen").chosen();
        $(".widget-body").css("overflow","");
        $("#Report_period_start").datepicker({
                // numberOfMonths: 2,
                onSelect: function(selected) {
                  $("#Report_period_end").datepicker("option","minDate", selected)
              }
          });
        $("#Report_period_end").datepicker({
                // numberOfMonths: 2,
                onSelect: function(selected) {
                 $("#Report_period_start").datepicker("option","maxDate", selected)
             }
         }); 

        var selectedVal = $( "#Report_course_id option:selected" ).val();
        if(selectedVal != ''){
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('Report/ListSchedule');?>",
                data:{ course_id:selectedVal},
                success: function(data) {
                    $('#Report_schedule_id').empty(); 
                    $('#Report_schedule_id').append(data); 
                    $('.chosen').trigger("chosen:updated");
                }
            }); 
        }
        


        $("#Report_course_id").change(function(){
            var course_id =  $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('Report/ListSchedule');?>",
                data:{ course_id:course_id},
                success: function(data) {
                    $('#Report_schedule_id').empty(); 
                    $('#Report_schedule_id').append(data); 
                    $('.chosen').trigger("chosen:updated");
                }
            });
        });

        endDate();
        startDate();
      //   $('#btnExport').click(function(e) {
      //       window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2><?= $title ?></h2>'+$('#export-table').html()));
      //       e.preventDefault();
      //   });
      // $('.div-table a').attr('href','#')+" ";
    });

    function startDate() {
        $('#passcoursStartDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function() {
                $("#passcoursEndDateBtn").datepicker("option","minDate", this.value);
            },
        });
    }
    function endDate() {
        $('#passcoursEndDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
        });
    }

</script>

<div class="innerLR">

    <?php
    /**  */
    $type_user[1] = 'บุคลากรทั่วไป';
    $type_user[2] = 'บุคลากรภายใน';

    $divisiondata = Division::model()->getDivisionListNew(); 
    $departmentdata = Department::model()->getDepartmentListNew();
    $stationdata = Station::model()->getStationList();


    $userModel = Users::model()->findByPk(Yii::app()->user->id);
    $state = Helpers::lib()->getStatePermission($userModel);
    if($state){
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    }

    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array(
                'type'=>'list',
                'name'=>'course_id',
                'query'=>CHtml::listData($modelCourse,'course_id', 'course_title')
            ),
            array(
                'type'=>'list',
                'name'=>'schedule_id',
                'query'=> ''
            ),
            array('name'=>'type_user','type'=>'list','query'=>$type_user),
            array('name'=>'search','type'=>'text','placeholder'=>'สามารถค้นหาด้วย ชื่อ, สกุล และอีเมลล์'),
           
            //array('name'=>'division_id','type'=>'listMultiple','query'=>$divisiondata),
            array('name'=>'department','type'=>'listMultiple','query'=>$departmentdata),
            //array('name'=>'station','type'=>'listMultiple','query'=>$stationdata),

            array('name'=>'period_start','type'=>'text'),
            array('name'=>'period_end','type'=>'text'),

        ),
    ));?>

<!-- <div class="innerLR">
	<div class="widget">
		<div class="widget-head">
			<h4 class="heading glyphicons search">
				<i></i> High Search:
			</h4>
		</div> -->
		<?php 
			// $form = $this->beginWidget('CActiveForm',
			// 	array(
			// 		'action'=>Yii::app()->createUrl($this->route),
			// 		'method'=>'get',
			// 	)
			// ); 
		?>
		<!-- <div class="widget-body">
			<dl class="dl-horizontal">
                 <div class="form-group">
                <dt><label>เลือกรุ่น : </label></dt>
                <dd>
                    <select name="ByCourse[generation]">
                        <option value="">--- รุ่นทั้งหมด ---</option>
                        <?php
                            $Generation = Generation::model()->findAll();
                            if($Generation) {
                                foreach($Generation as $gen) {
                                    ?>
                                    <option value="<?= $gen->id_gen ?>"><?= $gen->name ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                <option value="">ยังไม่มีรุ่นการเรียน</option>
                                <?php
                            }
                        ?>
                    </select>
                </dd>
            </div>
            <div class="form-group">
                <dt><label>เลือกหลักสูตร : </label></dt>
                <dd>
                    <select name="ByCourse[course_id][]" multiple style="width: 50%; height: 150px;" id="courseSelectMulti">
                    <?php
                        $CourseOnline = CourseOnline::model()->findAll(array(
                            'condition' => 'active = "y"',
                            'order' => 'cate_id ASC, cate_course ASC, course_id ASC'
                            )
                        );
                        $curr_supper_cate = null;
                        $curr_course_cate = null;
                        if($CourseOnline) {
                            foreach($CourseOnline as $Course) {
                                if($curr_course_cate != $Course->cate_course && $curr_course_cate != null) {
                                        ?>
                                        </optgroup>
                                        <?php
                                    }
                                if($curr_supper_cate != $Course->cate_id && $curr_supper_cate != null) {
                                    ?>
                                    </optgroup>
                                    <?php
                                }
                                if($curr_supper_cate != $Course->cate_id) {
                                    $curr_supper_cate = $Course->cate_id;
                                    ?>
                                    <optgroup label="<?=  $Course->cates->cate_title ?>">
                                    <?php
                                }
                                if($Course->cate_course != null && $curr_course_cate != $Course->cate_course) {
                                    $curr_course_cate = $Course->cate_course;
                                    ?>
                                    <optgroup label="-- <?=  $Course->category->name ?>" style="margin-left: 14px; ">
                                    <?php
                                }
                                ?>
                                <option value="<?= $Course->course_id ?>"><?= $Course->course_title ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="">ยังไม่มีบทเรียน</option>
                            <?php
                        }
                    ?>
                    </select>
                </dd>
            </div>
            <div class="form-group">
					<dt><label>ค้นหา : </label></dt>
					<dd>
						<div style="padding-bottom: 10px;">
							<input name="ByCourse[search]" type="text" value="" placeholder="สามารถค้นหาด้วย ชื่อ, สกุล และบัตรประชาชน">
							<span style="font-size: 0.9em; color: red;">(สามารถค้นหาด้วย ชื่อ, สกุล และบัตรประชาชน)</span>
						</div>
					</dd>
				</div>
            <div class="form-group">
                <dt><label>วันที่เริ่มต้น - วันที่สิ้นสุด : </label></dt>
                <dd>
                    <input name="ByCourse[period_start]" type="text" class="form-control" placeholder="เลือกช่วงเวลาเริ่ม" id="passcoursStartDateBtn"> : <input name="ByCourse[period_end]" type="text" class="form-control" placeholder="เลือกช่วงเวลาสิ้นสุด" id="passcoursEndDateBtn">
                </dd>
            </div>
				<div class="form-group">
					<dt></dt>
					<dd><button type="submit" class="btn btn-primary btn-icon glyphicons search"><i></i> Search</button></dd>
				</div>
			</dl>
		</div> -->
	<?php //$this->endWidget(); ?>
	</div>
    <?php
        // $search = $_GET['ByCourse'];
        $search = $_GET['Report'];
        $textsearch = ($search['search']!=null)?'and email like "%'.$search['search'].'%" or profile.firstname like "%'.$search['search'].'%" or profile.lastname like "%'.$search['search'].'%"':null;

        //type_user
        $searchTyprUser = $search['type_user'];
        if( !empty($searchTyprUser)) {
                if($searchTyprUser == 1){ //General
                    $texttype .= " AND type_register != '3' ";
                }else if($searchTyprUser == 2){ //Staff
                    $texttype .= " AND type_register = '3' ";

                }
                // $sqlUser .= " AND tbl_profiles.type_user LIKE '".$model->type_user."' ";
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


        $searchCourse = $search['course_id'];
        if(!empty($searchCourse)){
           $searchCourseArray = implode(',', $searchCourse);
           $sqlCourseQuery = ($searchCourseArray!='')?' and course_id in ('.$searchCourseArray.')':null;
           $SQLsearchCourse = ' and course_id = '.$searchCourse;
       }else{
            $SQLsearchCourse = '';
       }
       

        //generation
        $searchGeneration = $search['generation'];
        $gen = ($searchGeneration!='')?' and generation = "'. $searchGeneration . '"':null;

        //period
        $period_start = ($search['period_start'])?date('Y-m-d 00:00:00', strtotime($search['period_start'])):null;
        $period_end = ($search['period_end'])?date('Y-m-d 23:59:59', strtotime($search['period_end'])):null;
        
        $startdate = ($period_start)?' and learn.create_date >= "'. $period_start .'"':null;
        $enddate = ($period_end)?' and learn.create_date <= "'. $period_end .'"':null;




        // $course_online = CourseOnline::model()->findAll(array(
        //     'condition' => 'lang_id = 1 and active = "y" and status = "1"' . $sqlCourseQuery,
        //     'order' => 'course_id ASC'
        // ));
        $course_online = CourseOnline::model()->findAll(array(
            'condition' => 'lang_id = 1 and active = "y" and status = "1" '.$SQLsearchCourse,
            'order' => 'course_id ASC'
        ));
        $course_count = ($course_online)?count($course_online):0;
    ?>
	<!-- END HIGH SEARCH -->
        <div class="widget hidden" id="export-table" style=" overflow-x: scroll;">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' ถึงวันที่ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2">อีเมลล์</th>
                            <th colspan="<?= $course_count?>" class="center">รายหลักสูตร</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($course_online as $course) {
                                   ?>
                                <th style="writing-mode: tb-rl;"><?= $course['course_title'] ?></th>
                                   <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                             $user_Learn = Learn::model()->findAll(array(
                                    'condition' => 'course_id ="'. $course['course_id'] .'" and (lesson_status ="pass" or lesson_status ="learning")',
                                    'group'=>'user_id',
                                ));

                         $user_chk = array();
                         foreach ($user_Learn as $key => $val) {

                              $user_chk[] = $val->user_id;
                         }
                         if(count($user_chk) == 0){
                             $user_chk = array(0);
                        } 

                        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){
                            $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1" and user.id IN ('.implode(",",$user_chk).')'  . $gen . $textsearch.$texttype,
                            ));
                        }else{
                           $allUsers = User::model()->with('profile')->findAll(array(
                            'condition' => 'status ="1"' . $gen . $textsearch .$texttype,
                        ));
                       }

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

                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {

                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email ?>&nbsp;</td>
                                        <?php
                                           if($course_online) {
                                                foreach($course_online as $course) {
                                                    $statusLearn = Learn::model()->with('les')->find(array(
                                                        'condition' => 'user_id ="'.$user['id'].'" and learn.course_id ="'. $course['course_id'] .'"' . $startdate . $enddate . $startdate_schedule .$enddate_schedule,
                                                        'alias' => 'learn'
                                                    ));
                                                $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 
                                                        'pass' => '<b style="color: blue;">ผ่าน</b>',
                                                        'notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
                                                    ?>
                                                    <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?></td>
                                                    <?php
                                                }
                                           }
                                        ?>
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
        <?php 
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
        <div class="widget" id="export-table33" style=" overflow-x: scroll;">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' ถึงวันที่ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2">อีเมลล์</th>
                            <th colspan="<?= $course_count?>" class="center">รายหลักสูตร</th>
                          <?php   if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){ ?>
                            <th rowspan="2" class="center">วันที่ผ่านหลักสูตร</th>
                        <?php } ?>
                        </tr>
                        <tr>
                            <?php
                                foreach($course_online as $course) {
                                   ?>
                                <th style="writing-mode: tb-rl;"><?= $course['course_title'] ?></th>
                                   <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                         $user_Learn = Learn::model()->findAll(array(
                                    'condition' => 'course_id ="'. $course['course_id'] .'" and (lesson_status ="pass" or lesson_status ="learning")',
                                    'group'=>'user_id',
                                ));

                         $user_chk = array();
                         foreach ($user_Learn as $key => $val) {

                              $user_chk[] = $val->user_id;
                         }
                         if(count($user_chk) == 0){
                             $user_chk = array(0);
                        } 

                        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){
                            $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1" and user.id IN ('.implode(",",$user_chk).')'  . $gen . $textsearch.$texttype,
                            ));
                        }else{
                         $allUsers = User::model()->with('profile')->findAll(array(
                            'condition' => 'status ="1"' . $gen . $textsearch .$texttype,
                        ));
                     }

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


                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {

                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email ?></td>
                                        <?php
                                           if($course_online) {
                                                foreach($course_online as $course) {
                                                    $statusLearn = Learn::model()->with('les')->find(array(
                                                        'condition' => 'user_id ="'.$user['id'].'" and learn.course_id ="'. $course['course_id'] .'"' . $startdate . $enddate . $startdate_schedule.$enddate_schedule,
                                                        'alias' => 'learn'
                                                    ));
                                                    $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 'pass' => '<b style="color: blue;">ผ่าน</b>','notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
                                                    ?>
                                                    <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?></td>

                                                    <?php   if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){ ?>
                                                     <td class="center"><?= $statusLearn['learn_date']; ?></td>
                                                 <?php } ?>

                                                    <?php
                                                }
                                           }
                                        ?>
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
                <?php 
                    // $this->widget('CLinkPager',array(
                    //                 'pages'=>$dataProvider->pagination
                    //                 )
                    //             );
                ?>
            </div>
        </div>
        <div class="widget-body">

            <a href="<?= $this->createUrl('report/genExcelByCourse',array(
            'Report[generation]'=>$_GET['Report']['generation'],
            'Report[course_id]'=>$_GET['Report']['course_id'],
            'Report[search]'=>$_GET['Report']['search'],
            'Report[period_start]'=>$_GET['Report']['period_start'],
            'Report[type_user]'=>$_GET['Report']['type_user'],
            'Report[schedule_id]'=>$_GET['Report']['schedule_id'],
            'Report[division_id]'=>$_GET['Report']['division_id'],
            'Report[department]'=>$_GET['Report']['department'],
            'Report[station]'=>$_GET['Report']['station'],
            'Report[period_end]'=>$_GET['Report']['period_end'])); ?>" 
            target="_blank">

		    <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a>


            <!-- <a href="<?= $this->createUrl('report/genPdfByCourse',array('ByCourse[generation]'=>$_GET['ByCourse']['generation'],'ByCourse[course_id]'=>$_GET['ByCourse']['course_id'],'ByCourse[search]'=>$_GET['ByCourse']['search'],'ByCourse[period_start]'=>$_GET['ByCourse']['period_start'],'ByCourse[period_end]'=>$_GET['ByCourse']['period_end'])); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a> -->

            <a href="<?= $this->createUrl('report/genPdfByCourse',array(
            'Report[generation]'=>$_GET['Report']['generation'],
            'Report[course_id]'=>$_GET['Report']['course_id'],
            'Report[search]'=>$_GET['Report']['search'],
            'Report[period_start]'=>$_GET['Report']['period_start'],

            'Report[type_user]'=>$_GET['Report']['type_user'],
            'Report[schedule_id]'=>$_GET['Report']['schedule_id'],
            'Report[division_id]'=>$_GET['Report']['division_id'],
            'Report[department]'=>$_GET['Report']['department'],
            'Report[station]'=>$_GET['Report']['station'],

            'Report[period_end]'=>$_GET['Report']['period_end'])); ?>" 
            target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a>
             <!-- <button type="button" id="btnExportPdf" class="btn btn-primary btn-icon glyphicons file"> <i></i>ExportPDF</button> -->
	    </div>
</div>


<script type="text/javascript">

    var x =  '<h2>'+'<?php echo $title; ?>'+'</h2>'+$('#export-table').html();
    $("#btnExportPdf").click(function() {
        $.ajax({
  url: "<?= Yii::app()->createUrl('report/genpdf'); ?>",
  type: "POST",
  data: {param:x},
  success: function(data){
    // alert(data);
  },
});
    });
</script>