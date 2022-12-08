<?php
$titleName = 'แบบประเมิน';
$formNameModel = 'Questionnaire';
$this->breadcrumbs = array(
	'ระบบแบบประเมิน'
);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

Yii::app()->clientScript->registerScript(
	'updateGridView',
	<<<EOD
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
EOD,
	CClientScript::POS_READY
);

$user = User::model()->findByPk(Yii::app()->user->id);
$perarray = json_decode($user->group);
?>
<style type="text/css">
	div.dataTables_filter label {
		float: right;
	}
</style>
<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName; ?></h4>
		</div>
		<div class="widget-body">
			<table id="table_datatable" class="table table-bordered table-striped">
				<thead style="background-color: #e50000; font-weight: bold;color:aliceblue">
					<tr>
						<th>ชื่อแบบประเมิน</th>
						<th>จัดการ</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($header as $key => $val) {

						//System Admin เห็นทุกๆ แบบประเมิน
						if (!in_array("1", $perarray) || !in_array("7", $perarray) || $val->create_by == Yii::app()->user->id) {

							//Instructor เห็นเฉพาะแบบประเมินที่ตนเองสร้างเท่านั้น
							if (in_array("18", $perarray) && $val->create_by != Yii::app()->user->id) {
								continue;
							}

							//Instructor Manager เห็นเฉพาะแบบประเมินที่ instructor ในส่วนงานตนเองสร้างเท่านั้น
							if (in_array("17", $perarray)) {
								$userGroup = User::model()->findByPk($val->create_by);
								if (!empty($userGroup)) {
									$jsongroup = json_decode($userGroup->group);
									if (!in_array("17", $jsongroup)) {
										continue;
									}
								} else {
									continue;
								}
							}

							//HR Manager ไม่เห็นแบบประเมินของส่วนงานใด ๆ เลย
							if (in_array("15", $perarray)) {
								continue;
							}
						}
					?>
						<tr>
							<td><?= CHtml::decode(UHtml::markSearch($val, "survey_name")) ?></td>
							<td style="width: 90px;" class="center">
								<a class="btn-action glyphicons pencil btn-success" title="แก้ไข" href="<?= $this->createUrl("Questionnaire/update") . '/' . $val->survey_header_id ?>"><i></i></a>
								<a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="<?= $this->createUrl("Questionnaire/delete") . '/' . $val->survey_header_id ?>"><i></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>

	<?php if (Controller::DeleteAll(array("Questionnaire.*", "Questionnaire.Delete", "Questionnaire.MultiDelete"))) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php
				echo CHtml::link(
					"<i></i> ลบข้อมูลทั้งหมด",
					"#",
					array(
						"class" => "btn btn-primary btn-icon glyphicons circle_minus",
						"onclick" => "return multipleDeleteNews('" . $this->createUrl('//' . $formNameModel . '/MultiDelete') . "','$formNameModel-grid');"
					)
				);
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
<script>
	$(document).ready(function() {
		$('#table_datatable').DataTable({
			"searching": true,
		});
	});
</script>