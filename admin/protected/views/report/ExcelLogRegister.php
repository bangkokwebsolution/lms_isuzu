<?php

$strExcelFileName = "Export-Data-" . date('Ymd-His') . ".xls";
header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
header('Content-Type: text/plain; charset=UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Pragma:no-cache");
if (!empty($_GET)) {
    $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id";
    $sqlUser .= " AND tbl_users.superuser = 0";
    if ($model->employee_type != '') {
        $sqlUser .= " AND tbl_profiles.type_employee=" . $model->employee_type;
    }
    if ($model->department != '') {
        $department = Department::model()->findByPk($model->department);
        $sqlUser .= " AND tbl_users.department_id=" . $model->department;
    }
    if ($model->position_id != '') {
        $sqlUser .= " AND tbl_users.position_id=" . $model->position_id;
    }
    if ($model->nameSearch != '') {
        $search = explode(" ", $model->nameSearch);
        foreach ($search as $key => $searchText) {
            $sqlUser .= " AND (tbl_profiles.firstname_en LIKE '%" . trim($searchText) . "%' OR tbl_profiles.firstname LIKE '%" . trim($searchText) . "%' OR tbl_profiles.lastname_en LIKE '%" . trim($searchText) . "%' OR tbl_profiles.lastname LIKE '%" . trim($searchText) . "%')";
        }
    }
    if ($model->register_status != '') {
        $sqlUser .= " AND tbl_users.register_status=" . $model->register_status;
    }
    if (($model->date_start != '') && ($model->date_end != '')) {
        $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
        $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
        if ($startDate == $endDate) {
            $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
        }
        $sqlUser .= " AND tbl_users.create_at between '" . $startDate . "' and '" . $endDate . "' ";
    }
    $sqlUser .= " order by tbl_profiles.type_employee asc, firstname_en asc, firstname asc";
    $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();
    $dataProvider = new CArrayDataProvider($modelAll);
    $model = $dataProvider->getData();
}
?>

<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>
<!-- END HIGH SEARCH -->
<div class="widget" id="export-table">
    <div class="widget-head">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายงานการสมัครสมาชิก</h4>
        </div>
    </div>
    <div class="widget-body" style=" overflow-x: scroll;">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ประเภทพนักงาน</th>
                    <th>Name - Surname</th>
                    <th>ชื่อ - นามสกุล</th>
                    <th>เลขที่บัตรประชาชน</th>
                    <th>เลขพาสปอร์ต</th>
                    <th>รหัสพนักงานออฟฟิศ</th>
                    <th>แผนก/ฝ่าย</th>
                    <th>ตำแหน่ง</th>
                    <th>วันเดือนปีเกิด</th>
                    <th>อายุ</th>
                    <th>ระดับการศึกษา</th>
                    <th>สถาบันที่จบล่าสุด</th>
                    <th>เบอร์โทร</th>
                    <th>Email</th>
                    <th>สถานะการสมัคร</th>
                    <th>วันที่สมัคร</th>
                    <th>ชื่อผู้ตรวจสอบใบสมัคร</th>
                    <th>วันที่อนุมัติ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($modelAll as $value) { 
                    $profiles = Profiles::model()->findByPk($value['id']);
                    if ($profiles->type_employee == 1){
                        $type_emp = "พนักงานประจำเรือ";
                    }else if ($profiles->type_employee == 2){
                        $type_emp = "พนักงานออฟฟิศ";
                    }
                    $depart = Department::model()->findByPk($value['department_id']);
                    $dep_title =  $depart['dep_title'];
                    $position = Position::model()->findByPk($value['position_id']);
                    $pos_title = $position['position_title'];
                    $birthday = date_format(date_create($profiles['birthday']),"d/m/Y");
                    $edu = ProfilesEdu::model()->find(array('condition' => 'user_id=' . $value['id']));
                    $mt_edu = Education::model()->findByPk($edu->edu_id);
                    $mt_edu_title = $mt_edu->edu_name;
                    $edu = ProfilesEdu::model()->find(array('condition' => 'user_id=' . $value['id']));
                    $edu_title = $edu->institution;
                    if ($value['register_status'] == 1){
                        $status = 'Approved';
                    }else{
                        $status = 'Disapproved';
                    }
                    $regis_date =  LogRegister::model()->find(array('condition' => 'user_id=' . $value['id']. ' and active="y"'));
                    $regis_date = Helpers::changeFormatDate($regis_date->register_date,'datetime');
                    $regis = LogRegister::model()->find(array('condition' => 'user_id=' . $value['id']. ' and active="y"'));
                    $user_approv = Profile::model()->findByPk($regis->confirm_user);
                    $name_approve = $user_approv->firstname . ' ' . $user_approv->lastname;
                    $regis_date_approve = LogRegister::model()->find(array('condition' => 'user_id=' . $value['id']. ' and active="y"'));
                    $register_date_approve = Helpers::changeFormatDate($regis_date_approve->confirm_date,'datetime');
                    ?>
                    <?php if ($type_emp != "") { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $type_emp ?></td>                  
                            <td><?= $profiles->firstname_en . " " . $profiles->lastname_en ?></td>                  
                            <td><?= $profiles->firstname . " " . $profiles->lastname ?></td>                  
                            <td><?= $profiles->identification ?></td>                  
                            <td><?= ($profiles->type_employee == 1) ? $profiles->passport : '-' ?></td>             
                            <td><?= ($profiles->type_employee == 2) ? $value['username'] : '-' ?></td>   
                            <td><?= $dep_title ?></td>                            
                            <td><?= $pos_title ?></td>                          
                            <td><?= $birthday ?></td>                          
                            <td><?= $value['age'] ?></td>                          
                            <td><?= $mt_edu_title ?></td>                          
                            <td><?= $edu_title ?></td>                          
                            <td><?= $value['phone'] ?></td>                          
                            <td><?= $value['email'] ?></td>                          
                            <td><?= $status ?></td>                          
                            <td><?= ($profiles->type_employee == 1) ? $regis_date : '-' ?></td>                          
                            <td><?= ($profiles->type_employee == 1) ? $name_approve : '-' ?></td>                          
                            <td><?= ($profiles->type_employee == 1) ? $register_date_approve : '-' ?></td>                          
                        </tr>
                <?php $i ++; }} ?>
            </tbody>
        </table>
    </div>
</div>