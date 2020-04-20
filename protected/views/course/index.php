<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

//  $strDate = "2008-08-14 13:42:44";
//  echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>
<!-- <div class="header-page parallax-window">
    <div class="container">
        <h1><?php echo $label->label_course; ?>
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li> /
                    <li><span class="text-bc"><?php echo $label->label_course; ?></span></li>
                </ul>
            </small>
        </h1>
    </div>
</div> -->

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $label->label_course; ?></li>
        </ol>
    </nav>
</div>

<section class="content" id="course">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <!-- Search -->
                <!-- <form id="searchForm" action="<?php echo $this->createUrl('course/Search') ?>" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" name="text" placeholder='<?php echo $label->label_search; ?>'>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form> -->

                <!--end  Search -->

                <h4 class="text-center courseindex"><?php echo $label->label_cate; ?></h4>
                <div class="type-menu gallery">
                    <button class="btn btn-default filter-button btn-lg " data-filter="cate-all"><?php echo $label->label_courseAll; ?></button>
                    <?php foreach ($model_cate as $m_c) {
                        $m_c  = $m_c->course->CategoryTitle;
                        if (!$flag) {
                            $m_cChildren  = Category::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $m_c->cate_id, 'order' => 'cate_id'));
                            if ($m_cChildren) {
                               $m_c->cate_title = $m_cChildren->cate_title;
                               $m_c->cate_short_detail = $m_cChildren->cate_short_detail;
                               $m_c->cate_detail = $m_cChildren->cate_detail;
                               $m_c->cate_image = $m_cChildren->cate_image;
                           }
                       }
                       if ($m_c->lang_id != 1) {
                        $m_c->cate_id = $m_c->parent_id;
                    }
                    ?>
                    <button style="white-space: normal;" class="btn btn-default filter-button btn-lg" data-filter="<?= $m_c->cate_id ?>"><?= $m_c->cate_title ?></button>
                <?php } ?>

                <?php if ($model_cate_tms) {
                    if ($model_cate_tms->lang_id != 1) {
                        $model_cate_tms->cate_id = $m_c->parent_id;
                    }
                    ?>
                    <button style="white-space: normal;" class="btn btn-default filter-button btn-lg" data-filter="<?= $model_cate_tms->cate_id ?>"><?= $model_cate_tms->cate_title ?></button>
                <?php } ?>
            </div>
        </div>
        <div class="col-sm-8 col-md-9">
            <div class="row">
                <?php
                if ($model_cate_tms) {
                    if ($model_cate_tms->lang_id != 1) {
                        $model_cate_tms->cate_id = $model_cate_tms->parent_id;
                    }
                    ?>
                    <div class="gallery_product col-sm-6 col-md-4 filter cate-all">
                        <div class="well text-center">
                            <button class="btn btn-default filter-button btn-lg" data-filter="<?= $model_cate_tms->cate_id ?>" style="border:0;background-color: transparent;width: 100%;box-shadow: none;">

                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/category/' . $model_cate_tms->cate_id . '/thumb/' . $model_cate_tms->cate_image)) { ?>

                                    <div class="course-img" style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/uploads/category/<?php echo $model_cate_tms->cate_id . '/thumb/' . $model_cate_tms->cate_image; ?>);"></div>
                                <?php } else { ?>
                                    <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                <?php } ?>
                                <div class="course-detail">
                                    <h4 class="text11"><?= $model_cate_tms->cate_title ?>....</h4>
                                    <p class="p"><?= $model_cate_tms->cate_short_detail ?></p>
                                </div>
                            </button>
                        </div>
                    </div>
                <?php  } ?>


                <?php foreach ($model_cate as $m_c) {
                    $m_c  = $m_c->course->CategoryTitle;

                    if ($m_c->lang_id != 1) {
                        $m_c->cate_id = $m_c->parent_id;
                    }

                    ?>

                    <div class="gallery_product col-sm-6 col-md-4 filter cate-all">
                        <div class="well text-center">
                            <!--                            <a href="course-detail.php-->

                                <button class="btn btn-default filter-button btn-lg" data-filter="<?= $m_c->cate_id ?>" style="border:0;background-color: transparent;width: 100%;box-shadow: none;">
                                    <?php 

                                    if (!$flag) {
                                        $m_cChildren  = Category::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $m_c->cate_id, 'order' => 'cate_id'));
                                        if ($m_cChildren) {
                                           $m_c->cate_id = $m_cChildren->cate_id;
                                           $m_c->cate_title = $m_cChildren->cate_title;
                                           $m_c->cate_short_detail = $m_cChildren->cate_short_detail;
                                           $m_c->cate_detail = $m_cChildren->cate_detail;
                                           $m_c->cate_image = $m_cChildren->cate_image;
                                       }
                                   }
                                   ?>

                                   <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/category/' . $m_c->cate_id . '/thumb/' . $m_c->cate_image)) { ?>
                                    <div class="course-img" style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/uploads/category/<?php echo $m_c->cate_id . '/thumb/' . $m_c->cate_image; ?>);"></div>
                                <?php } else { ?>
                                    <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                <?php } ?>
                                <div class="course-detail">
                                    <h4 class="text11"><?= $m_c->cate_title ?>....</h4>
                                    <p class="p"><?= $m_c->cate_short_detail ?></p>
                                        <!-- <i class="fa fa-calendar"></i>&nbsp;<? php // echo DateThai($m_c->update_date); 
                                        ?> -->
                                    </div>
                                </button>
                            </div>
                        </div>
                    <?php  } ?>

                    <?php foreach ($modelCourseTms as $val) {
                        $model = $val->course;
                        $schedule = $val->schedule;
                        if ($model->lang_id != 1) {
                            $model->course_id = $model->parent_id;
                        }

                        if (!$flag) {
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $model->course_id, 'order' => 'course_id'));
                            if ($modelChildren) {
                        // $model->course_id = $modelChildren->course_id;
                                $model->course_title = $modelChildren->course_title;
                                $model->course_short_title = $modelChildren->course_short_title;
                                $model->course_detail = $modelChildren->course_detail;
                                $model->course_picture = $modelChildren->course_picture;
                            }
                        }
                        $expireDate = Helpers::lib()->checkCourseExpireTms($schedule);
                        if ($expireDate) {
                            $evnt = '';
                            $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id, 'courseType' => 'tms'));
                        } else {
            // $evnt = 'onclick="alertMsg(\'ระบบ\',\'หลักสูตรหมดอายุ\',\'error\')"';
                            if (date($schedule->training_date_start) > date("Y-m-d")) {
                                $evnt = 'onclick="alertMsgNotNow()"';
                                $url = 'javascript:void(0)';
                            } else {
                                $evnt = 'onclick="alertMsg()"';
                                $url = 'javascript:void(0)';
                            }
                        }
                        ?>

                        <div class="gallery_product col-sm-6 col-md-4 filter <?= $model->cate_id ?>" style="display: none;">
                            <div class="well text-center">
                                <!--                            <a href="course-detail.php-->
                                    <a href="<?= $url; ?>" <?= $evnt ?>>
                                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $model->course_id . '/thumb/' . $model->course_picture)) { ?>
                                            <div class="course-img" style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/uploads/courseonline/<?php echo $model->course_id . '/thumb/' . $model->course_picture; ?>);"></div>
                                        <?php } else { ?>
                                            <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                        <?php } ?>
                                        <div class="course-detail">

                                            <?php
                                            $courseStatus = Helpers::lib()->checkCoursePass($model->id);

                                            if ($courseStatus == "notPass") {
                                                $statusLearnClass = 'muted';
                                            } else if ($courseStatus == "learning") {
                                                $statusLearnClass = 'warning';
                                            } else if ($courseStatus == "pass") {
                                                $statusLearnClass = 'success';
                                            }
                                            ?>


                                            <h4 class="text11"><i class="fa fa-trophy fa-sm text-<?= $statusLearnClass; ?>"></i> &nbsp <?= $model->course_title ?>....</h4>

                                            <p class="p"><?= $model->course_short_title ?></p>
                                            <!-- <i class="fa fa-calendar"></i> -->
                                            <hr class="line-course">
                                        <!--  <p  class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> วันที่เริ่มเรียน <?= DateThai($model->course_date_start); ?> </p>
                                            <p  class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> วันที่สิ้นสุด <?= DateThai($model->course_date_end); ?></p>  -->
                                            <p class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?= $label->label_dateStart ?> <?php echo Helpers::lib()->DateLangTms($schedule->training_date_start, Yii::app()->session['lang']); ?> </p>
                                            <p class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?= $label->label_dateExpire ?> <?php echo Helpers::lib()->DateLangTms($schedule->training_date_end, Yii::app()->session['lang']); ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php  } ?>

                        <?php foreach ($Model as $model) {
                            $model = $model->course;

                            if ($model->lang_id != 1) {
                                $model->course_id = $model->parent_id;
                            }

                            // var_dump(expression)
                            $expireDate = Helpers::lib()->checkCourseExpire($model);
                            if ($expireDate) {
                                $evnt = '';
                                $url = Yii::app()->createUrl('course/detail/', array('id' => $model->course_id));
                            } else {
                            // $evnt = 'onclick="alertMsg(\'ระบบ\',\'หลักสูตรหมดอายุ\',\'error\')"';
                                if (date($model->course_date_start) > date("Y-m-d")) {
                                    $evnt = 'onclick="alertMsgNotNow()"';
                                    $url = 'javascript:void(0)';
                                } else {
                                    $evnt = 'onclick="alertMsg()"';
                                    $url = 'javascript:void(0)';
                                }
                            }
                            ?>
                            <div class="gallery_product col-sm-6 col-md-4 filter <?= $model->cate_id ?>" style="display: none;">
                                <div class="well text-center">
                                    <!--                            <a href="course-detail.php-->
                                        <a href="<?= $url; ?>" <?= $evnt ?>>
                                            <?php
                                            if (!$flag) {
                                                $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $model->course_id, 'order' => 'course_id'));
                                                if ($modelChildren) {
                                                    $model->course_id = $modelChildren->course_id;
                                                    $model->course_title = $modelChildren->course_title;
                                                    $model->course_short_title = $modelChildren->course_short_title;
                                                    $model->course_detail = $modelChildren->course_detail;
                                                    $model->course_picture = $modelChildren->course_picture;
                                                }
                                            }
                                            ?>
                                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $model->course_id . '/thumb/' . $model->course_picture)) { ?>
                                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/uploads/courseonline/<?php echo $model->course_id . '/thumb/' . $model->course_picture; ?>);"></div>
                                            <?php } else { ?>
                                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                            <?php } ?>
                                            <div class="course-detail">

                                                <?php
                                                $courseStatus = Helpers::lib()->checkCoursePass($model->id);

                                                if ($courseStatus == "notPass") {
                                                    $statusLearnClass = 'muted';
                                                } else if ($courseStatus == "learning") {
                                                    $statusLearnClass = 'warning';
                                                } else if ($courseStatus == "pass") {
                                                    $statusLearnClass = 'success';
                                                }
                                                ?>


                                                <h4 class="text11"><i class="fa fa-trophy fa-sm text-<?= $statusLearnClass; ?>"></i> &nbsp <?= $model->course_title ?>....</h4>

                                                <p class="p"><?= $model->course_short_title ?></p>
                                                <!-- <i class="fa fa-calendar"></i> -->
                                                <hr class="line-course">
                                        <!-- <p  class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> วันที่เริ่มเรียน <?= DateThai($model->course_date_start); ?> </p>
                                            <p  class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> วันที่สิ้นสุด <?= DateThai($model->course_date_end); ?></p> -->
                                            <p class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?= $label->label_dateStart ?> <?php echo Helpers::lib()->DateLang($model->course_date_start, Yii::app()->session['lang']); ?> </p>
                                            <p class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?= $label->label_dateExpire ?> <?php echo Helpers::lib()->DateLang($model->course_date_end, Yii::app()->session['lang']); ?></p>

                                            <div class="text-center mt-20">
                                                <a href="javascript" class="btn btn-danger btn-regislearn">สมัครเรียน</a>
                                                 <!-- <a href="javascript" class="btn btn-danger btn-learnmore">เข้าสู่บทเรียน</a> -->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php  } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function alertMsg() {

            var title = '<?= !empty($label->label_swal_warning) ? $label->label_swal_warning : ''; ?>';
            var message = '<?= !empty($label->label_alert_msg_expired) ? $label->label_alert_msg_expired : ''; ?>';
            var alert = 'error';

            swal(title, message, alert);
        }

        function alertMsgNotNow() {
            <?php
            if ($langId == 1) {
                $strDate = "Comming soon!";
            } else {
                $strDate = "ยังไม่ถึงเวลาเรียน";
            }
            ?>
            var title = '<?= !empty($label->label_swal_warning) ? $label->label_swal_warning : ''; ?>';
            var message = '<?= !empty($strDate) ? $strDate : ''; ?>';
            var alert = 'error';

            swal(title, message, alert);
        }
    </script>