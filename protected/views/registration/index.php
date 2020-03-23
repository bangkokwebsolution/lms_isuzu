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
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""><?= $label->label_email ?></label>
                            <?php echo $form->emailField($users, 'email', array('class' => 'form-control')); ?>
                            <?php echo $form->error($users, 'email', array('class' => 'error2')); ?>
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


        <div class="well">

            <div class="row justify-content-center mb-2 bb-1">
                <div class="col-sm-4">
                    <div class="upload-img">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-profile.png" alt="">
                        <div class="mt-2">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                                <label class="btn btn-success" for="customFileLang">เลือกรูปภาพ</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center select-profile">
                <div class="form-group">
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="status" id="accept" value="1">
                        <label for="accept" class="bg-success text-black">
                            สำหรับบุคคลทั่วไป </label>
                    </div>
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="status" id="reject" value="2">
                        <label for="reject" class="bg-danger text-black">สำหรับพนักงาน </label>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">ID พนักงาน</label>
                        <input type="text" class="form-control" id="" placeholder="ID พนักงาน">
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <h4 class="topic-register">ข้อมูลพื้นฐาน</h4>

            <div class="row justify-content-center">
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
                <div class="col-sm-5 col-lg-3">
                    <div class="form-group">
                        <label for=""><?= $label->label_firstname ?></label>
                        <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control')); ?>
                        <?php echo $form->error($profile, 'firstname', array('class' => 'error2')); ?>
                    </div>
                </div>
                <div class="col-sm-5 col-lg-3">
                    <div class="form-group">
                        <label for=""><?= $label->label_lastname ?></label>
                        <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control')); ?>
                        <?php echo $form->error($profile, 'lastname', array('class' => 'error2')); ?>
                        <!--<input type="text" class="form-control" id="">-->
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="row justify-content-center mt-1 mb-1">
                <div class="form-group">
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="status" id="card-1" value="1">
                        <label for="card-1" class="bg-success text-black">
                            เลขบัตรประจำตัวประชาชน </label>
                    </div>
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="status" id="card-2" value="2">
                        <label for="card-2" class="bg-danger text-black">เลขหนังสือเดินทาง </label>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center bb-1 ">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">วันที่ออกบัตร/หนังสือ</label>
                        <input type="text" class="form-control" id="" placeholder="วันที่ออกบัตร/หนังสือ">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">วันหมดอายุบัตร</label>
                        <input type="text" class="form-control" id="" placeholder="วันหมดอายุบัตร">
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="row justify-content-center mt-20">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">วัน/เดือน/ปี</label>
                        <input type="date" class="form-control" id="" placeholder="วัน/เดือน/ปี">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="">อายุ</label>
                        <input type="text" class="form-control" id="" placeholder="อายุ">
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">เชื้อชาติ</label>
                        <input type="text" class="form-control" id="" placeholder="เชื้อชาติ">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">สัญชาติ</label>
                        <input type="text" class="form-control" id="" placeholder="สัญชาติ">
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>


            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">ศาสนา</label>
                        <input type="text" class="form-control" id="" placeholder="เชื้อชาติ">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">เพศ</label>
                        <select class="form-control" name="" id="">
                            <option value="1">ชาย</option>
                            <option value="2">หญิง</option>
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="row  mt-1 mb-1">
                <div class="col-sm-3 text-right"> <strong>สถานะภาพทางการสมรส :</strong></div>
                <div class="col-sm-4">
                    <div class="form-group">

                        <span></span>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status" id="card-3" value="1">
                            <label for="card-3" class="bg-success text-black">
                                โสด </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status" id="card-4" value="2">
                            <label for="card-4" class="bg-danger text-black">สมรส </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="card-4" class="bg-danger text-black">ที่อยู่</label>
                        <textarea class="form-control" name="" id="" placeholder="ที่อยู่" value="" required="" cols="30" rows="3"></textarea>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" id="" placeholder="เบอร์โทรศัพท์">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" id="" placeholder="Email">
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="row  mt-1 mb-1 ">
                <div class="col-sm-3 text-right"> <strong>ประวัติการเจ็บป่วยรุนแรง :</strong></div>
                <div class="col-sm-4">
                    <div class="form-group">

                        <span></span>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status" id="card-5" value="1">
                            <label for="card-5" class="bg-success text-black">
                                ไม่เคย </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status" id="card-6" value="2">
                            <label for="card-6" class="bg-danger text-black">เคย </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row  mt-20 mb-1 bb-1">
                <div class="col-sm-3 text-right"> <strong>ประวัติการศึกษา :</strong></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <select class="form-control" name="" id="">
                            <option value="">ระดับการศึกษา</option>
                            <option value="1">ปริญญาตรี</option>
                            <option value="2">ปริญญาโท</option>
                            <option value="2">ปริญญาเอก</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="" placeholder="สถาบันที่จบ">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <input type="text" class="form-control" id="" placeholder="ปีที่จบ">
                    </div>
                </div>

            </div>

            <div class="row  mt-20 mb-1">
                <div class="col-sm-3 text-right"> <strong>ส่วนของพนักงาน :</strong></div>
                <div class="col-sm-4">
                    <div class="form-group">

                        <span></span>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status" id="card-7" value="1">
                            <label for="card-7" class="bg-success text-black">
                                Office </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status" id="card-8" value="2">
                            <label for="card-8" class="bg-danger text-black">เรือ </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-20 mb-1 bb-1 pb-20">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">แผนก</label>
                        <select class="form-control" name="" id="">
                            <option value="">แผนก</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="2">3</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">ตำแหน่ง</label>
                        <select class="form-control" name="" id="">
                            <option value="">ตำแหน่ง</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="2">3</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="text-center mt-20">
                <input class="btn btn-default bg-greenlight btn-lg center-block" type="submit" name="yt0" value="Register">
            </div>

        </div>


        <div class="login-bg">
            <img class="login-img-1" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg3.png">
            <img class="login-img-2" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg4.png">
        </div>

    </div>