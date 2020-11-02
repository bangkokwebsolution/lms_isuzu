<?php
class ReportController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', 
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'Loadgen', 'LogReset', 'ajaxgetlesson', 'ajaxgetlevel'),
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

    public function actionStatus($id=null) { //ข้อมูลการฝึกอบรมของพนักงานรายบุคคล
        $model=new Report('search');
        $model->unsetAttributes();

        if($id != null) {
            $model->user_id = $id;
        }

        if(isset($_GET['Report'])){
            $model->attributes=$_GET['Report'];
        }

        $this->render('status', array('model'=>$model));
    }


    public function actionByCourse($id=null) { // ค้นหาโดยใช้หลักสูตร

        $model = new Report('ByCourse');
        $model->unsetAttributes();

        if($id!=null) {
            $model->course_id = $id;
        }

        if(isset($_GET['Report'])) {
           
            $model->course_id = $_GET['Report']['course_id'];
            $model->gen_id = $_GET['Report']['gen_id'];
            $model->search = $_GET['Report']['search'];
            $model->type_register = $_GET['Report']['type_register'];
            $model->department = $_GET['Report']['department'];
            $model->position = $_GET['Report']['position'];
            $model->period_start = $_GET['Report']['period_start'];
            $model->period_end = $_GET['Report']['period_end'];

        }

        $this->render('ByCourse', array(
            'model' => $model
        ));
    }

    public function actionGenExcelByCourse(){
        $model = new Report('ByCourse');
        $model->unsetAttributes();

        if($id!=null) {
            $model->course_id = $id;
        }

        if(isset($_GET['Report'])) {
            $model->course_id = $_GET['Report']['course_id'];
            $model->gen_id = $_GET['Report']['gen_id'];
            $model->search = $_GET['Report']['search'];
            $model->type_register = $_GET['Report']['type_register'];
            $model->department = $_GET['Report']['department'];
            $model->position = $_GET['Report']['position'];
            $model->period_start = $_GET['Report']['period_start'];
            $model->period_end = $_GET['Report']['period_end'];
        }    

        $this->renderPartial('ExcelByCourse', array(
            'model'=>$model
        ));

    }

    public function actionByLesson() {
        $model = new Report();
        $model->unsetAttributes(); 

        if(isset($_GET['Report'])) {
            $model->course_id = $_GET['Report']['course_id'];
            $model->gen_id = $_GET['Report']['gen_id'];
            $model->lesson_id = $_GET['Report']['lesson_id'];
            $model->search = $_GET['Report']['search'];
            $model->type_register = $_GET['Report']['type_register'];
            $model->department = $_GET['Report']['department'];
            $model->position = $_GET['Report']['position'];
            $model->period_start = $_GET['Report']['period_start'];
            $model->period_end = $_GET['Report']['period_end'];
        }    
        

        $this->render('ByLesson', array(
            'model' => $model,
        ));
    }

    public function actionGenExcelByLesson(){
        $model = new Report();
        $model->unsetAttributes(); 

        if(isset($_GET['Report'])) {
            $model->course_id = $_GET['Report']['course_id'];
            $model->gen_id = $_GET['Report']['gen_id'];
            $model->lesson_id = $_GET['Report']['lesson_id'];
            $model->search = $_GET['Report']['search'];
            $model->type_register = $_GET['Report']['type_register'];
            $model->department = $_GET['Report']['department'];
            $model->position = $_GET['Report']['position'];
            $model->period_start = $_GET['Report']['period_start'];
            $model->period_end = $_GET['Report']['period_end'];
        }    

        
        $this->renderPartial('ExcelByLesson', array(
            'model'=>$model
        ));
    }


    public function actionajaxgetlesson(){

        if(isset($_POST["value"]) && $_POST["value"] != ""){

            $Lesson = Lesson::model()->findAll(array(
                'condition' => 'course_id=:course_id AND active=:active ',
                'params' => array(':course_id'=>$_POST["value"], ':active'=>"y"),
                'order' => 'title ASC',
            ));


            ?>
            <option value="">กรุณาบทเรียน</option>
            <?php
            if(!empty($Lesson)){                
                foreach ($Lesson as $key => $value) {
                    ?>
                    <option value="<?= $value->id ?>"><?= $value->title ?></option>
                    <?php
                }
            }

        }
    }    

    public function actionajaxgetlevel(){

        if(isset($_POST["value"]) && $_POST["value"] != ""){

            $Lesson = Branch::model()->findAll(array(
                'condition' => 'course_id=:course_id AND active=:active ',
                'params' => array(':course_id'=>$_POST["value"], ':active'=>"y"),
                'order' => 'title ASC',
            ));


            ?>
            <option value="">กรุณาบทเรียน</option>
            <?php
            if(!empty($Lesson)){                
                foreach ($Lesson as $key => $value) {
                    ?>
                    <option value="<?= $value->id ?>"><?= $value->title ?></option>
                    <?php
                }
            }

        }
    }


    public function actionAttendPrint()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report'])){            
            $model->attributes = $_GET['Report'];

        }
        $this->render('attendprint',array('model'=>$model));
    }

    public function actionByCourseDetail($id=null) { // รายงานการฝึกอบรมหลักสูตร

        $model = new Report();
        $model->unsetAttributes();

        if($id!=null) {
            $model->course_id = $id;
        }

        if(isset($_GET['Report'])) {
           
            $model->course_id = $_GET['Report']['course_id'];
            $model->gen_id = $_GET['Report']['gen_id'];
            $model->search = $_GET['Report']['search'];
            $model->type_register = $_GET['Report']['type_register'];
            $model->department = $_GET['Report']['department'];
            $model->position = $_GET['Report']['position'];
            $model->level = $_GET['Report']['level'];
            $model->period_start = $_GET['Report']['period_start'];
            $model->period_end = $_GET['Report']['period_end'];

        }

        $this->render('ByCourseDetail', array(
            'model' => $model
        ));
    }
























    public function actionIndex()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report'])){
            $model->attributes=$_GET['Report'];
        }

        $this->render('index',array('model'=>$model));
    }

    public function actionTrack()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

        $this->render('track',array('model'=>$model));
    }

    public function actionTrack2()
    {
        $model=new Report('Track');
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

        $this->render('track2',array('model'=>$model));
    }

    public function actionCourse($id=null) {
        $model = new Report('Course');
        $model->unsetAttributes();

        $this->render('course', array('model'=>$model));
    }

    public function actionStatusLearnAllLesson()
    {
        $model=new ReportUser();
        $model->unsetAttributes();
        if(isset($_GET['ReportUser'])){
            $model->attributes=$_GET['ReportUser'];
        }

        $this->render('statusLearnAllLesson',array('model'=>$model));
    }

    public function actionStatusBusiness()
    {
        $model=new ReportUser();
        $model->unsetAttributes();
        if(isset($_GET['ReportUser'])){
            $model->attributes=$_GET['ReportUser'];
        }

        $this->render('statusBusiness',array('model'=>$model));
    }

    public function actionScore()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];
        $this->render('score',array('model'=>$model));
    }
    public function actionIndividual()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];
        $this->render('individual',array('model'=>$model));
    }


    public function actionCoursePass()
    {
        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $lesson = Lesson::model()->findByPk($id);
        if(!empty($lesson)){
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$id);
            $criteria->compare('lesson_status','pass');
            $criteria->compare('active','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Learn::model()->findAll($criteria);
             foreach ($model as $key => $value) {
                if(empty($value->users->employee_id)){
                    $email = $value->users->email;
                    $this->updateEmployeeId($email);
                }
            }
            $this->render('coursePass',array('model'=>$model,'lesson' => $lesson));
        } else {
            $this->render('/site/index');   
        }
    }

    public function actionGenPdfCoursePass(){

        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $lesson = Lesson::model()->findByPk($id);
        if(!empty($lesson)){
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$id);
            $criteria->compare('lesson_status','pass');
            $criteria->compare('active','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Learn::model()->findAll($criteria);

        $renderFile = 'PdfCoursePass';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model,'lesson' => $lesson),true),'UTF-8','UTF-8'));
        $mPDF->Output("PdfCoursePass.pdf" , 'D');

}
}


    public function actionCoursePassAll()
    {
        $schedule_id = $_GET['schedule_id'];
        $course_id = $_GET['id'];
        $course = CourseOnline::model()->findByPk($course_id);
        $criteria = new CDbCriteria;
        $criteria->compare('course_id',$course_id);
        $criteria->compare('active',"y");
        $criteria->compare('parent_id','0');
        $lesson = Lesson::model()->findAll($criteria);
        $lessonCount = count($lesson);
        $userLearnPassCourse = array();
        $userLearnPassLesson = arraY();
        if(!empty($lesson)){
            foreach ($lesson as $key => $value) {
                $criteria = new CDbCriteria;
                $criteria->with = 'les';
                $criteria->compare('t.course_id',$course_id);
                $criteria->compare('t.lesson_id',$value->id);
                $criteria->compare('lesson_status','pass');
                $criteria->compare('t.active','y');
                $criteria->compare('lesson.active',"y");
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
                $modelLearn = Learn::model()->findAll($criteria);

                foreach ($modelLearn as $key => $valuePass) {
                    $userLearnPassLesson[] = $valuePass->user_id;
                }
            }
            foreach (array_count_values($userLearnPassLesson) as $key => $value) {
                if($value == $lessonCount)$userLearnPassCourse[] = $key;
            }
            
            $criteria = new CDbCriteria;
            $criteria->addIncondition('user_id',$userLearnPassCourse);
            $model = User::model()->findAll($criteria);
            foreach ($model as $key => $value) {
                if(empty($value->employee_id)){
                    $email = $value->email;
                    $this->updateEmployeeId($email);
                }
            }
            $this->render('coursePassAll',array('model'=>$model,'course' => $course,'title'=>$course->course_title));
        } else {
            $this->render('/site/index');   
        }
    }

      public function actionGenPdfCoursePassAll(){

          $schedule_id = $_GET['schedule_id'];
        $course_id = $_GET['id'];
        $course = CourseOnline::model()->findByPk($course_id);
        $criteria = new CDbCriteria;
        $criteria->compare('course_id',$course_id);
        $criteria->compare('active',"y");
        $criteria->compare('parent_id','0');
        $lesson = Lesson::model()->findAll($criteria);
        $lessonCount = count($lesson);
        $userLearnPassCourse = array();
        $userLearnPassLesson = arraY();
        if(!empty($lesson)){
            foreach ($lesson as $key => $value) {
                $criteria = new CDbCriteria;
                $criteria->with = 'les';
                $criteria->compare('t.course_id',$course_id);
                $criteria->compare('t.lesson_id',$value->id);
                $criteria->compare('lesson_status','pass');
                $criteria->compare('t.active','y');
                $criteria->compare('lesson.active',"y");
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
                $modelLearn = Learn::model()->findAll($criteria);

                foreach ($modelLearn as $key => $valuePass) {
                    $userLearnPassLesson[] = $valuePass->user_id;
                }
            }
            foreach (array_count_values($userLearnPassLesson) as $key => $value) {
                if($value == $lessonCount)$userLearnPassCourse[] = $key;
            }
            
            $criteria = new CDbCriteria;
            $criteria->addIncondition('user_id',$userLearnPassCourse);
            $model = User::model()->findAll($criteria);

        $renderFile = 'PdfCoursePassAll';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model,'lesson' => $lesson,'title'=>$course->course_title),true),'UTF-8','UTF-8'));
        $mPDF->Output($course->course_title.".pdf" , 'D');
        // $mPDF->Output(".pdf", 'D');

}
}


    private function updateEmployeeId($email){
        $member = Helpers::lib()->ldapTms($email);
        // $member['count'] = 0;
        if($member['count'] > 0){
            $modelUser = Users::model()->findByAttributes(array('email'=>$email,'del_status' => '0'));
            if($member[0]['description']['count'] > 0){
                $modelUser->employee_id = $member[0]['description'][0]; //Employee id
                $modelUser->save(false);
            }
        }
    }

    public function actionCourseLearning()
    {
        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $lesson = Lesson::model()->findByPk($id);
        if(!empty($lesson)){
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$id);
            $criteria->compare('lesson_status','learning');
            $criteria->compare('active','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Learn::model()->findAll($criteria);
             foreach ($model as $key => $value) {
                if(empty($value->users->employee_id)){
                    $email = $value->users->email;
                    $this->updateEmployeeId($email);
                }
            }
            $this->render('courseLearning',array('model'=>$model,'lesson' => $lesson));
        } else {
            $this->render('/site/index');   
        }
    }

      public function actionGenPdfCourseLearning(){

        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $lesson = Lesson::model()->findByPk($id);
        if(!empty($lesson)){
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$id);
            $criteria->compare('lesson_status','learning');
            $criteria->compare('active','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Learn::model()->findAll($criteria);

        $renderFile = 'PdfCourseLearning';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model,'lesson' => $lesson),true),'UTF-8','UTF-8'));
        $mPDF->Output("PdfCourseLearning.pdf" , 'D');

}
}

    public function actionRegisterCourse()
    {
        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $lesson = Lesson::model()->findByPk($id);
        if(!empty($lesson)){
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$id);
            $criteria->compare('active','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Learn::model()->findAll($criteria);
            foreach ($model as $key => $value) {
                if(empty($value->users->employee_id)){
                    $email = $value->users->email;
                    $this->updateEmployeeId($email);
                }
            }
           
            $this->render('registercourse',array('model'=>$model,'lesson' => $lesson));
        } else {
            $this->render('/site/index');   
        }
    }

    public function actionGenPdfRegisterCourse(){

      $id = $_GET['id'];
      $schedule_id = $_GET['schedule_id'];
      $lesson = Lesson::model()->findByPk($id);
      if(!empty($lesson)){
        $criteria = new CDbCriteria;
        $criteria->compare('lesson_id',$id);
        $criteria->compare('active','y');
        if(!empty($schedule_id)){
            $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
        }
        $model = Learn::model()->findAll($criteria);

        $renderFile = 'PdfRegisterCourse';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model,'lesson' => $lesson),true),'UTF-8','UTF-8'));
        $mPDF->Output("PdfRegisterCourse.pdf" , 'D');

}
}




    public function actionRegisterCourseTms()
    {
        $id = $_GET['id'];
        $criteria = new CDbCriteria;
        $criteria->compare('schedule_id',$id);
        $model = AuthCourse::model()->findAll($criteria);
        foreach ($model as $key => $value) {
            if(empty($value->user->employee_id)){
                $email = $value->user->email;
                $this->updateEmployeeId($email);
            }
        }
        $this->render('registerCourseTms',array('model'=>$model));
    }

     public function actionGenPdfRegisterCourseTms()
    {
        $id = $_GET['id'];
        $criteria = new CDbCriteria;
        $criteria->compare('schedule_id',$id);
        $model = AuthCourse::model()->findAll($criteria);
        $renderFile = 'PdfRegisterCourseTms';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
        $mPDF->Output("PdfRegisterCourseTms.pdf" , 'D');
        
    }


    public function actionTestScore()
    {
        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $type = $_GET['type'] == 'pass' ? 'y' : 'n';
        $titleName = $type == 'y' ? 'รายงานผู้ผ่านการสอบบทเรียน' : 'รายงานผู้ไม่ผ่านการสอบบทเรียน';
        $lesson = Lesson::model()->findByPk($id);

        if(!empty($lesson)){
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$id);
            $criteria->compare('active','y');
            $criteria->compare('type','post');
            $criteria->compare('score_past','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Score::model()->findAll($criteria);
            if($type == 'n'){
                $arr = array();
                foreach ($model as $key => $value) {
                    $arr[] = $value->user_id;
                }
                $criteria = new CDbCriteria;
                $criteria->compare('lesson_id',$id);
                $criteria->compare('active','y');
                $criteria->compare('type','post');
                $criteria->compare('score_past','n');
                $criteria->addNotInCondition('user_id',$arr);
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
            // $criteria->addNotInCondition('user_id',array("SELECT user_id FROM tbl_score WHERE lesson_id=".$id." AND active='y' AND type='post' AND score_past='y'"));
            // $criteria->addNotInCondition('user_id',array('1','50'));
                $model = Score::model()->findAll($criteria);
            }
            foreach ($model as $key => $value) {
                if(empty($value->user->employee_id)){
                    $email = $value->user->email;
                    $this->updateEmployeeId($email);
                }
            }
            $this->render('testScore',array('model'=>$model,'titleName'=>$titleName,'title'=>$lesson->title));
        } else {
            $this->render('/site/index');   
        }
    }

     public function actionGenPdfTestScore()
    {
        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $type = $_GET['type'] == 'pass' ? 'y' : 'n';
        $titleName = $type == 'y' ? 'รายงานผู้ผ่านการสอบบทเรียน' : 'รายงานผู้ไม่ผ่านการสอบบทเรียน';
        $lesson = Lesson::model()->findByPk($id);

        if(!empty($lesson)){
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$id);
            $criteria->compare('active','y');
            $criteria->compare('type','post');
            $criteria->compare('score_past','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Score::model()->findAll($criteria);
            if($type == 'n'){
                $arr = array();
                foreach ($model as $key => $value) {
                    $arr[] = $value->user_id;
                }
                $criteria = new CDbCriteria;
                $criteria->compare('lesson_id',$id);
                $criteria->compare('active','y');
                $criteria->compare('type','post');
                $criteria->compare('score_past','n');
                $criteria->addNotInCondition('user_id',$arr);
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
            // $criteria->addNotInCondition('user_id',array("SELECT user_id FROM tbl_score WHERE lesson_id=".$id." AND active='y' AND type='post' AND score_past='y'"));
            // $criteria->addNotInCondition('user_id',array('1','50'));
                $model = Score::model()->findAll($criteria);
            }

            $renderFile = 'PdftestScore';
            require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
            $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
            $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model,'titleName'=>$titleName),true),'UTF-8','UTF-8'));
            $mPDF->Output("PdftestScore.pdf" , 'D');
        }
    }

    public function actionTestCourseScore()
    {
        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $type = $_GET['type'] == 'pass' ? 'y' : 'n';
        $titleName = $type == 'y' ? 'รายงานผู้ผ่านการสอบหลักสูตร' : 'รายงานผู้ไม่ผ่านการสอบหลักสูตร';
        $course = CourseOnline::model()->findByPk($id);

        if(!empty($course)){
            $criteria = new CDbCriteria;
            $criteria->compare('course_id',$id);
            $criteria->compare('active','y');
            $criteria->compare('score_past','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Coursescore::model()->findAll($criteria);
            if($type == 'n'){
                $arr = array();
                foreach ($model as $key => $value) {
                    $arr[] = $value->user_id;
                }
                $criteria = new CDbCriteria;
                $criteria->compare('course_id',$id);
                $criteria->compare('active','y');
                $criteria->compare('score_past','n');
                $criteria->addNotInCondition('user_id',$arr);
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
            // $criteria->addNotInCondition('user_id',array("SELECT user_id FROM tbl_score WHERE lesson_id=".$id." AND active='y' AND type='post' AND score_past='y'"));
            // $criteria->addNotInCondition('user_id',array('1','50'));
                $model = Coursescore::model()->findAll($criteria);
            }
             foreach ($model as $key => $value) {
                if(empty($value->user->employee_id)){
                    $email = $value->user->email;
                    $this->updateEmployeeId($email);
                }
            }
            $this->render('notLearn',array('model'=>$model,'titleName'=>$titleName,'title'=>$course->course_title));
        } else {
            $this->render('/site/index');   
        }
    }

       public function actionGenPdfTestCourseScore(){

        $id = $_GET['id'];
        $schedule_id = $_GET['schedule_id'];
        $type = $_GET['type'] == 'pass' ? 'y' : 'n';
        $titleName = $type == 'y' ? 'รายงานผู้ผ่านการสอบหลักสูตร' : 'รายงานผู้ไม่ผ่านการสอบหลักสูตร';
        $course = CourseOnline::model()->findByPk($id);

        if(!empty($course)){
            $criteria = new CDbCriteria;
            $criteria->compare('course_id',$id);
            $criteria->compare('active','y');
            $criteria->compare('score_past','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $model = Coursescore::model()->findAll($criteria);
            if($type == 'n'){
                $arr = array();
                foreach ($model as $key => $value) {
                    $arr[] = $value->user_id;
                }
                $criteria = new CDbCriteria;
                $criteria->compare('course_id',$id);
                $criteria->compare('active','y');
                $criteria->compare('score_past','n');
                $criteria->addNotInCondition('user_id',$arr);
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
                $model = Coursescore::model()->findAll($criteria);
            }
        $renderFile = 'PdfNotLearn';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model,'titleName'=>$titleName,'title'=>$course->course_title,'type'=>$type),true),'UTF-8','UTF-8'));
        $mPDF->Output($course->course_title.".pdf" , 'D');
        // $mPDF->Output(".pdf" , 'D');
    }
}


    public function actionNotLearn()
    {
        $type = $_GET['type'];
        $schedule_id = $type == 'course' ? $_GET['id'] : $_GET['schedule_id'];
        $schedule = Schedule::model()->findByPk($schedule_id);
        if(!empty($schedule)){
            if($type == 'course'){
                $title = $schedule->course->course_title;
                $titleName = 'รายงานผู้ที่ไม่เข้าเรียนหลักสูตร';

                $criteria = new CDbCriteria;
                $criteria->compare('course_id',$schedule->course_id);
                $criteria->compare('active','y');
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
                $criteria->group = 'user_id';
                $learnCourse = Learn::model()->findAll($criteria);
                $allLearnCourse = array();
                foreach ($learnCourse as $key => $value) {
                    if(!in_array($value->user_id, $allLearnCourse))$allLearnCourse[] = $value->user_id;
                }

                $criteria = new CDbCriteria;
                $criteria->compare('schedule_id',$schedule_id);
                $authCourse = AuthCourse::model()->findAll($criteria);
                $model = array();
                foreach ($authCourse as $key => $value) {
                 if(!in_array($value->user_id, $allLearnCourse))$model[] = $value;
             }
         } else if($type == 'lesson'){
            $lesson_id = $_GET['id'];
            $titleName = 'รายงานผู้ที่ไม่เข้าเรียนบทเรียน';
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$lesson_id);
            $criteria->compare('active','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $criteria->group = 'user_id';
            $learnCourse = Learn::model()->findAll($criteria);
            $allLearnCourse = array();
            foreach ($learnCourse as $key => $value) {
                if(!in_array($value->user_id, $allLearnCourse))$allLearnCourse[] = $value->user_id;
            }

            $criteria = new CDbCriteria;
            $criteria->compare('schedule_id',$schedule_id);
            $authCourse = AuthCourse::model()->findAll($criteria);
            $model = array();
            foreach ($authCourse as $key => $value) {
             if(!in_array($value->user_id, $allLearnCourse))$model[] = $value;
         }
     }
     foreach ($model as $key => $value) {
                if(empty($value->user->employee_id)){
                    $email = $value->user->email;
                    $this->updateEmployeeId($email);
                }
            }
     $this->render('notLearn',array('model'=>$model,'titleName'=>$titleName,'title'=>$title,'type'=>'notLearn'));
 } else {
    $this->render('/site/index');   
}
}

    public function actionGenPdfNotLearn()
    {
        $type = $_GET['type'];
        $schedule_id = $type == 'course' ? $_GET['id'] : $_GET['schedule_id'];
        $schedule = Schedule::model()->findByPk($schedule_id);
        if(!empty($schedule)){
            if($type == 'course'){
                $title = $schedule->course->course_title;
                $titleName = 'รายงานผู้ที่ไม่เข้าเรียนหลักสูตร';

                $criteria = new CDbCriteria;
                $criteria->compare('course_id',$schedule->course_id);
                $criteria->compare('active','y');
                if(!empty($schedule_id)){
                    $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
                }
                $criteria->group = 'user_id';
                $learnCourse = Learn::model()->findAll($criteria);
                $allLearnCourse = array();
                foreach ($learnCourse as $key => $value) {
                    if(!in_array($value->user_id, $allLearnCourse))$allLearnCourse[] = $value->user_id;
                }

                $criteria = new CDbCriteria;
                $criteria->compare('schedule_id',$schedule_id);
                $authCourse = AuthCourse::model()->findAll($criteria);
                $model = array();
                foreach ($authCourse as $key => $value) {
                 if(!in_array($value->user_id, $allLearnCourse))$model[] = $value;
             }
         } else if($type == 'lesson'){
            $lesson_id = $_GET['id'];
            $titleName = 'รายงานผู้ที่ไม่เข้าเรียนบทเรียน';
            $criteria = new CDbCriteria;
            $criteria->compare('lesson_id',$lesson_id);
            $criteria->compare('active','y');
            if(!empty($schedule_id)){
                $criteria->addCondition('user_id IN((select user_id from tbl_auth_course where schedule_id='.$schedule_id.'))');
            }
            $criteria->group = 'user_id';
            $learnCourse = Learn::model()->findAll($criteria);
            $allLearnCourse = array();
            foreach ($learnCourse as $key => $value) {
                if(!in_array($value->user_id, $allLearnCourse))$allLearnCourse[] = $value->user_id;
            }

            $criteria = new CDbCriteria;
            $criteria->compare('schedule_id',$schedule_id);
            $authCourse = AuthCourse::model()->findAll($criteria);
            $model = array();
            foreach ($authCourse as $key => $value) {
             if(!in_array($value->user_id, $allLearnCourse))$model[] = $value;
         }
     }

       $renderFile = 'PdfNotLearn';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model,'titleName'=>$titleName),true),'UTF-8','UTF-8'));
        $mPDF->Output("PdfNotLearn.pdf" , 'D');

}
}


