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
$Year_start = $data['Year_start'] != ""?$data['Year_start']:date('Y')-1;
$Year_end = $data['Year_end']!= ""?$data['Year_end']:date('Y');
$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
$Chart = $data['Chart'];
  // exit();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="row">
		<div class="col-sm-12">
			<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint.png"; ?>">
			<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint1.png"; ?>"> 
		</div><br>
	</div>
	<?php
	if ($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
	$f = 20;
	for ($p=0; $p <= $f ; $p++) { 
		echo "<br>";
	}
	?>
	<div class="row">
		<div class="col-sm-12">
		<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint3.png"; ?>">
		<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint4.png"; ?>">
		</div><br>
	</div>
	<?php
	}
	$l = 20;
	for ($i=0; $i <= $l ; $i++) { 
		echo "<br>";
	}
	$criteria = new CDbCriteria;
	$criteria->compare('type_employee_id',$data['TypeEmployee']);
	if($data['Department']){
		$criteria->compare('id',$data['Department']);
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
	if($data['Position']){
		$criteria->compare('id',$data['Position']);
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
	if($data['Leval']){
		$criteria->compare('id',$data['Leval']);
	}
	$branch = Branch::model()->findAll($criteria);


	$branch_arr = [];
	foreach ($branch as $key => $val_branch) {
		$branch_arr[] = $val_branch->position_id;
	}
	$result_branch_arr = array_unique( $branch_arr );
	$result_pos_arr = array_unique( $posback_arr );

	$criteria = new CDbCriteria;
	$criteria->addIncondition('department_id',$dep_arr);
	if($data['Position']){
		$criteria->compare('id',$data['Position']);
	}
	$criteria->addNotInCondition('id',$result_branch_arr);
	$criteria->compare('active','y');
	$pos_back = Position::model()->findAll($criteria);

	$criteria = new CDbCriteria;
	$criteria->compare('type_employee_id',$data['TypeEmployee']);
	if($data['Department']){
		$criteria->compare('id',$data['Department']);
	}
	$criteria->addNotInCondition('id',$result_pos_arr);
	$criteria->compare('active','y');
	$dep_back = Department::model()->findAll($criteria);


	if($_POST['Year_start'] != "" && $_POST['Year_end'] != "" || $data['Department'] != "" || $data['Position'] != ""){
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
			<h2 class="text-center">
				<?php
				if (Yii::app()->session['lang'] == 1) {
					echo "Report";
				} else {
					echo "รายงานภาพ";
				}
				?>
			</h2>
			<?php
			$i = 1;?>
		
			<div class="report-table">
				<div class="table-responsive w-100 t-regis-language">
					<table class="table" style="border:1px solid #d8d8d8;border-collapse: collapse;width: 90%;">     
						<thead>
							<tr style="background: #010C65;color: #fff; border:1px solid #d8d8d8;padding: 8px;">
								<th style="border:1px solid #d8d8d8; padding: 8px;">ลำดับ</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">ฝ่าย</th>
								<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>
								<?php if($data['TypeEmployee'] != 1){ ?>
									<th>เลเวล</th>
								<?php } ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">จำนวน</th>
								<?php if($data['TypeEmployee'] != 2){ ?>
									<th style="border:1px solid #d8d8d8; padding: 8px;">สถานะอนุมัติ</th>
								<?php } ?>
								<th style="border:1px solid #d8d8d8; padding: 8px;">คิดเป็นร้อยละ</th>
							</tr> 
						</thead>
						<tbody>
							<?php if ($data['TypeEmployee'] == 2) {    
								foreach ($branch as $key => $value) { 	

									$criteria = new CDbCriteria;
									$criteria->compare('branch_id',$value->id);
									$criteria->compare('position_id',$value->Positions->id);
									$criteria->compare('department_id',$value->Positions->Departments->id);
									if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

										$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
									}
									$criteria->compare('superuser',0);
									if($status != null){
										$criteria->compare('status',$status);		
									}
									$users = Users::model()->findAll($criteria);

									$criteria = new CDbCriteria;
									$criteria->select = 'id';

									if($data['TypeEmployee']){
										$criteria->compare('type_employee',$data['TypeEmployee']);
									}
									if($data['Department']){
										$criteria->compare('department_id',$data['Department']);
									}
									if($data['Position']){
										$criteria->compare('position_id',$data['Position']);
									}
									if($data['Leval']){
										$criteria->compare('branch_id',$data['Leval']);
									}
									$criteria->compare('superuser',0);
									$usersAll = Users::model()->findAll($criteria);

									$cou_use = count($users);

									$cou_useAll = count($usersAll);
									$per_cen = ($cou_use / $cou_useAll) * 100; ?>
									<tr style="border:1px solid #d8d8d8; padding: 8px;">
										<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $i++;?></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $value->Positions->Departments->dep_title;?></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $value->Positions->position_title;?></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $value->branch_name;?></td>
										<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $cou_use;?></td>
										<?php if($data['TypeEmployee'] != 2){ ?>		
											<td class="text-center">
												<?php	if($cou_use > 0){
													if ($status == 1) {?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>
														<?php}else{?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>
														<?php }
													} ?>
												</td>
												<?php
											}
											if($cou_use > 0){ ?>
												<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo round($per_cen, 2); ?>%</td>
											<?php }else{ ?>
												<td style="border:1px solid #d8d8d8; padding: 8px;"></td>
											<?php } ?>
										</tr>
									<?php }
								}
								foreach ($pos_back as $keypos_back => $valuepos_back) { 	

									$criteria = new CDbCriteria;
									$criteria->compare('position_id',$valuepos_back->id);
									$criteria->compare('department_id',$valuepos_back->Departments->id);
									if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

										$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
									}
									$criteria->compare('superuser',0);
									if($status != null){
										$criteria->compare('status',$status);		
									}
									$users = Users::model()->findAll($criteria);

									$criteria = new CDbCriteria;
									$criteria->select = 'id';

									if($data['TypeEmployee']){
										$criteria->compare('type_employee',$data['TypeEmployee']);
									}
									if($data['Department']){
										$criteria->compare('department_id',$data['Department']);
									}
									if($data['Position']){
										$criteria->compare('position_id',$data['Position']);
									}
									if($data['Leval']){
										$criteria->compare('branch_id',$data['Leval']);
									}
									$criteria->compare('superuser',0);
									$usersAll = Users::model()->findAll($criteria);

									$cou_use = count($users);
									$cou_useAll = count($usersAll);
									$per_cen = ($cou_use / $cou_useAll) * 100; ?>

									<tr style="border:1px solid #d8d8d8; padding: 8px;">
										<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $i++;?></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $valuepos_back->Departments->dep_title;?></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $valuepos_back->position_title;?></td>
										<?php if($data['TypeEmployee'] != 1) { ?>
											<td style="border:1px solid #d8d8d8; padding: 8px;"></td>
										<?php } ?>
										<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $cou_use; ?></td>
										<?php if($data['TypeEmployee'] != 2){ ?>
											<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
												<?php if($cou_use > 0){
													if ($status == 1) { ?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>
													<?php }else{ ?>
														<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>
													<?php }
												} ?>
											</td>
										<?php }	
										if($cou_use > 0){ ?>
											<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo round($per_cen, 2) ?>%</td>
										<?php }else{ ?>
											<td style="border:1px solid #d8d8d8; padding: 8px;"></td>
										<?php } ?>
									</tr>

								<?php }  

								foreach ($dep_back as $keydep_back => $valuedep_back) { 

									$criteria = new CDbCriteria;
									$criteria->compare('department_id',$valuedep_back->id);
									if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

										$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
									}
									$criteria->compare('superuser',0);
									if($status != null){
										$criteria->compare('status',$status);		
									}
									$users = Users::model()->findAll($criteria);

									$criteria = new CDbCriteria;
									$criteria->select = 'id';

									if($data['TypeEmployee']){
										$criteria->compare('type_employee',$data['TypeEmployee']);
									}
									if($data['Department']){
										$criteria->compare('department_id',$data['Department']);
									}
									if($data['Position']){
										$criteria->compare('position_id',$data['Position']);
									}
									if($data['Leval']){
										$criteria->compare('branch_id',$data['Leval']);
									}
									$criteria->compare('superuser',0);
									$usersAll = Users::model()->findAll($criteria);

									$cou_use = count($users);
									$cou_useAll = count($usersAll);
									$per_cen = ($cou_use / $cou_useAll) * 100; ?>

									<tr>
										<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $i++;?></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $valuedep_back->dep_title; ?></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"></td>
										<td style="border:1px solid #d8d8d8; padding: 8px;"></td>
										<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $cou_use; ?></td>
										<?php if($data['TypeEmployee'] != 2){ ?>
											<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
												<?php if($cou_use > 0){
													if ($status == 1) { ?>
														<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>
														<?php}else{?>
															<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>
														<?php }
													} ?>
												</td>
											<?php }
											if($cou_use > 0){ ?>
												<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;"><?php echo round($per_cen, 2);?>%</td>
											<?php }else{ ?>
												<td style="border:1px solid #d8d8d8; padding: 8px;"></td>
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
			} ?>
		</body>
		</html>
