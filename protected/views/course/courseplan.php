<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
    $course_name = 'Course Name';
    $topic = 'Time Schedule of each Course';
    $date_now = date('Y');
    $mont = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
    $course_name = 'ชื่อหลักสูตร';
    $topic = 'ตารางเวลาของแต่ละหลักสูตร';
    $date_now = date('Y')+543;
    $mont = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
}
?>


<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php if ($langId == 2) { ?>
                    แผนการเรียน
                <?php } else { ?>
                    Plan
                <?php } ?></li>
        </ol>
    </nav>
        <div class="py-5">
            <h4 class="topic"><?= $date_now ?><span> : <?= $topic ?></span></h4>
            <div class=" my-4">
                <div class="table-plan-container">
                    <div id="table-plan" class="table-plan">
                        <div class="cell th"><?= $course_name ?></div>
                        <?php 
                        foreach ($mont as $keyM => $valueM) {
                            echo "<div class='cell th'>".$valueM."</div>";
                        }
                        ?>
                        <?php $row = 2; 
                        foreach ($Model as $key_C => $M_C) {
                        $date_start = explode('-', $M_C->course_date_start);
                        $date_end = explode('-', $M_C->course_date_end);
                            if($M_C->CategoryTitle->active == "y"){
                                    if($langId == 2){
                                        $date_Course = Helpers::changeFormatDateTHnew($M_C->course_date_start).' - '.Helpers::changeFormatDateTHnew($M_C->course_date_end);
                                        $course_id = $M_C->parent_id;
                                        // var_dump($M_C->course_id);exit();
                                    }else{
                                        $date_Course = Helpers::changeFormatDateENnew($M_C->course_date_start).' - '.Helpers::changeFormatDateENnew($M_C->course_date_end);
                                        $course_id = $M_C->course_id;
                                    }
                                $LogStartcourse = LogStartcourse::Model()->find(array('condition'=>'course_id ='.$course_id.' AND user_id ='.Yii::app()->user->id));
                                $passcourse = Passcours::Model()->find(array('condition'=>'passcours_cours = '.$course_id.' AND passcours_user ='.Yii::app()->user->id));
                                if(!empty($passcourse)){
                                    $status_user = '#4BBC99';
                                }else if(!empty($LogStartcourse) && empty($passcourse)){
                                    $status_user = '#FFA74A';
                                }else if(date('Y-m-d H:i:s') > $date_end && empty($passcourse)){
                                    $status_user = '#E64D3B';
                                }else{
                                    $status_user = '#3A8DDD';
                                }
                        // var_dump($date_start);exit();
                           ?>
                            <div class="cell" style="grid-row:<?= $row ?>;"><?= $M_C->course_title ?></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <div class="cell" style="grid-row:<?= $row ?>;"></div>
                            <section class="event row-plan<?= $row ?>" style=" grid-column: <?= $date_start[1]+1 ?> / span <?= $date_end[1]-$date_start[1]+1 ?>;background-color: <?= $status_user ?>"> <?= $date_Course ?></section>
                    <?php 

                                $row++;
                            } 
                        }
                    ?>
                        


                        <!-- <section class="event row-plan2" style=" grid-column: 2 / span 4;"> 4 Jan - 28 Feb </section>
                        <section class="event row-plan3"> 1 Mar - 31 Apr </section>
                        <section class="event row-plan4"> 01 May 2564 </section>
                        <section class="event row-plan5"> 01 Sep - 31 Dec </section>
                        <section class="event row-plan6"> 01 Jan - 31 Dec </section>
                        <section class="event row-plan7"> 01 Jan - 31 Sep </section> -->

                    </div>

                    <div class="form-group mt-20">
                        <div class="btn-plan1 text-4 btn-plan py-2 my-4">Not Started</div>
                        <div class="btn-plan2 text-4 btn-plan py-2 my-4">In Progress</div>
                        <div class="btn-plan3 text-4 btn-plan py-2 my-4">Passed</div>
                        <div class="btn-plan4 text-4 btn-plan py-2 my-4">Expired</div>
                       
                    </div>


                </div>
            </div>
        </div>


</div>