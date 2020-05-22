<style type="text/css">
    body {
        background-image: url('<?= Yii::app()->basePath."/../uploads/certificate/".$model['bgPath']; ?>');
        background-position: 0 0;
        background-image-resize: 4;
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
    }
    .b {}
    .size12 { font-size: 12px; }
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
    .red { color: #d05951; }
</style>

<?php if($model['pageSide']=='1'){  // แนวตั้ง
    ?>
    <div class="b size36" style="position:absolute; top: 93mm;">
        <?= $model['fulltitle_en'] ?>
    </div>
    <div style="position:absolute; top: 120mm;">
       <div class="b size40 red"><?= $model['courseTitle_en'] ?></div>
   </div>
   <div style="position:absolute; top: 150mm; left:30mm;">
       <div class="size16">10th December 2020</div>
   </div> 
   <div style="position:absolute; top: 177mm;">
     <div class="size12">
        <?php echo $model['cert_text']; ?>
        <!-- This course is intended to provide with understanding of IMO 2020 Global Sulphur regulation and the ship implementation plan in accorddance with the regulation 14.1.3 of MARPOL Annex VI. -->
    </div>
</div> 

<?php if ($model['renderSign']) {?>
    <div style="position:absolute; top: 190mm; left: -170px;" >
       <img src="<?php echo Yii::app()->basePath."/../uploads/signature/".$model['renderSign']; ?>" >
       <!-- <img src="<?php echo Yii::app()->basePath."/../uploads/signature/sign_border.png"; ?>" > -->
   </div>
<?php } ?>
<?php if ($model['renderSign2']) {?>
    <div style="position:absolute; top: 190mm; right: -170px;" >
        <img src="<?php echo Yii::app()->basePath."/../uploads/signature/".$model['renderSign2']; ?>" >
        <!-- <img src="<?php echo Yii::app()->basePath."/../uploads/signature/sign_border.png"; ?>" > -->
    </div>
<?php } ?>
<?php
    } else { // แนวนอน
        ?>

        <div style="position:absolute; top: 70mm;">
         <div class="b size40 red"><?= $model['courseTitle_en'] ?></div>
     </div>

     <div class="b size36 " style="position:absolute; top: 115mm;">
        <?= $model['fulltitle_en'] ?>
    </div>

    <div style="position:absolute; top: 132mm;">
       <div class="size12">
        <?php echo $model['cert_text']; ?>
        <!-- This course is intended to provide with understanding of IMO 2020 Global Sulphur regulation and the ship implementation plan in accorddance with the regulation 14.1.3 of MARPOL Annex VI. -->
    </div>
</div> 

<?php if ($model['renderSign']) {?>
    <div style="position:absolute; top: 138mm;left: -130px;" >
        <img src="<?php echo Yii::app()->basePath."/../uploads/signature/".$model['renderSign']; ?>" >
    </div>
<?php } ?>
<?php if ($model['renderSign2']) {?>
    <div style="position:absolute; top: 138mm; right: -130px;" >
        <img src="<?php echo Yii::app()->basePath."/../uploads/signature/".$model['renderSign2']; ?>" >
    </div>
<?php } ?>

<div style="position:absolute; top: 177mm; left: 280px ">
    <div class="size18"><?php echo $model['lastPasscourse']; ?></div>
</div>

<?php
}
?>


