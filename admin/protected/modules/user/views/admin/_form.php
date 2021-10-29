<style type="text/css">
  #upload-profileimg {
    width: 250px;
    height: 250px;
    padding-bottom: 25px;
}

figure figcaption {
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    margin-top: 10px;
}

.btn-uploadimg {
    font-size: 14px;
    padding: 10px 20px;
}

.clearfix {
    overflow: auto;
}
</style>
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

<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.css">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">
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


                    <div class="row" style="width: 30%">
                        <div class="row form-mb-1 justify-content-center box-uploadimage">

                            <div class="upload-img">
                                <label class="cabinet center-block">
                                    <figure>
                                        <center>
                                            <?php
                                            if ($model->pic_user == null) {
                                                $img  = Yii::app()->theme->baseUrl . "/images/default-avatar.png";
                                            } else {
                                                $img = Yii::app()->baseUrl . '/../uploads/user/' . $model->id . '/thumb/' . $model->pic_user;
                                            }
                                            $url_pro_pic = $img;
                                            ?>
                                            <img src="<?php echo $url_pro_pic; ?>" class="gambar img-responsive img-thumbnail" style="width: 150px;height: 150px" name="item-img-output" id="item-img-output" />
                                            <figcaption>
                                                <div class="btn btn-default btn-uploadimg"><i class="fa fa-camera"></i> <?= Yii::app()->session['lang'] == 1?'Select picture':'เลือกรูป'; ?> </div>
                                            </figcaption>
                                        </center>
                                    </figure>
                                    <input type="hidden" name="url_pro_pic" id="url_pro_pic">
                                    <input type="file"  style="display: none;" id="Profile_pro_pic" class="item-img file center-block d-none" name="News[picture]" />
                                </label>
                                <center>
                                    <span class="text-danger"><font color="red">*</font>รูปภาพควรมีขนาด 2X2 นิ้ว</span>
                                </center>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <?php 
                        $attSearch = array("class"=>"span3",'disable_search' => false);
                        $org_all = CHtml::listData(OrgChart::model()->findAll("active = 'y' and id != 1"), 'id', 'title');
                        ?>
                        <?php (empty($model->org_id)? $select = '' : $select = $model->org_id);?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $form->labelEx($model,'org_id'); ?>
                                <?php echo Chosen::activeDropDownList($model, 'org_id', $org_all, $attSearch); ?>
                                <?php echo $this->NotEmpty();?>
                                <?php echo $form->error($model,'org_id'); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                         <?php $shift_list = ['A','B','Z'];
                             ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'shift'); ?></label>
                                    <select onchange="SelectShift()" name="Profile[shift]" id="Profile_shift" required="required">
                                        <option selected value="">-- กรุณาเลือก shift --</option>
                                        <?php foreach ($shift_list as $keyShift => $valueShift) { ?>
                                                <option <?= $profile->shift == $valueShift ? 'selected':'' ?> value="<?= $valueShift ?>"><?= $valueShift ?></option>
                                        <?php } ?>
                                    </select>
                                   <!--  <?php echo $form->textField($profile, 'shift', array('class' => 'form-control', 'placeholder' => 'กะทำงาน เช่น A B หรือ Z','maxlength'=> '1')); ?> -->
                                    <?php echo $form->error($profile, 'shift'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><label for="username" class="required">employee ID <span class="required">*</span></label></label>
                                    <!-- <label><?php echo $form->labelEx($model, 'username',array("class"=>'required')); ?> -->
                                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'รหัสพนักงาน','disabled'=>'disabled','onchange'=>'check_id()','required'=>'required')); ?>
                                    <?php echo $form->error($model, 'username'); ?>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <!-- <label><?php echo $form->labelEx($model, 'email',array("class"=>'required')); ?></label> -->
                                    <label><label for="email" class="required">อีเมล <span class="required">*</span></label></label>
                                    <!-- <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'อีเมล','onchange'=>"",'type'=>'email')); ?> -->

                                    <input type="email"  name="User[email]" class="form-control" value="<?= $model->email ?>" id="User_email"  placeholder="อีเมล" onchange="checkMail('email')" required="required" disabled>
                                    <?php echo $form->error($model, 'email'); ?>
                                </div>
                            </div>  

                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                    <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง','required'=>'required')); ?>
                                    <?php echo $form->error($profile, 'firstname'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                    <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล','required'=>'required')); ?>
                                    <?php echo $form->error($profile, 'lastname'); ?>
                                </div>
                            </div>
                        </div>                                  


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'firstname_en'); ?></label>
                                    <?php echo $form->textField($profile, 'firstname_en', array('class' => 'form-control', 'placeholder' => 'ชื่ออังกฤษ','required'=>'required')); ?>
                                    <?php echo $form->error($profile, 'firstname_en'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'lastname_en'); ?></label>
                                    <?php echo $form->textField($profile, 'lastname_en', array('class' => 'form-control', 'placeholder' => 'นามสกุลอังกฤษ','required'=>'required')); ?>
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
                        </div>
                        <div class="row">
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'abbreviate_code'); ?></label>
                                    <?php echo $form->textField($profile, 'abbreviate_code', array('class' => 'form-control', 'placeholder' => 'ชื่อส่วนงาน')); ?>
                                    <?php echo $form->error($profile, 'abbreviate_code'); ?>
                                </div>
                            </div>
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

                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'employee_class'); ?></label>
                                    <!--  <?php echo $form->textField($profile, 'employee_class', array('class' => 'form-control', 'placeholder' => 'ระดับตำแหน่งงาน')); ?> -->
                                    <?php echo $form->dropDownList($profile,'employee_class', CHtml::listData(EmpClass::model()->findAll('active=1'), 'id', 'title'), array('empty'=>'-- กรุณาเลือก Employee Class --','onchange'=>'ClassSelected()')); ?>
                                    <?php echo $form->error($profile, 'employee_class'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php 
                                    if(!$profile->isNewRecord && !empty($profile->employee_class)){
                                        $model_po = Position::model()->findAll(array("condition"=>"active =  'y' and class_id = ".$profile->employee_class));
                                        $list_po = CHtml::listData($model_po,'id', 'position_title');
                                        (empty($model->org_id)? $select = '' : $select = $model->org_id);
                                    }else{
                                        $list_po = array();
                                    }?>
                                    <label><?php echo $form->labelEx($profile, 'position_description'); ?></label>
                                    <!-- <?php echo $form->dropDownList($profile,'position_description',$list_po, array('empty'=>'-- กรุณาเลือก Employee Class --')); ?> -->
                                    <?php echo $form->textField($profile, 'position_description', array('class' => 'form-control', 'placeholder' => 'Position Description','readonly'=>ture)); ?>
                                    <?php echo $form->error($profile, 'position_description'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $form->labelEx($profile, 'sex'); ?></label>
                                    <?php echo $form->dropDownList($profile,'sex',array('Male'=>'Male','Female'=>'Female'), array('empty'=>'-- กรุณาเลือก เพศ --')); ?>
                                    <!-- <?php echo $form->textField($profile, 'sex', array('class' => 'form-control', 'placeholder' => 'เพศ เช่น Male หรือ Female')); ?> -->
                                    <?php echo $form->error($profile, 'sex'); ?>
                                </div>
                            </div>
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
<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content crop-img">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">สร้างรูปข่าว
                </h4>
            </div>
            <div class="modal-body">
                <div id="upload-profileimg" class="center-block"></div>
                <div class="text-center center-block mt-2" style="margin-top: 10px" >
                    <button class="rotate_btn rotate_left btn" data-deg="90"><i class="glyphicon glyphicon-refresh"></i>
                    หมุนซ้าย</button>
                    <button class="rotate_btn rotate_right btn" data-deg="-90">
                    หมุนขวา</button>
                </div >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cropcancel" data-dismiss="modal">
                    ยกเลิก                      
                </button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">
                    บันทึกรูป                                             
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // crop รูปภาพ
    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;


    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.upload-profileimg').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);

            console.log($("#Profile_pro_pic").val());
        } else {
            swal("ท่านยังไม่ได้เลือกรูป");                      
        // swal("ขออภัย - เบราว์เซอร์ของคุณไม่รองรับ FileReader API");
    }
}

