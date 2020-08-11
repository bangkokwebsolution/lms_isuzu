<?php

class ReportController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionReport_register()
	{
		$this->render('report_register');
	}

	public function actionDetail()
	{
		$this->render('detail');
	}
	public function actionRegistership()
	{
		$this->render('registership');
	}

	
	public function actionRegisterShipData()
	{
		
		$Department = $_GET['Department'];
		$Position = $_GET['Position'];
		$age = $_GET['age'];
		$institution = $_GET['institution'];
		$datetime_start = $_GET['datetime_start'];
		$datetime_end = $_GET['datetime_end'];
		$Year_start = $_GET['Year_start'] != ""?$_GET['Year_start']:date('Y')-1;
		$Year_end = $_GET['Year_end']!= ""?$_GET['Year_end']:date('Y');
		$Chart = $_GET['Chart'];
		$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
		$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
		if ($Department) {

			$criteria = new CDbCriteria;
			$criteria->compare('department_id',$dep_arr);
			$criteria->compare('type_employee_id','1');
			if($Position){
				$criteria->compare('id',$Position);
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
			if($age){
				$criteria->compare('id',$age);
			}
			$profiles = profiles::model()->findAll($criteria);

			$profiles_arr = [];
			foreach ($profiles as $key => $val_pro) {
				$profiles_arr[] = $val_profile->position_id;
			}
			// $result_profiles_arr = array_unique( $profiles_arr );
			// $result_pos_arr = array_unique( $posback_arr );

			$criteria = new CDbCriteria;
			$criteria->addIncondition('department_id',$dep_arr);
			if($Position){
				$criteria->compare('id',$Position);
			}
			$criteria->addNotInCondition('id',$result_branch_arr);
			$criteria->compare('active','y');
			$pos_back = Position::model()->findAll($criteria);

			$criteria = new CDbCriteria;
			$criteria->compare('type_employee_id',$TypeEmployee);
			if($Department){
				$criteria->compare('id',$Department);
			}
			$criteria->addNotInCondition('id',$result_pos_arr);
			$criteria->compare('active','y');
			$dep_back = Department::model()->findAll($criteria);

			if ($TypeEmployee == '1') {

				if ($Year_start != null) {
					$datas = '["Element", "Position", { role: "style" } ],';
				// $colorName = Helpers::lib()->ColorCode();	
				// foreach ($colorName as $keyColor => $valueColor) {
				// 	$co = $valueColor;
				// 	} 
			// $name_title_start = "'แผนภูมิแสดงกราฟเปรียบเทียบการสมัครสมาชิกของแต่ละตำแหน่งในปี'";
					foreach ($pos_back as $key => $value) {

						$name_pos = $value->position_title;

						$criteria = new CDbCriteria;
						$criteria->compare('position_id',$value->id);
						$criteria->compare('department_id',$value->Departments->id);
						$criteria->compare('superuser',0);
						$criteria->compare('YEAR(create_at)', $Year_start);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						if($status != null){
							$criteria->compare('status',$status);		
						}
						$users_count= Users::model()->findAll($criteria);
						$count_pos = count($users_count);

						$datas .= '["'.$name_pos.'",'.$count_pos.',"'.$co.'"],';

					}
				}
				// $Year_end = '2020';

				if ($Year_end != null) {
					$data_year_end = '["Element", "Position", { role: "style" } ],';
					// $colorName = Helpers::lib()->ColorCode();	
					// foreach ($colorName as $keyColor => $valueColor) {
					// 	$co = $valueColor;
					// 	} 
	                //$name_title_end = "'แผนภูมิแสดงกราฟเปรียบเทียบการสมัครสมาชิกของแต่ละตำแหน่งในปี '";
					foreach ($pos_back as $key => $value) {

						$name_pos = $value->position_title;

						$criteria = new CDbCriteria;
						$criteria->compare('position_id',$value->id);
						$criteria->compare('department_id',$value->Departments->id);
						$criteria->compare('superuser',0);
						$criteria->compare('YEAR(create_at)', $Year_end);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						if($status != null){
							$criteria->compare('status',$status);		
						}
						$users_count= Users::model()->findAll($criteria);
						$count_pos = count($users_count);

						$data_year_end .= '["'.$name_pos.'",'.$count_pos.',"'.$co.'"],';

					}
				}
			}else if($TypeEmployee == '2'){
				// $Year_start = '2019';
				// $Year_end = '2020';

				if ($Year_start != null) {
					$datas = '["Element", "Division", { role: "style" } ],';
					foreach ($branch as $key => $value) { 	
						$name_dep[] = $value->Positions->Departments->id;
						$names_dep[] = $value->Positions->Departments->dep_title;

					}
					foreach ($dep_back as $keydep_back => $valuedep_back) { 
						$name_dep_not[] = $valuedep_back->id;
						$names_dep_not[] = $valuedep_back->dep_title;
					}
					$result_dep_in = array_unique( $name_dep );
					$result_dep_not = array_unique( $name_dep_not );

					$result_dep_in_name = array_unique( $names_dep );
					$result_dep_not_name = array_unique( $names_dep_not );

					foreach ($result_dep_not_name as $key => $value) {
						array_push($result_dep_in_name,$value);
					}
					foreach ($result_dep_not as $key => $value) {
						array_push($result_dep_in,$value);
					}

					foreach ($result_dep_in as $key => $value) {		
						$criteria = new CDbCriteria;
						$criteria->with = array('department');
						$criteria->compare('department_id',$value);
						$criteria->compare('YEAR(create_at)', $Year_start);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						$criteria->compare('superuser',0);

						$users_count = Users::model()->findAll($criteria);
						$count_dep = count($users_count);

						$datas .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$co.'"],';

					}

				}
				if($Year_end != null){


					$data_year_end = '["Element", "Division", { role: "style" } ],';
					foreach ($branch as $key => $value) { 	
						$name_dep[] = $value->Positions->Departments->id;
						$names_dep[] = $value->Positions->Departments->dep_title;

					}
					foreach ($dep_back as $keydep_back => $valuedep_back) { 
						$name_dep_not[] = $valuedep_back->id;
						$names_dep_not[] = $valuedep_back->dep_title;
					}
					$result_dep_in = array_unique( $name_dep );
					$result_dep_not = array_unique( $name_dep_not );

					$result_dep_in_name = array_unique( $names_dep );
					$result_dep_not_name = array_unique( $names_dep_not );

					foreach ($result_dep_not_name as $key => $value) {
						array_push($result_dep_in_name,$value);
					}
					foreach ($result_dep_not as $key => $value) {
						array_push($result_dep_in,$value);
					}

					foreach ($result_dep_in as $key => $value) {		
						$criteria = new CDbCriteria;
						$criteria->with = array('department');
						$criteria->compare('department_id',$value);
						$criteria->compare('YEAR(create_at)', $Year_end);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						$criteria->compare('superuser',0);

						$users_count = Users::model()->findAll($criteria);
						$count_dep = count($users_count);

						$data_year_end .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$co.'"],';

					}

				}
			}

			if ($Chart == "Bar Graph") {
				?>
				<script>
					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([

							<?=$datas?>    

							]);

						var view = new google.visualization.DataView(data);
						view.setColumns([0, 1,
							{ calc: "stringify",
							sourceColumn: 1,
							type: "string",
							role: "annotation" },
							2]);

						var options = {
							title: <?=$Year_start?>,
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						};
						var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
						 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
						chart.draw(view, options);
					}

				</script>
				<script>

					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([
							<?=$data_year_end?>


							]);

						var view = new google.visualization.DataView(data);
						view.setColumns([0, 1,
							{ calc: "stringify",
							sourceColumn: 1,
							type: "string",
							role: "annotation" },
							2]);

						var options = {
							title: <?=$Year_end?>,
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						};
						var chart = new google.visualization.ColumnChart(document.getElementById("chart_div2"));
						 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint1',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
						chart.draw(view, options);
					}
				</script>
				<?php
			}else if ($Chart == "Pie Charts") {

				?>
				<script>
					google.charts.load("current", {packages:["corechart"]});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([

							<?=$datas?>

							]);
						if (data) {}
							var options = {
								title: <?=$Year_start?>,
								sliceVisibilityThreshold:0,
								pieSliceText:'value',
								is3D: true,
							};

							var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
							 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint3',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
							chart.draw(data, options);
						}
					</script>
					<script>
						google.charts.load("current", {packages:["corechart"]});
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								<?=$data_year_end?>
								]);

							var options = {
								title: <?=$Year_end?>,
								sliceVisibilityThreshold:0,
								pieSliceText:'value',
								is3D: true,
							};

							var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
							 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint4',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
							chart.draw(data, options);
						}

					</script>
					<?php
				}
				if ($_GET['Year_start'] != "" && $_GET['Year_end'] != "") {


					if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
						?>
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
                  //if ($status != null) {

						$i = 1;
						$datatable .= '<div class="report-table">';
						$datatable .= '<div class="table-responsive w-100 t-regis-language">';
						$datatable .= '<table class="table">';       
						$datatable .= '<thead>';
						$datatable .= '<tr>';
						$datatable .= '<th>ลำดับ</th>';
						$datatable .= '<th>ฝ่าย</th>';
						$datatable .= '<th>แผนก</th>';
						if($TypeEmployee != 1){
							$datatable .= '<th>เลเวล</th>';
						}
						$datatable .= '<th>จำนวน</th>';
						if($TypeEmployee != 2){
							$datatable .= '<th>สถานะอนุมัติ</th>';
						}
						$datatable .= '<th>คิดเป็นร้อยละ</th>';
						$datatable .= '</tr>'; 
						$datatable .= '</thead>';
						$datatable .= '<tbody>';
						if ($TypeEmployee == 2) {    
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

								if($TypeEmployee){
									$criteria->compare('type_employee',$TypeEmployee);
								}
								if($Department){
									$criteria->compare('department_id',$Department);
								}
								if($Position){
									$criteria->compare('position_id',$Position);
								}
								if($Leval){
									$criteria->compare('branch_id',$Leval);
								}
								$criteria->compare('superuser',0);
								$usersAll = Users::model()->findAll($criteria);

								$cou_use = count($users);

								$cou_useAll = count($usersAll);
								$per_cen = ($cou_use / $cou_useAll) * 100; 
								$datatable .= '<tr>';
								$datatable .= '<td>'.$i++.'</td>';
								$datatable .= '<td>'.$value->Positions->Departments->dep_title.'</td>';
								$datatable .= '<td>'.$value->Positions->position_title.'</td>';
								$datatable .= '<td>'.$value->branch_name.'</td>';
								$datatable .= '<td>'.$cou_use.'</td>';
								if($TypeEmployee != 2){		
									$datatable .= '<td>';
									if($cou_use > 0){
										if ($status == 1) {
											$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
										}else{
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
										}
									}
									$datatable .= '</td>';
								}
								if($cou_use > 0){
									$datatable .= '<td>'.round($per_cen, 2).' %</td>';
								}else{
									$datatable .= '<td></td>';
								}
								$datatable .= '</tr>';
							}
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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuepos_back->Departments->dep_title.'</td>';
							$datatable .= '<td>'.$valuepos_back->position_title.'</td>';
							if($TypeEmployee != 1){
								$datatable .= '<td></td>';
							}
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}	
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuedep_back->dep_title.'</td>';
							$datatable .= '<td></td>';
							$datatable .= '<td></td>';
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

						$datatable .= '</tbody>';
						$datatable .= '</table>';
						$datatable .= '</div>';
						$datatable .= '</div>';


						echo $datatable;
					}else{
						echo "<p>ไม่พบข้อมูล</p>";
					}
				}else if($_GET['Year_start'] != "" && $_GET['Year_end'] != "" || $Department != "" || $Position != ""){
					if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
						?>
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
                  //if ($status != null) {

						$i = 1;
						$datatable .= '<div class="report-table">';
						$datatable .= '<div class="table-responsive w-100 t-regis-language">';
						$datatable .= '<table class="table">';       
						$datatable .= '<thead>';
						$datatable .= '<tr>';
						$datatable .= '<th>ลำดับ</th>';
						$datatable .= '<th>ฝ่าย</th>';
						$datatable .= '<th>แผนก</th>';
						if($TypeEmployee != 1){
							$datatable .= '<th>เลเวล</th>';
						}
						$datatable .= '<th>จำนวน</th>';
						if($TypeEmployee != 2){
							$datatable .= '<th>สถานะอนุมัติ</th>';
						}
						$datatable .= '<th>คิดเป็นร้อยละ</th>';
						$datatable .= '</tr>'; 
						$datatable .= '</thead>';
						$datatable .= '<tbody>';
						if ($TypeEmployee == 2) {    
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

								if($TypeEmployee){
									$criteria->compare('type_employee',$TypeEmployee);
								}
								if($Department){
									$criteria->compare('department_id',$Department);
								}
								if($Position){
									$criteria->compare('position_id',$Position);
								}
								if($Leval){
									$criteria->compare('branch_id',$Leval);
								}
								$criteria->compare('superuser',0);
								$usersAll = Users::model()->findAll($criteria);

								$cou_use = count($users);

								$cou_useAll = count($usersAll);
								$per_cen = ($cou_use / $cou_useAll) * 100; 
								$datatable .= '<tr>';
								$datatable .= '<td>'.$i++.'</td>';
								$datatable .= '<td>'.$value->Positions->Departments->dep_title.'</td>';
								$datatable .= '<td>'.$value->Positions->position_title.'</td>';
								$datatable .= '<td>'.$value->branch_name.'</td>';
								$datatable .= '<td>'.$cou_use.'</td>';
								if($TypeEmployee != 2){		
									$datatable .= '<td>';
									if($cou_use > 0){
										if ($status == 1) {
											$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
										}else{
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
										}
									}
									$datatable .= '</td>';
								}
								if($cou_use > 0){
									$datatable .= '<td>'.round($per_cen, 2).' %</td>';
								}else{
									$datatable .= '<td></td>';
								}
								$datatable .= '</tr>';
							}
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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuepos_back->Departments->dep_title.'</td>';
							$datatable .= '<td>'.$valuepos_back->position_title.'</td>';
							if($TypeEmployee != 1){
								$datatable .= '<td></td>';
							}
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}	
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuedep_back->dep_title.'</td>';
							$datatable .= '<td></td>';
							$datatable .= '<td></td>';
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

						$datatable .= '</tbody>';
						$datatable .= '</table>';
						$datatable .= '</div>';
						$datatable .= '</div>';


						echo $datatable;
					}else{
						echo "<p>ไม่พบข้อมูล</p>";
					}
				}

			}
		}

	public function actionReportRegisterData()
	{

		$TypeEmployee = $_POST['TypeEmployee'];
		$Department = $_POST['Department'];
		$Position = $_POST['Position'];
		$Leval = $_POST['Leval'];
		$datetime_start = $_POST['datetime_start'];
		$datetime_end = $_POST['datetime_end'];
		$status = $_POST['status'];
		$Year_start = $_POST['Year_start'] != ""?$_POST['Year_start']:date('Y')-1;
		$Year_end = $_POST['Year_end']!= ""?$_POST['Year_end']:date('Y');
		$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
		$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
		$Chart = $_POST['Chart'];

		if ($TypeEmployee) {
			
			$criteria = new CDbCriteria;
			$criteria->compare('type_employee_id',$TypeEmployee);
			if($Department){
				$criteria->compare('id',$Department);
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
			if($Position){
				$criteria->compare('id',$Position);
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
			if($Leval){
				$criteria->compare('id',$Leval);
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
			if($Position){
				$criteria->compare('id',$Position);
			}
			$criteria->addNotInCondition('id',$result_branch_arr);
			$criteria->compare('active','y');
			$pos_back = Position::model()->findAll($criteria);

			$criteria = new CDbCriteria;
			$criteria->compare('type_employee_id',$TypeEmployee);
			if($Department){
				$criteria->compare('id',$Department);
			}
			$criteria->addNotInCondition('id',$result_pos_arr);
			$criteria->compare('active','y');
			$dep_back = Department::model()->findAll($criteria);

			if ($TypeEmployee == '1') {

				if ($Year_start != null) {
					$datas = '["Element", "Position", { role: "style" } ],';
				$colorName = Helpers::lib()->ColorCode();	
				foreach ($colorName as $keyColor) {
					$color[] = $keyColor;
					} 
			// $name_title_start = "'แผนภูมิแสดงกราฟเปรียบเทียบการสมัครสมาชิกของแต่ละตำแหน่งในปี'";
					foreach ($pos_back as $key => $value) {

						$name_pos = $value->position_title;

						$criteria = new CDbCriteria;
						$criteria->compare('position_id',$value->id);
						$criteria->compare('department_id',$value->Departments->id);
						$criteria->compare('superuser',0);
						$criteria->compare('YEAR(create_at)', $Year_start);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						if($status != null){
							$criteria->compare('status',$status);		
						}
						$users_count= Users::model()->findAll($criteria);
						$count_pos = count($users_count);

						$datas .= '["'.$name_pos.'",'.$count_pos.',"'.$color[$key].'"],';

					}
				}

				if ($Year_end != null) {
					$data_year_end = '["Element", "Position", { role: "style" } ],';
					 $colorName = Helpers::lib()->ColorCode();	
					foreach ($colorName as $keyColor ) {
						$color[] = $keyColor;
						} 
	                //$name_title_end = "'แผนภูมิแสดงกราฟเปรียบเทียบการสมัครสมาชิกของแต่ละตำแหน่งในปี '";
					foreach ($pos_back as $key => $value) {

						$name_pos = $value->position_title;

						$criteria = new CDbCriteria;
						$criteria->compare('position_id',$value->id);
						$criteria->compare('department_id',$value->Departments->id);
						$criteria->compare('superuser',0);
						$criteria->compare('YEAR(create_at)', $Year_end);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						if($status != null){
							$criteria->compare('status',$status);		
						}
						$users_count= Users::model()->findAll($criteria);
						$count_pos = count($users_count);

						$data_year_end .= '["'.$name_pos.'",'.$count_pos.',"'.$color[$key].'"],';

					}
				}
			}else if($TypeEmployee == '2'){

				if ($Year_start != null) {
					$datas = '["Element", "Division", { role: "style" } ],';
					$colorName = Helpers::lib()->ColorCode();	
					foreach ($colorName as $keyColor ) {
						$color[] = $keyColor;
						} 
					foreach ($branch as $key => $value) { 	
						$name_dep[] = $value->Positions->Departments->id;
						$names_dep[] = $value->Positions->Departments->dep_title;

					}
					foreach ($dep_back as $keydep_back => $valuedep_back) { 
						$name_dep_not[] = $valuedep_back->id;
						$names_dep_not[] = $valuedep_back->dep_title;
					}
					$result_dep_in = array_unique( $name_dep );
					$result_dep_not = array_unique( $name_dep_not );

					$result_dep_in_name = array_unique( $names_dep );
					$result_dep_not_name = array_unique( $names_dep_not );

					foreach ($result_dep_not_name as $key => $value) {
						array_push($result_dep_in_name,$value);
					}
					foreach ($result_dep_not as $key => $value) {
						array_push($result_dep_in,$value);
					}

					foreach ($result_dep_in as $key => $value) {		
						$criteria = new CDbCriteria;
						$criteria->with = array('department');
						$criteria->compare('department_id',$value);
						$criteria->compare('YEAR(create_at)', $Year_start);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						$criteria->compare('superuser',0);

						$users_count = Users::model()->findAll($criteria);
						$count_dep = count($users_count);

						$datas .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$color[$key].'"],';

					}

					foreach ($result_dep_not as $key => $value) {		
						$criteria = new CDbCriteria;
						$criteria->with = array('department');
						$criteria->compare('department_id',$value);
						$criteria->compare('YEAR(create_at)', $Year_start);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						$criteria->compare('superuser',0);

						$users_count = Users::model()->findAll($criteria);
						$count_dep = count($users_count);

						$datas .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$color[$key].'"],';

					}
				}
				if($Year_end != null){


					$data_year_end = '["Element", "Division", { role: "style" } ],';
					$colorName = Helpers::lib()->ColorCode();	
					foreach ($colorName as $keyColor ) {
						$color[] = $keyColor;
						} 
					foreach ($branch as $key => $value) { 	
						$name_dep[] = $value->Positions->Departments->id;
						$names_dep[] = $value->Positions->Departments->dep_title;

					}
					foreach ($dep_back as $keydep_back => $valuedep_back) { 
						$name_dep_not[] = $valuedep_back->id;
						$names_dep_not[] = $valuedep_back->dep_title;
					}
					$result_dep_in = array_unique( $name_dep );
					$result_dep_not = array_unique( $name_dep_not );

					$result_dep_in_name = array_unique( $names_dep );
					$result_dep_not_name = array_unique( $names_dep_not );

					foreach ($result_dep_not_name as $key => $value) {
						array_push($result_dep_in_name,$value);
					}
					foreach ($result_dep_not as $key => $value) {
						array_push($result_dep_in,$value);
					}

					foreach ($result_dep_in as $key => $value) {		
						$criteria = new CDbCriteria;
						$criteria->with = array('department');
						$criteria->compare('department_id',$value);
						$criteria->compare('YEAR(create_at)', $Year_end);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						$criteria->compare('superuser',0);

						$users_count = Users::model()->findAll($criteria);
						$count_dep = count($users_count);

						$data_year_end .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$color[$key].'"],';


					}

					foreach ($result_dep_not as $key => $value) {
						$criteria = new CDbCriteria;
						$criteria->with = array('department');
						$criteria->compare('department_id',$value);
						$criteria->compare('YEAR(create_at)', $Year_end);
						if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

							$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
						}
						$criteria->compare('superuser',0);

						$users_count = Users::model()->findAll($criteria);
						$count_dep = count($users_count);

						$data_year_end .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$color[$key].'"],';

					}

				}
			}

			if ($Chart === "accommodation=Bar_Graph") {
				?>
				<script>
					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([

							<?=$datas?>    

							]);

						var view = new google.visualization.DataView(data);
						view.setColumns([0, 1,
							{ calc: "stringify",
							sourceColumn: 1,
							type: "string",
							role: "annotation" },
							2]);

						var options = {
							title: <?=$Year_start?>,
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						};
						var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
						 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
						chart.draw(view, options);
					}

				</script>
				<script>

					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([
							<?=$data_year_end?>


							]);

						var view = new google.visualization.DataView(data);
						view.setColumns([0, 1,
							{ calc: "stringify",
							sourceColumn: 1,
							type: "string",
							role: "annotation" },
							2]);

						var options = {
							title: <?=$Year_end?>,
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						};
						var chart = new google.visualization.ColumnChart(document.getElementById("chart_div2"));
						 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint1',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
						chart.draw(view, options);
					}
				</script>
				<?php
			}else if ($Chart === "accommodation=Pie_Charts") {
				?>
				<script>
					google.charts.load("current", {packages:["corechart"]});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([

							<?=$datas?>

							]);
						if (data) {}
							var options = {
								title: <?=$Year_start?>,
								sliceVisibilityThreshold:0,
								pieSliceText:'value',
								is3D: true,
							};

							var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
							 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint3',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
							chart.draw(data, options);
						}
					</script>
					<script>
						google.charts.load("current", {packages:["corechart"]});
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								<?=$data_year_end?>
								]);

							var options = {
								title: <?=$Year_end?>,
								sliceVisibilityThreshold:0,
								pieSliceText:'value',
								is3D: true,
							};

							var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
							 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint4',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
							chart.draw(data, options);
						}

					</script>
					<?php
				}else if($Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts"){ ?>
					<script>
					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([

							<?=$datas?>    

							]);

						var view = new google.visualization.DataView(data);
						view.setColumns([0, 1,
							{ calc: "stringify",
							sourceColumn: 1,
							type: "string",
							role: "annotation" },
							2]);

						var options = {
							title: <?=$Year_start?>,
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						};
						var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
						 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
						chart.draw(view, options);
					}

				</script>
				<script>

					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([
							<?=$data_year_end?>


							]);

						var view = new google.visualization.DataView(data);
						view.setColumns([0, 1,
							{ calc: "stringify",
							sourceColumn: 1,
							type: "string",
							role: "annotation" },
							2]);

						var options = {
							title: <?=$Year_end?>,
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						};
						var chart = new google.visualization.ColumnChart(document.getElementById("chart_div2"));
						 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint1',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
						chart.draw(view, options);
					}
				</script>
				<script>
					google.charts.load("current", {packages:["corechart"]});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([

							<?=$datas?>

							]);
						if (data) {}
							var options = {
								title: <?=$Year_start?>,
								sliceVisibilityThreshold:0,
								pieSliceText:'value',
								is3D: true,
							};

							var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
							 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint3',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
							chart.draw(data, options);
						}
					</script>
					<script>
						google.charts.load("current", {packages:["corechart"]});
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								<?=$data_year_end?>
								]);

							var options = {
								title: <?=$Year_end?>,
								sliceVisibilityThreshold:0,
								pieSliceText:'value',
								is3D: true,
							};

							var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));
							 google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint4',image_base64:chart.getImageURI()},function(json){
                                    var jsonObj = $.parseJSON( json );
                                });
                            });
							chart.draw(data, options);
						}

					</script>

				<?php }
				if ($_POST['Year_start'] != "" && $_POST['Year_end'] != "") {


					if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
						?>
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
                  //if ($status != null) {

						$i = 1;
						$datatable .= '<div class="report-table">';
						$datatable .= '<div class="table-responsive w-100 t-regis-language">';
						$datatable .= '<table class="table">';       
						$datatable .= '<thead>';
						$datatable .= '<tr>';
						$datatable .= '<th>ลำดับ</th>';
						$datatable .= '<th>ฝ่าย</th>';
						$datatable .= '<th>แผนก</th>';
						if($TypeEmployee != 1){
							$datatable .= '<th>เลเวล</th>';
						}
						$datatable .= '<th>จำนวน</th>';
						if($TypeEmployee != 2){
							$datatable .= '<th>สถานะอนุมัติ</th>';
						}
						$datatable .= '<th>คิดเป็นร้อยละ</th>';
						$datatable .= '</tr>'; 
						$datatable .= '</thead>';
						$datatable .= '<tbody>';
						if ($TypeEmployee == 2) {    
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

								if($TypeEmployee){
									$criteria->compare('type_employee',$TypeEmployee);
								}
								if($Department){
									$criteria->compare('department_id',$Department);
								}
								if($Position){
									$criteria->compare('position_id',$Position);
								}
								if($Leval){
									$criteria->compare('branch_id',$Leval);
								}
								$criteria->compare('superuser',0);
								$usersAll = Users::model()->findAll($criteria);

								$cou_use = count($users);

								$cou_useAll = count($usersAll);
								$per_cen = ($cou_use / $cou_useAll) * 100; 
								$datatable .= '<tr>';
								$datatable .= '<td>'.$i++.'</td>';
								$datatable .= '<td>'.$value->Positions->Departments->dep_title.'</td>';
								$datatable .= '<td>'.$value->Positions->position_title.'</td>';
								$datatable .= '<td>'.$value->branch_name.'</td>';
								$datatable .= '<td>'.$cou_use.'</td>';
								if($TypeEmployee != 2){		
									$datatable .= '<td>';
									if($cou_use > 0){
										if ($status == 1) {
											$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
										}else{
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
										}
									}
									$datatable .= '</td>';
								}
								if($cou_use > 0){
									$datatable .= '<td>'.round($per_cen, 2).' %</td>';
								}else{
									$datatable .= '<td></td>';
								}
								$datatable .= '</tr>';
							}
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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuepos_back->Departments->dep_title.'</td>';
							$datatable .= '<td>'.$valuepos_back->position_title.'</td>';
							if($TypeEmployee != 1){
								$datatable .= '<td></td>';
							}
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}	
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuedep_back->dep_title.'</td>';
							$datatable .= '<td></td>';
							$datatable .= '<td></td>';
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

						$datatable .= '</tbody>';
						$datatable .= '</table>';
						$datatable .= '</div>';
						$datatable .= '</div>';


						echo $datatable;
					}else{
						echo "<p>ไม่พบข้อมูล</p>";
					}
				}else if($_POST['Year_start'] != "" && $_POST['Year_end'] != "" || $Department != "" || $Position != ""){
					if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
						?>
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
                  //if ($status != null) {

						$i = 1;
						$datatable .= '<div class="report-table">';
						$datatable .= '<div class="table-responsive w-100 t-regis-language">';
						$datatable .= '<table class="table">';       
						$datatable .= '<thead>';
						$datatable .= '<tr>';
						$datatable .= '<th>ลำดับ</th>';
						$datatable .= '<th>ฝ่าย</th>';
						$datatable .= '<th>แผนก</th>';
						if($TypeEmployee != 1){
							$datatable .= '<th>เลเวล</th>';
						}
						$datatable .= '<th>จำนวน</th>';
						if($TypeEmployee != 2){
							$datatable .= '<th>สถานะอนุมัติ</th>';
						}
						$datatable .= '<th>คิดเป็นร้อยละ</th>';
						$datatable .= '</tr>'; 
						$datatable .= '</thead>';
						$datatable .= '<tbody>';
						if ($TypeEmployee == 2) {    
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

								if($TypeEmployee){
									$criteria->compare('type_employee',$TypeEmployee);
								}
								if($Department){
									$criteria->compare('department_id',$Department);
								}
								if($Position){
									$criteria->compare('position_id',$Position);
								}
								if($Leval){
									$criteria->compare('branch_id',$Leval);
								}
								$criteria->compare('superuser',0);
								$usersAll = Users::model()->findAll($criteria);

								$cou_use = count($users);

								$cou_useAll = count($usersAll);
								$per_cen = ($cou_use / $cou_useAll) * 100; 
								$datatable .= '<tr>';
								$datatable .= '<td>'.$i++.'</td>';
								$datatable .= '<td>'.$value->Positions->Departments->dep_title.'</td>';
								$datatable .= '<td>'.$value->Positions->position_title.'</td>';
								$datatable .= '<td>'.$value->branch_name.'</td>';
								$datatable .= '<td>'.$cou_use.'</td>';
								if($TypeEmployee != 2){		
									$datatable .= '<td>';
									if($cou_use > 0){
										if ($status == 1) {
											$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
										}else{
											$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
										}
									}
									$datatable .= '</td>';
								}
								if($cou_use > 0){
									$datatable .= '<td>'.round($per_cen, 2).' %</td>';
								}else{
									$datatable .= '<td></td>';
								}
								$datatable .= '</tr>';
							}
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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuepos_back->Departments->dep_title.'</td>';
							$datatable .= '<td>'.$valuepos_back->position_title.'</td>';
							if($TypeEmployee != 1){
								$datatable .= '<td></td>';
							}
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}	
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

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

							if($TypeEmployee){
								$criteria->compare('type_employee',$TypeEmployee);
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if($Position){
								$criteria->compare('position_id',$Position);
							}
							if($Leval){
								$criteria->compare('branch_id',$Leval);
							}
							$criteria->compare('superuser',0);
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

							$datatable .= '<tr>';
							$datatable .= '<td>'.$i++.'</td>';
							$datatable .= '<td>'.$valuedep_back->dep_title.'</td>';
							$datatable .= '<td></td>';
							$datatable .= '<td></td>';
							$datatable .= '<td>'.$cou_use.'</td>';
							if($TypeEmployee != 2){
								$datatable .= '<td>';
								if($cou_use > 0){
									if ($status == 1) {
										$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
									}else{
										$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
									}
								}
								$datatable .= '</td>';
							}
							if($cou_use > 0){
								$datatable .= '<td>'.round($per_cen, 2).' %</td>';
							}else{
								$datatable .= '<td></td>';
							}
							$datatable .= '</tr>';

						}  

						$datatable .= '</tbody>';
						$datatable .= '</table>';
						$datatable .= '</div>';
						$datatable .= '</div>';


						echo $datatable;
					}else{
						echo "<p>ไม่พบข้อมูล</p>";
					}
				}?>
				<div class="pull-left ShowGraph">
            <!-- <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF </button> -->
         <a href="<?= $this->createUrl('report/reportRegisterPDF',array('reportRegisterData[TypeEmployee]'=>$_POST['TypeEmployee'],
        'reportRegisterData[Department]'=>$_POST['Department'],
        'reportRegisterData[Position]'=>$_POST['Position'],
        'reportRegisterData[Leval]'=>$_POST['Leval'],
        'reportRegisterData[Chart]'=>$_POST['Chart'],
        'reportRegisterData[datetime_start]'=>$_POST['datetime_start'],
        'reportRegisterData[datetime_end]'=>$_POST['datetime_end'],
        'reportRegisterData[Year_start]'=>$_POST['Year_start'],
        'reportRegisterData[Year_end]'=>$_POST['Year_end'],
        'reportRegisterData[status]'=>$_POST['status'])); ?>" target="_blank" class="btn btn btn-pdf"><i class="fas fa-file-pdf"></i>Export PDF</a>
          <a href="<?= $this->createUrl('report/reportRegisterExcel',array('reportRegisterData[TypeEmployee]'=>$_POST['TypeEmployee'],
        'reportRegisterData[Department]'=>$_POST['Department'],
        'reportRegisterData[Position]'=>$_POST['Position'],
        'reportRegisterData[Leval]'=>$_POST['Leval'],
        'reportRegisterData[Chart]'=>$_POST['Chart'],
        'reportRegisterData[datetime_start]'=>$_POST['datetime_start'],
        'reportRegisterData[datetime_end]'=>$_POST['datetime_end'],
        'reportRegisterData[Year_start]'=>$_POST['Year_start'],
        'reportRegisterData[Year_end]'=>$_POST['Year_end'],
        'reportRegisterData[status]'=>$_POST['status'])); ?>" target="_blank" class="btn btn btn-excel"><i class="fas fa-file-excel"></i>Export Excel</a>
        </div>
		<?php
			}
		}

		public function actionSaveChart()
		{
			  function base64_to_jpeg($base64_string) {
			        $data = explode(',', $base64_string);

			        return base64_decode($data[1]);
			    }

			    if(isset($_POST)){
			    	
			        $save = file_put_contents(Yii::app()->basePath."/../uploads/".$_POST['name'].".png",base64_to_jpeg($_POST['image_base64']));
			        $array = array('msg'=>'success');
			        echo json_encode($array);
			    }
		}

		public function actionReportRegisterExcel()
		{
			 if ($_GET['reportRegisterData']) {
 				   $data = $_GET['reportRegisterData'];
 				
				$this->renderPartial('report_register_excel',array('data' => $data));
			 }
		}

		public function actionReportRegisterPDF()
		{
			if ($_GET['reportRegisterData']) {
 				   $data = $_GET['reportRegisterData'];
 				
				//$this->renderPartial('report_register_pdf',array('data' => $data));
				require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
			    $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
					    	$texttt= '
		         <style>
		         body { font-family: "garuda"; }
		         </style>
		         ';
		        $mPDF->WriteHTML($texttt);
			    $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('report_register_pdf', array('data'=>$data),true),'UTF-8','UTF-8'));
			    // if($_GET['ReportUser']['course']){
			    //     $mPDF->Output($course->course_title.".pdf" , 'D');

			    // }else{
			        $mPDF->Output("รายงานภาพรวมการสมัคร.pdf" , 'I');

			    //}
			 }
		}

		public function actionListDepartment()
		{
			$criteria= new CDbCriteria;
			$criteria->condition='type_employee_id=:type_employee_id AND active=:active';
			$criteria->params=array(':type_employee_id'=>$_POST['id'],':active'=>'y');
			$criteria->order = 'sortOrder ASC';
			$model = Department::model()->findAll($criteria);
			$sub_list = Yii::app()->session['lang'] == 1?'Select Department ':'เลือกแผนก';
			$data = '<option value ="">'.$sub_list.'</option>';
			foreach ($model as $key => $value) {
				$data .= '<option value = "'.$value->id.'"'.'>'.$value->dep_title.'</option>';
			}
			echo ($data);

		}

		public function actionListPosition()
		{
			$criteria= new CDbCriteria;
			$criteria->condition='department_id=:department_id AND active=:active';
			$criteria->params=array(':department_id'=>$_POST['id'],':active'=>'y');
			$criteria->order = 'sortOrder ASC';
			$model = Position::model()->findAll($criteria);
			if ($model) {
				$sub_list = Yii::app()->session['lang'] == 1?'Select Pocition ':'เลือกตำแหน่ง';
				$data = '<option value ="">'.$sub_list.'</option>';
				foreach ($model as $key => $value) {
					$data .= '<option value = "'.$value->id.'"'.'>'.$value->position_title.'</option>';
				}
				echo ($data);
			}else{
				echo '<option value = "">ไม่พบข้อมูล</option>';

			}
		}

		public function actionListLeval()
		{
			$criteria= new CDbCriteria;
			$criteria->condition='position_id=:position_id AND active=:active';
			$criteria->params=array(':position_id'=>$_POST['id'],':active'=>'y');
			$criteria->order = 'sortOrder ASC';
			$model = Branch::model()->findAll($criteria);
			if ($model) {

				$sub_list = Yii::app()->session['lang'] == 1?'Select Level ':'เลือกระดับ';
				$data = '<option value ="">'.$sub_list.'</option>';
				foreach ($model as $key => $value) {
					$data .= '<option value = "'.$value->id.'"'.'>'.$value->branch_name.'</option>';
				}
				echo ($data); 
			}else{
				echo '<option value = "">ไม่พบข้อมูล</option>';

			}
		}













			public function actionCourse(){ // อบรม
	if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }








	$this->render('course', array(
        // 'model'=>$model,
    ));
}

