<?php
$session = new CHttpSession;
$session->open();
$http = new CHttpRequest;
Yii::app()->user->returnUrl = $http->getUrl();
/*if ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '112.121.150.4' && $_SERVER['HTTP_HOST'] != '127.0.0.1') {
  if($_SERVER['HTTPS'] != 'on'){
    $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header('Location:'.$redirect);
  }
} */
?>
<!doctype html>
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]>
<html lang="en" class="no-js"> <![endif]-->
<html lang="en">

<head>


  <title><?php echo CHtml::encode($this->pageTitle); ?></title>

  <?php include("themes/template2/include/css.php"); ?>
</head>

<body>

  <?php //include("themes/template2/include/header.php"); ?>

 
<?php //content
$themeBaseUrl = Yii::app()->theme->baseUrl;
$uploadFolder = Yii::app()->getUploadUrl("lesson");
$uploadFolderScorm = Yii::app()->getUploadUrl("scorm");
// var_dump(Yii::app()->getBaseUrl(true).'/uploads/'.'scorm/1/'.'imsmanifest.xml');
// var_dump($uploadFolderScorm .'1/'.'imsmanifest.xml' );exit();
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
  $langId = Yii::app()->session['lang'] = 1;
  $flag = true;


  $pass_msg = "You Completed the Lesson.";
  $next_step_msg = "Do You Want to go to the next step?";
  $note_label = 'Note';
  $note_list = 'list';
  $note_des = 'Type a message and take notes.';
  $Notes = 'Notes';
  $captcha = 'Please Click Confirm To Continue';
  $buttonok = 'Confirm';
} else {
  $langId = Yii::app()->session['lang'];
  $flag = false;
  $note_list = 'รายการ';
  $note_label = 'จดบันทึก';
  $note_des = 'พิมพ์ข้อความและจดบันทึก';
  $Notes = 'จดบันทึก';
  $pass_msg = UserModule::t('you_pass');
  $next_step_msg = UserModule::t('next_step');
  $captcha = 'กรุณากดปุ่มยืนยันเพื่อเรียนต่อ';
  $buttonok = 'ยืนยัน';
  $modelLessonChildren  = Lesson::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $model->id));
  if ($modelLessonChildren) {
    $model->title = $modelLessonChildren->title;
  }
}
// $pass_msg = UserModule::t('you_pass');
$next_step_msg = UserModule::t('next_step');
$ok_msg = UserModule::t('Ok');
$cancel_msg = UserModule::t('Cancel');
$msg_learn_pass = $label->label_learnPass; //เรียนผ่าน
$msg_learning = $label->label_learning; //กำลังเรียน
$msg_notLearn = $label->label_notLearn; //ยังไม่ได้เรียน
$msg_do_test = $label->label_DoTest; //ทำแบบทดสอบ
?>
<link href="<?php echo $themeBaseUrl; ?>/plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/learn/prettyPhoto.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/learn/jquery.wizard.css" rel="stylesheet" type="text/css">
<link href="<?php echo $themeBaseUrl; ?>/css/learn/pace-learn.css" rel="stylesheet" type="text/css">
<script src="<?php echo $themeBaseUrl; ?>/plugins/video-js/video.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/library/jquery.prettyPhoto.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/library/jquery.wizard.js"></script>

<script type="text/javascript" src="<?php echo $themeBaseUrl; ?>/plugins/knob/jquery.knob.js"></script>
<script src="<?php echo $themeBaseUrl; ?>/js/library/pace.js" rel="stylesheet"></script>
<script type='text/javascript' src='<?php echo $themeBaseUrl; ?>/js/library/jquery.countdown.min.js'></script>
<style type="text/css" media="screen">
  .vjs-play-control .vjs-control .vjs-paused {
    display: none;
  }

  body {
    background-color: #ddd;
  }

  header {
    display: none;
  }

  footer {
    display: none !important;
  }
</style>
<script>
  var status_in_learn_note = "no";

  $(function() {
    init_knob();
    // $('audio').audioPlayer();
    show_collapse("<?php echo $_GET['file']; ?>"); // เปิดแถบวิดีโอ ตาม file ที่คลิ๊ก
    $("#id_tablenote_" + "<?php echo $_GET['file']; ?>").attr("status-show", 1);
    $("#id_tablenote_" + "<?php echo $_GET['file']; ?>").show();
  });

  function show_div_note(file_id) {
    $("#table_note_" + file_id).show();
  }
</script>

<style type="text/css">
  body {
    padding-bottom: 0;
  }

  .youtube-iframe {
    height: 80vh !important;
  }

  .video-js {
    max-width: 100%;
    width: 100%;
  }

  .contact-admin {
    right: 0 !important;
  }

  .video-js {
    width: auto !important;
    height: auto !important;
  }

  @media screen and (min-width:1240px) {
    .video-js {
      height: 75vh !important;
    }
  }

  .video-js video {
    position: relative !important;
  }

  .vjs-current-time-display {
    font-family: '';
  }

  .vjs-duration-display {
    font-family: '';
  }

  .split-me>div:first-child {
    background: #555;
  }

  .split-me>div:last-child {
    background: #dddddd;
  }


  .split-me-container {
    position: absolute;
    top: 3em;
    left: 1em;
    right: 1em;
    bottom: 1em;
    border-radius: 6px;
    overflow: hidden;
  }

  .splitter-bar {
    background: #333;
  }

  .showslidethumb {
    height: 144px;
    margin-top: 16px;
    /*margin: 100 px auto;*/
    background: #A3CBE0;
    border: 2px solid #000;
    overflow-x: auto;
    overflow-y: hidden;
    box-shadow: 0 0 10px #000;
  }

  .top-nav-list>li>a {
    min-width: 152px;
    padding: 0;
  }



  .showslidethumb ul {
    float: left;
    margin-right: -999em;
    white-space: nowrap;
    list-style: none;
  }

  .showslidethumb li {
    margin: 6px;
    text-align: center;
    float: left;
    display: inline;
  }

  .showslidethumb img {
    border: 0;
    display: block;
    border: 1px solid #A3CBE0;
    height: 108px;
    max-height: 120px;
    cursor: pointer;
    margin: 10px 0;
  }

  .showslidethumb a:active img,
  .showslidethumb a:focus img,
  .showslidethumb a:hover img {
    border: 1px solid #000;
  }

  .showslidethumb a {
    text-decoration: none;
    font-weight: bold;
    color: #000;
  }

  .showslidethumb a:active,
  .showslidethumb a:focus,
  .showslidethumb a:hover {
    color: #FFF;
  }

  .showslidethumb span {
    padding: 5px 0 0;
    display: block;
  }

  /* ------------- Flexcroll CSS ------------ */
  .scrollgeneric {
    line-height: 1px;
    font-size: 1px;
    position: absolute;
    top: 0;
    left: 0;
  }

  .hscrollerbase {
    height: 17px;
    background: #A3CBE0;
  }

  .hscrollerbar {
    height: 12px;
    background: #000;
    cursor: e-resize;
    padding: 3px;
    border: 1px solid #A3CBE0;
  }

  .hscrollerbar:hover {
    background: #222;
    border: 1px solid #222;
  }

  .menu_li_padding {
    padding: 10px 15px !important;
  }

  footer:before {
    content: none !important;
  }

  blockquote>footer {
    height: 10em;
    overflow-y: scroll;
  }

  p {
    color: #111;
  }

  .pageIndex {
    position: absolute;
    z-index: 999;
    bottom: 2%;
    right: 4%;
    font-size: 22px;
    color: #012060;
    background-color: rgba(0, 0, 0, 0.14);
    padding: 0 7px;
    border-radius: 5px;
    font-weight: 500;
  }

  .pageTime {
    position: fixed;
    z-index: 999999;
    background-color: #f2dede;
    bottom: 5%;
    left: 0;
    padding: 10px 20px;
    font-size: 25px;
    color: red;
  }

  .carousel-inner>.item>img,
  .carousel-inner>.item>a>img {
    width: 80%;
    /* use this, or not */
    margin: auto;
  }

  .cometchat_ccmobiletab_redirect {
    font-family: 'supermarket', 'supermarket' !important;
    font-size: 14px !important;
    color: rgb(255, 255, 255) !important;
    text-shadow: none !important;
    padding: 6px 14px !important;
    background: rgb(255, 164, 0) !important;
    border: none !important;
  }

  .carousel-indicators-numbers li {
    text-indent: 0;
    margin: 0 2px;
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 100%;
    line-height: 30px;
    color: #fff;
    background-color: #999;
    transition: all 0.25s ease;
  }

  .carousel-indicators-numbers li.active,
  .carousel-indicators-numbers li:hover {
    margin: 0 2px;
    width: 30px;
    height: 30px;
    background-color: #337ab7;
  }

  .list-scorm {
    font-size: 13px !important;
    background-color: #ededed;
    border-radius: 5px;
    padding: 10px;
  }

  .list-scorm table {
    margin: 3px 0;
  }

  .display-scorm {
    padding-right: 0;
  }

  @media screen and (min-width:1200px) {
    #placeholder_contentIFrame iframe {
      height: auto;
      min-height: 730px !important;
    }
  }

  .is-desktop .control-actions {
    transform: scale(1.5);
    margin-right: 4em;
  }
  }

  @media screen and (min-width:1024px) {
    .carousel-indicators {
      bottom: -10%;
    }
  }

  @media screen and (max-width:1023px) {
    .carousel-indicators {
      bottom: -15%;
    }

    @media screen and (max-width: 600) {
      .carousel-indicators {
        bottom: -22%;
      }

      @media screen and (max-width: 400) {
        .carousel-indicators {
          bottom: -25%;
        }

      }
</style>
<style>
  /*p { clear: both; }*/
  .audiojs {
    width: auto;
  }

  .audiojs {
    height: 40px;
    background: #404040;
    /* background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #444), color-stop(0.5, #555), color-stop(0.51, #444), color-stop(1, #444)); */
    /* background-image: -moz-linear-gradient(center top, #444 0%, #555 50%, #444 51%, #444 100%); */
    -webkit-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3);
    -o-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3);
    box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.3);
  }

  .audiojs .play-pause {
    border-right: 1px solid rgba(0, 0, 0, 0.3);
    width: 45px;
    height: 45px;
    padding: 8px 8px 0px 8px;
  }

  .audiojs p {
    width: 25px;
    height: 20px;
    margin: -3px 0px 0px -1px;
  }

  .audiojs .scrubber {
    background: #5a5a5a;
    width: 310px;
    height: 20px !important;
    margin: 10px;
  }

  .audiojs .progress {
    height: 20px !important;
    width: 0px;
    background: #ccc;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ccc), color-stop(0.5, #ddd), color-stop(0.51, #ccc), color-stop(1, #ccc));
    background-image: -moz-linear-gradient(center top, #ccc 0%, #ddd 50%, #ccc 51%, #ccc 100%);
  }

  .audiojs .loaded {
    height: 20px !important;
    background: #000;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #222), color-stop(0.5, #333), color-stop(0.51, #222), color-stop(1, #222));
    background-image: -moz-linear-gradient(center top, #222 0%, #333 50%, #222 51%, #222 100%);
  }

  .audiojs .time {
    float: right;
    height: 25px;
    line-height: 25px;
    margin-top: 8px;
    border-left: 1px solid rgba(0, 0, 0, 0.3);
  }

  .audiojs .time .duration {
    font-size: 12px;
    font-family: 'NotoSansThai', NotoSans, sans-serif;
  }

  .audiojs .error-message {
    height: 24px;
    line-height: 24px;
  }

  .track-details {
    clear: both;
    height: 20px;
    width: 448px;
    padding: 1px 6px;
    background: #eee;
    color: #222;
    font-family: monospace;
    font-size: 11px;
    line-height: 20px;
    -webkit-box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.15);
    -moz-box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.15);
  }

  .track-details:before {
    content: '♬ ';
  }

  .track-details em {
    font-style: normal;
    color: #999;
  }
</style>




