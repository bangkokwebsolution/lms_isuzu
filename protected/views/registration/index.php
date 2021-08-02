<?php
$my_org = '';
if (!Yii::app()->user->isGuest) {
    $my_org = json_decode($users->orgchart_lv2);
}
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}

$news_forms = $users->isNewRecord;
if ($news_forms) {
    $news_forms = 'y';
} else {
    $news_forms = 'n';
}
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.css">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.css">
<script src='https://www.google.com/recaptcha/api.js'></script>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Personal Information</li>
        </ol>
    </nav>
</div>
<section class="content" id="register">
    <div class="container">
        <div class="row g-0 position-relative">

            <div class="sidebar col-md-3 col-lg-2">
                <div class="container-fluid">
                    <p class="my-0">Personal Information</p>
                    <hr class="my-2">
                    <p class="my-0"><a class="text-decoration-none" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/status-user.php">Course Status</a></p>
                    <hr class="my-2">
                </div>
            </div>

            <div class="content col col-md-9 col-lg-10">
                <div class="container pb-5 card card-pf">
                    <div class="row justify-content-center ">
                        <div class="col col-md-10 col-lg-8">
                            <div class=" card-profile ">
                                <!-- <div class="card-body"> -->
                                <p class="my-0">Personal Information</p>
                                <br>
                                <div class="body-size">

                                    <div class="card card-profile-detail">
                                        <p>Firstname - Lastname <br> <span>อัศวรรณ์ จำเริญสม</span></p>
                                    </div>
                                    <div class="card card-profile-detail">
                                        <p>Employee ID <br><span> 7489287894756</span></p>
                                    </div>
                                    <div class="card card-profile-detail">
                                        <p>Section code <br><span> XXXXXXXXX</span></p>
                                    </div>
                                    <div class="card card-profile-detail">
                                        <p>Section name <br><span>XXXXXXXXX</span></p>
                                    </div>
                                    <div class="card card-profile-detail">
                                        <p>Class level <br><span>XXXXXXXXX</span></p>
                                    </div>
                                    <div class="card card-profile-detail">
                                        <p>Position Description <br><span>XXXXXXXXX</span></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class=" col-lg-2">
                            <img class="pf-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/profile-image.png">
                            <div class="card-body text-center" style="padding:10px;">
                                <button class="col-bt btn btn-main text-4 text-center">edit </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>