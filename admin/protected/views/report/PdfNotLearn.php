<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <!-- <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4> -->
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>
            Training Completion Report / Electronic Sign-in Sheet <br>
            รายงานผู้ผ่านการเรียน Training Course / หลักสูตร : <?php echo $title;?></h4>
        </div>
        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
            <table class="table table-bordered toggleairasia-table" style="width: 100%">
                <!-- Table heading -->
                <thead>
                    <tr style="background-color: #e476e8;">
                        <th style="vertical-align: middle;  border: 0.2px solid #000;" class="center"><b>No.</b></th>
                        <th style="vertical-align: middle;  border: 0.2px solid #000;" class="center"><b>Staff ID</b></th> 
                        <th style="vertical-align: middle;  border: 0.2px solid #000;" class="center"><b>Name - Surname</b></th>
                        <th style="vertical-align: middle;  border: 0.2px solid #000;" class="center"><b>E-mail</b></th>

                        <?php if($_GET['type'] ==  "pass"){ ?>
                        <th style="vertical-align: middle;  border: 0.2px solid #000;" class="center"><b>Complete Training Date</b></th>
                        <th style="vertical-align: middle;  border: 0.2px solid #000;" class="center"><b>Training Department signature</b></th>    
                        <?php } ?>


                    </tr>

                    <tr style="background-color: #e476e8;">
                        <td style="vertical-align: middle; text-align: center; border: 0.2px solid #000;" class="center"><b>ลำดับที่</b></td>
                        <td style="vertical-align: middle; text-align: center; border: 0.2px solid #000;" class="center"><b>รหัสพนักงาน</b></td> 
                        <td style="vertical-align: middle; text-align: center; border: 0.2px solid #000;" class="center"><b>ชื่อ - นามสกุล</b></td>
                        <td style="vertical-align: middle; text-align: center; border: 0.2px solid #000;" class="center"><b>อีเมลล์</b></td>
                        <?php if($_GET['type'] ==  "pass"){ ?>
                        <td style="vertical-align: middle; text-align: center; border: 0.2px solid #000;" class="center"><b>วันที่ผ่านการอบรม</b></td>
                        <td style="vertical-align: middle; text-align: center; border: 0.2px solid #000;" class="center"><b>ลายเซ็นผู้ตรวจสอบข้อมูล</b></td>    
                        <?php } ?>
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

                        <?php if($_GET['type'] ==  "pass"){ 

                            $course = Coursescore::model()->find(array(
                            'order' => 'update_date DESC',
                            'condition'=>'user_id=:user_id AND score_past=:score_past AND active =:active',
                            'params' => array(':user_id' => $value->user_id , ':score_past' => 'y', ':active' => 'y')
                        )); ?>

                         <td style="border: 0.2px solid #000;"><center><?php echo Helpers::lib()->changeFormatDate($course->update_date,'datetime'); ?>
                        <td style="border: 0.2px solid #000;"></td>

                        <?php } ?>


                    </tr>
                <?php }
                } else {
                ?>
                <tr>
                    <td style="border: 0.2px solid #000;" colspan="4">ไม่พบข้อมูล</td>
                </tr>
                <?php } ?>
                <!-- Table body -->
                <tbody>
                </tbody>
            </table>
    </div>
</div>
