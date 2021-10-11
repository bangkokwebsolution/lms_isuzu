<?php
$title = 'รายงานติดตามผู้เรียน';
$currentModel = 'Report';

$this->breadcrumbs = array($title);

// Yii::app()->clientScript->registerScript('search', "
//     $('#SearchFormAjax').submit(function(){
//         return true;
//     });
// ");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');

EOD
, CClientScript::POS_READY);
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/jquery.dataTables.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(function() {
       $(".chosen").chosen();
        $(".widget-body").css("overflow","");

        $("#Report_period_start").datepicker({
                onSelect: function(selected) {
                  $("#Report_period_end").datepicker("option","minDate", selected)
              }
          });
        $("#Report_period_end").datepicker({            
                onSelect: function(selected) {
                 $("#Report_period_start").datepicker("option","maxDate", selected)
             }
         });     

        endDate();
        startDate();


      $("#Report_type_register").change(function(){
            var value = $("#Report_type_register option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetdepartment"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_department").html(data);
                            $("#Report_position").html('<option value="">ทั้งหมด</option>');
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });
        $("#Report_department").change(function(){
            var value = $("#Report_department option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetposition"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_position").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });

        $("#Report_course_id").change(function(){
            var value = $("#Report_course_id option:selected").val();
            if(value != ""){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Passcours/ajaxgetgenid"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_gen_id").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
                 $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/Report/ajaxgetlesson"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_lesson_id").html(data);
                            $('.chosen').trigger("chosen:updated");
                        }
                    }
                });
            }
        });


    });

    function startDate() {
        $('#passcoursStartDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function() {
                $("#passcoursEndDateBtn").datepicker("option","minDate", this.value);
            },
        });
    }
    function endDate() {
        $('#passcoursEndDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
        });
    }

</script>
<div class="innerLR">
<?php

    $userModel = Users::model()->findByPk(Yii::app()->user->id);
    $state = Helpers::lib()->getStatePermission($userModel);

    if($state){
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelCourse = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    }

    $listCourse = CHtml::listData($modelCourse,'course_id','course_title');


    if($state){
        $modelLesson = Lesson::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelLesson = Lesson::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    }

    $listLesson = CHtml::listData($modelLesson,'id','title');



    $TypeEmployee = TypeEmployee::model()->findAll(array(
        'condition' => 'active = "y"',
        'order' => 'type_employee_name ASC'
    ));
    $listtype_user = CHtml::listData($TypeEmployee,'id','type_employee_name');



    $department = Department::model()->findAll(array(
        'condition' => 'active = "y"',
        'order' => 'dep_title ASC'
    ));
    $listdepartment = CHtml::listData($department,'id','dep_title');


    $position = Position::model()->findAll(array(
        'condition' => 'active = "y"',
        'order' => 'position_title ASC'
    ));
    $listposition = CHtml::listData($position,'id','position_title');

    if($_GET['Report']['course_id'] != ""){
        $arr_gen = CourseGeneration::model()->findAll(array(
            'condition' => 'course_id=:course_id AND active=:active ',
            'params' => array(':course_id'=>$_GET['Report']['course_id'], ':active'=>"y"),
            'order' => 'gen_title ASC',
        ));     

        if(empty($arr_gen)){
            $arr_gen[0] = "ไม่มีรุ่น";
        }else{
            $arr_gen = CHtml::listData($arr_gen,'gen_id','gen_title');
        }

    }else{
        $arr_gen[""] = "กรุณาเลือกหลักสูตร";
    }



    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'course_id','type'=>'list','query'=>$listCourse),            
            array('name'=>'gen_id','type'=>'list','query'=>$arr_gen),   
            array('name'=>'lesson_id','type'=>'list','query'=>$listLesson),
            array('name'=>'search','type'=>'text'),     
            // array('name'=>'type_register','type'=>'list','query'=>$listtype_user),
            // array('name'=>'department','type'=>'list','query'=>$listdepartment),
            // array('name'=>'position','type'=>'list','query'=>$listposition),            
            // array('name'=>'period_start','type'=>'text'),
            // array('name'=>'period_end','type'=>'text'),
    ),

    ));


    ?>
