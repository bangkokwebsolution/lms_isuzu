<style>
	hr.soften {
		height: 1px;
		background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		border: 0;
	}
</style>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.js"></script>
<!-- <script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce-4.3.4/tinymce.min.js" type="text/javascript"></script>
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

</script> -->
<script>
	$(function () {
		init_tinymce();
	});
</script>
<?php
$this->breadcrumbs=array(
	'จัดการแบบประเมิน'=>array('Index'),
	'เพิ่มแบบประเมิน',
);
?>
<script type="text/javascript">

</script>
<style type="text/css">
.block { display: block; }
label.error { display: none; }
</style>

<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i> เพิ่มแบบประเมิน
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<!-- FORM -->
			<div class="form">
				<?php echo CHtml::beginForm(Yii::app()->request->requestUri,'POST',array(
					'id'=>'questionnaire',
					'name'=>'questionnaire',
					'enableAjaxValidation'=>false,
				));?>
				<div class="row">
					<div>
						<label><h4>หัวข้อแบบประเมิน</h4></label>
						<input id="survey-header" name="surveyHeader" type="text" class="span8" required>
					</div>
				</div>
				<div class="row">
					<div>
						<label><h4>รายละเอียดแบบประเมิน</h4></label>
						<textarea name="surveyHeaderDetail" class="survey-header-detail tinymce" cols="30" rows="10"></textarea>
					</div>
				</div>
				<br>
				<hr class="soften" />
				<br>
				<div class="row">
					<div class="pull-left">
					<?php
					echo CHtml::link('<i class="icon-book"></i> เพิ่มกลุ่ม', '', array(
						'class'=>'btn btn-icon btn-success',
						'id'=>'add-section'
					));?>
					</div>
					<!-- <div class="pull-left" style="margin:4px 15px;">
						<h4>จำนวนข้อที่สร้าง <span id="CountNumAll">0</span> ข้อ</h4>
					</div> -->
				</div>
				<br>
				<div id="section-list">
				</div>
				<div class="row buttons" style="padding-top: 26px;">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>'tinyMCE.triggerSave();'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
			<!-- END form -->
		</div>
	</div>
