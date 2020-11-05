<?php
$titleName = 'รายงานภาพรวมแบบสอบถาม';
$formNameModel = 'Questionnaire';
$this->breadcrumbs = array(
	'รายงานภาพรวมแบบสอบถาม'
);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Questionnaire[news_per_page]", "news_per_page");

	$(document).on('click','.btn-sendmail',function() {
		var href_url = $(this).attr('href');
		$('#url').val(href_url);
		$('#myModal').modal();
		return false;
	});

	$(document).on('click','#sendmail',function() {
		var url = $('#url').val();

		// if($('#university').val() != ''){
		// 	url += '?university_id='+$('#university').val();
		// }
		// console.log(url);

		$.ajax({
		  method: "GET",
		  url: url,
		  data: { university_id: $('#university').val() }
		})
		.done(function( msg ) {
		    $('#myModal').modal('hide');
		});

		return false;
	});

EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$header->searchout(),
					'filter'=>$header,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Questionnaire[news_per_page]");	
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'name'=>'survey_name',
							'type'=>'html',
							'value'=>'CHtml::decode(UHtml::markSearch($data,"survey_name"))'
						),
						array(
							'header'=>'link ทำแบบสอบถาม',
							'value'=>function($data){
								$url = Yii::app()->createAbsoluteUrl('questionnaire/out');
								$url = str_replace("admin/", "", $url);
								$url = $url."?id=".$data->survey_header_id;
								return CHtml::textField("liketxt",$url,array("id"=>"liketxt"))." ".CHtml::button("Copy link", array(
									"class"=>"btn btn-primary btn-icon",
									"data-clipboard-text"=>$url
							    )); 
							},
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'300px'),
						),
						array(
							'header'=>'รายงาน',
					    	'value'=>'CHtml::link("รายงาน", array(
					      		"Report/reportquestionnair",
                                  "id"=>$data->survey_header_id,
                                  "all"=>1,
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					    	'type'=>'raw',
					    	'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
					    ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Questionnaire.*", "Questionnaire.View", "Questionnaire.Update", "Questionnaire.Delete") 
							),
							'template'=>'{update} {delete}',
							'buttons' => array(
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Questionnaire.*", "Questionnaire.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>

<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>ส่งเมล</h3>
  </div>
  <div class="modal-body">
    <p>
    	<input type="hidden" value="" name="url" id="url">
    	<label class="span1">มหาวิทยาลัย</label>
	    <select name="university" class="span5" id="university">
	    	<option value=""> -- ทั้งหมด -- </option>
	    	<?php
	    	$university = TbUniversity::getUniversityOptions();
	    	foreach ($university as $key => $value) {
	    	?>
			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
	    	<?php
	    	}
	    	?>
	    </select>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn btn-default">ยกเลิก</a>
    <a href="#" id="sendmail" class="btn btn-primary">ส่ง</a>
  </div>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/clipboard.min.js"></script>
<script>
var clipboard = new Clipboard('.btn');

clipboard.on('success', function(e) {
    console.log(e);
});

clipboard.on('error', function(e) {
    console.log(e);
});
</script>