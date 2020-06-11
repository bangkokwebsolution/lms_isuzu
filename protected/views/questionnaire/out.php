<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
<!-- <style>
    body h4 {
        font-size: 26px;
        font-weight: bold;
        border-left: 5px solid #58962c;
        padding-left: 10px;
    }
    .btn{
        font-size: 18px
    }
    .quiz {
        list-style-type: none;
        margin-bottom: 40px;
    }
    .h2, h2{
        font-weight: bold;
        font-size: 29px;
    }
    .quiz li {
        float: left;
        margin-right: 20px;
    }

    .head-quiz {
        padding-left: 20px;
        padding-right: 20px;
    }

    thead {
        background-color: #94CFFF;
    }
    .table-bordered{
        box-shadow: 0px 2px 24px #3333339e;
    }

    .mb-quiz {
        margin-bottom: 10px;
    }
    .form-control{
        border: 1px solid #D1D1D1;
    }
    .radio label::before {
        border: 1px solid #4193D0;
    }
    .checkbox label::before {
        border: 1px solid #4193D0;
    }
    .ml-15{
        margin-left: 15px;
    }
    .mb-10{
        margin-bottom: 15px;;
    }
    .span5 {
        width: 500px;
    }
</style> -->

<!-- <div class="header-page parallax-window">
  <div class="container">
    <h1>
    <small class="pull-right">
    <ul class="list-inline list-unstyled">
      <li><span class="text-bc"></span></li>
    </ul>
    </small>
    </h1>
  </div>
</div> -->
<div class="container">

    <div class="text-center bg-transparent margin-none">

    </div>
    <div class="page-section">
        <div class="panel panel-default head-quiz">
            <div class="row">
                <!-- <div class="col-md-12 col-sm-12" style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/head-subject/quiz.png" alt="person"/></div> -->
                
                <div class="bs-example">

    <?php $form=$this->beginWidget('AActiveForm', array(
        'id'=>'questionnaire-form',
        'errorMessageCssClass' => 'label label-important',
    )); ?>
        
            <h2><?php echo $header->survey_name; ?></h2>
            <input type="hidden" name="header_id" value="<?php echo $header->survey_header_id; ?>">
            <?php echo CHtml::decode($header->instructions); ?>
            <hr>
    <?php
            if(count($header->sections) > 0){
                $sections = $header->sections;
                foreach ($sections as $sectionKey => $sectionValue) {
    ?>
                 <h4><?php echo $sectionValue->section_title; ?></h4>
                 <hr>
                 <?php
                 if(count($sectionValue->questions) > 0){
                    foreach ($sectionValue->questions as $questionKey => $questionValue) {
                        //input text
                        if($questionValue->input_type_id == '1'){
?>                    
                    <div class="col-md-12 mtb-10">
                        <label class="dp-block mg-1">
                            <div class="dp-block">
                            <strong><?php echo $questionValue->question_name; ?></strong><label for="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label>
                            </div>
                            <input type="text" class="textip-question form-control" name="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" data-rule-required="true" data-msg-required="กรุณาตอบ">
                        </label>
                    </div>
<?php
                        //radio
                        }else if($questionValue->input_type_id == '2'){

?>
                        <div class="col-md-12 mtb-10">
                                <div class="dp-block">
                                    <strong><?php echo $questionValue->question_name; ?></strong>
                                    <label for="choice[radio][<?php echo $questionValue->question_id; ?>]" class="error"></label></div>
                                <div>
                        </div>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>

                        <label>
                            <input class="mg-5-10" type="radio" name="choice[radio][<?php echo $questionValue->question_id; ?>]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                            <?php echo $choiceValue->option_choice_name; ?>
                            <?php 
                            if($choiceValue->option_choice_type == 'specify'){
                            ?>
                            <input type="text" style="margin-left:10px;" name="choice[radioOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                            <?php
                            }
                            ?>
                        </label>

                        <?php
                            }
                        }
                        ?>
                        </div>
                        <br>
<?php
                        //checkbox
                        }else if($questionValue->input_type_id == '3'){
?>
                        <div class="col-md-12  mtb-10">
                            <div class="dp-block mg-1">
                                <strong><?php echo $questionValue->question_name; ?></strong>
                                <label for="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" class="error"></label>
                            </div>

                        <div>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>

                        <label>
                            <input class="mg-5-10" type="checkbox" name="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                            <?php echo $choiceValue->option_choice_name; ?>
                            <?php 
                            if($choiceValue->option_choice_type == 'specify'){
                            ?>
                            <input type="text" class="mg-5-10" name="choice[checkboxOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                            <?php
                            }
                            ?>
                        </label>
                        <?php
                            }
                        }
                        ?>
                        </div>
                    </div>
                       
<?php
                        //contentment
                        }else if($questionValue->input_type_id == '4'){
?>
                        <div class="col-md-12 mtb-10">
                            <div class="mt-2-5">
                            <table class="table table-bordered span10 topic-question" border="1">
                                    <tr>
                                        <th class="question-left"><strong><?php echo $questionValue->question_name; ?></strong></th>
                                        <?php
                                        if($questionValue->question_range == "" || $questionValue->question_range == "5"){
                                            $range = "5";
                                            $scoreDetails = array('5' => 'มากที่สุด', '4' => 'มาก', '3' => 'ปานกลาง', '2' => 'น้อย', '1' => 'น้อยที่สุด');
                                        }else{
                                            $range = "10";
                                            $scoreDetails = array('10' => 'มากที่สุด', '9' => '', '8' => '', '7' => '', '6' => '', '5' => 'ปานกลาง', '4' => '', '3' => '', '2' => '', '1' => 'น้อยที่สุด');
                                        }
                                        for($i=$range;$i>=1;$i--){
                                        ?>
                                        <th class="text-center" width="80"><strong><?php echo $i." ".$scoreDetails[$i]; ?></strong></th>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                            <?php
                            if(count($questionValue->choices) > 0){
                                foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                            ?>
                                    <tr>
                                        <td class="question-left" <?php echo ($choiceKey%2==0)?'style="background-color:#ececec"':''; ?>><?php echo $choiceValue->option_choice_name; ?><label for="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" class="error"></label></td>
                                        <?php
                                        for($i=$range;$i>=1;$i--){
                                        ?>
                                        <td class="text-center" <?php echo ($choiceKey%2==0)?'style="background-color:#ececec"':''; ?> ><input style="margin:0px;" type="radio" name="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" value="<?php echo $i; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ"></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            </table>
                            </div>
                        </div>
<?php
                        //text
                        }else if($questionValue->input_type_id == '5'){
?>
                       <div class="col-md-12  mtb-10">
                           <div class="dp-block">
                                <label class="dp-block">
                                    <div class="mtb-10"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                                    <textarea class="warea100" data-rule-required="true" data-msg-required="กรุณาตอบ" name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" rows="8" cols="50" style="width: 500px; height:130px; margin-bottom: -50px;"></textarea>
                                </label>
                           </div>
                       </div>
                        </div>
<?php
                        }
                    }
                 }
                 ?>
    <?php
                }
            }

    ?>

    <div class="col-md-12  mt-40">
        <?php echo CHtml::tag('button',array('class' => 'btn btn-icon btn-warning'),'บันทึกข้อมูล'); ?>
        <a href="<?=Yii::app()->createUrl('course/lesson',array('lesson_id'=>$_GET['id'],'id'=>$lesson->course_id))?>" class="navbar-btn btn btn-primary">ยกเลิก</a>
    </div>
           

    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#questionnaire-form").validate();
    });
