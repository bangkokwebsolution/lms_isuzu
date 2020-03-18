<?php

class VideoController extends Controller{
    public function init()
 {
  parent::init();
  $this->lastactivity();
  
 }
    public function actionIndex(){
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}
        $criteriavdo = new CDbCriteria;
        $criteriavdo->compare('active','y');
        $criteriavdo->compare('lang_id',$langId);
        $Video = Vdo::model()->findAll($criteriavdo);
//        var_dump($Vdo);        exit();
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
          	}

            $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));

            if(!$label){
                $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
            }
        
        $this->render('index',array(
            'Video'=>$Video,'label'=>$label
        ));
        
    }
    public function actionDetail($id)
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$id = $_GET['id'];
		//vdo
		$video = Vdo::model()->findByAttributes(array(
//			'active'=>'y',
			'vdo_id'=>$id,
		));

		$name = Profile::model()->findByAttributes(array(
					'user_id'=>$video->create_by,
				));
                
               // var_dump($name->firstname);exit();
		
		$this->render('video-detail',array(
			'video_data'=>$video,
			'name'=>$name,
		));
	}
    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usability-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
?>