public function actionCpdPass()
{
    $model=new ReportUser();
    $model->unsetAttributes();
    if(isset($_GET['ReportUser']))
        $model->attributes=$_GET['ReportUser'];
    $this->render('cpdpass',array('model'=>$model));
}

public function actionSaveChart()
{
    function base64_to_jpeg($base64_string) {
        $data = explode(',', $base64_string);

        return base64_decode($data[1]);
    }

    if(isset($_POST)){
        $save = file_put_contents(Yii::app()->basePath."/../../uploads/".$_POST['name'].".png",base64_to_jpeg($_POST['image_base64']));
        $array = array('msg'=>'success');
        echo json_encode($array);
    }

}

public function actionExportIndex()
{
    $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
    include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'ลำดับ')
    ->setCellValue('B1', 'หลักสูตร/หัวข้อวิชา')
    ->setCellValue('C1', 'จำนวนผู้เรียน')
    ->setCellValue('D1', 'ผ่าน')
    ->setCellValue('E1', 'ไม่ผ่าน')
    ->setCellValue('F1', '%การจบ');

    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);

    $style = array(
        'font' => array('bold' => true, 'size' => 10,),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->applyFromArray($style);


    $model=new Report();
    $model->unsetAttributes();
    if(isset($_GET['Report']))
        $model->attributes=$_GET['Report'];

    $cate_type = array('university'=>1,'company'=>2);
    if($model->typeOfUser != '') {
        $cate_id = '';
        if($model->typeOfUser == 'university'){
            if($model->categoryUniversity != ''){
                $cate_id = $model->categoryUniversity;
            }
        }
        if($model->typeOfUser == 'company'){
            if($model->categoryCompany != ''){
                $cate_id = $model->categoryCompany;
            }
        }

        if($cate_id == '') {
            $course = CourseOnline::model()->with('cates')->findAll(array(
                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                'order' => 'sortOrder'
            ));
        }else{
            $course = CourseOnline::model()->with('cates')->findAll(array(
                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                'order' => 'sortOrder'
            ));
        }
    }else{
        $course = CourseOnline::model()->findAll(array(
            'condition' => 'active = "y"',
            'order' => 'sortOrder'
        ));
    }
    $courseAllCountTotal = 0;
    $coursePassCountTotal = 0;
    $courseAllCount = array();
    $coursePassCount = array();
    $i = 2;
    foreach ($course as $key => $courseItem) {
        $courseTitle[$key] = $courseItem->course_title;
        $courseAllCount[$key] = 0;
        $coursePassCount[$key] = 0;

        if(isset($owner_id)) {
            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
        }else{
            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
        }
        foreach ($lesson as $lessonItem) {
            /** @var Lesson $lessonItem */
            $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
            if($model->typeOfUser == 'university' ) {
                $sqlAll .= " INNER JOIN university ON tbl_users.student_house = university.id ";
            }
            $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
            if($model->typeOfUser == 'university' ) {
                if($model->university != '') {
                    $sqlAll .= " AND university.id = '".$model->university."' ";
                }
            }
            if($model->typeOfUser !='' ) {
                $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
            }

            if($model->dateRang !='' ) {
                list($start,$end) = explode(" - ",$model->dateRang);
                $start = date("Y-d-m",strtotime($start))." 00:00:00";
                $end = date("Y-d-m",strtotime($end))." 23:59:59";
                $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
            }

            $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();

            $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain
            INNER JOIN tbl_users
            ON learnmain.user_id = tbl_users.id";
            if($model->typeOfUser == 'university' ) {
                $sqlPass .= " INNER JOIN university ON tbl_users.student_house = university.id ";
            }
            $sqlPass .= "
            WHERE lesson_id = '".$lessonItem->id."'
            AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')
            AND ((SELECT COUNT(*) FROM tbl_score WHERE lesson_id = learnmain.lesson_id AND user_id = learnmain.user_id AND tbl_score.type='post' AND score_past='y') > 0 OR (SELECT COUNT(*) FROM tbl_manage WHERE id = learnmain.lesson_id AND type='post') = 0)";

            if($model->typeOfUser == 'university' ) {
                if($model->university != '') {
                    $sqlPass .= " AND university.id = '".$model->university."' ";
                }
            }

            if($model->typeOfUser !='' ) {
                $sqlPass .= " AND authitem_name = '" . $model->typeOfUser . "' ";
            }

            if($model->dateRang !='' ) {
                list($start,$end) = explode(" - ",$model->dateRang);
                $start = date("Y-d-m",strtotime($start))." 00:00:00";
                $end = date("Y-d-m",strtotime($end))." 23:59:59";
                $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
            }

            $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();

//                        $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ";
//                        $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
//                        if($model->typeOfUser !='' ) {
//                            $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
//                        }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $lessonItem->title);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $courseAllCount[$key] += $allCount);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $coursePassCount[$key] += $passCount);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $allCount-$passCount);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $passCount/(($allCount==0)?1:$allCount)*100);
            $i++;

        }


        $courseAllCountTotal += $courseAllCount[$key];
        $coursePassCountTotal += $coursePassCount[$key];

    }
//        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, "รวม");
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $courseAllCountTotal);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $coursePassCountTotal);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $courseAllCountTotal-$coursePassCountTotal);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, number_format($coursePassCountTotal/(($courseAllCountTotal==0)?1:$courseAllCountTotal)*100,2));

