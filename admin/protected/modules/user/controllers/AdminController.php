<?php 
class AdminController extends Controller
{
	 // public function filters()
  //   {
  //       return array(
  //           'accessControl', // perform access control for CRUD operations
  //       );
  //   }

  //   /**
  //    * Specifies the access control rules.
  //    * This method is used by the 'accessControl' filter.
  //    * @return array access control rules
  //    */
  //   public function accessRules()
  //   {
  //       return array(
  //           array('allow',  // allow all users to perform 'index' and 'view' actions
  //               'actions' => array('index', 'view'),
  //               'users' => array('*'),
  //           ),
  //           array('allow',
  //               // กำหนดสิทธิ์เข้าใช้งาน actionIndex
  //               'actions' => AccessControl::check_action(),
  //               // ได้เฉพาะ group 1 เท่านั่น
  //               'expression' => 'AccessControl::check_access()',
  //           ),
  //           array('deny',  // deny all users
  //               'users' => array('*'),
  //           ),
  //       );
  //   }

	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';

	private $_model;

	// public function filters() {
	// 		return array(
	// 				'rights',
	// 		);
	// }

	public function actionGetAjaxDivision(){
        if(isset($_GET['company_id']) && $_GET['company_id'] != ""){
            $datalist = Division::model()->findAll('active = "y" and company_id = '.$_GET['company_id']);
            if($datalist){
                    echo "<option value=''> เลือกกอง</option>";
                foreach($datalist as $index => $val){
                    echo "<option value='".$val->id."'>".$val->div_title."</option>";
                }
            }else{
                    echo "<option value=''> ไม่พบกอง</option>";
            }
        }else{
            echo "<option value=''> เลือกกอง</option>";
        }
    }

    public function actionGetAjaxDepartment(){
        if(isset($_GET['division_id']) && $_GET['division_id'] != ""){
            $datalist = Department::model()->findAll('active = "y" and division_id = '.$_GET['division_id']);
            if($datalist){
                    echo "<option value=''> เลือกแผนก</option>";
                foreach($datalist as $index => $val){
                    echo "<option value='".$val->id."'>".$val->dep_title."</option>";
                }
            }else{
                    echo "<option value=''> ไม่พบแผนก</option>";
            }
        }else{
            echo "<option value=''> เลือกแผนก</option>";
        }
    }

    public function actionGetAjaxPosition(){
        if(isset($_GET['department_id']) && $_GET['department_id'] != ""){
            $datalist = Position::model()->findAll('active = "y" and department_id = '.$_GET['department_id']);
            if($datalist){
                    echo "<option value=''> เลือกตำแหน่ง</option>";
                foreach($datalist as $index => $val){
                    echo "<option value='".$val->id."'>".$val->position_title."</option>";
                }
            }else{
                    echo "<option value=''> ไม่พบตำแหน่ง</option>";
            }
        }else{
            echo "<option value=''> เลือกตำแหน่ง</option>";
        }
    }

