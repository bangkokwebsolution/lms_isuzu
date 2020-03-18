 <!-- Global site tag (gtag.js) - Google Analytics -->
<style>


.text33{
    color: #FFFFFF;
    font-weight: bold;
    font-size: 22px;
    margin-top: 10px;
    margin-bottom: 10px;
    text-align: left;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    height:90px;

}
.coursebox{
    margin-top: 50px;
}
.line-layout{
    width: 100%;
    height:1px;
    background-color: red;
    position: relative;
}

.tms-course{
    border-bottom: 1px dashed #333;
}
.title-tms{
    background-color: #e32526;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    text-align: center;
    display: inline-block;
}
@media screen and (min-width:992px){
   /* .tms-course{
    border-bottom: 2px dashed #333;
    margin-top: 20px;*/
}

@media (max-width:600px){
   /* .tms-course:nth-child(4){
    border-bottom: 1px dashed #333;
    }*/
}


</style>
<?php
$ck_mail = "";
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                    $langId = Yii::app()->session['lang'] = 1;
                    if(Yii::app()->user->hasFlash('mail')){
                    $ck_mail = "Please Check your Junk Mail";
                    }
                }else{
                    $langId = Yii::app()->session['lang'];
                    if(Yii::app()->user->hasFlash('mail')){
                    $ck_mail = "กรุณาตวรจสอบใน จดหมายขยะ";
                    }
                }
function DateThai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

//  $strDate = "2008-08-14 13:42:44";
//  echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>

    
<?php if (Yii::app()->user->hasFlash('profile') && !isset(Yii::app()->user->id)) {  ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    swal({
      title: "สมัครสมาชิกสำเร็จ Email และ Password ของท่านคือ ",
      text: "Email :"+"<?= Yii::app()->user->getFlash('users'); ?>"+" & Password :"+"<?= Yii::app()->user->getFlash('profile'); ?>"+"<?= $ck_mail ?>",
      icon: "success",
      buttons: true,
      dangerMode: true,
  })  
    .then((willDelete) => {
      if (willDelete) {
        $('#modal-login').modal('show');
    } 
});
</script>
<?php 
Yii::app()->user->setFlash('profile',null);
Yii::app()->user->setFlash('users',null);
} 
?>
<?php 
$msg = Yii::app()->user->getFlash('msg');
$icon = Yii::app()->user->getFlash('icon');
if(!empty($msg)){
    $icon = !empty($icon) ? $icon : 'warning';
    ?>
    <script type="text/javascript">
        swal({
            title: "<?= $label->label_alert_warning; ?>",
            text: "<?= $msg; ?>",
            type: "<?= $icon ?>",
            // dangerMode: true,
        });
        $(document).ready(function() {
            window.history.replaceState( {} , 'msg', '<?= $this->createUrl('site/index') ?>' );
        });
    </script>
    <?php
    Yii::app()->user->setFlash('msg',null);
    Yii::app()->user->setFlash('icon',null);
}?>

<div class="banner">
                <?php
                $criteriaimg = new CDbCriteria;
                $criteriaimg->compare('active',y);
                $criteriaimg->compare('lang_id',$langId);
                $banner = Mainimage::model()->find($criteriaimg);
                ?> 

    <img src="<?php echo Yii::app()->request->baseUrl;?>/uploads/mainimage/<?= $banner->id; ?>/thumb/<?= $banner->image_picture; ?>"  alt="airasia"  class="img-responsive">  
   <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner.jpg"  alt="airasia"  class="img-responsive"> -->
</div>

