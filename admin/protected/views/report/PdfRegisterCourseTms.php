
<?php
$titleName      = 'รายงานการสมัครเข้าเรียน';
?>

<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
        </div>
        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
            <table class="table table-bordered toggleairasia-table" style="width: 100%">
                <!-- Table heading -->
                <thead>
                    <tr style="background-color: #e476e8;">
                        <th style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>No.</b></th>
                        <th style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>รหัสพนักงาน</b></th> 
                        <th style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>ชื่อ - นามสกุล</b></th>
                        <th style="vertical-align: middle; border: 0.2px solid #000;" class="center"><b>อีเมลล์</b></th>
                    </tr>
                </thead>
                <!-- // Table heading END -->
                  <?php 
                if($model){
                 foreach($model as $key => $value) { ?>
                    <tr>
                        <td style="border: 0.2px solid #000;"><center><?= ($key+1) ?></center></td>
                        <td style="border: 0.2px solid #000;"><?= $value->user->employee_id; ?></td>
                        <td style="border: 0.2px solid #000;"><?= $value->user->profile->Fullname; ?></td>
                        <td style="border: 0.2px solid #000;"><?= $value->user->email; ?></td>
                    </tr>
                <?php }
                } else {
                ?>
                <tr>
                    <td style="border: 0.2px solid #000;" colspan="3">ไม่พบข้อมูล</td>
                </tr>
                <?php } ?>
                <!-- Table body -->
                <tbody>
                </tbody>
            </table>
    </div>
</div>
