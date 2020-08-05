<?php

 $strExcelFileName = "ภาพรวมผลการเรียนรายหลักสูตร-" . date('Ymd-His') . ".xls";
      header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
      header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
      header('Content-Type: text/plain; charset=UTF-8');
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Pragma:no-cache");
?>
     
     <!DOCTYPE html>
     <html>
     <head>
     	<title></title>
     </head>
     <body>
     <img src="<?= Yii::app()->basePath."/../uploads/AttendPrint.png"; ?>">
     </body>
     </html>
