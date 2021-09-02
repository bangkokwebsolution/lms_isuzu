<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
    $doc_download = "Document Download";
    $system_guide_and_others = "System guide and others";
    $how_to_use = "How to use";
    $sys_eleaning = "E-Learning system";
    $QaA = "Question and answer";
    $problem_of_use = "Problem of use";
    $Number_of_website_visitors = "Website visitors";
    $peple = "Time";
    $status = "Status";
    $edu = "Not study";
    $more = 'Read more';
    $course_plan = 'Course Plan';
    $course_status = 'Course Status';
    $classroom_online = 'Classroom Online';
    $library_show = 'E-Library';
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
    $library_show = 'ห้องสมุดออนไลน์';
    $doc_download = "เอกสารดาวน์โหลด";
    $system_guide_and_others = "คู่มือระบบและอื่นๆ";
    $how_to_use = "วิธีการใช้งาน";
    $sys_eleaning = "ระบบการเรียนรู้";
    $QaA = "คำถามที่พบบ่อย";
    $problem_of_use = "ปัญหาการใช้งาน";
    $Number_of_website_visitors = "จำนวนผู้เข้าชมเว็บไซต์";
    $peple = "ครั้ง";
    $status = "สถานะ";
    $edu = "ยังไม่เรียน";
    $more = 'อ่านเพิ่มเติม';
    $course_plan = 'แผนการเรียน';
    $course_status = 'สถานะของหลักสูตร';
    $classroom_online = 'ห้องเรียนออนไลน์';
}
?>
<!-- // -->
<?php if (Yii::app()->user->hasFlash('users') && !isset(Yii::app()->user->id)) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
                title: "<?= UserModule::t('confirm_regis'); ?> ",
                text: "Email :" + "<?= Yii::app()->user->getFlash('users'); ?>",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // $('#modal-login').modal('show');
                }
            });
    </script>
<?php
    Yii::app()->user->setFlash('profile', null);
    Yii::app()->user->setFlash('users', null);
}
?>

<?php if (Yii::app()->user->hasFlash('updateusers')) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
                title: "<?= UserModule::t('update_regis'); ?>",
                text: "Username :" + "<?= Yii::app()->user->getFlash('updateusers'); ?>",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // $('#modal-login').modal('show');
                }
            });
    </script>
<?php
    Yii::app()->user->setFlash('updateusers', null);
}
?>

<?php
$msg = Yii::app()->user->getFlash('msg');
$icon = Yii::app()->user->getFlash('icon');
if (!empty($msg) || !empty($_GET['msg'])) {
    $icon = !empty($icon) ? $icon : 'warning';
?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "<?= Yii::app()->user->getFlash('title') ?>",
            text: "<?= $msg; ?>",
            icon: "<?= $icon ?>",
            dangerMode: true,
        });
        $(document).ready(function() {
            window.history.replaceState({}, 'msg', '<?= $this->createUrl('site/index') ?>');
        });
    </script>
<?php
    Yii::app()->user->setFlash('title', null);
    Yii::app()->user->setFlash('msg', null);
    Yii::app()->user->setFlash('icon', null);
} ?>

<?php if (Yii::app()->user->id == null) { ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".course_site").attr("href", "JavaScript:void(0)")
            $(".course_site").click(function() {
                swal({
                    title: "<?= UserModule::t('Warning') ?>",
                    text: "<?= UserModule::t('regis_first') ?>",
                    icon: "warning",
                    dangerMode: true,
                }).then(function() {
                    $('#modal-login').modal('show');
                });

            });
        });
    </script>
