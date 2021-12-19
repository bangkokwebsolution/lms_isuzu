<?php
$real = '["55","56","54"]';
$arr = array();
$arr = json_decode($real);
?>
<?php 
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
  $langId = Yii::app()->session['lang'] = 1;
  $flag = true;

  $Time_allowed="Time allowed";
  $questionTypeArrayStr = array(1 => 'Multiple Choices', 2 => 'The exams can choose only one answer.', 3 => 'Essay Test', 4 => 'Matching Test', 6 => 'Alignment Test');
  $ok="OK";
  $cancel="Cancel";
  $Question="Question";

} else {
  $langId = Yii::app()->session['lang'];
  $flag = false;

  $Time_allowed="เวลา";
  $questionTypeArrayStr = array(1 => 'ข้อสอบแบบ เลือกได้หลายคำตอบ', 2 => 'ข้อสอบแบบ เลือกได้คำตอบเดียว', 3 => 'ข้อสอบแบบ คำตอบแบบบรรยาย', 4 => 'ข้อสอบแบบ คำตอบแบบจับคู่', 6 => 'ข้อสอบแบบ คำตอบแบบจัดเรียง');
  $ok="ยืนยัน";
  $cancel="ยกเลิก";
  $Question="คำถาม";
}

?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
	.exams p {
		display: inline !important;
		margin-top: -3px !important;
	}

	.exams label {
		margin-bottom: 15px !important;
	}

	.exams label:after {
		top: 3px !important;
	}

	.radio label:after {
		top: 5px !important;
	}

	.exams label:before {
		margin-top: -4px !important;
	}
	.li-cute{
		border: solid 1px black; 
		background: white; 
		padding-top: 10px; 
		padding-bottom: 10px; 
		margin-bottom: 10px; 
		padding-left: 10px; 
		padding-right: 10px;
	}
