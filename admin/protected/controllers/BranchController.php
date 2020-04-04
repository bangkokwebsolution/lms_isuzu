<?php

class BranchController extends Controller
{
	public function filters() 
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
        );
	}

	public function accessRules()
	{
		return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('Sequence'),
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

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Branch;

		if(isset($_POST['Branch']))
		{

			if($_POST['Branch'][position_id] != null && $_POST['Branch'][branch_name] != null){

				$position_id = $_POST['Branch'][position_id];
				$branch_name = $_POST['Branch'][branch_name];

				$modelTypePosi = Position::model()->findByPk($position_id);
				$typePosiName = $modelTypePosi->position_title;

				$criteria = new CDbCriteria;
				$criteria->compare('title',$typePosiName);
				$modelOrgChart = OrgChart::model()->findAll($criteria);

				if($modelOrgChart){
					foreach ($modelOrgChart as $value) {
						$idOrgChart = $value->id;
					}
				}

				$newOrgChart = new OrgChart;
				$newOrgChart->title = $branch_name;
				$newOrgChart->parent_id = $idOrgChart;
				$newOrgChart->level = 6;
				$newOrgChart->active = 'y';
				$newOrgChart->save();

				$model->attributes=$_POST['Branch'];
				if($model->save())
					$this->redirect(array('branch/index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if(isset($_POST['Branch']))	
		{
			$model->attributes=$_POST['Branch'];

			if($model->validate())
			{
				if($model->save())
				{
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($model->id);
					}
					$this->redirect(array('Branch/index'));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save(false);
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{
		// echo "string";
		// exit();	
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			}
		}
	}


	public function actionIndex()
	{
		$model=new Branch('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Branch']))
			$model->attributes=$_GET['Branch'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Branch::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='branch-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