$uploadCrop = $('#upload-profileimg').croppie({
    viewport: {
        width: 120,
        height: 120,
    },
    showZoomer: true,
    enableOrientation: true,
    enforceBoundary: true,
    enableExif: true
});

// $('.rotate_left, .rotate_right').on('click', function (ev) {
//     imageCrop.croppie('rotate', parseInt($(this).data('deg')));
//     });

$('.rotate_btn').on('click', function(ev) {
    $uploadCrop.croppie('rotate', $(this).attr("data-deg"));
});

$('#cropImagePop').on('shown.bs.modal', function() {
    $uploadCrop.croppie('bind', {
        url: rawImg,
        // orientation: 2
    }).then(function() {});
});

$('.item-img').on('change', function() {
    imageId = $(this).data('id');
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId);
    readFile(this);
});
$('#cropImageBtn').on('click', function(ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: {
            width: 150,
            height: 150
        }
    }).then(function(resp) {
        $('#item-img-output').attr('src', resp);
        $('#cropImagePop').modal('hide');
        $('#url_pro_pic').val($('#item-img-output').attr('src'));
    });
});

$('#cropcancel').on('click', function(ev) {
    $("#Profile_pro_pic").val("");
});


</script>
<script type="text/javascript">

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script type="text/javascript">
    function ClassSelected() {

        var Class = $('#Profile_employee_class').val();
        if (Class == '') {
            $('#Profile_position_description').html('<option value="">-- กรุณาเลือก Employee Class --</optiopn>');
            return;
        }
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl("user/admin/selectClass"); ?>",
            type: 'POST',
            data: ({
                Class: Class,
            }),
            success: function(result) {
                // alert(result);
                $('#Profile_position_description').val(result);
            }
        })

    }