<!--slide start-->
<!-- <section class="slide-video">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="page-header">
                    <h1><span class="inline">
                    </span><span class="linehead"><?php echo $label->label_imgslide; ?></span>  <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/banner/index'); ?>" role="button"><?= $label->label_viewAll ?></a></span></h1>
                </div>
                <?php
                $criteriaimg = new CDbCriteria;
                $criteriaimg->compare('active',y);
                $criteriaimg->order = 'update_date  DESC';
                $image = Imgslide::model()->findAll($criteriaimg);
                ?>            
                <div id="carousel-id" class="carousel slide" data-ride="carousel">

                    <ol class="carousel-indicators">

                        <?php if (!isset($image[0])) { ?>
                        <li data-target="#carousel-id" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-id" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-id" data-slide-to="2" class=""></li>
                        <?php }else{
                            foreach ($image as $key => $value) {
                                ?>

                                <li data-target="#carousel-id" data-slide-to="<?= $key; ?>" class="<?php if($key==0) echo 'active';?>"></li>

                                <?php 
                            }
                        }
                        ?>
                    </ol>

                    <div class="carousel-inner">
                        <?php if (!isset($image[0])) { ?>
                        <div class="item active">
                            <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                            <div class="container">
                            </div>
                        </div>
                        <div class="item">
                            <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                            <div class="container">
                            </div>
                        </div>
                        <div class="item">
                            <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                            <div class="container">
                                <div class="carousel-caption">
                                </div>
                            </div>
                        </div>
                        <?php } else {

                            foreach ($image as $key => $value) {

                                ?>

                                <div class="item <?php if($key==0) echo 'active';?>">
                                    <img alt="<?= $value->imgslide_title ; ?>" src="<?php echo Yii::app()->request->baseUrl;?>/uploads/imgslide/<?= $value->imgslide_id; ?>/thumb/<?= $value->imgslide_picture; ?>">
                                    <div class="container">
                                    </div>
                                </div>

                                <?php

                            }
                        } ?> 
                    </div>
                    <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                    <a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
            <?php
            $criteriavdo = new CDbCriteria;
            $criteriavdo->compare('active','y');
            $criteriavdo->order = 'vdo_id  DESC';
            $vdoshow = Vdo::model()->find($criteriavdo);
            ?>
            <div class="col-sm-4">
                <div class="page-header">
                    <h1><span class="inline">
                    </span><span class="linehead"><?php echo $label->label_vdo; ?></span> <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/video/index'); ?>" role="button"><?= $label->label_viewAll ?></a></span></h1>
                </div>
                <?php 
                if($vdoshow->vdo_type == 'link'){
                        $vdoName = $vdoshow->vdo_path;
                        $new_link = str_replace("watch?v=", "embed/", $vdoName);
                        $show = '<iframe class="embed-responsive-item" width="100%" height="120"  src="'.$new_link.'" allowfullscreen style="box-shadow:1px 4px 6px #767676"></iframe>';
                        echo $show;
                        $href = 'href="'.$vdoshow->vdo_path.'" target="_blank"';
                    } else {
                ?>
                <video class="video-js" controls preload="auto" style="width: 100%; height: 450px;" >
                    <source src="<?php echo Yii::app()->homeurl.'/uploads/'.$vdoshow->vdo_path ;?>" type='video/mp4'>
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section> -->
    <!--end slide and video-->
    
    <!--start course-->
    <?php if(!empty(Yii::app()->user->id)){ ?>
        <section class="course" style="background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-section1.png) no-repeat center bottom fixed;background-color: #e9eaed; background-size: contain;">
            <div class="container">
                <div class="page-header">
                    <h1><span class="inline"><!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/open-book.png" class="img-responsive" alt=""> --></span><span class="linehead"><?php echo $label->label_course; ?></span> <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/course/index'); ?>" role="button"><?= $label->label_viewAll ?></a></span></h1>
                    <?php foreach ($model as $key => $value) {
                        if(Yii::app()->user->id != null){
                             $value = $value->course;
                        }
                       
                        if(Yii::app()->session['lang'] != 1){
                            $modelChildren  = CourseOnline::model()->find(array(
                                    'condition' => 'active = "y" and lang_id = :lang_id AND parent_id = :parent_id', 'order' => 'update_date',
                                    'params' => array('lang_id' => Yii::app()->session['lang'],':parent_id' => $value->course_id)
                                )
                            );
                            if($modelChildren){
                                    $value->course_title = $modelChildren->course_title;
                                    $value->course_short_title = $modelChildren->course_short_title;
                                    $value->course_detail = $modelChildren->course_detail;
                                    $value->course_picture = $modelChildren->course_picture;
                            }

                        }
                  ?>

                 <div class="row tms-course">

                      <div class="col-xs-12 col-sm-4 col-md-3 coursebox">
                    <div class="well text-center">
                        <a href="<?= Yii::app()->createUrl('course/detail/', array('id' => $value->course_id)); ?>">
                            <!-- Check image -->
                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $value->course_id.'/thumb/'.$value->course_picture)) { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?php echo $value->course_id.'/thumb/'.$value->course_picture; ?>);"></div>
                                <?php } else { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                <?php } ?>
                                <div class="course-detail2">
                                    <h4 class="text11"><?= $value->course_title; ?></h4>
                                    <p class="p"><?= $value->course_short_title; ?></p>
                                    <hr class="line-course">
                                   <!--  <p class="cldcourse"><i class="fa fa-calendar dangercld"></i>&nbsp;<?php echo DateThai($value->update_date); ?></p> -->
                                    <p class="cldcourse"><i class="fa fa-calendar dangercld"></i>&nbsp;<?php echo Helpers::lib()->DateLang($value->course_date_end,Yii::app()->session['lang']); ?></p>
                                    <!-- <div class="statuscourse"> -->
                                        <div class="pull-left">
                                        <!-- <a class="btn btn-statusno">ยังไม่ได้เรียน</a> -->
                                        <!-- <a class="btn btn-statuswait">กำลังเรียน</a> -->
                                        <!-- <a class="btn btn-statussuc">เรียนผ่านแล้ว</a> -->
                                        </div>
                                       <!--  <div class="pull-right">
                                            <i class="fa fa-file-audio-o icontype" aria-hidden="true"></i>
                                            <i class="fa fa-file-pdf-o icontype" aria-hidden="true"></i>
                                            <i class="fa fa-file-video-o icontype" aria-hidden="true"></i>
                                        </div> -->
                                    <!-- </div> -->
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
                 </div>


                <?php 
                if(Yii::app()->user->id != null): ?>
                <?php if(!empty($modelCourseTms)){ ?>
               <div class="row  tms-course">
                   <div class="text-center"> <h4 class="title-tms">TMS</h4></div>
                    <?php foreach ($modelCourseTms as $key => $value) {
                        $schedule = $value->schedule;
                        $expireDate = Helpers::lib()->checkCourseExpireTms($schedule);
                        if($expireDate){
                            $evnt = '';
                            $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id,'courseType'=>'tms'));
                        } else {
                            if(date($schedule->training_date_start) > date("Y-m-d")){
                                $evnt = 'onclick="alertMsgNotNow()"';
                                $url = 'javascript:void(0)';
                            }else{
                                $evnt = 'onclick="alertMsg()"';
                                $url = 'javascript:void(0)';
                            }
                        }

                        if(Yii::app()->session['lang'] != 1){
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'active = "y" and lang_id = '.Yii::app()->session['lang'].' AND parent_id = ' . $value->course_id, 'order' => 'update_date'));
                            if($modelChildren){
                                    $value->course->course_title = $modelChildren->course_title;
                                    $value->course->course_short_title = $modelChildren->course_short_title;
                                    $value->course->course_detail = $modelChildren->course_detail;
                                    $value->course->course_picture = $modelChildren->course_picture;
                            }

                        }
                  ?>
                 
                      <div class="col-xs-12 col-sm-4 col-md-3 coursebox">
                    <div class="well text-center">
                            <!-- Check image -->
                            <a href="<?= $url; ?>" <?= $evnt?>>
                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $value->course->course_id.'/thumb/'.$value->course->course_picture)) { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?php echo $value->course->course_id.'/thumb/'.$value->course->course_picture; ?>);"></div>
                                <?php } else { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                <?php } ?>
                                <div class="course-detail2">
                                    <h4 class="text11"><?= $value->course->course_title; ?></h4>
                                    <p class="p"><?= $value->course->course_short_title; ?></p>
                                    <hr class="line-course">
                                   <!--  <p class="cldcourse"><i class="fa fa-calendar dangercld"></i>&nbsp;<?php echo DateThai($value->course->update_date); ?></p> -->
                                    <p class="cldcourse"><i class="fa fa-calendar dangercld"></i>&nbsp;<?php echo Helpers::lib()->DateLang($value->course->update_date,Yii::app()->session['lang']); ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
               </div>
           <?php } ?>



               <?php foreach ($modelCat as $key => $val){ 

                $criteria = new CDbCriteria;
                $criteria->with = array('course','course.CategoryTitle');
                $criteria->addIncondition('orgchart_id',$courseArr);
                $criteria->compare('course.active','y');
                $criteria->compare('course.status','1');
                $criteria->compare('categorys.cate_show','1');
                $criteria->compare('categorys.cate_id',$val->course->CategoryTitle->cate_id);
                $criteria->group = 'course.course_id';
                $criteria->addCondition('course.course_date_end >= :date_now');
                $criteria->params[':date_now'] = date('Y-m-d H:i');
                $criteria->order = 'course.course_id DESC';
                $criteria->limit = 4;
                $modelOrg = OrgCourse::model()->findAll($criteria);

                ?>
                   
                    
                <div class="row tms-course">
                    <br>
        <div class="text-center"> <h4 class="title-tms"><?= $val->course->CategoryTitle->cate_title ?></h4></div>
                <?php foreach ($modelOrg as $key => $value) {
                        $expireDate = Helpers::lib()->checkCourseExpire($value->course);
                        if($expireDate){
                            $evnt = '';
                            $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id,'courseType'=>'tms'));
                        } else {
                            if(date($schedule->training_date_start) > date("Y-m-d")){
                                $evnt = 'onclick="alertMsgNotNow()"';
                                $url = 'javascript:void(0)';
                            }else{
                                $evnt = 'onclick="alertMsg()"';
                                $url = 'javascript:void(0)';
                            }
                        }

                        if(Yii::app()->session['lang'] != 1){
                            $modelChildren  = CourseOnline::model()->find(array('condition' => 'active = "y" and lang_id = '.Yii::app()->session['lang'].' AND parent_id = ' . $value->course_id, 'order' => 'update_date'));
                            if($modelChildren){
                                    $value->course->course_title = $modelChildren->course_title;
                                    $value->course->course_short_title = $modelChildren->course_short_title;
                                    $value->course->course_detail = $modelChildren->course_detail;
                                    $value->course->course_picture = $modelChildren->course_picture;
                            }

                        }
                  ?>
                  <div class="col-xs-12 col-sm-4 col-md-3 coursebox">
                    <div class="well text-center">
                            <!-- Check image -->
                            <a href="<?= $url; ?>" <?= $evnt?>>
                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $value->course->course_id.'/thumb/'.$value->course->course_picture)) { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?php echo $value->course->course_id.'/thumb/'.$value->course->course_picture; ?>);"></div>
                                <?php } else { ?>
                                <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                                <?php } ?>
                                <div class="course-detail2">
                                    <h4 class="text11"><?= $value->course->course_title; ?></h4>
                                    <p class="p"><?= $value->course->course_short_title; ?></p>
                                    <hr class="line-course">
                                   <!--  <p class="cldcourse"><i class="fa fa-calendar dangercld"></i>&nbsp;<?php echo DateThai($value->course->update_date); ?></p> -->
                                    <p class="cldcourse"><i class="fa fa-calendar dangercld"></i>&nbsp;<?php echo Helpers::lib()->DateLang($value->course->update_date,Yii::app()->session['lang']); ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
            }
                    
                ?>
