<?php 
$my_org = '';
if(!Yii::app()->user->isGuest){
    $my_org = json_decode($users->orgchart_lv2);
}
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    $langId = Yii::app()->session['lang'] = 1;
}else{
    $langId = Yii::app()->session['lang'];
}
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script language="javascript">
    function checkID(id) {
        if(id.length != 13) return false;
        for(i=0, sum=0; i < 12; i++)
            sum += parseFloat(id.charAt(i))*(13-i);
        if((11-sum%11)%10!=parseFloat(id.charAt(12)))
            return false;
        return true;

    }

    function checkForm() {
        if(!checkID(document.form1.idcard.value)){
            alert ('<?= $label->label_alert_identification ?>');
        }
    }
</script>

<script>
    function check_number() {
           // alert("adadad");
           e_k=event.keyCode
            //if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
                if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
                    event.returnValue = false;
                    alert('<?= $label->label_alert_notNumber ?>');
                }
            }
        </script>

        <!-- Header -->
        <style>
        .error2 {
            color:red;
        }
    </style>
    <!-- Header page -->
    <div class="header-page parallax-window">
        <div class="container">
            <h1><?= $label->label_regis ?>
                <small class="pull-right">
                    <ul class="list-inline list-unstyled">
                        <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage ?></a></li> /
                        <li><a href="<?php echo $this->createUrl('/registration/index'); ?>"><?= $label->label_regis ?></a></li>
                    </ul>
                </small>
            </h1>
        </div>
        
    </div>
    <!-- Content -->
    <section class="content" id="register">
        <div class="container">
            <div class="well">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
//                            'name' => 'form1',
                    'id' => 'registration-form',
//                        'OnSubmit'=> checkForm(),
//                        'enableAjaxValidation'=>true,
//                        // 'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
//                        'clientOptions'=>array(
//                            'validateOnSubmit'=>true,
//                        ),
//                        บรรทัดนี้เอาไว้เก็บไฟลภาพ
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1'/*, 'onsubmit' => 'checkForm(); return false;'*/),
            ));
            ?>
            <div class="well">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group"> 
                             <label for=""><?= $label->label_identification ?></label> 
                            <?php echo $form->textField($profile, 'identification', array('class' => 'form-control required', 'name' => 'idcard', 'maxlength' => '13', 'onKeyPress' => 'return check_number();')); ?>
                            <?php echo $form->error($profile, 'identification', array('class' => 'error2')); ?> 
                            <!--<input type="text" class="form-control" id="">-->
                         </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""><?= $label->label_email ?></label>
                            <?php echo $form->emailField($users, 'email', array('class' => 'form-control')); ?>
                            <?php echo $form->error($users, 'email', array('class' => 'error2')); ?>
                            <!--<input type="email" class="form-control" id="">-->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                        <?php if(!$users->isNewRecord) { ?>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?php echo $form->labelEx($users, 'newpassword'); ?></label>
                            <?php echo $form->passwordField($users, 'newpassword', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)')); ?>
                            <?php echo $form->error($users, 'newpassword'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?php echo $form->labelEx($users, 'confirmpass'); ?></label>
                            <?php echo $form->passwordField($users, 'confirmpass', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
                            <?php echo $form->error($users, 'verifyPassword', array('class' => 'error2')); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>

            <div class="well">
                 <!-- <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group"> -->
                            <!-- <label for=""><? //echo UserModule::t("passport"); ?></label> -->
                            <?php //echo $form->textField($users, 'passport', array('class' => 'form-control')); ?>
                            <?php //echo $form->error($users, 'passport', array('class' => 'error2')); ?>
                       <!--  </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for=""><?= $label->label_title ?></label>
                            <?php $country = array('1' => $label->label_dropdown_mr, '2' => $label->label_dropdown_mrs, '3' => $label->label_dropdown_ms); ?>
                            <?php
                            $htmlOptions = array('class' => 'form-control');
                            echo $form->dropDownList($profile, 'title_id', $country, $htmlOptions);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for=""><?= $label->label_firstname ?></label>
                            <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control')); ?>
                            <?php echo $form->error($profile, 'firstname', array('class' => 'error2')); ?>
                            <!--<input type="text" class="form-control" id="">-->
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for=""><?= $label->label_lastname ?></label>
                            <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control')); ?>
                            <?php echo $form->error($profile, 'lastname', array('class' => 'error2')); ?>
                            <!--<input type="text" class="form-control" id="">-->
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for=""><?= $label->label_phone ?></label>
                            <?php echo $form->textField($profile, 'tel', array('class' => 'form-control')); ?>
                            <?php echo $form->error($profile, 'tel', array('class' => 'error2')); ?>
                            <!--<input type="text" class="form-control" id="">-->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                 <!-- CHECK LMS -->
               <?php 
                if(empty($users->email)){
                    // $memberLdap = Helpers::lib()->ldapTms($users->email);
                    // if($memberLdap['count'] > 0){

                ?>  
                <div class="row">

                    <?php
                    $dep = Department::model()->getDepartmentData();
                    ?>
                    <div class="col-sm-6">
                        <div class="form-group bussiness">
                            <label><?= $label->label_company ?> *
                                <span class="required"></span>
                            </label>
                            <?php
                            $htmlOptions = array('class' => 'form-control job','empty'=>$label->label_placeholder_company);
                            echo $form->dropDownList($users, 'department_id', $dep, $htmlOptions); ?>
                            <?php echo $form->error($users, 'department_id',array('class' => 'error2')); ?>
                        </div>
                    </div> 

                    <?php
                    $stations = Station::model()->getStationList($langId);
                    ?>
                    <div class="col-sm-6">
                        <div class="form-group bussiness">
                            <label><?= $label->label_station ?> *
                                <span class="required"></span>
                            </label>
                            <?php
                            $htmlOptions = array('class' => 'form-control job','empty'=>$label->label_placeholder_station);
                            echo $form->dropDownList($users, 'station_id', $stations, $htmlOptions); ?>
                            <?php echo $form->error($users, 'station_id',array('class' => 'error2')); ?>
                        </div>
                    </div> 

                    <div class="clearfix"></div>

                </div>
                <?php 
                        // }
                    }
                ?>
                <!-- CHECK LMS -->
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div style="display: inline-block;" class="g-recaptcha" data-sitekey="6LdMXXcUAAAAAN1JhNtbE94ISS3JPEdP8zEuoJPD"></div>
                            <?php echo $form->error($users, 'captcha',array('class' => 'error2')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php if(Yii::app()->user->getId()==null) { ?>
                <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block')); ?>
                <?php } else {
                   echo CHtml::submitButton($label->label_save, array('class' => 'btn btn-default bg-greenlight btn-lg center-block'));
               } ?>
               <?php $this->endWidget();
               ?>
           </div>
       </div>
   </section>