<?php
$titleName = 'รายชื่อผู้เรียน';
$this->breadcrumbs=array($titleName);

$url_form = $this->createUrl('Coursecontrol/Manageorguser/'.$_GET['id']);
?>
<style>
  .w-100 {
    width:100% !important; 
  }
  .dataTables_filter{
    text-align: right;
  }
</style>
<div class="innerLR">

  <!-- <div class="widget" style="margin-top: -1px;">
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
            <th>section name</th>
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
            <td></td>
            <td></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
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
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div> -->

 <!--  <div class="widget" style="margin-top: -1px;">
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
            <th>section name</th>
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
            <td></td>
            <td></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
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
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="pull-left" style=margin-top:14px;>
      <a class="btn btn-icon btn-success" id="add-section"><i class="glyphicon glyphicon-plus"></i> เพิ่มสมาชิก</a>					
    </div>
					
  </div> -->

  <div class="widget" style="margin-top: -1px;">
   <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
    </div>

     <div class="widget-body">
      
       <table class="table table-bordered dataTable-Orguser table-primary" id="user_list">
         <thead>
          <tr>            
            <th width="5%"></th>
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
        
            $num=1;
            foreach ($user as $key => $value) {
              ?>
              <tr>
                <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td>
                <td style="text-align: center;"><?php echo $num++; ?></td>
                <td><?= $value->profile->firstname." ".$value->profile->lastname ?></td>
                <td><?= $value->employee_id ?></td>
                <td><?= $value->profile->EmpClass->title ?></td>
                <td><?= $value->profile->EmpClass->descrpition ?></td>
                <td><?= $value->orgchart->title ?></td>
                <td>
                  <button type="button" class="btn btn-danger" onclick="if(confirm('แน่ใจว่าต้องการลบ <?= $value->profile->firstname_en." ".$value->profile->lastname_en ?> ?')){Deleteuser(<?= $value->id ?>);}else{ }" >
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
      
      </div>

    </div>

  <div class="widget" style="margin-top: -1px;">
   <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายชื่อผู้เรียนทั้งหมด</h4>
    </div>

     <div class="widget-body">
      <form action="<?= $url_form ?>" method="GET">
       <table class="table table-bordered dataTable-Orguser table-primary" id="user_list">
         <thead>
          <tr>            
            <th width="5%"></th>
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
          if(!empty($userAll)){
            $num=1;
            foreach ($userAll as $key => $value) {
              ?>
              <tr>
                <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td>
                <td style="text-align: center;"><?php echo $num++; ?></td>
                <td><?= $value->profile->firstname." ".$value->profile->lastname ?></td>
                <td><?= $value->employee_id ?></td>
                <td><?= $value->profile->EmpClass->title ?></td>
                <td><?= $value->profile->EmpClass->descrpition ?></td>
                <td><?= $value->orgchart->title ?></td>
              </tr>
              <?php
            }
          }else{
            ?>
            <tr>
              <td colspan="2">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }//end if




           ?>
        </tbody>
      </table>
      <br>
      <button type="submit" class="btn btn-success">+ เพิ่มสมาชิก</button>
      </form>
      </div>

    </div>




  


</div>




<script type="text/javascript">
  
  function Deleteuser(user) {
    if(user != ""){
      $.ajax({
        type: 'POST',
        url: '<?= $url_form ?>',
        data: ({
          user_id:user,
        }),
        success: function(data) {
          if(data == "success"){
            location.reload();
          }         
       }
     });
    }
  }

  $(document).ready(function() {
    $('.dataTable-Orguser').DataTable();
  } );

</script>
