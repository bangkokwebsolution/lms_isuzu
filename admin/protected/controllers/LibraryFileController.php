<?php

class LibraryFileController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			// 'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view', 'sequence', 'download', 'accept', 'reject', 'approveall'),
				'users'=>array('*'),
			),
			// array('allow', // allow authenticated user to perform 'create' and 'update' actions
			// 	'actions'=>array('create','update'),
			// 	'users'=>array('@'),
			// ),
			// array('allow', // allow admin user to perform 'admin' and 'delete' actions
			// 	'actions'=>array('admin','delete'),
			// 	'users'=>array('admin'),
			// ),
			array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
            	'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
            	'expression' => 'AccessControl::check_access()',
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
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
		$model=new LibraryFile;
		$model->scenario = 'validateCheckk';

		if(isset($_POST['LibraryFile']))
		{
			$model->attributes=$_POST['LibraryFile'];

			// $model->library_name_en = str_replace(' ', '_', $model->library_name_en);
			$filename_rename = str_replace(' ', '_', $model->library_name_en);

			if($model->validate() && $model->save()){
				$course_picture = CUploadedFile::getInstance($model, 'library_filename');
				if(!empty($course_picture)){
					$time = date("YmdHis");

					$fileNamePicture = $filename_rename.".".$course_picture->getExtensionName();
					$model->library_filename = $fileNamePicture;
					$path = Yii::app()->getUploadPath(null).$model->library_filename;		
					$course_picture->saveAs($path);		
				}
				
				$model->sortOrder = $model->library_id;
				if($model->save()){
					if(isset($_POST['url_pro_pic']) && $_POST['url_pro_pic'] != ""){
						$uploadDir = Yii::app()->getUploadPath(null);
						$path1 = "library";
						$path2 = $model->library_id;
						$path3 = "thumb";
						if (!is_dir($uploadDir."../".$path1."/")) {
							mkdir($uploadDir."../".$path1."/", 0777, true);
						}
						if (!is_dir($uploadDir."../".$path1."/".$path2."/")) {
							mkdir($uploadDir."../".$path1."/".$path2."/", 0777, true);
						}
						if (!is_dir($uploadDir."../".$path1."/".$path2."/".$path3."/")) {
							mkdir($uploadDir."../".$path1."/".$path2."/".$path3."/", 0777, true);
		            }else{ // ลบ file เก่า
		            	$files = glob($uploadDir."../".$path1."/".$path2."/".$path3.'/*');
		                    foreach($files as $file){ // iterate files
		                    	if(is_file($file)){
		                            unlink($file); // delete file
		                        }             
		                    }
		                }

		                $model->library_picture = date("YmdHis")."_.jpg";
		                $uploadDir = $uploadDir."..\\".$path1."\\".$path2."\\".$path3."\\";
		                $targetFile = $uploadDir.$model->library_picture;
		                file_put_contents($targetFile,file_get_contents($_POST['url_pro_pic']));
		                $model->save(false);
		            }
				}
				$this->redirect(array('view','id'=>$model->library_id));
			}
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
		$name_old = $model->library_filename;
		$exten_old = explode(".", $model->library_filename);
		$exten_old = $exten_old[(count($exten_old)-1)];


		if(isset($_POST['LibraryFile']))
		{
			$model->attributes=$_POST['LibraryFile'];
			$model->scenario = 'validateCheckk';

			// $model->library_name_en = str_replace(' ', '_', $model->library_name_en);
			$filename_rename = str_replace(' ', '_', $model->library_name_en);
			
			if(isset($_POST['url_pro_pic']) && $_POST['url_pro_pic'] != ""){
						$uploadDir = Yii::app()->getUploadPath(null);
						$path1 = "library";
						$path2 = $model->library_id;
						$path3 = "thumb";
						if (!is_dir($uploadDir."../".$path1."/")) {
							mkdir($uploadDir."../".$path1."/", 0777, true);
						}
						if (!is_dir($uploadDir."../".$path1."/".$path2."/")) {
							mkdir($uploadDir."../".$path1."/".$path2."/", 0777, true);
						}
						if (!is_dir($uploadDir."../".$path1."/".$path2."/".$path3."/")) {
							mkdir($uploadDir."../".$path1."/".$path2."/".$path3."/", 0777, true);
		            }else{ // ลบ file เก่า
		            	$files = glob($uploadDir."../".$path1."/".$path2."/".$path3.'/*');
		                    foreach($files as $file){ // iterate files
		                    	if(is_file($file)){
		                            unlink($file); // delete file
		                        }             
		                    }
		                }

		                $model->library_picture = date("YmdHis")."_.jpg";
		                $uploadDir = $uploadDir."..\\".$path1."\\".$path2."\\".$path3."\\";
		                $targetFile = $uploadDir.$model->library_picture;
		                file_put_contents($targetFile,file_get_contents($_POST['url_pro_pic']));
		    }
			
			if($model->validate() && $model->save()){
				$course_picture = CUploadedFile::getInstance($model, 'library_filename');
				if(!empty($course_picture)){

					$path = Yii::app()->getUploadPath(null).$name_old;
					$path_new = Yii::app()->getUploadPath(null)."z___update___".date("YmdHis")."___".$name_old;
					if($path != ""){
						rename($path , $path_new);
						unlink($path);
					}

					$time = date("YmdHis");					
					$model->library_filename = $filename_rename.".".$course_picture->getExtensionName();
					$path = Yii::app()->getUploadPath(null).$model->library_filename;
					$course_picture->saveAs($path);
					$model->save();

				}else{
					$path = Yii::app()->getUploadPath(null).$name_old;
					$path_new = Yii::app()->getUploadPath(null).$filename_rename.".".$exten_old;
					if($path != ""){
						rename($path , $path_new);
						unlink($path);
					}
					$model->library_filename = $filename_rename.".".$exten_old;
					$model->save();

				}

				$this->redirect(array('view','id'=>$model->library_id));
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
		// $this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save(false);

		$path = Yii::app()->getUploadPath(null).$model->library_filename;
		$path_new = Yii::app()->getUploadPath(null)."z___del___n___".date("YmdHis")."___".$model->library_filename;
		if($path != ""){
			rename($path , $path_new);
			unlink($path);
		}


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionMultiDelete()
	{	
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			
			}
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new LibraryFile('search');
		$model->unsetAttributes();  // clear any default values
		$model->active = 'y';

		if(isset($_GET['LibraryFile']))
			$model->attributes=$_GET['LibraryFile'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LibraryFile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LibraryFile']))
			$model->attributes=$_GET['LibraryFile'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$cur_items = LibraryFile::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = LibraryFile::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();
				}
			}
		}
	}

	public function actionDownload() {
		$model=new LibraryRequest('search');
		$model->unsetAttributes();  // clear any default values
		$model->active = 'y';

		if(isset($_GET['LibraryRequest'])){
			$model->attributes=$_GET['LibraryRequest'];
		}

		$this->render('download',array(
			'model'=>$model,
		));
	}

	public function actionAccept($id) {
		$model=LibraryRequest::model()->findByPk($id);
		$model->req_status = 2;
		// $model->save();
		if($model->save()){
			echo "success";
		}else{
			echo "error";
		}
		// $this->redirect('../LibraryFile/download');
	}

	public function actionReject($id) {
		$model=LibraryRequest::model()->findByPk($id);
		$model->req_status = 3;
		// $model->save();
		if($model->save()){
			echo "success";
		}else{
			echo "error";
		}
		// $this->redirect('../LibraryFile/download');		
	}

	public function actionapproveall(){
		if (isset($_POST["arr_chkbox"])) {
			foreach ($_POST["arr_chkbox"] as $key => $value) {
				$model=LibraryRequest::model()->findByPk($value);
				$model->req_status = 2;
				if($model->save()){
			// echo "success";
				}else{
					echo "error"; exit();
				}

			}
		}
		// var_dump($_POST["arr_chkbox"]); exit();
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LibraryFile the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LibraryFile::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LibraryFile $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='library-file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
