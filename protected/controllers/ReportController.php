<?php

class ReportController extends Controller
{
	public function actionIndex()
	{
		if(Yii::app()->user->id != null) {
			$user_login = User::model()->findByPk(Yii::app()->user->id);
			$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
			$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

			$this->render('index', array(
				'authority'=>$authority,
				'type_em'=>$type_em,
			));
		}else{
			$this->redirect(array('site/index'));
			exit();
		}
	}

	public function actionReport_register()
	{
		if(Yii::app()->user->id != null) {
			$user_login = User::model()->findByPk(Yii::app()->user->id);
			$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
			$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
			$Level = $user_login->branch_id;
			$Position = $user_login->position_id;
			$Department = $user_login->department_id;
		$this->render('report_register',array(
				'authority'=>$authority,
				'type_em'=>$type_em,
				'Level' =>$Level,
				'Position'=>$Position,
				'Department'=>$Department
			));
		}else{
			$this->redirect(array('site/index'));
			exit();
		}
	}

	public function actionDetail()
	{
		if(Yii::app()->user->id != null) {
		$this->render('detail');
		}else{
			$this->redirect(array('site/index'));
			exit();
		}
	}
	public function actionRegistership()
	{
		if(Yii::app()->user->id != null) {
			$user_login = User::model()->findByPk(Yii::app()->user->id);
			$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
			$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
			$Level = $user_login->branch_id;
			$Position = $user_login->position_id;
			$Department = $user_login->department_id;
		$this->render('registership',array(
				'authority'=>$authority,
				'type_em'=>$type_em,
				'Level' =>$Level,
				'Position'=>$Position,
				'Department'=>$Department
			));
		}else{
			$this->redirect(array('site/index'));
			exit();
		}
	}

	public function actionRegisteroffice()
	{
		if(Yii::app()->user->id != null) {
			$user_login = User::model()->findByPk(Yii::app()->user->id);
			$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
			$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
			$Level = $user_login->branch_id;
			$Position = $user_login->position_id;
			$Department = $user_login->department_id;
		$this->render('register_office',array(
				'authority'=>$authority,
				'type_em'=>$type_em,
				'Level' =>$Level,
				'Position'=>$Position,
				'Department'=>$Department
			));
		}else{
			$this->redirect(array('site/index'));
			exit();
		}
	}

	public function actionRegisterofficeData()
	{
		$Department = $_POST['Department'];
		$Position = $_POST['Position'];
		$Leval = $_POST['Leval'];
		$datetime_start = $_POST['datetime_start'];
		$datetime_end = $_POST['datetime_end'];
		$Year_start = $_POST['Year_start'];
		$Year_end = $_POST['Year_end'];
		$Chart = $_POST['Chart'];
		$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
		$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";

		if (Yii::app()->user->id != null) {
					$user_login = User::model()->findByPk(Yii::app()->user->id);
					$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
					$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
					$user_Level = $user_login->branch_id;
					$user_Position = $user_login->position_id;
					$user_Department = $user_login->department_id;

					$criteria = new CDbCriteria;
					if($Department){
						$criteria->compare('id',$Department);
					}
					if ($authority == 2 || $authority == 3) {
                                         
                        $criteria->compare('id',$user_Department);
                    }
					$criteria->compare('active','y');
					$criteria->compare('type_employee_id',2);
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
					if ($authority == 3) {
                                         
                        $criteria->compare('id',$user_Position);
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
					if ($Leval != "") {
						if($Leval){
						$criteria->compare('id',$Leval);
						}
					}else{
						if ($authority == 3) {              
                        $criteria->compare('id',$user_Level);
                    	}
					}					
					$branch = Branch::model()->findAll($criteria);

					$branch_arr = [];
					foreach ($branch as $key => $val_branch) {
						$branch_arr[] = $val_branch->position_id;
					}
					$result_branch_arr = array_unique( $branch_arr );
					$result_pos_arr = array_unique( $posback_arr );

					$criteria = new CDbCriteria;
					$criteria->with = array('profile');
					$criteria->compare('department_id',$dep_arr);
					$criteria->compare('superuser',0);
					if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {
						$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
					}
					if($Position){
						$criteria->compare('position_id',$Position);
					}else{
						$criteria->compare('position_id',$pos_arr);	
					}
					if ($Leval != "") {
						if ($Leval) {
							$criteria->compare('branch_id',$Leval);
						}
					}else{
						if ($authority == 3) {
                                         
        				$criteria->compare('branch_id',$user_Level);
    					}
					}
					

					$User = User::model()->findAll($criteria);

					if (isset($pos)) {
						
						$data_division_start = '["Element", "Position", { role: "style" } ],';

						$colorName = Helpers::lib()->ColorCode();	
				
						foreach ($pos as $key => $value) {
							$name_dep = $value->position_title;
							$criteria = new CDbCriteria;
							if($Position){
								$criteria->compare('position_id',$Position);
							}else{
								$criteria->compare('position_id',$value->id);	
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if ($authority == 2 || $authority == 3) {
                                         
                        	$criteria->compare('department_id',$user_Department);
                    		}
							$criteria->compare('superuser',0);
							if ($Year_start != null) {
								$criteria->compare('YEAR(create_at)', $Year_start);
							}
							if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

								$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
							}

							$users_count= Users::model()->findAll($criteria);
							$count_dep = count($users_count);

							$data_division_start .= '["'.$name_dep.'",'.$count_dep.',"'.$colorName[$key].'"],';
							}
						}
						if (empty($pos)) {	
						$data_division_start = '["Element", "Division", { role: "style" } ],';			
							foreach ($dep as $key => $value) {
									$name_dep = $value->dep_title;
								$criteria = new CDbCriteria;
								if($Position){
									$criteria->compare('position_id',$Position);
								}
								if($Department){
									$criteria->compare('department_id',$Department);
								}
								if ($authority == 2 || $authority == 3) {
                                         
                        		$criteria->compare('department_id',$user_Department);
                    			}
								$criteria->compare('superuser',0);
								if ($Year_start != null) {
									$criteria->compare('YEAR(create_at)', $Year_start);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}

								$users_count= Users::model()->findAll($criteria);
								$count_dep = count($users_count);

								$data_division_start .= '["'.$name_dep.'",'.$count_dep.',"'.$colorName[$key].'"],';
							}
						}

						if (isset($pos)) {
						
						$data_division_end = '["Element", "Position", { role: "style" } ],';

						$colorName = Helpers::lib()->ColorCode();	
				
						foreach ($pos as $key => $value) {
							$name_dep = $value->position_title;
							$criteria = new CDbCriteria;
							if($Position){
								$criteria->compare('position_id',$Position);
							}else{
								$criteria->compare('position_id',$value->id);	
							}
							if($Department){
								$criteria->compare('department_id',$Department);
							}
							if ($authority == 2 || $authority == 3) {
                                         
                        		$criteria->compare('department_id',$user_Department);
                    		}
							$criteria->compare('superuser',0);
							if ($Year_end != null) {
								$criteria->compare('YEAR(create_at)', $Year_end);
							}
							if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

								$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
							}

							$users_count= Users::model()->findAll($criteria);
							$count_dep = count($users_count);

							$data_division_end .= '["'.$name_dep.'",'.$count_dep.',"'.$colorName[$key].'"],';
							}
						}
						if (empty($pos)) {	
						$data_division_end = '["Element", "Division", { role: "style" } ],';			
							foreach ($dep as $key => $value) {
									$name_dep = $value->dep_title;
								$criteria = new CDbCriteria;
								if($Position){
									$criteria->compare('position_id',$Position);
								}
								if($Department){
									$criteria->compare('department_id',$Department);
								}
								if ($authority == 2 || $authority == 3) {
                                         
                        			$criteria->compare('department_id',$user_Department);
                    			}
								$criteria->compare('superuser',0);
								if ($Year_end != null) {
									$criteria->compare('YEAR(create_at)', $Year_end);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}

								$users_count= Users::model()->findAll($criteria);
								$count_dep = count($users_count);

								$data_division_end .= '["'.$name_dep.'",'.$count_dep.',"'.$colorName[$key].'"],';
							}
						}
					if ($Chart != "") { 
					if ($_POST['Year_start'] != null || $_POST['Year_end'] != null) {

					if ($Chart === "accommodation=Bar_Graph") { ?>
					<script>
						google.charts.load("current", {packages:['corechart']});
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								<?=$data_division_start?>    
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
								<?=$data_division_end?>
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
					<?php }else if ($Chart === "accommodation=Pie_Charts") {

					?>
					<script>
						google.charts.load("current", {packages:["corechart"]});
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								<?=$data_division_start?>
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
									<?=$data_division_end?>
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
								<?=$data_division_start?>    
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
								<?=$data_division_end?>
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
								<?=$data_division_start?>
								]);
							if (data) {}
								var options = {
									title: <?=$Year_start?>,
									sliceVisibilityThreshold:0,
									pieSliceText:'value',
									//is3D: true,
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
									<?=$data_division_end?>
									]);

								var options = {
									title: <?=$Year_end?>,
									sliceVisibilityThreshold:0,
									pieSliceText:'value',
									//is3D: true,
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

						<?php	
					}

					}else{

						if ($Chart === "accommodation=Bar_Graph" || $Chart === "accommodation=Pie_Charts" || $Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
							
						?>
						<script>
							google.charts.load("current", {packages:['corechart']});
							google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
								var data = google.visualization.arrayToDataTable([
									<?=$data_division_start?>    
									]);

								var view = new google.visualization.DataView(data);
								view.setColumns([0, 1,
									{ calc: "stringify",
									sourceColumn: 1,
									type: "string",
									role: "annotation" },
									2]);

								var options = {
									title: "รายงานภาพคนสมัครสมาชิกคนออฟฟิศ",
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
							google.charts.load("current", {packages:["corechart"]});
							google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
								var data = google.visualization.arrayToDataTable([
									<?=$data_division_start?>
									]);
								if (data) {}
									var options = {
										title: "รายงานภาพคนสมัครสมาชิกคนออฟฟิศ",
										sliceVisibilityThreshold:0,
										pieSliceText:'value',
										//is3D: true,
									};

									var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
									google.visualization.events.addListener(chart, 'ready', function () {
										$.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint1',image_base64:chart.getImageURI()},function(json){
											var jsonObj = $.parseJSON( json );
										});
									});
									chart.draw(data, options);
								}
							</script>

				<?php }
					}
				}
				if($_POST['Year_start'] == "" && $_POST['Year_end'] == ""){
									?>
									<li class="breadcrumb-item active" aria-current="page">
						            <center>
						                <h3>
						                    <?php
						                    if (Yii::app()->session['lang'] == 1) {
						                        echo "Register Staff Office Report";
						                    } else {
						                        echo "รายงานภาพการสมัครสมาชิก คนประจำoffice";
						                    }
						                    ?>
						                </h3>    
						            </center>
						        	</li>
									<?php
    
									$i = 1;
									$datatable .= '<div class="report-table">';
									$datatable .= '<div class="table-responsive w-100 t-regis-language">';
									$datatable .= '<table class="table">';       
									$datatable .= '<thead>';
									$datatable .= '<tr>';
									$datatable .= '<th>ลำดับ</th>';
									$datatable .= '<th>ชื่อ - นามสกุล</th>';
									$datatable .= '<th>ฝ่าย</th>';
									$datatable .= '<th>แผนก</th>';
									$datatable .= '</tr>'; 
									$datatable .= '</thead>';
									$datatable .= '<tbody>';
							if (!empty($User)) {
										foreach ($User as $key => $value) { 	

											$datatable .= '<tr>';
											$datatable .= '<td>'.$i++.'</td>';
											$datatable .= '<td>'.$value->profile->firstname."  ".$value->profile->lastname.'</td>';
											$datatable .= '<td>'.$value->department->dep_title.'</td>';
											$datatable .= '<td>';
											if ($value->position->position_title != "") {
												$datatable .= $value->position->position_title;
											}else{
												$datatable .="-";
											}
											$datatable .= '</td>';										
											$datatable .= '</tr>';
										}			 

									
								}else{
									$datatable .= '<tr>';
									$datatable .= '<td colspan="6">';
	                                    if(Yii::app()->session['lang'] != 1){
	                                        $datatable .= 'ไม่มีข้อมูล';
	                                    }else{
	                                        $datatable .= 'No data';
	                                    }
			                        $datatable .= '</td>';
									$datatable .= '</tr>';
								}
									$datatable .= '</tbody>';
									$datatable .= '</table>';
									$datatable .= '</div>';
									$datatable .= '</div>';


									echo $datatable;
							}
						} 
						?>
						 <div class="pull-left ShowGraph">
								<a href="<?= $this->createUrl('report/reportRegisterOfficePDF',array('registerofficeData[Department]'=>$_POST['Department'],
								'registerofficeData[Position]'=>$_POST['Position'],
								'registerofficeData[Chart]'=>$_POST['Chart'],
								'registerofficeData[datetime_start]'=>$_POST['datetime_start'],
								'registerofficeData[datetime_end]'=>$_POST['datetime_end'],
								'registerofficeData[Year_start]'=>$_POST['Year_start'],
								'registerofficeData[Year_end]'=>$_POST['Year_end'])); ?>" target="_blank" class="btn btn btn-pdf"><i class="fas fa-file-pdf"></i>Export PDF</a> 
								<a href="<?= $this->createUrl('report/reportRegisterOfficeExcel',array('registerofficeData[Department]'=>$_POST['Department'],
								'registerofficeData[Position]'=>$_POST['Position'],
								'registerofficeData[Chart]'=>$_POST['Chart'],
								'registerofficeData[datetime_start]'=>$_POST['datetime_start'],
								'registerofficeData[datetime_end]'=>$_POST['datetime_end'],
								'registerofficeData[Year_start]'=>$_POST['Year_start'],
								'registerofficeData[Year_end]'=>$_POST['Year_end'])); ?>" target="_blank" class="btn btn btn-excel"><i class="fas fa-file-excel"></i>Export Excel</a>
				</div> 
	<?php 
	}
