<script>
    $('.datetimepicker').datetimepicker({
        format: 'd-m-Y',
        step: 10,
        timepicker: false,
        timepickerScrollbar: false,
        yearOffset: 0
    });
    $.datetimepicker.setLocale('th');
</script>
<style type="text/css">
    .form-control-danger {
        border-color: #d9534f;
        color: #d9534f;
        background-color: #f8d7da !important;
    }

    .form-control-danger:focus,
    .form-control-danger:hover {
        border-color: #d9534f;
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var num_chart = 0;
    var check_department = 1;
    var check_position = 1;
</script>
 <?php 
    $path_file_2 = Yii::app()->basePath;
    $path_file = "http:\\\\thorconn.com";

    $path_file_2 = explode("\\", $path_file_2);
   
    $path_file_2 = implode("\\\\", $path_file_2);
 ?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item">
                <a href="<?php echo $this->createUrl('/site/index'); ?>">
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                        echo "Home";
                    } else {
                        echo "หน้าแรก";
                    }
                    ?>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php
                if (Yii::app()->session['lang'] == 1) {
                    echo "Training assessment Report";
                } else {
                    echo "รายงานภาพรวมแบบประเมินสอบถาม";
                }
                ?>
            </li>
        </ol>
    </nav>
    <a class="btn btn-reportsearch" href="<?php echo $this->createUrl('/report/index'); ?>?target=course" style="margin-bottom: 0px; margin-left: 0px; background-color: #087fe4;">
        <i class="fas fa-angle-left"></i> <?php echo Yii::app()->session['lang'] == 1?'Back':' ย้อนกลับ'; ?>
    </a>
</div>


<section id="report-detail">
    <div class="container">
        <div class="search-collapse panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#report-search"><i class="fas fa-search"></i> <?php echo Yii::app()->session['lang'] == 1?'Search':' ค้นหา'; ?> <span class="pull-right"><i class="fas fa-chevron-down"></i></span></a>
                    </h4>
                </div>
                <div id="report-search" class="panel-collapse collapse in">
                    <form method="GET" accept-charset="UTF-8" id="form_search" action="<?php echo $this->createUrl('/report/assessment'); ?>">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_course_id">
                                        <?php 
                                            if(Yii::app()->session['lang'] != 1){
                                                echo 'หลักสูตร <b style="color:red">*</b>';
                                            }else{
                                                echo 'Course <b style="color:red">*</b>';
                                            }
                                        ?>                                             
                                    </label>
                                    <select class="form-control" name="search[course_id]" id="search_course_id" onchange="change_gen();" required>
                                        <option value="" selected>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกหลักสูตร";
                                                }else{
                                                    echo "Select Course";
                                                }
                                            ?>
                                        </option>
                                        <?php 
                                        foreach ($model_course as $key => $value) {
                                            if(Yii::app()->session['lang'] != 1){
                                                $value->course_id = $value->parent_id;
                                            }
                        ?> <option <?php if(isset($_GET["search"]["course_id"]) && $_GET["search"]["course_id"] == $value->course_id){ echo "selected"; } ?> value="<?= $value->course_id ?>"><?= $value->course_title ?></option> <?php
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_gen_id">
                                         <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo 'รุ่น <b style="color:red">*</b>';
                                                }else{
                                                    echo 'Gen <b style="color:red">*</b>';
                                                }
                                            ?>
                                    </label>
                                    <select class="form-control" name="search[gen_id]" id="search_gen_id">
                                        <option value="" selected>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกรุ่นของหลักสูตร";
                                                }else{
                                                    echo "Select Gen";
                                                }
                                            ?>
                                        </option>
