<style>
    .course-detail2{
        display: block;
        -webkit-margin-before: 1.33em;
        -webkit-margin-after: 1.33em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
    }
    .text11{
        color: #4D8741;
        font-weight: bold;
        font-size: 22px;
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: center;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        height:24px;

    }
    .text22{
        color: #4D8741;
        font-weight: bold;
        font-size: 22px;
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: left;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        height:55px;

    }
    .p{
        font-size: 17px;
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: left;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        min-height: 3em;  
    }
    .p2{
        font-size: 17px;
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: left;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        min-height: 3em;  
    }
</style>
<?php

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

//	$strDate = "2008-08-14 13:42:44";
//	echo "ThaiCreate.Com Time now : ".DateThai($strDate);
?>
<!-- <div class="banner"> -->
    <!-- <div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png"></div>
    <div class="banner-txt"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-txt.png" class="img-responsive" alt=""></div>
    <div class="banner-bottom"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-bottom.png" class="img-responsive" alt=""></div> -->

    <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/banner-animation.jpg" class="img-responsive" alt="" style="margin-top: 75px;"> -->
    
<!-- </div> -->
<script src="https://code.createjs.com/createjs-2015.11.26.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/banner/bannerlayka.js"></script>
<script>
var canvas, stage, exportRoot, anim_container, dom_overlay_container, fnStartAnimation;
function init() {
    canvas = document.getElementById("canvas");
    anim_container = document.getElementById("animation_container");
    dom_overlay_container = document.getElementById("dom_overlay_container");
    var comp=AdobeAn.getComposition("146A1313A42DB543BC314EC9BDEE6AD0");
    var lib=comp.getLibrary();
    var loader = new createjs.LoadQueue(false);
    loader.addEventListener("fileload", function(evt){handleFileLoad(evt,comp)});
    loader.addEventListener("complete", function(evt){handleComplete(evt,comp)});
    var lib=comp.getLibrary();
    loader.loadManifest(lib.properties.manifest);
}
function handleFileLoad(evt, comp) {
    var images=comp.getImages();    
    if (evt && (evt.item.type == "image")) { images[evt.item.id] = evt.result; }    
}
function handleComplete(evt,comp) {
    //This function is always called, irrespective of the content. You can use the variable "stage" after it is created in token create_stage.
    var lib=comp.getLibrary();
    var ss=comp.getSpriteSheet();
    var queue = evt.target;
    var ssMetadata = lib.ssMetadata;
    for(i=0; i<ssMetadata.length; i++) {
        ss[ssMetadata[i].name] = new createjs.SpriteSheet( {"images": [queue.getResult(ssMetadata[i].name)], "frames": ssMetadata[i].frames} )
    }
    exportRoot = new lib.bannernew();
    stage = new lib.Stage(canvas);
    stage.addChild(exportRoot); 
    //Registers the "tick" event listener.
    fnStartAnimation = function() {
        createjs.Ticker.setFPS(lib.properties.fps);
        createjs.Ticker.addEventListener("tick", stage);
    }       
    //Code to support hidpi screens and responsive scaling.
    function makeResponsive(isResp, respDim, isScale, scaleType) {      
        var lastW, lastH, lastS=1;      
        window.addEventListener('resize', resizeCanvas);        
        resizeCanvas();     
        function resizeCanvas() {           
            var w = lib.properties.width, h = lib.properties.height;            
            var iw = window.innerWidth, ih=window.innerHeight;          
            var pRatio = window.devicePixelRatio || 1, xRatio=iw/w, yRatio=ih/h, sRatio=1;          
            if(isResp) {                
                if((respDim=='width'&&lastW==iw) || (respDim=='height'&&lastH==ih)) {                    
                    sRatio = lastS;                
                }               
                else if(!isScale) {                 
                    if(iw<w || ih<h)                        
                        sRatio = Math.min(xRatio, yRatio);              
                }               
                else if(scaleType==1) {                 
                    sRatio = Math.min(xRatio, yRatio);              
                }               
                else if(scaleType==2) {                 
                    sRatio = Math.max(xRatio, yRatio);              
                }           
            }           
            canvas.width = w*pRatio*sRatio;         
            canvas.height = h*pRatio*sRatio;
            canvas.style.width = dom_overlay_container.style.width = anim_container.style.width =  w*sRatio+'px';               
            canvas.style.height = anim_container.style.height = dom_overlay_container.style.height = h*sRatio+'px';
            stage.scaleX = pRatio*sRatio;           
            stage.scaleY = pRatio*sRatio;           
            lastW = iw; lastH = ih; lastS = sRatio;     
        }
    }
    makeResponsive(true,'both',true,1); 
    AdobeAn.compositionLoaded(lib.properties.id);
    fnStartAnimation();
}
</script>
<div id="animation_container" style="background-color:rgba(255, 255, 255, 1.00); width:1920px; height:950px; margin-top: 75px;">
        <canvas id="canvas" width="1920" height="950" style="position: absolute; display: block; background-color:rgba(255, 255, 255, 1.00);"></canvas>
        <div id="dom_overlay_container" style="pointer-events:none; overflow:hidden; width:1920px; height:950px; position: absolute; left: 0px; top: 0px; display: block;">
        </div>
    </div>