<div id="main">
  <div class="container-fluid">
    <div class="row bg-mute pt-1 pb-1">
      <div class="col-sm-10 col-sm-offset-1" id="myGroup">
        <?php
        $idx = 1;
        if (count($model->files) && $model->type == 'vdo') {
          foreach ($model->files as $file) :
            $learnFiles = Helpers::lib()->checkLessonFileMobile($les, $learnModel->learn_id,$gen_id,$user_id);
            if ($learnFiles == "notLearn") {
              $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> ';
            } else if ($learnFiles == "learning") {
              $statusValue = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true"> ';
            } else if ($learnFiles == "pass") {
              $statusValue = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true"> ';
            }

            $learnVdoModel = LearnFile::model()->find(array(
              'condition' => 'file_id=:file_id AND learn_id=:learn_id AND gen_id=:gen_id',
              'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id, ':gen_id' => $gen_id)
            ));
            $imageSlide = ImageSlide::model()->findAll('file_id=:file_id AND image_slide_time != \'\'', array(':file_id' => $file->id));
        ?>
            <div class="panel-group" id="accordion<?= $file->id; ?>" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                
                <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                  <div class="panel-body" style="background-color: #ddd; padding: 4px;">
                    <div>
                      <div class="split-me" id="split-me<?php echo $idx; ?>">
                        <div class="col-md-<?php echo empty($imageSlide) ? 12 : 6; ?>" style="padding: 0;">
                          <video id="example_video_<?php echo $idx; ?>" lesson_id="<?php echo $file->lesson_id; ?>" index="<?php echo $idx; ?>" fileId="<?php echo $file->id; ?>" class="video-js vjs-default-skin" controls preload="none" data-setup="{}">
                            <source src="<?php echo $uploadFolder . $file->filename; ?>" type='video/mp4' />
                            <p class="vjs-no-js">To view this video please enable
                              JavaScript, and consider upgrading to a web browser that
                              <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video
                              </a>
                            </p>
                          </video>
                        </div>
                        <div class="col-md-6 " style="padding: 0px; background-color: #f8f8f8;">
                          <a href="#" id="showslide<?php echo $idx; ?>" rel="prettyPhoto"> </a>
                        </div>
                        <?php if (!empty($imageSlide)) { ?>
                          <div class="col-md-12 showslidethumb" id="showslidethumb<?php echo $idx; ?>" style="overflow-x: auto; overflow-y: auto;">
                            <div class="row">
                              <?php
                              // $learnFiles = $user->learnFiles(array('condition' => 'file_id=' . $file->id));
                              $learnFiles = LearnFile::model()->findAll(array('condition' => 'file_id =' . $file->id . ' AND user_id_file = ' . $user_id . " AND gen_id='" . $gen_id . "'"));
                              foreach ($imageSlide as $key => $imageSlideItem) {
                                $displayNone = "display:none;";
                                if ($learnFiles[0]->learn_file_status != 'l' && $learnFiles[0]->learn_file_status != 's') {
                                  if ($learnFiles[0]->learn_file_status > $key || $learnFiles[0]->learn_file_status == $key) {
                                    $displayNone = "";
                                  }
                                } else if ($learnFiles[0]->learn_file_status == 's') {
                                  $displayNone = "";
                                }
                                if (count($imageSlide) == 1) {
                                  $name = '';
                                } else {
                                  $name = '-' . $imageSlideItem->image_slide_name;
                                }
                              ?>
                                <div class="col-md-2 col-xs-6" style="margin-top:10px; ">
                                  <img src="<?php echo Yii::app()->baseUrl . "/uploads/ppt/" . $file->id . "/slide" . $name . ".jpg"; ?>" id="slide<?php echo $idx; ?>_<?php echo $key; ?>" class="slidehide<?php echo $idx; ?> img-responsive" style="<?php echo $displayNone; ?>" data-time="<?php echo $imageSlideItem->image_slide_time; ?>">
                                </div>
                              <?php
                              }
                              ?>
                            </div>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                      <script type="text/javascript">
                        function clearAllRun<?php echo $idx; ?>() {
                          <?php
                          if (!empty($imageSlide)) {
                            foreach ($imageSlide as $key => $imageSlideItem) {
                          ?>
                              window.run<?php echo $idx; ?>_<?php echo $key; ?> = false;
                          <?php
                            }
                          }
                          ?>
                        }
                        var myPlayer<?php echo $idx; ?> = videojs('example_video_<?php echo $idx; ?>');

                        <?php
                        $imageTimeLast = 0;
                        if (!empty($imageSlide)) {
                          $countSlide = count($imageSlide);
                          foreach ($imageSlide as $key => $imageSlideItem) {
                        ?>
                            window.run<?php echo $idx; ?>_<?php echo $key; ?> = false;
                            <?php
                            if ($learnVdoModel->learn_file_status != 's') {
                              if ($countSlide == $key + 1) {
                                $imageSlideLearnLast = ImageSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id' => $file->id, ':slide_name' => $learnVdoModel->learn_file_status));
                                if ($imageSlideLearnLast) {
                                  $imageTimeLast = $imageSlideLearnLast->image_slide_time;
                            ?>
                                  myPlayer<?php echo $idx; ?>.currentTime(<?= $imageSlideLearnLast->image_slide_time ?>);
                        <?php
                                }
                              }
                            }
                          }
                        } else {
                          if (is_numeric($learnVdoModel->learn_file_status)) {
                            $imageTimeLast = $learnVdoModel->learn_file_status;
                          }
                        }
                        ?>

                        $('.vjs-seek-handle').attr('class', 'vjs-seek-handle<?php echo $idx; ?> vjs-slider-handle');

                        if (<?= $imageTimeLast ?> > myPlayer<?php echo $idx; ?>.currentTime()) {
                          var currentTime<?php echo $idx; ?> = <?= $imageTimeLast ?>;
                        } else {
                          var currentTime<?php echo $idx; ?> = (myPlayer<?php echo $idx; ?>.currentTime());
                        }
                        element = '<div class="vjs-play-past<?php echo $idx; ?>" style="background-color:red;height:100%">';
                        element += '<span class="vjs-control-text<?php echo $idx; ?>">';
                        element += '</span>';
                        element += '</div>';
                        $(element).insertAfter(".vjs-seek-handle<?php echo $idx; ?>");
                        $('.vjs-play-progress').css({
                          "z-index": 9999
                        });
                        $('.vjs-play-past<?php echo $idx; ?>').css({
                          "opacity": 0.3
                        });

                        <?php
                        if ($learnVdoModel->learn_file_status != 's') {
                        ?>
                          myPlayer<?php echo $idx; ?>.on("seeking", function(event) {
                            if (currentTime<?php echo $idx; ?> < myPlayer<?php echo $idx; ?>.currentTime()) {
                              myPlayer<?php echo $idx; ?>.currentTime(currentTime<?php echo $idx; ?>);
                            }
                            clearAllRun<?php echo $idx; ?>();
                          });

                          setInterval(function() {
                            var timePlayed<?php echo $idx; ?> = currentTime<?php echo $idx; ?>;


                            if (Math.floor(timePlayed<?php echo $idx; ?>) % 6 == 0 && Math.floor(timePlayed<?php echo $idx; ?>) > 0) {
                              // console.log("mod ----- "+Math.floor(timePlayed<?php echo $idx; ?>)%6);
                              // console.log("time ----- "+Math.floor(timePlayed<?php echo $idx; ?>));
                              // console.log("idx ----- "+<?php echo $idx; ?>);
                              // console.log("++++++++++++++++++++++++++++++++++++++++++++++");
                              save_time_video(Math.floor(timePlayed<?php echo $idx; ?>), <?php echo $idx; ?>);
                            }



                            var percenttimePlayed<?php echo $idx; ?> = (myPlayer<?php echo $idx; ?>.duration() / 60);
                            percenttimePlayed<?php echo $idx; ?> = (100 / percenttimePlayed<?php echo $idx; ?>);
                            percenttimePlayed<?php echo $idx; ?> = (timePlayed<?php echo $idx; ?> / 60) * percenttimePlayed<?php echo $idx; ?>;

                            if (myPlayer<?php echo $idx; ?>.currentTime() > timePlayed<?php echo $idx; ?>) {
                              if (!myPlayer<?php echo $idx; ?>.paused()) {
                                currentTime<?php echo $idx; ?> = myPlayer<?php echo $idx; ?>.currentTime();
                              }
                            }
                            $('.vjs-play-past<?php echo $idx; ?>').css({
                              "width": percenttimePlayed<?php echo $idx; ?> + '%',
                              "opacity": 0.3
                            });
                          }, 1000);
                        <?php
                        } else {
                        ?>
                          myPlayer<?php echo $idx; ?>.on("seeking", function(event) {
                            clearAllRun<?php echo $idx; ?>();
                          });
                        <?php
                        }
                        ?>

                        $('.slidehide<?php echo $idx; ?>').click(function(event) {
                          clearAllRun<?php echo $idx; ?>();
                          $('#showslide<?php echo $idx; ?>').attr('href', $(this).attr('src'));
                          $('#showslide<?php echo $idx; ?>').html($(this).clone());

                          myPlayer<?php echo $idx; ?>.currentTime($(this).attr('data-time'));
                        });
                        <?php
                        if ($learnVdoModel->learn_file_status != 's') {
                        ?>
                          myPlayer<?php echo $idx; ?>.on('play', function() {
                            $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                              id: <?php echo $file->id; ?>,
                              learn_id: <?php echo $learn_id; ?>,
                              page: "LearnVdo",
                            }, function(data) {

                              if (data == "logout") {
                                Swal.fire({
                                  title: 'กรุณาเข้าสู่ระบบ',
                                  icon: 'error',
                                  showCancelButton: true,
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'ตกลง',
                                  cancelButtonText: 'ยกเลิก'
                                }).then((result) => {
                                  window.location = "https://elearning.imct.co.th/";
                                });

                              } else {

                                data = JSON.parse(data);
                                //อัพเดต ให้ไอคอนบอกว่า กำลังเรียน
                                $('#imageCheck' + data.no).html(data.image);
                                $('#status_block_' + data.no).removeClass();
                                $('#status_block_' + data.no).addClass("label label-warning");
                                $('#status_block_' + data.no).html("<?php echo $msg_learning; ?>");
                                // console.log("imageCheck 1");
                                $('#imageCheckBar' + data.no).removeClass();
                                $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                init_knob();
                              }

                            });
                          });

                          myPlayer<?php echo $idx; ?>.on('ended', function() { // เรียนจบคลิป
                            //  swal({
                            //   title: "<?= $pass_msg ?>",
                            //   text: "Waiting",
                            //   type: "success",
                            //   showConfirmButton: true,
                            //   showCancelButton: false,
                            // });
                            $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                              id: <?php echo $file->id; ?>,
                              learn_id: <?php echo $learn_id; ?>,
                              status: "success",
                              page: "LearnVdo",
                            }, function(data) {
                              if (data == "logout") {
                                Swal.fire({
                                  title: 'กรุณาเข้าสู่ระบบ',
                                  icon: 'error',
                                  showCancelButton: true,
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'ตกลง',
                                  cancelButtonText: 'ยกเลิก'
                                }).then((result) => {
                                  window.location = "https://elearning.imct.co.th/";
                                });

                              } else {

                                data = JSON.parse(data);
                                $('#imageCheck' + data.no).html(data.image);
                                $('#status_block_' + data.no).removeClass();
                                $('#status_block_' + data.no).addClass("label label-success");
                                $('#status_block_' + data.no).html("<?php echo $msg_learn_pass; ?>");
                                // console.log("imageCheck 2");
                                $('#imageCheckBar' + data.no).removeClass();
                                $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                init_knob();
                                if (data.imageBar == 'success') { // แถบสถานะ เรียบจบ
                                  swal({
                                      title: "<?= $pass_msg ?>",
                                      text: "<?= $next_step_msg ?>",
                                      type: "success",
                                      confirmButtonText: "<?= $ok_msg ?>",
                                      cancelButtonText: "<?= $cancel_msg ?>",
                                      showCancelButton: true,
                                      closeOnConfirm: true,
                                      closeOnCancel: true
                                    },
                                    function(isConfirm) {
                                      if (isConfirm) {
                                        window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
                                      }
                                    }
                                  );
                                }
                              }
                            });
                          });
                        <?php
                        }
                        ?>

                        <?php
                        if (!empty($imageSlide)) {
                          $countSlide = count($imageSlide);
                          foreach ($imageSlide as $key => $imageSlideItem) {
                        ?>
                            window.run<?php echo $idx; ?>_<?php echo $key; ?> = false;
                        <?php
                            if ($learnVdoModel->learn_file_status != 's') {
                              if ($countSlide == $key + 1) {
                                $imageSlideLearnLast = ImageSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id' => $file->id, ':slide_name' => $learnVdoModel->learn_file_status));
                                if ($imageSlideLearnLast) {
                                  echo 'myPlayer' . $idx . '.currentTime(' . $imageSlideLearnLast->image_slide_time . ');';
                                }
                              }
                            }
                          }
                        }
                        ?>
                        myPlayer<?php echo $idx; ?>.currentTime(currentTime<?php echo $idx; ?>);
                        var nowPoint = 0;
                        myPlayer<?php echo $idx; ?>.on('timeupdate', function() {
                          <?php
                          if (!empty($imageSlide)) {
                            foreach ($imageSlide as $key => $imageSlideItem) {
                          ?>

                              if (myPlayer<?php echo $idx; ?>.currentTime() >= <?php echo ($imageSlideItem->image_slide_time) ? $imageSlideItem->image_slide_time : 0; ?>) {
                                if ($('#slide<?php echo $idx; ?>_<?php echo $key; ?>').css('display') == 'none') {
                                  $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').show('slow', function() {
                                    $('#showslide<?php echo $idx; ?>').attr('href', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                    $('#showslide<?php echo $idx; ?>').html($('#slide<?php echo $idx; ?>_<?php echo $key; ?>').clone());
                                    if ($('.pp_pic_holder').size() > 0) {
                                      $('#fullResImage').attr('src', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                    }
                                    $('#showslidethumb<?php echo $idx; ?>').scrollTop($('#showslidethumb<?php echo $idx; ?>')[0].scrollHeight);

                                    <?php
                                    if ($learnVdoModel->learn_file_status != 's') {
                                    ?>
                                      $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                                        id: <?php echo $file->id; ?>,
                                        learn_id: <?php echo $learn_id; ?>,
                                        slide_number: <?php echo $key; ?>,
                                        page: "LearnVdo",
                                      }, function(data) {
                                        if (data == "logout") {
                                          Swal.fire({
                                            title: 'กรุณาเข้าสู่ระบบ',
                                            icon: 'error',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'ตกลง',
                                            cancelButtonText: 'ยกเลิก'
                                          }).then((result) => {
                                            window.location = "https://elearning.imct.co.th/";
                                          });

                                        } else {}
                                      });
                                    <?php
                                    }
                                    ?>
                                  });
                                } else {
                                  if (!run<?php echo $idx; ?>_<?php echo $key; ?>) {
                                    $('#showslide<?php echo $idx; ?>').attr('href', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                    $('#showslide<?php echo $idx; ?>').html($('#slide<?php echo $idx; ?>_<?php echo $key; ?>').clone());
                                    if ($('.pp_pic_holder').size() > 0) {
                                      $('#fullResImage').attr('src', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                    }
                                  }
                                }
                                window.run<?php echo $idx; ?>_<?php echo $key; ?> = true;
                              }
                            <?php
                            }
                          } else {
                            if ($learnVdoModel->learn_file_status != 's') {
                            ?>
                              var currentTimeUpdate = parseInt(this.currentTime());
                              if (currentTimeUpdate % 180 == 0 && nowPoint != currentTimeUpdate) {
                                $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                                  id: <?php echo $file->id; ?>,
                                  learn_id: <?php echo $learn_id; ?>,
                                  slide_number: currentTimeUpdate,
                                  page: "LearnVdo",
                                }, function(data) {
                                  if (data == "logout") {
                                    Swal.fire({
                                      title: 'กรุณาเข้าสู่ระบบ',
                                      icon: 'error',
                                      showCancelButton: true,
                                      confirmButtonColor: '#3085d6',
                                      cancelButtonColor: '#d33',
                                      confirmButtonText: 'ตกลง',
                                      cancelButtonText: 'ยกเลิก'
                                    }).then((result) => {
                                      window.location = "https://elearning.imct.co.th/";
                                    });

                                  } else {}

                                });
                                nowPoint = currentTimeUpdate;
                              }
                            <?php
                            }
                            ?>
                          <?php } ?>
                        });
                        var focused = true;
                        document.addEventListener("visibilitychange", function() {
                          focused = !focused;
                          if (!focused) {
                            var myPlayer = videojs("example_video_<?php echo $idx; ?>");
                            // console.log("1 : "+status_in_learn_note);
                            myPlayer.pause();
                          }
                        });

                        function setTimeRollback<?php echo $idx; ?>(time) {
                          currentTime<?php echo $idx; ?> = time;
                        }

                        function getCurrentTimeRollback<?php echo $idx; ?>() {
                          return currentTime<?php echo $idx; ?>;
                        }
                      </script>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
            $idx++;
          endforeach;
        } else if (count($model->fileScorm) && $model->type == 'scorm') {
          foreach ($model->fileScorm as $file) :
            $learnFiles = Helpers::lib()->checkLessonFileMobile($les, $learnModel->learn_id,$gen_id,$user_id);
            if ($learnFiles == "notLearn") {
              $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> ';
            } else if ($learnFiles == "learning") {
              $statusValue = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true"> ';
            } else if ($learnFiles == "pass") {
              $statusValue = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true"> ';
            }

            $learnVdoModel = LearnFile::model()->find(array(
              'condition' => 'file_id=:file_id AND learn_id=:learn_id AND gen_id=:gen_id',
              'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id, ':gen_id' => $gen_id)
            ));

            $imageTimeLast = 0;
            $pathMyHost = Yii::app()->getBaseUrl(true) . '/uploads/scorm/' . $file->id . '/imsmanifest.xml';
          ?>
            <script type="text/javascript">
              $(document).ready(function() {
                InitPlayer();
              });

              function InitPlayer() {
                // PlayerConfiguration.Debug = true;
                PlayerConfiguration.StorageSupport = true;
                // PlayerConfiguration.BtnPrevious = false;
                // PlayerConfiguration.BtnContinueLabel = "Continue";
                // PlayerConfiguration.BtnExitLabel = "Exit";
                // PlayerConfiguration.BtnExitAllLabel = "Exit All";

                PlayerConfiguration.TreeMinusIcon = "<?= Yii::app()->getBaseUrl(true); ?>" + "/Img/minus.gif";
                PlayerConfiguration.TreePlusIcon = "<?= Yii::app()->getBaseUrl(true); ?>" + "/Img/plus.gif";
                PlayerConfiguration.TreeLeafIcon = "<?= Yii::app()->getBaseUrl(true); ?>" + "/Img/leaf.gif";
                PlayerConfiguration.TreeActiveIcon = "<?= Yii::app()->getBaseUrl(true); ?>" + "/Img/select.gif";

                // PlayerConfiguration.BtnPreviousLabel = "Previous";
                // PlayerConfiguration.BtnContinueLabel = "Continue";
                // PlayerConfiguration.BtnExitLabel = "Exit";
                // PlayerConfiguration.BtnExitAllLabel = "Exit All";
                // PlayerConfiguration.BtnAbandonLabel = "Abandon";
                // PlayerConfiguration.BtnAbandonAllLabel = "Abandon All";
                // PlayerConfiguration.BtnSuspendAllLabel = "Suspend All";

                //manifest by URL   
                //Run.ManifestByURL(manifest, true);
                Run.ManifestByURL("<?= $pathMyHost; ?>", true);
              }
              <?php if (empty($learnVdoModel)) { ?>
                $.post('<?php echo $this->createUrl("//course/LearnScorm"); ?>', {
                  id: <?php echo $file->id; ?>,
                  learn_id: <?php echo $learn_id; ?>
                }, function(data) {
                  data = JSON.parse(data);
                  $('#imageCheck' + data.no).html(data.image);
                  console.log("imageCheck 3");
                  $('#imageCheckBar' + data.no).removeClass();
                  $('#imageCheckBar' + data.no).addClass(data.imageBar);
                  init_knob();
                });
              <?php } ?>
              <?php if ($learnVdoModel->learn_file_status != 's') { ?>
                scorminterval = setInterval(function() {
                  if (localStorage.learn_status == 'passed') {
                    console.log(localStorage.learn_status);
                    localStorage.removeItem("learn_status");
                    clearInterval(scorminterval);
                    $.post('<?php echo $this->createUrl("//course/LearnScorm"); ?>', {
                      id: <?php echo $file->id; ?>,
                      learn_id: <?php echo $learn_id; ?>,
                      status: "success"
                    }, function(data) {
                      data = JSON.parse(data);
                      $('#imageCheck' + data.no).html(data.image);
                      console.log("imageCheck 4");
                      $('#imageCheckBar' + data.no).removeClass();
                      $('#imageCheckBar' + data.no).addClass(data.imageBar);
                      init_knob();
                      if (data.imageBar == 'success') {
                        swal({
                            title: "<?= $pass_msg ?>",
                            text: "<?= $next_step_msg ?>",
                            type: "success",
                            confirmButtonText: "<?= $ok_msg ?>",
                            cancelButtonText: "<?= $cancel_msg ?>",
                            showCancelButton: true,
                            closeOnConfirm: true,
                            closeOnCancel: true
                          },
                          function(isConfirm) {
                            if (isConfirm) {
                              window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
                            }
                          }
                        );
                      }
                    });
                  }

                }, 3000);
              <?php } ?>
            </script>
            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
                  <h4 class="panel-title">
                    <a id="a_slide<?php echo $file->id; ?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?= $file->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $file->id; ?>">
                      <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >' . $statusValue . '</div> <label style="font-size: 22px;color: #000;">' . $model->title . '</label>'; ?></a>
                  </h4>
                </div>
                <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                  <div class="panel-body" style="background-color: #ddd; padding: 4px;">
                    <div>
                      <div class="split-me" id="split-me<?php echo $idx; ?>">
                        <div class="col-md-12" style="padding: 0;">
                          <!-- <div class="col-md-3 col-sm-3 list-scorm">
                                                 <td valign="top" height="100%" style="padding-left:5px;">
                                                    <div id="placeholder_treeContainer" ></div>
                                                </td>
                                              </div> -->
                          <div class="col-md-12 col-sm-12" display-scorm>
                            <div width="100%" height="100%" valign="top">
                              <div id="placeholder_contentIFrame"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $idx++;
          endforeach;
        } else if ($model->type == 'audio') {
          $imageTimeLast = 0;
          if ($model->fileAudio) {
            foreach ($model->fileAudio as $file) :
              $learnFiles = Helpers::lib()->checkLessonFileMobile($les, $learnModel->learn_id,$gen_id,$user_id);
              if ($learnFiles == "notLearn") {
                $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> ';
              } else if ($learnFiles == "learning") {
                $statusValue = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true"> ';
              } else if ($learnFiles == "pass") {
                $statusValue = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true"> ';
              }

              $learnVdoModel = LearnFile::model()->find(array(
                'condition' => 'file_id=:file_id AND learn_id=:learn_id AND gen_id=:gen_id',
                'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id, ':gen_id' => $gen_id)
              ));
              $imageSlide = AudioSlide::model()->findAll('file_id=:file_id AND image_slide_time != \'\'', array(':file_id' => $file->id));
            ?>
              <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
                    <h4 class="panel-title">
                      <a id="a_slide<?php echo $file->id; ?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?= $file->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $file->id; ?>">
                        <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >' . $statusValue . '</div> <label class="clname">' . $file->getRefileName() . '</label>'; ?></a>
                    </h4>
                  </div>
                  <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                  <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                    <div class="panel-body" style="background-color: #ddd; padding: 4px;">
                      <div>
                        <div class="split-me" id="split-me<?php echo $idx; ?>">

                          <div class="col-md-12" style="padding: 0px 0px 0px 15px;">
                            <a href="#" id="showslide<?php echo $idx; ?>" rel="prettyPhoto"> </a>
                          </div>
                          <div class="col-md-12 <?php echo empty($imageSlide) ? 12 : 6; ?>" style="padding: 0;">
                            <audio id="audio-player<?= $idx; ?>" src="<?php echo $uploadFolder . $file->filename; ?>" preload="auto" fileId="<?php echo $file->id; ?>" lesson_id="<?php echo $file->lesson_id; ?>" />
                          </div>
                          <?php if (!empty($imageSlide)) { ?>
                            <div class="col-md-12 showslidethumb" id="showslidethumb<?php echo $idx; ?>" style="overflow-x: auto; overflow-y: auto;">
                              <div class="row">
                                <?php
                                // $learnFiles = $user->learnFiles(array('condition' => 'file_id=' . $file->id));
                                $learnFiles = LearnFile::model()->findAll(array('condition' => 'file_id =' . $file->id . ' AND user_id_file = ' . $user_id . " AND gen_id='" . $gen_id . "'"));
                                foreach ($imageSlide as $key => $imageSlideItem) {
                                  $displayNone = "display:none;";
                                  if ($learnFiles[0]->learn_file_status != 'l' && $learnFiles[0]->learn_file_status != 's') {
                                    if ($learnFiles[0]->learn_file_status > $key || $learnFiles[0]->learn_file_status == $key) {
                                      $displayNone = "";
                                    }
                                  } else if ($learnFiles[0]->learn_file_status == 's') {
                                    $displayNone = "";
                                  }
                                  if (count($imageSlide) == 1) {
                                    $name = '';
                                  } else {
                                    $name = '-' . $imageSlideItem->image_slide_name;
                                  }
                                ?>
                                  <div class="col-md-2 col-xs-6" style="margin-top:10px; ">
                                    <img src="<?php echo Yii::app()->baseUrl . "/uploads/ppt_audio/" . $file->id . "/slide" . $name . ".jpg"; ?>" id="slide<?php echo $idx; ?>_<?php echo $key; ?>" class="slidehide<?php echo $idx; ?> img-responsive" style="<?php echo $displayNone; ?> margin-right:auto;margin-left:auto;" data-time="<?php echo $imageSlideItem->image_slide_time; ?>">
                                  </div>
                                <?php
                                }
                                ?>
                              </div>
                            </div>
                          <?php
                          }
                          ?>
                        </div>
                        <script type="text/javascript">
                          function clearAllRun<?php echo $idx; ?>() {
                            <?php
                            if (!empty($imageSlide)) {
                              foreach ($imageSlide as $key => $imageSlideItem) {
                            ?>
                                window.run<?php echo $idx; ?>_<?php echo $key; ?> = false;
                            <?php
                              }
                            }
                            ?>
                          }

                          audiojs.events.ready(function() {
                            var as = audiojs.create($("#audio-player" + <?php echo $idx; ?>));
                            var myPlayer<?php echo $idx; ?> = document.getElementById("audio-player" + <?php echo $idx; ?>);

                            <?php
                            $imageTimeLast = 0;
                            if (!empty($imageSlide)) {
                              $countSlide = count($imageSlide);
                              foreach ($imageSlide as $key => $imageSlideItem) {
                            ?>
                                window.run<?php echo $idx; ?>_<?php echo $key; ?> = false;
                                <?php
                                if ($learnVdoModel->learn_file_status != 's') {
                                  if ($countSlide == $key + 1) {
                                    $imageSlideLearnLast = AudioSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id' => $file->id, ':slide_name' => $learnVdoModel->learn_file_status));
                                    if ($imageSlideLearnLast) {
                                      $imageTimeLast = $imageSlideLearnLast->image_slide_time;
                                ?>
                                      myPlayer<?php echo $idx; ?>.currentTime = <?= $imageSlideLearnLast->image_slide_time ?>;
                            <?php
                                    }
                                  }
                                }
                              }
                            }
                            ?>

                            $('.vjs-seek-handle').attr('class', 'vjs-seek-handle<?php echo $idx; ?> vjs-slider-handle');

                            if (<?= $imageTimeLast ?> > myPlayer<?php echo $idx; ?>.currentTime) {
                              var currentTime<?php echo $idx; ?> = <?= $imageTimeLast ?>;
                            } else {
                              var currentTime<?php echo $idx; ?> = (myPlayer<?php echo $idx; ?>.currentTime);
                            }
                            element = '<div class="vjs-play-past<?php echo $idx; ?>" style="background-color:red;height:100%">';
                            element += '<span class="vjs-control-text<?php echo $idx; ?>">';
                            element += '</span>';
                            element += '</div>';
                            $(element).insertAfter(".vjs-seek-handle<?php echo $idx; ?>");
                            $('.vjs-play-progress').css({
                              "z-index": 9999
                            });
                            $('.vjs-play-past<?php echo $idx; ?>').css({
                              "opacity": 0.3
                            });

                            <?php
                            if ($learnVdoModel->learn_file_status != 's') {
                            ?>
                              $("#audio-player" + <?php echo $idx; ?>).on("seeking", function(event) {
                                if (currentTime<?php echo $idx; ?> < myPlayer<?php echo $idx; ?>.currentTime) {
                                  myPlayer<?php echo $idx; ?>.currentTime = currentTime<?php echo $idx; ?>;
                                }
                                clearAllRun<?php echo $idx; ?>();
                              });

                              setInterval(function() {
                                var timePlayed<?php echo $idx; ?> = currentTime<?php echo $idx; ?>;

                                if (Math.floor(timePlayed<?php echo $idx; ?>) % 6 == 0 && Math.floor(timePlayed<?php echo $idx; ?>) > 0) {
                                  // console.log("mod ----- "+Math.floor(timePlayed<?php echo $idx; ?>)%6);
                                  // console.log("time ----- "+Math.floor(timePlayed<?php echo $idx; ?>));
                                  // console.log("idx ----- "+<?php echo $idx; ?>);
                                  // console.log("++++++++++++++++++++++++++++++++++++++++++++++");
                                  save_time_video(Math.floor(timePlayed<?php echo $idx; ?>), <?php echo $idx; ?>);
                                }


                                var percenttimePlayed<?php echo $idx; ?> = (myPlayer<?php echo $idx; ?>.duration / 60);
                                percenttimePlayed<?php echo $idx; ?> = (100 / percenttimePlayed<?php echo $idx; ?>);
                                percenttimePlayed<?php echo $idx; ?> = (timePlayed<?php echo $idx; ?> / 60) * percenttimePlayed<?php echo $idx; ?>;

                                if (myPlayer<?php echo $idx; ?>.currentTime > timePlayed<?php echo $idx; ?>) {
                                  if (!myPlayer<?php echo $idx; ?>.paused) {
                                    currentTime<?php echo $idx; ?> = myPlayer<?php echo $idx; ?>.currentTime;
                                  }
                                }
                                $('.vjs-play-past<?php echo $idx; ?>').css({
                                  "width": percenttimePlayed<?php echo $idx; ?> + '%',
                                  "opacity": 0.3
                                });
                              }, 1000);
                            <?php
                            } else {
                            ?>
                              $("#audio-player" + <?php echo $idx; ?>).on("seeking", function(event) {
                                clearAllRun<?php echo $idx; ?>();
                              });
                            <?php
                            }
                            ?>

                            <?php
                            if ($learnVdoModel->learn_file_status != 's') {
                            ?>
                              $("#audio-player" + <?php echo $idx; ?>).on('play', function() {
                                $.post('<?php echo $this->createUrl("//course/LearnAudio"); ?>', {
                                  id: <?php echo $file->id; ?>,
                                  learn_id: <?php echo $learn_id; ?>
                                }, function(data) {
                                  data = JSON.parse(data);
                                  $('#imageCheck' + data.no).html(data.image);
                                  console.log("imageCheck 5");
                                  $('#imageCheckBar' + data.no).removeClass();
                                  $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                  init_knob();
                                });
                              });

                              $("#audio-player" + <?php echo $idx; ?>).on('ended', function() {
                                //  swal({
                                //   title: "<?= $pass_msg ?>",
                                //   text: "Waiting",
                                //   type: "success",
                                //   showConfirmButton: false,
                                //   showCancelButton: false,
                                // });
                                $.post('<?php echo $this->createUrl("//course/LearnAudio"); ?>', {
                                  id: <?php echo $file->id; ?>,
                                  learn_id: <?php echo $learn_id; ?>,
                                  status: "success"
                                }, function(data) {
                                  data = JSON.parse(data);
                                  $('#imageCheck' + data.no).html(data.image);
                                  console.log("imageCheck 6");
                                  $('#imageCheckBar' + data.no).removeClass();
                                  $('#imageCheckBar' + data.no).addClass(data.imageBar);
                                  init_knob();
                                  swal({
                                      title: "<?= $pass_msg ?>",
                                      text: "<?= $next_step_msg ?>",
                                      type: "success",
                                      confirmButtonText: "<?= $ok_msg ?>",
                                      cancelButtonText: "<?= $cancel_msg ?>",
                                      showCancelButton: true,
                                      closeOnConfirm: true,
                                      closeOnCancel: true
                                    },
                                    function(isConfirm) {
                                      if (isConfirm) {
                                        window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
                                      }
                                    }
                                  );
                                });
                              });
                            <?php
                            }
                            ?>

                            <?php
                            if (!empty($imageSlide)) {
                              $countSlide = count($imageSlide);
                              foreach ($imageSlide as $key => $imageSlideItem) {
                            ?>
                                window.run<?php echo $idx; ?>_<?php echo $key; ?> = false;
                                if (myPlayer<?php echo $idx; ?>.currentTime >= <?php echo ($imageSlideItem->image_slide_time) ? $imageSlideItem->image_slide_time : 0; ?>) {
                                  if (!run<?php echo $idx; ?>_<?php echo $key; ?>) {
                                    $('#showslide<?php echo $idx; ?>').attr('href', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                    $('#showslide<?php echo $idx; ?>').html($('#slide<?php echo $idx; ?>_<?php echo $key; ?>').clone());
                                    if ($('.pp_pic_holder').size() > 0) {
                                      $('#fullResImage').attr('src', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                    }
                                  }
                                }
                            <?php
                                if ($learnVdoModel->learn_file_status != 's') {
                                  if ($countSlide == $key + 1) {
                                    $imageSlideLearnLast = AudioSlide::model()->find('file_id=:file_id AND image_slide_time != \'\' AND image_slide_name=:slide_name', array(':file_id' => $file->id, ':slide_name' => $learnVdoModel->learn_file_status));
                                    if ($imageSlideLearnLast) {
                                      echo 'myPlayer' . $idx . '.currentTime = ' . $imageSlideLearnLast->image_slide_time . ';';
                                    }
                                  }
                                }
                              }
                            }
                            ?>

                            $('.slidehide<?php echo $idx; ?>').click(function(event) {
                              clearAllRun<?php echo $idx; ?>();
                              $('#showslide<?php echo $idx; ?>').attr('href', $(this).attr('src'));
                              $('#showslide<?php echo $idx; ?>').html($(this).clone());

                              myPlayer<?php echo $idx; ?>.currentTime = $(this).attr('data-time');
                            });

                            $("#audio-player" + <?php echo $idx; ?>).on('timeupdate', function() {
                              <?php
                              if (!empty($imageSlide)) {
                                foreach ($imageSlide as $key => $imageSlideItem) {
                              ?>
                                  if (myPlayer<?php echo $idx; ?>.currentTime >= <?php echo ($imageSlideItem->image_slide_time) ? $imageSlideItem->image_slide_time : 0; ?>) {
                                    if ($('#slide<?php echo $idx; ?>_<?php echo $key; ?>').css('display') == 'none') {
                                      $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').show('slow', function() {
                                        $('#showslide<?php echo $idx; ?>').attr('href', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                        $('#showslide<?php echo $idx; ?>').html($('#slide<?php echo $idx; ?>_<?php echo $key; ?>').clone());
                                        if ($('.pp_pic_holder').size() > 0) {
                                          $('#fullResImage').attr('src', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                        }
                                        $('#showslidethumb<?php echo $idx; ?>').scrollTop($('#showslidethumb<?php echo $idx; ?>')[0].scrollHeight);

                                        <?php
                                        if ($learnVdoModel->learn_file_status != 's') {
                                        ?>
                                          $.post('<?php echo $this->createUrl("//course/learnAudio"); ?>', {
                                            id: <?php echo $file->id; ?>,
                                            learn_id: <?php echo $learn_id; ?>,
                                            slide_number: <?php echo $key; ?>
                                          }, function(data) {

                                          });
                                        <?php
                                        }
                                        ?>
                                      });
                                    } else {
                                      if (!run<?php echo $idx; ?>_<?php echo $key; ?>) {
                                        $('#showslide<?php echo $idx; ?>').attr('href', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                        $('#showslide<?php echo $idx; ?>').html($('#slide<?php echo $idx; ?>_<?php echo $key; ?>').clone());
                                        if ($('.pp_pic_holder').size() > 0) {
                                          $('#fullResImage').attr('src', $('#slide<?php echo $idx; ?>_<?php echo $key; ?>').attr('src'));
                                        }
                                      }
                                    }
                                    window.run<?php echo $idx; ?>_<?php echo $key; ?> = true;
                                  }
                              <?php
                                }
                              }
                              ?>
                            });
                            var focused = true;
                            document.addEventListener("visibilitychange", function() {
                              focused = !focused;
                              if (!focused) {
                                var myPlayer = videojs("example_video_<?php echo $idx; ?>");
                                // console.log("2 : "+status_in_learn_note);

                                myPlayer.pause();
                              }
                            });

                            function setTimeRollback<?php echo $idx; ?>(time) {
                              currentTime<?php echo $idx; ?> = time;
                            }

                            function getCurrentTimeRollback<?php echo $idx; ?>() {
                              return currentTime<?php echo $idx; ?>;
                            }
                          });
                        </script>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <?php
              $idx++;
            endforeach;
          }
        } else if ($model->type == 'youtube') {
          ?>
          <script type="text/javascript">
            var youyube_playing;
            $(document).ready(function() {

              var $win = $(window); // or $box parent container
              var $box = $(".youtube-iframe");
              $win.on("click.Bst", function(event) {
                if ($box.has(event.target).length == 0 && !$box.is(event.target)) {

                  <?php foreach ($model->files as $file) { ?>
                    player_<?= $file->id ?>.pauseVideo();
                  <?php } ?>

                } else {
                  console.log("elseeeeee");
                }
              });


            });



            function pauseVideoYoutube() {

            }


            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);


            var arr_Duration = new Array();
            var arr_status = new Array();

            function onPlayerReady(event) {

              var id_you = $(event.target.h).attr("id").split("_");
              id_you = id_you[1];
              arr_Duration[id_you] = event.target.getDuration();
            }

            function onPlayerPlaybackRateChange(event) {

            }

            function onPlayerError(event) {
              // 2 – The request contains an invalid parameter value. For example, this error occurs if you specify a video ID that does not have 11 characters, or if the video ID contains invalid characters, such as exclamation points or asterisks.
              // 5 – The requested content cannot be played in an HTML5 player or another error related to the HTML5 player has occurred.
              // 100 – The video requested was not found. This error occurs when a video has been removed (for any reason) or has been marked as private.
              // 101 – The owner of the requested video does not allow it to be played in embedded players.
              // 150 – This error is the same as 101. It's just a 101 error in disguise!


            }


            var mysetInterval, event_playing;


            // var done = false;
            function onPlayerStateChange(event) {
              // console.log(event);

              if (event.data == 1) { //play
                youyube_playing = event;
                var id_you = $(event.target.h).attr("id").split("_");
                id_you = id_you[1];
                <?php foreach ($model->files as $file) { ?>
                  if (id_you != <?= $file->id ?>) {
                    player_<?= $file->id ?>.pauseVideo();
                  }
                <?php } ?>
                mysetInterval = setInterval(followVDOyoutube, 1000);
                event_playing = event;
                // console.log("event_playing   play");
                // console.log(event_playing);
                $(window).focus();

              } else if (event.data == 2) { //paused
                event.target.pauseVideo();
                clearInterval(mysetInterval);
                $(window).focus();

              } else if (event.data == 3) { // รี

              } else if (event.data == 0) { // จบ
                // console.log("event_playing    end");
                // console.log(event_playing);


                // l m o           
                var id_you = $(event_playing.target.o).attr("id").split("_");
                id_you = id_you[1];

                // console.log(id_you);

                event_playing = event;
                arr_status[id_you] = 1;
                updateStatus(id_you);
                clearInterval(mysetInterval);
                // console.log("end");
              }





            }


            function followVDOyoutube() { // ติดตามเวลา vdo

              var id_you = $(event_playing.target.o).attr("id").split("_");
              id_you = id_you[1];


              if (event_playing.data == 1 && arr_status[id_you] == 2) {



                $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                  id: id_you,
                  learn_id: <?php echo $learn_id; ?>,
                  page: "LearnVdo",
                }, function(data) {

                  if (data == "logout") {
                    Swal.fire({
                      title: 'กรุณาเข้าสู่ระบบ',
                      icon: 'error',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'ตกลง',
                      cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                      window.location = "https://elearning.imct.co.th/";
                    });

                  } else {

                    data = JSON.parse(data);
                    //อัพเดต ให้ไอคอนบอกว่า กำลังเรียน
                    $('#imageCheck' + data.no).html(data.image);
                    $('#status_block_' + data.no).removeClass();
                    $('#status_block_' + data.no).addClass("label label-warning");
                    $('#status_block_' + data.no).html("<?php echo $msg_learning; ?>");
                    // console.log("imageCheck 1");
                    $('#imageCheckBar' + data.no).removeClass();
                    $('#imageCheckBar' + data.no).addClass(data.imageBar);
                    init_knob();
                  }



                });


              }

            }

            function updateStatus(file_id) {

              $.post('<?php echo $this->createUrl("//course/LearnVdo"); ?>', {
                id: file_id,
                learn_id: <?php echo $learn_id; ?>,
                status: "success",
                page: "LearnVdo",
              }, function(data) {

                if (data == "logout") {
                  Swal.fire({
                    title: 'กรุณาเข้าสู่ระบบ',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก'
                  }).then((result) => {
                    window.location = "https://elearning.imct.co.th/";
                  });

                } else {

                  data = JSON.parse(data);
                  $('#imageCheck' + data.no).html(data.image);
                  $('#status_block_' + data.no).removeClass();
                  $('#status_block_' + data.no).addClass("label label-success");
                  $('#status_block_' + data.no).html("<?php echo $msg_learn_pass; ?>");
                  // console.log("imageCheck 2");
                  $('#imageCheckBar' + data.no).removeClass();
                  $('#imageCheckBar' + data.no).addClass(data.imageBar);
                  init_knob();
                  if (data.imageBar == 'success') { // แถบสถานะ เรียบจบ
                    swal({
                        title: "<?= $pass_msg ?>",
                        text: "<?= $next_step_msg ?>",
                        type: "success",
                        confirmButtonText: "<?= $ok_msg ?>",
                        cancelButtonText: "<?= $cancel_msg ?>",
                        showCancelButton: true,
                        closeOnConfirm: true,
                        closeOnCancel: true
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                          window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
                        }
                      }
                    );
                  }

                }
              });

            }







            function stopVideo() {
              player.stopVideo();
              // console.log(player.getCurrentTime());

            }

            <?php foreach ($model->files as $file) { ?>
              var player_<?= $file->id ?>;
            <?php } ?>

            function onYouTubeIframeAPIReady() {
              <?php foreach ($model->files as $file) { ?>
                player_<?= $file->id ?> = new YT.Player('youtube_<?= $file->id ?>', {
                  height: 'auto',
                  width: '100%',
                  videoId: link_video_<?= $file->id ?>,
                  host: 'https://www.youtube.com',
                  events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange,
                    'onError': onPlayerError,
                    'onPlaybackRateChange': onPlayerPlaybackRateChange
                  }
                });
              <?php } ?>
            }
          </script>


          <?php
          foreach ($model->files as $file) {
            $youtube_id = $file->filename;
            $youtube_id = explode("v=", $youtube_id);
            $youtube_id = $youtube_id[1];
            $youtube_id = explode("&", $youtube_id);
            $youtube_id = $youtube_id[0];


            $learnFiles = Helpers::lib()->checkLessonFileMobile($les, $learnModel->learn_id,$gen_id,$user_id);
          ?>
            <script type="text/javascript">
              arr_status[<?= $file->id ?>] = 2;
            </script>
            <?php

            if ($learnFiles == "notLearn") {
              $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> ';
            } else if ($learnFiles == "learning") {
              $statusValue = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true"> ';
            } else if ($learnFiles == "pass") {
              $statusValue = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true"> ';
            ?>
              <script type="text/javascript">
                arr_status[<?= $file->id ?>] = 1;
              </script>
            <?php
            }


            ?>
            <div class="panel-group" id="accordion<?= $file->id; ?>" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?php echo $file->id; ?>">
                  <h4 class="panel-title">
                    <a id="a_slide<?php echo $file->id; ?>" data-toggle="collapse" data-parent="#myGroup" href="#collapse<?= $file->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $file->id; ?>">
                      <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck' . $file->id . '" >' . $statusValue . '</div> <label class="clname">' . $file->getRefileName() . '</label>'; ?></a>
                  </h4>
                </div>
                <span style="color:red; font-weight: bold; font-size: 20px; " id="timeTest1"></span>
                <div id="collapse<?php echo $file->id; ?>" class="panel-collapse collapse<?php echo ($idx == 1) ? " in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $file->id; ?>">
                  <div class="panel-body" style="background-color: #ddd; padding: 4px;">
                    <div class="split-me" id="split-me<?php echo $idx; ?>">
                      <div class="col-md-<?php echo empty($imageSlide) ? 12 : 6; ?>" style="padding: 0; margin-bottom: 10px;">
                        <div class="youtube-iframe" id="youtube_<?= $file->id ?>"></div>
                      </div>
                      <div class="encredit">
                        <h4>End credits: <?= $file->encredit; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <script type="text/javascript">
              var youtube_<?= $file->id ?>;
              var link_video_<?= $file->id ?> = "<?= $youtube_id ?>";
              // console.log(link_video_<?= $file->id ?>);
            </script>
            <?php
            $idx++;
          }
        } else if (count($model->filePdf) && $model->type == 'pdf') {
          //$modelPdf = ControlVdo::getChilds($_GET['id'],0,$lessonCurrent->type);
          if ($model->filePdf) {
            foreach ($model->filePdf as $key => $file) {
              $learnFiles = Helpers::lib()->checkLessonFileMobile($les, $learnModel->learn_id,$gen_id,$user_id);
              if ($learnFiles == "notLearn") {
                $statusValue = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#F00" data-readonly="true"> ';
              } else if ($learnFiles == "learning") {
                $statusValue = '<input type="text" class="knob" value="50" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#ff8000" data-readonly="true"> ';
              } else if ($learnFiles == "pass") {
                $statusValue = '<input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="25" data-height="25" data-displayInput="false" data-fgColor="#0C9C14" data-readonly="true"> ';
              }
            ?>
              <input type="hidden" value="<?= $_GET['file']; ?>" id="file_active">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading">
                  <h4 class="panel-title">
                    <?php
                    if ($learnFiles == "pass" || $fild_pdf->parent_id == 0) {
                    ?>
                      <a id="a_slide_<?php echo $file->id; ?>" data-toggle="collapse" data-parent="#accordion2" href="#collapsepdf_<?php echo $file->id; ?>" aria-expanded="true" onclick="active_file(<?php echo $file->id . ',' . $learn_id; ?>)" aria-controls="collapsepdf_<?php echo $file->id; ?>">
                      <?php  } else { ?>
                        <a id="a_slide_<?php echo $file->id; ?>" data-toggle="collapse" data-parent="#accordion2" href="#collapsepdf_<?php echo $file->id; ?>" aria-expanded="true" onclick="active_file(<?php echo $file->id . ',' . $learn_id; ?>)" aria-controls="collapsepdf_<?php echo $file->id; ?>" onclick="getAlertMsg('<?= $learnPdfMsg ?>')">
                        <?php
                      }
                      if ($file->RefileName == '') {
                        $fileNameCheck = '-';
                      } else {
                        $fileNameCheck = $file->RefileName;
                      }
                        ?>
                        <?php echo '<div style="float: left; margin-right:10px;" id="imageCheck_' . $file->id . '" >' . $statusValue . '</div> <label style="font-size: 16px;color: #000;">' . $fileNameCheck . '</label>'; ?>
                        </a>
                  </h4>
                </div>
                <div id="collapsepdf_<?php echo $file->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                  <div class="panel-body" style="background-color: #666; padding: 4px;">
                    <div>
                      <div class="split-me" id="split-me<?= $file->id; ?>">
                        <div class="col-md-12" style="padding: 0;">

                          <!-- START Learn PDF -->
                          <div id="myCarousel<?= $file->id; ?>" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <?php
                            $modelLearnFilePdf = LearnFile::model()->find(array(
                              'condition' => 'file_id=:file_id AND learn_id=:learn_id AND gen_id=:gen_id',
                              'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id, ':gen_id' => $gen_id)
                            ));

                            if ($modelLearnFilePdf->learn_file_status == 's') {

                              $directory =  Yii::app()->basePath . "/../uploads/pdf/" . $file->id . "/";
                              $filecount = 0;
                              $files = glob($directory . "*.{jpg}", GLOB_BRACE);
                              if ($files) {
                                $filecount = count($files);
                              }
                              $filePdf = $filecount;
                            } else {
                              $filePdf = $modelLearnFilePdf->learn_file_status;
                            }
                            ?>
                            <ol class="carousel-indicators carousel-indicators-numbers" id="indicators<?= $file->id; ?>">
                              <?php
                              // for ($x = 1; $x <= $filePdf; $x = $x + 5) {
                              for ($x = 1; $x <= $filePdf; $x++) {
                              ?>
                                <?php

                                if ($x == $filePdf) {
                                  $active = 'class="active"';
                                } else {
                                  $active = 'class';
                                }
                                ?>
                                <li data-target="#myCarousel<?= $file->id; ?>" data-slide-to="<?= $x - 1 ?>" <?= $active ?>> <?= $x ?> </li>
                              <?php
                              }
                              ?>
                              <!--   <li data-target="#myCarousel<?= $file->id; ?>" data-slide-to="11">11</li>
                                                  <li data-target="#myCarousel<?= $file->id; ?>" data-slide-to="12">12</li> -->
                            </ol>



                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" id="carouselInner<?= $file->id; ?>">
                              <?php
                              // $modelLearnFilePdf = LearnFile::model()->find(array(
                              //  'condition' => 'file_id=:file_id AND learn_id=:learn_id',
                              //  'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id)
                              // ));
                              if (is_numeric($modelLearnFilePdf->learn_file_status)) $statSlide = true;
                              $modelFilePdf = PdfSlide::model()->findAll(array(
                                'condition' => 'file_id=' . $file->id,
                                'order' => 'image_slide_time'
                              ));
                              foreach ($modelFilePdf as $keyFile => $value) {
                                $status = "";
                                if ($statSlide) {
                                  if ($keyFile == $modelLearnFilePdf->learn_file_status) {
                                    $status = 'active';
                                    $timeCountDown = $value->image_slide_next_time;
                                  }
                                } else {
                                  if ($keyFile == 0) {
                                    $status = 'active';
                                    $timeCountDown = $value->image_slide_next_time;
                                  }
                                }
                                if (count($modelFilePdf) == 1) {
                                  $name = '';
                                } else {
                                  $name = '-' . $value->image_slide_name;
                                }
                              ?>
                                <div class="item <?= $status ?> ">
                                  <a href="<?= Yii::app()->baseUrl . "/uploads/pdf/" . $file->id . "/slide" . $name; ?>.jpg" rel="prettyPhoto">
                                    <img src="<?= Yii::app()->baseUrl . "/uploads/pdf/" . $file->id . "/slide" . $name; ?>.jpg">
                                  </a>
                                  <p class="pageIndex"><?php echo ($keyFile + 1) . "/" . count($modelFilePdf); ?></p>
                                </div>
                              <?php
                              } ?>

                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel<?= $file->id; ?>" data-slide="prev" id="prePageTag<?= $file->id; ?>" <?php //if($modelLearnFilePdf->learn_file_status!='s') echo 'style="display:none;"'; 
                                                                                                                                                    ?>>
                              <span class="glyphicon glyphicon-chevron-left"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel<?= $file->id; ?>" data-slide="next" <?php if ($modelLearnFilePdf->learn_file_status != 's') echo 'style="display:none;"'; ?> id="nextPageTag<?= $file->id; ?>">
                              <span class="glyphicon glyphicon-chevron-right"></span>
                              <span class="sr-only">Next</span>
                            </a>
                          </div>

                          <div class="pageTime" style="display: none" id="timeCountdownCarousel<?= $file->id; ?>">
                          </div>
                          <!-- END Learn PDF -->

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <script>
                $('#myCarousel<?= $file->id; ?>').on('slid.bs.carousel', '', function() {
                  // console.log("เลื่อน slide");

                  <?php if ($modelLearnFilePdf->learn_file_status != 's') { ?>
                    $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                    var $this = $(this);
                    $this.children('.left.carousel-control').show();

                    if ($('#carouselInner<?= $file->id; ?> .item:first').hasClass('active')) {
                      $("#myCarousel<?= $file->id; ?>").children("#prePageTag<?= $file->id; ?>").hide();
                    }

                    var carouselData = $(this).data('bs.carousel');
                    var currentIndex = carouselData.getItemIndex(carouselData.$element.find('.item.active'));
                    setCurrentSlide(currentIndex);
                    var slideFrom = $(this).find('.active').index();
                    //Captcha PDF

                    var checkSlide = <?= isset($time->captchaTime->slide) ? $time->captchaTime->slide : 0; ?>;
                    var prev_slide = <?= isset($time->captchaTime->prev_slide) ? $time->captchaTime->prev_slide : 0; ?>;
                    var course_id = <?= $model->course_id; ?>;
                    // var slideInDatabase = <?= $modelLearnFilePdf->learn_file_status; ?>;
                    var slideInDatabase = <?= isset($modelLearnFilePdf->learn_file_status) ? $modelLearnFilePdf->learn_file_status : 0 ?>;
                    // $.post('<?php echo $this->createUrl("//course/GetSlide"); ?>', {
                    //  id: <?php echo $file->id; ?>,
                    //  learn_id: <?php echo $learn_id; ?>
                    // }, function (data) {
                    //  data = JSON.parse(data);
                    //   slideInDatabase  = parseInt(data.slide);
                    // });
                    <?php
                    $checkType = in_array("2", json_decode($time->captchaTime->type));
                    if (!$checkType) {
                      $checkType = 0;
                    }
                    ?>

                    var checkType = <?= $checkType ?>; //0 = dont have, 1 = have type PDF
                    // console.log('currentIndex: '+currentIndex);
                    if (currentIndex % checkSlide == 0 && checkType) {
                      $.post('<?php echo $this->createUrl("//course/GetSlide"); ?>', {
                        id: <?php echo $file->id; ?>,
                        learn_id: <?php echo $learn_id; ?>
                      }, function(data) {
                        data = JSON.parse(data);
                        slideInDatabase = parseInt(data.slide);
                        console.log('slideBase: ' + slideInDatabase);
                        if (parseInt(currentIndex) > slideInDatabase) {
                          $('#ValidateCaptcha_verifyCode').val("");
                          $('#newModal').modal({
                            backdrop: 'static',
                            keyboard: false
                          });
                          // $.ajax({
                          //     url: "<?php echo Yii::app()->createUrl("course/saveCaptchaStart"); ?>",
                          //     type: "POST",
                          //     dataType: 'json',
                          //     data: $("#validate-form").serialize(),
                          //     success:function(data){
                          //         setCurrentSlide(currentIndex);
                          //         if(data.timeBack)time_test_start_pdf(data.timeBack,currentIndex);
                          //     }
                          // });
                        } else {
                          console.log("LearnPdf 1");
                          $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
                            id: <?php echo $file->id; ?>,
                            learn_id: <?php echo $learn_id; ?>,
                            slide: currentIndex
                          }, function(data) {
                            data = JSON.parse(data);
                            if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
                              $('#indicators' + data.no).append(data.indicators);
                            }
                            console.log(data.status);
                            if (data.status) {
                              <?php
                              if (isset($_GET['file'])) {
                                // $modelFilePdfCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['file']));
                                // $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFilePdfCollapse->id));
                                // foreach ($modelFilsChk as $key => $val) {
                              ?>
                                // $('#ic_a_pdf_'+<?= $val->file_id; ?>).attr("href", "<?= $this->createUrl('learn/learning', array('id' => $_GET['id'], 'course_id' => $_GET['course_id'], 'collapsepdf' => $val->file_id)); ?>");
                                // $('#ic_a_pdf_<?= $val->file_id; ?>').removeAttr("onclick");
                                // $("#a_slide_<?= $val->file_id; ?>").removeAttr("onclick");
                                // $("#a_slide_<?= $val->file_id; ?>").attr("href","#collapsepdf_<?php echo $val->file_id; ?>");
                              <?php
                                // }
                              }
                              ?>
                              $('#ic_pdf_' + data.no).addClass("o-view");


                            }

                            //if(data.camera)
                            $('#imageCheck_' + data.no).html(data.image);
                            console.log("imageCheck 7");
                            if (data.timeNext) {
                              $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                              countdownTime(data.timeNext, <?= $file->id; ?>, data.status, <?= $langId ?>);
                            } else {
                              clearInterval(interval);
                              $("#nextPageTag<?= $file->id; ?>").css("display", "block");
                              $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
                              if (data.learn_file_status == 's') {
                                swal({
                                    title: "<?= $pass_msg ?>",
                                    text: "<?= $next_step_msg ?>",
                                    type: "success",
                                    confirmButtonText: "<?= $ok_msg ?>",
                                    cancelButtonText: "<?= $cancel_msg ?>",
                                    showCancelButton: true,
                                    closeOnConfirm: true,
                                    closeOnCancel: true
                                  },
                                  function(isConfirm) {
                                    if (isConfirm) {
                                      window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
                                    }
                                  }
                                );
                              }
                            }
                            init_knob();
                          }); //end post course/LearnPdf
                        }
                      });

                    } else {
                      // currentIndex = currentIndex-1;
                      // console.log("LearnPdf 2");
                      // console.log("currentIndex "+currentIndex);

                      $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
                        id: <?php echo $file->id; ?>,
                        learn_id: <?php echo $learn_id; ?>,
                        slide: currentIndex
                      }, function(data) {
                        data = JSON.parse(data);
                        if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
                          $('#indicators' + data.no).append(data.indicators);
                        }
                        console.log(data.status);
                        if (data.status) {
                          <?php
                          if (isset($_GET['file'])) {
                            // $modelFilePdfCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['file']));
                            // $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFilePdfCollapse->id));
                            // foreach ($modelFilsChk as $key => $val) {
                          ?>
                            // $('#ic_a_pdf_'+<?= $val->file_id; ?>).attr("href", "<?= $this->createUrl('learn/learning', array('id' => $_GET['id'], 'course_id' => $_GET['course_id'], 'collapsepdf' => $val->file_id)); ?>");
                            // $('#ic_a_pdf_<?= $val->file_id; ?>').removeAttr("onclick");
                            // $("#a_slide_<?= $val->file_id; ?>").removeAttr("onclick");
                            // $("#a_slide_<?= $val->file_id; ?>").attr("href","#collapsepdf_<?php echo $val->file_id; ?>");
                          <?php
                            // }
                          }
                          ?>
                          $('#ic_pdf_' + data.no).addClass("o-view");

                        }

                        //if(data.camera)
                        $('#imageCheck_' + data.no).html(data.image);
                        // console.log("imageCheck 8");
                        if (data.timeNext) {
                          $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                          countdownTime(data.timeNext, <?= $file->id; ?>, data.status, <?= $langId ?>);
                        } else {
                          clearInterval(interval);
                          $("#nextPageTag<?= $file->id; ?>").css("display", "block");
                          $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
                          if (data.learn_file_status == 's') {
                            swal({
                                title: "<?= $pass_msg ?>",
                                text: "<?= $next_step_msg ?>",
                                type: "success",
                                confirmButtonText: "<?= $ok_msg ?>",
                                cancelButtonText: "<?= $cancel_msg ?>",
                                showCancelButton: true,
                                closeOnConfirm: true,
                                closeOnCancel: true
                              },
                              function(isConfirm) {
                                if (isConfirm) {
                                  window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
                                }
                              }
                            );
                          }
                        }
                        init_knob();
                      }); //end post course/LearnPdf
                    }
                  <?php } ?>
                });
              </script>
        <?php
            } //end for
          } //end if
        }
        ?>
        <!-- DEFAULT -->
      </div>
    </div>

  </div>