</script>

<script type="text/javascript">
    $(function(){ // document ready

     
    });
</script>

               <!--  <div class="col-md-12 col-sm-12">1)
                    เอาอะไรไปคูณกับจำนวนเต็ม ผลลัพธ์จะน้อยลงกว่าเดิม
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="radio radio-info">
                        <input name="radio2" id="radio1" value="option2" type="radio">
                        <label for="radio1">จำนวนเต็ม</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio2" id="radio2" value="option2" type="radio">
                        <label for="radio2">เศษส่วนแท้</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio2" id="radio3" value="option2" type="radio">
                        <label for="radio3">เศษส่วนเกิน</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12">2)
                    เขาขอยืมเงินกองกลาง..............จ่ายไปก่อน
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="radio radio-info">
                        <input name="radio21" id="radio11" value="option2" type="radio">
                        <label for="radio11">ทดลอง</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio21" id="radio21" value="option2" type="radio">
                        <label for="radio21">ทดหนี้</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio21" id="radio31" value="option2" type="radio">
                        <label for="radio31">ทดรอง</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12">3)
                    ท่านได้รับทราบข้อมูลเดี่ยวกับตัวสินค้าบราเดอร์จากที่ใด
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox41" name="ccc" type="checkbox">
                        <label for="checkbox41">วิทยุ</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox42" name="ccc" type="checkbox">
                        <label for="checkbox42">หนังสือพิมพ์</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox43" name="ccc" type="checkbox">
                        <label for="checkbox43">นิตยสาร</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12">4)
                    คุณภาพที่ไดรับจากการใช้สินค้าบราเดอร์
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ml-15">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox51" name="ccc" type="checkbox">
                        <label for="checkbox51">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox52" name="ccc" type="checkbox">
                        <label for="checkbox52">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox53" name="ccc" type="checkbox">
                        <label for="checkbox53">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 ">5)
                    ท่านได้รับทราบข้อมูลเดี่ยวกับตัวสินค้าบราเดอร์จากที่ใด
                </div> -->
                <!-- <div class="col-md-12 col-sm-12 mb-quiz">
                    <div class="form-group" style="margin-top: 15px;">
                        <textarea class="form-control span5" rows="3" placeholder="ที่อยู่"></textarea>
                    </div>
                </div> -->
   
            </div>
        </div>
    </div>
</div>