//        $gdImage = imagecreatefrompng(Yii::app()->basePath.'/../uploads/index.png');

//        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Chart %การจบ');
    $objDrawing->setDescription('Chart %การจบ');
    $objDrawing->setPath(Yii::app()->basePath.'/../uploads/index.png');
//        $objDrawing->setHeight(350);
    $objDrawing->setCoordinates('H1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


    $objPHPExcel->getActiveSheet()->setTitle('ภาพรวมผลการเรียน');

    $objPHPExcel->setActiveSheetIndex(0);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    $strFileName = "ภาพรวมผลการเรียน-".date('YmdHis').".xlsx";
        // We'll be outputting an excel file
    header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
    header('Content-Disposition: attachment; filename="'.$strFileName.'"');

    $objWriter->save("php://output");

}

public function actionExportTrack()
{
    $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
    include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
    $objPHPExcel = new PHPExcel();
    $columnChar = range("C","Z");

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ลำดับ');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'ชื่อ - นามสกุล');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);

    $model=new Report();
    $model->unsetAttributes();
    if(isset($_GET['Report']))
        $model->attributes=$_GET['Report'];

    $cate_type = array('university'=>1,'company'=>2);
    if($model->typeOfUser != '') {
        $cate_id = '';
        if($model->typeOfUser == 'university'){
            if($model->categoryUniversity != ''){
                $cate_id = $model->categoryUniversity;
            }
        }
        if($model->typeOfUser == 'company'){
            if($model->categoryCompany != ''){
                $cate_id = $model->categoryCompany;
            }
        }

        if($cate_id == '') {
            $course = CourseOnline::model()->with('cates')->findAll(array(
                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                'order' => 'sortOrder'
            ));
        }else{
            $course = CourseOnline::model()->with('cates')->findAll(array(
                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                'order' => 'sortOrder'
            ));
        }
    }else{
        $course = CourseOnline::model()->findAll(array(
            'condition' => 'active = "y"',
            'order' => 'sortOrder'
        ));
    }
    $courseAllCountTotal = 0;
    $coursePassCountTotal = 0;
    $courseAllCount = array();
    $coursePassCount = array();

    foreach ($course as $key => $courseItem) {
        $courseTitle[$key] = $courseItem->course_title;
        $courseAllCount[$key] = 0;
        $coursePassCount[$key] = 0;

        if(isset($owner_id)) {
            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
        }else{
            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
        }
        foreach ($lesson as $lessonKey => $lessonItem) {/** @var Lesson $lessonItem */
            $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
            if($model->typeOfUser == 'university') {
                $sqlAll .= " INNER JOIN university ON tbl_users.student_house = university.id ";
            }
            $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
            if($model->typeOfUser == 'university' ) {
                if($model->university != '') {
                    $sqlAll .= " AND university.id = '".$model->university."' ";
                }
            }
            if($model->typeOfUser !='' ) {
                $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
            }
            if($model->dateRang !='' ) {
                list($start,$end) = explode(" - ",$model->dateRang);
                $start = date("Y-d-m",strtotime($start))." 00:00:00";
                $end = date("Y-d-m",strtotime($end))." 23:59:59";
                $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
            }

            $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();

            $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain
            INNER JOIN tbl_users
            ON learnmain.user_id = tbl_users.id";
            if($model->typeOfUser == 'university' ) {
                $sqlPass .= " INNER JOIN university ON tbl_users.student_house = university.id ";
            }
            $sqlPass .="
            WHERE lesson_id = '".$lessonItem->id."'
            AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')";
        /*$sqlPass .="
        WHERE lesson_id = '".$lessonItem->id."'
        AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')
        AND ((SELECT COUNT(*) FROM tbl_score WHERE lesson_id = learnmain.lesson_id AND user_id = learnmain.user_id AND tbl_score.type='post' AND score_past='y') > 0 OR (SELECT COUNT(*) FROM tbl_manage WHERE id = learnmain.lesson_id AND type='post') = 0)";*/

        if($model->typeOfUser == 'university' ) {
            if($model->university != '') {
                $sqlPass .= " AND university.id = '" . $model->university . "' ";
            }
        }

        if($model->typeOfUser !='' ) {
            $sqlPass .= " AND authitem_name = '" . $model->typeOfUser . "' ";
        }

        if($model->dateRang !='' ) {
            list($start,$end) = explode(" - ",$model->dateRang);
            $start = date("Y-d-m",strtotime($start))." 00:00:00";
            $end = date("Y-d-m",strtotime($end))." 23:59:59";
            $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
        }

        $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();

        $courseAllCount[$key] += $allCount;
        $coursePassCount[$key] += $passCount;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnChar[$key].'1', $lessonItem->title);
    }


}

