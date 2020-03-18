<?php

class VirtualClassroomController extends Controller
{

	public function actionCreate()
	{
		$model = new VRoom;

		if(isset($_POST['VRoom']))
		{
			$model->attributes=$_POST['VRoom'];
			$model->attendeePw=md5('attendeePw'.date('YmdHis'));
			$model->moderatorPw=md5('moderatorPw'.date('YmdHis'));
			$model->save();
			$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
	
		if(isset($_POST['VRoom']))	
		{
			$model->attributes=$_POST['VRoom'];
			$model->save();
			$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
	    $model = $this->loadModel($id);
	    $model->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{	
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) {
	        foreach($_POST['chk'] as $val) {
	            $this->actionDelete($val);
	        }
	    }
	}

	public function actionIndex()
	{

		/*$bbb=Yii::app()->bigbluebutton;
		try 
		{
		    $url=$bbb->createApiQuery("getMeetings");
		    $data=$bbb->getApiResponse($url);
		    CVarDumper::dump($data, 10, 1);
		} catch (BigBlueButtonException $ex)
		{
		    //remember to properly handle exception if something goes wrong
		    throw $ex;
		}*/
		
		$model=new VRoom('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['VRoom']))
			$model->attributes=$_GET['VRoom'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionRoomStatus($id)
	{
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();

		$room = Vroom::model()->findByPk($id);
		$meetingId = $room->id;
		$password = $room->moderatorPw;
		// Get the URL to join meeting:
		$itsAllGood = true;

		$infoParams = array(
			'meetingId' => $meetingId,		
			'password' => $password		
		);

		try {$result = $bbb->getMeetingInfoUrl($infoParams);}
			catch (Exception $e) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
				$itsAllGood = false;
			}

		if ($itsAllGood == true) {
			//Output results to see what we're getting:
			print_r($result);
		}
			
		return $model;
	}

	public function actionCreateRoom($id)
	{
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();

		$room = Vroom::model()->findByPk($id);
		if($room && !Yii::app()->user->isGuest){
			$creationParams = array(
				'meetingId' => $room->id, 					// REQUIRED
				'meetingName' => $room->name, 	// REQUIRED
				'attendeePw' => $room->attendeePw, 					// Match this value in getJoinMeetingURL() to join as attendee.
				'moderatorPw' => $room->moderatorPw, 					// Match this value in getJoinMeetingURL() to join as moderator.
				'welcomeMsg' => $room->welcomeMsg, 					// ''= use default. Change to customize.
	/*			'dialNumber' => '', 					// The main number to call into. Optional.
				'voiceBridge' => '12345', 				// 5 digit PIN to join voice conference.  Required.
				'webVoice' => '', 						// Alphanumeric to join voice. Optional.
				'logoutUrl' => '', 						// Default in bigbluebutton.properties. Optional.
				'maxParticipants' => '-1', 				// Optional. -1 = unlimitted. Not supported in BBB. [number]
				'record' => 'false', 					// New. 'true' will tell BBB to record the meeting.
				'duration' => '0', 						// Default = 0 which means no set duration in minutes. [number]
				//'meta_category' => '', 				// Use to pass additional info to BBB server. See API docs.*/
				'record' => 'true'
			);

			// preupload doc
			if(count($room->docs) > 0){
				
				$xml = "<?xml version='1.0' encoding='UTF-8'?> <modules><module name='presentation'> ";
				foreach ($room->docs as $key => $doc) {

					$xml .= "<document url='".str_replace("/admin/../", "/", Yii::app()->getUploadUrl('vc')).$doc->name."' />";
				}

				$xml .= " </module></modules>";
			}else{
				$xml = '';
			}
			// var_dump($xml);
			
			// exit;
			// Create the meeting and get back a response:
			$itsAllGood = true;
			try {$result = $bbb->createMeetingWithXmlResponseArray($creationParams,$xml);}
				catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
					$itsAllGood = false;
				}

			if ($itsAllGood == true) {
				// If it's all good, then we've interfaced with our BBB php api OK:
				if ($result == null) {
					// If we get a null response, then we're not getting any XML back from BBB.
					echo "Failed to get any response. Maybe we can't contact the BBB server.";
					$this->redirect(array('VirtualClassroom/Index'));
				}	
				else { 
				// We got an XML response, so let's see what it says:
				//print_r($result);
					if ($result['returncode'] == 'SUCCESS') {
						// Then do stuff ...
						echo "<p>Meeting succesfullly created.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
					else {
						echo "<p>Meeting creation failed.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
				}
			}
		}else{
			echo "<p>Meeting creation failed.</p>";
			$this->redirect(array('VirtualClassroom/Index'));
			// error
		}

	}

	public function actionEndRoom($id)
	{
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();

		$room = Vroom::model()->findByPk($id);
		if($room && !Yii::app()->user->isGuest){

			$endParams = array(
				'meetingId' => $room->id, 			// REQUIRED - We have to know which meeting to end.
				'password' => $room->moderatorPw,				// REQUIRED - Must match moderator pass for meeting.
			);


			// Create the meeting and get back a response:
			$itsAllGood = true;
			try {$result = $bbb->endMeetingWithXmlResponseArray($endParams);}
				catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
					$itsAllGood = false;
				}

			if ($itsAllGood == true) {
				// If it's all good, then we've interfaced with our BBB php api OK:
				if ($result == null) {
					// If we get a null response, then we're not getting any XML back from BBB.
					echo "Failed to get any response. Maybe we can't contact the BBB server.";
					$this->redirect(array('VirtualClassroom/Index'));
				}	
				else { 
				// We got an XML response, so let's see what it says:
				//print_r($result);
					if ($result['returncode'] == 'SUCCESS') {
						// Then do stuff ...
						echo "<p>Meeting succesfullly ended.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
					else {
						echo "<p>Failed to end meeting.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
				}
			}
		}else{
			echo "<p>Failed to end meeting.</p>";
			$this->redirect(array('VirtualClassroom/Index'));
			// error
		}

	}


	public function loadModel($id)
	{
		$model=VRoom::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-online-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = CourseOnline::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = CourseOnline::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();
				}
			}
		}
	}

	public function actionCheckExists()
    {
        $webroot = Yii::app()->getUploadPath('vc');
        $targetFolder = $webroot; // Relative to the root and should match the upload folder in the uploader script

        if (file_exists($targetFolder . $_POST['filename'])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function actionUploadifive()
    {
        // Set the uplaod directory
        $webroot = Yii::app()->getUploadPath('vc');
        $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('jpg','pdf','ppt','pptx','doc'); // Allowed file extensions

        if (!empty($_FILES)) {

            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = $uploadedFile->getName();

            $targetFile = $uploadDir . $fileName;

            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the file
                move_uploaded_file($tempFile, $targetFile);
                $roomDoc = new VRoomDoc();
                $roomDoc->room_id = $_POST['room_id'];
                $roomDoc->name = $fileName;
                $roomDoc->save();
                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }
        }
    }

}
