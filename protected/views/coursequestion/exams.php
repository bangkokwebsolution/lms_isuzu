    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style type="text/css">
    	p {
    		display: inline;
    	}
    </style>
    <?php
    if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
        $langId = 1;
        $ques_title = 'Question';
        $type_ques = 'The exams';
        $questionTypeArrayStr = array(1 => 'Multiple Choices', 2 => 'The exams can choose only one answer.', 3 => 'Essay Test', 4 => 'Matching Test', 6 => 'Alignment Test');
    }else{
        $langId = 2;
        $ques_title = 'คำถาม';
        $type_ques = 'ข้อสอบแบบ';
        $questionTypeArrayStr = array(1 => 'ข้อสอบแบบ เลือกได้หลายคำตอบ', 2 => 'ข้อสอบแบบ เลือกได้คำตอบเดียว', 3 => 'ข้อสอบแบบ คำตอบแบบบรรยาย', 4 => 'ข้อสอบแบบ คำตอบแบบจับคู่', 6 => 'ข้อสอบแบบ คำตอบแบบจัดเรียง');
    }

    ?>
    <div id="exam-result">
    	<div class="container">
    		<nav aria-label="breadcrumb">
    			<ol class="breadcrumb breadcrumb-main">
    				<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $labelCourse->label_course; ?></a>
                        <li class="breadcrumb-item active" aria-current="page"><?= $course->course_title; ?></li>
                    </ol>
                </nav>
            </div>
            <section class="content" id="exams">
              <div class="container">

                 <div class="">
                    <div class="timer">Time: &nbsp;<span id="tabtime">00:00:00</span></div>
                </div>

    				<!-- <div class="col-lg-9">
    						<div class="coursequestion-num owl-carousel owl-theme stage-margin nav-style-1 mb-0">
    							<div class='exam-nav'>
										<div  class="nav-item" >1 </div>
    							</div>
    						</div>
    					</div> -->
                        

                <div class="well">
                   <div class="exams">
                      <div class="row">
                         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="ques-show">
                              <div class="col-lg-12" id="exams_first_bar">
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
                                        <div class="well answer">
                                           <?php
                                           $ansData = json_decode($currentQuiz->ans_id);
                                           $choiceData = json_decode($currentQuiz->question);
                                           $arrType4Answer = array();

                                           if ($model->ques_type == 6) {
                                              ?>
                                              <ul id='sortable' style='cursor: pointer;'>
                                                 <?php
                                                 if (!empty(json_decode($currentQuiz->ans_id))) {
                                                   $choiceData = json_decode($currentQuiz->ans_id);
                                               }
                                           }


                                           if ($model->ques_type == 3) {
                                            echo '										
                                            <textarea class="examsta" rows="4" cols="50" name="lecture" >' . $currentQuiz->ans_id . '</textarea>
                                            ';
                                        } else {
																$countchoice = 1; // นับตัวเลือกข้อสอบแบบจับคู่
																foreach ($choiceData as $key => $val_choice) {
																	$choice = Coursechoice::model()->findByPk($val_choice);
																	$checked = '';
																	if (in_array($choice->choice_id, $ansData)) {
																		$checked = 'checked';
																	}
																	if ($model->ques_type == 1) {
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
                                                 }
                                             }

                                             if ($model->ques_type == 4) {
                                                echo '<label> ส่วนที่ 1 </label> <br>';
                                            }


                                            foreach ($Type4Answer as $key => $val_1) {

                                                $choice = Coursechoice::model()->findByPk($key);
                                                echo 	'<div style="display:inline-block">' . $val_1 . '. ' . CHtml::decode($choice->choice_detail) . '</div>';
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
                                                   array('empty' => 'เลือก', 'class' => 'dropdown_value', 'id' => 'Q' . $key)
                                                   ) . ' <label>
                                               ' . CHtml::decode($choice->choice_detail) . '
                                               </label>';
                                               echo '<br>';
                                               $countQuest++;
                                           }

                                           ?>
                                           <?php if ($model->ques_type == 6) {
                                            echo "</ul>";
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
                                ?>
                                <div class="text-center">
                                    <?php
                                    if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                                      $Previous = "Previous";
                                      $Next = "Next";
                                  } else {
                                      $Previous = "ก่อน";
                                      $Next = "ถัดไป";
                                  }
                                  ?>
                                  <?php echo CHtml::tag('button', array('class' => 'submit btn btn-outline btn-rounded btn-dark btn-lg', 'onclick' => 'save_ans("previous")'), $Previous); ?>
                                  <?php echo CHtml::tag('button', array('class' => 'submit btn btn-outline btn-rounded btn-dark btn-lg', 'onclick' => 'save_ans("next")'), $Next); ?>
                                  <?php if ($last_ques == 1) echo CHtml::tag('button', array('class' => 'submit btn btn-success btn-lg', 'onclick' => 'save_ans("save")'), UserModule::t('sendQues')); ?>
    												<!-- <?php //if($last_ques==1)echo CHtml::tag('button', array('class' => 'submit btn btn-success btn-lg','onclick'=>'save_ans("save")'), 'ส่งคำตอบ'); 
                                                 ?> -->
                                             </div>
                                         </form>
                                     </div>

                                 </div>
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

       function get_li() {
          arr_li_answer = [];
          $(".li-cute").each(function(index) {
             arr_li_answer.push($(this).attr("id"));
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
    		$.ajax({
    			url: "<?php echo Yii::app()->createUrl("coursequestion/index") . "?type=" . $_GET['type']; ?>",
    			type: "POST",
    			data: $("#question-form").serialize(),
    			success: function(data) {
    				if ($('#last_ques').val() == 1) {
    					var url = '<?php echo Yii::app()->createUrl('coursequestion/exams_finish', array('id' => $course->course_id, 'type' => $_GET['type'])); ?>';
    					if (evnt == 'save') {
    						// var strMsg = 'คุณทำข้อสอบสำเร็จ';
    						var strMsg = '';
    						var typeMsg = 'success';
    					} else {
    						var strMsg = 'Time out';
    						var typeMsg = 'warning';
    					}
    					swal({
                         title: "Completed",
                         text: strMsg,
                         type: typeMsg,
                         confirmButtonText: "OK",
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
    					url: "<?php echo Yii::app()->createUrl("coursequestion/SaveTimeExam") . "?type=" . $_GET['type']; ?>",
    					type: "POST",
    					data: {
    						course_id: <?= $course->course_id ?>,
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