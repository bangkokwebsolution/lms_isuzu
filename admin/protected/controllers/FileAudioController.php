<?php

class FileAudioController extends Controller
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
            	'actions' => array('index', 'view','Update','Sequence', 'DelSlide'),
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

    public function actionDelSlide($id)
    {
    	ImageSlide::model()->deleteAll("file_id='".$id."'");
    	echo "success";

    }

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['FileAudio']))
		{
			$model->attributes=$_POST['FileAudio'];
			if($model->save(false))
			{
				$pp_file = CUploadedFile::getInstance($model, 'pp_file');
				if(!empty($pp_file)){
					$time = date('YmdHis');
		            $fileNamePpt = $time."_ppt.".$pp_file->getExtensionName();
		            $FileName = $model->id;
		            $dirPpt = Yii::app()->basePath."/../../uploads/ppt_audio/".$FileName."/";

                    $pptFolder = Yii::app()->file->set($dirPpt);
                    $pptFolder->Delete();
                    if(!$pptFolder->CreateDir()){
                        echo "Can not create directory";
                        exit;
                    }

					$pp_file->saveAs($dirPpt.$fileNamePpt);

					$ppName = $dirPpt.$fileNamePpt;

					if($_SERVER['HTTP_HOST'] == 'localhost'){
						$imagemagick = "convert";
					}else{
						$imagemagick = "convert";
					}	
					$ppt_file = $ppName;
					$new_pdf_file  = str_replace(".pptx", ".pdf", $ppName);
    				$new_pdf_file  = str_replace(".ppt", ".pdf", $new_pdf_file);

    				exec($imagemagick.' "'.realpath($new_pdf_file).'" "'.realpath($dirPpt).'/slide.jpg"');
    				var_dump($imagemagick.' "'.realpath($new_pdf_file).'" "'.realpath($dirPpt).'/slide.jpg"');

    				$directory = realpath($dirPpt);
    				$scanned_directory = array_diff(scandir($directory), array('..', '.'));
    				$image_slide_len = count($scanned_directory)-1;

					AudioSlide::model()->deleteAll("file_id='".$model->id."'");

					for ($i=0; $i < $image_slide_len; $i++) { 
						$image_slide = new AudioSlide;
						$image_slide->file_id = $model->id;
						$image_slide->image_slide_name = $i;
						$image_slide->save();
					}

                    $pptFile = Yii::app()->file->set($dirPpt.$fileNamePpt);
                    $pptFile->Delete();

                    $pdfFile = Yii::app()->file->set($new_pdf_file);
                    $pdfFile->Delete();

	            	$this->redirect(array('update','id'=>$model->id));
		        }

                if(isset($_POST['time'])){
                    foreach ($_POST['time'] as $key => $value) {

                        $se = explode(':',$value);
                        $sec = ($se[0]*60)*60+$se[1]*60+$se[2];
                        $AudioSlide = AudioSlide::model()->findByPk($key);
                        $AudioSlide->image_slide_time = $sec;
                        $AudioSlide->save();
                    }
                }

				$this->redirect(array('index','id'=>$model->lesson_id));
			}
			//$this->redirect(array('view','id'=>$model->id));
		}


		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionIndex($id)
	{
		$model=new FileAudio('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['File']))
			$model->attributes=$_GET['File'];

		$this->render('index',array(
			'model'=>$model,
			'id'=>$id,
		));
	}

	public function loadModel($id)
	{
		$model=FileAudio::model()->findByPk($id);
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