</div>
</div>
<div style="margin-top:150px; z-index: 99999; " class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="form">
      <div class="row">
        <?php $form = $this->beginWidget('CActiveForm', array(
          'id' => 'validate-form',
          'enableClientValidation' => true,
          'clientOptions' => array(
            'validateOnSubmit' => true,
          ),
          'htmlOptions' => array(
            'onsubmit' => 'return false',
          ),
        )); ?>
        <div class="modal-content">
          <?php if (CCaptcha::checkRequirements()) : ?>
            <div class="modal-header">
              <?php echo $form->labelEx($modelCapt, 'verifyCode'); ?>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <!-- <input type="hidden" id="videoIdx" name="videoIdx" value="example_video_1">
                                            <input type="hidden" id="fileId" name="fileId" value="">
                                            <input type="hidden" id="index" name="index" value="">
                                            <input type="hidden" id="ValidateCaptcha_cnid" name="ValidateCaptcha[cnid]" value="<?= $model->course_id; ?>">
                                            <input type="hidden" id="ValidateCaptcha_lid" name="ValidateCaptcha[lid]" value=""> -->
                  <?php $this->widget('CCaptcha'); ?>
                  <?php echo $form->textField($modelCapt, 'verifyCode', array('class' => 'form-control ')); ?>
                </div>
                <div class="col-md-6" style="margin-top: 10px;">
                  กรุณากรอกภายใน : <span style="color:red; font-weight: bold; font-size: 20px;" id="timeTest"></span>
                  <div class="hint" style="margin-top: 10px;">กรุณากรอกรหัสยืนยันให้ตรงกับภาพที่แสดง
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <?php if ($model->type == 'vdo') { ?>
                <button type="button" id="yt0" class="btn btn-primary">ยืนยัน</button>
              <?php } else if ($model->type == 'pdf') { ?>
                <button type="button" id="yt1" class="btn btn-primary">ยืนยัน</button>
              <?php } ?>
            </div>
          <?php endif; ?>
        </div>
        <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>
