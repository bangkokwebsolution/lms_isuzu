<!-- <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/gsdk-base.css" rel="stylesheet"/> -->
<!-- <link href="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet"/> -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.css" media="screen"/>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.js"></script>

<script>
function fillfield(val){
    $('#User_bookkeeper_id').val(val);
}
$(function(){
    //                      var dropDown_department = document.getElementById("User_department_id");
    //                      var dropDown_position = document.getElementById("User_position_id");
    // $("#User_company_id").bind("change", function() {
    //              $.ajax({
    //                  type: "GET", 
    //                  url: "getAjaxDivision",
    //                  data: "company_id="+$("#User_company_id").val(),
    //                  success: function(html) {
    //                      $("#User_division_id").html(html);
    //                      $("#User_department_id").html("<option value=''> เลือกแผนก</option>");
    //                     dropDown_department.selectedIndex = 0;
    //                      $("#User_position_id").html("<option value=''> เลือกตำแหน่ง</option>");
    //                     dropDown_position.selectedIndex = 0;
    //                  }
    //              });
    //          });

    //          $("#User_division_id").bind("change", function() {
    //              $.ajax({
    //                  type: "GET", 
    //                  url: "getAjaxDepartment",
    //                  data: "division_id="+$("#User_division_id").val(),
    //                  success: function(html) {
    //                      $("#User_department_id").html(html);
    //                      $("#User_position_id").html("<option value=''> เลือกตำแหน่ง</option>");
    //                     dropDown_position.selectedIndex = 0;
    //                  }
    //              });
    //          });

             // $("#User_department_id").bind("change", function() {
             //     $.ajax({
             //         type: "GET", 
             //         url: "getAjaxPosition",
             //         data: "department_id="+$("#User_department_id").val(),
             //         success: function(html) {
             //             $("#User_position_id").html(html);
             //         }
             //     });
             // });
});
</script>

<style type="text/css">
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
    color: black;
}
input.form-control{
    height: 40px;
}
.wizard-header{margin-bottom: 2em;}
.form-control{height: 40px;}
label{font-weight: bold;}
.card{padding: 1em;background-color: rgba(255, 255, 255, 0.5);}
.wizard-card .picture{width: 200px;height: 200px;border-radius: 0;}
.wizard-card.ct-wizard-orange .picture:hover {
    border-color: #26A69A;
}
</style>
<?php 
date_default_timezone_set("Asia/Bangkok");
?>

