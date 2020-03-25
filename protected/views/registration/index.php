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
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.css" >
<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
.container1 input[type=text] {
padding:5px 0px;
margin:5px 5px 5px 0px;
}


.add_form_field
{
    background-color: #1c97f3;
    border: none;
    color: white;
    padding: 8px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border:1px solid #186dad;

}

input{
    border: 1px solid #1c97f3;
    width: 260px;
    height: 40px;
    margin-bottom:14px;
}

.delete{
    background-color: #fd1200;
    border: none;
    color: white;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 4px 2px;
    cursor: pointer;

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
            <?php
            $attTime = array('class' =>' form-control default_datetimepicker','autocomplete'=>'off','placeholder'=>'วันหมดอายุ');
            $graduation = array('class' => 'form-control default_datetimepicker','autocomplete'=>'off','placeholder'=>'วันที่จบการศึกษา');
            $birthday = array('class' => 'form-control default_datetimepicker','autocomplete'=>'off','placeholder'=>'วันเดือนปีเกิด','type'=>"text");
            ?>
            <div class="well">

                <div class="row justify-content-center mb-2 bb-1">
                    <div class="col-sm-4">
                        <div class="upload-img">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 144px; height: 130px;">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-profile.png" alt="">
                                    <div class="mt-2">
                                        <?php
                                        if ($users->pic_user==null) {?>
                                          <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                                      <?php  }else{
                                        $registor = new RegistrationForm;
                                        $registor->id = $users->id;                                       
                                        $img= Yii::app()->baseUrl.'/uploads/user/'.$users->id.'/original/'.$users->pic_user;
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="custom-file">
                             <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 180px; max-height: 240px;"></div>
                                <!--  <?php echo $form->fileField($users, 'pic_user', array('id' => 'wizard-picture')); ?> 
                                <label class="btn btn-success" for="customFileLang"><span class="fileinput-new"> เลือกรูปภาพ</span></label> -->
                                <span class="btn btn-info btn-file"><span class="fileinput-new">เลือกรูปภาพ</span>     
                                <?php echo $form->fileField($users, 'pic_user', array('id' => 'wizard-picture')); ?>
                                <a href="#" class=" btn-info fileinput-exists" data-dismiss="fileinput" >เปลี่ยนรูปภาพ</a>
                            </div>                     
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center select-profile">
                <div class="form-group">
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="type_user" id="accept" value="1"<?= ($type_user == 1)?'checked':($profile->type_user) ? 'checked' : ''?>>
                        <label for="accept" class="bg-success text-black">
                        สำหรับบุคคลทั่วไป </label>
                    </div>
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="type_user" id="reject" value="3"<?= ($type_user == 3)?'checked':($profile->type_user) ? 'checked' : ''?>>
                        <label for="reject" class="bg-danger text-black">สำหรับพนักงาน </label>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group" id="id_employee">
                        <label for=""><?php echo $form->labelEx($users, 'employee_id'); ?></label>
                        <?php echo $form->textField($users, 'employee_id', array('class' => 'form-control','placeholder'=>'เลขประจำตัวพนักงาน')); ?>
                        <?php echo $form->error($users, 'employee_id', array('class' => 'error2')); ?>
                        <!-- <input type="text" class="form-control" id="" placeholder="ID พนักงาน"> -->
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
                        <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control','placeholder'=>'ชื่อ')); ?>
                        <?php echo $form->error($profile, 'firstname', array('class' => 'error2')); ?>
                    </div>
                </div>
                <div class="col-sm-5 col-lg-3">
                    <div class="form-group">
                        <label for=""><?= $label->label_lastname ?></label>
                        <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control','placeholder'=>'นามสกุล')); ?>
                        <?php echo $form->error($profile, 'lastname', array('class' => 'error2')); ?>
                        <!--<input type="text" class="form-control" id="">-->
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="row justify-content-center mt-1 mb-1">
                <div class="form-group">
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="Identify" id="card-1" value="1">
                        <label for="card-1" class="bg-success text-black">
                        เลขบัตรประจำตัวประชาชน </label>
                    </div>
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="Identify" id="card-2" value="2">
                        <label for="card-2" class="bg-danger text-black">เลขหนังสือเดินทาง </label>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center bb-1 ">
                <div class="col-sm-4">
                    <div class="form-group" id="identification_card">
                        <?php echo $form->labelEx($profile, 'identification'); ?>
                        <?php echo $form->textField($profile, 'identification', array('class' => 'form-control', 'name' => 'idcard', 'maxlength' => '13', 'onKeyPress' => 'return check_number();','placeholder'=>'เลขบัตรประจำตัวประชาชน')); ?>
                        <?php echo $form->error($profile, 'identification', array('class' => 'error2')); ?>
                    </div>

                    <div class="form-group" id="passport_card">
                        <?php echo $form->labelEx($profile, 'passport'); ?>
                        <?php echo $form->textField($profile, 'passport', array('class' => 'form-control', 'name' => 'passport','placeholder'=>'passport')); ?>
                        <?php echo $form->error($profile, 'passport', array('class' => 'error2')); ?>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <!-- <label for="">วันหมดอายุบัตร</label>
                            <input type="text" class="form-control" id="" placeholder="วันหมดอายุบัตร" > -->
                            <?php echo $form->labelEx($profile, 'date_of_expiry'); ?>
                            <?php echo $form->textField($profile, 'date_of_expiry',$attTime); ?>
                            <?php echo $form->error($profile, 'date_of_expiry', array('class' => 'error2')); ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="row justify-content-center mt-20">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <!-- <label for="">วัน/เดือน/ปี</label>
                            <input type="date" class="form-control" id="" placeholder="วัน/เดือน/ปี"> -->
                            <?php echo $form->labelEx($profile, 'birthday'); ?>
                            <?php echo $form->textField($profile, 'birthday',$birthday); ?>
                            <?php echo $form->error($profile, 'birthday', array('class' => 'error2')); ?>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                        <!-- <label for="">อายุ</label>
                            <input type="text" class="form-control" id="" placeholder="อายุ"> -->
                            <?php echo $form->labelEx($profile, 'age'); ?>
                            <?php echo $form->textField($profile, 'age', array('class' => 'form-control','placeholder'=>'อายุ')); ?>
                            <?php echo $form->error($profile, 'age', array('class' => 'error2')); ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-sm-4">
                        <div class="form-group">
                       <!--  <label for="">เชื้อชาติ</label>
                        <input type="text" class="form-control" id="" placeholder="เชื้อชาติ"> -->
                        <?php echo $form->labelEx($profile, 'race'); ?>
                        <?php echo $form->textField($profile, 'race', array('class' => 'form-control','placeholder'=>'เชื้อชาติ')); ?>
                        <?php echo $form->error($profile, 'race', array('class' => 'error2')); ?>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <!-- <label for="">สัญชาติ</label>
                            <input type="text" class="form-control" id="" placeholder="สัญชาติ"> -->
                            <?php echo $form->labelEx($profile, 'nationality'); ?>
                            <?php echo $form->textField($profile, 'nationality', array('class' => 'form-control','placeholder'=>'สัญชาติ')); ?>
                            <?php echo $form->error($profile, 'nationality', array('class' => 'error2')); ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>


                <div class="row justify-content-center">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <!-- <label for="">ศาสนา</label>
                            <input type="text" class="form-control" id="" placeholder="เชื้อชาติ"> -->
                            <?php echo $form->labelEx($profile, 'religion'); ?>
                            <?php echo $form->textField($profile, 'religion', array('class' => 'form-control','placeholder'=>'ศาสนา')); ?>
                            <?php echo $form->error($profile, 'religion', array('class' => 'error2')); ?>
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
                                <input type="radio" name="status_sm" id="card-3" value="s"<?= ($status_sm == "s")?'checked':($profile->status_sm) ? 'checked' : ''?>>
                                <label for="card-3" class="bg-success text-black">
                                โสด </label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="status_sm" id="card-4" value="m"<?= ($status_sm == "m")?'checked':($profile->status_sm) ? 'checked' : ''?>>
                                <label for="card-4" class="bg-danger text-black">สมรส </label>   
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <div class="form-group">
                        <!-- <label for="card-4" class="bg-danger text-black">ที่อยู่</label>
                            <textarea class="form-control" name="" id="" placeholder="ที่อยู่" value="" required="" cols="30" rows="3"></textarea> -->
                            <?php echo $form->labelEx($profile, 'address'); ?>
                            <?php echo $form->textArea($profile, 'address', array('class' => 'form-control','cols'=>"30" ,'rows'=>"3",'placeholder'=>'ที่อยู่')); ?>
                            <?php echo $form->error($profile, 'address', array('class' => 'error2')); ?>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <!-- <label for="">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" id="" placeholder="เบอร์โทรศัพท์"> -->
                            <?php echo $form->labelEx($profile, 'tel'); ?>
                            <?php echo $form->textField($profile, 'tel', array('class' => 'form-control','placeholder'=>'เบอร์โทรศัพท์')); ?>
                            <?php echo $form->error($profile, 'tel', array('class' => 'error2')); ?>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                        <!-- <label for="">Email</label>
                            <input type="text" class="form-control" id="" placeholder="Email"> -->
                            <label><?php echo $form->labelEx($users, 'email'); ?></label>
                            <?php echo $form->emailField($users, 'email', array('class' => 'form-control','placeholder'=>'E-mail')); ?>
                            <?php echo $form->error($users, 'email', array('class' => 'error2')); ?>
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
                                <input type="radio" name="history_of_illness" id="card-5" value="n"<?= ($history_of_illness == "n")?'checked':($profile->history_of_illness) ? 'checked' : ''?>>
                                <label for="card-5" class="bg-success text-black">
                                ไม่เคย </label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="history_of_illness" id="card-6" value="y"<?= ($history_of_illness == "y")?'checked':($profile->history_of_illness) ? 'checked' : ''?>>
                                <label for="card-6" class="bg-danger text-black">เคย </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row  mt-20 mb-1 bb-1">
                    <div class="col-sm-3 text-right"> <strong>ประวัติการศึกษา :</strong></div>
                    <?php
                    
                    $modelList = Education::model()->findAll(array(
                        "condition"=>" active = 'y'"));
                    $list = CHtml::listData($modelList,'edu_id', 'edu_name');
                    $att_Education = array('class' => 'form-control','empty' => 'ระดับการศึกษา');
                    if(!$ProfilesEdu->isNewRecord){

                        $ProfilesEdu = count($ProfilesEdu);

                        foreach ($ProfilesEdu as $key=>$value){
                            ?>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <?php echo CHtml::activeDropDownList($value, '['.$key.']edu_id', $list,$att_Education); ?>
                                    <!--    <?php echo $form->error($ProfilesEdu,'edu_id'); ?>  -->

                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">

                                    <?php echo $form->textField($value, '['.$key.']institution', array('class' => 'form-control','placeholder'=>'สถานที่่จบการศึกษา')); ?>
                                    <!--     <?php echo $form->error($ProfilesEdu, 'institution', array('class' => 'error2')); ?> -->
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <?php echo $form->textField($value, '['.$key.']date_graduation', $graduation); ?>
                                    <!--   <?php echo $form->error($ProfilesEdu, 'date_graduation', array('class' => 'error2')); ?> -->
                                </div>
                            </div>

                            <div class="form-group" >
                                <label class="control-label"></label>
                                <button class="btn btn-danger btn-remove remove_edu" type="button" name="mytext[]" style="width: 100%;">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </div>
                            
                            <?php
                        }     }else{
                            ?>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]edu_id', $list,$att_Education); ?>
                                    <!--  <?php echo $form->error($ProfilesEdu,'edu_id'); ?>  -->

                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <?php echo $form->textField($ProfilesEdu, '[0]institution', array('class' => 'form-control','placeholder'=>'สถานที่่จบการศึกษา')); ?>
                                    <!--  <?php echo $form->error($ProfilesEdu, 'institution', array('class' => 'error2')); ?> -->
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <?php echo $form->textField($ProfilesEdu, '[0]date_graduation', $graduation); ?>
                                    <!--  <?php echo $form->error($ProfilesEdu, 'date_graduation', array('class' => 'error2')); ?> -->
                                </div>
                            </div>  <br>
                            <div class="containers"> </div>


                            <?php
                        }
                        ?>
                        <button class="btn btn-success btn-add add_form_field"  type="button" id="moreFields"  style="width: 100%;">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>   
                    </div>
                    <div class="row  mt-20 mb-1" id="employee_type">
                        <div class="col-sm-3 text-right"> <strong>ส่วนของพนักงาน :</strong></div>
                        <div class="col-sm-4">
                            <div class="form-group" >

                                <span></span>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="type_employee" id="card-7" value="office"<?= ($type_employee == "office")?'checked':($profile->type_employee) ? 'checked' : ''?>>
                                    <label for="card-7" class="bg-success text-black">
                                    Office </label>
                                </div>
                                <div class="radio radio-danger radio-inline">
                                    <input type="radio" name="type_employee" id="card-8" value="ship"<?= ($type_employee == "ship")?'checked':($profile->type_employee) ? 'checked' : ''?>>
                                    <label for="card-8" class="bg-danger text-black">เรือ </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-20 mb-1 bb-1 pb-20" id="employee_detail">
                        <div class="col-sm-4">
                            <div class="form-group">
                             <label><?php echo $form->labelEx($users, 'department_id'); ?></label>
                             <?php
                             $departmentModel = Department::model()->findAll(array(
                                "condition"=>" active = 'y'"));
                             $departmentList = CHtml::listData($departmentModel,'id', 'dep_title');
                             $departmentOption = array('class' => 'form-control department','empty' => 'แผนก');
                             ?>
                             <?php
                             echo $form->dropDownList($users, 'department_id', $departmentList, $departmentOption);
                             ?>
                             <?php echo $form->error($users, 'department_id', array('class' => 'error2')); ?> 
                         </div>
                     </div>

                     <div class="col-sm-4">
                        <div class="form-group">
                         <label><?php echo $form->labelEx($users, 'position_id'); ?></label>
                         <?php
                         $positionModel = Position::model()->findAll(array(
                            "condition"=>" active = 'y'"));
                         $positionList = CHtml::listData($positionModel,'id', 'position_title');
                         $positiontOption = array('class' => 'form-control position','empty' => 'ตำแหน่ง');
                         ?>
                         <?php
                         echo $form->dropDownList($users, 'position_id', $positionList, $positiontOption);?>
                         <?php echo $form->error($users, 'position_id', array('class' => 'error2')); ?> 

                     </div>
                 </div>

             </div> 
             <div class="text-center mt-20">
                <!-- <input class="btn btn-default bg-greenlight btn-lg center-block" type="submit" name="yt0" value="Register"> -->
                <!-- <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?> -->
                <?php if (Yii::app()->user->getId() == null) { ?>
                    <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block')); ?>
                <?php } else {
                    echo CHtml::submitButton($label->label_save, array('class' => 'btn btn-default bg-greenlight btn-lg center-block'));
                } ?>
            </div>

        </div>



        <?php $this->endWidget();
        ?>

    </div>
    <div class="login-bg">
        <img class="login-img-1" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg3.png">
        <img class="login-img-2" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg4.png">
    </div>
    <script type="text/javascript">
      $(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".containers"); 
    var add_button      = $(".add_form_field"); 
    var numItems = 0;
    var x = 1; 
    $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            numItems++;
            $(wrapper).append('<div class="ttt"><div class="col-sm-3 text-right ddd"><strong>ประวัติการศึกษา :</strong></div><div class="col-sm-2"><div class="form-group"><select class ="form-control" name="ProfilesEdu['+numItems+'][edu_id]"><?php foreach ($list as $key => $value): ?><option value=<?php echo $key?>><?php echo $value?></option><?php endforeach ?></select></div></div><div class="col-sm-3"><div class="form-group"><input type="text" class="form-control" placeholder="สถานที่่จบการศึกษา" name="ProfilesEdu['+numItems+'][institution]"></div></div><div class="col-sm-2"><div class="form-group"><input class="form-control datetimepicker" autocomplete="off" id="ProfilesEdu_'+numItems+'_date_graduation" placeholder="วันที่จบการศึกษา "name="ProfilesEdu['+numItems+'][date_graduation]"> </div></div><div class="delete">Delete</div></div>'); //add input box
            $('.datetimepicker').datetimepicker({
                    format:'Y-m-d',
                    step:10,
                    timepickerScrollbar:false
                     });
                $('.xdsoft_timepicker').hide();
                    
        }
        else
        {
        alert('You Reached the limits')
        }
    });
    
    $(wrapper).on("click",".delete", function(e){ 
        e.preventDefault(); $(this).parent('.ttt').remove(); 
        x--;
    })
});
       $('.default_datetimepicker').datetimepicker({
        format:'Y-m-d',
        step:10,
        timepickerScrollbar:false
    });

       $('.default_datetimepicker').datetimepicker({step:10});
       $('.xdsoft_timepicker').hide();

       $(function(){
         $('#accept').change(function(event) {
             $("#id_employee").hide();
             $("#employee_type").hide();
             $("#employee_detail").hide();
         });
         $("#reject").change(function(event) {
             $("#id_employee").show();
             $("#employee_type").show();
             $("#employee_detail").show();
         });
         $('#passport_card').hide();
         $('#card-1').change(function(event) {
            $('#passport_card').hide();
            $('#identification_card').show();
        });

         $('#card-2').change(function(event) {
            $('#passport_card').show();
            $('#identification_card').hide();
        });
         $(".department").change(function(){
          var id = $(".department").val();
          $.ajax({
            type: 'POST',
            url: "<?=Yii::app()->createUrl('Registration/ListPosition');?>",
            data:{id:id},
            success: function(data) {
             $('.position').empty(); 
             $('.position').append(data); 
         }
     });
      });

     });
 </script>
