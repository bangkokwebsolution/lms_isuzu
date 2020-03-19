<?php
/* @var $this TestController */
/* @var $model User */

$formNameModel = 'User';

$this->breadcrumbs=array(
    'Reset มหาวิทยาลัย'=>array('LearnReset/Reset_university'),
    'Reset ข้อมูลบทเรียน'
);

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
	$.appendFilter("User[per_page]", "per_page");
EOD
    , CClientScript::POS_READY);


?>

<div class="innerLR">

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>

              <span class="pull-left" style="color:#000;">
                Reset ข้อมูลบทเรียน :
                <span class="strong"><?php echo $uni->name; ?></span>
              </span>
        </div>
        <div class="widget-body">
            <div class="separator bottom form-inline small">
            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">
                <?php
                $this->widget('AGridView', array(
                    'loadProcessing' => true,
                    'id'=>$formNameModel.'-grid',
                    'selectableRows' => 2,
                    'dataProvider'=>$dataProvider,
                    'filter'=>$model,
                    'columns'=>array(
                        array(
                            'header' => 'บทเรียนที่มีนิสิตเรียน',
                            'value' => function($data){
                                return $data->lesson->title;
                            },
                            // 'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header' => 'หลักสูตร',
                            'value' => function($data){
                                return $data->lesson->courseonlines->course_title;
                            },
                            // 'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header'=>'จำนวนนักศึกษา',
                            'value'=> function($data){
                                $university_user = User::model()->findAll(array(
                                    'condition' => 'student_house=' . $data->user->university->id,
                                ));
                                $ids = array();
                                if ($university_user) {
                                    foreach ($university_user as $user) {
                                        $ids[] = $user->id;
                                    }
                                }
                                $sum = 0;
                                    $criteria = new CDbCriteria;
                                    $criteria->addCondition('lesson_id = '. $data->lesson->id);
                                    $criteria->addInCondition('user_id', $ids);
                                    $criteria->group ='user_id';
                                    $learnDel = Learn::model()->findAll($criteria);
                                    $sum += count($learnDel);
                                return $sum;
                            },
                            'htmlOptions'=>array( 'style'=>'width:150px;' ),
                        ),
                        array(
                            'header' => 'ลบการเรียนบทเรียน',
                            'type' => 'raw',
                            'value' => function($data){
                                return CHtml::link('Reset','#'.$data->user->university->id,array(
                                  'class'=>'btn btn-primary learn_reset',
                                  'data-lesson-id'=> $data->lesson_id,
                                ));
                            },
                            'htmlOptions'=>array( 'style'=>'text-align:center;'),
                            'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
                        ),
                    ),
                )); ?>

            </div>
            <br>
            <!-- <div class="buttons">
                <?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
                    "class"=>"btn btn-danger btn-icon glyphicons circle_minus",
                    "onclick"=>"return multipleDeleteNews('".$this->createUrl('LearnReset/MultiResetAllCourse')."','$formNameModel-grid');"
                )); ?>
            </div> -->

        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $('body').on('click','.learn_reset',function(){
            if(!confirm("คุณต้องการ Reset การเรียน ใช่หรือไม่ ?")) return false;
            var val = $(this).attr('href');
            var uniID = val.substr(1);
            var lessonID = $(this).attr('data-lesson-id');
            $.ajax({
                type: 'POST',
                url: "<?=Yii::app()->createUrl('LearnReset/resetLearnLessonUni');?>",
                data:{ uniID:uniID,lessonID:lessonID },
                success: function(data) {
                    alert("Reset การเรียน เรียบร้อยแล้ว");
                    window.location.href="<?= $this->createUrl('LearnReset/showResetLessonUni?uniID='); ?>"+uniID;
                }
            })
        });
    });
</script>
