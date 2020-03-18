<?php

use phpbb\cache\driver\eaccelerator;

class CourseController extends Controller {
    public function init()
    {
      parent::init();

      if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
        Yii::app()->language = 'en';
    }else{
        $langId = Yii::app()->session['lang'];
        Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
    }
    $label = MenuCourse::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
    if(!$label){
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }
    if (Yii::app()->user->id == null) {

        $msg = $label->label_alert_msg_plsLogin;
        Yii::app()->user->setFlash('msg',$msg);
        Yii::app()->user->setFlash('icon','warning');



        $this->redirect(array('site/index'));
        exit();
    }


    $this->lastactivity();
}
    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionsearch() {
        $text = $_POST['text'];
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
        }else{
            $langId = Yii::app()->session['lang'];
        }
        $userModel = Users::model()->findByPK(Yii::app()->user->id);
        $userDepartment = $userModel->department_id;
        $criteria = new CDbCriteria;
        $criteria->with = array('orgchart');
        if($userDepartment == 1){ 
            $criteria->compare('depart_id',$userDepartment);
        }else{
            $criteria->addIncondition('depart_id',[1,$userDepartment]);
        }

        $criteria->compare('orgchart.active','y');
        $criteria->compare('t.active','y');
        $criteria->group = 'orgchart_id';
        $modelOrgDep = OrgDepart::model()->findAll($criteria);

        foreach ($modelOrgDep as $key => $value) {
           $courseArr[] = $value->orgchart_id;
       }
       $criteria = new CDbCriteria;
       $criteria->join = "INNER JOIN tbl_course_online AS course ON (course.course_id = t.course_id) ";
       $criteria->join .= "INNER JOIN tbl_schedule as s ON ( s.id = t.schedule_id ) ";
       $criteria->compare('user_id',Yii::app()->user->id);
       $criteria->compare('course.active','y');
       $criteria->group = 't.course_id';
       $criteria->compare('course.course_title',$text,true);
       $criteria->order = 't.schedule_id DESC';
       $criteria->addCondition('s.training_date_end >= :date_now');
       $criteria->params[':date_now'] = date('Y-m-d');
       $modelCourseTms = AuthCourse::model()->findAll($criteria);

       $criteria = new CDbCriteria;
       $criteria->with = array('course','course.CategoryTitle');
       $criteria->addIncondition('orgchart_id',$courseArr);
       $criteria->compare('course.active','y');
       $criteria->compare('categorys.cate_show','1');
       $criteria->compare('course.course_title',$text,true);
       $criteria->group = 'course.course_id';
       $criteria->addCondition('course.course_date_end >= :date_now');
       $criteria->params[':date_now'] = date('Y-m-d H:i');
       $Model = OrgCourse::model()->findAll($criteria);

       $label = MenuCourse::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
       if(!$label){
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }

    $this->render('search_new', array(
        'modelCourseTms'=>$modelCourseTms,
        'Model' => $Model,
        'text' => $text,
        'label' => $label
    ));
}

public function actionResetLearn($id) {
    if(Yii::app()->user->id){
        Helpers::lib()->getControllerActionId();
    }
    $lesson = CourseOnline::model()->findAllByAttributes(array('course_id' => $id));

        //var_dump($lesson);
    if ($lesson) {
        foreach ($lesson as $key => $value) {
            $scoreLesson = Score::model()->deleteAll('user_id="' . Yii::app()->user->id . '" AND lesson_id="' . $value->id . '"');
            $scoreCourse = Coursescore::model()->deleteAll('user_id="' . Yii::app()->user->id . '" AND course_id="' . $id . '"');
            $learn = Learn::model()->findAllByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'lesson_id' => $value->id,
            ));
            foreach ($learn as $key => $data) {
                $learnFile = LearnFile::model()->deleteAll('user_id_file="' . Yii::app()->user->id . '" AND learn_id="' . $data->learn_id . '"');
            }
            $learn = Learn::model()->deleteAll('user_id="' . Yii::app()->user->id . '" AND lesson_id="' . $value->id . '"');
            $questAns = QQuestAns_course::model()->deleteAll("user_id='" . Yii::app()->user->id . "' AND course_id='" . $id . "'");
            $questAns = QQuestAns::model()->deleteAll("user_id='" . Yii::app()->user->id . "' AND lesson_id='" . $value->id . "'");
                //reset course start
            $courseStart = CourseStart::model()->find(array(
                'condition' => 'course_id = "' . $id . '" AND user_id ="' . Yii::app()->user->id . '"',
            ));
            if ($courseStart) {
                if ($courseStart->status == 1) {
                    $courseStart->status = 0;
                    $courseStart->save(false);
                }
            }
        }
        $logReset = LogResetLearn::model()->findByAttributes(array(
            'course_id' => $id,
            'user_id' => Yii::app()->user->id
        ));
        if ($logReset) {
            $logReset->update_date = date('Y-m-d H:i:s');
            $logReset->update_by = Yii::app()->user->id;
            $logReset->save(false);
        } else {
            $logReset = new LogResetLearn;
            $logReset->course_id = $id;
            $logReset->user_id = Yii::app()->user->id;
            $logReset->create_date = date('Y-m-d H:i:s');
            $logReset->create_by = Yii::app()->user->id;
            $logReset->update_date = date('Y-m-d H:i:s');
            $logReset->update_by = Yii::app()->user->id;
            $logReset->save();
        }
        $this->redirect(array('/course/detail/', 'id' => $id));
    }
}

    /*
    public function actionResetLearn($id) {
        $lesson = Lesson::model()->findAllByAttributes(array('course_id' => $id));

        //var_dump($lesson);
        if ($lesson) {
            foreach ($lesson as $key => $value) {
                $scoreLesson = Score::model()->deleteAll('user_id="' . Yii::app()->user->id . '" AND lesson_id="' . $value->id . '"');
                $scoreCourse = Coursescore::model()->deleteAll('user_id="' . Yii::app()->user->id . '" AND course_id="' . $id . '"');
                $learn = Learn::model()->findAllByAttributes(array(
                    'user_id' => Yii::app()->user->id,
                    'lesson_id' => $value->id,
                    ));
                foreach ($learn as $key => $data) {
                    $learnFile = LearnFile::model()->deleteAll('user_id_file="' . Yii::app()->user->id . '" AND learn_id="' . $data->learn_id . '"');
                }
                $learn = Learn::model()->deleteAll('user_id="' . Yii::app()->user->id . '" AND lesson_id="' . $value->id . '"');
                $questAns = QQuestAns_course::model()->deleteAll("user_id='" . Yii::app()->user->id . "' AND course_id='" . $id . "'");
                $questAns = QQuestAns::model()->deleteAll("user_id='" . Yii::app()->user->id . "' AND lesson_id='" . $value->id . "'");
                //reset course start
                $courseStart = CourseStart::model()->find(array(
                    'condition' => 'course_id = "' . $id . '" AND user_id ="' . Yii::app()->user->id . '"',
                    ));
                if ($courseStart) {
                    if ($courseStart->status == 1) {
                        $courseStart->status = 0;
                        $courseStart->save(false);
                    }
                }
            }
            $logReset = LogResetLearn::model()->findByAttributes(array(
                'course_id' => $id,
                'user_id' => Yii::app()->user->id
                ));
            if ($logReset) {
                $logReset->update_date = date('Y-m-d H:i:s');
                $logReset->update_by = Yii::app()->user->id;
                $logReset->save(false);
            } else {
                $logReset = new LogResetLearn;
                $logReset->course_id = $id;
                $logReset->user_id = Yii::app()->user->id;
                $logReset->create_date = date('Y-m-d H:i:s');
                $logReset->create_by = Yii::app()->user->id;
                $logReset->update_date = date('Y-m-d H:i:s');
                $logReset->update_by = Yii::app()->user->id;
                $logReset->save();
            }
            $this->redirect(array('/course/detail/', 'id' => $id));
        }
    }

    */

    public function actionDownload($id) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $fileDoc = FileDoc::model()->findByPK($id);
        if ($fileDoc) {
            // $webroot = Yii::app()->getUploadPath('filedoc');
            $webroot = Yii::app()->basePath.'/../uploads/filedoc/';
            // var_dump($webroot);exit();
            $uploadDir = $webroot;
            $filename = $fileDoc->filename;
            $filename = $uploadDir . $filename;
            // var_dump($filename);
            // exit;
            if (file_exists($filename)) {
                return Yii::app()->request->sendFile($fileDoc->file_name, file_get_contents($filename));
            } else {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($id = null) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
        }else{
            $langId = Yii::app()->session['lang'];
        }
        $userModel = Users::model()->findByPK(Yii::app()->user->id);
        $userDepartment = $userModel->department_id;
        // $courseArr = json_decode($userModel->orgchart_lv2);
        $criteria = new CDbCriteria;
        $criteria->with = array('orgchart');
        if($userDepartment == 1){ 
            $criteria->compare('depart_id',$userDepartment);
        }else{
            $criteria->addIncondition('depart_id',[1,$userDepartment]);
        }

        $criteria->compare('orgchart.active','y');
        $criteria->compare('t.active','y');
        $criteria->group = 'orgchart_id';
        $modelOrgDep = OrgDepart::model()->findAll($criteria);

        foreach ($modelOrgDep as $key => $value) {
           $courseArr[] = $value->orgchart_id;
       }
       $criteria = new CDbCriteria;
     // $criteria->with = array('authCourse');
       $criteria->join = "INNER JOIN tbl_course_online AS course ON (course.course_id = t.course_id) ";
       $criteria->join .= "INNER JOIN tbl_schedule as s ON ( s.id = t.schedule_id ) ";
       $criteria->compare('user_id',Yii::app()->user->id);
       $criteria->compare('course.active','y');
       $criteria->compare('course.status','1');
       $criteria->addCondition('s.training_date_end >= :date_now');
       $criteria->params[':date_now'] = date('Y-m-d');
       $criteria->group = 't.course_id';
       $criteria->order = 't.schedule_id DESC';
       $modelCourseTms = AuthCourse::model()->findAll($criteria);
     // var_dump($modelCourseTms);exit();
       if($modelCourseTms){
        // $model_cate_tms = ($langId == 1) ? Category::model()->findByPk(1) : Category::model()->findByAttributes(array('parent_id' => '1'));
        // $model_cate_tms = Category::model()->findByPk(24); //localhost
        $model_cate_tms = Category::model()->findByPk(1);
        
    }

    // foreach ($modelCourseTms as $key => $value) {
    //        $courseArr[] = $value->course_id;
    //    }
    // $modelCourseTms = null;
    $criteria = new CDbCriteria;
    $criteria->with = array('course','course.CategoryTitle');
    if(!empty($model_cate_tms))$criteria->condition = "categorys.cate_id != 1";
    $criteria->addIncondition('orgchart_id',$courseArr);
    $criteria->compare('categorys.active','y');
    $criteria->compare('course.status','1');
    $criteria->compare('categorys.cate_show','1');
    $criteria->compare('categorys.lang_id',$langId);
    $criteria->addCondition('course.course_date_end >= :date_now');
    $criteria->params[':date_now'] = date('Y-m-d H:i');
    // $criteria->compare('categorys.lang_id',$langId);
    $criteria->group = 'course.cate_id';
    $model_cate = OrgCourse::model()->findAll($criteria);

    $criteria = new CDbCriteria;
    $criteria->with = array('course','course.CategoryTitle');
    $criteria->addIncondition('orgchart_id',$courseArr);
    $criteria->compare('course.active','y');
    $criteria->compare('course.status','1');
    $criteria->compare('categorys.cate_show','1');
    $criteria->addCondition('course.course_date_end >= :date_now');
    $criteria->params[':date_now'] = date('Y-m-d H:i');
    $criteria->group = 'course.course_id';

    // $criteria->compare('course.lang_id',$langId);
    $Model = OrgCourse::model()->findAll($criteria);
    // var_dump($Model);exit();
    $label = MenuCourse::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
    if(!$label){
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }

    $this->render('index', array(
        'model_cate'=>$model_cate,
        'model_cate_tms'=>$model_cate_tms,
        'modelCourseTms'=>$modelCourseTms,
        'Model' => $Model,
        'label' => $label
    ));
}

