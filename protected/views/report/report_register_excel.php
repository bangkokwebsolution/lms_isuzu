<?php
$strExcelFileName = "รายงานภาพรวมการสมัคร-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");

  // var_dump($data['TypeEmployee']);

$datetime_start = $data['datetime_start'];
$datetime_end = $data['datetime_end'];
$status = $data['status'];
$Year_start = $data['Year_start'];
$Year_end = $data['Year_end'];
$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
$Chart = $data['Chart'];
  // exit();
$user_login = User::model()->findByPk(Yii::app()->user->id);
$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
$user_Level = $user_login->branch_id;
$user_Position = $user_login->position_id;
$user_Department = $user_login->department_id;

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="row">
		<h1><?php
		if (Yii::app()->session['lang'] == 1) {
			echo "Report overview register";
		}else{
			echo "รายงานภาพรวมการสมัครสมาชิก";
		}
		?></h1>
		<div class="col-sm-12">
			<?php
			if ($Chart != "") {
			?>
			<?php if ($Chart === "accommodation=Bar_Graph") { ?>
				<img src="<?= Yii::app()->getBaseUrl(true)?>/uploads/AttendPrint.png" width="500" height="auto">
			<?php }else if($Chart === "accommodation=Pie_Charts"){ ?>
				<img src="<?= Yii::app()->getBaseUrl(true)?>/uploads/AttendPrint1.png" width="500" height="auto">
			<?php } 
			$f = 20;
			for ($p=0; $p <= $f ; $p++) { 
			echo "<br>";
		}
			?>
		</div><br>
	</div>
	<?php
	if ($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") { ?>
		<div class="row">
			<div class="col-sm-12">
				<img src="<?= Yii::app()->getBaseUrl(true) ?>/uploads/AttendPrint.png" width="500" height="auto">
				<img src="<?= Yii::app()->getBaseUrl(true) ?>/uploads/AttendPrint1.png" width="500" height="auto">
			</div><br>
		</div>
		<?php	$f = 20;
		for ($p=0; $p <= $f ; $p++) { 
			echo "<br>";
		}

	}
	if ($Year_start != null && $Year_end != null) {
		if ($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") { ?>
			<div class="row">
				<div class="col-sm-12">
					<img src="<?= Yii::app()->getBaseUrl(true) ?>/uploads/AttendPrint3.png" width="500" height="auto">
					<img src="<?= Yii::app()->getBaseUrl(true) ?>/uploads/AttendPrint4.png" width="500" height="auto">
				</div><br>
			</div>
			<?php
		}
		$l = 20;
		for ($i=0; $i <= $l ; $i++) { 
			echo "<br>";
		}
	}
	}
	$criteria = new CDbCriteria;
	$criteria->compare('type_employee_id',$data['TypeEmployee']);
	if($data['Department']){
		$criteria->compare('id',$data['Department']);
	}
	if ($authority == 2 || $authority == 3) {
		$criteria->compare('id',$user_Department);
	}
	$criteria->compare('active','y');
	$dep = Department::model()->findAll($criteria);
	$dep_arr = [];
	foreach ($dep as $key => $val_dep) {
		$dep_arr[] = $val_dep->id;
	}


	$criteria = new CDbCriteria;
	$criteria->addIncondition('department_id',$dep_arr);
	$criteria->compare('active','y');
	if ($data['Position'] != "") {
		if($data['Position']){
				$criteria->compare('id',$data['Position']);
			}
	}else{
		if ($authority == 2 || $authority == 3) {
			$criteria->compare('id',$user_Position);
		}
	}
	$pos = Position::model()->findAll($criteria);

	$pos_arr = [];
	$posback_arr = [];
	foreach ($pos as $key => $val_pos) {
		$pos_arr[] = $val_pos->id;
		$posback_arr[] = $val_pos->department_id;
	}


	$criteria = new CDbCriteria;
	$criteria->addIncondition('position_id',$pos_arr);
	$criteria->compare('active','y');
	if ($data['Leval'] != "") {
			if($data['Leval']){
			$criteria->compare('id',$data['Leval']);
		}
	}else{
			if ($authority == 3) {
			$criteria->compare('id',$user_Level);
		}
	}
	$criteria->group = 'position_id';
	$criteria->order = 'sortOrder ASC';
	$branch = Branch::model()->findAll($criteria);


	$branch_arr = [];
	foreach ($branch as $key => $val_branch) {
		$branch_arr[] = $val_branch->position_id;
	}
	$result_branch_arr = array_unique( $branch_arr );
	$result_pos_arr = array_unique( $posback_arr );

	$criteria = new CDbCriteria;
	$criteria->addIncondition('department_id',$dep_arr);
	if ($data['Position'] != "") {
		if($data['Position']){
				$criteria->compare('id',$data['Position']);
			}
	}else{
		if ($authority == 2 || $authority == 3) {
			$criteria->compare('id',$user_Position);
		}
	}
	$criteria->addNotInCondition('id',$result_branch_arr);
	$criteria->compare('active','y');
	$criteria->order = 'sortOrder ASC';
	$pos_back = Position::model()->findAll($criteria);

	$criteria = new CDbCriteria;
	$criteria->compare('type_employee_id',$data['TypeEmployee']);
	if($data['Department']){
		$criteria->compare('id',$data['Department']);
	}
	if ($authority == 2 || $authority == 3) {
		$criteria->compare('id',$user_Department);
	}
	$criteria->addNotInCondition('id',$result_pos_arr);
	$criteria->compare('active','y');
	$criteria->order = 'sortOrder ASC';
	$dep_back = Department::model()->findAll($criteria);

							foreach ($branch as $key => $value) { 	
								$name_dep[] = $value->Positions->Departments->id;
								$names_dep[] = $value->Positions->Departments->dep_title;
								$id_pos[] = $value->Positions->id;
								$name_pos[] = $value->Positions->position_title;
								$name_level = $value->branch_name;
								$id_level = $value->id;

							}
							foreach ($dep_back as $keydep_back => $valuedep_back) { 
								$name_dep_not[] = $valuedep_back->id;
								$names_dep_not[] = $valuedep_back->dep_title;
							}
							$result_dep_in = array_unique( $name_dep );
							$result_dep_not = array_unique( $name_dep_not );
							$result_pos_in = array_unique( $id_pos );
							$result_pos_not = array_unique( $name_pos );

							$result_dep_in_name = array_unique( $names_dep );
							$result_dep_not_name = array_unique( $names_dep_not );
							foreach ($result_dep_not_name as $key => $value) {
								array_push($result_dep_in_name,$value);

							}
							foreach ($result_dep_not as $key => $value) {
								array_push($result_dep_in,$value);
							}
	if($Year_start == "" && $Year_end == ""){
	
		if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
			?>
			<style type="text/css">
				tr td,tr th{
					border:1px solid #d8d8d8;
					padding: 8px;
				}
				tr th{
				    background: #010C65;
    				color: #fff;
				}
				.text-center{
					text-align: center;
				}
			</style>
			<?php
			$i = 1;
			if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) { ?>
			<div class="report-table">
				<?php

								
									foreach ($result_pos_in as $key => $value) {
										$var_result[] = $value;
									}		
												$criteria = new CDbCriteria;
												$criteria->compare('position_id',$var_result);
												if ($Leval != "") {
													$criteria->compare('branch_id',$id_level);
												}
												if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
												}
												$criteria->compare('superuser',0);
												$criteria->compare('del_status',0);
												$criteria->compare('status',1);
												$criteria->compare('register_status',1);
									
											$users_br = Users::model()->findAll($criteria);
											$total = count($users_br);

									foreach ($pos_back as $keypos_back => $valuepos_back) { 
									 		$position_pos[] = $valuepos_back->id;
									 		$departments_pos[] = $valuepos_back->Departments->id;
									}
										$criteria = new CDbCriteria;
										$criteria->compare('position_id',$position_pos);
										$criteria->compare('department_id',$departments_pos);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
									if ($status != null) {

											if ($status == "1") {
												$criteria->compare('register_status',1);
												$criteria->compare('status',1);
											}
											if($status == "0"){
												if ($status != "1") {
													$criteria->compare('register_status',0);
													$criteria->compare('status',1);
												}else{
													$criteria->compare('register_status',0);
													$criteria->compare('status',0);
												} 
												
											}
										}
										$users_ps = Users::model()->findAll($criteria);
										
										$total_pos = count($users_ps);
									foreach ($dep_back as $keydep_back => $valuedep_back) { 
										$departments_dep[] = $valuedep_back->id;
									}
										$criteria = new CDbCriteria;
										$criteria->compare('department_id',$departments_dep);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										if($status != null){
											$criteria->compare('status',$status);		
										}
										$users_dm = Users::model()->findAll($criteria);
									
										$total_dep = count($users_dm);
				?>
				<p style="text-align: right;">จำนวนคนสมัครทั้งหมด<span style="font-weight:bold;">
					<?php
						if ($data['TypeEmployee'] == 2 && $dep_back && $data['Department'] != "") {
										echo $total_dep;
									}else if($data['TypeEmployee'] == 2 && $branch && $data['Department'] != ""){
										echo $total;
									}else if($data['TypeEmployee'] == 1 && $pos_back){
										echo  $total_pos;
									}else if($data['TypeEmployee'] == 2 && $data['Department'] == ""){
										echo  $total_dep + $total;
									}

					?>
				</span>คน</p>
				<div class="table-responsive w-100 t-regis-language">
					<table class="table" style="border:1px solid #d8d8d8;border-collapse: collapse;width: 100%;	">     
						<thead>
							<tr style="background: #010C65;color: #fff; border:1px solid #d8d8d8;padding: 8px;">
								<?php
								if (Yii::app()->session['lang'] == 1) { ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">No.</th>
								<?php if($data['TypeEmployee'] != 1){ ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Division</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Department</th>
								<?php
									if ($Leval != "") {
									?>
									<th style="border:1px solid #d8d8d8; padding: 8px;">Level</th>
								<?php 
									}
								}else{ ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Department</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Position</th>
								<?php } ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Number</th>
								<?php if($data['TypeEmployee'] != 2){ ?>
									<th style="border:1px solid #d8d8d8; padding: 8px;">Total number</th>
									<th style="border:1px solid #d8d8d8; padding: 8px;">Status</th>
								<?php } ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">Percent</th>
								<?php }else{ ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ลำดับ</th>
								<?php if($data['TypeEmployee'] != 1){ ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ฝ่าย</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>
								<?php
									if ($Leval != "") { ?>
									<th style="border:1px solid #d8d8d8; padding: 8px;">เลเวล</th>									
								<?php }
								}else{ ?>
									<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ตำแหน่ง</th>
								<?php } ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">จำนวน</th>
								<?php if($data['TypeEmployee'] != 2){ ?>
									<th style="border:1px solid #d8d8d8; padding: 8px;">สมัครทั้งหมด</th>
									<th style="border:1px solid #d8d8d8; padding: 8px;">สถานะอนุมัติ</th>
								<?php } ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">คิดเป็นร้อยละ</th>
							<?php }
								?>
							</tr> 
						</thead>
						<tbody>
							<?php if ($data['TypeEmployee'] == 2) {    
								//foreach ($branch as $key => $value) { 	

									// $criteria = new CDbCriteria;
									// $criteria->compare('branch_id',$value->id);
									// $criteria->compare('position_id',$value->Positions->id);
									// $criteria->compare('department_id',$value->Positions->Departments->id);
									// if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									// 	$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
									// }
									// $criteria->compare('superuser',0);
									// $criteria->compare('del_status',0);
									// if($status != null){
									// 	$criteria->compare('status',$status);		
									// }
									// $users = Users::model()->findAll($criteria);

									// $criteria = new CDbCriteria;
									// $criteria->select = 'id';

									// if($data['TypeEmployee']){
									// 	$criteria->compare('type_employee',$data['TypeEmployee']);
									// }
									// if($data['Department']){
									// 	$criteria->compare('department_id',$data['Department']);
									// }
									// if ($authority == 2 || $authority == 3) {
									// 	$criteria->compare('department_id',$user_Department);
									// }
									// if ($data['Position'] != "") {
									// 		if($data['Position']){
									// 				$criteria->compare('position_id',$data['Position']);
									// 			}
									// 		}else{
									// 			if ($authority == 2 || $authority == 3) {
									// 				$criteria->compare('position_id',$user_Position);
									// 			}
									// 		}
									// 		if($data['Leval'] != ""){
									// 		if($data['Leval']){
									// 			$criteria->compare('branch_id',$data['Leval']);
									// 		}
									// 		}else{
									// 			if ($authority == 3) {
									// 				$criteria->compare('branch_id',$user_Level);
									// 			}
									// 		}
									// $criteria->compare('superuser',0);
									// $criteria->compare('del_status',0);
									// $usersAll = Users::model()->findAll($criteria);
								foreach ($result_pos_in as $key => $value) {
										$criteria = new CDbCriteria;
												$criteria->compare('position_id',$value);
												if ($Leval != "") {
													$criteria->compare('branch_id',$id_level);
												}
												if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
												}
												$criteria->compare('superuser',0);
												$criteria->compare('del_status',0);
												$criteria->compare('status',1);
												$criteria->compare('register_status',1);
												$users_count = Users::model()->findAll($criteria);
												$cou_use = count($users_count);									

											$criteria = new CDbCriteria;
											$criteria->compare('position_id',$value);
											if ($Leval != "") {
													$criteria->compare('branch_id',$id_level);
												}
											if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

													$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
											}
											$criteria->compare('superuser',0);
											$criteria->compare('del_status',0);
											$criteria->compare('register_status',1);
											$usersAll = Users::model()->findAll($criteria);		
											$cou_useAll = count($usersAll);
											
											$per_cen = ($cou_useAll * 100 ) / $cou_use; 
									?>
									<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
										<td><?php echo $i++;?></td>
										<td><?php echo $names_dep[$key];?></td>
										<td><?php echo $result_pos_not[$key];?></td>
										<?php
										if ($Leval != "") { ?>
											<td><?php echo $name_level;?></td>
										<?php
										}
										?>
										
										<td class="text-center"><?php echo $cou_use;?></td>
										<?php if($data['TypeEmployee'] != 2){ ?>
										<?php if (Yii::app()->session['lang'] == 1) {
										 ?>		
											<td class="text-center">
												<?php	if($cou_use > 0){
													if ($status == 1) {?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;Approve</span>
														<?php }else{ ?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Disapproval</span>
														<?php }
													}else{
														echo "-";
													} ?>
												</td>
											<?php }else{ ?>
												<td class="text-center">
												<?php	if($cou_use > 0){
													if ($status == 1) {?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>
														<?php }else{ ?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>
														<?php }
													}else{
														echo "-";
													} ?>
												</td>
											<?php } ?>
												<?php
											}
											if($cou_use > 0){ ?>
												<td class="text-center"><?php echo round($per_cen, 2); ?>%</td>
											<?php }else{ ?>
												<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">-</td>
											<?php } ?>
										</tr>
									<?php }
								}
								foreach ($pos_back as $keypos_back => $valuepos_back) { 	

									// $criteria = new CDbCriteria;
									// $criteria->compare('position_id',$valuepos_back->id);
									// $criteria->compare('department_id',$valuepos_back->Departments->id);
									// if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									// 	$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
									// }
									// $criteria->compare('superuser',0);
									// $criteria->compare('del_status',0);
									// if($status != null){
									// 	$criteria->compare('status',$status);		
									// }
									// $users = Users::model()->findAll($criteria);

									// $criteria = new CDbCriteria;
									// $criteria->select = 'id';

									// if($data['TypeEmployee']){
									// 	$criteria->compare('type_employee',$data['TypeEmployee']);
									// }
									// if($data['Department']){
									// 	$criteria->compare('department_id',$data['Department']);
									// }
									// if ($authority == 2 || $authority == 3) {
									// 	$criteria->compare('department_id',$user_Department);
									// }
									// if ($data['Position'] != "") {
									// 		if($data['Position']){
									// 				$criteria->compare('position_id',$data['Position']);
									// 			}
									// 		}else{
									// 			if ($authority == 2 || $authority == 3) {
									// 				$criteria->compare('position_id',$user_Position);
									// 			}
									// 		}
									// 		if($data['Leval'] != ""){
									// 		if($data['Leval']){
									// 			$criteria->compare('branch_id',$data['Leval']);
									// 		}
									// 		}else{
									// 			if ($authority == 3) {
									// 				$criteria->compare('branch_id',$user_Level);
									// 			}
									// 		}
									// $criteria->compare('superuser',0);
									// $criteria->compare('del_status',0);
									// $usersAll = Users::model()->findAll($criteria);

									// $cou_use = count($users);
									// $cou_useAll = count($usersAll);
									// $per_cen = ($cou_use / $cou_useAll) * 100; 
									$criteria = new CDbCriteria;
										$criteria->compare('position_id',$valuepos_back->id);
										$criteria->compare('department_id',$valuepos_back->Departments->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										
										if ($status != null) {

											if ($status == "1") {
												$criteria->compare('register_status',1);
												$criteria->compare('status',1);
											}
											if($status == "0"){
												if ($status != "1") {
													$criteria->compare('register_status',0);
													$criteria->compare('status',1);
												}else{
													$criteria->compare('register_status',0);
													$criteria->compare('status',0);
												} 
												
											}
										}

										$users = Users::model()->findAll($criteria);
									
										$criteria = new CDbCriteria;
										$criteria->compare('position_id',$valuepos_back->id);
										$criteria->compare('department_id',$valuepos_back->Departments->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										$criteria->compare('status',array(0,1));
										$criteria->compare('register_status',array(0,1));
										$criteria->compare('superuser',0);
										$usersAll = Users::model()->findAll($criteria);

										$cou_use = count($users);
										$cou_useAll = count($usersAll);
										$SUM_user[] = $cou_useAll;
										$per_cen = ($cou_use * 100)/ $cou_useAll;
									?>

									<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
										<td><?php echo $i++;?></td>
										<td><?php echo $valuepos_back->Departments->dep_title;?></td>
										<td><?php echo $valuepos_back->position_title;?></td>
										<?php if($data['TypeEmployee'] != 1) { ?>
											<td></td>
										<?php } ?>
										<td class="text-center"><?php echo $cou_use; ?></td>
										<?php if($data['TypeEmployee'] != 2){ ?>
											<td class="text-center"><?php echo $cou_useAll ?></td>
										<?php if (Yii::app()->session['lang'] == 1) {
										 ?>		
											<td class="text-center">
												<?php	if($cou_use > 0){
													if ($status == 1) { ?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;Approve</span>
														<?php }else{ ?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Disapproval</span>
														<?php }
													}else{
														echo "-";
													} ?>
												</td>
											<?php }else{ ?>
												<td class="text-center">
												<?php	if($cou_use > 0){
													if ($status == 1) {?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>
														<?php }else{ ?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>
														<?php }
													}else{
														echo "-";
													} ?>
												</td>
											<?php } ?>
												<?php
											}
										if($cou_use > 0){ ?>
											<td class="text-center"><?php echo round($per_cen, 2) ?>%</td>
										<?php }else{ ?>
											<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">-</td>
										<?php } ?>
									</tr>

								<?php }  
								if ($data['TypeEmployee'] != 2) { ?>
										<tr style="border:2px solid #8B8386;">
											<td class="text-center"><span style="font-weight:bold;"><?php echo Yii::app()->session['lang'] == 1?"Total":"รวม"; ?></span></td>
											<td></td>
											<td></td>
											<td></td>
											<td class="text-center"><span style="font-weight:bold;"><?php echo array_sum($SUM_user)?></span></td>
											<td></td>
											<td></td>
										</tr>
								<?php	}

								foreach ($dep_back as $keydep_back => $valuedep_back) { 

									// $criteria = new CDbCriteria;
									// $criteria->compare('department_id',$valuedep_back->id);
									// if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									// 	$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
									// }
									// $criteria->compare('superuser',0);
									// $criteria->compare('del_status',0);
									// if($status != null){
									// 	$criteria->compare('status',$status);		
									// }
									// $users = Users::model()->findAll($criteria);

									// $criteria = new CDbCriteria;
									// $criteria->select = 'id';

									// if($data['TypeEmployee']){
									// 	$criteria->compare('type_employee',$data['TypeEmployee']);
									// }
									// if($data['Department']){
									// 	$criteria->compare('department_id',$data['Department']);
									// }
									// if ($authority == 2 || $authority == 3) {
									// 	$criteria->compare('department_id',$user_Department);
									// }
									// if ($data['Position'] != "") {
									// 		if($data['Position']){
									// 				$criteria->compare('position_id',$data['Position']);
									// 			}
									// 		}else{
									// 			if ($authority == 2 || $authority == 3) {
									// 				$criteria->compare('position_id',$user_Position);
									// 			}
									// 		}
									// 		if($data['Leval'] != ""){
									// 		if($data['Leval']){
									// 			$criteria->compare('branch_id',$data['Leval']);
									// 		}
									// 		}else{
									// 			if ($authority == 3) {
									// 				$criteria->compare('branch_id',$user_Level);
									// 			}
									// 		}
									// $criteria->compare('superuser',0);
									// $criteria->compare('del_status',0);
									// $usersAll = Users::model()->findAll($criteria);

									// $cou_use = count($users);
									// $cou_useAll = count($usersAll);
									// $per_cen = ($cou_use / $cou_useAll) * 100; 
									$criteria = new CDbCriteria;
										$criteria->compare('department_id',$valuedep_back->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										$criteria->compare('status',1);
										$criteria->compare('register_status',1);
										$users = Users::model()->findAll($criteria);

										 $criteria = new CDbCriteria;
										 $criteria->compare('department_id',$valuedep_back->id);
										if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

											$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
										}
										$criteria->compare('superuser',0);
										$criteria->compare('del_status',0);
										$criteria->compare('register_status',1);
										$usersAll = Users::model()->findAll($criteria);

										$cou_use = count($users);
										$cou_useAll = count($usersAll);
										$per_cen = ($cou_useAll * 100)/ $cou_use;

									?>
									<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
										<td><?php echo $i++;?></td>
										<td><?php echo $valuedep_back->dep_title; ?></td>
										<td class="text-center">-</td>
										<?php
											if ($Leval != "") {
										?>
										<td class="text-center">-</td>
										<?php
										}
										?>
										<td class="text-center"><?php echo $cou_use; ?></td>
										<?php if($data['TypeEmployee'] != 2){ ?>
										<?php if (Yii::app()->session['lang'] == 1) {
										 ?>		
											<td class="text-center">
												<?php	if($cou_use > 0){
													if ($status == 1) {?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;Approve</span>
														<?php }else { ?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;Disapproval</span>
														<?php }
													}else{
														echo "-";
													} ?>
												</td>
											<?php }else{ ?>
												<td class="text-center">
												<?php	if($cou_use > 0){
													if ($status == 1) {?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>
														<?php }else{ ?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>
														<?php }
													}else{
														echo "-";
													} ?>
												</td>
											<?php } ?>
												<?php
											}
											if($cou_use > 0){ ?>
												<td class="text-center"><?php echo round($per_cen, 2);?>%</td>
											<?php }else{ ?>
												<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">-</td>
											<?php } ?>
										</tr>

									<?php } ?> 

								</tbody>
							</table>
						</div>
					</div>

				<?php }else{ ?>
					<p>ไม่พบข้อมูล</p>
				<?php }
			} 
		}
			?>
		</body>
		</html>

