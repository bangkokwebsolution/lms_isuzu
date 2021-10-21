 <?php $strExcelFileName = 'Questionaire-' . date('Ymd-His') . ".xls";
  header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
  header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
  header('Content-Type: text/plain; charset=UTF-8');
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Pragma:no-cache");
  ?>

 <BODY>
   <?php
    $header_id = $QHeader->survey_header_id;
    $passQuest = QQuestAns::model()->findAll(array(
      'select' => 'id ',
      'condition' => 'header_id =' . $header_id . '',
    ));
    $url = Yii::app()->createAbsoluteUrl('filedownloads/load/');
    $url = str_replace("admin/", "", $url);
    $url = str_replace("index.php/", "", $url);
    ?>

   <h1><?= $QHeader->survey_name ?> (จำนวนผู้ทำแบบประเมิน : <?= count($passQuest) ?>)</h1>
   <?php echo CHtml::decode($QHeader->instructions); ?>

   <?php foreach ($QHeader->sections as $keySections => $valueSections) { ?>
     <h2><?= $valueSections->section_title ?></h2>
     <div class="innerLR">
       <div class="widget" style="margin-top: -1px;">
         <div class="widget-body div-table" style="overflow: auto;">
           <!-- Table -->
           <table class="table table-bordered toggleairasia-table" style="width: 100%">
             <!-- Table heading -->
             <thead>
               <tr style="background-color: #e476e8;border: 1.5px solid #000;">
                 <th rowspan="2" style="vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b>ลำดับ</b></th>
                 <th rowspan="2" style="width:200px; vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b>วัน/เวลา</b></th>
                 <?php foreach ($valueSections->questions as $keyQuestions => $valueQuestions) {
                    if ($valueQuestions->input_type_id == "2" || $valueQuestions->input_type_id == "3" || $valueQuestions->input_type_id == "4") { ?>
                     <th colspan="<?= count($valueQuestions->choices) ?>"  style="width:200px; vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b><?= $valueQuestions->question_name ?></b></th>
                   <?php }
                    if ($valueQuestions->input_type_id == "5" || $valueQuestions->input_type_id == "1") { ?>
                     <th colspan="1" style="vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b><?= $valueQuestions->question_name ?></b></th>
                   <?php }

                    if ($valueQuestions->input_type_id == "6") { ?>
                     <th rowspan="2" style="vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b><?= $valueQuestions->question_name ?></b></th>
                     <th rowspan="2" style="vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b>link download</b></th>
                 <?php }
                  } ?>
               </tr>
               <tr style="background-color: #e476e8;border: 1.5px solid #000;">
                 <?php foreach ($valueSections->questions as $keyQuestions => $valueQuestions) {
                    if ($valueQuestions->input_type_id == "2" || $valueQuestions->input_type_id == "3" || $valueQuestions->input_type_id == "4") { ?>
                     <?php foreach ($valueQuestions->choices as $choiceKey => $ChoiceValue) { ?>
                       <th  rowspan="1" style="vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b><?= $ChoiceValue->option_choice_name ?></b></th>
                     <?php } ?>
                   <?php }
                    if ($valueQuestions->input_type_id == "5" || $valueQuestions->input_type_id == "1") { ?>
                     <th rowspan="1" style="vertical-align: middle;text-align: center;border: 1.5px solid #000;" class="center"><b>คำตอบบรรยาย</b></th>
                   <?php } ?>
                 <?php }
                  ?>
               </tr>

             </thead>

             <tbody>
               <?php
                $passQuest = QQuestAns::model()->findAll(array(
                  'condition' => 't.header_id =' . $header_id . '',
                ));
                ?>
               <?php
                foreach ($passQuest as $keypassQuest => $valuepassQuest) {
                ?>
                 <tr style="border: 1.5px solid #000;">
                   <td style="text-align: center;border: 1.5px solid #000;"><?= $keypassQuest + 1 ?></td>
                   <?php $date = Helpers::lib()->changeFormatDate($valuepassQuest->date, 2, "datetime"); ?>
                   <td style="text-align: center;border: 1.5px solid #000;"><?= $date ?>&nbsp;</td>

                   <?php foreach ($valueSections->questions as $keyQuestions => $valueQuestions) {
                      // $array_ans = QAnswers_course::model()->findAll(array(
                      //         'condition' => 'quest_ans_id = ' . $valuepassQuest->id . ' AND user_id =' . $valuepassQuest->user_id . '',
                      // ));
                      $array_QAnswers_course = QAnswers::model()->findAll(array(
                        'select' => 't.choice_id , t.answer_numeric ,t.answer_text,t.answer_textarea,t.answer_id',
                        'group' => 't.choice_id , t.answer_numeric ,t.answer_text,t.answer_textarea,t.answer_id',
                        'condition' => 't.quest_ans_id = ' . $valuepassQuest->id,
                      ));
                      $array_ans = array();
                      $array_ans_numeric = array();
                      $array_ans_text = array();
                      $array_ans_textarea = array();
                      $array_ans_file_name_original = array();
                      $array_ans_file_name_random = array();
                      foreach ($array_QAnswers_course as $keyQAnswers_course => $valueQAnswers_course) {
                        $array_ans[] = $valueQAnswers_course->choice_id;
                        $array_ans_numeric[$valueQAnswers_course->choice_id] = $valueQAnswers_course->answer_numeric;
                        $array_ans_text[$valueQAnswers_course->choice_id] = $valueQAnswers_course->answer_text;
                        $array_ans_textarea[$valueQAnswers_course->choice_id] = $valueQAnswers_course->answer_textarea;
                        // $array_ans_file_name_original[$valueQAnswers_course->choice_id] = $valueQAnswers_course->file_name_original;
                        $array_ans_answer_id[$valueQAnswers_course->choice_id] = $valueQAnswers_course->answer_id;
                      }
                      if ($valueQuestions->input_type_id == "2" || $valueQuestions->input_type_id == "3" || $valueQuestions->input_type_id == "4") { ?>
                       <?php foreach ($valueQuestions->choices as $choiceKey => $ChoiceValue) { ?>
                         <td style="text-align: center;border: 1.5px solid #000;"  >
                           <?php if ($valueQuestions->input_type_id == "4") { ?>
                             <?= $array_ans_numeric[$ChoiceValue->option_choice_id] ?>
                           <?php } else { ?>
                             <?php if (in_array($ChoiceValue->option_choice_id, $array_ans)) { ?>
                               / <?= $array_ans_text[$ChoiceValue->option_choice_id] ?>
                             <?php } ?>
                           <?php } ?>
                         </td>
                       <?php } ?>
                     <?php }
                      if ($valueQuestions->input_type_id == "5") { ?>
                       <td style="text-align: center;border: 1.5px solid #000;">
                         <?php foreach ($valueQuestions->choices as $choiceKey => $ChoiceValue) { ?>
                           <?php if (in_array($ChoiceValue->option_choice_id, $array_ans)) { ?>
                             <?= $array_ans_textarea[$ChoiceValue->option_choice_id] ?>
                           <?php } ?>
                         <?php } ?>
                       </td>
                     <?php }
                      if ($valueQuestions->input_type_id == "1") { ?>
                       <?php foreach ($valueQuestions->choices as $choiceKey => $ChoiceValue) { ?>
                         <td style="text-align: center;border: 1.5px solid #000;">
                           <?php if (in_array($ChoiceValue->option_choice_id, $array_ans)) { ?>
                             <?= $array_ans_text[$ChoiceValue->option_choice_id] ?>
                           <?php } ?>
                         </td>
                       <?php } ?>
                     <?php }
                      if ($valueQuestions->input_type_id == "6") { ?>
                       <td style="text-align: center;border: 1.5px solid #000;">
                         <?php foreach ($valueQuestions->choices as $choiceKey => $ChoiceValue) { ?>
                           <?php if (in_array($ChoiceValue->option_choice_id, $array_ans)) { ?>
                             <?= $array_ans_file_name_original[$ChoiceValue->option_choice_id] ?>
                           <?php } ?>
                         <?php } ?>
                       </td>
                     <?php }
                      if ($valueQuestions->input_type_id == "6") { ?>
                       <td style="text-align: center;border: 1.5px solid #000;">
                         <?php foreach ($valueQuestions->choices as $choiceKey => $ChoiceValue) { ?>
                           <?php if (in_array($ChoiceValue->option_choice_id, $array_ans)) { ?>
                             <?= $url . '/' . $array_ans_answer_id[$ChoiceValue->option_choice_id]; ?>
                           <?php } ?>
                         <?php } ?>
                       </td>
                   <?php }
                    } ?>
                 </tr>
               <?php }
                ?>
             </tbody>
           </table>
         </div>
       </div>
     </div>
     <hr>
   <?php  } ?>

 </BODY>