<!--slide start-->
<section class="slide-video">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="page-header">
                    <h1><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/billboard.png" class="img-responsive" alt=""></span> ป้าย<small>ประชาสัมพันธ์</small> <span class="pull-right"><a class="btn btn-warning" href="<?php echo $this->createUrl('/banner/index'); ?>" role="button">ดูทั้งหมด</a></span></h1>
                </div>
                <?php
                $criteriaimg = new CDbCriteria;
                $criteriaimg->compare('active',y);
                $criteriaimg->order = 'update_date  DESC';
                $image = Imgslide::model()->findAll($criteriaimg);
                ?>            
                <div id="carousel-id" class="carousel slide" data-ride="carousel">

                    <ol class="carousel-indicators">
                        <li data-target="#carousel-id" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-id" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-id" data-slide-to="2" class=""></li>
                    </ol>

                    <div class="carousel-inner">
                        <!--first slide -->
                        <?php if ($image[0]->imgslide_id == null) { ?>
                            <div class="item active">
                            <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h4>Title</h4>
                                    <p class="visible-md visible-lg">Detail Example</p>
                                    <p><a class="btn btn-sm btn-warning" href="#" role="button">อ่านต่อ</a></p>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                                <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                                <div class="container">
                                    <div class="carousel-caption">
                                        <h4>Title</h4>
                                        <p class="visible-md visible-lg">Detail Example</p>
                                        <p><a class="btn btn-sm btn-warning" href="#" role="button">อ่านต่อ</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                                <div class="container">
                                    <div class="carousel-caption">
                                        <h4>Title</h4>
                                        <p class="visible-md visible-lg">Detail Example</p>
                                        <p><a class="btn btn-sm btn-warning" href="#" role="button">อ่านต่อ</a></p>
                                    </div>
                                </div>
                            </div>
                        <?php } else {} ?> 
                        <!--first slide -->
                        <!-- ///////////////////////////////////////////////////////////////////////// -->
                        <!-- slide  -->
                        <?php $searchtotal = count($image); ?>
                        <?php if ($searchtotal == 1) { ?>
                        <div class="item active">
                            <img alt="First slide" src="<?php echo Yii::app()->homeUrl; ?>/uploads/imgslide/<?php echo $image[0]->imgslide_id; ?>/thumb/<?php echo $image[0]->imgslide_picture; ?>">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h4><?php echo $image[0]->imgslide_title ; ?></h4>
                                    <p class="visible-md visible-lg"><?php echo $image[0]->imgslide_detail ; ?></p>
                                    <p><a class="btn btn-sm btn-warning" href="<?php echo $this->createUrl('/banner/detail',array('id'=> $image[0]->imgslide_id)); ?>" role="button">อ่านต่อ</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                                <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                                <div class="container">
                                    <div class="carousel-caption">
                                        <h4>Title</h4>
                                        <p class="visible-md visible-lg">Detail Example</p>
                                        <p><a class="btn btn-sm btn-warning" href="#" role="button">อ่านต่อ</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                                <div class="container">
                                    <div class="carousel-caption">
                                        <h4>Title</h4>
                                        <p class="visible-md visible-lg">Detail Example</p>
                                        <p><a class="btn btn-sm btn-warning" href="#" role="button">อ่านต่อ</a></p>
                                    </div>
                                </div>
                            </div>
                        <?php } elseif ($searchtotal == 2) { ?>
                        <div class="item active">
                            <img alt="First slide" src="<?php echo Yii::app()->homeUrl; ?>/uploads/imgslide/<?php echo $image[0]->imgslide_id; ?>/thumb/<?php echo $image[0]->imgslide_picture; ?>">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h4><?php echo $image[0]->imgslide_title ; ?></h4>
                                    <p class="visible-md visible-lg"><?php echo $image[0]->imgslide_detail ; ?></p>
                                    <p><a class="btn btn-sm btn-warning" href="<?php echo $this->createUrl('/banner/detail',array('id'=> $image[0]->imgslide_id)); ?>" role="button">อ่านต่อ</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <img alt="First slide" src="<?php echo Yii::app()->homeUrl; ?>/uploads/imgslide/<?php echo $image[1]->imgslide_id; ?>/thumb/<?php echo $image[1]->imgslide_picture; ?>">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h4><?php echo $image[1]->imgslide_title ; ?></h4>
                                    <p class="visible-md visible-lg"><?php echo $image[1]->imgslide_detail ; ?></p>
                                    <p><a class="btn btn-sm btn-warning" href="<?php echo $this->createUrl('/banner/detail',array('id'=> $image[1]->imgslide_id)); ?>" role="button">อ่านต่อ</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <img alt="First slide" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-banner.png">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h4>Title</h4>
                                    <p class="visible-md visible-lg">Detail Example</p>
                                    <p><a class="btn btn-sm btn-warning" href="#" role="button">อ่านต่อ</a></p>
                                </div>
                            </div>
                        </div>
                        <?php } elseif ($searchtotal == 3) { ?>
                        <div class="item active">
                            <img alt="First slide" src="<?php echo Yii::app()->homeUrl; ?>/uploads/imgslide/<?php echo $image[0]->imgslide_id; ?>/thumb/<?php echo $image[0]->imgslide_picture; ?>">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h4><?php echo $image[0]->imgslide_title ; ?></h4>
                                    <p class="visible-md visible-lg"><?php echo $image[0]->imgslide_detail ; ?></p>
                                    <p><a class="btn btn-sm btn-warning" href="<?php echo $this->createUrl('/banner/detail',array('id'=> $image[0]->imgslide_id)); ?>" role="button">อ่านต่อ</a></p>
                                </div>
                            </div>
                        </div>
                        <?php $s = 1; ?>  
                        <?php while ($s <= 2) { ?>
                        <div class="item">
                            <img alt="First slide" src="<?php echo Yii::app()->homeUrl; ?>/uploads/imgslide/<?php echo $image[$s]->imgslide_id; ?>/thumb/<?php echo $image[$s]->imgslide_picture; ?>">
                            <div class="container">
                                <div class="carousel-caption">
                                    <h4><?php echo $image[$s]->imgslide_title ; ?></h4>
                                    <p class="visible-md visible-lg"><?php echo $image[$s]->imgslide_detail ; ?></p>
                                    <p><a class="btn btn-sm btn-warning" href="<?php echo $this->createUrl('/banner/detail',array('id'=> $image[$s]->imgslide_id)); ?>" role="button">อ่านต่อ</a></p>
                                </div>
                            </div>
                        </div>
                       <?php $s++; } } ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                    <a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
          <!--end slide-->
          <!--start video-->
            <div class="col-sm-4">
                <div class="page-header">
                    <h1><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/youtube.png" class="img-responsive" alt=""></span> วิดีโอ<small>แนะนำ</small> <span class="pull-right"><a class="btn btn-warning" href="<?php echo $this->createUrl('/video/index'); ?>" role="button">ดูทั้งหมด</a></span></h1>
                </div>
                <video class="video-js" controls preload="auto" style="width: 100%; height: 416px;" data-setup="{}">
                    <source src="<?php echo Yii::app()->theme->baseUrl; ?>/vdo/mov_bbb.mp4" type='video/mp4'>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a web browser that
                        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>
                <!-- <video class="video-js" controls preload="auto" style="width: 100%; height: 416px;" data-setup="{}">
                    <source src="<?php echo Yii::app()->baseUrl; ?>/admin/uploads/pre_video_mp4.mp4" type='video/mp4'>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a web browser that
                        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video> -->
            </div>
          <!--end video-->
        </div>
    </div>
