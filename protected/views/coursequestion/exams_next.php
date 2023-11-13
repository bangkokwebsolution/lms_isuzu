<?php

if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
	$langId = Yii::app()->session['lang'] = 1;
	Yii::app()->language = 'en';
	$ques_title = 'Question';
	$questionTypeArrayStr = array(1 => 'Multiple Choices', 2 => 'The exams can choose only one answer.', 3 => 'Essay Test', 4 => 'Matching Test', 6 => 'Alignment Test');
	$Next = "Next";
	$Previous = "Previous";
	$SendAns = "Send";
} else {
	$langId = Yii::app()->session['lang'];
	$ques_title = 'คำถาม';
	$questionTypeArrayStr = array(1 => 'ข้อสอบแบบ เลือกได้หลายคำตอบ', 2 => 'ข้อสอบแบบ เลือกได้คำตอบเดียว', 3 => 'ข้อสอบแบบ คำตอบแบบบรรยาย', 4 => 'ข้อสอบแบบ คำตอบแบบจับคู่', 6 => 'ข้อสอบแบบ คำตอบแบบจัดเรียง');
	$Next = "ถัดไป";
	$Previous = "ย้อนกลับ";
	$SendAns = "ส่งคำตอบ";
}

?>
<style type="text/css">
	p {
		display: inline;
	}

	.con-answer {
		margin-top: 30px;
	}

	.row-total {
		display: flex;
		justify-content: center;
	}

	.total-lebal {
		text-align: center;
		margin-top: 20px;
		background: #ffc5c5;
		padding: 15px 20px;
		border-radius: 5px;
	}

	.total-lebal.success {
		background-color: #40db63;
	}

	.td-quest {
		display: grid;
		grid-template-columns: 7% 93%;
		width: 100%;
		grid-gap: 5px;
	}

	.td-quest>.items-quest {
		text-align: left;
	}

	.table-question th {
		background-color: #5CB85C;
		color: white;
	}
</style>