public function actionCourseCaptain(){ // อบรม คนเรือ
	if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    	$langId = Yii::app()->session['lang'] = 1;
    }else{
    	$langId = Yii::app()->session['lang'];
    }

    //------------------- ค่า form search ------------------------//
    $model_course = CourseOnline::model()->findAll(array(
    	'condition' => 'active=:active AND lang_id=:lang_id',
    	'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
    	'order' => 'course_title ASC'
    ));

    $model_department = Department::model()->findAll(array(
    	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>1), //1=เรือ 2=office
    	'order' => 'dep_title ASC'    	
    ));

    $year_start = LogStartcourse::model()->find(array(
    	'condition' => 'active=:active',
    	'params' => array(':active'=>'y'),
    	'order' => 'id ASC'
    ));
    $year_start = date("Y", strtotime($year_start->start_date));

    $year_end = LogStartcourse::model()->find(array(
    	'condition' => 'active=:active',
    	'params' => array(':active'=>'y'),
    	'order' => 'id DESC'
    ));
    $year_end = date("Y", strtotime($year_end->start_date));

    if($year_end <= $year_start){
    	$year_end = $year_start+1;
    }
    //------------------- ค่า form search ------------------------//

    if(isset($_GET["search"])){
    	// var_dump("<pre>"); 
    	// var_dump($_GET["search"]); 
    	// exit();

    	$criteria = new CDbCriteria;

    	if($_GET["search"]["fullname"] != ""){
    		$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

    		if(isset($ex_fullname[0])){    			
    			$name = $ex_fullname[0];
    			$criteria->compare('pro.firstname', $name, true);
        		$criteria->compare('pro.lastname', $name, true, 'OR');
        		// $criteria->compare('pro.firstname_en', $name, true, 'OR');
        		// $criteria->compare('pro.lastname_en', $name, true, 'OR');
    		}

    		if(isset($ex_fullname[1])){
    			$name = $ex_fullname[1];
    			$criteria->compare('pro.lastname',$name,true, 'OR');
    			// $criteria->compare('pro.lastname_en',$name,true, 'OR');
    		}
    	}

    	$criteria->compare('t.active', 'y');
    	$criteria->compare('course.active', 'y');
    	$criteria->compare('pro.type_employee', 1); //1=เรือ 2=office

    	$criteria->addCondition('user.id IS NOT NULL');
    	$criteria->addCondition('t.course_id IS NOT NULL');

    	if($_GET["search"]["course_id"] != ""){
    		$criteria->compare('t.course_id', $_GET["search"]["course_id"]);
    	}

    	if($_GET["search"]["gen_id"] != ""){
    		$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
    	}

    	if($_GET["search"]["department"] != ""){
    		$criteria->compare('user.department_id', $_GET["search"]["department"]);
    	}

    	if($_GET["search"]["position"] != ""){
    		$criteria->compare('user.position_id', $_GET["search"]["position"]);
    	}

    	$arr_count_course = [];
    	$arr_course_title = [];
    	if($_GET["search"]["start_date"] != "" && $_GET["search"]["end_date"] != ""){
    		if($_GET["search"]["start_date"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_date"]." 00:00:00");
    		}
    		if($_GET["search"]["end_date"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_date"]." 23:59:59");
    		}

    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

			// $criteria->group = 't.course_id';
    		$criteria->order = 't.course_id ASC';
    		$criteria->select ='t.course_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		
    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[$value->course_id] = $arr_count_course[$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}


    	}elseif($_GET["search"]["start_year"] != "" && $_GET["search"]["end_year"] != ""){
    		if($_GET["search"]["start_year"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_year"]."-01-01 00:00:00");
    		}
    		if($_GET["search"]["end_year"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_year"]."-12-31 23:59:59");
    		}

    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		$criteria->order = 'yearrrr ASC';
    		$criteria->select ='t.start_date, t.course_id, YEAR(t.start_date) AS yearrrr';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}

    	}else{
    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

			// $criteria->group = 't.course_id';
    		$criteria->order = 't.course_id ASC';
    		$criteria->select ='t.course_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		
    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[$value->course_id] = $arr_count_course[$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}
    	}
    	

		$this->render('course_captain', array(
	        'model_course'=>$model_course,
	        'model_department'=>$model_department,
	        'year_start'=>$year_start,
	        'year_end'=>$year_end,
	        'model_search'=>$model_search,
	        'arr_count_course'=>$arr_count_course,
	        'arr_course_title'=>$arr_course_title,
	    ));
		exit();
    } // if(isset($_GET["search"]))

	$this->render('course_captain', array(
        'model_course'=>$model_course,
        'model_department'=>$model_department,
        'year_start'=>$year_start,
        'year_end'=>$year_end,
    ));
}

public function actionCourseOffice(){ // อบรม office
	if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    	$langId = Yii::app()->session['lang'] = 1;
    }else{
    	$langId = Yii::app()->session['lang'];
    }

    //------------------- ค่า form search ------------------------//
    $model_course = CourseOnline::model()->findAll(array(
    	'condition' => 'active=:active AND lang_id=:lang_id',
    	'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
    	'order' => 'course_title ASC'
    ));

    $model_department = Department::model()->findAll(array(
    	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>2), //1=เรือ 2=office
    	'order' => 'dep_title ASC'    	
    ));

    $year_start = LogStartcourse::model()->find(array(
    	'condition' => 'active=:active',
    	'params' => array(':active'=>'y'),
    	'order' => 'id ASC'
    ));
    $year_start = date("Y", strtotime($year_start->start_date));

    $year_end = LogStartcourse::model()->find(array(
    	'condition' => 'active=:active',
    	'params' => array(':active'=>'y'),
    	'order' => 'id DESC'
    ));
    $year_end = date("Y", strtotime($year_end->start_date));

    if($year_end <= $year_start){
    	$year_end = $year_start+1;
    }
    //------------------- ค่า form search ------------------------//

    if(isset($_GET["search"])){
    	// var_dump("<pre>"); 
    	// var_dump($_GET["search"]); 
    	// exit();

    	$criteria = new CDbCriteria;

    	if($_GET["search"]["fullname"] != ""){
    		$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

    		if(isset($ex_fullname[0])){    			
    			$name = $ex_fullname[0];
    			$criteria->compare('pro.firstname', $name, true);
        		$criteria->compare('pro.lastname', $name, true, 'OR');
        		// $criteria->compare('pro.firstname_en', $name, true, 'OR');
        		// $criteria->compare('pro.lastname_en', $name, true, 'OR');
    		}

    		if(isset($ex_fullname[1])){
    			$name = $ex_fullname[1];
    			$criteria->compare('pro.lastname',$name,true, 'OR');
    			// $criteria->compare('pro.lastname_en',$name,true, 'OR');
    		}
    	}

    	$criteria->compare('t.active', 'y');
    	$criteria->compare('course.active', 'y');
    	$criteria->compare('pro.type_employee', 2); //1=เรือ 2=office

    	$criteria->addCondition('user.id IS NOT NULL');
    	$criteria->addCondition('t.course_id IS NOT NULL');

    	if($_GET["search"]["course_id"] != ""){
    		$criteria->compare('t.course_id', $_GET["search"]["course_id"]);
    	}

    	if($_GET["search"]["gen_id"] != ""){
    		$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
    	}

    	if($_GET["search"]["department"] != ""){
    		$criteria->compare('user.department_id', $_GET["search"]["department"]);
    	}

    	if($_GET["search"]["position"] != ""){
    		$criteria->compare('user.position_id', $_GET["search"]["position"]);
    	}

    	if($_GET["search"]["level"] != ""){
    		$criteria->compare('user.branch_id', $_GET["search"]["level"]);
    	}

    	$arr_count_course = [];
    	$arr_course_title = [];
    	if($_GET["search"]["start_date"] != "" && $_GET["search"]["end_date"] != ""){
    		if($_GET["search"]["start_date"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_date"]." 00:00:00");
    		}
    		if($_GET["search"]["end_date"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_date"]." 23:59:59");
    		}

    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

			// $criteria->group = 't.course_id';
    		$criteria->order = 't.course_id ASC';
    		$criteria->select ='t.course_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		
    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[$value->course_id] = $arr_count_course[$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}


    	}elseif($_GET["search"]["start_year"] != "" && $_GET["search"]["end_year"] != ""){
    		if($_GET["search"]["start_year"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_year"]."-01-01 00:00:00");
    		}
    		if($_GET["search"]["end_year"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_year"]."-12-31 23:59:59");
    		}

    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		$criteria->order = 'yearrrr ASC';
    		$criteria->select ='t.start_date, t.course_id, YEAR(t.start_date) AS yearrrr';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}

    	}else{
    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

			// $criteria->group = 't.course_id';
    		$criteria->order = 't.course_id ASC';
    		$criteria->select ='t.course_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		
    		foreach ($model_graph as $key => $value) {
    			$arr_count_course[$value->course_id] = $arr_count_course[$value->course_id]+1;
    			$course_model = CourseOnline::model()->findByPk($value->course_id);
    			$arr_course_title[$value->course_id] = $course_model->course_title;
    		}
    	}
    	

		$this->render('course_office', array(
	        'model_course'=>$model_course,
	        'model_department'=>$model_department,
	        'year_start'=>$year_start,
	        'year_end'=>$year_end,
	        'model_search'=>$model_search,
	        'arr_count_course'=>$arr_count_course,
	        'arr_course_title'=>$arr_course_title,
	    ));
		exit();
    } // if(isset($_GET["search"]))

	$this->render('course_office', array(
        'model_course'=>$model_course,
        'model_department'=>$model_department,
        'year_start'=>$year_start,
        'year_end'=>$year_end,
    ));
}

	public function actionGetGenid(){
		if(isset($_POST["course_id"]) && $_POST["course_id"] != ""){
			$model_gen = CourseGeneration::model()->findAll(array(
				'condition' => 'active=:active AND course_id=:course_id',
				'params' => array(':active'=>'y', ':course_id'=>$_POST["course_id"], ),
				'order' => 'gen_title ASC'
			));

			if(!empty($model_gen)){
				?>
				<option value="" selected>เลือกรุ่นของหลักสูตร</option>
				<?php
				foreach ($model_gen as $key => $value) {
					?>
					<option value="<?= $value->gen_id ?>"><?= $value->gen_title ?></option>
					<?php
				}
			}else{
				?>
				<option value="0" selected>ไม่มีรุ่น</option>
				<?php
			}
		}else{
			?>
			<option value="" selected>เลือกรุ่นของหลักสูตร</option>
			<?php
		}
	}

	public function actionGetPosition(){
		if(isset($_POST["department_id"]) && $_POST["department_id"] != ""){
			if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
				$langId = Yii::app()->session['lang'] = 1;
			}else{
				$langId = Yii::app()->session['lang'];
			}

			$model_position = Position::model()->findAll(array(
				'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y', ':department_id'=>$_POST["department_id"], ':lang_id'=>1),
				'order' => 'position_title ASC'
			));

			if(!empty($model_position)){
				?>
				<option value="" selected>เลือกตำแหน่ง</option>
				<?php
				foreach ($model_position as $key => $value) {
					// if(Yii::app()->session['lang'] != 1){
					// 	$value->id = $value->parent_id;
					// }
					?>
					<option value="<?= $value->id ?>"><?= $value->position_title ?></option>
					<?php
				}
			}else{
				?>
				<option value="" selected>ไม่มีตำแหน่ง</option>
				<?php
			}
		}else{
			?>
			<option value="" selected>เลือกตำแหน่ง</option>
			<?php
		}
	}

	public function actionGetLevel(){
		
		if(isset($_POST["position_id"]) && $_POST["position_id"] != ""){
			if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
				$langId = Yii::app()->session['lang'] = 1;
			}else{
				$langId = Yii::app()->session['lang'];
			}
			
			$model_branch = Branch::model()->findAll(array(
				'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y', ':position_id'=>$_POST["position_id"], ':lang_id'=>1),
				'order' => 'branch_name ASC'
			));

			if(!empty($model_branch)){
				?>
				<option value="" selected>เลือกเลเวล</option>
				<?php
				foreach ($model_branch as $key => $value) {
					// if(Yii::app()->session['lang'] != 1){
					// 	$value->id = $value->parent_id;
					// }
					?>
					<option value="<?= $value->id ?>"><?= $value->branch_name ?></option>
					<?php
				}
			}else{
				?>
				<option value="" selected>ไม่มีเลเวล</option>
				<?php
			}
		}else{
			?>
			<option value="" selected>เลือกเลเวล</option>
			<?php
		}
	}

	public function actionSavePicChart(){
		if(isset($_POST['chart']) && $_POST['chart'] != ""){
			$key = $_POST['key'];
			$name_chart = date("YmdHis")."_".$key.".png";
			file_put_contents(Yii::app()->basePath."/../uploads/pic_chart/".$name_chart, base64_decode($_POST['chart']));
			echo $name_chart;
			exit();
		}

	}

	public function actionDelPicChart(){
		// if(isset($_POST['chart']) && !empty($_POST['chart'])){

		// 	foreach ($_POST['chart'] as $key => $value) {
		// 		$files = Yii::app()->basePath."/../uploads/pic_chart/".$value;
		// 		if(is_file($files)){
		// 			unlink($files);					
		// 		}
		// 	}			
		// 	exit();

		// }
	}

	public function actionExportPDF(){

		require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
		$mPDF = new \Mpdf\Mpdf(['format' => 'A4-P']);
		$result = '<style type="text/css"> body { font-family:"thaisansneue"; font-size:20px; } td{ text-align:center; } table{ width:100%; }</style>';
		$result .= urldecode($_POST["text_element1"]);
		$page = mb_convert_encoding($result, 'UTF-8', 'UTF-8');
		$mPDF->WriteHTML($page);
		// $mPDF->Output();
		$mPDF->Output('exportPDF.pdf', 'D');


	}








	

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}