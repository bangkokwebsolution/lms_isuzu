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
		if ($TypeEmployee) {
				 $start_date = date("Y-m-d", strtotime($datetime_start))." 00:00:00";
				 $end_date = date("Y-m-d", strtotime($datetime_end))." 23:59:59";
      

				    $sqlAll = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_profiles.user_id = tbl_users.id ";
				    //if ($Department != "") {

				     	$sqlAll .= " INNER JOIN tbl_department ON tbl_department.id = tbl_users.department_id ";
				   // } 
				    			
				    //if($Position != "") {
								$sqlAll .= " INNER JOIN tbl_position ON tbl_position.id = tbl_users.position_id";
					// }
					  if($Leval != "") {
								$sqlAll .= " INNER JOIN tbl_Branch ON tbl_Branch.id = tbl_users.branch_id";
					}
							$sqlAll .= 	" WHERE tbl_users.del_status = 0 AND tbl_users.superuser = 0 AND tbl_users.status = '". $status ."' ";

							$sqlAll .= " AND tbl_profiles.type_employee = '".$TypeEmployee."'";

					if($Department != "") {
                            $sqlAll .= " AND tbl_users.department_id = '".$Department."'";
                    }
                    		
                    if($Position != "") {
                            $sqlAll .= " AND tbl_users.position_id = '".$Position."'";
                    }
                    if($Leval != "") {
                            $sqlAll .= " AND tbl_users.branch_id = '".$Leval."'";
                    }
                                        
                    if($datetime_start != "" && $datetime_end != "") {
                         //   $sqlAll .= " AND create_at BETWEEN '" . $start . "' AND '".$end."'";
                    	$sqlAll .= " AND tbl_users.create_at >= '" . $start_date . "' AND tbl_users.create_at <= '".$end_date."'";
                    }               
                       // $sqlAll .= " GROUP BY tbl_users.`status`";

                  $allCount = Yii::app()->db->createCommand($sqlAll)->queryAll();
                  
                  foreach ($allCount as $key => $value) {
                 
                  }
					if (!empty($allCount)) {
						$i = 1;
							$datatable .= '<div class="report-table">';
				            $datatable .= '<div class="table-responsive w-100 t-regis-language">';
				            $datatable .= '<table class="table">';       
				            $datatable .= '<thead>';
				            $datatable .= '<tr>';
				            $datatable .= '<th>ลำดับ</th>';
				            $datatable .= '<th>ฝ่าย</th>';
				            $datatable .= '<th>แผนก</th>';
				            $datatable .= '<th>เลเวล</th>';
				            $datatable .= '<th>จำนวน</th>';
				            $datatable .= '<th>สถานะอนุมัติ</th>';
				            $datatable .= '<th>คิดเป็นร้อยละ</th>';
				            $datatable .= '</tr>'; 
				            $datatable .= '</thead>';
				            $datatable .= '<tbody>';
				            
						foreach ($allCount as $key => $value) { 		     
				           	$datatable .= '<tr>';
				            $datatable .= '<td>'.$i++.'</td>';
				            $datatable .= '<td>'.$value['dep_title'].'</td>';
				            $datatable .= '<td>'.$value['position_title'].'</td>';
				            $datatable .= '<td>'.$value['branch_name'].'</td>';
				            $datatable .= '<td></td>';
				            $datatable .= '<td>';
										    if ($value['status'] == 1) {
										      $datatable .= '<span class="text-success"><i class="fas fa-check"></i>อนุมัติ</span>';
										    }else{
										      $datatable .= '<span class="text-danger"><i class="fas fa-times"></i>ไม่อนุมัติ</span>';
										    }
				            $datatable .= '</td>';
				            $datatable .= '<td></td>';
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