</style>
<div id="exam-result">
	
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb breadcrumb-main">
				<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $labelCourse->label_course; ?></a>
					<li class="breadcrumb-item active" aria-current="page"><?= $lesson->CourseOnlines->course_title; ?></li>
				</ol>
			</nav>
		</div> 
		<section class="content" id="exams">
			<div class="container">
				<!-- tabtime -->
				<div class="alert alert-danger stick center shadow">
					<h4 class="mb-0 text-center"><?=$Time_allowed ?> : <span id="tabtime">00:00:00</span></h4>
				</div>
				<!-- Content -->

				<div class="well">
					<div class="exams">
						<div class="row">
							<div id="ques-show" class="col-md-12 col-sm-12 col-xs-12">
								<form id="question-form" action="#" method="POST" role="form" onSubmit="return false">
									<div class="col-md-8 col-sm-12 col-xs-12">
										<div class="form-group">
											<?php
											$strTotal = 0;
											$questionTypeArray = array(1 => 'checkbox', 2 => 'radio', 3 => 'textarea', 4 => 'dropdown', 6 => 'hidden');
											
											?>
											<h4><?= $questionTypeArrayStr[$model->ques_type] ?></h4>
											<p><?= $currentQuiz->number; ?>. <?= $model->ques_title; ?></p>
											<div class="well answer" style="margin-top: 10px;">
												<?php
												$ansData = json_decode($currentQuiz->ans_id);
												$choiceData = json_decode($currentQuiz->question);
												$arrType4Answer = array();

												if($model->ques_type == 6 ){ 
													?>
													<ul id='sortable' style='cursor: pointer;'>
													<?php
													if( !empty( json_decode($currentQuiz->ans_id) ) ) {
														$choiceData = json_decode($currentQuiz->ans_id);
													}

												 }

											// echo '<pre>';
											// var_dump($choiceData);
											// exit();
											////////////////////////////////////////////////////<<<
												
												 if($model->ques_type == 3) {
												echo '										
												<textarea class="examsta form-control" rows="4" cols="50" name="lecture" >'.$currentQuiz->ans_id.'</textarea>
												';

											}else{
											$countchoice = 1; // นับตัวเลือกข้อสอบแบบจับคู่
											foreach ($choiceData as $key => $val_choice) {
												$choice = Choice::model()->findByPk($val_choice);
												$checked = '';
												if (in_array($choice->choice_id, $ansData)) {
													$checked = 'checked';
												}
												if ($model->ques_type == 1) {
													echo '<div class="checkbox checkbox-info checkbox-circle">
													<input id="checkbox-' . $choice->choice_id . '" type="checkbox" class="check" ' . $checked . ' value="' . $choice->choice_id . '" name="Choice[' . $model->ques_id . '][]">
													<label for="checkbox-' . $choice->choice_id . '">
													' . CHtml::decode($choice->choice_detail) . '
													</label>
													</div>
													';
												}else if ($model->ques_type == 6) {
													// echo '<div class="checkbox checkbox-info checkbox-circle">
													// <input id="checkbox-' . $choice->choice_id . '" type="checkbox" class="check" ' . $checked . ' value="' . $choice->choice_id . '" name="Choice[' . $model->ques_id . '][]">
													// <label for="checkbox-' . $choice->choice_id . '">
													// ' . CHtml::decode($choice->choice_detail) . '
													// </label>
													// </div>
													// ';
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
													// $ranNumber = rand(1, 10000000);
													if ($choice->choice_answer == 2) {
														$thaichar = array('ก', 'ข', 'ค', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ฌ', 'ญ', 'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ');
														$Type4Answer[$choice->choice_id] = $thaichar[$countchoice - 1];
														$countchoice++;
														// $arrType4Answer[$ranNumber] = $val_choice;
													}
													if ($choice->choice_answer == 1) {
														$Type4Question[$val_choice] = $key;
													}
												}
											} // foreach

										}


											if ($model->ques_type == 4) {
												echo '<label> ส่วนที่ 1 </label> <br>';
											}


											foreach ($Type4Answer as $key => $val_1) {

												$choice = Choice::model()->findByPk($key);
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

												$choice = Choice::model()->findByPk($key);
												echo 	CHtml::dropDownList(
													'dropdownVal[]',
													$selected_value = $selected,
													$Type4Answer,
													array('empty' => UserModule::t('Choose'), 'class' => 'dropdown_value', 'id' => 'Q' . $key)
													) . ' <label>
												' . CHtml::decode($choice->choice_detail) . '
												</label>';
												echo '<br>';
												$countQuest++;
											}
											?>
											<?php if($model->ques_type == 6 ){ echo "</ul>"; } ?>
										</div>
									</div>
									<!-- <button type="submit" class="btn btn-warning center-block">ส่งคำตอบ</button> -->
									<?php if($model->ques_type == 6 ){ 
										?>
										<input type="hidden" id="answer_sort" name="answer_sort" value="<?php echo implode(",", $choiceData); ?>">
										<?php
									} ?>
									<?php
									echo CHtml::hiddenField("Question_type[" . $model->ques_id . "]", $questionTypeArray[$model->ques_type]);
									echo CHtml::hiddenField("last_ques");
									echo CHtml::hiddenField("actionEvnt");
									echo CHtml::hiddenField("lesson_id", $lesson->id);
									echo CHtml::hiddenField("idx_now", $currentQuiz->number);
									?>
									<div class="text-center">
										<?php 
										if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
											$Previous = "Previous";
											$Next = "Next";
										}else{  
											$Previous = "ก่อน";
											$Next = "ถัดไป";
										}
										?>
										<?php echo CHtml::tag('button', array('class' => 'submit btn btn-info btn-lg', 'onclick' => 'save_ans("previous")'), $Previous); ?>
										<?php echo CHtml::tag('button', array('class' => 'submit btn btn-info btn-lg', 'onclick' => 'save_ans("next")'), $Next); ?>
										<!-- 	<.?php if($last_ques==1)echo CHtml::tag('button', array('class' => 'submit btn btn-success btn-lg','onclick'=>'save_ans("save")'), 'ส่งคำตอบ'); ?> -->
									</div>
								</div>
								<div class="col-md-4">
									<div class="all-exams">
										<div class="exams-title">
											<?=$Question?> <span class="pull-right"><?= $countExam . ' / ' . count($temp_all); ?></span>
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
														/*$this->createUrl('index',array('id'=>$lesson->id,'number'=>$val_temp->number));*/
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
									<center style="margin-top: 80px">
										<?php if ($last_ques == 1) echo CHtml::tag('button', array('class' => 'submit btn btn-success btn-lg', 'onclick' => 'save_ans("save")'), UserModule::t('sendQues')); ?>
									</center>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	var interval;
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

		time_test_start('<?= $time_up; ?>');

		// alert('test');
		$(".dropdown_value").each(function() {
			var $self = $(this);
			$self.data("previous_value", $self.val());
		});

		$(".dropdown_value").on("change", function() {
			// alert('test');

			var $self = $(this);
			var prev_value = $self.data("previous_value");
			var cur_value = $self.val();

			$(".dropdown_value").not($self).find("option").filter(function() {
				return $(this).val() == prev_value;
			}).prop("disabled", false);

			if (cur_value != "") {
				$(".dropdown_value").not($self).find("option").filter(function() {
					return $(this).val() == cur_value;
				}).prop("disabled", true);

				$self.data("previous_value", cur_value);
			}
		});

	});

	var arr_li_answer = Array();
	function get_li(){
		arr_li_answer = [];
		$(".li-cute").each(function( index ) {
			arr_li_answer.push($( this ).attr("id"));
		});

		$("#answer_sort").val(arr_li_answer.join())
		// console.log(arr_li_answer.join());
	}

	function save_ans(evnt) {
		$("#actionEvnt").val(evnt);
		if (evnt == 'save' || evnt == 'timeup') {
			$('#last_ques').val(1);
		}
		if ($('#last_ques').val() == 1) {
			$(".submit").button('loading');
			$(".submit").attr('disabled', 'disabled');
		}

		if (evnt == 'save') {

			if(<?= Yii::app()->session['lang'] ?> == 2){
				var title_swal = "ยืนยันเพื่อส่งคำตอบ";
			}else{
				var title_swal = "Confirm to send a reply.";
			}

			swal({
				title: title_swal,
				// text: "(กรุณาตรวจสอบคำตอบของท่านอีกครั้ง !!)",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "<?=$ok?>",
				cancelButtonText: "<?=$cancel?>",
			}, function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						url: "<?php echo Yii::app()->createUrl("question/index", array('type' => $testType)); ?>",
						type: "POST",
						data: $("#question-form").serialize(),
						success: function(data) {
							if ($('#last_ques').val() == 1) {
								var url = '<?php echo Yii::app()->createUrl('question/exams_finish', array('id' => $lesson->id, 'type' => $testType)); ?>';
								if (evnt == 'save') {
									var strMsg = '<?= UserModule::t('success_test'); ?>';
									var typeMsg = 'success';
								} else {
									var strMsg = '<?= UserModule::t('fail_test'); ?>';
									var typeMsg = 'warning';
								}
								// swal({
								// 	title: "<?= UserModule::t('success_test'); ?>",
								// 	text: '',
								// 	type: typeMsg,
								// 	confirmButtonText: "OK",
								// },
								function() {
										$('#exam-result').html(data); //window.location.href = url;
									});
							} else {
								$('#ques-show').html(data);
							}
						},
						complete: function() {
							$(".submit").button('reset');
						}
					});
				} else {
					$('#last_ques').val(2);
					$(".submit").button('reset');
				}
			});

		} else {
			$.ajax({
				url: "<?php echo Yii::app()->createUrl("question/index", array('type' => $testType)); ?>",
				type: "POST",
				data: $("#question-form").serialize(),
				success: function(data) {
					if ($('#last_ques').val() == 1) {
						var url = '<?php echo Yii::app()->createUrl('question/exams_finish', array('id' => $lesson->id, 'type' => $testType)); ?>';
						if (evnt == 'save') {
							var strMsg = '<?= UserModule::t('success_test'); ?>';
							var typeMsg = 'success';
						} else {
							var strMsg = '<?= UserModule::t('fail_test'); ?>';
							var typeMsg = 'warning';
						}
						swal({
							title: "<?= UserModule::t('success_test'); ?>",
							text: '',
							type: typeMsg,
							confirmButtonText: "<?=$ok?>",
							cancelButtonText: "<?=$cancel?>",
						},
						function() {
								$('#exam-result').html(data); //window.location.href = url;
							});
					} else {
						$('#ques-show').html(data);
					}
				},
				complete: function() {
					$(".submit").button('reset');
				}
			});
		}
	}

	function time_test_start(time_down) {
		var count = time_down;
		var hours = 0;
		var minutes = 0;
		var seconds = 0;
		var timeStr = '';
		clearInterval(interval);
		interval = setInterval(function() {
			count--;
			var hours = Math.floor(count / 3600);
			var minutes = Math.floor((count - (hours * 3600)) / 60);
			var seconds = count - (hours * 3600) - (minutes * 60);

			if (hours < 10) {
				hours = "0" + hours;
			}
			if (minutes < 10) {
				minutes = "0" + minutes;
			}
			if (seconds < 10) {
				seconds = "0" + seconds;
			}
			timeStr = hours + ':' + minutes + ':' + seconds;
			if (seconds == 0) {
				$.ajax({
					url: "<?php echo Yii::app()->createUrl("question/SaveTimeExam"); ?>",
					type: "POST",
					data: {
						lesson_id: <?= $lesson->id ?>,
						time: count
					},
					success: function(data) {
						console.log(data);
					}
				});
			}

			$("#tabtime").html(timeStr);
			if (count <= 0) {
				clearInterval(interval);
				save_ans('timeup');
			}
		}, 1000);
	}
</script>