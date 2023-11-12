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

        .table {
            border: solid 1px black;
        }
    </style>
</head>

<body>
    <?php
    $this->renderPartial("../report/reportAnswerAnalyze/AnswerLesson", [
        'course' => $course,
        'array_lesson' => $array_lesson,
    ])
    ?>
</body>

</html>