<?php
$titleName = 'รายชื่อผู้เรียน';
$formNameModel = 'List of learners';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#popup-grid').yiiGridView('update', {
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
	$.appendFilter("PopUp[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<!-- <?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'name','type'=>'text'),
		//array('name'=>'update_date','type'=>'date'),
		// array('name'=>'detail','type'=>'textArea'),
	),
	));?> -->

<style>
  .w-100 {
    width:100% !important; 
  }
</style>
<div class="innerLR">

  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
    </div>
    <div class="widget-body">
      <div class="clear-div"></div>
      <div class="overflow-table">
        <table class="table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable ui-sortable" id="table_datatable">
          <thead>
          <tr>
		  <th>ลำดับ</th>
            <th>ชือ-นามสกุล</th>
            <th>รหัสพนักงาน</th>
            <th>ลำดับชั้นงาน</th>
            <th>ตำแหน่งงาน</th>
            <th>จัดการ</th>
          </tr>
          </thead>
          <tbody>
           <tr>
            <td><input class="select-on-check-all" type="checkbox" value="1" name="chk_all" id="chk_all"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายชื่อผู้เรียนทั้งหมด</h4>
    </div>
    <div class="widget-body">
      <div class="clear-div"></div>
      <div class="overflow-table">
        <table class="table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable ui-sortable" id="table_datatable">
          <thead>
          <tr>
		  <th>ลำดับ</th>
            <th>ชือ-นามสกุล</th>
            <th>รหัสพนักงาน</th>
            <th>ลำดับชั้นงาน</th>
            <th>ตำแหน่งงาน</th>
            <th>จัดการ</th>
          </tr>
          </thead>
          <tbody>
           <tr>
            <td><input class="select-on-check-all" type="checkbox" value="1" name="chk_all" id="chk_all"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>
