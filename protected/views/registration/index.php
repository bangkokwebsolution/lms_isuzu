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

    .add_form_work {
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
        /*border: 1px solid #1c97f3;*/
       /* width: 260px;
        height: 40px;
        margin-bottom: 14px;*/
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
        margin: 4px 15px;
        cursor: pointer;
        /* position: absolute;
        right: 0 */
    }
    .delete_work {
        border-radius: 3px;
        border: none;
        color: white;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-table;
        font-size: 14px;
        margin: 4px 15px;
        cursor: pointer;
        position: absolute;
        right: 0 
    }
    .uploadifive-button {
        float: left;
        margin-right: 10px;
    }
    #queue {
        border: 1px solid rgba(26, 26, 26, 0.14901960784313725);
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 100%;
        border-radius: 4px;
    }

    #docqueue {
        border: 1px solid rgba(26, 26, 26, 0.14901960784313725);
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 100%;
        border-radius: 4px;
    }

    .birthday-icon{
        position: relative;
    }
    .birthday-icon i{
        position: absolute;
        right: 16px;
        top: 40px;
    }
    .since-icon{
        position: relative;
    }
    .since-icon i{
        position: absolute;
        right: 16px;
        top: 13px;
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

        //tinymce.triggerSave();
        //tinyMCE.triggerSave();

        var file = $('#queue').val();
        var file2 = $('#docqueue').val();
        var exts = ['jpg','pdf','png','jpeg'];
        if ( file || file2) {
            var get_ext = file.split('.');
            get_ext = get_ext.reverse();

            if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){

                if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0){
                    return true;
                }else{
                    if($('#queue .uploadifive-queue-item').length > 0 ) {
                        $('#Training').uploadifive('upload');
                        return false;
                    }else if($('#docqueue .uploadifive-queue-item').length > 0){
                        $('#doc').uploadifive('upload');
                        return false;
                    }
                } 
            }
        }else{
           if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0 ){
            return true;
        }else{
         // var Training  = $('#Training').uploadifive('upload');
         // var doc =  $('#doc').uploadifive('upload');
         // if($('#queue .uploadifive-queue-item').length > 0 && $('#docqueue .uploadifive-queue-item').length > 0) {
         //    return false;
          //  return [Training,doc];
             if($('#docqueue .uploadifive-queue-item').length > 0){
                $('#doc').uploadifive('upload');
                return false;
             }else if($('#queue .uploadifive-queue-item').length > 0){
                $('#Training').uploadifive('upload');
                return false;

     }


 }
}
}

function deleteFileDoc(filedoc_id,file_id){

    $.get("<?php echo $this->createUrl('Registration/deleteFileDoc'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
           // notyfy({dismissQueue: false,text: "ลบไฟล์เรียบร้อย",type: 'success'});
           var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
           alert(success_file);
           location.reload();
           $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        alert(Unable_file);
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

function deleteFiletrain(filedoc_id,file_id){

    $.get("<?php echo $this->createUrl('Registration/deleteFileTrain'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
           // notyfy({dismissQueue: false,text: "ลบไฟล์เรียบร้อย",type: 'success'});
           var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
           alert(success_file);
           location.reload();
           $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        alert(Unable_file);
    }
});
}

function editNameTrain(filedoc_id){
    var name = $('#filenameTrains'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNameTrain'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filenameTrains'+filedoc_id).hide();
        $('#filenametraintext'+filedoc_id).text(name);
        $('#filenametraintext'+filedoc_id).show();
        $('#btnEditNametrain'+filedoc_id).show();
    });

}
function deleteFilepassport(file_id){
   console.log(file_id);
    $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
           var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
           alert(success_file);
           location.reload();
           $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        alert(Unable_file);
    }
});
}

function editNamepassport(filedoc_id){
    var name = $('#filename_attach_passport'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_passport'+filedoc_id).hide();
        $('#file_attach_passporttext'+filedoc_id).text(name);
        $('#file_attach_passporttext'+filedoc_id).show();
        $('#btnEditName_attach_passport'+filedoc_id).show();
    });
    location.reload();
}
function deleteFilecrew_identification(file_id){
    $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
           var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
           alert(success_file);
           location.reload();
           $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        alert(Unable_file);
    }
});
}

function editNamecrew_identification(filedoc_id){
    var name = $('#filename_attach_crew_identification'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_crew_identification'+filedoc_id).hide();
        $('#file_crew_identificationtext'+filedoc_id).text(name);
        $('#file_crew_identificationtext'+filedoc_id).show();
        $('#btnEditName_attach_crew_identification'+filedoc_id).show();
    });
    location.reload();
}
function deleteFileidentification(file_id){
    $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
           var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
           alert(success_file);
           location.reload();
           $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        alert(Unable_file);
    }
});
}

function editNameidentification(filedoc_id){
    var name = $('#filename_attach_identification'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_identification'+filedoc_id).hide();
        $('#file_identificationtext'+filedoc_id).text(name);
        $('#file_identificationtext'+filedoc_id).show();
        $('#btnEditName_attach_identification'+filedoc_id).show();
    });
    location.reload();
}
function deleteFilehouse_registration(file_id){
    $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
           var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
           alert(success_file);
           location.reload();
           $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        alert(Unable_file);
    }
});
}

function editNamehouse_registration(filedoc_id){
    var name = $('#filename_attach_house_registration'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_house_registration'+filedoc_id).hide();
        $('#file_house_registrationtext'+filedoc_id).text(name);
        $('#file_house_registrationtext'+filedoc_id).show();
        $('#btnEditName_attach_house_registration'+filedoc_id).show();
    });
    location.reload();
}
</script>