<?php 
if(isset($model_gen) && !empty($model_gen)){
    ?>
    <option value="0">
        <?php 
        if(Yii::app()->session['lang'] != 1){
            echo "ไม่มีรุ่น";
        }else{
            echo "No Gen";
        }
        ?>
    </option>
    <?php
    foreach ($model_gen as $key => $value) {
        ?>
        <option value="<?= $value->gen_id ?>" <?php if(isset($_GET["search"]["gen_id"]) && $_GET["search"]["gen_id"] == $value->gen_id){ echo "selected"; } ?> ><?= $value->gen_title ?></option>
        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div><label>
                                        <?php 
                                            if(Yii::app()->session['lang'] != 1){
                                                echo "รูปแบบกราฟแสดงผล";
                                            }else{
                                                echo "Graph Type";
                                            }
                                        ?>
                                    </label></div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input <?php if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"])){ echo "checked"; } ?> type="checkbox" name="search[graph][]" id="search_graph_bar" value="bar">
                                        <label for="search_graph_bar" class="text-black">Bar Graph </label>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <?php if($authority == 1){ ?>
                                <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_employee">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ประเภทพนักงาน";
                                        }else{
                                            echo "Employee Type";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[employee]" id="search_employee" onchange="change_department();">
                                        <option value="">
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกประเภทพนักงาน";
                                                }else{
                                                    echo "Select Employee Type";
                                                }
                                            ?>
                                        </option>
                                        <option value="1" <?php if(isset($_GET['search']['employee']) && $_GET['search']['employee'] == 1){ echo "selected"; } ?>>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "คนเรือ";
                                                }else{
                                                    echo "MASTER / CAPTAIN";
                                                }
                                            ?>
                                        </option>
                                        <option value="2" <?php if(isset($_GET['search']['employee']) && $_GET['search']['employee'] == 2){ echo "selected"; } ?>>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "คนออฟฟิศ";
                                                }else{
                                                    echo "Office";
                                                }
                                            ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($authority == 1){ ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_department">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ฝ่าย/แผนก";
                                        }else{
                                            echo "Department";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[department]" id="search_department" onchange="change_position();">
                                        <option value="" selected>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกฝ่าย/แผนก";
                                                }else{
                                                    echo "Select Department";
                                                }
                                            ?>
                                        </option>
<?php 
if(isset($model_department) && !empty($model_department)){
    foreach ($model_department as $key => $value) {
        ?>
        <?php var_dump($value); ?>
        <option <?php if(isset($_GET["search"]["department"]) && $_GET["search"]["department"] == $value->id){ echo "selected"; $department = $_GET["search"]["department"];} ?> value="<?= $value->id?>"><?= $value->dep_title ?></option> 
        <?php
}
}
?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($authority == 1 || $authority == 2){ ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_position">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "แผนก/ตำแหน่ง";
                                        }else{
                                            echo "Position";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[position]" id="search_position" onchange="change_level();">
                                        <option value="" selected>
                                            <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลือกแผนก/ตำแหน่ง";
                                        }else{
                                            echo "Select Position";
                                        }
                                        ?>
                                        </option>
