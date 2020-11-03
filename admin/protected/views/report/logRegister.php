<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$titleName = 'รายงานการสมัครสมาชิก';
$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');
    $('#Report_dateRang').daterangepicker();
EOD
, CClientScript::POS_READY);
?>

<script>
    $(document).ready(function(){
        $("#ReportUser_date_start").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
              $("#ReportUser_date_end").datepicker("option","minDate", selected)
            }
        });
        $("#ReportUser_date_end").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
               $("#ReportUser_date_start").datepicker("option","maxDate", selected)
            }
        }); 
});
</script>

<div class="innerLR">

    <?php
        $depmodel = Department::model()->findAll('active = "y" AND lang_id = 1');
        $depList = CHtml::listData($depmodel,'id','dep_title');
        $status = array(
            '1'=>'Approved',
            '0'=>'Disapproved'
        );

        $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'employee_type','type'=>'list','query'=>$model->getTypeEmployeeList()),
            array('name'=>'register_status','type'=>'list','query'=>$status),
            array('name'=>'nameSearch','type'=>'text'),
         //   array('name'=>'division_id','type'=>'list','query'=> $model->getDivisionList()),
            array('name'=>'department','type'=>'list','query'=> $depList),
            array('name'=>'position_id','type'=>'list','query'=> Position::getPositionList()),
            array('name'=>'date_start','type'=>'text'),
            array('name'=>'date_end','type'=>'text'),
        ),
    ));?>
    <?php
    if(!empty($_GET)){
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id";
        $sqlUser .= " AND tbl_users.superuser = 0";
        if ($model->employee_type != ''){
            $sqlUser .= " AND tbl_profiles.type_employee=" . $model->employee_type;
        }
        if ($model->department != ''){
            $department = Department::model()->findByPk($model->department);
            $sqlUser .= " AND tbl_users.department_id=" . $model->department;
        }
        if ($model->position_id != ''){
            $sqlUser .= " AND tbl_users.position_id=" . $model->position_id;
        }
        if($model->nameSearch !='') {
            $search = explode(" ",$model->nameSearch);
            foreach ($search as $key => $searchText) {
                $sqlUser .= " AND (tbl_profiles.firstname_en LIKE '%". trim($searchText) ."%' OR tbl_profiles.firstname LIKE '%" . trim($searchText) . "%' OR tbl_profiles.lastname_en LIKE '%" . trim($searchText) . "%' OR tbl_profiles.lastname LIKE '%" . trim($searchText) . "%')";
            }
        }
        if ($model->register_status != ''){
            $sqlUser .= " AND tbl_users.register_status=" . $model->register_status;
        }
        if(($model->date_start != '') && ($model->date_end != '')){
            $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
            $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
            if($startDate == $endDate){
                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
            }
            $sqlUser .= " AND tbl_users.create_at between '".$startDate."' and '".$endDate."' ";
        }
        $sqlUser .= " order by firstname_en asc";
        $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();
        $dataProvider = new CArrayDataProvider($modelAll);
        $model = $dataProvider->getData();
        if (!empty($model)){
            ?>
            <div class="widget" style="margin-top: 10px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"> <i></i> รายงานการสมัครสมาชิก <?php echo ($_GET['ReportUser']['date_start'] != "") ? 'ข้อมูลตั้งแต่วันที่ ' . date_format(date_create($_GET['ReportUser']['date_start']), 'd/m/Y') . ' - ' . date_format(date_create($_GET['ReportUser']['date_end']), 'd/m/Y') : ''; ?></h4>
                </div>
                    <div class="widget-body" style=" overflow-x: scroll;">
                        <div class="clear-div"></div>
                        <div class="overflow-table">
                        <?php 
                        if ($_GET['ReportUser']['employee_type'] == 2) { 
                            $this->widget('AGridView', array(
                                'id' => $formNameodel.'-grid',
                                'dataProvider'=> $dataProvider,
                                'columns' => array(
                                    array(
                                        'header' => 'ลำดับ',
                                        'type' => 'raw',
                                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                        'htmlOptions' => array('width' => '1%')
                                    ),
                                    array(
                                        'header' => 'ประเภทพนักงาน',
                                        'name' => 'type_employee',
                                        'value' => function ($data){
                                            $type_emp = TypeEmployee::model()->findByPk($data['type_employee']);
                                            return $type_emp->type_employee_name;
                                        },
                                        'filterHtmlOptions'=>array('style'=>'width:30px'),
                                    ),
                                    array(
                                        'header' => 'Name-Surname',
                                        'name' => 'nameSearch',
                                        'value' => function ($data){
                                            return $data['firstname_en'] . ' ' . $data['lastname_en'];
                                        }
                                    ),
                                    array(
                                        'header' => 'ชื่อ-นามสกุล',
                                        'name' => 'nameSearch',
                                        'value' => function ($data){
                                            return $data['firstname'] . ' ' . $data['lastname'];
                                        }
                                    ),
                                    array('header' => 'เลขที่บัตรประชาชน', 'name' => 'identification'),
                                   // array('header' => 'เลขพาสปอร์ต', 'name' => 'passport'),
                                    array('header' => 'รหัสพนักงานออฟฟิศ', 'name' => 'username', 'value' => function($data){
                                        if ($data['type_employee'] == 2){
                                            return $data['username'];
                                        }
                                    }),
                                    array(
                                        'header' => 'แผนก', 
                                        'name' => 'department',
                                        'value' => function($data){
                                            $depart = Department::model()->findByPk($data['department_id']);
                                            return $depart['dep_title'];
                                        }
                                    ),
                                    array(
                                        'header' => 'ตำแหน่ง', 
                                        'name' => 'position_id',
                                        'value' => function($data){
                                            $depart = Position::model()->findByPk($data['position_id']);
                                            return $depart['position_title'];
                                        }
                                    ),
                                    array(
                                        'header' => 'ฝ่าย', 
                                        'name' => 'division_id',
                                        'value' => function($data){
                                            if ($data['type_employee'] == 2){
                                                $divisionAll = Department::model()->findByPk($data['department_id']);
                                                return $divisionAll['dep_title'];
                                            }
                                        }
                                    ),
                                    array('header' => 'วันเดือนปีเกิด', 'name' => 'birthday'),
                                    array('header' => 'อายุ', 'name' => 'age'),
                                    array('header' => 'ระดับการศึกษา', 'value' => function($data){
                                        $edu = ProfilesEdu::model()->find(array('condition' => 'user_id=' . $data['user_id']));
                                        $mt_edu = Education::model()->findByPk($edu->edu_id);
                                        return $mt_edu->edu_name;
                                    }),
                                    array('header' => 'สถาบันที่จบล่าสุด', 'value' => function($data){
                                        $edu = ProfilesEdu::model()->find(array('condition' => 'user_id=' . $data['user_id']));
                                        return $edu->institution;
                                    }),
                                    array('header' => 'เบอร์โทร', 'name' => 'phone'),
                                    array('header' => 'Email', 'name' => 'email'),
                                    array('header' => 'สถานะการสมัคร', 'name' => 'register_status', 'value' => function($data){
                                        if ($data['register_status'] == 1){
                                            return 'Approved';
                                        }else{
                                            return 'Disapproved';
                                        }
                                    }),
                                    array('header' => 'วันที่สมัคร', 'value' => function($data){
                                        $regis_date =  LogRegister::model()->find(array('condition' => 'user_id=' . $data['user_id']. ' and active="y"'));
                                        return $regis_date->register_date;
                                    }),
                                    array('header' => 'ชื่อผู้ตรวจสอบใบสมัคร', 'value' => function($data){
                                        $regis = LogRegister::model()->find(array('condition' => 'user_id=' . $data['user_id']. ' and active="y"'));
                                        $user_approv = Profile::model()->findByPk($regis->confirm_user);
                                        return $user_approv->firstname . ' ' . $user_approv->lastname;
                                    }),
                                    array('header' => 'วันที่อนุมัติ', 'value' => function($data){
                                        $regis_date = LogRegister::model()->find(array('condition' => 'user_id=' . $data['user_id']. ' and active="y"'));
                                        return $regis_date->confirm_date;
                                    }),
                                ),
                            ));
                        }else{
                            $this->widget('AGridView', array(
                                'id' => $formNameodel.'-grid',
                                'dataProvider'=> $dataProvider,
                                'columns' => array(
                                    array(
                                        'header' => 'ลำดับ',
                                        'type' => 'raw',
                                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                        'htmlOptions' => array('width' => '1%')
                                    ),
                                    array(
                                        'header' => 'ประเภทพนักงาน',
                                        'name' => 'type_employee',
                                        'value' => function ($data){
                                            $type_emp = TypeEmployee::model()->findByPk($data['type_employee']);
                                            return $type_emp->type_employee_name;
                                        },
                                        'filterHtmlOptions'=>array('style'=>'width:30px'),
                                    ),
                                    array(
                                        'header' => 'Name-Surname',
                                        'name' => 'nameSearch',
                                        'value' => function ($data){
                                            return $data['firstname_en'] . ' ' . $data['lastname_en'];
                                        }
                                    ),
                                    array(
                                        'header' => 'ชื่อ-นามสกุล',
                                        'name' => 'nameSearch',
                                        'value' => function ($data){
                                            return $data['firstname'] . ' ' . $data['lastname'];
                                        }
                                    ),
                                    array('header' => 'เลขที่บัตรประชาชน', 'name' => 'identification'),
                                    array('header' => 'เลขพาสปอร์ต', 'name' => 'passport'),
                                    array(
                                        'header' => 'แผนก', 
                                        'name' => 'department',
                                        'value' => function($data){
                                            $depart = Department::model()->findByPk($data['department_id']);
                                            return $depart['dep_title'];
                                        }
                                    ),
                                    array(
                                        'header' => 'ตำแหน่ง', 
                                        'name' => 'position_id',
                                        'value' => function($data){
                                            $depart = Position::model()->findByPk($data['position_id']);
                                            return $depart['position_title'];
                                        }
                                    ),
                                    array('header' => 'วันเดือนปีเกิด', 'name' => 'birthday'),
                                    array('header' => 'อายุ', 'name' => 'age'),
                                    array('header' => 'ระดับการศึกษา', 'value' => function($data){
                                        $edu = ProfilesEdu::model()->find(array('condition' => 'user_id=' . $data['user_id']));
                                        $mt_edu = Education::model()->findByPk($edu->edu_id);
                                        return $mt_edu->edu_name;
                                    }),
                                    array('header' => 'สถาบันที่จบล่าสุด', 'value' => function($data){
                                        $edu = ProfilesEdu::model()->find(array('condition' => 'user_id=' . $data['user_id']));
                                        return $edu->institution;
                                    }),
                                    array('header' => 'เบอร์โทร', 'name' => 'phone'),
                                    array('header' => 'Email', 'name' => 'email'),
                                    array('header' => 'สถานะการสมัคร', 'name' => 'register_status', 'value' => function($data){
                                        if ($data['register_status'] == 1){
                                            return 'Approved';
                                        }else{
                                            return 'Disapproved';
                                        }
                                    }),
                                    array('header' => 'วันที่สมัคร', 'value' => function($data){
                                        $regis_date =  LogRegister::model()->find(array('condition' => 'user_id=' . $data['user_id']. ' and active="y"'));
                                        return $regis_date->register_date;
                                    }),
                                    array('header' => 'ชื่อผู้ตรวจสอบใบสมัคร', 'value' => function($data){
                                        $regis = LogRegister::model()->find(array('condition' => 'user_id=' . $data['user_id']. ' and active="y"'));
                                        $user_approv = Profile::model()->findByPk($regis->confirm_user);
                                        return $user_approv->firstname . ' ' . $user_approv->lastname;
                                    }),
                                    array('header' => 'วันที่อนุมัติ', 'value' => function($data){
                                        $regis_date = LogRegister::model()->find(array('condition' => 'user_id=' . $data['user_id']. ' and active="y"'));
                                        return $regis_date->confirm_date;
                                    }),
                                ),
                            ));
                        }
                        ?>
                    </div>
                    <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
                </div>
            <?php 
        }else{ ?>
            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                </div>
                <div class="widget-body">
                    <!-- Table -->
                    <h3 style="color: red;">ไม่พบข้อมูล</h3>
                    <!-- // Table END -->
                </div>
            </div>
        <?php }
    }else{ ?>
     <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> </h4>
        </div>
        <div class="widget-body">
            <!-- Table -->
            <h3 class="text-success">กรุณาป้อนข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3>
            <!-- // Table END -->
        </div>
    </div>
    <?php } ?>
