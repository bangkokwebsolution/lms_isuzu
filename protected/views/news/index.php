<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
    //$strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

//	$strDate = "2008-08-14 13:42:44";
//	echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>
<html lang="th">

<?php include './include/head.php'; ?>

<body>

    <?php include './include/header.php'; ?>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $label->label_news ?></li>
            </ol>
        </nav>
    </div>


    <section class="content" id="banner-news">
        <div class="container">
            <div class="row">
                <?php
                $criteria = new CDbCriteria;
                $criteria->compare('active', y);
                $criteria->compare('lang_id', $langId);
                $criteria->order = 'update_date  DESC';
                ?>
                <?php $news = News::model()->findAll($criteria); ?>
                <?php foreach ($news as $all) { ?>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="well">
                            <a href="<?php echo $this->createUrl('news/detail/', array('id' => $all->cms_id)); ?>">
                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' . $all->cms_id . '/thumb/' . $all->cms_picture)) { ?>
                                    <div class="news-img" style="background-image: url('<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $all->cms_id ?>/thumb/<?php echo $all->cms_picture ?>');">
                                    <?php } else { ?>
                                        <div class="news-img" style="background-image: url('<?php echo Yii::app()->theme->baseUrl; ?>/images/newspaper.png');">
                                        <?php } ?>
                                        <!-- <span class="news-date"><?php echo DateThai($all->update_date) ?></span> -->
                                        <span class="news-date"><?php echo Helpers::lib()->DateLang($all->update_date, Yii::app()->session['lang']); ?></span>
                                        </div>
                                        <div class="p">
                                            <?php echo $all->cms_title ?>
                                        </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include './include/footer.php'; ?>

    <!-- Script -->
    <?php include './include/script.php'; ?>

</body>

</html>