<?php
$strExcelFileName = "Export-Report_Training_Course-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");

if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){
        $search = $_GET['Report'];
        
        $criteria = New CDbCriteria;
        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null) {
            $criteria->compare('t.course_id', $_GET['Report']['course_id']);
        }

        if(isset($_GET['Report']['gen_id']) && $_GET['Report']['gen_id'] != null) {
            $criteria->compare('t.gen_id', $_GET['Report']['gen_id']);
        }
        $course_online = CourseOnline::model()->findByPk($search['course_id']);

        $user_Learn = LogStartcourse::model()->findAll($criteria);


}
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
            <h4 class="heading glyphicons show_thumbnails_with_lines">รายงานการฝึกอบรมหลักสูตร <?= $course_online->course_title ?></h4>
        </div>
    </div>
    <div class="widget-body" style=" overflow-x: scroll;">
        <table class="table table-bordered table-striped" border='1'>
            <thead>
              <tr>
                <th  style="vertical-align: middle;" class="center"><b>No.</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Minor course type</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Subminor course type</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Course Name</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Gen</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Group</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Employee</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Name</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Organization unit</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Abbreviate code</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Employee class</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Position desc.</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Learning Status</b></th>
                <th  style="vertical-align: middle;" class="center"><b>Completed Date</b></th>
            </tr>
                    </thead>
                    <tbody>
                        <?php $no =1; 
                    foreach ($user_Learn as $keyL => $valueL) {
                        // if(isset($search['gen_id']) && $search['gen_id'] !=''){
                        //     if($search['gen_id'] != $valueL->course->getGenID($valueL->course_id)){ continue; }
                        // }
                        $status_course_gen = Helpers::lib()->StatusCourseGen($valueL->course_id, $valueL->course->getGenID($valueL->course_id),$valueL->user_id);

                        if ($status_course_gen == "notLearn") {
                            $lessonStatusStr = 'Not start';
                        } else if ($status_course_gen == "learning") {
                            $lessonStatusStr = 'On process';
                        } else if ($status_course_gen == "pass") {
                            $lessonStatusStr =  'Completed';
                        }

                        $passcourse = Passcours::model()->find(array( 
                            'condition' => 'gen_id=:gen_id AND passcours_cours=:course_id AND passcours_user=:user_id',
                            'params' => array(':gen_id'=>$valueL->course->getGenID($valueL->course_id), ':course_id'=>$valueL->course_id, ':user_id'=>$valueL->user_id),
                        ));
                     ?>
                        <tr>
                            <td class="center"><?= $no++ ?></td>
                            <td class="center"><?= isset($valueL->course->cates->type->type_name)? $valueL->course->cates->type->type_name :"" ?></td>
                            <td class="center"><?= $valueL->course->course_number ?></td>
                            <td><?= $valueL->course->course_title ?></td>
                            <td class="center"><?= isset($valueL->gen->gen_title) ? $valueL->gen->gen_title : '-' ?></td>
                            <td class="center"><?= $valueL->pro->group_name ?></td>
                            <td class="center"><?= $valueL->mem->employee_id ?></td>
                            <td class="center"><?= $valueL->pro->fullname ?></td>
                            <td class="center"><?= $valueL->pro->organization_unit ?></td>
                            <td class="center"><?= $valueL->mem->orgchart->title ?></td>
                            <td class="center"><?= $valueL->pro->EmpClass->title ?></td>
                            <td class="center"><?= $valueL->pro->position_description ?></td>
                            <td class="center"><?= $lessonStatusStr ?></td>
                            <td class="center"><?= isset($passcourse)? $passcourse->passcours_date :'' ?></td>
                        </tr>
                    <?php 

                } ?>
                    </tbody>
                </table>
                
            </div>
        </div>

