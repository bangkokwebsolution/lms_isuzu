<?php
function standard_deviation($array_value, $xbar)
{
    $count = count($array_value);
    $sum = 0.00;
    $sumcount = array_sum($array_value);
    for ($i = 0; $i < $count; $i++){
        $x = $count - $i;
        $sum += pow($x-$xbar, 2) * ($array_value[$i]);
    }
    $final_sum = $sum/($sumcount-1);
    return number_format(sqrt($final_sum), 2);
}
function checkRange($val,$max){
    switch ($max) {
        case 5:
                if($val >= 4.21){
                    $msg_range = "มากที่สุด";
                }else if($val >= 3.41){
                    $msg_range = "มาก";
                }else if($val >= 2.61){
                    $msg_range = "ปานกลาง";
                }else if($val >= 1.81){
                    $msg_range = "น้อย";
                }else if($val >= 0){
                    $msg_range = "น้อยมาก";
                }
        break;
        case 10:
                if($val >= 8.42){
                    $msg_range = "มากที่สุด";
                }else if($val >= 6.82){
                    $msg_range = "มาก";
                }else if($val >= 5.22){
                    $msg_range = "ปานกลาง";
                }else if($val >= 3.62){
                    $msg_range = "น้อย";
                }else if($val >= 0){
                    $msg_range = "น้อยมาก";
                }
        break;
    }
    return $msg_range;
}
?>

<style>
    th, .redclr {
        background-color: #E25F39;
        color: white;
    }
</style>

<?php
    if ($_GET['all'] == 0){
        $course = CourseOnline::model()->findByPk($_GET['id']);
        $courseteacher = CourseTeacher::model()->find(array('condition' => 'course_id=' . $_GET['id']));
        $sql = 'select * from q_survey_headers where survey_header_id=' . $courseteacher->survey_header_id;
        $question = Yii::app()->db->createCommand($sql)->queryAll();
        $sql = 'select * from q_survey_sections where survey_header_id=' . $courseteacher->survey_header_id;
        $questionsections = Yii::app()->db->createCommand($sql)->queryAll();
?>

<div class="innerLR">
    <div class="widget">
        <div class="widget-head">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>รายงานแบบสอบถามสำหรับหลักสูตร <?= $course->course_title; ?> </h4>
            </div>
        </div>
        <div class="widget-body" style=" overflow-x: scroll;" id="export-table1">
            <h5><b><?= $question[0]['survey_name']; ?></b></h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2" class="center" style="vertical-align:middle;">หัวข้อประเมิน</th>
                        <th colspan="11" class="center">ระดับความพึงพอใจ</th>
                        <th rowspan="2" class="center">x̄</th>
                        <th rowspan="2" class="center">SD</th>
                        <th rowspan="2" class="center">%</th>
                        <th rowspan="2" class="center">ระดับคะแนน</th>
                    </tr>
                    <tr>
                        <?php for ($i = 10; $i > 0; $i--) {?>
                            <th class="center"><?= ($i); ?></th>
                        <?php } ?>
                        <th>ทั้งหมด</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php
                        $user_quest_total = 0;
                        $xbar_total = 0;
                        $q_total = 0;

                        for ($i = 0; $i < count($questionsections); $i ++){
                            ?>
                                <tr>
                                    <td colspan="16" style="color:red;"><b><?= $questionsections[$i]['section_title']; ?></b></td>
                                </tr>
                                <?php 
                                    $sql = "select * from q_questions where survey_section_id=" . $questionsections[$i]['survey_section_id'] . " and input_type_id = 4";
                                    $questtionname = Yii::app()->db->createCommand($sql)->queryAll();
                                    foreach ($questtionname as $value){
                                        echo '<tr>';
                                        echo '<td colspan="16"><b>' . $value['question_name'] . '</b></td>';
                                        echo '</tr>';
                                        $sql = "select * from q_option_choices where question_id=" . $value['question_id'];
                                        $questionoption = Yii::app()->db->createCommand($sql)->queryAll();
                                        $sql = "select * from q_quest_ans_course where course_id=" . $_GET['id'] . " and gen_id=" . $_GET['genid'] . ' and header_id=' . $question[0]['survey_header_id']; 
                                        $useranswer = Yii::app()->db->createCommand($sql)->queryAll();
                                        foreach ($questionoption as $value2){
                                            echo '<tr>';
                                            echo '<td>' . $value2['option_choice_name'] . '</td>';
                                            $score = [];
                                            foreach ($useranswer as $value3){
                                                $sql = "select * from q_answers_course where quest_ans_id=" . $value3['id'] . " and choice_id=" . $value2['option_choice_id'];
                                                $scorequestion = Yii::app()->db->createCommand($sql)->queryRow();
                                                for ($i2 = 10; $i2 > 0; $i2--){
                                                    if ($i2 == $scorequestion['answer_numeric']){
                                                        $score[$i2] ++;
                                                        break;
                                                    }
                                                }
                                            }
                                            $xbarsum = 0;
                                            $sdscore = $score;
                                            for ($i2 = 10; $i2 > 0; $i2--){
                                                if ($score[$i2] == ""){
                                                    $score[$i2] = "0<br>(0.00%)";
                                                    $sdscore[$i2] = 0;
                                                }else{
                                                    $score[$i2] .= "<br>(" . number_format((($score[$i2] * 100) / count($useranswer)), 2, '.', '') . "%)";
                                                    $xbarsum += ($score[$i2] * $i2);
                                                }
                                                echo '<td class="center">' . $score[$i2] . '</td>';
                                            }
                                            $xbar_sum_final = $xbarsum/count($useranswer);
                                            echo '<td class="center">' . count($useranswer) . '</td>';
                                            echo '<td class="center">' . number_format($xbar_sum_final, 2, '.', '') . '</td>';
                                            echo '<td class="center">' .standard_deviation($sdscore, $xbar_sum_final). '</td>';
                                            echo '<td class="center">' . number_format(($xbar_sum_final*100/10), 2, '.', '') . '%</td>';
                                            echo '<td class="center">'. checkRange($xbar_sum_final,10) . '</td>';
                                            echo '</tr>';
                                            $user_quest_total += count($useranswer);
                                            $xbar_total += $xbar_sum_final;
                                            $q_total ++;
                                        }
                                    }
                                ?>
                            <?php
                        }
                    ?>
                    <tr>
                        <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b>รวม</b></td>
                        <td class="right redclr" colspan="11" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= $user_quest_total ?></b></td>
                        <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= number_format(($xbar_total/$q_total), 2, '.', '') ?></b></td>
                        <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b></b></td>
                        <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= number_format((($xbar_total/$q_total) * 100/10), 2, '.', '') ?>%</b></td>
                        <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= checkRange($xbar_total,10) ?></b></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $dataProvider->pagination
            ));
            ?>
        </div>
    </div>
    <button type="button" id="btnExport1" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
