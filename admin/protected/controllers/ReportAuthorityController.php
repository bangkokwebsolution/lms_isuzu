<?php

class ReportAuthorityController extends Controller
{

	public function init()
	{
		parent::init();
		$this->lastactivity();		
	}

	public function actionBoard()
	{
		$userAll = User::model()->with('profile')->findAll(array(
			'condition'=>'superuser=0 AND report_authority IS NULL',
			'order'=>'profile.firstname ASC',
		));
		$user_board = User::model()->findAll(array(
			'condition'=>'superuser=0 AND report_authority=1',
			'order'=>'profile.firstname ASC',
		));

		if(isset($_GET['user_list'])){
			$report_authority = 1;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->report_authority = $report_authority;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('ReportAuthority/board'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->report_authority = "";
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}

		$this->render('board',array(
			'userAll'=>$userAll,
			'user_board'=>$user_board
		));
	}

	public function actionDivisionManager()
	{
		$userAll = User::model()->with('profile', 'department')->findAll(array(
            'condition'=>'superuser=0 AND report_authority IS NULL AND department_id IS NOT NULL AND department.active="y" AND profile.type_employee IS NOT NULL',
            'order'=>'profile.firstname ASC',
        ));
		$user_division = User::model()->findAll(array(
            'condition'=>'superuser=0 AND report_authority=2 AND department_id IS NOT NULL',
            'order'=>'profile.firstname ASC',
        ));

        if(isset($_GET['user_list'])){
			$report_authority = 2;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->report_authority = $report_authority;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('ReportAuthority/DivisionManager'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->report_authority = "";
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}

		$this->render('divisionManager',array(
			'userAll'=>$userAll,
			'user_division'=>$user_division
		));
	}

	public function actionDepartmentManager()
	{
		$userAll = User::model()->with('profile', 'department', 'position')->findAll(array(
            'condition'=>'superuser=0 AND report_authority IS NULL AND user.department_id IS NOT NULL AND department.active="y" AND position_id IS NOT NULL AND position.active="y" AND profile.type_employee IS NOT NULL',
            'order'=>'profile.firstname ASC',
        ));
		$user_department = User::model()->findAll(array(
            'condition'=>'superuser=0 AND report_authority=3 AND user.department_id IS NOT NULL AND position_id IS NOT NULL',
            'order'=>'profile.firstname ASC',
        ));

        if(isset($_GET['user_list'])){
			$report_authority = 3;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->report_authority = $report_authority;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('ReportAuthority/DepartmentManager'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->report_authority = "";
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}
				
				echo "success";
				exit();
			}
		}

		$this->render('departmentManager',array(
			'userAll'=>$userAll,
			'user_department'=>$user_department
		));
	}



}