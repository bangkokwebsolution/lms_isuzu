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

            <div class=" col-md-3 col-lg-3 col-xs-12">
                <ul class="sidebar-account">
                    <li class="active">Personal Information</li>
                    <li class=""><a class="text-decoration-none" href="<?php echo $this->createUrl('/site/dashboard'); ?>">Course Status</a></p>
                </ul>
            </div>

            <div class="col col-md-9 col-lg-9">
                <div class="card card-profile mt-20">
                    <div class="row">
                        <div class="col col-md-10 col-lg-9">
                            <h3 class="title-account">Personal Information</h3>
                            <div class="row form-group">

                                <div class="col-md-6 col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Firstname - Lastname <br> <span><?php if($langId ==1){

                                            echo $profile->firstname_en.' - '.$profile->lastname_en;
                                        }else{

                                            echo $profile->firstname.' - '.$profile->lastname;

                                        } ?></span></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Employee ID <br><span> <?= $profile->identification ?></span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Section code <br><span> XXXXXXXXX</span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="card card-profile-detail">
                                        <p>Section name <br><span>XXXXXXXXX</span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 ">
                                    <div class="card card-profile-detail">
                                        <p>Class level <br><span>XXXXXXXXX</span></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 ">
                                    <div class="card card-profile-detail">
                                        <p>Position Description <br><span>XXXXXXXXX</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="pic-profile">
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
    </div>
</section>