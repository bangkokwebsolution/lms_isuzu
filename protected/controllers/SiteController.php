<?php

class SiteController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

	public function actionApiSendSchedule(){
		$date_now = date('Y-m-d',strtotime("-1 days"));
		$criteria = new CDbCriteria;
		// $criteria->compare('training_date_end',$date_now,true);
		$criteria->compare('training_date_end',$date_now,true);
		$schedules = Schedule::model()->findAll($criteria);
		foreach ($schedules as $key => $value) {
			$criteria = new CDbCriteria;
			$criteria->compare('schedule_id',$value->id,true);
			$criteria->group = 'user_id';
			$authen = AuthCourse::model()->findAll($criteria);
			// var_dump($authen);
			$response = Helpers::lib()->sendApiLms($authen,$value->schedule_id);
			var_dump($response);
		}
		exit();

	}

	public function actionApiSendScheduleId($schedule_id,$key){
		if($key != 'BwjPHhyjbhhhU4pex5e1igys5Dp8yyim')$this->redirect('site/index');
		$criteria = new CDbCriteria;
		$criteria->compare('schedule_id',$schedule_id);
		$schedules = Schedule::model()->findAll($criteria);
		foreach ($schedules as $key => $value) {
			$criteria = new CDbCriteria;
			$criteria->compare('schedule_id',$value->id,true);
			$criteria->group = 'user_id';
			$authen = AuthCourse::model()->findAll($criteria);
   // var_dump($authen);
			$response = Helpers::lib()->sendApiLms($authen,$value->schedule_id);
			var_dump($response);
		}
		exit();
	}

	// public function actionApiSendScheduleFix(){
	// 	$date_now = date('2019-07-19');
	// 	$criteria = new CDbCriteria;
	// 	// $criteria->compare('training_date_end',$date_now,true);
	// 	$criteria->compare('training_date_end',$date_now,true);
	// 	$schedules = Schedule::model()->findAll($criteria);
	// 	foreach ($schedules as $key => $value) {
	// 		$criteria = new CDbCriteria;
	// 		$criteria->compare('schedule_id',$value->id,true);
	// 		$criteria->group = 'user_id';
	// 		$authen = AuthCourse::model()->findAll($criteria);
	// 		// var_dump($authen);
	// 		$response = Helpers::lib()->sendApiLms($authen,$value->schedule_id);
	// 		var_dump(json_decode($response));
	// 	}
	// 	exit();

	// }

	// public function actionGetUser(){
	// 	$model = User::model()->findByPk($_GET['id']);
	// 	if(isset($_GET['update'])){
	// 		$model->employee_id = 5;
	// 		$model->save(false);
	// 	}
	// 	echo "<pre>";
	// 	var_dump($model);
	// 	var_dump($model->profile);
	// }

	public function actionGetData(){
		echo $_REQUEST;
	}

	// public function actionTestapi(){
	// 	$date_now = date('Y-m-d');
	// 	$criteria = new CDbCriteria;
	// 	$criteria->compare('training_date_end',$date_now,true);
	// 	$schedules = Schedule::model()->findAll($criteria);
	// 	foreach ($schedules as $key => $value) {
	// 		// var_dump($value);
	// 		$criteria = new CDbCriteria;
	// 		$criteria->compare('schedule_id',$value->id,true);
	// 		$criteria->group = 'user_id';
	// 		$authen = AuthCourse::model()->findAll($criteria);
	// 		// var_dump($authen);
	// 		$response = Helpers::lib()->sendApiLms2($authen,$value->id);
	// 		// $response = Helpers::lib()->sendApiLms($value);
	// 		// var_dump($response);
	// 	}
	// 	exit();

	// }

	// public function actionTest167(){
	// 	$user_id = 167;
	// 	$id = 73;
 //        $modelUser = User::model()->findByPk($user_id);
 //        $modelCourseName = CourseOnline::model()->findByPk($id);
 //        $criteria = new CDbCriteria;
 //        $criteria->join = " INNER JOIN `tbl_lesson` AS les ON (les.`id`=t.`lesson_id`)";
 //        $criteria->compare('t.course_id',$id);
 //        $criteria->compare('t.user_id',$user_id);
 //        $criteria->compare('lesson_active','y');
 //        $criteria->compare('les.active','y');

 //        $learn = Learn::model()->findAll($criteria);
	// 	var_dump($learn);exit();
	// }

	// public function actionShowScheduleNow(){
	// 	$date_now = date('Y-m-d');
	// 	$criteria = new CDbCriteria;
	// 	$criteria->compare('training_date_end',$date_now,true);
	// 	$schedules = Schedule::model()->findAll($criteria);
	// 	var_dump($schedules);exit();
	// }

	// public function actionShowSchedule(){
	// 	$schedules = Schedule::model()->findAll();
	// 	var_dump($schedules);exit();
	// }
	// public function actionShowSchedule2($id){
	// 	$criteria = new CDbCriteria;
	// 	$criteria->with = array('schedule');
	// 	$criteria->compare('schedule.schedule_id',$id);
	// 	$schedules = AuthCourse::model()->findAll($criteria);
	// 	echo "<pre>";
	// 	foreach ($schedules as $key => $value) {
	// 		var_dump($value);echo "<br>";
	// 	}
	// }

	// public function actionShowSchedule3($id){
	// 	$criteria = new CDbCriteria;
	// 	// $criteria->with = array('schedule');
	// 	// $criteria->compare('schedule.schedule_id',$id);
	// 	$schedules = AuthCourse::model()->findAll($criteria);
	// 	echo "<pre>";
	// 	foreach ($schedules as $key => $value) {
	// 		var_dump($value);echo "<br>";
	// 	}
	// }

	// public function actionShowSchedule4(){
	// 	$date_now = date('2019-07-19');
	// 	$criteria = new CDbCriteria;
	// 	// $criteria->compare('training_date_end',$date_now,true);
	// 	$criteria->compare('training_date_end',$date_now,true);
	// 	$schedules = Schedule::model()->findAll($criteria);
	// 	foreach ($schedules as $key => $value) {
	// 		$criteria = new CDbCriteria;
	// 		$criteria->compare('schedule_id',$value->id,true);
	// 		$criteria->group = 'user_id';
	// 		$authen = AuthCourse::model()->findAll($criteria);

	// 		 foreach ($authen as $key => $value) {
	// 	    // foreach ($scheduleMain->auth as $key => $value) {
	// 	            // var_dump($value);
	// 	        $userModel = Users::model()->findByPK($value->user_id);
	// 	        if($userModel){
	// 	            // $learnStatus = $this->checkCoursePass($value->course_id);

	// 	            // $learnStatus = $this->checlAllLessonLearnPass($value->course_id,$value->user_id);
	// 	            $learnStatus = Helpers::lib()->checlAllLessonPass($value->course_id,$value->user_id);

	// 	            $member[$key]['username'] = strtolower($userModel->username);
	// 	            // $member[$key]['course_id'] = $value->course_id;
	// 	            $member[$key]['date'] = "";
	// 	            // $member[$key]['course_id'] = $value->course_id;
	// 	            $member[$key]['score'] = 0;
	// 	            if($learnStatus == "pass"){ //learn pass
	// 	                $logStart = LogStartcourse::model()->findByAttributes(array('user_id' => $value->user_id,'course_id'=> $value->course_id,'active'=>'y'));
	// 	                $member[$key]['date'] = $logStart->end_date;
	
	// 	                // $passCourse = Passcours::model()->findByPk(array('passcours_user' => $value->user_id,'passcours_cours'=> $value->course_id,'passcours_cates'=> 1));
	// 	                // $member[$key]['date'] = $passCourse->passcours_date;
	// 	                if(Helpers::lib()->checkHaveCourseTestInManage($value->course_id)){
	// 	                    $courseScore = Coursescore::model()->findByAttributes(array('user_id' => $value->user_id,'course_id'=> $value->course_id,'score_past' => 'y','active'=>'y'));
	
	// 	                    if($courseScore){
	// 	                        $member[$key]['status'] = "P";
	// 	                        $member[$key]['score'] = $courseScore->score_number.'/'.$courseScore->score_total;
	// 	                    }else{
	// 	                        $member[$key]['status'] = "N";
	// 	                    }
	// 	                }
	// 	            }else if($learnStatus == "notPass"){
	// 	                $criteria = new CDbCriteria;
	// 	                $criteria->compare('course_id',$value->course_id);
	// 	                $criteria->compare('lesson_active','y');
	// 	                $criteria->compare('user_id',$value->user_id);
	// 	                $learns = Learn::model()->findAll($criteria);
	// 	                if($learns){
	// 	                    $member[$key]['status'] = "N";
	// 	                }else{
	// 	                    $member[$key]['status'] = "A";
	// 	                }
	// 	            }else{
	// 	                $member[$key]['status'] = "A";
	// 	            }
	// 	        }
	// 	    }
	// 	    echo "<pre>";
	// 	    var_dump($member);
	// 		var_dump("จำนนวน : ".count($authen));
	// 		var_dump($authen);
	// 	}
	// }

	// //TAAONPREM04 testus
	// public function actionGetSchedule(){
	// 	$schedules = Schedule::model()->findAll();
	// 	echo "<pre> SCHEDULES";
	// 	var_dump($schedules);
	// 	$criteria = new CDbCriteria;
	// 	// $criteria->with = array('course','schedule');
	// 	$criteria->compare('user_id',Yii::app()->user->id);
	// 	$modelCourseTms = AuthCourse::model()->findAll($criteria);
	// 	echo "<pre> AuthCourse";
	// 	var_dump($modelCourseTms);
	// }

	// public function actiongetDataApi(){
	// 	$json = file_get_contents('php://input');
	// 	$put_vars = CJSON::decode($json,true);
	// 	foreach ($put_vars['member'] as $key => $value) {
	// 		var_dump($value['username']." | ".$value['score']." | ".$value['date']." | ".$value['status'].'<br>');
	// 	}
	// 	var_dump("<br> REQUEST JSON : ".$json);
	// }
	public function actionDashboard()
	{
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(Yii::app()->user->isGuest){
			$this->redirect('index');
		}
		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}

		//Label Multi lang

		$label = MenuSite::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));
		if(!$label){
			$label = MenuSite::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}
		$this->render('dashboard', array(
			'user'=>$user,
			'label'=> $label,
		));
	}

	public function actionAllStatus()
	{
		$this->render('all_status');
	}

	public function actionShowTest()
	{
		var_dump(Yii::app()->user->id);
		exit();
	}

	// public function actionDisplay()
	// {
	// 	Helpers::lib()->displayUser();
	// }

	public function actionDbug()
	{
		$lesson = Lesson::model()->findByPk(212);
		$state = Helpers::lib()->CheckPostTestAll($lesson);
		var_dump($state);
	}

	// public function actionDeleteFile(){
	// 	$webroot = Yii::app()->basePath.'/../uploads/templete_import_users.xlsx';
	// 	@unlink($webroot);
	// 	var_dump(file_exists($webroot));
	// }

	// public function actionUploadFile(){
	// 	if(!empty($_FILES)){
	// 	$target_dir = Yii::app()->basePath."/../uploads/";
	// 	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	// 	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// 	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
 //        	echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	//     } else {
	//         echo "Sorry, there was an error uploading your file.";
	//     }
	// 	exit();
	// }
	// $this->layout = false;
	// $this->render('fileupload');
	// }

	public function actionIndex($login = null)
	{
		$dateNow  =date("d-m-Y");
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'] != '127.0.0.1')
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '127.0.0.1')
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if ($_SERVER['HTTP_X_FORWARDED'] != '127.0.0.1')
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if ($_SERVER['HTTP_FORWARDED_FOR'] != '127.0.0.1')
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if ($_SERVER['HTTP_FORWARDED'] != '127.0.0.1')
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';

		$modelCount = Counter::model()->findAll();
		foreach ($modelCount as $key => $value) {
			$ip_Old = $value->ip_visit;
			$date_Old = $value->date_visit;			 
		}

		if($ip_Old != $ipaddress && $date_Old != $dateNow){
			$count = new Counter;
			$count->date_visit = $dateNow;
			$count->ip_visit = $ipaddress;
			$count->visit = 1;
			$count->save();
		}

		$result =  Yii::app()->db->createCommand("Select count(visit) as visit From counter")->queryAll();
		$counter = implode(" ",$result[0]);


		// echo Yii::app()->user->id;
  //       exit();
		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
			Yii::app()->language = 'en';
		}else{
			$langId = Yii::app()->session['lang'];
			Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
		}

		//Label Multi lang

		$label = MenuSite::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));
		if(!$label){
			$label = MenuSite::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}

		$labelCourse = MenuCourse::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));
		if(!$labelCourse){
			$labelCourse = MenuCourse::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}

		$this->layout = '//layouts/mainIndex';

		// if(Yii::app()->user->id != null){
		// 	// var_dump('expression');exit();
		// 	$userModel = Users::model()->findByPK(Yii::app()->user->id);
		// 	$userDepartment = $userModel->department_id;

		// 	$criteria = new CDbCriteria;
		// 	$criteria->with = array('orgchart');
		// 	if($userDepartment == 1){ 
		// 		$criteria->compare('depart_id',$userDepartment);
		// 	}else{
		// 		$criteria->addIncondition('depart_id',[1,$userDepartment]);
		// 	}

		// 	$criteria->compare('orgchart.active','y');
		// 	$criteria->compare('t.active','y');
		// 	$criteria->group = 'orgchart_id';
		// 	$modelOrgDep = OrgDepart::model()->findAll($criteria);

		// 	foreach ($modelOrgDep as $key => $value) {
		// 		$courseArr[] = $value->orgchart_id;
		// 	}
		// 	$criteria = new CDbCriteria;
		// 	$criteria->join = "INNER JOIN tbl_course_online AS course ON (course.course_id = t.course_id) ";
		// 	$criteria->join .= "INNER JOIN tbl_schedule as s ON ( s.id = t.schedule_id ) ";
		// 	$criteria->compare('user_id',Yii::app()->user->id);
		// 	$criteria->compare('course.active','y');
		// 	$criteria->compare('course.status','1');
		// 	$criteria->addCondition('s.training_date_end >= :date_now');
		// 	$criteria->params[':date_now'] = date('Y-m-d');
		// 	$criteria->group = 't.course_id';
		// 	$criteria->order = 't.schedule_id DESC';
		// 	$criteria->limit = 4;
		// 	$modelCourseTms = AuthCourse::model()->findAll($criteria);


		// 	$criteria = new CDbCriteria;
		// 	$criteria->with = array('course','course.CategoryTitle');
		// 	$criteria->addIncondition('orgchart_id',$courseArr);
		// 	$criteria->compare('course.active','y');
		// 	$criteria->compare('course.status','1');
		// 	$criteria->compare('categorys.cate_show','1');
		// 	$criteria->compare('categorys.cate_id','1');
		// 	$criteria->group = 'course.course_id';
		// 	$criteria->addCondition('course.course_date_end >= :date_now');
		// 	$criteria->params[':date_now'] = date('Y-m-d H:i');
		// 	$criteria->order = 'course.course_id';
		// 	// $criteria->limit = 5;
		// 	$modelOrgOld = OrgCourse::model()->findAll($criteria);

		// 	$criteria = new CDbCriteria;
		// 	$criteria->with = array('course','course.CategoryTitle');
		// 	$criteria->addIncondition('orgchart_id',$courseArr);
		// 	$criteria->compare('course.active','y');
		// 	$criteria->compare('course.status','1');
		// 	$criteria->compare('categorys.cate_show','1');
		// 	$criteria->group = 'course.cate_id';
		// 	$criteria->addCondition('course.course_date_end >= :date_now');
		// 	$criteria->params[':date_now'] = date('Y-m-d H:i');
		// 	$criteria->order = 'course.course_id';
		// 	// $criteria->limit = 5;
		// 	$modelCat = OrgCourse::model()->findAll($criteria);

		// } else {
		// 	$criteria = new CDbCriteria;
		// 	$criteria->with = array('Schedules');
		// 	$criteria->compare('active','y');
		// 	$criteria->compare('lang_id',$langId);
		// 	$criteria->compare('status','1');
		// 	// $criteria->order = 'update_date  DESC';
		// 	// $criteria->compare('lang_id',Yii::app()->session['lang']);
		// 	$criteria->order = 'course.course_id,Schedules.id desc';
		// 	$criteria->addCondition('Schedules.id IS NULL');
		// 	$criteria->addCondition('course_date_end >= :date_now');
		// 	$criteria->params[':date_now'] = date('Y-m-d H:i');
		// 	$criteria->limit = 4;
		// 	$model = CourseOnline::model()->findAll($criteria); 
		// }

