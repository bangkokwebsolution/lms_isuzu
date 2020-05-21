<style type="text/css">
    body {
        /*background-image: url("/lms_airasia/admin/protected/../../uploads/certificate/5ea13923b42b7_13434763.png");*/
        background-image: url('<?= Yii::app()->basePath."/../../uploads/certificate/".$model['bgPath']; ?>');
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
        /*background-color: red;*/
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
        Mr.Tester  Tester
    </div>
    <div style="position:absolute; top: 120mm;">
     <div class="b size40 red">COURSE TITLE</div>
    </div>
    <div style="position:absolute; top: 150mm; left:30mm;">
     <div class="size16">10th December 2020</div>
    </div> 
    <div style="position:absolute; top: 177mm;">
       <div class="size12">
           This course is intended to provide with understanding of IMO 2020 Global Sulphur regulation and the ship implementation plan in accorddance with the regulation 14.1.3 of MARPOL Annex VI.
       </div>
    </div> 

    <?php if ($model['renderSign']) {?>
    <div style="position:absolute; top: 190mm; left: -170px;" >
         <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>" >
        <!-- <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/sign_border.png"; ?>" > -->
    </div>
<?php } ?>
<?php if ($model['renderSign2']) {?>
<div style="position:absolute; top: 190mm; right: -170px;" >
    <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign2']; ?>" >
    <!-- <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/sign_border.png"; ?>" > -->
</div>
<?php } ?>
        <?php
    } else {
        ?>

        <div style="position:absolute; top: 70mm;">
           <div class="b size40 red">"COURSE TITLE"</div>
       </div>

        <div class="b size36 " style="position:absolute; top: 115mm;">
            Mr.Tester  Tester
        </div>

        <div style="position:absolute; top: 132mm;">
         <div class="size12">
             This course is intended to provide with understanding of IMO 2020 Global Sulphur regulation and the ship implementation plan in accorddance with the regulation 14.1.3 of MARPOL Annex VI.
         </div>
     </div> 

<?php if ($model['renderSign']) {?>
    <div style="position:absolute; top: 138mm;left: -130px;" >
        <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>" >
    </div>
<?php } ?>
<?php if ($model['renderSign2']) {?>
<div style="position:absolute; top: 138mm; right: -130px;" >
    <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign2']; ?>" >
    <!-- <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/sign_border.png"; ?>" > -->
</div>
<?php } ?>

       <div class="size20 black" style="position:absolute; top: 177mm; left: 280px ">
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