$style = array(
    'font' => array('bold' => true, 'size' => 10,),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
for($i=0;$i<=$key;$i++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnChar[$i])->setWidth(20);
}
$objPHPExcel->getActiveSheet()->getStyle("A1:".$columnChar[$key]."1")->applyFromArray($style);

$learnUser = Learn::model()->findAll(array(
    'select'=>'distinct user_id'
));

$learnUserArray = array();
foreach($learnUser as $user){
    $learnUserArray[] = $user->user_id;
}
$sqlUser = " SELECT *,tbl_users.id AS user_id FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id ";

if($model->typeOfUser == 'university') {
    $sqlUser .= " INNER JOIN university ON tbl_users.student_house = university.id ";
}

$sqlUser .= " WHERE status='1' ";

if(count($learnUserArray) == 0){
    $learnUserArray = array(0);
}

$sqlUser .= " AND user_id IN (".implode(",",$learnUserArray).") ";
//                $sqlUser .= " WHERE status='1' ";

if($model->typeOfUser == 'university' ) {
    if($model->university != '') {
        $sqlUser .= " AND university.id = '".$model->university."' ";
    }
}

if($model->typeOfUser !='' ) {
    $sqlUser .= ' AND authitem_name = "'.$model->typeOfUser.'" ';
}

$user = Yii::app()->db->createCommand($sqlUser)->queryAll();
$orderNumber = 1;
$statusArray = array(
    'pass'=>'ผ่าน',
    'learning'=>'กำลังเรียน',
    'notLearn'=>'ไม่ได้เข้าเรียน',
);
foreach ($user as $userKey => $userItem) {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($userKey+2),$orderNumber++);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($userKey+2),$userItem['firstname']." ".$userItem['lastname']);
    $cate_type = array('university'=>1,'company'=>2);
    if($model->typeOfUser != '') {
        $cate_id = '';
        if($model->typeOfUser == 'university'){
            if($model->categoryUniversity != ''){
                $cate_id = $model->categoryUniversity;
            }
        }
        if($model->typeOfUser == 'company'){
            if($model->categoryCompany != ''){
                $cate_id = $model->categoryCompany;
            }
        }

        if($cate_id == '') {
            $course = CourseOnline::model()->with('cates')->findAll(array(
                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                'order' => 'sortOrder'
            ));
        }else{
            $course = CourseOnline::model()->with('cates')->findAll(array(
                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                'order' => 'sortOrder'
            ));
        }
    }else{
        $course = CourseOnline::model()->findAll(array(
            'condition' => 'active = "y"',
            'order' => 'sortOrder'
        ));
    }

    foreach ($course as $key => $courseItem) {
        if(isset($owner_id)) {
            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
        }else{
            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
        }

        foreach ($lesson as $lessonKey => $lessonItem) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnChar[$key].($userKey+2), $statusArray[Helpers::lib()->checkLessonPassById($lessonItem,$userItem['user_id'],$model->dateRang)]);
        }

    }

}

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Chart เปรียบเทียบจำนวนผู้ที่เรียนผ่านกับเรียนไม่ผ่าน');
$objDrawing->setDescription('Chart เปรียบเทียบจำนวนผู้ที่เรียนผ่านกับเรียนไม่ผ่าน');
$objDrawing->setPath(Yii::app()->basePath.'/../uploads/track.png');
//        $objDrawing->setHeight(350);
$objDrawing->setCoordinates('A'.($userKey+4));
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()->setTitle('รายงานติดตามผลการเรียน');