// 		//News
// 		$news_data = News::model()->findAll(array(
// 			'condition'=>'active="y"',
// 			'order'=>'create_date DESC',
// 			// 'limit'=>'6',
// 		));

		//CourseOnline
		// $course_online = CourseOnline::model()->findAll(array(
		// 	'condition'=>'active="y"',
		// 	'order'=>'create_date DESC',
		// 	// 'limit'=>'4',
		// ));

// 		$coursevodaudit = CourseVod::model()->findAll(array(
// 				'condition' => 'name="ธรรมาภิบาลภาคธุรกิจ" or name="กลยุทธ์ดึงดูดลูกค้าออนไลน์" or name="เริ่มต้นธุรกิจแบบมืออาชีพ" or name="หลักสูตร e-Commerce"',
// 				'order'=>'id ASC',
// 			));

// 		// var_dump($coursevodaudit);exit();

// 		$vod = LessonVod::model()->findAll(array(
// 				'select' => 'name, DATE(create_date) AS create_at, DATE(update_date) AS update_at',
// 				'condition' => 'type="video"',
// 				// 'group' => 'course_id',
// 				'order'=>'create_at DESC, update_at DESC'
// 			));
// // article_rating DESC, article_time DESC
// 		$audit = LessonVod::model()->findAll(array(
// 				'condition' => 'type="audio"',
// 				'limit'=>4,
// 				'order'=>'course_id ASC'
// 			));

