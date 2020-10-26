<style>
    html {
      scroll-behavior: smooth;
  }
  header .navbar{
    position: inherit !important;
}
.header-page{
    margin: 0px 00px 20px !important;
}
.text-success{
    color: #3c763d;
}
.text-danger{
    color: rgb(232, 42, 37);
}

</style>

<?php 
$course_wait_cer = 1; // สถานะ 1=พิมใบ cer ได้    2=มีข้อสอบบรรยายรอตรวจ พิมไม่ได้
$themeBaseUrl = Yii::app()->theme->baseUrl;
$uploadFolder = Yii::app()->getUploadUrl("lesson");
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
    $statusEdu = "Study status";
    $lastStatus = "Recent study status";
    $failStudy = "Still not passing the condition";
    $successStudy = "You have passed the conditions";
    $Period = "Period";
    $day = "day";
    $Questionnaire = "Questionnaire ";
    $Click = "Click";
    $final = "Final";
    $clickFinal = "Final test";
    $click_precourse = "Pre test";
    $pre_course = "Pre Test Course";
    $pre_course_wait = "Wait for inspection...";


}else{  
    $langId = Yii::app()->session['lang'];
    $flag = false;
    $statusEdu = "สถานนะการเรียน";
    $lastStatus = "ไปยังสถานะเรียนล่าสุด";
    $failStudy = "ท่านยังเรียนไม่ผ่านตามเงื่อนไข";
    $successStudy = "ท่านเรียนผ่านตามเงื่อนไข";
    $Period = "ระยะเวลา";
    $day = "วัน";
    $Questionnaire = "แบบสอบถาม ";
    $Click = "คลิก";
    $final = "การสอบวัดผล";
    $pre_course = "การสอบก่อนเรียนหลักสูตร";
    $click_precourse = "เข้าสู่การสอบ";
    $clickFinal = "เข้าสู่การสอบ";
    $pre_course_wait = "รอตรวจสอบ...";


    
    $courseChildren = CourseOnline::model()->find(array('condition' => 'parent_id = ' . $course->course_id));
    if($courseChildren){
        $course->course_title = $courseChildren->course_title;
        $course->course_detail = $courseChildren->course_detail;
    }  
}

$course_model = CourseOnline::model()->findByPk($course->course_id);
$gen_id = $course_model->getGenID($course_model->course_id);

function Cuttime($date){
    $strYear = date("Y", strtotime($date)) + 543;
    $strMonth = date("n", strtotime($date));
    $strDay = date("j", strtotime($date));
    $strHour= date("H",strtotime($date));
    $strMinute= date("i",strtotime($date));
    $strSeconds= date("s",strtotime($date));
    $strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay / $strMonthThai / $strYear";
}
?>

<?php 
$criteria = new CDbCriteria;
// $criteria->with = 'LessonLearn';
$criteria->compare('active','y');
// $criteria->compare('t.course_id',$course->course_id);
$criteria->compare('course_id',$course->course_id);
$criteria->compare('lang_id',1);
// $criteria->compare('lesson_active','y');
$criteria->order = 'lesson_no';
$model = Lesson::model()->findAll($criteria);
$state = true;

if($model){
    foreach ($model as $key => $value) {
        $checkLessonPass = Helpers::lib()->checkLessonPass($value);
        $isChecklesson = Helpers::Checkparentlesson($value->id);

        $checkPreTest = Helpers::checkHavePreTestInManage($value->id);
        $checkPostTest = Helpers::checkHavePostTestInManage($value->id);
        if($isChecklesson){
            if($state){
                if($checkLessonPass == 'notLearn'){
                    $stopId = $value->id;
                    $state = false;
                    $msg_step = UserModule::t('goto_lesson').': '.$value->title;
                }else if($checkLessonPass == 'learning'){
                    $stopId = $value->id;
                    $state = false;
                    $msg_step = UserModule::t('learning_lesson').': '.$value->title;
                }else{
                    $state = true;
                }

                if($checkPostTest){
                    $isPostTest = Helpers::isPosttestState($value->id); //true = ยังไมได้ทำข้อสอบหลังเรียน,false = ทำข้อสอบหลังเรียนแล้ว
                    if($isPostTest){
                     $stopId = $value->id;
                     $state = false;
                     $msg_step = UserModule::t('learning_lesson').': '.$value->title;
                 }else{
                    $criteria = new CDbCriteria;
                    $criteria->condition = ' lesson_id="' . $value->id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y" AND score_past = "y" AND type = "post"'." AND gen_id='".$gen_id."'";
                    $criteria->order = 'create_date ASC';
                    $BestFinalTestScore = Score::model()->findAll($criteria);
                    if(!$BestFinalTestScore){
                        $stopId = $value->id;
                        $msg_step = UserModule::t('learning_lesson').': '.$value->title;
                        $state = false;
                    }else{
                        $state = true;
                    }
                }
            }
        }  
        }else{ //No sort
            if($state){
                $stopId = $value->sequence_id;
                $state = false;
                $msg_step = UserModule::t('goto_lesson').': '.$value->lessonParent->title;
            }
        }
    }
}


    if(empty($stopId)){ //All pass
        // $stopId = $model[count($model)-1]->id;
        $stopId = '';
        $msg_step = $label->label_startTestCourse;
    }
    if(!empty($_GET['lid'])){
        $stopId = $_GET['lid'];
    }
    $criteria = new CDbCriteria;
    $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y" AND score_past = "y"'." AND gen_id='".$gen_id."'".' AND type="post"';
    $criteria->order = 'create_date ASC';
    $FinalScore = Coursescore::model()->findAll($criteria);
    ?>
    <!-- Alert -->
    <?php if(empty($FinalScore) && empty($_GET['lid'])){ ?>
        <script type="text/javascript">
    // $(document).ready(function() {
    //     ////state learning
    //     // swal({
    //     //     title: "<?= $label->label_swal_warning; ?>",
    //     //     text: "<?= $msg_step; ?>",
    //     //     icon: "warning",
    //     //     dangerMode: true,
    //     // });
    // });
</script>
<?php } ?>

<?php if(!empty($_GET['msg'])){ ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "แจ้งเตือน",
            text: "<?= $_GET['msg'] ?>",
            icon: "warning",
            dangerMode: true,
        });
        $(document).ready(function() {
            window.history.replaceState( {} , 'msg', '<?= $this->createUrl('site/index') ?>' );
        } );
    </script>
<?php } ?>
<link href="<?php echo $themeBaseUrl; ?>/plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<script src="<?php echo $themeBaseUrl; ?>/plugins/video-js/video.js"></script>
<script type="text/javascript">
    function getDuration(id){

    var myVideoPlayer = document.getElementById('video_player'+id);
    var duration = myVideoPlayer.duration;
    var time = '';

    var lang = "<?= Yii::app()->session['lang']?>";

    if(lang == 1 ){
        var leng = 'Length';
        var min = 'Minutes';
    }else{  
        var leng = 'ความยาว';
        var min = 'นาที';
    }

    if(!isNaN(duration)){
        var sec_num = parseInt(duration);
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);
        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        time = '<i class="far fa-clock"></i> '+hours+':'+minutes+':'+seconds+' '+min;
    } 
    $("#lblduration-"+id).html(time);
}
</script>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $label->label_course; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $course->course_title ?> <?= $course->getGen($course->course_id); ?></li>
        </ol>
    </nav>
</div>

<div class="course-detail-main">
 <div class="container">
<!--     <?php
    // $this->renderPartial('menu-steps', array(
    //     'course'=>$course,
    //     'stepActivate'=>$stepActivate,
    //     'lessonList'=>$lessonList,
    //     'label'=>$label,
    //     'course_type'=>$course_type,
    //));
