
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
			
			 if(!empty($_GET)){ ?>
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
		<?php } ?>


	
	