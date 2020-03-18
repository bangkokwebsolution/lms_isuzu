<?php

class DocumentController extends Controller{
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
        $Document = Document::model()->findAll('active = 1 and lang_id = '.$langId);
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

           
//        var_dump($Document);        exit();
        $this->render('index',array(
            'Document'=>$Document,'label'=>$label
        ));
    }
    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='faq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
?>