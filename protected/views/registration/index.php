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
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script language="javascript">
    function checkID(id) {
        if (id.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i);
        if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
            return false;
        return true;

    }

    function checkForm() {
        if (!checkID(document.form1.idcard.value)) {
            alert('<?= $label->label_alert_identification ?>');
        }
    }
</script>

<script>
    function check_number() {
        // alert("adadad");
        e_k = event.keyCode
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
        color: red;
    }
</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_regis ?></li>
        </ol>
    </nav>
</div>

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
                <?php if (!$users->isNewRecord) { ?>
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
                <!-- <label for=""><? //echo UserModule::t("passport"); 
                                    ?></label> -->
                <?php //echo $form->textField($users, 'passport', array('class' => 'form-control')); 
                ?>
                <?php //echo $form->error($users, 'passport', array('class' => 'error2')); 
                ?>
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
                if (empty($users->email)) {
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
                                $htmlOptions = array('class' => 'form-control job', 'empty' => $label->label_placeholder_company);
                                echo $form->dropDownList($users, 'department_id', $dep, $htmlOptions); ?>
                                <?php echo $form->error($users, 'department_id', array('class' => 'error2')); ?>
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
                                $htmlOptions = array('class' => 'form-control job', 'empty' => $label->label_placeholder_station);
                                echo $form->dropDownList($users, 'station_id', $stations, $htmlOptions); ?>
                                <?php echo $form->error($users, 'station_id', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </div>
                <?php
                    // }
                }
                ?>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div style="display: inline-block;" class="g-recaptcha" data-sitekey="6LdMXXcUAAAAAN1JhNtbE94ISS3JPEdP8zEuoJPD"></div>
                            <?php echo $form->error($users, 'captcha', array('class' => 'error2')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php if (Yii::app()->user->getId() == null) { ?>
                <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block')); ?>
            <?php } else {
                echo CHtml::submitButton($label->label_save, array('class' => 'btn btn-default bg-greenlight btn-lg center-block'));
            } ?>
            <?php $this->endWidget();
            ?>
        </div>
    </div>


    <div class="container">
        <div class="register-form">
            <h3>สมัครสมาชิก</h3>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tab-formregis">
                        <div class="upload-img">
                            <img src="themes/template/images/thumbnail-profile.png" alt="">
                            <div class="mt-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                                    <label class="btn btn-success" for="customFileLang">เลือกรูปภาพ</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-resigter">
                            <div class="row justify-content-center border-bottom">
                                <div class="col-md-6">
                                    <form class="">
                                        <div class="custom-control-inline custom-radio-inline c-input">
                                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">สำหรับบุคคลทั่วไป</label>
                                        </div>
                                        <div class="custom-control-inline custom-radio-inline c-input">
                                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">สำหรับพนักงาน</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <form class="needs-validation" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-8 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="ID พนักงาน" value="" required>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <h6 class="font-weight-bold">ข้อมูลพื้นฐาน</h6>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="ชื่อ" value="" required>

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="นามสกุล" value="" required>

                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-8 mb-3">
                                                <div class="custom-control-inline custom-radio-inline c-input">
                                                    <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio3">เลขบัตรประจำตัวประชาชน</label>
                                                </div>
                                                <div class="custom-control-inline custom-radio-inline c-input">
                                                    <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio4">เลขหนังสือเดินทาง</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-8 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="เลขบัตรประจำตัวประชาชน" value="" required>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="วันที่ออกบัตร/หนังสือ" value="" required>

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="วันหมดอายุ" value="" required>

                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-row pt-3">
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="วัน/เดือน/ปีเกิด" value="" required>

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="อายุ" value="" required>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="เชื้อชาติ" value="" required>

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="สัญชาติ" value="" required>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="ศาสนา" value="" required>

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <select class="custom-select form-control" required>
                                                    <option value="" selected class="select-none">เพศ</option>
                                                    <option value="1">ชาย</option>
                                                    <option value="2">หญิง</option>
                                                </select>
                                                <div class="invalid-feedback">กรุณาเลือกเพศ</div>
                                            </div>
                                        </div>

                                        <div class="form-row form-inline">
                                            <label for="inputPassword6" class="font-weight-bold">สถานะภาพทางการสมรส :</label>
                                            <div class="col-md-8 ml-3">
                                                <div class="custom-control-inline custom-radio-inline c-input">
                                                    <input type="radio" id="customRadio7" name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio7">โสด</label>
                                                </div>
                                                <div class="custom-control-inline custom-radio-inline c-input">
                                                    <input type="radio" id="customRadio6" name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio6">สมรส</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row pt-3">
                                            <div class="col-md-8 mb-3">
                                                <textarea class="form-control" name="" id="validationCustom01" placeholder="ที่อยู่" value="" required id="" cols="30" rows="3"></textarea>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-8 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="เบอร์โทรศัพท์" value="" required>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-8 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="E-mail" value="" required>

                                            </div>
                                        </div>

                                        <div class="form-row form-inline">
                                            <label for="inputPassword6" class="font-weight-bold">ประวัติการเจ็บป่วยรุนแรง :</label>
                                            <div class="col-md-8 ml-3">
                                                <div class="custom-control-inline custom-radio-inline c-input">
                                                    <input type="radio" id="customRadio8" name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio8">ไม่เคย</label>
                                                </div>
                                                <div class="custom-control-inline custom-radio-inline c-input">
                                                    <input type="radio" id="customRadio9" name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio9">เคย</label>
                                                </div>

                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <input type="text" class="form-control" id="validationCustom01" placeholder="ระบุโรคที่ป่วย" value="" required>
                                            </div>
                                        </div>

                                        <div class="study-register">
                                            <div class="form-row">
                                                <label for="inputPassword6" class="font-weight-bold p-2">ประวัติการศึกษา :</label>
                                                <div class="col-md-3">
                                                    <select class="custom-select form-control w-100" required>
                                                        <option value="" selected class="select-none">ระดับการศึกษา</option>
                                                        <option value="1">ปริญญาตรี</option>
                                                        <option value="2">ปริญญาโท</option>
                                                        <option value="3">ปริญญาเอก</option>
                                                    </select>

                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="ชื่อสถาบัน" value="" required>

                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="ปีการศึกษาที่จบ" value="" required>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="staff-register">
                                            <div class="form-row form-inline">
                                                <label for="inputPassword6" class="font-weight-bold">ส่วนของพนักงาน :</label>
                                                <div class="col-md-8 ml-3">
                                                    <div class="custom-control-inline custom-radio-inline c-input">
                                                        <input type="radio" id="customRadio11" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio11">Office</label>
                                                    </div>
                                                    <div class="custom-control-inline custom-radio-inline c-input">
                                                        <input type="radio" id="customRadio10" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio10">เรือ</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-8 mb-3">
                                                    <select class="custom-select form-control" required>
                                                        <option value="" selected class="select-none">แผนก</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-8 mb-3">
                                                    <select class="custom-select form-control" required>
                                                        <option value="" selected class="select-none">ตำแหน่ง</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center pb-3"> <button class="btn btn-main p-2" type="submit">ยืนยันการสมัคร</button></div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>