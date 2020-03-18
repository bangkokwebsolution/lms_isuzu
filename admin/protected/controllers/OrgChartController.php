<?php

class OrgChartController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
    	return array(
        	array('allow',  // allow all users to perform 'index' and 'view' actions
        		'actions'=>array('index','view','OrgChart2','OrgChartSave','SaveOrgchart'),
        		'users'=>array('*'),
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

	public function actionListorg()
	{
		$model= OrgChart::model()->findAll();
		var_dump($model);exit();
	}

	public function actionEditorg()
	{
		$modelRoot= OrgChart::model()->findByPk(1177);
		$modelRoot->parent_id = null;
		$modelRoot->level = 1;
		$modelRoot->save();

		$model= OrgChart::model()->findByPk(1179);
		$model->parent_id = 1177;
		$model->level = 2;
		$model->save();
		
	}

	public function actionDel()
	{
		$model= OrgChart::model()->findAll();
		foreach ($model as $key => $value) {
			$this->loadModel($value->id)->delete();
		}
		
	}

	public function actionNeworg()
	{
		$model = new OrgChart;
		$model->id = 1;
		$model->title = 'Air Asiaแผนก TEST';
		$model->parent_id = null;
		$model->level = 1;
		$model->active = 'y';
		$model->save();

		$model = new OrgChart;
		$model->id = 2;
		$model->title = 'LMS';
		$model->parent_id = 1;
		$model->level = 2;
		$model->active = 'y';
		$model->save();

		$model = new OrgChart;
		$model->id = 4;
		$model->title = 'TMS';
		$model->parent_id = 1;
		$model->level = 2;
		$model->active = 'y';
		$model->save();
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new OrgChart;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrgChart']))
		{
			$model->attributes=$_POST['OrgChart'];
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}



	public function actionSaveOrgchart()
	{
		$allorg = OrgChart::model()->findAll();
		$chk_org = array();
		foreach ($allorg as $value) {
			$chk_org[] = $value->id;
		}

		if(isset($_POST['post_value'])){
			$chk_org_new = array();
			foreach($_POST['post_value'] as $key => $value){
				$chk_org_new[] = $value['id'];
				$model_org = OrgChart::model()->findByPk($value['id']);
				// var_dump($_POST['post_value']);
				// exit();
				if($value['id']!=1 && $value['parent_id']==""){
					$parent_value = 1;
					$level_value = 2;
				}else{
					$parent_value = $value['parent_id'];
					$level_value = $value['level'];
				}
				if($model_org){
					$model_org->title = $value['key']; //********
					$model_org->parent_id = $parent_value;
					$model_org->level = $level_value;
					$model_org->save();
				}else{
					$model = new OrgChart;
					$model->title = $value['key'];
					$model->parent_id = $parent_value;
					$model->level = $level_value;
					$model->save();
				}
			}
		}

		$result_org = array_diff($chk_org,$chk_org_new);

		foreach ($result_org as $value) {
			$model_orgchart = OrgChart::model()->findByPk($value);
			$model_orgchart->active = 'n';
			$model_orgchart->save();
		}
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		$this->render('index');
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrgChart']))
		{
			$model->attributes=$_POST['OrgChart'];
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{


/*		$root=new OrgChart;
		$root->title='Mobile Phones';
		$root->saveNode();
		$root=new OrgChart;
		$root->title='Cars';
		$root->saveNode();
		$OrgChart1=new OrgChart;
		$OrgChart1->title='Ford';
		$OrgChart2=new OrgChart;
		$OrgChart2->title='Mercedes';
		$OrgChart3=new OrgChart;
		$OrgChart3->title='Audi';
		$root=OrgChart::model()->findByPk(1);
		$OrgChart1->appendTo($root);
		$OrgChart2->insertAfter($OrgChart1);
		$OrgChart3->insertBefore($OrgChart1);

		$OrgChart1=new OrgChart;
		$OrgChart1->title='Samsung';
		$OrgChart2=new OrgChart;
		$OrgChart2->title='Motorola';
		$OrgChart3=new OrgChart;
		$OrgChart3->title='iPhone';
		$root=OrgChart::model()->findByPk(2);
		$OrgChart1->appendTo($root);
		$OrgChart2->insertAfter($OrgChart1);
		$OrgChart3->prependTo($root);

		$OrgChart1=new OrgChart;
		$OrgChart1->title='X100';
		$OrgChart2=new OrgChart;
		$OrgChart2->title='C200';
		$node=OrgChart::model()->findByPk(3);
		$OrgChart1->appendTo($node);
		$OrgChart2->prependTo($node);
*/



		$dataProvider=new CActiveDataProvider('OrgChart');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionOrgChart2()
	{
		$this->renderPartial('orgChart2');
	}

	public function actionOrgChartSave()
	{

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrgChart('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrgChart']))
			$model->attributes=$_GET['OrgChart'];

		$this->render('admin',array(
			'model'=>$model,
		));
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
