<!DOCTYPE html>
<?php
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));

    if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
        $langId = Yii::app()->session['lang'] = 1;
    } else {
        $langId = Yii::app()->session['lang'];
    }

    if($langId == 1)
    {
       $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
   }
   else{
     $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
 }
 
 $strMonthThai = $strMonthCut[$strMonth];
 return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}
?>
<html lang="th">

<!-- Head -->
<?php include './include/head.php'; ?>

<body>

    <?php include './include/header.php'; ?>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/banner/index'); ?>">ป้ายประชาสัมพันธ์</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $img_data->imgslide_title; ?></li>
            </ol>
        </nav>
    </div>

    <section class="content" id="banner-news-detail">
        <div class="container">
            <div class="well">
                <div class="news-detail-img">

                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/imgslide/' . $img_data->imgslide_id . '/thumb/' . $img_data->imgslide_picture)) { ?>
                        <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/imgslide/<?php echo $img_data->imgslide_id . '/thumb/' . $img_data->imgslide_picture; ?>" class="img-responsive center-block img-rounded" alt="">
                    <?php } else { ?>
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/slide-news.jpg" class="img-responsive center-block img-rounded" alt="">
                    <?php } ?>

                </div>
            </div>
            <div class="news-detail-content">
                <div class="content-header">
                    <div class="pull-left">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/billboard.png" alt="">
                    </div>
                    <h2><?php echo $img_data->imgslide_title; ?></h2>
                    <?php
                    $id = $img_data->create_by;
                    $create = profile::model()->findbyPk($id);
                    ?>
                    <ul class="list-inline">
                       <?php if($img_data->update_date != null) {?>
                        <li><small><i class="fa fa-calendar"></i> <?php echo DateThai($img_data->update_date) ?></small></li>
                    <?php }else{?>
                     <li><small><i class="fa fa-calendar"></i> <?php echo DateThai($img_data->create_date) ?></small></li>
                 <?php } ?>
                 <!-- <li><small><i class="fa fa-user"></i> <?= $create->firstname; ?> </small></li> -->
             </ul>
         </div>
         <div class="content-detail">
            <?php echo $img_data->imgslide_detail; ?>
        </div>
    </div>
</div>
</section>

<!-- Footer -->
<?php include './include/footer.php'; ?>

<!-- Script -->
<?php include './include/script.php'; ?>

</body>

</html>