public function actionReportRegisterOfficeExcel()
{
	if (Yii::app()->user->id != null) { 
	if ($_GET['registerofficeData']) {
		$data = $_GET['registerofficeData'];

		$this->renderPartial('report_registerOffice_excel',array('data' => $data));
	}
}
}

	public function actionReportRegisterOfficePDF()
	{
		if (Yii::app()->user->id != null) { 
		if ($_GET['registerofficeData']) {
			$data = $_GET['registerofficeData'];
			require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
			$mPDF = new \Mpdf\Mpdf(['format' => 'A4-P']);
			$mPDF->useDictionaryLBR = false;
			$mPDF->setDisplayMode('fullpage');
			$texttt= '
			<style>
			body { font-family: "garuda"; }
			</style>
			';
			$mPDF->WriteHTML($texttt);
			$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('report_registeOffice_pdf', array('data'=>$data),true),'UTF-8','UTF-8'));

			$mPDF->Output("รายงานภาพรวมการสมัครคนออฟฟิศ.pdf" , 'I');

			
		}
	}
	}
	
	public function actionRegistershipData()
	{
		
		$Department = $_POST['Department'];
		$Position = $_POST['Position'];
		$age = $_POST['age'];
		$age2 = $_POST['age2'];
		$datetime_start = $_POST['datetime_start'];
		$datetime_end = $_POST['datetime_end'];
		$Year_start = $_POST['Year_start'];
		$Year_end = $_POST['Year_end'];
		$Chart = $_POST['Chart'];
		$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
		$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";

		if (Yii::app()->user->id != null) {
					$user_login = User::model()->findByPk(Yii::app()->user->id);
					$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
					$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
					$user_Level = $user_login->branch_id;
					$user_Position = $user_login->position_id;
					$user_Department = $user_login->department_id;

			$criteria = new CDbCriteria;
			$criteria->compare('type_employee_id',1);
			if($Department){
				$criteria->compare('id',$Department);
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
			$criteria->compare('department_id',$dep_arr);
			if($Position){
				$criteria->compare('id',$Position);
			}
			if ($authority == 3) {
				$criteria->compare('id',$user_Position);
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

			if (!empty($pos)) {

				$datas = '["Element", "Position", { role: "style" } ],';
				$colorName = Helpers::lib()->ColorCode();	
		
				foreach ($pos as $key => $value) {
					$name_pos = $value->position_title;
					$criteria = new CDbCriteria;
					if($Position){
						$criteria->compare('position_id',$Position);
					}else{
						$criteria->compare('position_id',$value->id);	
					}
					if($Department){
						$criteria->compare('department_id',$Department);
					}
					if ($authority == 2 || $authority == 3) {
						$criteria->compare('department_id',$user_Department);
					}
					$criteria->compare('superuser',0);
					if ($Year_start != null) {
						$criteria->compare('YEAR(create_at)', $Year_start);
					}
					if ($age != null && $age2 != null || $age != "" && $age2 != "") {
						$criteria->addBetweenCondition('age', $age, $age2, 'AND');
					}
					if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

						$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
					}

					$users_count= Users::model()->findAll($criteria);
					$count_pos = count($users_count);

					$datas .= '["'.$name_pos.'",'.$count_pos.',"'.$colorName[$key].'"],';

				}

				$data_year_end = '["Element", "Position", { role: "style" } ],';
				$colorName = Helpers::lib()->ColorCode();	
			
				foreach ($pos as $key => $value) {
					$name_pos = $value->position_title;
					$criteria = new CDbCriteria;
					if($Position){
						$criteria->compare('position_id',$Position);
					}else{
						$criteria->compare('position_id',$value->id);	
					}
					if($Department){
						$criteria->compare('department_id',$Department);
					}
					if ($authority == 2 || $authority == 3) {
						$criteria->compare('department_id',$user_Department);
					}
					$criteria->compare('superuser',0);
					if ($Year_end != null) {
						$criteria->compare('YEAR(create_at)', $Year_end);
					}
					if ($age != null && $age2 != null || $age != "" && $age2 != "") {
						$criteria->addBetweenCondition('age', $age, $age2, 'AND');
					}
					if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

						$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
					}
					$users_count= Users::model()->findAll($criteria);

					$count_pos = count($users_count);

					$data_year_end .= '["'.$name_pos.'",'.$count_pos.',"'.$colorName[$key].'"],';
				}
			}
			if ($Chart != "") {
			if ($_POST['Year_start'] != null || $_POST['Year_end'] != null) {

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
									//is3D: true,
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
									//is3D: true,
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
									//is3D: true,
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
									//is3D: true,
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

						<?php	
					}
				}else{
					if ($Chart === "accommodation=Bar_Graph" || $Chart === "accommodation=Pie_Charts" || $Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {

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
									title: "รายงานภาพคนสมัครสมาชิกคนประจำเรือ",
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
							google.charts.load("current", {packages:["corechart"]});
							google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
								var data = google.visualization.arrayToDataTable([
									<?=$datas?>
									]);
								if (data) {}
									var options = {
										title: "รายงานภาพคนสมัครสมาชิกคนประจำเรือ",
										sliceVisibilityThreshold:0,
										pieSliceText:'value',
										//is3D: true,
									};

									var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
									google.visualization.events.addListener(chart, 'ready', function () {
										$.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint1',image_base64:chart.getImageURI()},function(json){
											var jsonObj = $.parseJSON( json );
										});
									});
									chart.draw(data, options);
								}
							</script>

						<?php }
						}
					}
					if($_POST['Year_start'] == "" && $_POST['Year_end'] == ""){
						
							?>
							<li class="breadcrumb-item active" aria-current="page">
				            <center>
				                <h3>
				                    <?php
				                    if (Yii::app()->session['lang'] == 1) {
				                        echo " Register staff ship Report";
				                    } else {
				                        echo " รายงานภาพการสมัครสมาชิก คนประจำเรือ";
				                    }
				                    ?>
				                </h3>    
				            </center>
				        	</li>
							<?php

							$i = 1;
							$datatable .= '<div class="report-table">';
							$datatable .= '<div class="table-responsive w-100 t-regis-language">';
							$datatable .= '<table class="table">';       
							$datatable .= '<thead>';
							$datatable .= '<tr>';
							$datatable .= '<th>ลำดับ</th>';
							$datatable .= '<th>ชื่อ - สกุล</th>';
							$datatable .= '<th>ฝ่าย</th>';
							$datatable .= '<th>แผนก</th>';
							$datatable .= '<th>อายุ</th>';
							$datatable .= '<th>สถานะอนุมัติ</th>';
							$datatable .= '</tr>'; 
							$datatable .= '</thead>';
							$datatable .= '<tbody>';
						if (!empty($User)) {
							foreach ($User as $keypos_back => $valuepos_back) { 	

								$datatable .= '<tr>';
								$datatable .= '<td>'.$i++.'</td>';
								$datatable .= '<td>'.$valuepos_back->profile->firstname."  ".$valuepos_back->profile->lastname.'</td>';
								$datatable .= '<td>'.$valuepos_back->department->dep_title.'</td>';
								$datatable .= '<td>'.$valuepos_back->position->position_title.'</td>';
								$datatable .= '<td>';
								if ($valuepos_back->profile->age) {
									$datatable .= $valuepos_back->profile->age;
								}else{
									$datatable .= "-";
								}

								$datatable .= '</td>';
								$datatable .= '<td>';
								if ($valuepos_back->status == 1) {
									$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
								}else{
									$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
								}
								$datatable .= '</td>';
								$datatable .= '</tr>';

							}  							
						}else{
						$datatable .= '<tr>';
						$datatable .= '<td colspan="6">';
                                    if(Yii::app()->session['lang'] != 1){
                                        $datatable .= 'ไม่มีข้อมูล';
                                    }else{
                                        $datatable .= 'No data';
                                    }
                        $datatable .= '</td>';
						$datatable .= '</tr>';
					}

							$datatable .= '</tbody>';
							$datatable .= '</table>';
							$datatable .= '</div>';
							$datatable .= '</div>';

					echo $datatable;	
					}		
				} ?>
				<div class="pull-left ShowGraph">
								<a href="<?= $this->createUrl('report/reportRegisterShipPDF',array('registershipData[Department]'=>$_POST['Department'],
								'registershipData[Position]'=>$_POST['Position'],
								'registershipData[age]'=>$_POST['age'],
								'registershipData[age2]'=>$_POST['age2'],
								'registershipData[Chart]'=>$_POST['Chart'],
								'registershipData[datetime_start]'=>$_POST['datetime_start'],
								'registershipData[datetime_end]'=>$_POST['datetime_end'],
								'registershipData[Year_start]'=>$_POST['Year_start'],
								'registershipData[Year_end]'=>$_POST['Year_end'])); ?>" target="_blank" class="btn btn btn-pdf"><i class="fas fa-file-pdf"></i>Export PDF</a>
								<a href="<?= $this->createUrl('report/reportRegisterShipExcel',array('registershipData[Department]'=>$_POST['Department'],
								'registershipData[Position]'=>$_POST['Position'],
								'registershipData[age]'=>$_POST['age'],
								'registershipData[age2]'=>$_POST['age2'],
								'registershipData[Chart]'=>$_POST['Chart'],
								'registershipData[datetime_start]'=>$_POST['datetime_start'],
								'registershipData[datetime_end]'=>$_POST['datetime_end'],
								'registershipData[Year_start]'=>$_POST['Year_start'],
								'registershipData[Year_end]'=>$_POST['Year_end'])); ?>" target="_blank" class="btn btn btn-excel"><i class="fas fa-file-excel"></i>Export Excel</a>
				</div>
<?php }

