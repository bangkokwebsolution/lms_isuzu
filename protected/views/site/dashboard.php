<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_statusLearn ?></li>
        </ol>
    </nav>
</div>

<section class="dashboard">
    <div class="container">
        <div class="row g-0 position-relative">
            <div class=" col-md-3 col-lg-3 col-xs-12">
                <ul class="sidebar-account">
                    <li class=""><a class="text-decoration-none" href="<?php echo $this->createUrl('/registration/Update'); ?>">Personal Information</a></li>
                    <li class="active">Course Status</p>
                </ul>
            </div>

            <div class="col col-md-9 col-lg-9">
                <div class="row g-5">

                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-course">
                            <a href="#"><img class="card-img-top" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-image.png"></a>
                            <div class="card-body" style="padding:10px;">
                                <h4 class="card-title  text-4 text-main "><a href="#">Course Name</a></h4>
                                <div class="progress progress-sm progress-border-radius mt-4 ">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    </div>
                                </div>
                                <p class="text-dark ">0 % Complete </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-course">
                            <a href="#"><img class="card-img-top" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-image.png"></a>
                            <div class="card-body" style="padding:10px;">
                                <h4 class="card-title  text-4 text-main "><a href="#">Course Name</a></h4>
                                <div class="progress progress-sm progress-border-radius mt-4 ">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    </div>
                                </div>
                                <p class="text-dark ">0 % Complete </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-course">
                            <a href="#"><img class="card-img-top" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-image.png"></a>
                            <div class="card-body" style="padding:10px;">
                                <h4 class="card-title  text-4 text-main "><a href="#">Course Name</a></h4>
                                <div class="progress  progress-border-radius mt-4 ">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    </div>
                                </div>
                                <p class="text-dark ">0 % Complete </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>