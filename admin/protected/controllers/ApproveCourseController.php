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

    }

    
	public function actionIndex()
	{

		$model=new ApproveCourse('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ApproveCourse']))
			$model->attributes=$_GET['ApproveCourse'];

		$this->render('index',array(
			'model'=>$model,
		));
		

		
	}

	public function actionGeneral()
	{

		$model=new ApproveCourse('searchGeneral');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ApproveCourse']))
			$model->attributes=$_GET['ApproveCourse'];

		$this->render('general',array(
			'model'=>$model,
		));

	}

	public function actionGetDatamodal()
	{
		if (isset($_POST["course_id"]) && isset($_POST["user_id"]) && isset($_POST["request_id"])) {
			$course_id = $_POST["course_id"];
			$user_id = $_POST["user_id"];
			$request_id = $_POST["request_id"];

		
			$CourseOnline = CourseOnline::model()->findByPk($course_id);

			$form_text = "";
			if ($CourseOnline != "") {
				$form_text .= "<h3 style='margin-bottom: 10px;'><b>ข้อมูลหลักสูตร</b></h3>";

				$form_text .= "<div class='row' style='margin-bottom: 20px;'>";
				$form_text .= "<div class='col-md-12'>";
				$form_text .= "<p class='pull-left' style='display: inline-block; font-size: 16px;'>Course Name</p>";
				$form_text .= "</div>";
				$form_text .= "<div class='col-md-6'>";
				$form_text .= "<input class='form-control' style='height: 40px;' readonly type='text' value='" . $CourseOnline->course_title . "'>";				
				$form_text .= "</div>";
				$form_text .= "</div>";
			}

			echo $form_text;
		}
	}

	public function actionSaveApproval()
	{
		if (isset($_POST["request_id"]) && $_POST["request_id"] != "" && isset($_POST["approval_status"]) && $_POST["approval_status"] != "") {
			$request_id = $_POST["request_id"];
			$approval_status = $_POST["approval_status"];

			$request = TrainingRequest::model()->findByPk($request_id);
			$request_step = $request->request_step + 1;

			if ($request_step <= 2 && $request->request_status == 3) {

				$approve = new TrainingRequestApproval;
				$approve->request_id = $request_id;
				$approve->approval_status = $approval_status;
				$approve->approval_user = Yii::app()->user->id;
				$request->request_step = $request_step;

				if ($approve->approval_status == 2) {
					$request->request_status = 2;
					$approve->approval_note = $_POST["comment"];
				}

				if ($approve->save() && $request->save()) {
					if (Yii::app()->user->id) {
						Helpers::lib()->getControllerActionId();
					}
					echo "success";
				} else {
					echo "error";
				}
			} else {
				echo "error";
			}
		}
	}

}