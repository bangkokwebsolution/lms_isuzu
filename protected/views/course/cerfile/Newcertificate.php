<head>
    <style type="text/css">
        body { 
            background-image: url('<?= Yii::app()->basePath."/../uploads/certificate/".$model['bgPath']; ?>');
            background-position: 0 0;
            background-image-resize: 1;
            background-repeat: no-repeat;
            /*font-family: 'coco';*/
        }
        .eng{
            font-family: 'coco';
        }
        .th{ 
            font-family: 'kanit';
        }
        div {
            /*font-family: 'dsn_montanaregular', sans-serif;*/
            text-align: center;
            width: 246mm;
            /*width: 200px;*/
            word-wrap: break-word;
        }
        .l { text-align: justify; }
        .b { font-weight: bold; }
        .size16 { font-size: 16px; }
        .size18 { font-size: 18px; }
        .size20 { font-size: 20px; }
        .size22 { font-size: 22px; }
        .size24 { font-size: 24px; }
        .size26 { font-size: 26px; }
        .size28 { font-size: 28px; }
        .size30 { font-size: 30px; }
        .size32 { font-size: 32px; }]
        .size36 { font-size: 36px; }
        .size38 { font-size: 38px; }
        .size40 { font-size: 40px; }
        .size42 { font-size: 42px; }
        .size50 { font-size: 50px; }
        .dark-purple { color: #262262; }
        .purple { color: #4E3892; }
        .dark-yellow { color: #EBA022; }
    </style> 
</head>
<?php ( mb_detect_encoding($model['fulltitle']) == 'ASCII')? $fontType = 'eng' : $fontType = 'th'; ?>
<div class="b size38 <?= $fontType ?>" style="position:absolute; top: 118mm; left: 96px;">
    <?= $model['fulltitle'] ?>
</div>

<?php ( mb_detect_encoding($model['courseTitle']) == 'ASCII')? $fontType = 'eng' : $fontType = 'th'; ?>
<div class="size30 black <?= $fontType ?> l" style="position:absolute;  text-align: center; top: 80mm; left:510px;">
    <div class="b size30 l">"<?= $model['courseTitle'] ?>"</div>
</div>

<!-- div class="size20 black eng" style="position:absolute; top: 138mm; left: -90px ">
   <div class="size20 black"><?= $model['period'] ?></div>
</div> -->

<div class="size16 black eng" style="position:absolute;left: 82mm; top: 160mm">
 <div class="size16 black"><?= $model['endDateCourse'] ?></div>
</div>

<?php if ($model['renderSign']) {?>

    <div style="position:absolute;  top: 140mm; left: -100px " >
       <img src="<?php  echo Yii::app()->baseUrl."../uploads/signature/".$model['renderSign']; ?>" >
   </div>
<?php } ?>

<!-- <div style="position:absolute; left: 133mm; top: 115mm" >
 <img src="<?php  echo Yii::app()->baseUrl."../uploads/signature/".$model['renderSign2']; ?>" >
</div> -->

<!-- <div style="position:absolute; right: 97mm; top: 167mm;font-family: 'Trirong', serif;" >
    <span class="b size20 purple"><?php echo $model['nameSign']; ?></span>
</div>

<div style="position:absolute; left: 102mm; top: 167mm;font-family: 'Trirong', serif;" >
    <span class="b size20 purple"><?php echo $model['nameSign2']; ?></span>
</div>

<div style="position:absolute; right: 98mm; top: 178mm;font-family: 'Trirong', serif;" >
    <div class="b size22 purple"><?php echo $model['positionSign']; ?></div>
</div>

<div style="position:absolute; left: 103mm; top: 178mm;font-family: 'Trirong', serif;" >
    <div class="b size22 purple"><?php echo $model['positionSign2']; ?></div>
</div> -->