</div>

<div style="margin-top:150px; z-index: 99999; " class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="form">
      <div class="row">
        <?php $form = $this->beginWidget('CActiveForm', array(
          'id' => 'validate-form-new',
          'enableClientValidation' => true,
          'clientOptions' => array(
            'validateOnSubmit' => true,
          ),
          'htmlOptions' => array(
            'onsubmit' => 'return false',
          ),
        )); ?>
        <div class="modal-content">
          <div class="modal-header">
            Check
          </div>
          <div class="modal-body">
            <input type="hidden" id="videoIdx" name="videoIdx" value="example_video_1">
            <input type="hidden" id="fileId" name="fileId" value="">
            <input type="hidden" id="index" name="index" value="">
            <input type="hidden" id="ValidateCaptcha_cnid" name="ValidateCaptcha[cnid]" value="<?= $model->course_id; ?>">
            <input type="hidden" id="ValidateCaptcha_lid" name="ValidateCaptcha[lid]" value="">
            <div class="row">
              <div class="col-md-12">
                <?= $captcha ?>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <?php if ($model->type == 'vdo') { ?>
              <button type="button" id="yt2" class="btn btn-primary"><?= $buttonok ?></button>
            <?php } else if ($model->type == 'pdf') { ?>
              <button type="button" id="yt3" class="btn btn-primary"><?= $buttonok ?></button>
            <?php } ?>
          </div>
        </div>
        <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="stopLearn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
      </div>
      <div class="modal-body text-center">
        Please intend to study
      </div>
      <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div> -->
    </div>
  </div>