<script>
    function check_number() {
        // alert("adadad");
        e_k = event.keyCode
        //if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
            if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
                event.returnValue = false;

                alert("Number only...Please check your information again ...");
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
            $attTime = array('class' => ' form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_date_of_expiry);
            $birthday = array('class' => 'form-control default_datetimepicker birth', 'autocomplete' => 'off', 'placeholder' => $label->label_birthday, 'type' => "text");
            $ships_up_date = array('class' => ' form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_ship_up_date);
            $ships_down_date = array('class' => 'form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_ship_down_date);
            $Since = array('class' => 'form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => Yii::app()->session['lang'] == 1?'Since ':'ตั้งแต่');
            ?>
            <div class="well">

                <div class="row box-img-center mb-2 bb-1">
                    <div class="col-sm-4">
                        <div class="upload-img">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 180px; max-height: 240px;">
                                    <div class="mt-2">
                                        <!-- <input type="file" class="custom-file-input" id="customFileLang" lang="es"> -->
                                        <?php
                                        if ($users->pic_user == null) {

                                            $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                        } else {
                                            $registor = new RegistrationForm;
                                            $registor->id = $users->id;
                                            $img = Yii::app()->baseUrl . '/uploads/user/' . $users->id . '/thumb/' . $users->pic_user;
                                        }
                                        ?>
                                        <img src="<?= $img ?>" alt="">
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 180px; max-height: 240px;"></div>
                                    <!--  <?php echo $form->fileField($users, 'pic_user', array('id' => 'wizard-picture')); ?> 
                                    <label class="btn btn-success" for="customFileLang"><span class="fileinput-new"> เลือกรูปภาพ</span></label> -->
                                    <span class="btn btn-info btn-file"><span class="fileinput-new"><?= Yii::app()->session['lang'] == 1?'Choose image ':'เลือกรูปภาพ'; ?></span>
                                    <?php echo $form->fileField($users, 'pic_user', array('id' => 'wizard-picture')); ?>
                                    <a href="#" class=" btn-info fileinput-exists" data-dismiss="fileinput"><?= Yii::app()->session['lang'] == 1?'Change picture ':'เปลี่ยนรูปภาพ'; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center select-profile mg-0">
                    <div class="form-group">
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="type_user" id="accept" value="1" <?php if ($profile->type_user == 1) : ?> checked="checked" <?php endif ?>>
                            <label for="accept" class="bg-success text-black">
                                <?php echo $label->label_general_public; ?> </label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="type_user" id="reject" value="3" <?php if ($profile->type_user == 3) : ?> checked="checked" <?php endif ?>>
                                <label for="reject" class="bg-danger text-black"><?php echo $label->label_personnel; ?> </label>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-1 id_employee" >
                        <div class="col-sm-4">
                            <div class="form-group" >
                                <!-- <label for=""><?php echo $form->labelEx($users, 'username'); ?></label> -->
                                <label for=""><?php echo $label->label_employee_id ; ?></label>
                                <?php echo $form->textField($users, 'username', array('class' => 'form-control user_ID', 'placeholder' => $label->label_employee_id,'maxlength'=>'13', 'autocomplete' => 'off')); ?>
                                <?php echo $form->error($users, 'username', array('class' => 'error2')); ?>
                                <!-- <input type="text" class="form-control" id="" placeholder="ID พนักงาน"> -->
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <h4 class="topic-register form_name"><i class="fas fa-user-edit"></i> <?= Yii::app()->session['lang'] == 1?'Basic information ':'ข้อมูลพื้นฐาน'; ?></h4>

                    <div class="row justify-content-center form_name">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_title; ?>(TH)</label>
                                <?php  $country = array('1' => 'นาย', '2' => 'นางสาว', '3' => 'นาง');?>
                                <?php
                                $htmlOptions = array('class' => 'form-control', 'empty' => 'คำนำหน้า');
                                echo $form->dropDownList($profile, 'title_id', $country, $htmlOptions);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_firstname; ?>(TH)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => $label->label_firstname)); ?>
                                <?php echo $form->error($profile, 'firstname', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_lastname; ?>(TH)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => $label->label_lastname)); ?>
                                <?php echo $form->error($profile, 'lastname', array('class' => 'error2')); ?>
                                <!--<input type="text" class="form-control" id="">-->
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row justify-content-center form_name">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_title; ?>(EN)</label>
                                <?php  $country2 = array('1' => 'Mr.', '2' => 'Miss.', '3' => 'Mrs.'); ?>
                                <?php
                                $htmlOptions = array('class' => 'form-control', 'empty' => 'Prefix');
                                echo $form->dropDownList($profile, 'title_id', $country2, $htmlOptions);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_firstname; ?>(EN)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'firstname_en', array('class' => 'form-control', 'placeholder' => $label->label_firstname)); ?>
                                <?php echo $form->error($profile, 'firstname_en', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_lastname; ?>(EN)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'lastname_en', array('class' => 'form-control', 'placeholder' => $label->label_lastname)); ?>
                                <?php echo $form->error($profile, 'lastname_en', array('class' => 'error2')); ?>
                                <!--<input type="text" class="form-control" id="">-->
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>


                    <div class="row justify-content-center mt-1 mb-1 form_number_id">
                        <div class="form-group">
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="type_card" id="card-1" value="l" <?php if ($profile->type_card == "l") : ?> checked="checked" <?php endif ?>>
                                <label for="card-1" class="bg-success text-black"><?php echo $label->label_identification; ?> </label>
                            </div>

                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="type_card" id="card-2" value="p" <?php if ($profile->type_card == "p") : ?> checked="checked" <?php endif ?>>
                                <label for="card-2" class="bg-danger text-black"><?php echo $label->label_passport; ?> </label>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center bb-1 pb-20 form_number_id">
                        <div class="col-md-4 col-sm-6 col-xs-12" >
                            <div class="form-group" id="identification_card">
                                <label> <?php echo $label->label_identification;?><font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'identification', array('class' => 'form-control', 'name' => 'idcard', 'maxlength' => '13', 'onKeyPress' => 'return check_number();', 'placeholder' => $label->label_identification)); ?>
                                <?php echo $form->error($profile, 'identification', array('class' => 'error2')); ?>
                            </div>

                            <div class="form-group" id="passport_card">
                                <label><?php echo $label->label_passport;?></label>
                                <?php echo $form->textField($profile, 'passport', array('class' => 'form-control', 'name' => 'passport', 'placeholder' => $label->label_passport)); ?>
                                <?php echo $form->error($profile, 'passport', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group birthday-icon">
                                <i class="far fa-calendar-alt"></i>
                                <label> <?php echo $label->label_date_of_expiry;?></label>
                                <?php echo $form->textField($profile, 'date_of_expiry', $attTime); ?>
                                <?php echo $form->error($profile, 'date_of_expiry', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row justify-content-center mt-20 form_name">
                        <div class="col-md-4 col-sm-6 col-xs-12" >
                            <div class="form-group">
                                <label><?= Yii::app()->session['lang'] == 1?'Crew identification number ':'เลขหนังสือประจำลูกเรือ'; ?></label>
                                <?php echo $form->textField($profile, 'seamanbook', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Crew identification number ':'เลขหนังสือประจำลูกเรือ')); ?>
                                <?php echo $form->error($profile, 'seamanbook', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group birthday-icon">
                                <i class="far fa-calendar-alt"></i>
                                <label><?= Yii::app()->session['lang'] == 1?'Date Expired ':'วันหมดอายุ'; ?></label>
                                <?php echo $form->textField($profile, 'seaman_expire', $attTime); ?>
                                <?php echo $form->error($profile, 'seaman_expire', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group birthday-icon">
                                <i class="far fa-calendar-alt"></i>
                                <label><?php echo $label->label_birthday; ?></label>
                                <?php echo $form->textField($profile, 'birthday', $birthday); ?>
                                <?php echo $form->error($profile, 'birthday', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-xs-12 form_name">
                            <div class="form-group">
                                <label><?php echo $label->label_age; ?></label>
                                <?php echo $form->textField($profile, 'age', array('class' => 'form-control ages', 'placeholder' => $label->label_age,'readonly'=>true )); ?>
                                <?php echo $form->error($profile, 'age', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row justify-content-center form_name">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                            <!--  <label for="">เชื้อชาติ</label>
                                <input type="text" class="form-control" id="" placeholder="เชื้อชาติ"> -->
                                <label><?php echo $label->label_race; ?></label>
                                <?php echo $form->textField($profile, 'race', array('class' => 'form-control', 'placeholder' => $label->label_race)); ?>
                                <?php echo $form->error($profile, 'race', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                            <!-- <label for="">สัญชาติ</label>
                                <input type="text" class="form-control" id="" placeholder="สัญชาติ"> -->
                                <label><?php echo $label->label_nationality; ?></label>
                                <?php echo $form->textField($profile, 'nationality', array('class' => 'form-control', 'placeholder' => $label->label_nationality)); ?>
                                <?php echo $form->error($profile, 'nationality', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>


                    <div class="row justify-content-center form_name">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                            <!-- <label for="">ศาสนา</label>
                                <input type="text" class="form-control" id="" placeholder="เชื้อชาติ"> -->
                                <label><?php echo $label->label_religion; ?></label>
                                <?php echo $form->textField($profile, 'religion', array('class' => 'form-control', 'placeholder' => $label->label_religion)); ?>
                                <?php echo $form->error($profile, 'religion', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_sex; ?></label>
                                <?php
                                $sex_list = array('Male' => $label->label_male, 'Female' => $label->label_female);
                                $sex_Option = array('class' => 'form-control', 'empty' => $label->label_sex);
                                ?>
                                <?php
                                echo $form->dropDownList($profile, 'sex', $sex_list, $sex_Option);
                                ?>
                                <?php echo $form->error($profile, 'sex', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row  mt-1 mb-1 form_name">
                        <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_marital_status; ?></strong></div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <span></span>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="status_sm" id="card-3" value="s" <?php if ($profile->status_sm == "s") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-3" class="bg-success text-black"> <?php echo $label->label_single; ?> </label>
                                </div>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="status_sm" id="card-4" value="m" <?php if ($profile->status_sm == "m") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-4" class="bg-danger text-black"><?php echo $label->label_marry; ?> </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center form_name">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="form-group">

                                <label><?php echo $label->label_address; ?></label>
                                <?php echo $form->textArea($profile, 'address', array('class' => 'form-control', 'cols' => "30", 'rows' => "3", 'placeholder' => $label->label_address)); ?>
                                <?php echo $form->error($profile, 'address', array('class' => 'error2')); ?>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="row justify-content-center form_name">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                            <!-- <label for="">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" id="" placeholder="เบอร์โทรศัพท์"> -->
                                <label><?php echo $label->label_phone; ?></label>
                                <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => $label->label_phone)); ?>
                                <?php echo $form->error($profile, 'tel', array('class' => 'error2')); ?>

                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                            <!-- <label for="">Email</label>
                                <input type="text" class="form-control" id="" placeholder="Email"> -->
                                <label><?php echo $label->label_email; ?><font color="red">*</font></label>
                                <?php echo $form->emailField($users, 'email', array('class' => 'form-control', 'placeholder' => $label->label_email)); ?>
                                <?php echo $form->error($users, 'email', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row justify-content-center form_name">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><?php echo $label->label_id_Line;  ?></label>
                                <?php echo $form->textField($profile, 'line_id', array('class' => 'form-control', 'placeholder' => $label->label_id_Line)); ?>
                                <?php echo $form->error($profile, 'line_id', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="row  mt-1 mb-1 form_name">
                        <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_history_of_severe_illness;  ?></strong></div>
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">

                                <span></span>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="history_of_illness" id="card-5" value="n" <?php if ($profile->history_of_illness == "n") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-5" class="bg-success text-black"><?php echo $label->label_never;  ?> </label>
                                </div>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="history_of_illness" id="card-6" value="y" <?php if ($profile->history_of_illness == "y") : ?> checked="checked" <?php endif ?>>
                                    <label for="card-6" class="bg-danger text-black"><?php echo $label->label_ever;  ?> </label>
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
                    if (Yii::app()->session['lang'] == 1) {
                      $list = CHtml::listData($modelList, 'edu_id', 'edu_name_EN');
                  }else{
                      $list = CHtml::listData($modelList, 'edu_id', 'edu_name');
                  }

                  $att_Education = array('class' => 'form-control', 'empty' => $label->label_education_level);

                  $starting_year  = 2500;
                  $ending_year = 543 + date('Y');
                  if ($ending_year) {

                    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                        $edu_lest[]  =  $starting_year;

                    }                 
                }
                $graduation = array('class' => 'form-control', 'autocomplete' => 'off', 'empty' => $label->label_graduation_year);   
                if (!$ProfilesEdu->isNewRecord) { 
                         if (isset($ProfilesEdu)) {
                              $ProfilesEdu = new ProfilesEdu;
                            ?>
                             <div class="row form_name">
                        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?php echo $label->label_educational;  ?></strong></div>
                        <div class="col-md-2 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]edu_id', $list, $att_Education); ?>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesEdu, '[0]institution', array('class' => 'form-control', 'placeholder' => $label->label_academy)); ?>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]date_graduation',$edu_lest ,$graduation); ?>
                            </div>
                        </div>
                    </div>


                    <div class="add-study"></div>
                     <?php  }else{
                    ?>
                           <div class="add-study">
                       
                       <?php foreach ($ProfilesEdu as $kedu => $valedu) {?>

                            <div class="row del_edu">
                                <div class="col-md-3 col-sm-12 text-right-md"> <strong><?php echo $label->label_educational;  ?></strong></div>
                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <?php echo CHtml::activeDropDownList($valedu, '[' . $kedu . ']edu_id', $list, $att_Education); ?>
                                    </div>
                                </div>


                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">

                                        <?php echo $form->textField($valedu, '[' . $kedu . ']institution', array('class' => 'form-control', 'placeholder' => $label->label_academy)); ?>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <?php echo CHtml::activeDropDownList($valedu, '[' . $kedu . ']date_graduation',$edu_lest, $graduation); ?>
                                    </div>
                                </div>
                                <span class="delete btn-danger" name="mytext[]"><i class="fas fa-minus-circle"></i><?= Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?> </span>

                            </div>

                            <?php } ?>
                           </div>    
                <?php }} else {  ?>

                    <div class="row form_name">
                        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?php echo $label->label_educational;  ?></strong></div>
                        <div class="col-md-2 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]edu_id', $list, $att_Education); ?>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesEdu, '[0]institution', array('class' => 'form-control', 'placeholder' => $label->label_academy)); ?>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]date_graduation',$edu_lest ,$graduation); ?>
                            </div>
                        </div>
                    </div>


                    <div class="add-study"></div>

                    <?php
                }
                ?>

                <div class="row justify-content-center bb-1 pb-20 mt-20 form_name">
                    <div class="col-md-3 col-sm-12  col-xs-12 text-center">
                        <button class="btn btn-info btn-add add_form_field" type="button" id="moreFields">
                            <span class="glyphicon glyphicon-plus"> </span> <?= Yii::app()->session['lang'] == 1?'Add education history ':'เพิ่มประวัติการศึกษา'; ?>
                        </button>
                    </div>
                </div>
                <?php if ($ProfilesWorkHistory->isNewRecord === null) { 
                      if (isset($ProfilesWorkHistory)) {
                         $ProfilesWorkHistory = new ProfilesWorkHistory;
                       ?>
                          <div class="row form_name pt-20 ">
                        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?></strong></div>
                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]company_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Company ':'บริษัท')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]position_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง')); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group since-icon">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]since_date', $Since); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]reason_leaving', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="add-Work"></div>
                  <?php }else{
                    ?>
                    <div class="add-Work">
                        <?php
                        foreach ($ProfilesWorkHistory as $keywh => $valwh) {

                            ?>
                            <div class="row del_work">
                                <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?></strong></div>
                                <div class="col-md-4 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <?php echo $form->textField($valwh, '['.$keywh.']company_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Company ':'บริษัท')); ?>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <?php echo $form->textField($valwh, '['.$keywh.']position_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง')); ?>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
                                <div class="col-md-4 col-sm-6 col-xs-12 ">
                                    <div class="form-group since-icon">
                                        <i class="far fa-calendar-alt"></i>
                                        <?php echo $form->textField($valwh, '['.$keywh.']since_date', $Since); ?>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <?php echo $form->textField($valwh, '['.$keywh.']reason_leaving', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก')); ?>
                                    </div>
                                </div>
                                <span class="delete_work btn-danger" name="mytext[]"><i class="fas fa-minus-circle"></i><?= Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?> </span>
                            </div>

                        <?php } ?>
                    </div>
                <?php }} else {?>
                    <div class="row form_name pt-20" style="padding-top: 20px;">
                        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?></strong></div>
                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]company_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Company ':'บริษัท')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]position_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง')); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group since-icon">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]since_date', $Since); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <?php echo $form->textField($ProfilesWorkHistory, '[0]reason_leaving', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="add-Work"></div>
                <?php } ?>
                <div class="row justify-content-center bb-1 pb-20 mt-20 form_name">
                    <div class="col-md-3 col-sm-12  col-xs-12 text-center">
                        <button class="btn btn-info btn-add add_form_work" type="button" id="moreFieldsWork">
                            <span class="glyphicon glyphicon-plus"> </span> <?= Yii::app()->session['lang'] == 1?'Add Work history ':'เพิ่มประวัติการทำงาน'; ?>
                        </button>
                    </div>
                </div>

                <div id="office-section1" class="form_name ">
                    <div class="row  mt-20 mb-1">

                        <div class="col-md-3 col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Attachments of Qualification / Professional File ':'เอกสารแนบไฟล์วุฒิการศึกษา/วิชาชีพ'; ?><small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
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
                                                    console.log(file);
                                                    if($('#queue .uploadifive-queue-item').length == 0) {
                                                                $('#registration-form').submit();
                                                            }else{
                                                                $('#Training').uploadifive('upload');
                                                            }
                                                   //$('#registration-form').submit();

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
                           $confirm_del  = Yii::app()->session['lang'] == 1?'Do you want to delete the file ?\nWhen you agree, the system will permanently delete the file from the system. ':'คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร';
                           foreach($FileEdu as $fileDatas){
                            ?>

                            <div id="filenamedoc<?php echo $idx; ?>">
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
                                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFileDoc("filedoc'.$idx.'","'.$fileDatas->id.'"); }')); ?>

                                    </div>
                                    <?php
                                    $idx++;
                                }?><br><?php
                            }
                            ?>   
                        </div>
                    </div>
                </div>

                <div id="office-section2" class="form_name">
                    <div class="row  mt-20 mb-1">

                        <div class="col-md-3 col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training file attachment ':'เอกสารแนบไฟล์ฝึกอบรม'; ?><small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
                        <div class="col-sm-12 col-xs-12 col-md-8">
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
                                                    console.log(data);
                                                   $('#registration-form').submit();
                                                   // if($('#docqueue .uploadifive-queue-item').length == 0) {
                                                   //              $('#registration-form').submit();
                                                   //          }else{
                                                   //              $('#queue').uploadifive('upload');
                                                   //          }

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
                              $confirm_del  = Yii::app()->session['lang'] == 1?'Do you want to delete the file ?\nWhen you agree, the system will permanently delete the file from the system. ':'คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร'; 
                              foreach($Trainingfile as $fileData){

                                ?>
                                <div id="filenameTrain<?php echo $idx; ?>">
                                 <!--  <a href="<?php echo $this->createUrl('Trainingfile',array('id' => $fileData->id)); ?>" target="_blank"> -->
                                    <?php
                                    echo '<strong id="filenametraintext'.$fileData->id.'">'.$fileData->file_name.'</strong>';
                                    ?>
                                    <!-- </a> -->
                                    <?php echo '<input id="filenameTrains'.$fileData->id.'" 
                                    class="form-control"
                                    type="text" value="'.$fileData->file_name.'" 
                                    style="display:none;" 
                                    onblur="editNameTrain('.$fileData->id.');">'; ?>


                                    <?php echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                                        'id'=>'btnEditNametrain'.$fileData->id,
                                        'class'=>'btn-action glyphicons pencil btn-danger',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'$("#filenametraintext'.$fileData->id.'").hide(); 
                                        $("#filenameTrains'.$fileData->id.'").show(); 
                                        $("#filenameTrains'.$fileData->id.'").focus(); 
                                        $("#btnEditNametrain'.$fileData->id.'").hide(); ')); ?>


                                    <?php echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                        'id'=>'btnSaveNametrain'.$fileData->id,
                                        'class'=>'btn-action glyphicons btn-danger remove_2',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFiletrain("filedoc'.$idx.'","'.$fileData->id.'"); }')); ?>

                                    </div>

                                    <?php
                                    $idx++;
                                }?><?php
                            }
                            ?> 
                        </div>  
                    </div>
                </div>
                <div class="row  mt-1 mb-1 form_name">
                    <div class="col-md-3 text-right-md"> <strong><?php echo Yii::app()->session['lang'] == 1?'File attachment':'เอกสารแนบไฟล์'; ?><small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
                </div>
                <div class="row  mt-1 mb-1 form_name">
                    <div class="col-md-3 text-right-md"> <strong><?php echo Yii::app()->session['lang'] == 1?'File attachment passport':'ไฟล์พาสปอร์ต'; ?></strong></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-append">

                                <div class="">
                                    <?php echo $form->fileField($AttachName, 'attach_passport', array('id' => 'wizard-picture')); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->error($AttachName, 'attach_passport'); ?>
                        <?php 
                            $passport = Yii::app()->getUploadUrl('attach');
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                            $criteria->addCondition("active ='y'");
                            $criteria->addCondition("file_data ='1'");
                            $Attach_passport_File = AttachFile::model()->find($criteria);
                            if (isset($Attach_passport_File)) {
                                echo '<strong id="file_attach_passporttext'.$Attach_passport_File->id.'">'.$Attach_passport_File->filename.'</strong>';
                                echo '<input id="filename_attach_passport'.$Attach_passport_File->id.'" 
                                    class="form-control"
                                    type="text" value="'.$Attach_passport_File->filename.'" 
                                    style="display:none;" 
                                    onblur="editNamepassport('.$Attach_passport_File->id.');">'; 
                                echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                                        'id'=>'btnEditName_attach_passport'.$Attach_passport_File->id,
                                        'class'=>'btn-action glyphicons pencil btn-danger',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'$("#file_attach_passporttext'.$Attach_passport_File->id.'").hide(); 
                                        $("#filename_attach_passport'.$Attach_passport_File->id.'").show(); 
                                        $("#filename_attach_passport'.$Attach_passport_File->id.'").focus(); 
                                        $("#btnEditName_attach_passport'.$Attach_passport_File->id.'").hide(); ')); 

                                echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                        'id'=>'btnSaveName_attach_passport'.$Attach_passport_File->id,
                                        'class'=>'btn-action glyphicons btn-danger remove_2',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFilepassport("'.$Attach_passport_File->id.'"); }'));
                            }
                        ?>
                    </div>
                </div>

                <div class="row  mt-1 mb-1 form_name">
                    <div class="col-md-3 text-right-md"> <strong><?php echo Yii::app()->session['lang'] == 1?' File attachment Crew identification':'ไฟล์หนังสือประจำตัวลูกเรือ'; ?></strong></div>
                    <div class="col-md-4">
                        <div class="form-group">

                               <div class="input-append">
                                <div class="">
                                    <?php echo $form->fileField($AttachName, 'attach_crew_identification', array('id' => 'wizard-picture')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($AttachName, 'attach_crew_identification'); ?>
                            <?php 
                            $crew_identification = Yii::app()->getUploadUrl('attach');
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                            $criteria->addCondition("active ='y'");
                            $criteria->addCondition("file_data ='2'");
                            $Attach_crew_identification_File = AttachFile::model()->find($criteria);
                            if (isset($Attach_crew_identification_File)) {
                                echo '<strong id="file_crew_identificationtext'.$Attach_crew_identification_File->id.'">'.$Attach_crew_identification_File->filename.'</strong>';
                                echo '<input id="filename_attach_crew_identification'.$Attach_crew_identification_File->id.'" 
                                    class="form-control"
                                    type="text" value="'.$Attach_crew_identification_File->filename.'" 
                                    style="display:none;" 
                                    onblur="editNamecrew_identification('.$Attach_crew_identification_File->id.');">'; 
                                echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                                        'id'=>'btnEditName_attach_crew_identification'.$Attach_crew_identification_File->id,
                                        'class'=>'btn-action glyphicons pencil btn-danger',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'$("#file_crew_identificationtext'.$Attach_crew_identification_File->id.'").hide(); 
                                        $("#filename_attach_crew_identification'.$Attach_crew_identification_File->id.'").show(); 
                                        $("#filename_attach_crew_identification'.$Attach_crew_identification_File->id.'").focus(); 
                                        $("#btnEditName_attach_crew_identification'.$Attach_crew_identification_File->id.'").hide(); ')); 

                                echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                        'id'=>'btnSaveName_attach_crew_identification'.$Attach_crew_identification_File->id,
                                        'class'=>'btn-action glyphicons btn-danger remove_2',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFilecrew_identification("'.$Attach_crew_identification_File->id.'"); }'));
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row  mt-1 mb-1 form_name">
                    <div class="col-md-3 text-right-md"> <strong><?php echo Yii::app()->session['lang'] == 1?'File attachment identification':'ไฟล์สำเนาบัตรประชาชน'; ?></strong></div>
                    <div class="col-md-4">
                        <div class="form-group">
                             <div class="input-append">
                                <div class="">
                            <?php echo $form->fileField($AttachName, 'attach_identification', array('id'=>"wizard-picture")); ?> 
                                 </div>
                            </div>
                            <?php echo $form->error($AttachName, 'attach_identification'); ?>
                            <?php 
                            $identification = Yii::app()->getUploadUrl('attach');
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                            $criteria->addCondition("active ='y'");
                            $criteria->addCondition("file_data ='3'");
                            $Attach_identification_File = AttachFile::model()->find($criteria);
                            if (isset($Attach_identification_File)) {
                                echo '<strong id="file_identificationtext'.$Attach_identification_File->id.'">'.$Attach_identification_File->filename.'</strong>';
                                 echo '<input id="filename_attach_identification'.$Attach_identification_File->id.'" 
                                    class="form-control"
                                    type="text" value="'.$Attach_identification_File->filename.'" 
                                    style="display:none;" 
                                    onblur="editNameidentification('.$Attach_identification_File->id.');">'; 
                                echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                                        'id'=>'btnEditName_attach_identification'.$Attach_identification_File->id,
                                        'class'=>'btn-action glyphicons pencil btn-danger',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'$("#file_identificationtext'.$Attach_identification_File->id.'").hide(); 
                                        $("#filename_attach_identification'.$Attach_identification_File->id.'").show(); 
                                        $("#filename_attach_identification'.$Attach_identification_File->id.'").focus(); 
                                        $("#btnEditName_attach_identification'.$Attach_identification_File->id.'").hide(); ')); 

                                echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                        'id'=>'btnSaveName_attach_identification'.$Attach_identification_File->id,
                                        'class'=>'btn-action glyphicons btn-danger remove_2',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFileidentification("'.$Attach_identification_File->id.'"); }'));

                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row  mt-1 mb-1 form_name">
                    <div class="col-md-3 text-right-md"> <strong><?php echo Yii::app()->session['lang'] == 1?'File attachment House registration':'ไฟล์สำเนาทะเบียนบ้าน'; ?></strong></div>
                    <div class="col-md-4">
                        <div class="form-group">

                              <div class="input-append">
                                <div class="">
                            <?php echo $form->fileField($AttachName, 'attach_house_registration', array('id'=>"wizard-picture")); ?>
                            </div>
                            </div>
                           <?php echo $form->error($AttachName, 'attach_house_registration'); ?>
                              <?php 
                            $house_registration = Yii::app()->getUploadUrl('attach');
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                            $criteria->addCondition("active ='y'");
                            $criteria->addCondition("file_data ='4'");
                            $Attach_house_registration_File = AttachFile::model()->find($criteria);
                            if (isset($Attach_house_registration_File)) {
                                echo '<strong id="file_house_registrationtext'.$Attach_house_registration_File->id.'">'.$Attach_house_registration_File->filename.'</strong>';
                                 echo '<input id="filename_attach_house_registration'.$Attach_house_registration_File->id.'" 
                                    class="form-control"
                                    type="text" value="'.$Attach_house_registration_File->filename.'" 
                                    style="display:none;" 
                                    onblur="editNamehouse_registration('.$Attach_house_registration_File->id.');">'; 
                                echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                                        'id'=>'btnEditName_attach_house_registration'.$Attach_house_registration_File->id,
                                        'class'=>'btn-action glyphicons pencil btn-danger',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'$("#file_house_registrationtext'.$Attach_house_registration_File->id.'").hide(); 
                                        $("#filename_attach_house_registration'.$Attach_house_registration_File->id.'").show(); 
                                        $("#filename_attach_house_registration'.$Attach_house_registration_File->id.'").focus(); 
                                        $("#btnEditName_attach_house_registration'.$Attach_house_registration_File->id.'").hide(); ')); 

                                echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                        'id'=>'btnSaveName_attach_house_registration'.$Attach_house_registration_File->id,
                                        'class'=>'btn-action glyphicons btn-danger remove_2',
                                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFilehouse_registration("'.$Attach_house_registration_File->id.'"); }'));
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="office-section">
                    <div class="row  mb-1 " id="employee_type" >
                        <div class="col-md-3 col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Employee section ':'ส่วนของพนักงาน'; ?></strong></div>
                        <div class="col-sm-12 col-xs-12 col-md-8">
                            <div class="form-group">

                                <span></span>
                                <div class="radio radio-danger radio-inline emp">
                                    <input type="radio" name="type_employee" id="card-7" value="2" <?php if ($profile->type_employee == 2) : ?> checked="checked" <?php endif ?>>

                                    <label for="card-7" class="bg-success text-black"> <?php echo $label->label_office ?> </label>
                                </div>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="type_employee" id="card-8" value="1" <?php if ($profile->type_employee == 1) : ?> checked="checked" <?php endif ?>>

                                    <label for="card-8" class="bg-danger text-black"><?php echo $label->label_ship ?> </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-1 pb-20" id="employee_detail">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo $label->label_company; ?></label>
                                <?php
                                $departmentModel = Department::model()->findAll(array(
                                    "condition" => " active = 'y'"
                                ));
                                $departmentList = CHtml::listData($departmentModel, 'id', 'dep_title');
                                $departmentOption = array('class' => 'form-control department', 'empty' => $label->label_placeholder_company);
                                ?>
                                <?php
                                echo $form->dropDownList($users, 'department_id', $departmentList, $departmentOption);
                                ?>
                                <?php echo $form->error($users, 'department_id', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo $label->label_position; ?></label>
                                <?php
                                $positionModel = Position::model()->findAll(array(
                                    "condition" => " active = 'y'"
                                ));
                                $positionList = CHtml::listData($positionModel, 'id', 'position_title');
                                $positiontOption = array('class' => 'form-control position', 'empty' => $label->label_placeholder_position);
                                ?>
                                <?php
                                echo $form->dropDownList($users, 'position_id', $positionList, $positiontOption); ?>
                                <?php //echo $form->error($users, 'position_id', array('class' => 'error2')); ?>

                            </div>
                        </div>

                           <div class="col-md-8">
                                <div class="form-group">
                                    <label class="label_branch"><?php echo $label->label_branch; ?> </label>
                                    <?php
                                    $BranchModel = Branch::model()->findAll(array(
                                        "condition" => " active = 'y'"
                                    ));
                                    $BranchList = CHtml::listData($BranchModel, 'id', 'branch_name');
                                    $BranchOption = array('class' => 'form-control Branch', 'empty' => $label->label_placeholder_branch );
                                    ?>
                                    <?php
                                    echo $form->dropDownList($users, 'branch_id', $BranchList, $BranchOption);
                                    ?>
                                    <?php echo $form->error($users, 'branch_id', array('class' => 'error2')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="office-section_gen">
                        <div class="row  mb-1 " id="employee_type" >
                            <div class="col-md-3 col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'The boat position you are interested in applying for ':'ตำแหน่งเรือที่ท่านสนใจสมัคร'; ?></strong></div>
                            <div class="col-sm-12 col-xs-12 col-md-8">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <?php
                                        $Department_ship = Department::model()->findAll(array(
                                            'condition' => 'type_employee_id=:type_employee_id AND active=:active',
                                            'params' => array(':type_employee_id'=>1, ':active'=>'y')));

                                        foreach ($Department_ship as $keydepart => $valuedepart) {
                                            $position_ship = Position::model()->findAll(array(
                                                'condition' => 'department_id=:department_id AND active=:active',
                                                'params' => array(':department_id'=>$valuedepart['id'], ':active'=>'y')
                                            ));

                                            $positionLists[] = CHtml::listData($position_ship, 'id', 'position_title');
                                 // var_dump($positionLists);
                                    // foreach ($positionLists as $keypos => $valuepos) { 

                                    //    $positions_id = $valuepos['id'];
                                    //    $positions_title = $valuepos['position_title'];

                                    //   $positionListss[] = array($positions_id=>$positions_title);

                                    //   var_dump($positionLists);
                                    //    }

                                        }
                                        ?> 
                                        <?php
                                        $positiontOption = array('class' => 'form-control position_gen ', 'empty' => $label->label_placeholder_position, 'name' => 'position_gen');
                                        ?>
                                        <?php echo $form->dropDownList($users, 'position_id', $positionLists, $positiontOption); ?>
                                        <?php echo $form->error($users, 'position_id', array('class' => 'error2')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="well form_ship">
                    <div id="report-staff">
                        <h3 class="text-center"><?php echo $label->label_boat_person_report; ?></h3>
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><?php echo $label->label_boat_name; ?></label>
                                        <!-- <input type="text" class="form-control" id="" placeholder="ขึ้นจากเรือชื่อ">
                                            <label><?php echo $label->label_race; ?></label> -->
                                            <?php echo $form->textField($profile, 'ship_name', array('class' => 'form-control', 'placeholder' => $label->label_placeholder_boat_name)); ?>
                                            <?php echo $form->error($profile, 'ship_name', array('class' => 'error2')); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group birthday-icon">
                                            <i class="far fa-calendar-alt"></i>
                                            <label><?php echo $label->label_ship_up_date; ?></label>
                                        <!-- <input class="form-control default_datetimepicker " autocomplete="off" placeholder="เมื่อวันที่" type="text" name="" id="" value="">  
                                            <label><?php echo $label->label_race; ?></label> -->
                                            <?php echo $form->textField($profile, 'ship_up_date', $ships_up_date); ?>
                                            <?php echo $form->error($profile, 'ship_up_date', array('class' => 'error2')); ?>                                                           </div>
                                        </div>
                                    </div>

                                    <!-- <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for=""><?php echo $label->label_adress2; ?></label>
                                                <?php echo $form->textArea($profile, 'address2', array('class' => 'form-control', 'cols' => "30", 'rows' => "3", 'placeholder' => $label->label_placeholder_address2)); ?>
                                                <?php echo $form->error($profile, 'address2', array('class' => 'error2')); ?>
                                            </div>
                                        </div>
                                    </div>
                                -->
                                <div class="row justify-content-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo $label->label_phone1; ?></label>
                                           <!--  <input type="text" class="form-control" id="" placeholder="เบอร์โทรศัพท์ที่สามารถติดต่อได้"> 
                                             <label><?php echo $label->label_phone; ?></label>-->
                                             <?php echo $form->textField($profile, 'phone1', array('class' => 'form-control', 'placeholder' => $label->label_phone1)); ?>
                                             <?php echo $form->error($profile, 'phone1', array('class' => 'error2')); ?>
                                         </div>
                                     </div>
                                     <div class="col-md-4">
                                        <div class="form-group birthday-icon">
                                            <i class="far fa-calendar-alt"></i>
                                            <label><?php echo $label->label_ship_down_date; ?></label>
                                            <!-- <input class="form-control default_datetimepicker " autocomplete="off" placeholder="สามารถจะลงทำงานเรือครั้งต่อไป" type="text" name="" id="" value=""> -->      
                                            <?php echo $form->textField($profile, 'ship_down_date', $ships_down_date); ?>
                                            <?php echo $form->error($profile, 'ship_down_date', array('class' => 'error2')); ?>                                                            </div>
                                        </div>
                                    </div>
                                     <!--   <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><?php echo $label->label_phone2; ?></label>
                                      
                                            <?php echo $form->textField($profile, 'phone2', array('class' => 'form-control', 'placeholder' => $label->label_phone2)); ?>
                                            <?php echo $form->error($profile, 'phone2', array('class' => 'error2')); ?>
                                        </div>
                                    </div> -->
                                </div>

                             <!--    <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for=""><?php echo $label->label_phone3; ?></label>
                                            <?php echo $form->textField($profile, 'phone3', array('class' => 'form-control', 'placeholder' => $label->label_phone3)); ?>
                                            <?php echo $form->error($profile, 'phone3', array('class' => 'error2')); ?>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row justify-content-center">


                                </div>
                            </div>


                            <div class="text-center submit-register">

                                <?php 
                                $branch_js = $users->branch_id;
                                if ($branch_js === null ) {
                                 $branch_js = 0;
                             }else{
                                 $branch_js = 1;
                             }

                             $new_form = $users->isNewRecord;
                             if ($new_form) {
                               $new_form = true;
                           }else{
                            $new_form = 0;
                        }

                        if (Yii::app()->user->getId() == null) { ?>
                            <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block ok_2','onclick'=>"return upload();")); ?>
                        <?php } else {
                            echo CHtml::submitButton($label->label_save, array('class' => 'btn btn-default bg-greenlight btn-lg center-block ok_2','onclick'=>"return upload();"));
                        } ?>
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

                                var level = '<option value=""><?php echo $label->label_education_level; ?></option>';
                                var academy = '<?php echo $label->label_academy; ?>';
                                var graduation_year = '<option value=""><?php echo $label->label_graduation_year; ?></option>';
                                var del = '<?php echo Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?>';
                                $(wrapper).append('<div class="row del_edu"><div class="col-md-3 col-sm-12 text-right-md "><strong><?php echo $label->label_educational; ?></strong></div>'
                                    +'<div class="col-md-2 col-sm-6"><div class="form-group"><select class ="form-control" name="ProfilesEdu[' + numItems + '][edu_id]">' + level + '<?php foreach ($list as $key => $value) : ?><option value=<?php echo $key ?>><?php echo $value ?></option><?php endforeach ?></select></div></div>'
                                    +'<div class="col-md-3 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + academy + '" name="ProfilesEdu[' + numItems + '][institution]"></div></div>'
                            +'<div class="col-md-2 col-sm-6"><div class="form-group"><select class="form-control" autocomplete="off" id="ProfilesEdu_' + numItems + '_date_graduation" name="ProfilesEdu[' + numItems + '][date_graduation]">' + graduation_year + '<?php foreach ($edu_lest as $keys => $values): ?><option value="<?php echo $keys ?>"><?php echo $values ?></option><?php endforeach ?></select></div></div><span class="delete btn-danger" name="mytext[]"><i class="fas fa-minus-circle" ></i> ' + del + '</span></div>'); //add input box
                        // $('.datetimepicker').datetimepicker({
                        //     format: 'Y-m-d',
                        //     step: 10,
                        //     timepickerScrollbar: false
                        // });
                        // $('.xdsoft_timepicker').hide();

                    } else {
                        alert('You Reached the limits')
                    }
                });
                        $(wrapper).on("click", ".delete", function(e) {
                            e.preventDefault();
                            $(this).parent('.del_edu').remove();
                            x--;
                        });

                        var max_fields_work = 10;
                        var wrapper_work = $(".add-Work");
                        var add_button_work = $(".add_form_work");
                        var numItems_work = 0;
                        var i = 1;

                        $(add_button_work).click(function(e) {
                            e.preventDefault();
                            if (i < max_fields_work) {
                                i++;
                                numItems_work++;
                                var head_work = '<?php echo Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?>';
                                var company_work = '<?php echo Yii::app()->session['lang'] == 1?'Company ':'บริษัท'; ?>';
                                var position_work = '<?php echo Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง'; ?>';
                                var since_work = '<?php echo Yii::app()->session['lang'] == 1?'Since ':'ตั้งแต่'; ?>';
                                var reason_for_leaving = '<?php echo Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก'; ?>';
                                var del_work = '<?php echo Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?>';
                                $(wrapper_work).append('<div class="row del_work"><div class="col-md-3 col-sm-12 text-right-md "><strong> ' + head_work + '</strong></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + company_work + '" name="ProfilesWorkHistory[' + numItems_work + '][company_name]"></div></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + position_work + '" name="ProfilesWorkHistory[' + numItems_work + '][position_name]"></div></div>'+'<div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group since-icon"><i class="far fa-calendar-alt"></i><input type="text" class="form-control datetimepicker" autocomplete = "off" placeholder="' + since_work + '" name="ProfilesWorkHistory[' + numItems_work + '][since_date]"></div></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + reason_for_leaving + '" name="ProfilesWorkHistory[' + numItems_work + '][reason_leaving]"></div></div>'
                            +'<span class="delete_work btn-danger" name="mytext[]"><i class="fas fa-minus-circle" ></i> ' + del_work + '</span></div>'); //add input box
                                $('.datetimepicker').datetimepicker({
                                    format: 'd-m-Y',
                                    step: 10,
                                    timepickerScrollbar: false
                                });
                                $('.xdsoft_timepicker').hide();

                            } else {
                                alert('You Reached the limits')
                            }
                        });
                        $(wrapper_work).on("click", ".delete_work", function(e) {
                            e.preventDefault();
                            $(this).parent('.del_work').remove();
                            i--;
                        });

                        $('#accept').change(function(event) {
                            $(".id_employee").hide();
                            $('.form_name').show();
                            $('.form_number_id').show();
                            $("#office-section").hide();
                            $("#office-section_gen").show();
                        });
                        $("#reject").change(function(event) {
                            $(".id_employee").show();
                            $('.form_name').show();
                            $('.form_number_id').show();
                            $("#office-section").show();
                            $("#office-section_gen").hide();
                        });

                        $("#card-7").change(function(event) {
                            var id = $("input[name='type_employee']:checked").val();
                            $.ajax({
                                type: 'POST',
                                url: "<?= Yii::app()->createUrl('Registration/ListDepartment'); ?>",
                                data: {
                                    id: id
                                },
                                success: function(data) {
                                    $('.department').empty();
                                    $('.department').append(data);
                                    var Branch ='<option value ="">Select Level </option>';
                                    var Position ='<option value ="">Select Position </option>';
                                    $('.position').empty();
                                    $('.Branch').empty();
                                    $('.position').append(Position);
                                    $('.Branch').append(Branch);
                                }
                            });
                        });

                        $("#card-8").change(function(event) {
                            var id = $("input[name='type_employee']:checked").val();
                            $.ajax({
                                type: 'POST',
                                url: "<?= Yii::app()->createUrl('Registration/ListDepartment'); ?>",
                                data: {
                                    id: id
                                },
                                success: function(data) {
                                    $('.department').empty();
                                    $('.department').append(data);
                                   var Branch ='<option value ="">Select Branch </option>';
                                   var Position ='<option value ="">Select Position </option>';
                                    $('.position').empty();
                                    $('.Branch').empty();
                                    $('.position').append(Position);
                                    $('.Branch').append(Branch);
                                }
                            });
                        });
                // $('.ok_2').click(function(){
                //     var id = $("#file_Crew_identification").val();
                //     alert(id);
                // });
    //             $("select[name='position_gen']:eq(0)").on("change", function() {                  
    // $("select[name='position_gen']:eq(1)").find("optgroup, option").hide().filter("[label='" + this.value + "'], [label='" + this.value + "'] > *").show();
    //         });
    //             // var optGroup = document.getElementsByTagName("optgroup")[0];
    //             // var option = document.getElementsByTagName("option")[0];
    //             // option.style.display = "inline";
    //             // optGroup.style.display = "none";
    //             // var optGroup = document.getElementsByTagName("optgroup")[1];
    //             // optGroup.style.display = "none";

});
$('.default_datetimepicker').datetimepicker({
               // format: 'Y-m-d',
               format: 'd-m-Y',
               step: 10,
               timepickerScrollbar: false
           });