?> -->
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
     <div class="course-active" id="sticker">
       <div class="card">
           <div class="card-body" align="center">
               <div class="mb-3">
                <?php if($course->course_picture != null) {?>
                    <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $course->course_id ?>/thumb/<?= $course->course_picture?>" class="w-100 ">
                <?php }else{ ?>
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png" class="w-100 ">
                <?php } ?>
            </div>
            <?php 
            $lessonModel = Lesson::model()->findAllByAttributes(array(
                'active' => 'y',
                'lang_id' => '1',
                'course_id' => $course->course_id
            ));

            $percent_learn_net = 0;
            foreach ($lessonModel as $key => $lessonListStatus) {
                $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListStatus, 0);
                $checkPostTest = Helpers::checkHavePostTestInManage($lessonListStatus->id);
                $lessonStatus = Helpers::lib()->checkLessonPass($lessonListStatus);

                if ($checkPostTest) {
                    $isPostTest = Helpers::isPosttestState($lessonListStatus->id);
                    if ($lessonStatus == 'pass') {
                        if ($isPostTest) {
                            $percent_learn = $checkLessonPass->percent - 10;    
                        } else {
                            $percent_learn = $checkLessonPass->percent;
                        }
                    } else {
                        $percent_learn = $checkLessonPass->percent;
                    }
                } else {
                    $percent_learn = $checkLessonPass->percent;
                }
                $percent_learn_net += $percent_learn;
            }

            $percent_learn_net = count($lessonModel) > 0 ? $percent_learn_net/count($lessonModel) : 0;

            ?>

            <h4 class="text-left"><?= $statusEdu?></h4>
            <div class="progress" style="height: 8px;">
                <!-- <div class="progress-bar" role="progressbar" style="width: <?=$percent_learn_net ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> -->
                <div class="progress-bar" role="progressbar" style="width: <?= Helpers::lib()->percent_CourseGen($course->course_id, $gen_id) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <!-- <h5 class="text-muted text-left"><?=$percent_learn_net ?>%</h5> -->
            <h5 class="text-muted text-left"><?= Helpers::lib()->percent_CourseGen($course->course_id, $gen_id) ?>%</h5>

            <div class="mt-10"> <a href="#tab-content" onclick = "$('#change_tab2').click();" class="btn btn-success"><?=$lastStatus?></a></div>
            <!--old-->
            <!-- <?php if($checkLessonPass->status != "pass") {?>
                <div class="certificate-check">
                    <a href="#"> <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/cer-warning.png"></a>
                </div>
                <h4 style="margin-top:25px;"><?=$failStudy?></h4>
            <?php }else{?>
                <div class="certificate-check">
                    <a href="<?= $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id,'langId'=>1)); ?>"> <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/cer-success.png"></a>
                </div>
                <h4 style="margin-top:25px;"><?=$successStudy?></h4>
                <?php } ?>  -->

                <?php 
                $category = Category::model()->findByPk($course->cate_id);
                $checkCourseTest = Helpers::lib()->checkCoursePass($course->course_id);
                $checkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
                $checkHaveCoursePreTest = Helpers::lib()->checkHaveCoursePreTestInManage($course->course_id);
                $criteria = new CDbCriteria;
                $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y"'." AND gen_id='".$gen_id."'".' AND type="post"';
                $criteria->order = 'create_date ASC';
                $BestFinalTestScore = Coursescore::model()->findAll($criteria);

                if($checkHaveCourseTest && $checkCourseTest == 'pass'){
                    $allPassed = true;
                    if($BestFinalTestScore) {
                        foreach($BestFinalTestScore as $time => $FinalTest) {
                            if($FinalTest->score_past == 'n' && $allPassed) {
                                $allPassed = false;
                            }
                            if($FinalTest->score_past == 'y') {
                                $allPassed = true;
                            }

                        }
                    }else{
                       $allPassed = false;
                   }
               } else if($checkCourseTest == 'pass'){
                $allPassed = true;
            }

            $pathPassed_Onclick = '';
            $statePrintCert = false;
            $disBtn = '';

            $can_print_cer = 2;
            $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
            if($CourseSurvey){ // มี แบบสอบถาม
                foreach ($CourseSurvey as $key => $value) {
                     $num_step++; 
                     $passQuest = QQuestAns_course::model()->find(array(
                        'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $course->course_id . '"'." AND gen_id='".$gen_id."'",
                    ));
                     if ($passQuest) { //ตอบแบบสอบถามแล้ว
                        $can_print_cer = 1;
                     }
                 }
             }else{
                        $can_print_cer = 1;                
             }


            if($allPassed && $can_print_cer == 1 && $course_wait_cer == 1 && Helpers::lib()->percent_CourseGen($course->course_id, $gen_id) == 100){
               $certDetail = CertificateNameRelations::model()->find(array('condition'=>'course_id='.$course->course_id));
               if(empty($certDetail)){
                   $pathPassed = 'javascript:void(0);';
                   $pathPassed_Onclick = 'onClick="alertswalNocert()"';
               }else{
                $targetBlank = 'target="_blank"';
                $statePrintCert = true;
                $pathPassed = $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id,'langId'=>1));
            }

            $certFaStat = 'text-success';
            $img_tophy = Yii::app()->theme->baseUrl."/images/cer-success.png";
        } else {
        //$pathPassed = $this->createUrl('/course/final', array('id' => $course->course_id));
            $pathPassed = 'javascript:void(0);';
            $certFaStat = 'text-muted';
            $certEvnt = 'onclick="alertswalcert()"';
            $img_tophy = Yii::app()->theme->baseUrl."/images/cer-warning.png";
            $disBtn = 'disabled';
        }

        ?>
        <?php 
        $CheckHaveCer = Helpers::lib()->CheckHaveCer($course->course_id);
        if($CheckHaveCer){ 
            ?>
            <div class="certificate-check">

                <a href="<?php echo $pathPassed; ?>" <?= $pathPassed_Onclick; ?> <?php echo $targetBlank." ".$certEvnt; ?>>
                    <div class="text-center">
                        <i class="" aria-hidden="true"><img src="<?=$img_tophy?>"></i>
                        <p><?= $label->label_printCert ?></p>
                    </div>
                </a>
                
            </div>
        <?php } ?>
        <?php //} ?>
    </div>
</div>
</div>
</div>