</div>

<script>
  function init_knob() {
    $(".knob").knob({
      draw: function() {
        if (this.$.data('skin') == 'tron') {
          var a = this.angle(this.cv) // Angle
            ,
            sa = this.startAngle // Previous start angle
            ,
            sat = this.startAngle // Start angle
            ,
            ea // Previous end angle
            , eat = sat + a // End angle
            ,
            r = true;
          this.g.lineWidth = this.lineWidth;
          this.o.cursor &&
            (sat = eat - 0.3) &&
            (eat = eat + 0.3);
          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor &&
              (sa = ea - 0.3) &&
              (ea = ea + 0.3);
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
  }
  var current_slide

  function setCurrentSlide(current_slide) {
    this.current_slide = current_slide;
  }

  function getCurrentSlide() {
    return current_slide;
  }
</script>

<script type="text/javascript">
  $(document).ready(function() {



    <?php if ($model->type == 'pdf') { ?>

      function getSlideFromDatabase() {
        var slideInDatabase;
        $.post('<?php echo $this->createUrl("//course/GetSlide"); ?>', {
          id: <?php echo $file->id; ?>,
          learn_id: <?php echo $learn_id; ?>
        }, function(data) {
          data = JSON.parse(data);
          slideInDatabase = parseInt(data.slide);
          console.log('slideBase: ' + slideInDatabase);
        });
      }
    <?php } ?>
    var myVar;
    var width = $(document).width();
    var height = $(document).height();
    var arr_videoId = new Array();
    $(".video-js").each(function(videoIndex) {
      var videoId = $(this).attr("id");
      var lessonId = $(this).attr("lesson_id");
      var index = $(this).attr("index");
      var fileId = $(this).attr("fileId");
      var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
      arr_videoId.push(videoId);
      var myPlayer = videojs(videoId);
      //detect Click out bound video
      var $win = $(window); // or $box parent container
      var $box = $(".video-js");
      $win.on("click.Bst", function(event) {
        if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
          // alert('you clicked outside the video');

          // console.log("3 : "+status_in_learn_note);
          var idx_status_in_learn_note = parseInt("<?php echo $idx; ?>") - 1;

          if (status_in_learn_note != "no") {
            if (status_in_learn_note <= idx_status_in_learn_note) {
              status_in_learn_note = status_in_learn_note + 1;
            } else {
              status_in_learn_note = "no";
              myPlayer.pause();
            }
          } else {
            myPlayer.pause();
          }
        }
        // else {
        //     console.log('you clicked inside the video');
        // }
      });
      //Detect key for stop video
      var keys = {};
      $(document).keydown(function(e) {
        // console.log(e.which);
        // 17 Ctrl, 18 Alt, 9 Tab
        if (e.which == 17 || e.which == 18 || e.which == 9) {
          // console.log("4 : "+status_in_learn_note);

          myPlayer.pause();
        }
      });

      //Restore down (mini size browser)
      $(window).bind('resize', function() {
        // alert('STOP');
        var current_width = $(document).width();
        var current_height = $(document).height();
        // console.log("5 : "+status_in_learn_note);

        myPlayer.pause();
        if (current_width < width && current_height < height) {
          console.log('HIDE !!!!!!!!!!!');
          //vjs-paused
          $(".vjs-control-bar").css("display", "none");
          $("video").css("display", "none");
          $('video').click(function() {
            return false;
          });
          $('#stopLearn').modal({
            backdrop: 'static',
            keyboard: false
          });
          $('#stopLearn').modal('show');
          // $('video').click(false);
          // console.log("6 : "+status_in_learn_note);

          myPlayer.pause();
        } else {
          $(".vjs-control-bar").css("display", "block");
          $("video").css("display", "block");
          $('video').click(function() {
            return false;
          });
          $('#stopLearn').modal('hide');
          // $('video').click(true);
        }

      });

      window.onblur = function() {
        // console.log('blur'); 
        for (var i = 0; i < arr_videoId.length; i++) {
          videojs(arr_videoId[i]).pause();
          // console.log("7 : "+status_in_learn_note);
          // myPlayer.pause();
        }
      }

      _V_(videoId).ready(function() {
        if (iOS) {
          <?php if (!empty($imageSlideLearnLast->image_slide_time)) { ?>
            swal({
              title: "ระบบ!",
              text: "คุณสามารถเลื่อนเวลาเพื่อดูวิดีโอได้",
              type: "warning",
            });
          <?php } ?>
        }
        this.load();
        this.on("play", function(e) {
          $("#videoIdx").val(videoId);
          $("#ValidateCaptcha_lid").val(lessonId);
          $("#index").val(index);
          $("#fileId").val(fileId);

          var timeSetRandom = <?= $time->captchaTime->capt_time_random * 60 ?>;
          var myPlayer = videojs(videoId);
          var currentTime = myPlayer.currentTime();
          var modulus = currentTime % timeSetRandom;
          var time = timeSetRandom - modulus;
          var allTime = currentTime + time;
          var lengthOfVideo;
          lengthOfVideo = myPlayer.duration();
          <?php $checkType = in_array("1", json_decode($time->captchaTime->type));
          if (!$checkType) {
            $checkType = 0;
          }
          ?>
          <?php if ($learnFiles->learn_file_status != 's' && $time && $checkType) { ?>
            clearTimeout(myVar);
            myVar = setTimeout(function() {
              checkTime();
            }, timeSetRandom * 1000); //timeSetRandom
          <?php } ?>
          $(".video-js").each(function(index) {
            if (videoIndex !== index) {
              // console.log("8 : "+status_in_learn_note);

              this.player.pause();
            }
          });
        });

        this.on("pause", function(e) {
          clearTimeout(myVar);
          // clearInterval(interval);
        });


      });
    });

    $("a[rel^='prettyPhoto']").prettyPhoto({
      social_tools: false
    });

    $('.carousel').carousel({
      interval: false
    });
  });
</script>

<script>
  function hideImage(idx = 0, count, i) {
    count = parseInt(count);
    i = parseInt(i);
    for (i; i < count; i++) {
      $("img#slide" + idx + "_" + i).css("display", "none");
    }
  }

  $(document).ready(function() {
    localStorage.removeItem("learn_status");
    <?php if ($model->type == 'vdo' || $model->type == 'scorm') { ?>
      $("#collapse<?= $_GET['collapse'] ?>").addClass("collapse in");
    <?php } else { ?>
      $("#collapsepdf_<?= $_GET['file'] ?>").addClass("collapse in");
      if ($('.carousel-inner .item:first').hasClass('active')) {
        $("#myCarousel<?= $_GET['file']; ?>").children('.left.carousel-control').hide();
      } else {
        $("#myCarousel<?= $_GET['file']; ?>").children('.left.carousel-control').show();
      }
      <?php if (!empty($timeCountDown) && $learnFiles != "pass") { ?>
        var t = new Date();
        t.setSeconds(t.getSeconds() + <?= $timeCountDown; ?>);
        $("#myCarousel<?= $_GET['file']; ?>").children("#nextPageTag<?= $_GET['file']; ?>").hide();
        countdownTime(<?= $timeCountDown ?>, <?= $_GET['file']; ?>, 'null', <?= $langId ?>);
      <?php } else { ?>
        $("#myCarousel<?= $_GET['file']; ?>").children("#nextPageTag<?= $_GET['file']; ?>").show();
        $("#myCarousel<?= $_GET['file']; ?>").children("#prePageTag<?= $_GET['file']; ?>").show();
    <?php }
    } ?>

    $('.carousel').carousel({
      interval: false
    });
  });

  function openNav() {
    document.getElementById("mySidenav").style.width = "400px";
    document.getElementById("main").style.marginRight = "400px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginRight = "0";
  }

  function active_file(file_id, learn_id) {
    $('#file_active').val(file_id);
    time_countdown_start_ajax(learn_id);
  }

  function time_countdown_start_ajax(learn_pdf_id) {
    var file_id = $('#file_active').val();
    $.ajax({
      url: "<?php echo Yii::app()->createUrl("course/CountdownAjax"); ?>",
      type: "POST",
      dataType: "JSON",
      data: {
        file_id: file_id,
        learn_pdf_id: learn_pdf_id
      },
      success: function(data) {
        if (data.status != false) {
          if (data.idx != 1) $("#myCarousel" + file_id).children("#prePageTag" + file_id).show();
          $("#myCarousel" + file_id).children("#nextPageTag" + file_id).hide();
          countdownTime(data.dateTime, file_id, 'null', <?= $langId ?>);
        } else {
          clearInterval(interval);
          $("#myCarousel" + file_id).children("#nextPageTag" + file_id).show();
        }
      }
    });
  }

  var interval;

  function countdownTime(time_down, file, type, lang) {
    var count = time_down;
    var minute = 0;
    var second = 0;
    var timeStr = '';
    clearInterval(interval);
    interval = setInterval(function() {
      count--;
      if (count >= 60) {
        minute = parseInt(count / 60) < 10 ? "0" + parseInt(count / 60) : parseInt(count / 60);
        second = (count % 60) < 10 ? "0" + count % 60 : count % 60;
      } else {
        second = count < 10 ? '0' + count : count;
        minute = '00';
      }

      if (lang == 2) {
        timeStr = 'หน้าถัดไป';
      } else {
        timeStr = 'Next page';
      }
      timeStr = timeStr + ' : ' + minute + ':' + second + '';
      // timeStr = 'หน้าถัดไป : '+minute+':'+second+'';

      $("#timeCountdownCarousel" + file).html(timeStr);
      $("#timeCountdownCarousel" + file).css("display", "block");
      if (count <= 0) {
        clearInterval(interval);
        $("#nextPageTag" + file).css("display", "block");
        $("#timeCountdownCarousel" + file).css("display", "none");
        if (type == true) {
          swal({
              title: "<?= $pass_msg ?>",
              text: "<?= $next_step_msg ?>",
              type: "success",
              confirmButtonText: "<?= $ok_msg ?>",
              cancelButtonText: "<?= $cancel_msg ?>",
              showCancelButton: true,
              closeOnConfirm: true,
              closeOnCancel: true
            },
            function(isConfirm) {
              if (isConfirm) {
                // window.location.href = "<?php echo $this->createUrl('course/courselearn'); ?>";
                window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
              }
            }
          );
        }
      }
    }, 1000);
  }

  <?php if ($time) { ?>
    $("#yt0").click(function() {
      $.ajax({
        url: "<?= Yii::app()->createUrl("course/checkcaptcha"); ?>",
        type: "POST",
        dataType: 'json',
        data: $("#validate-form").serialize(),
        success: function(data) {
          var videoId = document.getElementById("videoIdx").value;
          var times = <?php echo $time->captchaTime->capt_times; ?>;
          var timeBack = <?php echo $time->captchaTime->capt_wait_time * 1000; ?>;
          $("#yw0_button").click();
          if (data.status == 1) {
            var t = new Date();
            t.setSeconds(t.getSeconds() + 999999);
            time_test_start(t);
            swal({
              title: "ถูกต้อง!",
              text: "รหัสยืนยันถูกต้อง",
              type: "success",
              timer: 3000
            });
            $('#myModal').modal('toggle');
            var myPlayer = videojs(videoId);
            myPlayer.play();
          } else if (data.status == 2) {
            getRollBack(data.status);
          } else {
            $("#ValidateCaptcha_verifyCode").val('');
            swal("กรอกรหัสผิดผลาด", "คุณมีโอกาสตอบผิดอีกจำนวน " + (times - data.count) + " ครั้ง", "error");
          }
        }
      });
    });

    $("#yt2").click(function() {
      var videoId = document.getElementById("videoIdx").value;
      $('#newModal').modal('toggle');
      var myPlayer = videojs(videoId);
      myPlayer.play();
    });

    $("#yt3").click(function(event) {
      var current_slide = getCurrentSlide();
      console.log("LearnPdf 3");
      $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
        id: <?php echo $file->id; ?>,
        learn_id: <?php echo $learn_id; ?>,
        slide: current_slide
      }, function(data) {
        data = JSON.parse(data);
        if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
          $('#indicators' + data.no).append(data.indicators);
        }

        if (data.status) {
          $('#ic_pdf_' + data.no).addClass("o-view");
          swal({
              title: "<?= $pass_msg ?>",
              text: "<?= $next_step_msg ?>",
              type: "success",
              confirmButtonText: "<?= $ok_msg ?>",
              cancelButtonText: "<?= $cancel_msg ?>",
              showCancelButton: true,
              closeOnConfirm: true,
              closeOnCancel: true
            },
            function(isConfirm) {
              if (isConfirm) {
                window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
              }
            }
          );

        }

        $('#imageCheck_' + data.no).html(data.image);
        console.log("imageCheck 9");
        if (data.timeNext) {
          $("#nextPageTag<?= $file->id; ?>").css("display", "none");
          countdownTime(data.timeNext, <?= $file->id; ?>, data.status, <?= $langId ?>);
        } else {
          clearInterval(interval);
          $("#nextPageTag<?= $file->id; ?>").css("display", "block");
          $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
        }
        init_knob();
      });

      $('#newModal').modal('toggle');
    });

    //PDF
    $("#yt1").click(function() {
      $.ajax({
        url: "<?= Yii::app()->createUrl("course/checkcaptcha"); ?>",
        type: "POST",
        dataType: 'json',
        data: $("#validate-form").serialize(),
        success: function(data) {
          var times = <?= isset($time->captchaTime->capt_times) ? $time->captchaTime->capt_times : 0; ?>;
          var timeBack = <?= isset($time->captchaTime->capt_wait_time) ?  $time->captchaTime->capt_wait_time * 1000 : 0; ?>;
          $("#yw0_button").click();
          if (data.status == 1) {
            var t = new Date();
            t.setSeconds(t.getSeconds() + 999999);
            time_test_start(t);
            swal({
              title: "ถูกต้อง!",
              text: "รหัสยืนยันถูกต้อง",
              type: "success",
              timer: 3000
            });
            var current_slide = getCurrentSlide();
            console.log("LearnPdf 4");

            $.post('<?php echo $this->createUrl("//course/LearnPdf"); ?>', {
              id: <?php echo $file->id; ?>,
              learn_id: <?php echo $learn_id; ?>,
              slide: current_slide
            }, function(data) {
              data = JSON.parse(data);
              if (typeof data.indicators !== 'undefined' && typeof data.no !== 'undefined') {
                $('#indicators' + data.no).append(data.indicators);
              }

              if (data.status) {
                <?php
                if (isset($_GET['file'])) {
                  // $modelFilePdfCollapse = ControlVdo::model()->find(array('condition' => 'file_id='.$_GET['file']));
                  // $modelFilsChk = ControlVdo::model()->findAll(array('condition' => 'parent_id='.$modelFilePdfCollapse->id));
                  // foreach ($modelFilsChk as $key => $val) {
                ?>
                  // $('#ic_a_pdf_'+<?= $val->file_id; ?>).attr("href", "<?= $this->createUrl('learn/learning', array('id' => $_GET['id'], 'course_id' => $_GET['course_id'], 'collapsepdf' => $val->file_id)); ?>");
                  // $('#ic_a_pdf_<?= $val->file_id; ?>').removeAttr("onclick");
                  // $("#a_slide_<?= $val->file_id; ?>").removeAttr("onclick");
                  // $("#a_slide_<?= $val->file_id; ?>").attr("href","#collapsepdf_<?php echo $val->file_id; ?>");
                <?php
                  // }
                }
                ?>
                $('#ic_pdf_' + data.no).addClass("o-view");
                swal({
                    title: "<?= $pass_msg ?>",
                    text: "<?= $next_step_msg ?>",
                    type: "success",
                    confirmButtonText: "<?= $ok_msg ?>",
                    cancelButtonText: "<?= $cancel_msg ?>",
                    showCancelButton: true,
                    closeOnConfirm: true,
                    closeOnCancel: true
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                      window.location.href = "<?php echo $this->createUrl('course/detail'); ?>" + "/" + <?= $model->course_id; ?>;
                    }
                  }
                );

              }

              //if(data.camera)
              $('#imageCheck_' + data.no).html(data.image);
              console.log("imageCheck 10");
              if (data.timeNext) {
                $("#nextPageTag<?= $file->id; ?>").css("display", "none");
                countdownTime(data.timeNext, <?= $file->id; ?>, data.status, <?= $langId ?>);
              } else {
                clearInterval(interval);
                $("#nextPageTag<?= $file->id; ?>").css("display", "block");
                $("#timeCountdownCarousel<?= $file->id; ?>").css("display", "none");
              }
              init_knob();
            });

            $('#myModal').modal('toggle');
          } else if (data.status == 2) {
            getRollBackPdf(data.status);
          } else {
            $("#ValidateCaptcha_verifyCode").val('');
            swal("กรอกรหัสผิดผลาด", "คุณมีโอกาสตอบผิดอีกจำนวน " + (times - data.count) + " ครั้ง", "error");
          }
        }
      });
    });

    function time_test_start(time_down) {
      var count = time_down;
      var minute = 0;
      var second = 0;
      var timeStr = '';
      clearInterval(interval);
      interval = setInterval(function() {
        count--;
        if (count >= 60) {
          minute = parseInt(count / 60) < 10 ? "0" + parseInt(count / 60) : parseInt(count / 60);
          second = (count % 60) < 10 ? "0" + count % 60 : count % 60;
        } else {
          second = count < 10 ? '0' + count : count;
          minute = '00';
        }
        timeStr = minute + ':' + second + '';
        $("#timeTest").html(timeStr);
        if (count <= 0) {
          clearInterval(interval);
          captchaTimeOut();
        }
      }, 1000);
    }
    //PDF
    function time_test_start_pdf(time_down, current_slide) {
      var count = time_down;
      var minute = 0;
      var second = 0;
      var timeStr = '';
      clearInterval(interval);
      interval = setInterval(function() {
        count--;
        if (count >= 60) {
          minute = parseInt(count / 60) < 10 ? "0" + parseInt(count / 60) : parseInt(count / 60);
          second = (count % 60) < 10 ? "0" + count % 60 : count % 60;
        } else {
          second = count < 10 ? '0' + count : count;
          minute = '00';
        }
        timeStr = minute + ':' + second + '';
        $("#timeTest").html(timeStr);
        if (count <= 0) {
          console.log('clearInterval active : ' + interval);
          clearInterval(interval);
          // captchaTimeOutPdf(current_slide);
        }
      }, 1000);
    }

    function getRollBack(status) {
      if (status == 2) {
        var fileId = document.getElementById("fileId").value;
        var videoId = document.getElementById("videoIdx").value;
        var index = document.getElementById("index").value;
        var times = <?php echo $time->captchaTime->capt_times; ?>;
        var timeSetRollback = <?php echo $time->captchaTime->capt_time_back; ?>;
        var myPlayer = videojs(videoId);
        var currentTime = window["getCurrentTimeRollback" + index]();
        var allTime = currentTime - (timeSetRollback * 60);
        var course_id = <?= $model->course_id; ?>;
        var lesson_id = <?= $model->id; ?>;
        $.ajax({
          url: "<?= Yii::app()->createUrl("course/checkcaptcha"); ?>",
          type: "POST",
          dataType: 'json',
          data: {
            id: fileId,
            ctime: allTime,
            cnid: course_id,
            lid: lesson_id
          },
          success: function(data) {
            if (data.state == 1) {
              var i = 0;
              if (data.fileIndex > 0) i = data.fileIndex;
              hideImage(index, data.count, i);
            }
          }
        });
        $('#ValidateCaptcha_verifyCode').val("");
        $('#myModal').modal('toggle');
        var t = new Date();
        t.setSeconds(t.getSeconds() + 999999);
        time_test_start(t);
        swal({
            title: "กรอกรหัสผิดผลาดครบ " + times + " ครั้ง",
            text: "คุณถูกกำหนดให้กลับไปเรียน " + timeSetRollback + " นาทีก่อน",
            type: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ตกลง",
            closeOnConfirm: true,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
              window["setTimeRollback" + index](allTime);
              myPlayer.currentTime(allTime);
              myPlayer.play();
            }
          }
        );
      }
    }

    function getRollBackPdf(status) {
      console.log('getRollBackPdf active');
      if (status == 2) {
        var current_slide = getCurrentSlide();
        var course_id = <?= $model->course_id; ?>;
        var lesson_id = <?= $model->id; ?>;

        var file_id = <?php echo $file->id; ?>;
        var learn_id = <?php echo $learn_id; ?>;
        var rollback_slide = <?php
                              if ($time && isset($time->captchaTime->prev_slide)) {
                                echo $time->captchaTime->prev_slide;
                              } else {
                                echo 9999999;
                              }
                              ?>;
        var times = <?= isset($time->captchaTime->capt_times) ? $time->captchaTime->capt_times : 0; ?>;
        rollback_slide = current_slide - rollback_slide;
        if (rollback_slide <= 0) {
          rollback_slide = 1;
        }
        //Rollback slide into database
        $.ajax({
          url: "<?= Yii::app()->createUrl("course/checkcaptchaPdf"); ?>",
          type: "POST",
          dataType: 'json',
          data: {
            file_id: file_id,
            lesson_id: lesson_id,
            learn_id: learn_id,
            slide: rollback_slide,
            staTime: 'timeout',
            cnid: <?= $model->course_id; ?>,
            lid: <?= $model->id; ?>
          },
          success: function(data) {
            if (data.state == 1) {
              $('#myCarousel<?= $file->id; ?>').carousel(rollback_slide);
            }
          }
        });
        $('#ValidateCaptcha_verifyCode').val("");
        $('#myModal').modal('toggle');
        var t = new Date();
        t.setSeconds(t.getSeconds() + 999999);
        time_test_start(t);
        swal({
            title: "กรอกรหัสผิดผลาดครบ " + times + " ครั้ง",
            text: "คุณถูกกำหนดให้ถอยกลับไปเรียน " + rollback_slide + " สไลด์",
            type: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ตกลง",
            closeOnConfirm: true,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
              // window["setTimeRollback"+index](allTime);
              // myPlayer.currentTime(allTime);
              // myPlayer.play();
            }
          }
        );
      }
    }

    function checkTime() {
      var videoId = document.getElementById("videoIdx").value;
      var myPlayer = videojs(videoId);
      if (myPlayer.isFullscreen()) {
        myPlayer.exitFullscreen();
      }
      var currentTime = myPlayer.currentTime();
      var lengthOfVideo = myPlayer.duration();
      var timeBack = <?php echo $time->captchaTime->capt_wait_time; ?>;
      if (currentTime < lengthOfVideo) {
        // console.log("9 : "+status_in_learn_note);

        myPlayer.pause();
        $('#ValidateCaptcha_verifyCode').val("");
        $('#newModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        // $.ajax({
        //  url: "<?php echo Yii::app()->createUrl("course/saveCaptchaStart"); ?>",
        //  type: "POST",
        //  dataType: 'json',
        //  data: $("#validate-form").serialize(),
        //  success:function(data){
        //      if(data.timeBack)time_test_start(data.timeBack);
        //  }
        // });
      }
    }


    function captchaTimeOut() {
      var fileId = document.getElementById("fileId").value;
      var videoId = document.getElementById("videoIdx").value;
      var index = document.getElementById("index").value;
      var timeSetRollback = <?php
                            if ($time && isset($time->captchaTime->capt_time_back)) {
                              echo $time->captchaTime->capt_time_back;
                            } else {
                              echo 9999999;
                            }
                            ?>;
      var myPlayer = videojs(videoId);
      var currentTime = window["getCurrentTimeRollback" + index]();
      var allTime = currentTime - (timeSetRollback * 60);
      $.ajax({
        url: "<?php echo Yii::app()->createUrl("course/checkcaptcha"); ?>",
        type: "POST",
        dataType: 'json',
        data: {
          id: fileId,
          ctime: allTime,
          staTime: 'timeout',
          cnid: <?= $model->course_id; ?>,
          lid: <?= $model->id; ?>
        },
        success: function(data) {
          if (data.state == 1) {
            var i = 0;
            if (data.fileIndex > 0) i = data.fileIndex;
            hideImage(index, data.count, i);
          }
        }
      });
      $('#ValidateCaptcha_verifyCode').val("");
      $('#myModal').modal('hide');
      swal({
          title: "คุณไม่กรอกข้อมูลตามเวลาที่กำหนด",
          text: "คุณถูกกำหนดให้กลับไปเรียน " + timeSetRollback + " นาทีก่อน",
          type: "warning",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ตกลง",
          closeOnConfirm: true,
          closeOnCancel: false
        },
        function(isConfirm) {
          if (isConfirm) {
            window["setTimeRollback" + index](allTime);
            myPlayer.currentTime(allTime);
            myPlayer.play();
          }
        }
      );
    }


    function captchaTimeOutPdf(current_slide) {
      var file_id = <?php echo $file->id; ?>;
      var learn_id = <?php echo $learn_id; ?>;
      var timeSetRollback = <?php
                            if ($time && isset($time->captchaTime->prev_slide)) {
                              // echo $time->captchaTime->prev_slide;
                              echo  $time->captchaTime->prev_slide;
                            } else {
                              echo 9999999;
                            }
                            ?>;
      var current_slide = current_slide;
      var lesson_id = <?= $model->id; ?>;
      var rollback_slide = <?php
                            if ($time && isset($time->captchaTime->prev_slide)) {
                              echo $time->captchaTime->prev_slide;
                            } else {
                              echo 9999999;
                            }
                            ?>;
      rollback_slide = current_slide - rollback_slide;
      $.ajax({
        url: "<?php echo Yii::app()->createUrl("course/CheckCaptchaPdf"); ?>",
        type: "POST",
        dataType: 'json',
        data: {
          file_id: file_id,
          lesson_id: lesson_id,
          learn_id: learn_id,
          slide: rollback_slide,
          staTime: 'timeout',
          cnid: <?= $model->course_id; ?>,
          lid: <?= $model->id; ?>
        },
        success: function(data) {
          if (data.state == 1) {
            $('#myCarousel<?= $file->id; ?>').carousel(rollback_slide);
          }
        }
      });
      $('#ValidateCaptcha_verifyCode').val("");
      $('#myModal').modal('hide');
      swal({
          title: "คุณไม่กรอกข้อมูลตามเวลาที่กำหนด",
          text: "คุณถูกกำหนดให้ถอยกลับไปเรียน " + timeSetRollback + " สไลด์",
          type: "warning",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "ตกลง",
          closeOnConfirm: true,
          closeOnCancel: false
        },
        function(isConfirm) {
          if (isConfirm) {
            //Rollback slide
          }
        }
      );
    }

  <?php } ?>

  $(document).on("contextmenu", function(e) {
    swal({
      title: "แจ้งเตือน!",
      text: "ไม่สามารถคลิ๊กขวาได้",
      type: "warning",
      timer: 1000
    });
    return false;
  });
  $(document).keydown(function(event) {
    /* if (event.keyCode == 123) {
      swal({
        title: "แจ้งเตือน!",
        text: "ไม่สามารถเข้าถึงข้อมูลส่วนนี้ได้",
        type: "warning",
        timer: 1000
      });
      return false;
    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
      swal({
        title: "แจ้งเตือน!",
        text: "ไม่สามารถเข้าถึงข้อมูลส่วนนี้ได้",
        type: "warning",
        timer: 1000
      });
      return false;
    } */
  });



  /* // เริ่ม สมุดโน๊ต */
  var $myGroup = $('#myGroup'); // บังคับเปิดแถบโชว์ วิดีโอ ได้ 1 อัน
  $myGroup.on('show.bs.collapse', '.collapse', function() {
    $myGroup.find('.collapse.in').collapse('hide');
  });

  // $( "#note-1" ).click(function() { // text area note
  //   status_in_learn_note = 1; // เข้าฟังชัน ไม่ให้ video หยุดเล่น
  // });

  $("#note-1").keydown(function(event) {
    if (event.keyCode == 13) { // enter
      save_learn_note();
    }
  });

  function show_collapse(file) { // เปิด แถบวิดีโอ
    var num_show_video_i;

    for (var i = 0; i < jQuery('.collapse.in').length; i++) {
      var name_collapse = jQuery('.collapse.in')[i].getAttribute("id").replace("collapse", "");
      name_collapse = parseInt(name_collapse);
      if (Number.isInteger(name_collapse)) {
        num_show_video_i = i;
        break;
      }
    }
    if (num_show_video_i != null) {
      var id_video_file_open = jQuery('.collapse.in');
      id_video_file_open = id_video_file_open[num_show_video_i].getAttribute("id").replace("collapse", "");
    }

    $("#collapse" + id_video_file_open).removeClass("collapse in");
    $("#collapse" + id_video_file_open).addClass("collapse");


    $("#collapse" + file).removeClass("collapse");
    $("#collapse" + file).addClass("collapse in");
    $("#collapse" + file).css({
      "height": "auto"
    });

  }

  $(".td_time_note").click(function() { // mote time click                    
    status_in_learn_note = 1; // เข้าฟังชัน ไม่ให้ video หยุดเล่น
    var id_video_file = this.getAttribute("note_file");
    var name_video_file = this.getAttribute("name_video");
    var id_video_time = this.getAttribute("note_time");
    show_collapse(id_video_file);
    video_id_last = $("[fileid=" + id_video_file + "]").attr("index");
    var id_video_file_open = jQuery('.collapse.in');
    var num_show_video_i;
    for (var i = 0; i < jQuery('.collapse.in').length; i++) {
      var name_collapse = jQuery('.collapse.in')[i].getAttribute("id").replace("collapse", "");
      name_collapse = parseInt(name_collapse);
      if (Number.isInteger(name_collapse)) {
        num_show_video_i = i;
        break;
      }
    }
    id_video_file_open = id_video_file_open[num_show_video_i].getAttribute("id").replace("collapse", "");
    if (id_video_file_open == id_video_file) {
      document.getElementById('example_video_' + video_id_last + '_html5_api').play();
      document.getElementById('example_video_' + video_id_last + '_html5_api').currentTime = id_video_time;
      var video = $("#" + 'example_video_' + video_id_last + '_html5_api').get(0);
    } else {
      swal({
        type: "warning",
        title: "แจ้งเตือน!",
        text: "เปิดแถบวิดีโอ " + name_video_file + " ก่อน",
        timer: 1000
      });
    }
  });


  function fn_td_time_note(id) {
    var td = document.getElementById('td_time_note_' + id);
    status_in_learn_note = 1; // เข้าฟังชัน ไม่ให้ video หยุดเล่น
    var id_video_file = td.getAttribute("note_file");
    var name_video_file = td.getAttribute("name_video");
    var id_video_time = td.getAttribute("note_time");
    show_collapse(id_video_file);
    video_id_last = $("[fileid=" + id_video_file + "]").attr("index");
    var id_video_file_open = jQuery('.collapse.in');
    var num_show_video_i;
    for (var i = 0; i < jQuery('.collapse.in').length; i++) {
      var name_collapse = jQuery('.collapse.in')[i].getAttribute("id").replace("collapse", "");
      name_collapse = parseInt(name_collapse);
      if (Number.isInteger(name_collapse)) {
        num_show_video_i = i;
        break;
      }
    }
    id_video_file_open = id_video_file_open[num_show_video_i].getAttribute("id").replace("collapse", "");
    if (id_video_file_open == id_video_file) {
      document.getElementById('example_video_' + video_id_last + '_html5_api').play();
      document.getElementById('example_video_' + video_id_last + '_html5_api').currentTime = id_video_time;
    } else {
      swal({
        type: "warning",
        title: "แจ้งเตือน!",
        text: "เปิดแถบวิดีโอ " + name_video_file + " ก่อน",
        timer: 1000
      });
    }
  }


  var video_id_last = 1;
  var note_lesson_id = "";
  var note_file_id = "";

  function save_learn_note() {
    var num_show_video = jQuery('.collapse.in').length;

    var num_show_video_status = 2;
    var num_show_video_i;
    for (var i = 0; i < num_show_video; i++) {
      var name_collapse = jQuery('.collapse.in')[i].getAttribute("id").replace("collapse", "");
      name_collapse = parseInt(name_collapse);
      if (Number.isInteger(name_collapse)) {
        num_show_video_status = 1;
        num_show_video_i = i;
        break;
      }
    }


    // if(num_show_video >= 1 ){ // ถ้า แถบวิดีโอไม่เปิด บันทึกไม่ได้
    if (num_show_video_status == 1) { // ถ้า แถบวิดีโอไม่เปิด บันทึกไม่ได้
      var num_video_file = "<?php echo $idx; ?>";
      var video_check, note_time, video, note_text;
      status_in_learn_note = 1; // เข้าฟังชัน ไม่ให้ video หยุดเล่น

      var id_video_file = jQuery('.collapse.in');

      id_video_file = id_video_file[num_show_video_i].getAttribute("id").replace("collapse", "");
      video_id_last = $("[fileid=" + id_video_file + "]").attr("index");

      for (var i = 1; i <= num_video_file; i++) {
        video_check = $("#" + 'example_video_' + i + '_html5_api').get(0);

        if (video_check != null) {
          if (!video_check.paused) {
            video_id_last = i;
            break;
          }
        }
      }

      video = $("#" + 'example_video_' + video_id_last + '_html5_api').get(0);
      note_lesson_id = $("#" + 'example_video_' + video_id_last + '_html5_api').attr("lesson_id");
      note_file_id = $("#" + 'example_video_' + video_id_last + '_html5_api').attr("fileid");
      note_time = video.currentTime;
      note_text = $("#note-1").val();

      var note_gen_id = "<?php echo $gen_id; ?>";

      if (note_text != "") {
        if (note_lesson_id != null && note_file_id != null && note_time != null) {
          $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/Course/CourseLearnNoteSave"); ?>',
            data: ({
              note_lesson_id: note_lesson_id,
              note_file_id: note_file_id,
              note_time: note_time,
              note_text: note_text,
              note_gen_id: note_gen_id,
            }),
            success: function(data) {
              if (data != "error" && data != "error2") {
                $("#note-1").val("");
                $("#tr_note_" + data.split("'")[1].replace("tr_note_", "")).remove();
                var tbody_note = data.split("'")[11];
                $("#tbody_note_" + tbody_note).append(data);
                $("#table_note_" + tbody_note).show();

              } else {
                swal({
                  type: "warning",
                  title: "แจ้งเตือน!",
                  text: "ทำรายการไม่สำเร็จ",
                  timer: 1000
                });
              }
            }
          });
        } else { // if(note_lesson_id != null
          swal({
            type: "warning",
            title: "แจ้งเตือน!",
            text: "ทำรายการไม่สำเร็จ",
            timer: 1000
          });
        }
      } else { // if(note_text != ""){
        swal({
          type: "warning",
          title: "แจ้งเตือน!",
          text: "กรุณาพิมพ์ข้อความก่อนจดบันทึก",
          timer: 1000
        });
      }

    } else {
      swal({
        type: "warning",
        title: "แจ้งเตือน!",
        text: "กรุณาเปิดแถบวิดีโอก่อนจดโน๊ต",
        timer: 1000
      });
    }
  } //  function save_learn_note()

  // $(".edit-note").click(function() {
  //    var note_id = this.getAttribute("id").replace("span_id_", "");

  //   Swal.fire({
  //     // icon: 'info',
  //     title: "แก้ไข",                      
  //     html: '<div class="form-group p-4"><textarea onKeyPress="check_enter('+');" class="form-control" placeholder="พิมพ์ข้อความและกดจดบันทึก" id="note-2" rows="3">'+this.innerHTML+'</textarea>' +
  //     '<button type="button" onclick="edit_learn_note('+note_id+');" class="btn-note btn btn-sm btn-dark mt-4 ">จดบันทึก</button></div>',
  //     showCloseButton: true,
  //     showCancelButton: false,
  //     showConfirmButton: false,
  //     focusConfirm: false
  //   })
  // });

  function fn_edit_note(note_id) {
    Swal.fire({
      // icon: 'info',
      title: "แก้ไข",
      html: '<div class="form-group p-4"><textarea onKeyPress="check_enter(event, ' + note_id + ');" class="form-control" placeholder="พิมพ์ข้อความและกดจดบันทึก" id="note-2" rows="3">' + document.getElementById("span_id_" + note_id).innerHTML + '</textarea>' +
        '<button type="button" onclick="edit_learn_note(' + note_id + ');" class="btn-note btn btn-sm btn-dark mt-4 ">จดบันทึก</button></div>',
      showCloseButton: true,
      showCancelButton: false,
      showConfirmButton: false,
      focusConfirm: false
    })
  }


  function check_enter(event, note_id) { // enter sweet alert
    if (event.keyCode == 13) { // enter
      edit_learn_note(note_id);
    }
  }

  function edit_learn_note(note_id) {
    var note_text = $("#note-2").val();

    if (note_id != "") {
      $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createAbsoluteUrl("/Course/CourseLearnNoteSave"); ?>',
        data: ({
          note_id: note_id,
          note_text: note_text,
        }),
        success: function(data) {
          if (data != "error" && data != "error2") {
            $("#note-2").val("");
            if (note_text != "") {
              document.getElementById("span_id_" + note_id).innerHTML = note_text;
            } else {
              $("#tr_note_" + note_id).remove();
            }
            Swal.close();
          } else {
            swal({
              type: "warning",
              title: "แจ้งเตือน!",
              text: "ทำรายการไม่สำเร็จ",
              timer: 1000
            });
            // alert("ทำรายการไม่สำเร็จ");
          }
        }
      });
    }
  }

  function remove_learn_note(note_id) {
    Swal.fire({
      title: 'ยืนยันใช่ไหม',
      text: "ว่าต้องการลบบันทึก",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.value) {
        var note_text = $("#note-2").val();
        if (note_id != "") {
          $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/Course/CourseLearnNoteRemove"); ?>',
            data: ({
              note_id: note_id,
              // note_text: note_text,
            }),
            success: function(data) {
              if (data != "error" && data != "error2") {
                $("#note-2").val("");
                // if(note_text != ""){
                //   document.getElementById("span_id_"+note_id).innerHTML = note_text;
                // }else{
                $("#tr_note_" + note_id).remove();
                // }

                Swal.close();
              } else {
                swal({
                  type: "warning",
                  title: "แจ้งเตือน!",
                  text: "ทำรายการไม่สำเร็จ",
                  timer: 1000
                });
              }
            }
          });
        }

      }
    });

  }

  function show_note(file_id) {
    if ($("#id_tablenote_" + file_id).attr("status-show") == 2) {
      $("#id_tablenote_" + file_id).attr("status-show", 1);
      $("#id_tablenote_" + file_id).show();
    } else {
      $("#id_tablenote_" + file_id).attr("status-show", 2);
      $("#id_tablenote_" + file_id).hide();
    }
  }


  var save_time_file, save_time_time;

  function save_time_video(time, idx) {
    var time = time;
    var lesson = $("#" + 'example_video_' + idx + '_html5_api').attr("lesson_id");
    var file = $("#" + 'example_video_' + idx + '_html5_api').attr("fileid");

    if (typeof(lesson) === "undefined") {

      var lesson = $("#" + 'audio-player' + idx).attr("lesson_id");
      var file = $("#" + 'audio-player' + idx).attr("fileid");
    }

    var gen_iddd = "<?php echo $gen_id; ?>";

    if (save_time_file != file || save_time_time != time) {
      save_time_file = file;
      save_time_time = time;

      // console.log(time);
      // console.log(idx);
      // console.log($("#"+'example_video_'+idx+'_html5_api').attr("fileid"));

      $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createAbsoluteUrl("/CourseApiMobile/CourseLearnSaveTimeVideo"); ?>',
        data: ({
          time: time,
          file: file,
          gen_id: gen_iddd,
          lesson: lesson,
          user_id: <?php echo $user_id ?>,
          page: "courselearnsavetimevideo",
        }),
        success: function(data) {
          if (data != "error") {

            if (data == "logout") {
              Swal.fire({
                title: 'กรุณาเข้าสู่ระบบ',
                // text: "ว่าต้องการลบบันทึก",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                window.location = "https://elearning.imct.co.th/";
                // if (result.value) {

                // }
              });




            } else {
              console.log(data);
              // console.log(textStatus);
              // console.log(xhr);
              // console.log(xhr.status);

            }


            // console.log(data);
          }
        }
      });
    }

  }