public function actionReportRegisterShipExcel()
{
	if (Yii::app()->user->id != null) { 
							$user_login = User::model()->findByPk(Yii::app()->user->id);
							$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
							$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
							$user_Level = $user_login->branch_id;
							$user_Position = $user_login->position_id;
							$user_Department = $user_login->department_id;
				if ($_GET['registershipData']) {
					$data = $_GET['registershipData'];

					$this->renderPartial('report_registerShip_excel',array('data' => $data));
				}
	}
}

	public function actionReportRegisterShipPDF()
	{
		if (Yii::app()->user->id != null) { 
						

		if ($_GET['registershipData']) {
			$data = $_GET['registershipData'];
			require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
			$mPDF = new \Mpdf\Mpdf(['format' => 'A4-P']);
			$mPDF->useDictionaryLBR = false;
			$mPDF->setDisplayMode('fullpage');
			$texttt= '
			<style>
			body { font-family: "garuda"; }
			</style>
			';
			$mPDF->WriteHTML($texttt);
			$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('report_registeShip_pdf', array('data'=>$data),true),'UTF-8','UTF-8'));

			$mPDF->Output("รายงานภาพรวมการสมัครคนเรือ.pdf" , 'I');

			
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
				$Year_start = $_POST['Year_start'];
				$Year_end = $_POST['Year_end'];
				$start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
				$end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
				$Chart = $_POST['Chart'];

				if (Yii::app()->user->id != null) {
					$user_login = User::model()->findByPk(Yii::app()->user->id);
					$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
					$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office
					$user_Level = $user_login->branch_id;
					$user_Position = $user_login->position_id;
					$user_Department = $user_login->department_id;
					$criteria = new CDbCriteria;
					$criteria->compare('type_employee_id',$TypeEmployee);
					if($Department){
						$criteria->compare('id',$Department);
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
					if ($Position != "") {
						if($Position){
							$criteria->compare('id',$Position);
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
					if ($Leval != "") {
						if($Leval){
							$criteria->compare('id',$Leval);
						}
					}else{
						if ($authority == 3) {
							$criteria->compare('id',$user_Level);
						}
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
					if ($Position != "") {
					if($Position){
							$criteria->compare('id',$Position);
						}
					}else{
						if ($authority == 2 || $authority == 3) {
							$criteria->compare('id',$user_Position);
						}
					}
					$criteria->addNotInCondition('id',$result_branch_arr);
					$criteria->compare('active','y');
					$pos_back = Position::model()->findAll($criteria);

					$criteria = new CDbCriteria;
					$criteria->compare('type_employee_id',$TypeEmployee);
					if($Department){
						$criteria->compare('id',$Department);
					}
					if ($authority == 2 || $authority == 3) {
						$criteria->compare('id',$user_Department);
					}
					$criteria->addNotInCondition('id',$result_pos_arr);
					$criteria->compare('active','y');
					$dep_back = Department::model()->findAll($criteria);

					if ($TypeEmployee == '1') {

						
							$datas = '["Element", "Position", { role: "style" } ],';
							$colorName = Helpers::lib()->ColorCode();	
						
							foreach ($pos_back as $key => $value) {

								$name_pos = $value->position_title;

								$criteria = new CDbCriteria;
								$criteria->compare('position_id',$value->id);
								$criteria->compare('department_id',$value->Departments->id);
								$criteria->compare('superuser',0);
								if ($Year_start != null) {
								$criteria->compare('YEAR(create_at)', $Year_start);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}
								if($status != null){
									$criteria->compare('status',$status);		
								}
								$users_count= Users::model()->findAll($criteria);
								$count_pos = count($users_count);

								$datas .= '["'.$name_pos.'",'.$count_pos.',"'.$colorName[$key].'"],';

							}
						
							$data_year_end = '["Element", "Position", { role: "style" } ],';
							$colorName = Helpers::lib()->ColorCode();	
					         
							foreach ($pos_back as $key => $value) {

								$name_pos = $value->position_title;

								$criteria = new CDbCriteria;
								$criteria->compare('position_id',$value->id);
								$criteria->compare('department_id',$value->Departments->id);
								$criteria->compare('superuser',0);
								if ($Year_end != null) {
								$criteria->compare('YEAR(create_at)', $Year_end);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}
								if($status != null){
									$criteria->compare('status',$status);		
								}
								$users_count= Users::model()->findAll($criteria);
								$count_pos = count($users_count);

								$data_year_end .= '["'.$name_pos.'",'.$count_pos.',"'.$colorName[$key].'"],';

							}
						
					}else if($TypeEmployee == '2'){

						
							$datas = '["Element", "Division", { role: "style" } ],';
							$colorName = Helpers::lib()->ColorCode();	
						
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
								if ($Year_start != null) {
								$criteria->compare('YEAR(create_at)', $Year_start);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}
								$criteria->compare('superuser',0);

								$users_count = Users::model()->findAll($criteria);
								$count_dep = count($users_count);

								$datas .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$colorName[$key].'"],';

							}

							foreach ($result_dep_not as $key => $value) {		
								$criteria = new CDbCriteria;
								$criteria->with = array('department');
								$criteria->compare('department_id',$value);
								if ($Year_start != null) {
								$criteria->compare('YEAR(create_at)', $Year_start);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}
								$criteria->compare('superuser',0);

								$users_count = Users::model()->findAll($criteria);
								$count_dep = count($users_count);

								$datas .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$color[$key].'"],';

							}
						
						


							$data_year_end = '["Element", "Division", { role: "style" } ],';
							$colorName = Helpers::lib()->ColorCode();	
					
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
								if($Year_end != null){
								$criteria->compare('YEAR(create_at)', $Year_end);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}
								$criteria->compare('superuser',0);

								$users_count = Users::model()->findAll($criteria);
								$count_dep = count($users_count);

								$data_year_end .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$colorName[$key].'"],';


							}

							foreach ($result_dep_not as $key => $value) {
								$criteria = new CDbCriteria;
								$criteria->with = array('department');
								$criteria->compare('department_id',$value);
								if($Year_end != null){
								$criteria->compare('YEAR(create_at)', $Year_end);
								}
								if ($datetime_start != null && $datetime_end != null || $datetime_start != "" && $datetime_end != "") {

									$criteria->addBetweenCondition('create_at', $start_date, $end_date, 'AND');
								}
								$criteria->compare('superuser',0);

								$users_count = Users::model()->findAll($criteria);
								$count_dep = count($users_count);

								$data_year_end .= '["'.$result_dep_in_name[$key].'",'.$count_dep.',"'.$colorName[$key].'"],';

							}

						
					}
				if ($Chart != "") {
					
					if ($_POST['Year_start'] != null || $_POST['Year_end'] != null) {
					
						
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
									//is3D: true,
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
									//is3D: true,
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
									//is3D: true,
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
									//is3D: true,
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

						<?php	
					}
				}else{
					if ($Chart === "accommodation=Bar_Graph" || $Chart === "accommodation=Pie_Charts" || $Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {

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
									title: "รายงานภาพรวมสมัครสมาชิก",
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
							google.charts.load("current", {packages:["corechart"]});
							google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
								var data = google.visualization.arrayToDataTable([
									<?=$datas?>
									]);
								if (data) {}
									var options = {
										title: "รายงานภาพสมัครสมาชิก",
										sliceVisibilityThreshold:0,
										pieSliceText:'value',
										//is3D: true,
									};

									var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
									google.visualization.events.addListener(chart, 'ready', function () {
										$.post('<?=$this->createUrl('report/saveChart')?>',{name:'AttendPrint1',image_base64:chart.getImageURI()},function(json){
											var jsonObj = $.parseJSON( json );
										});
									});
									chart.draw(data, options);
								}
							</script>

						<?php }
						}
					} ?>
						<?php	if ($_POST['Year_start'] == "" && $_POST['Year_end'] == "") {
								
									?>
										<li class="breadcrumb-item active" aria-current="page">
						            <center>
						                <h3>
						                    <?php
						                    if (Yii::app()->session['lang'] == 1) {
						                        echo "Register Overview Report";
						                    } else {
						                        echo "รายงานภาพรวมการสมัครสมาชิก";
						                    }
						                    ?>
						                </h3>    
						            </center>
						        </li>

												
									<?php

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
									if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
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
											if ($authority == 2 || $authority == 3) {
												$criteria->compare('department_id',$user_Department);
											}
											if ($Position != "") {
												if($Position){
													$criteria->compare('position_id',$Position);
												}
											}else{
												if ($authority == 2 || $authority == 3) {
													$criteria->compare('position_id',$user_Position);
												}
											}
											if($Leval != ""){
											if($Leval){
												$criteria->compare('branch_id',$Leval);
											}
											}else{
												if ($authority == 3) {
													$criteria->compare('branch_id',$user_Level);
												}
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
												}else{
												$datatable .= '-';
											}
												$datatable .= '</td>';
											}
											if($cou_use > 0){
												$datatable .= '<td>'.round($per_cen, 2).' %</td>';
											}else{
												$datatable .= '<td>-</td>';
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
											if ($authority == 2 || $authority == 3) {
												$criteria->compare('department_id',$user_Department);
											}
											if ($Position != "") {
												if($Position){
													$criteria->compare('position_id',$Position);
												}
											}else{
												if ($authority == 2 || $authority == 3) {
													$criteria->compare('position_id',$user_Position);
												}
											}
											if($Leval != ""){
											if($Leval){
												$criteria->compare('branch_id',$Leval);
											}
											}else{
												if ($authority == 3) {
													$criteria->compare('branch_id',$user_Level);
												}
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
											}else{
												$datatable .= '-';
											}
											$datatable .= '</td>';
										}	
										if($cou_use > 0){
											$datatable .= '<td>'.round($per_cen, 2).' %</td>';
										}else{
											$datatable .= '<td>-</td>';
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
											if ($authority == 2 || $authority == 3) {
												$criteria->compare('department_id',$user_Department);
											}
											if ($Position != "") {
												if($Position){
													$criteria->compare('position_id',$Position);
												}
											}else{
												if ($authority == 2 || $authority == 3) {
													$criteria->compare('position_id',$user_Position);
												}
											}
											if($Leval != ""){
											if($Leval){
												$criteria->compare('branch_id',$Leval);
											}
											}else{
												if ($authority == 3) {
													$criteria->compare('branch_id',$user_Level);
												}
											}
										$criteria->compare('superuser',0);
										$usersAll = Users::model()->findAll($criteria);

										$cou_use = count($users);
										$cou_useAll = count($usersAll);
										$per_cen = ($cou_use / $cou_useAll) * 100; 

										$datatable .= '<tr>';
										$datatable .= '<td>'.$i++.'</td>';
										$datatable .= '<td>'.$valuedep_back->dep_title.'</td>';
										$datatable .= '<td>-</td>';
										$datatable .= '<td>-</td>';
										$datatable .= '<td>'.$cou_use.'</td>';
										if($TypeEmployee != 2){
											$datatable .= '<td>';
											if($cou_use > 0){
												if ($status == 1) {
													$datatable .= '<span class="text-success"><i class="fas fa-check"></i>&nbsp;อนุมัติ</span>';
												}else{
													$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>&nbsp;ไม่อนุมัติ</span>';
												}
											}else{
												$datatable .= '-';
											}
											$datatable .= '</td>';
										}
										if($cou_use > 0){
											$datatable .= '<td>'.round($per_cen, 2).' %</td>';
										}else{
											$datatable .= '<td>-</td>';
										}
										$datatable .= '</tr>';

									}  

									
								}else{
									$datatable .= '<tr>';
									$datatable .= '<td colspan="6">';
	                                    if(Yii::app()->session['lang'] != 1){
	                                        $datatable .= 'ไม่มีข้อมูล';
	                                    }else{
	                                        $datatable .= 'No data';
	                                    }
			                        $datatable .= '</td>';
									$datatable .= '</tr>';
								}
									$datatable .= '</tbody>';
									$datatable .= '</table>';
									$datatable .= '</div>';
									$datatable .= '</div>';

									echo $datatable;
							}?>
							<div class="pull-left ShowGraph">
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
						if (Yii::app()->user->id != null) { 
			
							if ($_GET['reportRegisterData']) {
								$data = $_GET['reportRegisterData'];

								$this->renderPartial('report_register_excel',array('data' => $data));
							}
						}
					}

					public function actionReportRegisterPDF()
					{
						if (Yii::app()->user->id != null) { 
						
							if ($_GET['reportRegisterData']) {
								$data = $_GET['reportRegisterData'];
								require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
								$mPDF = new \Mpdf\Mpdf(['format' => 'A4-P']);
								$mPDF->useDictionaryLBR = false;
								$mPDF->setDisplayMode('fullpage');
								$texttt= '
								<style>
								body { font-family: "garuda"; }
								</style>
								';
								$mPDF->WriteHTML($texttt);
								$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('report_register_pdf', array('data'=>$data),true),'UTF-8','UTF-8'));
			
								$mPDF->Output("รายงานภาพรวมการสมัคร.pdf" , 'I');

								}
						}
					}

		public function actionListDepartment()
		{
			if (Yii::app()->user->id != null) {   // ต้อง login ถึงจะเห็น
			
				$user_login = User::model()->findByPk(Yii::app()->user->id);
				$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
				$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office			

				$criteria= new CDbCriteria;
				$criteria->condition='type_employee_id=:type_employee_id AND active=:active';
				$criteria->params=array(':type_employee_id'=>$_POST['id'],':active'=>'y');
				$criteria->order = 'sortOrder ASC';
				$model = Department::model()->findAll($criteria);
				if ($type_em == 1) {
					$sub_list = Yii::app()->session['lang'] == 1?'Select Department ':'เลือกแผนก';
				}else{
					$sub_list = Yii::app()->session['lang'] == 1?'Select Division ':'เลือกฝ่าย';
				}
				
				
				$data = '<option value ="">'.$sub_list.'</option>';
				foreach ($model as $key => $value) {
					$data .= '<option value = "'.$value->id.'"'.'>'.$value->dep_title.'</option>';
				}
				echo ($data);
			}	
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
		}else{
			$user_login = User::model()->findByPk(Yii::app()->user->id);
			$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
			$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

			if($authority != 1 && $authority != 2 && $authority != 3){
				$this->redirect(array('report/index'));
				exit();
			}
		}

		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}

		//------------------- ค่า form search ------------------------//
		$model_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
			'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
			'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
			'order' => 'course_title ASC'
		));

		// if($authority == 1){
		// 	$model_department = Department::model()->findAll(array(
		// 		'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	 //    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>1), //1=เรือ 2=office
	 //    	'order' => 'dep_title ASC'    	
	 //    ));
		// }else{
			$model_department = [];
		// }

		if($authority == 2){
			$model_position = Position::model()->findAll(array(
				'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y',':department_id'=>$user_login->department_id,':lang_id'=>1),
				'order' => 'position_title ASC'
			));
		}else{
			$model_position = [];
		}

		if($authority == 3){
			$model_level = Branch::model()->findAll(array(
				'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y',':position_id'=>$user_login->position_id,':lang_id'=>1),
				'order' => 'branch_name ASC'
			));
		}else{
			$model_level = [];
		}

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

			if($_GET["search"]["course_id"] != ""){
    			$search_course = CourseOnline::model()->findAll("active='y' AND lang_id=1 AND course_id='".$_GET["search"]["course_id"]."'");

$model_gen = CourseGeneration::model()->findAll(array(
	'condition' => 'active=:active AND course_id=:course_id',
	'params' => array(':active'=>'y', ':course_id'=>$_GET["search"]["course_id"]),
	'order' => 'gen_title ASC'    	
));

    		}else{
    			$search_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
    				'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
    				'params' => array(':active'=>'y', ':lang_id'=>1),
    				'order' => 'course_title ASC'
    			));
    		}

    		if($_GET["search"]["end_year"] == "" && $_GET["search"]["start_year"] == ""){ // ไม่ใช่ช่วงปี

    		$arr_course_gen = [];
    		$arr_course_graph = [];
    		if(!empty($search_course)){
    			foreach ($search_course as $key_c => $value_c) {
    				// $arr_course_gen[$key_c]["course_id"] = $value_c->course_id;    
    				// $arr_course_graph[$value_c->course_id]["title"] = $value_c->course_title;
    				// $arr_course_graph[$value_c->course_id]["register"] = 0;		
    				// $arr_course_graph[$value_c->course_id]["pass"] = 0;		
    				// $key_gen = 0;

$gen_all= [];
if($_GET["search"]["gen_id"] != ""){
	$value_c->CourseGeneration = CourseGeneration::model()->findAll("gen_id=".$_GET["search"]["gen_id"]);

	if(!empty($value_c->CourseGeneration)){
		foreach ($value_c->CourseGeneration as $key_cg => $value_cg) {
			if($value_cg->active == 'y'){
				$gen_all[] = $value_cg->gen_id;
			}
		}
	}	
}else{

	if(!empty($value_c->CourseGeneration)){
		$gen_all[] = 0;
		foreach ($value_c->CourseGeneration as $key_cg => $value_cg) {
			if($value_cg->active == 'y'){
				$gen_all[] = $value_cg->gen_id;
			}
		}
	}

}
    				// else{
    					if(!empty($gen_all)){
    						foreach ($gen_all as $key_cg => $value_cg) {
    							$arr_course_gen[$key_c]["course_id"] = $value_c->course_id;    
    							$arr_course_graph[$value_c->course_id]["title"] = $value_c->course_title;
    							$arr_course_graph[$value_c->course_id]["register"] = 0;		
    							$arr_course_graph[$value_c->course_id]["pass"] = 0;		
    							$key_gen = 0;
    								$arr_course_gen[$key_c]["gen"][$key_gen]["gen_id"] = $value_cg;

$criteria = new CDbCriteria;
$criteria->addCondition('user.id IS NOT NULL');
$criteria->compare('t.active', 'y');
$criteria->compare('t.course_id', $value_c->course_id);
$criteria->compare('t.gen_id', $value_cg);
$criteria->compare('user.superuser',0);

if($_GET["search"]["employee"] != ""){
	if($_GET["search"]["employee"] == 1){
		$criteria->compare('pro.type_employee', 1); //1=เรือ
	}elseif($_GET["search"]["employee"] == 2){
		$criteria->compare('pro.type_employee', 2); //2=office
	}else{
		$criteria->addCondition('pro.type_employee IS NOT NULL');
	}

$model_department = Department::model()->findAll(array(
	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
    'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>$_GET["search"]["employee"]),
    'order' => 'dep_title ASC'    	
 ));

}else{
	$criteria->addCondition('pro.type_employee IS NOT NULL');
}

if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
	$_GET["search"]["department"] = $user_login->department_id;
}
if($_GET["search"]["department"] != ""){
	$criteria->compare('user.department_id', $_GET["search"]["department"]);

	$model_position = Position::model()->findAll(array(
		'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
		'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
		'order' => 'position_title ASC'
	));

	if($authority == 3){ // ผู้จัดการแผนก
		$_GET["search"]["position"] = $user_login->position_id;
	}
	if($_GET["search"]["position"] != ""){
		$criteria->compare('user.position_id', $_GET["search"]["position"]);

		$model_level = Branch::model()->findAll(array(
			'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
			'params' => array(':active'=>'y',':position_id'=>$_GET["search"]["position"],':lang_id'=>1),
			'order' => 'branch_name ASC'
		));

		if($_GET["search"]["level"] != ""){
			$criteria->compare('user.branch_id', $_GET["search"]["level"]);
		}
	}
}

if($_GET["search"]["start_date"] != "" && $_GET["search"]["end_date"] != ""){
	if($_GET["search"]["start_date"] != ""){
		$criteria->compare('t.start_date', ">=".$_GET["search"]["start_date"]." 00:00:00");
	}
	if($_GET["search"]["end_date"] != ""){
		$criteria->compare('t.start_date', "<=".$_GET["search"]["end_date"]." 23:59:59");
	}
}

$criteria->order = 't.course_id ASC, t.gen_id ASC';
$LogStartcourse = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

$num_pass = 0;
$num_notlearn = 0;
if(!empty($LogStartcourse)){
	foreach ($LogStartcourse as $key_lsc => $value_lsc) {
		$pass_course = Passcours::model()->findAll("passcours_cours='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND passcours_user='".$value_lsc->user_id."' ");
$arr_course_gen[$key_c]["gen"][$key_gen]["user"] = $arr_course_gen[$key_c]["gen"][$key_gen]["user"].$value_lsc->user_id.",";

		if(!empty($pass_course)){
			$num_pass++;
		}

		$learn_course = Learn::model()->findAll("course_id='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND user_id='".$value_lsc->user_id."' ");
		if(empty($learn_course)){
			$num_notlearn++;
		}

	}
} // if(!empty($LogStartcourse))

if(count($LogStartcourse) > 0){
	$arr_course_gen[$key_c]["gen"][$key_gen]["register"] = count($LogStartcourse);
	$arr_course_gen[$key_c]["gen"][$key_gen]["pass"] = $num_pass;
	$arr_course_gen[$key_c]["gen"][$key_gen]["notlearn"] = $num_notlearn;
	$arr_course_gen[$key_c]["gen"][$key_gen]["learn"] = count($LogStartcourse)-($num_pass+$num_notlearn);

	$arr_course_gen[$key_c]["gen"][$key_gen]["per_pass"] = ($num_pass*100)/count($LogStartcourse);
	$arr_course_gen[$key_c]["gen"][$key_gen]["per_notpass"] = (($num_notlearn+count($LogStartcourse)-($num_pass+$num_notlearn))*100)/count($LogStartcourse);


	


	$key_gen++;
}else{
		unset($arr_course_gen[$key_c]["gen"][$key_gen]);
}

$arr_course_graph[$value_c->course_id]["register"] = $arr_course_graph[$value_c->course_id]["register"]+count($LogStartcourse);
	$arr_course_graph[$value_c->course_id]["pass"] = $arr_course_graph[$value_c->course_id]["pass"]+$num_pass;

// $arr_course_gen[$key_c]["gen"][$key_gen]["register"] = count($LogStartcourse);
// $arr_course_gen[$key_c]["gen"][$key_gen]["pass"] = $num_pass;
// $arr_course_gen[$key_c]["gen"][$key_gen]["notlearn"] = $num_notlearn;
// $arr_course_gen[$key_c]["gen"][$key_gen]["learn"] = count($LogStartcourse)-($num_pass+$num_notlearn);

// $arr_course_gen[$key_c]["gen"][$key_gen]["per_pass"] = ($num_pass*100)/count($LogStartcourse);
// $arr_course_gen[$key_c]["gen"][$key_gen]["per_notpass"] = (($num_notlearn+count($LogStartcourse)-($num_pass+$num_notlearn))*100)/count($LogStartcourse);


// $arr_course_graph[$value_c->course_id]["register"] = $arr_course_graph[$value_c->course_id]["register"]+count($LogStartcourse);
// $arr_course_graph[$value_c->course_id]["pass"] = $arr_course_graph[$value_c->course_id]["pass"]+$num_pass;


//     								$key_gen++;
    							// } // if($value_cg->active == 'y')
    						} // foreach ($value_c->CourseGeneration
    					}else{ // if(!empty($value_c->CourseGeneration))
    						// $arr_course_gen[$key_c]["gen"] = [];
    					}
    				// }

    			} //foreach ($search_course
    		} //if(!empty($search_course))

}else{ // if(isset($_GET["search"]["end_year"])  // ช่วงปี

	$arr_course_year = [];
	if(!empty($search_course)){		
		foreach ($search_course as $key_c => $value_c) {

			for ($year=$_GET["search"]["start_year"]; $year <= $_GET["search"]["end_year"] ; $year++) { 
						$arr_course_year[$year][$value_c->course_id]["register"] = 0;
						$arr_course_year[$year][$value_c->course_id]["pass"] = 0;

						$criteria = new CDbCriteria;
						$criteria->addCondition('user.id IS NOT NULL');
						$criteria->compare('t.active', 'y');
						$criteria->compare('t.course_id', $value_c->course_id);
						
						$criteria->compare('user.superuser',0);

						if($_GET["search"]["employee"] != ""){
							if($_GET["search"]["employee"] == 1){
								$criteria->compare('pro.type_employee', 1); //1=เรือ
							}elseif($_GET["search"]["employee"] == 2){
								$criteria->compare('pro.type_employee', 2); //2=office
							}else{
								$criteria->addCondition('pro.type_employee IS NOT NULL');
							}
$model_department = Department::model()->findAll(array(
	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>$_GET["search"]["employee"]),
	'order' => 'dep_title ASC'    	
));

						}else{
							$criteria->addCondition('pro.type_employee IS NOT NULL');
						}

						if($_GET["search"]["gen_id"] != ""){
							$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
						}

						if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
							$_GET["search"]["department"] = $user_login->department_id;
						}
						if($_GET["search"]["department"] != ""){
							$criteria->compare('user.department_id', $_GET["search"]["department"]);

$model_position = Position::model()->findAll(array(
	'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
	'order' => 'position_title ASC'
));

						if($authority == 3){ // ผู้จัดการแผนก
							$_GET["search"]["position"] = $user_login->position_id;
						}
						if($_GET["search"]["position"] != ""){
							$criteria->compare('user.position_id', $_GET["search"]["position"]);

$model_level = Branch::model()->findAll(array(
	'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y', ':position_id'=>$_GET["search"]["position"], ':lang_id'=>1),
	'order' => 'branch_name ASC'
));

							if($_GET["search"]["level"] != ""){
								$criteria->compare('user.branch_id', $_GET["search"]["level"]);
							}

						}

						}
						$criteria->compare('t.start_date', ">=".$year."-01-01"." 00:00:00");
						$criteria->compare('t.start_date', "<=".$year."-12-31"." 23:59:59");
						// $criteria->compare('t.start_date', ">=".$_GET["search"]["start_year"]."-01-01"." 00:00:00");
						// $criteria->compare('t.start_date', "<=".$_GET["search"]["end_year"]."-12-31"." 23:59:59");

						$criteria->order = 't.course_id ASC, t.gen_id ASC';
						$LogStartcourse = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);