public function actionCateIndex($id) {
    if(Yii::app()->user->id){
        Helpers::lib()->getControllerActionId();
    }
    $cate_coure = CategoryCourse::model()->findAll(array(
        "condition" => " active = '1' AND cate_id = '" . $id . "'", 'order' => 'id'));
    $this->render('cate-index', array(
        'cate_coure' => $cate_coure
    ));
}

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionLesson($id) {

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $course = CourseOnline::model()->findByPk($id);
        $courseTec = CourseTeacher::model()->findAllByAttributes(array('course_id' => $id));
        $lessonList = Lesson::model()->findAll('course_id=' . $id);
        $model_cate = Category::model()->findAllByAttributes(array('active' => 'y'));

        // $course_id = $course->course_id;
        // $CheckBuy = Helpers::lib()->CheckBuyItem($course_id);
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        // var_dump($isPreTest);
        // exit();

        $learn_id = "";

        if (count($lessonCurrent) > 0) {
            $user = Yii::app()->getModule('user')->user();
            $learnModel = Learn::model()->find(array(
                'condition' => 'lesson_id=:lesson_id AND user_id=:user_id',
                'params' => array(':lesson_id' => $lessonCurrent->id, ':user_id' => $user->id)
            ));
            if (!$learnModel) {
                $learnLog = new Learn;
                $learnLog->user_id = $user->id;
                $learnLog->lesson_id = $lessonCurrent->id;
                $learnLog->learn_date = new CDbExpression('NOW()');
                $learnLog->save();
                $learn_id = $learnLog->learn_id;
            } else {
                $learnModel->learn_date = new CDbExpression('NOW()');
                $learnModel->save();
                $learn_id = $learnModel->learn_id;
            }
        }



        $this->render('lesson', array(
            'lessonCurrent' => $lessonCurrent,
            'lessonList' => $lessonList,
            'course' => $course,
            'learn_id' => $learn_id,
            'courseTec' => $courseTec,
            'model_cate' => $model_cate,
        ));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionLearning($id) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $course = CourseOnline::model()->findByPk($id);
        $lessonList = Lesson::model()->findAll('course_id=' . $id);
        $lessonCurrent = Lesson::model()->findByPk($_GET['lesson_id']);

        $isPreTest = Helpers::isPretestState($lessonCurrent->id);

        $learn_id = "";
        if ($isPreTest) {

            $this->redirect(array('//question/index', 'id' => $lessonCurrent->id));
        } else {

            if (count($lessonCurrent) > 0) {
                $user = Yii::app()->getModule('user')->user();
                $learnModel = Learn::model()->find(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id',
                    'params' => array(':lesson_id' => $lessonCurrent->id, ':user_id' => $user->id)
                ));

                if (empty($learnModel)) {
                    $learnLog = new Learn;
                    $learnLog->user_id = $user->id;
                    $learnLog->lesson_id = $lessonCurrent->id;
                    $learnLog->learn_date = new CDbExpression('NOW()');
                    $learnLog->course_id = $id;
                    $learnLog->save();
                    $learn_id = $learnLog->learn_id;
                } else {
                    $learnModel->learn_date = new CDbExpression('NOW()');
                    $learnModel->save();
                    $learn_id = $learnModel->learn_id;
                }
            }

            $this->render('learning', array(
                'lessonCurrent' => $lessonCurrent,
                'lessonList' => $lessonList,
                'course' => $course,
                'learn_id' => $learn_id
            ));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLearnScorm($id=null, $learn_id=null) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $id = isset($_POST['id']) ? $_POST['id'] : $_GET['id']; 
        $learn_id = isset($_POST['learn_id']) ? $_POST['learn_id'] : $_GET['learn_id']; 
        $status = isset($_POST['status']) ? $_POST['status'] : $_GET['status'];

        $model = FileScorm::model()->findByPk($id);

        if (count($model) > 0) {
            //$user = Yii::app()->getModule('user')->user();
            $learnVdoModel = LearnFile::model()->find(array(
                'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                'params' => array(':file_id' => $id, ':learn_id' => $learn_id)
            ));


            if (empty($learnVdoModel)) {
                $learnLog = new LearnFile;
                $learnLog->learn_id = $learn_id;
                $learnLog->user_id_file = Yii::app()->user->id;
                $learnLog->file_id = $id;
                $learnLog->learn_file_date = new CDbExpression('NOW()');
                $learnLog->learn_file_status = "l";
                $learnLog->save();

                $att['no'] = $id;
                $att['image'] = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
                $att['imageBar'] = 'warning';

                Learn::model()->updateByPk($learn_id, array(
                    'lesson_status' => 'learning'
                ));

                    echo json_encode($att);
            } else {
                $learnVdoModel->learn_file_date = new CDbExpression('NOW()');
                if ($status == 'success' || $learnVdoModel->learn_file_status == 's') {
                        $learnVdoModel->learn_file_status = 's';
                        $att['no'] = $id;
                        $att['image'] = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true">';
                        $att['imageBar'] = 'success';
                        echo json_encode($att);
                }
                $learnVdoModel->save();

                // start update lesson status pass
                    $lesson = Lesson::model()->findByPk($model->lesson_id);
                    if ($lesson) {

                        Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id, $lesson->course_id);

                        $user = Yii::app()->getModule('user')->user();
                        $lessonStatus = Helpers::lib()->checkLessonPass($lesson);
                        $learnLesson = $user->learns(
                            array(
                                'condition' => 'lesson_id=:lesson_id AND lesson_active="y"',
                                'params' => array(':lesson_id' => $lesson->id)
                            )
                        );

                        $learn = Learn::model()->findByPk($learnLesson[0]->learn_id);
                        $learn->lesson_status = $lessonStatus;
                        $learn->save();

                    //$cateStatus = Helpers::lib()->checkCategoryPass($lesson->CourseOnlines->cate_id);
                        $courseStats = Helpers::lib()->checkCoursePass($lesson->course_id);
                        $postTestHave = Helpers::lib()->checkHavePostTestInManage($lesson->id);
                        $courseManageHave = Helpers::lib()->checkHaveCourseTestInManage($lesson->course_id);
                        if ($courseStats == "pass" && !$postTestHave && !$courseManageHave) {
                            $passCoursModel = Passcours::model()->findByAttributes(array(
                                'passcours_cates' => $lesson->CourseOnlines->cate_id,
                                'passcours_user' => Yii::app()->user->id
                            ));
                            if (!$passCoursModel) {
                                $modelPasscours = new Passcours;
                                $modelPasscours->passcours_cates = $lesson->CourseOnlines->cate_id;
                                $modelPasscours->passcours_cours = $lesson->course_id;
                                $modelPasscours->passcours_user = Yii::app()->user->id;
                                $modelPasscours->passcours_date = new CDbExpression('NOW()');
                                $modelPasscours->save();
                            }
                        }
                        if($courseStats == "pass"){
                            $this->SendMailLearn($lesson->course_id);
                        }
                    }
                // end update lesson status pass
                }
            }
        }

    public function actionLearnVdo($id=null, $learn_id=null) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
        $id = isset($_POST['id']) ? $_POST['id'] : $_GET['id']; 
        $learn_id = isset($_POST['learn_id']) ? $_POST['learn_id'] : $_GET['learn_id']; 
        $slide_number = isset($_POST['slide_number']) ? $_POST['slide_number'] : $_GET['slide_number'];
        $status = isset($_POST['status']) ? $_POST['status'] : $_GET['status'];
        $counter = isset($_POST['counter']) ? $_POST['counter'] : $_GET['counter'];
        $currentTime = isset($_POST['current_time']) ? $_POST['current_time'] : $_GET['current_time'];
        if($type == 'scorm'){
            $model = fileScorm::model()->findByPk($id);
        } else {
            $model = File::model()->findByPk($id);
        }

        if (count($model) > 0) {
            //$user = Yii::app()->getModule('user')->user();
            $learnVdoModel = LearnFile::model()->find(array(
                'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                'params' => array(':file_id' => $id, ':learn_id' => $learn_id)
            ));

            if ($counter == "counter") {
                $post = File::model()->findByPk($id);
                $post->saveCounters(array('views' => 1));
            }

            if (empty($learnVdoModel)) {
                $learnLog = new LearnFile;
                $learnLog->learn_id = $learn_id;
                $learnLog->user_id_file = Yii::app()->user->id;
                $learnLog->file_id = $id;
                $learnLog->learn_file_date = new CDbExpression('NOW()');
                $learnLog->learn_file_status = "l";
                $learnLog->save();

                $att['no'] = $id;
                $att['image'] = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
                $att['imageBar'] = 'warning';

                    /*$learn = Learn::model()->findAllByAttributes(array(
                        'user_id' => Yii::app()->user->id,
                        'lesson_id' => $model->lesson_id,
                        'course_id' => $model->lesson->course_id
                    ));
                    $learn->lesson_status = 'learning';
                    $learn->save();*/

                    Learn::model()->updateByPk($learn_id, array(
                        'lesson_status' => 'learning'
                    ));

                    echo json_encode($att);
                } else {
                    $learnVdoModel->learn_file_date = new CDbExpression('NOW()');

                    if ($status == 'success' || $learnVdoModel->learn_file_status == 's') {
                        $learnVdoModel->learn_file_status = 's';

                        $att['no'] = $id;
                        $att['image'] = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true">';
                        $att['imageBar'] = 'success';
                        echo json_encode($att);
                    } else if ($slide_number != '') {
                        $learnVdoModel->learn_file_status = $slide_number;
                    } else if ($currentTime != '') {
                        $learnVdoModel->learn_file_status = $currentTime;
                    } else {
                        $att['no'] = $id;
                        $att['image'] = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
                        $att['imageBar'] = 'warning';
                        echo json_encode($att);
                    }

                    $learnVdoModel->save();

                // start update lesson status pass
                    $lesson = Lesson::model()->findByPk($model->lesson_id);
                    if ($lesson) {

                        Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id, $lesson->course_id);

                        $user = Yii::app()->getModule('user')->user();
                        $lessonStatus = Helpers::lib()->checkLessonPass($lesson);
                        $learnLesson = $user->learns(
                            array(
                                'condition' => 'lesson_id=:lesson_id AND lesson_active="y"',
                                'params' => array(':lesson_id' => $lesson->id)
                            )
                        );

                        $learn = Learn::model()->findByPk($learnLesson[0]->learn_id);
                        $learn->lesson_status = $lessonStatus;
                        $learn->save();

                    //$cateStatus = Helpers::lib()->checkCategoryPass($lesson->CourseOnlines->cate_id);
                        $courseStats = Helpers::lib()->checkCoursePass($lesson->course_id);
                        $postTestHave = Helpers::lib()->checkHavePostTestInManage($lesson->id);
                        $courseManageHave = Helpers::lib()->checkHaveCourseTestInManage($lesson->course_id);
                        if ($courseStats == "pass" && !$postTestHave && !$courseManageHave) {
                            $passCoursModel = Passcours::model()->findByAttributes(array(
                                'passcours_cates' => $lesson->CourseOnlines->cate_id,
                                'passcours_user' => Yii::app()->user->id
                            ));
                            if (!$passCoursModel) {
                                $modelPasscours = new Passcours;
                                $modelPasscours->passcours_cates = $lesson->CourseOnlines->cate_id;
                                $modelPasscours->passcours_cours = $lesson->course_id;
                                $modelPasscours->passcours_user = Yii::app()->user->id;
                                $modelPasscours->passcours_date = new CDbExpression('NOW()');
                                $modelPasscours->save();
                            }
                        }
                        if($courseStats == "pass"){
                            $this->SendMailLearn($lesson->course_id);
                        }
                    }


                // end update lesson status pass
                }
            }
        }

        public function actionLearnAudio($id=null, $learn_id=null) {
            if(Yii::app()->user->id){
                Helpers::lib()->getControllerActionId();
            }
            $type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
            $id = isset($_POST['id']) ? $_POST['id'] : $_GET['id']; 
            $learn_id = isset($_POST['learn_id']) ? $_POST['learn_id'] : $_GET['learn_id']; 
            $slide_number = isset($_POST['slide_number']) ? $_POST['slide_number'] : $_GET['slide_number'];
            $status = isset($_POST['status']) ? $_POST['status'] : $_GET['status'];
            $counter = isset($_POST['counter']) ? $_POST['counter'] : $_GET['counter'];
            $currentTime = isset($_POST['current_time']) ? $_POST['current_time'] : $_GET['current_time'];
            $model = FileAudio::model()->findByPk($id);
            if (count($model) > 0) {
            //$user = Yii::app()->getModule('user')->user();
                $learnVdoModel = LearnFile::model()->find(array(
                    'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                    'params' => array(':file_id' => $id, ':learn_id' => $learn_id)
                ));

                if ($counter == "counter") {
                    $post = File::model()->findByPk($id);
                    $post->saveCounters(array('views' => 1));
                }

                if (empty($learnVdoModel)) {
                    $learnLog = new LearnFile;
                    $learnLog->learn_id = $learn_id;
                    $learnLog->user_id_file = Yii::app()->user->id;
                    $learnLog->file_id = $id;
                    $learnLog->learn_file_date = new CDbExpression('NOW()');
                    $learnLog->learn_file_status = "l";
                    $learnLog->save();

                    $att['no'] = $id;
                    $att['image'] = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
                    $att['imageBar'] = 'warning';

                    /*$learn = Learn::model()->findAllByAttributes(array(
                        'user_id' => Yii::app()->user->id,
                        'lesson_id' => $model->lesson_id,
                        'course_id' => $model->lesson->course_id
                    ));
                    $learn->lesson_status = 'learning';
                    $learn->save();*/

                    Learn::model()->updateByPk($learn_id, array(
                        'lesson_status' => 'learning'
                    ));

                    echo json_encode($att);
                } else {
                    $learnVdoModel->learn_file_date = new CDbExpression('NOW()');

                    if ($status == 'success' || $learnVdoModel->learn_file_status == 's') {
                        $learnVdoModel->learn_file_status = 's';

                        $att['no'] = $id;
                        $att['image'] = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true">';
                        $att['imageBar'] = 'success';
                        echo json_encode($att);
                    } else if ($slide_number != '') {
                        $learnVdoModel->learn_file_status = $slide_number;
                    } else if ($currentTime != '') {
                        $learnVdoModel->learn_file_status = $currentTime;
                    } else {
                        $att['no'] = $id;
                        $att['image'] = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
                        $att['imageBar'] = 'warning';
                        echo json_encode($att);
                    }

                    $learnVdoModel->save();

                // start update lesson status pass
                    $lesson = Lesson::model()->findByPk($model->lesson_id);
                    if ($lesson) {

                        Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id, $lesson->course_id);

                        $user = Yii::app()->getModule('user')->user();
                        $lessonStatus = Helpers::lib()->checkLessonPass($lesson);
                        $learnLesson = $user->learns(
                            array(
                                'condition' => 'lesson_id=:lesson_id AND lesson_active="y"',
                                'params' => array(':lesson_id' => $lesson->id)
                            )
                        );

                        $learn = Learn::model()->findByPk($learnLesson[0]->learn_id);
                        $learn->lesson_status = $lessonStatus;
                        $learn->save();

                    //$cateStatus = Helpers::lib()->checkCategoryPass($lesson->CourseOnlines->cate_id);
                        $courseStats = Helpers::lib()->checkCoursePass($lesson->course_id);
                        $postTestHave = Helpers::lib()->checkHavePostTestInManage($lesson->id);
                        $courseManageHave = Helpers::lib()->checkHaveCourseTestInManage($lesson->course_id);
                        if ($courseStats == "pass" && !$postTestHave && !$courseManageHave) {
                            $passCoursModel = Passcours::model()->findByAttributes(array(
                                'passcours_cates' => $lesson->CourseOnlines->cate_id,
                                'passcours_user' => Yii::app()->user->id
                            ));
                            if (!$passCoursModel) {
                                $modelPasscours = new Passcours;
                                $modelPasscours->passcours_cates = $lesson->CourseOnlines->cate_id;
                                $modelPasscours->passcours_cours = $lesson->course_id;
                                $modelPasscours->passcours_user = Yii::app()->user->id;
                                $modelPasscours->passcours_date = new CDbExpression('NOW()');
                                $modelPasscours->save();
                            }
                        }
                        if($courseStats == "pass"){
                            $this->SendMailLearn($lesson->course_id);
                        }
                    }


                // end update lesson status pass
                }
            }
        }

        public function actionLearnPdf($id=null,$learn_id=null,$slide=null){

            if(Yii::app()->user->id){
                Helpers::lib()->getControllerActionId();
            }
            $id = $id != null ? $id : $_POST['id'];
            $learn_id = $learn_id != null ? $learn_id : $_POST['learn_id'];
            $slide = $slide != null ? $slide : $_POST['slide'];
            $model = FilePdf::model()->findByPk($id);
            $countFile = PdfSlide::model()->count(array('condition' => 'file_id="'.$id.'"'));
            $modelLearnFilePdf = LearnFile::model()->find(array(
                'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                'params' => array(':file_id' => $id, ':learn_id' => $learn_id)
            ));
            $filePdfSlide = PdfSlide::model()->find(array(
                'condition' => 'file_id=:file_id AND image_slide_time=:image_slide_time',
                'params' => array(':file_id' => $id, ':image_slide_time' => $slide)
            ));
            if($modelLearnFilePdf->learn_file_status != 's' && $modelLearnFilePdf->learn_file_status <= $slide){
                $att['timeNext'] = $filePdfSlide->image_slide_next_time;
            }
            if(empty($modelLearnFilePdf)){
               $learnLog = new LearnFile;
               $learnLog->learn_id = $learn_id;
               $learnLog->user_id_file = Yii::app()->user->id;
               $learnLog->file_id = $id;
               $learnLog->learn_file_date = new CDbExpression('NOW()');
               $learnLog->learn_file_status = "1";
               $learnLog->save();

               $att['no']      = $id;
               $att['image']   = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
               $learn = Learn::model()->findByPk($learn_id);
               $learn->lesson_status = 'learning';
               $learn->save();
           } else {
               if(($countFile-1) == $slide || $modelLearnFilePdf->learn_file_status == 's')
               {
                $modelLearnFilePdf->learn_file_status = 's';
            //$modelLearnFilePdf->learn_file_date_end = new CDbExpression('NOW()');
                $att['no']      = $id;
                $att['status']  = true;
                $att['image']   = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true">';
                $att['learn_file_status'] = $modelLearnFilePdf->learn_file_status;
            }else if($slide != ''){
                //Jae edit 03/12/2561
                if($modelLearnFilePdf->learn_file_status<=$slide){
                    //file_id = $id
                    $index =  $slide - 1;
                    $att['no']      = $id;
                    // $att['timeNext'] = $filePdfSlide->image_slide_next_time;
                    if($index%5 == 0 && $slide != 0 && $modelLearnFilePdf->learn_file_status != $slide){
                        $att['indicators'] = '<li data-target="#myCarousel'.$id.'" data-slide-to="'.$index.'" >'.$index.'</li>';
                    }
                    $modelLearnFilePdf->learn_file_status = $slide;
                    
                }else{
                    $att['no']      = $id;
                    $att['image']   = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
                }
            }else{
                $att['no']      = $id;
                $att['image']   = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true">';
            }

            $modelLearnFilePdf->save();
            $lesson = Lesson::model()->findByPk($model->lesson_id);
            if($lesson){
                Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id, $lesson->course_id);
                $user = Yii::app()->getModule('user')->user();
                $lessonStatus = Helpers::lib()->checkLessonPass($lesson);

                $learn = Learn::model()->findByPk($learn_id);
                $learn->lesson_status = $lessonStatus;
                // if($lessonStatus=='pass'){
                //     $learn->learn_date_end = new CDbExpression('NOW()');
                // }
                $learn->save();

                $courseStats = Helpers::lib()->checkCoursePass($lesson->course_id);
                $postTestHave = Helpers::lib()->checkHavePostTestInManage($lesson->id);
                $courseManageHave = Helpers::lib()->checkHaveCourseTestInManage($lesson->course_id);
                if ($courseStats == "pass" && !$postTestHave && !$courseManageHave) {
                    $passCoursModel = Passcours::model()->findByAttributes(array(
                        'passcours_cates' => $lesson->CourseOnlines->cate_id,
                        'passcours_user' => Yii::app()->user->id
                    ));
                    if (!$passCoursModel) {
                        $modelPasscours = new Passcours;
                        $modelPasscours->passcours_cates = $lesson->CourseOnlines->cate_id;
                        $modelPasscours->passcours_cours = $lesson->course_id;
                        $modelPasscours->passcours_user = Yii::app()->user->id;
                        $modelPasscours->passcours_date = new CDbExpression('NOW()');
                        $modelPasscours->save();
                    }
                }
                if($courseStats == "pass"){
                    $this->SendMailLearn($lesson->course_id);
                }
            }
        }


        echo json_encode($att);
    }

    public function SendMailLearn($id){

        $user_id = Yii::app()->user->id;
        $modelUser = User::model()->findByPk($user_id);
        $modelCourseName = CourseOnline::model()->findByPk($id);
        $criteria = new CDbCriteria;
        $criteria->join = " INNER JOIN `tbl_lesson` AS les ON (les.`id`=t.`lesson_id`)";
        $criteria->compare('t.course_id',$id);
        $criteria->compare('user_id',$user_id);
        $criteria->compare('lesson_active','y');
        $criteria->compare('les.active','y');
        $learn = Learn::model()->findAll($criteria);
        $message = $this->renderPartial('_emailLearn',array(
            'modelUser'=>$modelUser,
            'modelCourseName'=>$modelCourseName,
            'learn'=>$learn,
        ),true);
        $to = array();
        $filepath = array();
        //$email_ref = $modelMember->m_ref_email1;
       $to['email'] = $modelUser->email;//'chalermpol.vi@gmail.com';
       $to['firstname'] = $modelUser->profile->firstname;
       $to['lastname'] = $modelUser->profile->lastname;
       $subject = 'ผลการเรียน หลักสูตร  : ' . $modelCourseName->course_title;

       if($message){
        // if(Helpers::lib()->SendMail($to, $subject, $message)){
        if(Helpers::lib()->SendMailLearnPass($to, $subject, $message)){
            $model = new LogEmail;
            $model->user_id = $user_id;
            $model->course_id = $id;
            $model->message = $message;
            if(!$model->save())var_dump($model->getErrors()); 
        }
    }
}
    // 31 March 17 by shinobu22
    //
