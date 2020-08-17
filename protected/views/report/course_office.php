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
                    echo "Report";
                } else {
                    echo "รายงานผู้เรียนตามรายหลักสูตร คนOffice";
                }
                ?>
            </li>
        </ol>
    </nav>
</div>

<section id="report-detail">
    <div class="container">
        <div class="search-collapse panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#report-search"><i class="fas fa-search"></i> ค้นหา <span class="pull-right"><i class="fas fa-chevron-down"></i></span></a>
                    </h4>
                </div>
                <div id="report-search" class="panel-collapse collapse in">
                    <form method="GET" accept-charset="UTF-8" id="form_search" action="<?php echo $this->createUrl('/report/courseOffice'); ?>">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_course_id">
                                        <?php 
                                            if(Yii::app()->session['lang'] != 1){
                                                echo "หลักสูตร";
                                            }else{
                                                echo "Course";
                                            }
                                        ?>                                             
                                    </label>
                                    <select class="form-control" name="search[course_id]" id="search_course_id" onchange="change_gen();">
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
?> 
<option <?php if(isset($_GET["search"]["course_id"]) && $_GET["search"]["course_id"] == $value->course_id){ echo "selected"; } ?> value="<?= $value->course_id ?>"><?= $value->course_title ?></option> 
<?php
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
                                                    echo "รุ่น";
                                                }else{
                                                    echo "Gen";
                                                }
                                            ?>
                                    </label>
                                    <select class="form-control" name="search[gen_id]" id="search_gen_id">
                                        <option value="">
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
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input <?php if(isset($_GET["search"]["graph"]) && in_array("pie", $_GET["search"]["graph"])){ echo "checked"; } ?> type="checkbox" name="search[graph][]" id="search_graph_pie" value="pie">
                                        <label for="search_graph_pie" class="text-black">Pie Charts </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <?php if(!empty($model_department) && $authority == 1){ ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_department">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ฝ่าย";
                                        }else{
                                            echo "Department";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[department]" id="search_department" onchange="change_position();">
                                        <option value="" selected>
                                            <?php 
                                                if(Yii::app()->session['lang'] != 1){
                                                    echo "เลือกฝ่าย";
                                                }else{
                                                    echo "Select Department";
                                                }
                                            ?>
                                        </option>
<?php 
$department = "";
foreach ($model_department as $key => $value) {
    ?> 
    <option <?php if(isset($_GET["search"]["department"]) && $_GET["search"]["department"] == $value->id){ echo "selected"; $department = $_GET["search"]["department"];} ?> value="<?= $value->id?>"><?= $value->dep_title ?></option> 
    <?php
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
                                            echo "แผนก";
                                        }else{
                                            echo "Position";
                                        }
                                        ?>
                                    </label>
                                    <select class="form-control" name="search[position]" id="search_position" onchange="change_level();">
                                        <option value="" selected>
                                            <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "เลือกแผนก";
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
                            <div class="col-sm-3 col-md-3 col-xs-12">
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
                            <div class="col-md-3 col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="search_fullname">
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ค้นหาตามชื่อ-นามสกุล";
                                        }else{
                                            echo "Search Fullname";
                                        }
                                        ?>
                                    </label>
                                    <input class="form-control" placeholder="<?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo "ชื่อ-นามสกุล";
                                        }else{
                                            echo "Fullname";
                                        }
                                        ?>" name="search[fullname]" id="search_fullname" type="text" value="<?php if(isset($_GET["search"]["fullname"])){ echo $_GET["search"]["fullname"]; } ?>">
                                </div>
                            </div>
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
                                        for ($i=($year_start+1); $i<$year_end ; $i++) {
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
        if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"])){
            ?>
            <div class="col-sm-6">
                <div class="year-report">
                    <h4>Bar Graph</h4>
                    <div style="width:100%">
                        <div id="chart_bar"></div>
                    </div>
                    <script type="text/javascript">

                        google.charts.load("current", {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                          var data = google.visualization.arrayToDataTable([
                            ["หลักสูตร", "ผู้สมัคร", { role: "style" } ],
                            <?php 
                            $color = Helpers::lib()->ColorCode();
                            $no_c = 0;
                            foreach ($arr_count_course as $key => $value) {
                                if(!isset($color[$no_c])){
                                    $color[$no_c] = "silver";
                                }
                                echo "['".$arr_course_title[$key]."', ".$value.", '".$color[$no_c]."'],";
                                $no_c++;
                            } 
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
                            bar: {groupWidth: "95%"},
                            legend: { position: "none" },
                        };
                        var chart = new google.visualization.ColumnChart(document.getElementById("chart_bar"));
                        google.visualization.events.addListener(chart, 'ready', function () {
                            $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){

                                var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;                                
                                $("#result_search_graph").append("<img src='"+url_chart+"' >");
                                var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
                                $("#chart_graph").append("<img src='"+url_chart_2+"' >");
                            });
                            num_chart = num_chart+1;

                        });
                        chart.draw(view, options);
                    }
                </script>
                </div>
            </div>
            <?php
        }

        if(isset($_GET["search"]["graph"]) && in_array("pie", $_GET["search"]["graph"])){
        ?>
            <div class="col-sm-6">
                <div class="year-report">
                    <h4>Pie Charts</h4>
                    <div style="width:100%">
                        <div id="chart_pie"></div>
                    </div>
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['corechart']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                          ['หลักสูตร', 'ผู้สมัคร'],
                          <?php 
                            foreach ($arr_count_course as $key => $value) {
                                echo "['".$arr_course_title[$key]."', ".$value."],";
                            } 
                            ?>
                          ]);

                        var options = {
                          // title: 'Pie Charts'
                      };

                      var chart = new google.visualization.PieChart(document.getElementById('chart_pie'));
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
        <?php
        }
        ?>
        </div>
        <!-- จบ กราฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟฟ -->
        <div id="div_graph" style="display: none;">
               <div id="chart_graph"></div> 
               <div id="result_search_graph"></div> 
        </div>
        <div id="result_search"> <!-- export excel -->            
        <div class="report-table">
            <div class="table-responsive w-100 t-regis-language">
                <table class="table" id="table_list">
                    <thead>
                        <tr>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ลำดับ";
                            }else{
                                echo "No.";
                            }
                            ?></th>
                            <!-- <th>user_id</th> -->
                            <th>
                            <?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ชื่อ - นามสกุล";
                            }else{
                                echo "Fullname";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "ฝ่าย";
                            }else{
                                echo "Department";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "แผนก";
                            }else{
                                echo "Position";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "เลเวล";
                            }else{
                                echo "Level";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "หลักสูตร";
                            }else{
                                echo "Course";
                            }
                            ?></th>
                            <th><?php 
                            if(Yii::app()->session['lang'] != 1){
                                echo "รุ่น";
                            }else{
                                echo "Gen";
                            }
                            ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        if(!empty($model_search)){
                            $no = 1;
                            foreach ($model_search as $key => $value) {
                                ?>  
                                <tr>
                                    <td><?php echo $no; $no++; ?></td>
                                    <!-- <td><?= $value->mem->id ?></td> -->
                                    <td>
                                        <?php 
                                        if(Yii::app()->session['lang'] != 1){
                                            echo $value->pro->firstname." ".$value->pro->lastname;
                                        }else{
                                            echo $value->pro->firstname_en." ".$value->pro->lastname_en;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $value->mem->department->dep_title ?></td>
                                    <td><?= $value->mem->position->position_title ?></td>
                                    <td><?= $value->mem->branch->branch_name ?></td>
                                    <td><?= $value->course->course_title ?></td>
                                    <td><?= $value->gen->gen_title ?></td>
                                </tr>
                                <?php
                            } // foreach search
                        }else{ // !empty
                            ?>  
                            <tr>
                                <td colspan="6">
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

<div class="pull-right ">
    <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
    <button class="btn btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
</div>
    <?php }else{ // ไม่ค้นหา ช่วงเวลา ?>
        <!-- ค้นหาแบบ ช่วงเวลา -->
        <?php if(isset($_GET["search"]["graph"]) && !empty($_GET["search"]["graph"])){ ?>

                <div class="row">
                    <?php 
                    foreach ($arr_count_course as $key_y => $value_y) {                       
                        if(isset($_GET["search"]["graph"]) && in_array("bar", $_GET["search"]["graph"])){ ?>
                            <div class="col-sm-6">
                                <div class="year-report">
                                    <h4>ปี <?= $key_y ?></h4>
                                    <div style="width:100%">
                                        <div id="chart_bar"></div>
                                    </div>
                                    <script type="text/javascript">
                                        google.charts.load("current", {packages:['corechart']});
                                        google.charts.setOnLoadCallback(drawChart);
                                        function drawChart() {
                                          var data = google.visualization.arrayToDataTable([
                                            ["หลักสูตร", "ผู้สมัคร", { role: "style" } ],
                                            <?php 
                                            $color = Helpers::lib()->ColorCode();
                                            $no_c = 0;
                                            foreach ($value_y as $key => $value) {
                                                if(!isset($color[$no_c])){
                                                    $color[$no_c] = "silver";
                                                }
                                                echo "['".$arr_course_title[$key]."', ".$value.", '".$color[$no_c]."'],";
                                                $no_c++;
                                            } 
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
                                            bar: {groupWidth: "95%"},
                                            legend: { position: "none" },
                                        };
                                        var chart = new google.visualization.ColumnChart(document.getElementById("chart_bar"));
                                        google.visualization.events.addListener(chart, 'ready', function () {

                                            $.post('<?=$this->createUrl('report/SavePicChart')?>',{chart: chart.getImageURI().replace("data:image/png;base64,", ""), key : num_chart},function(json){

                                                var url_chart = "<?= $path_file ?>\\uploads\\pic_chart\\"+json;
                                                $("#result_search_graph").append("<img src='"+url_chart+"' >");
                                                var url_chart_2 = "<?= $path_file_2 ?>\\..\\uploads\\pic_chart\\"+json;
                                                $("#chart_graph").append("<img src='"+url_chart_2+"' >");
                                            });
                                            num_chart = num_chart+1;
                                        });
                                        chart.draw(view, options);
                                    }
                                </script>
                            </div>
                        </div>
                       <?php } // in_array("bar",

                        if(isset($_GET["search"]["graph"]) && in_array("pie", $_GET["search"]["graph"])){ ?>
                            <div class="col-sm-6">
                                <div class="year-report">
                                    <h4>ปี <?= $key_y ?></h4>
                                    <div style="width:100%">
                                        <div id="chart_pie"></div>
                                    </div>
                                    <script type="text/javascript">
                                      google.charts.load('current', {'packages':['corechart']});
                                      google.charts.setOnLoadCallback(drawChart);

                                      function drawChart() {

                                        var data = google.visualization.arrayToDataTable([
                                          ['หลักสูตร', 'ผู้สมัคร'],
                                          <?php 
                                          foreach ($value_y as $key => $value) {
                                            echo "['".$arr_course_title[$key]."', ".$value."],";
                                        } 
                                        ?>
                                        ]);

                                        var options = { };

                                        var chart = new google.visualization.PieChart(document.getElementById('chart_pie'));
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
                     <?php   } // in_array("pie",
                    } //foreach ($arr_count_course
                     ?>
                </div>

             <div id="div_graph" style="display: none;">
                 <div id="chart_graph"></div> 
                 <div id="result_search_graph"></div> 
                 <div id="result_search"><table><tr><td></td></tr></table></div>
             </div>

            <div class="pull-right ">
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
            $("#text_element1").attr("value", encodeURIComponent($('#chart_graph').html()+'<br>'+$('#result_search').html()) );
            $("#export_pdf").submit();
        });
      
        $('.btn-excel').click(function(e) {
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#result_search_graph').html()+'<br><br><br><br><br><br><br><br><br><br><br><br>'+$('#result_search').html() ));
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

    function change_position(){
        var department_id = $("#search_department option:selected").val();
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
        var position_id = $("#search_position option:selected").val();

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
        var status_pass = 1;

        var start_year = $("#search_start_year").val();
        var end_year = $("#search_end_year").val();
        if(end_year != "" && start_year == ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงปีเริ่มต้น");
            $("#search_start_year").addClass('form-control-danger');
        }else{
            $("#search_start_year").removeClass('form-control-danger');
        }
        if(end_year == "" && start_year != ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงปีสิ้นสุด");
            $("#search_end_year").addClass('form-control-danger');
        }else{
            $("#search_end_year").removeClass('form-control-danger');
        }

        var start_date = $("#search_start_date").val();
        var end_date = $("#search_end_date").val();
        if(end_date != "" && start_date == ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงเวลาเริ่มต้น");
            $("#search_start_date").addClass('form-control-danger');
        }else{
            $("#search_start_date").removeClass('form-control-danger');
        }
        if(end_date == "" && start_date != ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงเวลาสิ้นสุด");
            $("#search_end_date").addClass('form-control-danger');
        }else{
            $("#search_end_date").removeClass('form-control-danger');
        }

        if(status_pass == 1){
            $("#form_search").submit();
        }
    }

</script>