<?php } ?>
<section class="container banner-main">
    <div class="row">
        <div class="col-md-3">
            <a class="" href="<?php echo $this->createUrl('/site/index'); ?>">
                <div class="logo-h30" style="background-image:url(<?php echo Yii::app()->theme->baseUrl; ?>/images/logo-index.png">
                    <!-- <img src="" alt=""> -->
                </div>
            </a>
        </div>
        <div class="col-md-9">
            <div class="banner-slide h-30">
                <?php
                $criteriaimg = new CDbCriteria;
                $criteriaimg->compare('active', y);
                $criteriaimg->compare('lang_id', Yii::app()->session['lang']);
                // $criteriaimg->order = 'update_date  DESC';
                $image = Imgslide::model()->findAll($criteriaimg);
                ?>
                <div id="carousel-banner" class="owl-carousel owl-theme owl-main">
                    <?php
                    foreach ($image as $key => $value) {
                        $criteriaType = new CDbCriteria;
                        $criteriaType->compare('active', y);
                        $criteriaType->compare('gallery_type_id', $value->gallery_type_id);
                        $criteriaType->order = 'id ASC';
                        $galleryType = Gallery::model()->findAll($criteriaType);
                    ?>
                        <div class="item <?php if ($key == 0) echo 'active'; ?>">
                            <?php
                            if ($value->imgslide_link == "" && $value->gallery_type_id != null) {
                                foreach ($galleryType as $key_t => $data) {
                            ?>
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/uploads/gallery/<?= $data->image; ?>" class="liquid-lp-read-more zoom fresco" data-fresco-group="ld-pf-1[<?= $value->id ?>]">
                                        <?php if ($key_t == 0) {
                                        ?>
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/main-bg.png" class="slide-main-thor" alt="">
                                            <!-- <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>" class="slide-main-thor" alt=""> -->
                                        <?php
                                        }  ?>
                                    </a>
                                <?php } ?>
                            <?php } else if ($value->imgslide_link != "" && $value->gallery_type_id == null) { ?>
                                <a href="<?= $value->imgslide_link;  ?>" target="_blank">
                                    <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/main-bg.png" class="slide-main-thor" alt=""> -->
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>" class="slide-main-thor" alt="">
                                </a>
                            <?php } else { ?>
                                <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/main-bg.png" class="slide-main-thor" alt=""> -->
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>" class="slide-main-thor" alt="">
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>

</section>

<section class="menu-section menu-elearning featured-boxes featured-boxes-style-2">
    <div class="container">
        <div id="menu-index" class="owl-carousel owl-theme nav-inside nav-style-1 nav-light">
            <div class=" mb-1">
                <div class="featured-box featured-box-one  featured-box-effect-4 text-center">
                    <div class="box-content">
                        <a data-toggle="modal" href="<?php if (Yii::app()->user->id == null) {
                                                            echo '#modal-login';
                                                        } else {
                                                            echo Yii::app()->createUrl('virtualclassroom/index');
                                                        } ?>">
                            <div class="icon-featured">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/online-class.svg">
                            </div>
                            <h4 class="mb-0"><?= $classroom_online ?></h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class=" mb-1">
                <div class="featured-box featured-box-one  featured-box-effect-4 text-center">
                    <div class="box-content">
                        <a data-toggle="modal" href="<?php if (Yii::app()->user->id == null) {
                                                            echo '#modal-login';
                                                        } else {
                                                            echo Yii::app()->createUrl('video/library');
                                                        } ?>">
                            <div class="icon-featured">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/E-Library.svg">
                            </div>
                            <h4 class="mb-0"><?= $library_show ?></h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class=" mb-1">
                <div class="featured-box featured-box-one  featured-box-effect-4 text-center">
                    <div class="box-content">
                        <a href="<?php echo $this->createUrl('/document/index'); ?>">
                            <div class="icon-featured">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/Download-Files.svg">
                            </div>
                            <h4 class="mb-0"><?= $doc_download ?></h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class=" mb-1">
                <div class="featured-box featured-box-one  featured-box-effect-4 text-center">
                    <div class="box-content">
                        <a data-toggle="modal" href="<?php if (Yii::app()->user->id == null) {
                                                            echo '#modal-login';
                                                        } else {
                                                            echo Yii::app()->createUrl('course/courseplan');
                                                        } ?>">
                            <div class="icon-featured">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/Course-Plan.svg">
                            </div>
                            <h4 class="mb-0"><?= $course_plan ?></h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class=" mb-1">
                <div class="featured-box featured-box-one  featured-box-effect-4 text-center">
                    <div class="box-content">
                        <a data-toggle="modal" href="<?php if (Yii::app()->user->id == null) {
                                                            echo '#modal-login';
                                                        } else {
                                                            echo Yii::app()->createUrl('site/dashboard');
                                                        } ?>">
                            <div class="icon-featured">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/Course-Status.svg">
                            </div>
                            <h4 class="mb-0"><?= $course_status ?></h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3 col-sm-6 col-xs-12 mb-1">
                    <a href="#" class="btn btn-elearning bg-user">
                        <div class="row center-align">
                            <div class="col-md-3 col-sm-3 col-xs-2">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-9 text-center">
                                <h4 class="mb-0 text-white"><?= $Number_of_website_visitors ?></h4>
                                <span class="font-weight-normal text-white"><?= $counter ?> <?= $peple ?></span>
                            </div>
                        </div>
                    </a>
                </div> -->
        </div>
    </div>