$num_pass = 0;
$num_notlearn = 0;
if(!empty($LogStartcourse)){
	foreach ($LogStartcourse as $key_lsc => $value_lsc) {
		$pass_course = Passcours::model()->findAll("passcours_cours='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND passcours_user='".$value_lsc->user_id."' ");

		// $arr_course_gen[$key_c]["gen"][$key_gen]["user"] = $arr_course_gen[$key_c]["gen"][$key_gen]["user"].$value_lsc->user_id.",";

		if(!empty($pass_course)){
			$num_pass++;
		}

		$learn_course = Learn::model()->findAll("course_id='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND user_id='".$value_lsc->user_id."' ");
		if(empty($learn_course)){
			$num_notlearn++;
		}

	}
} // if(!empty($LogStartcourse))



					$arr_course_year[$year][$value_c->course_id]["register"] = $arr_course_year[$year][$value_c->course_id]["register"]+count($LogStartcourse);
					$arr_course_year[$year][$value_c->course_id]["pass"] = $arr_course_year[$year][$value_c->course_id]["pass"]+$num_pass;

			} //for ($i=$_GET["search"]["start_year"]
		} // foreach ($search_course
    } // if(!empty($search_course))



} // ช่วงปี


    		$this->render('course', array(
    			'model_course'=>$model_course,
    			'model_gen'=>$model_gen,
    			'model_department'=>$model_department,
    			'model_position'=>$model_position,
    			'model_level'=>$model_level,
    			'year_start'=>$year_start,
    			'year_end'=>$year_end,
    			'authority'=>$authority,
    			'type_em'=>$type_em,
    			'user_login'=>$user_login,
    			'model_search'=>$arr_course_gen,
    			'model_graph'=>$arr_course_graph,
    			'model_year'=>$arr_course_year,
    		));
    		exit();
		} //if(isset($_GET["search"]))





		$this->render('course', array(
			'model_course'=>$model_course,
			'model_department'=>$model_department,
			'model_position'=>$model_position,
			'model_level'=>$model_level,
			'year_start'=>$year_start,
			'year_end'=>$year_end,
			'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
		));
	}

public function actionCourseCaptain(){ // อบรม คนเรือ
	if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }else{
    	$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == "" || ($type_em != 1 && $authority != 1)){
			$this->redirect(array('report/index'));
        	exit();
		}
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    	$langId = Yii::app()->session['lang'] = 1;
    }else{
    	$langId = Yii::app()->session['lang'];
    }

    //------------------- ค่า form search ------------------------//
    $model_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
    	'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
    	'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
    	'order' => 'course_title ASC'
    ));

    if($authority == 1){
    	$model_department = Department::model()->findAll(array(
    		'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>1), //1=เรือ 2=office
	    	'order' => 'dep_title ASC'    	
	    ));
    }else{
    	$model_department = [];
    }    

    if($authority == 2){
    	$model_position = Position::model()->findAll(array(
    		'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
    		'params' => array(':active'=>'y',':department_id'=>$user_login->department_id,':lang_id'=>1),
    		'order' => 'position_title ASC'
    	));
    }else{
    	$model_position = [];
    }

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

    	$criteria = new CDbCriteria;

    	if($_GET["search"]["fullname"] != ""){
    		$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

    		if(isset($ex_fullname[0])){    			
    			$name = $ex_fullname[0];
    			$criteria->compare('pro.firstname', $name, true);
        		$criteria->compare('pro.lastname', $name, true, 'OR');
    		}

    		if(isset($ex_fullname[1])){
    			$name = $ex_fullname[1];
    			$criteria->compare('pro.lastname',$name,true, 'OR');
    		}
    	}

    	$criteria->compare('t.active', 'y');
    	$criteria->compare('course.active', 'y');
    	$criteria->compare('pro.type_employee', 1); //1=เรือ 2=office
		$criteria->compare('user.superuser',0);

    	$criteria->addCondition('user.id IS NOT NULL');
    	$criteria->addCondition('t.course_id IS NOT NULL');

    	if($_GET["search"]["course_id"] != ""){
    		$criteria->compare('t.course_id', $_GET["search"]["course_id"]);

    		$model_gen = CourseGeneration::model()->findAll(array(
    			'condition' => 'active=:active AND course_id=:course_id',
    			'params' => array(':active'=>'y', ':course_id'=>$_GET["search"]["course_id"]),
    			'order' => 'gen_title ASC'    	
    		));

    		if($_GET["search"]["gen_id"] != ""){    			
    			$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);    			
    		}
    	}

    	if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
    		$_GET["search"]["department"] = $user_login->department_id;
    	}
    	if($_GET["search"]["department"] != ""){
    		$criteria->compare('user.department_id', $_GET["search"]["department"]);

$model_position = Position::model()->findAll(array(
	'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
	'order' => 'position_title ASC'
));

    		if($authority == 3){ // ผู้จัดการแผนก
    			$_GET["search"]["position"] = $user_login->position_id;
    		}
    		if($_GET["search"]["position"] != ""){
    			$criteria->compare('user.position_id', $_GET["search"]["position"]);
    		}
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
	        'model_gen'=>$model_gen,	        
	        'model_department'=>$model_department,
	        'model_position'=>$model_position,	        
	        'year_start'=>$year_start,
	        'year_end'=>$year_end,
	        'model_search'=>$model_search,
	        'arr_count_course'=>$arr_count_course,
	        'arr_course_title'=>$arr_course_title,
	        'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
	    ));
		exit();
    } // if(isset($_GET["search"]))

	$this->render('course_captain', array(
        'model_course'=>$model_course,
        'model_department'=>$model_department,
        'model_position'=>$model_position,
        'year_start'=>$year_start,
        'year_end'=>$year_end,
        'authority'=>$authority,
		'type_em'=>$type_em,
		'user_login'=>$user_login,
    ));
}

