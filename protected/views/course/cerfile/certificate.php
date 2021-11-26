<style type="text/css"> 
    body {
        background-image: url("<?php echo Yii::app()->baseUrl."/uploads/certificate/".$model['bgPath']; ?>"); /*test Path image*/
        background-position: 0 0;
        background-image-resize: 1;
        background-repeat: no-repeat;
        font-family: 'dbhelvethaicax';
    }

    div {
        text-align: center;
        <?php if($model['pageSide']=='1'){ ?>
            width: 185mm;
            <?php } else { ?>
                width: 246mm;
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
            .size30 { font-size: 30px; }
            .size32 { font-size: 32px; }
            .size36 { font-size: 36px; }
            .size40 { font-size: 40px; }
            .size50 { font-size: 50px; }
            .dark- { color: #262262; }
            . { color: #4E3892; }
            .dark-yellow { color: #EBA022; }
        </style> 

      <div style="position:absolute; top: 10mm;text-align: center;" ><img width="140mm" src="../admin/images/cer_1.png" ></div>

 <div class="b size30 " style="position:absolute; top: 80mm;">
    Mr.Tester  Tester
</div>

<div style="position:absolute; top: 100mm;" ><img width="90mm" src="../admin/images/cer_2.png" ></div>

<div style="position:absolute; top: 10mm;left: 130mm " ><img width="50mm" src="../admin/images/cer_3.png" ></div>

<!-- padding-left:610px; -->

    
    <div style="position:absolute; top: 125mm;">
     <div class="b size30 ">COURSE TITLE</div>
 </div>







<div style="position:absolute; top: 170mm; <?= $fontTH ?> ">
 <div class="b size30">ให้ไว้ ณ วันที่ <?php echo Helpers::lib()->changeFormatDate(date("Y-m-d")); ?> </div>
</div>
    

