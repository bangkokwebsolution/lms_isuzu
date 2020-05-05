<?php
$title = 'รายงานผู้เรียนตามหัวข้อวิชา';
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
<script type="text/javascript">
    $(function() {
        $(".chosen").chosen();

        var itemToDisable = $("option:contains('กรุณาเลือก')");
        itemToDisable.attr("disabled",true);
        $(".chosen").trigger("chosen:updated");

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


        // $('#btnExport').click(function(e) {
        //     window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2><?= $title ?></h2>'+$('#export-table').html()));
        //     e.preventDefault();
        // });

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
    });
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
    $LessonAll = Lesson::model()->findAll(array('condition' => 'active = "y" and lang_id = 1','order' => 'lesson_no ASC'));
    }else{
        $LessonAll = Lesson::model()->findAll(array('condition' => 'active = "y" and lang_id = 1 and create_by = "'.Yii::app()->user->id.'"','order' => 'lesson_no ASC'));
    }
    // foreach($LessonAll as $value)
    // {

    //     if ($value->active==0) { // We found an inactive item on Model B

    //             $dataDisabledContentArr[$value->content_id] = array('disabled'=>true); // Store it here

    //         }

    //     $dataContentArr[$value->content_id] = $value->name; // Now storing item from Model A

    // }


    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array(
                'type'=>'listMultiple',
                'name'=>'lesson_id',
                'query'=>CHtml::listData($LessonAll,'id', 'title')
            ),
            array('name'=>'type_user','type'=>'list','query'=>$type_user),
            array('name'=>'search','type'=>'text','placeholder'=> 'สามารถค้นหาด้วย ชื่อหลักสูตร หรือบทเรียน'),
           
            //array('name'=>'division_id','type'=>'listMultiple','query'=>$divisiondata),
            array('name'=>'department','type'=>'listMultiple','query'=>$departmentdata),
            //array('name'=>'station','type'=>'listMultiple','query'=>$stationdata),

            array('name'=>'period_start','type'=>'text'),
            array('name'=>'period_end','type'=>'text'),

        ),
    ));?>
