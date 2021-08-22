
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
<?php  
date_default_timezone_set("Asia/Bangkok");
?>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                    <?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
                    
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
                                <p class="text-center"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
                            </div>
                            
                            <div class="row pd-1em border">
                                    
                                <div class="col-md-8">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'emp_id'); ?></label>
                                        <?php echo $form->textField($model, 'emp_id', array('class' => 'form-control', 'placeholder' => 'รหัสพนักงาน','required'=>'required')); ?>
                                        <?php echo $form->error($model, 'emp_id'); ?>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="row">
                                        
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'อีเมล')); ?>
                                                <?php echo $form->error($model, 'email'); ?>
                                            </div>
                                        </div>  
                                    </div>
                                    
                                    

                                    <div class="row">
                                       
                                       
                                        

                                       

                                        
                                      
                                    </div>
                                   
                                    <div class="form-group" style="text-align: right;">
                                        <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t("Register") : 'บันทึก', array('class' => 'btn btn-primary',)); ?>
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
            $('.branch').hide();
            $('.label_branch').hide();
            
        </script>