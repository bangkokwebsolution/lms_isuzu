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
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.css">
<script src='https://www.google.com/recaptcha/api.js'></script>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">
<style>
    .container1 input[type=text] {
        padding: 5px 0px;
        margin: 5px 5px 5px 0px;
    }

    .add_form_field {
        background-color: #1c97f3;
        border: none;
        color: #fff;
        padding: 8px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }


    input {
        border: 1px solid #1c97f3;
        width: 260px;
        height: 40px;
        margin-bottom: 14px;
    }


    .delete {
        border-radius: 3px;
        border: none;
        color: white;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-table;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
        /* position: absolute;
        right: 0 */
    }
    .uploadifive-button {
        float: left;
        margin-right: 10px;
    }
    #queue {
        border: 1px solid #E5E5E5;
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 100%;
    }

    #docqueue {
        border: 1px solid #E5E5E5;
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 100%;
    }

    @media screen and (max-width: 600px){
        #register .row.justify-content-center{
            justify-content: inherit !important;
        }
    }


</style>
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

    function upload()
    {

       // tinymce.triggerSave();
        //tinyMCE.triggerSave();

        var file = $('#Lesson_image').val();
        var exts = ['jpg','gif','png'];
        if ( file ) {

            var get_ext = file.split('.');
            get_ext = get_ext.reverse();
            if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){

                if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0){
                    return true;
                }else{
                    if($('#queue .uploadifive-queue-item').length > 0) {
                        $('#Training').uploadifive('upload');
                        return false;
                    }else if($('#docqueue .uploadifive-queue-item').length > 0){
                        $('#doc').uploadifive('upload');
                        return false;
                    }
                }

            } else {
                $('#Lesson_image_em_').removeAttr('style').html("<p class='error help-block'><span class='label label-important'> ไม่สามารถอัพโหลดได้ ไฟล์ที่สามารถอัพโหลดได้จะต้องเป็น: jpg, gif, png.</span></p>");
                return false;
            }

        }
        else
        {
         if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0 ){
            return true;
        }else{
            if($('#queue .uploadifive-queue-item').length > 0) {
                $('#Training').uploadifive('upload');
                return false;
            }else if($('#docqueue .uploadifive-queue-item').length > 0){
                $('#doc').uploadifive('upload');
                return false;
            }
        }

    }
}

function deleteFileDoc(filedoc_id,file_id){
    $.get("<?php echo $this->createUrl('Registration/deleteFileDoc'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
            notyfy({dismissQueue: false,text: "ลบไฟล์เรียบร้อย",type: 'success'});
            $('#'+filedoc_id).parent().hide('fast');
        }else{
            alert('ไม่สามารถลบไฟล์ได้');
        }
    });
}