</script>


<?php echo $content; ?>


<?php include("themes/template2/include/footer.php"); ?>

<?php
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;
$cs->scriptMap = array(
  //'jquery.js' => $themePath.'/js/scorm/jquery.min.js',
  'jquery.js' => $themePath . '/js/library/jquery-1.11.0.min.js',
  //    'jquery.yii.js' => Yii::app()->request->baseUrl.'/js/jquery.min.js',
);
$cs->registerCoreScript('jquery')
  ->registerCoreScript('jquery.ui', CClientScript::POS_END)
  ->registerScriptFile($themePath . '/js/library/bootstrap.min.js', CClientScript::POS_END)
  ->registerScriptFile($themePath . '/js/library/jquery.owl.carousel.js', CClientScript::POS_END)
  ->registerScriptFile($themePath . '/js/library/jquery.appear.min.js', CClientScript::POS_END)
  ->registerScriptFile($themePath . '/js/library/perfect-scrollbar.min.js', CClientScript::POS_END)
  ->registerScriptFile($themePath . '/js/audiojs/audio.min.js')
  ->registerScriptFile($themePath . '/js/library/jquery.easing.min.js', CClientScript::POS_END)
  ->registerScriptFile($themePath . '/js/library/jquery.easing.min.js', CClientScript::POS_END)

  //scortm_insert_lerm
  ->registerScriptFile($themePath . '/js/Lib/sscompat.js')
  ->registerScriptFile($themePath . '/js/Lib/sscorlib.js')
  ->registerScriptFile($themePath . '/js/Lib/ssfx.Core.js')

  ->registerScriptFile($themePath . '/js/Lib/API_BASE.js')
  ->registerScriptFile($themePath . '/js/Lib/API.js')
  ->registerScriptFile($themePath . '/js/Lib/API_1484_11.js')

  ->registerScriptFile($themePath . '/js/Lib/Controls.js')
  ->registerScriptFile($themePath . '/js/Lib/LocalStorage.js')
  ->registerScriptFile($themePath . '/js/Lib/Player.js')

  ->registerScriptFile($themePath . '/sweetalert/dist/sweetalert.min.js', CClientScript::POS_END);
//->registerScriptFile($themePath.'/js/script.js',CClientScript::POS_END);
/*->registerScriptFile($themePath.'/js/scorm/jquery.blockUI.js')
->registerScriptFile($themePath.'/js/scorm/jquery-ui.min.js');
->registerScriptFile($themePath.'/js/scorm/popup.js')
->registerScriptFile($themePath.'/js/scorm/treemenu.js')
->registerScriptFile($themePath.'/js/scorm/prototype.js')
->registerScriptFile($themePath.'/js/scorm/JSCookMenu.js')
->registerScriptFile($themePath.'/js/scorm/plugins.js');*/
?>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jquery-validation/dist/jquery.validate.js"></script>

<!-- <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"></script> -->

</body>

</html>