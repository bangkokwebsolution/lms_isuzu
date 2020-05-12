<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<?php
$title = 'สถิติจำนวนผู้พิมพ์หนังสือรับรองออกจากระบบรายเดือน แยกตามรายหัวข้อวิชา และรายหลักสูตร';
$form_name_model = 'Passcours Report';

$this->breadcrumbs = array($title);

$get = $_GET['PasscoursLog'];

$course_array = (is_array($get['pclog_target']))? implode(',', $get['pclog_target']) : null;
$period_start = ($get['period_start'])?date('Y-m-d 00:00:00', strtotime($get['period_start'])):null;
$period_end = ($get['period_end'])?date('Y-m-d 23:59:59', strtotime($get['period_end'])):null;

$coursesql = ($course_array!=null)?' and courseonline.course_id in (' . $course_array . ')':null;
$startdate = ($period_start)?' and pclog_date >= "'. $period_start .'"':null;
$enddate = ($period_end)?' and pclog_date <= "'. $period_end .'"':null;

$type_user[1] = 'บุคลากรทั่วไป';
$type_user[2] = 'บุคลากรภายใน';

$divisiondata = Division::model()->getDivisionListNew(); 
$departmentdata = Department::model()->getDepartmentListNew();
$stationdata = Station::model()->getStationList();

$userModel = Users::model()->findByPk(Yii::app()->user->id);
$state = Helpers::lib()->getStatePermission($userModel);

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
EOD
, CClientScript::POS_READY);

