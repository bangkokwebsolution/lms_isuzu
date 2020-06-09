<?php

class FilePdfController extends Controller
{
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
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
            	'actions' => array('index', 'view', 'update', 'delete', 'sort'),
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

    public function actionDelete($id)
    {
    	$model = FilePdf::model()->findByPk($id);
    	if($model->count()>0){

    		if(is_file(Yii::app()->getUploadPath('filepdf').$model->filename)){
    			unlink(Yii::app()->getUploadPath('filepdf').$model->filename);
    		}

    		if($model->delete($id)){
    			echo 1;
    		}else{
    			echo 0;
    		}
    	}
    }

    public function actionSort()
    {
    	$sort = $_POST['items'];
    	foreach ($sort as $key => $value) {
    		$no = explode(" ",$value);
    		$model = PdfSlide::model()->findByPk($no[1]);
    		$model->image_slide_time = $key;
    		$model->save(false);
    	}
    }

    public function actionUpdate($id)
    {
    	$model=$this->loadModel($id);
    	if(isset($_POST['time'])){
    		foreach ($_POST['time'] as $key => $value) {

    			$se = explode(':',$value);
    			$sec = ($se[0]*60)*60+$se[1]*60+$se[2];
    			$imageSlide = PdfSlide::model()->findByPk($key);
    			$imageSlide->image_slide_next_time = $sec;
    			$imageSlide->update();
    		}
    	}
    	if(isset($_POST['FilePdf'])){    		
    		$model->attributes = $_POST['FilePdf'];
    		$model->filename = $_POST['FilePdf']['file_name'];
    		$model->save(false);
    	}

    	$this->render('update',array(
    		'id'=>$id,
    		'model'=>$model
    		));
    }

