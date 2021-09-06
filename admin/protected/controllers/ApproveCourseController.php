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
		// $model->compare('parent_id', 0);
		// $model->compare('active', 'y');
		// $model->with=array('cates');
		// $model->compare('categorys.cate_type', 1);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ApproveCourse']))
			$model->attributes=$_GET['ApproveCourse'];

		$this->render('index',array(
			'model'=>$model,
		));
		

		
	}

	public function actionGeneral()
	{

		if(isset($_GET['user_list'])){
			$authority_hr = 2;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->authority_hr = $authority_hr;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('AuthorityHR/hr2'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->authority_hr = 0;
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}



		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->compare('authority_hr', 0);
		$userAll = User::model()->with('profile')->findAll($criteria);

		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->compare('authority_hr', 2);
		$user_hr2 = User::model()->with('profile')->findAll($criteria);



		$this->render('general', array('userAll'=>$userAll, 'user'=>$user_hr2));
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