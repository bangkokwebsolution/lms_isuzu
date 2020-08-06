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