?>
<div class="innerLR">
	<?php 

	if(!$state){
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1 and cate_id != 1 and create_by = "'.Yii::app()->user->id.'"',
			'order' => 'course_id DESC'
		)
	);
	}else{
		$CourseOnline = CourseOnline::model()->findAll(array(
			'condition' => 'active = "y" and lang_id = 1 and cate_id != 1',
			'order' => 'course_id DESC'
		)
	);
	}
	

	$this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'pclog_target','type'=>'list','query'=>$model->getCourseList()),
			array('name'=>'type_register','type'=>'list','query'=>$type_user),
			//array('name'=>'division_id','type'=>'listMultiple','query'=>$divisiondata),
			array('name'=>'department','type'=>'listMultiple','query'=>$departmentdata),
			//array('name'=>'station','type'=>'listMultiple','query'=>$stationdata),
			array('name'=>'period_start','type'=>'text'),
			array('name'=>'period_end','type'=>'text'),
		),
		));?>
		<div class="widget" id="export-table">
			<div class="widget-head">
				<h4 class="heading glyphicons search">
					<i></i> สถิติจำนวนผู้พิมพ์หนังสือรับรอง : วันที่ <?= Helpers::lib()->changeFormatDate($period_start) ?> ถึงวันที่ <?= Helpers::lib()->changeFormatDate($period_end) ?>
				</h4>
			</div>
			<?php if(!empty($_GET)){ ?>
			<div class="widget-body">
				<table class="table table-bordered table-striped" id="export-excel-<?php echo $less['id'] ?>">
					<thead>
						<tr>
							<!--<th class="center" style="width: 80px;">ลำดับ</th>-->
							<th style="min-width: 400px;" class="left">บทเรียน</th>
							<th class="center" style="width: 75x;">ผู้เรียนทั้งหมด</th>
							<th class="center" style="width: 75x;">เรียนผ่าน</th>
							<th class="center" style="width: 75x;">พิมพ์ใบประกาศ</th>
							<th class="center" style="width: 75x;">ไม่พิมพ์ใบประกาศ</th>
							<th class="center" style="width: 75x;">คิดเป็นร้อยละ</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(!empty($_GET['PasscoursLog']['pclog_target'])){
							$courseSearch = ' and courseonline.course_id = '.$_GET['PasscoursLog']['pclog_target'];
						}
						if(!$state){
							$allCurrentCourse = CourseOnline::model()->with('category')->findAll(array(
								'condition' => 'courseonline.lang_id = 1 and courseonline.cate_id != 1 and courseonline.active = "y"' . $coursesql.' and courseonline.create_by = "'.Yii::app()->user->id.'"'.$courseSearch,
								'order' => 'courseonline.cate_id ASC, courseonline.cate_course ASC',
							));
						}else{
							$allCurrentCourse = CourseOnline::model()->with('category')->findAll(array(
								'condition' => 'courseonline.lang_id = 1 and courseonline.cate_id != 1 and courseonline.active = "y"' . $coursesql.$courseSearch,
								'order' => 'courseonline.cate_id ASC, courseonline.cate_course ASC',
							));
						}
						
						$sumLearn = 0;
						$sumPass = 0;
						$sumPrint = 0;
						$sumNotPrint = 0;
						if($allCurrentCourse) {
							$last_cate_id = null;
							$lastCategory = null;
							foreach($allCurrentCourse as $Course) {
								if($last_cate_id != $Course['cate_id']) { 
									$last_cate_id = $Course['cate_id'];
									?>
									<tr>
										<td colspan="6" style="color: white; background-color: #997eb9; font-weight: bold;"><?= $Course->cates->cate_title ?></td>
									</tr>
									<?php
								}
								if($lastCategory != $Course['cate_course'] && $Course['cate_course'] != null) {
									$lastCategory = $Course['cate_course'];
									?>
									<tr>
										<td colspan="6" style="padding-left: 40px; color: white; background-color: #5b2d90; font-weight: bold;"><?= $Course->category->name ?></td>
									</tr>
									<?php
								}
								$print = PasscoursLog::model()->with('Course')->findAll(array(
									'condition' => 'passcours_cours = "' . $Course['course_id'] . '"' . $startdate . $enddate,
									'group' => 'pclog_target'
								));
								$allLearn = Learn::model()->with('les')->findAll(array(
									'condition' => 't.course_id = "' . $Course['course_id'] . '" and lesson_active = "y"',
									'group' => 'user_id'
								));
								$pass = Learn::model()->with('les')->findAll(array(
									'condition' => 't.course_id = "' . $Course['course_id'] . '" and lesson_status = "pass" and lesson_active = "y"',
									'group' => 'user_id'
								));
								$CurrentLesson = Lesson::model()->findAll(array(
									'condition' => 'course_id = "' . $Course['course_id'] . '" AND active ="y" AND lang_id = 1',
								));
						//count
								$count_learn = count($allLearn);
								$count_pass = count($pass);
								$count_print = count($print);

								$calNotPrint = $count_pass - $count_print;
								if($calNotPrint < 0){
									$calNotPrint = 0;
								}
								$count_notprint = $calNotPrint;
								$calPercentage = $count_print*100/$count_pass;


						//sum

								$sumLearn = $sumLearn + $count_learn;
								$sumPass = $sumPass + $count_pass;
								$sumPrint = $sumPrint + $count_print;
								$sumNotPrint = $sumNotPrint + $count_notprint;
								$sumPercentage = $sumPrint*100/$sumPass;
								
								?>
								<tr>
									<td><span style="padding-left: 60px; "><?= $Course['course_title'] ?></span></td>
									<td class="center"><?= $count_learn ?></td>
									<td class="center"><?= $count_pass ?></td>
									<td class="center"><?= $count_print ?></td>
									<td class="center"><?= ($calNotPrint>0)?$calNotPrint:0 ?></td>
									<td class="center"><?= ($calPercentage>0)?round($calPercentage, 2).'%':0 ?></td>
								</tr>
								<?php
							}
						} else {
							echo 'no course yet.';
						}
						?>	
						<tr>
							<td class="right" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;">รวมทั้งสิ้น</td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumLearn ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumPass ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumPrint ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $sumNotPrint ?></td>
							<td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= ($sumPercentage>0)?round($sumPercentage, 2).'%':0 ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } else { ?>
			<div class="widget-body div-table" style="overflow: auto;">
				<h4>กรุณาเลือกหลักสูตร หรือข้อมูลที่ต้องการ แล้วกด ปุ่มค้นหา</h4>
			</div>
		<?php } ?>
	</div>
			 <div class="widget-body">
			 <a href="<?= $this->createUrl('passcours/genExcelPasscoursLog',array(
			'PasscoursLog[pclog_target]'=>$_GET['PasscoursLog']['pclog_target'],
            'PasscoursLog[type_register]'=>$_GET['PasscoursLog']['type_register'],
            'PasscoursLog[division_id]'=>$_GET['PasscoursLog']['division_id'],
            'PasscoursLog[department]'=>$_GET['PasscoursLog']['department'],
            'PasscoursLog[station]'=>$_GET['PasscoursLog']['station'],
            'PasscoursLog[period_start]'=>$_GET['PasscoursLog']['period_start'],
            'PasscoursLog[period_end]'=>$_GET['PasscoursLog']['period_end'])); ?>" 
            target="_blank">
					<button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
			</a>
			</div>
		
	</div>
	<script type="text/javascript">
		$(function() {
        // $('#courseSelectMulti').select2();
        $(".chosen").chosen();
        endDate();
        startDate();
        // $('#btnExport').click(function(e) {
        // 	window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>"<?= $title ?>"</h2>'+$('#export-table').html()));
        // 	e.preventDefault();
        // });
        // $('.div-table a').attr('href','#');
    });
		function startDate() {
			$('#PasscoursLog_period_start').datepicker({
				dateFormat:'yy/mm/dd',
				showOtherMonths: true,
				selectOtherMonths: true,
				onSelect: function() {
					$("#PasscoursLog_period_end").datepicker("option","minDate", this.value);
				},
			});
		}
		function endDate() {
			$('#PasscoursLog_period_end').datepicker({
				dateFormat:'yy/mm/dd',
				showOtherMonths: true,
				selectOtherMonths: true,
			});
		}
	</script>