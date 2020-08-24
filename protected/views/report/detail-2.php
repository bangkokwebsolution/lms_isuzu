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
                                    <label for="">หลักสูตร</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>เลือกหลักสูตร</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">รุ่น</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>เลือกรุ่น</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div><label>รูปแบบกราฟแสดงผล</label></div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input type="checkbox" name="accommodation" id="1" value="Bar Graph">
                                        <label for="1" class="text-black">Bar Graph </label>
                                    </div>
                                    <div class="checkbox checkbox-main checkbox-inline">
                                        <input type="checkbox" name="accommodation" id="2" value="Pie Charts">
                                        <label for="2" class="text-black">Pie Charts </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ประเภทพนังกาน</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>เลือกประเภทพนังกาน</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ฝ่าย</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>เลือกฝ่าย</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">แผนก</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>เลือกแผนก</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">เลเวล</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>เลือกเลเวล</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                        
                          
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label>ช่วงเวลาเริ่มต้น</label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="ช่วงเวลาเริ่มต้น" type="text" name="" id="">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group day-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <label>ช่วงเวลาสิ้นสุด</label>
                                    <input class="form-control datetimepicker" autocomplete="off" placeholder="ช่วงเวลาสิ้นสุด" type="text" name="" id="">
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ช่วงปีเริ่มต้น</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>ช่วงปีเริ่มต้น</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">ช่วงปีสิ้นสุด</label>
                                    <select class="form-control" name="" id="x">
                                        <option value="" selected disabled>ช่วงปีสิ้นสุด</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-reportsearch"><i class="fas fa-search"></i> ค้นหา </button>
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
                <div class="year-report">
                    <h4>ปี 2019</h4>
                    
                
                </div>
            </div>
            <div class="col-sm-6">
                <div class="year-report">
                    <h4>ปี 2020</h4>
                    

                </div>
            </div>
        </div>
        <h2 class="text-center">
            <?php
            if (Yii::app()->session['lang'] == 1) {
                echo "Report";
            } else {
                echo "รายงานภาพ";
            }
            ?>
        </h2>

        <div class="report-table">
            <div class="table-responsive w-100 t-regis-language">
                <table class="table">
                    <thead>
                        <tr>
                            <th>หลักสูตร</th>
                            <th>ผลสอบ Pre-test</th>
                            <th>ผลสอบ Post-test</th>
                            <th>คิดเป็นร้อยละ</th>
                            <th>ค่าเฉลี่ย Post-test</th>
                            <th>ร้อยละค่าเฉลี่ยผลการสอบ</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td></td>
                            <td><span class="text-success"><i class="fas fa-check"></i> สอบผ่าน</span>(xxx คน) <span class="text-danger"><i class="fas fa-times"></i> อนุมัติ</span>(xxx คน)</td>
                            <td><span class="text-success"><i class="fas fa-check"></i> สอบผ่าน</span>(xxx คน) <span class="text-danger"><i class="fas fa-times"></i> อนุมัติ</span>(xxx คน)</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="pull-right ">
            <button class="btn btn-pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
            <button class="btn btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
        </div>

    </div>
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
</script>