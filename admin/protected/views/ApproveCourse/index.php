
<?php
$titleName = 'อนุมัติหลักสูตรเฉพาะ';
$formNameModel = 'ApproveCourse';

$this->breadcrumbs=array($titleName);
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
  $.appendFilter("ApproveCourse[news_per_page]", "news_per_page");
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
          'dataProvider'=>$model->search(),
          'filter'=>$model,
          'rowCssClassExpression'=>'"items[]_{$data->course_id}"',
          'selectableRows' => 2,
          'htmlOptions' => array(
            'style'=> "margin-top: -1px;",
          ),
          'afterAjaxUpdate'=>'function(id, data){
            $.appendFilter("ApproveCourse[news_per_page]");
            InitialSortTable();
          }',
          'columns'=>array(

            array(
              'name'=>'course_id',
              // 'filter'=>false,
              'header'=>'หลักสูตร',
              'type'=>'raw',              
              'htmlOptions'=>array('width'=>'20%'),
              'value'=>function($data){
                if(is_numeric($data->course_id)){
                  echo $data->course_title;
                }else{
                  echo $data->course_title;
                }
              }
            ),

            array(
              'name'=>'cate_id',
              'value'=>'$data->cates->cate_title',
              'filter'=>CHtml::activeTextField($model,'cates_search'),
                      'htmlOptions' => array(
                         'style' => 'width:350px',
                      ),  
            ),
            // 'course_title',


            array(
              'type'=>'raw',
              'value'=>function($data){
                if($data->status == 1){
                  return "อนุมัติแล้ว";
                } else {
                  return "ยังไม่อนุมัติ";
                }
              },
              'header' => 'สถานะการอนุมัติ',
              'htmlOptions'=>array('style'=>'text-align: center;'),
              'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
            ),

            
            array(
              'header' => 'จัดการ',
              'type'=>'html',
              'value'=>function($data){
                echo CHtml::button("จัดการ",array("class"=>"btn btn-success", "onclick"=>"btn_manage(this)","data-id" => $data->course_id."_".$data->course_id."_".$data->course_id));
              },
              'htmlOptions'=>array('style'=>'text-align:center; width:100px;', ),
             
            ),


            
          ),
        )); ?>
      </div>
    </div>
  </div>


</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_data">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #3C8DBC; height: 41px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;font-size: 22px;">&times;</span></button>
        <h4 class="modal-title" style="font-size: 20px;color: #fff;padding: .3em;">ข้อความ</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer" style="background-color: #eee;">        
        <button type="button" class="btn btn-primary" onclick="approval(1);">อนุมัติ</button>
        <!-- <button type="button" class="btn btn-danger" onclick="approval(2);">ไม่อนุมัติ</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_data_comment">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #3C8DBC; height: 41px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;font-size: 22px;">&times;</span></button>
        <h4 class="modal-title" style="font-size: 20px;color: #fff;padding: .3em;">ข้อความ</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <p>หมายเหตุที่ไม่อนุมัติฟอร์มฝึกอบรมนี้</p>
            <textarea id="comment" class="form-control"></textarea>
          </div>
        </div>
        <input type="hidden" id="inp_request_id">
        <input type="hidden" id="inp_approval_status">
      </div>
      <div class="modal-footer" style="background-color: #eee;">        
        <button type="button" class="btn btn-primary" onclick="approval_reject();">ไม่อนุมัติ</button>
        <!-- <button type="button" class="btn btn-danger" onclick="approval(2);">ไม่อนุมัติ</button> -->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var form_select = 0;
  // $(".btn_manage").on('click', function(event){
    function btn_manage(val){
      console.log("9");
      var tag = val;
    var dataid = $(tag).attr("data-id");
    var course = dataid.split("_")[0];
    var user = dataid.split("_")[1];
    var request_id = dataid.split("_")[2];
    form_select = request_id;

    if( user != ""){

      $.ajax({
        url: "<?= $this->createUrl('ApproveCourse/getDatamodal'); ?>", 
        type: "POST",
        data: {
          course_id:course,
          user_id:user,
          request_id:request_id,
        },
        success: function(data){
          if(data != "error"){
            $('#modal_data .modal-title').html('อนุมัติหลักสูตรเฉพาะ');
            $('#modal_data .modal-body').html(data);
            $('#modal_data').modal('show');
          }
        }
      });
    }
  }
  // });

  function approval(val){
    if(val == 1){
      var text_title = "อนุมัติหลักสูตรนี้"
    }else if(val == 2){
      var text_title = "ไม่อนุมัติฟอร์มฝึกอบรมนี้"
    }
    swal({
      title: "คุณต้องการ"+text_title,
      type: "info",
      cancelButtonText: "ไม่",
      showCancelButton: true,
      closeOnCancel: true,

      confirmButtonText: "ใช่",   
      confirmButtonClass: "btn-danger",       
      closeOnConfirm: true,
      
    },
    function(isConfirm) {
      if (isConfirm) {
        $('#modal_data').modal('hide');
        if(val == 1){
          if(form_select != 0){
            $.ajax({
              url: "<?= $this->createUrl('ApproveCourse/saveApproval'); ?>", 
              type: "POST",
              data: {
                request_id:form_select,
                approval_status:val,
              },
              success: function(data){
                if(data != "error"){
                  location.reload();
                }
              }
            });
          }
        }else{
          $("#inp_request_id").val(form_select);
          $("#inp_approval_status").val(val);
          $('#modal_data_comment .modal-title').html('ฟอร์มฝึกอบรม');
          // $('#modal_data_comment .modal-body').html(data);
          $('#modal_data_comment').modal('show');
        }





      }
    }
    );
  }

  function approval_reject(){ // ส่งฟอร์ม ไม่อนุมัติ
    var request_id = $("#inp_request_id").val();
    var approval_status = $("#inp_approval_status").val();
    var comment = $("#comment").val();

    $("#inp_request_id").val("");
    $("#inp_approval_status").val("");

    $.ajax({
      url: "<?= $this->createUrl('TrainingForm/saveApproval'); ?>", 
      type: "POST",
      data: {
        request_id:request_id,
        approval_status:approval_status,
        comment:comment,
      },
      success: function(data){
        if(data != "error"){
          location.reload();
        }
      }
    });
  }
</script>