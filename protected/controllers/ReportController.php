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

                  $criteria = new CDbCriteria;
                  $criteria->compare('type_employee_id',2);
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
                  $criteria->compare('type_employee_id',2);
                  if($Department){
                  $criteria->compare('id',$Department);
                  }
                  $criteria->addNotInCondition('id',$result_pos_arr);
                  $criteria->compare('active','y');
                  $dep_back = Department::model()->findAll($criteria);


                  if ($status != null) {
					if (!empty($branch) || !empty($pos_back) || !empty($dep_back) ) {
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
				            if($TypeEmployee != 2){
				            $datatable .= '<th>สถานะอนุมัติ</th>';
				        	}
				            $datatable .= '<th>คิดเป็นร้อยละ</th>';
				            $datatable .= '</tr>'; 
				            $datatable .= '</thead>';
				            $datatable .= '<tbody>';
				            
						foreach ($branch as $key => $value) { 	

							$criteria = new CDbCriteria;
							$criteria->compare('branch_id',$value->id);
							$criteria->compare('position_id',$value->Positions->id);
							$criteria->compare('department_id',$value->Positions->Departments->id);
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
										      $datatable .= '<span class="text-success"><i class="fas fa-check"></i>อนุมัติ</span>';
										    }else{
										      $datatable .= '<span class="text-danger"><i class="fas fa-times"></i>ไม่อนุมัติ</span>';
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

						foreach ($pos_back as $keypos_back => $valuepos_back) { 	

							$criteria = new CDbCriteria;
							$criteria->compare('position_id',$valuepos_back->id);
							$criteria->compare('department_id',$valuepos_back->Departments->id);
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
							$usersAll = Users::model()->findAll($criteria);

							$cou_use = count($users);
							$cou_useAll = count($usersAll);
							$per_cen = ($cou_use / $cou_useAll) * 100; 

				           	$datatable .= '<tr>';
				            $datatable .= '<td>'.$i++.'</td>';
				            $datatable .= '<td>'.$valuepos_back->Departments->dep_title.'</td>';
				            $datatable .= '<td>'.$valuepos_back->position_title.'</td>';
				            $datatable .= '<td></td>';
				            $datatable .= '<td>'.$cou_use.'</td>';
				              if($TypeEmployee != 2){
				            $datatable .= '<td>';
				            if($cou_use > 0){
				            	if ($status == 1) {
				            		$datatable .= '<span class="text-success"><i class="fas fa-check"></i>อนุมัติ</span>';
				            	}else{
				            		$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>ไม่อนุมัติ</span>';
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
				            		$datatable .= '<span class="text-success"><i class="fas fa-check"></i>อนุมัติ</span>';
				            	}else{
				            		$datatable .= '<span class="text-danger"><i class="fas fa-times"></i>ไม่อนุมัติ</span>';
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