$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$strFileName = "รายงานติดตามผลการเรียน-".date('YmdHis').".xlsx";
        // We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
header('Content-Disposition: attachment; filename="'.$strFileName.'"');

$objWriter->save("php://output");

}

public function actionByStatus($id=null) {

    $model=new Report('ByStatus');
    $model->unsetAttributes();

    if($id!=null) {
        $model->user_id = $id;
    }

    if(isset($_GET['Status'])) {
        $model->nameSearch = $_GET['Status']['nameSearch'];
        $model->typeuser = $_GET['Status']['typeuser'];
        $model->courseArray = $_GET['Status']['course_id'];
            // $model->attributes = $_POST['Status'];
    }

    $course_id = $_POST['id'];
    if($course_id) {
        $html = '';
        foreach(json_decode($course_id) as $course) {
            $lesson = Lesson::model()->findAll(array(
                'condition' => 'course_id = "' . $course .'" and active = "y"',
            ));
            if($lesson) {
                foreach($lesson as $l) {
                    $html.= '<option value="'. $l['id'] . '">' . $l['title'] . '</option>';
                }
            }
        }
        echo $html;
    } else {
        $this->render('ByStatus', array(
            'model'=>$model
        )
    );
    }            
}


public function actionBeforAndAfter($id=null) {
    $model = new Report();
    $model->unsetAttributes(); 
    if(isset($_GET['Report'])){
        $model->attributes=$_GET['Report'];
    }
    $this->render('BeforAndAfter', array(
        'model' => $model,
    ));
}

