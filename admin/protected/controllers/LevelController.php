<?php
class LevelController extends Controller
{
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

	public function actions()
	{
	    return array(
            'toggle'=>'ext.jtogglecolumn.ToggleAction',
            'switch'=>'ext.jtogglecolumn.SwitchAction',
            'qtoggle'=>'ext.jtogglecolumn.QtoggleAction',
	    );
	}

	/*public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}*/

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionIndex()
	{
		$model=new Level('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Level']))
			$model->attributes=$_GET['Level'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Level::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/*protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='level-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}*/
}
