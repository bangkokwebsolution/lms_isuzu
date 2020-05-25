<?php

class VirtualClassroomController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//CourseOnline
		$this->render('index');
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */ 
	//$id
	public function actionJoinkey()
	{
			$ids = $_POST['id'];

		$key = $_POST['check_key'];
		$en_key = UserModule::encrypting($key);

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();
		$room = Vroom::model()->findByPk($ids);
		if($room && !Yii::app()->user->isGuest){
			$userObject = Yii::app()->getModule('user')->user();
			$joinParams = array(
				'meetingId' => $room->id, 				// REQUIRED - We have to know which meeting to join.
				'username' => $userObject->username,		// REQUIRED - The user display name that will show in the BBB meeting.
				'password' => $room->attendeePw,					// REQUIRED - Must match either attendee or moderator pass for meeting.
				// 'createTime' => '',					// OPTIONAL - string
				'userId' => $userObject->id,						// OPTIONAL - string
				// 'webVoiceConf' => ''				// OPTIONAL - string
			);
			// Get the URL to join meeting:

			if(!empty($room->ckeck_key)){
			$iskey = false;
			if($en_key == $room->ckeck_key){
			$iskey = true;
			}
			if ($iskey == false) {
				$errorkey = true ;
				$this->redirect(array('virtualclassroom/index','error_key'=>$errorkey));
			}
			}

			if(!empty($room->number_learn)){
							$itsnum_learn = true;
								$infoParams = array(
									'meetingId' => $room->id,		
									'password' => $room->moderatorPw		
								);

								try {$result = $bbb->getMeetingInfoWithXmlResponseArray($infoParams);}
									catch (Exception $e) {
										//echo 'Caught exception: ', $e->getMessage(), "\n";
										echo 'Error';
										$itsnum_learn = false;
									}
				if($result['participantCount'] >= $room->number_learn ){
					$errornum = true ;
				    $this->redirect(array('virtualclassroom/index','error_num'=>$errornum));
				}
			}

				if(!empty($room->start_learn_room) || !empty($room->end_learn_room)){

					$date = date_create(date("Y-m-d H:i:s"));
					$newdate = date_format($date, 'U');

					$date_st = date_create($room->start_learn_room);
					$newdatest = date_format($date_st, 'U');

					$date_en = date_create($room->end_learn_room);
					$newdateen = date_format($date_en, 'U');

					$isdate = false;

					if($newdate >= $newdatest  && $newdate <= $newdateen){
					$isdate = true;		
					}

					if ($isdate == false) {
						$errordate = true ;
						$this->redirect(array('virtualclassroom/index','error_date'=>$errordate));
					}
				}

			$itsAllGood = true;
			try {$result = $bbb->getJoinMeetingURL($joinParams);}
				catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
					$itsAllGood = false;
				}

			if ($itsAllGood == true && $iskey = true ) {
				//Output results to see what we're getting:
				$this->redirect($result);
			}else{
				$this->redirect(array('virtualclassroom/index'));
			}

		}
	}

	public function actionJoinid($id)
	{
		$ids = $id;
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();
		$room = Vroom::model()->findByPk($ids);
		if($room && !Yii::app()->user->isGuest){
			$userObject = Yii::app()->getModule('user')->user();
			$joinParams = array(
				'meetingId' => $room->id, 				// REQUIRED - We have to know which meeting to join.
				'username' => $userObject->username,		// REQUIRED - The user display name that will show in the BBB meeting.
				'password' => $room->attendeePw,					// REQUIRED - Must match either attendee or moderator pass for meeting.
				// 'createTime' => '',					// OPTIONAL - string
				'userId' => $userObject->id,						// OPTIONAL - string
				// 'webVoiceConf' => ''				// OPTIONAL - string
			);
			// Get the URL to join meeting:
			
			$it_user = true;
			
			if($room->status_key != '0'){
				if($room->user_learn != 'all'){
					$user_check = json_decode($room->user_learn);  
					$check_array = array();
					foreach($user_check as $key => $val){
						$check_array[] =  $val->ul;
					}
					if (in_array(Yii::app()->user->id, $check_array)){
						$it_user = true;
					}else{
						$it_user = false;
						$erroruser = true ;
						$this->redirect(array('virtualclassroom/index','erroruser'=>$erroruser));
					}

				}else{
					$it_user = true;
				}
			}else{
				$it_user = true;
			}

			$itsnum_learn = true;
			if(!empty($room->number_learn)){
							
								$infoParams = array(
									'meetingId' => $room->id,		
									'password' => $room->moderatorPw		
								);

								try {$result = $bbb->getMeetingInfoWithXmlResponseArray($infoParams);}
									catch (Exception $e) {
										//echo 'Caught exception: ', $e->getMessage(), "\n";
										echo 'Error';
										$itsnum_learn = false;
									}
				if($result['participantCount'] >= $room->number_learn ){
					$errornum = true ;
				    $this->redirect(array('virtualclassroom/index','error_num_nokey'=>$errornum));
				}
			}

			$isdate = true;	
			if(!empty($room->start_learn_room) || !empty($room->end_learn_room)){

				$date = date_create(date("Y-m-d H:i:s"));
				$newdate = date_format($date, 'U');

				$date_st = date_create($room->start_learn_room);
				$newdatest = date_format($date_st, 'U');

				$date_en = date_create($room->end_learn_room);
				$newdateen = date_format($date_en, 'U');

				$isdate = false;

				if($newdate >= $newdatest  && $newdate <= $newdateen){
					$isdate = true;		
				}
				if ($isdate == false) {
					$errordate = true ;
					$this->redirect(array('virtualclassroom/index','error_date_nokey'=>$errordate));
				}
			}


			$itsAllGood = true;
			try {$result = $bbb->getJoinMeetingURL($joinParams);}
				catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
					$itsAllGood = false;
				}

			if ($itsAllGood == true && $isdate = true && $itsnum_learn = true) {
				//Output results to see what we're getting:
				$this->redirect($result);
			}else{
				$this->redirect(array('virtualclassroom/index'));
			}

		}
	}


		public function actionLogoutroom()
	{
		$room_id = $_GET['vroom_id'];
		if(Yii::app()->user->id && $room_id)
		{

		$log_learn = Vroomloglearn::model()->findByAttributes(array(
            'v_room_id'=> $room_id, 'active'=>"y", 'user_id' => Yii::app()->user->id,
        ));

		if($log_learn){

		$log_learn->time_learn_end = date("Y-m-d H:i:s");
		$remain=intval(strtotime($log_learn->time_learn_end)-strtotime($log_learn->time_learn_start));
		$wan=floor($remain/86400);
		$l_wan=$remain%86400;
		$hour=floor($l_wan/3600);
		$l_hour=$l_wan%3600;
		$minute=floor($l_hour/60);
		$second=$l_hour%60;
		$log_learn->learn_minute = $minute;

		if($minute >= 35){
		$log_learn->status_learn = 1;
		}else{
		$log_learn->active = 'n';	
		}

		if($log_learn->save()){

		$this->redirect(array('virtualclassroom/index'));
		}

		}
		else{

			$this->redirect(array('virtualclassroom/index'));
		}
		}
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
}