public function actionDetail($id) {
    $course_type = (isset($_GET['courseType']))? $_GET['courseType']:'lms';
    if(Yii::app()->user->id){
        Helpers::lib()->getControllerActionId();
    }
    $criteria = new CDbCriteria;
    $criteria->compare('course_id',$id);
    $criteria->compare('user_id',Yii::app()->user->id);
    $modelCourseTms = AuthCourse::model()->find($criteria);
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        // $this->layout = '//layouts/main';
    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
        Yii::app()->language = 'en';
    }else{
        $langId = Yii::app()->session['lang'];
        Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
    }

    $label = MenuCourse::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
    if(!$label){
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }
    // $ckPermission =  Helpers::lib()->CoursePermission(Yii::app()->user->id,$id);

    // if(!$ckPermission){
    //     $msg = $label->label_noPermis;
    //     Yii::app()->user->setFlash('msg',$msg);
    //     Yii::app()->user->setFlash('icon','warning');

    //     $this->redirect(array('site/index'));
    //     exit();
    // }

    $cate_id = CourseOnline::getCateID($id);

    $category = Category::model()->findByPk($cate_id);
    $course = CourseOnline::model()->findByPk($id);

    $model_cate = Category::model()->findAllByAttributes(array('active' => 'y'));
    $courseTec = CourseTeacher::model()->findAllByAttributes(array('course_id' => $id));