public function actionListSchedule(){
    $course_id  = $_POST['course_id'];
    $schedule_id = $_POST['schedule_id'];
    $model = Schedule::model()->findAll(array(
        'condition' => 'course_id=:course_id','order'=>'id',
        'params' => array(':course_id' => $course_id)));
    $data .= '<option value">ทั้งหมด</option>';
    foreach ($model as $key => $value) {
        $data .= '<option value = "'.$value->id.'" '.($schedule_id == $value->id ? 'selected' : '').'>'.$value->schedule_id.' || '.$value->course->course_title.'</option>';
    }
    echo ($data);
}

 public function actionAjaxFindGen(){
        $course_id = $_POST['course_id'];
        $gen_course = CourseGeneration::model()->findAll(array(
            'condition' => 'course_id=:course_id and active=:active',
            'params' => array(':course_id' => $course_id, ':active'=>'y'),
            'order'=>'gen_title ASC',
        ));
        if(!empty($gen_course)){
            foreach ($gen_course as $key => $value) {
                echo "<option value='".$value->gen_id."'>".$value->gen_title."</option>";
            }
        }

    }

public function actionListLesson(){

    $course_id  = $_POST['course_id'];
    $model = Lesson::model()->findAll(array(
        'condition' => 'course_id=:course_id and lang_id = 1 and active = "y"','order'=>'id',
        'params' => array(':course_id' => $course_id)));
    $data .= '<option value">ทั้งหมด</option>';
    foreach ($model as $key => $value) {
        $data .= '<option value = "'.$value->id.'">'.$value->title.'</option>';
    }
    echo ($data);
}

