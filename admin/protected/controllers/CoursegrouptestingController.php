<?php

class CoursegrouptestingController extends Controller
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
    	$model=new Coursegrouptesting;
    	if(isset($_POST['Coursegrouptesting']))
    	{
    		$model->attributes=$_POST['Coursegrouptesting'];
            // $model->course_id=$_POST['course_id'];
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
        ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
            $check_user = User::model()->findByPk(Yii::app()->user->id);
            $group = $check_user->group;
            $group_arr = json_decode($group);
            $see_all = 2;
            if(in_array("1", $group_arr) || in_array("7", $group_arr)){
                $see_all = 1;
            }
            //////////////////
            if($see_all == 1 || $model->create_by == Yii::app()->user->id){

    	

    	if(isset($_POST['Coursegrouptesting']))
    	{
    		$model->attributes=$_POST['Coursegrouptesting'];
            // $model->course_id=$_POST['course_id'];
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
        $this->redirect(array('index'));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
            $check_user = User::model()->findByPk(Yii::app()->user->id);
            $group = $check_user->group;
            $group_arr = json_decode($group);
            $see_all = 2;
            if(in_array("1", $group_arr) || in_array("7", $group_arr)){
                $see_all = 1;
            }
            //////////////////
            if($see_all == 1 || $model->create_by == Yii::app()->user->id){
		//$this->loadModel($id)->delete();
        // if($state){
        //     $model = $this->loadModelCoursequestion($id);
        // }else{
        //     $model = $this->loadModel($id);
        // }
    	
        
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
        $this->redirect(array('index'));
    }

    public function actionMultiDelete()
    {	
    	// header('Content-type: application/json');
    	if(isset($_POST['chk'])) 
    	{
    		foreach($_POST['chk'] as $val) 
    		{
    			$this->actionDelete($val,true);
            
    		}
    	}
    }

    public function actionIndex()
    {
    	$model=new Coursegrouptesting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Coursegrouptesting']))
			$model->attributes=$_GET['Coursegrouptesting'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

    public function actionOnchangeList(){
        // var_dump($_POST);
        $courseAll = CourseOnline::model()->findAll(array("condition"=>"active = 'y' and lang_id = ".$_POST['lang_id'],'order'=>'course_id'));
        $options = '<option value>ทั้งหมด</option>';
        foreach ($courseAll as $key => $value) {
            
            $options .= '<option value = "'.$value->course_id.'">'.$value->course_title.'</option>';
            # code...
        }
        echo   $options;
    }

	public function loadModel($id)
	{
		$model=Coursegrouptesting::model()->grouptestingcheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='coursegrouptesting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
