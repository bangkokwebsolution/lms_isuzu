<style type="text/css">
    body {
        /*background-image: url("/lms_airasia/admin/protected/../../uploads/certificate/5b7456efd1fc8_23380785.jpg");*/
        background-image: url('<?= Yii::app()->getBaseUrl(true)."/../uploads/certificate/".$model['bgPath']; ?>');
        background-position: 0 0;
        background-image-resize: 1;
        background-repeat: no-repeat;
        font-family: 'coco';
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

<!-- $model['pageSide']=='2' -->
<div class="b size36 " style="position:absolute; top: 120mm; left: 60px;">
            Mr.Tester  Tester
</div>
<div class="size40 black" style="position:absolute; top: 85mm; left: 60px;">
   <div class="b size40 purple">"COURSE TITLE"</div>
</div>


<div class="size20 black" style="position:absolute; top: 158mm; left: 280px ">
   <div class="size20 black">3 - 4 May 2018</div>
</div>

<!-- Date*************** -->
<?php
    if($model['endLearnDate'] != null) {
        $date = explode(' ',Helpers::lib()->changeFormatDate($model['endLearnDate']));
?>
<div class="size40 black" style="position:absolute; top: 145mm; left: -20px">
     <?= Helpers::lib()->changethainum($date[0]) ?>
</div>

<div class="size40 black" style="position:absolute; top: 145mm; right: 85px">
     <?= $date[1] ?>
</div>

<div class="size40 black" style="position:absolute; top: 145mm; right: -110px">
     <?= Helpers::lib()->changethainum($date[2]) ?>
</div>
<?php
    }
?>

<!-- Signature********************
 -->
 <?php if ($model['renderSign']) {?>
 <div style="position:absolute; top: 135mm;left: -130px;" >
    <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>" >
</div>
<?php } ?>

<div style="position:absolute; top: 135mm;left: 60px;" >
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