public function actionCourseOffice(){ // อบรม office
	if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }else{
    	$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == "" || ($type_em != 2 && $authority != 1)){
			$this->redirect(array('report/index'));
			exit();
		}
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    	$langId = Yii::app()->session['lang'] = 1;
    }else{
    	$langId = Yii::app()->session['lang'];
    }

    //------------------- ค่า form search ------------------------//
    $model_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
    	'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
    	'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
    	'order' => 'course_title ASC'
    ));

    if($authority == 1){
    	$model_department = Department::model()->findAll(array(
	    	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>2),
	    	'order' => 'dep_title ASC'    	
    	));
    }else{
    	$model_department = [];
    }

    if($authority == 2){
    	$model_position = Position::model()->findAll(array(
    		'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
    		'params' => array(':active'=>'y',':department_id'=>$user_login->department_id,':lang_id'=>1),
    		'order' => 'position_title ASC'
    	));
    }else{
    	$model_position = [];
    }

    if($authority == 3){
    	$model_level = Branch::model()->findAll(array(
    		'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
    		'params' => array(':active'=>'y',':position_id'=>$user_login->position_id,':lang_id'=>1),
    		'order' => 'branch_name ASC'
    	));
    }else{
    	$model_level = [];
    }

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

    	$criteria = new CDbCriteria;

    	if($_GET["search"]["fullname"] != ""){
    		$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

    		if(isset($ex_fullname[0])){    			
    			$name = $ex_fullname[0];
    			$criteria->compare('pro.firstname', $name, true);
        		$criteria->compare('pro.lastname', $name, true, 'OR');
    		}

    		if(isset($ex_fullname[1])){
    			$name = $ex_fullname[1];
    			$criteria->compare('pro.lastname',$name,true, 'OR');
    		}
    	}

    	$criteria->compare('t.active', 'y');
    	$criteria->compare('course.active', 'y');
    	$criteria->compare('pro.type_employee', 2); //1=เรือ 2=office
		$criteria->compare('user.superuser',0);

    	$criteria->addCondition('user.id IS NOT NULL');
    	$criteria->addCondition('t.course_id IS NOT NULL');

    	if($_GET["search"]["course_id"] != ""){
    		$criteria->compare('t.course_id', $_GET["search"]["course_id"]);

    		if($_GET["search"]["gen_id"] != ""){
    			$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
    		}
    	}    	

    	if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
    		$_GET["search"]["department"] = $user_login->department_id;
    	}
    	if($_GET["search"]["department"] != ""){
    		$criteria->compare('user.department_id', $_GET["search"]["department"]);

    		$model_position = Position::model()->findAll(array(
    			'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
    			'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
    			'order' => 'position_title ASC'
    		));

    		if($authority == 3){ // ผู้จัดการแผนก
    			$_GET["search"]["position"] = $user_login->position_id;
    		}
    		if($_GET["search"]["position"] != ""){
    			$criteria->compare('user.position_id', $_GET["search"]["position"]);

$model_level = Branch::model()->findAll(array(
	'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y',':position_id'=>$_GET["search"]["position"],':lang_id'=>1),
	'order' => 'branch_name ASC'
));    			

    			if($_GET["search"]["level"] != ""){
    				$criteria->compare('user.branch_id', $_GET["search"]["level"]);
    			}
    		}
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
        	'model_gen'=>$model_gen,
	        'model_department'=>$model_department,
	        'model_position'=>$model_position,
        	'model_level'=>$model_level,
	        'year_start'=>$year_start,
	        'year_end'=>$year_end,
	        'model_search'=>$model_search,
	        'arr_count_course'=>$arr_count_course,
	        'arr_course_title'=>$arr_course_title,
	        'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
	    ));
		exit();
    } // if(isset($_GET["search"]))

	$this->render('course_office', array(
        'model_course'=>$model_course,
        'model_department'=>$model_department,
        'model_position'=>$model_position,
        'model_level'=>$model_level,
        'year_start'=>$year_start,
        'year_end'=>$year_end,
        'authority'=>$authority,
		'type_em'=>$type_em,
		'user_login'=>$user_login,
    ));
}

	public function actionExamOffice(){

		if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }else{
    	$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == "" || ($type_em != 2 && $authority != 1)){
			$this->redirect(array('report/index'));
			exit();
		}
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    	$langId = Yii::app()->session['lang'] = 1;
    }else{
    	$langId = Yii::app()->session['lang'];
    }

    //------------------- ค่า form search ------------------------//
    $model_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
    	'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
    	'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
    	'order' => 'course_title ASC'
    ));

    if($authority == 1){
    	$model_department = Department::model()->findAll(array(
	    	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>2),
	    	'order' => 'dep_title ASC'    	
    	));
    }else{
    	$model_department = [];
    }

    if($authority == 2){
    	$model_position = Position::model()->findAll(array(
    		'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
    		'params' => array(':active'=>'y',':department_id'=>$user_login->department_id,':lang_id'=>1),
    		'order' => 'position_title ASC'
    	));
    }else{
    	$model_position = [];
    }

    if($authority == 3){
    	$model_level = Branch::model()->findAll(array(
    		'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
    		'params' => array(':active'=>'y',':position_id'=>$user_login->position_id,':lang_id'=>1),
    		'order' => 'branch_name ASC'
    	));
    }else{
    	$model_level = [];
    }

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

    	$criteria = new CDbCriteria;

    	if($_GET["search"]["fullname"] != ""){
    		$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

    		if(isset($ex_fullname[0])){    			
    			$name = $ex_fullname[0];
    			$criteria->compare('pro.firstname', $name, true);
        		$criteria->compare('pro.lastname', $name, true, 'OR');
    		}

    		if(isset($ex_fullname[1])){
    			$name = $ex_fullname[1];
    			$criteria->compare('pro.lastname',$name,true, 'OR');
    		}
    	}

    	$criteria->compare('t.active', 'y');
    	$criteria->compare('course.active', 'y');
    	$criteria->compare('pro.type_employee', 2); //1=เรือ 2=office
		$criteria->compare('user.superuser',0);

    	$criteria->addCondition('user.id IS NOT NULL');
    	$criteria->addCondition('t.course_id IS NOT NULL');

    	if($_GET["search"]["course_id"] != ""){
    		$criteria->compare('t.course_id', $_GET["search"]["course_id"]);

    		if($_GET["search"]["gen_id"] != ""){
    			$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
    		}
    	}    	

    	if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
    		$_GET["search"]["department"] = $user_login->department_id;
    	}
    	if($_GET["search"]["department"] != ""){
    		$criteria->compare('user.department_id', $_GET["search"]["department"]);

    		$model_position = Position::model()->findAll(array(
    			'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
    			'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
    			'order' => 'position_title ASC'
    		));

    		if($authority == 3){ // ผู้จัดการแผนก
    			$_GET["search"]["position"] = $user_login->position_id;
    		}
    		if($_GET["search"]["position"] != ""){
    			$criteria->compare('user.position_id', $_GET["search"]["position"]);

$model_level = Branch::model()->findAll(array(
	'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y',':position_id'=>$_GET["search"]["position"],':lang_id'=>1),
	'order' => 'branch_name ASC'
));    			

    			if($_GET["search"]["level"] != ""){
    				$criteria->compare('user.branch_id', $_GET["search"]["level"]);
    			}
    		}
    	} 

    	$arr_count_course = [];
    	$arr_course_title = [];
    	if($_GET["search"]["start_year"] != "" && $_GET["search"]["end_year"] != ""){
    		if($_GET["search"]["start_year"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_year"]."-01-01 00:00:00");
    		}
    		if($_GET["search"]["end_year"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_year"]."-12-31 23:59:59");
    		}

    		$criteria->order = 'yearrrr ASC';
    		$criteria->select ='t.start_date, t.course_id, YEAR(t.start_date) AS yearrrr, t.user_id, t.gen_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);


    		foreach ($model_graph as $key => $value) {
    			$course_score = Coursescore::model()->find(array(
    				'condition' => 'active=:active AND user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type',
    				'params' => array(':active'=>'y',':user_id'=>$value->user_id,':course_id'=>$value->course_id, ':gen_id'=>$value->gen_id, ':type'=>'post'),
    				'order' => 'score_id DESC'
    			));
    			if($course_score != ""){
$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"];
$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"];
if($course_score->score_past == 'y'){
	$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"]+1;
	$course_model = CourseOnline::model()->findByPk($value->course_id);
	$arr_course_title[$value->course_id] = $course_model->course_title;
}elseif($course_score->score_past == 'n'){
	$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"]+1;
	$course_model = CourseOnline::model()->findByPk($value->course_id);
	$arr_course_title[$value->course_id] = $course_model->course_title;
}
    			}    			
    		}

    	}else{

    		if($_GET["search"]["start_date"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_date"]." 00:00:00");
    		}
    		if($_GET["search"]["end_date"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_date"]." 23:59:59");
    		}

    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		$model_search_score = [];
    		$model_search_graph = [];
    		foreach ($model_search as $key => $value) {
    			$course_score = Coursescore::model()->find(array(
    				'condition' => 'active=:active AND user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type',
    				'params' => array(':active'=>'y',':user_id'=>$value->user_id,':course_id'=>$value->course_id, ':gen_id'=>$value->gen_id, ':type'=>'post'),
    				'order' => 'score_id DESC'
    			));
    			if($course_score != ""){
    				$model_search_score[$key]["status"] = $course_score->score_past;
    				$model_search_score[$key]["score"] = $course_score->score_number."/".$course_score->score_total;



$course_model = CourseOnline::model()->findByPk($value->course_id);
$model_search_graph[$value->course_id]["title"] = $course_model->course_title;
$model_search_graph[$value->course_id]["pass"] = $model_search_graph[$value->course_id]["pass"];
$model_search_graph[$value->course_id]["fail"] = $model_search_graph[$value->course_id]["fail"];
if($course_score->score_past == 'y'){
	$model_search_graph[$value->course_id]["pass"] = $model_search_graph[$value->course_id]["pass"]+1;
}elseif($course_score->score_past == 'n'){
	$model_search_graph[$value->course_id]["fail"] = $model_search_graph[$value->course_id]["fail"]+1;
}


    			}


    		} // foreach ($model_search
    	} // else

    	// var_dump("<pre>");
    	// var_dump($arr_count_course);
    	// exit();

		$this->render('exam_office', array(
	        'model_course'=>$model_course,
        	'model_gen'=>$model_gen,
	        'model_department'=>$model_department,
	        'model_position'=>$model_position,
        	'model_level'=>$model_level,
	        'year_start'=>$year_start,
	        'year_end'=>$year_end,
	        'model_search'=>$model_search,
	        'model_search'=>$model_search,
	        'model_search_score'=>$model_search_score,
	        'model_search_graph'=>$model_search_graph,
	        'arr_course_title'=>$arr_course_title,
	        'arr_count_course'=>$arr_count_course,
	        'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
	    ));
		exit();
    } // if(isset($_GET["search"]))

		$this->render('exam_office', array(
			'model_course'=>$model_course,
			'model_department'=>$model_department,
			'model_position'=>$model_position,
			'model_level'=>$model_level,
			'year_start'=>$year_start,
			'year_end'=>$year_end,
			'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
		));
	}

public function actionExamShip(){

		if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');
        $this->redirect(array('site/index'));
        exit();
    }else{
    	$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == "" || ($type_em != 2 && $authority != 1)){
			$this->redirect(array('report/index'));
			exit();
		}
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    	$langId = Yii::app()->session['lang'] = 1;
    }else{
    	$langId = Yii::app()->session['lang'];
    }

    //------------------- ค่า form search ------------------------//
    $model_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
    	'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
    	'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
    	'order' => 'course_title ASC'
    ));

    if($authority == 1){
    	$model_department = Department::model()->findAll(array(
	    	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>1),
	    	'order' => 'dep_title ASC'    	
    	));
    }else{
    	$model_department = [];
    }

    if($authority == 1){
    	$model_position = Position::model()->findAll(array(
    		'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
    		'params' => array(':active'=>'y',':department_id'=>$user_login->department_id,':lang_id'=>1),
    		'order' => 'position_title ASC'
    	));
    }else{
    	$model_position = [];
    }

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

    	$criteria = new CDbCriteria;

    	if($_GET["search"]["fullname"] != ""){
    		$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

    		if(isset($ex_fullname[1])){    			
    			$name = $ex_fullname[1];
    			$criteria->compare('pro.firstname', $name, true);
        		$criteria->compare('pro.lastname', $name, true, 'OR');
    		}

    		if(isset($ex_fullname[0])){
    			$name = $ex_fullname[0];
    			$criteria->compare('pro.firstname_en',$name,true, 'OR');
    			$criteria->compare('pro.lastname_en',$name,true, 'OR');
    		}
    	}

    	$criteria->compare('t.active', 'y');
    	$criteria->compare('course.active', 'y');
    	$criteria->compare('pro.type_employee', 1); //1=เรือ 2=office
		$criteria->compare('user.superuser',0);

    	$criteria->addCondition('user.id IS NOT NULL');
    	$criteria->addCondition('t.course_id IS NOT NULL');

    	if($_GET["search"]["course_id"] != ""){
    		$criteria->compare('t.course_id', $_GET["search"]["course_id"]);

    		if($_GET["search"]["gen_id"] != ""){
    			$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
    		}
    	}    	

    	if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
    		$_GET["search"]["department"] = $user_login->department_id;
    	}
    	if($_GET["search"]["department"] != ""){
    		$criteria->compare('user.department_id', $_GET["search"]["department"]);

    		$model_position = Position::model()->findAll(array(
    			'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
    			'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
    			'order' => 'position_title ASC'
    		));

    		if($authority == 3){ // ผู้จัดการแผนก
    			$_GET["search"]["position"] = $user_login->position_id;
    		}
    		if($_GET["search"]["position"] != ""){
    			$criteria->compare('user.position_id', $_GET["search"]["position"]);
    		}
    	} 

    	$arr_count_course = [];
    	$arr_course_title = [];
    	if($_GET["search"]["start_year"] != "" && $_GET["search"]["end_year"] != ""){
    		if($_GET["search"]["start_year"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_year"]."-01-01 00:00:00");
    		}
    		if($_GET["search"]["end_year"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_year"]."-12-31 23:59:59");
    		}

    		$criteria->order = 'yearrrr ASC';
    		$criteria->select ='t.start_date, t.course_id, YEAR(t.start_date) AS yearrrr, t.user_id, t.gen_id';
    		$criteria->distinct = true;
    		$model_graph = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);


    		foreach ($model_graph as $key => $value) {
    			$course_score = Coursescore::model()->find(array(
    				'condition' => 'active=:active AND user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type',
    				'params' => array(':active'=>'y',':user_id'=>$value->user_id,':course_id'=>$value->course_id, ':gen_id'=>$value->gen_id, ':type'=>'post'),
    				'order' => 'score_id DESC'
    			));
    			if($course_score != ""){
$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"];
$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"];
if($course_score->score_past == 'y'){
	$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["pass"]+1;
	$course_model = CourseOnline::model()->findByPk($value->course_id);
	$arr_course_title[$value->course_id] = $course_model->course_title;
}elseif($course_score->score_past == 'n'){
	$arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"] = $arr_count_course[date("Y", strtotime($value->start_date))][$value->course_id]["fail"]+1;
	$course_model = CourseOnline::model()->findByPk($value->course_id);
	$arr_course_title[$value->course_id] = $course_model->course_title;
}
    			}    			
    		}

    	}else{

    		if($_GET["search"]["start_date"] != ""){
    			$criteria->compare('t.start_date', ">=".$_GET["search"]["start_date"]." 00:00:00");
    		}
    		if($_GET["search"]["end_date"] != ""){
    			$criteria->compare('t.start_date', "<=".$_GET["search"]["end_date"]." 23:59:59");
    		}

    		$criteria->order = 't.id ASC';
    		$model_search = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

    		$model_search_score = [];
    		$model_search_graph = [];
    		foreach ($model_search as $key => $value) {
    			$course_score = Coursescore::model()->find(array(
    				'condition' => 'active=:active AND user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type',
    				'params' => array(':active'=>'y',':user_id'=>$value->user_id,':course_id'=>$value->course_id, ':gen_id'=>$value->gen_id, ':type'=>'post'),
    				'order' => 'score_id DESC'
    			));
    			if($course_score != ""){
    				$model_search_score[$key]["status"] = $course_score->score_past;
    				$model_search_score[$key]["score"] = $course_score->score_number."/".$course_score->score_total;



$course_model = CourseOnline::model()->findByPk($value->course_id);
$model_search_graph[$value->course_id]["title"] = $course_model->course_title;
$model_search_graph[$value->course_id]["pass"] = $model_search_graph[$value->course_id]["pass"];
$model_search_graph[$value->course_id]["fail"] = $model_search_graph[$value->course_id]["fail"];
if($course_score->score_past == 'y'){
	$model_search_graph[$value->course_id]["pass"] = $model_search_graph[$value->course_id]["pass"]+1;
}elseif($course_score->score_past == 'n'){
	$model_search_graph[$value->course_id]["fail"] = $model_search_graph[$value->course_id]["fail"]+1;
}


    			}


    		} // foreach ($model_search
    	} // else

		$this->render('exam_ship', array(
	        'model_course'=>$model_course,
        	'model_gen'=>$model_gen,
	        'model_department'=>$model_department,
	        'model_position'=>$model_position,
	        'year_start'=>$year_start,
	        'year_end'=>$year_end,
	        'model_search'=>$model_search,
	        'model_search'=>$model_search,
	        'model_search_score'=>$model_search_score,
	        'model_search_graph'=>$model_search_graph,
	        'arr_course_title'=>$arr_course_title,
	        'arr_count_course'=>$arr_count_course,
	        'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
	    ));
		exit();
    } // if(isset($_GET["search"]))

		$this->render('exam_ship', array(
			'model_course'=>$model_course,
			'model_department'=>$model_department,
			'model_position'=>$model_position,
			'year_start'=>$year_start,
			'year_end'=>$year_end,
			'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
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
				<option value="" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "เลือกรุ่นของหลักสูตร";
					}else{
						echo "Select Gen";
					}
					?>
				</option>
				<option value="0">
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "ไม่มีรุ่น";
					}else{
						echo "No Gen";
					}
					?>
				</option>
				<?php
				foreach ($model_gen as $key => $value) {
					?>
					<option value="<?= $value->gen_id ?>"><?= $value->gen_title ?></option>
					<?php
				}
			}else{
				?>
				<option value="0" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "ไม่มีรุ่น";
					}else{
						echo "No Gen";
					}
					?>
				</option>
				<?php
			}
		}else{
			?>
			<option value="" selected>
				<?php 
				if(Yii::app()->session['lang'] != 1){
					echo "เลือกรุ่นของหลักสูตร";
				}else{
					echo "Select Gen";
				}
				?>
			</option>
			<?php
		}
	}

	public function actionGetDepartment(){
		$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == 2 || $authority == 3){
			$_POST["employee_type"] = $user_login->profile->type_employee;
		}

		if(isset($_POST["employee_type"]) && $_POST["employee_type"] != ""){
			if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
				$langId = Yii::app()->session['lang'] = 1;
			}else{
				$langId = Yii::app()->session['lang'];
			}

			$model_department = Department::model()->findAll(array(
				'condition' => 'active=:active AND type_employee_id=:type_employee_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y', ':type_employee_id'=>$_POST["employee_type"], ':lang_id'=>1),
				'order' => 'dep_title ASC'
			));

			if(!empty($model_department)){
				?>
				<option value="" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "เลือกฝ่าย/แผนก";
					}else{
						echo "Select Department";
					}
					?>
				</option>
				<?php
				foreach ($model_department as $key => $value) {					
					?>
					<option value="<?= $value->id ?>"><?= $value->dep_title ?></option>
					<?php
				}
			}else{
				?>
				<option value="" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "ไม่มีฝ่าย/แผนก";
					}else{
						echo "No Department";
					}
					?>
				</option>
				<?php
			}
		}else{
			?>
			<option value="" selected>
				<?php 
				if(Yii::app()->session['lang'] != 1){
					echo "เลือกฝ่าย/แผนก";
				}else{
					echo "Select Department";
				}
				?>
			</option>
			<?php
		}


	}

	public function actionGetPosition(){

		$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == 2){
			$_POST["department_id"] = $user_login->department_id;
		}
		
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
				<option value="" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "เลือกตำแหน่ง";
					}else{
						echo "Select Position";
					}
					?>
				</option>
				<?php
				foreach ($model_position as $key => $value) {					
					?>
					<option value="<?= $value->id ?>"><?= $value->position_title ?></option>
					<?php
				}
			}else{
				?>
				<option value="" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "ไม่มีตำแหน่ง";
					}else{
						echo "No Position";
					}
					?>
				</option>
				<?php
			}
		}else{
			?>
			<option value="" selected>
				<?php 
				if(Yii::app()->session['lang'] != 1){
					echo "เลือกตำแหน่ง";
				}else{
					echo "Select Position";
				}
				?>
			</option>
			<?php
		}
	}

	public function actionGetLevel(){

		$user_login = User::model()->findByPk(Yii::app()->user->id);
		$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
		$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

		if($authority == 3){
			$_POST["position_id"] = $user_login->position_id;
		}

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
				<option value="" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "เลือกเลเวล";
					}else{
						echo "Select Level";
					}
					?>
				</option>
				<?php
				foreach ($model_branch as $key => $value) {
					?>
					<option value="<?= $value->id ?>"><?= $value->branch_name ?></option>
					<?php
				}
			}else{
				?>
				<option value="" selected>
					<?php 
					if(Yii::app()->session['lang'] != 1){
						echo "ไม่มีเลเวล";
					}else{
						echo "No Level";
					}
					?>
				</option>
				<?php
			}
		}else{
			?>
			<option value="" selected>
				<?php 
				if(Yii::app()->session['lang'] != 1){
					echo "เลือกเลเวล";
				}else{
					echo "Select Level";
				}
				?>
			</option>
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
		$result = '
		<style type="text/css"> 
			body{ 
				font-family:"garuda"; 
				font-size:10px;
			}
			table{ 
				width:100%;
				border-collapse: collapse; 
			}
			table, th, td {
				border: 1px solid black;
				text-align:center
			}
			th{
				color: #fff;
			}
		</style>
		';
		$result .= urldecode($_POST["text_element1"]);
		$page = mb_convert_encoding($result, 'UTF-8', 'UTF-8');
		$mPDF->WriteHTML($page);
		// $mPDF->Output();
		$mPDF->Output('exportPDF.pdf', 'D');


	}






	public function actionCourseAll(){ // อบรม
		if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
			$msg = $label->label_alert_msg_plsLogin;
			Yii::app()->user->setFlash('msg',$msg);
			Yii::app()->user->setFlash('icon','warning');
			$this->redirect(array('site/index'));
			exit();
		}else{
			$user_login = User::model()->findByPk(Yii::app()->user->id);
			$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
			$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

			if($authority != 1 && $authority != 2 && $authority != 3){
				$this->redirect(array('report/index'));
				exit();
			}
		}

		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}

		//------------------- ค่า form search ------------------------//
		$model_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
			'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
			'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
			'order' => 'course_title ASC'
		));

		// if($authority == 1){
		// 	$model_department = Department::model()->findAll(array(
		// 		'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	 //    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>1), //1=เรือ 2=office
	 //    	'order' => 'dep_title ASC'    	
	 //    ));
		// }else{
			$model_department = [];
		// }

		if($authority == 2){
			$model_position = Position::model()->findAll(array(
				'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y',':department_id'=>$user_login->department_id,':lang_id'=>1),
				'order' => 'position_title ASC'
			));
		}else{
			$model_position = [];
		}

		if($authority == 3){
			$model_level = Branch::model()->findAll(array(
				'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y',':position_id'=>$user_login->position_id,':lang_id'=>1),
				'order' => 'branch_name ASC'
			));
		}else{
			$model_level = [];
		}

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

			if($_GET["search"]["course_id"] != ""){
    			$search_course = CourseOnline::model()->findAll("active='y' AND lang_id=1 AND course_id='".$_GET["search"]["course_id"]."'");

$model_gen = CourseGeneration::model()->findAll(array(
	'condition' => 'active=:active AND course_id=:course_id',
	'params' => array(':active'=>'y', ':course_id'=>$_GET["search"]["course_id"]),
	'order' => 'gen_title ASC'    	
));

    		}else{
    			$search_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
    				'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
    				'params' => array(':active'=>'y', ':lang_id'=>1),
    				'order' => 'course_title ASC'
    			));
    		}

    		if($_GET["search"]["end_year"] == "" && $_GET["search"]["start_year"] == ""){ // ไม่ใช่ช่วงปี

    		$arr_course_gen = [];
    		$arr_course_graph = [];
    		if(!empty($search_course)){
    			foreach ($search_course as $key_c => $value_c) {
    				$arr_course_gen[$key_c]["course_id"] = $value_c->course_id;    
    				$arr_course_graph[$value_c->course_id]["title"] = $value_c->course_title;
    				$arr_course_graph[$value_c->course_id]["register"] = 0;		
    				$arr_course_graph[$value_c->course_id]["pass"] = 0;		
    				$key_gen = 0;

$gen_all= [];
if($_GET["search"]["gen_id"] != ""){
	$value_c->CourseGeneration = CourseGeneration::model()->findAll("gen_id=".$_GET["search"]["gen_id"]);

	if(!empty($value_c->CourseGeneration)){
		foreach ($value_c->CourseGeneration as $key_cg => $value_cg) {
			if($value_cg->active == 'y'){
				$gen_all[] = $value_cg->gen_id;
			}
		}
	}	
}else{

	if(!empty($value_c->CourseGeneration)){
		$gen_all[] = 0;
		foreach ($value_c->CourseGeneration as $key_cg => $value_cg) {
			if($value_cg->active == 'y'){
				$gen_all[] = $value_cg->gen_id;
			}
		}
	}

}
    				// else{
    					if(!empty($gen_all)){
    						foreach ($gen_all as $key_cg => $value_cg) {
    								$arr_course_gen[$key_c]["gen"][$key_gen]["gen_id"] = $value_cg;

$criteria = new CDbCriteria;
$criteria->addCondition('user.id IS NOT NULL');
$criteria->compare('t.active', 'y');
$criteria->compare('t.course_id', $value_c->course_id);
$criteria->compare('t.gen_id', $value_cg);
$criteria->compare('user.superuser',0);

if($_GET["search"]["employee"] != ""){
	if($_GET["search"]["employee"] == 1){
		$criteria->compare('pro.type_employee', 1); //1=เรือ
	}elseif($_GET["search"]["employee"] == 2){
		$criteria->compare('pro.type_employee', 2); //2=office
	}else{
		$criteria->addCondition('pro.type_employee IS NOT NULL');
	}

$model_department = Department::model()->findAll(array(
	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
    'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>$_GET["search"]["employee"]),
    'order' => 'dep_title ASC'    	
 ));

}else{
	$criteria->addCondition('pro.type_employee IS NOT NULL');
}

if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
	$_GET["search"]["department"] = $user_login->department_id;
}
if($_GET["search"]["department"] != ""){
	$criteria->compare('user.department_id', $_GET["search"]["department"]);

	$model_position = Position::model()->findAll(array(
		'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
		'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
		'order' => 'position_title ASC'
	));

	if($authority == 3){ // ผู้จัดการแผนก
		$_GET["search"]["position"] = $user_login->position_id;
	}
	if($_GET["search"]["position"] != ""){
		$criteria->compare('user.position_id', $_GET["search"]["position"]);

		$model_level = Branch::model()->findAll(array(
			'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
			'params' => array(':active'=>'y',':position_id'=>$_GET["search"]["position"],':lang_id'=>1),
			'order' => 'branch_name ASC'
		));

		if($_GET["search"]["level"] != ""){
			$criteria->compare('user.branch_id', $_GET["search"]["level"]);
		}
	}
}

if($_GET["search"]["start_date"] != "" && $_GET["search"]["end_date"] != ""){
	if($_GET["search"]["start_date"] != ""){
		$criteria->compare('t.start_date', ">=".$_GET["search"]["start_date"]." 00:00:00");
	}
	if($_GET["search"]["end_date"] != ""){
		$criteria->compare('t.start_date', "<=".$_GET["search"]["end_date"]." 23:59:59");
	}
}

$criteria->order = 't.course_id ASC, t.gen_id ASC';
$LogStartcourse = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

$num_pass = 0;
$num_nopass = 0;
$num_prepass = 0;
$user_pass = [];
$score_passpost = [];
$score_passpre = [];


if(!empty($LogStartcourse)){
	foreach ($LogStartcourse as $key_lsc => $value_lsc) {

		$passpost_course = Coursescore::model()->find("course_id='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND user_id='".$value_lsc->user_id."' AND active='y' AND type='post' AND score_past='y'");

		$passpre_course = Coursescore::model()->find("course_id='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND user_id='".$value_lsc->user_id."' AND active='y' AND type='pre' AND score_past='y'");
		if(!empty($passpost_course)){
			$num_pass++;
			$user_pass[] = $passpost_course->user_id;
			$score_passpost[] = $passpost_course->score_number;
		}

		if(!empty($passpre_course)){
			$num_prepass++;
			$score_passpre[] = $passpre_course->score_number;
		}		


	}
} // if(!empty($LogStartcourse))

if(!empty($LogStartcourse)){
	foreach ($LogStartcourse as $key_lsc => $value_lsc) {

		$nopasspost_course = Coursescore::model()->find("course_id='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND user_id = '".$value_lsc->user_id."'  AND active='y' AND type='post' AND score_past='n' ");
		if(!empty($nopasspost_course) && !in_array($nopasspost_course->user_id, $user_pass)){
			$num_nopass++;
		}
	}
} // if(!empty($LogStartcourse))

if($num_pass > 0){
$meanposttest = number_format( array_sum($score_passpost) / $num_pass , 2) ;
}else{
$meanposttest = 0 ;
}

if($num_prepass > 0){
$meanpretest =  number_format(array_sum($score_passpre) / $num_prepass, 2);
}else{
$meanpretest = 0 ;
}
$percentpass = ($num_pass / count($LogStartcourse)) * 100;
$arr_course_gen[$key_c]["gen"][$key_gen]["register"] = count($LogStartcourse);
$arr_course_gen[$key_c]["gen"][$key_gen]["postpass"] = $num_pass;
$arr_course_gen[$key_c]["gen"][$key_gen]["postnopass"] = $num_nopass;
$arr_course_gen[$key_c]["gen"][$key_gen]["postnolearn"] = count($LogStartcourse) - ( $num_pass + $num_nopass );

$arr_course_gen[$key_c]["gen"][$key_gen]["percentpass"] = number_format($percentpass , 2);
$arr_course_gen[$key_c]["gen"][$key_gen]["meanposttest"] = $meanposttest;
$arr_course_gen[$key_c]["gen"][$key_gen]["meanpretest"] = $meanpretest;


$arr_course_graph[$value_c->course_id]["register"] = $arr_course_graph[$value_c->course_id]["register"]+count($LogStartcourse);
$arr_course_graph[$value_c->course_id]["pass"] = $arr_course_graph[$value_c->course_id]["pass"]+$num_pass;


    								$key_gen++;
    							// } // if($value_cg->active == 'y')
    						} // foreach ($value_c->CourseGeneration
    					}else{ // if(!empty($value_c->CourseGeneration))
    						$arr_course_gen[$key_c]["gen"] = [];
    					}
    				// }

    			} //foreach ($search_course
    		} //if(!empty($search_course))

}else{ // if(isset($_GET["search"]["end_year"])  // ช่วงปี

	$arr_course_year = [];
	if(!empty($search_course)){		
		foreach ($search_course as $key_c => $value_c) {

			for ($year=$_GET["search"]["start_year"]; $year <= 2020 ; $year++) { 
						$arr_course_year[$year][$value_c->course_id]["register"] = 0;
						$arr_course_year[$year][$value_c->course_id]["pass"] = 0;

						$criteria = new CDbCriteria;
						$criteria->addCondition('user.id IS NOT NULL');
						$criteria->compare('t.active', 'y');
						$criteria->compare('t.course_id', $value_c->course_id);
						
						$criteria->compare('user.superuser',0);

						if($_GET["search"]["employee"] != ""){
							if($_GET["search"]["employee"] == 1){
								$criteria->compare('pro.type_employee', 1); //1=เรือ
							}elseif($_GET["search"]["employee"] == 2){
								$criteria->compare('pro.type_employee', 2); //2=office
							}else{
								$criteria->addCondition('pro.type_employee IS NOT NULL');
							}
$model_department = Department::model()->findAll(array(
	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>$_GET["search"]["employee"]),
	'order' => 'dep_title ASC'    	
));

						}else{
							$criteria->addCondition('pro.type_employee IS NOT NULL');
						}

						if($_GET["search"]["gen_id"] != ""){
							$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
						}

						if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
							$_GET["search"]["department"] = $user_login->department_id;
						}
						if($_GET["search"]["department"] != ""){
							$criteria->compare('user.department_id', $_GET["search"]["department"]);

$model_position = Position::model()->findAll(array(
	'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
	'order' => 'position_title ASC'
));

						if($authority == 3){ // ผู้จัดการแผนก
							$_GET["search"]["position"] = $user_login->position_id;
						}
						if($_GET["search"]["position"] != ""){
							$criteria->compare('user.position_id', $_GET["search"]["position"]);

$model_level = Branch::model()->findAll(array(
	'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y', ':position_id'=>$_GET["search"]["position"], ':lang_id'=>1),
	'order' => 'branch_name ASC'
));

							if($_GET["search"]["level"] != ""){
								$criteria->compare('user.branch_id', $_GET["search"]["level"]);
							}

						}

						}

						$criteria->compare('t.start_date', ">=".$_GET["search"]["start_year"]."-01-01"." 00:00:00");
						$criteria->compare('t.start_date', "<=".$_GET["search"]["end_year"]."-12-31"." 23:59:59");

						$criteria->order = 't.course_id ASC, t.gen_id ASC';
						$LogStartcourse = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);


