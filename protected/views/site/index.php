
<?php
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
}else{
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
?>

<?php if (Yii::app()->user->hasFlash('users') && !isset(Yii::app()->user->id)) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "<?=UserModule::t('confirm_regis');?> ",
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
    Yii::app()->user->setFlash('profile',null);
    Yii::app()->user->setFlash('users',null);
}
?>

<?php if (Yii::app()->user->hasFlash('updateusers')) {  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "<?=UserModule::t('update_regis');?>",
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
    Yii::app()->user->setFlash('updateusers',null);
}
?>

<?php 
$msg = Yii::app()->user->getFlash('msg');
$icon = Yii::app()->user->getFlash('icon');
if(!empty($msg) || !empty($_GET['msg'])){
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
        $(document).ready(function () {
            window.history.replaceState({}, 'msg', '<?= $this->createUrl('site/index') ?>');
        });
    </script>
    <?php
    Yii::app()->user->setFlash('title',null);
    Yii::app()->user->setFlash('msg',null);
    Yii::app()->user->setFlash('icon',null);
}?>

<?php if(Yii::app()->user->id == null){ ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".course_site").attr("href", "JavaScript:void(0)")
            $(".course_site").click(function () {
                swal({
                    title: "<?=UserModule::t('Warning')?>",
                    text: "<?=UserModule::t('regis_first')?>",
                    icon: "warning",
                    dangerMode: true,
                }).then(function () {
                    $('#modal-login').modal('show');
                });

            });
        });
    </script>
<?php } ?>

<div class="banner" id="banner-bws">
 <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner.jpg" alt="Fitness Frist"
 class="img-responsive w-100">
</div>