//        var_dump($courseTec[0]->teacher_id);        exit();
    $teacher = Teacher::model()->findAllByAttributes(array('teacher_id' => $courseTec[0]->teacher_id));

//        var_dump($teacher[0]->teacher_name) ;        exit();
    $lessonList = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $id, 'order' => 'lesson_no'));

    // if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    //         $langId = Yii::app()->session['lang'] = 1;
    //     }else{
    //         $langId = Yii::app()->session['lang'];
    //     }

    $user = Yii::app()->getModule('user')->user();
//        var_dump($lessonList); exit();
/*            foreach ($lessonList as $key => $lesson) {
                $lessonStatus = Helpers::lib()->checkLessonPass($lesson);
//var_dump($lessonStatus);            exit();
//            $learnLesson = $user->learns(
//                array(
//                    'condition' => 'lesson_id=:lesson_id',
//                    'params' => array(':lesson_id' => $lesson->id)
//                )
//            );
//var_dump($learnLesson);            exit();


                $learn = Learn::model()->findByPk($learnLesson[0]->learn_id);
//var_dump($learn);            exit();
                if ($learn) {
                    $learn->lesson_status = $lessonStatus;
                    $learn->save();
                }
            }*/



            $course_notifications = CourseNotification::model()->findAll(array('condition' => 'course_id=' . $id, 'order' => 'end_date DESC'));
//var_dump($course_notifications);        exit();
            $user = User::model()->findByPk(Yii::app()->user->id);
            $profile = $user->profile;
            foreach ($course_notifications as $key => $course_notification) {
                if ($course_notification->generation_id == $profile->generation) {
                    $checkNotification = Helpers::lib()->checkNotificationCourse($course_notification);
                    if ($checkNotification != false) {
                        Yii::app()->user->setFlash('nofitication', 'แจ้งเตือนเรียนหลักสูตร');
                        Yii::app()->user->setFlash('messages', 'ระยะการเรียนเหลือ ' . $checkNotification . ' วัน');
                    }
                }
            }
        // Calculator time course notification // end
