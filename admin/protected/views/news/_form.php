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
					'id'=>'news-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
					<div class="row">
						<?php echo $form->labelEx($model,'cms_title'); ?>
						<?php echo $form->textField($model,'cms_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'cms_title'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'cms_short_title'); ?>
						<?php echo $form->textArea($model,'cms_short_title',array('rows'=>4, 'cols'=>40,'class'=>'span8','maxlength'=>255)); ?>
						<?php echo $this->NotEmpty();?>
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
						<?php echo $form->labelEx($model,'picture'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						  	</div>
						</div>
						<?php echo $form->error($model,'picture'); ?>
					</div>

					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 250x180(แนวนอน) หรือ ขนาด 250x(xxx) (แนวยาว)
						</font>
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