<?php
$timeTest = Helpers::lib()->getTimeTest($course->time_test, $temp_all[0]->time_up);
$percent = $modelScore->score_number > 0 ? number_format(($modelScore->score_number * 100) / $modelScore->score_total, 2) : 0;
if ($modelScore->score_past == 'y') {
	$class = 'fa fa-check-circle';
	$classH1 = 'text-success';
	// $strMsg = 'ผ่าน';
	$strMsg = $labelCourse->label_passTest;
	$link = '#modal-pass';
} else {
	$class = 'fa fa-times-circle';
	$classH1 = 'text-danger';
	// $strMsg = 'ไม่ผ่าน';
	$strMsg = $labelCourse->label_notPassTest;
	$link = '#modal-alert';
}
/*$stateTest = Helpers::lib()->CheckTest($lesson,$testType);
$class = $stateTest->value['statusBoolean'] ? 'fa fa-check-circle' : 'fa fa-times-circle';
$classH1 = $stateTest->value['statusBoolean'] ? 'text-success' : 'text-danger';*/
$criteria = new CDbCriteria;
$criteria->compare('course_id', $course->course_id);
$criteria->compare('user_id', Yii::app()->user->id);
$criteria->compare('active', 'y');
$countScore = Coursescore::model()->findAll($criteria);

if ($course->cate_amount < count($countScore)) {
	$msgLink = UserModule::t('reTestFail');
} else {
	$msgLink = UserModule::t('reTest');
}

if ($course->cate_id != 1) { //LMS
	$linkPrint = $this->createUrl('Course/SendCertificateEmail', array('id' => $course->course_id));
} else { //TMS
	$linkPrint = $this->createUrl('course/detail', array('id' => $course->course_id));
}



?>
<?php 
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
  $langId = Yii::app()->session['lang'] = 1;
  $flag = true;

  $Minutes="Minutes";
  $score_number="Your score earned";

} else {
  $langId = Yii::app()->session['lang'];
  $flag = false;

  $Minutes="นาที";
  $score_number="คะแนนของคุณ";
}

?>
<script>
	$(function() {
		if ("<?= $testType ?>" != "pre" && $quesType_ != 3) { // 3= บรรยาย pop up
			$('<?= $link ?>').modal('show');
		}
	});
</script>
<style type="text/css">
	.text-success {
		color: #22c020 !important;
	}

	.bg-success {
		background-color: #5cb85c;
		color: #fff;
	}
</style>
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-main">
			<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $labelCourse->label_course; ?></a>
			<li class="breadcrumb-item active" aria-current="page"><?= $course->course_title; ?></li>
		</ol>
	</nav>
</div>
</div>

<section class="content" id="exams-finish">
	<div class="container">
		<div class="row exams-finish-content">
			<div class="col-sm-8">
				<div class="well bg-greendark">

					<?php if ($testType != "pre" && $quesType_ != 3) { // 3= บรรยาย   หัว icon ว่าผ่าน ไม่ผ่าน 
					?>
						<div class="well text-center result">
							<h1 class="<?= $classH1; ?>">
								<span><i class="<?= $class; ?>" aria-hidden="true"></i></span>
								<?= $strMsg; ?>
							</h1>
						</div>
					<?php } ?>

					<div class="well detail exams-finish-detail">
						<ul class="list-unstyled">
							<li>
								<?= $labelCourse->label_totalTest ?>
								<span class="pull-right"><?= count($temp_all) ?> <?= $labelCourse->label_list ?></span>
							</li>
							<li>
								<?= UserModule::t('timeTest'); ?>
								<span class="pull-right"><?= $course->time_test; ?> <?= $Minutes; ?></span>
							</li>
							<li>
								<?= UserModule::t('timeToUse'); ?>
								<span class="pull-right"><?= $timeTest ?> <?= $Minutes; ?></span>
							</li>
							<li>
								<?= UserModule::t('totoal'); ?>
								<span class="pull-right"><?= $modelScore->score_total; ?> <?= $labelCourse->label_point; ?></span>
							</li>
							<li>
								<?= $labelCourse->label_haveCorrect; ?>
								<!-- <span class="pull-right"><?= $score_number; ?> <?= $labelCourse->label_point; ?></span> -->
								<span class="pull-right"><?= $modelScore->score_number ?> <?= $labelCourse->label_point; ?></span>
							</li>
							<li>
								<?= $labelCourse->label_percentage ?>
								<span class="pull-right"><?= $percent; ?> %</span>
							</li>
						</ul>
					</div>
				</div>
				<div class="text-center">
					<a href="<?= Yii::app()->createUrl('course/detail/', array('id' => $course->course_id)); ?>" type="button" class="btn btn-warning btn-lg"><?= UserModule::t('complete_btn'); ?></a>
				</div>
			</div>

			<?php if ($testType != "pre" && ($quesType_ != 4 && $quesType_ != 6 && $quesType_ != 3)) { // โชว์ว่าข้อไหนถูก ไม่ถูก 
			?>
				<div class="col-sm-4">
					<aside>
						<h4 class="title text-success"><span class="pull-right"><?= $modelScore->score_number; ?></span><?= UserModule::t('scoreAll'); ?></h4>
						<ul class="list-unstyled">
							<?php
							$logQues = Courselogques::model()->findAll(array(
								'condition' => 'score_id=:score_id AND user_id=:user_id',
								'params' => array(':score_id' => $modelScore->score_id, ':user_id' => Yii::app()->user->id)
							));
							foreach ($logQues as $key => $value) {
								if ($value->result >= 1) {
									$class = 'fa fa-circle text-success';
									$score = $value->result;
								} else {
									$class = 'fa fa-circle text-danger';
									$score = '0';
								}
								echo '
							<li><spna class="pull-right">' . $score . '</spna><i class="' . $class . '" aria-hidden="true"></i>' . UserModule::t('list_question') . ' ' . ($key + 1) . '</li>
							';
							}
							?>
						</ul>
					</aside>
				</div>
			<?php } ?>

		</div>
	</div>
