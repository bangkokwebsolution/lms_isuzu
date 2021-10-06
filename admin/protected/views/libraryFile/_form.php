<script src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>

<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.css">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">

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
                    'id' => 'Category-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
                <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>

                <div class="row">
                	<div class="col-md-8">
                    <?php echo $form->labelEx($model, 'library_type_id'); ?>
					<?php echo $form->dropDownList($model, 'library_type_id', CHtml::listData(LibraryType::model()->findAll('active="y"'), 'library_type_id', 'library_type_name') , array('empty' => '-- กรุณาเลือกประเภทห้องสมุด --', 'class' => 'form-control')); ?>
					<?php echo $form->error($model, 'library_type_id'); ?>
                    </div>
                </div>

                <div class="row">
                	<div class="col-md-8">
                    <?php echo $form->labelEx($model, 'library_name'); ?>
                    <?php echo $form->textField($model, 'library_name', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'library_name'); ?>
                    </div>
                </div>

                <div class="row">
                	<div class="col-md-8">
                    <?php echo $form->labelEx($model, 'library_name_en'); ?>
                    <?php echo $form->textField($model, 'library_name_en', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'library_name_en'); ?>
                    </div>
                </div>


                <!-- <div class="row">
                    <div class="col-md-8">
                        <?php echo $form->labelEx($model,'status_ebook'); ?>
                        <?php echo $form->checkBox($model,'status_ebook',array(
                            'data-toggle'=> 'toggle','value'=>"1", 'uncheckValue'=>"2"
                        )); ?>
                        <?php echo $form->error($model,'status_ebook'); ?>
                    </div>
                </div> -->
                

                <div class="row">
                	<div class="col-md-8">
                    <?php echo $form->labelEx($model, 'library_filename'); ?>
                    <?php echo $form->fileField($model, 'library_filename', array('class' => 'form-control', 'onchange'=>"checkExt(this)")); ?>
                    <?php echo $form->error($model, 'library_filename'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <?php 
                        if($model->library_filename != ""){
                            $file = glob(Yii::app()->getUploadPath(null)."*");
                             $path = Yii::app()->basePath;                           
                            foreach ($file as $key => $value) {
                                $filename = basename($value);
                                if($model->library_filename == $filename){
                                    $ext = pathinfo($value, PATHINFO_EXTENSION);
                                    ?>
                                    <a target="blank_" href="../../../../uploads/<?= $filename ?>"><?= $model->library_name.".".$ext ?></a>
                                    <?php
                                    break;
                                }
                            }
                        }
                         ?>
                    </div>
                </div>
                <div class="row" style="width: 20%">
                        <div class="row form-mb-1 justify-content-center box-uploadimage">

                            <div class="upload-img">
                                <label class="cabinet center-block">
                                    <figure>
                                        <center>
                                            <?php
                                            if ($model->library_picture == null) {
                                                $img  = Yii::app()->theme->baseUrl . "/images/default-avatar.png";
                                            } else {
                                                $img = Yii::app()->baseUrl . '/../uploads/library/' . $model->library_id . '/thumb/' . $model->library_picture;
                                            }
                                            $url_pro_pic = $img;
                                            ?>
                                            <img src="<?php echo $url_pro_pic; ?>" class="gambar img-responsive img-thumbnail" style="width: 150px;height: 150px" name="item-img-output" id="item-img-output" />
                                            <figcaption>
                                                <div class="btn btn-default btn-uploadimg"><i class="fa fa-camera"></i> เลือกรูป</div>
                                            </figcaption>
                                        </center>
                                    </figure>
                                    <input type="hidden" name="url_pro_pic" id="url_pro_pic">
                                    <input type="file"  style="display: none;" id="Profile_pro_pic" class="item-img file center-block d-none" name="LibraryFile[picture]" />
                                </label>
                                <center>
                                    <span class="text-danger"><font color="red">*</font>รูปภาพควรมีขนาด 2X2 นิ้ว</span>
                                </center>
                            </div>

                        </div>
                    </div>
                
                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2', 'onclick' => "return upload();"), '<i></i>บันทึกข้อมูล'); ?>
                </div>

                <?php $this->endWidget(); ?>
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
<script>
    $(function () {
        init_tinymce();
    });


    function checkExt(input){
        var id = input.getAttribute("id");
        var input_file = document.getElementById(id);
        if(input_file != ""){
            var file = input_file.files[0];
            var filename = file.name;
             var extension = filename.split(".");
             var count_extension = extension.length;
             extension = (extension[count_extension-1]).toLowerCase();

             if(extension !== 'mp4' && extension !== 'mkv' && extension !== 'mp3' && extension !== 'pdf' && extension !== 'doc' && extension !== 'docx' && extension !== 'xls' && extension !== 'xlsx' && extension !== 'ppt' && extension !== 'pptx' && extension !== 'zip'){

                swal({
                    title: "ไม่สามารถทำรายการได้",
                    text: 'กรุณาเลือกไฟล์นามสกุล mp4, mkv, mp3, pdf, doc, docx, xls, xlsx, ppt, pptx, zip(E-Book) ค่ะ',
                    type: "error",
                    successMode: true,
                });
                input_file.value = "";
            }


        }
    }
</script>

