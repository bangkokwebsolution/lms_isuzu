<?php
$strExcelFileName = "Export-ReportProblem-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");


    ?>
    <style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>
	<!-- END HIGH SEARCH -->
        <div class="widget hidden" id="export-table">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">รายงานปัญหาการใช้งาน</h4>
                </div>
            </div>
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped" border='1'>
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ - สกุล</th>                            
                            <th>อีเมล์</th>
                            <th>ประเภทปัญหา</th>
                            <th>ประเภทคอร์ส</th>
                            <th>ข้อความ</th>
                            <th>วันที่ส่งปัญหา</th>
                            <th>เบอร์โทรศัพท์</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $dataProvider=new CArrayDataProvider($model, array(
                                'pagination'=>array(
                                'pageSize'=>25
                                ),
                        ));

                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }
                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $Problem) {

                                    ?>
                                    <tr>
                                        <td style="vertical-align: top;" ><?= $start_cnt+1?></td>
                                        <td style="vertical-align: top;"><?= $Problem->firstname.' '.$Problem->lastname ?></td>
                                        <td style="vertical-align: top;"><?= $Problem->email ?></td>
                                        <td style="vertical-align: top;"><?= $Problem->usa->usa_title ?></td>
                                        <td style="vertical-align: top;"><?= $Problem->course->course_title ?></td>
                                        <td style="vertical-align: top;"><?= UHtml::markSearch($Problem,"report_detail") ?></td>
                                        <td style="vertical-align: top;"><?= Helpers::changeFormatDate($Problem->report_date,'datetime') ?></td>
                                        <td align="left" style="vertical-align: top;"><?= $Problem->tel ?></td>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <strong>ไม่พบข้อมูล</strong>
                                </tr>
                                <?php
                            }

                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>

