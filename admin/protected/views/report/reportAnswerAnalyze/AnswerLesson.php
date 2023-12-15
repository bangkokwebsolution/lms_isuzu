<?php
$lesson_list = [];
foreach ($array_lesson as $key => $value) {
    $lesson_list[] = $value;
}
$lessons = Lesson::model()->findAll([
    'condition' => 'id IN (' . implode(',', $lesson_list) . ')',
    'order' => 'id ASC',
]);
$countQuestion = 0;
$list_queston  = [];
foreach ($lessons as $key_l => $value_l) {
    $Lmanage_post = Manage::model()->find(["condition" => "id = $value_l->id AND active ='y' AND type='post'"]);
    if (!empty($Lmanage_post)) {
        $model_ques = Question::model()->findAll(["condition" => "group_id = $Lmanage_post->group_id ", "order" => "ques_id ASC"]);
        $countQuestion = $countQuestion + count($model_ques);
        $list_queston[$value_l->id] = $model_ques;
    }
}

$logstart = LogStartcourse::model()->findAll(["condition" => "course_id = $course->course_id"]);


?>
<table border="1" class="table table-bordered table-striped" id="table_datatable">
    <thead>
        <tr>
            <th colspan="9"></th>
            <?php if ($countQuestion > 0) { ?>
                <th class="center" colspan="2">Post-Test</th>
                <th class="center" colspan="<?= $countQuestion ?>">จำนวนครั้งที่ตอบผิด (No. of Wrong Answer)</th>
            <?php  } ?>
        </tr>
        <tr>
            <th class="center">Course Name</th>
            <th class="center">Gen</th>
            <th class="center">Group</th>
            <th class="center">Employee Code</th>
            <th class="center">Name</th>
            <th class="center">Surname</th>
            <th class="center">Organization Unit</th>
            <th class="center">Abbreviate Code</th>
            <th class="center">Employee Class</th>
            <?php if ($countQuestion > 0) { ?>
                <th class="center">Score</th>
                <th class="center">Percent</th>
                <?php $ques_i = 1;
                for ($max_i = 0; $max_i < $countQuestion; $max_i++) { ?>
                    <th class="center">Q<?= $ques_i++ ?></th>
            <?php
                }
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($logstart as $log => $val_log) { ?>
            <tr>
                <td class="left"><?= $course->course_title ?></td>
                <td class="center"><?= $val_log->gen_id ?></td>
                <td class="center"><?= $val_log->pro->group_name ?>&nbsp;</td>
                <td class="center"><?= $val_log->mem->employee_id ?>&nbsp;</td>
                <td class="center"><?= $val_log->pro->firstname ?></td>
                <td class="center"><?= $val_log->pro->lastname ?></td>
                <td class="center"><?= $val_log->pro->organization_unit ?>&nbsp;</td>
                <td class="center"><?= $val_log->pro->abbreviate_code ?>&nbsp;</td>
                <td class="center"><?= !empty($val_log->pro->EmpClass->title) ? $val_log->pro->EmpClass->title : "" ?></td>
                <?php
                $score_log_post =  HelperCourseQuest::lib()->sumLessonPosttest($lessons, $list_queston, $val_log);
                if ($countQuestion > 0) { ?>
                    <td class="center"><?= $score_log_post["score"] ?></td>
                    <td class="center"><?= $score_log_post["percent"] ?></td>
                    <?php foreach ($score_log_post["answer_list"] as $key_ans => $val_ans) { ?>
                        <td class="center"><?= $val_ans ?></td>
                <?php   }
                }
                ?>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>