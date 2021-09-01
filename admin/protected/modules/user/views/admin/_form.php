
<script>

$(function(){
    
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
.errorMessage{
    color:red;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<?php  
date_default_timezone_set("Asia/Bangkok");
?>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                    <?php 

                    $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
                    
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

                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                        )); ?>
                        <?php //echo $form->errorSummary(array($model, $profile)); ?>

                            <div class="wizard-header">
                                <h3><strong><?php echo UserModule::t("Registration"); ?>
                                <!-- <small class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small> --></strong>
                                </h3>
                                <p class="text-left"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
                            </div>
                            
                            <div class="row pd-1em border">

                                    
                                    
                                    
                                <div class="col-md-12">
                                    <?php 
                                        $model_org = OrgChart::model()->findAll(array("condition"=>"active =  'y' and id != '1' "));
                                    ?>
                                    <?php $list = CHtml::listData($model_org,'id', 'title'); ?>
                                    <?php (empty($model->org_id)? $select = '' : $select = $model->org_id);?>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <?php echo $form->labelEx($model,'org_id'); ?>
                                        <?php echo Chosen::activeDropDownList($model, 'org_id', $list, $attSearch); ?>
                                        <?php echo $this->NotEmpty();?>
                                        <?php echo $form->error($model,'org_id'); ?>
                                        </div>
                                    </div>
                                    <br>
                                    

                                    
                                    <div class="row">
                                        


                                        <div class="col-md-4">
                                        <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'employee_id'); ?></label>
                                        <?php echo $form->textField($model, 'employee_id', array('class' => 'form-control', 'placeholder' => 'รหัสพนักงาน','required'=>'required')); ?>
                                        <?php echo $form->error($model, 'employee_id'); ?>
                                        </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'อีเมล')); ?>
                                                <?php echo $form->error($model, 'email'); ?>
                                            </div>
                                        </div>  
                                   
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                                <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง')); ?>
                                                <?php echo $form->error($profile, 'firstname'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                                <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล')); ?>
                                                <?php echo $form->error($profile, 'lastname'); ?>
                                            </div>
                                        </div>
                                    </div>                                  
                                    
                                   
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'firstname_en'); ?></label>
                                                <?php echo $form->textField($profile, 'firstname_en', array('class' => 'form-control', 'placeholder' => 'ชื่ออังกฤษ')); ?>
                                                <?php echo $form->error($profile, 'firstname_en'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'lastname_en'); ?></label>
                                                <?php echo $form->textField($profile, 'lastname_en', array('class' => 'form-control', 'placeholder' => 'นามสกุลอังกฤษ')); ?>
                                                <?php echo $form->error($profile, 'lastname_en'); ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'kind'); ?></label>
                                                <?php echo $form->textField($profile, 'kind', array('class' => 'form-control', 'placeholder' => 'ประเภทพนักงาน เช่น P หรือ J','maxlength'=> '1')); ?>
                                                <?php echo $form->error($profile, 'kind'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'organization_unit'); ?></label>
                                                <?php echo $form->textField($profile, 'organization_unit', array('class' => 'form-control', 'placeholder' => 'รหัสส่วนงาน')); ?>
                                                <?php echo $form->error($profile, 'organization_unit'); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'abbreviate_code'); ?></label>
                                                <?php echo $form->textField($profile, 'abbreviate_code', array('class' => 'form-control', 'placeholder' => 'ชื่อส่วนงาน')); ?>
                                                <?php echo $form->error($profile, 'abbreviate_code'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'location'); ?></label>
                                                <?php echo $form->textField($profile, 'location', array('class' => 'form-control', 'placeholder' => 'สถานที่ทำงาน เช่น SR หรือ GW','maxlength'=> '2')); ?>
                                                <?php echo $form->error($profile, 'location'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'group_name'); ?></label>
                                                <?php echo $form->textField($profile, 'group_name', array('class' => 'form-control', 'placeholder' => 'รหัสกลุ่มงาน')); ?>
                                                <?php echo $form->error($profile, 'group_name'); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'shift'); ?></label>
                                                <?php echo $form->textField($profile, 'shift', array('class' => 'form-control', 'placeholder' => 'กะทำงาน เช่น A B หรือ Z','maxlength'=> '1')); ?>
                                                <?php echo $form->error($profile, 'shift'); ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'employee_class'); ?></label>
                                                <?php echo $form->textField($profile, 'employee_class', array('class' => 'form-control', 'placeholder' => 'ระดับตำแหน่งงาน')); ?>
                                                <?php echo $form->error($profile, 'employee_class'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'position_description'); ?></label>
                                                <?php echo $form->textField($profile, 'position_description', array('class' => 'form-control', 'placeholder' => 'ชื่อตำแหน่งงาน')); ?>
                                                <?php echo $form->error($profile, 'position_description'); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'sex'); ?></label>
                                                <?php echo $form->textField($profile, 'sex', array('class' => 'form-control', 'placeholder' => 'เพศ เช่น Male หรือ Female')); ?>
                                                <?php echo $form->error($profile, 'sex'); ?>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    
                                    
                                    

                                    <div class="row">
                                       
                                       
                             

                                        

                                        
                                      
                                    </div>

                                    
                                   
                                    <div class="form-group" style="text-align: center;">
                                        <?php echo CHtml::submitButton($model->isNewRecord ? 'เพิ่มสมาชิก' : 'บันทึก', array('class' => 'btn btn-primary',)); ?>
                                    </div>
                                </div>

                            </div>
                            <?php $this->endWidget(); ?>
                                        
                            <!-- </div> --><!-- form -->
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
