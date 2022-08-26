<!-- innerLR -->
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
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.css">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'news-form',
                 'enableClientValidation'=>true,
                 'clientOptions'=>array(
                     'validateOnSubmit'=>true
                 ),
                 'errorMessageCssClass' => 'label label-important',
                 'htmlOptions' => array('enctype' => 'multipart/form-data')
             )); ?>
             <p class="note">ค่าที่มี <font color="red">*</font> จำเป็นต้องใส่ให้ครบ</p>
             <div class="row">
              <?php echo $form->labelEx($model,'cms_title'); ?>
              <?php echo $form->textField($model,'cms_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
              
              <?php echo $form->error($model,'cms_title'); ?>
          </div>

          <div class="row">
              <?php echo $form->labelEx($model,'cms_short_title'); ?>
              <?php echo $form->textArea($model,'cms_short_title',array('rows'=>4, 'cols'=>40,'class'=>'span8','maxlength'=>255)); ?>
              
              <?php echo $form->error($model,'cms_short_title'); ?>
          </div>

          <div class="row">
              <?php echo $form->labelEx($model,'cms_url'); ?>
              <?php echo $form->textField($model,'cms_url',array('size'=>60,'maxlength'=>250, 'class'=>'span8','onchange'=>'search(this)')); ?>
              <?php echo $form->error($model,'cms_url'); ?>
          </div>

          <div class="row urllink">
              <?php echo $form->labelEx($model,'cms_tab'); ?>
              <!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
                <?php echo $form->checkBox($model,'cms_tab',array(
                   'value'=>1, 'uncheckValue'=>0 ,
                   'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
               )); ?>
               <!--</div>-->
               <?php echo $form->error($model,'cms_tab'); ?>
           </div>

           <div class="row urllink">
              <?php echo $form->labelEx($model,'cms_type_display'); ?>
              <!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
                <?php echo $form->checkBox($model,'cms_type_display',array(
                   'value'=>1, 'uncheckValue'=>0,'onchange'=>'dotextbox(this)',
                   'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
               )); ?>
               <!--</div>-->
               <?php echo $form->error($model,'cms_type_display'); ?>
           </div>


           <div class="row textarea">
              <?php echo $form->labelEx($model,'cms_detail'); ?>
              <?php echo $form->textArea($model,'cms_detail',array('class'=>'tinymce')); ?>
              <?php echo $form->error($model,'cms_detail'); ?>
          </div>

          <br>
          <!-- <div class="row">
           <?php
           if(isset($imageShow)){
              echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
                 "class"=>"thumbnail"
             ));
          }
          ?>
      </div> -->
      <br>

					<!-- <div class="row">
						<?php echo $form->labelEx($model,'picture'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						  	</div>
						</div>
						<?php echo $form->error($model,'picture'); ?>
					</div> -->
					<!-- <div class="row"> -->
						<!-- <div class="pic-profile"> -->
                            <div class="row" style="width: 35%">
                                <div class="row form-mb-1 justify-content-center box-uploadimage">

                                			<div class="upload-img">
                                				<label class="cabinet center-block">
                                					<figure>
                                                        <center>
                                						<?php
                                						if ($model->cms_picture == null) {
                                							$img  = Yii::app()->theme->baseUrl . "/images/logo_course.png";
                                						} else {
                                							$img = Yii::app()->baseUrl . '/../uploads/news/' . $model->cms_id . '/thumb/' . $model->cms_picture;
                                						}
                                						$url_pro_pic = $img;
                                						?>
                                						<img src="<?php echo $url_pro_pic; ?>" class="gambar img-responsive img-thumbnail" style="width: 250px;height: 180px" name="item-img-output" id="item-img-output" />
                                                     <figcaption>
                                                        <div class="btn btn-default btn-uploadimg"><i class="fa fa-camera"></i> <?= Yii::app()->session['lang'] == 1?'Select picture':'เลือกรูป'; ?> </div>
                                                    </figcaption>
                                                    </center>
                                                </figure>
                                                <input type="hidden" name="url_pro_pic" id="url_pro_pic">
                                                <input type="file"  style="display: none;" id="Profile_pro_pic" class="item-img file center-block d-none" name="News[picture]" />
                                            </label>
                                           <font style="margin-top: 10px;color: red">
                                           <font color="red">*</font> รูปภาพควรมีขนาด 250x180(แนวนอน) หรือ ขนาด 250x(xxx) (แนวยาว)
                                           </font>
                                        </div>

                                    </div>
                                </div>
                                <!-- </div> -->
                            <!-- </div> -->
                         <div class="row buttons" style="margin-top: 10px">
                          <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                      </div>
                      <?php $this->endWidget(); ?>
                  </div><!-- form -->
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
                        <button class="rotate_btn rotate_left btn" data-deg="90"><i class="fas fa-undo"></i>
                        หมุนซ้าย</button>
                        <button class="rotate_btn rotate_right btn" data-deg="-90"><i class="fas fa-redo-alt"></i> 
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
        width: 250,
        height: 180,
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
            width: 250,
            height: 180
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

function cancelForm(){
    window.location.href = "<?= Yii::app()->createUrl('/news/create') ?>";
}

</script>
<!-- END innerLR -->
<script>
	$(function () {
		init_tinymce();
	});
	<?php 
	if(!empty($model->cms_url)){
		?>
		$(document).ready(function(){
			$('.urllink').show();
		});
		<?php
	}else{
        ?>
        $(document).ready(function(){
         $('.urllink').hide();
     });
        <?php
    }
    ?>
    function dotextbox(checkboxElem) {
     if (checkboxElem.checked) {
        $('.textarea').hide();
    } else {
        $('.textarea').show();
    }
}
function search(ele) {
  var val = document.getElementById("News_cms_url").value;
  if(val != ''){
   $('.urllink').show();  
} else {
   $('.urllink').hide();
}
}
</script>