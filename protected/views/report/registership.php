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
                    echo "Register staff ship Report";
                } else {
                    echo "รายงานภาพการสมัครสมาชิก คนประจำเรือ";
                }
                ?>
            </li>
        </ol>
    </nav>
    <a class="btn btn-reportsearch" href="<?php echo $this->createUrl('/report'); ?>" style="margin-bottom: 0px; margin-left: 0px; background-color: #087fe4;">
        <i class="fas fa-angle-left"></i><?php echo Yii::app()->session['lang'] == 1?'Back':' ย้อนกลับ'; ?>
    </a>
</div>

<section id="report-detail">
    <div class="container">
        <div class="search-collapse panel-group">
            <div class="panel panel-default"> 
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#report-search"><i class="fas fa-search"></i></i><?= Yii::app()->session['lang'] == 1?'Search':'ค้นหา'; ?> <span class="pull-right"><i class="fas fa-chevron-down"></i></span></a>
                    </h4>
                </div>
                <div id="report-search" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <?php
                            if($authority == 1){
                            ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for=""><?= Yii::app()->session['lang'] == 1?'Department':'ฝ่าย'; ?></label>
                                    <select class="form-control Department" name="" id="Department">
                                        <option value="" selected disabled><?= Yii::app()->session['lang'] == 1?'Select department':'เลือกฝ่าย'; ?></option>
                                        <?php

                                            $criteria= new CDbCriteria;
                                            $criteria->compare('type_employee_id','1');
                                            if ($authority == 2 || $authority == 3) {
                                                if ($Department != "") {
                                                    $criteria->compare('id',$Department);
                                                }else{
                                                    $criteria->compare('id',0);
                                                }
                                                 
                                            }
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
                        <?php } ?>
                         <?php if($authority == 1 || $authority == 2 || $authority == 2 && $type_em == 1 ){   ?>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for=""><?= Yii::app()->session['lang'] == 1?'Position':'แผนก'; ?></label>
                                    <select class="form-control Position" name="" id="x">
                                        <option value="" selected disabled><?= Yii::app()->session['lang'] == 1?'Select Position':'เลือกแผนก'; ?></option>
                                    <?php

                                        $criteria= new CDbCriteria;
                                        if ($authority == 2 || $authority == 3 ) {
                                            if ($Position != "") {
                                                $criteria->compare('id',$Position);
                                            }else{
                                                $criteria->compare('id',0);
                                            }
                                        }
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
                        <?php } ?>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <div><label><?= Yii::app()->session['lang'] == 1?'Chart pattern':'รูปแบบกราฟ'; ?></label></div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input type="checkbox" name="accommodation" id="1" value="Bar_Graph" > <!-- checked -->
                                        <label for="1" class="text-black"><?= Yii::app()->session['lang'] == 1?'Bar Graph':'กราฟแท่ง'; ?></label>
                                    </div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input type="checkbox" name="accommodation" id="2" value="Pie_Charts">
                                        <label for="2" class="text-black"><?= Yii::app()->session['lang'] == 1?'Pie Charts':'กราฟวงกลม'; ?> </label>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-3 col-md-3 col-xs-12">
                            <div><label for=""><?= Yii::app()->session['lang'] == 1?'Age range':'ช่วงอายุ'; ?></label></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control " placeholder="<?= Yii::app()->session['lang'] == 1?'low':'จาก'; ?>" name="" id="age" type="text" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control " placeholder="<?= Yii::app()->session['lang'] == 1?'high':'ถึง'; ?>" name="" id="age2" type="text" maxlength="50">
                                    </div>
                                </div>
                            </div>

                        </div>
                   <!--      <div class="row">
                           
                            <div class="col-md-3 col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">มหาวิทยาลัย</label>
                                    <input class="form-control " placeholder="มหาวิทยาลัย" name="" id="institution" type="text" maxlength="50">
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label><?= Yii::app()->session['lang'] == 1?'Datetime start':'ช่วงเวลาเริ่มต้น'; ?></label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="<?= Yii::app()->session['lang'] == 1?'Datetime start':'ช่วงเวลาเริ่มต้น'; ?>" type="text" name="" id="datetime_start">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label><?= Yii::app()->session['lang'] == 1?'Datetime end':'ช่วงเวลาสิ้นสุด'; ?></label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="<?= Yii::app()->session['lang'] == 1?'Datetime end':'ช่วงเวลาสิ้นสุด'; ?>" type="text" name="" id="datetime_end">
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for=""><?= Yii::app()->session['lang'] == 1?'Year start':'ช่วงปีเริ่มต้น'; ?></label>
                                    <select class="form-control year_start" name="" id="Year_start">
                                        <option value="" selected disabled><?= Yii::app()->session['lang'] == 1?'Year start':'ช่วงปีเริ่มต้น'; ?></option>
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
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for=""><?= Yii::app()->session['lang'] == 1?'Year end':'ช่วงปีสิ้นสุด'; ?></label>
                                    <select class="form-control year_end" name="" id="Year_end">
                                        <option value="" selected disabled><?= Yii::app()->session['lang'] == 1?'Year end':'ช่วงปีสิ้นสุด'; ?></option>
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
                            <button class="btn btn-reportsearch search" onclick="chk_form_search();"><i class="fas fa-search"></i> <?= Yii::app()->session['lang'] == 1?'Search':'ค้นหา'; ?> </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="divider">
            <i class="fas fa-chevron-down"></i>
        </div>