$num_pass = 0;
$num_notlearn = 0;

if(!empty($LogStartcourse)){
	foreach ($LogStartcourse as $key_lsc => $value_lsc) {

		$passpost_course = Coursescore::model()->find("course_id='".$value_lsc->course_id."' AND gen_id='".$value_lsc->gen_id."' AND user_id='".$value_lsc->user_id."' AND active='y' AND type='post' AND score_past='y'");

		if(!empty($passpost_course)){
			$num_pass++;
		}


	}
}

					$arr_course_year[$year][$value_c->course_id]["register"] = $arr_course_year[$year][$value_c->course_id]["register"]+count($LogStartcourse);
					$arr_course_year[$year][$value_c->course_id]["pass"] = $arr_course_year[$year][$value_c->course_id]["pass"]+$num_pass;

			} //for ($i=$_GET["search"]["start_year"]
		} // foreach ($search_course
    } // if(!empty($search_course))



} // ช่วงปี

    		$this->render('detail-2', array(
    			'model_course'=>$model_course,
    			'model_gen'=>$model_gen,
    			'model_department'=>$model_department,
    			'model_position'=>$model_position,
    			'model_level'=>$model_level,
    			'year_start'=>$year_start,
    			'year_end'=>$year_end,
    			'authority'=>$authority,
    			'type_em'=>$type_em,
    			'user_login'=>$user_login,
    			'model_search'=>$arr_course_gen,
    			'model_graph'=>$arr_course_graph,
    			'model_year'=>$arr_course_year,
    		));
    		exit();
		} //if(isset($_GET["search"]))

		$this->render('detail-2', array(
			'model_course'=>$model_course,
			'model_department'=>$model_department,
			'model_position'=>$model_position,
			'model_level'=>$model_level,
			'year_start'=>$year_start,
			'year_end'=>$year_end,
			'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
		));
	}



	public function actionAssessment(){
		if (Yii::app()->user->id == null) {   // ต้อง login ถึงจะเห็น
			$msg = $label->label_alert_msg_plsLogin;
			Yii::app()->user->setFlash('msg',$msg);
			Yii::app()->user->setFlash('icon','warning');
			$this->redirect(array('site/index'));
			exit();
		}else{
			$user_login = User::model()->findByPk(Yii::app()->user->id);
			$authority = $user_login->report_authority; // 1=ผู้บริการ 2=ผู้จัดการฝ่ายDep 3=ผู้จัดการแผนกPosi
			$type_em = $user_login->profile->type_employee; // 1=คนเรือ 2=office

			if($authority != 1 && $authority != 2 && $authority != 3){
				$this->redirect(array('report/index'));
				exit();
			}
		}

		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}

		//------------------- ค่า form search ------------------------//
		$model_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
			'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
			'params' => array(':active'=>'y', ':lang_id'=>$langId, ),
			'order' => 'course_title ASC'
		));

		// if($authority == 1){
		// 	$model_department = Department::model()->findAll(array(
		// 		'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
	 //    	'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>1), //1=เรือ 2=office
	 //    	'order' => 'dep_title ASC'    	
	 //    ));
		// }else{
			$model_department = [];
		// }

		if($authority == 2){
			$model_position = Position::model()->findAll(array(
				'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y',':department_id'=>$user_login->department_id,':lang_id'=>1),
				'order' => 'position_title ASC'
			));
		}else{
			$model_position = [];
		}

		if($authority == 3){
			$model_level = Branch::model()->findAll(array(
				'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
				'params' => array(':active'=>'y',':position_id'=>$user_login->position_id,':lang_id'=>1),
				'order' => 'branch_name ASC'
			));
		}else{
			$model_level = [];
		}

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

			if($_GET["search"]["course_id"] != ""){
    			$search_course = CourseOnline::model()->findAll("active='y' AND lang_id=1 AND course_id='".$_GET["search"]["course_id"]."'");


$model_gen = CourseGeneration::model()->findAll(array(
	'condition' => 'active=:active AND course_id=:course_id',
	'params' => array(':active'=>'y', ':course_id'=>$_GET["search"]["course_id"]),
	'order' => 'gen_title ASC'    	
));

    		}else{
    			$search_course = CourseOnline::model()->with('CategoryTitle')->findAll(array(
    				'condition' => 'course.active=:active AND course.lang_id=:lang_id AND categorys.active=:active',
    				'params' => array(':active'=>'y', ':lang_id'=>1),
    				'order' => 'course_title ASC'
    			));
    		}

    		if($_GET["search"]["end_year"] == "" && $_GET["search"]["start_year"] == ""){ // ไม่ใช่ช่วงปี

    		$arr_course_gen = [];
    		$arr_course_graph = [];
    		if(!empty($search_course)){
    			foreach ($search_course as $key_c => $value_c) {
    				$arr_course_gen[$key_c]["course_id"] = $value_c->course_id;    
    				$arr_course_graph[$value_c->course_id]["title"] = $value_c->course_title;
    				$arr_course_graph[$value_c->course_id]["register"] = 0;		
    				$arr_course_graph[$value_c->course_id]["pass"] = 0;		
    				$key_gen = 0;

$gen_all= [];
if($_GET["search"]["gen_id"] != ""){
	$value_c->CourseGeneration = CourseGeneration::model()->findAll("gen_id=".$_GET["search"]["gen_id"]);

	if(!empty($value_c->CourseGeneration)){
		foreach ($value_c->CourseGeneration as $key_cg => $value_cg) {
			if($value_cg->active == 'y'){
				$gen_all[] = $value_cg->gen_id;
			}
		}
	}	
}else{

	if(!empty($value_c->CourseGeneration)){
		$gen_all[] = 0;
		foreach ($value_c->CourseGeneration as $key_cg => $value_cg) {
			if($value_cg->active == 'y'){
				$gen_all[] = $value_cg->gen_id;
			}
		}
	}

}
    				// else{
    					if(!empty($gen_all)){
    						foreach ($gen_all as $key_cg => $value_cg) {
    								$arr_course_gen[$key_c]["gen"][$key_gen]["gen_id"] = $value_cg;

// var_dump($value_cg);
// var_dump($value_c->course_id);

$criteria = new CDbCriteria;
$criteria->addCondition('user.id IS NOT NULL');
$criteria->compare('t.active', 'y');
$criteria->compare('t.course_id', $value_c->course_id);
$criteria->compare('t.gen_id', $value_cg);
$criteria->compare('user.superuser',0);

if($_GET["search"]["employee"] != ""){
	if($_GET["search"]["employee"] == 1){
		$criteria->compare('pro.type_employee', 1); //1=เรือ
	}elseif($_GET["search"]["employee"] == 2){
		$criteria->compare('pro.type_employee', 2); //2=office
	}else{
		$criteria->addCondition('pro.type_employee IS NOT NULL');
	}

$model_department = Department::model()->findAll(array(
	'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
    'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>$_GET["search"]["employee"]),
    'order' => 'dep_title ASC'    	
 ));

}else{
	$criteria->addCondition('pro.type_employee IS NOT NULL');
}

if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
	$_GET["search"]["department"] = $user_login->department_id;
}
if($_GET["search"]["department"] != ""){
	$criteria->compare('user.department_id', $_GET["search"]["department"]);

	$model_position = Position::model()->findAll(array(
		'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
		'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
		'order' => 'position_title ASC'
	));

	if($authority == 3){ // ผู้จัดการแผนก
		$_GET["search"]["position"] = $user_login->position_id;
	}
	if($_GET["search"]["position"] != ""){
		$criteria->compare('user.position_id', $_GET["search"]["position"]);

		$model_level = Branch::model()->findAll(array(
			'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
			'params' => array(':active'=>'y',':position_id'=>$_GET["search"]["position"],':lang_id'=>1),
			'order' => 'branch_name ASC'
		));

		if($_GET["search"]["level"] != ""){
			$criteria->compare('user.branch_id', $_GET["search"]["level"]);
		}
	}
}

if($_GET["search"]["start_date"] != "" && $_GET["search"]["end_date"] != ""){
	if($_GET["search"]["start_date"] != ""){
		$criteria->compare('t.start_date', ">=".$_GET["search"]["start_date"]." 00:00:00");
	}
	if($_GET["search"]["end_date"] != ""){
		$criteria->compare('t.start_date', "<=".$_GET["search"]["end_date"]." 23:59:59");
	}
}

$criteria->order = 't.course_id ASC, t.gen_id ASC';
$LogStartcourse = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);
$num_pass = 0;
$num_nopass = 0;
$num_prepass = 0;
$user_pass = [];
$score_passpost = [];
$score_passpre = [];

$course_title = CourseOnline::model()->findByPk($_GET["search"]["course_id"]);
$course_teacher = CourseTeacher::model()->find(array(
	'condition' => ' course_id=:course_id',
	'params' => array(':course_id'=>$_GET["search"]["course_id"]),
));
$header = $course_teacher->q_header;
$teacher_id = $course->teacher_id;
$header_id = $header->survey_header_id;


if(!empty($LogStartcourse)){
	foreach ($LogStartcourse as $key_lsc => $value_lsc) {
		$user_pass[] = $value_lsc->user_id;
	}
} 

$user_id_chk = implode(",",$user_pass);

if (count($header->sections) > 0 && !empty($LogStartcourse)) {	

			$sections = $header->sections;
			$total_section = [];
			$countquest_section = [];
			$title_section = [];

	foreach ($sections as $sectionKey => $sectionValue) {
		if (count($sectionValue->questions) > 0) {
			foreach ($sectionValue->questions as $questionKey => $questionValue) {
					if($questionValue->input_type_id == 4){

                                        if (count($questionValue->choices) > 0) {
                                            $labelArray = array();
                                            $countArray = array();
                                            $dataArray = array();

                                            $dataArray[] = array('คำถาม', 'ค่าเฉลี่ย');
                                            $date_table = "";
                                            $total_average = 0;
                                            $countQuest = count($questionValue->choices);
                                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                $label = $choiceValue->option_choice_name;
                                                
                                            if($questionValue->question_range == "" || $questionValue->question_range == "5"){
                                    $sql = "SELECT 
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END) AS five,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END) AS four,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END) AS three,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END) AS two,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 0 ELSE 0 END) AS one,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END)*5 AS fivem,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END)*4 AS fourm,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END)*3 AS threem,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END)*2 AS twom,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END)*1 AS onem
                                    FROM q_answers_course INNER JOIN q_quest_ans_course ON q_answers_course.quest_ans_id = q_quest_ans_course.id ";
                                    $sql .= " WHERE header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";

                                    $sql .= " AND course_id ='" . $_GET["search"]["course_id"] . "' AND header_id='" . $header_id . "' AND choice_id ='" . $choiceValue->option_choice_id."' AND q_quest_ans_course.gen_id='".$value_cg."'";
                                    if(!empty($user_id_chk)){
                                    $sql .= " AND q_quest_ans_course.user_id in (".$user_id_chk.")";
                                	}

                                    $count = Yii::app()->db->createCommand($sql)->queryRow();
                                    $totalCount = $count['five']+$count['four']+$count['three']+$count['two']+$count['one'];
                                    $totalCountM = $count['fivem']+$count['fourm']+$count['threem']+$count['twom']+$count['onem'];
                                    $average = $totalCountM/(($totalCount!=0)?$totalCount:1);
                                    $percent = ($average*100/5)-5;
