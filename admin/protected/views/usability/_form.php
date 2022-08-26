<!-- innerLR -->
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
					'id'=>'usability-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
					<p class="note">ค่าที่มี <font color="red">*</font> จำเป็นต้องใส่ให้ครบ</p>	

					<div class="row">
						<?php echo $form->labelEx($model,'usa_title'); ?>
						<?php echo $form->textField($model,'usa_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $form->error($model,'usa_title'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'usa_detail'); ?>
						<?php echo $form->textArea($model,'usa_detail',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
						<?php echo $form->error($model,'usa_detail'); ?>
					</div>

					<br>
				<div class="row">
					<div class="col-md-12">
					<?php
					if(isset($imageShow)){
						echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
							"class"=>"thumbnail"
						));
					}
					?>
					</div>
				</div>
				<br>
					<div class="row">
					<?php echo $form->labelEx($model, 'usa_address'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span>
							</div>
							<span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span>
							<?php echo $form->fileField($model, 'usa_address', array('id' => 'wizard-picture')); ?>
							<span class="fileupload-exists">Change</span>
							<?php echo $form->fileField($model, 'usa_address'); ?>
						</span>
						<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					</div>
				</div>
				<?php echo $form->error($model, 'usa_address'); ?>
			</div>
			<div class="row">
					<div class="col-md-12">
					<font color="#990000">
						* รูปภาพควรมีขนาด 225x150px(แนวนอน) หรือ ขนาด 255x(xxx)px (แนวยาว)
					</font>
					</div>
				</div>
			<br>
					<div class="row buttons">
						<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
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

	$(document).ready(function(){
		$("#usaMutiLang").hide();
	// console.log($('#Usability_lang_id option:selected').val()); //start value

	$('#Usability_lang_id').on('change', function() {
  		
  		if(this.value == 1){
			 $("#usaMutiLang").hide();
  		}else{
  			$("#usaMutiLang").show();
  		}
		});



	});

</script>