</section>

<div class="activity-index">

    <?php if (Yii::app()->user->id != null && $course_online != null) { ?>
        <section class="course">
            <div class="container">
                <h4 class="course-recommend clearfix">
                    <span><?= $label->label_courseOur ?></span>
                </h4>

                <div class="row course-main owl-carousel owl-theme">
                    <?php foreach ($course_online as $key => $value) {
                        if ($value->status == 1) {

                            if ($value->lang_id != 1) {
                                $value->course_id = $value->parent_id;
                            }
                            if (!$flag) {
                                $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $value->course_id, 'order' => 'course_id'));
                                if ($modelChildren) {
                                    $value->course_title = $modelChildren->course_title;
                                    $value->course_short_title = $modelChildren->course_short_title;
                                    $value->course_detail = $modelChildren->course_detail;
                                    $value->course_picture = $modelChildren->course_picture;
                                }
                            }


                            if ($value->parent_id != 0) {
                                $value->course_id = $value->parent_id;
                            }


                            $expireDate = Helpers::lib()->checkCourseExpire($value);
                            if ($expireDate) {

                                $date_start = date("Y-m-d H:i:s", strtotime($value->course_date_start));
                                $dateStartStr = strtotime($date_start);
                                $currentDate = strtotime(date("Y-m-d H:i:s"));

                                if ($currentDate >= $dateStartStr) {

                                    $chk = Helpers::lib()->getLearn($value->course_id);
                                    if ($chk) {



                                        $chk_logtime = LogStartcourse::model()->find(array(
                                            'condition' => 'course_id=:course_id and user_id=:user_id and active=:active and gen_id=:gen_id',
                                            'params' => array(':course_id' => $value->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $value->getGenID($value->course_id))
                                        ));
                                        $course_chk_time = CourseOnline::model()->findByPk($value->course_id);


                                        if (!empty($chk_logtime)) {
                                            if ($chk_logtime->course_day != $course_chk_time->course_day_learn) {
                                                $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));

                                                $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                                $chk_logtime->end_date = $Endlearncourse;
                                                $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                                $chk_logtime->save(false);
                                            }
                                        }





                                        $expireUser = Helpers::lib()->checkUserCourseExpire($value);
                                        if (!$expireUser) {

                                            $evnt = 'onclick="alertMsg(\'' . $label->label_swal_youtimeout . '\',\'\',\'error\')"';
                                            $url = 'javascript:void(0)';
                                        } else {

                                            $evnt = '';
                                            $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                                        }
                                    } else {
                                        $evnt = 'data-toggle="modal"';
                                        $url = '#modal-startcourse' . $value->course_id;
                                        // $url = '#modal-login';

                                        // $evnt = '';
                                        //   $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                                    }
                                } else {

                                    $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                    $url = 'javascript:void(0)';
                                }
                            } elseif ($expireDate == 3) {
                                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                                $url = 'javascript:void(0)';
                            } else {
                                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_timeoutcourse . '\',\'error\')"';
                                $url = 'javascript:void(0)';
                            }
                    ?>


                            <div class="course-item">
                                <div class="item item-course-index">
                                    <div class="cours-card">
                                        <div class="card">
                                            <a href="<?= $url ?>" <?= $evnt ?> class="course_site">
                                                <?php $idCourse_img = (!$flag) ? $modelChildren->course_id : $value->course_id; ?>
                                                <?php if ($value->course_picture != null) { ?>
                                                    <div class="course-boximg" style="background-image:url(<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $idCourse_img ?>/thumb/<?= $value->course_picture ?>)"></div>
                                                <?php } else { ?>
                                                    <div class="course-boximg" style="background-image:url(<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png);"></div>
                                                <?php } ?>

                                                <div class="card-body">
                                                    <div class="course-category">
                                                        <small class="text-muted"><i class="fa fa-play-circle"></i> Course Category</small>
                                                    </div>
                                                    <a href="<?= $url ?>" <?= $evnt ?>>
                                                        <h5 class="card-title"><?= $value->course_title; ?></h5>
                                                    </a>
                                                    <?php
                                                    $lessonList = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $value->course_id, 'order' => 'lesson_no'));

                                                    // foreach ($lessonList as $key => $lessonListValue) {

                                                    //    if(!$flag){
                                                    //        $lessonListChildren  = Lesson::model()->find(array('condition' => 'parent_id = ' . $lessonListValue->id, 'order' => 'lesson_no'));
                                                    //        if($lessonListChildren){
                                                    //         $lessonListValue->title = $lessonListChildren->title;
                                                    //         $lessonListValue->description = $lessonListChildren->description;
                                                    //         $lessonListValue->content = $lessonListChildren->content;
                                                    //         $lessonListValue->image = $lessonListChildren->image;
                                                    //     }

                                                    // }

                                                    // var_dump($lessonListValue);

                                                    // $checkLessonPass = Helpers::lib()->checkCourseStatus($value->course_id);

                                                    // var_dump($value->getGenID($value->course_id)); exit();
                                                    $status_course_gen = Helpers::lib()->StatusCourseGen($value->course_id, $value->getGenID($value->course_id));

                                                    // var_dump($checkLessonPass);

                                                    // if ($checkLessonPass->status == "notLearn") {
                                                    //     $colorTab = 'listlearn-danger';
                                                    //     $lessonStatusStr = $labelCourse->label_notLearn;
                                                    // } else if ($checkLessonPass->status == "learning") {
                                                    //     $colorTab = 'listlearn-warning';
                                                    //     $lessonStatusStr = $labelCourse->label_learning;
                                                    // } else if ($checkLessonPass->status == "pass") {
                                                    //     $colorTab = 'listlearn-success';
                                                    //     $lessonStatusStr =  $labelCourse->label_learnPass;
                                                    // }

                                                    if ($status_course_gen == "notLearn") {
                                                        $colorTab = 'listlearn-danger';
                                                        $lessonStatusStr = $labelCourse->label_notLearn;
                                                        $class = "defaultcourse";
                                                        $color = "#fff";
                                                    } else if ($status_course_gen == "learning") {
                                                        $colorTab = 'listlearn-warning';
                                                        $lessonStatusStr = $labelCourse->label_learning;
                                                        $class = "warningcourse";
                                                        $color = "#fff";
                                                    } else if ($status_course_gen == "pass") {
                                                        $colorTab = 'listlearn-success';
                                                        $lessonStatusStr =  $labelCourse->label_learnPass;
                                                        $class = "successcourse";
                                                        $color = "#fff";
                                                    }

                                                    ?>
                                                    <span class="card-text-1">
                                                        <?= $status ?> :
                                                        <a style="color: <?= $color ?>" class="<?= $class ?>">
                                                            <?= $lessonStatusStr ?>
                                                        </a>
                                                    </span>
                                                    <?php
                                                    //}

                                                    ?>
                                                    <div class="course-time">
                                                        <small class="text-muted"><i class="fa fa-clock"></i> 1 hr 30 min.</small>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php

                        }
                    }
                    ?>
                </div>
                <div class="text-center">
                    <a class="btn btn-viewall" href="<?php echo $this->createUrl('/course/index'); ?>" role="button"><?= $label->label_viewAll ?> <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/add.svg"></a>
                </div>
            </div>
        </section>
    <?php } ?>
    <?php foreach ($course_online as $key => $value) {

        if ($value->status == 1) {

            if ($value->lang_id != 1) {
                $value->course_id = $value->parent_id;
            }
            if (!$flag) {
                $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $value->course_id, 'order' => 'course_id'));
                if ($modelChildren) {
                    $value->course_title = $modelChildren->course_title;
                    $value->course_short_title = $modelChildren->course_short_title;
                    $value->course_detail = $modelChildren->course_detail;
                    $value->course_picture = $modelChildren->course_picture;
                }
            }
            if ($value->parent_id != 0) {
                $value->course_id = $value->parent_id;
            }
            $expireDate = Helpers::lib()->checkCourseExpire($value);
            if ($expireDate) {
                $date_start = date("Y-m-d H:i:s", strtotime($value->course_date_start));
                $dateStartStr = strtotime($date_start);
                $currentDate = strtotime(date("Y-m-d H:i:s"));
                if ($currentDate >= $dateStartStr) {
                    $chk = Helpers::lib()->getLearn($value->course_id);
                    if ($chk) {


                        $chk_logtime = LogStartcourse::model()->find(array(
                            'condition' => 'course_id=:course_id and user_id=:user_id and active=:active and gen_id=:gen_id',
                            'params' => array(':course_id' => $value->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $value->getGenID($value->course_id))
                        ));
                        $course_chk_time = CourseOnline::model()->findByPk($value->course_id);


                        if (!empty($chk_logtime)) {
                            if ($chk_logtime->course_day != $course_chk_time->course_day_learn) {
                                $Endlearncourse = strtotime("+" . $course_chk_time->course_day_learn . " day", strtotime($chk_logtime->start_date));

                                $Endlearncourse = date("Y-m-d", $Endlearncourse);

                                $chk_logtime->end_date = $Endlearncourse;
                                $chk_logtime->course_day = $course_chk_time->course_day_learn;
                                $chk_logtime->save(false);
                            }
                        }



                        $expireUser = Helpers::lib()->checkUserCourseExpire($value);
                        if (!$expireUser) {
                            $evnt = 'onclick="alertMsg(\'' . $label->label_swal_youtimeout . '\',\'\',\'error\')"';
                            $url = 'javascript:void(0)';
                        } else {
                            $evnt = '';
                            $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                        }
                    } else {
                        $evnt = '';
                        $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                        // $evnt = 'data-toggle="modal"';
                        // $url = '#modal-startcourse'.$value->course_id;
                    }
                } else {
                    $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                    $url = 'javascript:void(0)';
                }
            } elseif ($expireDate == 3) {
                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_coursenoopen . '\',\'error\')"';
                $url = 'javascript:void(0)';
            } else {
                $evnt = 'onclick="alertMsg(\'ระบบ\',\'' . $labelcourse->label_swal_timeoutcourse . '\',\'error\')"';
                $url = 'javascript:void(0)';
            }
            $chk = Helpers::lib()->getLearn($value->course_id);

            if (!$chk) { ?>

                <div class="modal fade" id="modal-startcourse<?= $value->course_id ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><?= $labelcourse->label_learnlesson ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2 text-center">
                                        <h3><?= (Yii::app()->user->id) ? $labelcourse->label_swal_regiscourse : $labelcourse->label_detail; ?></h3>
                                        <h2>"<?= $value->course_title ?>"</h2>
                                        <h3>(<?= $value->CategoryTitle->cate_title ?>)</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-success" href="<?= $url ?>" <?= $evnt ?>><?= UserModule::t("Ok") ?></a>
                                <a class="btn btn-warning" href="#" class="close" data-dismiss="modal" aria-hidden="true"><?= UserModule::t("Cancel") ?></a>
                            </div>
                        </div>
                    </div>
                </div>

    <?php }
        } //condition status
    } ?>

    <section class="slide-video news">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-sm-12">
                    <div class="page-header">
                        <h4><span><?= $label->label_news ?></span> </h4>
                    </div>
                    <?php
                    $criteria = new CDbCriteria;
                    $criteria->compare('active', y);
                    $criteria->compare('lang_id', $langId);
                    $criteria->order = 'sortOrder ASC';
                    $criteria->limit = 3;
                    $news = News::model()->findAll($criteria);
                    ?>
                    <?php foreach ($news as $key => $value) {
                        if ($value->cms_type_display == 'url' && !empty($value->cms_link)) {
                            $arr = json_decode($value->cms_link);
                            $link = $arr[0];
                            $new_tab = ($arr[1] == '0') ? '' : 'target="_blank"';
                        } else {
                            if (Yii::app()->session['lang'] != 1) {
                                $link = $this->createUrl('news/detail/', array('id' => $value->parent_id));
                            } else {
                                $link = $this->createUrl('news/detail/', array('id' => $value->cms_id));
                            }
                        }
                    ?>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <div class="well">
                                <a href="<?php echo $link; ?>" <?= $new_tab ?>>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' . $value->cms_id . '/thumb/' . $value->cms_picture)) { ?>
                                                <div class="news-img">
                                                    <img src="<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $value->cms_id ?>/thumb/<?php echo $value->cms_picture ?>" alt="">
                                                </div>
                                            <?php } else { ?>
                                                <div class="news-img">
                                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/new-img.png" alt="">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-12 col-sm-12  col-xs-12">
                                            <h4 class="title-news"><?php echo $value->cms_title ?></h4>
                                            <p class="detail-news "><?php echo $value->cms_short_title ?></p>
                                            <!-- <div class="news-date">
                                                <small><i class="far fa-clock"></i> <?php echo Helpers::lib()->DateLangTms($value->update_date, Yii::app()->session['lang']); ?></small>
                                            </div> -->
                                            <div class="news-more">
                                                <a href="<?php echo $link; ?>" <?= $new_tab ?> class="more"><?= $more ?> </a>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                    <span class="pull-right"><a class="btn btn-viewall" href="<?php echo $this->createUrl('/news/index'); ?>" role="button"><?= $label->label_viewAll ?> <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/add.svg"></a></span>
                </div>

                <?php
                $criteriavdo = new CDbCriteria;
                $criteriavdo->compare('active', 'y');
                $criteriavdo->compare('lang_id', Yii::app()->session['lang']);
                $criteriavdo->order = 'sortOrder DESC';
                $vdoshow = vdo::model()->find($criteriavdo);
                ?>
                <div class="col-lg-4 col-xs-12 col-sm-12">
                    <div class="page-header">
                        <h4><span><?= $label->label_vdo ?></span> </h4>
                    </div>
                    <?php
                    if ($vdoshow->vdo_type == 'link') {
                        $vdoName = $vdoshow->vdo_path;
                        $new_link = str_replace("watch?v=", "embed/", $vdoName);
                        $show = '<iframe class="embed-responsive-item" width="100%" height="88"  src="' . $new_link . '" allowfullscreen></iframe>';
                        echo $show;
                        $href = 'href="' . $vdoshow->vdo_path . '" target="_blank"';
                    } else {
                    ?>
                        <video class="video-js" controls preload="auto" style="width: 100%; height: 300;">
                            <!--  <source src="<?php echo Yii::app()->homeurl . '/../uploads/' . $vdoshow->vdo_path; ?>" type='video/mp4'> -->
                            <source src="<?php echo Yii::app()->baseUrl . '/admin/uploads/' . $vdoshow->vdo_path; ?>" type='video/mp4'>
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                            </p>
                        </video>
                    <?php } ?>
                    <span class="pull-right"><a class="btn mt-1 btn-viewall btn-sm" href="<?php echo $this->createUrl('/video/index'); ?>" role="button"><?= $label->label_viewAll ?> <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/add.svg"></a></span>
                </div>

            </div>
        </div>
    </section>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    function alertMsg(title, message, alert) {
        swal(title, message, alert);
    }
</script>

<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover();
    });
</script>