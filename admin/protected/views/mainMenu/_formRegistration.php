


<script src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">

</script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<style type="text/css">
    body {
        font: 13px Arial, Helvetica, Sans-serif;
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
        width: 600px;
    }
    .width500{width: 450px;}
</style>

<!-- innerLR -->
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php
                $form = $this->beginWidget('AActiveForm', array(
                    'id' => 'MainMenu-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
                <!-- <div class="row" style="display: none;">
                    <?php echo $form->labelEx($model, 'lang_id'); ?>
                    <?php echo $this->listlanguageShow($model, 'lang_id','span8'); ?>
                    <?php echo $form->textField($model, 'lang_id'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'lang_id'); ?>
                </div>
                
                <div class="row" id="parent_id" style="display: none;">
                    <?php echo $form->labelEx($model, 'parent_id'); ?>
                    <?php echo $this->listParentMainmenuShow($model, 'parent_id','span8'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'parent_id'); ?>
                </div> -->

                <div class="row">
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <?php if(!isset($_GET['parent_id'])){ ?>
                <div class="row" id="url">
                    <?php echo $form->labelEx($model, 'url'); ?>
                    <?php echo $form->textField($model, 'url', array('size' => 60, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'url'); ?>
                </div>
               <?php } ?>

               <h4 class="labelCourse"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp; ฟอร์มสมัครสมาชิก & แก้ไขข้อมูล<h4>
                <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_regis'); ?>
                    <?php echo $form->textField($label, 'label_regis', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_regis'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_homepage'); ?>
                    <?php echo $form->textField($label, 'label_homepage', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_homepage'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_accept'); ?>
                    <?php echo $form->textField($label, 'label_accept', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_accept'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_reject'); ?>
                    <?php echo $form->textField($label, 'label_reject', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_reject'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_identification'); ?>
                    <?php echo $form->textField($label, 'label_identification', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_identification'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_email'); ?>
                    <?php echo $form->textField($label, 'label_email', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_email'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_courseAll'); ?>
                    <?php echo $form->textField($label, 'label_courseAll', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_courseAll'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_course'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_course', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_course'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_title'); ?>
                    <?php echo $form->textField($label, 'label_title', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_title'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_firstname'); ?>
                    <?php echo $form->textField($label, 'label_firstname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_firstname'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_lastname'); ?>
                    <?php echo $form->textField($label, 'label_lastname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_lastname'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_phone'); ?>
                    <?php echo $form->textField($label, 'label_phone', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_phone'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_station'); ?>
                    <?php echo $form->textField($label, 'label_station', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_station'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_company'); ?>
                    <?php echo $form->textField($label, 'label_company', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_company'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_position'); ?>
                    <?php echo $form->textField($label, 'label_position', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_position'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_station'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_station', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_station'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_company'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_company', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_company'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_position'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_position', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_position'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_save'); ?>
                    <?php echo $form->textField($label, 'label_save', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_save'); ?>
                </div>
            </div>

                <h4 class="labelCourse"><i class="fa fa-window-maximize" aria-hidden="true"></i>&nbsp; แจ้งเตือน (Alert ต่างๆ)<h4>
                <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_alert_identification'); ?>
                    <?php echo $form->textField($label, 'label_alert_identification', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_alert_identification'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_alert_notNumber'); ?>
                    <?php echo $form->textField($label, 'label_alert_notNumber', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_alert_notNumber'); ?>
                </div>
                </div>

                <h4 class="labelCourse"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i>&nbsp; ตัวเลือก (Dropdown)<h4>
                <div class="row">
                    <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dropdown_mr'); ?>
                    <?php echo $form->textField($label, 'label_dropdown_mr', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dropdown_mr'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dropdown_ms'); ?>
                    <?php echo $form->textField($label, 'label_dropdown_ms', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dropdown_ms'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dropdown_mrs'); ?>
                    <?php echo $form->textField($label, 'label_dropdown_mrs', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dropdown_mrs'); ?>
                </div>
                </div>


                <div class="row">
                    <?php echo $form->labelEx($model,'status'); ?>
                    <!-- <div class="toggle-button" data-toggleButton-style-enabled="success"> -->
                        <?php echo $form->checkBox($model,'status',array(
                            'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
                        )); ?>
                    <!-- </div> -->
                    <?php echo $form->error($model,'status'); ?>
                </div>

                
                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2', 'onclick' => "return upload();"), '<i></i>บันทึกข้อมูล'); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>
<!-- END innerLR -->

<script>
    $(function () {
        init_tinymce();
        // getParentList(1);
    });

    // function getParentList(id){
    //     if(id != '1'){
    //         $("#url").css('display','none');
    //         $("#parent_id").css('display','block');
    //         $("#MainMenu_parent_id").attr('disabled',false);
    //     } else {
    //         $("#url").css('display','block');
    //         $("#parent_id").css('display','none');
    //         $("#MainMenu_parent_id").attr('disabled',true);
    //     }
    // }
</script>