// var_dump($category->special_category);exit();
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            $profile = $user->profile;
//var_dump($profile->type_user);        exit();
//var_dump($category->special_category);        exit();
//        if (($category->special_category == 'y') && ($profile->type_user != 1)) {
//            if ($user->pic_cardid) {
//                if ($course === null) {
//                    throw new CHttpException(404, 'The requested page does not exist.');
//                }
//            } else {
//                $this->redirect(array('/course/index/', 'id' => $course->cate_id));
//            }
//        }

            if($course->Schedules){ //Check LMS or TMS
                $criteria=new CDbCriteria;
                $criteria->with = array('schedule');
                $criteria->compare('user_id',Yii::app()->user->id);
                $criteria->compare('schedule.course_id',$course->course_id);
                $criteria->order = 't.schedule_id DESC';
                $authData = AuthCourse::model()->find($criteria);
                $course->course_date_start = $authData->schedule->training_date_start;
                $course->course_date_end = $authData->schedule->training_date_end;
            }
            if (!empty(Yii::app()->user->id)) {

                $logtime = LogStartcourse::model()->find(array(
                    'condition'=>'course_id=:course_id AND user_id=:user_id AND active=:active',
                    'params' => array(':course_id' => $id, ':user_id' => Yii::app()->user->id , ':active' => 'y')
                ));

    // $Endlearncourse = helpers::lib()->getEndlearncourse($course->course_day_learn);

                if (empty($logtime)) {

        // if($course->Schedules){ //Check LMS or TMS
        //     $course->course_date_end = $course->Schedules->training_date_end;
        // }

                    $now = date('Y-m-d H:i:s');
                    $Endlearncourse = strtotime("+".$course->course_day_learn." day", strtotime($now));
                    $Endlearncourse = date("Y-m-d", $Endlearncourse);

                    $logtime = new LogStartcourse;
                    $logtime->user_id = Yii::app()->user->id;
                    $logtime->course_id = $id;
            // $logtime->start_date = new CDbExpression('NOW()');
                    $logtime->start_date = $now;
                    $logtime->end_date = $Endlearncourse;
                    $logtime->course_day = $course->course_day_learn;
                    $logtime->save();

                }else if($logtime->course_day != $course->course_day_learn) {

                    $Endlearncourse = strtotime("+".$course->course_day_learn." day", strtotime($logtime->start_date));
                    $Endlearncourse = date("Y-m-d", $Endlearncourse);

                    $logtime->end_date = $Endlearncourse;
                    $logtime->course_day = $course->course_day_learn;
                    $logtime->save();
                }

            }

            if($logtime){
            // $dateStart=date_create($logtime->start_date);
                if($course->cate_id == '1' && !empty($modelCourseTms)){
                    $courseDateExpire = $authData->schedule->training_date_end;
                } else {
                    $courseDateEnd = CourseOnline::model()->findByPk($id);
                    $courseDateExpire =  $courseDateEnd->course_date_end;
                }
                $dateStart=date_create();
                $dateEnd=date_create($logtime->end_date);
                $diff=date_diff($dateStart,$dateEnd);
                $diff = $diff->format("%a");
            if($diff < 0 || (date('Y-m-d') > date($courseDateExpire))){//$course->course_date_end
                //set Flash
                Yii::app()->user->setFlash('msg', 'คุณหมดเวลาเรียนแล้ว');
                $this->redirect(array('site/index'));
            }
            
        }
        $this->render('detail', array(
            'lessonList' => $lessonList,
            'course' => $course,
            'courseTec' => $courseTec,
            'model_cate' => $model_cate,
            'teacher' => $teacher,
            'label' => $label,
            'logtime' => $logtime,
            'course_type' => $course_type
        ));
    }

    public function actionQuestionnaire($id) {

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $course = CourseOnline::model()->findByPk($id);
        $lessonList = Lesson::model()->findAll('course_id=' . $id);
        $lessonCurrent = Lesson::model()->findByPk($_GET['lesson_id']);

        $model_cate = Category::model()->findAllByAttributes(array('active' => 'y'));

        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
        }else{
            $langId = Yii::app()->session['lang'];
        }

        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if(!$label){
            $label = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        $this->render('questionnaire', array(
            'course' => $course,
            'lessonList' => $lessonList,
            'lessonCurrent' => $lessonCurrent,
            'model_cate' => $model_cate,
            'label'=>$label,
        ));
    }

    public function actionFinal($id = null) {

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
        }else{
            $langId = Yii::app()->session['lang'];
        }
        $criteria = new CDbCriteria;
        $criteria->condition = ' course_id="' . $id . '" AND lang_id="' . $langId.'"';
        $course_model = CourseOnline::model()->find($criteria);
        if(!$course_model){
            $course_model = CourseOnline::model()->findByPk($id);
        }

            // $course_model = CourseOnline::model()->findByPk($id);
        $lessonList = Lesson::model()->findAll('course_id=' . $id);
        $lessonCurrent = Lesson::model()->findByPk($_GET['lesson_id']);



        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if(!$label){
            $label = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        $model_cate = Category::model()->findAllByAttributes(array('active' => 'y'));

        $this->render('final', array(
            'course' => $course_model,
            'lessonList' => $lessonList,
            'lessonCurrent' => $lessonCurrent,
            'model_cate' => $model_cate,
            'label'=>$label
        ));
    }

    public function actionCertificate($id = null) {

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $course_model = CourseOnline::model()->findByPk($id);
        $lessonList = Lesson::model()->findAll('course_id=' . $id);
        $lessonCurrent = Lesson::model()->findByPk($_GET['lesson_id']);

        $model_cate = Category::model()->findAllByAttributes(array('active' => 'y'));
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
        }else{
            $langId = Yii::app()->session['lang'];
        }

        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if(!$label){
            $label = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        $this->render('certificate', array(
            'course' => $course_model,
            'lessonList' => $lessonList,
            'lessonCurrent' => $lessonCurrent,
            'model_cate' => $model_cate,
            'label' => $label,
        ));
    }

    public function actionCheckrequirement() {

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $lessonId = $_POST['lesson_id'];
        $currentUser = Yii::app()->user->id;

        $respon = null;
        if ($lessonId != null && $currentUser != null) {
            $currentLesson = Lesson::model()->findByPk($lessonId);
            if ($currentLesson) {
                // foreach($lessonList as $i => $lessonListValue) {
                //     $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListValue);
                //     if($checkLessonPass->percent == 100) {
                //         $allPass = true;
                //     } else {
                //         $allPass = false;
                //     }
                // }
                $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($currentLesson);
                if ($checkLessonPass->percent == 100) {
                    $allPass = true;
                } else {
                    $allPass = false;
                }
            }

            if ($allPass) {
                $respon['status'] = 1;
                $respon['errormsg'] = 'ผ่านการทำแบบทดสอบรายวิชา เรียบร้อยแล้ว';
            } else {
                $respon['status'] = 2;
                $respon['errormsg'] = 'มีบางรายวิชา หรือแบบทดสอบที่ยังไม่เสร็จ กรุณาทำให้ครบก่อนนะคะ';
            }
        } else {
            $respon['status'] = 0;
            $respon['errormsg'] = 'no have course_id or user login';
        }
        echo json_encode($respon);
    }

    public function actionPrintCertificate($id, $dl = null) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        //get all $_POST data
        $UserId = Yii::app()->user->id;
        $PassCoursId = $id;
        $certDetail = CertificateNameRelations::model()->find(array('condition'=>'course_id='.$id));
        //
        $currentUser = User::model()->findByPk($UserId);

        if ($PassCoursId != null) {
            $CourseModel = CourseOnline::model()->findByAttributes(array(
                'course_id' => $PassCoursId,
                'active' => 'y'
            ));
        } else {
            //category/index
            $this->redirect(array('category/index'));
        }

        $CertificateType = ($CourseModel->CategoryTitle->special_category == 'y') ? 'cpd' : null;

        if ($CertificateType) {
            $model = Passcours::model()->find(array(
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND passcours_user = "' . $UserId . '"',
            )
        );
            if ($model == null) {
                $model = Coursescore::model()->find(array(
                    'condition' => 'course_id= " ' . $PassCoursId . '" AND user_id= "' . $UserId . '"'
                ));
            }
        } else {
            $model = Passcours::model()->find(array(
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND passcours_user = "' . $UserId . '"',
            )
        );
            if ($model == null) {
                $model = $CourseModel;
            }
        }

        //set default text + data
        $PrintTypeArray = array(
            '2' => array('text' => 'ผู้ทำบัญชีรหัสเลขที่', 'id' => (isset($model->user)) ? $model->user->bookkeeper_id : $currentUser->bookkeeper_id),
            '3' => array('text' => 'ผู้สอบบัญชีรับอนุญาต เลขทะเบียน', 'id' => (isset($model->user)) ? $model->user->auditor_id : $currentUser->auditor_id)
        );

        //set user type
        if (isset($model->Profiles)) {
            switch ($model->Profiles->type_user) {
                case '1':
                $userAccountCode = null;
                break;
                case '4':
                $userAccountCode = $PrintTypeArray['2']['text'] . ' ' . $PrintTypeArray['2']['id'] . ' ' . $PrintTypeArray['3']['text'] . ' ' . $PrintTypeArray['3']['id'];
                break;
                default:
                $userAccountCode = $PrintTypeArray[$model->Profiles->type_user]['text'] . ' ' . $PrintTypeArray[$model->Profiles->type_user]['id'];
                break;
            }
        }

        //get start & end learn date of current course
        $StartDateLearnThisCourse = Learn::model()->with('LessonMapper')->find(array(
            'condition' => 'learn.user_id = ' . $UserId . ' AND learn.course_id = ' . $PassCoursId,
            'alias' => 'learn',
            'order' => 'learn.create_date ASC',
        ));

        $startDate = $StartDateLearnThisCourse->learn_date;
        if ($StartDateLearnThisCourse->create_date) {
            $startDate = $StartDateLearnThisCourse->create_date;
        }
        //
        //get date passed final test **future change
        $CourseDatePass = null;
        //Pass Course Date
        $CourseDatePassModel = Passcours::model()->find(array('condition' => 'passcours_user = '.$UserId));
        $CourseDatePass = $CourseDatePassModel->passcours_date;

        // $CoursePassedModel = Coursescore::model()->find(array(
        //     'condition' => 'user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId . ' AND score_past = "y"',
        //     'order' => 'create_date ASC'
        //     ));
        $CoursePassedModel = Passcours::model()->find(array(
            'condition' => 'passcours_user = ' . $UserId . ' AND passcours_cours = ' . $PassCoursId 
        ));

        // if ($CoursePassedModel) {
        //     $CourseDatePass = date('Y-m-d', strtotime($CoursePassedModel->passcours_date));
        // }
        //
        //get period when test score over thai 60 percent **remark select just only first time
        if (isset($model->Period)) {
            foreach ($model->Period as $i => $PeriodTime) {
                if ($CourseDatePass >= $PeriodTime->startdate && $CourseDatePass <= $PeriodTime->enddate) {
                    $courseCode = $PeriodTime->code;
                    $courseAccountHour = $PeriodTime->hour_accounting;
                    $courseEtcHour = $PeriodTime->hour_etc;
                }
            }
        }

        $course_check_sign = array('170', '174', '186', '187', '188', '189', '190', '191', '192', '193', '194');
        // $renderFile = 'certificate';
        $renderFile = 'Newcertificate';
        /*if ($CertificateType == 'cpd') {
            $renderFile = 'certificate_cpd';
            $renderSign = 'dbd_certificate_dbd_sign.png';
            $nameSign = '( นางโสรดา เลิศอาภาจิตร์ )';
            $positionSign = 'ผู้อำนวยการกองกำกับบัญชีธุรกิจ';
        } else {
            if (in_array($PassCoursId, $course_check_sign)) {
                $renderSign = 'dbd_certificate_sign_2.png';
                $nameSign = '( ม.ล. ภู่ทอง  ทองใหญ่ )';
                $positionSign = 'ผู้อำนวยการกองพัฒนาผู้ประกอบธุรกิจ';
            } else {
                $renderSign = 'dbd_certificate_sign.png';
                $nameSign = '( นายธานี  โอฬารรัตน์มณี )';
                $positionSign = 'ผู้อำนวยการกองพาณิชย์อิเล็กทรอนิกส์';
            }
        }*/
        $renderSign = $certDetail->certificate->signature->sign_path;
        $nameSign = $certDetail->certificate->signature->sign_title;
        $positionSign = $certDetail->certificate->signature->sign_position;

        $sign_id2 = $certDetail->certificate->sign_id2; //key
        $model2 = Signature::model()->find(array('condition' => 'sign_id = '.$sign_id2)); //model PK = sign_id2

        $renderSign2 = $model2->sign_path;
        // $nameSign2 = $model2->sign_title;
        // $positionSign2 = $model2->sign_position;

        //position
        // $position_id = $currentUser->position_id;
        // $position = Position::model()->find(array('condition' => 'id = '.$position_id));
        // $position_title = $position->position_title;

        //Company
        $company_id = $currentUser->company_id;
        if(!empty($company_id)){
            $company = Company::model()->find(array('condition' => 'company_id = '.$company_id));
            $company_title = $company->company_title;
        }else{
            $company_title =$currentUser->profile->department;
        }
        // var_dump($certDetail->certificate);exit();

        if($certDetail->certificate->cert_display == '1'){
            $pageFormat = 'P';
        } else {
            $pageFormat = 'L';
        }

        $logStartTime = LogStartcourse::model()->findByAttributes(array('user_id' => $UserId,'course_id'=> $PassCoursId));


        if(!$logStartTime){

            $logStartTime->start_date =  date('Y-m-d');
            $logStartTime->end_date = date('Y-m-d');

            if($logStartTime->start_date == $logStartTime->end_date){
                $period = Helpers::lib()->PeriodDate($logStartTime->end_date,true);
            }
        }else{
            $startLogDate = Helpers::lib()->PeriodDate($logStartTime->start_date,false);
            $endLogDate = Helpers::lib()->PeriodDate($logStartTime->end_date,true);

            $ckMonthStart = explode(' ', $startLogDate);
            $ckMonthEnd = explode(' ', $endLogDate);


            if($ckMonthStart[1] == $ckMonthEnd[1]){
                $period = $ckMonthStart[0]." - ".$ckMonthEnd[0]." ".$ckMonthStart[1]." ".$ckMonthEnd[2];
            }else{
                $period = $startLogDate." - ".$endLogDate;
            }

        }

        $course_model = CourseOnline::model()->findByAttributes(array(
            'course_id' => $PassCoursId,
            'active' => 'y'
        ));
        if(!empty($course_model->course_date_end)){ //LMS
            $course_model->course_date_end =  Helpers::lib()->PeriodDate($course_model->course_date_end,true);
        }else{ //TMS
            $course_model->course_date_end = Helpers::lib()->PeriodDate($course_model->Schedules->training_date_end,true);
        }
        
        if ($model) {
            $fulltitle = $currentUser->profile->ProfilesTitle->prof_title ."". $currentUser->profile->firstname . " " . $currentUser->profile->lastname;
            $identification = $currentUser->profile->identification ;

            if (isset($model->Profiles)) {
                $fulltitle = $model->Profiles->firstname . " " . $model->Profiles->lastname;
            }
            $setCertificateData = array(
                'fulltitle' => $fulltitle,
                'userAccountCode' => $userAccountCode,
                'courseTitle' => (isset($model->CourseOnlines)) ? $model->CourseOnlines->course_title : $model->course_title,
                'courseCode' => (isset($courseCode)) ? 'รหัสหลักสูตร ' . $courseCode : null,
                'courseAccountHour' => (isset($courseAccountHour)) ? $courseAccountHour : null,
                'courseEtcHour' => (isset($courseEtcHour)) ? $courseEtcHour : null,
                'startLearnDate' => $startDate,
                
                'period' => $period,
                'endDateCourse' => $course_model->course_date_end,

                'endLearnDate' => (isset($model->passcours_date)) ? $model->passcours_date : $model->create_date,
                'courseDatePassOver60Percent' => $CourseDatePass,

                'renderSign' => $renderSign,
                'nameSign' => $nameSign,
                'positionSign' => $positionSign,

                'renderSign2' => $renderSign2,
                // 'nameSign2' => $nameSign2,
                // 'positionSign2' => $positionSign2,

                'positionUser' => $position_title,
                'companyUser' => $company_title,

                'identification' => $identification,
                'bgPath' => $certDetail->certificate->cert_background,
                'pageFormat' => $pageFormat,
                'pageSide' => $certDetail->certificate->cert_display,
            );


            //Print
            // $mPDF = Yii::app()->ePdf->mpdf('th', 'A4-L', '0', 'dbhelvethaicax');
            // $mPDF->setDisplayMode('fullpage');
            // $mPDF->setAutoFont();
            // $mPDF->SetTitle($certDetail->certificate->cert_name);
            // $mPDF->AddPage($pageFormat);

            //encode html for UTF-8 before write to html
            // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model' => $setCertificateData), true), 'UTF-8', 'UTF-8'));

            require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
            $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
            $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));

            //output
            if (isset($model->passcours_id) OR isset($model->score_id)) {
                if (isset($model->passcours_id)) {
                    $target = $model->passcours_id;
                } else if (isset($model->score_id)) {
                    $target = $model->score_id;
                }
            } else {
                $target = $model->course_id;
            }
            if ($dl != null && $dl == 'dl') {
                self::savePassCourseLog('Download', $target);
                $mPDF->Output($fulltitle . '.pdf', 'D');
            } else {
                self::savePassCourseLog('Print', $target);
                $mPDF->Output();
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionSendCertificateEmail($id, $dl = null) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            Yii::app()->language = 'en';
        }else{
            $langId = Yii::app()->session['lang'];
            Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
        }

        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if(!$label){
            $label = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }
        //get all $_POST data
        $UserId = Yii::app()->user->id;
        $PassCoursId = $id;
        $certDetail = CertificateNameRelations::model()->find(array('condition'=>'course_id='.$id));
        //
        $currentUser = User::model()->findByPk($UserId);

        if ($PassCoursId != null) {
            $CourseModel = CourseOnline::model()->findByAttributes(array(
                'course_id' => $PassCoursId,
                'active' => 'y'
            ));
        } else {
            //category/index
            $this->redirect(array('category/index'));
        }


        $CertificateType = ($CourseModel->CategoryTitle->special_category == 'y') ? 'cpd' : null;

        if ($CertificateType) {
            $model = Passcours::model()->find(array(
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND passcours_user = "' . $UserId . '"',
            )
        );
            if ($model == null) {
                $model = Coursescore::model()->find(array(
                    'condition' => 'course_id= " ' . $PassCoursId . '" AND user_id= "' . $UserId . '"'
                ));
            }
        } else {
            $model = Passcours::model()->find(array(
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND passcours_user = "' . $UserId . '"',
            )
        );
            if ($model == null) {
                $model = $CourseModel;
            }
        }

        //set default text + data
        $PrintTypeArray = array(
            '2' => array('text' => 'ผู้ทำบัญชีรหัสเลขที่', 'id' => (isset($model->user)) ? $model->user->bookkeeper_id : $currentUser->bookkeeper_id),
            '3' => array('text' => 'ผู้สอบบัญชีรับอนุญาต เลขทะเบียน', 'id' => (isset($model->user)) ? $model->user->auditor_id : $currentUser->auditor_id)
        );

        //set user type
        if (isset($model->Profiles)) {
            switch ($model->Profiles->type_user) {
                case '1':
                $userAccountCode = null;
                break;
                case '4':
                $userAccountCode = $PrintTypeArray['2']['text'] . ' ' . $PrintTypeArray['2']['id'] . ' ' . $PrintTypeArray['3']['text'] . ' ' . $PrintTypeArray['3']['id'];
                break;
                default:
                $userAccountCode = $PrintTypeArray[$model->Profiles->type_user]['text'] . ' ' . $PrintTypeArray[$model->Profiles->type_user]['id'];
                break;
            }
        }

        //get start & end learn date of current course
        $StartDateLearnThisCourse = Learn::model()->with('LessonMapper')->find(array(
            'condition' => 'learn.user_id = ' . $UserId . ' AND learn.course_id = ' . $PassCoursId,
            'alias' => 'learn',
            'order' => 'learn.create_date ASC',
        ));

        $startDate = $StartDateLearnThisCourse->learn_date;
        if ($StartDateLearnThisCourse->create_date) {
            $startDate = $StartDateLearnThisCourse->create_date;
        }
        //
        //get date passed final test **future change
        $CourseDatePass = null;
        //Pass Course Date
        $CourseDatePassModel = Passcours::model()->find(array('condition' => 'passcours_user = '.$UserId));
        $CourseDatePass = $CourseDatePassModel->passcours_date;

        $CoursePassedModel = Passcours::model()->find(array(
            'condition' => 'passcours_user = ' . $UserId . ' AND passcours_cours = ' . $PassCoursId 
        ));

        //get period when test score over thai 60 percent **remark select just only first time
        if (isset($model->Period)) {
            foreach ($model->Period as $i => $PeriodTime) {
                if ($CourseDatePass >= $PeriodTime->startdate && $CourseDatePass <= $PeriodTime->enddate) {
                    $courseCode = $PeriodTime->code;
                    $courseAccountHour = $PeriodTime->hour_accounting;
                    $courseEtcHour = $PeriodTime->hour_etc;
                }
            }
        }
        if($certDetail){
            $course_check_sign = array('170', '174', '186', '187', '188', '189', '190', '191', '192', '193', '194');
            $renderFile = 'Newcertificate';
            $renderSign = $certDetail->certificate->signature->sign_path;
            $nameSign = $certDetail->certificate->signature->sign_title;
            $positionSign = $certDetail->certificate->signature->sign_position;

        $sign_id2 = $certDetail->certificate->sign_id2; //key
        $model2 = Signature::model()->find(array('condition' => 'sign_id = '.$sign_id2)); //model PK = sign_id2

        $renderSign2 = $model2->sign_path;
        //Company
        $company_id = $currentUser->company_id;
        if(!empty($company_id)){
            $company = Company::model()->find(array('condition' => 'company_id = '.$company_id));
            $company_title = $company->company_title;
        }else{
            $company_title =$currentUser->profile->department;
        }
        // var_dump($certDetail->certificate);exit();

        if($certDetail->certificate->cert_display == '1'){
            $pageFormat = 'P';
        } else {
            $pageFormat = 'L';
        }
    }
    $logStartTime = LogStartcourse::model()->findByAttributes(array('user_id' => $UserId,'course_id'=> $PassCoursId));


    if(!$logStartTime){

        $logStartTime->start_date =  date('Y-m-d');
        $logStartTime->end_date = date('Y-m-d');

        if($logStartTime->start_date == $logStartTime->end_date){
            $period = Helpers::lib()->PeriodDate($logStartTime->end_date,true);
        }
    }else{
        $startLogDate = Helpers::lib()->PeriodDate($logStartTime->start_date,false);
        $endLogDate = Helpers::lib()->PeriodDate($logStartTime->end_date,true);

        $ckMonthStart = explode(' ', $startLogDate);
        $ckMonthEnd = explode(' ', $endLogDate);


        if($ckMonthStart[1] == $ckMonthEnd[1]){
            $period = $ckMonthStart[0]." - ".$ckMonthEnd[0]." ".$ckMonthStart[1]." ".$ckMonthEnd[2];
        }else{
            $period = $startLogDate." - ".$endLogDate;
        }

    }

    $course_model = CourseOnline::model()->findByAttributes(array(
        'course_id' => $PassCoursId,
        'active' => 'y'
    ));

        if(!empty($course_model->course_date_end)){ //LMS
            $course_model->course_date_end =  Helpers::lib()->PeriodDate($course_model->course_date_end,true);
            $course_type = 'lms';
        }else{ //TMS
            $course_model->course_date_end = Helpers::lib()->PeriodDate($course_model->Schedules->training_date_end,true);
            $course_type = 'tms';
        }

        
        if ($model && $certDetail) {
            $fulltitle = $currentUser->profile->ProfilesTitle->prof_title ."". $currentUser->profile->firstname . " " . $currentUser->profile->lastname;
            $identification = $currentUser->profile->identification ;

            if (isset($model->Profiles)) {
                $fulltitle = $model->Profiles->firstname . " " . $model->Profiles->lastname;
            }
            $setCertificateData = array(
                'fulltitle' => $fulltitle,
                'userAccountCode' => $userAccountCode,
                'courseTitle' => (isset($model->CourseOnlines)) ? $model->CourseOnlines->course_title : $model->course_title,
                'courseCode' => (isset($courseCode)) ? 'รหัสหลักสูตร ' . $courseCode : null,
                'courseAccountHour' => (isset($courseAccountHour)) ? $courseAccountHour : null,
                'courseEtcHour' => (isset($courseEtcHour)) ? $courseEtcHour : null,
                'startLearnDate' => $startDate,
                
                'period' => $period,
                'endDateCourse' => $course_model->course_date_end,

                'endLearnDate' => (isset($model->passcours_date)) ? $model->passcours_date : $model->create_date,
                'courseDatePassOver60Percent' => $CourseDatePass,

                'renderSign' => $renderSign,
                'nameSign' => $nameSign,
                'positionSign' => $positionSign,

                'renderSign2' => $renderSign2,
                // 'nameSign2' => $nameSign2,
                // 'positionSign2' => $positionSign2,

                'positionUser' => $position_title,
                'companyUser' => $company_title,

                'identification' => $identification,
                'bgPath' => $certDetail->certificate->cert_background,
                'pageFormat' => $pageFormat,
                'pageSide' => $certDetail->certificate->cert_display,
            );
            require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
            $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
            $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));

            //Save file
            $pathSavePdf = $_SERVER['DOCUMENT_ROOT']."/lms_airasia/uploads/certificate/".$currentUser->id.'_'.$PassCoursId.'_'.time().'.pdf';
            $mPDF->Output($pathSavePdf, 'F');


            if(!empty($certDetail)){
             $to = array();
             $to['email'] = $currentUser->email;
             $to['firstname'] = $currentUser->profile->firstname;
             $to['lastname'] = $currentUser->profile->lastname;
             $subject = 'ระบบส่งไฟล์ใบประกาศนียบัตร';
             $message = 'ท่านสอบผ่านหลักสูตร '.$course_model->course_title;
             $mail = Helpers::lib()->SendMailMsg($to, $subject, $message,$pathSavePdf);
         }
            //output
         if (isset($model->passcours_id) OR isset($model->score_id)) {
            if (isset($model->passcours_id)) {
                $target = $model->passcours_id;
            } else if (isset($model->score_id)) {
                $target = $model->score_id;
            }
        } else {
            $target = $model->course_id;
        }
        if ($dl != null && $dl == 'dl') {
            self::savePassCourseLog('Download', $target);
                // $mPDF->Output($fulltitle . '.pdf', 'D');
        } else {
            self::savePassCourseLog('Print', $target);
                // $mPDF->Output();
        }

        $this->redirect(array('/course/detail/', 'id' => $PassCoursId));
            // exit();

    } else {
        $this->redirect(array('/course/detail/', 'id' => $PassCoursId));
            // throw new CHttpException(404, 'The requested page does not exist.');
    }
}

