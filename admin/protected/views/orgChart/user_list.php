<?php
$titleName = 'รายชื่อผู้เรียน';
$this->breadcrumbs = array($titleName);

$url_form = $this->createUrl('OrgChart/CheckUser/' . $_GET['id'].'?orgchart_id='.$_GET['orgchart_id']);

$url_delAll = $this->createUrl('OrgChart/delAll/' . $_GET['id'].'?orgchart_id='.$_GET['orgchart_id']);
?>
<style>
  .w-100 {
    width: 100% !important;
  }

  .dataTables_filter {
    text-align: right;
  }

  .head-sec2 {
    display: flex;
    justify-content: space-between;
    margin: 8px 0px 14px 0px;
  }

  .head-sec2 .wrap {
    display: flex;
    flex-direction: row-reverse;
    column-gap: 12px;
  }

  .head-sec2 .span6 {
    display: none !important;
  }
</style>
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php
                $form = $this->beginWidget('AActiveForm', array(
                    'id' => 'Orgchart-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
               
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="OrgChart_parent_id" class="required">Division <span class="required">*</span></label>
                            <?php $div_model = OrgChart::model()->getDivisionListNew();
                            // echo $form->dropDownList($model, 'division_id', $div_model, array('empty' => 'เลือก Division', 'class' => 'form-control', 'style' => 'width:100%','required'=>'required')); 
                            echo $form->dropDownList($model, 'division_id', $div_model, array('empty' => 'เลือก Division', 'class' => 'form-control', 'style' => 'width:100%')); 
                            ?>
                            <?php echo $form->error($model, 'division_id'); ?>
                        </div>
                    </div>

                    
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="OrgChart_parent_id" class="required">Department <span class="required">*</span></label>
                            <?php $dep_model = OrgChart::model()->getDepartmentListNew();
                            // echo $form->dropDownList($model, 'department_id', $dep_model, array('empty' => 'เลือก Department', 'class' => 'form-control','required'=>'required')); 
                            echo $form->dropDownList($model, 'department_id', $dep_model, array('empty' => 'เลือก Department', 'class' => 'form-control')); 
                            
                            ?>
                            <?php echo $form->error($model, 'department_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="OrgChart_parent_id" class="required">Group <span class="required">*</span></label>
                            <?php $dep_model = OrgChart::model()->getGroupListNew();
                            // echo $form->dropDownList($model, 'group_id', $dep_model, array('empty' => 'เลือก Group', 'class' => 'form-control','required'=>'required')); 
                            echo $form->dropDownList($model, 'group_id', $dep_model, array('empty' => 'เลือก Group', 'class' => 'form-control')); 
                            ?>
                            <?php echo $form->error($model, 'group_id'); ?>
                        </div>
                    </div>
                </div>


                <div class="row">
                	<div class="col-md-8">
                    <label for="OrgChart_title" class="required">Section <span class="required">*</span></label>
                            <?php $dep_model = OrgChart::model()->getSectionListNew();
                            // echo $form->dropDownList($model, 'section_id', $dep_model, array('empty' => 'เลือก Section', 'class' => 'form-control','required'=>'required')); 
                            echo $form->dropDownList($model, 'section_id', $dep_model, array('empty' => 'เลือก Section', 'class' => 'form-control')); 
                            ?>
                            <?php echo $form->error($model, 'section_id'); ?>
                    </div>
                </div>
                                           
                
                <br>

                <div class="row buttons">
                    <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons search'),'<i></i>ค้นหาข้อมูล');?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<div class="innerLR">

  

  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName; ?></h4>
    </div>

    <div class="widget-body">

      <table class="table table-bordered dataTable-Orguser table-primary" id="user_list">
        <thead>
          <tr>
            <!-- <th width="5%"></th> -->
            <th width="5%">ลำดับ</th>
            <th>ชื่อ - นามสกุล</th>
            <th>รหัสพนักงาน</th>
            <th>ลำดับชั้นงาน</th>
            <th>ตำแหน่งงาน</th>
            <th>Section Name</th>
            <th width="5%">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $num = 1;
          foreach ($user as $key => $value) {
          ?>
            <tr>
              <!-- <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td> -->
              <td style="text-align: center;"><?php echo $num++; ?></td>
              <td><?= $value->profile->firstname . " " . $value->profile->lastname ?></td>
              <td><?= $value->employee_id ?></td>
              <td><?= $value->profile->EmpClass->title ?></td>
              <td><?= $value->profile->EmpClass->descrpition ?></td>
              <td><?= $value->orgchart->title ?></td>
              <td>
                <button type="button" class="btn btn-danger" onclick="if(confirm('แน่ใจว่าต้องการลบ <?= $value->profile->firstname_en . " " . $value->profile->lastname_en ?> ?')){Deleteuser(<?= $value->id ?>);}else{ }">
                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
              </td>
            </tr>
          <?php
          }

          ?>


        </tbody>
      </table>
      <br>
      <a href="<?= $url_delAll ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการล้างข้อมูลทั้งหมดหรือไม่ ?')">- ล้างทั้งหมด</a>
    </div>

  </div>

  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายชื่อผู้เรียนทั้งหมด</h4>
    </div>

    <div class="widget-body">
      <form action="<?= $url_form ?>" method="GET">
      <input type="hidden" name="division_id" value="<?php echo $_POST['OrgChart']["division_id"]?>" />
      <input type="hidden" name="department_id" value="<?php echo $_POST['OrgChart']["department_id"]?>" />
      <input type="hidden" name="group_id" value="<?php echo $_POST['OrgChart']["group_id"]?>" />
      <input type="hidden" name="section_id" value="<?php echo $_POST['OrgChart']["section_id"]?>" />

        <table class="table table-bordered dataTable-Orguser table-primary" id="user_list">
        <input type="hidden" name="orgchart_id" value="<?php echo $_GET["orgchart_id"]?>" />
          <thead>
            <tr>
              <th width="5%" align="center"><input type="checkbox" id="chkAll" /></th>
              <th width="5%">ลำดับ</th>
              <th>ชื่อ - นามสกุล</th>
              <th>รหัสพนักงาน</th>
              <th>ลำดับชั้นงาน</th>
              <th>ตำแหน่งงาน</th>
              <th>Section Name</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $num = 1;
            foreach ($userAll as $key => $value) {
            ?>
              <tr>
                <td align="center"><input type="checkbox" class="chk" name="user_list[]" value="<?= $value->id ?>"></td>
                <td style="text-align: center;"><?php echo $num++; ?></td>
                <td><?= $value->profile->firstname . " " . $value->profile->lastname ?></td>
                <td><?= $value->employee_id ?></td>
                <td><?= $value->profile->EmpClass->title ?></td>
                <td><?= $value->profile->EmpClass->descrpition ?></td>
                <td><?= $value->orgchart->title ?></td>
              </tr>
            <?php
            }



            ?>
          </tbody>
        </table>
        <br>
        <button type="submit" class="btn btn-success">+ เพิ่มผู้เรียน</button>
      </form>
    </div>

  </div>







</div>




<script type="text/javascript">
  function Deleteuser(user) {
    if (user != "") {
      $.ajax({
        type: 'POST',
        data: { division_id: <?php echo $_POST['OrgChart']["division_id"]?> , department_id: <?php echo $_POST['OrgChart']["department_id"]?> ,group_id:<?php echo $_POST['OrgChart']["group_id"]?>,section_id:<?php echo $_POST['OrgChart']["section_id"]?>}
        url: '<?= $url_form ?>',
        data: ({
          user_id: user,
        }),
        success: function(data) {
          if (data == "success") {
            location.reload();
          }
        }
      });
    }
  }

  $(document).ready(function() {
    $('.dataTable-Orguser').DataTable({
      aoColumnDefs: [{
        bSortable: false,
        aTargets: [0]
      }]
    }); //datatable


    $("#chkAll").click(function() {
      $(".chk").prop("checked", $("#chkAll").prop("checked"))

    }); //chkall


  });


  $("#OrgChart_division_id").change(function() {
        var id = $("#OrgChart_division_id").val();
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('Orgmanage/ListDepartment'); ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#OrgChart_department_id').empty();
                $('#OrgChart_department_id').append(data);
            }
        });
    });

    $("#OrgChart_department_id").change(function() {
        var id = $("#OrgChart_department_id").val();
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('Orgmanage/ListGroup'); ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#OrgChart_group_id').empty();
                $('#OrgChart_group_id').append(data);
            }
        });
    });

    $("#OrgChart_group_id").change(function() {
        var id = $("#OrgChart_group_id").val();
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('Orgmanage/ListSection'); ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#OrgChart_section_id').empty();
                $('#OrgChart_section_id').append(data);
            }
        });
    });
</script>