    public function actionApprove()
	{
		$model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User'])){
        	$model->attributes=$_GET['User'];
        }
        $this->render('approve',array(
        	'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}

	public function loadDepartment($department_id){
		$data=OrgChart::model()->findAll('id=:id',
			array(':id'=>$department_id)
		);

		$data=CHtml::listData($data,'id','title');

		return $data;
	}

	public function actionEditTable(){
		$model = TypeUser::model()->findAll(array('condition'=>'active = 1'));
		foreach ($model as $key => $value) {
			if($value->id == 1){
				$value->name = 'ผู้ใช้งานทั่วไป(ลงทะเบียนหน้าบ้าน)';
			}else if($value->id == 2){
				$value->name = 'ผู้ใช้งานทั่วไป(ลงทะเบียนหลังบ้าน)';
			}else if($value->id == 3){
				$value->name = 'บุคลากรภายใน';
			}else{
				$value->active = 0;
			}
			$value->save();
		}

	}

	public function actionStatus()
	{
		$model=new ReportUser();
		$model->unsetAttributes();
		if(isset($_GET['ReportUser'])){
			//$_GET['ReportUser']['type_user'] = 1 General , 2 = Staff
			//type_user 1,2 General
			//type_user 3 Staff
			$model->attributes=$_GET['ReportUser'];
		}

		$this->render('status',array('model'=>$model));
	}

	public function actionExport_excel(){
		$this->layout = FALSE;
		$model=new ReportUser();
		$model->unsetAttributes();
		if(isset($_GET['ReportUser'])){
			$model->attributes=$_GET['ReportUser'];
		}

		$contentView = $this->renderPartial('excel_export', array(
			'model'=>$model
		));



		echo '<meta charset="UTF-8">';
		echo $contentView;
		exit();
	}

	public function actionAdmin()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
        	$model->attributes=$_GET['User'];

        $this->render('index',array(
        	'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}

	public function actionGeneral()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        $model->supper_user_status = true;
        if(isset($_GET['User']))
        	$model->attributes=$_GET['User'];
        $this->render('index',array(
        	'model'=>$model,
        ));
	}

	public function actionActive(){
		$id = $_POST['id'];
		$model = User::model()->findByPk($id);
		//$member = Helpers::lib()->ldapTms($model->email);
		if($model->status == 1){
			$model->status = 0;
		} else {
			$model->status = 1;
		}
		// $model->passwordChange = 1;

		// $password = $this->RandomPassword();
		// $model->password = md5($password);
		// $model->newpassword = $password;
		// if($member['count'] > 0){
		// 	$model->newpassword = $model->email;
		// }else{
		// 	$model->newpassword = $model->identification;
		// }
		$genpass = substr($model->identification, -6);
		$model->username = $model->identification;
		$model->save(false);
		$to['email'] = $model->email;
		$to['firstname'] = $model->profile->firstname;
		$to['lastname'] = $model->profile->lastname;
		$message = $this->renderPartial('_mail_message',array('model' => $model,'genpass' => $genpass),true);
		if($message){
			 $send = Helpers::lib()->SendMail($to,'อนุมัติการสมัครสมาชิก',$message);
			//$send = Helpers::lib()->SendMailNotification($to,'อนุมัติการสมัครสมาชิก',$message);
		}
		$this->redirect(array('/user/admin/approve'));
	}

	public function actionIdCard($id)
	{
		// var_dump($id);exit();
		$model= User::model()->findbyPk($id);
		$regis = new RegistrationForm;
		$regis->id = $model->id;
		$profile= $model->profile;

		if(isset($_POST['User']))
		{
			$uploadFile = CUploadedFile::getInstance($model,'pic_user');
			if(isset($uploadFile))
			{
				$uglyName = strtolower($uploadFile->name);
				$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
				$beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
				$model->pic_cardid = $beautifulName;
				$model->save(false);
				Yii::app()->user->setFlash('registration','แก้ไขสำเร็จ');
				if(isset($uploadFile))
				{
					/////////// SAVE IMAGE //////////
					Yush::init($regis);
					$originalPath = Yush::getPath($regis, Yush::SIZE_ORIGINAL, $model->pic_cardid);
					$thumbPath = Yush::getPath($regis, Yush::SIZE_THUMB, $model->pic_cardid);
					$smallPath = Yush::getPath($regis, Yush::SIZE_SMALL, $model->pic_cardid);
					// Save the original resource to disk
					$uploadFile->saveAs($originalPath);

					// Create a small image
					$smallImage = Yii::app()->phpThumb->create($originalPath);
					$smallImage->resize(385, 220);
					$smallImage->save($smallPath);

					// Create a thumbnail
					$thumbImage = Yii::app()->phpThumb->create($originalPath);
					$thumbImage->resize(350, 200);
					$thumbImage->save($thumbPath);

				}
			}
			// var_dump($model->pic_cardid);exit();
		}
		$this->render('id_card',array(
			'model'=>$model,
			'profile'=>$profile
		));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}

	private function RandomPassword(){
		$number="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$i = '';
		$result = '';
		for($i==1;$i<8;$i++){ // จำนวนหลักที่ต้องการสามารถเปลี่ยนได้ตามใจชอบนะครับ จาก 5 เป็น 3 หรือ 6 หรือ 10 เป็นต้น
			$random=rand(0,strlen($number)-1); //สุ่มตัวเลข
			$cut_txt=substr($number,$random,1); //ตัดตัวเลข หรือ ตัวอักษรจากตำแหน่งที่สุ่มได้มา 1 ตัว
			$result.=substr($number,$random,1); // เก็บค่าที่ตัดมาแล้วใส่ตัวแปร
			$number=str_replace($cut_txt,'',$number); // ลบ หรือ แทนที่ตัวอักษร หรือ ตัวเลขนั้นด้วยค่า ว่าง
		}
		return $result;
	}


	public function actionExcelOld()
	{
		$HisImportArr = array();
		$HisImportErrorArr = array();
		$HisImportAttrErrorArr = array();
		$HisImportErrorMessageArr = array();
		$HisImportUserPassArr = array();
		//Student
		if (isset($_FILES['excel_import_student'])) {
			$extensionFile = pathinfo($_FILES['excel_import_student']['name'], PATHINFO_EXTENSION);
			$fullPath = Yii::app()->basePath.'/../../uploads/temp_excel.'.$extensionFile;
			if (!move_uploaded_file($_FILES["excel_import_student"]["tmp_name"],$fullPath)) {
				echo "Move File Error!!!";
				exit;
			}
			$file_path = $fullPath;
			$sheet_array = Yii::app()->yexcel->readActiveSheet($file_path);
			$HisImportArr = $sheet_array;
			
			foreach ($sheet_array as $key => $valueRow) {
				if ($key == 1) { // Header first row
				}else { // Data Row ALL 2 -
					// $passwordGen = $this->RandomPassword();
					// $HisImportUserPassArr[$key]['password'] = $passwordGen;

					$modelUser = new User;
					$modelUser->email = $valueRow['A'];
					$modelUser->username = $valueRow['A'];
					$modelUser->password = md5($valueRow['B']); // Random password
					$modelUser->verifyPassword = $modelUser->password;
					// $modelUser->department_id = $valueRow['G'];
					// $modelUser->company_id = $valueRow['F'];
					// $modelUser->division_id = $valueRow['G'];
					// $modelUser->department_id = $valueRow['H'];
					// $modelUser->position_id = $valueRow['I'];
					// $modelUser->orgchart_lv2 = $valueRow['J'];
					$modelUser->type_register = 2;
					$modelUser->superuser = 0;
					// $modelUser->auditor_id = $valueRow['G'];
					// $modelUser->bookkeeper_id = $valueRow['H'];

					$member = Helpers::lib()->ldapTms($modelUser->email);
					if($member['count'] > 0){ //TMS
						$modelUser->type_register = 3;
						Helpers::lib()->_insertLdap($member);
						$modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
						$modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
						$modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

						$modelUser->division_id = $modelDivision->id;
						$modelUser->station_id = $modelStation->station_id;
						$modelUser->department_id = $modelDepartment->id;
						$modelUser->password = md5($model->email);
						$modelUser->verifyPassword = $model->password;
						$modelUser->status = 1; //bypass not confirm
					}else{ //LMS
						$modelUser->password = md5($valueRow['B']); // Random password
						$modelUser->verifyPassword = $modelUser->password;
						// $modelUser->department_id = 2;
						$modelUser->department_id = 1;
						$modelUser->status = 0;
					}
					
					if ($modelUser->validate()) {
						// insert right
						$modelUser->save();
						$modelProfile = new Profile;
						$modelProfile->user_id = $modelUser->id;
						$modelProfile->title_id = $valueRow['C'];
						$modelProfile->firstname = $valueRow['D'];
						$modelProfile->lastname = $valueRow['E'];
						$modelProfile->identification = $valueRow['B'];
						$modelProfile->phone = $valueRow['F'];
						// $modelProfile->active = 1;
						// $modelProfile->type_user = $valueRow['F'];
						// $modelProfile->birthday = $valueRow['I'];
						// $modelProfile->age = $valueRow['K'];
						// $modelProfile->education = $valueRow['L'];
						// $modelProfile->occupation = $valueRow['M'];
						// $modelProfile->position = $valueRow['N'];
						// $modelProfile->website = $valueRow['O'];
						// $modelProfile->address = $valueRow['P'];
						// $province=Province::model()->findByAttributes(array('pv_name_th'=>$valueRow['Q']));
						// $modelProfile->province = $province->pv_id;
						// $modelProfile->tel = $valueRow['R'];
						// $modelProfile->phone = $valueRow['S'];
						// $modelProfile->fax = $valueRow['T'];
						// $modelProfile->generation = $valueRow['W'];
						// $modelProfile->contactfrom = $valueRow['V'];
						// $modelProfile->firstname_en = $valueRow['H'];
						// $modelProfile->lastname_en = $valueRow['I'];
						// $modelProfile->advisor_email1 = $valueRow['L'];
						// $modelProfile->advisor_email2 = $valueRow['M'];
						// var_dump($modelProfile);exit();
						// $modelProfile->birthday = Yii::app()->dateFormatter->format("y-M-d",strtotime($valueRow['I']));
						if($modelProfile->validate()){
							$modelProfile->save();
							$Insert_success[$key] = "สร้างชื่อผู้ใช้เรียบร้อย";
						} else {
							$HisImportErrorArr[] = $HisImportArr[$key];
							$msgAllArr = array();
							$attrAllArr = array();
							foreach($modelProfile->getErrors() as $field => $msgArr){
								$attrAllArr[] = $field;
								$msgAllArr[] = $msgArr[0];
							}

							$HisImportErrorMessageArr[$key] = implode(", ",$msgAllArr);
							$HisImportAttrErrorArr[] = $attrAllArr;
							$HisImportArr = $sheet_array;
							$deldata = User::model()->findbyPk($modelUser->id);
							$deldata->delete();
							$Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
						}


						/*$message = '
						<strong>สวัสดี คุณ' . $modelProfile->firstname . ' ' . $modelProfile->lastname . '</strong><br /><br />

						โปรดคลิกลิงค์ต่อไปนี้ เพื่อดำเนินการเข้าสู่ระบบ<br />
						<a href="' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '">' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '</a><br />
						<strong>Username</strong> : ' . $valueRow['A'] . '<br />
						<strong>Password</strong> : ' . $passwordGen . '<br /><br />

						ยินดีตอนรับเข้าสู่ระบบ Brother E-Traning<br /><br />

						ทีมงาน SET

						';
						$subject = 'ยินดีต้อนรับเข้าสู่ระบบ SET E-Training';
						$to['email'] = $valueRow['K'];
						$to['firstname'] = $valueRow['F'];
						$to['lastname'] = $valueRow['G'];

						Helpers::lib()->SendMail($to,$subject,$message);*/

						
					} else {

						/*if(!isset($orgchart->id) && $valueRow['E'] != ''){
							//$modelUser->student_board = 0;
							$modelUser->clearErrors('department_id');
							$modelUser->addError('department_id','ไม่มีแผนกนี้');
						}*/

						$HisImportErrorArr[] = $HisImportArr[$key];

						$msgAllArr = array();
						$attrAllArr = array();
						foreach($modelUser->getErrors() as $field => $msgArr){
							$attrAllArr[] = $field;
							$msgAllArr[] = $msgArr[0];
						}

						$HisImportErrorMessageArr[$key] = implode(", ",$msgAllArr);
						$HisImportAttrErrorArr[] = $attrAllArr;

//						unset($HisImportArr[$key]);
						$HisImportArr = $sheet_array;
						$Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
					}
//				}
				}
			}
			unlink($fullPath);
		}

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		$this->render('excel',array('HisImportArr'=>$HisImportArr,'HisImportUserPassArr'=>$HisImportUserPassArr,'HisImportErrorArr'=>$HisImportErrorArr,'HisImportAttrErrorArr'=>$HisImportAttrErrorArr,'HisImportErrorMessageArr'=>$HisImportErrorMessageArr,'Insert_success'=>$Insert_success));
	}

	public function actionExcel()
    {
        $model=new User('import');
        $HisImportArr = array();
		$HisImportErrorArr = array();
		$HisImportAttrErrorArr = array();
		$HisImportErrorMessageArr = array();
		$HisImportUserPassArr = array();
		$data = array();
        // if(isset($_FILES['excel_import_student']))
        $model->excel_file = CUploadedFile::getInstance($model,'excel_file');
        if(!empty($model->excel_file))
        {      
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

            $model->excel_file = CUploadedFile::getInstance($model,'excel_file');
			// $model->excel_file =  $_FILES['excel_import_student'];
           
            //if ($model->excel_file && $model->validate()) {
                // $webroot = YiiBase::getPathOfAlias('webroot');
                $webroot = Yii::app()->basePath."/../..";
                // $filename = $webroot.'/uploads/' . $model->excel_file->name . '.' . $model->excel_file->extensionName;
                $filename = $webroot.'/uploads/' . $model->excel_file->name;
                $model->excel_file->saveAs($filename);

				$sheet_array = Yii::app()->yexcel->readActiveSheet($filename);
                $inputFileName = $filename;
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFileName);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();

				$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
				$headingsArray = $headingsArray[1];

				$r = -1;
				$namedDataArray = array();
				for ($row = 2; $row <= $highestRow; ++$row) {
					$dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
					if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
						++$r;
						foreach($headingsArray as $columnKey => $columnHeading) {
							$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
						}
					}
				}

				$index = 0;
				
				foreach($namedDataArray as $key => $result){
					
					$model = new User;
					$profile=new Profile;
					$model->email = $result["email"];
					$model->username = $model->email;
					// $model->identification = $result["รหัสบัตรประชาชน"];

					$model->type_register = 2;
					$model->superuser = 0;

					$data[$key]['fullname'] = $result["ชื่อ"].' '.$result["นามสกุล"];
					$data[$key]['email'] = $result["email"];
					$data[$key]['phone'] =  $result["โทรศัพท์"];
					// $data[$key]['identification'] =  $result["รหัสบัตรประชาชน"];
					$member = Helpers::lib()->ldapTms($model->email);
					// $member['count'] = 0;
					if($member['count'] > 0){ //TMS
						$model->type_register = 3;
						Helpers::lib()->_insertLdap($member);
						$modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
						$modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
						$modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

						$model->division_id = $modelDivision->id;
						$model->station_id = $modelStation->station_id;
						$model->department_id = $modelDepartment->id;
						$model->password = md5($model->email);
						$model->verifyPassword = $model->password;
						$model->status = 1; //bypass not confirm
					}else{ //LMS
						$model->password = md5($model->email); // Random password
						$model->verifyPassword = $model->password;
						$model->department_id = 2;
						$model->status = 0;
					}

					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
					if ($model->validate()) {
						$model->save();
						$data[$key]['msg'] = 'pass';
						
						$modelProfile = new Profile;
						$modelProfile->user_id = $model->id;
						$modelProfile->title_id = $result["คำนำหน้าชื่อ"];
						$modelProfile->firstname = $result["ชื่อ"];
						$modelProfile->lastname = $result["นามสกุล"];
						// $modelProfile->identification = $result["รหัสบัตรประชาชน"];
						$modelProfile->tel = $result["โทรศัพท์"];

						if($modelProfile->validate()){
							$modelProfile->save();
							$data[$key]['msg'] = 'pass';
							
							$Insert_success[$key] = "สร้างชื่อผู้ใช้เรียบร้อย";

							$message = '
							<strong>สวัสดี คุณ' . $modelProfile->firstname . ' ' . $modelProfile->lastname . '</strong><br /><br />

							โปรดคลิกลิงค์ต่อไปนี้ เพื่อดำเนินการเข้าสู่ระบบ<br />
							<a href="' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '">' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '</a><br />
							<strong>Email</strong> : ' . $model->email . '<br />

							ยินดีตอนรับเข้าสู่ระบบ Air Asia e-Learning<br /><br />

							ทีมงาน Air Asia

							';
							$subject = 'ยินดีต้อนรับเข้าสู่ระบบ Air Asia e-Learning';
							$to['email'] = $model->email;
							$to['firstname'] = $modelProfile->firstname;
							$to['lastname'] = $modelProfile->lastname;

							$mail = Helpers::lib()->SendMail($to,$subject,$message);
						} else {

							$HisImportErrorArr[] = $HisImportArr[$key];
							$msgAllArr = array();
							$attrAllArr = array();
							foreach($modelProfile->getErrors() as $field => $msgArr){
								$attrAllArr[] = $field;
								$msgAllArr[] = $msgArr[0];
							}

							$HisImportErrorMessageArr[$key] = implode(", ",$msgAllArr);
							$data[$key]['msg'] = implode(", ",$msgAllArr);
							$HisImportAttrErrorArr[] = $attrAllArr;
							$HisImportArr = $sheet_array;
							$deldata = User::model()->findbyPk($model->id);
							$deldata->delete();
							$Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
						}
					}else{
						$msgAllArr = array();
						$attrAllArr = array();
						foreach($model->getErrors() as $field => $msgArr){
								$attrAllArr[] = $field;
								$msgAllArr[] = $msgArr[0];
						}
						$data[$key]['msg'] = implode(", ",$msgAllArr);
						// var_dump($model->getErrors());
						// exit();
					}

				} //end loop add user
                //if($model->save())
                // $this->redirect(array('import','id'=>$id));
                 $this->render('excel',array('model'=>$model,'HisImportArr'=>$HisImportArr,'HisImportUserPassArr'=>$HisImportUserPassArr,'HisImportErrorArr'=>$HisImportErrorArr,'HisImportAttrErrorArr'=>$HisImportAttrErrorArr,'HisImportErrorMessageArr'=>$HisImportErrorMessageArr,'Insert_success'=>$Insert_success,'data' => $data));
                 exit();
            //}
        }

        // $this->render('excel',array('model'=>$model));
        $this->render('excel',array('model'=>$model,'HisImportArr'=>$HisImportArr,'HisImportUserPassArr'=>$HisImportUserPassArr,'HisImportErrorArr'=>$HisImportErrorArr,'HisImportAttrErrorArr'=>$HisImportAttrErrorArr,'HisImportErrorMessageArr'=>$HisImportErrorMessageArr,'Insert_success'=>$Insert_success));
        // $this->render('import',array(
        //     'model'=>$model,
        // ));
    }

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// $gen = Generation::model()->find('active=1');
		$model=new User;
		$profile=new Profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}

