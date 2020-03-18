<?php

class MailgroupController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        $model = User::model()->findallByAttributes(array('superuser'=>'1'));
        $user = array();
        foreach ($model as $key => $value) {
            $user[$key]=$value->username;
        }
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users'=>$user,
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Mailgroup;
        $mailuser = new Mailuser;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);


        $personlist = User::model()->findAll();


//		$criteria = new CDbCriteria;
//		$criteria->addCondition('online_status=:online_status');
//		$criteria->params = array(':online_status' => 1);
//		$paidpersons = Mailuser::model()->findAll($criteria);
        $paidpersons = array();


        if (isset($_POST['Mailgroup'])) {
            $model->attributes = $_POST['Mailgroup'];

            if($model->validate())
            {

                $model->save();

                foreach ($_POST['selected_mail'] as $key => $value) {
                    $mailuser = new Mailuser;
                    $mailuser->user_id = $value;
                    $mailuser->group_id = $model->id;
                    $mailuser->save();
                }

                $path = Yii::app()->basePath . '/../../uploads/filemail/';
                $file = CUploadedFile::getInstancesByName('file_name');
                if (isset($file) && count($file) > 0) {
                    // go through each uploaded image
                    foreach ($file as $key => $file_mail) {
                        $uglyName = strtolower($file_mail->name);
                        $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
                        $fileName = trim($mediocreName, '_') . "." . $file_mail->extensionName;
                        if ($file_mail->saveAs($path.$fileName)) {
                            // add it to the main model now
                            $file_add = new Mailfile();
                            $file_add->maildetail_id = $model->id;
                            $file_add->file_name = $fileName;
                            $file_add->file_type = $file_mail->extensionName;
                            $file_add->save();
                        }
                    }
                }

            }


            Helpers::lib()->SendMailGroup($model->id,$model->mail_title,$model->mail_detail);


                $this->redirect(array('admin'));

        }

        $this->render('create', array(
            'mailuser' => $mailuser,
            'model' => $model,
            'personlist' => $personlist,
            'paidpersons' => $paidpersons,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $mailuser = new Mailuser;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $personlist = User::model()->findAll();


        $criteria = new CDbCriteria;
        $criteria->addCondition('group_id=:group_id');
        $criteria->params = array(':group_id' => $id);
        $paidpersons = Mailuser::model()->findAll($criteria);
//		$paidpersons = Mailuser::model()->findAll($criteria);
//		$paidpersons = array();



        if (isset($_POST['Mailgroup'])) {



            $model->attributes = $_POST['Mailgroup'];

            if($model->validate())
            {

                $model->save();

                foreach ($_POST['selected_mail'] as $key => $value) {
                    $array_select_user[] = $value;
                    $mailuser = Mailuser::model()->find(array(
                        'condition' => 'user_id=' . $value . ' AND group_id=' . $id,
                    ));
                    if (!$mailuser) {
                        $mailuser = new Mailuser;
                        $mailuser->user_id = $value;
                        $mailuser->group_id = $model->id;
                        $mailuser->save();
                    }
                }

                $criteria = new CDbCriteria;
                $criteria->addCondition('group_id=:group_id');
                $criteria->params = array(':group_id' => $id);
                $paidpersons = Mailuser::model()->findAll($criteria);
                // array user ทั้งหมด
                foreach ($paidpersons as $key => $value) {
                    $array_user[] = $value->user_id;
                }

                // รวม array email ทั้งหมดและที่เลือก
                if (count($array_select_user) > count($array_user)) {
                    $array_s = array_diff($array_select_user, $array_user);
                } else {
                    $array_s = array_diff($array_user, $array_select_user);
                }

//                var_dump($array_s);
//                exit();
                foreach($array_s as $key=>$value){
                    $mailuser = Mailuser::model()->find(array(
                        'condition' => 'user_id=' . $value . ' AND group_id=' . $id,
                    ));
                    $mailuser->delete();
                }

                $path = Yii::app()->basePath . '/../../uploads/filemail/';
                $file = CUploadedFile::getInstancesByName('file_name');
                if (isset($file) && count($file) > 0) {
                    // go through each uploaded image
                    foreach ($file as $key => $file_mail) {
                        $uglyName = strtolower($file_mail->name);
                        $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
                        $fileName = trim($mediocreName, '_') . "." . $file_mail->extensionName;
                        if ($file_mail->saveAs($path.$fileName)) {
                            // add it to the main model now
                            $file_add = new Mailfile();
                            $file_add->maildetail_id = $model->id;
                            $file_add->file_name = $fileName;
                            $file_add->file_type = $file_mail->extensionName;
                            $file_add->save();
                        }
                    }
                }

            }

            Helpers::lib()->SendMailGroup($model->id,$model->mail_title,$model->mail_detail);

            $this->redirect(array('admin'));

        }

        $this->render('update', array(
            'mailuser' => $mailuser,
            'model' => $model,
            'personlist' => $personlist,
            'paidpersons' => $paidpersons,
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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Mailgroup');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Mailgroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Mailgroup']))
            $model->attributes = $_GET['Mailgroup'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Mailgroup the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Mailgroup::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Mailgroup $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'mailgroup-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