</section>
<div class="container">
	<?php if ($course->course_refer == 'y' && $testType != "pre" && $quesType_ != 3) { ?>
		<div class="question-content-wrap">
			<div class="row">
				<div class="col-md-8">

					<table class="table-question table table-bordered">
						<thead>
							<tr class="bg-success">
								<th style="text-align: center">ข้อ</th>
								<th style="text-align: left">รายละเอียด</th>
								<th style="text-align: center">สถานะ</th>
								<!--<th class="right-answer">% Right Answer</th>-->
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($temp_all as $index => $val) {
								$modelCoursescore = Coursescore::model()->find(array(
									'condition' => 'user_id=:user_id AND course_id=:course_id AND active="y"',
									'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $course->course_id),
									'order' => 'score_id desc'
								));
								$logchoice = Courselogchoice::model()->findAll(array(
									'condition' => "score_id=:score_id and logchoice_answer = 1 and ques_id=:ques_id",
									'params' => array(':score_id' =>  $modelCoursescore->score_id, ':ques_id' => $val->ques_id)
								));
								$choiceData = 0;
								$ansStr = '';
								$arrayCount = count($logchoice);
								$choiceState = true;
								if (!$logchoice) $ansStr .= '-';
								foreach ($logchoice as $key => $valChoice) {
									$ansStr .= CHtml::decode($valChoice->choices->choice_detail);
									if (($arrayCount - 1) != $key) $ansStr .= ',';
									if ($valChoice->is_valid_choice == 1) {
										$choiceData++;
									} else {
										$choiceState = false;
									}
								}
								$logCoursescore = Coursechoice::model()->findAll(array(
									'condition' => "ques_id=:ques_id and choice_answer='1'",
									'params' => array(':ques_id' => $val->ques_id)
								));
								$arrayCount = count($logCoursescore);

								if ($logchoice) {
									if (($choiceData == $arrayCount) && $choiceState) {
										$icon_score = '<i class="fa fa-check text-success"></i>';
									} else {
										$icon_score = '<i class="fa fa-times text-danger"></i>';
									}
								} else {
									$icon_score = '<i class="icon icon-err md-close-2"></i>';
								}
								$question = CourseQuestion::model()->find(array(
									'condition' => 'ques_id = ' . $val->ques_id
								));
							?>
								<tr>
									<td><?= ($index + 1); ?></td>
									<td class="td-quest" style="text-align: left">
										<b>คำภาม</b> : <?= $question->ques_title; ?><br>
										<b>คำตอบ</b> : <?= $ansStr; ?>

										<br><b>เฉลย</b> : <?php
															foreach ($logCoursescore as $key => $logCourse) {
																echo CHtml::decode($logCourse->choice_detail);
																if (($arrayCount - 1) != $key) echo ',';
															}; ?>
										<?php if ($question->ques_explain) { ?><br><b>คำอภิปราย</b> : <?= $question->ques_explain; ?>
										<?php
										}
										?>
									</td>
									<td><?= $icon_score; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php } ?>
</div>


<div class="modal fade" id="modal-alert">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= $labelCourse->label_swal_warning; ?></h4>
			</div>
			<div class="modal-body">
				<center>
					<i class="fa fa-warning" style="font-size:6em; color: #F8BB86; padding-top: 15px;padding-bottom: 15px;"></i>
					<h2 style="color: #575757;"><?= $labelCourse->label_notPassTest; ?></h2>
					<p><?= $msgLink; ?></p>
				</center>
			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-success" style="padding: 15px 32px; height: auto" data-dismiss="modal">OK</button>
				</center>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-pass">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= $labelCourse->label_swal_warning; ?></h4>
			</div>
			<div class="modal-body">
				<center>
					<i class="fa fa-check" style="font-size:6em; color: #4cdb20; padding-top: 15px;padding-bottom: 15px;"></i>
					<h2 style="color: #575757;"><?= $labelCourse->label_passTest; ?></h2>
					<!-- <p><?= UserModule::t('msg_pass'); ?></p> -->
				</center>
			</div>
			<div class="modal-footer">
				<center>
					<!-- <button type="button" class="btn btn-success"  style="padding: 15px 32px; height: auto" data-dismiss="modal" onclick="location.href='<?php //echo $linkPrint 
																																								?>'">OK</button> -->
					<button type="button" class="btn btn-success" style="padding: 15px 32px; height: auto" data-dismiss="modal">OK</button>
				</center>
			</div>

		</div>
	</div>
</div>