</div>

<?php } 
else if ($_GET['all'] == 1){
    // แบบเรียกดูทั้งหมด
    $allcourse = CourseTeacher::model()->findAll(array('condition' => 'survey_header_id='.$_GET['id']));
    if ($allcourse){
        $sql = 'select * from q_survey_headers where survey_header_id=' .$_GET['id'];
        $question = Yii::app()->db->createCommand($sql)->queryAll();
        $sql = 'select * from q_survey_sections where survey_header_id=' .$_GET['id'];
        $questionsections = Yii::app()->db->createCommand($sql)->queryAll();
    ?>
        <div class="innerLR">
            <div class="widget">
                <div class="widget-head">
                    <div class="widget-head">
                        <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>รายงานภาพรวมแบบสอบถาม - <?= $question[0]['survey_name']; ?> </h4>
                    </div>
                </div>
                <div class="widget-body" style=" overflow-x: scroll;" id="export-table2">
                    <h5><b>ภาพรวม <?= $question[0]['survey_name']; ?></b></h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2" class="center" style="vertical-align:middle;">หัวข้อประเมิน</th>
                                <th colspan="11" class="center">ระดับความพึงพอใจ</th>
                                <th rowspan="2" class="center">x̄</th>
                                <th rowspan="2" class="center">SD</th>
                                <th rowspan="2" class="center">%</th>
                                <th rowspan="2" class="center">ระดับคะแนน</th>
                            </tr>
                            <tr>
                                <?php for ($i = 10; $i > 0; $i--) {?>
                                    <th class="center"><?= ($i); ?></th>
                                <?php } ?>
                                <th>ทั้งหมด</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php
                                $user_quest_total = 0;
                                $xbar_total = 0;
                                $q_total = 0;

                                for ($i = 0; $i < count($questionsections); $i ++){
                                    ?>
                                        <tr>
                                            <td colspan="16" style="color:red;"><b><?= $questionsections[$i]['section_title']; ?></b></td>
                                        </tr>
                                        <?php 
                                            $sql = "select * from q_questions where survey_section_id=" . $questionsections[$i]['survey_section_id'] . " and input_type_id = 4";
                                            $questtionname = Yii::app()->db->createCommand($sql)->queryAll();
                                            foreach ($questtionname as $value){
                                                echo '<tr>';
                                                echo '<td colspan="16"><b>' . $value['question_name'] . '</b></td>';
                                                echo '</tr>';
                                                $sql = "select * from q_option_choices where question_id=" . $value['question_id'];
                                                $questionoption = Yii::app()->db->createCommand($sql)->queryAll();
                                                foreach ($questionoption as $value2){
                                                    // Loop แสดง หัวข้อ
                                                    echo '<tr>';
                                                    echo '<td>' . $value2['option_choice_name'] . '</td>';
                                                    $score = [];
                                                    $useranswerall = [];
                                                    $user_total = 0;

                                                    foreach ($allcourse as $value1){
                                                        $sql = "select * from q_quest_ans_course where course_id=" . $value1->course_id . ' and header_id=' . $question[0]['survey_header_id']; 
                                                        $useranswer = Yii::app()->db->createCommand($sql)->queryAll();
                                                        for ($n = 0; $n < count($useranswer); $n++){
                                                            $sql = "select * from q_answers_course where quest_ans_id=" . $useranswer[$n]['id'] . " and choice_id=" . $value2['option_choice_id'];
                                                            $scorequestion = Yii::app()->db->createCommand($sql)->queryRow();
                                                            $score[$scorequestion['answer_numeric']] ++;
                                                        }
                                                        $user_total += count($useranswer);
                                                    }

                                                    $xbarsum = 0;
                                                    $sdscore = $score;
                                                    for ($i2 = 10; $i2 > 0; $i2--){
                                                        if ($score[$i2] == ""){
                                                            $score[$i2] = "0<br>(0.00%)";
                                                            $sdscore[$i2] = 0;
                                                        }else{
                                                            $score[$i2] .= "<br>(" . number_format((($score[$i2] * 100) / $user_total), 2, '.', '') . "%)";
                                                            $xbarsum += ($score[$i2] * $i2);
                                                        }
                                                        echo '<td class="center">' . $score[$i2] . '</td>';
                                                    }
                                                    $xbar_sum_final = $xbarsum/$user_total;
                                                    echo '<td class="center">' . $user_total . '</td>';
                                                    echo '<td class="center">' . number_format($xbar_sum_final, 2) . '%</td>';
                                                    echo '<td class="center">' . standard_deviation($sdscore, $xbar_sum_final) . '%</td>';
                                                    echo '<td class="center">' . number_format(($xbar_sum_final*100/10), 2) . '%</td>';
                                                    echo '<td class="center">'. checkRange($xbar_sum_final,10) . '</td>';
                                                    echo '</tr>';

                                                    $user_quest_total += $user_total;
                                                    $xbar_total += $xbar_sum_final;
                                                    $q_total ++;
                                                }
                                            }
                                        ?>
                                    <?php
                                }
                            ?>
                            <tr>
                                <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b>รวม</b></td>
                                <td class="right redclr" colspan="11" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= $user_quest_total ?></b></td>
                                <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= number_format(($xbar_total/$q_total), 2) ?>%</b></td>
                                <td class="center redclr" style="white; font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b></b></td>
                                <td class="center redclr" style="white; font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= number_format((($xbar_total/$q_total) * 100/10), 2) ?>%</b></td>
                                <td class="center redclr" style="font-weight: bold; font-size: 1.1em;vertical-align:middle;"><b><?= checkRange($xbar_total,10) ?></b></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <?php
                    $this->widget('CLinkPager', array(
                        'pages' => $dataProvider->pagination
                    ));
                    ?>
                </div>
            </div>
            <button type="button" id="btnExport2" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
        </div>
    <?php }else{
        echo '<h2 style="color:red;">ไม่มีข้อมูล</h2>';
    }

}else{
    echo '<h2 style="color:red;">ไม่มีข้อมูล</h2>';
} ?>


<script>
      $('#btnExport1').click(function(e) {
		var a = document.createElement('a');
		var data_type = 'data:application/vnd.ms-excel';
		var table_div = document.getElementById('export-table1');
		var Html = table_div.outerHTML;
		var table_html = Html.replace(/ /g, '%20');
		a.href = data_type + ', ' + table_html;
        var filename = "<?= "Export-Data-" . date('Ymd-His') . ".xls";?>";
		a.download = filename;
		a.click();
		e.preventDefault();
	});

    $('#btnExport2').click(function(e) {
		var a = document.createElement('a');
		var data_type = 'data:application/vnd.ms-excel';
		var table_div = document.getElementById('export-table2');
		var Html = table_div.outerHTML;
		var table_html = Html.replace(/ /g, '%20');
		a.href = data_type + ', ' + table_html;
        var filename = "<?= "Export-Data-" . date('Ymd-His') . ".xls";?>";
		a.download = filename;
		a.click();
		e.preventDefault();
	});
</script>