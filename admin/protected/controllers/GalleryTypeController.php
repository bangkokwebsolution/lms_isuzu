<?php

class GalleryTypeController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public function filters() 
	{
		return array(
//            'rights',
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
           array('allow',  // allow all users to perform 'index' and 'view' actions
           	'actions' => array('index', 'view', 'update','multidelete','delete'),
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
		$model=new GalleryType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GalleryType']))
		{
			$model->attributes=$_POST['GalleryType'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['GalleryType']))
		{
			$model->attributes=$_POST['GalleryType'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);

		$model->active = 'n';

		$model->save();

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{	
		if(isset($_POST['chk'])) 
		{
			foreach($_POST['chk'] as $val) 
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionIndex()
	{
		$model=new GalleryType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GalleryType']))
			$model->attributes=$_GET['GalleryType'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=GalleryType::model()->gallerytypecheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
