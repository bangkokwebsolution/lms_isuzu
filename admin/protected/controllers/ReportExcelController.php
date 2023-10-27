<?php
class ReportExcelController extends Controller
{
    public function init()
    {
        if (Yii::app()->user->id == null) {
            $this->redirect(array('site/index'));
        }
    }

    public $layout = false;

    public function actionAnswerAnalyze()
    {
        if (isset($_GET['Report'])) {
            if (!empty($_GET['Report']['course_id'])) {
                $course = CourseOnline::model()->findByPk($_GET['Report']['course_id']);
                $Cmanage_pre = Coursemanage::model()->find(["condition" => "id = $course->course_id AND active ='y' AND type='pre'"]);
                $Cmanage_post = Coursemanage::model()->find(["condition" => "id = $course->course_id AND active ='y' AND type='course'"]);
                $Coursequestion = [];
        
                if (!empty($Cmanage_post)) {
                    $Coursequestion = Coursequestion::model()->findAll(["condition" => "group_id = $Cmanage_post->group_id "]);
                }
        
                $logstart = LogStartcourse::model()->findAll(["condition" => "course_id = $course->course_id"]);
                $this->render('AnswerAnalyze', array(
                    'course' => $course , 
                    'Cmanage_pre'=>$Cmanage_pre,
                    'Cmanage_post'=>$Cmanage_post,
                    'Coursequestion'=>$Coursequestion,
                    'logstart'=>$logstart
                ));
                exit;
            }
        }
        $this->redirect("site/index");
    }
}