</div>
<script type="text/javascript">

	$(function(){
		$('#add-section').click(function(){
			var section_id = 0;
			var sectionLast = $('.section:last');
			if(sectionLast.length > 0){
				var lastid = sectionLast.attr('data-section-id');
				section_id = parseInt(lastid)+1;
			}
			
			var section ='<div class="section" data-section-id="'+section_id+'">';
				section +='ชื่อกลุ่ม';
				section +=' <input type="text" class="section-title" name="sectionTitle['+section_id+']" required><br>';
				section +=' <a class="btn btn-icon btn-success add-question-input"><i class="icon-book"></i> เพิ่มคำถามแบบตอบบรรทัดเดียว</a>';
				section +=' <a class="btn btn-icon btn-success add-question-radio"><i class="icon-book"></i> เพิ่มคำถามแบบคำตอบเดียว</a>';
				section +=' <a class="btn btn-icon btn-success add-question-checkbox"><i class="icon-book"></i> เพิ่มคำถามแบบหลายคำตอบ</a>';
				section +=' <br><br>';
				section +=' <a class="btn btn-icon btn-success add-question-score"><i class="icon-book"></i> เพิ่มคำถามแบบให้คะแนน</a>';
				section +=' <a class="btn btn-icon btn-success add-question-text"><i class="icon-book"></i> เพิ่มคำถามบรรยาย</a>';
				section +=' <a class="btn btn-icon btn-danger section-remove"><i class="icon-remove"></i> ลบ</a>';
				section +='<div class="question-list">';
				section +='</div>';
				section +='<br>';
				section +='<hr class="soften" />';
				section +='<br>';
				section +='</div>';
				
			$('#section-list').append(section);
		});

		$('#section-list').on('click','.add-question-input',function(){
			var index = $(this).index('.add-question-input');
			var section_id = $('.section').eq(index).attr('data-section-id');
			var question_id = 0;
			var questionLast = $('.question-list:eq('+index+') > .question:last');
			if(questionLast.length > 0){
				var lastid = questionLast.attr('data-question-id');
				question_id = parseInt(lastid)+1;
			}
				var question = '<div class="question" data-question-id="'+question_id+'">';
					question +='<br>';
					question +='<hr/>';
					question +='<br>';
					question += 'คำถาม (แบบตอบบรรทัดเดียว) <a class="btn btn-icon btn-danger question-remove"><i class="icon-remove"></i> ลบ</a><br>';
					question += '<input type="hidden" value="input" name="questionType['+section_id+']['+question_id+']">';
					question += '<input type="text" class="question-title" id="question-title" name="questionTitle['+section_id+']['+question_id+']" required><br>';
					question += '</div>';

			$('.question-list').eq(index).append(question); 
		});

		$('#section-list').on('click','.add-question-radio',function(){
			var index = $(this).index('.add-question-radio');
			var section_id = $('.section').eq(index).attr('data-section-id');
			var question_id = 0;
			var questionLast = $('.question-list:eq('+index+') > .question:last');
			if(questionLast.length > 0){
				var lastid = questionLast.attr('data-question-id');
				question_id = parseInt(lastid)+1;
			}
				var question = '<div class="question" data-question-id="'+question_id+'">';
					question +='<br>';
					question +='<hr/>';
					question +='<br>';
					question += 'คำถาม (แบบคำตอบเดียว) <a class="btn btn-icon btn-danger question-remove"><i class="icon-remove"></i> ลบ</a><br>';
					question += '<input type="hidden" value="radio" name="questionType['+section_id+']['+question_id+']">';
					question += '<input type="text" class="question-title" id="question-title" name="questionTitle['+section_id+']['+question_id+']" required><br>';
					question += 'ตัวเลือก <a class="btn btn-icon btn-success add-choice"><i class="icon-book"></i> เพิ่มตัวเลือก</a><br>';
					question += '<div class="choice-list" data-section-id="'+section_id+'" data-question-id="'+question_id+'">';
					question += '<div class="choice" data-choice-id="0"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+'][0]" required> อื่น ๆ ระบุ <input type="checkbox" class="choice-specify" name="choiceSpecify['+section_id+']['+question_id+'][0]" value="y"> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';
					question += '<div class="choice" data-choice-id="1"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+'][1]" required> อื่น ๆ ระบุ <input type="checkbox" class="choice-specify" name="choiceSpecify['+section_id+']['+question_id+'][1]" value="y"> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';
					question += '</div>';
					question += '</div>';

			$('.question-list').eq(index).append(question); 
		});

		$('#section-list').on('click','.add-question-checkbox',function(){
			var index = $(this).index('.add-question-checkbox');
			var section_id = $('.section').eq(index).attr('data-section-id');
			var question_id = 0;
			var questionLast = $('.question-list:eq('+index+') > .question:last');
			if(questionLast.length > 0){
				var lastid = questionLast.attr('data-question-id');
				question_id = parseInt(lastid)+1;
			}
				var question = '<div class="question" data-question-id="'+question_id+'">';
					question +='<br>';
					question +='<hr/>';
					question +='<br>';
					question += 'คำถาม (แบบหลายคำตอบ) <a class="btn btn-icon btn-danger question-remove"><i class="icon-remove"></i> ลบ</a><br>';
					question += '<input type="hidden" value="checkbox" name="questionType['+section_id+']['+question_id+']">';
					question += '<input type="text" class="question-title" id="question-title" name="questionTitle['+section_id+']['+question_id+']" required><br>';
					question += 'ตัวเลือก <a class="btn btn-icon btn-success add-choice"><i class="icon-book"></i> เพิ่มตัวเลือก</a><br>';
					question += '<div class="choice-list" data-section-id="'+section_id+'" data-question-id="'+question_id+'">';
					question += '<div class="choice" data-choice-id="0"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+'][0]" required> อื่น ๆ ระบุ <input type="checkbox" class="choice-specify" name="choiceSpecify['+section_id+']['+question_id+'][0]" value="y"> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';
					question += '<div class="choice" data-choice-id="1"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+'][1]" required> อื่น ๆ ระบุ <input type="checkbox" class="choice-specify" name="choiceSpecify['+section_id+']['+question_id+'][1]" value="y"> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';
					question += '</div>';
					question += '</div>';

			$('.question-list').eq(index).append(question); 
		});

		$('#section-list').on('click','.add-question-score',function(){
			var index = $(this).index('.add-question-score');
			var section_id = $('.section').eq(index).attr('data-section-id');
			var question_id = 0;
			var questionLast = $('.question-list:eq('+index+') > .question:last');
			if(questionLast.length > 0){
				var lastid = questionLast.attr('data-question-id');
				question_id = parseInt(lastid)+1;
			}
			var question = '<div class="question" data-question-id="'+question_id+'">';
				question += '<br>';
				question += '<hr/>';
				question += '<br>';
				question += 'กลุ่ม (แบบให้คะแนน) <a class="btn btn-icon btn-danger question-remove"><i class="icon-remove"></i> ลบ</a><br>';
				question += '<input type="hidden" value="contentment" name="questionType['+section_id+']['+question_id+']" required>';
				question += '<input type="text" class="question-title" id="question-title" name="questionTitle['+section_id+']['+question_id+']" required><br>';
				question += 'ระดับคะแนน <label><input type="radio" class="question-range" id="question-range" name="questionRange['+section_id+']['+question_id+']" value="5" checked> 5 คะแนน</label><label><input type="radio" class="question-range" id="question-range" name="questionRange['+section_id+']['+question_id+']" value="10"> 10 คะแนน</label><br>';
				question += 'คำถาม <a class="btn btn-icon btn-success add-choice-score"><i class="icon-book"></i> เพิ่มคำถาม</a><br>';
				question += '<div class="choice-list" data-section-id="'+section_id+'" data-question-id="'+question_id+'">';
				question += '<div class="choice" data-choice-id="0"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+'][0]" required> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';
				question += '<div class="choice" data-choice-id="1"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+'][1]" required> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';
				question += '</div>';
				question += '</div>';

			$('.question-list').eq(index).append(question); 
		});

		$('#section-list').on('click','.add-question-text',function(){
			var index = $(this).index('.add-question-text');
			var section_id = $('.section').eq(index).attr('data-section-id');
			var question_id = 0;
			var questionLast = $('.question-list:eq('+index+') > .question:last');
			if(questionLast.length > 0){
				var lastid = questionLast.attr('data-question-id');
				question_id = parseInt(lastid)+1;
			}
				var question = '<div class="question" data-question-id="'+question_id+'">';
					question +='<br>';
					question +='<hr/>';
					question +='<br>';
					question += 'คำถาม (แบบบรรยาย) <a class="btn btn-icon btn-danger question-remove"><i class="icon-remove"></i> ลบ</a><br>';
					question += '<input type="hidden" value="text" name="questionType['+section_id+']['+question_id+']">';
					question += '<input type="text" class="question-title" id="question-title" name="questionTitle['+section_id+']['+question_id+']" required><br>';
					question += '</div>';

			$('.question-list').eq(index).append(question); 
		});

		$('#section-list').on('click','.add-choice',function(){
			var choiceList = $(this).nextAll('.choice-list');
			var section_id = choiceList.attr('data-section-id');
			var question_id = choiceList.attr('data-question-id');
			var choice_id = 0;
			var choiceLast = choiceList.find('.choice:last');
			if(choiceLast.length > 0){
				var lastid = choiceLast.attr('data-choice-id');
				choice_id = parseInt(lastid)+1;
			}
			
			var choice = '<div class="choice" data-choice-id="'+choice_id+'"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+']['+choice_id+']" required> อื่น ๆ ระบุ <input type="checkbox" class="choice-specify" name="choiceSpecify['+section_id+']['+question_id+']['+choice_id+']" value="y"> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';

			choiceList.append(choice);
		});

		$('#section-list').on('click','.add-choice-score',function(){
			var choiceList = $(this).nextAll('.choice-list');
			var section_id = choiceList.attr('data-section-id');
			var question_id = choiceList.attr('data-question-id');
			var choice_id = 0;
			var choiceLast = choiceList.find('.choice:last');
			if(choiceLast.length > 0){
				var lastid = choiceLast.attr('data-choice-id');
				choice_id = parseInt(lastid)+1;
			}
			
			var choice = '<div class="choice" data-choice-id="'+choice_id+'"><input type="text" class="choice-title" name="choiceTitle['+section_id+']['+question_id+']['+choice_id+']" required> <a class="btn btn-icon btn-danger choice-remove"><i class="icon-remove"></i> ลบ</a></div>';

			choiceList.append(choice);
		});

		$('#section-list').on('click','.choice-remove',function(){
			if(confirm('คุณต้องการลบข้อมูล?')) {
				$(this).parent('.choice').remove();
			}
		});

		$('#section-list').on('click','.question-remove',function(){
			if(confirm('คุณต้องการลบข้อมูล?')) {
				$(this).parent('.question').remove();
			}
		});

		$('#section-list').on('click','.section-remove',function(){
			if(confirm('คุณต้องการลบข้อมูล?')) {
				$(this).parent('.section').remove();
			}
		});

	});
</script>
<!-- END innerLR -->
