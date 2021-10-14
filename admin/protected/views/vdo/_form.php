<script src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">
function typeVdo(val){
    console.log(val);
    if(val == 'link') {
        $('.vdo-file').hide();
        $('.vdo-link').show();
        $('#model_department_id').attr('required', true);
    } else {
        $('.vdo-file').show();
        $('.vdo-link').hide();
        $('#model_department_id').attr('required', false);
        $('#model_department_id').val('');
    }
}
	<?php
	if(!$model->isNewRecord){
	?>
	$(document).ready(function(){
		typeVdo('<?= $model->vdo_type ?>');
	});
	<?php
	}
	?>
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
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
			<?php $form = $this->beginWidget('AActiveForm', array(
				'id'=>'vdo-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true
		        ),
		        'errorMessageCssClass' => 'label label-important',
		        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        //         'pluginOptions'=>array(
        // 'allowedFileExtensions'=>array('mp4', 'avi', 'mpge'),
        // 'maxFileSize' => 1024 * 1024 * 2,)
			)); 
     
            ?>
				<div class="row">
					<?php echo $form->labelEx($model,'vdo_title'); ?>
					<?php echo $form->textField($model,'vdo_title',array('size'=>60,'maxlength'=>255,'class'=>'span7')); ?>
					<?php echo $form->error($model,'vdo_title'); ?>
				</div>
                <div class="row">
                    <?php echo $form->labelEx($model,'vdo_credit'); ?>
                    <?php echo $form->textField($model,'vdo_credit',array('size'=>60,'maxlength'=>255,'class'=>'span7')); ?>
                    <?php echo $form->error($model,'vdo_credit'); ?>
                </div>
				<div class="row">
                    <label><?php echo $form->labelEx($model, 'vdo_type'); ?></label>
                    <?php
                    $department_id = array('file' => 'ไฟล์','link' => 'ลิงค์');
                    echo $form->dropDownList($model, 'vdo_type', $department_id, array('class' => 'span4',
                        'onchange'=>'typeVdo(this.value)'));
                    ?>
                    <?php echo $form->error($model, 'vdo_type'); ?>
                </div>
                <!-- thumbnail -->
                <!-- <?php echo $form->labelEx($model, 'vdo_thumbnail'); ?> -->
              <!--   รูปภาพหน้าปกวีดีโอ -->
       <!--          <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span>
                            </div>
                                <span class="btn btn-default btn-file"><span class="fileupload-new">    Select file</span>
                                        <?php echo $form->fileField($model, 'vdo_thumbnail', array('id' => 'wizard-picture')); ?>
                                <span class="fileupload-exists">Change</span>
                                        <?php echo $form->fileField($model, 'vdo_thumbnail'); ?>
                                </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'vdo_thumbnail'); ?> -->
               
               <!--  <div class="row">
				     <font color="#990000">
				      <?php echo $this->NotEmpty();?> ไฟล์รูปภาพนามสกุลต่างๆ
				     </font>
				<br>
				<br>
			    </div> -->
               
				<!-- upload vdo -->
                <div class="vdo-file">
                    <?php echo $form->labelEx($model, 'vdo_path'); ?>
                   <!--  <div class="fileupload fileupload-new " data-provides="fileupload">
                        <div class="input-append">
                            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span>
                                </div>
                                    <span class="btn btn-default btn-file"><span class="fileupload-new">    Select file</span>
                                            <?php echo $form->fileField($model, 'vdo_path', array('id' => 'wizard-picture')); ?>
                                    <span class="fileupload-exists">Change</span>
                                            <?php echo $form->fileField($model, 'vdo_path',array('class' => 'name_file')); ?>
                                    </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>-->
                    
                     <?php echo $form->fileField($model, 'vdo_path', array('id' => 'wizard-picture')); ?>
                      <?php echo $form->error($model, 'vdo_path'); ?> 
                </div>
                <?php
        
                if(!$model->isNewRecord){
                    if (!empty($model)) {
                        if ($model->vdo_type =='link') {
                            $vdoName = $model->link_vdo;
                            $new_link = str_replace("watch?v=", "embed/", $vdoName);
                            $show = '<iframe class="embed-responsive-item" width="40%" height="300"  src="' . $new_link . '" allowfullscreen style="box-shadow:1px 4px 6px #767676"></iframe>';
                             echo $show;
                             $href = 'href="' . $vdo->vdo_path . '" target="_blank"';
                         
                        }else{
           
                      $criteria= new CDbCriteria;
                      $criteria->compare('vdo_id',$model->vdo_id);
                      $criteria->compare('active','y');
                      $criteria->compare('lang_id',$model->lang_id);
                      $Vdos = Vdo::model()->findAll($criteria);
                       foreach ($Vdos as $vdo) { 
                            ?>
                            <video class="video-js" poster="<?php echo Yii::app()->baseUrl . "/../uploads/$vdo->vdo_thumbnail"; ?>" controls preload="auto" style="width: 40%; height: 300px;">
                                

                                <!-- video show-->
                                <?php
                                if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/' . $vdo->vdo_path)) {
                                    $file_name = Yii::app()->baseUrl . '/../uploads/' . $vdo->vdo_path;
                             
                                } 
                                $show = "<source src=" . $file_name . " type='video/mp4' >";
                                echo $show;
                                ?>
                               
                                <!-- video show-->
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                                    <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                </p>
                            </video>
                       <?php }
                   }
                       
                    }

                }
                ?>
                <div class="row vdo-file">
				     <font color="#990000">
				      <?php echo $this->NotEmpty();?> ไฟล์ขนาดไม่เกิน 1 GB
				     </font>
				<br>
				<br>
			    </div>

                <div class="row vdo-link" style="display: none;">
                    <?php echo $form->labelEx($model,'link_vdo'); ?>
					<?php echo $form->textField($model,'link_vdo',array('size'=>60,'maxlength'=>255,'class'=>'span7')); ?>
					<?php echo $form->error($model,'link_vdo'); ?>

                </div>
                <div class="row vdo-link"  style="display: none;">
				     <font color="#990000">
				      <?php echo $this->NotEmpty();?> ตัวอย่าง: https://www.youtube.com/watch?v=2MpUj-Aua48
				     </font>
				<br>
				<br>
			    </div>
          
                <!-- upload vdo -->
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
</script>
<script type="text/javascript">
    document.getElementById('wizard-picture').addEventListener('change', checkFile, false);

function checkFile(e) {
    var file_list = e.target.files;
    for (var i = 0, file; file = file_list[i]; i++) {
        var fileExtension = file.name.split('.')[file.name.split('.').length - 1].toLowerCase();
        var iConvert = (file.size / 1024).toFixed(2);
           
        //txt = "File type : " +fileExtension + "\n";
        // if(file.size > (1024 * 1024 * 100)){
        if(file.size > (1024 * 1024 * 1024)){
       
            swal("ไฟล์มีขนาดใหญ่เกิน กรุณาเลือกไฟล์ขนาดไม่เกิน 1 GB");
            document.getElementById('wizard-picture').value = []
           // txt += "Size: " + (file.size / (1024*1024)).toFixed(2) + " MB \n";
        } 
        // else {
        //     return false;
       // txt += "Size: " + (file.size / 1024).toFixed(2) + " KB \n";
        //}
        // alert(txt);
    }
}
</script>