<li class="breadcrumb-item active" aria-current="page">
            <center>
                <h3>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                        echo " Register staff ship Report";
                    } else {
                        echo " รายงานภาพการสมัครสมาชิก คนประจำเรือ";
                    }
                    ?>
                </h3>    
            </center>
        </li>
         <div class="row">
                <div class="col-sm-6 col-md-6 Graph_1">
                        <div class="chart"></div>
                            <h4></h4>
                            <div style="width:100%">
                                <div id="chart_div" style="width: auto; height: 400px;"></div>
                            </div>
                </div>
                <div class="col-sm-6 col-md-6 Graph_2">
                        <div class="chart"></div>
                            <h4></h4>
                         <div style="width:100%">
                                <div id="chart_div2" style="width: auto; height: 400px;"></div>
                        </div>
                    </div>
 
            </div>

           <div class="row mt-2">
                <div class="col-sm-6 col-md-6 Graph_3">
                    <div class="chart"></div>
                        <div style="width:100%">
                            <div id="chart_div3" style="width: auto; height: 400px;"></div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 Graph_4">
                    <div class="chart"></div>
                     <div style="width:100%">
                            <div id="chart_div4" style="width: auto; height: 400px;"></div>
                    </div>
                </div>
            </div>
        <hr>   
        <div class="dataTable"></div>

    </div>

</section>

<script>
    $('.datetimepicker').datetimepicker({
        format: 'd-m-Y',
        step: 10,
        timepicker: false,
        timepickerScrollbar: false,
        yearOffset: 0
    });
    $.datetimepicker.setLocale('th');
    $('.Graph_1').hide();
    $('.Graph_2').hide();
    $('.Graph_3').hide();
    $('.Graph_4').hide();

$(document).ready(function(){
    $('#datetime_start').on('change',function(){
    $('#Year_start').attr('disabled',true);
    $('#Year_end').attr('disabled',true);
    });
    $('#datetime_end').on('change',function(){
    $('#Year_start').attr('disabled',true);
    $('#Year_end').attr('disabled',true);
    });
    $('#Year_start').on('change',function(){
    $('#datetime_start').attr('disabled',true);
    $('#datetime_end').attr('disabled',true);
    });
    $('#Year_end').on('change',function(){
    $('#datetime_start').attr('disabled',true);
    $('#datetime_end').attr('disabled',true);
    });
});