		if(isset($_POST['User']))
		{
			// $Neworg = $_POST['Orgchart'];           
			// $Neworg = json_encode($Neworg);
			// $PGoup = $_POST['PGoup'];           
			// $PGoup = json_encode($PGoup);
			// $model->orgchart_lv2 = $Neworg;
			// $model->group = $PGoup;
			// $criteria=new CDbCriteria;
   //          $criteria->compare('department_id',$_POST['User']['department_id']);
   //          $criteria->compare('position_title',$_POST['User']['position_name']);
            // $position = Position::model()->find($criteria);
    //         if(!$position){
    //             $position = new Position;
    //             $position->department_id = $_POST['User']['department_id'];
    //             $position->position_title = $_POST['User']['position_name'];
    //             $position->create_date = date("Y-m-d H:i:s");
				// if(!empty($_POST['User']['department_id']) && !empty($_POST['User']['position_name']))$position->save();
    //         }
            $model->type_register = 2;
            
			// $model->position_name = $_POST['User']['position_name'];
            // $model->position_id = $position->id;
			// $model->division_id = $_POST['User']['division_id'];
			// $model->company_id = $_POST['User']['company_id'];
			$model->username = $_POST['User']['username'];
			
			// $model->identification = $_POST['User']['identification'];
			// $model->passport = $_POST['User']['passport'];
			// $model->password = $_POST['User']['password'];
			// $model->verifyPassword = $_POST['User']['verifyPassword'];

			$member = Helpers::lib()->ldapTms($model->email);

			////Test
			// $member['count'] = 0;
			if($member['count'] > 0){ //TMS
				$model->type_register = 3;
				Helpers::lib()->_insertLdap($member);
				$modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
				$modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
				$modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

				$model->division_id = $modelDivision->id;
				$model->station_id = $modelStation->station_id;
				$model->department_id = $modelDepartment->id;
				$model->password = md5($model->email);
				$model->verifyPassword = $model->password;
				$model->confirmpass = $model->password;

				$model->status = 1;
				$model->email = $member[0]['mail'][0];
			} else { //LMS
				$model->email = $_POST['User']['username'];
				// $model->password = $_POST['User']['identification'];
				$model->password = $_POST['User']['username'];

				$model->verifyPassword = $model->password;
				$model->confirmpass = $model->password;
				// $model->department_id = 1;
				$model->department_id = $_POST['User']['department_id'];
				$model->station_id = $_POST['User']['station_id'];
				$model->division_id = $_POST['User']['division_id'];
				$model->repass_status= 0;
				// $model->newpassword = $_POST['User']['identification'];
				$model->status = 1;
				// $model->status = 0;
				$model->scenario = 'general';
			}
			// $model->department_id = $_POST['User']['department_id'];

			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
				
			// var_dump($profile->identification);
			// 	var_dump($model->save());
			// 	var_dump($model->getErrors());
			// 	exit();
			// var_dump($model->validate());
			// var_dump($profile->validate());exit();

			if($model->validate() && $profile->validate()) {


				$model->password=Yii::app()->controller->module->encrypting($model->email);
				// $model->verifyPassword= UserModule::encrypting($model->password);
				$model->confirmpass=Yii::app()->controller->module->encrypting($model->email);


				$uploadFile = CUploadedFile::getInstance($model,'pic_user');
				if(isset($uploadFile))
				{
					$uglyName = strtolower($uploadFile->name);
					$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
					$beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
					$model->pic_user = $beautifulName;
				}
				// $model->status = 1;
			
				if($model->save()) {
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					// if(isset($uploadFile))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 				$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_user);
					// 				$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_user);
					// 				$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_user);
					// 				// Save the original resource to disk
					// 				$uploadFile->saveAs($originalPath);

					// 				// Create a small image
					// 				$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 				$smallImage->resize(385, 220);
					// 				$smallImage->save($smallPath);

					// 				// Create a thumbnail
					// 				$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 				$thumbImage->resize(350, 200);
					// 				$thumbImage->save($thumbPath);
					// }
					if($profile->contactfrom){

						$contacts = $profile->contactfrom;
						foreach ($contacts as $key => $contact) {
									// var_dump($contact);
									// exit();
							if($contact != end($contacts)){
								$value .= $contact.',';
							} else {
								$value .= $contact;
							}

						}
						$profile->contactfrom = $value;
					}
					// $profile->generation = $gen->id_gen;
					$profile->user_id=$model->id;
					$profile->save();

					if($model->type_register != 3 && $model->status != 0){
						$to['email'] = $model->email;
						$to['firstname'] = $profile->firstname;
						$to['lastname'] = $profile->lastname;
						$message = $this->renderPartial('_mail_message',array('model' => $model),true);
						if($message){
							$send = Helpers::lib()->SendMailNotification($to,'อนุมัติการสมัครสมาชิก',$message);
						}
					}
					
				}
				$this->redirect(array('view','id'=>$model->id));
			} else {
				// var_dump($model->getErrors());exit();
				$profile->validate();
				$profile->getErrors();
				$model->getErrors();
			}
		}
		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$model->verifyPassword = $model->password;
		// $this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		if(isset($_POST['User']))
		{			
			// $Neworg = $_POST['Orgchart'];           
			// $Neworg = json_encode($Neworg);
			// $PGoup = $_POST['PGoup'];           
			// $PGoup = json_encode($PGoup);
			// $model->orgchart_lv2 = $Neworg;
			// $model->group = $PGoup;
			// $criteria=new CDbCriteria;
   //          $criteria->compare('department_id',$_POST['User']['department_id']);
   //          $criteria->compare('position_title',$_POST['User']['position_name']);
   //          $position = Position::model()->find($criteria);
    //         if(!$position){
    //             $position = new Position;
    //             $position->department_id = $_POST['User']['department_id'];
    //             $position->position_title = $_POST['User']['position_name'];
    //             $position->create_date = date("Y-m-d H:i:s");
				// if(!empty($_POST['User']['department_id']) && !empty($_POST['User']['position_name']))$position->save();
    //         }
			// $model->position_name = $_POST['User']['position_name'];
			// $model->position_id = $position->id;
			// $model->position_id = isset($_POST['User']['position_id']) ? $_POST['User']['position_id'] : 1;
			// $model->division_id = $_POST['User']['division_id'];
			// $model->company_id = $_POST['User']['company_id'];
			// $model->department_id = $_POST['User']['department_id'];
			// $model->department_id = 2;

			$model->username = $_POST['User']['username'];
			
			// $model->identification = $_POST['User']['identification'];
			// $model->passport = $_POST['User']['passport'];
			$model->status = $_POST['User']['status'];
			$model->superuser = $_POST['User']['superuser'];
			// if($_POST['User']['newpassword'] != ''){
			// 	$model->password = $_POST['User']['newpassword'];
			// 	$model->verifyPassword = $_POST['User']['confirmpass'];
			// }

				    $member = Helpers::lib()->ldapTms($model->email);
			 // $member['çount'] = 0;
				if($member["count"] > 0){ //TMS
					Helpers::lib()->_insertLdap($member);
					$modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
					$modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
					$modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

					$model->division_id = $modelDivision->id;
					$model->station_id = $modelStation->station_id;
					$model->department_id = $modelDepartment->id;
					$model->password = md5($model->email);
					$model->verifyPassword = $model->password;
					$model->confirmpass = $model->password;
					

					$model->email = $member[0]['mail'][0];
				}else{ //LMS
					$model->email = $_POST['User']['username'];
					// $model->password = ($_POST['User']['identification']);
					// $model->verifyPassword = $model->password;
					// $model->department_id = 1;
					$model->confirmpass = $model->password;
					$model->department_id = $_POST['User']['department_id'];
					$model->station_id = $_POST['User']['station_id'];
					$model->division_id = $_POST['User']['division_id'];
					if($_POST['User']['newpassword'] != null ){
					$model->password=Yii::app()->controller->module->encrypting($_POST['User']['newpassword']);
					// $model->verifyPassword=UserModule::encrypting($model->password);
					$model->confirmpass=UserModule::encrypting($_POST['User']['confirmpass']);
					}
					$model->scenario = 'general';
				}

			$profile->attributes=$_POST['Profile'];
			// $model->verifyPassword = $model->password;
				// var_dump($model->password);
				// var_dump($model->confirmpass);
				// var_dump($model->save());
				// var_dump($model->getErrors());exit();

			if($model->validate()&&$profile->validate()) {
				// $model->password=Yii::app()->controller->module->encrypting($model->password);
				// $model->verifyPassword=UserModule::encrypting($model->verifyPassword);


						// $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->newpassword);

				// $uploadFile = CUploadedFile::getInstance($model,'pic_user');
				// if(isset($uploadFile))
				// {
				// 	$uglyName = strtolower($uploadFile->name);
				// 	$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
				// 	$beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
				// 	$model->pic_user = $beautifulName;

				// // $rnd = rand(0,999);
				// // $fileName = $time."_Picture.".$uploadFile->getExtensionName();
				// // // $path = Yii::app()->basePath.'/../uploads/user/';
				// // $destination = $path.$fileName;
				// // $w = 200;
				// // $h = 200;
				// // $model->pic_user = $fileName;
				// }

				if($profile->contactfrom){
					$contacts = $profile->contactfrom;
					foreach ($contacts as $key => $contact) {
									// var_dump($contact);
									// exit();
						if($contact != end($contacts)){
							$value .= $contact.',';
						} else {
							$value .= $contact;
						}

					}
					$profile->contactfrom = $value;
				}

				$model->save();
				$profile->save();

			// 	if(isset($uploadFile))
			// 	{
			// 		/////////// SAVE IMAGE //////////
			// 		Yush::init($model);
			// 					$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_user);
			// 					$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_user);
			// 					$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_user);
			// 					// Save the original resource to disk
			// 					$uploadFile->saveAs($originalPath);

			// 					// Create a small image
			// 					$smallImage = Yii::app()->phpThumb->create($originalPath);
			// 					$smallImage->resize(110);
			// 					$smallImage->save($smallPath);

			// 					// Create a thumbnail
			// 					$thumbImage = Yii::app()->phpThumb->create($originalPath);
			// 					$thumbImage->resize(240);
			// 					$thumbImage->save($thumbPath);

			// }
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('view','id'=>$model->id));
			} 
			// var_dump($model->getErrors());
			// var_dump($profile->getErrors());
			// exit();
		}
		$model->position_name = isset($_POST['User']['position_name']) ? $_POST['User']['position_name'] : $model->position->position_title;
		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	public function actionPrintpdf(){
		
		$user_id =$_POST['id'];
		if ($user_id === '') {
			$profile = Profile::model()->find(array(
				//'condition' => 'pro_id=:pro_id AND active=:active',
				'params' => array('user_id' => $user_id)
			));
			$user = User::model()->find(array(
				//'condition' => 'pro_id=:pro_id AND active=:active',
				'params' => array('id' => $user_id)
			));
             $padding_left = 12.7;
		$padding_right = 12.7;
		// $padding_right = 25.4;
		
		$padding_top = 15;
		$padding_bottom = 20;
		Yii::import('application.extensions.*');
		require_once('THSplitLib/segment.php');


		$mPDF = Yii::app()->ePdf->mpdf('th', 'A4', '0', '', $padding_left, $padding_right, $padding_top, $padding_bottom);
		$mPDF->useDictionaryLBR = false;
		// $mPDF->useDictionaryLBR = false;
		$mPDF->setDisplayMode('fullpage');
		$mPDF->autoLangToFont = true;
		$mPDF->SetTitle("ใบสมัครเข้ารับการศึกษา");
		$mPDF->AddPage('P'); // แนวตั้ง
		// $mPDF->showImageErrors = true;
		$firstpage = '
			<style type="text/css">
 		body {
 			font-family: "sarabun";
 		}
 		</style>


		<div style="padding-bottom:-20px;">
		<table border="0" width="100%" style="border-collapse:collapse;">
		<tr>
		<td style="text-align:center; padding-top:30px;">
		<p><img src="images/logo_kpi_regis_bw.jpg" width="120"></p>
		</td>
		</tr>
		<tr>
		<td width="100%" style="text-align:center; font-size:50px; font-weight: bold;">
		<p>ใบสมัครเข้ารับการศึกษา</p>
		</td>
		</tr>
		<tr>
		<td width="100%" style="text-align:center; padding-top:100px; font-size:40px; font-weight: bold;">
		<p>'.$category['cate_title'].'</p>
		</td>
		</tr>
		<tr>
		<td width="100%" style="text-align:center; font-size:50px; font-weight: bold;">
		<p>'.$course['course_title'];

		if($generation != 0){
			$firstpage .= " รุ่นที่ ".$generation; 
		}

		$firstpage .= '</p>
		</td>
		</tr>
		<tr>
			<td width="100%" style="text-align:center; font-size:40px; font-weight: bold;">
				<p>ปีการศึกษา พ.ศ. '.(date('Y', strtotime($issueCourse['ic_regis_date']))+543).'</p>
			</td>
		</tr>
		<tr>
			<td width="100%" style="text-align:center; padding-top:170px; font-size:42px; font-weight: bold;">
				<p>';
				if($issueCourse_ex->course->office->office_name != ""){
					$firstpage .=  $issueCourse_ex->course->office->office_name;
				}else{
					$firstpage .= '<font color="white">-</font>';
				}

				$firstpage .= '</p>
			</td>
		</tr>
		<tr>
			<td width="100%" style="text-align:center; font-size:42px; font-weight: bold;">
				<p>ใบสมัครสมาชิก</p>
			</td>
		</tr>
		<tr>
			<td width="80%" style="text-align:center; font-size:30px; font-weight: bold;">		
				<p><img src="images/line_3rd.jpg" width="500"></p>				
			</td>
		</tr>
		</table>
		</div>';


		$firstpage = mb_convert_encoding($firstpage, 'UTF-8', 'UTF-8');
		$mPDF->WriteHTML($firstpage);
		$mPDF->AddPage();

		$footer = "<div><table border='0' width='100%'><tr><td width='80%'>".$course_iso_doc."</td><td width='20%' style='text-align:right;'><p>{PAGENO}</p></td><tr></table></div>";
		$mPDF->SetFooter($footer);
		$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('prinf', array('profile'=>$profile, 'user'=>$user), true), 'UTF-8', 'UTF-8'));
		// $mPDF->SetHeader("");
		// $mPDF->AddPage();
		// $arr_month = array('มกราคม', 'กุมพาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
		// $export_page = '
		// <div style="padding-top:20px; padding-bottom:10px; font-size:22px;">
 	// 	<table border="0" width="100%" style="border-collapse:collapse;">
 	// 		<tr>
 	// 			<td rowspan="2" width="10%" style="text-align:center;">
 	// 				<img src="images/logo_kpi_regis.jpg" width="40">
 	// 			</td>
 	// 			<td style="font-size:22px; font-weight: bold; padding-bottom:-5px;" width="90%">
 	// 				ออกหมายเลขใบสมัคร
 	// 			</td>
 	// 		</tr>
 	// 		<tr>
 	// 			<td style="font-size:18px; padding-top:-5px;" width="80%">
 	// 				'.date('d', strtotime($issueCourse['ic_regis_date'])).' '.$arr_month[date('m', strtotime($issueCourse['ic_regis_date']))-1].' '.(date('Y', strtotime($issueCourse['ic_regis_date']))+543).'
 	// 			</td>
 	// 		</tr>
 	// 	</table>
 	// 	<div class="col-sm-10 col-sm-offset-1" style="text-align:center;">
 	// 		<div class="text-center">
 	// 			<img src="images/success-export.jpg">
 	// 		</div>
 	// 		<h3 class="text-center success-course">
 	// 			ลงทะเบียนเสร็จสิ้น
 	// 			<br>
 	// 			<div>
 	// 				<h4>
 	// 					<div>
 	// 						<span>'.$category['cate_title'].'<br></span>
 	// 					</div>';

  //                       if($gen != 0){
  //                           $export_page .= '<span>'.$course.'<br> ( รุ่นที่ '.$gen.' )</span>';

  //                       }
  //               $export_page .= '</h4>
 	// 				<small></small>
 	// 			</div>
 	// 		</h3>
 	// 		<div class="export-code">
 	// 			<div class="code-box"> หมายเลขใบสมัครของท่าน:
 	// 				<span id="code-register">'.$issueCourse['ic_code'].'</span>
 	// 			</div>
 	// 		</div>
 	// 	</div>
 	// 	<div style="text-align:center;">
 	// 	<img src="images/bottom-export.jpg">
 	// 	</div>
 	// </div>
		// ';
		// $mPDF->WriteHTML($export_page);
		// $mPDF->Output('ใบสมัครเข้ารับการศึกษา_'.$issueCourse['ic_code'].'.pdf', 'I');
		
		}
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
			{
			// we only allow deletion via POST request
				$model = $this->loadModel();
			// $profile = Profile::model()->findByPk($model->id);
			// $profile->delete();
			// $model->status = '0';
				$model->del_status = '1';
				$model->save(false);
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_POST['ajax']))
					$this->redirect(array('/user/admin'));
			}
			else
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}



		public function actionSub_category() {
			$data=OrgChart::model()->findAll('parent_id=:parent_id',
				array(':parent_id'=>(int) $_POST['orgchart_lv2']));

			$data=CHtml::listData($data,'id','title');
			echo CHtml::tag('option',
				array('value'=>''),"---กลุ่มหลักสูตรย่อย---",true);
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option',
					array('value'=>$value),CHtml::encode($name),true);
			}

		}

		// public function actionDivision()
		// {
		// 	$data=Division::model()->findAll('company_id=:company_id',
		// 		array(':company_id'=>(int)$_POST['company_id']));
		// 	$options[] = CHtml::tag('option',
		// 		array('value'=>''),"---เลือกศูนย์/แผนก---",true);
		// 	$data = CHtml::listData($data,'id','div_title');
		// 	foreach($data as $value=>$name)
		// 	{
		// 		$options[] =  CHtml::tag('option',
		// 			array('value'=>$value),CHtml::encode($name),true);
		// 	}

		// 	$data1=Position::model()->findAll('company_id=:company_id',
		// 		array(':company_id'=>(int)$_POST['company_id']));
		// 	$options1[] = CHtml::tag('option',
		// 		array('value'=>''),"---เลือกตำแหน่ง---",true);
		// 	$data1 =CHtml::listData($data1,'id','position_title');
		// 	foreach($data1 as $value=>$name)
		// 	{
		// 		$options1[] =  CHtml::tag('option',
		// 			array('value'=>$value),CHtml::encode($name),true);
		// 	}

		// 	echo json_encode(array("data_dsivision"=>$options,'data_position'=>$options1));
		// }

		// public function LoadDivision($company_id)
		// {
		// 	$data=Division::model()->findAll('company_id=:company_id',
		// 		array(':company_id'=>$company_id)
		// 	);

		// 	$data=CHtml::listData($data,'id','dep_title');

		// 	return $data;
		// }



	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
	protected function performAjaxValidation($validate)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($validate);
			Yii::app()->end();
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

}
