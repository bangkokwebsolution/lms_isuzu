
<?php
$formNameModel  = 'contactus';
$titleName      = 'รายงานผู้ใช้งานที่กำลังเรียน';
?>

<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>
    <div class="widget" style="margin-top: -1px;" id="export-table">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
        </div>
        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
            <table class="table table-bordered toggleairasia-table" style="width: 100%">
                <!-- Table heading -->
                <thead>
                    <tr style="background-color: #e476e8;">
                        <th  style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>No.</b></th>
                        <th  style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>รหัสพนักงาน</b></th>
                        <th  style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>ชื่อ - นามสกุล</b></th>
                        <th  style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>อีเมลล์</b></th>
                        <th  style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>วันที่เริ่มเรียน</b></th>
                        <th  style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>วันที่เรียนล่าสุด</b></th>
                    </tr>
                </thead>
                <!-- // Table heading END -->
                 <?php 
                if($model){
                 foreach($model as $key => $value) { ?>
                    <tr>
                        <td style="border: 0.2px solid #000;"><center><?= ($key+1) ?></center></td>
                        <td style="border: 0.2px solid #000;"><?= $value->users->employee_id; ?></td>
                        <td style="border: 0.2px solid #000;"><?= $value->User->Fullname; ?></td>
                        <td style="border: 0.2px solid #000;"><?= $value->users->email; ?></td>
                        <td style="border: 0.2px solid #000;"><center><?= Helpers::lib()->changeFormatDate($value->create_date,'datetime'); ?></center></td>
                        <td style="border: 0.2px solid #000;"><center><?= Helpers::lib()->changeFormatDate($value->learn_date,'datetime'); ?></center></td>
                    </tr>
                <?php }
                } else {
                ?>
                <tr>
                    <td style="border: 0.2px solid #000;" colspan="6">ไม่พบข้อมูล</td>
                </tr>
                <?php } ?>
                <!-- Table body -->
                <tbody>
                </tbody>
            </table>
    </div>
</div>