</div>
<?php if(!empty($_GET)){ ?>
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
                    <select name="ByLesson[generation]">
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
                    <select name="ByLesson[lesson_id][]" multiple style="width: 50%; height: 150px;" id="courseSelectMulti">
                    <?php
                        $LessonAll = Lesson::model()->findAll(array(
                            'condition' => 'active = "y"',
                            'order' => 'lesson_no ASC'
                            )
                        );
                        $curr_supper_cate = null;
                        $curr_course_cate = null;
                        if($LessonAll) {
                            foreach($LessonAll as $Lesson) {
                                ?>
                                <option value="<?= $Lesson['id'] ?>"><?= $Lesson['title'] ?></option>
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
							<input name="ByLesson[search]" type="text" value="" placeholder="สามารถค้นหาด้วย ชื่อหลักสูตร หรือวิชา">
							<span style="font-size: 0.9em; color: red;">(สามารถค้นหาด้วย ชื่อหลักสูตร หรือวิชา)</span>
						</div>
					</dd>
				</div>
            <div class="form-group">
                <dt><label>วันที่เริ่มต้น - วันที่สิ้นสุด : </label></dt>
                <dd>
                    <input name="ByLesson[period_start]" type="text" class="form-control" placeholder="เลือกช่วงเวลาเริ่ม" id="passcoursStartDateBtn"> : <input name="ByLesson[period_end]" type="text" class="form-control" placeholder="เลือกช่วงเวลาสิ้นสุด" id="passcoursEndDateBtn">
                </dd>
            </div>
				<div class="form-group">
					<dt></dt>
					<dd><button type="submit" class="btn btn-primary btn-icon glyphicons search"><i></i> Search</button></dd>
				</div>
			</dl>
		</div> -->
	<?php //$this->endWidget(); ?>
	<!-- </div> -->
    <?php
        // $search = $_GET['ByLesson'];
        $search = $_GET['Report'];
        $textsearch = ($search['search']!=null)?'and email like "%'.$search['search'].'%" or profile.firstname like "%'.$search['search'].'%" or profile.lastname like "%'.$search['search'].'%"':null;
        $searchLesson = $search['lesson_id'];
        $searchLessonArray = implode(',', $searchLesson);
        $sqlLessonQuery = ($searchLessonArray!='')?' and id in ('.$searchLessonArray.')':null;
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

        //period
        $period_start = ($search['period_start'])?date('Y-m-d 00:00:00', strtotime($search['period_start'])):null;
        $period_end = ($search['period_end'])?date('Y-m-d 23:59:59', strtotime($search['period_end'])):null;
        
        $startdate = ($period_start)?' and learn.create_date >= "'. $period_start .'"':null;
        $enddate = ($period_end)?' and learn.create_date <= "'. $period_end .'"':null;

        $lesson_online = Lesson::model()->findAll(array(
            'condition' => 'active = "y"' . $sqlLessonQuery,
            'order' => 'lesson_no ASC'
        ));
        $lesson_count = ($lesson_online)?count($lesson_online):0;
    ?>
	<!-- END HIGH SEARCH -->
    <div class="innerLR">
        <div class="widget" id="export-table" style="display: none;">
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
                            <th colspan="<?= $lesson_count?>" class="center">สถานะผู้เรียนรายวิชา</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($lesson_online as $lesson) {
                                   ?>
                                <th style="writing-mode: tb-rl;"><?= $lesson['title'] ?></th>
                                   <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($_GET)){
                               $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1"' . $gen . $textsearch . $texttype,
                                ));
                            }
                           
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
                            if($dataProvider->getData()) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email ?>&nbsp;</td>
                                        <?php
                                           if($lesson_online) {
                                                foreach($lesson_online as $lesson) {
                                                    $statusLearn = Learn::model()->with('les')->find(array(
                                                        'condition' => 'lesson_active = "y" and user_id ="'.$user['id'].'" and lesson_id ="'. $lesson['id'] .'"' . $startdate . $enddate ,
                                                        'alias' => 'learn'
                                                    ));
                                                    $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 'pass' => '<b style="color: blue;">ผ่าน</b>','notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
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
                <?php 
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
            </div>
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
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2">อีเมลล์</th>
                            <th colspan="<?= $lesson_count?>" class="center">สถานะผู้เรียนรายวิชา</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($lesson_online as $lesson) {
                                   ?>
                                <th style="writing-mode: tb-rl;"><?= $lesson['title'] ?></th>
                                   <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($_GET)){
                            $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1"' . $gen . $textsearch. $texttype,
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
                            if($dataProvider->getData()) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email ?></td>
                                        <?php
                                           if($lesson_online) {
                                                foreach($lesson_online as $lesson) {
                                                    $statusLearn = Learn::model()->with('les')->find(array(
                                                        'condition' => 'lesson_active = "y" and user_id ="'.$user['id'].'" and lesson_id ="'. $lesson['id'] .'"' . $startdate . $enddate ,
                                                        'alias' => 'learn'
                                                    ));
                                                    $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 'pass' => '<b style="color: blue;">ผ่าน</b>','notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
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
                <?php 
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
            </div>
        </div>

        <!-- End   -->

        <div class="widget-body">
       
               <a href="<?= $this->createUrl('report/genExcelByLesson',array(
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
            target="_blank" >

            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a>
            <!-- <a href="<?= $this->createUrl('report/genPdfByLesson',array('ByLesson[generation]'=>$_GET['ByLesson']['generation'],'ByLesson[course_id]'=>$_GET['ByLesson']['course_id'],'ByLesson[search]'=>$_GET['ByLesson']['search'],'ByLesson[period_start]'=>$_GET['ByLesson']['period_start'],'ByLesson[period_end]'=>$_GET['ByLesson']['period_end'])); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a> -->

            <a href="<?= $this->createUrl('report/genPdfByLesson',array(
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