</section>
<!--end slide and video-->
<!--start course-->
<!-- <section class="course parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-section1.png"> -->
<section class="course" style="background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-section1.png) no-repeat center top fixed;background-size: cover">
    <div class="top1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/cloud-top.png" class="img-responsive" alt=""></div>
    <div class="container">
        <div class="page-header">
            <h1><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/open-book.png" class="img-responsive" alt=""></span> หลักสูตร<small>ของเรา</small> <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/course/index'); ?>" role="button">ดูทั้งหมด</a></span></h1>
        </div>
        <?php
        $criteria2 = new CDbCriteria;
        $criteria2->compare('active',y);
        $criteria2->order = 'update_date  DESC';
        $model = CourseOnline::model()->findAll($criteria2); 
        ?>
        <?php $i = 0; ?>
        <?php while ($i <= 11) { ?>
            <div class="col-sm-4 col-md-3">
                <div class="well text-center">
                    <a href="<?= Yii::app()->createUrl('course/detail/', array('id' => $model[$i]->course_id)); ?>">
                        <!-- Check image -->
                            <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $model[$i]->course_id.'/thumb/'.$model[$i]->course_picture)) { ?>
                        <div class="course-img" style="background-image: url(<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?php echo $model[$i]->course_id.'/thumb/'.$model[$i]->course_picture; ?>);"></div>
                            <?php } else { ?>
                        <div class="course-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                            <?php } ?>
                        <div class="course-detail2">
                            <h4 class="text11"><?= $model[$i]->course_title; ?></h4>
                            <p class="p"><?= $model[$i]->course_short_title; ?></p>
                            <i class="fa fa-calendar"></i>&nbsp;<?php echo DateThai($model[$i]->update_date); ?>
                        </div>
                    </a>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>
    <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</section>
<!--end course-->
<!--start news-->
<section class="news">
    <div class="container">
        <div class="page-header">
            <h1><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/text-lines.png" class="img-responsive" alt=""></span> ข่าว<small>ประชาสัมพันธ์</small> <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/news/index'); ?>" role="button">ดูทั้งหมด</a></span></h1>
        </div>
        <?php
        $criteria1 = new CDbCriteria;
        $criteria1->compare('active',y);
        $criteria1->order = 'update_date  DESC';
        ?>
        <?php $news = News::model()->findAll($criteria1); ?>
        <?php $i = 0; ?>
        <?php while ($i <= 3) { ?>
            <div class="col-sm-6">
                <div class="well">
                    <a href="<?php echo $this->createUrl('news/detail/', array('id' => $news[$i]->cms_id)); ?>">
                        <div class="row">
                            <div class="col-sm-4">

                                <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/news/' .$news[$i]->cms_id.'/thumb/'.$news[$i]->cms_picture)) { ?>

                                <div class="news-img" style="background-image: url(<?php echo Yii::app()->homeUrl; ?>uploads/news/<?php echo $news[$i]->cms_id ?>/thumb/<?php echo $news[$i]->cms_picture ?>);"></div>

                                    <?php } else { ?>

                                <div class="news-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/newspaper.jpg);"></div>

                                <?php } ?>
                                
                                <div class="news-date"><small><?php echo DateThai($news[$i]->update_date) ?></small></div>
                            </div>
                            <div class="col-sm-8">
                                <h4 class="text22"><?php echo $news[$i]->cms_title ?></h4>
                                <p class="p2"><?php echo $news[$i]->cms_short_title ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>
</section>
<!--end news-->
<!--start document-->
<?php
$criteria =new CDbCriteria;
$criteria->order = 'updatedate  DESC';
$criteria->condition='active = 1'; 
$Document = Document::model()->findAll($criteria); 
 ?>
<section class="document">
    <div class="container">
        <div class="page-header">
            <h1><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/record.png" class="img-responsive" alt=""></span> เอกสาร<small>เผยแพร่</small> <span class="pull-right"><a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/document/index'); ?>" role="button">ดูทั้งหมด</a></span></h1>
        </div>
        <div class="container">
            <div class="well bg-greenlight">
                <h4 class="text-center">ดาวน์โหลดฟรี</h4>
                <ul class="list-unstyled">
                <?php $i = 0; ?>
                        <?php while ($i <= 9) { ?>
                        <?php if (empty($Document[$i]->dow_name)) {
                        }else{ ?>

                       <li><?=$Document[$i]->dow_name ?>. <span class="pull-right">
                        <i class="fa fa-calendar"></i>&nbsp;<?php echo DateThai($Document[$i]->updatedate); ?> | 
                        <a href="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $Document[$i]->dow_address ?>" download="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $Document[$i]->dow_address ?>"><span class="glyphicon glyphicon-download-alt"></span></a></span></li>

                        <?php }  $i++; } ?>                          
                </ul>
                 
            </div>

        </div>

    </div>

</section>
<!--end document-->
<!--start link-->
<section class="partner">
    <div class="container">
        <!-- <div class="partner-link parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-section1.png"> -->
        <div class="partner-link" style="background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-section1.png) no-repeat center top fixed;background-size: cover">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h3 class="text-center"><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/diagram.png" class="img-responsive" alt=""></span> หน่วยงานที่เกี่ยวข้อง</h3>
                </div>
            </div>
            <?php $link = FeaturedLinks::model()->findAll(); ?>
            <?php $i = 1; ?>
            <div class="owl-carousel owl-theme">
                <?php while ($i <= 6) { ?>
                    <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/featuredlinks/thumb/' . $link[$i]->link_image)) {
                        $img = Yii::app()->homeUrl.'/uploads/featuredlinks/thumb/'.$link[$i]->link_image;    
                    } else { 
                        $img = Yii::app()->theme->baseUrl.'/images/c2.png';
                    }
                    ?>
                    <div class = "bg-white"> 
                        <a href = "<?php echo $link[$i]->link_url ?>" target = "_blank"><img src = "<?= $img ?>" class = "img-rounded" alt = ""></a> 
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
            <div class="text-center">
                <a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('/site/Linkall'); ?>" role="button">ดูทั้งหมด</a>
            </div>
        </div>
    </div>
</section>
<!--end link-->