</script>
<script type="text/javascript">
   var focus_email = 0;
   $("#User_email").on("click", function() {
    if ($(this).is(":focus")) {
        focus_email = 0;
    }
});
   function checkMail(input){   
    focus_email++;
    if (focus_email > 0) {

        var email = $('#User_email').val();
        if (email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)+$/)) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("user/admin/check_email"); ?>',
                data: ({
                    email: email,
                }),
                success: function(data) {
                    if(data == 1){
                        $('#User_email').val('');
                        alert('email ซ้ำ');
                    }
                }
            });
        } 
    }
}

function check_id(){   

    var emp_id = $('#User_username').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createAbsoluteUrl("user/admin/check_empid"); ?>',
        data: ({
            emp_id: emp_id,
        }),
        success: function(data) {
            if(data == 1){
                // $('#User_employee_id').val('');
                $('#User_username').val('');
                alert('รหัสพนักงาน ซ้ำ');
            }
        }
    });
}

function SelectShift(){
    var shift = $('#Profile_shift').val();
    if(shift == 'A' || shift == 'B'){
     $('#User_username').attr('required','required').removeAttr('disabled');
     $('#User_email').attr('required','required').removeAttr('disabled');
    }else if(shift == 'Z'){
     $('#User_username').attr('disabled','disabled').removeAttr('required');
     $('#User_email').attr('required','required').removeAttr('disabled');
    }else{
     $('#User_username').attr('disabled','disabled').attr('required');
     $('#User_email').attr('disabled','disabled').attr('required');
    }
    // username.attr('disabled', 'disabled');
    // alert(shift);
}

</script>