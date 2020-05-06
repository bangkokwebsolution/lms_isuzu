
<style type="text/css">
  body{
    line-height:10.4 !important;
  }
    .t-center{
      text-align: center;
    }
    .t-bold{
      font-weight: bold;
    }

    .f-22{
      font-size: 22px;
        line-height:10.4 !important;
    }
   
    .f-20{
      font-size: 20px;
        line-height:10.4 !important;
    }

    .f-14{
      font-size: 14px;
    }
    .w-100{
      width: 100%;
      display:block;
    }
    
    .border-main{
      /*border: 3px solid #000;*/
      padding: 1.5em;
      height: 100%;
      width: 100%;
    }
    .w-100 span{
      display: inline-block;
    }

    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }
    tr td{
      padding: 5px 0;
    }
table .t-edu {
/* page-break-after: always;*/
}
  
</style>

<div class="border-main"> 

    
    <?php
 if ($user != null) {
   $head  = Yii::app()->baseUrl . "/../admin/images/head.jpg";
  } else {
   $head  = Yii::app()->baseUrl . "/../admin/images/head.jpg";                                            
  }
?>
 <img src="<?php echo $head; ?> " style="height:180px; padding-left: 20px;">

    <table style="width: 100%;">
            <tr class="clearfix" >
              <td width="80%" style="padding-top: 4em; padding-left: 10em; vertical-align: top; text-align: center;">
                <p class="t-bold f-20" >
                  JOB APPLICATION FORM 
                  <br>
                  ใบสมัครงาน
                </p>
                </td>
                <td  width="20%" style="padding-top: 30px; ">
                  <?php 
                if ($user['pic_user'] == null) {

                    $img  = Yii::app()->theme->baseUrl . "/../../../themes/template2/images/thumbnail-profile.png";
                } else {
                 
                    $img = Yii::app()->baseUrl . '/../uploads/user/' . $user['id'] . '/thumb/' . $user['pic_user'];
                }
                ?>   
                    <img src="<?php echo $img; ?>" width="150" height="180" style="border: 1px solid #999"> 
                </td>
            </tr>

          </table>
          <table style="width: 100%">

           <tr>
              <td width="100%" style="padding-left:104px; padding-bottom:-19px; text-align:left; ">
                <p class="f-14"><?php if($profiles['firstname_en'] != ""){ echo $profiles['firstname_en'];?>&nbsp;&nbsp;
                <?php echo $profiles['lastname_en']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
              <tr>
                <td width="100%"  style="text-align:left; ">
                  <p class="f-14">Name : ..........................................................................................................................................................</p>
                </td>
              </tr>
              <tr>
                <td width="100%" style="padding-left:104px; padding-bottom:-19px; text-align:left; ">
                  <p class="f-14"><?php if($profiles['firstname'] != ""){ echo $profiles['firstname'];?>&nbsp;&nbsp;
                  <?php echo $profiles['lastname']; }else{ echo "-"; } ?></p>
                </td>
              </tr>
              <tr>
                <td width="100%" style="text-align:left; ">
                  <p class="f-14">ชื่อ : ...............................................................................................................................................................</p>
                </td>
              </tr>

           <tr>
              <td  style="  padding-left:90px; padding-bottom:-28px;">
                <p class="f-14">
                  <?php if($profiles['sex'] != ""){if ($profiles['sex'] == 'Male') {
                    echo "ชาย";
                  }else{
                    echo "หญิง";
                  }}else{ echo "-"; } ?>
                </p>
              </td>
            </tr>

            <tr>
              <td style="  padding-left:290px;padding-bottom:-28px;">
                <p class="f-14">
                    <?php if($profiles['age'] != ""){ echo $profiles['age']; }else{ echo "-"; } ?>
                  </p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:500px; padding-bottom:-19px;">
                <p class="f-14">
                  <?php if($profiles['birthday'] != ""){ echo $profiles['birthday']; }else{ echo "-"; } ?>
                  </p>
              </td>
            </tr>

            <tr width="100%">
              <td width="100%">
                <p class="f-14">
                  เพศ : ....................................... อายุ : ........................................  วันเดือนปีเกิด : ...........................................
                </p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:90px; padding-bottom:-25px;">
                    <p class="f-14"><?php if($profiles['race'] != ""){ echo $profiles['race']; }else{ echo "-"; } ?></p>
              </td>
                  </p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:320px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['nationality'] != ""){ echo $profiles['nationality']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:550px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['religion'] != ""){ echo $profiles['religion']; }else{ echo "-"; } ?></p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left; ">
                <p class="f-14">
                   เชื้อชาติ : ....................................... สัญชาติ : ..........................................  ศาสนา : .........................................
                 </p>
              </td>
            </tr>

            <tr>
              <td style="text-align:left;  padding-left:190px; padding-bottom:-24px;">
                <p class="f-14"><?php if($profiles['identification'] != ""){ echo $profiles['identification']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['date_of_expiry'] != ""){ echo $profiles['date_of_expiry']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">บัตรประจำตัวประชาชน : ........................................................  วันหมดอายุ....................................................... </p>
              </td>
            </tr>
                
            <div style="page-break-after:always;"></div>

             <tr>
              <td style="text-align:left;  padding-left:190px; padding-bottom:-22px;">
                <p><?php if($profiles['passport'] != ""){echo $profiles['passport'];}else{ echo "-";  } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['passport'] != ""){ echo $profiles['passport']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">หนังสือเดินทางเลขที่ : ...........................................................  วันหมดอายุ : ....................................................</p>
              </td>
            </tr>
              <tr>
              <td style="text-align:left;  padding-left:190px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['seamanbook'] != ""){ echo $profiles['seamanbook']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:460px; padding-bottom:-22px;">
                <p class="f-14"><?php if($profiles['seaman_expire'] != ""){ echo $profiles['seaman_expire']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">หนังสือประจำตัวลูกเรือ : ........................................................  วันหมดอายุ : ....................................................</p>
              </td>
            </tr>
                <tr>
              <td style="text-align:left;  padding-left:250px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['status_sm'] != ""){ 
                  if ($profiles['status_sm'] == 's') {
                    echo "โสด";
                  }else{
                    echo "สมรส"; 
                  }
                }else{ 
                  echo "-"; 
                } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">สถานภาพทางการสมรส : .........................................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:58px; padding-bottom:-21px;">
                <p class="f-14"><?php if($profiles['address'] != ""){ echo $profile['address']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14" style="line-height:10px;">ที่อยู่ : .............................................................................................................................................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:90px; padding-bottom:-23px;">
                <p class="f-14"><?php if($profiles['tel'] != ""){ echo $profiles['tel']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:408px; padding-bottom:-20px;">
                <p class="f-14"><?php if($profiles['line_id'] != ""){ echo $profiles['line_id']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">มือถือ : .....................................................................  ID-Line : ...................................................................... </p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:58px; padding-bottom:-19px;">
                <p class="f-14"><?php if($user['email'] != ""){ echo $user['email']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">อีเมล : ............................................................................................................................................................</p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left;  padding-left:190px; padding-bottom:-19px;">
                <p class="f-14"><?php if($profiles['history_of_illness'] != ""){ 
                  if ($profiles['history_of_illness'] == 'y') {
                    echo "เคย";
                  }else{
                    echo "ไม่เคย"; 
                  }
                }else{ 
                  echo "-"; 
                } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">เคยเจ็บป่วยรุนแรงหรือไม่ : ........................................</p>
              </td>
            </tr>
  
            <?php
              $position = Position::model()->find(array(
              'condition' => 'id=:position_id',
              'params' => array(':position_id'=>$user['position_id'])));
            $position = $position->attributes;
            ?>
            <tr>
              <td style="text-align:left;  padding-left:160px; padding-bottom:-19px; ">
                <p class="f-14"><?php if($position['position_title'] != ""){ echo $position['position_title']; }else{ echo "-"; } ?></p>
              </td>
            </tr>
            <tr>
              <td style="text-align:left; ">
                <p class="f-14">ตำแหน่งที่สมัคร : ......................................................</p>
              </td>
            </tr>  
          </table>

<table border="1" class="t-edu" style="border-collapse:collapse; overflow: wrap; width: 100%;margin-top: 3em;" >
  <thead>
    <tr style="background-color:#D3D3D3;">
      <td colspan="3" style="text-align:left;  font-weight: bold; padding:10px;">
        <p class="f-14">ประวัติการศึกษา</p>
      </td>
    </tr>
    <tr>
      <td width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14 ">ระดับการศึกษา</p>
      </td>
      <td width="45% " style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">สถาบันการศึกษา</p>
      </td>
      <td width="13%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14 ">ปี พ.ศ.</p>
      </td>
    </tr>
  </thead>
  <tbody>
    <?php 
      $user_id = $user['id'];
      $ProfilesEdu = ProfilesEdu::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active=:active',
        'params' => array(':user_id'=>$user_id, ':active'=>'y')));
    
      if(!empty($ProfilesEdu)){ 
      foreach ($ProfilesEdu as $key => $value) {          

        $education_data = $ProfilesEdu[$key]->attributes;
        $edu_id = $education_data['edu_id'];
        $institution = $education_data['institution'];
        $date_graduation = $education_data['date_graduation'];
      
       $Education = Education::model()->findAll(array(
        'condition' => 'edu_id=:edu_id AND active=:active',
        'params' => array(':edu_id'=>$edu_id, ':active'=>'y')));
       $Education = $Education->attributes;
        $edu_name = $Education['edu_name'];
  
        ?>
        <tr>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($edu_id != ""){
            if($edu_id == 1) {
                             echo "มัธยมศึกษาตอนต้น(ม.3)";
            }else if($edu_id == 2){
                             echo "มัธยมศึกษาตอนปลาย(ม.6)"; 
            }else if($edu_id == 3){
                             echo "ประกาศนียบัตรวิชาชีพ(ปวช.)";
            }else if($edu_id == 4){
                             echo "ประกาศนียบัตรวิชาชีพชั้นสูง(ปวส.)";
            }else if($edu_id == 5){
                             echo "ประกาศนียบัตรวิชาชีพเทคนิค (ปวท.)";
            }else if($edu_id == 6){
                             echo "ปริญญาตรี";
            }else if($edu_id == 7){
                             echo "ปริญญาโท";
            }else if($edu_id == 8){
                           echo "ปริญญาเอก";
            }
                   
                     }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($institution != ""){ echo $institution; }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($date_graduation != ""){ echo 25; echo $date_graduation; }else{ echo "-"; } ?></p>
          </td>
        </tr>  
        <?php
      }
    }else{
      ?>
      <tr>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>          
      </tr> 
      <?php
    }
    ?>
  </tbody>      
</table>   

<table border="1" style="border-collapse:collapse; overflow: wrap; width: 100%;">
  <thead >
    <tr style="background-color:#D3D3D3;">
      <td colspan="4" style="text-align:left;  font-weight: bold; padding:10px; border-top: none;">
        <p class="f-14">ประวัติการทำงาน</p>
      </td>
    </tr>
    <tr>
      <td width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">บริษัท</p>
      </td>
      <td width="17%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">ตำแหน่ง</p>
      </td>
      <td width="13%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">ตั้งแต่</p>
      </td>
      <td width="43%" style="padding-bottom:-2px; text-align:center;  font-weight: bold;padding:10px;">
        <p class="f-14">สาเหตุที่ออก</p>
      </td>
    </tr>
  </thead>
  <tbody>
    <?php 
      $user_id = $user['id'];
      $ProfilesWorkHistory = ProfilesWorkHistory::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active=:active',
        'params' => array(':user_id'=>$user_id, ':active'=>'y')));
    
      if(!empty($ProfilesWorkHistory)){ 
      foreach ($ProfilesWorkHistory as $key => $value) {          

        $WorkHistory_data = $ProfilesWorkHistory[$key]->attributes;
        $company_name = $WorkHistory_data['company_name'];
        $since_date = $WorkHistory_data['since_date'];
        $position_name = $WorkHistory_data['position_name'];
        $reason_leaving = $WorkHistory_data['reason_leaving'];
  
        ?>
        <tr>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($company_name != ""){ echo $company_name; }else{ echo "-"; } ?></p>
          </td>
         <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($position_name != ""){ echo $position_name; }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($since_date != ""){ echo $since_date; }else{ echo "-"; } ?></p>
          </td>
          <td style="text-align:center; " valign="top">
            <p class="f-14"><?php if($reason_leaving != ""){echo $reason_leaving; }else{ echo "-"; } ?></p>
          </td>
        </tr>  
        <?php
      }
    }else{
      ?>
      <tr>
        
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>
        <td style="text-align:center;  font-style:italic;">-</td>          
      </tr> 
      <?php
    }
    ?>
  </tbody>      
</table>
 
<table style="border-collapse:collapse; width: 100%;margin-top: 3em;">
    <tr> 
      <td style="padding-left:204px;text-align:right;">
        <p class="f-14">ลงชื่อผู้สมัคร : .................................................................</p>
      </td>
    </tr>

    <tr>
      <td style="padding-left:430px;text-align:left; padding-bottom:-18px;" >
        <p class="f-14"><?php if($profiles['firstname'] != ""){ echo $profiles['firstname'];?>&nbsp;&nbsp;
        <?php echo $profiles['lastname']; }else{ echo "-"; } ?></p>
      </td>
    </tr>

      <tr>
        <td style="padding-left:204px;text-align:right;" >
          <p class="f-14">(.......................................................................)</p>
        </td>
      </tr>
  
      <tr>
        <td style="padding-left:204px;text-align:right; ">
          <p class="f-14">วันที่ : .......................................................................</p>
        </td>
      </tr>
    
</table>


</div>