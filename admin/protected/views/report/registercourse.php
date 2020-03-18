
<?php
$formNameModel  = 'contactus';
$titleName      = 'รายงานการสมัครเข้าเรียน';

$this->breadcrumbs=array(
    $titleName => array('report/AttendPrint'),
    $lesson->title
);
?>

<div class="innerLR">

    <!-- <div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
        <div class="widget-head">
            <h4 class="heading  glyphicons search"><i></i>ค้นหาขั้นสูง</h4>
        </div>
        <div class="widget-body collapse" style="height: 0px;">
            <div class="search-form">
                <?php //$this->renderPartial('_search',array(
                    //'model'=>$model,
                //)); ?>
            </div>
        </div>
    </div> -->
    <div class="widget" style="margin-top: -1px;" id="export-table">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
        </div>
        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
            <table class="table table-bordered toggleairasia-table">
                <!-- Table heading -->
                <thead>
                    <tr style="background-color: #e476e8;">
                        <th  style="vertical-align: middle;" class="center"><b>No.</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>รหัสพนักงาน</b></th> 
                        <th  style="vertical-align: middle;" class="center"><b>ชื่อ - นามสกุล</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>อีเมลล์</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่เริ่มเรียน</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่เรียนล่าสุด</b></th>
                    </tr>
                </thead>
                <tbody>

                <!-- // Table heading END -->
                  <?php 
                if($model){
                 foreach($model as $key => $value) { ?>
                    <tr>
                        <td ><center><?= ($key+1) ?></center></td>
                        <td ><?= $value->users->employee_id; ?></td>
                        <td ><?= $value->User->Fullname; ?></td>
                        <td ><?= $value->users->email; ?></td>
                        <td ><center><?= Helpers::lib()->changeFormatDate($value->create_date,'datetime'); ?></center></td>
                        <td ><center><?= Helpers::lib()->changeFormatDate($value->learn_date,'datetime'); ?></center></td>
                    </tr>
                <?php }
                } else {
                ?>
                <tr>
                    <td  colspan="3">ไม่พบข้อมูล</td>
                </tr>
                <?php } ?>
                <!-- Table body -->
                </tbody>
            </table>
    </div>
</div>
      <div class="widget-body">
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
                <a href="<?= $this->createUrl('report/genpdfregistercourse',array('id'=>$_GET['id'],
            'schedule_id'=>$_GET['schedule_id'])); ?>" 
            target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a>

        </div>

<script type="text/javascript">
    $(function() {
        $('#btnExport').click(function(e) {
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2><?= $title ?></h2>'+$('#export-table').html()));
            e.preventDefault();
        });
      $('.div-table a').attr('href','#');
    });

    </script>

