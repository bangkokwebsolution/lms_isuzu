
<script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce-4.3.4/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    tinymce.init({
        selector: ".tinymce",theme: "modern",width: 680,height: 300,
        plugins: [
             "advlist autolink link image lists charmap print preview hr anchor pagebreak",
             "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
             "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
       ],
       toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
       toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
       image_advtab: true ,
       
       external_filemanager_path:"/filemanager/",
       filemanager_title:"Responsive Filemanager" ,
       external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
     });
});
</script>
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
				<?php $form=$this->beginWidget('AActiveForm', array(
					'id'=>'course-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

				<div class="row">
					<?php echo $form->labelEx($model,'name'); ?>
					<?php echo $form->textField($model,'name',array('span8'));?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'name'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'welcomeMsg'); ?>
					<?php echo $form->textArea($model,'welcomeMsg',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
					<?php echo $form->error($model,'welcomeMsg'); ?>
				</div>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->