<?php 
if(isset($model_position) && !empty($model_position)){
    foreach ($model_position as $key => $value) {
        ?>
        <option value="<?= $value->id ?>" <?php if(isset($_GET["search"]["position"]) && $_GET["search"]["position"] == $value->id){ echo "selected"; } ?> ><?= $value->position_title ?></option>
        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
<?php if($authority == 1 || ( ($authority == 2 || $authority == 3) && $user_login->profile->type_employee == 2) ){ ?>
                            <div class="col-sm-3 col-md-3 col-xs-12" id="div_search_level">
                                <div class="form-group">
                                    <label for="search_level">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลเวล";
                                        }else{
                                            echo "Level";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[level]" id="search_level">
                                        <option value="" selected>
                                            <?php 
                                            if(Yii::app()->session['lang'] != 1){
                                                echo "เลือกเลเวล";
                                            }else{
                                                echo "Select Level";
                                            }
                                            ?>
                                        </option>
<?php 
if(isset($model_level) && !empty($model_level)){
    foreach ($model_level as $key => $value) {
        ?>
        <option value="<?= $value->id ?>" <?php if(isset($_GET["search"]["level"]) && $_GET["search"]["level"] == $value->id){ echo "selected"; } ?> ><?= $value->branch_name ?></option>
        <?php
    }
}
?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label for="search_start_date">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาเริ่มต้น";
                                        }else{
                                            echo "Range start date";
                                        }
                                        ?>
                                    </label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="<?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาเริ่มต้น";
                                        }else{
                                            echo "Range start date";
                                        }
                                        ?>" type="text" name="search[start_date]" id="search_start_date" value="<?php if(isset($_GET["search"]["start_date"])){ echo $_GET["search"]["start_date"]; } ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label for="search_end_date">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาสิ้นสุด";
                                        }else{
                                            echo "Range end date";
                                        }
                                        ?>
                                    </label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="<?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงเวลาสิ้นสุด";
                                        }else{
                                            echo "Range end date";
                                        }
                                        ?>" type="text" name="search[end_date]" id="search_end_date" value="<?php if(isset($_GET["search"]["end_date"])){ echo $_GET["search"]["end_date"]; } ?>">
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_start_year">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงปีเริ่มต้น";
                                        }else{
                                            echo "Range start year";
                                        }
                                        ?>                                            
                                    </label>
                                    <select class="form-control" name="search[start_year]" id="search_start_year">
                                        <option value="">
                                            <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลือกช่วงปีเริ่มต้น";
                                        }else{
                                            echo "Select Range start year";
                                        }
                                        ?>
                                        </option>
                                        <?php 
                                        for ($i=$year_start; $i<$year_end ; $i++) {
                                            ?> <option <?php if(isset($_GET["search"]["start_year"]) && $_GET["search"]["start_year"] == $i){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option> <?php
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_end_year">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ช่วงปีสิ้นสุด";
                                        }else{
                                            echo "Range end year";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[end_year]" id="search_end_year">
                                        <option value="">
                                            <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลือกช่วงปีสิ้นสุด";
                                        }else{
                                            echo "Select Range end year";
                                        }
                                        ?>
                                        </option>
                                        <?php 
                                        for ($i=($year_start+1); $i<=$year_end ; $i++) {
                                            ?> <option <?php if(isset($_GET["search"]["end_year"]) && $_GET["search"]["end_year"] == $i){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option> <?php
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-reportsearch" type="button" onclick="chk_form_search();"><i class="fas fa-search"></i>
                                <?php 
                                if(Yii::app()->session['lang'] != 1){
                                    echo "ค้นหา";
                                }else{
                                    echo "Search";
                                }
                                ?>
                            </button>
                        </div>

                    </div>
                </form>
                </div>

            </div>
        </div>
        <div class="divider">
            <i class="fas fa-chevron-down"></i>
        </div>


        <?php if(isset($_GET["search"])){ ?>
        <?php if($_GET["search"]["start_year"] == "" && $_GET["search"]["end_year"] == ""){ // ไม่ค้นหา ช่วงเวลา ?>

        <!-- เริ่ม กราฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟ -->
        <div class="row">
        <?php 
        if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"]) && !empty($sections)){
            ?>
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="year-report">
                    <h4>Bar Graph</h4>
                    <div style="width:100%">
                        <div id="chart_bar"></div>
                    </div>
                    <?php 
                    $data = ['0'=>"หลักสูตร"];
                    $dataresult = [];

                    foreach ($sections as $keysectionschart => $valsectionschart) {
                        $data[] = $title_section[$valsectionschart->survey_section_id];
                        $dataresult[] = $resultssec =  round($total_section[$valsectionschart->survey_section_id]/$countquest_section[$valsectionschart->survey_section_id],2) ;

                    } 

                    // $data =  ['0'=>"หลักสูตร",'1'=>"คนสมัคร" ,'3'=>"test"] ; 
                    $data_chk = implode('","',$data);
                    $dataresult_chk = implode(',',$dataresult);

                    $test  = '["'.$data_chk.'"],';
                    $testresult  = '["'.$course_title->course_title.'",'.$dataresult_chk.'],';

                    
                    ?>
                   
                    <script type="text/javascript">

                        google.charts.load("current", {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            <?php 
                            // foreach ($model_graph as $key => $value) {
                                    echo $test;
                                    echo $testresult;
                            // } 
                            ?>
                          ]);

                          var options = {
                            seriesType: 'bars',
                            bar: {groupWidth: "50%"},
                            legend: { position: "right" },
                            chartArea:{ right:'15%' },
                        };

                        var chart = new google.visualization.ComboChart(document.getElementById('chart_bar'));

google.visualization.events.addListener(chart, 'ready', function () {
    $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){
        var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;
        $("#result_search_graph").append("<img src='"+url_chart+"' >");
        var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
        $("#chart_graph").append("<img src='"+url_chart_2+"' >");
    });
    num_chart = num_chart+1;
});

chart.draw(data, options);
                    }
                </script>

                </div>
            </div>
            <div class="col-sm-1"></div>
            <?php
        }

        
        ?>
        </div>
        <!-- จบ กราฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟ -->

        <li class="breadcrumb-item active" aria-current="page">
            <center>
                <h3>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                        echo "Training assessment Report";
                    } else {
                        echo "รายงานภาพรวมแบบประเมินสอบถาม";
                    }
                    ?>
                </h3>    
            </center>
        </li>
        <div id="div_graph" style="display: none;">
               <div id="chart_graph"></div> 
               <div id="result_search_graph"></div> 
        </div>
        <div id="result_search"> <!-- export excel -->            
        <div class="report-table">
            <div class="table-responsive w-100 t-regis-language">
                <table class="table" id="table_list" >
                    <thead>

                          <tr style="background-color: #010C65; color: #fff; border: 1.5px solid #000;">
                            <th rowspan="2" width="10%">
                                <?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ลำดับ";
                            }else{
                                echo "No.";
                            }
                            ?></th>
                            <th rowspan="2"> <?php if(Yii::app()->session['lang'] != 1){
                                echo "หลักสูตร";
                            }else{
                                echo "Course";
                            } ?></th>
                            <th colspan="<?= count($sections)?>" width="65%"><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ผลการประเมิน";
                            }else{
                                echo "Assessment results";
                            }
                            ?></th>
                        </tr>
                        <tr style="background-color: #010C65; color: #fff; border: 1.5px solid #000;" >

                            <?php foreach ($sections as $keysections=> $valsections) { ?>
                           
                            <th> <?=$title_section[$valsections->survey_section_id] ?></th>
                            <?php } ?>
                        </tr>

                    </thead>

                    <tbody>
                        <?php 
                        if(!empty($sections)){
                            $no = 1; ?>
                           
                            
                            <tr style="border: 1.5px solid #000; text-align: center;">
                                <td><?php echo $no; $no++; ?></td>
                                <td><?= $course_title->course_title ?></td>
                                <?php foreach ($sections as $keysections2 => $valsections2) {

                                    $resultssec =  round($total_section[$valsections2->survey_section_id]/$countquest_section[$valsections2->survey_section_id],2); ?>

                                    <td> <?=$resultssec ?> %</td>

                                <?php } ?>
                            </tr>
                      <?php  }else{ // !empty
                            ?>  
                            <tr style="border: 1.5px solid #000; text-align: center;">
                                <td colspan="3">
                                    <?php 
                                    if(Yii::app()->session['lang'] != 1){
                                        echo "ไม่มีข้อมูล";
                                    }else{
                                        echo "No data";
                                    }
                                    ?></td>
                            </tr>
                            <?php
                        }

                         ?>
                    </tbody>

                </table>
            </div>
        </div>

