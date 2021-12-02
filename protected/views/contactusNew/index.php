<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $Position = 'Position :';
    $Desk_phone ='Internal Contact No.';
    $Email ='E-mail :';
} else {
    $langId = Yii::app()->session['lang'];
    $Position = 'ตำแหน่ง :';
    $Desk_phone ='เบอร์ติดต่อภายใน :';
    $Email ='อีเมล :';
}
 ?>
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
                    <div class="col-lg-12 pt-3 mb-2 text-center">
                        <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/Company.png" class="img-fluid mt-3" alt="Company"> -->
                        <img src="<?= Yii::app()->theme->baseUrl ?>/images/contact.png" class="img-fluid mt-3" alt="Company">
                    </div>
                    <div class="col-lg-10 ">
              
                        <div class="row pt-2 gy-3">
                            <?php 
                                if ($ContactusNew_data) {
                                foreach ($ContactusNew_data as $key => $value) {      
                            ?>
                            <div class="col-sm-6 col-xs-12 mb-2">

                                <div class="card box-contact border p-2 ">
                                    <!-- <?php
                                        if ($value['con_image'] == null) {

                                            $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                        } else {
                                            $img = Yii::app()->baseUrl . '/uploads/contactusnew/' . $value['id'] . '/thumb/' . $value['con_image'];
                                        }
                                    ?>
                                      <img src="<?php echo $img ?>" class="img-fluid"> -->
                                    <div class="contect-detial">
                                        <p>
                                        <?php 
                                            if (Yii::app()->session['lang'] == 1 || Yii::app()->session['lang'] == Null) {
                                                echo $value['con_firstname_en']." ".$value['con_lastname_en'];
                                            }else{
                                                echo $value['con_firstname']." ".$value['con_lastname'];
                                            }
                                        ?>
                                        </p>
                                        <p><?= $Position ?> 
                                        <?php
                                            if (Yii::app()->session['lang'] == 1) {
                                                echo $value['con_position_en'];
                                            }else{
                                                echo $value['con_position'];
                                            }
                                        ?> 
                                        </p>
                                        <p><?= $Desk_phone ?>  
                                         <?php
                                            echo $value['con_tel'];
                                        ?>
                                        </p>
                                        <p><?= $Email ?>  <?php
                                            echo $value['con_email'];
                                        ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                }// end foreach
                                }// end if
                            ?>

                            <!-- <div class="col-sm-6">
                                <div class="card border p-2">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/avatar-2.png" class="img-fluid">
                                    <div class="contect-detial">
                                        <p>Mr. FirstName LastName</p>
                                        <p>Position : Admin staff</p>
                                        <p>Phone Number : 0-2966-2111</p>
                                        <p>Email : info@isuzu-tis.com</p>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                    </div>

                </div>
    </div>
</section>

