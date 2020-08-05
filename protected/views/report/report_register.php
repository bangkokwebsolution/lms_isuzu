<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                    echo "Report...";
                } else {
                    echo "รายงาน...";
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
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ประเภทพนักงาน</label>
                                    <select class="form-control TypeEmployee" name="" id="TypeEmployee">
                                        <option value="" selected disabled>เลือกประเภท</option>
                                        <!-- <option value="1">1</option>
                                        <option value="2">2</option> -->
                                        <?php

                                    $criteria= new CDbCriteria;
                                    $criteria->compare('active','y');
                                    $TypeEmployeeModel = TypeEmployee::model()->findAll($criteria);
                                   foreach ($TypeEmployeeModel as $key => $val) {
                                    $TypeEmployee_list = $TypeEmployeeModel[$key]->attributes;
                                    ?>
                                    <option value="<?php echo $TypeEmployee_list['id']; ?>"><?php echo $TypeEmployee_list['type_employee_name']; ?></option>
                                <?php   
                                }                       
                                ?>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ฝ่าย</label>
                                    <select class="form-control Department" name="" id="Department">
                                        <option value="" selected disabled>เลือกฝ่าย</option>
                                        <!-- <option value="1">1</option>
                                        <option value="2">2</option> -->
                                <?php

                                    $criteria= new CDbCriteria;
                                   // $criteria->compare('type_employee_id','2');
                                    $criteria->compare('active','y');
                                    $criteria->order = 'sortOrder ASC';
                                    $departmentModel = Department::model()->findAll($criteria);
                                   foreach ($departmentModel as $key => $val) {
                                    $department_list = $departmentModel[$key]->attributes;
                                    ?>
                                    <option value="<?php echo $department_list['id']; ?>"><?php echo $department_list['dep_title']; ?></option>
                                <?php   
                                }                       
                                ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <!--   <div><label>รูปแบบกราฟแสดงผล</label></div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input type="checkbox" name="accommodation" id="1" value="Bar Graph">
                                        <label for="1" class="text-black">Bar Graph </label>
                                    </div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input type="checkbox" name="accommodation" id="2" value="Pie Charts">
                                        <label for="2" class="text-black">Pie Charts </label>
                                    </div>-->
                                    <div class="radio radio-main radio-inline">
                                        <input type="radio" name="accommodation" id="1" value="Bar Graph">
                                        <label for="1" class="text-black">Bar Graph </label>
                                    </div>
                                    <div class="radio radio-main radio-inline">
                                        <input type="radio" name="accommodation" id="2" value="Pie Charts">
                                        <label for="2" class="text-black">Pie Charts </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">แผนก</label>
                                    <select class="form-control Position" name="" id="x">
                                        <option value="" selected disabled>เลือกแผนก</option>
                                        <!-- <option value="1">1</option>
                                        <option value="2">2</option> -->
                                    <?php

                                    $criteria= new CDbCriteria;
                                   // $criteria->compare('type_employee_id','2');
                                    $criteria->compare('active','y');
                                    $criteria->order = 'sortOrder ASC';
                                    $PositionModel = Position::model()->findAll($criteria);
                                   foreach ($PositionModel as $key => $val) {
                                    $Position_list = $PositionModel[$key]->attributes;
                                    ?>
                                    <option value="<?php echo $Position_list['id']; ?>"><?php echo $Position_list['position_title']; ?></option>
                                <?php   
                                }                       
                                ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12 tag_leval">
                                <div class="form-group">
                                    <label for="">เลเวล</label>
                                    <select class="form-control Leval" name="" id="x">
                                        <option value="" selected disabled>เลเวล</option>
                                       <!--  <option value="1">1</option>
                                        <option value="2">2</option> -->
                                    <?php
                                    $criteria= new CDbCriteria;
                                   // $criteria->compare('type_employee_id','2');
                                    $criteria->compare('active','y');
                                    $criteria->order = 'sortOrder ASC';
                                    $BranchModel = Branch::model()->findAll($criteria);
                                   foreach ($BranchModel as $key => $val) {
                                    $Branch_list = $BranchModel[$key]->attributes;
                                    ?>
                                    <option value="<?php echo $Branch_list['id']; ?>"><?php echo $Branch_list['branch_name']; ?></option>
                                <?php   
                                }                       
                                ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12 tag_status">
                                <div class="form-group">
                                    <label for="">สถานะอนุมัติ</label>
                                    <select class="form-control status" name="" id="x">
                                        <option value="" selected disabled>สถานะอนุมัติ</option>
                                        <option value="1">อนุมัติ</option>
                                        <option value="0">ไม่อนุมัติ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label>ช่วงเวลาเริ่มต้น</label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="ช่วงเวลาเริ่มต้น" type="text" name="" id="datetime_start">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label>ช่วงเวลาสิ้นสุด</label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="ช่วงเวลาสิ้นสุด" type="text" name="" id="datetime_end">
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ช่วงปีเริ่มต้น</label>
                                    <select class="form-control Year_start" name="" id="x">
                                        <option value="" selected disabled>ช่วงปีเริ่มต้น</option>
                                        <?php
                                        $starting_year  = 2019;
                                        $ending_year = date('Y');
                                              if ($ending_year) {

                                               for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                                                     <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                                              <?php   }                 
                                             }
                                       ?>
                                  <!--       <option value="1">1</option>
                                        <option value="2">2</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ช่วงปีสิ้นสุด</label>
                                    <select class="form-control Year_end" name="" id="x">
                                        <option value="" selected disabled>ช่วงปีสิ้นสุด</option>
                                        <!-- <option value="1">1</option>
                                        <option value="2">2</option> -->
                                        <?php
                                        $starting_year  = 2019;
                                        $ending_year = date('Y');
                                              if ($ending_year) {

                                               for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                                                     <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                                              <?php   }                 
                                             }
                                       ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-reportsearch search"><i class="fas fa-search"></i> ค้นหา </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="divider">
            <i class="fas fa-chevron-down"></i>
        </div>

         <div class="row">
            <div class="col-sm-6">
                <div class="chart"></div>
                <div class="year-report">
                    <h4>ปี 2019</h4>
                    <div style="width:100%">
                        <div id="chart_div"></div>
                    </div>
                  
                </div> 
            </div>
            <div class="col-sm-6">
                <div class="year-report">
                    <h4>ปี 2020</h4>
                 <div style="width:100%">
                        <div id="chart_div2"></div>
                    </div>
                </div>
            </div>
        </div> 
     <!--    <h2 class="text-center">
            <?php
            if (Yii::app()->session['lang'] == 1) {
                echo "Report";
            } else {
                echo "รายงานภาพ";
            }
            ?>
        </h2> -->
        <div class="dataTable"></div>
        <div class="pull-right ">
            <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
            <button class="btn btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
        </div>

    </div>
    </div>