<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                    <?php 
                    $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
                   /* $this->breadcrumbs = array(
                    UserModule::t("Registration"),
                    );*/
                    ?>

                    <?php if (Yii::app()->user->hasFlash('registration')): ?>
                    <div class="success">
                        <div class="card wizard-card ct-wizard-orange" id="wizard">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo Yii::app()->user->getFlash('registration'); 
                                    if(Yii::app()->user->hasFlash('error')) {
                                        echo Yii::app()->user->getFlash('error'); 
                                    } else if (Yii::app()->user->hasFlash('contact')){
                                        echo Yii::app()->user->getFlash('contact'); 
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php unset(Yii::app()->session['rule']); else: ?>
                    <div class="form">
                        <?php $form = $this->beginWidget('UActiveForm', array(
                        'id'=>'registration-form',
                        // 'enableAjaxValidation'=>true,
                        // 'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                        )); ?>
                        <?php echo $form->errorSummary(array($model, $profile)); ?>
                        <div class="card wizard-card ct-wizard-orange" id="wizard">
                        
                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                            <div class="wizard-header">
                                <h3><strong><?php echo UserModule::t("Registration"); ?>
                                <!-- <small class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small> --></strong>
                                </h3>
                                <p class="text-center"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
                            </div>
                            <div class="row pd-1em border">
                                <!-- <div class="col-md-3">
                                    <div class="picture-container">
                                        <h4>รูปภาพโปรไฟล์</h4>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" >
                                                <?php
                                                    // if($model->pic_user!=""){
                                                    $registor = new RegistrationForm;
                                                    $registor->id = $model->id;
                                                    // }
                                                    ?>
                                                    <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $model, $model->pic_user, $registor, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                                            </div>
                                            <div>
                                            <span class="btn btn-success btn-small btn-file">
                                                <span class="fileinput-new">เลือกรูปภาพ</span>
                                                <?php echo $form->fileField($model, 'pic_user', array('id' => 'wizard-picture')); ?>
                                            </span>           
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-md-7"> 
                                    <div class="form-group">
                                        <label>กลุ่มผู้ใช้</label>
                                        <br>
                                         <?php
                                        $UPGroup =  PGroup::model()->findAll(array('condition' => 'id != 1'));
                                        $UPGrouplist = CHtml::listData($UPGroup,'id','group_name');
                                        if(!$model->isNewRecord){
                                            $UGroups = json_decode($model->group);
                                            foreach ($UGroups as $key => $uGroup) {
                                                $data_selected[$uGroup]=array('selected' => 'selected');
                                            }
                                        } 
                                    
                                        foreach ($UPGroup as $Group) {
                                                $UGroup[$Group->id] = $Group->group_name;
                                        }


                                        ?>
                                        <?php 
                                        // foreach ($UPGrouplist as $key => $value) {
                                        //         echo CHtml::checkBox('PGoup[]', (in_array($key, $UGroups))?TRUE:FALSE, array('value'=>$key,'class'=>'inline'));
                                        //         echo '<label>'.$value.'</label></br>';
                                        // }
                                        ?>
                                        <?php  $this->widget('booster.widgets.TbSelect2',
                                                   array(
                                                       'name' => 'PGoup[]',
                                                       'data' => $UGroup,
                                                       'options' => array(
                                                           'placeholder' => 'type clever, or is, or just type!',
                                                           'width' => '100%',
                                                       ),
                                                       'htmlOptions' => array(
                                                           'multiple' => 'multiple',
                                                           'options'=> 
                                                               $data_selected
                                                       ),
                                               )
                                           );?>   
                                        
                                    </div>                                
                                    <!-- <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'username'); ?></label>
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้ (Email)')); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div> -->
                                     <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'อีเมลล์')); ?>
                                        <?php echo $form->error($model, 'email'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'identification'); ?></label>
                                        <?php echo $form->textField($profile, 'identification', array('class' => 'form-control','placeholder' => 'รหัสบัตรประชาชน','oninput' => 'fillfield(this.value)')); ?>
                                        <?php echo $form->error($profile, 'identification'); ?>
                                    </div>
                                    <div class="row">
                                    <?php if($model->isNewRecord) { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'password'); ?></label>
                                                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)')); ?>
                                                <?php echo $form->error($model, 'password'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'verifyPassword'); ?></label>
                                                <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
                                                <?php echo $form->error($model, 'verifyPassword'); ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'newpassword'); ?></label>
                                                <?php echo $form->passwordField($model, 'newpassword', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)')); ?>
                                                <?php echo $form->error($model, 'newpassword'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'confirmpass'); ?></label>
                                                <?php echo $form->passwordField($model, 'confirmpass', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
                                                <?php echo $form->error($model, 'confirmpass'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'title_id'); ?></label>
                                        <?php echo $form->dropDownList($profile, 'title_id', ProfilesTitle::getTitleList(), array('empty' => '---เลือกคำนำหน้าชื่อ---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                        <?php echo $form->error($profile, 'title_id'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                                <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง')); ?>
                                                <?php echo $form->error($profile, 'firstname'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                                <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล')); ?>
                                                <?php echo $form->error($profile, 'lastname'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'tel'); ?></label>
                                                <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์')); ?>
                                                <?php echo $form->error($profile, 'tel'); ?>
                                            </div>
                                        </div>  
                                    </div>
                                    
                                    <div class="row">
                                        <!-- <?php
                                        $companydata = Company::model()->getCompanyList();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($model, 'company_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'company_id', $companydata, array('empty' => 'เลือกฝ่าย', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'company_id'); ?>
                                            </div>
                                        </div> -->
                                        <?php
                                            // $divisiondata = (!$model->division_id)?array():Division::model()->getDivisionListNew();
                                            //$divisiondata = Division::model()->getDivisionListNew();
                                        ?>
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'division_id'); ?></label>
                                                
                                                <?php
                                                echo $form->dropDownList($model, 'division_id', $divisiondata, array('empty' => 'เลือกกอง', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'division_id'); ?>
                                            </div>
                                        </div> -->

                                        <?php
                                            // $departmentdata = (!$model->division_id)?array():Department::model()->getDepartmentList($model->division_id);

                                            // $departmentdata = (!$model->department_id)?array():Department::model()->getDepartmentListNew($model->department_id);
                                            $department = Department::model()->getDepartmentListNew();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'department_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'department_id', $department, array('empty' => 'เลือกแผนก', 'class' => 'form-control', 'style' => 'width:100%')); 
                                                ?>
                                                <?php echo $form->error($model, 'department_id'); ?>
                                            </div>
                                        </div>
                                        <?php   
                                         $Positiondata = Position::model()->getPositionListNew();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'position_id'); ?></label>
                                                
                                                <?php
                                                echo $form->dropDownList($model, 'position_id', $Positiondata, array('empty' => 'เลือกตำแหน่ง', 'class' => 'form-control position', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'position_id'); ?>
                                            </div>
                                        </div>

                                       

                                        <?php
                                        //    $Branch = Branch::model()->getBranchList();
                                        ?>
                                       <!--  <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php //echo $form->labelEx($model, 'branch_id'); ?></label>
                                                <label class="label_branch">ระดับ</label>
                                                <?php
                                                echo $form->dropDownList($model, 'branch_id', $Branch, array('empty' => 'เลือกระดับ', 'class' => 'form-control branch', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'branch_id'); ?>
                                            </div>
                                        </div> -->

                                        <?php
                                            // $station = (!$model->station_id)?array():Station::model()->getStationList($model->station_id);
                                           // $station = Station::model()->getStationList();
                                        ?>
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'station_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'station_id', $station, array('empty' => 'เลือกสถานี', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'station_id'); ?>
                                            </div>
                                        </div> -->

                                        <?php
                                        // $positiondata = ($model->isNewRecord)?array():position::model()->getPositionList();
                                        ?>
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'position_id'); ?></label>
                                                <?php
                                                // echo $form->textField($model, 'position_name', array('class' => 'form-control', 'style' => 'width:100%')); 
                                                echo $form->dropDownList($model, 'position_id', $positiondata, array('empty' => 'เลือกตำแหน่ง', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'position_id'); ?>
                                            </div>
                                        </div> -->
                                        <?php
                                        $my_org = '';
                                        if(!Yii::app()->user->isGuest){
                                            $my_org = json_decode($model->orgchart_lv2);
                                        }
                                        ?>
                                        <?php
                                        $Orgchart = OrgChart::model()->findAll(array(
                                                            'condition' => 'active = "y"',
                                                            'order' => 'id ASC'
                                                            )
                                                        );
                                        ?>
                                    </div>
                                       <?php
                                            $my_group = '';
                                            if(!Yii::app()->user->isGuest){
                                                $my_group = json_decode($model->group);
                                            }
                                        ?>
                                        
                                        <?php 
                                            $type = array(0 =>'สมาชิกทั่วไป',1 => 'แอดมิน');
                                         ?>
                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($model, 'superuser'); ?></label>
                                            <?php
                                            echo $form->dropDownList($model, 'superuser', $type, array('class' => 'form-control', 'style' => 'width:100%')); ?>
                                            <?php echo $form->error($model, 'superuser'); ?>
                                        </div>
                                    
                                        <div class="form-group" style="text-align: right;">
                                            <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t("Register") : 'บันทึก', array('class' => 'btn btn-primary',)); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php $this->endWidget(); ?>
                            </div><!-- form -->
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $('.branch').hide();
            $('.label_branch').hide();
            $(".department").change(function() {
                    var id = $(".department").val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('user/admin/ListPosition'); ?>",
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
                        url: "<?= Yii::app()->createUrl('user/admin/ListBranch'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {
                                console.log(data);
                                if (data == '<option value ="">เลือกระดับ</option>') {
                                    console.log(555);
                                    $('.branch').hide();
                                    $('.label_branch').hide();
                                }else{
                                    console.log(666);
                                    $('.branch').show();
                                    $('.label_branch').show();
                                    $('.branch').empty();
                                    $('.branch').append(data);
                                }
                            }
                        });
                });
        </script>