function editName(filedoc_id){

    var name = $('#filenamedoc'+filedoc_id).val();

    $.get("<?php echo $this->createUrl('Registration/editName'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filenamedoc'+filedoc_id).hide();
        $('#filenamedoctext'+filedoc_id).text(name);
        $('#filenamedoctext'+filedoc_id).show();
        $('#btnEditName'+filedoc_id).show();
    });

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
            <div class="well reset-well">
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
            <?php
            $attTime = array('class' => ' form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => 'วันหมดอายุ');
            $graduation = array('class' => 'form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => 'วันที่จบการศึกษา');
            $birthday = array('class' => 'form-control default_datetimepicker birth', 'autocomplete' => 'off', 'placeholder' => 'วันเดือนปีเกิด', 'type' => "text");
            ?>
            <div class="well">

                <div class="row box-img-center mb-2 bb-1">
                    <div class="col-sm-4">
                        <div class="upload-img">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 144px; height: 130px;">
                                    <div class="mt-2">
                                        <!-- <input type="file" class="custom-file-input" id="customFileLang" lang="es"> -->
                                        <?php
                                        if ($users->pic_user == null) {

                                            $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                        } else {
                                            $registor = new RegistrationForm;
                                            $registor->id = $users->id;
                                            $img = Yii::app()->baseUrl . '/uploads/user/' . $users->id . '/original/' . $users->pic_user;
                                        }
                                        ?>
                                        <img src="<?= $img ?>" alt="">
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 180px; max-height: 240px;"></div>
                                    <!--  <?php echo $form->fileField($users, 'pic_user', array('id' => 'wizard-picture')); ?> 
                                    <label class="btn btn-success" for="customFileLang"><span class="fileinput-new"> เลือกรูปภาพ</span></label> -->
                                    <span class="btn btn-info btn-file"><span class="fileinput-new">เลือกรูปภาพ</span>
                                    <?php echo $form->fileField($users, 'pic_user', array('id' => 'wizard-picture')); ?>
                                    <a href="#" class=" btn-info fileinput-exists" data-dismiss="fileinput">เปลี่ยนรูปภาพ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center select-profile">
                    <div class="form-group">
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="type_user" id="accept" value="1" <?php if ($profile->type_user == 1) : ?> checked="checked" <?php endif ?>>
                            <label for="accept" class="bg-success text-black">
                            สำหรับบุคคลทั่วไป </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="type_user" id="reject" value="3" <?php if ($profile->type_user == 3) : ?> checked="checked" <?php endif ?>>
                            <label for="reject" class="bg-danger text-black">สำหรับพนักงาน </label>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-1">
                    <div class="col-sm-4">
                        <div class="form-group" id="id_employee" style="display:none">
                            <!-- <label for=""><?php echo $form->labelEx($users, 'username'); ?></label> -->
                            <label for="">เลขประจำตัวพนักงาน</label>
                            <?php echo $form->textField($users, 'username', array('class' => 'form-control user_ID', 'placeholder' => 'เลขประจำตัวพนักงาน','maxlength'=>'13', 'autocomplete' => 'off')); ?>
                            <?php echo $form->error($users, 'username', array('class' => 'error2')); ?>
                            <!-- <input type="text" class="form-control" id="" placeholder="ID พนักงาน"> -->
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <h4 class="topic-register"><i class="fas fa-user-edit"></i> ข้อมูลพื้นฐาน</h4>

                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">คำนำหน้า</label>
                            <?php  $country = array('1' => 'นาย', '2' => 'นาง', '3' => 'นางสาว'); ?>
                            <?php
                            $htmlOptions = array('class' => 'form-control');
                            echo $form->dropDownList($profile, 'title_id', $country, $htmlOptions);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="">ชื่อ</label>
                            <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อ')); ?>
                            <?php echo $form->error($profile, 'firstname', array('class' => 'error2')); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="">นามสกุล</label>
                            <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล')); ?>
                            <?php echo $form->error($profile, 'lastname', array('class' => 'error2')); ?>
                            <!--<input type="text" class="form-control" id="">-->
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Prefix</label>
                            <?php $country = array('1' => 'Mr.', '2' => 'Mrs.', '3' => 'Miss.'); ?>
                            <?php
                            $htmlOptions = array('class' => 'form-control');
                            echo $form->dropDownList($profile, 'title_id', $country, $htmlOptions);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-3">
                        <div class="form-group">
                            <label for="">firstname</label>
                            <?php echo $form->textField($profile, 'firstname_en', array('class' => 'form-control', 'placeholder' => 'firstname')); ?>
                            <?php echo $form->error($profile, 'firstname_en', array('class' => 'error2')); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-3">
                        <div class="form-group">
                            <label for="">lastname</label>
                            <?php echo $form->textField($profile, 'lastname_en', array('class' => 'form-control', 'placeholder' => 'lastname')); ?>
                            <?php echo $form->error($profile, 'lastname_en', array('class' => 'error2')); ?>
                            <!--<input type="text" class="form-control" id="">-->
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>


                <div class="row justify-content-center mt-1 mb-1 ">
                    <div class="form-group">
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="type_card" id="card-1" value="l" <?php if ($profile->type_card == "l") : ?> checked="checked" <?php endif ?>>
                            <label for="card-1" class="bg-success text-black">
                            เลขบัตรประจำตัวประชาชน </label>
                        </div>

                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="type_card" id="card-2" value="p" <?php if ($profile->type_card == "p") : ?> checked="checked" <?php endif ?>>
                            <label for="card-2" class="bg-danger text-black">เลขหนังสือเดินทาง </label>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-center bb-1 pb-20">
                    <div class="col-md-4">
                        <div class="form-group" id="identification_card">
                            <?php echo $form->labelEx($profile, 'identification'); ?>
                            <?php echo $form->textField($profile, 'identification', array('class' => 'form-control', 'name' => 'idcard', 'maxlength' => '13', 'onKeyPress' => 'return check_number();', 'placeholder' => 'เลขบัตรประจำตัวประชาชน')); ?>
                            <?php echo $form->error($profile, 'identification', array('class' => 'error2')); ?>
                        </div>

                        <div class="form-group" id="passport_card">
                            <?php echo $form->labelEx($profile, 'passport'); ?>
                            <?php echo $form->textField($profile, 'passport', array('class' => 'form-control', 'name' => 'passport', 'placeholder' => 'passport')); ?>
                            <?php echo $form->error($profile, 'passport', array('class' => 'error2')); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <!-- <label for="">วันหมดอายุบัตร</label>
                                <input type="text" class="form-control" id="" placeholder="วันหมดอายุบัตร" > -->
                                <?php echo $form->labelEx($profile, 'date_of_expiry'); ?>
                                <?php echo $form->textField($profile, 'date_of_expiry', $attTime); ?>
                                <?php echo $form->error($profile, 'date_of_expiry', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row justify-content-center mt-20">
                        <div class="col-md-6">
                            <div class="form-group">
                            <!-- <label for="">วัน/เดือน/ปี</label>
                                <input type="date" class="form-control" id="" placeholder="วัน/เดือน/ปี"> -->
                                <?php echo $form->labelEx($profile, 'birthday'); ?>
                                <?php echo $form->textField($profile, 'birthday', $birthday); ?>
                                <?php echo $form->error($profile, 'birthday', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                            <!-- <label for="">อายุ</label>
                                <input type="text" class="form-control" id="" placeholder="อายุ"> -->
                                <?php echo $form->labelEx($profile, 'age'); ?>
                                <?php echo $form->textField($profile, 'age', array('class' => 'form-control ages', 'placeholder' => 'อายุ')); ?>
                                <?php echo $form->error($profile, 'age', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                            <!--  <label for="">เชื้อชาติ</label>
                                <input type="text" class="form-control" id="" placeholder="เชื้อชาติ"> -->
                                <?php echo $form->labelEx($profile, 'race'); ?>
                                <?php echo $form->textField($profile, 'race', array('class' => 'form-control', 'placeholder' => 'เชื้อชาติ')); ?>
                                <?php echo $form->error($profile, 'race', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                            <!-- <label for="">สัญชาติ</label>
                                <input type="text" class="form-control" id="" placeholder="สัญชาติ"> -->
                                <?php echo $form->labelEx($profile, 'nationality'); ?>
                                <?php echo $form->textField($profile, 'nationality', array('class' => 'form-control', 'placeholder' => 'สัญชาติ')); ?>
                                <?php echo $form->error($profile, 'nationality', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                            <!-- <label for="">ศาสนา</label>
                                <input type="text" class="form-control" id="" placeholder="เชื้อชาติ"> -->
                                <?php echo $form->labelEx($profile, 'religion'); ?>
                                <?php echo $form->textField($profile, 'religion', array('class' => 'form-control', 'placeholder' => 'ศาสนา')); ?>
                                <?php echo $form->error($profile, 'religion', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">เพศ</label>
                                <select class="form-control" name="" id="">
                                    < <?php
                                    if ($profile->sex) {
                                        if ($profile->sex === 'Male') { ?> 
                                            <option value="1">ชาย</option>
                                            <option value="2">หญิง</option>
                                        <?php } else { ?>
                                            <option value="2">หญิง</option>
                                            <option value="1">ชาย</option>
                                        <?php    }
                                    } else ?>
                                    <option value="">เพศ</option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                    <?php?>
                                </select>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row  mt-1 mb-1 ">
                        <div class="col-md-3 text-right-md"> <strong>สถานะภาพทางการสมรส</strong></div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <span></span>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="status_sm" id="card-3" value="s" <?php if ($profile->status_sm == "s") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-3" class="bg-success text-black">
                                    โสด </label>
                                </div>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="status_sm" id="card-4" value="m" <?php if ($profile->status_sm == "m") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-4" class="bg-danger text-black">สมรส </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group">
                            <!-- <label for="card-4" class="bg-danger text-black">ที่อยู่</label>
                                <textarea class="form-control" name="" id="" placeholder="ที่อยู่" value="" required="" cols="30" rows="3"></textarea> -->
                                <?php echo $form->labelEx($profile, 'address'); ?>
                                <?php echo $form->textArea($profile, 'address', array('class' => 'form-control', 'cols' => "30", 'rows' => "3", 'placeholder' => 'ที่อยู่')); ?>
                                <?php echo $form->error($profile, 'address', array('class' => 'error2')); ?>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                            <!-- <label for="">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" id="" placeholder="เบอร์โทรศัพท์"> -->
                                <?php echo $form->labelEx($profile, 'tel'); ?>
                                <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์')); ?>
                                <?php echo $form->error($profile, 'tel', array('class' => 'error2')); ?>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                            <!-- <label for="">Email</label>
                                <input type="text" class="form-control" id="" placeholder="Email"> -->
                                <label><?php echo $form->labelEx($users, 'email'); ?></label>
                                <?php echo $form->emailField($users, 'email', array('class' => 'form-control', 'placeholder' => 'E-mail')); ?>
                                <?php echo $form->error($users, 'email', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo $form->labelEx($profile, 'line_id'); ?></label>
                                <?php echo $form->textField($profile, 'line_id', array('class' => 'form-control', 'placeholder' => 'IDLine')); ?>
                                <?php echo $form->error($profile, 'line_id', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="row  mt-1 mb-1 ">
                        <div class="col-md-3 text-right-md"> <strong>ประวัติการเจ็บป่วยรุนแรง</strong></div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <span></span>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="history_of_illness" id="card-5" value="n" <?php if ($profile->history_of_illness == "n") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-5" class="bg-success text-black">
                                    ไม่เคย </label>
                                </div>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="history_of_illness" id="card-6" value="y" <?php if ($profile->history_of_illness == "y") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-6" class="bg-danger text-black">เคย </label>
                                </div>
                            </div>
                        </div>
                    </div>



                    <?php

                    if (!$ProfilesEdu->isNewRecord || $ProfilesEdu->isNewRecord == NULL) {
                        echo "";
                    } else { ?>
                        <!-- <div class="col-sm-3 text-right"> <strong>ประวัติการศึกษา :</strong></div> -->
                        <?php
                    }
                    $modelList = Education::model()->findAll(array("condition" => " active = 'y'"));
                    $list = CHtml::listData($modelList, 'edu_id', 'edu_name');
                    $att_Education = array('class' => 'form-control', 'empty' => 'ระดับการศึกษา');
                    if (!$ProfilesEdu->isNewRecord) { ?>
                        <div class="add-study">
                            <?php
                            foreach ($ProfilesEdu as $kedu => $valedu) {
                                ?>

                                <div class="row del_edu">
                                    <div class="col-md-3 text-right"> <strong>ประวัติการศึกษา</strong></div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <?php echo CHtml::activeDropDownList($valedu, '[' . $kedu . ']edu_id', $list, $att_Education); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <?php echo $form->textField($valedu, '[' . $kedu . ']institution', array('class' => 'form-control', 'placeholder' => 'สถานที่่จบการศึกษา')); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <?php echo $form->textField($valedu, '[' . $kedu . ']date_graduation', $graduation); ?>
                                        </div>
                                    </div>
                                    <span class="delete btn-danger" name="mytext[]"><i class="fas fa-minus-circle"></i> Delete</span>

                                </div>

                                <?php
                            } ?>
                        </div>

                    <?php } else {
                        ?>

                        <div class="row">
                            <div class="col-md-3 text-right-md"> <strong>ประวัติการศึกษา</strong></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]edu_id', $list, $att_Education); ?>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo $form->textField($ProfilesEdu, '[0]institution', array('class' => 'form-control', 'placeholder' => 'สถานที่่จบการศึกษา')); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php echo $form->textField($ProfilesEdu, '[0]date_graduation', $graduation); ?>
                                </div>
                            </div>
                        </div>


                        <div class="add-study"></div>

                        <?php
                    }
                    ?>

                    <div class="row justify-content-center bb-1 pb-20">
                        <div class="col-md-3">
                            <button class="btn btn-info btn-add add_form_field" type="button" id="moreFields">
                                <span class="glyphicon glyphicon-plus"> </span> เพิ่มประวัติการศึกษา
                            </button>
                        </div>
                    </div>

                    <div id="office-section1">
                        <div class="row  mt-20 mb-1">

                            <div class="col-md-3 col-sm-12 text-right-md"> <strong>เอกสารแนบไฟล์วุฒิการศึกษา/วิชาชีพ<small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
                            <!--     <?php echo $form->labelEx($FileEdu,'file_name'); ?> --> 
                            <div class="col-sm-12 col-xs-12 col-md-8">
                                <div id="docqueue"></div>
                                <?php echo $form->fileField($FileEdu,'file_name',array('id'=>'doc','multiple'=>'true')); ?>
                                <script type="text/javascript">
                                    <?php $timestamp = time();?>
                                    $(function() {
                                        $('#doc').uploadifive({
                                            'auto'             : false,

                                            'formData'         : {
                                                'timestamp' : '<?php echo $timestamp;?>',
                                                'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                            },
                                            'queueID'          : 'docqueue',
                                            'uploadScript'     : '<?php echo $this->createUrl("Registration/uploadifiveEdu"); ?>',
                                            'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'pdf':
                                                        case 'png':
                                                        case 'jpg':
                                                        case 'jpeg':
                                                        break;
                                                        default:
                                                        alert('Wrong filetype');
                                                        $('#doc').uploadifive('cancel', file);
                                                        break;
                                                    }
                                                },
                                                'onQueueComplete' : function(file, data) {

                                                 $('#registration-form').submit();

                                             }
                                         });
                                    });
                                </script>
                                <?php echo $form->error($FileEdu,'file_name'); ?>
                            </div>

                        </div>
                        <div class="row">
                           <div class="col-md-offset-3 col-md-4">
                                <?php
                                $idx = 1;
                                $uploadFolder = Yii::app()->getUploadUrl('edufile');
                                $criteria = new CDbCriteria;
                                $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                                $criteria->addCondition("active ='y'");
                                $FileEdu = FileEdu::model()->findAll($criteria);
    
                                if(isset($FileEdu)){
                                    foreach($FileEdu as $fileDatas){
                                        ?>
    
                                            <div id="filedoc<?php echo $idx; ?>">
                                                <!-- <a href="<?php echo $this->createUrl('edufile',array('id' => $fileDatas->id)); ?>" target="_blank"> -->
                                                <?php
                                                    echo '<strong id="filenamedoctext'.$fileDatas->id.'">'.$fileDatas->file_name.'</strong>';
                                                    ?>
                                                <!-- </a> -->
                                                <?php echo '<input id="filenamedoc'.$fileDatas->id.'" 
                                                                    class="form-control"
                                                                   type="text" value="'.$fileDatas->file_name.'" 
                                                                   style="display:none;" 
                                                                   onblur="editName('.$fileDatas->id.');">'; ?>
    
    
                                                <?php echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                                                       'id'=>'btnEditName'.$fileDatas->id,
                                                       'class'=>'btn-action glyphicons pencil btn-danger',
                                                       'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                                       'onclick'=>'$("#filenamedoctext'.$fileDatas->id.'").hide();
                                                                   $("#filenamedoc'.$fileDatas->id.'").show(); 
                                                                   $("#filenamedoc'.$fileDatas->id.'").focus(); 
                                                                   $("#btnEditName'.$fileDatas->id.'").hide(); ')); ?>
    
    
    
                                                <?php echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                                        'id'=>'btnSaveName'.$fileDatas->id,
                                                        'class'=>'btn-action glyphicons btn-danger remove_2',
                                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                                        'onclick'=>'if(confirm("คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร")){ deleteFileDoc("filedoc'.$idx.'","'.$fileDatas->id.'"); }')); ?>
                                               
                                          
                                           
                                        </div>
                                        <?php
                                        $idx++;
                                    }?><br><?php
                                }
                                ?>   
                           </div>
                        </div>
                    </div>

                    <div id="office-section2">
                        <div class="row  mt-20 mb-1">

                            <div class="col-md-3 col-sm-12 text-right-md"> <strong>เอกสารแนบไฟล์ฝึกอบรม<small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
                            <div class="col-sm-12 col-xs-12 col-md-8"">
                                <div id="queue"></div>
                                <?php echo $form->fileField($FileTraining,'file_name',array('id'=>'Training','multiple'=>'true')); ?>
                                <script type="text/javascript">
                                    <?php $timestamp = time();?>
                                    $(function() {
                                        $('#Training').uploadifive({
                                            'auto'             : false,

                                            'formData'         : {
                                                'timestamp' : '<?php echo $timestamp;?>',
                                                'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                                            },
                                            'queueID'          : 'queue',
                                            'uploadScript'     : '<?php echo $this->createUrl("Registration/uploadifiveTraining"); ?>',
                                            'onAddQueueItem' : function(file){
                                                var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'pdf':
                                                        case 'png':
                                                        case 'jpg':
                                                        case 'jpeg':
                                                        break;
                                                        default:
                                                        alert('Wrong filetype');
                                                        $('#Training').uploadifive('cancel', file);
                                                        break;
                                                    }
                                                },
                                                'onQueueComplete' : function(file, data) {

                                                 $('#registration-form').submit();

                                             }
                                         });
                                    });
                                </script>
                                <?php echo $form->error($FileTraining,'file_name'); ?>
                            </div>
                            
                        </div>
                        <div class="row mt-20 mb-3">
                            <div class="col-md-offset-3 col-md-4">
                            <?php
                            $idx = 1;
                            $uploadFolder = Yii::app()->getUploadUrl('Trainingfile');
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                            $criteria->addCondition("active ='y'");
                            $Trainingfile = FileTraining::model()->findAll($criteria);
                            
                            if(isset($Trainingfile)){
                                foreach($Trainingfile as $fileData){

                                    ?>
                                        <div id="filedoc<?php echo $idx; ?>">
                                           <!--  <a href="<?php echo $this->createUrl('Trainingfile',array('id' => $fileData->id)); ?>" target="_blank"> -->
                                            <?php
                                                echo '<strong id="filenamedoctext'.$fileData->id.'">'.$fileData->file_name.'</strong>';
                                                ?>
                                            <!-- </a> -->
                                            <?php echo '<input id="filenameTrain'.$fileData->id.'" 
                                                        class="form-control"
                                                         type="text" value="'.$fileData->file_name.'" 
                                                         style="display:none;" 
                                                         onblur="editName('.$fileData->id.');">'; ?>

                                            <?php echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                                            'id'=>'btnEditName'.$fileData->id,
                                            'class'=>'btn-action glyphicons pencil btn-danger',
                                            'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                            'onclick'=>'$("#filenamedoctext'.$fileData->id.'").hide(); 
                                                        $("#filenameTrain'.$fileData->id.'").show(); 
                                                        $("#filenameTrain'.$fileData->id.'").focus(); 
                                                        $("#btnEditName'.$fileData->id.'").hide(); ')); ?>


                                            <?php echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                            'id'=>'btnSaveName'.$fileData->id,
                                            'class'=>'btn-action glyphicons btn-danger remove_2',
                                            'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                            'onclick'=>'if(confirm("คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร")){ deleteFileDoc("filedoc'.$idx.'","'.$fileData->id.'"); }')); ?>
                                            
                                        </div>
                                    
                                    <?php
                                    $idx++;
                                }?><?php
                            }
                            ?> 
                            </div>  
                        </div>
                    </div>

                    <div id="office-section">
                        <div class="row  mt-20 mb-1" id="employee_type">
                            <div class="col-md-3 col-sm-12 text-right-md"> <strong>ส่วนของพนักงาน</strong></div>
                            <div class="col-sm-12 col-xs-12 col-md-8">
                                <div class="form-group">

                                    <span></span>
                                    <div class="radio radio-danger radio-inline">
                                        <input type="radio" name="type_employee" id="card-7" value="office" <?php if ($profile->type_employee == "office") : ?> checked="checked" <?php endif ?>>

                                        <label for="card-7" class="bg-success text-black">
                                        Office </label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input type="radio" name="type_employee" id="card-8" value="ship" <?php if ($profile->type_employee == "ship") : ?> checked="checked" <?php endif ?>>

                                        <label for="card-8" class="bg-danger text-black">เรือ </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-20 mb-1 bb-1 pb-20" id="employee_detail">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($users, 'department_id'); ?></label>
                                    <?php
                                    $departmentModel = Department::model()->findAll(array(
                                        "condition" => " active = 'y'"
                                    ));
                                    $departmentList = CHtml::listData($departmentModel, 'id', 'dep_title');
                                    $departmentOption = array('class' => 'form-control department', 'empty' => 'แผนก');
                                    ?>
                                    <?php
                                    echo $form->dropDownList($users, 'department_id', $departmentList, $departmentOption);
                                    ?>
                                    <?php echo $form->error($users, 'department_id', array('class' => 'error2')); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($users, 'position_id'); ?></label>
                                    <?php
                                    $positionModel = Position::model()->findAll(array(
                                        "condition" => " active = 'y'"
                                    ));
                                    $positionList = CHtml::listData($positionModel, 'id', 'position_title');
                                    $positiontOption = array('class' => 'form-control position', 'empty' => 'ตำแหน่ง');
                                    ?>
                                    <?php
                                    echo $form->dropDownList($users, 'position_id', $positionList, $positiontOption); ?>
                                    <?php echo $form->error($users, 'position_id', array('class' => 'error2')); ?>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="text-center submit-register">

                        <?php if (Yii::app()->user->getId() == null) { ?>
                            <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block ok_2','onclick'=>"return upload();")); ?>
                        <?php } else {
                            echo CHtml::submitButton($label->label_save, array('class' => 'btn btn-default bg-greenlight btn-lg center-block ok_2','onclick'=>"return upload();"));
                        } ?>
                    </div>

                </div>



                <?php $this->endWidget();
                ?>

            </div>


            <script type="text/javascript">
                $(document).ready(function() {
                    var max_fields = 10;
                    var wrapper = $(".add-study");
                    var add_button = $(".add_form_field");
                    var numItems = 0;
                    var x = 1;

                    $(add_button).click(function(e) {
                        e.preventDefault();
                        if (x < max_fields) {
                            x++;
                            numItems++;
                            var level = '<option value="">ระดับการศึกษา</option>';
                            $(wrapper).append('<div class="row del_edu"><div class="col-sm-3 text-right-md "><strong>ประวัติการศึกษา</strong></div><div class="col-sm-2"><div class="form-group"><select class ="form-control" name="ProfilesEdu[' + numItems + '][edu_id]">' + level + '<?php foreach ($list as $key => $value) : ?><option value=<?php echo $key ?>>ระดับการศึกษา<?php echo $value ?></option><?php endforeach ?></select></div></div><div class="col-sm-3"><div class="form-group"><input type="text" class="form-control" placeholder="สถานที่่จบการศึกษา" name="ProfilesEdu[' + numItems + '][institution]"></div></div><div class="col-sm-2"><div class="form-group"><input class="form-control datetimepicker" autocomplete="off" id="ProfilesEdu_' + numItems + '_date_graduation" placeholder="วันที่จบการศึกษา "name="ProfilesEdu[' + numItems + '][date_graduation]"> </div></div><span class="delete btn-danger" name="mytext[]"><i class="fas fa-minus-circle" ></i> Delete</span></div>'); //add input box
                            $('.datetimepicker').datetimepicker({
                                format: 'Y-m-d',
                                step: 10,
                                timepickerScrollbar: false
                            });
                            $('.xdsoft_timepicker').hide();

                        } else {
                            alert('You Reached the limits')
                        }
                    });
                    $(wrapper).on("click", ".delete", function(e) {
                        e.preventDefault();
                        $(this).parent('.del_edu').remove();
                        x--;
                    });
                });
                $('.default_datetimepicker').datetimepicker({
                    format: 'Y-m-d',
                    step: 10,
                    timepickerScrollbar: false
                });

                $('.xdsoft_timepicker').hide();

                $(function() {
                    $('.user_ID').change(function(event,length){
                        var max = $(this).attr('maxlength');
                        var vals = $(this).val();
                        if (max.length < vals) { 
                            var setval = '' + $(this).val();
                            while (setval.length < max) {
                             setval = '0' + setval;
                         }
                         $(this).val(setval);

                     } 
                        // else {
                        //     alert("คุณได้กรอกเลขประจำตัวพนักงานเกินกว่าที่กำหนด");
                        //      $(this).empty();
                        //      $(this).val();
                        // }
                    });

                    $('#accept').change(function(event) {
                        $("#id_employee").hide();
                        $("#employee_type").hide();
                        $("#employee_detail").hide();
                    });

                    $("#reject").change(function(event) {
                        $("#id_employee").show();
                        $("#employee_type").show();
                        $("#employee_detail").show();
                        $("#office-section").show();
                    });
                    $("#id_employee").hide();
                    $("#employee_type").hide();
                    $("#employee_detail").hide();
                    $('#passport_card').hide();
                    $('#card-1').change(function(event) {
                        $('#passport_card').hide();
                        $('#identification_card').show();
                    });

                    $('#card-2').change(function(event) {
                        $('#passport_card').show();
                        $('#identification_card').hide();
                    });

                    $(".department").change(function() {
                        var id = $(".department").val();
                        $.ajax({
                            type: 'POST',
                            url: "<?= Yii::app()->createUrl('Registration/ListPosition'); ?>",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                $('.position').empty();
                                $('.position').append(data);
                            }
                        });
                    });

                    $(".birth").change(function() {
                        var item = $(".birth").val();
                        $.ajax({
                            type: 'POST',
                            url: "<?= Yii::app()->createUrl('Registration/CalculateBirthday'); ?>",
                            data: {
                                item: item
                            },
                            success: function(data) {
                                $('.ages').val(data);
                                $('.ages').append(data);
                            }
                        });
                    });
                });
            </script>


        </section>
        <div class="login-bg">
            <img class="login-img-1" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg3.png">
            <img class="login-img-2" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg4.png">
        </div>