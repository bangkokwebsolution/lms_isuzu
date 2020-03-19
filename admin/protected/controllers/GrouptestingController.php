<?php

class GrouptestingController extends Controller
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
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('index', 'view','update','delete','create'),
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
    // public function filters() 
    // {
    //     return array(
    //         'rights',
    //     );
    // }

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionCreate()
    {
    	$model=new Grouptesting;

    	if(isset($_POST['Grouptesting']))
    	{
    		$model->attributes=$_POST['Grouptesting'];
            // $model->lesson_id=$_POST['lesson_id'];
            $model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
            $model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
    		if($model->save()){
    			if(Yii::app()->user->id){
    				Helpers::lib()->getControllerActionId();
    			}
    			$this->redirect(array('view','id'=>$model->group_id));
    		}
    	}

    	$this->render('create',array(
    		'model'=>$model,
    	));
    }

    public function actionUpdate($id)
    {
    	$model=$this->loadModel($id);

    	if(isset($_POST['Grouptesting']))
    	{
    		$model->attributes=$_POST['Grouptesting'];
            // $model->lesson_id=$_POST['lesson_id'];
    		if($model->save()){
    			if(Yii::app()->user->id){
    				Helpers::lib()->getControllerActionId();
    			}
    			$this->redirect(array('view','id'=>$model->group_id));
    		}
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

    	$modelManage = Manage::model()->findAllByAttributes(array('group_id' => $id));
    	if(count($modelManage) > 0) {
    		foreach($modelManage as $manage) {
    			$manage->active = 'n';
    			$manage->save();
    		}
    	}
    	if(Yii::app()->user->id){
    		Helpers::lib()->getControllerActionId();
    	}
    	if(!isset($_GET['ajax']))
    		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionMultiDelete()
    {	
    	header('Content-type: application/json');
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
    	$model=new Grouptesting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Grouptesting']))
			$model->attributes=$_GET['Grouptesting'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

    public function actionOnchangeList(){
        // var_dump($_POST);
        $lessonList = Lesson::model()->findAll(array("condition"=>"active = 'y' and lang_id = ".$_POST['lang_id'],'order'=>'id'));
        $options = '<option value>ทั้งหมด</option>';
        foreach ($lessonList as $key => $value) {
            
            $options .= '<option value = "'.$value->id.'">'.$value->title.'</option>';
            # code...
        }
        echo   $options;
    }

	public function loadModel($id)
	{
		$model=Grouptesting::model()->grouptestingcheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='grouptesting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
