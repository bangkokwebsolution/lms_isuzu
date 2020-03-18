<?php
$title = 'รายงานผู้เรียนรายบุคคล';
$currentModel = 'Report';

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

<div class="innerLR">
	<!-- START HIGH SEARCH -->
    <?php
        // $Generation = Generation::model()->findAll();
        // $listGeneration = CHtml::listData($Generation,'id_gen','name');

        $userModel = Users::model()->findByPk(Yii::app()->user->id);
        $state = Helpers::lib()->getStatePermission($userModel);

        $type_user[1] = 'บุคลากรทั่วไป';
        $type_user[2] = 'บุคลากรภายใน';

        $divisiondata = Division::model()->getDivisionListNew(); 
        $departmentdata = Department::model()->getDepartmentListNew();
        $stationdata = Station::model()->getStationList();


        if($state){
            $CourseOnline = CourseOnline::model()->findAll(array(
                'condition' => 'active = "y" AND lang_id = 1',
                'order' => 'course_id DESC'
            ));
            $LessonAll = Lesson::model()->findAll(array('condition' => 'active = "y" and lang_id = 1','order' => 'lesson_no ASC'));
        }else{
            $CourseOnline = CourseOnline::model()->findAll(array(
                'condition' => 'active = "y" AND lang_id = 1 AND create_by = "'.Yii::app()->user->id.'"',
                'order' => 'course_id DESC'
            ));
            $LessonAll = Lesson::model()->findAll(array('condition' => 'active = "y" and lang_id = 1 and create_by = "'.Yii::app()->user->id.'"','order' => 'lesson_no ASC'));
        }
        $listCourse = CHtml::listData($CourseOnline,'course_id','course_title');

        $this->widget('AdvanceSearchForm', array(
            'data'=>$model,
            'route' => $this->route,
            'attributes'=>array(
                // array('name'=>'generation','type'=>'list','query'=>$listGeneration),
                array('name'=>'course_id','type'=>'list','query'=>$listCourse),
                array('name'=>'schedule_id','type'=>'list','query'=> ''),
                // array('name'=>'lesson_id','type'=>'text'),
                array(
                    'type'=>'listMultiple',
                    'name'=>'lesson_id',
                    'query'=>CHtml::listData($LessonAll,'id', 'title')
                ),
                array('name'=>'search','type'=>'text','placeholder'=> 'สามารถค้นหาด้วย ชื่อ,นามสกุล,อีเมลล์'),
                array('name'=>'type_user','type'=>'list','query'=>$type_user),
                array('name'=>'division_id','type'=>'listMultiple','query'=>$divisiondata),
                array('name'=>'department','type'=>'listMultiple','query'=>$departmentdata),
                array('name'=>'station','type'=>'listMultiple','query'=>$stationdata),
                array('name'=>'period_start','type'=>'text'),
                array('name'=>'period_end','type'=>'text'),
        ),
        ));

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
    <?php if(!empty($_GET)){ ?>
	<!-- END HIGH SEARCH -->
            <div class="widget hidden" id="export-table">
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
                            <th rowspan="2" class="center">อีเมลล์</th>
                            <th colspan="<?= $course_count?>" class="center">รายหลักสูตร</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($course_online as $i => $course) {
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
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email; ?></td>
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
                                                            <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?></td>
                                                            <?php
                                                        }
                                                    }
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
        <div class="widget" id="export-table33">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' ถึงวันที่ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ1</th>
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
                                        'condition' => 'lang_id = 1 and course_id ="' . $course['course_id'] . '" and active="y"' . $sqlLessonQuery,
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
                                'condition' => 'status ="1"' . $gen . $textsearch.$texttype,
                            ));

                            $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>array(
                                'pageSize'=>100
                                ),
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
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
            </div>
        </div>



        <div class="widget-body">

            <a href="<?= $this->createUrl('report/genExcelByUser',array(
            'Report[generation]'=>$_GET['Report']['generation'],
            'Report[course_id]'=>$_GET['Report']['course_id'],
            'Report[lesson_id]'=>$_GET['Report']['lesson_id'],
            'Report[search]'=>$_GET['Report']['search'],
            'Report[period_start]'=>$_GET['Report']['period_start'],
            'Report[type_user]'=>$_GET['Report']['type_user'],
            'Report[schedule_id]'=>$_GET['Report']['schedule_id'],
            'Report[division_id]'=>$_GET['Report']['division_id'],
            'Report[department]'=>$_GET['Report']['department'],
            'Report[station]'=>$_GET['Report']['station'],
            'Report[period_end]'=>$_GET['Report']['period_end'])); ?>" 
            target="_blank" >

		    <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a>


            <!-- <a href="<?= $this->createUrl('report/genPdfByUser',array('ByUser[generation]'=>$_GET['ByUser']['generation'],'ByUser[course_id]'=>$_GET['ByUser']['course_id'],'ByUser[lesson_id]'=>$_GET['ByUser']['lesson_id'],'ByUser[search]'=>$_GET['ByUser']['search'],'ByUser[period_start]'=>$_GET['ByUser']['period_start'],'ByUser[period_end]'=>$_GET['ByUser']['period_end'])); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a> -->

            <a href="<?= $this->createUrl('report/genPdfByUser',array(
            'Report[generation]'=>$_GET['Report']['generation'],
            'Report[course_id]'=>$_GET['Report']['course_id'],
            'Report[lesson_id]'=>$_GET['Report']['lesson_id'],
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
<?php }else{ ?>
            <div class="innerLR">
            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                    </div>
                    <div class="widget-body">
                        <!-- Table -->
                        <h3 class="text-success">กรุณาป้อนข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3>
                        <!-- // Table END -->
                    </div>
                </div>
                </div>
        <?php } ?>
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

            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('Report/ListLesson');?>",
                data:{ course_id:selectedVal},
                success: function(data) {
                    $('#Report_lesson_id').empty(); 
                    $('#Report_lesson_id').append(data);
                    $('#Report_lesson_id').trigger("chosen:updated");
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

            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('Report/ListLesson');?>",
                data:{ course_id:course_id},
                success: function(data) {
                    $('#Report_lesson_id').empty(); 
                    $('#Report_lesson_id').append(data);
                    $('.chosen').trigger("chosen:updated");
                   
                }
            });
        });

        endDate();
        startDate();
        $('#courseSelectMulti').click(function(e) {
            var setArray = new Array();
            $('#courseSelectMulti :selected').each(function(i, val) {
                setArray[i] = val.value;
            });
            $.post("<?= Yii::app()->createUrl($this->route) ?>", { id: JSON.stringify(setArray) }, function(data) {
                $('#chooseLesson').html(data);
            });
        });
		// $('#btnExport').click(function(e) {
		// 	window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2><?= $title ?></h2>'+$('#export-table').html()));
		// 	e.preventDefault();
		// });
  //     $('.div-table a').attr('href','#');
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