</div>
<?php 
if(!empty($_GET) && $_GET['Report']['course_id'] != null && $_GET['Report']['gen_id'] != null){ 

        $search = $_GET['Report'];


        $course_online = CourseOnline::model()->findByPk($search["course_id"]);

        $statusArray = array(
            'learning'=>'<b style="color: green;">กำลังเรียน</b>', 
            'pass' => '<b style="color: blue;">เรียนสำเร็จ</b>',
            'notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>'
        );


        $criteria = new CDbCriteria;
        $criteria->with = array('pro', 'course', 'mem');

        if(isset($_GET['Report']['search']) && $_GET['Report']['search'] != null){
            $ex_fullname = explode(" ", $_GET['Report']['search']);

            if(isset($ex_fullname[0])){
                $pro_fname = $ex_fullname[0];
                $criteria->compare('pro.firstname_en', $pro_fname, true);
                $criteria->compare('pro.lastname_en', $pro_fname, true, 'OR');

                $criteria->compare('pro.firstname', $pro_fname, true, 'OR');
                $criteria->compare('pro.lastname', $pro_fname, true, 'OR');
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                $criteria->compare('pro.lastname',$pro_lname,true);
                $criteria->compare('pro.lastname_en', $pro_lname, true, 'OR');
            }
        }   

        $criteria->compare('superuser',0);
        $criteria->addCondition('user.id IS NOT NULL');

        $criteria->compare('user.superuser', 0);

        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null) {
            $criteria->compare('t.course_id', $_GET['Report']['course_id']);
        }

        if(isset($_GET['Report']['gen_id']) && $_GET['Report']['gen_id'] != null) {
            $criteria->compare('t.gen_id', $_GET['Report']['gen_id']);
        }

        // if(isset($_GET['Report']['type_register']) && $_GET['Report']['type_register'] != null) {
        //     $criteria->compare('pro.type_employee', $_GET['Report']['type_register']);
        // }

        if(isset($_GET['Report']['department']) && $_GET['Report']['department'] != null) {
            $criteria->compare('user.department_id',$_GET['Report']['department']);
        }

        if(isset($_GET['Report']['position']) && $_GET['Report']['position'] != null) {
            $criteria->compare('user.position_id',$_GET['Report']['position']);
        }

        if(isset($_GET['Report']['period_start']) && $_GET['Report']['period_start'] != null) {
            $criteria->compare('start_date >= "' . date('Y-m-d 00:00:00', strtotime($_GET['Report']['period_start'])) . '"');
        }
        if(isset($_GET['Report']['period_end']) && $_GET['Report']['period_end'] != null) {
            $criteria->compare('start_date <= "' . date('Y-m-d 23:59:59', strtotime($_GET['Report']['period_end'])) . '"');
        }

        $user_Learn = LogStartcourse::model()->findAll($criteria);

        $user_chk = array();
        foreach ($user_Learn as $key => $val) {
            if($val->user_id != ""){
                $user_chk[] = $val->user_id;
            }
        }

        if(count($user_chk) == 0){
            $user_chk = array(0);
        } 

        $allUsers = User::model()->with('profile')->findAll(array(
            'condition' => 'status ="1" and user.id IN ('.implode(",", $user_chk).')',
            'order' => 'profile.firstname_en ASC'
        ));


        if(isset($_GET['Report']['lesson_id']) && $_GET['Report']['lesson_id'] != null) {

           $lesson_online = Lesson::model()->findAll("active='y' AND id='".$_GET['Report']['lesson_id']."' AND course_id='".$search["course_id"]."'");

       }else{
          $lesson_online = Lesson::model()->findAll(array(
            "condition"=>"active='y' AND lang_id='1' AND course_id='".$search["course_id"]."'",
            "order"=>"title ASC"
        ));
      }

        $gen_title = "";
        if($_GET['Report']['gen_id'] != 0){
            $gen_title = CourseGeneration::model()->findByPk($_GET['Report']['gen_id']);
            $gen_title = " รุ่น ".$gen_title->gen_title;
        }

?>


