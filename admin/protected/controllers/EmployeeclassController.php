<?php

class EmployeeclassController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();

		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
		}
		

	}
	
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
            	'actions' => array('index', 'view','update','delete'),
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
	// 	return array(
	// 		'rights',
	// 		);
	// }

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    		));
    }

    public function actionCreate()
    {
    	$model = new EmpClass;
    	if(isset($_POST['EmpClass'])){
    		$model->attributes = $_POST['EmpClass'];
    		if($model->save(false)){
    			$this->redirect(array('index'));
    		}
    	}

    	$this->render('create',array(
    		'model'=>$model
    		));
    }

    public function actionUpdate($id)
    {
    	$model = $this->loadModel($id);
    	if(isset($_POST['EmpClass'])){
    		$model->attributes = $_POST['EmpClass'];
    		if($model->save(false)){
    			$this->redirect(array('index'));
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
		// $this->actionSort($model->sortOrder);
		$model->active = 0;
		$model->save();

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}


		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{
		//header('Content-type: application/json');
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
		$model= new EmpClass('search');
		$this->render('index',array(
			'model'=>$model,
			));
	}

	public function loadModel($id)
	{
		$model=EmpClass::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
// 	 public function actionSequence() {

//     if (isset($_POST['items']) && is_array($_POST['items'])) {
       
//             // Get all current target items to retrieve available sortOrders
//         $cur_items = News::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
        
//             // Check 1 by 1 and update if neccessary

//         foreach ($cur_items as $keys => $values) {

//             for ($i = 0; $i < count($_POST['items']); $i++) {
//                 $item = News::model()->findByPk($_POST['items'][$i]);

//                 if ($item->sortOrder != $cur_items[$i]->sortOrder) {
//                     $item->sortOrder = $cur_items[$i]->sortOrder ;
//                     $item->save(false);
//                 } 

//                 $modellang2 = News::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
//                   //var_dump($modellang2->sortOrder);exit();
                
//                 if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
//                     if ($modellang2->parent_id == '') {
//                         $items = News::model()->findByPk($_POST['items'][$i]);
//                         $items->sortOrder = $cur_items[$i]->sortOrder ;
//                         $items->save(false);
                        
//                     }
//                     if ($modellang2->parent_id != null) {
//                         $modellang2->sortOrder = $cur_items[$i]->sortOrder ;
//                         $modellang2->save(false);   
//                     }
                    
//                 } 
//             }
//         }        
//     }
// }

	public function actionSort($sort){
		$model = News::model()->findAll(array(
	    		'condition'=>'sortOrder >= '.$sort.' AND active="y"',
	    		'order'=>'sortOrder ASC'
	    	));

		if ($model) {
			foreach ($model as $key => $value) {
				$value->sortOrder = ($key==0)? $sort:$sort++;
				$value->save(false);
			}
		}
	}
}