// 		$featurelinks = FeaturedLinks::model()->findAll(array(
// 				'condition' => 'active=1',
// 			));

// 		// echo '<pre>';
// 		// foreach ($coursevod as $key => $value) {
// 		// 	var_dump($value);
// 		// }
		// echo '</pre>';
		// if(isset($cookie)) {
  //                   setcookie('checkbox',$cookie,time()+3600*24*356);
  //               }
		// $this->render('index');

		if(!Yii::app()->user->isGuest){

			// $course_online = new CourseOnline('search');
			// $course_online->unsetAttributes();
			// $userObject = Users::model()->findByPk(Yii::app()->user->id);

			if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
				$langId = Yii::app()->session['lang'] = 1;
			}else{
				$langId = Yii::app()->session['lang'];
			}
			// if($userObject->position_id != 4){
			// 	if($userObject->orgposition){
			// 		$courses = $userObject->orgposition;
			// 	}
			// }else{
			// 	$criteria = new CDbCriteria;
			// 	$criteria->compare('title_all','General');
			// 	$courses = OrgRoot::model()->findAll($criteria);
			// }

			// foreach ($courses as $key => $cate) {
			// 	$courseArr[] = $cate->course->CategoryTitle->cate_id;
			// }
			// $courseArray = array();
			// if(!empty($courses)){
			// 	$courseArray = CHtml::listData($courses,'course_id','course_id');
			// }
			// $course_online->course_id_array = array_values($courseArray);
			$course = CourseOnline::model()->with("CategoryTitle")->findAll(array("condition" => "course.active='y' and course.status ='1' and categorys.active='y' and categorys.cate_show='1' and course.lang_id = ".$langId));
		}else{

			$criteria = new CDbCriteria;
			$criteria->compare('course_id',$id);
			$criteria->compare('active','y');
			$criteria->compare('status',1);
			$criteria->compare('lang_id',$langId);
			// $criteria->limit = 8;
			$course = CourseOnline::model()->findAll($criteria);
		}

		// var_dump("<pre>");
		// var_dump($courseStatus);
		// var_dump("<br>");
		// exit();
		// foreach($courseStatus as $data) {

		// 	$test = $data;

		// 	$lessonList = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $data->course_id, 'order' => 'lesson_no'));
		// }

		// var_dump($lessonList);exit();

		// var_dump("<pre>");
		// var_dump($lessonList);
		// var_dump("<br>");
		// exit();

		$this->render('index',array('label'=>$label,'model'=>$model,'modelCourseTms'=>$modelCourseTms,'modelOrg'=>$modelOrg,'labelCourse' => $labelCourse,'modelCat' => $modelCat,'courseArr' => $courseArr, 'course_online'=>$course, 'counter'=>$counter));

	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
				"Reply-To: {$model->email}\r\n".
				"MIME-Version: 1.0\r\n".
				"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	// Test Learning
	// public function actionTestLearning()
	// {
	// 	$sample = CourseSample::model()->findAll();
	// 	// var_dump($sample);exit();
	// 	$this->render('testlearning',array(
	// 		'sample' => $sample,
	// 	));
	// }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function actionLinkall()
	{
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}

		$label = MenuSite::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));

		if(!$label){
			$label = MenuSite::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}
		$this->render('link',array('label'=>$label));
	}

	public function actionDisplayDocument($id)
	{
		$model = Document::model()->find(array('condition' => 'dow_id='.$id)); 
		$exp = explode('.' , $model->dow_address);
		if($model && $exp[count($exp)-1] == 'pdf'){
			$filepath = Yii::app()->basePath.'/../admin/uploads/'.$model->dow_address;
			$file = Yii::app()->basePath.'/../admin/uploads/'.$model->dow_address;
			$filename = $model->dow_address;
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="' . $filename . '"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($file));
			header('Accept-Ranges: bytes');
			@readfile($file);
		}
	}
  //       public function actionTest2(){
  //       $imagemagick = "172.21.81.113/www/ImageMagick/ImageMagick/utilities/";
  //       exec('ping google.com',$str);
  //       var_dump($str);exit();
		// }
	public function actionNotification(){

		$criteria = new CDbCriteria;
		$criteria->with = array('orgCourses');
		    // $criteria->group = 'orgCourses.course_id';
		$criteria->compare('t.active','1');
		$model_cates = CourseNotification::model()->findAll($criteria);
		$i = 0;
		foreach ($model_cates as $key => $model_cate) {
			if($model_cate->orgCourses){
				foreach ($model_cate->orgCourses as $key => $depart) {
		    			// $course[]['course_id'] = $depart->course_id;
		    			// $course[]['notification_time'] = $model_cate->notification_time;
		    			// $course[]['depart'] = $depart->OrgDeparts->depart_id;
					$course[$i] = new StdClass();
					$course[$i]->course_id = $depart->course_id;
		    			$course[$i]->notification_time = $model_cate->notification_time; //day
		    			$course[$i]->depart = $depart->OrgDeparts->depart_id; //Add depart_id
		    			$i++;
		    		}
		    	}
		    	
		    }
		    // exit();
		    
		    $subject = "แจ้งเตือนหลักสูตรกำลังจะหมดอายุ";
		    foreach ($model_cates as $key => $value) {
		    	$course_online = CourseOnline::model()->findByPk($value->course_id);
			    if($course_online->SchedulesAll){ //tms
			    	//Loop Schedules->authen course user_id to array
			    	foreach ($course_online->SchedulesAll as $key => $schedule) {
			    		$course_online->course_date_start = $schedule->training_date_start;
			    		$course_online->course_date_end = $schedule->training_date_end;
			    		//Condition Check Course Expire date
			    		$now = date("Y-m-d h:m:s");
			    		$diff=date_diff(date_create($now),date_create($course_online->course_date_end));
			    		$diff = $diff->format("%R%a");
			    		$diff = (int)$diff;

			    		if($diff == $value->notification_time && $diff >= 0){

			    			$criteria = new CDbCriteria;
			    			$criteria->compare('schedule_id',$schedule->id);
			    			$authCourses = AuthCourse::model()->findAll($criteria);
			    			
			    			foreach ($authCourses as $key => $authenUser) {
			    					// $message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายใน ".$value->notification_time." วัน";
			    				$message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายในวันที่ ".Helpers::lib()->changeFormatDate($course_online->course_date_end);
			    				Helpers::lib()->SendMailNotificationByUser($subject,$message,$authenUser->user_id);
			    			}
			    		}
			    	}

			    }else{ //lms
			    	$course_online->course_date_start = $course_online->course_date_start;
			    	$course_online->course_date_end = $course_online->course_date_end;

			    	//Perrmission
			    	$depart = array();
			    	foreach ($course_online->orgCourses as $key => $org) {
			    		foreach ($org->OrgDepartsAll as $key => $orgDep) {
			    			$depart[] = $orgDep->depart_id;
			    		}
			    	}
			    	//Condition Check Course Expire date
			    	$now = date("Y-m-d h:m:s");
			    	$diff=date_diff(date_create($now),date_create($course_online->course_date_end));
			    	$diff = $diff->format("%R%a");
			    	$diff = (int)$diff;
			    	
			    	if($diff == $value->notification_time && $diff >= 0){

			    		$criteria = new CDbCriteria;
			    		$criteria->addIncondition('department_id',$depart);
			    		$allUser = Users::model()->findAll($criteria);
			    		
			    		if($allUser){
			    			foreach ($allUser as $key => $user) {
			    				// $message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายใน ".$value->notification_time." วัน";
			    				$message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายในวันที่ ".Helpers::lib()->changeFormatDate($course_online->course_date_end);
			    				Helpers::lib()->SendMailNotificationByUser($subject,$message,$user->id);
			    			}
			    			
			    		}
			    	}
			    }
			    
			}
		}

		// public function actionTest3(){
		
		// 	$sch = Schedule::model()->findAll();
		// 	foreach ($sch as $key => $value) {
		// 		$data = Helpers::lib()->sendApiLms($value);
		// 		var_dump($data);
		// 	}
		// 	exit();
		
		// }

		public function actionListLdap(){
			if($_GET['key'] == 'dlas5g78drg4dfh54c536wqwk'){
				$data = Helpers::lib()->listDataLdap($_GET['email']);
			}
		}

		// public function actionCheckLdap(){
		// 	echo "<pre>";
		// 	$data = Helpers::lib()->ldapTms($_GET['email']);
		// 	var_dump($data[0]['descripaddresstion'][0]);
		// 	var_dump($data);exit();
		// }

		// public function actionDeb(){
		// 	// $test = array();
		// 	$test = array('count'=>1,0=>"1020194");
		// 	// $test = array(0=>"1020194");
		// 	if($test['count'] > 0){
		// 		var_dump($test[0]);
		// 	}
		// 	exit();
		// }

		// public function actionUpdateUser(){
		// 	$data = Helpers::lib()->_updateUser('akekarakj@airasia.com');
		// 	var_dump($data);exit();
		// }

		// public function actionShowCourse(){
		// 	$period_start = '2018-02-01';
		// 	$criteria = new CDbCriteria;
  //   		$criteria->with = 'Schedules';
		// 	// if(!empty($_GET['year']){
  //   			$criteria->addCondition('course.course_date_start !=  "'.$period_start.'" ');
		// 		$criteria->addCondition('t.create_date >= "'.$period_start.'" ');
		// 		$criteria->addCondition('t.create_date <= "'.$period_start.'" ');
		// 	// }
		// 	$criteria->compare('course.active','y');
		// 	$criteria->compare('course.lang_id',1);
		// 	$criteria->order = 'course.course_id';
		// 	$model = CourseOnline::model()->findAll($criteria);
		// 	foreach ($model as $key => $value) {
		// 		if($i == 5){
		// 			continue;
		// 		}
		// 		// if(empty($value->course_date_start)){ //TMS
		// 		// 	var_dump($value->Schedules->training_date_start);
		// 		// }else{ //LMS
		// 		// 	var_dump($value->course_date_start);
		// 		// }
		// 	}
		// 	exit();
		//}

		// public function actionShowdivision(){
		// 	$criteria = new CDbCriteria;
		// 	$criteria->compare('active','y');
		// 	$model = Division::model()->findAll($criteria);
		// 	var_dump($model);
		// 	exit();
		// }

		// public function actionTestdivision(){
		// 	$modelDivision = Division::model()->findByAttributes(array('div_title'=>'RAMP'));
		// 	var_dump($modelDivision->id);
		// 	exit();
		// }

		// public function actionTest6(){
		// 	$subject = "แจ้งเตือนหลักสูตรกำลังจะหมดอายุ";
		// 	$message = "หลักสูตร ทดสอบ กำลังจะหมดอายุภายใน 10 วัน";
		// 	Helpers::lib()->SendMailNotification($subject,$message,1);
		
		// 	var_dump($courseScore);exit();
		// }

		// public function actionSee(){
		// 	$userModel = User::model()->notsafe()->findAll();
		// 	var_dump($userModel);
		// 	exit();
		// }

		// public function actionEditUser(){
		// 	$userModel = User::model()->notsafe()->findByPk(208);
		// 	// $userModel = User::model()->notsafe()->findByPk(186);
		// 	$userModel->password = 'ca0350e0c22fec3df052298e9a2d9321';
		// 	$userModel->save();
		// 	var_dump($userModel);
		// 	exit();
		// 	// ca0350e0c22fec3df052298e9a2d9321
		// }

		// public function actionEditUserAdmin(){
		// 	$userModel = User::model()->notsafe()->findByPk(1);
		// 	// $userModel = User::model()->notsafe()->findByPk(186);
		// 	$userModel->del_status = 0;
		// 	$userModel->save();
		// 	var_dump($userModel);
		// 	exit();
		// 	// ca0350e0c22fec3df052298e9a2d9321
		// }

		public function actionPermission(){

			//Guntrakon
			// $userModel = User::model()->notsafe()->findByPk(208);
			// $userModel->superuser = 1;
			// $userModel->group = '["7","1"]';
			// $userModel->save();

			// //Chutima Kanjanathammarat
			// $userModel = User::model()->notsafe()->findByPk(201);
			// $userModel->superuser = 1;
			// $userModel->group = '["7","1"]';
			// $userModel->save();

			// //Chaiwat Teejaroensawang
			// $userModel = User::model()->notsafe()->findByPk(207);
			// $userModel->superuser = 1;
			// $userModel->group = '["7","1"]';
			// $userModel->save();

			//Taa
			$userModel = User::model()->notsafe()->findByPk(167);
			$userModel->superuser = 1;
			$userModel->group = '["7","1"]';
			$userModel->save();

			// $userModel2 = User::model()->findByPk(167);
			// var_dump($userModel2);
			exit();
		}

		// public function actionTestscore(){
		// 		$manage = Manage::Model()->with('question')->findAll("id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
	 //                array("id" => 114,"type" => 'post'));

	 //        if($manage){
	 //            $criteria=new CDbCriteria;
	 //            $criteria->condition = "ques_type <> :ques_type";
	 //            $criteria->params = array (
	 //            ':ques_type' => 3,
	 //            );
	 //            $criteria->compare('user_id',1);
	 //            $criteria->compare('active',"y");
	 //            $criteria->compare('lesson_id',114);
	 //            $criteria->compare('type',"post");
	 //            $score1 = Score::model()->findAll($criteria);
	 //            $count_score = count($score1);
	 //        }
	 //        if($manage){
	 //            $scorePass = array();
	 //            foreach ($score1 as $key => $value) {
	 //            	$scorePass[] = $value->score_past;
	 //            }
	 //        }

	 //        if(in_array("y", $scorePass)){
	 //        	// return true;
	 //        	var_dump("true");
	 //        }else{
	 //        	if($count_score < 2){
	 //        		// return true;
	 //        		var_dump("true");
	 //        	}else{
	 //        		// return false;
	 //        		var_dump("false");
	 //        	}
	 //        }
		
		// }

		// public function actionTesttoken(){
		// 	$token = UserModule::encrypting(time());
		// 	var_dump($token);
		// }

		// public function actionTestTime(){
		// 	echo date('Y-m-d H:i:s');
		// 	echo '<br>';
		// 	echo date_default_timezone_get();
		// 	$sql = "SELECT NOW()";
		// 	$list = Yii::app()->db->createCommand($sql)->queryAll();
		// 	var_dump($list);
		// }
	}