public function actionByPlatform($id=null) {
    $model = new Report('ByPlatform');
    $model->unsetAttributes();

    if($id != null) {
        $model->user_id = $id;
    }

    $this->render('ByPlatform', array(
        'model' => $model,
    ));
}


public function actionByUser() {
    $model = new Report();
    $model->unsetAttributes(); 

    $course_id = $_POST['id'];
    if($course_id) {
        $html = '';
        foreach(json_decode($course_id) as $course) {
            $lesson = Lesson::model()->findAll(array(
                'condition' => 'course_id = "' . $course .'" and active = "y"',
            ));
            if($lesson) {
                foreach($lesson as $l) {
                    $html.= '<option value="'. $l['id'] . '">' . $l['title'] . '</option>';
                }
            }
        }
        echo $html;
    } else {
        $this->render('ByUser', array(
            'model' => $model,
        ));
    }
}

public function actionGenPdfAttendPrint(){
    $model=new ReportUser();
    $model->unsetAttributes();
    if(isset($_GET['ReportUser'])){
        $model->attributes=$_GET['ReportUser'];

        if($_GET['ReportUser']['course']){
            $course = CourseOnline::model()->findByPk($_GET['ReportUser']['course']);
        }
    }

    $renderFile = 'PdfAttendPrint';
        // $mPDF = Yii::app()->ePdf->mpdf('th','A4-L','0','dbhelventhaicax');
        // $mPDF->setDisplayMode('fullpage');
        // $mPDF->setAutoFont();
        // $mPDF->AddPage('L');

        // //$mPDF->WriteHTML($_POST["x"]);
        // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
        // $mPDF->Output("PdfAttendPrint.pdf" , 'D');

    require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
    $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
    if($_GET['ReportUser']['course']){
        $mPDF->Output($course->course_title.".pdf" , 'D');

    }else{
        $mPDF->Output("หลักสูตรทั้งหมด.pdf" , 'D');

    }
}

