<?php

class ApproveCourseController extends Controller
{

	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
        	// 'rights- toggle, switch, qtoggle',
        );
	}

	public function init()
	{
		parent::init();
		$this->lastactivity();
		if(Yii::app()->user->id == null){
			$this->redirect(array('site/index'));
		}
		
	}

	public function accessRules()
	{
		return array(
        	array('allow',  // allow all users to perform 'index' and 'view' actions
        		'actions' => array('index', 'view'),
        		'users' => array('*'),
        	),
        	array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
        		'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
        		'expression' => 'AccessControl::check_access()',
        	),
            array('deny',  // deny all users
            	'users' => array('*'),
            ),
        );
	}

	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('cates');
		$criteria->compare('categorys.type_id',1);
		$criteria->compare('categorys.active','y');
		
		$criteria->compare('courseonline.active','y');
		$criteria->compare('courseonline.parent_id',0);
		$criteria->addCondition('approve_status != 1');
		$criteria->order = 'sortOrder ASC';

		$Specific = ApproveCourse::model()->findAll($criteria);

		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['ApproveCourse']))
		// 	$model->attributes=$_GET['ApproveCourse'];
		$user = User::model()->findByPk(Yii::app()->user->id);

		$this->render('index',array(
			'model'=>$Specific,
		));
		

		
	}

	public function actionGeneral()
	{

		$criteria = new CDbCriteria;
		$criteria->with = array('cates');
		$criteria->compare('categorys.type_id',3);
		$criteria->compare('categorys.active','y');

		$criteria->compare('courseonline.active','y');
		$criteria->compare('courseonline.parent_id',0);
		$criteria->addCondition('approve_status != 1 AND approve_status !=2');
		$criteria->order = 'sortOrder ASC';
		$General = ApproveCourse::model()->findAll($criteria);

		$this->render('general',array(
			'model'=>$General,
		));

	}

	public function actionGeneralHr()
	{

		$criteria = new CDbCriteria;
		$criteria->with = array('cates');
		$criteria->compare('categorys.type_id',3);
		$criteria->compare('categorys.active','y');

		$criteria->compare('courseonline.active','y');
		$criteria->compare('courseonline.parent_id',0);
		$criteria->addCondition('approve_status = 1');
		$criteria->order = 'sortOrder ASC';
		$GeneralHr = ApproveCourse::model()->findAll($criteria);

		$this->render('generalHr',array(
			'model'=>$GeneralHr,
		));

	}

	public function actionGetDatamodal()
	{
		if (isset($_POST["course_id"]) && isset($_POST["user_id"]) && isset($_POST["request_id"])) {
			$course_id = $_POST["course_id"];
			$user_id = $_POST["user_id"];
			$request_id = $_POST["request_id"];

			$CourseOnline = CourseOnline::model()->findByPk($course_id);
			// var_dump($CourseOnline->usernewcreate->orgchart->title);exit();

			$form_text = "";
			if ($CourseOnline != "") {
				$this->renderPartial('coursedata',array('CourseOnline'=>$CourseOnline));
			}else{
				echo 'noData';
			}

		}
	}

	public function actionSaveApproval()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->compare('authority_hr', 1);
		$criteria->compare('id', Yii::app()->user->id);
		$user_hr1 = User::model()->with('profile')->find($criteria);

		$course = CourseOnline::model()->findByPk($_POST['request_id']); 
		$user_org = orgchart::model()->findByPk($course->usernewcreate->org_id);
		
		$ceh = 2;
        if (!empty($user_hr1) && $course->create_by != Yii::app()->user->id) {
            if ($user_org->id == $user_hr1->org_id) {
                $ceh = 1;
            }
            if ($user_org->level == 2 && $user_hr1->orgchart->level == $user_org->level) {

                $ceh = 1;
            }else if($user_org->level == 3 && $user_hr1->orgchart->level <= $user_org->level && ($user_hr1->orgchart->id ==$user_org->division_id || $user_org->id == $user_hr1->org_id )) {

                $ceh = 1;

            }else if($user_org->level == 4 && $user_hr1->orgchart->level <= $user_org->level && ($user_org->id == $user_hr1->org_id || $user_org->orgchart->id == $user_hr1->org_id || $user_org->div->id ==  $user_hr1->org_id || $user_org->dep->id ==  $user_hr1->org_id )){

                $ceh = 1;

            }else if($user_org->level == 5 && $user_hr1->orgchart->level <= $user_org->level && ($user_org->orgchart->id == $user_hr1->org_id || $user_org->div->id ==  $user_hr1->org_id || $user_org->dep->id ==  $user_hr1->org_id || $user_org->gro->id ==  $user_hr1->org_id )){

                $ceh = 1;
            }
        }
        if ($ceh == 1) {
        	$course->approve_status = 1;
			$course->approve_by = Yii::app()->user->id;
			if($course->save(false)){
				echo 1;
			}else{
				echo 2;
			}
        }else{
        	echo 2;
        }

	}

	public function actionSaveApprovalGeneral()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->compare('authority_hr', 1);
		$criteria->compare('id', Yii::app()->user->id);
		$user_hr1 = User::model()->with('profile')->find($criteria);

		$course = CourseOnline::model()->findByPk($_POST['request_id']); 
		$user_org = orgchart::model()->findByPk($course->usernewcreate->org_id);

		$ceh = 2;
        if (!empty($user_hr1) && $course->create_by != Yii::app()->user->id) {
            if ($user_org->id == $user_hr1->org_id) {
                $ceh = 1;
            }
            if ($user_org->level == 2 && $user_hr1->orgchart->level == $user_org->level) {

                $ceh = 1;
            }else if($user_org->level == 3 && $user_hr1->orgchart->level <= $user_org->level && ($user_hr1->orgchart->id ==$user_org->division_id || $user_org->id == $user_hr1->org_id )) {

                $ceh = 1;

            }else if($user_org->level == 4 && $user_hr1->orgchart->level <= $user_org->level && ($user_org->id == $user_hr1->org_id || $user_org->orgchart->id == $user_hr1->org_id || $user_org->div->id ==  $user_hr1->org_id || $user_org->dep->id ==  $user_hr1->org_id )){

                $ceh = 1;

            }else if($user_org->level == 5 && $user_hr1->orgchart->level <= $user_org->level && ($user_org->orgchart->id == $user_hr1->org_id || $user_org->div->id ==  $user_hr1->org_id || $user_org->dep->id ==  $user_hr1->org_id || $user_org->gro->id ==  $user_hr1->org_id )){

                $ceh = 1;
            }
        }
        if ($ceh == 1) {
        	$course->approve_status = 1;
			$course->approve_by = Yii::app()->user->id;
			if($course->save(false)){
				echo 1;
			}else{
				echo 2;
			}
        }else{
        	echo 2;
        }


	}
	public function actionSaveApprovalGeneralHR()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->compare('authority_hr', 2);
		$criteria->compare('id', Yii::app()->user->id);
		$user_hr1 = User::model()->with('profile')->find($criteria);

		$course = CourseOnline::model()->findByPk($_POST['request_id']); 
		$user_org = orgchart::model()->findByPk($course->usernewcreate->org_id);

		$ceh = 2;
        if (!empty($user_hr1) && $course->create_by != Yii::app()->user->id) {
            $ceh = 1;
        }
        if ($ceh == 1) {
        	$course->approve_status = 2;
			$course->approve_by_hr = Yii::app()->user->id;
			if($course->save(false)){
				echo 1;
			}else{
				echo 2;
			}
        }else{
        	echo 2;
        }
		// if($user_org->id == $user_hr1['org_id']){

		// }
		// $user_create = UserNew::model()->findByPk();


		// if (isset($_POST["request_id"]) && $_POST["request_id"] != "" && isset($_POST["approval_status"]) && $_POST["approval_status"] != "") {
		// 	$request_id = $_POST["request_id"];
		// 	$approval_status = $_POST["approval_status"];

		// }
	}

}