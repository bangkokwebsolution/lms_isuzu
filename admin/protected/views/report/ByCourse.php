
<?php
$title = 'ค้นหาโดยใช้หลักสูตร';
$currentModel = 'Report';

ob_start();

$this->breadcrumbs = array($title);

// Yii::app()->clientScript->registerScript('search', "
// 	$('#SearchFormAjax').submit(function(){
// 	    return true;
// 	});
// ");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');

EOD
, CClientScript::POS_READY);
?>
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
            array('name'=>'search','type'=>'text'),     
            array('name'=>'type_register','type'=>'list','query'=>$listtype_user),
            array('name'=>'department','type'=>'list','query'=>$listdepartment),
            array('name'=>'position','type'=>'list','query'=>$listposition),            
            array('name'=>'period_start','type'=>'text'),
            array('name'=>'period_end','type'=>'text'),
    ),

    ));


    ?>

	</div>
    <?php
    if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null && $_GET['Report']['gen_id'] != null){

        $search = $_GET['Report'];

        // var_dump($search); exit();

        // $textsearch = "";

        // // if($search['search'] != ""){
        //     $search_text = explode(" ",$search['search']);
        //     $textsearch .= "(";
        //     if(isset($search_text[0])){
        //         $textsearch .= " ( firstname LIKE '%" . trim($search_text[0]) . "%' OR firstname_en LIKE '%" . trim($search_text[0]) . "%' ) ";
        //     }
        //     if(isset($search_text[1])){
        //         $textsearch .= " AND ( lastname LIKE '%" . trim($search_text[1]) . "%' OR lastname_en LIKE '%" . trim($search_text[1]) . "%' ) ";
        //     }
        //     $textsearch .= ")";
        // // }

        // if($search['type_register'] != ""){
        //     $textsearch .= " AND profile.type_employee='".$search['type_register']."'";
        // }

        // if($search['department'] != ""){
        //     $textsearch .= " AND department_id='".$search['department']."'";
        // }

        // if($search['position'] != ""){
        //     $textsearch .= " AND position_id='".$search['position']."'";
        // }


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

                        if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null) {
                            $criteria->compare('t.course_id', $_GET['Report']['course_id']);
                        }

                        if(isset($_GET['Report']['gen_id']) && $_GET['Report']['gen_id'] != null) {
                            $criteria->compare('t.gen_id', $_GET['Report']['gen_id']);
                        }

                        if(isset($_GET['Report']['type_register']) && $_GET['Report']['type_register'] != null) {
                            $criteria->compare('pro.type_employee', $_GET['Report']['type_register']);
                        }

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

                        // $criteria->order = 'pro.type_employee ASC, pro.firstname_en ASC';
                        $user_Learn = LogStartcourse::model()->findAll($criteria);

                        // var_dump($user_Learn); exit();


                        $user_chk = array();
                        foreach ($user_Learn as $key => $val) {
                            $user_chk[] = $val->user_id;
                        }

                        if(count($user_chk) == 0){
                            $user_chk = array(0);
                        } 

                        $allUsers = User::model()->with('profile')->findAll(array(
                            'condition' => 'status ="1" and user.id IN ('.implode(",",$user_chk).')',
                            'order' => 'profile.firstname_en ASC'
                        ));

    ?>