<!--slide start-->
<section class="slide-video">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="page-header">
                    <h1><span class="inline">
                        <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/billboard.png" class="img-responsive" alt=""> --></span><span
                        class="linehead"><?= $label->label_imgslide ?></span> <span class="pull-right">
                            <a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/banner/index'); ?>"
                                role="button"><?= $label->label_viewAll ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></span></h1>
                            </div>
                            <?php
                            $criteriaimg = new CDbCriteria;
                            $criteriaimg->compare('active',y);
                            $criteriaimg->compare('lang_id',1);
                            $criteriaimg->order = 'update_date  DESC';
                            $image = Imgslide::model()->findAll($criteriaimg);
                            ?>
                            <div id="carousel-id" class="carousel slide" data-ride="carousel" data-interval="false">

                                <ol class="carousel-indicators">

                                    <?php if (!isset($image[0])) { ?>
                                        <li data-target="#carousel-id" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-id" data-slide-to="1" class=""></li>
                                        <li data-target="#carousel-id" data-slide-to="2" class=""></li>
                                    <?php }else{
                                        foreach ($image as $key => $value) {
                                            ?>
                                            <li data-target="#carousel-id" data-slide-to="<?= $key; ?>"
                                                class="<?php if($key==0) echo 'active';?>"></li>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </ol>

                                    <div class="carousel-inner">
                                        <!--first slide -->
                                        <?php if (!isset($image[0])) { ?>
                                            <div class="item active">
                                                <img alt="First slide"
                                                src="<?php echo Yii::app()->theme->baseUrl; ?>/img/banner-slide1.jpg">
                                                <div class="container">
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img alt="First slide"
                                                src="<?php echo Yii::app()->theme->baseUrl; ?>/img/banner-slide2.jpg">
                                                <div class="container">
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img alt="First slide"
                                                src="<?php echo Yii::app()->theme->baseUrl; ?>/img/banner-slide3.jpg">
                                                <div class="container">
                                                    <div class="carousel-caption">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else {

                                            foreach ($image as $key => $value) { ?>
                                                <div class="item <?php if($key==0) echo 'active';?>">
                                                    <a href="<?=  empty($value->imgslide_link)? 'javascript:void(0)':$value->imgslide_link;  ?>">
                                                        <img alt="<?= $value->imgslide_title ; ?>"
                                                        src="<?php echo Yii::app()->request->baseUrl;?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>">
                                                    </a>
                                                    <div class="container">
                                <!-- <div class="carousel-caption">
                                            <p><a class="btn btn-sm btn-warning" href="<?= $this->createUrl('/banner/detail',array('id'=> $value->imgslide_id)); ?>" role="button">อ่านต่อ</a></p>
                                        </div>-->
                                    </div>
                                </div>

                                <?php
                            }
                        } ?>
                        <!--first slide -->
                    </div>
                    <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span
                        class="glyphicon glyphicon-chevron-left"></span></a>
                        <a class="right carousel-control" href="#carousel-id" data-slide="next"><span
                            class="glyphicon glyphicon-chevron-right"></span></a>
                        </div>
                    </div>

                    <?php
                    $criteriavdo = new CDbCriteria;
                    $criteriavdo->compare('active','y');
                    $criteriavdo->order = 'vdo_id  DESC';
                    $vdoshow = vdo::model()->find($criteriavdo);
                    ?>
                    <div class="col-sm-4">
                        <div class="page-header">
                            <h1><span class="inline">
                                <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/youtube.png" class="img-responsive" alt=""> --></span><span
                                class="linehead"><?= $label->label_vdo ?></span> <span class="pull-right"><a
                                    class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/video/index'); ?>"
                                    role="button"><?= $label->label_viewAll ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></span></h1>
                                </div>
                                <?php
                                if($vdoshow->vdo_type == 'link'){
                                    $vdoName = $vdoshow->vdo_path;
                                    $new_link = str_replace("watch?v=", "embed/", $vdoName);
                                    $show = '<iframe class="embed-responsive-item" width="100%" height="350"  src="'.$new_link.'" allowfullscreen style="box-shadow:1px 4px 6px #767676"></iframe>';
                                    echo $show;
                                    $href = 'href="'.$vdoshow->vdo_path.'" target="_blank"';
                                } else {
                                    ?>
                                    <video class="video-js" controls preload="auto" style="width: 100%; height: 416px;">
                                        <source src="<?php echo Yii::app()->homeurl.'admin/uploads/'.$vdoshow->vdo_path ;?>"
                                            type='video/mp4'>
                                            <p class="vjs-no-js">
                                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                                <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                            </p>
                                        </video>
                                    <?php } ?>
                                </div>
                                <!--end video-->
                            </div>
                        </div>
                    </section>
                    <!--end slide and video-->

                    <!--start course-->
                    <section class="course"
                    style="background: url(<?php echo Yii::app()->theme->baseUrl; ?>/img/bg-course.jpg) no-repeat center bottom fixed;background-color: #e9eaed; ">
                    <div class="container">
                        <?php if(Yii::app()->user->id != null){ ?>
                            <div class="page-header">
                                <h1><span class="inline">
                                    <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/open-book.png" class="img-responsive" alt=""> --></span><span
                                    class="linehead"><?= $label->label_courseOur ?></span> <span class="pull-right"><a
                                        class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/course/index'); ?>"
                                        role="button"><?= $label->label_viewAll ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></span></h1>
                                    </div>
                                    <?php foreach ($course_online as $key => $value) {
                                        if($value->status == 1){

                                           if($value->lang_id != 1){
                                            $value->course_id = $value->parent_id;
                                        }
                                        if(!$flag){
                                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = '.$langId.' AND parent_id = ' . $value->course_id, 'order' => 'course_id'));
                                            if($modelChildren){
                                                $value->course_title = $modelChildren->course_title;
                                                $value->course_short_title = $modelChildren->course_short_title;
                                                $value->course_detail = $modelChildren->course_detail;
                                                $value->course_picture = $modelChildren->course_picture;
                                            }
                                        }


                                        if($value->parent_id != 0){
                                            $value->course_id = $value->parent_id;
                                        }
                                        

                                        $expireDate = Helpers::lib()->checkCourseExpire($value);
                                        if($expireDate){

                                            $date_start = date( "Y-m-d H:i:s", strtotime($value->course_date_start));
                                            $dateStartStr = strtotime($date_start);
                                            $currentDate = strtotime(date("Y-m-d H:i:s"));

                                            if($currentDate >= $dateStartStr){

                                                $chk = Helpers::lib()->getLearn($value->course_id);
                                                if ($chk) {
                                                 $expireUser = Helpers::lib()->checkUserCourseExpire($value);
                                                 if (!$expireUser) {
                                                    
                                                   $evnt = 'onclick="alertMsg(\''.$label->label_swal_youtimeout .'\',\'\',\'error\')"';
                                                   $url = 'javascript:void(0)';
                                               }else{
                                                   
                                                  $evnt = '';
                                                  $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                                              }
                                          }else{
                                           $evnt = 'data-toggle="modal"';
                                           $url = '#modal-startcourse'.$value->course_id;
                           // $url = '#modal-login';

                              // $evnt = '';
                              //   $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                                       }
                                   }else{

                                    $evnt = 'onclick="alertMsg(\'ระบบ\',\''. $labelcourse->label_swal_coursenoopen.'\',\'error\')"';
                                    $url = 'javascript:void(0)';
                                }

                            }elseif ($expireDate == 3) {
                                $evnt = 'onclick="alertMsg(\'ระบบ\',\''.$labelcourse->label_swal_coursenoopen.'\',\'error\')"';
                                $url = 'javascript:void(0)';
                            }else {
                                $evnt = 'onclick="alertMsg(\'ระบบ\',\''.$labelcourse->label_swal_timeoutcourse.'\',\'error\')"';
                                $url = 'javascript:void(0)';
                            }
                            // $evnt = '';
                          //             $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));
                            ?>





                            <div class="col-lg-3 col-md-3 coursebox">
                                <div class="well text-center">
                <!-- <a href="<?= Yii::app()->createUrl('course/detail/', array('id' => $value->course_id)); ?>"
                    class="course_site"> -->
                    <a href="<?= $url; ?>" <?= $evnt?>>

                        <!-- Check image -->
                        <?php $idCourse_img = (!$flag)? $modelChildren->course_id: $value->course_id; ?>
                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $idCourse_img.'/thumb/'.$value->course_picture)) { ?>

                            <div class="course-img"
                            style="background-image: url(<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?php echo $idCourse_img.'/thumb/'.$value->course_picture; ?>);">
                        </div>
                    <?php } else { ?>
                        <div class="course-img"
                        style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/img/book.png);"></div>
                    <?php } ?>
                    <div class="course-detail2">
                        <h4 class="text11"><?= $value->course_title; ?></h4>
                        <p class="p"><?= $value->course_short_title; ?></p>
                        <hr class="line-course">
                        <!--   <i class="fa fa-calendar"></i>&nbsp;<?php echo Helpers::lib()->DateLangTms($value->update_date, Yii::app()->session['lang']); ?> -->

                        <p  class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?=$labelcourse->label_startLearn?> <?php echo Helpers::lib()->DateLangTms($value->course_date_start,Yii::app()->session['lang']); ?>  </p>
                        <p  class="p" style="min-height: 0em; margin-top: 0px; margin-bottom: 0px;"> <?=$labelcourse->label_endLearn?> <?php echo Helpers::lib()->DateLangTms($value->course_date_end,Yii::app()->session['lang']); ?></p>


                    </div>

                </a>
            </div>
        </div>

        <?php

                    }//condition status
                }
                ?>

            <?php }else{ ?>
                <div class="col-md-12">
                    <div class="well before-login text-center">
                        <h3>กรุณาเข้าสู่ระบบ</h3>
                        <div class="mg-login">
                            <a class="btn-login-before" data-toggle="modal" href='#modal-login'><i class="fa fa-sign-in"
                                aria-hidden="true"></i>
                                <?=  $label->label_header_login ?>
                            </a>
                        </div>
                        <?php
                        if (Yii::app()->user->id == null) {
                            $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
                            $chk_status_reg = $SettingAll['ACTIVE_REGIS'];
                            if ($chk_status_reg) {
                                ?>
                                <p>หรือ</p>
                                <div class="mg-regis">
                                    <a class="btn-register-before" href="<?php echo $this->createUrl('/registration/ShowForm'); ?>">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i> <?= $label->label_header_regis ?>
                                    </a>
                                </div>
                            <?php }
                        }?>

                    </div>
                </div>
            <?php } ?>
        </div>

    </section>
    <!--end course-->
    <!--start news-->
    <section class="news">
        <div class="container">
            <div class="page-header">
                <h1><span class="inline">
                    <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/text-lines.png" class="img-responsive" alt=""> --></span><span
                    class="linehead"><?= $label->label_news ?></span> <span class="pull-right"><a
                        class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/news/index'); ?>"
                        role="button"><?= $label->label_viewAll ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></span></h1>
                    </div>
                    <?php
                    $criteria = new CDbCriteria;
                    $criteria->compare('active',y);
                    $criteria->compare('lang_id',$langId);
                    $criteria->order = 'sortOrder ASC';
                    $criteria->limit = 4;
                    ?>
                    <?php $news = News::model()->findAll($criteria); ?>
                    <?php foreach ($news as $key => $value) {
                        if($value->cms_type_display == 'url' && !empty($value->cms_link)){
                            $arr = json_decode($value->cms_link);
                            $link = $arr[0];
                            $new_tab = ($arr[1] == '0') ? '' : 'target="_blank"';
                        } else {
                            $link = $this->createUrl('news/detail/', array('id' => $value->cms_id));
                        }
                        ?>
                        <div class="col-sm-6">
                            <div class="well">
                                <a href="<?php echo $link; ?>" <?= $new_tab ?>>
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' .$value->cms_id.'/thumb/'.$value->cms_picture)) { ?>

                                                <div class="news-img"
                                                style="background-image: url(<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $value->cms_id ?>/thumb/<?php echo $value->cms_picture ?>);">
                                            </div>

                                        <?php } else { ?>

                                            <div class="news-img"
                                            style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/img/newspaper.jpg);">
                                        </div>

                                    <?php } ?>

                                    <div class="news-date">
                                        <small><?php echo Helpers::lib()->DateLangTms($value->update_date, Yii::app()->session['lang']); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <h4 class="text22"><?php echo $value->cms_title ?></h4>
                                    <p class="p2"><?php echo $value->cms_short_title ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>


    <?php foreach ($course_online as $key => $value) {
        
        if($value->status == 1){
            $chk = Helpers::lib()->getLearn($value->course_id);

            if (!$chk) { ?>

                <div class="modal fade" id="modal-startcourse<?=$value->course_id ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><?= $labelcourse->label_learnlesson ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2 text-center">
                                        <h3><?= (Yii::app()->user->id)? $labelcourse->label_swal_regiscourse : $labelcourse->label_detail ;?></h3>
                                        <h2>"<?= $value->course_title ?>"</h2>
                                        <h3>(<?=$value->CategoryTitle->cate_title ?>)</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-success" href="<?php echo Yii::app()->createUrl('course/detail/', array('id' => $value->course_id)) ?>"><?= UserModule::t("Ok")?></a>
                                <a class="btn btn-warning" href="#" class="close" data-dismiss="modal" aria-hidden="true"><?= UserModule::t("Cancel")?></a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } 
                    }//condition status
                } ?>
                <!--end news-->

                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                <script type="text/javascript">
                    function alertMsg(title,message,alert) {
                        swal(title, message, alert);
                    }
                </script>

                <script>
                    $(document).ready(function(){
                      $('[data-toggle="popover"]').popover(); 
                  });
              </script>

              <section class="document">
                <div class="container">
                    <div class="page-header" style="margin: 0px">
                        <h1 class="headtitle"><span class="line1"><?php echo $label->label_docs; ?></span><span
                            class="pull-right"><a class="btn btn-warning btn-sm"
                            href="<?php echo $this->createUrl('/document/index'); ?>" role="button"><i
                            class="fa fa-plus-circle"></i> <?= $label->label_viewAll ?></a></span></h1>
                        </div>
                        <div class="col-sm-12">
                            <div class="well bg-greenlight" style="margin-top: 20px;">
                                <?php
                                $criteria =new CDbCriteria;
                                $criteria->compare('active',1);
                                $criteria->compare('lang_id',$langId);
                                $criteria->order = 'updatedate  DESC';
                                $criteria->limit = 4;
                                $DocumentType = DocumentType::model()->findAll($criteria);
                                if(empty($DocumentType)){

                                    $criteria =new CDbCriteria;
                                    $criteria->compare('active',1);
                                    $criteria->compare('lang_id',1);
                                    $criteria->order = 'updatedate  DESC';
                                    $criteria->limit = 4;
                                    $DocumentType = DocumentType::model()->findAll($criteria);
                                }
                                ?>
                                <?php if (!empty($DocumentType)):
                                  foreach ($DocumentType as $key => $dt) { ?>
                                    <?php $docLang = $dt->lang_id ?>
                                    <div class="panel-headingdoc" style="padding-top: 10px">
                                        <h3 class="panel-titledoc"><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;
                                            <?= $dt->dty_name; ?></h3>
                                        </div>

                                        <?php
                                        $criteria =new CDbCriteria;
                                        $criteria->compare('active',1);
                                        $criteria->compare('dty_id',$dt->dty_id);
                                        $criteria->compare('lang_id',$docLang);
                                        $criteria->order = 'updatedate  DESC';
                                        $Document = Document::model()->findAll($criteria);
                                        ?>
                                        <ul class="list-unstyled" style="padding-left: 20px;">
                                            <?php if (isset($Document)) {
                                             foreach ($Document as $key => $value) { ?>
                                                <li>
                                                    <a href="<?php echo $this->createUrl('/document/download', array('id' => $value->dow_id)); ?>">
                                                        <?=$value->dow_name ?>.
                                                        <span class="pull-right"><i class="fa fa-calendar"
                                                            style="padding-right: 5px"></i><?= Helpers::lib()->DateLangTms($value->updatedate, Yii::app()->session['lang']); ?><i
                                                            class="fa fa-download" style="padding-left: 10px;"></i>
                                                        </a>
                                                    </li>
                                                <?php } } ?>
                                            </ul>

                                        <?php } endif ?>

                                    </div>
                                </div>
                            </div>
                        </section> 