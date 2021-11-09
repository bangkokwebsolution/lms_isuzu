<?php
$titleName = 'อนุมัติหลักทั่วไปโดย (HR)';
$formNameModel = 'ApproveCourse';

$this->breadcrumbs=array($titleName);
  Yii::app()->clientScript->registerScript('searchGeneral', "
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
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
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
            <th>หลักสูตร</th>
            <th>หมวดอบรมออนไลน์ (ภาษา US )</th>
            <th>สถานะการอนุมัติ</th>
            <th>จัดการ</th>
          </tr>
          </thead>
          <tbody>
           <?php 
           foreach ($model as $key => $value) {
            
                   $check_validate = helpers::ApprovalGeneralHr($value->course_id);

                   if($check_validate != 'pass'){ continue; }
                        if($value->approve_status == 1){
                          $status =  "รอการอนุมัติจาก HR";
                        } else {
                          $status =  "ยังไม่อนุมัติ";
                        }
                 ?>
                 <tr>
                  <td><?= $value->cates->cate_title ?></td>
                  <td><?= $value->course_title ?></td>
                  <td><?= $status ?></td>
                  <td><?= CHtml::button("จัดการ",array("class"=>"btn btn-success", "onclick"=>"btn_manage(this)","data-id" => 
                  $value->course_id."_".$value->course_id."_".$value->course_id)); ?></td>
                </tr>
              <?php  } 
              ?>
          </tbody>
        </table>
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
              $('#modal_data .modal-title').html('อนุมัติหลักสูตรทั่วไป');
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
              url: "<?= $this->createUrl('ApproveCourse/saveApprovalGeneralHR'); ?>", 
              type: "POST",
              data: {
                request_id:form_select,
                approval_status:val,
              },
              success: function(data){
                if(data != 1){
                  // alert(data);
                  alert('ท่านไม่มีสิทธื์ อนุมัติหลักสูตรนี้');
                  // location.reload();
                }else{
                  // alert(data);
                  alert('อนุมัติหลักสูตรนี้สำเร็จ');
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
  $('#table_datatable').DataTable({
                   "searching": true,
                });
</script>