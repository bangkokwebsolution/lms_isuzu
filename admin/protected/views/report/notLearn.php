<?php
$formNameModel  = 'contactus';

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
                        <th style="vertical-align: middle;" class="center"><b>No.</b></th>
                        <th style="vertical-align: middle;" class="center"><b>Staff ID</b></th> 
                        <th style="vertical-align: middle;" class="center"><b>Name - Surname</b></th>
                        <th style="vertical-align: middle;" class="center"><b>E-mail</b></th>
                        <?php if($_GET['type'] ==  "pass"){ ?>
                        <th style="vertical-align: middle;" class="center"><b>Complete Training Date</b></th>
                        <th style="vertical-align: middle;" class="center"><b>Training Department signature</b></th>    
                        <?php } ?>


                    </tr>
                </thead>
                <!-- // Table heading END -->
                    <tr style="background-color: #e476e8;">
                        <td style="vertical-align: middle; text-align: center;" class="center"><b>ลำดับที่</b></td>
                        <td style="vertical-align: middle; text-align: center;" class="center"><b>รหัสพนักงาน</b></td> 
                        <td style="vertical-align: middle; text-align: center;" class="center"><b>ชื่อ - นามสกุล</b></td>
                        <td style="vertical-align: middle; text-align: center;" class="center"><b>อีเมลล์</b></td>
                        <?php if($_GET['type'] ==  "pass"){ ?>
                        <td style="vertical-align: middle; text-align: center;" class="center"><b>วันที่ผ่านการอบรม</b></td>
                        <td style="vertical-align: middle; text-align: center;" class="center"><b>ลายเซ็นผู้ตรวจสอบข้อมูล</b></td>    
                        <?php } ?>
                    </tr>
                    <?php 
                if($model){
                 foreach($model as $key => $value) { ?>
                    <tr>
                     
                        <td><center><?= ($key+1) ?></center></td>
                        <td><?= $value->user->employee_id; ?></td>
                        <td><?= $value->user->profile->Fullname; ?></td>
                        <td><?= $value->user->email; ?></td>

                        <?php if($_GET['type'] ==  "pass"){ 

                            $course = Coursescore::model()->find(array(
                            'order' => 'update_date DESC',
                            'condition'=>'user_id=:user_id AND score_past=:score_past AND active =:active',
                            'params' => array(':user_id' => $value->user_id , ':score_past' => 'y', ':active' => 'y')
                        )); ?>

                        <td><center><?php echo Helpers::lib()->changeFormatDate($course->update_date,'datetime'); ?>
                        <td></td>

                        <?php } ?>
                    </tr>
                <?php }
                } else {
                ?>
                <tr>
                    <td colspan="4">ไม่พบข้อมูล</td>
                </tr>
                <?php } ?>
                <!-- Table body -->
                <tbody>
                </tbody>
            </table>
    </div>
</div>
<div class="widget-body">
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
              <?php if($type == 'notLearn') { ?>
            <a href="<?= $this->createUrl('report/genpdfnotlearn',array('id'=>$_GET['id'],
            'schedule_id'=>$_GET['schedule_id'],
            'type'=>$_GET['type'])); ?>" 
            target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a>
       <?php }else{ ?>
             <a href="<?= $this->createUrl('report/genpdftestcoursescore',array('id'=>$_GET['id'],
            'schedule_id'=>$_GET['schedule_id'],
            'type'=>$_GET['type'])); ?>" 
            target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a>

        <?php } ?>
        </div>

<script type="text/javascript">
    $(function() {
        $('#btnExport').click(function(e) {
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent( 'Training Completion Report / Electronic Sign-in Sheet <br>รายงานผู้ผ่านการเรียน Training Course / หลักสูตร : <?= $title ?>'+$('#export-table').html()));
            e.preventDefault();
        });
      $('.div-table a').attr('href','#');
    });

    </script>

