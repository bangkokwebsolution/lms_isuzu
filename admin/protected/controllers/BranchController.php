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
				$department_id = $modelTypePosi->department_id;

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
				$newOrgChart->department_id = $department_id;
				$newOrgChart->position_id = $position_id;
				$newOrgChart->level = 6;
				$newOrgChart->active = 'y';
				$newOrgChart->save();
				$newOrgChart->sortOrder = $newOrgChart->id;
				$newOrgChart->save();

				$model->attributes=$_POST['Branch'];

				$sortOrder_model = Department::model()->find(array(
					'condition' => 'active=:active',
					'params' => array(':active' => 'y'),
					'order' => 'sortOrder DESC'
				));

				if($sortOrder_model != ""){
					$n_sortOrder = ($sortOrder_model->sortOrder)+1;
				}else{
					$n_sortOrder = 1;
				}
				$model->sortOrder = $n_sortOrder;

				if($model->save())
					$newOrgChart->branch_id = $model->id;
					$newOrgChart->save();

					$this->redirect(array('branch/index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$type_position_id = $_POST['Branch'][position_id];
		$branch_titles = $_POST['Branch'][branch_name];	

		$modelTypeBranch = Branch::model()->findByPk($id);
		$typeBranchName = $modelTypeBranch->branch_name;

		// if(isset($_POST['Branch']))
		// 		{
				
		// 	}

		if(isset($_POST['Branch']))
		{
		    $modelTypePosiToOrg= Position::model()->findByPk($type_position_id);
			$typePosiOrgName = $modelTypePosiToOrg->position_title;

			$criteria1 = new CDbCriteria();
			$criteria1->compare('position_id',$type_position_id);
			$criteria1->compare('title',$typePosiOrgName);
			$modelParent = OrgChart::model()->findAll($criteria1);
			foreach ($modelParent as $key => $value) {
					$idParent = $value->id;
			}

			// var_dump($modelParent);exit();

			$criteria = new CDbCriteria();
			$criteria->compare('branch_id',$id);
			$criteria->compare('title',$typeBranchName);
			$modelOrgChart = OrgChart::model()->findAll($criteria);
				foreach ($modelOrgChart as $key => $value) {
					$value->title = $branch_titles;
					$value->position_id = $type_position_id;
					$value->parent_id = $idParent;
					$value->save();
				}
		}

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
		$modelOrgChart=OrgChart::model()->updateAll(
            array('active' => "n"), 
            'branch_id ='.$id
        );


		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save(false);

		$mmodell = Branch::model()->findAll(array(
			'condition' => 'active=:active',
			'params' => array(':active'=>'y'),
			'order' => 'sortOrder ASC',
		));
		foreach ($mmodell as $key => $value) {
			$model_edit = Branch::model()->findByPk($value->id);
			$model_edit->sortOrder = $key+1;
			$model_edit->save(false);
		}

		
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

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = Branch::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = Branch::model()->findByPk($_POST['items'][$i]);
//				echo $item->sortOrder." = ".$cur_items[$i]->sortOrder."<br>";
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();

					$org_1 = OrgChart::model()->find(array(
					'condition' => 'active=:active AND department_id=:department_id AND position_id IS NULL AND branch_id IS NULL',
					'params' => array(':active' => 'y', ':department_id'=>$item->id),
				));

					$org_2 = OrgChart::model()->find(array(
					'condition' => 'active=:active AND department_id=:department_id AND position_id IS NULL AND branch_id IS NULL',
					'params' => array(':active' => 'y', ':department_id'=>$cur_items[$i]->id),
				));

					$org_1->sortOrder = $org_2->id;
					var_dump($org_2->sortOrder);
					// $org_2->sortOrder = $org_1->sortOrder;
					$org_1->save();
					// $org_2->save();
				}
			}
		}
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