<div class="col-sm-8 col-md-8 col-xs-12">

    <div class="topic-course">
        <h3><?= $course->course_title ?> <?= $course->getGen($course->course_id); ?></h3>
        <div class="alert alert-warning mt-20" role="alert">
            <?=$Period?> <?=$course->course_day_learn?> <?=$day?> <?= (!empty($course))? "(".Helpers::lib()->CuttimeLang($course->course_date_start,$langId)." - ".Helpers::lib()->CuttimeLang($course->course_date_end,$langId).")":""; ?>
        </div>
    </div>

    <div class="course-detail">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#course-info" aria-controls="course-info" role="tab" data-toggle="tab"><?php echo $label->label_detail; ?></a>
                </li>
                <li role="presentation">
                    <a href="#course-unit" aria-controls="course-unit" role="tab" id="change_tab2" data-toggle="tab"><?php echo $label->label_Content; ?></a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" id="tab-content">
                <div role="tabpanel" class="tab-pane active" id="course-info">
                    <li class="list-group-item">

                        <?php echo htmlspecialchars_decode($course->course_detail); ?>

                    </li>
                </div>
                <div role="tabpanel" class="tab-pane" id="course-unit">
                    <ol class="course-ol">
                        <div class="panel panel-default">
                            <?php 
                            $can_next_step = 1; //เรียนได้
                            if($checkHaveCoursePreTest){ // เช็คมีข้อสอบ สอบก่อนเรียน ของหลักสูตร
                                ?>
                                <div class="panel-heading headcourse final-test">
                                    <a role="button" data-toggle="collapse" data-target="#collapsePreCourse" data-parent="#accordion" aria-expanded="true">
                                       <li>
                                        <span class="stepcourse"> <?= $checkHaveCoursePreTest ? $pre_course : ''; ?> <?= $course->course_title ?> <?= $course->getGen($course->course_id); ?></span>
                                        <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                    </li>
                                </a>
                            </div>


<?php 
$checkHaveScoreCoursePreTest = Helpers::lib()->checkHaveScoreCoursePreTest($course->course_id, $gen_id);
if($checkHaveScoreCoursePreTest){ //ยังไม่สอบ ไม่มีคะแนน
    $can_next_step = 2; //ห้ามเรียน ห้ามสอบ ห้ามทุกอย่าง
    $pathCourseTest = $this->createUrl('coursequestion/preexams', array('id' => $course->course_id, 'type'=>'pre'));
    ?>
    <div id="collapsePreCourse" class="collapse in">
     <li class="list-group-item ">
        <a href="<?= $pathCourseTest ?>" <?= $alertCourseTest ?> >
            <span class="list__course"><?php echo $label->label_testPre; ?></span>
            <span class="btn btn-warning detailmore pull-right"><?php echo $label->label_DoTest; ?>
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
        </li>
    </div>
    <?php
}else{ //มีคะแนนสอบ
    $ScoreCoursePreTest = Helpers::lib()->ScoreCoursePreTest($course->course_id, $gen_id);
    $CheckPreTestAnsTextAreaCourse = Helpers::lib()->CheckPreTestAnsTextAreaCourse($course->course_id, "pre");
?>
<div id="collapsePreCourse" class="collapse" style="height: 0px;">
    <?php 
    if($CheckPreTestAnsTextAreaCourse){
        ?>
        <li class="list-group-item ">
         <a href="">
            <span class="list__course"><?php echo $label->label_testPre; ?></span>
            <span class="pull-right  text-danger prepost">
                <?= $ScoreCoursePreTest; ?>
                <?= $label->label_point; ?></span>
            </a> 
        </li>
        <?php
    }else{
        $course_wait_cer = 2;
        ?>
        <li class="list-group-item ">
         <a href="">
            <span class="list__course"><?php echo $label->label_testPre; ?></span>
            <span class="pull-right  text-danger prepost"><?= $label->label_course_wait; ?></span>
        </a> 
    </li>
    <?php
}

     ?>


    
</div>
<?php
} //if($checkHaveScoreCoursePreTest)
} //if($checkHaveCoursePreTest) 
?>












                            <?php                                         
                            foreach ($lessonList as $key => $lessonListValue) {
                             if(!$flag){
                                $lessonListChildren  = Lesson::model()->find(array('condition' => 'parent_id = ' . $lessonListValue->id, 'order' => 'lesson_no'));
                                if($lessonListChildren){
                                    $lessonListValue->title = $lessonListChildren->title;
                                    $lessonListValue->description = $lessonListChildren->description;
                                    $lessonListValue->content = $lessonListChildren->content;
                                    $lessonListValue->image = $lessonListChildren->image;
                                }

                            }

                            // var_dump($lessonListValue);
                            $idx = 1;
                            $checkPreTest = Helpers::checkHavePreTestInManage($lessonListValue->id);

                            $checkPostTest = Helpers::checkHavePostTestInManage($lessonListValue->id);
                                                    // var_dump($checkPostTest);exit();
                            $lessonStatus = Helpers::lib()->checkLessonPass($lessonListValue);

                            $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListValue);

                            $postStatus = Helpers::lib()->CheckTest($lessonListValue, "post");
                                                    // var_dump($postStatus);
                            $chk_test_type = Helpers::lib()->CheckTestCount('pass', $lessonListValue->id, true, false, "post");
                            $isChecklesson = Helpers::lib()->Checkparentlesson($lessonListValue->id);

                            ?>

                            <?php 
                            if ($checkLessonPass->status == "notLearn") {
                                $colorTab = 'listlearn-danger';
                                $lessonStatusStr = $label->label_notLearn;
                            } else if ($checkLessonPass->status == "learning") {
                                $colorTab = 'listlearn-warning';
                                $lessonStatusStr = $label->label_learning;
                            } else if ($checkLessonPass->status == "pass") {
                                $colorTab = 'listlearn-success';
                                                        // $lessonStatusStr = $label->label_lessonPass;
                                $lessonStatusStr =  $label->label_learnPass;
                            }

                            // var_dump($label->label_learning);

                            $step = 0;
                            if($lessonListValue->id == $stopId){
                             $step =  Helpers::lib()->checkStepLesson($lessonListValue);
                                                           // var_dump($step);
                                                    }else if(empty($stopId)){ //step to course test
                                                        $criteria = new CDbCriteria;
                                                        $criteria->compare('active','y');
                                                        $criteria->compare('user_id',Yii::app()->user->id);
                                                        $criteria->compare('course_id',$course->course_id);
                                                        $criteria->compare('gen_id',$gen_id);
                                                        $criteria->compare('type','post');
                                                        $scoreCourse = Coursescore::model()->findAll($criteria);
                                                        $status_courseTest = array();
                                                        foreach ($scoreCourse as $key => $value) {
                                                            $status_courseTest[] = $value->score_past;
                                                        }
                                                        if(in_array("y", $status_courseTest)){

                                                            $step = 5;
                                                        }else if(count($scoreCourse) == $course->cate_amount){
                                                            $step = 4;
                                                        }else{ //ยังไม่ผ่านแต่มีสิทธสอบ
                                                            $step = 4;
                                                        }
                                                    }
                                                    ?>

                                                    <div class="panel-heading headcourse <?php //echo $colorTab; ?>" role="tab" id="lessonId<?= $lessonListValue->id; ?>">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $lessonListValue->id ?>" aria-expanded="true" aria-controls="collapseOne">

                                                            <?php 
                                                            $idLesson_img = (!$flag)? $lessonListChildren->id: $lessonListValue->id;
                                                            $uploadDir = Yii::app()->baseUrl . '/uploads/lesson/' . $idLesson_img . '/thumb/';
                                                            $filename = $lessonListValue->image;
                                                            $filename = $uploadDir . $filename;

                                                            ?> 
                                                            <li id="collapseles<?= $lessonListValue->id ?>">
                                                                <?php if($lessonListValue->image != ""){ ?>
                                                                    <img src="<?= $filename; ?>" class="img-rounded" alt="" style=" width:70px; height:50px;">
                                                                <?php } ?>
                                                                <span class="title__course">
                                                                    <?= $lessonListValue->title ?> 
                                                                </span>
                                                                <label style="color: <?= $checkLessonPass->color ?>" class="<?= $checkLessonPass->class ?>"><?= $lessonStatusStr ?></label>
                                                                <span class="pull-right"><i class="fa fa-angle-down"></i></span>

                                                            </li>
                                                        </a>
                                                    </div>
                                                    
                                                    <div class="panel-collapse collapse <?= ($lessonListValue->id == $stopId && $can_next_step != 2)? 'in':'' ?>" id="collapse-<?= $lessonListValue->id ?>" role="tabpanel" aria-labelledby="headingOne">
                                                        <?php if ($checkPreTest) { ?>
                                                            <div class="stepcoursediv">
                                                               <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_testPre; ?></div></div>
                                                               <ul class="list-group">
                                                                <?php

                                                                $isPreTest = Helpers::isPretestState($lessonListValue->id);

                                                                if($isChecklesson && $can_next_step  != 2){
                                                                    $ckLinkTest = $this->createUrl('/question/preexams', array('id' => $lessonListValue->id,'type'=>'pre'));
                                                                    $ckLinkTest_onClick = '';
                                                                }else{
                                                                    $ckLinkTest = 'javascript:void(0);';
                                                                    $ckLinkTest_onClick = 'onclick="alertSequence();"';
                                                                }

                                                                if ($isPreTest) { // สอบ pre 1 ครั้ง แล้ว ไม่เข้า
                                                                    $prelearn = false;
                                                                    ?>
                                                                    <li class="list-group-item">
                                                                        <?php if($step == 1){ ?>
                                                                            <!-- <div class="pt-now"> You are here</div> -->
                                                                        <?php } ?>
                                                                        <?php echo $label->label_testPre; ?>  <span class="pull-right"><!-- <a href="<?php echo $this->createUrl('/question/preexams', array('id' => $lessonListValue->id,'type'=>'pre')); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"> -->
                                                                            <a href="<?= $ckLinkTest; ?>" 
                                                                                <?= $ckLinkTest_onClick; ?> class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true">
                                                                                </i> <?php echo $label->label_DoTest; ?></a></span></li>
                                                                                <?php
                                                                } else { //Pre Test // สอบ pre 1 ครั้ง แล้ว เข้านี่
                                                                    $prelearn = true;
                                                                    // $flagPreTestPass = false;
                                                                    $flagPreTestPass = true;
                                                                    $criteriaScoreAll = new CDbCriteria;
                                                                    $criteriaScoreAll->condition = ' type = "pre" AND lesson_id="' . $lessonListValue->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"'." AND gen_id='".$gen_id."'";
                                                                    $scoreAll = Score::model()->findAll($criteriaScoreAll);
                                                                    foreach ($scoreAll as $keyx => $score_ck) {
                                                                    // $preStatus = Helpers::lib()->CheckTest($lessonListValue, "pre");
                                                                        if($score_ck->score_past == 'y'){
                                                                            $flagPreTestPass = true;
                                                                            $colorText = 'text-success';
                                                                        } else {
                                                                            $colorText = 'text-danger';
                                                                        }
                                                                        $preStatus = Helpers::lib()->CheckTestAll($lessonListValue, "pre",$score_ck);


                                                                        $CheckPreTestAnsTextAreaLesson = Helpers::lib()->CheckPreTestAnsTextAreaLesson($lessonListValue, "pre");

                                                                        if($CheckPreTestAnsTextAreaLesson){

                                                                            ?>
                                                                            <li class="list-group-item">
                                                                                <?php echo $label->label_resultTestPre; ?> <?= $keyx+1; ?><span class="pull-right <?= $colorText; ?> prepost"> <?= $preStatus->value['score']; ?>/<?= $preStatus->value['total']; ?> <?php echo $label->label_point; ?></span> </li>
                                                                                <?php
                                                                        }else{
                                                                        //ข้อสอบ ก่อนเรียน ของบทเรียน
                                                                            $course_wait_cer = 2;
                                                                            ?>
                                                                            <li class="list-group-item">
                                                                                <?php echo $label->label_resultTestPre; ?> <?= $keyx+1; ?><span class="pull-right <?= $colorText; ?> prepost"> <?= $label->label_course_wait ?> </span> </li>
                                                                                <?php
                                                                            }                                                                        
                                                                    } //end foreach
                                                                }
                                                                ?>
                                                                <?php 
                                                                $pre_test_again = 2; // ไม่ให้โชว์ สอบ pre อีก
                                                                // $lessonListValue->cate_amount = 1;
                                                                if($pre_test_again == 1 && count($scoreAll) < 1 && !$flagPreTestPass && count($scoreAll) != 0 && $can_next_step  != 2){ 
                                                                    ?>
                                                                    <li class="list-group-item">
                                                                        <?php if($step == 1){ ?>
                                                                            <!-- <div class="pt-now"> You are here</div> -->
                                                                        <?php } ?>
                                                                        <?php echo $label->label_testPre; ?> <?= count($scoreAll)+1; ?> <span class="pull-right"><a href="<?php echo $this->createUrl('/question/preexams', array('id' => $lessonListValue->id,'type'=>'pre')); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span></li>
                                                                    <?php } ?>
                                                                    <?php
                                                                } else {
                                                                    $prelearn = true;
                                                                    ?>
                                                                    <!-- <li class="list-group-item">ไม่มีข้อสอบก่อนเรียน</li> -->
                                                                    <?php
                                                                }
                                                                $learnModel = Learn::model()->find(array(
                                                                    'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                                                                    'params'=>array(':lesson_id'=>$lessonListValue->id,':user_id'=>Yii::app()->user->id,':status'=>'y', ':gen_id'=>$gen_id)
                                                                ));
                                                                if($lessonListValue->type == 'vdo'){
                                                                    ?>
                                                                    <div class="stepcoursediv">
                                                                        <div>
                                                                            <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?>
                                                                            </span><?php echo $label->label_gotoLesson; ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    foreach ($lessonListValue->files as $les) {
                                                                        if ($isChecklesson) {
                                                                            if(!$prelearn){
                                                                                $learnlink = 'javascript:void(0);';
                                                                                $learnalert = 'alertswalpretest();';
                                                                            } else{
                                                                                $criteriaPre = new CDbCriteria;
                                                                                $criteriaPre->compare('lesson_id',$lessonListValue->id);
                                                                                $criteriaPre->compare('user_id',Yii::app()->user->id);
                                                                                $criteriaPre->compare('type','pre');
                                                                                $criteriaPre->compare('gen_id', $gen_id);
                                                                                $criteriaPre->compare('active','y');
                                                                                $modelPreScore = Score::model()->findAll($criteriaPre);
                                                                                $flagCheckPre = true;
                                                                                if($modelPreScore){
                                                                                    $checkPrePass = array();
                                                                                    foreach ($modelPreScore as $key => $scorePre) {
                                                                                        $checkPrePass[] = $scorePre->score_past;
                                                                                // if($scorePre->score_past == 'n' && (count($scorePre) < $lessonListValue->cate_amount)){
                                                                                //     $flagCheckPre = true;
                                                                                // }
                                                                                    }
                                                                                    if(!in_array("y", $checkPrePass)){
                                                                                        if(count($modelPreScore) < 1){
                                                                                            $flagCheckPre = false;
                                                                                        }
                                                                                    }
                                                                                // if(count($modelPreScore) == $lessonListValue->cate_amount){
                                                                                //     if(!in_array("y", $checkPrePass)){
                                                                                //         $flagCheckPre = false;
                                                                                //     }
                                                                                // } 
                                                                            // if(in_array("n", $checkPrePass) && count($modelPreScore) < $lessonListValue->cate_amount){
                                                                            //     $flagCheckPre = false;
                                                                            // }else{
                                                                            //     $flagCheckPre = true;
                                                                            // }
                                                                                } 
                                                                                if(!$flagCheckPre){
                                                                                    $learnlink = 'javascript:void(0);';
                                                                                    $learnalert = 'alertswalpretest();';    
                                                                                }elseif ($can_next_step  != 2){
                                                                                    $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
                                                                                    $learnalert = '';    
                                                                                }else{
                                                                                    $learnlink = 'javascript:void(0);';
                                                                                    $learnalert = 'alertswalpretest();';   
                                                                                }
                                                                            }
                                                                        }else{
                                                                            $learnlink = 'javascript:void(0);';
                                                                            $learnalert = 'alertSequence();';
                                                                        }
                                                                        $learnFiles = Helpers::lib()->checkLessonFile($les,$learnModel->learn_id);
                                                                        if ($learnFiles == "notLearn") {
                                                                            $statusValue = '<span class="label label-default" >'.$label->label_notLearn.' </span>';
                                                                        } else if ($learnFiles == "learning") {
                                                                            $statusValue = '<span class="label label-warning" >'. $label->label_learning.'</span>';
                                                                        } else if ($learnFiles == "pass") {
                                                                            $statusValue = '<span class="label label-success" >'.$label->label_learnPass.'</span>';
                                                                        }
                                                                        ?>
                                                                        <!-- <div class="stepcoursediv"> -->
                                                                        <!-- <div>
                                                                                <span class="stepcourse"><?php echo $label->label_step; ?> 
                                                                            </span><?php echo $label->label_gotoLesson; ?>
                                                                        </div> -->
                                                                        <!-- </div> -->
                                                                            <a href="<?=$learnlink?>"  <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                                <li class="list-group-item ">
                                                                                   <?php if($step == 2){ ?>
                                                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                                                <?php } ?>
                                                                                <span class="pull-right">
                                                                                    <span id="lblduration-<?=$les->id?>"></span>  <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                                    <span class="vdocourse list__course"><?= $les->getRefileName() ?> </span>&nbsp;<?=$statusValue?>
                                                                                    <div class="hidden">
                                                                                        <video  id="video_player<?=$les->id?>" width="320" height="240" controls>
                                                                                            <source src="<?php echo $uploadFolder . $les->filename;?>" type="video/mp4">
                                                                                            </video>
                                                                                            <div id="meta"></div>   
                                                                                        </div>
                                                                                    </li>
                                                                                </a> 
                                                                                <script type="text/javascript">
                                                                                   var vid = document.getElementById("video_player"+<?=$les->id?>);
                                                                                   vid.onloadedmetadata = function() {
                                                                                    getDuration(<?=$les->id?>);
                                                                                };
                                                                            </script> 
                                                                            <?php 
                                                                        } 
                                                                    } else if($lessonListValue->type == 'youtube'){
                                                                    ?>
                                                                    <div class="stepcoursediv">
                                                                        <div>
                                                                            <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?>
                                                                            </span><?php echo $label->label_gotoLesson; ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    foreach ($lessonListValue->files as $les) {
                                                                        if ($isChecklesson) {
                                                                            if(!$prelearn){
                                                                                $learnlink = 'javascript:void(0);';
                                                                                $learnalert = 'alertswalpretest();';
                                                                            } else{
                                                                                $criteriaPre = new CDbCriteria;
                                                                                $criteriaPre->compare('lesson_id',$lessonListValue->id);
                                                                                $criteriaPre->compare('user_id',Yii::app()->user->id);
                                                                                $criteriaPre->compare('type','pre');
                                                                                $criteriaPre->compare('gen_id', $gen_id);
                                                                                $criteriaPre->compare('active','y');
                                                                                $modelPreScore = Score::model()->findAll($criteriaPre);
                                                                                $flagCheckPre = true;
                                                                                if($modelPreScore){
                                                                                    $checkPrePass = array();
                                                                                    foreach ($modelPreScore as $key => $scorePre) {
                                                                                        $checkPrePass[] = $scorePre->score_past;
                                                                                    }
                                                                                    if(!in_array("y", $checkPrePass)){
                                                                                        if(count($modelPreScore) < 1){
                                                                                            $flagCheckPre = false;
                                                                                        }
                                                                                    }
                                                                                } 
                                                                                if(!$flagCheckPre){
                                                                                    $learnlink = 'javascript:void(0);';
                                                                                    $learnalert = 'alertswalpretest();';    
                                                                                }elseif ($can_next_step  != 2){
                                                                                    $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
                                                                                    $learnalert = '';    
                                                                                }else{
                                                                                    $learnlink = 'javascript:void(0);';
                                                                                    $learnalert = 'alertswalpretest();';   
                                                                                }
                                                                            }
                                                                        }else{
                                                                            $learnlink = 'javascript:void(0);';
                                                                            $learnalert = 'alertSequence();';
                                                                        }
                                                                        $learnFiles = Helpers::lib()->checkLessonFile($les,$learnModel->learn_id);
                                                                        if ($learnFiles == "notLearn") {
                                                                            $statusValue = '<span class="label label-default" >'.$label->label_notLearn.' </span>';
                                                                        } else if ($learnFiles == "learning") {
                                                                            $statusValue = '<span class="label label-warning" >'. $label->label_learning.'</span>';
                                                                        } else if ($learnFiles == "pass") {
                                                                            $statusValue = '<span class="label label-success" >'.$label->label_learnPass.'</span>';
                                                                        }
                                                                        ?>
                                                                            <a href="<?=$learnlink?>"  <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                                <li class="list-group-item ">
                                                                                <span class="pull-right">
                                                                                    <span id="lblduration-<?=$les->id?>"></span>  <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                                    <span class="vdocourse list__course"><?= $les->getRefileName() ?> </span>&nbsp;<?=$statusValue?>
                                                                                    <div class="hidden">
                                                                                        <video  id="video_player<?=$les->id?>" width="320" height="240" controls>
                                                                                            <source src="<?php echo $les->filename;?>" type="video/mp4">
                                                                                            </video>
                                                                                            <div id="meta"></div>   
                                                                                        </div>
                                                                                    </li>
                                                                                </a> 
                                                                                <script type="text/javascript">
                                                                                   var vid = document.getElementById("video_player"+<?=$les->id?>);
                                                                                   vid.onloadedmetadata = function() {
                                                                                    getDuration(<?=$les->id?>);
                                                                                };
                                                                            </script> 
                                                                            <?php 
                                                                        } 
                                                                    } else if($lessonListValue->type == 'scorm') {
                                                                        foreach ($lessonListValue->fileScorm as $les) {
                                                                            if(!$prelearn){
                                                                                $learnlink = 'javascript:void(0);';
                                                                                $learnalert = 'alertswalpretest();';
                                                                            } elseif ($can_next_step != 2){
                                                                                $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
                                                                                $learnalert = '';    
                                                                            }else{
                                                                                $learnlink = 'javascript:void(0);';
                                                                                $learnalert = 'alertswalpretest();';
                                                                            }
                                                                            $learnFiles = Helpers::lib()->checkLessonFile($les,$learnModel->learn_id);
                                                                            if ($learnFiles == "notLearn") {
                                                                                $statusValue = '<span class="label label-default" >'. $label->label_notLearn .'</span>';
                                                                            } else if ($learnFiles == "learning") {
                                                                                $statusValue = '<span class="label label-warning" >'. $label->label_learning .'</span>';
                                                                            } else if ($learnFiles == "pass") {
                                                                                $statusValue = '<span class="label label-success" >'. $label->label_learnPass .'</span>';
                                                                            }
                                                                            ?>
                                                                            <a href="<?=$learnlink?>"  <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                                <li class="list-group-item ">
                                                                                    <?php if($step == 2){ ?>
                                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                                    <?php } ?>
                                                                                    <span class="pull-right">
                                                                                        <span id="lblduration-<?=$les->id?>"></span>  <span class="label label-default"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                                        <span class="list__course"><?= $les->filename; ?></span>&nbsp;<?=$statusValue?>
                                                                                        <div class="hidden">
                                                                                            <video id="video_player<?=$les->id?>" width="320" height="240" controls>
                                                                                                <source src="<?php echo $uploadFolder . $les->filename;?>" type="video/mp4">
                                                                                                </video>
                                                                                                <div id="meta"></div>   
                                                                                            </div>
                                                                                        </li>
                                                                                    </a>  
                                                                                    <?php 
                                                                                } 
                                                                            } else if($lessonListValue->type == 'audio'){
                                                                                foreach ($lessonListValue->fileAudio as $les) {
                                                                                    if(!$prelearn){
                                                                                        $learnlink = 'javascript:void(0);';
                                                                                        $learnalert = 'alertswalpretest();';
                                                                                    } else{
                                                                                        $criteriaPre = new CDbCriteria;
                                                                                        $criteriaPre->compare('lesson_id',$lessonListValue->id);
                                                                                        $criteriaPre->compare('gen_id',$gen_id);
                                                                                        $criteriaPre->compare('user_id',Yii::app()->user->id);
                                                                                        $criteriaPre->compare('type','pre');
                                                                                        $criteriaPre->compare('active','y');
                                                                                        $modelPreScore = Score::model()->findAll($criteriaPre);
                                                                                        $flagCheckPre = true;
                                                                                        if($modelPreScore){
                                                                                            $checkPrePass = array();
                                                                                            foreach ($modelPreScore as $key => $scorePre) {
                                                                                                $checkPrePass[] = $scorePre->score_past;
                                                                                            }
                                                                                            if(count($modelPreScore) < 1){
                                                                                                if(!in_array("y", $checkPrePass)){
                                                                                                    $flagCheckPre = false;
                                                                                                }
                                                                                            }
                                                                                        }

                                                                                        if(!$flagCheckPre){
                                                                                            $learnlink = 'javascript:void(0);';
                                                                                            $learnalert = 'alertswalpretest();';    
                                                                                        }elseif ($can_next_step != 2){
                                                                                            $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
                                                                                            $learnalert = '';    
                                                                                        }else{
                                                                                            $learnlink = 'javascript:void(0);';
                                                                                            $learnalert = 'alertswalpretest();'; 
                                                                                        }
                                                                                    }
                                                                                    $learnFiles = Helpers::lib()->checkLessonFile($les,$learnModel->learn_id);
                                                                                    if ($learnFiles == "notLearn") {
                                                                                        $statusValue = '<span class="label label-default" >'.$label->label_notLearn.' </span>';
                                                                                    } else if ($learnFiles == "learning") {
                                                                                        $statusValue = '<span class="label label-warning" >'. $label->label_learning.'</span>';
                                                                                    } else if ($learnFiles == "pass") {
                                                                                        $statusValue = '<span class="label label-success" >'.$label->label_learnPass.'</span>';
                                                                                    }
                                                                                    ?>
                                                                                    <div class="stepcoursediv">
                                                                                     <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_gotoLesson; ?></div></div>
                                                                                     <a href="<?=$learnlink?>"  <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                                        <li class="list-group-item">
                                                                                            <?php if($step == 2){ ?>
                                                                                                <!-- <div class="pt-now"> You are here</div> -->
                                                                                            <?php } ?>
                                                                                            <span class="pull-right">
                                                                                                <span id="lblduration-<?=$les->id?>"></span>  <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                                                <span class="vdocourse list__course"><?= $les->getRefileName() ?> </span>&nbsp;<?=$statusValue?>
                                                                                                <div class="hidden">
                                                                                                    <video  id="video_player<?=$les->id?>" width="320" height="240" controls>
                                                                                                        <source src="<?php echo $uploadFolder . $les->filename;?>" type="video/mp4">
                                                                                                        </video>
                                                                                                        <div id="meta"></div>   
                                                                                                    </div>
                                                                                                </li>
                                                                                            </a>  
                                                                                            <?php 
                                                                                        } 
                                                                                    } else if($lessonListValue->type == 'pdf') {
                                                                                        foreach ($lessonListValue->filePdf as $les) {
                                                                                            if ($isChecklesson) {
                                                                                                if(!$prelearn){
                                                                                                    $learnlink = 'javascript:void(0);';
                                                                                                    $learnalert = 'alertswalpretest();';
                                                                                                } elseif ($can_next_step != 2){
                                                                                                    $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'file' => $les->id));
                                                                                                    $learnalert = '';    
                                                                                                }else{
                                                                                                    $learnlink = 'javascript:void(0);';
                                                                                                    $learnalert = 'alertswalpretest();';
                                                                                                }
                                                                                            }else{
                                                                                             $learnlink = 'javascript:void(0);';
                                                                                             $learnalert = 'alertswal();';
                                                                                         }
                                                                                         $learnFiles = Helpers::lib()->checkLessonFile($les,$learnModel->learn_id);
                                                                                         if ($learnFiles == "notLearn") {
                                                                                            $statusValue = '<span class="label label-default" >'.$label->label_notLearn .'</span>';
                                                                                        } else if ($learnFiles == "learning") {
                                                                                            $statusValue = '<span class="label label-warning" >'. $label->label_learning .'</span>';
                                                                                        } else if ($learnFiles == "pass") {
                                                                                            $statusValue = '<span class="label label-success" >'. $label->label_learnPass .'</span>';
                                                                                        }
                                                                                        ?>
                                                                                        <div class="stepcoursediv">
                                                                                            <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_gotoLesson; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <a href="<?=$learnlink?>"  <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                                        <li class="list-group-item ">
                                                                                            <?php if($step == 2){ ?>
                                                                                                <!-- <div class="pt-now"> You are here</div> -->
                                                                                            <?php } ?>
                                                                                            <span class="pull-right">
                                                                                                <span id="lblduration-<?=$les->id?>"></span>  <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                                                <span class="list__course"><?= $les->getRefileName(); ?></span>&nbsp;<?=$statusValue?>
                                                                                                <!-- <div class="hidden">
                                                                                                    <video id="video_player<?=$les->id?>" width="320" height="240" controls>
                                                                                                        <source src="<?php //echo $uploadFolder . $les->filename;?>" type="video/mp4">
                                                                                                        </video>
                                                                                                        <div id="meta"></div>   
                                                                                                    </div> -->
                                                                                                </li>
                                                                                            </a>  
                                                                                            <?php 
                                                                                        } 
                                                                                    }
                                                                                    ?>
                                                                                    <?php
                                                                                    if ($checkPostTest) {
                                                                                        $isPostTest = Helpers::isPosttestState($lessonListValue->id);
                                                                                        if ($isPostTest) {
                                                                                            if ($lessonStatus != 'pass') {
                                                                                                $link = 'javascript:void(0);';
                                                                                                $alert = 'alertswal();';
                                                                                            } elseif ($lessonStatus == 'pass' && $can_next_step != 2){
                                                                                                $link = $this->createUrl('question/preexams', array('id' => $lessonListValue->id));
                                                                                                $alert = '';
                                                                                            }else{
                                                                                               $link = 'javascript:void(0);';
                                                                                                $alert = 'alertswal();'; 
                                                                                            }
                                                                                            ?>
                                                                        <div class="stepcoursediv">
                                                                            <div>
                                                                                <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?>
                                                                                </span><?php echo $label->label_testPost; ?>
                                                                            </div>
                                                                        </div>
                                                                                            <li class="list-group-item">
                                                                                                <?php if($step == 3){ ?>
                                                                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                                                                <?php } ?>
                                                                                                <?php echo $label->label_testPost; ?>  <span class="pull-right"><a href="<?= $link ?>" <?= $alert != '' ? 'onclick="' . $alert . '"' : ''; ?> class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span></li>
                                                                                                <?php
                                                                                        } else { //Post Test
                                                                                            $flagPostTestPass = false;
                                                                                            $criteriaScoreAll = new CDbCriteria;
                                                                                            $criteriaScoreAll->condition = ' type = "post" AND lesson_id="' . $lessonListValue->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"'." AND gen_id='".$gen_id."'";
                                                                                            $scoreAll = Score::model()->findAll($criteriaScoreAll);
                                                                                            ?>
                                                                                            <div class="stepcoursediv">
                                                                                               <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_testPost; ?></div></div>
                                                                                               <?php
                                                                                               foreach ($scoreAll as $keys => $scorePost) {
                                                                                                if($scorePost->score_past == 'y'){
                                                                                                    $flagPostTestPass = true;
                                                                                                    $colorText = 'text-success';
                                                                                                } else {
                                                                                                    $colorText = 'text-danger';
                                                                                                }
                                                                                                $postStatus = Helpers::lib()->CheckTestAll($lessonListValue, "post",$scorePost);



                                                                                                $CheckPreTestAnsTextAreaLessonPost = Helpers::lib()->CheckPreTestAnsTextAreaLesson($lessonListValue, "post");

                                                                                                if($CheckPreTestAnsTextAreaLessonPost){
                                                                                                    ?>

                                                                                                <li class="list-group-item"><?php echo $label->label_resultTestPost; ?> <?= $keys+1 ?><span class="pull-right <?= $colorText ?> prepost"><?= $postStatus->value['score']; ?>/<?= $postStatus->value['total']; ?> <?php echo $label->label_point; ?></span></li>
                                                                                                <?php
                                                                                                }else{
                                                                                                    $course_wait_cer = 2;
                                                                                                    ?>

                                                                                                <li class="list-group-item"><?php echo $label->label_resultTestPost; ?> <?= $keys+1 ?><span class="pull-right <?= $colorText ?> prepost"><?= $label->label_course_wait ?></span></li>
                                                                                                <?php
                                                                                                }
                                                                                                
                                                                                                }//end foreach
                                                                                                ?>
                                                                                                <?php if(count($scoreAll) < $lessonListValue->cate_amount && !$flagPostTestPass && count($scoreAll) != 0 && $can_next_step != 2 && $CheckPreTestAnsTextAreaLessonPost == true){
                                                                                                    $link = $this->createUrl('question/preexams', array('id' => $lessonListValue->id));
                                                                                                    $alert = '';
                                                                                                    ?>
                                                                                                    <li class="list-group-item">
                                                                                                       <?php if($step == 3){ ?>
                                                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                                                    <?php } ?>
                                                                                                    <?php echo $label->label_testPost; ?> <?= count($scoreAll)+1; ?> <span class="pull-right"><a href="<?= $link ?>" <?= $alert != '' ? 'onclick="' . $alert . '"' : ''; ?> class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span></li>
                                                                                                <?php } ?>

                                                                                                <?php
                                                                                            }
                                                                                        } else {
                                                                                            ?>
                                                                                            <!-- <li class="list-group-item">ไม่มีข้อสอบหลังเรียน</li> -->
                                                                                        <?php } ?>
                                                                                        <!--                                                        <li class="list-group-item">แบบทดสอบ <?= $lessonListValue->id ?> <span class="pull-right"><a href="<?php echo $this->createUrl('/quiz/preexams', array('id' => $lessonListValue->id)); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ทำแบบทดสอบ</a></span></li>-->

                                                                                        <?php
                                                                                        if ($lessonListValue->header_id) {

                if ($checkPostTest) { //ถ้ามีข้อสอบหลังเรียน
                    if ($isPostTest) {//ถ้ายังไม่ทำข้อสอบ
                        $link_questionnair = 'javascript:void(0);';
                        $alert_questionnair = 'alertswal_test();';
                    } elseif ($isPostTest && $can_next_step != 2){//ถ้าทำข้อสอบแล้ว
                        $link_questionnair = $this->createUrl('questionnaire/index', array('id' => $lessonListValue->id));
                        $alert_questionnair = '';
                    }else{
                        $link_questionnair = 'javascript:void(0);';
                        $alert_questionnair = 'alertswal_test();';
                    }
                } else {//ถ้าไม่มีสอบหลังเรียน
                    $isLearnPass = Helpers::checkLessonPass($lessonListValue);
                    if ($isLearnPass != 'pass') { //ถ้าเรียนยังไม่ผ่าน
                        $link_questionnair = 'javascript:void(0);';
                        $alert_questionnair = 'alertswal();';
                    } elseif ($isLearnPass == 'pass' && $can_next_step != 2) {//ถ้าเรียนผ่านแล้ว
                        $link_questionnair = $this->createUrl('questionnaire/index', array('id' => $lessonListValue->id));
                        $alert_questionnair = '';
                    }else{
                        $link_questionnair = 'javascript:void(0);';
                        $alert_questionnair = 'alertswal();';
                    }
                }
                $lessonQuestionAns = Helpers::lib()->checkLessonQuestion($lessonListValue);
                ?>
                <div class="stepcoursediv">
                    <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_survey; ?></div></div>
                    <li class="list-group-item">
                        <?php echo $label->label_questionnaire; ?> 
                        <span class="pull-right">
                            <?php if(!$lessonQuestionAns){ ?>
                                <a href="<?php echo $link_questionnair ?>" <?= $alert_questionnair != '' ? 'onclick="' . $alert_questionnair . '"' : ''; ?>  class="btn btn-warning">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_Doquestionnaire; ?></a>
                                <?php } else { ?>
                                    <a class="btn btn-warning detailmore" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseSurvay"> <?php echo $label->label_detailSurvey; ?></a>
                                <?php } ?>
                            </span>
                        </li>
                        <div class="panel-collapse collapse " id="collapseSurvay" role="tabpanel" aria-labelledby="headingOne">
                            <ul class="list-group">
                                <?php
                                if($lessonQuestionAns) {
                                    $titleArray = array(
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '5' => '5',
                                    );
                                    ?>
                                    <!-- <div class="panel-collapse collapse" id="showAnswerPanel_<?= $surveyCnt ?>" role="tabpanel" aria-labelledby="headingOne"> -->
                                        <div class="stepcoursediv"><span class="stepcourse"><?php echo $label->label_surveyName; ?> <?php echo $lessonListValue->header->survey_name ?></span> </div>
                                        <div class="box-content-body panel-body">
                                            <?php
                                            $currentQuestionaire = QSection::model()->findByAttributes(array('survey_header_id' =>$lessonListValue->header_id));
                                            if(isset($currentQuestionaire)) {
                                                ?>
                                                <div class="box-content-body">
                                                    <h4><?php echo $label->label_headerSurvey; ?> <?= $currentQuestionaire->section_title ?></h4>
                                                </div>
                                                <div class="box-content-body panel-body">
                                                    <?php
                                                    if(isset($currentQuestionaire->questions)) {
                                                        foreach($currentQuestionaire->questions as $keys => $QQuestion) {
                                                            if($QQuestion->input_type_id == 5 || $QQuestion->input_type_id == 1){
                                                                echo ($keys+1).'. '.$QQuestion->question_name;
                                                                echo '<ul>';
                                                                foreach($QQuestion->choices as $QChoices) {
                                                                    $currentAnswer = QAnswers::model()->find(array(
                                                                        'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $lessonQuestionAns->id . '"'." AND gen_id='".$gen_id."'",
                                                                    ));

                                                                    if($currentAnswer->choice_id == $QChoices->option_choice_id){
                                                                        echo '<li>';
                                                                        if($QQuestion->input_type_id == 1){
                                                                            echo $currentAnswer->answer_text;
                                                                        } else {
                                                                            echo $currentAnswer->answer_textarea;
                                                                        }
                                                                        echo ' </li>';
                                                                    } 
                                                                } 
                                                                echo '</ul>';
                                                            } else if($QQuestion->input_type_id == 2 || $QQuestion->input_type_id == 3){ 
                                                                echo ($keys+1).'. '.$QQuestion->question_name;
                                                                echo '<ul>';
                                                                foreach($QQuestion->choices as $QChoices) {
                                                                    $currentAnswer = QAnswers::model()->find(array(
                                                                        'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $lessonQuestionAns->id . '"'." AND gen_id='".$gen_id."'",
                                                                    ));

                                                                    if($currentAnswer->choice_id == $QChoices->option_choice_id){
                                                                        echo '<li>';
                                                                        echo $QChoices->option_choice_name;
                                                                        echo ' </li>';
                                                                    } 
                                                                } 
                                                                echo '</ul>';
                                                            } else{ ?>
                                                                <?= ($keys+1).'. '.$QQuestion->question_name; ?>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <td style="vertical-align: middle;" class="left padleft" rowspan="2"><?= $QQuestion->question_name ?></td>

                                                                            <td class="center" <?= ($QQuestion->question_range)?'colspan="'.$QQuestion->question_range.'"':null ?>><?php echo  $label->label_SatisfactionLv; ?></td>
                                                                        </tr>
                                                                        <tr class="info">
                                                                            <?php
                                                                            if($QQuestion->question_range > 0) {
                                                                                $j = 5;
                                                                                for($i=1; $i <= $QQuestion->question_range; $i++) {
                                                                                    ?>
                                                                                    <td class="center padleft" style="width: 75px;"><?= $titleArray[$j] ?></td>
                                                                                    <?php
                                                                                    $j--;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <?php
                                                                    if($QQuestion->choices) {
                                                                        foreach($QQuestion->choices as $QChoices) {
                                                                                                // $currentAnswer
                                                                            $currentAnswer = QAnswers::model()->find(array(
                                                                                'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $lessonQuestionAns->id . '"'." AND gen_id='".$gen_id."'",
                                                                            ));
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= $QChoices->option_choice_name ?></td>
                                                                                <?php
                                                                                if($QQuestion->question_range > 0) {
                                                                                    $j = 5;
                                                                                    for($i=1; $i <= $QQuestion->question_range; $i++) {
                                                                                        ?>
                                                                                        <td class="center"><input type="radio" disabled <?= ($currentAnswer->answer_numeric == $j)?'checked':null ?> /></td>
                                                                                        <?php
                                                                                        $j--;
                                                                                    }
                                                                                }

                                                                                ?>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <!-- </div> -->
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        if($lessonListValue->fileDocs):
                            ?>
                            <div class="stepcoursediv">
                                <div> <span class="stepcourse"><?php echo $label->label_DocsDowload; ?>  </span></div></div>
                                <?php foreach ($lessonListValue->fileDocs as $filesDoc => $doc) {
                                    if ($isChecklesson && $can_next_step != 2) {
                                        $linkDownload =  $this->createUrl('/course/download', array('id' => $doc->id));
                                        $onClickDownload =  '';
                                    }else{
                                        $linkDownload =  'javascript:void(0);';
                                        $onClickDownload =  'onclick="alertSequence();"';
                                    }
                                    ?>
                                    <li class="list-group-item "><a href="<?= $linkDownload; ?>"  <?= $onClickDownload ?> ><?=$filesDoc+1?>. <span class="list__course"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #ee0f10;"></i>&nbsp;&nbsp;<?=$doc->getRefileName()?></span> <span class="pull-right"><i class="fa fa-download"></i> <?php echo  $label->label_download; ?></span></a></li>
                                    <?php 
                                }
                            endif; 
                            ?>


                        </ul>
                    </div>
                <?php } ?>

                <!-- Course question  -->
                <?php 
                $ckPassAll = true;
                foreach ($lessonList as $key => $value) {
                    $state = Helpers::lib()->CheckPostTestAll($value);
                    if(!$state){
                        $ckPassAll = false;
                    }
            // var_dump($state);
                }

                $criteria = new CDbCriteria;
                $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y"'." AND gen_id='".$gen_id."'".' AND type="post"';
                $criteria->order = 'create_date ASC';
                $BestFinalTestScore = Coursescore::model()->findAll($criteria);

        $checkCourseTest = Helpers::lib()->checkCoursePass($course->course_id); //Chekc Lesson all pass to test course exam
        $checkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
        $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
        ?>
        <?php 
        if($checkHaveCourseTest){
            if($checkCourseTest == 'pass' && count($BestFinalTestScore) < $course->cate_amount && $ckPassAll && $can_next_step != 2){ //มีสิทธิสอบและยังสามารถสอบได้อีก
                $pathCourseTest = $this->createUrl('coursequestion/preexams', array('id' => $course->course_id, 'type'=>'course'));
                $alertCourseTest = '';
            }else{
                $pathCourseTest = 'javascript:void(0);';
                $alertCourseTest = 'onclick="alertswalCourse()"';
            }
        }else{
            $pathCourseTest = 'javascript:void(0);';
            $alertCourseTest = 'onclick="alertswalNoCourse()"';
        }

        ?>
        <?php if($checkHaveCourseTest || $CourseSurvey){ ?>
           <div class="panel-heading headcourse final-test">
            <a role="button" data-toggle="collapse" data-target="#collapseFinal<?=$key?>" data-parent="#accordion" aria-expanded="true">
               <li>
                <span class="stepcourse"> <?= $checkHaveCourseTest ? $final : ''; ?> <?= $checkHaveCourseTest && $CourseSurvey ? '&' : ''; ?> <?= $CourseSurvey ? $Questionnaire : '' ?><?= $course->course_title ?> <?= $course->getGen($course->course_id); ?></span>
                <span class="pull-right"><i class="fa fa-angle-down"></i></span>
            </li>
        </a>
    </div>
<?php } ?>
<?php $CheckPreTestAnsTextAreaCoursePost = Helpers::lib()->CheckPreTestAnsTextAreaCourse($_GET['id'], "post"); 

// var_dump($CheckPreTestAnsTextAreaCoursePost); exit();
?>

<?php //var_dump($BestFinalTestScore); exit(); ?>

<!-- Check count test -->
<div id="collapseFinal<?=$key?>">
    <?php if($BestFinalTestScore){ ?>
        <?php foreach ($BestFinalTestScore as $key => $course_score) { ?>
            <?php //$CheckPreTestAnsTextAreaCoursePost = Helpers::lib()->CheckPreTestAnsTextAreaCourse($course->course_id, "post"); ?>

            <?php if(count($BestFinalTestScore) < $course->cate_amount){ ?>
                <?php if($course_score->score_past == 'n'){ 
                    //อาจจะยังไม่ตรวจ หรือ ตรวจแล้ว แต่คะแนนไม่ผ่าน
                    ?>

                    <?php 
                    if($CheckPreTestAnsTextAreaCoursePost){
                        ?>
                        <li class="list-group-item ">
                    <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key+1; ?></span>
                        <span class="pull-right  text-danger prepost"> 
                            <?= $course_score->score_number ?>/<?= $course_score->score_total ?>
                            <?= $label->label_point; ?>                                
                        </span>
                    </a> 
                    </li>
                    <?php
                    }else{
                        $course_wait_cer = 2;
                        ?>
                        <li class="list-group-item ">
                    <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key+1; ?></span>
                        <span class="pull-right  text-danger prepost"> <?= $label->label_course_wait; ?> 888</span></a> 
                    </li>

                        <?php
                    }
                     ?>
                 <?php }else{ ?>
                    <?php 
                    $logcourseques = Courselogques::model()->find("score_id='".$course_score->score_id."' ");

                    // ตรวจแล้ว แต่ยังไม่ยืนยัน คะแนนผ่าน
                    if(($logcourseques->confirm == 1 && $logcourseques->check == 1 && $logcourseques->ques_type == 3) || ($logcourseques->ques_type != 3)){
                        ?>
                        <li class="list-group-item ">
                        <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key+1; ?></span>
                            <span class="pull-right  text-success prepost"> <?= $course_score->score_number ?>/<?= $course_score->score_total ?> <?= $label->label_point; ?></span></a> 
                        </li>
                        <?php
                    }else{
                        $course_wait_cer = 2;
                        ?>  
                         <li class="list-group-item ">
                        <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key+1; ?></span>
                            <span class="pull-right  text-success prepost"> <?= $label->label_course_wait; ?>999</span></a> 
                        </li>
                        <?php
                    }
                     ?>                    
                    <?php } ?>
                <?php }else{
                    // สอบครบจำนวนแล้ว
                    if($CheckPreTestAnsTextAreaCoursePost){
                        ?>

                        <li class="list-group-item ">
                        <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key+1; ?></span>
                            <span class="pull-right  text-success prepost"> <?= $course_score->score_number ?>/<?= $course_score->score_total ?> <?= $label->label_point; ?></span></a> 
                        </li>
                        <?php
                    }else{
                        $course_wait_cer = 2;
                        ?>
                        <li class="list-group-item ">
                        <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key+1; ?></span>
                            <span class="pull-right  text-success prepost"> <?= $label->label_course_wait; ?>000</span></a> 
                        </li>
                        <?php
                    }
                 ?>

                    
                    <?php } ?>
                <?php }?>


                <?php if($step == 4){ ?>
                   <!-- <li class="list-group-item "> -->
                    <!-- <div class="pt-now"> You are here</div> -->
                    <!-- <a href="<?= $pathCourseTest ?>" <?= $alertCourseTest ?> >
                        <span class="list__course"><?= $label->label_testFinalTimes; ?> <?= $key+2; ?></span>
                        <span class="btn btn-warning detailmore pull-right"><?= $label->label_gotoLesson ?>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                    </li> -->
                <?php } ?>


            <?php } // if($BestFinalTestScore 

            $criteria = new CDbCriteria;
            $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND score_past="y" AND active="y"'." AND gen_id='".$gen_id."'".' AND type="post"';
            $criteria->order = 'create_date ASC';
            $BestFinalTestScore_pass = Coursescore::model()->findAll($criteria);

            // && empty($BestFinalTestScore_pass) ตัวบอกว่า ไม่มีคะแนนสอบ
            if($checkHaveCourseTest && $CheckPreTestAnsTextAreaCoursePost == true && count($BestFinalTestScore) < $course->cate_amount){ ?>
               <li class="list-group-item ">
                <?php if($step == 4){ ?>
                    <!-- <div class="pt-now"> You are here</div> -->
                <?php } ?>
                <a href="<?= $pathCourseTest ?>" <?= $alertCourseTest ?> >
                    <span class="list__course"><?= $label->label_testFinalTimes; ?> <?= count($BestFinalTestScore)+1; ?></span>
                    <!-- <span class="list__course"><?= $label->label_testFinalTimes; ?> <?= $key+2; ?>5555</span> -->
                    <span class="btn btn-warning detailmore pull-right"><?= $clickFinal ?>
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                </li>
            <?php } ?>


            <!-- end Course question  -->
            <?php 
            $PaQuest = false;
            if ($CourseSurvey) {
                $passQuest = QQuestAns_course::model()->find(array(
                    'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $course->course_id . '"'." AND gen_id='".$gen_id."'",
                ));
                $countSurvey = count($passQuest);
                if ($passQuest) {
                    $PaQuest = true;
                }
            }else{
                $PaQuest = true;
            }

        if($checkCourseTest == 'pass'){ //Lesson All pass
            if($checkHaveCourseTest){
             $criteria = new CDbCriteria;
             $criteria->compare('course_id',$course->course_id);
             $criteria->compare('gen_id',$gen_id);
             $criteria->compare('type',"post");
             $criteria->compare('user_id',Yii::app()->user->id);
             $criteria->compare('score_past','y');
             $criteria->compare('active','y');
             $criteria->order = 'score_id';
             $courseScorePass = Coursescore::model()->findAll($criteria);
             if($courseScorePass){

                        if($PaQuest){ //ทำแบบสอบถามแล้ว
                            $step = 0;
                            $pathSurvey = $this->createUrl('course/questionnaire', array('id' => $course->course_id));
                        }else{
                            $pathSurvey = $this->createUrl('questionnaire_course/index', array('id' =>$CourseSurvey[0]->id));
                        }
                   }else{ //ยังทำแบบทดสอบหลักสูตรไม่ผ่าน
                    $pathSurvey = 'javascript:void(0);';
                    $alrtSurvey = 'onclick="alertswalCourse()"';
                }

            }else{
                if($PaQuest){ //ทำแบบสอบถามแล้ว
                    $step = 0;
                    $pathSurvey = $this->createUrl('course/questionnaire', array('id' => $course->course_id));
                }else{
                    $pathSurvey = $this->createUrl('questionnaire_course/index', array('id' =>$CourseSurvey[0]->id));
                }
            }

        }else{
            $pathSurvey = 'javascript:void(0);';
            $alrtSurvey = 'onclick="alertswalCourse()"';
        }


        ?>
        <!-- Survey -->
        <?php if($CourseSurvey){ ?>
            <div class="list-group-item">
                <?php if($step == 5){ ?>
                    <!-- <div class="pt-now"> Step now</div> -->
                <?php } ?>
                <span><i class="fa fa-list" aria-hidden="true"></i> <?= $label->label_surveyCourse; ?></span> <a href="<?= $pathSurvey ?>" <?= $alrtSurvey  ?>  class="btn btn-warning detailmore pull-right"><?= $Click ?> <i class="fa fa-check-square-o" aria-hidden="true"></i></a>
            </div>
        <?php } ?>
        <!-- end Survey -->
    </div>
</div>
</div>

</div>

</ol>   
</div>
</div>
</div>
</div>
</div>

<!-- <div class="col-sm-4 col-md-3">
                <?php 
                $criteria=new CDbCriteria;
                $criteria->compare('active',"y");
                $criteria->compare('status',"1");
                $criteria->compare('recommend',"y");
                $courseRecommend = CourseOnline::model()->findAll($criteria);
                if($courseRecommend):
                    ?>
                    <div class="course-popular">
                        <div class="page-header">
                            <h3><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-popular.png" class="img-responsive" alt=""></span> <?php echo  $label->label_courseRec; ?></h3>
                        </div>
                        <div class="well">
                            <ul class="list-unstyled">
                                <?php 

                                foreach ($courseRecommend as $key => $value) { ?>
                                <li><a href="<?php echo $this->createUrl('/course/detail', array('id' => $value->course_id)); ?>">
                                    <span class="pull-right"><strong style="font-size: 19px;"><?php echo ($value->course_title) ?></strong></span>
                                    <div class="popular-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div> -->

</div>


<div class="modal fade" id="showtime" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
            <!-- <div class="modal-header" style="background-color: #01b7f2">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">ระยะเวลาเรียน</h4>
          </div> -->
          <div class="modal-body">
            <!-- <center>
                <i class="fa fa-warning" style="font-size:6em; color: #F8BB86; padding-top: 15px;padding-bottom: 15px;"></i>
                <h2 style="color: #575757;">คำเตือน</h2>
                <p style="color: #797979;"> <?= $label->label_day ?>ที่เริ่มเรียน < ?=DateThai(($logtime->start_date == 'NOW()')? date('Y-m-d H:i:s'):$logtime->start_date) ?></p>
                <p style="color: #797979;"> เรียนได้ถึงวันที่ < ?=DateThai($logtime->end_date) ?></p>
                <div style="padding-top: 20px; padding-bottom: 20px;">
                  <button type="button" class="btn btn-success" data-dismiss="modal" style="padding: 15px 32px; height: auto">ตกลง</button>
              </div>
          </center> -->
          <?php 
          $dateEndLearnUser = date('Y-m-d', strtotime($logtime->end_date));
          $dayCourseEnd = date('Y-m-d', strtotime($course->course_date_end));
          if($dateEndLearnUser > $dayCourseEnd){
            $dateEndLearnUser = $dayCourseEnd;
        } 
        ?>
        <center>
            <i class="fas fa-exclamation-triangle" style="font-size:6em; color: #F8BB86; padding-top: 15px;padding-bottom: 15px;"></i>
            <h2 style="color: #575757;"><?= $label->label_swal_regis ?></h2>
            <h2><?= $label->label_course ?> "<?= $course->course_title ?> <?= $course->getGen($course->course_id); ?>" <?= $label->label_swal_success ?></h2>
            <p><?= $label->label_swal_alltimelearn?> 
            <?= $course->course_day_learn ?> 
            <?= $label->label_day ?></p>
            <?php if (Yii::app()->user->id) { ?>
                <p>
                    <?= $label->label_swal_since ?> 

                    <?=Helpers::lib()->DateLangTms($course->course_date_start,Yii::app()->session['lang']) ?> 
                    <?= $label->label_swal_to ?> 

                    <?=Helpers::lib()->DateLangTms($course->course_date_end,Yii::app()->session['lang']) ?></p>



                    <p><?= $label->label_remaintime?> <?= $diff?> <?= $label->label_day ?></p>        
                <?php }  ?>

                <div style="padding-top: 20px; padding-bottom: 20px;">
                  <button type="button" class="btn btn-success" data-dismiss="modal" style="padding: 15px 32px; height: auto"><?= Yii::app()->session['lang'] == 1?'OK':'ตกลง'?></button>
              </div>
          </center>
      </div>
  </div>

</div>
</div>

</section>
<script>

    <?php
    if (!empty($logtime)) {?>
        $(window).load(function(){

            $('#showtime').modal('show');

        });
    <?php } ?>

    function alertswal() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsLearnPass ?>', "error");
    }

    function alertSequence() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsLearnPass ?>', "error");
    }

    function alertswal_test() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsTestPost ?>', "error");
    }

    function alertswalpretest() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsTestPre ?>', "error");
    }

    function alertswalCourse() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_noPermis ?>', "error");
    }

    function alertswalNoCourse() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_alert_msg_notFound ?>', "error");
    }

    function alertswalcert() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_cantPrintCert ?>', "error");
      //   Swal.fire({
      //     icon: 'error',
      //     title: 'Oops...',
      //     text: 'Something went wrong!',
      //     footer: '<a href>Why do I have this issue?</a>'
      // })
  }

  function alertswalNocert() {
    swal('<?= $label->label_swal_warning ?>', 'หลักสูตรนี้ไม่มีใบประกาศนียบัตร กรุณาติดต่อผู้ดูแลระบบ', "error");
}

function showNotice(coursetype) {
    if (coursetype != null && coursetype == '36') {
        swal({
            title: '<?= $label->label_swal_warning ?>',
            text: "หากช่วงเวลาการเข้าระบบ (Login) พร้อมกันในหลายวิชา <br> กรมฯ จะนับ CPD ให้ท่าน<span style='color: red;'>เพียงวิชาเดียว</span>เท่านั้น",
            type: "info",
            html: true,
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: '<?= $label->label_confirm ?>',
            closeOnConfirm: true
        }, function () {
                //do something
            });
    } else {
        console.log(coursetype);
    }
}

function checkPermissionBeforeLearn(course, type) {
    $.post("<?= $this->createUrl("CourseStart/Permission") ?>", {course: course},
        function (respon) {
                // var jsonRespon = JSON.parse(respon);
                // if (type == '36') {
                //     if (jsonRespon.status) {
                //         switch (jsonRespon.status) {
                //             case 99:
                //             swal({

                //                 // title: '<?= $label->label_swal_warning ?>',
                //                 title: '<?= $label->label_course.': '.$course->course_title ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "warning",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: false
                //             },
                //             function () {
                //                 showNotice(jsonRespon.coursetype);
                //             });
                //             break;
                //             case 1:
                //             swal({
                //                 title: '<?= $label->label_alert_welcome ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "success",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: false
                //             },
                //             function () {
                //                 showNotice(jsonRespon.coursetype);
                //             });
                //             break;
                //         }
                //     }
                // } else {
                //     if (jsonRespon.status) {
                //         switch (jsonRespon.status) {
                //             case 99:
                //             swal({
                //                 title: '<?= $label->label_course.': '.$course->course_title ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "warning",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: true
                //             },
                //             function () {
                //             });
                //             break;
                //             case 1:
                //             swal({
                //                 title: '<?= $label->label_alert_welcome ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "success",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: true
                //             },
                //             function () {
                //             });
                //             break;
                //         }
                //     }
                // }
            }
            );
}

$(window).load(function () {
    console.log($('#loader1'));
});
$(function () {

    <?php if(Yii::app()->user->hasFlash('CheckQues')){ 
        ?>
        var msg = '<?php echo Yii::app()->user->getFlash('CheckQues'); ?>';
        var cla = '<?php echo Yii::app()->user->getFlash('class'); ?>';
        swal({
            title: '<?= $label->label_swal_system ?>',
            text: msg,
            type: cla,
            confirmButtonText: '<?= $label->label_confirm ?>',
        });
        <?php 
        Yii::app()->user->setFlash('CheckQues',null);
        Yii::app()->user->setFlash('class',null);
    } 
    ?>
    $('#loader1').hide();
        //check permission and show pop-up
        checkPermissionBeforeLearn('<?= $course->course_id ?>', '<?= $course->cate_id ?>');

        /* jQueryKnob */

        $(".knob").knob({
            draw: function () {
                // "tron" case
                if (this.$.data('skin') == 'tron') {
                    var a = this.angle(this.cv)  // Angle
                            , sa = this.startAngle          // Previous start angle
                            , sat = this.startAngle         // Start angle
                            , ea                            // Previous end angle
                            , eat = sat + a                 // End angle
                            , r = true;

                            this.g.lineWidth = this.lineWidth;

                            this.o.cursor
                            && (sat = eat - 0.3)
                            && (eat = eat + 0.3);

                            if (this.o.displayPrevious) {
                                ea = this.startAngle + this.angle(this.value);
                                this.o.cursor
                                && (sa = ea - 0.3)
                                && (ea = ea + 0.3);
                                this.g.beginPath();
                                this.g.strokeStyle = this.previousColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                                this.g.stroke();
                            }

                            this.g.beginPath();
                            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                            this.g.stroke();

                            this.g.lineWidth = 2;
                            this.g.beginPath();
                            this.g.strokeStyle = this.o.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                            this.g.stroke();

                            return false;
                        }
                    }
                });
        /* END JQUERY KNOB */

    });

    // Start Step

// End Step
// function lang(){
//   if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
//     $leng = "Length";
//     $min = "Minutes";
//     this.getDuration($leng);
// }else{  
//     $leng = "ความยาว";
//     $min = "นาที";
// }
// }

</script>