<?php if(1 == 2){  // export PDF มั้งนะ  ?>
        <!-- <div class="widget hidden" id="export-table" style=" overflow-x: scroll;">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ประเภทพนักงาน</th>                            
                            <th>Name - Surname</th>
                            <th>แผนก/ฝ่าย</th>
                            <th>ตำแหน่ง/แผนก</th>
                            <th class="center">หลักสูตร</th>
                            <th class="center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
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


                            $gen_title = "";
                            if($_GET['Report']['gen_id'] != 0){
                                $gen_title = CourseGeneration::model()->findByPk($_GET['Report']['gen_id']);
                                $gen_title = " รุ่น ".$gen_title->gen_title;
                            }

                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {

                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1?></td>
                                        <td><?= $user->profile->typeEmployee->type_employee_name; ?></td>
                                        <td><?= $user->profile->firstname_en . ' ' . $user->profile->lastname_en ?></td>
                                        <td><?= $user->department->dep_title ?></td>
                                        <td><?= $user->position->position_title ?></td>
                                        <td class="center"><?= $course_online->course_title.$gen_title ?></td>

                                        <?php
                                           if($course_online) {
                                                // foreach($course_online as $course) {
                                                    // $statusLearn = Learn::model()->with('les')->find(array(
                                                    //     'condition' => 'user_id ="'.$user['id'].'" and learn.course_id ="'. $course_online->course_id .'"' . $startdate . $enddate . $startdate_schedule .$enddate_schedule,
                                                    //     'alias' => 'learn'
                                                    // ));
                                            $passcourse = Passcours::model()->find("passcours_cours='".$_GET['Report']['course_id']."' AND passcours_user='".$user->id."' AND gen_id='".$_GET['Report']['gen_id']."' ");
                                            if($passcourse != ""){
                                                $statusLearn = "pass";
                                            }else{
                                                $statusLearn = Learn::model()->findAll(array(
                                                    'condition' => 'user_id ="'.$user->id.'" and course_id ="'. $_GET['Report']['course_id'] .'" AND gen_id="'.$_GET['Report']['gen_id'].'"' ,
                                                ));
                                                if(!empty($statusLearn)){
                                                    $statusLearn = "learning";
                                                }else{
                                                    $statusLearn = "notlearn"; 
                                                }
                                            }

                                                
                                                    ?>
                                                    <td class="center">
                                                        <?= $statusArray[$statusLearn]?>
                                                        <?php 
                                                        if($statusLearn == "learning"){
                                                            echo Helpers::lib()->percent_CourseGen($course_online->course_id, $_GET['Report']['gen_id'], $user->id)." %";
                                                        }
                                                         ?>
                                                    </td>
                                                    <?php
                                                // }
                                           }
                                        ?>



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
        </div>  -->
<?php } ?>



<!-- โชว์ตารางตรงด้านล่างนี้น้าาาาาาาาาาาาาาาา -->

        <div class="widget" id="export-table33" style=" overflow-x: scroll;">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title ?></h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                           <th>ลำดับ</th>
                            <th>ประเภทพนักงาน</th>                            
                            <th>Name - Surname</th>
                            <th>แผนก/ฝ่าย</th>
                            <th>ตำแหน่ง/แผนก</th>
                            <th class="center">หลักสูตร</th>
                            <th class="center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                     //    $criteria = new CDbCriteria;
                     //    $criteria->with = array('Profiles', 'CourseOnlines', 'user');

                     //    if(isset($_GET['Report']['search']) && $_GET['Report']['search'] != null){
                     //        $ex_fullname = explode(" ", $_GET['Report']['search']);

                     //        if(isset($ex_fullname[0])){
                     //            $pro_fname = $ex_fullname[0];
                     //            $criteria->compare('Profiles.firstname_en', $pro_fname, true);
                     //            $criteria->compare('Profiles.lastname_en', $pro_fname, true, 'OR');

                     //            $criteria->compare('Profiles.firstname', $pro_fname, true, 'OR');
                     //            $criteria->compare('Profiles.lastname', $pro_fname, true, 'OR');
                     //        }

                     //        if(isset($ex_fullname[1])){
                     //            $pro_lname = $ex_fullname[1];
                     //            $criteria->compare('Profiles.lastname',$pro_lname,true);
                     //            $criteria->compare('Profiles.lastname_en', $pro_lname, true, 'OR');
                     //        }
                     //    }

                     //    if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] != null) {
                     //        $criteria->compare('passcours_cours', $_GET['Report']['course_id']);
                     //    }

                     //    if(isset($_GET['Report']['type_register']) && $_GET['Report']['type_register'] != null) {
                     //        $criteria->compare('Profiles.type_employee', $_GET['Report']['type_register']);
                     //    }

                     //    if(isset($_GET['Report']['department']) && $_GET['Report']['department'] != null) {
                     //        $criteria->compare('user.department_id',$_GET['Report']['department']);
                     //    }

                     //    if(isset($_GET['Report']['position']) && $_GET['Report']['position'] != null) {
                     //        $criteria->compare('user.position_id',$_GET['Report']['position']);
                     //    }

                     //    if(isset($_GET['Report']['period_start']) && $_GET['Report']['period_start'] != null) {
                     //        $criteria->compare('passcours_date >= "' . date('Y-m-d 00:00:00', strtotime($_GET['Report']['period_start'])) . '"');
                     //    }
                     //    if(isset($_GET['Report']['period_end']) && $_GET['Report']['period_end'] != null) {
                     //        $criteria->compare('passcours_date <= "' . date('Y-m-d 23:59:59', strtotime($_GET['Report']['period_end'])) . '"');
                     //    }

                     //    $criteria->order = 'Profiles.type_employee ASC, Profiles.firstname_en ASC';
                     //    $user_Learn = Passcours::model()->findAll($criteria);



                     //     $user_chk = array();
                     //     foreach ($user_Learn as $key => $val) {

                     //          $user_chk[] = $val->passcours_user;
                     //     }
                     //     if(count($user_chk) == 0){
                     //         $user_chk = array(0);
                     //    } 

                     //    if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){
                     //        $allUsers = User::model()->with('profile')->findAll(array(
                     //            'condition' => 'status ="1" and user.id IN ('.implode(",",$user_chk).')'  . $gen . $textsearch.$texttype,
                     //        ));
                     //    }else{
                     //     $allUsers = User::model()->with('profile')->findAll(array(
                     //        'condition' => 'status ="1"' . $gen . $textsearch .$texttype,
                     //    ));
                     // }

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

                            $gen_title = "";
                            if($_GET['Report']['gen_id'] != 0){
                                $gen_title = CourseGeneration::model()->findByPk($_GET['Report']['gen_id']);
                                $gen_title = " รุ่น ".$gen_title->gen_title;
                            }

                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {

                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1?></td>
                                        <td><?= $user->profile->typeEmployee->type_employee_name; ?></td>
                                        <td><?= $user->profile->firstname_en . ' ' . $user->profile->lastname_en ?></td>
                                        <td><?= $user->department->dep_title ?></td>
                                        <td><?= $user->position->position_title ?></td>
                                        <td class="center"><?= $course_online->course_title.$gen_title ?></td>
                                        <?php
                                           if($course_online) {
                                                // foreach($course_online as $course) {
                                                    // $statusLearn = Learn::model()->with('les')->find(array(
                                                    //     'condition' => 'user_id ="'.$user['id'].'" and learn.course_id ="'. $course_online->course_id .'"' . $startdate . $enddate . $startdate_schedule.$enddate_schedule,
                                                    //     'alias' => 'learn'
                                                    // ));

                                            // $passcourse = Passcours::model()->find("passcours_cours='".$_GET['Report']['course_id']."' AND passcours_user='".$user->id."' AND gen_id='".$_GET['Report']['gen_id']."' ");
                                            // if($passcourse != ""){
                                            //     $statusLearn = "pass";
                                            // }else{
                                            //     $statusLearn = Learn::model()->findAll(array(
                                            //         'condition' => 'user_id ="'.$user->id.'" and course_id ="'. $_GET['Report']['course_id'] .'" AND gen_id="'.$_GET['Report']['gen_id'].'"' ,
                                            //     ));
                                            //     if(!empty($statusLearn)){
                                            //         $statusLearn = "learning";
                                            //     }else{
                                            //         $statusLearn = "notlearn"; 
                                            //     }
                                            // }

                                            $statusLearn =  Helpers::lib()->chk_status_course($course_online->course_id, $_GET['Report']['gen_id'], $user->id);

                                                    ?>
                                        <td class="center">
                                         <?= $statusArray[$statusLearn]?>
                                         <?php 
                                         if($statusLearn == "learning"){
                                            echo Helpers::lib()->percent_CourseGen($course_online->course_id, $_GET['Report']['gen_id'], $user->id)." %";
                                        }
                                        ?>
                                        </td>
                                                    <?php   //if(isset($_GET['Report']['course_id']) && $_GET['Report']['course_id'] !=''){ ?>
                                        <!-- <td class="center">
                                            <?= $statusLearn['learn_date']; ?>
                                        </td> -->
                                                 <?php //} ?>

                                                    <?php
                                                // }
                                           }
                                        ?>
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
                <?php 
                    // $this->widget('CLinkPager',array(
                    //                 'pages'=>$dataProvider->pagination
                    //                 )
                    //             );
                ?>
            </div>
        </div>
        <?php 
        $this->widget('CLinkPager',array(
            'pages'=>$dataProvider->pagination
        )
    );
    ?>




        <div class="widget-body">
            <br>
            <br>
            <br>
            <a href="<?= $this->createUrl('report/genExcelByCourse',array(
            'Report[course_id]'=>$_GET['Report']['course_id'],
            'Report[gen_id]'=>$_GET['Report']['gen_id'],
            'Report[search]'=>$_GET['Report']['search'],
            'Report[type_register]'=>$_GET['Report']['type_register'],
            'Report[department]'=>$_GET['Report']['department'],
            'Report[position]'=>$_GET['Report']['position'],
            'Report[period_start]'=>$_GET['Report']['period_start'],
            'Report[period_end]'=>$_GET['Report']['period_end']
            )); ?>" 
            target="_blank">
		    <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button></a>


            <!-- <a href="<?= $this->createUrl('report/genPdfByCourse',array('ByCourse[generation]'=>$_GET['ByCourse']['generation'],'ByCourse[course_id]'=>$_GET['ByCourse']['course_id'],'ByCourse[search]'=>$_GET['ByCourse']['search'],'ByCourse[period_start]'=>$_GET['ByCourse']['period_start'],'ByCourse[period_end]'=>$_GET['ByCourse']['period_end'])); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a> -->

            <!-- <a href="<?= $this->createUrl('report/genPdfByCourse',array(
            'Report[generation]'=>$_GET['Report']['generation'],
            'Report[course_id]'=>$_GET['Report']['course_id'],
            'Report[search]'=>$_GET['Report']['search'],
            'Report[period_start]'=>$_GET['Report']['period_start'],

            'Report[type_user]'=>$_GET['Report']['type_user'],
            'Report[schedule_id]'=>$_GET['Report']['schedule_id'],
            'Report[division_id]'=>$_GET['Report']['division_id'],
            'Report[department]'=>$_GET['Report']['department'],
            'Report[station]'=>$_GET['Report']['station'],

            'Report[period_end]'=>$_GET['Report']['period_end'])); ?>" 
            target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i>ExportPDF</a> -->
             <!-- <button type="button" id="btnExportPdf" class="btn btn-primary btn-icon glyphicons file"> <i></i>ExportPDF</button> -->
	    </div>



    <?php } ?>

</div>


<script type="text/javascript">

    var x =  '<h2>'+'<?php echo $title; ?>'+'</h2>'+$('#export-table').html();
    $("#btnExportPdf").click(function() {
        $.ajax({
  url: "<?= Yii::app()->createUrl('report/genpdf'); ?>",
  type: "POST",
  data: {param:x},
  success: function(data){
    // alert(data);
  },
});
    });
</script>