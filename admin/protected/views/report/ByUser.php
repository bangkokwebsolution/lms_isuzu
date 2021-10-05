<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.js"></script>
<!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.css" />
<?php
$titleName = 'ปัญหาการใช้งาน';
$formNameModel = 'ReportProblem';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
    $('#SearchFormAjax').submit(function(){
        $.fn.yiiGridView.update('$formNameModel-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    $('#export').click(function(){
        window.location = '". $this->createUrl('//report/ByUser')  . "?' + '&export=true';
        return false;
    });
");


Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $.updateGridView = function(gridID, name, value) {
        $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
        $.fn.yiiGridView.update(gridID, {data: $.param(
            $("#"+gridID+" input, #"+gridID+" .filters select")
        )});
    }
    $.appendFilter = function(name, varName) {
        var val = eval("$."+varName);
        $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
    }
    $.appendFilter("ReportProblem[news_per_page]", "news_per_page");

    $('#ReportProblem_report_date').attr('readonly','readonly');
    $('#ReportProblem_report_date').css('cursor','pointer');
    $('#ReportProblem_report_date').datepicker();
EOD
, CClientScript::POS_READY);
// var_dump(Yii::app()->createUrl('sssssss'));exit();
?>
<div class="innerLR">
    <?php $typeStatus = [""=>'ทั้งหมด','success'=>'ตอบกลับแล้ว','eject'=>'ยกเลิก','wait'=>'ยังไม่ได้ตอบ'] ?>
    <div class="widget"  >
        <div class="widget-head">
            <h4 class="heading  glyphicons search"><i></i>ค้นหา</h4>
            <span class="collapse-toggle"></span></div>
            <div class="widget-body of-out in collapse" style="height: auto;">
                <div class="search-form">
                    <div class="wide form" style="padding-top:6px;">
                        <form id="SearchFormAjax" action="<?= Yii::app()->createUrl('Report/ByUser'); ?>" method="get"><div class="row">
                            <label>ชื่อ</label>
                            <input class="span6" autocomplete="off" name="ReportProblem[firstname]" id="ReportProblem_firstname" type="text" maxlength="255"></div>
                            <div class="row">
                                <label>วันที่ส่งปัญหา</label>
                                <input class="span6" autocomplete="off" name="ReportProblem[report_date]" id="ReportProblem_report_date" type="text" readonly="readonly" >
                            </div>
                            <div class="row"><label>Status</label>
                                <select class="span6 chosen" name="ReportProblem[status]" id="ReportProblem_status">
                                    <?php 
                                    foreach ($typeStatus as $keyS => $valueS) { ?>
                                        <option value="<?= $keyS ?>"><?= $valueS ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary mt-10 btn-icon glyphicons search"><i></i> ค้นหา</button>
                            </div>
                        </form>                    
                    </div>
                </div>
            </div>
        </div>

     <div class="widget" id="export-table33" >
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title ?></h4>
                </div>
            </div> 
          
            <div class="widget-body">
               <!--  <div class="search-datacustom" id="table_datatable_filter">
                   <input type="search" class="" placeholder="Search" aria-controls="table_datatable">
                 </div> -->
                <table id="table_datatable" class="table table-bordered table-striped">
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
                        $AllProblem = ReportProblem::model()->findAll();
                        $dataProvider=new CArrayDataProvider($AllProblem, array(
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
                                        <td><?= $start_cnt+1?></td>
                                        <td><?= $Problem->firstname.' '.$Problem->lastname ?></td>
                                        <td><?= $Problem->email ?></td>
                                        <td><?= $Problem->usa->usa_title ?></td>
                                        <td><?= $Problem->course->course_title ?></td>
                                        <td><?= UHtml::markSearch($Problem,"report_detail") ?></td>
                                        <td><?= Helpers::changeFormatDate($Problem->report_date,'datetime') ?></td>
                                        <td><?= $Problem->tel ?></td>
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
</div>

<script>
                // $('#example').dataTable( {
                //     "sScrollY": "300px",
                //     "sScrollX": "100%",
                //     "sScrollXInner": "150%",
                //     "bScrollCollapse": true,
                //     "bPaginate": false,
                //     "aaSortingFixed": [ [1, 'asc'] ],
                //     "aoColumnDefs": [
                //         { "bVisible": false, "aTargets": [1] }
                //     ]
                // }
    $('#table_datatable').DataTable({
                   "searching": true,
                });

    function sendMsg(id){
      swal({
        title: "ส่งข้อความ",
        //text: "ระบุข้อความ",
        type: "input",
        confirmButtonColor: "#DD6B55",
        showCancelButton: true,
                //allowEnterKey: true,
                closeOnConfirm: false,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก",
                animation: "slide-from-top",
                inputPlaceholder: "ข้อความ"
              },
              function(inputValue){
                if (inputValue === false) 
                  {return false;
                  } else {
                   swal({
                    title: "โปรดรอสักครู่",
                    text: "ระบบกำลังตรวจสอบ",
                    type: "info",
                    //confirmButtonText: "ตกลง",
                    showConfirmButton: false
                  });
       
                   $.ajax({
                    type: "POST",
                    url: '<?php echo $this->createUrl('reportProblem/sendMailMessage'); ?>',
                    data: {
                        inputValue: inputValue,
                        id: id
                    },
                    success: function (data) {

                    if (data === 'y') {
                      swal({
                        type: "success",
                        title: "ระบบ",
                        text: "ทำรายการสำเร็จ",
                        timer: 500,
                         },
                    function() {
                      setTimeout(function(){
                        location.reload();
                      },500);
                    }
                    );
                    }else{
                        swal({
                        type: "error",
                        title: "ระบบ",
                        text: "ทำรายการตอบปัญหาไม่สำเร็จ",
                        timer: 500,
                         },
                             function() {
                      setTimeout(function(){
                        location.reload();
                      },500);
                    }
                    );
                    }
                    },
                  });
                 }
               });
    }
</script>

