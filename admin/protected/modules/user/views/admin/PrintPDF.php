
 	<div style="padding-bottom:10px;">
 		<table border="1" width="100%" style="border-collapse:collapse;overflow: wrap;">

 			<tr>
 				<td>
 					<table border="0" width="100%" style="border-collapse:collapse;">
 						<tr>
 							<td width="100%" style="text-align:center;">
 								<?php 
                                        if ($user['pic_user'] == null) {

                                            $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                        } else {
                                         
                                            $img = Yii::app()->baseUrl . '/../uploads/user/' . $user['id'] . '/thumb/' . $user['pic_user'];
                                            
                                        }

								?> 		
 								<table border="0" width="100%" style="border-collapse:collapse;">
 									
 									<tr>
 										<td width="75%" style="padding-top: 10px;">
 											<table border="0" width="100%" style="border-collapse:collapse;">
 												<tr>
 													<td style="padding-left:200px; padding-bottom:-40px; text-align:left; font-size:20px;">
 														<p>JOB APPLICATION FORM</p>
 													</td>
 												</tr>
 												<tr>
 													<td style="text-align:left; font-size:200px;">
 														<p></p>
 													</td>
 												</tr>
 												<tr>
 													<td style="padding-left:270px; padding-bottom:-40px; text-align:left; font-size:20px;">
 														<p>ใบสมัครงาน</p>
 													</td>
 												</tr>
 												<tr>
 													<td style="text-align:left; font-size:500px;">
 														<p></p>
 													</td>
 												</tr>
 												<tr>
 													<td style="padding-left:104px; padding-bottom:-20px; text-align:left; font-size:18px;">
 														<p><?php if($profiles['firstname_en'] != ""){ echo $profiles['firstname_en'];?>&nbsp;&nbsp;
 														<?php echo $profiles['lastname_en']; }else{ echo "-"; } ?></p>
 													</td>
 												</tr>
 												<tr>
 													<td style="text-align:left; font-size:18px;">
 														<p>Name : .................................................................</p>
 													</td>
 												</tr>
 												<tr>
 													<td style="padding-left:104px; padding-bottom:-20px; text-align:left; font-size:18px;">
 														<p><?php if($profiles['firstname'] != ""){ echo $profiles['firstname'];?>&nbsp;&nbsp;
 														<?php echo $profiles['lastname']; }else{ echo "-"; } ?></p>
 													</td>
 												</tr>
 												<tr>
 													<td style="text-align:left; font-size:18px;">
 														<p>ชื่อ : .......................................................................</p>
 													</td>
 												</tr>
 										
 											</table>
 										</td>
 										<td width="25%" style="text-align:right;">
 											<img border="9" src="<?php echo $img; ?>" width="150" height="180";>
 										</td>
 									</tr>
 								</table>
 							</td>
 						</tr> 				
 						<tr>
 							<td width="100%"  style="text-align:left; font-size:18px; padding-left:70px; padding-bottom:-25px;">
 								<p><?php if($profiles['age'] != ""){ echo $profiles['age']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:290px; padding-bottom:-21px;">
 								<p><?php if($profiles['birthday'] != ""){ echo $profiles['birthday']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:500px; padding-bottom:-20px;">
 								<p><?php if($profiles['race'] != ""){ echo $profiles['race']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>อายุ.................วันเดือนปีเกิด...........................................เชื้อชาติ........................................</p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:90px; padding-bottom:-22px;">
 								<p><?php if($profiles['nationality'] != ""){ echo $profiles['nationality']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:408px; padding-bottom:-20px;">
 								<p><?php if($profiles['religion'] != ""){ echo $profiles['religion']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>สัญชาติ................................................ศาสนา.....................................................................</p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:220px; padding-bottom:-22px;">
 								<p><?php if($profiles['identification'] != ""){ echo $profiles['identification']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:567px; padding-bottom:-22px;">
 								<p><?php if($profiles['date_of_expiry'] != ""){ echo $profiles['date_of_expiry']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>บัตรประจำตัวประชาชน...............................................วันหมดอายุ.......................................</p>
 							</td>
 						</tr>
                        <tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:80px; padding-bottom:-22px;">
 								<p><?php if($profiles['sex'] != ""){if ($profiles['sex'] == 'Male') {
 										echo "ชาย";
 									}else{
 										echo "หญิง";
 									}}else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>เพศ...........................................</p>
 							</td>
 						</tr>
                        <tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:220px; padding-bottom:-22px;">
 								<p><?php if($profiles['passport'] != ""){echo $profiles['passport'];}else{ echo "-";  } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:567px; padding-bottom:-22px;">
 								<p><?php if($profiles['passport'] != ""){ echo $profiles['passport']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>หนังสือเดินทางเลขที่................................................วันหมดอายุ..........................................</p>
 							</td>
 						</tr>
 					    <tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:220px; padding-bottom:-22px;">
 								<p><?php if($profiles['passport'] != ""){ echo $profiles['passport']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:567px; padding-bottom:-22px;">
 								<p><?php if($profiles['passport'] != ""){ echo $profiles['passport']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>หนังสือประจำตัวลูกเรือ.............................................วันหมดอายุ..........................................</p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:280px; padding-bottom:-22px;">
 								<p><?php if($profiles['status_sm'] != ""){ 
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
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>สถานภาพทางการสมรส...........................................</p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:58px; padding-bottom:-22px;">
 								<p><?php if($profiles['address'] != ""){ echo $profile['address']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>ที่อยู่...................................................................................................................................</p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:90px; padding-bottom:-22px;">
 								<p><?php if($profiles['tel'] != ""){ echo $profiles['tel']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:408px; padding-bottom:-22px;">
 								<p><?php if($profiles['line_id'] != ""){ echo $profiles['line_id']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>มือถือ............................................ID-Line.........................................................................</p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:58px; padding-bottom:-20px;">
 								<p><?php if($user['email'] != ""){ echo $user['email']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>อีเมล..................................................................................................................................</p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:280px; padding-bottom:-20px;">
 								<p><?php if($profiles['history_of_illness'] != ""){ 
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
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>เคยเจ็บป่วยรุนแรงหรือไม่........................................</p>
 							</td>
 						</tr>
 						<?php
                        $position = Position::model()->find(array(
 							'condition' => 'id=:position_id',
 							'params' => array(':position_id'=>$user['position_id'])));
 						$position = $position->attributes;
 						?>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px; padding-left:280px; padding-bottom:-20px;">
 								<p><?php if($position['position_title'] != ""){ echo $position['position_title']; }else{ echo "-"; } ?></p>
 							</td>
 						</tr>
 						<tr>
 							<td width="100%" style="text-align:left; font-size:18px;">
 								<p>ตำแหน่งที่สมัคร......................................................</p>
 							</td>
 						</tr>				
 				</table>
 			</td>
 		</tr>
 	</table>
 </div>
<?php
//  $user_id = $user['id'];
//  				$ProfilesEdu = ProfilesEdu::model()->findAll(array(
//  					'condition' => 'user_id=:user_id AND active=:active',
//  					'params' => array(':user_id'=>$user_id, ':active'=>'y')));
//  				if(!empty($ProfilesEdu)){ 
// foreach ($ProfilesEdu as $key => $value) {					

//  					$education_data = $ProfilesEdu[$key]->attributes;
//  					$edu_id = $education_data['edu_id'];
//  					$institution = $education_data['institution'];
//  					$date_graduation = $education_data['date_graduation'];
 				
//  				 $Educations = Education::model()->findAll(array(
//  					'condition' => 'edu_id=:edu_id AND active=:active',
//  					'params' => array(':edu_id'=>$edu_id, ':active'=>'y')));
 				 
//  		var_dump($Educations['edu_name']);
 			
//  					$edu_name = $Education['edu_name'];
 
//  				}
//  			}
?>
 <div style="padding-bottom:10px;">
 	<table border="1" width="100%" style="border-collapse:collapse; overflow: wrap;">
 		<thead>
 			<tr style="background-color:#D3D3D3;">
 				<td colspan="3" width="100%" style="text-align:left; font-size:20px; font-weight: bold;">
 					<p>ประวัติการศึกษา</p>
 				</td>
 			</tr>
 			<tr>
 				<td width="17%" style="padding-bottom:-2px; text-align:center; font-size:19px; font-weight: bold;">
 					<p>ระดับการศึกษา</p>
 				</td>
 				<td width="45%" style="padding-bottom:-2px; text-align:center; font-size:19px; font-weight: bold;">
 					<p>สถาบันการศึกษา</p>
 				</td>
 				<td width="13%" style="padding-bottom:-2px; text-align:center; font-size:19px; font-weight: bold;">
 					<p>ปี พ.ศ.</p>
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
 						<td style="text-align:center; font-size:18px;" valign="top">
 							<p><?php if($edu_id != ""){
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
 						<td style="text-align:center; font-size:18px;" valign="top">
 							<p><?php if($institution != ""){ echo $institution; }else{ echo "-"; } ?></p>
 						</td>
 						<td style="text-align:center; font-size:18px;" valign="top">
 							<p><?php if($date_graduation != ""){ echo 25; echo $date_graduation; }else{ echo "-"; } ?></p>
 						</td>
 					</tr>  
 					<?php
 				}
 			}else{
 				?>
 				<tr>
 					
 					<td style="text-align:center; font-size:18px; font-style:italic;">-</td>
 					<td style="text-align:center; font-size:18px; font-style:italic;">-</td>
 					<td style="text-align:center; font-size:18px; font-style:italic;">-</td> 					
 				</tr> 
 				<?php
 			}
 			?>
 		</tbody> 			
 	</table>
 </div>
