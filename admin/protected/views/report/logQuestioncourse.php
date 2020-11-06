<?php
$title = 'รายงานแบบสอบถามสำหรับหลักสูตร';
$currentModel = 'Questionnaire';
$this->breadcrumbs = array(
	'รายงานภาพรวมแบบสอบถาม'
);


$this->breadcrumbs = array($title);

// Yii::app()->clientScript->registerScript('search', "
// 	$('#SearchFormAjax').submit(function(){
// 	    return true;
// 	});
// ");

Yii::app()->clientScript->registerScript(
    'updateGridView',
    <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');

EOD
,CClientScript::POS_READY
);
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>

<div class="innerLR">
    <?php 
        $this->widget('AdvanceSearchForm', array(
            'data' => $model,
            'route' => $this->route,
            'attributes' => array(
                array('name' => 'question', 'type' => 'list', 'query' => $model->getAllQuestion()),
            ),
        ));
    ?>
</div>
<?php
if (!empty($_GET) && $_GET['Report']['question'] != "") {
    $search = $_GET['Report'];
    $criteria = new CDbCriteria;
    $criteria->with = array('pro', 'course', 'mem');
?>
    <div class="widget" id="export-table33">
        <div class="widget-head">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?= $title ?></h4>
            </div>
        </div>
        <div class="widget-body" style=" overflow-x: scroll;">
            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th class="center" width="10%">ลำดับ</th>
                        <th class="center">ชื่อหลักสูตร</th>              
                        <th class="center">รุ่น</th>              
                        <th class="center">รายงาน</th>              
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $course_teacher = CourseTeacher::model()->findAll(array('condition' => 'survey_header_id=' . $search['question']));
                        if (count($course_teacher) > 0){
                            $k = false;
                            for ($i = 0; $i < count($course_teacher); $i ++){
                                $checkcourse = CourseOnline::model()->findByPk($course_teacher[$i]['course_id']);
                                if ($checkcourse->active == "y") {
                                    $gen = CourseGeneration::model()->findAll(array('condition' => 'course_id=' . $course_teacher[$i]['course_id'] . ' and active="y"'));
                                    foreach ($gen as $value){
                                        echo '<tr>';
                                        echo '<td class="center">'. ($i+1). '</td>';
                                        echo '<td class="center">'. $course_teacher[$i]['title']. '</td>';
                                        echo '<td class="center">'. $value->gen_title . '</td>';
                                        echo '<td class="center"><a href="'.$this->createUrl('//Report/reportquestionnair/id/' . $course_teacher[$i]['course_id'] . '/genid/' . $value->gen_id . '/all/0').'" class="btn btn-primary btn-icon">รายงาน</a></td>';
                                        echo '</tr>';
                                        $k = true;
                                    }
                                }
                            }
                            if ($k == false){
                                echo '<tr><td colspan="8" class="center">ไม่มีข้อมูล</td></tr>';
                            }
                        }else{
                            echo '<tr><td colspan="8" class="center">ไม่มีข้อมูล</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
            <br>
            <?php
            $this->widget('CLinkPager', array(
                'pages' => $dataProvider->pagination
            ));
            ?>
    </div>
    </div>
    </div>
    </div>
<?php } else { ?>
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
?>

<script>
    var select = document.getElementById("Report_question");
    for(var i = 0, l = select.options.length; i < l; i++) {
        var option = select.options[i];
        if(option.innerHTML == "ทั้งหมด") {
            option.innerHTML = "กรุณาเลือกแบบสอบถาม";
            option.disabled = true;
        }
    }
</script>