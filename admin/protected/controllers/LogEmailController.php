<?php

class LogEmailController extends Controller
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
                'actions' => array('index', 'view'),
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
	
    public function actionEmail()
    {
        $model=new LogEmail('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogEmail']))
            $model->attributes=$_GET['LogEmail'];

        $this->render('email',array(
            'model'=>$model,
        ));
    }
}