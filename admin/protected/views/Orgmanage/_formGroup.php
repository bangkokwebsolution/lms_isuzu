<!-- <script src="<?php //echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php //echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php //echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script> -->

<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css"> -->


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
                    'id' => 'Orgchart-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
                <p class="note">ค่าที่มี <span class="required">*</span> จำเป็นต้องใส่ให้ครบ</p>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'division_id'); ?>
                            <?php $div_model = OrgChart::model()->getDivisionListNew();
                            echo $form->dropDownList($model, 'division_id', $div_model, array('empty' => 'เลือก Division', 'class' => 'form-control', 'style' => 'width:100%','required'=>'required')); ?>
                            <?php echo $form->error($model, 'division_id'); ?>
                        </div>
                    </div>

                    
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="OrgChart_parent_id" class="required">Department <span class="required">*</span></label>
                            <?php $dep_model = OrgChart::model()->getDepartmentListNew();
                            echo $form->dropDownList($model, 'parent_id', $dep_model, array('empty' => 'เลือก Department', 'class' => 'form-control','required'=>'required')); ?>
                            <?php echo $form->error($model, 'parent_id'); ?>
                        </div>
                    </div>
                </div>


                <div class="row">
                	<div class="col-md-8">
                    <label for="OrgChart_title" class="required">Group <span class="required">*</span></label>
                    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'autocomplete'=>'off','required'=>'required')); ?>
                    <?php echo $form->error($model, 'title'); ?>
                    </div>
                </div>
                                           
                
                <br>

                <div class="row buttons">
                    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        init_tinymce();
    });

    $("#OrgChart_division_id").change(function() {
        var id = $("#OrgChart_division_id").val();
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('Orgmanage/ListDepartment'); ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#OrgChart_parent_id').empty();
                $('#OrgChart_parent_id').append(data);
            }
        });
    });
</script>

