<?php
$title = 'รายงานการฝึกอบรมหลักสูตร';
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


      $("#Report_type").change(function(){
            var value = $("#Report_type option:selected").val();
            if(value != ""){
                // alert(value);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/CourseType/ajaxGetCategory"); ?>',
                    data: ({
                        value: value,
                    }),
                    success: function(data) {
                        if(data != ""){
                            $("#Report_course_id").html(data);
                            // $("#Report_position").html('<option value="">ทั้งหมด</option>');
                            // $('.chosen').trigger("chosen:updated");
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
        $modelType = CourseType::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelType = CourseType::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND created_by = "'.$userModel->id.'"'));
    }

    if($state){
        $modelCategory = Category::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    }else{
        $modelCategory = Category::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1 AND create_by = "'.$userModel->id.'"'));
    }

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



    // $this->widget('AdvanceSearchForm', array(
    //     'data'=>$model,
    //     'route' => $this->route,
    //     'attributes'=>array(
    //         array('name'=>'course_id','type'=>'list','query'=>$listCourse),            
    //         array('name'=>'gen_id','type'=>'list','query'=>$arr_gen),   
    //         array('name'=>'lesson_id','type'=>'list','query'=>$listLesson),
    //         array('name'=>'search','type'=>'text'),     
            
    // ),

    // ));


    ?>
    <div class="widget">

        <div class="widget-head">
            <h4 class="heading glyphicons search">
                <i></i> ค้นหา:
            </h4>
        </div>
        <?php 
            $form = $this->beginWidget('CActiveForm',
                array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                )
            ); 
        ?>
        <div class="widget-body">
            <dl class="dl-horizontal">

                <div class="form-group">
                    <dt><label>ประเภทหลักสูตร : </label></dt>
                    <dd>
                        <select name="Report[Report_type]" id="Report_type"   style="width: 50%;"  required="">
                            <option value="">กรุณาเลือกประเภทหลักสูตร</option>
                            <?php 
                        // if(isset($_GET['Report']['category']) && $_GET['Report']['category'] != ""){
                        //     $course_model = CourseOnline::model()->findAll(array(
                        //         'select'=>'course_id, course_title',
                        //         'condition'=>'active="y" AND lang_id="1" AND cate_id="'.$_GET['Report']['category'].'"',
                        //         'order'=>'course_title ASC'
                        //     ));

                            foreach ($modelType as $key => $val) {
                                ?>
                                <option <?php if(isset($_GET['Report']['type']) && $_GET['Report']['type'] != "" && $_GET['Report']['type'] == $val->type_id){ echo "selected"; } ?> value="<?= $val->type_id ?>" >
                                    <?= $val->type_name ?>                                
                                </option>
                                <?php
                            }
                        // }
                            ?>
                        </select>
                    </dd>
                </div>

                <div class="form-group">
                    <dt><label>หมวดหมู่หลักสูตร : </label></dt>
                    <dd>
                        <select name="Report[category]" id="Report_course_id"  style="width: 50%;"  required="">
                            <option value="">กรุณาเลือกหมวดหมู่หลักสูตร</option>
                            <?php 
                        // if(isset($_GET['Report']['category']) && $_GET['Report']['category'] != ""){
                        //     $course_model = CourseOnline::model()->findAll(array(
                        //         'select'=>'course_id, course_title',
                        //         'condition'=>'active="y" AND lang_id="1" AND cate_id="'.$_GET['Report']['category'].'"',
                        //         'order'=>'course_title ASC'
                        //     ));

                            foreach ($modelCategory as $key => $val) {
                                ?>
                                <option <?php if(isset($_GET['Report']['category']) && $_GET['Report']['category'] != "" && $_GET['Report']['category'] == $val->cate_id){ echo "selected"; } ?> value="<?= $val->cate_id ?>" >
                                    <?= $val->cate_title ?>                                
                                </option>
                                <?php
                            }
                        // }
                            ?>
                        </select>
                    </dd>
                </div>


                <!-- <div class="form-group">
                    <dt><label>Gen : </label></dt>
                    <dd>
                        <select name="Report[gen_id]" id="Report_gen_id"  style="width: 50%;" >
                            <option value="">All</option>
                            <?php
                            if(isset($_GET['Report']['course']) && $_GET['Report']['course'] != ""){


                                foreach ($arr_gen as $key => $val) {
                                    ?>
                                    <option <?php if(isset($_GET['Report']['gen_id']) && $_GET['Report']['gen_id'] != "" && $_GET['Report']['gen_id'] == $val->gen_id){ echo "selected"; } ?> value="<?= $val->gen_id ?>" >
                                        <?= $val->gen_title ?>                                
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </dd>
                </div>


                <div class="form-group">
                <dt><label>Name : </label></dt>
                <dd>
                    <input type="text" name="Report[name]" style="width: 50%;" value="<?php if(isset($_GET['Report']['name']) && $_GET['Report']['name'] != ""){ echo $_GET['Report']['name']; } ?>">
                </dd>
                </div> -->

            <div class="form-group">
                <dt></dt>
                <dd>
                    <button type="submit" class="btn btn-primary btn-icon glyphicons search">
                        <i></i> Search
                    </button>
                </dd>
            </div>

            </dl>
        </div>
    <?php $this->endWidget(); ?>
</div><!--innerLR-->
<?php 
if(isset($_GET['Report'])){
    $report = $_GET['Report'];

    $criteria = new CDbCriteria;
    $criteria->with = array('courseonlines', 'courseonlines.usercreate', 'courseonlines.cates');

    // // $criteria->select = 'pro, user';
    $criteria->compare('categorys.active', "y");
    $criteria->compare('courseonline.active', "y");
    $criteria->compare('lesson.active', "y");

    $criteria->compare('categorys.lang_id', 1);
    $criteria->compare('courseonline.lang_id', 1);
    $criteria->compare('lesson.lang_id', 1);

    // $criteria->addCondition('id > 11');     // user test
    // $criteria->addCondition('id != 386');   // user test

    // if($report["department"] != ""){        
    //     $criteria->compare('user.department_id', $report["department"]);
    // }

    // if($report["employee_status"] != ""){        
    //     $criteria->compare('user.del_status', $report["employee_status"]);
    // }

    if($report["category"] != ""){        
        $criteria->compare('courseonline.cate_id', $report["category"]);
    }

    if($report["course"] != ""){        
        $criteria->compare('courseonline.course_id', $report["course"]);
    }

    if($report["lesson"] != ""){        
        $criteria->compare('lesson.id', $report["lesson"]);
    }

    if($report["start_date"] != "" && $report["end_date"] != ""){
        $criteria->addCondition("lesson.create_date>='".$report["start_date"]." 00:00:00"."'");
        $criteria->addCondition("lesson.create_date<='".$report["end_date"]." 23:59:59"."'");
    }

    $criteria->order = "categorys.cate_title ASC, courseonline.course_title ASC, lesson.title ASC";
    $model_result = Lesson::model()->findAll($criteria);
    $model_count = count($model_result);

    // var_dump($model_result); exit();
?>
</div>

        <div class="widget" id="export-table">
            <div class="widget-head">
                <div class="widget-head"></div>
            </div> 

            <div class="widget-body div-table" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped" id="table_datatable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Minor Course Type</th>
                            <th>Course Group</th>
                            <th>Course Number</th>
                            <th>Course Name</th>
                            <th>Lesson Number</th>
                            <th>Lesson</th>
                            <th>Course Created Date</th>
                            <th>Course Created By</th>
                            <th>Lasted Edit Date</th>
                            <th>Lasted Edit by</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <?php

                        $dataProvider = new CArrayDataProvider($model_result, array(
                            'pagination'=>array(
                                'pageSize'=>400
                            ),
                        ));

                        $getPages = $_GET['page'];
                        if($getPages = $_GET['page']!=0 ){
                            $getPages = $_GET['page'] -1;
                        }

                        $start_cnt = $dataProvider->pagination->pageSize * $getPages;

                            if($dataProvider->getData()) {
                                foreach($dataProvider->getData() as $i => $list) {
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $list->courseonlines->cates->type->type_name ?></td>
                                        <td><?= $list->courseonlines->cates->cate_title ?></td>
                                        <td><?= $list->courseonlines->course_number ?></td>
                                        <td><?= $list->courseonlines->course_title ?></td>
                                        <td><?= $list->lesson_number ?></td>
                                        <td><?= $list->title ?></td>
                                        <td><?= date("d-M-Y", strtotime($list->courseonlines->create_date)) ?></td>
                                        <td><?= $list->courseonlines->usercreate->employee_id ?></td>
                                        <td><?= date("d-M-Y", strtotime($list->courseonlines->update_date)) ?></td>
                                        <td><?= $list->courseonlines->userupdate->employee_id ?></td>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="200"><strong>ไม่พบข้อมูล</strong></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                *หากต้องการดูรายละเอียดกรุณากด Export Excel
            </div>
        </div>
       
<?php }  ?>


<?php if($model_count > 0){ ?>

<a href="<?= $this->createUrl('Report/ExcelCourseReport', array(
'Report[start_date]'=>$report["start_date"],
'Report[end_date]'=>$report["end_date"],
'Report[category]'=>$report["category"],
'Report[course]'=>$report["course"],
'Report[lesson]'=>$report["lesson"]
)); ?>" target="_blank" class="btn btn-primary btn-icon glyphicons file"><i></i> Export Excel</a>

<?php } ?>

<script type="text/javascript">
    $('#table_datatable').DataTable({
                   "searching": true,
                });
</script>