</div>
    <?php } 
    endif;
    ?>



                </div>
            
        </section>
    <?php } ?>
        <!--end course-->
        <!--start news-->
        <!-- <section class="news">
            <div class="container">
                <div class="page-header">
                    <h1><span class="inline">
                    </span><span class="linehead"><?php echo $label->label_news; ?> </span> <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/news/index'); ?>" role="button"><?= $label->label_viewAll ?></a></span></h1>
                </div>
                <?php
                
                $criteria = new CDbCriteria;
                $criteria->with = array('parent');
                $criteria->compare('t.active','y');
                $criteria->compare('t.lang_id',$langId);
                $criteria->order = 't.update_date  DESC';
                if($langId != 1 && !empty($langId))$criteria->compare('parent.active','y');
                $criteria->limit = 9;
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

                                            <div class="news-img" style="background-image: url(<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $value->cms_id ?>/thumb/<?php echo $value->cms_picture ?>);"></div>
                                            <?php } else { ?>
                                            <div class="news-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/newspaper.jpg);"></div>
                                            <?php } ?>
                                            <div class="news-date"><small><?php echo Helpers::lib()->DateLang($value->update_date,Yii::app()->session['lang']); ?></small></div>
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
            </section> -->
            <!--end news-->
            <!--start document-->
            <?php
            $criteria =new CDbCriteria;
            $criteria->order = 'updatedate  DESC';
            $criteria->condition='active = 1';
             $criteria->compare('lang_id',$langId);
            $criteria->limit = 10;  
            $Document = Document::model()->findAll($criteria); 
            if(!empty($Document) && Yii::app()->user->id != null){
            ?>
            <section class="document">
                <div class="container">
                    <div class="page-header">
                        <h1><span class="inline"><!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/record.png" class="img-responsive" alt=""> --></span><span class="linehead"><?php echo $label->label_docs; ?></span> <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/document/index'); ?>" role="button"><?= $label->label_viewAll ?></a></span></h1>
                    </div>
                        <div class="well">
                            <ul class="documentblock">
                                    <?php foreach ($Document as $key => $value) { ?>
                                    <?php if (!empty($value->dow_name)) { ?>
                                    <li><a href="<?= $this->createUrl('site/displayDocument',array('id'=>$value->dow_id)); ?> " target="_blank" >
                                        <?=$value->dow_name ?></a><span class="pull-right">
                                        <!-- <span class="text-date"><i class="fa fa-calendar"></i>&nbsp;<?php echo DateThai($value->dow_createday); ?></span> &nbsp;  -->
                                        <span class="text-date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Helpers::lib()->DateLang($value->dow_createday,Yii::app()->session['lang']); ?></span> &nbsp; 
                                        <a class="btn btn-warning" style="font-size: 12px;" href="<?= Yii::app()->baseUrl.'/admin/uploads/'.$value->dow_address; ?>" download="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $value->dow_address ?>"><i class="fa fa-download"></i>&nbsp;Download</a></span></li>

                                        <?php }   } ?>                          
                                    </ul>
                        </div>    
                </section>
            <?php  } ?>
                <!--end document-->
                <!--start link-->
                <!-- <section class="partner">
                    <div class="container">
                        <div class="partner-link parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-section1.png">
                            <div class="partner-link" style="background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-section1.png) no-repeat center top fixed;background-size: cover">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <h3 class="text-center"><span class="inline"></span> <?php echo $label->label_linkall; ?> </h3>
                                    </div>
                                </div>
                                <?php
                                $criteria = new CDbCriteria;
                                $criteria->compare('active',1);
                                $criteria->order = 'updatedate  DESC';
                                $criteria->limit = 7;
                                $link = FeaturedLinks::model()->findAll($criteria); ?>
                                <div class="owl-carousel owl-theme">
                                    <?php foreach ($link as $key => $value) { ?>
                                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/featuredlinks/original/' . $value->link_image)) { ?>
                                        <div class = "bg-white"> <a href = "<?php echo $value->link_url ?>" target = "_blank"><img height="82" src = "<?php echo Yii::app()->request->baseUrl; ?>/uploads/featuredlinks/original/<?php echo $value->link_image; ?>" class = "img-rounded" alt = ""></a> </div>
                                        <?php } else { ?>
                                        <div class = "bg-white"> <a href = "#" target = "_blank"><img height="82" src = "<?php echo Yii::app()->theme->baseUrl; ?>/images/c3.png" class = "img-rounded" alt = ""></a> </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="text-center">
                                <a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/site/Linkall'); ?>" role="button"><?= $label->label_viewAll ?></a>
                            </div>
                        </div>
                    </div>
                </section> -->
<!--end link -->
<script type="text/javascript">
    function alertMsg() {

        var title = '<?= !empty($labelCourse->label_swal_warning)? $labelCourse->label_swal_warning :''; ?>';
        var message = '<?= !empty($labelCourse->label_alert_msg_expired)? $labelCourse->label_alert_msg_expired:''; ?>';
        var alert = 'error';

        swal(title, message, alert);
    }

    function alertMsgNotNow() {
        <?php 
        if($langId == 1){
            $strDate = "Comming soon!";
        }else{
            $strDate = "ยังไม่ถึงเวลาเรียน";
        }
        ?>
        var title = '<?= !empty($labelCourse->label_swal_warning)? $labelCourse->label_swal_warning :''; ?>';
        var message = '<?= !empty($strDate)? $strDate:''; ?>';
        var alert = 'error';

        swal(title, message, alert);
    }
</script>