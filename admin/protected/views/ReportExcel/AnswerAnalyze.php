<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=AnswerAnalyze-report.xls");
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        .center {
            text-align: center;
        }
        .table{
            border: solid 1px black;
        }
    </style>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <td colspan="10"></td>
                <?php if (!empty($Cmanage_pre)) { ?>
                    <td class="center" colspan="2">Pre-Test</td>
                <?php  } ?>
                <?php if (!empty($Cmanage_post)) { ?>
                    <td class="center" colspan="2">Post-Test</td>
                <?php  } ?>
                <?php if (!empty($Coursequestion)) { ?>
                    <td class="center" colspan="<?= count($Coursequestion) ?>">จำนวนครั้งที่ตอบผิด (No. of Wrong Answer)</td>
                <?php  } ?>
            </tr>
            <tr>
                <td class="center">Course Name</td>
                <td class="center">Gen</td>
                <td class="center">Group</td>
                <td class="center">Employee Code</td>
                <td class="center">Name</td>
                <td class="center">Surname</td>
                <td class="center">Organization Unit</td>
                <td class="center">Abbreviate Code</td>
                <td class="center">Employee Class</td>
                <td class="center">Type</td>
                <?php if (!empty($Cmanage_pre)) { ?>
                    <td class="center">Score</td>
                    <td class="center">Percent</td>
                <?php  } ?>
                <?php if (!empty($Cmanage_post)) { ?>
                    <td class="center">Score</td>
                    <td class="center">Percent</td>
                <?php  } ?>
                <?php
                $ques_i = 1;
                foreach ($Coursequestion as $key_cq => $val_cq) { ?>
                    <td class="center">Q<?= $ques_i++ ?></td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($logstart as $log => $val_log) {
                $ScoreLog = HelperCourseQuest::lib()->getScoreLog($val_log);
            ?>
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
                    <td class="center"><?= HelperCourseQuest::lib()->getTypeRefer($ScoreLog); ?></td>
                    <?php if (!empty($Cmanage_pre)) {
                        $score_log_pre = HelperCourseQuest::lib()->getScores($val_log, "pre");
                    ?>
                        <td class="center"><?= $score_log_pre["score"] ?></td>
                        <td class="center"><?= $score_log_pre["percent"] ?></td>
                    <?php  } ?>
                    <?php if (!empty($Cmanage_post)) {
                        $score_log_post = HelperCourseQuest::lib()->getScores($val_log, "post");
                    ?>
                        <td class="center"><?= $score_log_post["score"] ?></td>
                        <td class="center"><?= $score_log_post["percent"] ?></td>
                    <?php  } ?>
                    <?php
                    foreach ($Coursequestion as $key_cq => $val_cq) { ?>
                        <td class="center"><?= HelperCourseQuest::lib()->getAnswers($ScoreLog, $val_cq->ques_id) ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>