<?php

class CoursequestionController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionPreExams($id = null)
    {
        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }
        $isPreTest = Helpers::isPretestState($id);
        $course = CourseOnline::model()->findByPk($id);
        $gen_id = $course->getGenID($course->course_id);

        $que_type = "course";
        if (isset($_GET['type'])) {
            $que_type = $_GET['type']; // pre
        }

        $Coursemanage = Coursemanage::Model()->find(
            "id=:id AND active=:active AND type=:type",
            array("id" => $id, "active" => "y", ":type" => $que_type)
        );

        $Question = Coursequestion::model()->with('choices')->findAll("ques.group_id=:group_id AND choices.choice_answer=:choice_answer", array(
            "group_id" => $Coursemanage->group_id,
            "choice_answer" => 1,
        ));

        if (empty($Question)) { // ถ้าไม่มีช้อย แสดงว่าเป็นข้อเขียน
            $Question = Coursequestion::model()->with('choices')->findAll("ques.group_id=:group_id AND ques_type=3", array(
                "group_id" => $Coursemanage->group_id,
            ));
        }


        if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
            $langId = Yii::app()->session['lang'] = 1;
            Yii::app()->language = 'en';
        } else {
            $langId = Yii::app()->session['lang'];
            Yii::app()->language = (Yii::app()->session['lang'] == 1) ? 'en' : 'th';
        }

        $label = MenuCoursequestion::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if (!$label) {
            $label = MenuCoursequestion::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        $labelCourse = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if (!$labelCourse) {
            $labelCourse = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        if ($Question[0]->ques_type == 3) {

            foreach ($Question as $key => $value) {
                $total_score += $value->max_score;
            }
        } else {
            $total_score = $Coursemanage->manage_row;
        }



        $currentQuiz = TempCourseQuiz::model()->find(array(
            'condition' => "user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type order by id",
            'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $id, ':gen_id' => $gen_id, ':type' => $que_type)
        ));
        // Not found and redirect
        if (!$Coursemanage) {
            Yii::app()->user->setFlash('CheckQues', $label->label_alert_noTest);
            Yii::app()->user->setFlash('class', "error");

            $this->redirect(array(
                "//course/detail/$id",
            ));
        }
        if ($currentQuiz) {
            $this->redirect(array(
                'coursequestion/index',
                'id' => $course->course_id,
                'labelCourse' => $labelCourse,
                'type' => $que_type,
            ));
        } else {
            $this->render('pre_exams', array(
                'type' => $que_type,
                'course' => $course,
                'manage' => $Coursemanage,
                'total_score' => $total_score,
                'label' => $label,
                'labelCourse' => $labelCourse,
            ));
        }
    }

    public function actionIndex($id = null)
    {
        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }

        $que_type = "course";
        if (isset($_GET['type'])) {
            $que_type = $_GET['type']; // pre
        }
        $quesType_ = 2; // เช็คว่ามี ข้อสอบ 3 บรรยาย ไหม
        $type_question = 0; // ประเภทข้อสอบ

        $id = isset($_POST['course_id']) ? $_POST['course_id'] : $id;
        if (Yii::app()->user->id) {
            $course = CourseOnline::model()->findByPk($id);
            $gen_id = $course->getGenID($course->course_id);
            $courseStatus = Helpers::lib()->checkCoursePass($id);

            if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                $langId = Yii::app()->session['lang'] = 1;
                Yii::app()->language = 'en';
            } else {
                $langId = Yii::app()->session['lang'];
                Yii::app()->language = (Yii::app()->session['lang'] == 1) ? 'en' : 'th';
            }

            $label = MenuCoursequestion::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));
            if (!$label) {
                $label = MenuCoursequestion::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                ));
            }

            $labelCourse = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));
            if (!$labelCourse) {
                $labelCourse = MenuCourse::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                ));
            }

            $status_precorse = false;
            $checkHaveCoursePreTest = Helpers::lib()->checkHaveCoursePreTestInManage($course->course_id);
            if ($checkHaveCoursePreTest) {
                $checkHaveScoreCoursePreTest = Helpers::lib()->checkHaveScoreCoursePreTest($course->course_id, $gen_id);
                if ($checkHaveScoreCoursePreTest) {  // true=ไม่มีคะแนน สอบได้   false=มีคะแนน ไม่ต้องสอบละ
                    $status_precorse = true;
                }
            }

            if ($courseStatus == "notPass" && $status_precorse == false) {
                Yii::app()->user->setFlash('CheckQues', $label->label_alert_noPermisTest);
                Yii::app()->user->setFlash('class', "error");
                $this->redirect(array(
                    "//course/detail/$id",
                ));
            } else if ($courseStatus == "pass" || $status_precorse == true) {
                $countCoursemanage = Coursemanage::Model()->count("id=:id AND active=:active AND type=:type", array(
                    "id" => $id,
                    "active" => "y",
                    "type" => $que_type,
                ));

                // Not found and redirect
                if (!$countCoursemanage) {
                    Yii::app()->user->setFlash('CheckQues', $label->label_alert_noTest);
                    Yii::app()->user->setFlash('class', "error");

                    $this->redirect(array(
                        "//course/detail/$id",
                    ));
                }

                if ($que_type == "course") {
                    $que_type = "post";
                }
                $countCoursescore = Coursescore::Model()->count("course_id=:course_id AND user_id=:user_id and active = 'y' AND gen_id=:gen_id AND type=:type", array(
                    "course_id" => $id,
                    "user_id" => Yii::app()->user->id, ':gen_id' => $gen_id, ':type' => $que_type

                ));



                if ($countCoursescore == $course->cate_amount) //สอบครบจำนวนครั้งที่กำหนดไว้
                {
                    $countCoursescorePast = Coursescore::model()->findAll(array(
                        'condition' => ' course_id = "' . $id . '"
                        AND user_id    = "' . Yii::app()->user->id . '"
                        AND score_past = "y" and active = "y"
                        ' . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'",
                    ));

                    if (!empty($countCoursescorePast)) {
                        // Pass
                        Yii::app()->user->setFlash('CheckQues', $label->label_alert_testPass);
                        Yii::app()->user->setFlash('class', "success");

                        $this->redirect(array('//course/detail', 'id' => $id));
                    } else {
                        // Not Pass
                        Yii::app()->user->setFlash('CheckQues', $label->label_alert_testFail);
                        Yii::app()->user->setFlash('class', "error");

                        $this->redirect(array('//course/detail', 'id' => $id));
                    }
                } else {
                    $countCoursescorePast = Coursescore::Model()->count("course_id=:course_id AND user_id=:user_id AND score_past=:score_past  and active = 'y' AND gen_id=:gen_id AND type=:type", array(
                        "course_id" => $id,
                        "user_id" => Yii::app()->user->id,
                        "score_past" => "y", ':gen_id' => $gen_id, ':type' => $que_type
                    ));
                    $chk_passssss = 1;
                    if (!empty($countCoursescorePast) && $chk_passssss == 2) {

                        // Yii::app()->user->setFlash('CheckQues', $label->label_alert_testPass);
                        // Yii::app()->user->setFlash('class', "success");

                        // $this->redirect(array('//course/detail', 'id' => $id));
                    } else {
                        // Config default pass score 60 percent
                        $scorePercent = $course->percen_test;
                        if ($que_type == "post") {
                            $que_type = "course";
                        }

                        $temp_all = TempCourseQuiz::model()->findAll(array(
                            'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                        ));

                        if (!$temp_all) {
                            //สร้างข้อสอบหลักสูตร
                            $this->create_questions($course, $gen_id, $id, $que_type);
                        }

                        if (is_numeric($_POST['actionEvnt'])) {
                            $sql_number = 'AND number = ' . $_POST['actionEvnt'];
                        } else {
                            $sql_number = 'AND status="0"';
                        }

                        $currentQuiz = TempCourseQuiz::model()->find(array(
                            'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND gen_id=:gen_id $sql_number order by id",
                            'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $id, ':gen_id' => $gen_id, ':type' => $que_type)
                        ));

                        if (empty($currentQuiz)) {
                            $currentQuiz = TempCourseQuiz::model()->find(array(
                                'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND gen_id=:gen_id order by id",
                                'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $id, ':gen_id' => $gen_id, ':type' => $que_type)
                            ));
                        }

                        $model = Coursequestion::getTempData($currentQuiz['ques_id']);

                        if (count($model) != null || count($model) != 0) {

                            $chk_byone = ["total" => null, "ans_status" => true, "status" => false];
                            $ChkByOne = ["status" => true, "text_status" => "none"];

                            $update_temp = new TempCourseQuiz();
                            if (isset($_POST['actionEvnt'])) {
                                if (isset($_POST['Choice'])) {

                                    foreach ($_POST['Question_type'] as $question_id => $value) {
                                        $update_temp = TempCourseQuiz::model()->find(array(
                                            'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " and ques_id=" . $question_id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                                        ));
                                        $update_temp->ans_id = json_encode($_POST['Choice'][$question_id]);

                                        //ถ้าหลักสูตรนี้เปิดเฉลยทีละข้อ
                                        $chk_byone =  $this->chkQuestionByOne($course, $update_temp, $update_temp->ans_id);
                                        $ChkByOne = $this->ChkByOne($chk_byone, $update_temp);
                                        if ($ChkByOne["status"] == false) {
                                            continue;
                                        }

                                        $update_temp->status = 1;
                                        $update_temp->update();
                                    }
                                }

                                if (isset($_POST["answer_sort"])) {
                                    $_POST["answer_sort"] = explode(",", $_POST["answer_sort"]);
                                    foreach ($_POST['Question_type'] as $question_id => $value) {
                                        $update_temp = TempCourseQuiz::model()->find(array(
                                            'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " and ques_id=" . $question_id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                                        ));
                                        $update_temp->ans_id = json_encode($_POST["answer_sort"]);
                                        $chk_byone =  $this->chkQuestionByOne($course, $update_temp, $update_temp->ans_id);
                                        $ChkByOne = $this->ChkByOne($chk_byone, $update_temp);
                                        if ($ChkByOne["status"] == false) {
                                            continue;
                                        }

                                        $update_temp->status = 1;
                                        if (!$update_temp->update()) var_dump($update_temp->getErrors());
                                    }
                                }

                                if (isset($_POST['dropdownVal'])) {
                                    foreach ($_POST['Question_type'] as $question_id => $value) {

                                        $update_temp = TempCourseQuiz::model()->find(array(
                                            'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " and ques_id=" . $question_id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                                        ));

                                        $update_temp->ans_id = json_encode($_POST['dropdownVal']);
                                        $chk_byone =  $this->chkQuestionByOne($course, $update_temp, $update_temp->ans_id);
                                        $ChkByOne = $this->ChkByOne($chk_byone, $update_temp);
                                        if ($ChkByOne["status"] == false) {
                                            continue;
                                        }

                                        $update_temp->status = 1;

                                        if (!$update_temp->update()) var_dump($update_temp->getErrors());
                                    }
                                }

                                if (isset($_POST['lecture'])) {
                                    foreach ($_POST['Question_type'] as $question_id => $value) {

                                        $update_temp = TempCourseQuiz::model()->find(array(
                                            'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " and ques_id=" . $question_id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                                        ));
                                        $update_temp->status = 1;
                                        $update_temp->ans_id = $_POST['lecture'];

                                        if (!$update_temp->update()) var_dump($update_temp->getErrors());
                                    }
                                }

                                //===================================== !!! ส่งคำตอบทุกข้อ !!! ===============================================
                                if ($_POST['actionEvnt'] == "save" || $_POST['actionEvnt'] == "timeup") {
                                    if (isset($_GET['type'])) {
                                        $type = $_GET['type'];
                                    } else {
                                        $type = "post";
                                    }

                                    if ($type == "course") {
                                        $type = "post";
                                    }
                                    //save_questions คือ function ส่งคำตอบ
                                    $result_question = $this->save_questions($id, $course, $gen_id, $que_type, $type, $scorePercent, $model, $countCoursescore);

                                    $this->renderPartial('exams_finish', array(
                                        'model' => $model,
                                        'testType' => $type,
                                        'course' => $course,
                                        'temp_all' => $temp_all,
                                        'quesType_' => $result_question['type_question'],
                                        'quesType' => $result_question['quesType_'],
                                        'modelScore' => $result_question['modelScore'],
                                        'label' => $label,
                                        'labelCourse' => $labelCourse
                                    ));
                                } else {
                                    $temp_count = count($temp_all);
                                    if ($_POST['actionEvnt'] == "next") {
                                        $idx = $_POST['idx_now'] + 1;
                                        if ($_POST['idx_now'] == $temp_count) $idx = 1;
                                    } elseif ($_POST['actionEvnt'] == "previous") {
                                        $idx = $_POST['idx_now'] - 1;
                                        if ($_POST['idx_now'] == 1) $idx = $temp_count;
                                    } else {
                                        $idx = $_POST['actionEvnt'];
                                    }

                                    $count_no_select = TempCourseQuiz::model()->count(array(
                                        'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND status='0' AND gen_id=:gen_id order by id",
                                        'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $id, ':gen_id' => $gen_id, ':type' => $que_type)
                                    ));

                                    $last_ques = $count_no_select == 0 ? 1 : 0;
                                    $currentQuiz = $this->getTempQuiz($id, $idx, $gen_id, $que_type);

                                    $ans_course = new LogAnsCourse();
                                    $chk_passquest = false;
                                    $alert_select_ans = false;

                                    if ($course->course_refer == "AnswerByOne") {
                                        $idx = $idx - 1;
                                        if ($_POST['idx_now'] == $temp_count) {
                                            $idx = $temp_count;
                                        }

                                        $Quiz_now = $this->getTempQuiz($id, $idx, $gen_id, $que_type);
                                        if (!empty($Quiz_now)) {
                                            $ans_course = LogAnsCourse::model()->find(["condition" => "temp_id = $Quiz_now->id", "order" => 'id DESC']);
                                        }

                                        if (!empty($ans_course) && ($ans_course->status == "correct" || $ans_course->number == 2)) { //ตรวจสอบว่า ข้อสอบเฉลยทีละข้อ หากตอบถูก($ans_course->status) หรือ ตอบครบ 2 ครั้ง($ans_course->number)ให้แสดงข้อความถัดไป
                                            $chk_passquest = true;
                                        } else if (empty($ans_course) || (!empty($ans_course->status != "correct") && $ans_course->number == 1)) {  //ตรวจสอบว่า ข้อสอบเฉลยทีละข้อ ถ้าไม่เคยตอบ หรือ ตอบผิดในรอบแรกทำการค้างอยู่หน้าเดิม
                                            $currentQuiz = $this->getTempQuiz($id, $idx, $gen_id, $que_type);
                                            $alert_select_ans = true; //ขึ้นข้อสอบเลือกคำตอบ
                                        }

                                        if ($chk_byone['status'] == true) {

                                            if ($ChkByOne['status'] == false && $ChkByOne['text_status'] == "try") {
                                                $chk_passquest = false;
                                            }

                                            if ($ChkByOne['status'] == true && $ChkByOne['text_status'] == "done") {
                                                $chk_passquest = true;
                                            }

                                            $alert_select_ans = false;
                                            $currentQuiz = $this->getTempQuiz($id, $idx, $gen_id, $que_type);
                                        }
                                    }

                                    $model = Coursequestion::getTempData($currentQuiz['ques_id']);

                                    $temp_all = TempCourseQuiz::model()->findAll(array(
                                        'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                                    ));

                                    $countExam = count($temp_all) - $count_no_select;
                                    $this->renderPartial('exams_next', array(
                                        'model' => $model,
                                        'course' => $course,
                                        'temp_all' => $temp_all,
                                        'currentQuiz' => $currentQuiz,
                                        'OneStep_exam' => $chk_byone,
                                        'ans_course' => $ans_course,
                                        'ChkByOne' => $ChkByOne,
                                        'last_ques' => $last_ques,
                                        'countExam' => $countExam,
                                        'label' => $label,
                                        'labelCourse' => $labelCourse,
                                        'chk_passquest' => $chk_passquest,
                                        'alert_select_ans' => $alert_select_ans
                                    ));
                                }
                            } else {

                                $temp_all = TempCourseQuiz::model()->findAll(array(
                                    'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                                ));

                                $count_no_select = TempCourseQuiz::model()->count(array(
                                    'condition' => "user_id=:user_id AND type=:type AND course_id=:course_id AND status='0' AND gen_id=:gen_id order by id",
                                    'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $id, ':gen_id' => $gen_id, ':type' => $que_type)
                                ));
                                $chk_passquest = false;
                                if ($course->course_refer == "AnswerByOne") {
                                    $ans_course = LogAnsCourse::model()->find(["condition" => "temp_id = $currentQuiz->id", "order" => 'id DESC']);
                                    if (!empty($ans_course) && ($ans_course->status == "correct" || $ans_course->number == 2)) {
                                        $chk_passquest = true;
                                    }
                                }

                                $last_ques = $count_no_select == 0 ? 1 : 0;
                                $countExam = count($temp_all) - $count_no_select;

                                $this->render('exams', array(
                                    'model' => $model,
                                    'course' => $course,
                                    'currentQuiz' => $currentQuiz,
                                    'temp_all' => $temp_all,
                                    'time_up' => $temp_all[0]->time_up,
                                    'last_ques' => $last_ques,
                                    'countExam' => $countExam,
                                    'label' => $label,
                                    'labelCourse' => $labelCourse,
                                    'chk_passquest' => $chk_passquest
                                ));
                            }
                        } else {
                            Yii::app()->user->setFlash('CheckQues', $label->label_alert_noTest);
                            Yii::app()->user->setFlash('class', "error");

                            $this->redirect(array(
                                '//course/detail', 'id' => $id
                            ));
                        }
                    }
                }
            } else {
                if (Yii::app()->session['lang'] == 2) {
                    Yii::app()->user->setFlash('CheckQues', $label->label_alert_error);
                } else {
                    Yii::app()->user->setFlash('CheckQues', "error");
                }
                Yii::app()->user->setFlash('class', "error");

                $this->redirect(array('//course/detail', 'id' => $id));
            }
        } else {
            Yii::app()->user->setFlash('regiserror', $label->label_alert_expired);
            Yii::app()->user->setFlash('messages', $label->label_alert_plsLogin);
            $this->redirect(array(
                "//site/index",
            ));
        }
    }

    public function getTempQuiz($id, $idx, $gen_id, $que_type)
    {
        return TempCourseQuiz::model()->find(array(
            'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND number=:number AND gen_id=:gen_id order by id",
            'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $id, ':number' => $idx, ':gen_id' => $gen_id, ':type' => $que_type)
        )); //ข้อสอบข้อถัดไป
    }

    public function actionScore($id)
    {
        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }
        $model = Coursescore::model()->findByPk($id);
        if ($model->user_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('CheckQues', "เกิดข้อผิดพลาด ไม่สามารถตรวจสอบได้");
            $this->redirect(array('//categoryLesson/index'));
        } else {
            $this->render('score', array('model' => $model));
        }
    }

    public function actionScoreAll($id)
    {
        $que_type = "course";
        if (isset($_GET['type'])) {
            $que_type = $_GET['type']; // pre
        }

        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }

        if ($que_type == "course") {
            $que_type = "post";
        }
        $course_model = CourseOnline::model()->findByPk($id);
        $gen_id = $course_model->getGenID($course_model->course_id);
        $model = Coursescore::model()->findAll(array(
            'condition' => 'course_id=' . $id . ' and active = "y" AND user_id=' . Yii::app()->user->id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'",
        ));
        $this->render('scoreAll', array('model' => $model));
    }


    public function loadModel($id)
    {
        $model = Coursequestion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coursequestion-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actiondeleteTemp($lesson_id = null)
    {

        $que_type = "course";
        if (isset($_GET['type'])) {
            $que_type = $_GET['type']; // pre
        }

        $course_model = CourseOnline::model()->findByPk($lesson_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        TempCourseQuiz::model()->deleteAll(array(
            'condition' => "user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type",
            'params' => array(':user_id' => Yii::app()->user->id, ':course_id' => $lesson_id, ':gen_id' => $gen_id, ':type' => $que_type)
        ));
    }
    public function actionSaveTimeExam()
    {
        $que_type = "course";
        if (isset($_GET['type'])) {
            $que_type = $_GET['type']; // pre
        }

        $course_model = CourseOnline::model()->findByPk($_POST['course_id']);
        $gen_id = $course_model->getGenID($course_model->course_id);
        $temp_time_start = TempCourseQuiz::model()->find(array(
            'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $_POST['course_id'] . " and time_start is not null AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
        ));
        if ($temp_time_start) {
            $temp_time_start->time_up = $_POST['time'];
            if ($temp_time_start->update()) {
                $state = 'success';
            } else {
                $state = 'error';
            }
        } else {
            $state = 'error';
        }
        echo $state;
    }

    //สร้างข้อสอบหลักสูตร
    public function create_questions($course, $gen_id, $id, $que_type)
    {
        $manage = new CActiveDataProvider(
            'Coursemanage',
            array(
                'criteria' => array(
                    'condition' => ' id = "' . $id . '" AND active = "y" AND type="' . $que_type . '"'
                )
            )
        );

        foreach ($manage->getData() as $i => $value) {
            $modelQuestion[] = Coursequestion::getLimitData($value['group_id'], $value['manage_row']);
            foreach ($modelQuestion as $key1 => $ques) {
                foreach ($ques as $key2 => $val) {
                    $temp_test = new TempCourseQuiz;
                    $temp_test->user_id = Yii::app()->user->id;
                    $temp_test->course_id = $id;
                    $temp_test->gen_id = $gen_id;
                    $temp_test->group_id = $val['group_id'];
                    $temp_test->ques_id = $val['ques_id'];
                    $temp_test->type = $que_type;
                    $choice = array();
                    $choiceData = array();
                    $choiceData = $val['choices'];
                    $arrType4Answer = array();
                    $Type4Question = array();

                    foreach ($choiceData as $key => $val_choice) {
                        if ($val_choice->choice_type != 'dropdown') {
                            $choice[] = $val_choice->choice_id;
                            // echo 'NO';
                        } else {
                            $ranNumber = rand(1, 10000000);
                            if ($val_choice->choice_answer == 2) {
                                $arrType4Answer[$ranNumber] = $val_choice->choice_id;
                            }
                            if ($val_choice->choice_answer == 1) {
                                $choice[] = $val_choice->choice_id;
                            }
                        }
                    }


                    if ($arrType4Answer) {
                        ksort($arrType4Answer);
                        $choiceA = array();
                        foreach ($arrType4Answer as $key => $arrTypeVal) {
                            $choiceA[] = $arrTypeVal;
                        }
                        $choice = array_merge($choice, $choiceA);
                    }

                    // array_rand($choice); //Random choice

                    $criteria = new CDbCriteria;
                    $criteria->addInCondition('choice_id', $choice);
                    $criteria->order = 'RAND() ';
                    $rand_choice =  Coursechoice::model()->findAll($criteria);
                    $choice_array = [];
                    $num_checkk = 1;
                    $num_check_2 = 0;
                    foreach ($rand_choice as $key => $val_choice) {
                        // $choice_array[] = $val_choice->choice_id;

                        if ($val_choice->choice_answer == 1 && $val_choice->choice_type == 'dropdown') {
                            $choice_array[count($rand_choice) - $num_checkk] = $val_choice->choice_id;
                            $num_checkk++;
                        } else {
                            $choice_array[$num_check_2] = $val_choice->choice_id;
                            $num_check_2++;
                        }
                    }

                    ksort($choice_array);
                    $temp_test->question = json_encode($choice_array);
                    $temp_test->number = $key2 + 1;
                    $temp_test->status = 0;
                    if ($key2 == 0) {
                        $temp_test->time_start = new CDbExpression('NOW()');
                        $temp_test->time_up = $course->time_test * 60;
                    }
                    $temp_test->save();
                }
            }
        }
    }

    //ส่งคำตอบทุกข้อ
    public function save_questions($id, $course, $gen_id, $que_type, $type, $scorePercent, $model, $countCoursescore)
    {
        $modelCoursescore = new Coursescore;
        $modelCoursescore->course_id = $id;
        $modelCoursescore->gen_id = $gen_id;
        $modelCoursescore->type = $type;
        $modelCoursescore->refer_status = $course->course_refer;
        $modelCoursescore->user_id = Yii::app()->user->id;
        $modelCoursescore->save();

        $temp_accept = TempCourseQuiz::model()->findAll(
            array(
                'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
            )
        );
        $countAllCoursequestion = 0;
        $scoreSum = 0;
        if ($_POST['actionEvnt'] == 'timeup') {

            $AllCoursequestion = 0;
            foreach ($temp_accept as $key => $value) {
                $result = 0;
                if ($value->quest->ques_type == 1) {
                    $AllCoursequestion += 1;
                }
                if ($value->quest->ques_type == 6) {
                    $AllCoursequestion += 1;
                } else if ($value->quest->ques_type == 3) {   //textarea
                    $AllCoursequestion += $value->quest->max_score;
                } else if ($value->quest->ques_type == 2) {
                    $AllCoursequestion += 1;
                } else if ($value->quest->ques_type == 4) {
                    $choiceUserAnswerArray = array();
                    if (isset($value->ans_id)) {
                        $choiceUserAnswerArray = json_decode($value->ans_id);
                    }

                    $choiceUserQuestionArray = array();

                    $key_atart = count(json_decode($value->question)) - count($choiceUserAnswerArray);

                    foreach (json_decode($value->question) as $key_q => $value_q) {
                        if ($key_atart <= $key_q) {
                            // var_dump($value_q);
                            $choiceUserQuestionArray[] = Coursechoice::model()->findByPk($value_q);
                        }
                    }
                    foreach ($choiceUserQuestionArray as $key => $value) {
                        $AllCoursequestion += 1;
                    }
                }
            }

            $modelCoursescore->score_number = 0;
            $modelCoursescore->score_total = $AllCoursequestion;
            $modelCoursescore->score_past = 'n';
            $modelCoursescore->update();
            TempCourseQuiz::model()->deleteAll(
                array(
                    'condition' => "user_id=" . Yii::app()->user->id . " and course_id=" . $id . " AND gen_id='" . $gen_id . "' AND type='" . $que_type . "'"
                )
            );
            echo "timeount";
            exit;
        }

        foreach ($temp_accept as $key => $value) {
            $LogAnsCourse = LogAnsCourse::model()->find(array(
                'condition' => 'temp_id = :value_id',
                'params' => array(':value_id' => $value->id),
                'order' => 'id DESC'
            ));

            if (!empty($LogAnsCourse) && $course->course_refer == "AnswerByOne") {
                $status_new = "";
                if ($LogAnsCourse->status == "correct") {
                    $status_new  = $LogAnsCourse->number - 1;
                } else {
                    $status_new  = $LogAnsCourse->number;
                }

                $New_Sum = new SumAnsLogCourse();
                $New_Sum->score_id = $modelCoursescore->score_id;
                $New_Sum->course_id = $LogAnsCourse->course_id;
                $New_Sum->user_id = $LogAnsCourse->user_id;
                $New_Sum->gen_id = $LogAnsCourse->gen_id;
                $New_Sum->quest_id = $LogAnsCourse->quest_id;
                $New_Sum->status = $status_new;
                $New_Sum->create_date = date("Y-m-d H:i:s");
                $New_Sum->save(false);
            }

            LogAnsCourse::model()->deleteAll(array(
                'condition' => 'temp_id = :value_id',
                'params' => array(':value_id' => $value->id),
                'order' => 'id DESC'
            ));

            $result = 0;
            if ($value->quest->ques_type == 1) {
                $countAllCoursequestion += 1;
                $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                    "id" => $value->ques_id,
                ));
                $choiceUserAnswerArray = array();
                if (isset($value->ans_id)) {
                    $choiceUserAnswerArray = json_decode($value->ans_id);
                }

                $choiceCorrect = $coursequestion->choices(array(
                    'condition' => 'choice_answer=1'
                ));

                $choiceCorrectArray = array();
                foreach ($choiceCorrect as $choiceCorrectItem) {
                    $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                }
                sort($choiceUserAnswerArray);
                if ($choiceUserAnswerArray === $choiceCorrectArray) {
                    $scoreSum++;
                    $result = 1;
                }

                if ($course->course_refer != "AnswerByOne") {
                    $this->save_SumAnsLogCourse($modelCoursescore, $value, $result, $course);
                }

                foreach ($coursequestion->choices as $keyChoice => $choice) {
                    // Save Logchoice
                    $modelCourselogchoice = new Courselogchoice;
                    $modelCourselogchoice->course_id = $id; // $_GET ID
                    $modelCourselogchoice->logchoice_select = 1;
                    $modelCourselogchoice->gen_id = $gen_id;
                    $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                    $modelCourselogchoice->choice_id = $choice->choice_id;
                    $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                    $modelCourselogchoice->user_id = Yii::app()->user->id;
                    $modelCourselogchoice->test_type = $type;
                    $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                    $modelCourselogchoice->is_valid_choice = $choice->choice_answer == "1" ? '1' : '0';
                    $modelCourselogchoice->logchoice_answer = (in_array($choice->choice_id, $choiceUserAnswerArray)) ? 1 : 0;
                    // Save Courselogchoice
                    $modelCourselogchoice->save();
                }

                // Save Logques
                $modelCourselogques = new Courselogques;
                $modelCourselogques->course_id = $id; // $_GET ID
                $modelCourselogques->gen_id = $gen_id;
                $modelCourselogques->score_id = $modelCoursescore->score_id;
                $modelCourselogques->ques_id = $value->ques_id;
                $modelCourselogques->user_id = Yii::app()->user->id;
                $modelCourselogques->test_type = $type;
                $modelCourselogques->ques_type = $coursequestion->ques_type;
                $modelCourselogques->result = $result;
                $modelCourselogques->save();

                $type_question = $coursequestion->ques_type;
                if ($coursequestion->ques_type == 3) {
                    $quesType_ = 1;
                }
            }
            if ($value->quest->ques_type == 6) {
                $countAllCoursequestion += 1;
                $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                    "id" => $value->ques_id,
                ));
                $choiceUserAnswerArray = array();
                if (isset($value->ans_id)) {
                    // $choiceUserAnswerArray = json_decode($value->ans_id);
                    $choiceUserAnswerArray = $value->ans_id;
                }

                $choiceCorrect = $coursequestion->choices(array(
                    'condition' => 'choice_answer=1'
                ));

                $choiceCorrectArray = array();
                foreach ($choiceCorrect as $choiceCorrectItem) {
                    $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                }
                // sort($choiceUserAnswerArray);
                $choiceCorrectArray = json_encode($choiceCorrectArray);
                if ($choiceUserAnswerArray === $choiceCorrectArray) {
                    $scoreSum++;
                    $result = 1;
                }

                if ($course->course_refer != "AnswerByOne") {
                    $this->save_SumAnsLogCourse($modelCoursescore, $value, $result, $course);
                }

                foreach ($coursequestion->choices as $keyChoice => $choice) {
                    // Save Logchoice
                    $modelCourselogchoice = new Courselogchoice;
                    $modelCourselogchoice->course_id = $id; // $_GET ID
                    $modelCourselogchoice->logchoice_select = 1;
                    $modelCourselogchoice->gen_id = $gen_id;
                    $modelCourselogchoice->test_type = $type;
                    $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                    $modelCourselogchoice->choice_id = $choice->choice_id;
                    $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                    $modelCourselogchoice->user_id = Yii::app()->user->id;
                    $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                    $modelCourselogchoice->is_valid_choice = $choice->choice_answer == "1" ? '1' : '0';
                    $modelCourselogchoice->logchoice_answer = ($choiceUserAnswerArray === $choiceCorrectArray) ? 1 : 0;
                    // Save Courselogchoice
                    $modelCourselogchoice->save();
                }

                // Save Logques
                $modelCourselogques = new Courselogques;
                $modelCourselogques->course_id = $id; // $_GET ID
                $modelCourselogques->gen_id = $gen_id;
                $modelCourselogques->score_id = $modelCoursescore->score_id;
                $modelCourselogques->ques_id = $value->ques_id;
                $modelCourselogques->user_id = Yii::app()->user->id;
                $modelCourselogques->test_type = $type;
                $modelCourselogques->ques_type = $coursequestion->ques_type;
                $modelCourselogques->result = $result;
                $modelCourselogques->save();

                $type_question = $coursequestion->ques_type;
                if ($coursequestion->ques_type == 3) {
                    $quesType_ = 1;
                }
            } else if ($value->quest->ques_type == 3) {   //textarea
                $countAllCoursequestion += $value->quest->max_score;
                $coursequestion = CourseQuestion::model()->findByPk($value->ques_id);

                $result = 0;
                // Save Logchoice
                $modelCourselogchoice = new Courselogchoice;
                $modelCourselogchoice->course_id = $id; // $_GET ID
                $modelCourselogchoice->logchoice_select = 1;
                $modelCourselogchoice->gen_id = $gen_id;
                $modelCourselogchoice->test_type = $type;
                $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                $modelCourselogchoice->choice_id =  '0';
                $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                $modelCourselogchoice->user_id = Yii::app()->user->id;
                $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                $modelCourselogchoice->is_valid_choice = '0';
                $modelCourselogchoice->logchoice_answer = '0';
                // Save Courselogchoice
                $modelCourselogchoice->save();

                // Save Logques

                $modelCourselogques = new Courselogques;
                $modelCourselogques->course_id = $id; // $_GET ID
                $modelCourselogques->score_id = $modelCoursescore->score_id;
                $modelCourselogques->ques_id = $value->ques_id;
                $modelCourselogques->gen_id = $gen_id;
                $modelCourselogques->user_id = Yii::app()->user->id;
                $modelCourselogques->test_type = $type;
                $modelCourselogques->ques_type = $coursequestion->ques_type;
                $modelCourselogques->result = $result;
                $modelCourselogques->logques_text = $value->ans_id;
                $modelCourselogques->save();

                $type_question = $coursequestion->ques_type;
                if ($coursequestion->ques_type == 3) {
                    $quesType_ = 1;
                }
            } else if ($value->quest->ques_type == 2) {
                $countAllCoursequestion += 1;
                $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                    "id" => $value->ques_id,
                ));
                $choiceUserAnswerArray = array();
                if (isset($value->ans_id)) {
                    $choiceUserAnswerArray = json_decode($value->ans_id);
                }

                $choiceCorrect = $coursequestion->choices(array(
                    'condition' => 'choice_answer=1'
                ));

                $choiceCorrectArray = array();
                foreach ($choiceCorrect as $choiceCorrectItem) {
                    $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                }

                if ($choiceUserAnswerArray === $choiceCorrectArray) {
                    $scoreSum++;
                    $result = 1;
                }
                if ($course->course_refer != "AnswerByOne") {
                    $this->save_SumAnsLogCourse($modelCoursescore, $value, $result, $course);
                }

                foreach ($coursequestion->choices as $keyChoice => $choice) {
                    // Save Logchoice
                    $modelCourselogchoice = new Courselogchoice;
                    $modelCourselogchoice->course_id = $id; // $_GET ID
                    $modelCourselogchoice->gen_id = $gen_id;
                    $modelCourselogchoice->test_type = $type;
                    $modelCourselogchoice->logchoice_select = 1;
                    $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                    $modelCourselogchoice->choice_id = $choice->choice_id;
                    $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                    $modelCourselogchoice->user_id = Yii::app()->user->id;
                    $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                    $modelCourselogchoice->is_valid_choice = $choice->choice_answer == "1" ? '1' : '0';
                    $modelCourselogchoice->logchoice_answer = (in_array($choice->choice_id, $choiceUserAnswerArray)) ? 1 : 0;
                    // Save Courselogchoice
                    $modelCourselogchoice->save();
                }

                // Save Logques
                $modelCourselogques = new Courselogques;
                $modelCourselogques->course_id = $id; // $_GET ID
                $modelCourselogques->gen_id = $gen_id;
                $modelCourselogques->score_id = $modelCoursescore->score_id;
                $modelCourselogques->ques_id = $value->ques_id;
                $modelCourselogques->user_id = Yii::app()->user->id;
                $modelCourselogques->test_type = $type;
                $modelCourselogques->ques_type = $coursequestion->ques_type;
                $modelCourselogques->result = $result;
                $modelCourselogques->save();

                $type_question = $coursequestion->ques_type;
                if ($coursequestion->ques_type == 3) {
                    $quesType_ = 1;
                }
            } else if ($value->quest->ques_type == 4) {
                $countAllCoursequestion += 1;
                $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                    "id" => $value->ques_id,
                ));

                $choiceUserAnswerArray = array();
                if (isset($value->ans_id)) {
                    $choiceUserAnswerArray = json_decode($value->ans_id);
                }

                $choiceUserQuestionArray = array();

                $key_atart = count(json_decode($value->question)) - count($choiceUserAnswerArray);




                foreach (json_decode($value->question) as $key_q => $value_q) {
                    if ($key_atart <= $key_q) {
                        $choiceUserQuestionArray[] = Coursechoice::model()->findByPk($value_q);
                    }
                }


                $choiceCorrectIDs = array();
                $choiceIsQuest = array();
                $checkValue = 0;

                foreach ($choiceUserQuestionArray as $key => $value_c) {
                    $choiceIsQuest[] = $value_c->choice_id;
                    $choiceCorrectID['Anschoice_id'] = $choiceUserAnswerArray[$key];

                    $AnsChoice = $coursequestion->choices(array(
                        'condition' => 'choice_id=' . $choiceUserAnswerArray[$key] .
                            ' AND reference IS NOT NULL '
                    ));

                    if ($AnsChoice) {
                        if ($AnsChoice[0]->reference == $value_c->choice_id) {
                            $checkValue++;
                        }
                    }

                    $choiceCorrectID['checkVal'] = $checkValue;
                    $choiceCorrectIDs[$value_c->choice_id] = $choiceCorrectID;
                }
                //    $this->dump(count($choiceUserAnswerArray)); $this->dump($checkValue);exit;
                if (count($choiceUserAnswerArray) == $checkValue) {
                    $result = 1;
                    $scoreSum++;
                }

                if ($course->course_refer != "AnswerByOne") {
                    $this->save_SumAnsLogCourse($modelCoursescore, $value, $result, $course);
                }

                $quest_score = 0;
                foreach ($coursequestion->choices as $keyChoice => $choice) {

                    $is_valid_choice = 0;
                    $logchoice_answer = 0;

                    $modelCourselogchoice = new Courselogchoice;
                    $modelCourselogchoice->course_id = $id; // $_POST ID
                    $modelCourselogchoice->gen_id = $gen_id;
                    $modelCourselogchoice->logchoice_select = 1;
                    $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                    $modelCourselogchoice->choice_id = $choice->choice_id;
                    $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                    $modelCourselogchoice->user_id = Yii::app()->user->id;
                    $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                    $modelCourselogchoice->test_type = $type;


                    $checkChoice_quest = (in_array($choice->choice_id, $choiceIsQuest)) ? $choice->choice_id : 0;

                    if ($checkChoice_quest != 0) {

                        $logchoice_answer = $choiceCorrectIDs[$checkChoice_quest]['Anschoice_id'];
                        if ($choiceCorrectIDs[$checkChoice_quest]['checkVal'] == 1) {
                            $is_valid_choice = 1;
                            $quest_score++;
                        }
                    }

                    $modelCourselogchoice->logchoice_answer = $logchoice_answer;
                    $modelCourselogchoice->is_valid_choice = $is_valid_choice == 1 ? 1 : 0;
                    // Save Courselogchoice
                    $modelCourselogchoice->save();
                }


                $modelCourselogques = new Courselogques;
                $modelCourselogques->course_id = $id; // $_POST ID
                $modelCourselogques->gen_id = $gen_id;
                $modelCourselogques->score_id = $modelCoursescore->score_id;
                $modelCourselogques->ques_id = $value->ques_id;
                $modelCourselogques->user_id = Yii::app()->user->id;
                $modelCourselogques->test_type = $type;
                $modelCourselogques->ques_type = $coursequestion->ques_type;
                $modelCourselogques->result = $quest_score;
                $modelCourselogques->save();

                $type_question = $coursequestion->ques_type;
                if ($coursequestion->ques_type == 3) {
                    $quesType_ = 1;
                }
            }
        }
        $sumPoint = $scoreSum * 100 / $countAllCoursequestion;
        if ($quesType_ == 1) {
            Coursescore::model()->updateByPk($modelCoursescore->score_id, array(
                'score_number' => $scoreSum,
                'update_date' => date('Y-m-d H:i:s'),
                'score_total' => $countAllCoursequestion,
                'score_past' => 'n',
            ));
        } else {
            Coursescore::model()->updateByPk($modelCoursescore->score_id, array(
                'score_number' => $scoreSum,
                'update_date' => date('Y-m-d H:i:s'),
                'score_total' => $countAllCoursequestion,
                'score_past' => ($sumPoint >= $scorePercent) ? 'y' : 'n',
            ));
        }
        $modelScore = Coursescore::model()->findByPk($modelCoursescore->score_id);
        if ($sumPoint >= $scorePercent && $modelCoursescore->type != "pre") { // สอบ post ถึงจะผ่าน
            $passCoursModel = Passcours::model()->findByAttributes(array(
                'passcours_cates' => $course->cate_id,
                'passcours_user' => Yii::app()->user->id,
                'gen_id' => $gen_id
            ));
            if (!$passCoursModel) {
                $modelPasscours = new Passcours;
                $modelPasscours->passcours_cates = $course->cate_id;
                $modelPasscours->gen_id = $gen_id;
                $modelPasscours->passcours_cours = $course->course_id;
                $modelPasscours->passcours_user = Yii::app()->user->id;
                $modelPasscours->passcours_date = new CDbExpression('NOW()');
                $modelPasscours->save();
            }
            $this->SendMailLearn($course->course_id);  // final ผ่าน ส่ง อีเมล์
        } elseif ($modelCoursescore->type != "pre" && ($countCoursescore + 1) == $course->cate_amount) {
            $this->SendMailLearn($course->course_id); // final สอบครบจำนวน แต่ยังไม่ผ่าน                     
        }
        $this->actiondeleteTemp($id);
        Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id, $course->course_id);
        return [
            'type_question' => $type_question,
            'modelScore' => $modelScore,
            'quesType_' => $quesType_
        ];
    }

    public function save_SumAnsLogCourse($modelCoursescore, $temp, $status, $course)
    {
        $New_Sum = new SumAnsLogCourse();
        $New_Sum->score_id = $modelCoursescore->score_id;
        $New_Sum->course_id = $course->course_id;
        $New_Sum->user_id = $temp->user_id;
        $New_Sum->gen_id = $temp->gen_id;
        $New_Sum->quest_id = $temp->ques_id;
        $New_Sum->status = $status == 1 ? 0 : 1;
        $New_Sum->create_date = date("Y-m-d H:i:s");
        $New_Sum->save(false);
    }

    //เก็บ log การตอบคำถาม
    public function chkQuestionByOne($course, $temp_course, $user_ans)
    {
        $ex_total = null;
        $ex_status = false;
        $ex_ans_status = true;
        $model = LogAnsCourse::model()->findAll(["condition" => "temp_id = $temp_course->id"]);

        if ($course->course_refer == "AnswerByOne") {
            $result = 0;
            $chk_true = LogAnsCourse::model()->findAll(["condition" => "temp_id = $temp_course->id AND status = 'correct'"]);

            if (count($chk_true) > 0) {
                return ["total" => $ex_total, "ans_status" => $ex_ans_status, "status" => $ex_status];
            }

            if (count($model) < 2) {

                //ตอบหลายคำตอบ
                if ($temp_course->quest->ques_type == 1) {
                    $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                        "id" => $temp_course->ques_id,
                    ));
                    $choiceUserAnswerArray = array();
                    if (isset($temp_course->ans_id)) {
                        $choiceUserAnswerArray = json_decode($user_ans);
                    }

                    $choiceCorrect = $coursequestion->choices(array(
                        'condition' => 'choice_answer=1'
                    ));

                    $choiceCorrectArray = array();
                    foreach ($choiceCorrect as $choiceCorrectItem) {
                        $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                    }
                    sort($choiceUserAnswerArray);
                    if ($choiceUserAnswerArray === $choiceCorrectArray) {
                        $result = 1;
                    }

                    $ex_ans_status = $result == 1 ? true : false;
                    $ex_total = 2 - $this->saveCountByOne($model, $temp_course, $user_ans, $choiceCorrectArray, $result);
                    $ex_status = true;
                }

                if ($temp_course->quest->ques_type == 2) {
                    $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                        "id" => $temp_course->ques_id,
                    ));
                    $choiceUserAnswerArray = array();
                    if (isset($temp_course->ans_id)) {
                        $choiceUserAnswerArray = json_decode($user_ans);
                    }

                    $choiceCorrect = $coursequestion->choices(array(
                        'condition' => 'choice_answer=1'
                    ));

                    $choiceCorrectArray = array();
                    foreach ($choiceCorrect as $choiceCorrectItem) {
                        $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                    }

                    if ($choiceUserAnswerArray === $choiceCorrectArray) {
                        $result = 1;
                    }

                    $ex_ans_status = $result == 1 ? true : false;
                    $ex_total = 2 - $this->saveCountByOne($model, $temp_course, $user_ans, $choiceCorrectArray, $result);
                    $ex_status = true;
                }

                if ($temp_course->quest->ques_type == 4) {

                    $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                        "id" => $temp_course->ques_id,
                    ));

                    $choiceUserAnswerArray = array();
                    if (isset($temp_course->ans_id)) {
                        $choiceUserAnswerArray = json_decode($user_ans);
                    }
                    $choiceUserQuestionArray = array();
                    $key_atart = count(json_decode($temp_course->question)) - count($choiceUserAnswerArray);

                    foreach (json_decode($temp_course->question) as $key_q => $value_q) {
                        if ($key_atart <= $key_q) {
                            $choiceUserQuestionArray[] = Coursechoice::model()->findByPk($value_q);
                        }
                    }
                    $choiceCorrectIDs = array();
                    $choiceIsQuest = array();

                    $checkValue = 0;
                    foreach ($choiceUserQuestionArray as $key => $value) {
                        $choiceIsQuest[] = $value->choice_id;
                        $choiceCorrectID['Anschoice_id'] = $choiceUserAnswerArray[$key];

                        $AnsChoice = $coursequestion->choices(array(
                            'condition' => 'choice_id=' . $choiceUserAnswerArray[$key] .
                                ' AND reference IS NOT NULL '
                        ));

                        $ans_true = $coursequestion->choices(array(
                            'condition' => 'reference = ' . $value->choice_id
                        ));

                        if ($ans_true) {
                            $choiceCorrectIDs[] = [$ans_true[0]->reference => $ans_true[0]->choice_id];
                        }

                        if ($AnsChoice) {
                            if ($AnsChoice[0]->reference == $value->choice_id) {
                                $checkValue++;
                            }
                        }
                    }

                    if (count($choiceUserAnswerArray) == $checkValue) {
                        $result = 1;
                    }

                    $ex_ans_status = $result == 1 ? true : false;
                    $ex_total = 2 - $this->saveCountByOne($model, $temp_course, $user_ans, $choiceCorrectIDs, $result);
                    $ex_status = true;
                }

                if ($temp_course->quest->ques_type == 6) {
                    $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                        "id" => $temp_course->ques_id,
                    ));
                    $choiceUserAnswerArray = array();
                    if (isset($temp_course->ans_id)) {
                        $choiceUserAnswerArray = $user_ans;
                    }

                    $choiceCorrect = $coursequestion->choices(array(
                        'condition' => 'choice_answer=1'
                    ));

                    $choiceCorrectArray = array();
                    foreach ($choiceCorrect as $choiceCorrectItem) {
                        $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                    }
                    $choiceCorrectArray = json_encode($choiceCorrectArray);
                    if ($choiceUserAnswerArray === $choiceCorrectArray) {
                        $result = 1;
                    }

                    $ex_ans_status = $result == 1 ? true : false;
                    $ex_total = 2 - $this->saveCountByOne($model, $temp_course, $user_ans, json_decode($choiceCorrectArray), $result);
                    $ex_status = true;
                }
            }
        }

        return ["total" => $ex_total, "ans_status" => $ex_ans_status, "status" => $ex_status];
    }

    public function ChkByOne($chk_byone, $temp)
    {
        $chk = true;
        $text_status = "none";

        if ($chk_byone["status"] = true) {
            $text_status = "done";
            if ($chk_byone["total"] == 0 && $temp->status == 1) {
                $chk  = false;
                $text_status = "none";
            } else {
                if ($chk_byone["total"] == 1 && $chk_byone["ans_status"] == false) {
                    $chk  = false;
                    $text_status = "try";
                }
            }
        }

        return ["status" => $chk, "text_status" => $text_status];
    }

    public function saveCountByOne($model, $temp_course, $choiceUserAnswerArray, $choiceCorrectArray, $result)
    {

        $count_total = count($model) + 1;
        $newLog = new LogAnsCourse();
        $newLog->course_id = $temp_course->course_id;
        $newLog->user_id = $temp_course->user_id;
        $newLog->gen_id = $temp_course->gen_id;
        $newLog->quest_id = $temp_course->ques_id;
        $newLog->answer_choice = $choiceUserAnswerArray;
        if ($result == 1 || $count_total == 2) {
            $newLog->choice_correct = json_encode($choiceCorrectArray);
        }
        $newLog->temp_id = $temp_course->id;
        $newLog->number = $count_total;
        $newLog->status = $result ==  1 ? 'correct' : 'incorrect';
        $newLog->save(false);
        return $count_total;
    }

    public function SendMailLearn($id)
    {

        $user_id = Yii::app()->user->id;
        $modelUser = User::model()->findByPk($user_id);
        $modelCourseName = CourseOnline::model()->findByPk($id);
        $gen_id = $modelCourseName->getGenID($modelCourseName->course_id);
        $criteria = new CDbCriteria;
        $criteria->join = " INNER JOIN `tbl_lesson` AS les ON (les.`id`=t.`lesson_id`)";
        $criteria->compare('t.course_id', $id);
        $criteria->compare('t.gen_id', $gen_id);
        $criteria->compare('t.user_id', $user_id);
        $criteria->compare('lesson_active', 'y');
        $criteria->compare('les.active', 'y');

        $learn = Learn::model()->findAll($criteria);
        $message = $this->renderPartial('_email', array(
            'user_id' => $user_id,
            'modelUser' => $modelUser,
            'modelCourseName' => $modelCourseName,
            'learn' => $learn,
        ), true);
        $to = array();
        $filepath = array();
        //$email_ref = $modelMember->m_ref_email1;
        $to['email'] = $modelUser->email; //'chalermpol.vi@gmail.com';
        // $to['email'] = 'jojo99za@gmail.com';//'chalermpol.vi@gmail.com';
        $to['firstname'] = $modelUser->profile->firstname;
        $to['lastname'] = $modelUser->profile->lastname;
        // $subject = 'ผลการเรียน หลักสูตร  : ' . $modelCourseName->course_title;
        $subject = 'Exams score\ ผลการทดสอบหลักสูตร  : ' . $modelCourseName->course_title;

        if ($message) {
            if (Helpers::lib()->SendMail($to, $subject, $message)) {
                //if(Helpers::lib()->SendMailLearnPass($to, $subject, $message)){
                $model = new LogEmail;
                $model->user_id = $user_id;
                $model->course_id = $id;
                $model->gen_id = $gen_id;
                $model->message = $message;
                if (!$model->save()) var_dump($model->getErrors());
            }
        }
    }

    public function dump($data = "")
    {
        echo "<pre>";
        var_dump($data);
    }
}
