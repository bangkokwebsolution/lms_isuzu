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



   

    



  

    public function actionCourseLearnSaveTimeVideo()
    {

        // var_dump($_POST);  exit();
        if (isset($_POST["time"]) && isset($_POST["file"])) {
            $user_id = $_POST['user_id'];
            $file_id = $_POST["file"];
            $time = $_POST["current_time"];
            $lesson = $_POST["lesson_id"];

            $lesson2 = Lesson::model()->find(array(
                'condition' => 'id=:id AND active=:active',
                'params' => array(':id' => $lesson, ':active' => 'y'),
            ));

            $chk_start = Helpers::lib()->chk_logstartcourse($lesson2->course_id);

            $lesson_fine_course = Lesson::model()->findByPk($lesson);

            $learn_model = Learn::model()->find(array(
                'condition' => 'lesson_id=:lesson_id AND startcourse_id=:startcourse_id AND user_id=:user_id AND course_id=:course_id ',
                'params' => array(':lesson_id' => $lesson, ':startcourse_id' => $chk_start, ':user_id' => $user_id, ':course_id' => $lesson_fine_course->course_id),
            ));

            $model = LearnFile::model()->find(array(
                'condition' => 'file_id=:file_id AND startcourse_id=:startcourse_id AND user_id_file=:user_id AND learn_id=:learn_id AND learn_file_status!="s"',
                'params' => array(':file_id' => $file_id, ':startcourse_id' => $chk_start, ':user_id' => $user_id, ':learn_id' => $learn_model->learn_id),
            ));

            // var_dump($learn_model); 
            // var_dump($model); exit();

            if ($model->learn_file_status == "l" || (is_numeric($model->learn_file_status) && (int)$model->learn_file_status < (int)$time)) {
                $model->learn_file_status = $time;
                $model->save();
                echo "success";
            } else {
                echo (int)$model->learn_file_status . " < " . (int)$time;
            }
        }
    }

    public function actionPrintCertificate()
    {
        $user_id = $_GET['user_id'];
        $id = $_GET['course_id'];
        $langId = $_GET['lang_id'];

        $chk_start = Helpers::lib()->chk_logstartcourse($id,$user_id);

        //get all $_POST data
        $UserId = $user_id;
        $PassCoursId = $id;

        $certDetail = CertificateNameRelations::model()->find(array('condition' => 'course_id=' . $id));

        $currentlangauge = Language::model()->findByPk($langId);

        if (empty($certDetail)) {
            Yii::app()->user->setFlash('Nocert', 'เกิดข้อผิดพลาด \n กรุณาติดต่อผู้ดูแลระบบ');
            $this->redirect(array('/course/detail/', 'id' => $id));
        }
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
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND startcourse_id="' . $chk_start . '"  AND passcours_user = "' . $UserId . '"',
            ));
            if ($model == null) {
                $model = Coursescore::model()->find(array(
                    'condition' => 'course_id= " ' . $PassCoursId . '" AND startcourse_id="' . $chk_start . '"  AND user_id= "' . $UserId . '"'
                ));
            }
        } else {
            $model = Passcours::model()->find(array(
                'condition' => 'passcours_cours = "' . $PassCoursId . '" AND startcourse_id="' . $chk_start . '"  AND passcours_user = "' . $UserId . '"',
            ));
            if ($model == null) {
                $model = $CourseModel;
            }
        }

        // var_dump($chk_start);exit();

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
            'condition' => 'learn.user_id = ' . $UserId . ' AND startcourse_id="' . $chk_start . '"  AND learn.course_id = ' . $PassCoursId,
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
        $CourseDatePassModel = Passcours::model()->find(array('condition' => 'passcours_user = ' . $UserId . ' AND startcourse_id="' . $chk_start . '" '));
        $CourseDatePass = $CourseDatePassModel->passcours_date;

        // $CoursePassedModel = Coursescore::model()->find(array(
        //     'condition' => 'user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId . ' AND score_past = "y"',
        //     'order' => 'create_date ASC'
        //     ));
        $CoursePassedModel = Passcours::model()->find(array(
            'condition' => 'passcours_user = ' . $UserId . ' AND startcourse_id="' . $chk_start . '"  AND passcours_cours = ' . $PassCoursId
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
        if ($CourseModel->cate_id == 77) {
            $renderFile = 'Eventcertificate';
        } else {
            $renderFile = 'Newcertificate';
        }

        
        $renderSign = $certDetail->certificate->signature->sign_path;
        $nameSign = $certDetail->certificate->signature->sign_title;
        $positionSign = $certDetail->certificate->signature->sign_position;

        // $sign_id2 = $certDetail->certificate->sign_id2; //key
        // $model2 = signature::model()->find(array('condition' => 'sign_id = '.$sign_id2)); //model PK = sign_id2

        // $renderSign2 = $model2->sign_path;
        // $nameSign2 = $model2->sign_title;
        // $positionSign2 = $model2->sign_position;

        //position
        // $position_id = $currentUser->position_id;
        // $position = Position::model()->find(array('condition' => 'id = '.$position_id));
        // $position_title = $position->position_title;

        //Company
        $company_id = $currentUser->company_id;
        if (!empty($company_id)) {
            $company = company::model()->find(array('condition' => 'company_id = ' . $company_id));
            $company_title = $company->company_title;
        } else {
            $company_title = $currentUser->profile->department;
        }
        // var_dump($certDetail->certificate);exit();

        if ($certDetail->certificate->cert_display == '1') {
            $pageFormat = 'P';
        } else {
            $pageFormat = 'L';
        }
        if ($model) {
            // $fulltitle = $currentUser->profile->ProfilesTitle->prof_title ."". $currentUser->profile->firstname . " " . $currentUser->profile->lastname;
            if ($currentlangauge->id == 1) { //EN
                $fulltitle = $currentUser->profile->firstname_en . " " . $currentUser->profile->lastname_en;
            } else {
                $fulltitle = $currentUser->profile->firstname . " " . $currentUser->profile->lastname;
            }

            $identification = $currentUser->profile->identification;

            if (isset($model->Profiles)) {
                // $fulltitle = $model->Profiles->ProfilesTitle->prof_title . $model->Profiles->firstname . " " . $model->Profiles->lastname;
                if ($currentlangauge->id == 1) {
                    $fulltitle = $model->Profiles->firstname_en . " " . $model->Profiles->lastname_en;
                } else {
                    $fulltitle = $model->Profiles->firstname . " " . $model->Profiles->lastname;
                }
            }

            if (isset($model->CourseOnlines)) {
                $courseCer = $model->CourseOnlines;
            } else {
                $courseCer = $model;
            }

            if ($currentlangauge->id == 1) {
                $courseCertitle =  $courseCer->course_title;
            } else {
                $modelParent = CourseOnline::model()->findByAttributes(array('parent_id' => $courseCer->course_id, 'lang_id' => $currentlangauge->id));
                if (empty($modelParent)) {
                    $courseCertitle = $courseCer->course_title;
                } else {
                    $courseCertitle = $modelParent->course_title;
                }
            }
            $setCertificateData = array(
                'fulltitle' => $fulltitle,
                'userAccountCode' => $userAccountCode,
                // 'courseTitle' => (isset($model->CourseOnlines)) ? $model->CourseOnlines->course_title : $model->course_title,
                'courseTitle' => $courseCertitle,
                'courseCode' => (isset($courseCode)) ? 'รหัสหลักสูตร ' . $courseCode : null,
                'courseAccountHour' => (isset($courseAccountHour)) ? $courseAccountHour : null,
                'courseEtcHour' => (isset($courseEtcHour)) ? $courseEtcHour : null,
                'startLearnDate' => $startDate,
                'endLearnDate' => (isset($model->passcours_date)) ? $model->passcours_date : $model->create_date,
                'courseDatePass' => $CourseDatePass,

                'renderSign' => $renderSign,
                'nameSign' => $nameSign,
                'positionSign' => $positionSign,

                // 'renderSign2' => $renderSign2,
                // 'nameSign2' => $nameSign2,
                // 'positionSign2' => $positionSign2,

                'positionUser' => $position_title,
                'companyUser' => $company_title,

                'identification' => $identification,
                'bgPath' => $certDetail->certificate->cert_background,
                'pageFormat' => $pageFormat,
                'pageSide' => $certDetail->certificate->cert_display,
                'hr_name' => $certDetail->certificate->cert_hr_fullname,
                'hr_position' => $certDetail->certificate->cert_hr_position,
                'langId' => $langId,



                'qr_user' => Yii::app()->user->id,
                'qr_course' => $courseCer->course_id,
                'qr_chk_start' => $chk_start,

            );

            // var_dump($certDetail->certificate->cert_background);exit();

            //Print
            // $mPDF = Yii::app()->ePdf->mpdf('th', 'A4-L', '0', 'dbhelvethaicax');
            // $mPDF->setDisplayMode('fullpage');
            // $mPDF->setAutoFont();
            // $mPDF->SetTitle($certDetail->certificate->cert_name);
            // $mPDF->AddPage($pageFormat);

            // //encode html for UTF-8 before write to html
            // $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model' => $setCertificateData), true), 'UTF-8', 'UTF-8'));
            require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
            $mPDF = new \Mpdf\Mpdf(['format' => 'A4-' . $pageFormat]);

            // $mPDF = Yii::app()->ePdf->mpdf('th', 'A4-L', '0', 'dbhelvethaicax');
            $mPDF->setDisplayMode('fullpage');
            $mPDF->autoLangToFont = true;
            $mPDF->SetTitle($certDetail->certificate->cert_name);

            $mPDF->showImageErrors = false;
            //$mPDF->setAutoFont();
            $mPDF->AddPage($pageFormat);
            //encode html for UTF-8 before write to html
            $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model' => $setCertificateData), true), 'UTF-8', 'UTF-8'));

            //output
            if (isset($model->passcours_id) or isset($model->score_id)) {
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