</div> <!-- export excel -->

<div class="pull-left ">
    <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
    <button class="btn btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
</div>
    <?php }else{ // ไม่ค้นหา ช่วงเวลา ?>
        <!-- ค้นหาแบบ ช่วงเวลา -->
        <?php if(isset($_GET["search"]["graph"]) && !empty($_GET["search"]["graph"])){ ?>

                <div class="row">
                    <?php 
                    foreach ($model_year as $key_y => $value_y) { 
                       
                        if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"])){ ?>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="year-report">
                                    <h4>ปี <?= $key_y ?></h4>
                                    <div style="width:100%">
                                        <div id="chart_bar"></div>
                                    </div>
                                    <?php

                                    $data = ['0'=>"หลักสูตร"];
                                    $dataresult = [];
                                    foreach ($sections as $keysectionschart2 => $valsectionschart2) {
                                        $data[] = $title_section[$valsectionschart2->survey_section_id];
                                        $dataresult[] = $resultssec =  round($total_section[$valsectionschart2->survey_section_id]/$countquest_section[$valsectionschart2->survey_section_id],2) ;

                                    } 

                    // $data =  ['0'=>"หลักสูตร",'1'=>"คนสมัคร" ,'3'=>"test"] ; 
                                    $data_chk = implode('","',$data);
                                    $dataresult_chk = implode(',',$dataresult);

                                    $test  = '["'.$data_chk.'"],';
                                    $testresult  = '["'.$course_title->course_title.'",'.$dataresult_chk.'],';

                                    ?>
                                    <script type="text/javascript">
                                        google.charts.load("current", {packages:['corechart']});
                                        google.charts.setOnLoadCallback(drawChart);
                                        function drawChart() {
                                         var data = google.visualization.arrayToDataTable([
                                            <?php 
                            // foreach ($model_graph as $key => $value) {
                                            echo $test;
                                            echo $testresult;
                            // } 
                                            ?>
                                            ]);

                                          var view = new google.visualization.DataView(data);
                                          view.setColumns([0, 1,
                                           { calc: "stringify",
                                           sourceColumn: 1,
                                           type: "string",
                                           role: "annotation" },
                                           2]);

                          var options = {
                            seriesType: 'bars',
                            bar: {groupWidth: "50%"},
                            legend: { position: "right" },
                            chartArea:{ right:'15%' },
                        };

var chart = new google.visualization.ComboChart(document.getElementById('chart_bar'));

google.visualization.events.addListener(chart, 'ready', function () {
    $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){

        var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;
        $("#result_search_graph").append("<img src='"+url_chart+"' >");
        var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
        $("#chart_graph").append("<img src='"+url_chart_2+"' >");
    });
    num_chart = num_chart+1;
});

chart.draw(data, options);
                                    }
                                </script>
                            </div>
                        </div>
                            <div class="col-sm-1"></div>

                       <?php } // in_array("bar",

                    }//foreach ($arr_count_course
                     ?>
                </div>

             <div id="div_graph" style="display: none;">
                 <div id="chart_graph"></div> 
                 <div id="result_search_graph"></div> 
                 <div id="result_search"><table><tr><td></td></tr></table></div>
             </div>

            <div class="pull-left ">
                <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
                <button class="btn btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
            </div>
        <?php } // !empty($_GET["search"]["graph"]) ?>

    <?php } // }else{ // ไม่ค้นหา ช่วงเวลา ?>