public function actionTest(){
 require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
 $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);

        //Save file

 $mPDF->WriteHTML('Hello xxxxxx');
 $pathSavePdf = $_SERVER['DOCUMENT_ROOT']."/lms_airasia/uploads/certificate/testset.pdf";
 $mPDF->Output($pathSavePdf, 'F');

 var_dump(Yii::app()->getBaseUrl(true)."/uploads/certificate/");
 var_dump($_SERVER['DOCUMENT_ROOT']);
 exit();
}

private function savePassCourseLog($action, $passcours_id) {

    if (Yii::app()->user->id) {
        $model = new PasscoursLog();
            //set model data
        $model->pclog_userid = Yii::app()->user->id;
        $model->pclog_event = $action;
        $model->pclog_target = $passcours_id;
        $model->pclog_date = date('Y-m-d H:i:s');

            //save
        if (!$model->save()) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }
}

public function actionCourseLearn($id = null){

    $param = $_GET['file'];
    $str = CHtml::encode($param);
    if(!is_numeric($str)){
        throw new CHttpException(404, 'The requested page does not exist.');
    }

    if(Yii::app()->user->id){
        Helpers::lib()->getControllerActionId();
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
        Yii::app()->language = 'en';
    }else{
        $langId = Yii::app()->session['lang'];
        Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
    }

    $label = MenuCourse::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
    if(!$label){
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }

    $modelCapt = new ValidateCaptcha;
    $model = Lesson::model()->findByPk($id);
    $time = ConfigCaptchaCourseRelation::model()->with('captchaTime')->find(array(
        'condition'=>'cnid=:cnid AND captchaTime.capt_hide="1" AND captchaTime.capt_active="y"',
        'params' => array('cnid' => $model->course_id)));
    if(!$time){
        $time = ConfigCaptchaCourseRelation::model()->findByPk(0);
    }


    $lessonList = Lesson::model()->findAll(array(
        'condition'=>'course_id=:course_id AND active=:active AND lang_id=:lang_id',
        'params'=>array(':course_id'=>$model->course_id,':active'=>'y',':lang_id'=>1),
        'order'=>'lesson_no ASC'
    ));

    Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id,$model->course_id);

    if(Helpers::lib()->CheckBuyItem($model->course_id,false) == true && ! Helpers::isPretestState($id))
    {
        $learn_id = "";
                // if($model->count() > 0)
        if(count($model) > 0)
        {
            $user = Yii::app()->getModule('user')->user();
            $learnModel = Learn::model()->find(array(
                'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active="y"',
                'params'=>array(':lesson_id'=>$id,':user_id'=>$user->id)
            ));
            if(!$learnModel)
            {
                $learnLog = new Learn;
                $learnLog->user_id = $user->id;
                $learnLog->lesson_id = $id;
                $learnLog->learn_date = new CDbExpression('NOW()');
                $learnLog->course_id = $model->course_id;
                $learnLog->save();
                $learn_id = $learnLog->learn_id;
            }
            else
            {
                $learnModel->learn_date = new CDbExpression('NOW()');
                $learnModel->save();
                $learn_id = $learnModel->learn_id;
            }
        }
        $this->layout = "//layouts/learn";
        $this->render('course-learn',array(
            'model'=>$model,
            'learn_id'=>$learn_id,
            'modelCapt' => $modelCapt,
            'time' => $time,
            'lessonList' => $lessonList,
            'label' => $label
        ));
    }
    else
    {
        Yii::app()->user->setFlash('CheckQues', array('msg'=>'Error','class'=>'error'));
        $this->redirect(array('//courseOnline/index','id'=>Yii::app()->user->getState('getLesson')));
    }
}
public function actionLessonShow() {
    $vars = array_merge($_GET,$_POST);
    $lesson = Lesson::model()->findByPk($vars['lid']);
    $uploadFolderScorm = Yii::app()->getUploadUrl("scorm");
    foreach ($lesson->fileScorm as $key => $value) {
        $lessonfile = $value->file_name;
        $fid = $value->id;
    }
    header("location:$uploadFolderScorm$fid/$lessonfile", false);
}

