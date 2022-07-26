<?php

class CourseApiMobileController extends Controller
{
    public function init()
    {
        parent::init();

    }
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
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



   

    



  

    public function actionCourseLearnSaveTimeVideo(){
        // var_dump($_POST); 
        if(isset($_POST["time"]) && isset($_POST["file"])){
            $user_id = $_POST["user_id"];
            $file_id = $_POST["file"];
            $gen_id = $_POST["gen_id"];
            $time = $_POST["time"];
            $lesson = $_POST["lesson"];
    
            $lesson_fine_course = Lesson::model()->findByPk($lesson);
    
            $learn_model = Learn::model()->find(array(
                    'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id',
                    'params'=>array(':lesson_id'=>$lesson,':user_id'=>$user_id, ':course_id'=>$lesson_fine_course->course_id, ':gen_id'=>$gen_id),
                ));
    
            $model = LearnFile::model()->find(array(
                'condition'=>'file_id=:file_id AND user_id_file=:user_id AND learn_id=:learn_id AND gen_id=:gen_id AND learn_file_status!="s"',
                'params'=>array(':file_id'=>$file_id,':user_id'=>$user_id, ':gen_id'=>$gen_id, ':learn_id'=>$learn_model->learn_id),
            ));
    
            // var_dump($learn_model); 
            // var_dump($model); exit();
    
            if( $model->learn_file_status == "l" || (is_numeric($model->learn_file_status) && (int)$model->learn_file_status < (int)$time) ){
                $model->learn_file_status = $time;
                $model->save();
                echo "success";
            }else{
                echo (int)$model->learn_file_status." < ".(int)$time;
            }
    
            
        }
    }

