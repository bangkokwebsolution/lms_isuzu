


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
                    'id' => 'Language-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>

                <div class="row">
                <?php
                if(isset($model->imageShow)){
                    echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->imageShow), $model->imageShow,array(
                        "class"=>"thumbnail"
                    ));
                }
                ?>
                </div>
                <br>

                <div class="row">
                    <?php echo $form->labelEx($model,'image'); ?>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-append">
                            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'image'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <?php echo $form->error($model,'image'); ?>
                </div>

                <div class="row">
                    <font color="#990000">
                        <?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 30 x 30 px
                    </font>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'language'); ?>
                    <?php echo $form->textField($model, 'language', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'language'); ?>
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
    });
</script>