//                                    var_dump($percent);

                                }else{
                                    $sql = "SELECT 
                                    SUM(CASE WHEN (answer_numeric=10) THEN 1 ELSE 0 END) AS ten,
                                    SUM(CASE WHEN (answer_numeric=9) THEN 1 ELSE 0 END) AS nine,
                                    SUM(CASE WHEN (answer_numeric=8) THEN 1 ELSE 0 END) AS eight,
                                    SUM(CASE WHEN (answer_numeric=7) THEN 1 ELSE 0 END) AS seven,
                                    SUM(CASE WHEN (answer_numeric=6) THEN 1 ELSE 0 END) AS six,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END) AS five,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END) AS four,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END) AS three,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END) AS two,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END) AS one,
                                    SUM(CASE WHEN (answer_numeric=10) THEN 1 ELSE 0 END)*10 AS tenm,
                                    SUM(CASE WHEN (answer_numeric=9) THEN 1 ELSE 0 END)*9 AS ninem,
                                    SUM(CASE WHEN (answer_numeric=8) THEN 1 ELSE 0 END)*8 AS eightm,
                                    SUM(CASE WHEN (answer_numeric=7) THEN 1 ELSE 0 END)*7 AS sevenm,
                                    SUM(CASE WHEN (answer_numeric=6) THEN 1 ELSE 0 END)*6 AS sixm,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END)*5 AS fivem,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END)*4 AS fourm,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END)*3 AS threem,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END)*2 AS twom,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END)*1 AS onem 
                                    FROM q_answers_course INNER JOIN q_quest_ans_course ON q_answers_course.quest_ans_id = q_quest_ans_course.id ";
                                    $sql .= " WHERE header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";

                                    $sql .= " AND course_id ='" . $_GET["search"]["course_id"] . "' AND header_id='" . $header_id . "' AND choice_id ='" . $choiceValue->option_choice_id."' AND q_quest_ans_course.gen_id='".$value_cg."'";
                                    if(!empty($user_id_chk)){
                                    $sql .= " AND q_quest_ans_course.user_id in (".$user_id_chk.")";
                                	}
                                    // WHERE Country IN ('Germany', 'France', 'UK');

                                    $count = Yii::app()->db->createCommand($sql)->queryRow();
                                    $totalCount = $count['ten']+$count['nine']+$count['eight']+$count['seven']+$count['six']+$count['five']+$count['four']+$count['three']+$count['two']+$count['one'];
                                    $totalCountM = $count['tenm']+$count['ninem']+$count['eightm']+$count['sevenm']+$count['sixm']+$count['fivem']+$count['fourm']+$count['threem']+$count['twom']+$count['onem'];
                                    $average = $totalCountM/(($totalCount!=0)?$totalCount:1);
                                    $percent = $average*100/10;
                                }

                                $total_average += $percent;
                            }

                        }	
                        $countquest_section[$sectionValue->survey_section_id] += $countQuest;
                        $total_section[$sectionValue->survey_section_id] += $total_average ;
                        $title_section[$sectionValue->survey_section_id] = $sectionValue->section_title ;

                                    // var_dump(round($total_average/$countQuest,2));
                                    // var_dump($countQuest);

                                    // round($total_average/$countQuest,2)
                    }
			}
		}

	}
}


