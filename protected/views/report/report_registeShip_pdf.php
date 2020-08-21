<?php 
$age = $data['age'];
$age2 = $data['age2'];
$datetime_start = $data['datetime_start'];
$datetime_end = $data['datetime_end'];
$status = $data['status'];
$Year_start = $data['Year_start'];
$Year_end = $data['Year_end'];
$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
$Chart = $data['Chart'];

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="row">
		<div class="col-sm-12">
			<?php if ($Chart === "accommodation=Bar_Graph") { ?>
				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint.png"; ?>" width="500" height="auto">
			<?php }else if($Chart === "accommodation=Pie_Charts"){ ?>
				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint1.png"; ?>" width="500" height="auto"> 
			<?php } ?>
		</div><br>
	</div>
	<?php
	if ($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") { ?>
		<div class="row">
			<div class="col-sm-12">
				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint.png"; ?>" width="500" height="auto">
				<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint1.png"; ?>" width="500" height="auto">
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
					<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint3.png"; ?>" width="500" height="auto">
					<img src="<?= Yii::app()->basePath."/../uploads/AttendPrint4.png"; ?>" width="500" height="auto">
				</div><br>
			</div>
			<?php
		}
		$l = 20;
		for ($i=0; $i <= $l ; $i++) { 
			echo "<br>";
		}
	}

	$criteria = new CDbCriteria;
	$criteria->compare('type_employee_id',1);
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
	$criteria->compare('department_id',$dep_arr);
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
	$result_pos_arr = array_unique( $pos_arr );
	$result_dep_arr = array_unique( $posback_arr );

	$criteria = new CDbCriteria;
	$criteria->with = array('profile');
	$criteria->compare('department_id',$result_dep_arr);
	$criteria->compare('superuser',0);
	if ($age != null && $age2 != null || $age != "" && $age2 != "") {
		$criteria->addBetweenCondition('age', $age, $age2, 'AND');
	}
	if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {
		$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
	}
	if($Position){
		$criteria->compare('position_id',$Position);
	}else{
		$criteria->compare('position_id',$result_pos_arr);	
	}
	$User = User::model()->findAll($criteria);
 if ($Year_start == "" && $Year_end) {
 
	if (!empty($User)) { ?>
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
			$i = 1;
			?>
		</h2>
		<div class="report-table">
			<div class="table-responsive w-100 t-regis-language">
				<table class="table" style="border:1px solid #d8d8d8;border-collapse: collapse;width: 90%;">       
					<thead>
						<tr style="background: #010C65;color: #fff; border:1px solid #d8d8d8;padding: 8px;">
							<th style="border:1px solid #d8d8d8; padding: 8px;">ลำดับ</th>
							<th style="border:1px solid #d8d8d8; padding: 8px;">ชื่อ - สกุล</th>
							<th style="border:1px solid #d8d8d8; padding: 8px;">ฝ่าย</th>
							<th style="border:1px solid #d8d8d8; padding: 8px;">แผนก</th>
							<th style="border:1px solid #d8d8d8; padding: 8px;">อายุ</th>
							<th style="border:1px solid #d8d8d8; padding: 8px;">สถานะอนุมัติ</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($User as $keypos_back => $valuepos_back) { ?>	

							<tr class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
								<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $i++; ?></td>
								<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $valuepos_back->profile->firstname; ?> <?php echo $valuepos_back->profile->lastname; ?></td>
								<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $valuepos_back->department->dep_title; ?></td>
								<td style="border:1px solid #d8d8d8; padding: 8px;"><?php echo $valuepos_back->position->position_title; ?></td>
								<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
									<?php
									if ($valuepos_back->profile->age) { 
										echo $valuepos_back->profile->age;
									}else{ 
										echo "-";
									}
									?>
								</td>
								<td class="text-center" style="border:1px solid #d8d8d8; padding: 8px;">
									<?php if ($valuepos_back->status == 1) { ?>
										<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>
									<?php }else{ ?>
										<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>
									<?php } ?>
								</td>
							</tr>

						<?php }  ?>

					</tbody>
				</table>
			</div>
		</div>
	<?php }
	}
	 ?>

</body>
</html>