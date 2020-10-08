<?php

class LogStartcourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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

    public function actionIndex()
    {
    	$model = new LogStartcourse('search');
    	$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LogStartcourse']))
			$model->attributes=$_GET['LogStartcourse'];

		$this->render('index',array(
			'model'=>$model,
		));
    }

    public function actionSendMailMessage()
    {
    	$id = $_POST['id'];
    	if ($id != null) {
	    	$LogStartcourse = LogStartcourse::model()->findByPk($id);
	    	$User = User::model()->findByPk($LogStartcourse->user_id);
			$profile = Profile::model()->findByPk($LogStartcourse->user_id);
    		
    	$to['email'] = $User->email;
		$to['firstname'] = $User->profile->firstname;
		$to['lastname'] = $User->profile->lastname;
		$message = $this->renderPartial('_mail_CourseAlart',array('User' => $User),true);
		if($message){
			 $send = Helpers::lib()->SendMail($to,'แจ้งเตือนสมัครเข้าเรียนระบบ',$message);
	
		}
		$this->redirect(array('index'));
		}
    }

    public function actionMultiSendMailMessages()
    {
    	if (isset($_POST['chk'])) {
    		foreach ($_POST['chk'] as $key => $value) {
    			$LogStartcourse = LogStartcourse::model()->findByPk($value);
	    		$User = User::model()->findByPk($LogStartcourse->user_id);
				$profile = Profile::model()->findByPk($LogStartcourse->user_id);
				$to['email'] = $User->email;
				$to['firstname'] = $User->profile->firstname;
				$to['lastname'] = $User->profile->lastname;
				$message = $this->renderPartial('_mail_CourseAlart',array('User' => $User),true);
				if($message){
					 $send = Helpers::lib()->SendMail($to,'แจ้งเตือนสมัครเข้าเรียนระบบ',$message);
			
				}
    		}
    	}
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Manage the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LogStartcourse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Manage $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='LogStartcourse-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