$arr_course_graph[$value_c->course_id]["register"] = $arr_course_graph[$value_c->course_id]["register"]+count($LogStartcourse);
$arr_course_graph[$value_c->course_id]["pass"] = $arr_course_graph[$value_c->course_id]["pass"]+$num_pass;


    								$key_gen++;
    							// } // if($value_cg->active == 'y')
    						} // foreach ($value_c->CourseGeneration
    					}else{ // if(!empty($value_c->CourseGeneration))
    						$arr_course_gen[$key_c]["gen"] = [];
    					}
    				// }

    			} //foreach ($search_course
    		} //if(!empty($search_course))

}else{ // if(isset($_GET["search"]["end_year"])  // ช่วงปี

	$arr_course_year = [];
	if(!empty($search_course)){		
		foreach ($search_course as $key_c => $value_c) {
			for ($year=$_GET["search"]["start_year"]; $year <= 2020 ; $year++) { 
						$arr_course_year[$year][$value_c->course_id]["register"] = 0;
						$arr_course_year[$year][$value_c->course_id]["pass"] = 0;

						$criteria = new CDbCriteria;
						$criteria->addCondition('user.id IS NOT NULL');
						$criteria->compare('t.active', 'y');
						$criteria->compare('t.course_id', $value_c->course_id);
						$criteria->compare('user.superuser',0);

						if($_GET["search"]["employee"] != ""){
							if($_GET["search"]["employee"] == 1){
								$criteria->compare('pro.type_employee', 1); //1=เรือ
							}elseif($_GET["search"]["employee"] == 2){
								$criteria->compare('pro.type_employee', 2); //2=office
							}else{
								$criteria->addCondition('pro.type_employee IS NOT NULL');
							}
							$model_department = Department::model()->findAll(array(
								'condition' => 'active=:active AND lang_id=:lang_id AND type_employee_id=:type_id',
								'params' => array(':active'=>'y', ':lang_id'=>1, ':type_id'=>$_GET["search"]["employee"]),
								'order' => 'dep_title ASC'    	
							));

						}else{
							$criteria->addCondition('pro.type_employee IS NOT NULL');
						}

						if($_GET["search"]["gen_id"] != ""){
							$criteria->compare('t.gen_id', $_GET["search"]["gen_id"]);
						}

						if($authority == 2 || $authority == 3){ // ผู้จัดการฝ่าย
							$_GET["search"]["department"] = $user_login->department_id;
						}
						if($_GET["search"]["department"] != ""){
							$criteria->compare('user.department_id', $_GET["search"]["department"]);

$model_position = Position::model()->findAll(array(
	'condition' => 'active=:active AND department_id=:department_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y',':department_id'=>$_GET["search"]["department"],':lang_id'=>1),
	'order' => 'position_title ASC'
));

						if($authority == 3){ // ผู้จัดการแผนก
							$_GET["search"]["position"] = $user_login->position_id;
						}
						if($_GET["search"]["position"] != ""){
							$criteria->compare('user.position_id', $_GET["search"]["position"]);

$model_level = Branch::model()->findAll(array(
	'condition' => 'active=:active AND position_id=:position_id AND lang_id=:lang_id',
	'params' => array(':active'=>'y', ':position_id'=>$_GET["search"]["position"], ':lang_id'=>1),
	'order' => 'branch_name ASC'
));

							if($_GET["search"]["level"] != ""){
								$criteria->compare('user.branch_id', $_GET["search"]["level"]);
							}

						}
						}

						$criteria->compare('t.start_date', ">=".$_GET["search"]["start_year"]."-01-01"." 00:00:00");
						$criteria->compare('t.start_date', "<=".$_GET["search"]["end_year"]."-12-31"." 23:59:59");

						$criteria->order = 't.course_id ASC, t.gen_id ASC';
						$LogStartcourse = LogStartcourse::model()->with("mem", "pro", "course")->findAll($criteria);

$course_title = CourseOnline::model()->findByPk($_GET["search"]["course_id"]);
$course_teacher = CourseTeacher::model()->find(array(
	'condition' => ' course_id=:course_id',
	'params' => array(':course_id'=>$_GET["search"]["course_id"]),
));
$header = $course_teacher->q_header;
$teacher_id = $course->teacher_id;
$header_id = $header->survey_header_id;



if(!empty($LogStartcourse)){
	foreach ($LogStartcourse as $key_lsc => $value_lsc) {
		$user_pass[] = $value_lsc->user_id;
	}
} 

$user_id_chk = implode(",",$user_pass);

if (count($header->sections) > 0 && !empty($LogStartcourse)) {	

			$sections = $header->sections;
			$total_section = [];
			$countquest_section = [];
			$title_section = [];

	foreach ($sections as $sectionKey => $sectionValue) {
		if (count($sectionValue->questions) > 0) {
			foreach ($sectionValue->questions as $questionKey => $questionValue) {
					if($questionValue->input_type_id == 4){

                                        if (count($questionValue->choices) > 0) {
                                            $labelArray = array();
                                            $countArray = array();
                                            $dataArray = array();

                                            $dataArray[] = array('คำถาม', 'ค่าเฉลี่ย');
                                            $date_table = "";
                                            $total_average = 0;
                                            $countQuest = count($questionValue->choices);
                                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                $label = $choiceValue->option_choice_name;
                                                
                                            if($questionValue->question_range == "" || $questionValue->question_range == "5"){
                                    $sql = "SELECT 
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END) AS five,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END) AS four,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END) AS three,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END) AS two,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 0 ELSE 0 END) AS one,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END)*5 AS fivem,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END)*4 AS fourm,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END)*3 AS threem,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END)*2 AS twom,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END)*1 AS onem
                                    FROM q_answers_course INNER JOIN q_quest_ans_course ON q_answers_course.quest_ans_id = q_quest_ans_course.id ";
                                    $sql .= " WHERE header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";

                                    $sql .= " AND course_id ='" . $_GET["search"]["course_id"] . "' AND header_id='" . $header_id . "' AND choice_id ='" . $choiceValue->option_choice_id."' AND q_quest_ans_course.gen_id='".$value_cg."'";
                                    if(!empty($user_id_chk)){
                                    $sql .= " AND q_quest_ans_course.user_id in (".$user_id_chk.")";
                                	}

                                    $count = Yii::app()->db->createCommand($sql)->queryRow();
                                    $totalCount = $count['five']+$count['four']+$count['three']+$count['two']+$count['one'];
                                    $totalCountM = $count['fivem']+$count['fourm']+$count['threem']+$count['twom']+$count['onem'];
                                    $average = $totalCountM/(($totalCount!=0)?$totalCount:1);
                                    $percent = ($average*100/5)-5;
//                                    var_dump($percent);

                                }else{
                                    $sql = "SELECT 
                                    SUM(CASE WHEN (answer_numeric=10) THEN 1 ELSE 0 END) AS ten,
                                    SUM(CASE WHEN (answer_numeric=9) THEN 1 ELSE 0 END) AS nine,
                                    SUM(CASE WHEN (answer_numeric=8) THEN 1 ELSE 0 END) AS eight,
                                    SUM(CASE WHEN (answer_numeric=7) THEN 1 ELSE 0 END) AS seven,
                                    SUM(CASE WHEN (answer_numeric=6) THEN 1 ELSE 0 END) AS six,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END) AS five,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END) AS four,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END) AS three,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END) AS two,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END) AS one,
                                    SUM(CASE WHEN (answer_numeric=10) THEN 1 ELSE 0 END)*10 AS tenm,
                                    SUM(CASE WHEN (answer_numeric=9) THEN 1 ELSE 0 END)*9 AS ninem,
                                    SUM(CASE WHEN (answer_numeric=8) THEN 1 ELSE 0 END)*8 AS eightm,
                                    SUM(CASE WHEN (answer_numeric=7) THEN 1 ELSE 0 END)*7 AS sevenm,
                                    SUM(CASE WHEN (answer_numeric=6) THEN 1 ELSE 0 END)*6 AS sixm,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END)*5 AS fivem,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END)*4 AS fourm,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END)*3 AS threem,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END)*2 AS twom,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END)*1 AS onem 
                                    FROM q_answers_course INNER JOIN q_quest_ans_course ON q_answers_course.quest_ans_id = q_quest_ans_course.id ";
                                    $sql .= " WHERE header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";

                                    $sql .= " AND course_id ='" . $_GET["search"]["course_id"] . "' AND header_id='" . $header_id . "' AND choice_id ='" . $choiceValue->option_choice_id."' ";
                                    if(!empty($user_id_chk)){
                                    $sql .= " AND q_quest_ans_course.user_id in (".$user_id_chk.")";
                                	}
                                    // WHERE Country IN ('Germany', 'France', 'UK');

                                    $count = Yii::app()->db->createCommand($sql)->queryRow();
                                    $totalCount = $count['ten']+$count['nine']+$count['eight']+$count['seven']+$count['six']+$count['five']+$count['four']+$count['three']+$count['two']+$count['one'];
                                    $totalCountM = $count['tenm']+$count['ninem']+$count['eightm']+$count['sevenm']+$count['sixm']+$count['fivem']+$count['fourm']+$count['threem']+$count['twom']+$count['onem'];
                                    $average = $totalCountM/(($totalCount!=0)?$totalCount:1);
                                    $percent = $average*100/10;
                                }

                                $total_average += $percent;
                            }

                        }	

                        $countquest_section[$sectionValue->survey_section_id] += $countQuest;
                        $total_section[$sectionValue->survey_section_id] += $total_average ;
                        $title_section[$sectionValue->survey_section_id] = $sectionValue->section_title ;

                                    // var_dump(round($total_average/$countQuest,2));
                                    // var_dump($countQuest);

                                    // round($total_average/$countQuest,2)
                    }
			}
		}

	}
}



$arr_course_graph[$value_c->course_id]["register"] = $arr_course_graph[$value_c->course_id]["register"]+count($LogStartcourse);
$arr_course_graph[$value_c->course_id]["pass"] = $arr_course_graph[$value_c->course_id]["pass"]+$num_pass;


			} //for ($i=$_GET["search"]["start_year"]
		} // foreach ($search_course
    } // if(!empty($search_course))


} // ช่วงปี

    		$this->render('assessment', array(
    			'model_course'=>$model_course,
    			'model_gen'=>$model_gen,
    			'model_department'=>$model_department,
    			'model_position'=>$model_position,
    			'model_level'=>$model_level,
    			'year_start'=>$year_start,
    			'year_end'=>$year_end,
    			'authority'=>$authority,
    			'type_em'=>$type_em,
    			'user_login'=>$user_login,
    			'model_search'=>$arr_course_gen,
    			'model_graph'=>$arr_course_graph,
    			'model_year'=>$arr_course_year,

    			'sections'=>$sections,
    			'title_section'=>$title_section,
    			'countquest_section'=>$countquest_section,
    			'total_section'=>$total_section,
    			'course_title'=>$course_title,

    		));
    		exit();
		} //if(isset($_GET["search"]))

		$this->render('assessment', array(
			'model_course'=>$model_course,
			'model_department'=>$model_department,
			'model_position'=>$model_position,
			'model_level'=>$model_level,
			'year_start'=>$year_start,
			'year_end'=>$year_end,
			'authority'=>$authority,
			'type_em'=>$type_em,
			'user_login'=>$user_login,
		));

	}





	

	
}