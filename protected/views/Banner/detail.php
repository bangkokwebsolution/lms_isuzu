<!DOCTYPE html>
<?php 
function DateThai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}
?>
<html lang="th">

    <!-- Head -->
    <?php include './include/head.php'; ?>

    <body>

        <!-- Header -->
        <?php include './include/header.php'; ?>

        <!-- Header page -->
        <div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
            <div class="container">
                <h1>ชื่อป้ายประชาสัมพันธ์
                    <small class="pull-right">
                        <ul class="list-inline list-unstyled">
                            <li><a href="<?php echo $this->createUrl('/site/index'); ?>">หน้าแรก</a></li>/
                            <li><a href="<?php echo $this->createUrl('/banner/index'); ?>">ป้ายประชาสัมพันธ์</a></li>/
                            <li><span class="text-bc"><?php echo $img_data->imgslide_title; ?></span></li>
                        </ul>
                    </small>
                </h1>
            </div>
            <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
        </div>

        <!-- Content -->
        <section class="content" id="banner-news-detail">
            <div class="container">
                <div class="well">
                    <div class="news-detail-img">

                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/imgslide/' . $img_data->imgslide_id.'/thumb/'.$img_data->imgslide_picture)) { ?>
                        <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/imgslide/<?php echo $img_data->imgslide_id.'/thumb/'.$img_data->imgslide_picture; ?>" class="img-responsive center-block img-rounded" alt="">
                        <?php } else { ?>
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-slide1.jpg" class="img-responsive center-block img-rounded" alt="">
                        <?php } ?>

                    </div>
                </div>
                <div class="news-detail-content">
                    <div class="content-header">
                        <div class="pull-left">
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/billboard.png" alt="">
                        </div>
                        <h2><?php echo $img_data->imgslide_title ; ?></h2>
                            <?php 
                            $id = $img_data->create_by; 
                            $create = profile::model()->findbyPk($id);
                            ?>
                        <ul class="list-inline">
                            <li><small><i class="fa fa-calendar"></i> <?php echo DateThai($img_data->update_date) ?></small></li>
                            <li><small><i class="fa fa-user"></i> <?= $create->firstname;?> </small></li>
                        </ul>						
                    </div>
                    <div class="content-detail">
                        <?php echo $img_data->imgslide_detail ; ?>
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