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
$titleName = 'รายงานภาพรวมการสมัครสมาชิก';
$formNameModel = 'Report';

$this->breadcrumbs = array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript(
    'updateGridView',
    <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');
	$('#Report_dateRang').daterangepicker();

EOD
, CClientScript::POS_READY
);
?>

<script>
    $(document).ready(function() {
        $("#ReportUser_date_start").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
                $("#ReportUser_date_end").datepicker("option", "minDate", selected)
            }
        });
        $("#ReportUser_date_end").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
                $("#ReportUser_date_start").datepicker("option", "maxDate", selected)
            }
        });
    });
</script>

<div class="innerLR">

    <?php
    $depmodel = Department::model()->findAll('active = "y" AND lang_id = 1');
    $depList = CHtml::listData($depmodel, 'id', 'dep_title');
    /**  */
    $this->widget('AdvanceSearchForm', array(
        'data' => $model,
        'route' => $this->route,
        'attributes' => array(
            array('name' => 'employee_type', 'type' => 'list', 'query' => $model->getTypeEmployeeList()),
            // array('name' => 'division_id', 'type' => 'list', 'query' => $model->getDivisionList()),
            array('name' => 'department', 'type' => 'list', 'query' => $depList),
            array('name' => 'position_id', 'type' => 'list', 'query' => Position::getPositionList()),
            array('name' => 'date_start', 'type' => 'text'),
            array('name' => 'date_end', 'type' => 'text'),
        ),
    ));
    if (!empty($model->employee_type)) {
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id 
            WHERE del_status = 0 and tbl_users.superuser = 0";

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
        if (($model->date_start != '') && ($model->date_end != '')) {
            $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
            $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
            if ($startDate == $endDate) {
                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
            }
            $sqlUser .= " AND tbl_users.create_at between '" . $startDate . "' and '" . $endDate . "' ";
        }

        $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();
        $dataProvider = new CArrayDataProvider($modelAll);
        $model = $dataProvider->getData();
        if (!empty($model)) {
    ?>
            <div class="widget" style="margin-top: 10px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"> <i></i> รายงานภาพรวมการสมัครสมาชิก <?php echo ($_GET['ReportUser']['date_start'] != "") ? 'ข้อมูลตั้งแต่วันที่ ' . date_format(date_create($_GET['ReportUser']['date_start']), 'd/m/Y') . ' - ' . date_format(date_create($_GET['ReportUser']['date_end']), 'd/m/Y') : ''; ?></h4>
                </div>
                <div class="widget-body" style=" overflow-x: scroll;">
                    <div class="clear-div"></div>
                    <div class="overflow-table">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="center" width="20%" style="vertical-align:middle;">ประเภทพนักงาน</th>
                                    <?php if ($_GET['ReportUser']['employee_type'] == '1') { ?>
                                        <th rowspan="2" class="center" width="25%" style="vertical-align:middle;">แผนก</th>
                                        <th rowspan="2" class="center" width="25%" style="vertical-align:middle;">ตำแหน่ง</th>
                                        <th colspan="3" class="center">จำนวน</th>
                                    <?php } else { ?>
                                        <th rowspan="2" class="center" width="15%" style="vertical-align:middle;">ฝ่าย</th>
                                        <th rowspan="2" class="center" width="15%" style="vertical-align:middle;">แผนก</th>
                                        <th rowspan="2" class="center" width="15%" style="vertical-align:middle;">ระดับ</th>
                                        <th colspan="3" class="center">จำนวน</th>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <th class="center">จำนวนคนสมัคร</th>
                                    <th class="center">จำนวนที่รับสมัคร</th>
                                    <th class="center">จำนวนที่ไม่รับสมัคร</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" style="background-color:burlywood;"><b><?php $emptype = TypeEmployee::model()->findByPk($_GET['ReportUser']['employee_type']);
                                                                                            echo $emptype->type_employee_name; ?></b></td>
                                </tr>
                                <?php $regispass = 0;
                                if ($_GET['ReportUser']['department'] != "") {
                                    $dep = Department::model()->findAll(array('condition' => 'id=' . $_GET['ReportUser']['department']));
                                } else {
                                    if ($_GET['ReportUser']['position_id'] != "") {
                                        $pos = Position::model()->findByPk($_GET['ReportUser']['position_id']);
                                        $dep = Department::model()->findAll(array('condition' => 'id=' . $pos->department_id . ' and active="y"'));
                                    } else {
                                        $dep = Department::model()->findAll(array('condition' => 'type_employee_id=' . $_GET['ReportUser']['employee_type'] . ' and active="y"'));
                                    }
                                }
                                ?>
                                <?php
                                // จำนวนทั้งหมด
                                $total_re_total = 0;
                                $total_accept_total = 0;
                                if ($_GET['ReportUser']['employee_type'] == '1') {
                                    foreach ($dep as $value) {
                                        $Setdep = 0;
                                        if ($_GET['ReportUser']['position_id'] != "") {
                                            $PositionAll = Position::model()->findAll(array('condition' => 'id=' . $_GET['ReportUser']['position_id']));
                                        } else {
                                            $PositionAll = Position::model()->findAll(array('condition' => 'department_id=' . $value->id . ' and active="y"'));
                                        }
                                        for ($i = 0; $i < count($PositionAll); $i++) { ?>
                                            <tr>
                                                <?php
                                                $check = Department::model()->findByPk($PositionAll[$i]['department_id']);
                                                if ($check && $check->type_employee_id == 1) { ?>
                                                    <?php
                                                    // หาจำนวน
                                                    $re_total = 0;
                                                    $accept_total = 0;
                                                    for ($n = 0; $n < count($modelAll); $n++) {
                                                        if ($modelAll[$n]['position_id'] == $PositionAll[$i]['id']) {
                                                            if ($modelAll[$n]['register_status'] == 1) {
                                                                $accept_total++;
                                                            }
                                                            $re_total++;
                                                        }
                                                    }
                                                    $total_re_total += $re_total;
                                                    $total_accept_total += $accept_total;
                                                    ?>
                                                    <td></td>
                                                    <td><?php if ($Setdep == 0) {
                                                            echo $value->dep_title;
                                                            $Setdep = 1;
                                                        } ?></td>
                                                    <td><?= $PositionAll[$i]['position_title']; ?></td>
                                                    <td class="center"><?= $re_total; ?></td>
                                                    <td class="center"><?= $accept_total; ?></td>
                                                    <td class="center"><?= ($re_total - $accept_total); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php }
                                    }
                                } else {
                                    $idcheckOld = 0;
                                    if ($_GET['ReportUser']['department'] != "") {
                                        $DivisionAll = Department::model()->findAll(array('condition' => 'id=' . $_GET['ReportUser']['department'], 'order' => 'sortOrder asc'));
                                    } else {
                                        $DivisionAll = Department::model()->findAll(array('condition' => 'type_employee_id=2 and active="y"', 'order' => 'sortOrder asc'));
                                    }
                                    for ($i = 0; $i < count($DivisionAll); $i++) {
                                        $Setdiv = 0;
                                        $PosAll = Position::model()->findAll(array('condition' => 'department_id=' . $DivisionAll[$i]['id'] . ' and active="y"'));
                                        ?>
                                        <?php for ($n = 0; $n < count($PosAll); $n++) {
                                            $Setpos = 0;
                                            $levelAll = Branch::model()->findAll(array('condition' => 'position_id=' . $PosAll[$n]['id'] . ' and active="y"'));
                                        ?>
                                            <?php for ($x = 0; $x < count($levelAll); $x++) { ?>
                                                <?php
                                                // หาจำนวน
                                                $re_total = 0;
                                                $accept_total = 0;
                                                for ($r = 0; $r < count($modelAll); $r++) {
                                                    //$modelAll[$r]['department_id'] == $DivisionAll[$i]['id']
                                                    if ($modelAll[$r]['branch_id'] == $levelAll[$x]['id']) {
                                                        if ($modelAll[$r]['register_status'] == 1) {
                                                            $accept_total++;
                                                        }
                                                        $re_total++;
                                                    }
                                                    else{
                                                        if ($modelAll[$r]['branch_id'] == "" && $modelAll[$r]['position_id'] == $PosAll[$n]['id']){
                                                            if ($idcheckOld != $modelAll[$r]['id']){
                                                                if ($modelAll[$r]['register_status'] == 1) {
                                                                    $accept_total++;
                                                                }
                                                                $re_total++;
                                                                $idcheckOld = $modelAll[$r]['id'];
                                                            }
                                                        }
                                                    }
                                                }
                                                $total_re_total += $re_total;
                                                $total_accept_total += $accept_total;
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php if ($Setdiv == 0) {
                                                            echo $DivisionAll[$i]['dep_title'];
                                                            $Setdiv = 1;
                                                        } ?></td>
                                                    <td><?php if ($Setpos == 0) {
                                                            echo $PosAll[$n]['position_title'];
                                                            $Setpos = 1;
                                                        } ?></td>
                                                    <td><?= $levelAll[$x]['branch_name']; ?></td>
                                                    <td class="center"><?= $re_total; ?></td>
                                                    <td class="center"><?= $accept_total; ?></td>
                                                    <td class="center"><?= ($re_total - $accept_total); ?></td>
                                                </tr>
                                        <?php }
                                        }
                                        if (!$PosAll){
                                            $userIT = Users::model()->findAll(array('condition' => 'department_id=' . $DivisionAll[$i]['id'] . ' and superuser=0 and del_status=0'));
                                            if ($userIT){
                                                $userIT_Approved = Users::model()->findAll(array('condition' => 'department_id=' . $DivisionAll[$i]['id'] . ' and superuser=0 and del_status=0 and register_status=1'));
                                                $total_re_total += count($userIT);
                                                $total_accept_total += count($userIT_Approved);
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php if ($Setdiv == 0) {
                                                            echo $DivisionAll[$i]['dep_title'];
                                                            $Setdiv = 1;
                                                        } ?></td>
                                                    <td><?php if ($Setpos == 0) {
                                                            echo $PosAll[$n]['position_title'];
                                                            $Setpos = 1;
                                                        } ?></td>
                                                    <td>-</td>
                                                    <td class="center"><?= count($userIT_Approved); ?></td>
                                                    <td class="center"><?= count($userIT); ?></td>
                                                    <td class="center"><?= (count($userIT) - count($userIT_Approved)); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                <?php }
                                } ?>
                                <tr>
                                    <?php if ($_GET['ReportUser']['employee_type'] == '2') { ?>
                                        <td class="right" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"></td>
                                    <?php } ?>
                                    <td class="right" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"></td>
                                    <td class="right" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"></td>
                                    <td class="right" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;">รวมทั้งหมด</td>
                                    <td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $total_re_total; ?></td>
                                    <td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= $total_accept_total; ?></td>
                                    <td class="center" style="background: #e25f39; color: white; font-weight: bold; font-size: 1.1em;"><?= ($total_re_total - $total_accept_total); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
        <?php
        } else { ?>
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
    } else {
        ?>
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

    document.getElementById("ReportUser_employee_type").onchange = function() {
        $.post("<?=$this->createUrl('report/GetDataLogRegister');?>", {
            type: document.getElementById("ReportUser_employee_type").value,
            department: 1,
        },
        function(data) {
            document.getElementById('ReportUser_department').innerHTML = data;
        });
    };

    document.getElementById("ReportUser_department").onchange = function() {
        $.post("<?=$this->createUrl('report/GetDataLogRegister');?>", {
            type: document.getElementById("ReportUser_department").value,
            position: document.getElementById("ReportUser_department").value,
        },
        function(data) {
            document.getElementById('ReportUser_position_id').innerHTML = data;
        });
    };
</script>