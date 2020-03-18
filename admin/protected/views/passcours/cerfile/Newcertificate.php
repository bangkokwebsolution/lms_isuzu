<style type="text/css">
    body {
        /* background-image: url("<?= Yii::app()->baseUrl."/../../uploads/certificate/".$model['bgPath']; ?>");  */
        background-image: url('<?= Yii::app()->getBaseUrl(true)."/../uploads/certificate/".$model['bgPath']; ?>');
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
        text-align: center;
        <?php if($model['pageSide']=='1'){ ?>
            width: 185mm;
            <?php } else { ?>
                width: 260mm;
                <?php } ?>
                /*background-color: red;*/
            }
            .b {}
            .size16 { font-size: 16px; }
            .size18 { font-size: 18px; }
            .size20 { font-size: 20px; }
            .size22 { font-size: 22px; }
            .size24 { font-size: 24px; }
            .size26 { font-size: 26px; }
            .size28 { font-size: 28px; }
            .size30 { font-size: 30px; }
            .size32 { font-size: 32px; }
            .size36 { font-size: 36px; }
            .size40 { font-size: 40px; }
            .size50 { font-size: 50px; }
            .dark- { color: #262262; }
            . { color: #4E3892; }
            .dark-yellow { color: #EBA022; }
            .word-wrap {
                word-wrap: break-word;
            } 
        </style>

        <?php if($model['pageSide']=='1'){ ?>
        <div class="b size32 " style="position:absolute; top: 70mm;">
            วุฒิบัตรฉบับนี้ให้ไว้เพื่อแสดงว่า
        </div>

        <div class="b size32 " style="position:absolute; top: 85mm; font-weight: bold;">
            <?= $model['fulltitle'] ?>
        </div>
        <div class="b size32 " style="position:absolute; top: 100mm;">
            ได้รับการอบรมครบถ้วนตามหลักสูตร
        <div class="b size30 " style="position:absolute; top: 115mm; font-weight: bold;">
            <?= $model['courseTitle'] ?>
        </div>

        <div class="b size26 " style="position:absolute; top: 200mm;">
            ให้ไว้ ณ วันที่ <?= Helpers::lib()->changeFormatDate(date('Y-m-d')) ?>
        </div>

        <!-- <img src="" id="tableBanner" /> -->
        <div style="position:absolute; top: 215mm;" >
            <img src="<?= Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>">
        </div>
        <div style="position:absolute; top: 250mm;" >
            <span class="b size26 "><?php echo $model['nameSign']; ?></span>
        </div>
        <div style="position:absolute; top: 260mm;" >
            <div class="b size26 "><?php echo $model['positionSign']; ?></div>
        </div>
        <div class="b size26 " style="position:absolute; top: 270mm; ">
            สมาคมบริษัทหลักทรัพย์ไทย
        </div>
        <?php
    } else {
        ?>

<?php ( mb_detect_encoding($model['fulltitle']) == 'ASCII')? $fontType = 'eng' : $fontType = 'th'; ?>
<!-- $model['pageSide']=='2' -->
<?php if (!empty($model['fulltitle'])) { ?>
<div class="b size36 <?= $fontType ?>" style="position:absolute; top: 65mm; left: -190px;">
            <?= $model['fulltitle'] ?>
</div>
<?php } ?>

<?php ( mb_detect_encoding($model['courseTitle']) == 'ASCII')? $fontType = 'eng' : $fontType = 'th'; ?>
<?php if (!empty($model['courseTitle'])) { ?>
<div class="size26 black <?= $fontType ?>" style="position:absolute; top: 110mm; left: 130px;word-break: break-all;  display : inline-block; max-width: 600px; min-width: 350px; width: 600px; overflow: auto; text-align: left !important;">
   <div class="b size26 purple">"<?= $model['courseTitle'] ?>"</div>
</div>
<?php } ?>

<div class="size20 black eng" style="position:absolute; top: 138mm; left: -120px">
   <div class="size20 black"><?= $model['period'] ?></div>
</div>

<div class="size16 black eng" style="position:absolute; top: 148mm; left: -157px">
   <div class="size16 black"><?= $model['endDateCourse'] ?></div>
</div>


<!-- Date*************** -->
<!-- <?php
    if($model['endLearnDate'] != null) {
        $date = explode(' ',Helpers::lib()->changeFormatDate($model['endLearnDate']));
?>
<div class="size40 black" style="position:absolute; top: 145mm; left: -20px">
     <?= Helpers::lib()->changethainum($date[0]) ?>
</div>

<div class="size40 black" style="position:absolute; top: 145mm; right: 20px">
     <?= $date[1] ?>
</div>

<div class="size40 black" style="position:absolute; top: 145mm; right: -190px">
     <?= Helpers::lib()->changethainum($date[2]) ?>
</div>
<?php
    }
?> -->

<!-- Signature********************
 --><div style="position:absolute; left: 120mm; top: 86mm" >
    <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>" >
</div>

<div style="position:absolute; left: 120mm; top: 115mm" >
    <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign2']; ?>" >
</div>

<!-- <div style="position:absolute; right: 90mm; top: 167mm;font-family: 'Trirong', serif;" >
    <span class="b size20 purple"><?php echo $model['nameSign']; ?></span>
</div>

<div style="position:absolute; left: 94mm; top: 167mm;font-family: 'Trirong', serif;" >
    <span class="b size20 purple"><?php echo $model['nameSign2']; ?></span>
</div>

<div style="position:absolute; right: 90mm; top: 178mm;font-family: 'Trirong', serif;" >
    <div class="b size24 purple"><?php echo $model['positionSign']; ?></div>
</div>

<div style="position:absolute; left: 97mm; top: 178mm;font-family: 'Trirong', serif;" >
    <div class="b size24 purple"><?php echo $model['positionSign2']; ?></div>
</div> -->

    <?php
}
    ?>