public function actionCheckCaptcha()
{
    $model = new ValidateCaptcha;
    $model->attributes = $_POST['ValidateCaptcha'];
    $user = Yii::app()->getModule('user')->user();
    if(isset($_POST['ValidateCaptcha'])) {
        $modelCapt = ValidateCaptcha::model()->find(array(
            'condition' => 'user_id=:user_id AND cnid=:cnid AND status="0"',
            'params' => array(':user_id' => $user->id,':cnid' => $model->cnid)
        )
    );
        $time = ConfigCaptchaCourseRelation::model()->with('captchaTime')->find(array(
            'condition'=>'cnid=:cnid AND captchaTime.capt_hide="1" AND captchaTime.capt_active="y"',
            'params' => array(':cnid' => $model->cnid)
        ));
        $val = array();
        if($modelCapt){
            $captchaStart = strtotime(Yii::app()->session['captchaTimeStart']);
            $captchaStop = strtotime(date('Y-m-d H:i:s'));
            $modelCapt->time = $captchaStop-$captchaStart;
            $modelCapt->status = 1;
            if ($model->validate()) {
                $modelCapt->check = 'true';
                $val['status'] = 1;
            } else {
                if($modelCapt->count==($time->captchaTime->capt_times)){
                    $val['status'] = 2;
                    $modelCapt->check = 'back';
                } else {
                    Yii::app()->session['captchaTimeStart'] = date('Y-m-d H:i:s');
                    $val['status'] = 0;
                    $model->user_id = $user->id;
                    $model->status = 0;
                    $model->count = $modelCapt->count+1;
                    $model->created_date = date('Y-m-d H:i:s');
                    $model->save(false);
                }
            }
            $val['count'] = $modelCapt->count;
            $modelCapt->save(false);
        } 
        echo json_encode($val);
    }

    if(isset($_POST['id'])){
        $imageCount = ImageSlide::model()->count('file_id=:file_id AND image_slide_name != ""', array(':file_id' => $_POST['id']));
        $file_index = ImageSlide::model()->find('(file_id=:file_id AND image_slide_name != "" AND image_slide_name<=:ctime) ORDER BY image_slide_id DESC', array(':file_id' => $_POST['id'],':ctime' => $_POST['ctime']));
        $data = array();
        $data['count'] = $imageCount;
        $data['fileIndex'] = $file_index->image_slide_name;
        $criteria=new CDbCriteria;
        $criteria->with = "learn";
        $criteria->compare('user_id_file',$user->id);
        $criteria->compare('file_id',$_POST['id']);
        $criteria->compare('learn.cnid',$_POST['course_id']);
        $criteria->compare('learn.lid',$_POST['lesson_id']);
        $criteria->addCondition('learn_file_status != "s"');
        $learn_state = LearnFile::model()->find($criteria);
        if($learn_state){
            if(!$file_index->image_slide_name) $file_index->image_slide_name = 0;
            $learn_state->learn_file_status = (string)$file_index->image_slide_name;
            $data['state'] = 1;
            $learn_state->save(false);
        }
        if(isset($_POST['staTime'])){
           $modelCapt = ValidateCaptcha::model()->find(array(
            'condition' => 'user_id=:user_id AND cnid=:cnid AND status="0"',
            'params' => array(':user_id' => $user->id,':cnid' => $_POST['cnid'])
        )
       );
           $time = ConfigCaptchaCourseRelation::model()->with('captchaTime')->find(array(
            'condition'=>'cnid=:cnid AND captchaTime.capt_hide="1" AND captchaTime.capt_active="y"',
            'params' => array(':cnid' => $_POST['cnid'])
        ));
           if($modelCapt){
            $modelCapt->time = $time->captchaTime->capt_wait_time;
            $modelCapt->status = 1;
            $modelCapt->check = $_POST['staTime'];
            $modelCapt->user_id = $user->id;
                //$modelCapt->count = $modelCapt->count+1;
            $modelCapt->created_date = date('Y-m-d H:i:s');
            $modelCapt->save(false);
        } 
    }
    echo json_encode($data);
}

}