    public function actionIndex($id)
    {
    	$model=new FilePdf('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FilePdf']))
			$model->attributes=$_GET['FilePdf'];

		$this->render('index',array(
			'model'=>$model,
			'id'=>$id,
			));
	}

	public function actionSortVdo($id)
	{
		$control_lesson = ControlVdo::model()->findAll(array(
			'condition' => 'lesson_id=' . $id,
			));
		$chk_control_lesson = array();
		if ($control_lesson) {
			foreach ($control_lesson as $key => $value) {
				$chk_control_lesson[] = $value->file_id;
			}

		}



		$lesson = LessonList::model()->with('files')->findByPk($id);
		$chk_lesson = array();
		if ($lesson) {
			foreach ($lesson->files as $key => $value) {
				$chk_lesson[] = $value->id;
			}
		}

		$result_control_lesson = array_diff($chk_lesson, $chk_control_lesson);


		$this->render('sort-vdo', array(
			'result_control_lesson' => $result_control_lesson,
			'control_lesson' => $control_lesson,
			));
	}

	public function parseJsonArray($jsonArray, $parentID = 0)
	{
		$return = array();
		foreach ($jsonArray as $subArray) {
			$returnSubSubArray = array();
			if (isset($subArray['children'])) {
				$returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
			}
			$return[] = array('id' => $subArray['id'], 'parentID' => $parentID,'fileid' =>$subArray['fileid']);
			$return = array_merge($return, $returnSubSubArray);
		}
		return $return;
	}

	public function actionSavePriority()
	{
		if (isset($_POST['pdf'])) {

			$json = $_POST['pdf'];
			$json2 = $_POST['pdf2'];

			$data = json_decode($json, true);


			foreach ($this->parseJsonArray($data) as $key => $value) {
				$criteria=new CDbCriteria;
				$criteria->addCondition('file_id ='.$value['fileid']);
				$criteria->addCondition('type = "pdf"');
				$criteria->addCondition('lesson_id ='.$_POST['lesson_id']);                
				$orgc = ControlVdo::model()->find($criteria);
				if ($orgc) {
					$value_parent = $value['parentID'];
					$criteria=new CDbCriteria;
					$criteria->addCondition('file_id ='.$value['parentID']);
					$criteria->addCondition('type = "pdf"');
					$criteria->addCondition('lesson_id ='.$_POST['lesson_id']);
					$orgcRe = ControlVdo::model()->find($criteria);
					if(!$orgcRe) {
						$criteria=new CDbCriteria;
						$criteria->addCondition('id ='.$value['parentID']);
						$criteria->addCondition('type = "pdf"');
						$criteria->addCondition('lesson_id ='.$_POST['lesson_id']);
						$orgcRe = ControlVdo::model()->find($criteria);
						$value_parent = $orgcRe->id;
					} else {
						$value_parent = $orgcRe->id;
					}
					if($orgc->parent_id != $value['parentID']){
						if($orgcRe){
							$orgc->parent_id = $value_parent;
						} elseif($value['parentID']=='0') {
							$orgc->parent_id = 0;
						} else {
							$orgc->parent_id = $orgc->id+1;
						}
					}
					$orgc->type = 'pdf';
					$orgc->con_no = $key;
					$orgc->save();

					/*$orgc->parent_id = $value['parentID'];
					$orgc->type = 'pdf';
					$orgc->save();*/
				} else {
					/*$criteria=new CDbCriteria;
					$criteria->addCondition('file_id ='.$value['parentID']);
					$criteria->addCondition('type = "pdf"');
					$criteria->addCondition('lesson_id ='.$_POST['lesson_id']);
					$orgcRe = ControlVdo::model()->find($criteria);
					$orgc = new ControlVdo;
					$orgc->lesson_id = $_POST['lesson_id'];
					$orgc->file_id = $value['id'];
					$orgc->parent_id = empty($orgcRe) ? 0 : $orgcRe->id;
					$orgc->type = 'pdf';
					$orgc->save();*/

					$criteria=new CDbCriteria;
					$criteria->addCondition('file_id ='.$value['parentID']);
					$criteria->addCondition('type = "pdf"');
					$criteria->addCondition('lesson_id ='.$_POST['lesson_id']);
					$orgcRe = ControlVdo::model()->find($criteria);
					if(!$orgcRe) {
						$criteria=new CDbCriteria;
						$criteria->addCondition('id ='.$value['parentID']);
						$criteria->addCondition('type = "pdf"');
						$criteria->addCondition('lesson_id ='.$_POST['lesson_id']);
						$orgcRe = ControlVdo::model()->find($criteria);
					}
					$orgc = new ControlVdo;
					$orgc->lesson_id = $_POST['lesson_id'];
					$orgc->file_id = $value['id'];
					$orgc->parent_id = empty($orgcRe) ? 0 : $orgcRe->id;
//                    $orgc->parent_id = $value['parentID'];
					$orgc->type = 'pdf';
					$orgc->con_no = $key;
					$orgc->save();
				}

			}


			foreach (json_decode($json2, true) as $key => $value) {
				$orgc = ControlVdo::model()->findByPk($value['id']);
				if ($orgc) {
					$orgc->delete();
				}

				if (isset($value['children'])) {
					$this->hasChild($value['children'],$_POST['lesson_id']);
				}
			}

			if(Yii::app()->user->id){
				Helpers::lib()->getControllerActionId($_POST['lesson_id']);
			}


		} else {
			echo "Noooooooo";
		}
	}

	public function hasChild($value,$lesson_id){
		foreach ($value as $key_children => $value_children) {

			$criteria=new CDbCriteria;
			$criteria->addCondition('file_id ='.$value_children['fileid']);
			$criteria->addCondition('type = "pdf"');
			$criteria->addCondition('lesson_id ='.$lesson_id); 
			$orgc2 = ControlVdo::model()->find($criteria);
			if ($orgc2) {
				$orgc2->delete();
			}
			if (isset($value_children['children'])) {
				$this->hasChild($value_children['children'],$lesson_id);
			}
		}
	}

	public function loadModel($id)
	{
		$model=FilePdf::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-form')
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
				$checkSort = File::model()->findByPk($value);
				$SortArray[] = $checkSort->file_position;
			}

			usort($SortArray, function ($a, $b){ return substr($b, -2) - substr($a, -2); });

			$i = 0;
			foreach ($_POST['items'] as $item) 
			{
				File::model()->updateByPk($_POST['items'][$i], array(
					'file_position'=>$SortArray[$i],
					));
				$i++;
			}
		}
	}
}