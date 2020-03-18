<?php
$title = 'รายงานผู้เรียนตามรายหลักสูตร';
$currentModel = 'Report';

$this->breadcrumbs = array($title);

Yii::app()->clientScript->registerScript('search', "
    $('#SearchFormAjax').submit(function(){
        return true;
    });
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');

EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
    <!-- START HIGH SEARCH -->
    <div class="widget">
        <div class="widget-head">
            <h4 class="heading glyphicons search">
                <i></i> High Search:
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
                <dt><label>เลือกรุ่น : </label></dt>
                <dd>
                    <select name="ByUser[generation]">
                        <option value="">--- รุ่นทั้งหมด ---</option>
                        <?php
                            $Generation = Generation::model()->findAll();
                            if($Generation) {
                                foreach($Generation as $gen) {
                                    ?>
                                    <option value="<?= $gen->id_gen ?>"><?= $gen->name ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                <option value="">ยังไม่มีรุ่นการเรียน</option>
                                <?php
                            }
                        ?>
                    </select>
                </dd>
            </div>
            <div class="form-group">
                <dt><label>เลือกหลักสูตร : </label></dt>
                <dd>
                    <select name="ByUser[course_id][]" multiple style="width: 50%; height: 150px;" id="courseSelectMulti">
                    <?php
                        $CourseOnline = CourseOnline::model()->findAll(array(
                            'condition' => 'active = "y"',
                            'order' => 'course_id ASC'
                            )
                        );
                        $curr_supper_cate = null;
                        $curr_course_cate = null;
                        if($CourseOnline) {
                            foreach($CourseOnline as $Course) {
                                ?>
                                <option value="<?= $Course['course_id'] ?>"><?= $Course['course_title'] ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="">ยังไม่มีบทเรียน</option>
                            <?php
                        }
                    ?>
                    </select>
                </dd>
            </div>
            <div class="form-group">
                <dt><label>เลือกวิชา : </label></dt>
                <dd>
                    <select name="ByUser[lesson_id][]" multiple style="width: 50%; height: 150px;" id="chooseLesson">
                        <option value="">กรุณาเลือกหลักสูตร..</option>
                    </select>
                </dd>
            </div>
            <div class="form-group">
                    <dt><label>ค้นหา : </label></dt>
                    <dd>
                        <div style="padding-bottom: 10px;">
                            <input name="ByUser[search]" type="text" value="" placeholder="สามารถค้นหาด้วย ชื่อ, สกุล และบัตรประชาชน">
                            <span style="font-size: 0.9em; color: red;">(สามารถค้นหาด้วย ชื่อ, สกุล และบัตรประชาชน)</span>
                        </div>
                    </dd>
                </div>
            <div class="form-group">
                <dt><label>วันที่เริ่มต้น - วันที่สิ้นสุด : </label></dt>
                <dd>
                    <input name="ByUser[period_start]" type="text" class="form-control" placeholder="เลือกช่วงเวลาเริ่ม" id="passcoursStartDateBtn"> : <input name="ByUser[period_end]" type="text" class="form-control" placeholder="เลือกช่วงเวลาสิ้นสุด" id="passcoursEndDateBtn">
                </dd>
            </div>
                <div class="form-group">
                    <dt></dt>
                    <dd><button type="submit" class="btn btn-primary btn-icon glyphicons search"><i></i> Search</button></dd>
                </div>
            </dl>
        </div>
    <?php $this->endWidget(); ?>
    </div>
    <?php
        $search = $_GET['ByUser'];
        $textsearch = ($search['search']!=null)?'and id like "%'.$search['search'].'%" or profile.firstname like "%'.$search['search'].'%"':null;
        $searchLesson = $search['lesson_id'];
        $searchCourse = $search['course_id'];
        $searchLessonArray = implode(',', $searchLesson);
        $searchCourseArray = implode(',', $searchCourse);
        $sqlLessonQuery = ($searchLessonArray!='')?' and id in ('.$searchLessonArray.')':null;
        $sqlCourseQuery = ($searchCourseArray!='')?' and courseonline.course_id in ('.$searchCourseArray.')':null;

        //generation
        $searchGeneration = $search['generation'];
        $gen = ($searchGeneration!='')?' and generation = "'. $searchGeneration . '"':null;

        //period
        $period_start = ($search['period_start'])?date('Y-m-d 00:00:00', strtotime($search['period_start'])):null;
        $period_end = ($search['period_end'])?date('Y-m-d 23:59:59', strtotime($search['period_end'])):null;

        $startdate = ($period_start)?' and learn.create_date >= "'. $period_start .'"':null;
        $enddate = ($period_end)?' and learn.create_date <= "'. $period_end .'"':null;

        $course_online = CourseOnline::model()->findAll(array(
            'condition' => 'courseonline.active = "y"' . $sqlCourseQuery,
            // 'join' => 'left join tbl_lesson on tbl_lesson.course_id = courseonline.course_id',
            'alias' => 'courseonline',
            'order' => 'courseonline.course_id ASC'
        ));
        $course_count = ($course_online)?count($course_online):0;
    ?>
    <!-- END HIGH SEARCH -->
        <div class="widget hidden div-table" id="export-table">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' ถึงวันที่ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div>
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2" class="center">รหัสบัตรประชาชน</th>
                            <th colspan="<?= $course_count?>" class="center">รายหลักสูตร</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($course_online as $i => $course) {
                                    $cur_Lesson = Lesson::model()->findAll(array(
                                        'condition' => 'course_id ="' . $course['course_id'] . '" and active="y"' . $sqlLessonQuery,
                                    ));
                                    if($cur_Lesson) {
                                        foreach($cur_Lesson as $lesson) {
                                            ?>
                                            <th class="center"><?= $lesson['title'] ?></th>
                                        <?php
                                        }
                                    }
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1"' . $gen . $textsearch,
                            ));
                            $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>array(
                                'pageSize'=>1300
                                ),
                        ));
                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }
                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;
                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user['bookkeeper_id'] ?>&nbsp;</td>
                                        <?php
                                           if($course_online) {
                                                foreach($course_online as $course) {
                                                    $curLesson = Lesson::model()->findAll(array(
                                                        'condition' => 'course_id ="' . $course['course_id'] . '" and active="y"' . $sqlLessonQuery,
                                                    ));
                                                    if($curLesson) {
                                                        foreach($curLesson as $les) {
                                                            $statusLearn = Learn::model()->find(array(
                                                                'condition' => 'user_id = "' . $user['id'] . '" and lesson_id = "' . $les['id'] . '"' . $startdate . $enddate ,
                                                                'alias' => 'learn'
                                                            ));
                                                            $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 'pass' => '<b style="color: blue;">ผ่าน</b>','notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
                                                            ?>
                                                            <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?></td>
                                                            <?php
                                                        }
                                                    }
                                                }
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
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
            </div>
        </div>
</div>
<div class="widget" id="export-table332">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title . ': ' .($period_start != null OR $period_end !=null)?Helpers::lib()->changeFormatDate($period_start) . ' ถึงวันที่ ' . Helpers::lib()->changeFormatDate($period_end):null ?></h4>
                </div>
            </div>
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2" class="center">รหัสบัตรประชาชน</th>
                            <th colspan="<?= $course_count?>" class="center">รายหลักสูตร</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($course_online as $i => $course) {
                                    $cur_Lesson = Lesson::model()->findAll(array(
                                        'condition' => 'course_id ="' . $course['course_id'] . '" and active="y"' . $sqlLessonQuery,
                                    ));
                                    if($cur_Lesson) {
                                        foreach($cur_Lesson as $lesson) {
                                            ?>
                                            <th class="center"><?= $lesson['title'] ?></th>
                                        <?php
                                        }
                                    }
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1"' . $gen . $textsearch,
                            ));
                            $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>array(
                                'pageSize'=>25
                                ),
                        ));
                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }
                            $start_cnt = ($dataProvider->pagination->pageSize) * $getPages;
                            if($dataProvider) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?= 1+$start_cnt ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user['bookkeeper_id'] ?></td>
                                        <?php
                                           if($course_online) {
                                                foreach($course_online as $course) {
                                                    $curLesson = Lesson::model()->findAll(array(
                                                        'condition' => 'course_id ="' . $course['course_id'] . '" and active="y"' . $sqlLessonQuery,
                                                    ));
                                                    if($curLesson) {
                                                        foreach($curLesson as $les) {
                                                            $statusLearn = Learn::model()->find(array(
                                                                'condition' => 'user_id = "' . $user['id'] . '" and lesson_id = "' . $les['id'] . '"' . $startdate . $enddate ,
                                                                'alias' => 'learn'
                                                            ));
                                                            $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 'pass' => '<b style="color: blue;">ผ่าน</b>','notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
                                                            ?>
                                                            <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?></td>
                                                            <?php
                                                        }
                                                    }
                                                }
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
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
            </div>
        </div>
        <div class="widget-body">
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
        </div>
</div>
<script type="text/javascript">
    $(function() {
        // $('#courseSelectMulti').select2();
        endDate();
        startDate();
        $('#courseSelectMulti').click(function(e) {
            var setArray = new Array();
            $('#courseSelectMulti :selected').each(function(i, val) {
                setArray[i] = val.value;
            });
            $.post("<?= Yii::app()->createUrl($this->route) ?>", { id: JSON.stringify(setArray) }, function(data) {
                $('#chooseLesson').html(data);
            });
        });
        $('#btnExport').click(function(e) {
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2><?= $title ?></h2>'+$('#export-table').html()));
            e.preventDefault();
        });
      $('.div-table a').attr('href','#');
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
