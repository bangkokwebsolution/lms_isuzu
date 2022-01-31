<?php
$titleName = 'จัดการผู้อนุมัติ คนที่ 1';
$this->breadcrumbs=array($titleName);
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

       <h3>จัดการผู้อนุมัติ คนที่ 1</h3>
       <table class="table table-bordered" id="user_board">
         <thead>
          <tr>
            <th width="5%" style="text-align: center;">ลำดับ</th>
            <th>User id</th>
            <th>Role</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ - นามสกุล</th>
            <th>KIND</th>
            <th>Employee class</th>
            <th>Position description</th>
            <th>Work Location</th>
            <th width="5%">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($user)){
            $no = 1;
            foreach ($user as $key => $value) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $no; $no++; ?></td>
                <td><?= $value->username ?></td>
                <?php 
                        $group =  $value->group;
                                $jsongroup =  json_decode($group);
                                $groups = '';
                                if($jsongroup){
                                    foreach ($jsongroup as $key => $grp) {
                                        $criteria = new CDbCriteria;
                                        $criteria->addcondition('id ='.$grp);
                                        $criteria->addcondition('id != 1');
                                        
                                        // $groupUser =  PGroup::model()->find(array('condition' => 'id ='.$grp));

                                        $groupUser =  PGroup::model()->find($criteria);
                                        $number =$key+1;
                                        // $groups .=   $number.').'.$groupUser->group_name.'<br>';
                                        $groups .=   $groupUser->group_name.'<br>';
                                    }
                                    
                                } 
                ?>
                <td><?= $groups ?></td>
                <td><?= $value->employee_id ?></td>
                <td><?= $value->profile->firstname_en." ".$value->profile->lastname_en ?></td>
                <td><?= $value->profile->kind ?></td>
                <td><?= $value->profile->EmpClass->title ?></td>
                <td><?= $value->profile->EmpClass->descrpition ?></td>
                <td><?= $value->profile->location ?></td>
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
              <td colspan="8">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }
           ?>
         </tbody>
      </table>
      <hr><br><br>
     

      <h3>รายชื่อทั้งหมด</h3>
      <form action="<?= $this->createUrl('AuthorityHR/Index') ?>" method="GET">
       <table class="table table-bordered" id="user_list">
         <thead>
          <tr>            
            <th width="5%"></th>
            <th>User id</th>
            <th>Role</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ - นามสกุล</th>
            <th>KIND</th>
            <th>Employee class</th>
            <th>Position description</th>
            <th>Work Location</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($userAll)){
            foreach ($userAll as $key => $value) {
              ?>
              <tr>
                <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td>
                 <td><?= $value->username ?></td>
                <?php 
                        $group =  $value->group;
                                $jsongroup =  json_decode($group);
                                $groups = '';
                                if($jsongroup){
                                    foreach ($jsongroup as $key => $grp) {
                                        $criteria = new CDbCriteria;
                                        $criteria->addcondition('id ='.$grp);
                                        $criteria->addcondition('id != 1');
                                        
                                        // $groupUser =  PGroup::model()->find(array('condition' => 'id ='.$grp));

                                        $groupUser =  PGroup::model()->find($criteria);
                                        $number =$key+1;
                                        // $groups .=   $number.').'.$groupUser->group_name.'<br>';
                                        $groups .=   $groupUser->group_name.'<br>';
                                    }
                                    
                                } 
                ?>
                <td><?= $groups ?></td>
                <td><?= $value->employee_id ?></td>
                <td><?= $value->profile->firstname_en." ".$value->profile->lastname_en ?></td>
                <td><?= $value->profile->kind ?></td>
                <td><?= $value->profile->EmpClass->title ?></td>
                <td><?= $value->profile->EmpClass->descrpition ?></td>
                <td><?= $value->profile->location ?></td>
              </tr>
              <?php
            }
          }else{
            ?>
            <tr>
              <td colspan="8">ไม่มีข้อมูล</td>
            </tr>
            <?php
          }




           ?>
        </tbody>
      </table>
      <br>
      <button type="submit" class="btn btn-success">+ เพิ่ม จัดการผู้อนุมัติ 1</button>
      </form>




    </div>
  </div>
</div>
<script type="text/javascript">
  
  function Deleteuser(user) {
    if(user != ""){
      $.ajax({
        type: 'POST',
        url: '<?= $this->createUrl('AuthorityHR/Index') ?>',
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