<?php } // if(isset($_GET["search"] ?>


   

</section>
</div>

<div style="display: none;">
    <form id="export_pdf" action="<?=$this->createUrl('report/ExportPDF')?>" target="blank_" method="POST">
        <input type="text" name="text_element1" id="text_element1" value="">
    </form>
</div>

<script type="text/javascript">
    $(document).ready( function () {

        $('.btn-pdf').click(function(e) {
            $("#text_element1").attr("value", encodeURIComponent("<h2> <?php
                if (Yii::app()->session['lang'] == 1) {
                    echo "Training assessment Report";
                } else {
                    echo "รายงานภาพรวมแบบประเมินสอบถาม";
                }
                ?></h2>"+$('#chart_graph').html()+'<br>'+$('#result_search').html()) );
            $("#export_pdf").submit();
        });
      
       
          $('.btn-excel').click(function(e) {
            window.open('data:application/vnd.ms-excel;charset=UTF-8;,' + encodeURIComponent("<h2><?php
                if (Yii::app()->session['lang'] == 1) {
                    echo "Training assessment Report";
                } else {
                    echo "รายงานภาพรวมแบบประเมินสอบถาม";
                }
                ?></h2>"+$('#result_search_graph').html()+'<br><br><br><br><br><br><br><br><br><br><br><br><font color="white">ตาราง</font>'+$('#result_search').html() ));
            e.preventDefault();
        });


    });

    $('.datetimepicker').datetimepicker({
        format: 'Y-m-d',
        step: 10,
        timepicker: false,
        timepickerScrollbar: false,
        yearOffset: 0
    });
    $.datetimepicker.setLocale('th');

    $("#search_start_date").change(function () {
        $("#search_end_date").val("");
        $("#search_start_year").val("");
        $("#search_end_year").val("");
    });
    $("#search_end_date").change(function () {
        var first = new Date($("#search_start_date").val());
        var current = new Date($(this).val());
        // console.log(first.getTime() +">"+ current.getTime());
        if (first.getTime() > current.getTime()) {
            alert("ไม่สามารถเลือกช่วงเวลาสิ้นสุดมากกว่าช่วงเวลาเริ่มต้นได้");
            $(this).val("");
        }
        $("#search_start_year").val("");
        $("#search_end_year").val("");
    });

    $("#search_start_year").change(function () {
        $("#search_end_year").val("");
        $("#search_start_date").val("");
        $("#search_end_date").val("");
    });
    $("#search_end_year").change(function () {
        var first = $("#search_start_year").val();
        var current = $(this).val();
        if (first >= current && current != "") {
            alert("ไม่สามารถเลือกช่วงปีสิ้นสุดมากกว่าช่วงปีเริ่มต้นได้");            
            $(this).val("");
        }
        $("#search_start_date").val("");
        $("#search_end_date").val("");
    });

    function change_gen(){
        var course_id = $("#search_course_id option:selected").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getGenid"); ?>',
            data: ({
                course_id: course_id,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_gen_id").html(data);
                }
            }
        });
    }

    function change_department(){
        var employee_type = $("#search_employee option:selected").val();
        if(employee_type == 1){
            $("#div_search_level").hide();
        }else{
            $("#div_search_level").show();
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getDepartment"); ?>',
            data: ({
                employee_type: employee_type,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_department").html(data);
                    $("#search_position").html("<option value='' selected><?php if(Yii::app()->session['lang'] != 1){ echo "เลือกตำแหน่ง"; }else{ echo "Select Position"; } ?></option>");
                    $("#search_level").html("<option value='' selected><?php if(Yii::app()->session['lang'] != 1){ echo "เลือกเลเวล"; }else{ echo "Select Level"; } ?></option>");
                }
            }
        });
    }

    function change_position(){
        if(check_department == 1 && "<?= $department ?>" != ""){
            var department_id = "<?= $department ?>";
            check_department = 2;
        }else{
            var department_id = $("#search_department option:selected").val();
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getPosition"); ?>',
            data: ({
                department_id: department_id,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_position").html(data);
                    $("#search_level").html("<option value='' selected><?php if(Yii::app()->session['lang'] != 1){ echo "เลือกเลเวล"; }else{ echo "Select Level"; } ?></option>");
                }
            }
        });
    }

    function change_level(){      
    if(check_position == 1 && "<?= $position ?>" != ""){
        var position_id = "<?= $position ?>";
        check_position = 2;
    }else{  
        var position_id = $("#search_position option:selected").val();
    }
    
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/report/getLevel"); ?>',
            data: ({
                position_id: position_id,
            }),
            success: function(data) {
                if(data != ""){
                    $("#search_level").html(data);
                }
            }
        });
    }

    function chk_form_search(){
        var Alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 

        var status_pass = 1;

        var start_year = $("#search_start_year").val();
        var end_year = $("#search_end_year").val();
        if(end_year != "" && start_year == ""){
            status_pass =2;
             var startyear_datealert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a starting year! ':'กรุณาเลือกช่วงปีเริ่มต้น!'; ?>";
            swal(Alert_message,startyear_datealert)
            $("#search_start_year").addClass('form-control-danger');
        }else{
            $("#search_start_year").removeClass('form-control-danger');
        }
        if(end_year == "" && start_year != ""){
            status_pass =2;
             var endyear_datealert = "<?php echo Yii::app()->session['lang'] == 1?'Please select an end year! ':'กรุณาเลือกช่วงปีสิ้นสุด!'; ?>";
            swal(Alert_message,endyear_datealert)

            alert("กรุณาเลือกช่วงปีสิ้นสุด");
            $("#search_end_year").addClass('form-control-danger');
        }else{
            $("#search_end_year").removeClass('form-control-danger');
        }





        var start_date = $("#search_start_date").val();
        var end_date = $("#search_end_date").val();
        if(end_date != "" && start_date == ""){
            status_pass =2;
            var start_datealert = "<?php echo Yii::app()->session['lang'] == 1?'Please select Start Date! ':'กรุณาเลือกช่วงเวลาเริ่มต้น!'; ?>";
            swal(Alert_message,start_datealert)
            $("#search_start_date").addClass('form-control-danger');
        }else{
            $("#search_start_date").removeClass('form-control-danger');
        }
        if(end_date == "" && start_date != ""){
            status_pass =2;
              var end_dateAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select End Date! ':'กรุณาเลือกช่วงเวลาสิ้นสุด!'; ?>";
            swal(Alert_message,end_dateAlert)
            $("#search_end_date").addClass('form-control-danger');
        }else{
            $("#search_end_date").removeClass('form-control-danger');
        }

        var course = $("#search_course_id").val();
        var gen = $("#search_gen_id").val();

         if(course == "" ){
            status_pass =2;
            var CourseAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select Course! ':'กรุณาเลือกหลักสูตร!'; ?>";
            swal(Alert_message,CourseAlert)

            $("#search_course_id").addClass('form-control-danger');
        }else{
            $("#search_course_id").removeClass('form-control-danger');
        }
        if(gen == "" ){
            status_pass =2;
            var genAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select Gen! ':'กรุณาเลือกรุ่น!'; ?>";
            swal(Alert_message,genAlert)
            $("#search_gen_id").addClass('form-control-danger');
        }else{
            $("#search_gen_id").removeClass('form-control-danger');
        }


        if(status_pass == 1){
            $("#form_search").submit();
        }
    }

</script>