public function actionCheckCaptchaPdf()
{
            // $model = new ValidateCaptcha;
            // $model->attributes = $_POST['ValidateCaptcha'];
    $user = Yii::app()->getModule('user')->user();
            // if(isset($_POST['ValidateCaptcha'])) {
            //     $modelCapt = ValidateCaptcha::model()->find(array(
            //         'condition' => 'user_id=:user_id AND cnid=:cnid AND status="0"',
            //         'params' => array(':user_id' => $user->id,':cnid' => $model->cnid)
            //     )
            // );
            //     $time = ConfigCaptchaCourseRelation::model()->with('captchaTime')->find(array(
            //         'condition'=>'cnid=:cnid AND captchaTime.capt_hide="1" AND captchaTime.capt_active="y"',
            //         'params' => array(':cnid' => $model->cnid)
            //     ));
            //     $val = array();
            //     if($modelCapt){
            //         $captchaStart = strtotime(Yii::app()->session['captchaTimeStart']);
            //         $captchaStop = strtotime(date('Y-m-d H:i:s'));
            //         $modelCapt->time = $captchaStop-$captchaStart;
            //         $modelCapt->status = 1;
            //         if ($model->validate()) {
            //             $modelCapt->check = 'true';
            //             $val['status'] = 1;
            //         } else {
            //             if($modelCapt->count==($time->captchaTime->capt_times)){
            //                 $val['status'] = 2;
            //                 $modelCapt->check = 'back';
            //             } else {
            //                 Yii::app()->session['captchaTimeStart'] = date('Y-m-d H:i:s');
            //                 $val['status'] = 0;
            //                 $model->user_id = $user->id;
            //                 $model->status = 0;
            //                 $model->count = $modelCapt->count+1;
            //                 $model->created_date = date('Y-m-d H:i:s');
            //                 $model->save(false);
            //             }
            //         }
            //         $val['count'] = $modelCapt->count;
            //         $modelCapt->save(false);
            //     } 
            //     echo json_encode($val);
            // }
    if(isset($_POST['file_id'])){

        $data = array();
        $criteria=new CDbCriteria;
        $criteria->compare('user_id_file',$user->id);
        $criteria->compare('file_id',$_POST['file_id']);
        $criteria->compare('learn_id',$_POST['learn_id']);
        $criteria->addCondition('learn_file_status != "s"');
        $learn_state = LearnFile::model()->find($criteria);

        if($learn_state){
            $learn_state->learn_file_status = $_POST['slide'];
            $data['state'] = 1;
            $learn_state->save(false);
        }
        if(isset($_POST['staTime'])){
           $modelCapt = ValidateCaptcha::model()->find(array(
            'condition' => 'user_id=:user_id AND cnid=:cnid AND status="0"',
            'params' => array(':user_id' => $user->id,':cnid' => $_POST['cnid'])
        )
       );
           $time = ConfigCaptchaCourseRelation::model()->with('captchaTime')->find(array(
            'condition'=>'cnid=:cnid AND captchaTime.capt_hide="1" AND captchaTime.capt_active="y"',
            'params' => array(':cnid' => $_POST['cnid'])
        ));
           if($modelCapt){
                    // $modelCapt->time = $time->captchaTime->capt_wait_time;
            $modelCapt->status = 1;
            $modelCapt->check = $_POST['staTime'];
            $modelCapt->user_id = $user->id;
                //$modelCapt->count = $modelCapt->count+1;
            $modelCapt->created_date = date('Y-m-d H:i:s');
            $modelCapt->save(false);
        } 
    }
    echo json_encode($data);
}

}

public function actionSaveCaptchaStart(){
    if(isset($_POST['ValidateCaptcha'])) {
        $model = new ValidateCaptcha;
        $model->attributes = $_POST['ValidateCaptcha'];
        Yii::app()->session['captchaTimeStart'] = date('Y-m-d H:i:s');
        $user = Yii::app()->getModule('user')->user();
        $count = ValidateCaptcha::model()->count(array(
            'condition' => 'user_id=:user_id AND cnid=:cnid AND status="0"',
            'params' => array(':user_id' => $user->id,':cnid' => $model->cnid)
        )
    );
        $att = array();
        $att['status'] = true;
        if(!$count){
            $model->attributes = $_POST['ValidateCaptcha'];
            $model->user_id = $user->id;
            $model->status = 0;
            $model->count = $model->count+1;
            $model->created_date = date('Y-m-d H:i:s');
            if(!$model->save(false)){
                $att['status'] = false;
                echo ($model->getErrors());
            }
        }
        $time = ConfigCaptchaCourseRelation::model()->find(array(
            'condition' => 'cnid=:cnid',
            'params' => array(':cnid'=>$model->cnid)
        ));
        $att['timeBack'] = $time->captchaTime->capt_wait_time;
        echo json_encode($att);
    }                                                   
}

public function actionCountdownAjax(){
        // var_dump($_POST);
        // exit();
    $modelLearnFilePdf = LearnFile::model()->find(array(
        'condition' => 'user_id_file=:user_id AND file_id=:file_id AND learn_id=:learn_id',
        'params' => array(':user_id' => Yii::app()->user->id,':file_id' => $_POST['file_id'],':learn_id' => $_POST['learn_pdf_id'])));
    if(is_numeric($modelLearnFilePdf->learn_file_status) || empty($modelLearnFilePdf->learn_file_status))$statSlide = true;
    if($statSlide){
        $attr = array();
        $slideIdx = $modelLearnFilePdf->learn_file_status ? $modelLearnFilePdf->learn_file_status : 0;
        $modelFilePdf = PdfSlide::model()->find(array(
            'condition' => 'file_id='.$_POST['file_id'].' AND image_slide_name='.$slideIdx
        ));
        $attr['dateTime'] = $modelFilePdf->image_slide_next_time;/*date('Y/m/d H:i:s',strtotime('+'.$modelFilePdf->image_slide_next_time.' seconds',strtotime(date('Y/m/d H:i:s'))));*/
        $attr['idx'] = $modelLearnFilePdf->learn_file_status;
    } else {
        $attr['status'] = false;
    }
    echo json_encode($attr);
}

public function actionCaptchaPdf(){
        // $slide_id = $_POST['slide_id'];
        // $course_id = $_POST['course_id'];
    $slide_id = 16;
    $course_id = 59;

    $data = array();
    $ckType = json_decode($time->captchaTime->type);
        if(in_array("2", json_decode($time->captchaTime->type))){ //Type 2 = PDF
            $data['slide'] = $time->captchaTime->slide;
            $data['prev_slide'] = $time->captchaTime->prev_slide;
            $data['state'] = true;
        }else{
            $data['state'] = false;
        }

        echo json_encode($data);


    }
    public function actionGetSlide(){
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $learn_id = (isset($_POST['learn_id'])) ? $_POST['learn_id'] : '';
        $modelLearnFilePdf = LearnFile::model()->find(array(
            'condition' => 'file_id=:file_id AND learn_id=:learn_id',
            'params' => array(':file_id' => $id, ':learn_id' => $learn_id)
        ));
        $data = array();
        if($modelLearnFilePdf->learn_file_status != 's'){
            $data['slide'] = $modelLearnFilePdf->learn_file_status;
        }else{
            $directory =  Yii::app()->basePath."/../uploads/pdf/".$id."/";
            $filecount = 0;
            $files = glob($directory . "*.{jpg}",GLOB_BRACE);
            if ($files){
                $filecount = count($files);
            }
            $data['slide'] = $filecount;
        }

        echo json_encode($data);
    }
}