</section>
<?php 
            
// foreach ($net_regischart as $key => $value) {
//     if($value !=0) {
//          $ries = "'".$CourseTitle_chart[$key]."'";
//          $pass = $net_passchart[$key];
//         // // $notPass = $lessonAllCount[$key] - $lessonPassCount[$key];
//         $notPass = $net_regischart[$key] - $net_passchart[$key];
//         $all = $net_regischart[$key];
//     }
// }
            ?>
<script>
    $('.datetimepicker').datetimepicker({
        format: 'd-m-Y',
        step: 10,
        timepicker: false,
        timepickerScrollbar: false,
        yearOffset: 0
    });
    $.datetimepicker.setLocale('th');

    $(".TypeEmployee").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('report/ListDepartment'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {
                         
                            $('.Department').empty();
                            $('.Department').append(data);

                            $('.Position').val("");
                            $('.Leval').val("");

                            var e = document.getElementById("TypeEmployee");
                            var strUser = e.options[e.selectedIndex].value;
                            if (strUser === '1') {
                                 $('.tag_status').show();
                                 $('.tag_leval').hide();
                            }else if (strUser === '2') {
                                 $('.tag_status').hide();
                                 $('.tag_leval').show();
                            }
                        }
        });
    });
    $(".Department").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('report/ListPosition'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            
                            $('.Position').empty();
                            $('.Position').append(data);
                            $('.Leval').val("");
                        }
        });
    });

    $(".Position").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('report/ListLeval'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            
                            $('.Leval').empty();
                            $('.Leval').append(data);
                        }
        });
    });

    $(".search").click(function() {
                    var TypeEmployee = $(".TypeEmployee").val();
                    var Department = $(".Department").val();
                    var Position = $(".Position").val();
                    var Leval = $(".Leval").val(); 
                    var Chart = $("input[name='accommodation']:checked").val();
                    var datetime_start = $("#datetime_start").val();
                    var datetime_end = $("#datetime_end").val();
                    var Year_start = $(".Year_start").val();
                    var Year_end = $(".Year_end").val();
                    var status = $(".status").val();

                    // var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                    // if (TypeEmployee == '' || TypeEmployee === null) {
                    //       var TypeEmployeeAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select staff type! ':'กรุณาเลือกประเภทพนักงาน!'; ?>";
                    //       swal(alert_message,TypeEmployeeAlert)
                    //       return false; 
                    // }else if(Department == '' || Department === null) {
                    //       var DepartmentAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select department! ':'กรุณาเลือกฝ่าย!'; ?>";
                    //       swal(alert_message,DepartmentAlert)
                    //       return false; 
                    // }
                    // else if(typeof  Chart === 'undefined' || Chart === null) {
                    //       var ChartAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select Bar Graph or Pie Charts! ':'กรุณาเลือกBar Graph หรือ Pie Charts!'; ?>";
                    //       swal(alert_message,ChartAlert)
                    //       return false; 
                    // }else if(datetime_start === '') {
                    //       var datetime_startAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please choose a starting period! ':'กรุณาเลือกช่วงเวลาเริ่มต้น!'; ?>";
                    //       swal(alert_message,datetime_startAlert)
                    //       return false; 
                    // }else if(datetime_end === '') {
                    //       var datetime_endAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select an end period! ':'กรุณาเลือกช่วงเวลาสิ้นสุด!'; ?>";
                    //       swal(alert_message,datetime_endAlert)
                    //       return false; 
                    // }else if(Year_start == '' || Year_start === null) {
                    //       var Year_startAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a start year! ':'กรุณาเลือกช่วงปีเริ่มต้น!'; ?>";
                    //       swal(alert_message,Year_startAlert)
                    //       return false; 
                    // }else if(Year_end == '' || Year_end === null) {
                    //       var Year_endAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select an ending year! ':'กรุณาเลือกช่วงปีสิ้นสุด!'; ?>";
                    //       swal(alert_message,Year_endAlert)
                    //       return false; 
                    // }else if(status == '') {
                    //       var statusAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select an approval status! ':'กรุณาเลือกสถานะอนุมัติ!'; ?>";
                    //       swal(alert_message,statusAlert)
                    //       return false; 
                    // }    
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('report/reportRegisterData'); ?>",
                        data: {
                            TypeEmployee: TypeEmployee,
                            Department: Department,
                            Position: Position,
                            Leval: Leval,
                            Chart: Chart,
                            datetime_start: datetime_start,
                            datetime_end: datetime_end,
                            Year_start: Year_start,
                            Year_end: Year_end,
                            status:status,

                        },
                        success: function(data) {
                           console.log(data);
                     
                           $(".dataTable").html(data);

                        }
        });
    });


// google.charts.load("current", {packages:['corechart']});
//     google.charts.setOnLoadCallback(drawChart);
//     function drawChart() {

//       var data = google.visualization.arrayToDataTable([
//         ["Element", "Density", { role: "style" } ],
//         <?php 
//         $datatest = ''; 
//         $datatest .= '["Copper",8.94,"#b87333"],';
//         $datatest .= '["Silver",10.94,"#000000"]';
       
//         echo $datatest;

//         ?>
//       ]);

//       var view = new google.visualization.DataView(data);
//       view.setColumns([0, 1,
//                        { calc: "stringify",
//                          sourceColumn: 1,
//                          type: "string",
//                          role: "annotation" },
//                        2]);

//       var options = {
//         title: "Density of Precious Metals, in g/cm^3",
//         width: 600,
//         height: 400,
//         bar: {groupWidth: "95%"},
//         legend: { position: "none" },
//       };
//       var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
//       chart.draw(view, options);
//   }
</script>
