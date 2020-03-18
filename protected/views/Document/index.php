
<?php
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                    $langId = Yii::app()->session['lang'] = 1;
                }else{
                    $langId = Yii::app()->session['lang'];
                }
function DateThai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    //$strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthCut = Array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>

        <!-- Header page -->
        <div class="header-page parallax-window">
            <div class="container">
                <h1><?= $label->label_docs  ?>
                    <small class="pull-right">
                        <ul class="list-inline list-unstyled">
                            <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage  ?></a></li> /
                            <li><span class="text-bc"><?= $label->label_docs  ?></span></li>
                        </ul>
                    </small>
                </h1>
            </div>
        </div>

        <!-- Content -->
        <section class="content" id="document">
            <div class="container">
                <!-- <div role="tabpanel"> -->
                    <!-- Nav tabs -->
                    <!-- <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" class="active f">
                            <a href="#doc-1" aria-controls="doc-1" role="tab" data-toggle="tab">รายชื่อเอกสาร</a>
                        </li>
                    </ul> -->

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!--start Doc1-->
                        <?PHP $DocumentType = DocumentType::model()->findAll('active = 1 and lang_id ='.$langId) ?>
                        <div role="tabpanel" class="tab-pane fade in active" id="doc-1">
                            <div class="well">
                                <div class="panel panel-default">
                                    <?php foreach ($DocumentType as $doctype) { ?>
                                        <div class="panel-heading">
                                            <h2 class="panel-title"><li><i class="fa fa-file">&nbsp;&nbsp;</i><?=$doctype->dty_name ?></li></h2> 
                                    </div>
                                    <?php foreach ($Document as $doc) { 
                                         if ($doctype->dty_id == $doc->dty_id) { //3?>
                                    
                                        <div class="doc-list">
                                            <span class="pull-right"><span class="text-date"><i class="fa fa-calendar"></i>&nbsp<?php echo DateThai($doc->dow_createday); ?></span>&nbsp; <!--  
<a href="javascript:void(0)" onclick="Download()">dowloadtest</a>   
                                <a download="<?= Yii::app()->baseUrl.'/admin/uploads/'.$doc->dow_address?>" href="<?= Yii::app()->baseUrl.'/admin/uploads/'.$doc->dow_address?>" >
                                        <img alt="ดาวน์โหลด" src="">
                                </a> -->
                                <a class="btn btn-warning" href="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $doc->dow_address ?>" download="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $doc->dow_address ?>" ><i class="fa fa-download"></i>&nbsp;ดาวน์โหลด</a>
                                            <!--     <a href="#"><i class="fa fa-download"></i> ดาวน์โหลด</a> -->
                                            </span>
                   
                                           <a href="<?= $this->createUrl('site/displayDocument',array('id'=>$doc->dow_id)); ?> " target="_blank" ><?= $doc->dow_name ?></a>  
                                        </div>
                                        <?php
                                         }
                                    }  
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!--end Doc1-->
                        <!--start Doc2-->
            <div role="tabpanel" class="tab-pane fade" id="doc-2">
                <div class="well">
                    <?php foreach ($Document as $doc) { ?>
                        <div class="doc-list">
                            <span class="pull-right"><span class="text-date"><i class="fa fa-calendar"></i><?php echo DateThai($doc->dow_createday); ?></span>&nbsp;
                                     <a href="<?= Yii::app()->baseUrl?> /admin/uploads/<?= $doc->dow_address ?>"  download="<?= $doc->dow_address ?>"><i class="fa fa-download"></i>&nbsp;ดาวน์โหลด</a>
                            </span>
                            <?= $doc->dow_name ?>     
                            <a href="<?= $this->createUrl('site/displayDocument',array('id'=>$doc->dow_id)); ?> " target="_blank" ><?= $doc->dow_name ?></a>  
                        </div>
                    <?php   }   ?>
                </div>
            </div>

                        <?php // var_dump($Document)  ?>


                        <!--end Doc2-->
                   <!--  </div> -->
                </div>
            </div>
        </section>	

<iframe id="my_iframe" style="display:none;"></iframe>
<script>
function Download() {
    var url = '/lms_plm/admin/uploads/58832_300x300.jpg';
    document.getElementById('my_iframe').src = url;
};
</script>