function chk_form_search(){
        var status_pass = 1;

        var start_year = $("#Year_start").val();
        var end_year = $("#Year_end").val();
        if(end_year != "" && start_year == ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงปีเริ่มต้น");
        //     $("#search_start_year").addClass('form-control-danger');
        // }else{
        //     $("#search_start_year").removeClass('form-control-danger');
         }
        if(end_year == "" && start_year != ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงปีสิ้นสุด");
        //     $("#search_end_year").addClass('form-control-danger');
        // }else{
        //     $("#search_end_year").removeClass('form-control-danger');
         }


        var start_date = $("#datetime_start").val();
        var end_date = $("#datetime_end").val();
        if(end_date != "" && start_date == ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงเวลาเริ่มต้น");
        //     $("#search_start_date").addClass('form-control-danger');
        // }else{
        //     $("#search_start_date").removeClass('form-control-danger');
         }
        if(end_date == "" && start_date != ""){
            status_pass =2;
            alert("กรุณาเลือกช่วงเวลาสิ้นสุด");
        //     $("#search_end_date").addClass('form-control-danger');
        // }else{
        //     $("#search_end_date").removeClass('form-control-danger');
        }

        if(status_pass == 1){
            $(".search").submit();
        }
    }

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
                    var Department = $(".Department").val();
                    var Position = $(".Position").val();
                    var age = $(".age").val();
                    var age2 = $(".age2").val();
                    //var institution = $("#institution").val();
                    var Chart = $('input[name="accommodation"]:checked').serialize();
                    var datetime_start = $("#datetime_start").val();
                    var datetime_end = $("#datetime_end").val();
                    var Year_start = $(".Year_start").val();
                    var Year_end = $(".Year_end").val();

                    var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                        if (Department == '' || Department === null) {
                            var DepartmentAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select Department type! ':'กรุณาเลือกประเภทฝ่ายพนักงาน!'; ?>";
                            swal(alert_message,DepartmentAlert)
                        return false; 
                    }


                    // var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                    // if (DepartmentAlert == ''|| Department === null) {
                    //     var Department = "<?php echo Yii::app()->session['lang'] == 1?'Please select Department type! ':' กรุณาเลือกประเภทฝ่ายพนักงาน!'; ?>";
                    //     swal(alert_message,DepartmentAlert) 
                    //     return false;
                    // }

                    // if (datetime_start === '' || datetime_start === null) {
                    //         var datetime_startAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a datetime start! ':'กรุณาเลือกช่วงเวลาเริ่มต้น!'; ?>";
                    //         swal(alert_message,datetime_startAlert)
                    //           return false;
                    //     }
                    
                        
                       
                    //         if (datetime_end === '' || datetime_end === null) {
                    //         var datetime_endAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a datetime end! ':'กรุณาเลือกช่วงเวลาสิ้นสุด!'; ?>";
                    //         swal(alert_message,datetime_endAlert)
                    //           return false;
                    //     }

                    //      if (year_start === '' || year_start === null) {
                    //         var year_startAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a Year start! ':'กรุณาเลือกช่วงปีเริ่มต้น!'; ?>";
                    //         swal(alert_message,year_startAlert)
                    //           return false;
                    //     }
                    

                      
                    //         if (year_end === '' || year_end === null) {
                    //             var year_endtAlert = "<?php echo Yii::app()->session['lang'] == 1?'Please select a Year end! ':'กรุณาเลือกช่วงปีสิ้นสุด!'; ?>";
                    //             swal(alert_message,year_endtAlert)
                    //               return false;
                    //         }
                               

                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('report/registershipData '); ?>",
                        data: {
                            Department: Department,
                            Position: Position,
                            age: age,
                            age2: age2,
                            //institution: institution,
                            Chart: Chart,
                            datetime_start: datetime_start,
                            datetime_end: datetime_end,
                            Year_start: Year_start,
                            Year_end: Year_end,
   
                        },
                        success: function(data) {
                        if (Chart != "") {
                        if (typeof Year_start === 'undefined' || typeof Year_end === 'undefined' || Year_start === null || Year_end === null) {
          
                            if (Chart === "accommodation=Bar_Graph") {
                      
                            $('.Graph_1').show();
                            $('.Graph_2').hide();
                            $('.Graph_3').hide();
                            $('.Graph_4').hide();

                            }else if (Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
                            $('.Graph_1').show();
                            $('.Graph_2').show();
                            $('.Graph_3').hide();
                            $('.Graph_4').hide();

                            }else if (Chart === "accommodation=Pie_Charts") {
                            $('.Graph_1').hide();
                            $('.Graph_2').show();
                            $('.Graph_3').hide();
                            $('.Graph_4').hide();
                      
                            }
                             }else{

                            if (Chart === "accommodation=Bar_Graph") {
                            $('.Graph_1').show();
                            $('.Graph_2').show();
                            $('.Graph_3').hide();
                            $('.Graph_4').hide();
                      
                            }else if (Chart === "accommodation=Bar_Graph&accommodation=Pie_Charts") {
                            $('.Graph_1').show();
                            $('.Graph_2').show();
                            $('.Graph_3').show();
                            $('.Graph_4').show();

                            }else if (Chart === "accommodation=Pie_Charts") {
                            $('.Graph_1').show();
                            $('.Graph_2').show();
                            $('.Graph_3').hide();
                            $('.Graph_4').hide();
                      
                            }
                            }
                        }
                           $(".dataTable").html(data);
                        }
        });
    });

</script>