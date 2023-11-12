<?php
$lesson_list = [];
foreach ($array_lesson as $key => $value) {
    $lesson_list[] = $value;
}
$lessons = Lesson::model()->findAll([
    'condition' => 'id IN (' . implode(',', $lesson_list) . ')',
    'order' => 'id ASC',
]);
$Lessonquestion = [];

foreach ($lessons as $key_l => $value_l) {
    $Lmanage_post = Manage::model()->find(["condition" => "id = $value_l->id AND active ='y' AND type='post'"]);
    if (!empty($Lmanage_post)) {
        $Lessonquestion[] = count(Question::model()->findAll(["condition" => "group_id = $Lmanage_post->group_id ", "order" => "ques_id ASC"]));
    }
}

if(count($Lessonquestion) <= 0){
    $Lessonquestion[] = 0;
}
// $Lmanage_pre = Manage::model()->find(["condition" => "id = $value_l->id AND active ='y' AND type='pre'"]);

// var_dump($_GET['Report']['lesson_id']);exit;
$logstart = LogStartcourse::model()->findAll(["condition" => "course_id = $course->course_id"]);
?>
<table border="1" class="table table-bordered table-striped" id="table_datatable">
    <thead>
        <tr>
            <th colspan="11"></th>
            <th class="center" colspan="2">Pre-Test</th>
            <th class="center" colspan="2">Post-Test</th>
            <?php if (count($Lessonquestion) > 0 && max($Lessonquestion) != 0) { ?>
                <th class="center" colspan="<?= max($Lessonquestion) ?>">จำนวนครั้งที่ตอบผิด (No. of Wrong Answer)</th>
            <?php  } ?>
        </tr>
        <tr>
            <th class="center">Lesson Name</th>
            <th class="center">Gen</th>
            <th class="center">Group</th>
            <th class="center">Employee Code</th>
            <th class="center">Name</th>
            <th class="center">Surname</th>
            <th class="center">Department</th>
            <th class="center">Organization Unit</th>
            <th class="center">Abbreviate Code</th>
            <th class="center">Employee Class</th>
            <th class="center">Type</th>
            <th class="center">Score</th>
            <th class="center">Percent</th>
            <th class="center">Score</th>
            <th class="center">Percent</th>
            <?php
            $ques_i = 1;
            for ($max_i = 0; $max_i < max($Lessonquestion); $max_i++) { ?>
                <th class="center">Q<?= $ques_i++ ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($logstart as $log => $val_log) {
            foreach ($lessons as $key_l => $val_l) {
                $ScoreLog = HelperCourseQuest::lib()->getScoreLogLesson($val_log, $val_l);
        ?>
                <tr>
                    <td class="left"><?= $val_l->title ?></td>
                    <td class="center"><?= $val_log->gen_id ?></td>
                    <td class="center"><?= $val_log->pro->group_name ?></td>
                    <td class="center"><?= $val_log->mem->employee_id ?></td>
                    <td class="center"><?= $val_log->pro->firstname ?></td>
                    <td class="center"><?= $val_log->pro->lastname ?></td>
                    <td class="center">-</td>
                    <td class="center"><?= $val_log->pro->organization_unit ?></td>
                    <td class="center"><?= $val_log->pro->abbreviate_code ?></td>
                    <td class="center"><?= $val_log->pro->employee_class ?></td>
                    <td class="center"><?= HelperCourseQuest::lib()->getTypeReferLesson($ScoreLog); ?></td>
                    <?php
                    $score_log_pre = HelperCourseQuest::lib()->getScoresLesson($val_log, $val_l, "pre");
                    ?>
                    <td class="center"><?= $score_log_pre["score"] ?></td>
                    <td class="center"><?= $score_log_pre["percent"] ?></td>
                    <?php
                    $score_log_post = HelperCourseQuest::lib()->getScoresLesson($val_log, $val_l, "post");
                    ?>
                    <td class="center"><?= $score_log_post["score"] ?></td>
                    <td class="center"><?= $score_log_post["percent"] ?></td>
                    <?php
                    $Lmanage_post = Manage::model()->find(["condition" => "id = $val_l->id AND active ='y' AND type='post'"]);
                    $question = [];
                    if (!empty($Lmanage_post)) {
                        $question = Question::model()->findAll(["condition" => "group_id = $Lmanage_post->group_id ", "order" => "ques_id ASC"]);
                    }

                    foreach ($question as $key_q => $val_q) { ?>
                        <td class="center"><?= HelperCourseQuest::lib()->getAnswersLesson($ScoreLog, $val_q->ques_id) ?></td>
                    <?php }

                    for ($q_none = 0; $q_none < (max($Lessonquestion) - count($question)) ; $q_none++) { ?>
                        <td class="center">-</td>
                    <?php } ?>

                </tr>
        <?php    }
        } ?>
    </tbody>
</table>