    public function actionPrintCertificate($id, $dl = null) {
        // if(Yii::app()->user->id){
        //     Helpers::lib()->getControllerActionId();
        // }
        //get all $_POST data
        $UserId = $_GET["user_id"];
        $PassCoursId = $id;
        $certDetail = CertificateNameRelations::model()->find(array('condition'=>'course_id='.$id));
        //
        $currentUser = User::model()->findByPk($UserId);

        $course_model = CourseOnline::model()->findByPk($id);
        if(isset($_GET['gen']) && $_GET['gen'] != ""){
            $gen_id = $_GET['gen'];
        }else{
            $gen_id = $course_model->getGenID($course_model->course_id);
        }

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
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND passcours_user = "' . $UserId . '" AND gen_id="'.$gen_id.'"',
            )
        );
            if ($model == null) {
                $model = Coursescore::model()->find(array(
                    'condition' => 'course_id= " ' . $PassCoursId . '" AND user_id= "' . $UserId . '" AND gen_id="'.$gen_id.'"'
                ));
            }
        } else {
            $model = Passcours::model()->find(array(
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND passcours_user = "' . $UserId . '" AND gen_id="'.$gen_id.'"',
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
        // if (isset($model->Profiles)) {
        //     switch ($model->Profiles->type_user) {
        //         case '1':
        //         $userAccountCode = null;
        //         break;
        //         case '4':
        //         $userAccountCode = $PrintTypeArray['2']['text'] . ' ' . $PrintTypeArray['2']['id'] . ' ' . $PrintTypeArray['3']['text'] . ' ' . $PrintTypeArray['3']['id'];
        //         break;
        //         default:
        //         $userAccountCode = $PrintTypeArray[$model->Profiles->type_user]['text'] . ' ' . $PrintTypeArray[$model->Profiles->type_user]['id'];
        //         break;
        //     }
        // }

        //get start & end learn date of current course
        $StartDateLearnThisCourse = Learn::model()->with('LessonMapper')->find(array(
            'condition' => 'learn.user_id = ' . $UserId . ' AND learn.course_id = ' . $PassCoursId.' AND gen_id='.$gen_id,
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
        $CourseDatePassModel = Passcours::model()->find(array('condition' => 'passcours_user = '.$UserId.' AND gen_id='.$gen_id." AND passcours_cours='".$PassCoursId."'"));
        $CourseDatePass = $CourseDatePassModel->passcours_date;

        // $CoursePassedModel = Coursescore::model()->find(array(
        //     'condition' => 'user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId . ' AND score_past = "y"',
        //     'order' => 'create_date ASC'
        //     ));
        $CoursePassedModel = Passcours::model()->find(array(
            'condition' => 'passcours_user = ' . $UserId . ' AND passcours_cours = ' . $PassCoursId .' AND gen_id='.$gen_id
        ));

        $num_pass = PasscourseNumber::model()->find(array(
            'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id',
            'params' => array(':course_id'=>$PassCoursId, ':gen_id'=>$gen_id, ':user_id'=>$UserId,),
            'order' => 'id DESC',
        ));
        $num_pass = $num_pass->code_number;
        

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
        $nameSign2 = $model2->sign_title;
        $positionSign2 = $model2->sign_position;

        //position
        // $position_id = $currentUser->position_id;
        // $position = Position::model()->find(array('condition' => 'id = '.$position_id));
        // $position_title = $position->position_title;

        //Company
        $company_id = $currentUser->company_id;
        // if(!empty($company_id)){
        //     $company = Company::model()->find(array('condition' => 'company_id = '.$company_id));
        //     $company_title = $company->company_title;
        // }else{
        //     $company_title =$currentUser->profile->department;
        // }
        // var_dump($certDetail->certificate);exit();

        if($certDetail->certificate->cert_display == '1'){
            $pageFormat = 'P';
        }elseif($certDetail->certificate->cert_display == '3'){
            $pageFormat = 'P';
        } else {
            $pageFormat = 'L';
        }

        $course_model = CourseOnline::model()->findByPk($PassCoursId);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $logStartTime = LogStartcourse::model()->findByAttributes(array('user_id' => $UserId,'course_id'=> $PassCoursId, 'gen_id'=>$gen_id));


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

        $lastPasscourse = Helpers::lib()->PeriodDate($CourseDatePass, true);

        $year_pass = date("y", strtotime($CourseDatePass));

        $format_date_pass = date('jS F Y', strtotime($lastPasscourse));
        $format_date_pass2 = date('d M Y', strtotime($lastPasscourse));


        if ($model) {
            $fulltitle = $currentUser->profile->ProfilesTitle->prof_title ."". $currentUser->profile->firstname . " " . $currentUser->profile->lastname;
            // $identification = $currentUser->profile->identification ;

            if (isset($model->Profiles)) {
                $fulltitle = $model->Profiles->firstname . " " . $model->Profiles->lastname;
                $fulltitle_en =  $model->Profiles->firstname_en . " " . $model->Profiles->lastname_en;
            }
            $setCertificateData = array(
                'fulltitle' => $fulltitle,
                'fulltitle_en' => $fulltitle_en,
                'cert_text' => $certDetail->certificate->cert_text,
                'userAccountCode' => $userAccountCode,
                'courseTitle_en' => (isset($model->CourseOnlines)) ? $model->CourseOnlines->course_title : $model->course_title,
                'coursenumber' => $model->CourseOnlines->course_number,
                'format_date_pass' => $format_date_pass,                
                'format_date_pass2' => $format_date_pass2,                
                'courseCode' => (isset($courseCode)) ? 'รหัสหลักสูตร ' . $courseCode : null,
                'courseAccountHour' => (isset($courseAccountHour)) ? $courseAccountHour : null,
                'courseEtcHour' => (isset($courseEtcHour)) ? $courseEtcHour : null,
                'startLearnDate' => $startDate,
                
                'period' => $period,
                'endDateCourse' => $course_model->course_date_end,

                'endLearnDate' => (isset($model->passcours_date)) ? $model->passcours_date : $model->create_date,
                'courseDatePassOver60Percent' => $CourseDatePass,
                'year_pass' => $year_pass,
                'num_pass' => $num_pass,
                'renderSign' => $renderSign,
                'nameSign' => $nameSign,
                'positionSign' => $positionSign,

                'renderSign2' => $renderSign2,
                'nameSign2' => $nameSign2,
                'positionSign2' => $positionSign2,

                'positionUser' => $position_title,
                'companyUser' => $company_title,

                // 'identification' => $identification,
                'bgPath' => $certDetail->certificate->cert_background,
                'pageFormat' => $pageFormat,
                'pageSide' => $certDetail->certificate->cert_display,
                'user' => $UserId,
                'course' => $course_model->course_id,
                'gen' => $gen_id
            );


            //Print
            // $mPDF = Yii::app()->ePdf->mpdf('th', 'A4-L', '0', 'dbhelvethaicax');
            // $mPDF->setDisplayMode('fullpage');
            // $mPDF->setAutoFont();
            // $mPDF->SetTitle($certDetail->certificate->cert_name);
            // $mPDF->AddPage($pageFormat);

            //encode html for UTF-8 before write to html
            // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model' => $setCertificateData), true), 'UTF-8', 'UTF-8'));
            if($certDetail->certificate->cert_display == '1'){
            $pageFormat = 'P';
        }elseif($certDetail->certificate->cert_display == '3'){
            $pageFormat = 'P';
        }  else {
            $pageFormat = 'L';
        }


            require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
            $mPDF = new \Mpdf\Mpdf(['format' => 'A4-'.$pageFormat]);
            // $mPDF = new \Mpdf\Mpdf(['orientation' => $pageFormat]);
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




}
