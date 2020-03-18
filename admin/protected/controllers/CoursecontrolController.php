<?php

class CoursecontrolController extends Controller
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
		$model=new OrgCourse;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrgCourse']))
		{
			$model->attributes=$_POST['OrgCourse'];
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

		if(isset($_POST['OrgCourse']))
		{
			$model->attributes=$_POST['OrgCourse'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionIndex($id)
	{
		$OrgCourse=OrgCourse::model()->findAll(array(
			'condition'=>'orgchart_id='.$id,
			));
		$chk_orgcourse = array();
		if($OrgCourse){
			foreach ($OrgCourse as $key => $value) {
				$chk_orgcourse[] = $value->course_id;
			}

		}

		if($id == 4){
			$CourseOnline = CourseOnline::model()->courseonlinecheck()->findAll(array(
				'condition'=>'parent_id=:parent_id AND active=:active AND lang_id =:lang_id AND cate_id = 1',
				'params' => array(':parent_id' => 0, ':active' => 'y',':lang_id'=> 1)
			));
			$chk_courseonline = array();
			if($CourseOnline){
				foreach ($CourseOnline as $key => $value) {
					$chk_courseonline[] = $value->course_id;
				}
			}

		}else{

		// $CourseOnline=CourseOnline::model()->courseonlinecheck()->findAll();
			$CourseOnline = CourseOnline::model()->courseonlinecheck()->findAll(array(
				'condition'=>'parent_id=:parent_id AND active=:active AND lang_id =:lang_id AND cate_id != 1',
				'params' => array(':parent_id' => 0, ':active' => 'y',':lang_id'=> 1 )
			));
			$chk_courseonline = array();
			if($CourseOnline){
				foreach ($CourseOnline as $key => $value) {
					$chk_courseonline[] = $value->course_id;
				}
			}

		}

		// $result_orgcourse = array_diff($chk_orgcourse, $chk_courseonline);
		$result_courseonline = array_diff($chk_courseonline, $chk_orgcourse);
		// var_dump($result_courseonline);
		// exit();

		

		$this->render('index',array(
			'result_courseonline'=> $result_courseonline,
			'OrgCourse'=>$OrgCourse,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrgCourse('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrgCourse']))
			$model->attributes=$_GET['OrgCourse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function parseJsonArray($jsonArray, $parentID = 0) {
	  $return = array();
	  foreach ($jsonArray as $subArray) {
	    $returnSubSubArray = array();
	    if (isset($subArray['children'])) {
	  		$returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
	    }
	    	$return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
	    	$return = array_merge($return, $returnSubSubArray);
	  }
	  return $return;
	}

	public function actionSave_categories(){

			if(isset($_POST['categories'])) {

				$json = $_POST['categories'];
				$json2 = $_POST['categories2'];

				$data = json_decode($json, true);
				// var_dump($this->parseJsonArray($data));
				// exit();

				foreach (json_decode($json2, true) as $key => $value) {
					$orgc = OrgCourse::model()->findByPk($value['id']);
					if($orgc){
					$orgc->delete();
					}
					// echo $_GET['id'];
					// if(isset($value['children'])){
						foreach ($value['children'] as $key_children => $value_children) {
							$orgc2 = OrgCourse::model()->findByPk($value_children['id']);
							if($orgc2){
							$orgc2->delete();
							}
						}

				}
				
				foreach ($this->parseJsonArray($data) as $key => $value) {

					$orgc = OrgCourse::model()->findByPk($value['id']);
					if($orgc){
						// $course_online = CourseOnline::model()->findByPk($orgc->course_id);
						$orgc->parent_id = $value['parentID'];
						$orgc->save();
						// echo $value['id'];
					}else{
						$orgc = new OrgCourse;
						// $orgc->save();
						// $course_online = CourseOnline::model()->findByPk($value['id']);
						$orgc->orgchart_id = $_POST['org_id'];
						$orgc->course_id = $value['id'];
						$orgc->parent_id = $value['parentID'];
						$orgc->active = 'y';
						$orgc->save();
					}
					// echo $_GET['id'];
					// if(isset($value['children'])){
						// foreach ($value['children'] as $key_children => $value_children) {
						// 	$orgc2 = OrgCourse::model()->findByPk($value_children['id']);
						// 		if($orgc2){
						// 			// $course_online = CourseOnline::model()->findByPk($orgc2->course_id);
						// 			// $orgc->course_id = $course_online->course_id;
						// 			$orgc2->parent_id = $orgc->id;
						// 			$orgc2->save();
						// 			// echo $value_children['id'];
						// 		}else{
						// 			$orgc2 = new OrgCourse;
						// 			// $orgc->save();
						// 			// $course_online = CourseOnline::model()->findByPk($value['id']);
						// 			$orgc2->orgchart_id = $_POST['org_id'];
						// 			$orgc2->course_id = $value_children['id'];
						// 			$orgc2->parent_id = $orgc->id;
						// 			$orgc2->active = 'y';
						// 			$orgc2->save();
						// 		}
						// }
					// }

				}

			} else {
				echo "Noooooooo";
			}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrgCourse the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrgCourse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}



	/**
	 * Performs the AJAX validation.
	 * @param OrgCourse $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='org-course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