<div class="widget" id="export-table33">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table id="table_datatable" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th class="center" rowspan="2">ลำดับ</th>
                            <th class="center" rowspan="2">Name - Surname (EN)</th>
                            <th class="center" rowspan="2">Name - Surname (TH)</th>
                            <th class="center" rowspan="2">Work Location</th>
                            <th class="center" rowspan="2">Employee Class</th>
                            <th class="center" rowspan="2">Position desc.</th>
                            <th class="center" rowspan="2">Organization unit</th>
                            <th class="center" colspan="<?= count($lesson_online)+1 ?>">หลักสูตร <?= $course_online->course_title.$gen_title ?></th>
                            <th rowspan="2">Email ที่สมัคร</th>

                        </tr>
                        <tr>
                            <?php foreach($lesson_online as $lesson) { ?>
                                <th class="center"><?= $lesson->title ?></th>
                            <?php } ?>
                            <th class="center">Percent</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        if(!empty($allUsers)){
                            
                           $dataProvider=new CArrayDataProvider($allUsers, array(
                            'pagination'=>array(
                                'pageSize'=>25
                            ),
                        ));

                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }

                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                            if($dataProvider->getData()) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $user->profile->firstname_en . ' ' . $user->profile->lastname_en ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><center><?= $user->profile->location ?></center></td>
                                        <td><?= isset($user->profile->EmpClass->title) ? $user->profile->EmpClass->title :'' ?></td>
                                        <td><?= $user->profile->position_description ?></td>
                                        <td><?= $user->profile->organization_unit ?></td>
                                        <?php
                                           if($lesson_online) {
                                                foreach($lesson_online as $lesson) {
                                                    $statusLearn_course =  Helpers::lib()->chk_status_course($course_online->course_id, $_GET['Report']['gen_id'], $user->id);

                                                        ?>
                                                        <td class="center" <?php if($statusLearn_course != "learning"){ echo 'colspan="'.count($lesson_online).'"'; } ?>>
                                                            <?php 
                                                            if($statusLearn_course != "learning"){
                                                                echo $statusArray[$statusLearn_course];
                                                            }else{
                                                                $statusLearn_lesson =  Helpers::lib()->chk_status_lesson($lesson->id, $_GET['Report']['gen_id'], $user->id);
                                                                echo $statusArray[$statusLearn_lesson];
                                                            }
                                                             ?>
                                                        </td>
                                                        <?php
                                                        if($statusLearn_course != "learning"){
                                                            break;
                                                        }
                                                }
                                           }
                                        ?>
                                        <td class="center">
                                            <?php 
                                            if($statusLearn_course != "pass"){
                                                echo Helpers::lib()->percent_CourseGen($course_online->course_id, $_GET['Report']['gen_id'], $user->id)." %"; 
                                            }else{
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td><?= $user->email ?></td>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <strong>ไม่พบข้อมูล</strong>
                                </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <br>
                <br>
                <br>
                <?php 
                $this->widget('CLinkPager',array(
                    'pages'=>$dataProvider->pagination
                ));
                ?>
                <br>
                <br>
                <a href="<?= $this->createUrl('report/GenExcelByUser',array(
                'Report[course_id]'=>$_GET['Report']['course_id'],
                'Report[gen_id]'=>$_GET['Report']['gen_id'],
                'Report[lesson_id]'=>$_GET['Report']['lesson_id'],
                'Report[search]'=>$_GET['Report']['search'],
                'Report[type_register]'=>$_GET['Report']['type_register'],
                'Report[department]'=>$_GET['Report']['department'],
                'Report[position]'=>$_GET['Report']['position'],
                'Report[period_start]'=>$_GET['Report']['period_start'],
                'Report[period_end]'=>$_GET['Report']['period_end']
                )); ?>" 
                target="_blank">
                <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a>
            </div>
        </div>
    </div>
</div>
        <?php }else{ ?>
            <div class="innerLR">
            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                    </div>
                    <div class="widget-body">

                        <h3 class="text-success">กรุณาป้อนข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3>

                    </div>
                </div>
                </div>
        <?php 
    }  
}
?>
<script type="text/javascript">
    $('#table_datatable').DataTable({
                   "searching": true,
                });
</script>