public function actionGenPdfByCourse(){
    $model = new Report('ByCourse');
    $model->unsetAttributes();

    if($id!=null) {
        $model->course_id = $id;
    }

    if(isset($_GET['Report'])) {
        $model->nameSearch = $_GET['Report']['search'];
        $model->course_id = $_GET['Report']['course_id'];
    }
        // $mPDF = Yii::app()->ePdf->mpdf('th','A4-L','0','dbhelventhaicax');
        // $mPDF->setDisplayMode('fullpage');
        // $mPDF->setAutoFont();
        // $mPDF->AddPage('L');
    $renderFile = 'PdfByCourse';
        // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
        // $mPDF->Output("PdfByCourse.pdf" , 'D');

    require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
    $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
    $mPDF->Output("PdfByCourse.pdf" , 'D');

}





public function actionGenPdfByLesson(){
    $model = new Report();
    $model->unsetAttributes(); 
        // $mPDF = Yii::app()->ePdf->mpdf('th','A4-L','0','dbhelventhaicax');
        // $mPDF->setDisplayMode('fullpage');
        // $mPDF->setAutoFont();
        // $mPDF->AddPage('L');
    $renderFile = 'PdfByLesson';
        // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
        // $mPDF->Output("PdfByLesson.pdf" , 'D');

    require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
    $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
    $mPDF->Output("PdfByLesson.pdf" , 'D');

}


public function actionGenPdfByUser(){
    $model = new Report();
    $model->unsetAttributes(); 
        // $mPDF = Yii::app()->ePdf->mpdf('th','A4-L','0','dbhelventhaicax');
        // $mPDF->setDisplayMode('fullpage');
        // $mPDF->setAutoFont();
        // $mPDF->AddPage('L');
    $renderFile = 'PdfByUser';
        // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
        // $mPDF->Output("PdfByUser.pdf" , 'D');

    require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
    $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
    $mPDF->Output("PdfByUser.pdf" , 'D');
}

public function actionGenExcelByUser(){
    $model = new Report();
    $model->unsetAttributes(); 

     $this->renderPartial('ExcelByUser', array(
            'model'=>$model
        ));
}

public function actionGenPdfBeforeAndAfter(){
    $model = new Report();
    $model->unsetAttributes();
    if(isset($_GET['Report'])){
        $model->attributes=$_GET['Report'];
    }
        // $mPDF = Yii::app()->ePdf->mpdf('th','A4-L','0','dbhelventhaicax');
        // $mPDF->setDisplayMode('fullpage');
        // $mPDF->setAutoFont();
        // $mPDF->AddPage('L');
    $renderFile = 'PdfBeforAndAfter';
        // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
        // $mPDF->Output("PdfBeforAndAfter.pdf" , 'D');

    require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
    $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
    $mPDF->Output("PdfBeforAndAfter.pdf" , 'D');
}


public function actionGenExcelBeforeAndAfter(){
    $model = new Report();
    $model->unsetAttributes();
    if(isset($_GET['Report'])){
        $model->attributes=$_GET['Report'];
    }

   $this->renderPartial('ExcelBeforAndAfter', array(
            'model'=>$model
        ));


}



public  function actionReport_list(){
    $teacher = new CourseTeacher('search');
        $teacher->unsetAttributes();  // clear any default values
        if(isset($_GET['CourseTeacher'])){
            $teacher->attributes=$_GET['CourseTeacher'];
            $schedule_id  = $_GET['CourseTeacher']['schedule_id'];
            if(!empty($schedule_id) && $schedule_id != 'ทั้งหมด'){
                $modelSch  = Schedule::model()->findByAttributes(array('schedule_id'=> $schedule_id));
                $teacher->course_id = $modelSch->course_id;
            }
        }

        $this->render('report_list',array(
          'teacher'=>$teacher,
      ));
    }


    public function actionLogReset()
    {
        if(isset($_GET['Report'])){

            $this->render('logReset', array());
        }   
        $this->render('logReset');     
    }

    public function actionLoadgen()
    {
        if(isset($_POST['course_id']) && $_POST['course_id'] != ""){
            $criteria = new CDbCriteria;
            $criteria->compare('course_id',$_POST['course_id']);
            $criteria->compare('active','y');
            $criteria->order = 'gen_title ASC';
            $gen = CourseGeneration::model()->findAll($criteria);

            if(!empty($gen)){
                echo "<option value=''>กรุณา เลือกรุ่น</option>";
                foreach ($gen as $key => $value) {
                echo "<option value='".$value->gen_id."'>".$value->gen_title."</option>";                    
                }
            }else{
                echo "<option value='0'>ไม่มีรุุ่น</option>";
            }
        }
    }

    public function actionLogAllRegister()
    {
        $model=new ReportUser();
        $model->unsetAttributes();
        if(isset($_GET['ReportUser'])){
            $model->attributes=$_GET['ReportUser'];
        }
        $this->render('logAllRegister',array('model'=>$model));
    }

    public function actionLogRegister()
    {
        $model=new ReportUser();
        $model->unsetAttributes();
        if(isset($_GET['ReportUser'])){
            $model->attributes=$_GET['ReportUser'];
        }
        $this->render('logRegister',array('model'=>$model));
    }
}