$('.xdsoft_timepicker').hide();

$(function() {
    $('.user_ID').change(function(event,length){
                    var max = 13;//$(this).attr('maxlength');
                    var vals = $(this).val();
                    if (max.length < vals.length) { 
                        var setval = '' + $(this).val();
                        while (setval.length < max.length) {
                           setval = '0' + setval;
                       }

                       $(this).val(setval);

                   }else{
                    var setval = '' + $(this).val();
                    while (setval.length < max) {
                       setval = '0' + setval;
                   }

                   $(this).val(setval);
               }
           });
    var new_forms = <?php echo $new_form; ?>;
                    //console.log(new_forms);
                    if (new_forms === 1 || new_forms === true) {   

                        var type_users = $("input[name='type_user']:checked").val();
                        if (type_users === '3') {

                            var type_cards = $("input[name='type_card']:checked").attr('value');
                            //console.log('type_cards');
                            if (type_cards === 'l') {

                                $('#passport_card').hide();
                                $('#identification_card').show();
                                $(".id_employee").show();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").show();
                                $("#office-section_gen").hide();
                                $('.form_ship').hide();
                            }else if(type_cards === 'p'){

                                $('#passport_card').show();
                                $('#identification_card').hide();
                                $(".id_employee").show();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").show();
                                $("#office-section_gen").hide();
                                $('.form_ship').hide();
                            }else if(type_cards === '' || typeof  type_cards === 'undefined' || typeof  type_cards === null){

                                $('#passport_card').hide();
                                $('#identification_card').show();
                                $(".id_employee").show();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").show();
                                $("#office-section_gen").hide();
                                $('.form_ship').hide();
                            }
                        }else if (type_users === '1'){

                            var type_cards = $("input[name='type_card']:checked").val();
                            if (type_cards === 'l') {

                                $('#passport_card').hide();
                                $('#identification_card').show();
                                $(".id_employee").hide();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").hide();
                                $("#office-section_gen").show();
                                $('.form_ship').hide();
                            }else if(type_cards === 'p'){

                                $('#passport_card').show();
                                $('#identification_card').hide();
                                $(".id_employee").hide();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").hide();
                                $("#office-section_gen").show();
                                $('.form_ship').hide();
                            }else if(type_cards === '' || typeof  type_cards === 'undefined' || typeof  type_cards === null){

                                $('#passport_card').hide();
                                $('#identification_card').show();
                                $(".id_employee").hide();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").hide();
                                $("#office-section_gen").show();
                                $('.form_ship').hide();
                            }
                        }else if (typeof  type_users === 'undefined' ){
                            $('.Branch').hide();
                            $('.label_branch').hide();
                            $(".id_employee").hide();
                            $('#passport_card').hide();
                            $("#office-section").hide();
                            $('.form_name').hide();
                            $('.form_number_id').hide();
                            $('.form_ship').hide(); 
                            $("#office-section_gen").hide();
                        }              
                    }else if(new_forms === 0 || typeof  new_forms === 'undefined' || new_forms === false){

                       var type_users = $("input[name='type_user']:checked").val();

                       if (type_users === '3') {

                        var type_cards = $("input[name='type_card']:checked").val();
                        if (type_cards === 'l') {
                            var branch = <?php echo $branch_js; ?>;
                                //console.log(branch);
                                if (branch === 1) {
                                    $('.Branch').show();
                                    $('.label_branch').show();
                                }else if(branch === 0){
                                    $('.Branch').hide();
                                    $('.label_branch').hide();
                                }
                                var type_employee = $("input[name='type_employee']:checked").val();

                                if (type_employee === '1') {

                                    $('.form_ship').show();
                                }else{

                                    $('.form_ship').hide();
                                }
                                $('#passport_card').hide();
                                $('#identification_card').show();
                                $(".id_employee").show();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").show();
                                $("#office-section_gen").hide();

                            }else if(type_cards === 'p'){
                                var branch = <?php echo $branch_js; ?>;
                                //console.log(branch);
                                if (branch === 1) {
                                    $('.Branch').show();
                                    $('.label_branch').show();
                                }else if(branch === 0){
                                    $('.Branch').hide();
                                    $('.label_branch').hide();
                                }
                                var type_employee = $("input[name='type_employee']:checked").val();
                                if (type_employee === '1') {
                                    $('.form_ship').show();
                                }else{
                                    $('.form_ship').hide();
                                }
                                $('#passport_card').show();
                                $('#identification_card').hide();
                                $(".id_employee").show();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").show();
                                $("#office-section_gen").hide();

                            }
                        }else if (type_users === '1'){

                            var type_cards = $("input[name='type_card']:checked").val();
                            if (type_cards === 'l') {

                                $('#passport_card').hide();
                                $('#identification_card').show();
                                $(".id_employee").show();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").hide();
                                $("#office-section_gen").show();
                                $('.form_ship').hide();

                            }else if(type_cards === 'p'){

                                $('#passport_card').show();
                                $('#identification_card').hide();
                                $(".id_employee").show();
                                $('.form_name').show();
                                $('.form_number_id').show();
                                $("#office-section").hide();
                                $("#office-section_gen").show();
                                $('.form_ship').hide();
                            }
                        }  
                    }  
                 // $("input[name='type_employee']").prop("checked", true);


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
                    $(".position").change(function() {
                        var id = $(".position").val();
                        $.ajax({
                            type: 'POST',
                            url: "<?= Yii::app()->createUrl('Registration/ListBranch'); ?>",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                //console.log(data);
                                if (data === '<option value ="">Select Level </option>') {
                                $('.Branch').hide();
                                $('.label_branch').hide();
                                }else{

                                $('.Branch').show();
                                $('.label_branch').show();
                                $('.Branch').empty();
                                $('.Branch').append(data);
                            }
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