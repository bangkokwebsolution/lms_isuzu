<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $No = 'No.';
    $Docname ='Document Name';
    $An_name = 'Announced Date';
    $last_DOc = 'Latest Document';
    $search_type = 'Type a search term';
} else {
    $langId = Yii::app()->session['lang'];
    $No = 'ลำดับ';
    $Docname ='ชื่อเอกสาร';
    $An_name = 'วันที่ประกาศ';
    $last_DOc = 'เอกสารล่าสุด';
    $search_type = 'พิมพ์คำค้นหา';
}
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    //$strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_docs  ?></li>
        </ol>
    </nav>
</div>


<section class="content" id="document">
    <div class="container">

        <div class="row justify-content-between align-items-end mb-3">
            <div class="col-7 col-md-8 col-lg-9">
                <h4 class="topic mb-0"> <?= $last_DOc ?></h4>
            </div>
            <div class="col-5 col-md-4 col-lg-3">
                <input class="form-control text-3" type="text" style="width: 100%;" placeholder="<?= $search_type ?>">
            </div>
        </div>

        <div class="tab-content mt-20">

            <?php $DocumentType = DocumentType::model()->findAll('active = 1 and lang_id =' . $langId) ?>
            <div role="tabpanel" class="tab-pane fade in active" id="doc-1">
                <div class="well">
                    <div class="panel panel-default">
                        <?php foreach ($DocumentType as $key => $doctype) { ?>
                            <div class="panel-heading">
                                <a role="button" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                    <h2 class="panel-title">
                                        <li><i class="fa fa-file">&nbsp;&nbsp;</i><?= $doctype->dty_name ?></li>
                                    </h2>
                                </a>
                            </div>
                            <div id="collapse<?= $key ?>">

                                <?php foreach ($Document as $doc) {
                                    if ($doctype->dty_id == $doc->dty_id) { //3
                                ?>
                                        <table class="table table-condensed table-document ">
                                            <thead>
                                                <tr>
                                                    <td width="10%"><?= $No ?></td>
                                                    <td class="text-left"><?= $Docname ?></td>
                                                    <td width="20%"><?= $An_name ?></td>
                                                    <td width="15%"></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-left"><?= $doc->dow_name ?></td>
                                                    <td><?php 
                                                    if($langId==1){
                                                        echo Helpers::changeFormatDateEN($doc->dow_createday);
                                                    }else{
                                                        echo Helpers::changeFormatDate($doc->dow_createday);
                                                    }   ?>
                                                    <td>
                                                        <a class="btn btn-download text-white" href="<?= Yii::app()->baseUrl ?>/admin/uploads/<?= $doc->dow_address ?>" download="<?= Yii::app()->baseUrl ?>/admin/uploads/<?= $doc->dow_address ?>" type="button">Download</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

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