<?php

class OrgmanageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function init()
    {
        parent::init();
        $this->lastactivity();

    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionDivision()
	{
		$model = new Orgchart('search');
		$model->unsetAttributes();  // clear any default values
		$model->level = "2";
		$model->active = "y";

		if(isset($_GET['OrgChart'])){
			$model->attributes=$_GET['OrgChart'];
		}

		$this->render('Division',array(
			'model'=>$model,
		));
	}

	public function actionDivision_create()
	{
		$model = new Orgchart;
		// $model->scenario = 'validateCheckk';

		if(isset($_POST['OrgChart']))
		{
			// var_dump($_POST['OrgChart']);exit();
			$model->attributes=$_POST['OrgChart'];
			$model->level = 2;
			$model->parent_id = 1;
			

			if($model->save()){
				$model->division_id = $model->id;//บันทึก Division id ด้วย				
				// $model->sortOrder = $model->id;
				$model->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Division'));
			}
		}

		$this->render('Division_create',array(
			'model'=>$model,
		));

	}

	public function actionDivision_update($id)
	{
		$model = Orgchart::model()->findByPk($id);

		if(isset($_POST['OrgChart']))
		{
			
			$model->attributes=$_POST['OrgChart'];
			
			if($model->save(false)){

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Division'));
			}
		}

		$this->render('Division_update',array(
			'model'=>$model,
		));

	}

	public function actionDivision_delete($id)
	{	
		
		$model = Orgchart::model()->findByPk($id);
		$model->active = 'n';
		// $model->org_number = null;
		$model->save(false);

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('Division'));
		}
		// $this->redirect(array('ManageOrg'));
	}

	// Department
	public function actionDepartment()
	{
		$model = new Orgchart('search');
		$model->unsetAttributes();  // clear any default values
		$model->level = "3";
		$model->active = "y";

		if(isset($_GET['OrgChart'])){
			$model->attributes=$_GET['OrgChart'];
			$model->level = "3";
			$model->active = "y";
		}

		$this->render('Department',array(
			'model'=>$model,
		));
	}


	public function actionDepartment_create()
	{
		$model = new Orgchart;

		if(isset($_POST['OrgChart']))
		{
			// var_dump($_POST);exit();
			$model->parent_id=$_POST['OrgChart']["parent_id"];
			$model->title=$_POST['OrgChart']["title"];
			$model->level = 3;
			$model->division_id = $_POST['OrgChart']["parent_id"];

			if($model->save(false)){				
				$model->department_id = $model->id;
				$model->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('Department'));
			}
		}

		$this->render('Department_create',array(
			'model'=>$model,
		));

	}

	public function actionDepartment_update($id)
	{
		$model = Orgchart::model()->findByPk($id);

		if(isset($_POST['OrgChart']))
		{
			
			$model->attributes=$_POST['OrgChart'];
			$model->division_id = $_POST['OrgChart']["parent_id"];
			$model->department_id = $model->id;
			
			if($model->save(false)){

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Department'));
			}
		}

		$this->render('Department_update',array(
			'model'=>$model,
		));

	}

	public function actionDepartment_delete($id)
	{	
		
		$model = Orgchart::model()->findByPk($id);
		$model->active = 'n';
		// $model->org_number = null;
		$model->save(false);

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('Department'));
		}
		// $this->redirect(array('ManageOrg'));
	}

	
	public function actionGroup()
	{
		$model = new Orgchart('search');
		$model->unsetAttributes();  // clear any default values
		$model->level = "4";
		$model->active = "y";


		if(isset($_GET['OrgChart'])){
			$model->attributes=$_GET['OrgChart'];
			$model->level = "4";
			$model->active = "y";
		}

		$this->render('Group',array(
			'model'=>$model,
		));
	}

	public function actionGroup_create()
	{
		$model = new Orgchart;

		if(isset($_POST['OrgChart']))
		{
			// var_dump($_POST);exit();
			$model->parent_id=$_POST['OrgChart']["parent_id"];
			$model->title=$_POST['OrgChart']["title"];
			$model->division_id=$_POST['OrgChart']["division_id"];
			$model->department_id = $_POST['OrgChart']["parent_id"];
			$model->level = 4;
			// $model->parent_id = 1;

			if($model->save()){				
				
				$model->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('Group'));
			}
		}

		$this->render('Group_create',array(
			'model'=>$model,
		));

	}

	public function actionGroup_update($id)
	{
		$model = Orgchart::model()->findByPk($id);

		if(isset($_POST['OrgChart']))
		{
			
			$model->attributes=$_POST['OrgChart'];
			$model->department_id = $_POST['OrgChart']["parent_id"];
			$model->group_id = $model->id;
			
			if($model->save(false)){

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Group'));
			}
		}

		$this->render('Group_update',array(
			'model'=>$model,
		));

	}

	public function actionGroup_delete($id)
	{	
		
		$model = Orgchart::model()->findByPk($id);
		$model->active = 'n';
		// $model->org_number = null;
		$model->save(false);

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('Group'));
		}
		// $this->redirect(array('ManageOrg'));
	}




	public function actionSection()
	{
		$model = new Orgchart('search');
		$model->unsetAttributes();  // clear any default values
		$model->level = "5";
		$model->active = "y";


	

		if(isset($_GET['OrgChart'])){
			// var_dump($_GET);exit();
			$model->attributes=$_GET['OrgChart'];
			$model->level = "5";
			$model->active = "y";
		}

		$this->render('Section',array(
			'model'=>$model,
		));
	}

	public function actionSection_create()
	{
		$model = new Orgchart;

		if(isset($_POST['OrgChart']))
		{
			// var_dump($_POST);exit();
			$model->parent_id=$_POST['OrgChart']["parent_id"];
			$model->title=$_POST['OrgChart']["title"];
			$model->division_id=$_POST['OrgChart']["division_id"];
			$model->department_id=$_POST['OrgChart']["department_id"];
			$model->group_id=$_POST['OrgChart']["parent_id"];
			
			$model->level = 5;
			// $model->parent_id = 1;

			if($model->save()){				
				$model->section_id=$model->id;
				$model->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('Section'));
			}
		}

		$this->render('Section_create',array(
			'model'=>$model,
		));

	}

	public function actionSection_update($id)
	{
		$model = Orgchart::model()->findByPk($id);

		if(isset($_POST['OrgChart']))
		{
			
			

			$model->attributes=$_POST['OrgChart'];
			$model->group_id =$_POST['OrgChart']["parent_id"];
			
			if($model->save(false)){

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Section'));
			}
		}

		$this->render('Section_update',array(
			'model'=>$model,
		));

	}

	public function actionSection_delete($id)
	{	
		
		$model = Orgchart::model()->findByPk($id);
		$model->active = 'n';
		// $model->org_number = null;
		$model->save(false);

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('Section'));
		}
		// $this->redirect(array('ManageOrg'));
	}

	public function actionListDepartment(){
		$model = OrgChart::model()->findAll("active='y' AND parent_id='".$_POST["id"]."'");
		$data = CHtml::listData($model,'id','title',array('empty' => 'Department'));
		$sub_list = 'เลือก Department';
		$data = '<option value ="">'.$sub_list.'</option>';
		foreach ($model as $key => $value) {
			$data .= '<option value = "'.$value->id.'"'.'>'.$value->title.'</option>';
		}
		echo ($data);
	}

	public function actionListGroup(){
		$model = OrgChart::model()->findAll("active='y' AND parent_id='".$_POST["id"]."'");
		$data = CHtml::listData($model,'id','title',array('empty' => 'Group'));
		$sub_list = 'เลือก Group';
		$data = '<option value ="">'.$sub_list.'</option>';
		foreach ($model as $key => $value) {
			$data .= '<option value = "'.$value->id.'"'.'>'.$value->title.'</option>';
		}
		echo ($data);
	}

	public function actionListSection(){
		$model = OrgChart::model()->findAll("active='y' AND parent_id='".$_POST["id"]."'");
		$data = CHtml::listData($model,'id','title',array('empty' => 'Group'));
		$sub_list = 'เลือก Section';
		$data = '<option value ="">'.$sub_list.'</option>';
		foreach ($model as $key => $value) {
			$data .= '<option value = "'.$value->id.'"'.'>'.$value->title.'</option>';
		}
		echo ($data);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrgChart the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrgChart::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OrgChart $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='org-chart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
