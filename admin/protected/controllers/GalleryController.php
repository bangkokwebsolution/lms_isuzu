<?php

class GalleryController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public function filters() 
	{
		return array(
//            'rights',
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
           array('allow',  // allow all users to perform 'index' and 'view' actions
           	'actions' => array('index', 'view','update','delete' ,'create'),
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

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Gallery;

		if(isset($_POST['Gallery']))
		{
			$time = date("dmYHis");
			$model->image=$_POST['Gallery'][image];
			$model->gallery_type_id=$_POST['Gallery'][gallery_type_id];

			$image_picture = CUploadedFile::getInstance($model, 'image');
			if(!empty($image_picture)){
				$fileNamePicture = $time."_Picture.".$image_picture->getExtensionName();
				$model->image = $fileNamePicture;
			}

			if($model->validate())
			{
				if($model->save())
				{
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					if(isset($image_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->image);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->image);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->image);
			            // Save the original resource to disk
						$image_picture->saveAs($originalPath);
						$size = getimagesize($originalPath);
			            //if ($size[0] == 750 && $size[1] == 416) {
						if (isset($size)) {
			            // Create a small image
							$smallImage = Yii::app()->phpThumb->create($originalPath);
							$smallImage->resize(110);
							$smallImage->save($smallPath);

			            // Create a thumbnail
							$thumbImage = Yii::app()->phpThumb->create($originalPath);
							$thumbImage->resize(750,416);
							$thumbImage->save($thumbPath);
						} else {
							unlink($originalPath);
							$model->delete();
							$notsave = 1;
							$this->render('create',array(
								'model'=>$model,'notsave'=>$notsave));
						}
					}
				}

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$imageShow = $model->image;
		if(isset($_POST['Gallery']))
		{
			$time = date("dmYHis");
			$model->gallery_type_id=$_POST['Gallery'][gallery_type_id];

			$imageOld = $model->image; // Image Old

			$image_picture = CUploadedFile::getInstance($model, 'image');
			if(isset($image_picture)){
				$fileNamePicture = $time."_Picture.".$image_picture->getExtensionName();
				$model->image = $fileNamePicture;
			}

			if($model->validate())
			{
				if($model->save())
				{
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($model->id);
					}
					if(isset($imageShow) && isset($image_picture))
					{
						Yii::app()->getDeleteImageYush('gallery',$model->id,$imageShow);
					}

					if(isset($image_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->image);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->image);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->image);
			            // Save the original resource to disk
						$image_picture->saveAs($originalPath);
						$size = getimagesize($originalPath);
			            //if ($size[0] == 750 && $size[1] == 416) {
						if (isset($size)) {
			            // Create a small image
							$smallImage = Yii::app()->phpThumb->create($originalPath);
							$smallImage->resize(110);
							$smallImage->save($smallPath);

			            // Create a thumbnail
							$thumbImage = Yii::app()->phpThumb->create($originalPath);
							$thumbImage->resize(750,416);
							$thumbImage->save($thumbPath);
						} else {
							unlink($originalPath);
							$notsave = 1;
							$this->render('create',array(
								'model'=>$model,'notsave'=>$notsave));
						}
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow
		));
	}


	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
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
		$model=new Gallery('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gallery']))
			$model->attributes=$_GET['Gallery'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Gallery::model()->gallerycheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
