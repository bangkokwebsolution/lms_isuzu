<?php

class CategoryCourseController extends Controller
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
            // 'rights',
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
		$model=new CategoryCourse;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CategoryCourse']))
		{
			$model->attributes=$_POST['CategoryCourse'];
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
		$time = date("dmYHis");
		if(isset($_POST['CategoryCourse']))
		{
			$model->attributes=$_POST['CategoryCourse'];
			$pic_file = CUploadedFile::getInstance($model, 'file');
			if(isset($pic_file)){
	            $fileNamePicture = $time."_Picture.".$pic_file->getExtensionName();
            	$model->pic = $fileNamePicture;
	        }
			if($model->save()){
				if(isset($pic_file))
				{
					/////////// SAVE IMAGE //////////
					Yush::init($model);
		            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic);
		            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic);
		            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic);
		            // Save the original resource to disk
		            $pic_file->saveAs($originalPath);

		            // Create a small image
		            $smallImage = Yii::app()->phpThumb->create($originalPath);
		            $smallImage->resize(110);
		            $smallImage->save($smallPath);

		            // Create a thumbnail
		            $thumbImage = Yii::app()->phpThumb->create($originalPath);
		            $thumbImage->resize(240);
		            $thumbImage->save($thumbPath);
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CategoryCourse');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CategoryCourse('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CategoryCourse']))
			$model->attributes=$_GET['CategoryCourse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CategoryCourse the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CategoryCourse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CategoryCourse $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
