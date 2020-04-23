
<style type="text/css">
	.topic-info{
		color: #000;
	}
	.profile-detail h5{
		margin: 5px 0;
	}
	.profile-detail h5 b{
		color: #333;
	    padding-right: 8px;
	    min-width: 120px;
	    display: inline-block;
	    text-align: left;
	}
	.profile-detail h5 span{
		color: #296283;
		padding: 8px 8px;
		background: #f0f0f0;
		border-radius: 5px;
	    margin: 5px 0;
	    font-weight: 600;
        border: 1px solid #ddd;
        width: 100%;
        display: inline-block;
	}

	.profile-detail h5 ul{
		list-style: square;
	}
	.profile-detail h5 ul li{
		margin: 8px 0 0 0;
	}
	.profile-detail h5 ul li span{
		width: auto !important;
		margin: 0 5px;
	}
	.profile-detail h5 ul li a span{
		color: #296283 !important;
	}
	.m-1{
		margin: 1em 0;
	}
	.mt-1{
		margin-top: 1em;
	}
	.mt-2{
		margin-top: 2em;
	}

	.d-inlineblock{
		display: inline-block;
		width: auto !important;
	}
	.register-detail{
		padding: 0 2em 2em;
</style>

<form>
	<div class="well profile-detail">
			<div class="text-center m-1">
				<?php 
                                        if ($user['pic_user'] == null) {

                                            $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                        } else {
                                         
                                            $img = Yii::app()->baseUrl . '/../uploads/user/' . $user['id'] . '/thumb/' . $user['pic_user'];
                                            
                                        }

								?> 
				<img border="9" src="<?php echo $img; ?>" width="150" height="180">
			</div>
		<h4 class="topic-info">ข้อมูลพื้นฐาน</h4>
		<div class="mt-1 register-detail">
			<div class="row">
				<div class="col-md-12"><h5><b>ชื่อ-นามสกุล:</b><span><?php if ($profile['sex'] == 'Male') {
					echo "นาย";
				}else{
					echo "นางสาว";
				} ?>&nbsp;&nbsp;<?php echo $profile['firstname'] ?>&nbsp;&nbsp;<?php echo $profile['lastname'] ?></span></h5></div>
				<div class="col-md-12"><h5><b>Name:</b><span><?php if ($profile['sex'] == 'Male') {
					echo "Mr.";
				}else{
					echo "Miss";
				}?>&nbsp;&nbsp;<?php echo $profile['firstname_en'] ?>&nbsp;&nbsp;<?php echo $profile['lastname_en'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>เลขบัตรประจำตัวประชาชน:</b><span><?php echo $profile['identification'] ?></span> </h5></div>
				<div class="col-md-6"><h5><b>วันที่บัตรหมดอายุ:	</b><span><?php echo $profile['date_of_expiry'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>วันเดือนปีเกิด:</b><span><?php echo $profile['birthday'] ?></span> </h5></div>
				<div class="col-md-6"><h5><b>อายุ:</b><span><?php echo $profile['age'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>เชื้อชาติ:</b><span><?php echo $profile['race'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>สัญชาติ:</b><span><?php echo $profile['nationality'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>ศาสนา:</b><span><?php echo $profile['religion'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>เพศ:</b><span><?php if ($profile['sex'] == 'Male') {
					echo "ชาย";
				}else{
					echo "หญิง";
				} ?></span></h5></div>
				<div class="col-md-6"><h5><b>สถานะภาพทางการสมรส:</b><span><?php if ($profile['status_sm'] == 's') {
					echo "โสด";
				}else{
					echo "สมรส";
				} ?></span></h5></div>
				<div class="col-md-12"><h5><b>ที่อยู่:</b><span><?php echo $profile['address'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>เบอร์โทรศัพท์:</b><span><?php echo $profile['tel'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>อีเมล:</b><span><?php echo $user['email'] ?></span></h5></div>
				<div class="col-md-12"><h5><b>ไอดีไลน์:</b><span><?php echo $profile['line_id'] ?></span></h5></div>
				<div class="col-md-6"><h5><b>ประวัติการเจ็บป่วยรุนแรง:</b><span><?php if ($profile['status_sm'] == 'y') {
					echo "เคย";
				}else{
					echo "ไม่เคย";
				} ?></span></h5></div>
				<div class="col-md-12">
					<h5><b>ประวัติการศึกษา:</b>
						<ul><?php
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
							<li>
								<span><?php if($edu_id != ""){
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
                     
                       }else{ echo "-"; }?></span><span><?php echo $institution; ?></span><span><?php echo 25; echo $date_graduation; ?></span>
							</li>
							<?php
}
}
							?>
						</ul>
					</h5>
				</div>
				<div class="col-md-12">
					<h5><b>เอกสารแนบไฟล์วุฒิการศึกษา/วิชาชีพ:</b>
						<ul>
						 <?php
						 $user_id = $user['id'];
                            $idx = 1;
                            $uploadFolder = Yii::app()->getUploadUrl('edufile');
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('user_id ="'.$user_id.'"');
                            $criteria->addCondition("active ='y'");
                            $FileEdu = FileEdu::model()->findAll($criteria);

                            if(isset($FileEdu)){
                             $confirm_del  = Yii::app()->session['lang'] == 1?'Do you want to delete the file ?\nWhen you agree, the system will permanently delete the file from the system. ':'คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร';
                             foreach($FileEdu as $fileDatas){?>
							<li>
								<a href="#"><span><?php echo $fileDatas->file_name;?></span></a>
							</li>
							<?php
}
}
							?>
						</ul>
						</ul>
					</h5>
				</div>
				<div class="col-md-12">
					<h5><b>เอกสารแนบไฟล์ฝึกอบรม:</b>
						<ul>
						 <?php
						 $user_id = $user['id'];
                            $idx = 1;
                            $uploadFolder = Yii::app()->getUploadUrl('edufile');
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('user_id ="'.$user_id.'"');
                            $criteria->addCondition("active ='y'");
                            $FileTraining = FileTraining::model()->findAll($criteria);

                            if(isset($FileTraining)){
                             $confirm_del  = Yii::app()->session['lang'] == 1?'Do you want to delete the file ?\nWhen you agree, the system will permanently delete the file from the system. ':'คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร';
                             foreach($FileTraining as $fileDatas){?>
							<li>
								<a href="#"><span><?php echo $fileDatas->file_name;?></span></a>
							</li>
							<?php
}
}
							?>
						
						</ul>
					</h5>
				</div>
				<?php  
                      $position = Position::model()->find(array(
 							'condition' => 'id=:position_id',
 							'params' => array(':position_id'=>$user['position_id'])
 						));
                      $position = $position->attributes;

				?>
				<div class="col-md-6"><h5><b>ตำแหน่งเรือที่ท่านสนใจสมัคร:</b><span><?php echo $position['position_title']; ?></span></h5></div>
				
				<div class="col-md-12">
					<h5><b>เปลี่ยนตำแหน่งเรือ:</b>
					<select class="form-control d-inlineblock position_id" name="position_id" id="<?php echo $user['id'];?>">
						<option value="">เลือกตำแหน่ง</option>
					 	<option value="16">CHIEF OFFICE</option>
						<option value="17">SECOND OFFICER</option>
						<option value="18">THIRD OFFICER</option>
						<option value="19">BOSAN</option>
						<option value="20">AB</option>
						<option value="21">D-FITTER</option>
						<option value="22">D-BOY</option>
						<option value="23">D-CADET</option>
						<option value="24">CHIEF COOK</option>
						<option value="25">MESSMAN</option>
						<option value="26">CHIEF ENGINEER</option>
						<option value="27">SECOND ENGINEER</option>
						<option value="28">THIRD ENGINEER</option>
						<option value="29">FOURTH ENGINEER</option>
						<option value="30">ELECTRICIAN ENGINEER</option> 
						<option value="31">ASSISTANT ELECTRICIAN</option>
						<option value="32">OILER</option>
						<option value="33">E-FITTER</option>
						<option value="34">E-BOY</option>
						<option value="35">E-CADET</option>
						<option value="36">HR</option>
						<option value="37">ADM</option>
						<option value="38">BUI</option>
						<option value="39">ACT</option>
						<option value="40">FIN</option>
						<option value="41">Chartering</option>
						<option value="42">Operation</option>
						<option value="43">Ins. & Clam</option>
						<option value="44">MOD Center</option>
						<option value="45">MAR</option>
						<option value="46">MPD</option>
						<option value="47">MTT</option>
						<option value="48">QAS</option>
						<option value="49">Technical</option>
						<option value="50">Procure</option>
					</select>
				</h5>
				</div>
			</div>
			<div class="text-center mt-2">
                 <button class="btn btn-primary btn-icon save_data"><i></i>บันทึกข้อมูล</button>                        
             </div>
		</div>
         
    </div>
</form>
</body>