<div id="ques-show">
	<div class="col-lg-12">
		<div class="all-exams">
			<div class="exams-title">
				<?= $ques_title ?> <span class="pull-right"><?= $countExam . ' / ' . count($temp_all); ?></span>
			</div>
			<table class="table table-bordered table-striped">
				<tbody>
					<tr>
						<?php
						$loop = 0;
						foreach ($temp_all as $key => $val_temp) {
							$loop++;
							if ($model->ques_id == $val_temp->ques_id) {
								$class = 'btn-info';
							} else {
								$class = ($val_temp->status == '1') ? 'btn-success' : '';
							}
							$link = 'onclick="save_ans(\'' . $val_temp->number . '\')"';
						?>
							<td><a href="javascript:void(0)" <?= $link; ?> class="btn <?= $class ?> btn-block">
									<div style="height:100%;width:100%"><?= $val_temp->number; ?></div>
								</a></td>
						<?php
							if ($loop == 10) {
								$loop = 0;
								echo '</tr><tr style="background-color: #f9f9f9">';
							}
						}
						?>
					</tr>
				</tbody>
			</table>

		</div>

	</div>
	<div class="col-sm-12">
		<form id="question-form" action="#" method="POST" role="form" onSubmit="return false">

			<div class="form-group">
				<?php
				$strTotal = 0;
				$questionTypeArray = array(1 => 'checkbox', 2 => 'radio', 3 => 'textarea', 4 => 'dropdown', 6 => 'hidden');



				?>
				<h4><?= $questionTypeArrayStr[$model->ques_type] ?> </h4>
				<p><?= $currentQuiz->number; ?>. <?= $model->ques_title; ?></p>
				<div class="well answer" style="margin-top: 10px;">
					<?php
					$ansData = json_decode($currentQuiz->ans_id);
					$choiceData = json_decode($currentQuiz->question);

					if ($model->ques_type == 6) {
					?>
						<ul id='sortable' style='cursor: pointer;'>
							<?php
							if (!empty(json_decode($currentQuiz->ans_id))) {
								$choiceData = json_decode($currentQuiz->ans_id);
							}
						}

						$Type4Question = array();
						$arrType4Answer = array();
						$Type4Answer = array();

						if ($model->ques_type == 3) {
							echo '										
							<textarea class="examsta" rows="4" cols="50" name="lecture" >' . $currentQuiz->ans_id . '</textarea>
							';
						} else {

							$countchoice = 1; // นับตัวเลือกข้อสอบแบบจับคู่
							foreach ($choiceData as $key => $val_choice) {
								$choice = Coursechoice::model()->findByPk($val_choice);
								$checked = '';
								if ($model->ques_type == 1) {
									if (in_array($choice->choice_id, $ansData)) {
										$checked = 'checked';
									}
									echo '<div class="checkbox checkbox-info checkbox-circle">
							<input id="checkbox-' . $choice->choice_id . '" type="checkbox" ' . $checked . ' value="' . $choice->choice_id . '" name="Choice[' . $model->ques_id . '][]">
							<label for="checkbox-' . $choice->choice_id . '">
							' . CHtml::decode($choice->choice_detail) . '
							</label>
							</div>';
								} else if ($model->ques_type == 6) {
							?>
									<li class="li-cute" id='<?php echo $choice->choice_id; ?>'><?php echo CHtml::decode($choice->choice_detail); ?>
									</li>
						<?php
								} else if ($model->ques_type == 2) {
									if (in_array($choice->choice_id, $ansData)) {
										$checked = 'checked';
									}
									echo '
						<div class="radio radio-info radio-circle">
						<input id="radio-' . $choice->choice_id . '" 
						type="radio"' . $checked . ' value=' . $choice->choice_id . ' name="Choice[' . $model->ques_id . '][]">
						<label for="radio-' . $choice->choice_id . '">
						' . CHtml::decode($choice->choice_detail) . '
						</label>
						</div>';
								} else if ($model->ques_type == 4) {
									$thaichar = array('ก', 'ข', 'ค', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ฌ', 'ญ', 'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ');
									// $ranNumber = rand(1, 10000000);
									if ($choice->choice_answer == 2) {
										// $arrType4Answer[$ranNumber] = $val_choice;
										$Type4Answer[$choice->choice_id] = $thaichar[$countchoice - 1];
										$countchoice++;
									}
									if ($choice->choice_answer == 1) {
										$Type4Question[$val_choice] = $key;
									}
								}
							}
						}
						if ($model->ques_type == 4) {
							echo '<label> ส่วนที่ 1 </label> <br>';
						}


						foreach ($Type4Answer as $key => $val_1) {

							$choice = Coursechoice::model()->findByPk($key);
							echo 	'<div style="display:block">' . $val_1 . '. ' . CHtml::decode($choice->choice_detail) . '</div>';
							echo 	'<br>';
						}
						echo '<br>';

						if ($model->ques_type == 4) {
							echo '<label> ส่วนที่ 2 </label> <br>';
						}

						$ansDatas = array_flip($ansData);

						$countQuest = 0;
						foreach ($Type4Question as $key => $val_2) {
							$selected = '';
							if (in_array($countQuest, $ansDatas)) {
								$selected = $ansData[$countQuest];
							}

							$choice = Coursechoice::model()->findByPk($key);
							echo 	CHtml::dropDownList(
								'dropdownVal[]',
								$selected_value = $selected,
								$Type4Answer,
								array('empty' => UserModule::t('Choose'), 'class' => 'dropdown_value', 'id' => 'Q' . $key)
							) . ' <label>' . CHtml::decode($choice->choice_detail) . '</label>';
							echo '<br>';
							$countQuest++;
						}
						?>

						<?php if ($model->ques_type == 6) {
							echo "</ul>";

						?>
							<script type="text/javascript">
								$(function() {
									$('#sortable').sortable({
										start: function(event, ui) {
											var start_pos = ui.item.index();
											ui.item.data('start_pos', start_pos);
										},
										change: function(event, ui) {
											var start_pos = ui.item.data('start_pos');
											var index = ui.placeholder.index();
										},
										update: function(event, ui) {
											var start_pos = ui.item.data('start_pos');
											var index = ui.placeholder.index();
											get_li();
										}
									});
								});
							</script>
						<?php
						} ?>
				</div>
			</div>
			<!-- <button type="submit" class="btn btn-warning center-block">ส่งคำตอบ</button> -->

			<?php if ($model->ques_type == 6) {
			?>
				<input type="hidden" id="answer_sort" name="answer_sort" value="<?php echo implode(",", $choiceData); ?>">
			<?php
			} ?>

			<?php
			echo CHtml::hiddenField("Question_type[" . $model->ques_id . "]", $questionTypeArray[$model->ques_type]);
			echo CHtml::hiddenField("last_ques");
			echo CHtml::hiddenField("actionEvnt");
			echo CHtml::hiddenField("course_id", $course->course_id);
			echo CHtml::hiddenField("idx_now", $currentQuiz->number);

			if (!empty($OneStep_exam) && $OneStep_exam["status"] == true) {
				if ($ChkByOne["text_status"] == "done") {
					$SendAns = $Next;
				}
			}
			?>
			<div class="text-center">
				<?php
				if ($course->course_refer != "AnswerByOne") {
					echo CHtml::tag('button', array('class' => 'submit btn btn-outline btn-rounded btn-dark btn-lg', 'onclick' => 'save_ans("previous")'), $Previous);
					echo CHtml::tag('button', array('class' => 'submit btn btn-outline btn-rounded btn-dark  btn-lg', 'onclick' => 'save_ans("next")'), $Next);
				} else {
					echo CHtml::tag('button', array('class' => 'submit btn btn-warning btn-lg', 'onclick' => 'save_ans("next")'), $SendAns);
				}
				?>
				<?php if ($last_ques == 1) echo CHtml::tag('button', array('class' => 'submit btn btn-success btn-lg', 'onclick' => 'save_ans("save")'), UserModule::t('sendQues')); ?>
			</div>
		</form>
		<?php

		if (!empty($OneStep_exam) && $OneStep_exam["status"] == true && !empty($ans_course)) {
		?>
			<div class="con-answer">
				<div class="question-content-wrap">

					<table class="table-question table table-bordered">
						<thead>
							<tr class="bg-success">
								<th style="text-align: center">ข้อ</th>
								<th style="text-align: left">รายละเอียด</th>
								<th style="text-align: center">สถานะ</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$last_question_id = [];
							$last_question_id =  json_decode($ans_course->answer_choice);
							?>
							<tr>
								<td style="width: 10%;"><?= $currentQuiz->number; ?></td>
								<td style="width: 80%;">
									<div class="td-quest">
										<div class="items-quest font-weight-bold">
											คำถาม:
										</div>
										<div class="items-quest">
											<?= $model->ques_title; ?>
										</div>
										<div class="items-quest font-weight-bold">
											คำตอบ:
										</div>
										<div class="items-quest">
											<?php foreach ($last_question_id as $key_ans => $val_ans) {
												$title_c = Coursechoice::model()->findByPk($val_ans); ?>
												<?= CHtml::decode($title_c->choice_detail) ?> <br>
											<?php } ?>
										</div>

										<?php
										if (!empty($ans_course->choice_correct)) { ?>
											<div class="items-quest font-weight-bold">
												คำอธิบาย:
											</div>
											<div class="items-quest">
												<?= $model->ques_explain ?>
											</div>
										<?php }
										?>
									</div>
								</td>
								<td style="width: 10%;">
									<?php if ($ans_course->status == "correct") { ?>
										<i class="fa fa-check text-success"></i>
										<div class="text-success">คำตอบถูกต้อง</div>
									<?php } else { ?>
										<i class="fa fa-times text-danger"></i>
										<div class="text-danger">
											<?= $OneStep_exam["total"] != null && $ChkByOne["text_status"] == "try" ? "คำตอบผิด กรุณาเลือกคำตอบใหม่อีกครั้ง" : "คำตอบผิด" ?>
										</div>
									<?php } ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		<?php
		} ?>
		<script type="text/javascript">
			$('#exams_first_bar').remove();
		</script>