<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_contactus ?></li>
        </ol>
    </nav>
</div>

<section class="content" id="contact-us">
    <div class="container">
    <div class="row justify-content-center gy-4">
                    <div class="col-lg-6 pt-3">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/Company.png" class="img-fluid mt-3" alt="Company">
                    </div>
                    <div class="col-lg-6">
                        <h4 class="contact-title"><span>Admin</span></h4>
                        <div class="row pt-2 gy-3">
                            <div class="col-sm-6">
                                <div class="card border p-2">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/avatar-1.png" class="img-fโluid">
                                    <div class="contect-detial">
                                        <p>Mr. FirstName LastName</p>
                                        <p>Position : Admin staff</p>
                                        <p>Phone Number : 0-2966-2222</p>
                                        <p>Email : info@isuzu-tis.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card border p-2">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/avatar-2.png" class="img-fluid">
                                    <div class="contect-detial">
                                        <p>Mr. FirstName LastName</p>
                                        <p>Position : Admin staff</p>
                                        <p>Phone Number : 0-2966-2111</p>
                                        <p>Email : info@isuzu-tis.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
    </div>
</section>

