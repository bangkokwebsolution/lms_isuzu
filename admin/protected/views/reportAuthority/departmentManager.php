<?php
$titleName = 'จัดการ ผู้จัดการแผนก';
$this->breadcrumbs=array($titleName);
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

       <h3>รายชื่อ ผู้จัดการแผนก</h3>
       <table class="table table-bordered" id="user_department">
         <thead>
          <tr>
            <th width="5%" style="text-align: center;">ลำดับ</th>
            <th>ชื่อ - นามสกุล</th>
            <th width="12%">ประเภทพนักงาน</th>
            <th>ฝ่าย</th>
            <th>แผนก</th>
            <th width="5%">เลเวล</th>
            <th width="5%">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($user_department)){
            $no = 1;
            foreach ($user_department as $key => $value) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $no; $no++; ?></td>
                <td><?= $value->profile->firstname." ".$value->profile->lastname ?></td>
                <td>
                  <?php 
                  if($value->profile->type_employee == 1){
                    echo "คนเรือ";
                  }elseif($value->profile->type_employee == 2){
                    echo "คนออฟฟิศ";
                  }
                   ?>
                </td>
                <td><?= $value->department->dep_title ?></td>
                <td><?= $value->position->position_title ?></td>
                <td><?= $value->branch->branch_name ?></td>
                <td>
                  <button type="button" class="btn btn-danger" onclick="if(confirm('แน่ใจว่าต้องการลบ <?= $value->profile->firstname." ".$value->profile->lastname ?> ?')){Deleteuser(<?= $value->id ?>);}else{ }" >
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                  </button>
                </td>
              </tr>
              <?php
            }
          }else{
            ?>
            <tr>
              <td colspan="6">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }
           ?>
         </tbody>
      </table>
      <hr><hr><br><br>


     

      <h3>รายชื่อพนักงาน</h3>
      <form action="<?= $this->createUrl('ReportAuthority/DepartmentManager') ?>" method="GET">
       <table class="table table-bordered" id="user_list">
         <thead>
          <tr>            
            <th></th>
            <th>ชื่อ - นามสกุล</th>
            <th>ประเภทพนักงาน</th>
            <th>ฝ่าย</th>
            <th>แผนก</th>
            <th>เลเวล</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($userAll)){
            foreach ($userAll as $key => $value) {
              ?>
              <tr>
                <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td>
                <td><?= $value->profile->firstname." ".$value->profile->lastname ?></td>
                <td>
                  <?php 
                  if($value->profile->type_employee == 1){
                    echo "คนเรือ";
                  }elseif($value->profile->type_employee == 2){
                    echo "คนออฟฟิศ";
                  }
                   ?>
                </td>
                <td><?= $value->department->dep_title ?></td>
                <td><?= $value->position->position_title ?></td>
                <td><?= $value->branch->branch_name ?></td>
              </tr>
              <?php
            }
          }else{
            ?>
            <tr>
              <td colspan="6">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }




           ?>
        </tbody>
      </table>
      <br>
      <button type="submit" class="btn btn-success">+ เพิ่ม ผู้จัดการแผนก</button>
      </form>




    </div>
  </div>
</div>
<script type="text/javascript">
  
  function Deleteuser(user) {
    if(user != ""){
      $.ajax({
        type: 'POST',
        url: '<?= $this->createUrl('ReportAuthority/DepartmentManager') ?>',
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

</script>