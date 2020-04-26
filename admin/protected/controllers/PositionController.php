<?php

class PositionController extends Controller
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

	public function actionCreate()
	{
		$model = new Position;

		if(isset($_POST['Position']))
		{
			if($_POST['Position'][department_id] != null && $_POST['Position'][position_title] != null){

				$department_id = $_POST['Position'][department_id];
				$position_title = $_POST['Position'][position_title];

				$modelTypeDep = Department::model()->findByPk($department_id);
				$typeDepName = $modelTypeDep->dep_title;

				$criteria = new CDbCriteria;
				$criteria->compare('title',$typeDepName);
				$criteria->compare('department_id',$department_id);
				$modelOrgChart = OrgChart::model()->findAll($criteria);

				if($modelOrgChart){
					foreach ($modelOrgChart as $value) {
						$idOrgChart = $value->id;
					}
				}

				$newOrgChart = new OrgChart;
				$newOrgChart->title = $position_title;
				$newOrgChart->parent_id = $idOrgChart;
				$newOrgChart->level = 5;
				$newOrgChart->active = 'y';
				$newOrgChart->save();

				$model->attributes=$_POST['Position'];
				if($model->validate())
				{
				if($model->save()){
					$newOrgChart->position_id = $model->id;
					$newOrgChart->department_id = $department_id;
					$newOrgChart->save();


					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					$this->redirect(array('position/index'));
				}
			}
				
			}
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{

		$type_employee_id = $_POST['Position'][department_id];
		$posi_titles = $_POST['Position'][position_title];

		$modelTypePosi= Position::model()->findByPk($id);
		$typePosiName = $modelTypePosi->position_title;

		if(isset($_POST['Position']))
		{
		    $modelTypeDepToOrg= Department::model()->findByPk($type_employee_id);
			$typeDepOrgName = $modelTypeDepToOrg->dep_title;

			$criteria1 = new CDbCriteria();
			$criteria1->compare('department_id',$type_employee_id);
			$criteria1->compare('title',$typeDepOrgName);
			$modelParent = OrgChart::model()->findAll($criteria1);
			foreach ($modelParent as $key => $value) {
					$idParent = $value->id;
			}

			$criteria = new CDbCriteria();
			$criteria->compare('position_id',$id);
			$criteria->compare('title',$typePosiName);
			$modelOrgChart = OrgChart::model()->findAll($criteria);
				foreach ($modelOrgChart as $key => $value) {
					$value->title = $posi_titles;
					$value->department_id = $type_employee_id;
					$value->parent_id = $idParent;
					$value->save();
				}
		}


		$model = $this->loadModel($id);
		if(isset($_POST['Position']))	
		{
			$model->attributes=$_POST['Position'];

			if($model->validate())
			{
				if($model->save())
				{
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($model->id);
					}
					$this->redirect(array('position/index'));
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

		$modelOrgChart=OrgChart::model()->updateAll(
            array('active' => "n"), 
            'position_id ='.$id
            );


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
		$model=new Position('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Position']))
			$model->attributes=$_GET['Position'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Position::model()->findByPk($id);
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
}