</div>

<script>
    var select = document.getElementById("ReportUser_employee_type");
    for(var i = 0, l = select.options.length; i < l; i++) {
        var option = select.options[i];
        if(option.innerHTML == "ทั้งหมด") {
            option.innerHTML = "กรุณาเลือกประเภท";
        }
    }

    var select = document.getElementById("ReportUser_department");
    for(var i = 0, l = select.options.length; i < l; i++) {
        var option = select.options[i];
        if(option.innerHTML == "ทั้งหมด") {
            option.innerHTML = "กรุณาเลือกแผนก";
        }
    }

    var select = document.getElementById("ReportUser_position_id");
    for(var i = 0, l = select.options.length; i < l; i++) {
        var option = select.options[i];
        if(option.innerHTML == "ทั้งหมด") {
            option.innerHTML = "กรุณาเลือกตำแหน่ง";
        }
    }

    function Get1(){
        $.post("<?=$this->createUrl('report/GetDataLogRegister');?>", {
            type: document.getElementById("ReportUser_employee_type").value,
            department: 1,
        },
        function(data) {
            if (data != ""){
                document.getElementById('ReportUser_department').innerHTML = data;
            }
        });
    }

    function Get2(){
        $.post("<?=$this->createUrl('report/GetDataLogRegister');?>", {
            type: document.getElementById("ReportUser_department").value,
            position: document.getElementById("ReportUser_department").value,
        },
        function(data) {
            if (data != ""){
                document.getElementById('ReportUser_position_id').innerHTML = data;
            }
        });
    }

    document.getElementById("ReportUser_employee_type").onchange = function() {
        Get1();
    };

    document.getElementById("ReportUser_department").onchange = function() {
        Get2();
    };

</script>