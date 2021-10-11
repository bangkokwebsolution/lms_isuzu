
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
					'id'=>'imgslide-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
					<?php echo $form->labelEx($model,'imgslide_title'); ?>
					<?php echo $form->textField($model,'imgslide_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'imgslide_title'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'imgslide_detail'); ?>
					<?php echo $form->textarea($model,'imgslide_detail',array('rows' => '3', 'class'=>'span8')); ?>
					<?php echo $form->error($model,'imgslide_detail'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'imgslide_link'); ?>
					<input type="checkbox" id="swiftLink" <?php if($model->imgslide_link != ""){ echo "checked='checked'"; $status_type = 1;}else{ echo "checked=''";$status_type = 0;} ?> data-toggle="toggle" data-onstyle="success" data-offstyle="danger">

				</div>
				<br>
				<div class="row" id="link" style="display: none;">
				    <!-- 	<font color="#990000">
							<?php echo $this->NotEmpty();?> ตัวอย่าง http://www.cpdland.com/
						</font> -->
						<?php //echo $form->labelEx($model,'imgslide_link'); ?>
						<?php echo $form->textField($model,'imgslide_link',array('size'=>60, 'class'=>'span8')); ?>
						<?php echo $form->error($model,'imgslide_link'); ?>
						
					</div>
					<!--  -->
					<div class="row">
						<?php
						if(isset($imageShow)){
							echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
								"class"=>"thumbnail"
							));
						}
						?>
					</div>
					<br>

					<div class="row">
						<?php echo $form->labelEx($model,'imgslide_picture'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-append">
								<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'imgslide_picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div>
						<?php echo $form->error($model,'imgslide_picture'); ?>
					</div>

					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 1985X671 Pixel
						</font>
					</div>
					<?php if ($notsave == 1) { ?>
						<p class="note"><font color="red">*ขนาดของรูปภาพไม่ถูกต้อง </font></p>
					<?php }else{} ?> 
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
		$( document ).ready(function() {
			if(<?php echo $status_type ?> == 1){
				checkswitch(true);
			}			
		});

		$('#swiftLink').change(function(){
			var chk = $(this).is(":checked");
			checkswitch(chk);
		});

		function checkswitch(chk){
			if (chk == true) {
				$('#link').show();

				$('#typeId').hide();
				$('#Imgslide_gallery_type_id').val("");
			}else{
				$('#link').hide();
				$('#Imgslide_imgslide_link').val("");

				$('#typeId').show();
			}
		}
	</script>

