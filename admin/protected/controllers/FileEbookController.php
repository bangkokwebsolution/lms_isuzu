<?php

class FileEbookController extends Controller
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
            	'actions' => array('index', 'view','Update','Sequence'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new FileEbook;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FileEbook']))
		{
			$model->attributes=$_POST['FileEbook'];
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
		if(isset($_POST['FileEbook']))
		{
			$model->attributes=$_POST['FileEbook'];
			$model->save(false);
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
	public function actionDelete($id){
		$model = $this->loadModel($id);
		// $model->active = 'n';
		$model->delete();
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

	public function actionIndex($id)
	{
		$model=new FileEbook('search');
		$model->unsetAttributes();  // clear any default values
		$model->active = 'y';
		if(isset($_GET['FileScorm']))
			$model->attributes=$_GET['FileScorm'];

		$this->render('index',array(
			'model'=>$model,
			'id'=>$id,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FileEbook('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FileEbook']))
			$model->attributes=$_GET['FileEbook'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FileEbook the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FileEbook::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FileEbook $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-ebook-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionSequence()
	{
	    if(isset($_POST['items']) && is_array($_POST['items'])) 
	    {
	    	$SortArray = array();
			foreach ($_POST['items'] as $key => $value) 
			{
				$checkSort = FileEbook::model()->findByPk($value);
				$SortArray[] = $checkSort->file_position;
			}

			usort($SortArray, function ($a, $b){ return substr($b, -2) - substr($a, -2); });

	        $i = 0;
	        foreach ($_POST['items'] as $item) 
	        {
				FileEbook::model()->updateByPk($_POST['items'][$i], array(
					'file_position'=>$SortArray[$i],
				));
	            $i++;
	        }
	    }
	}

}
