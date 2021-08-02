<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
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
            <h4 class="topic">2021<span> : Time Schedule of each Course</span></h4>
            <div class=" my-4">
                <div class="table-plan-container">
                    <div id="table-plan" class="table-plan">
                        <div class="cell th">Course Name</div>
                        <div class="cell th">Jan</div>
                        <div class="cell th">Feb</div>
                        <div class="cell th">Mar</div>
                        <div class="cell th">Apr</div>
                        <div class="cell th">May</div>
                        <div class="cell th">Jun</div>
                        <div class="cell th">Jul</div>
                        <div class="cell th">Aug</div>
                        <div class="cell th">Sep</div>
                        <div class="cell th">Oct</div>
                        <div class="cell th">Nov</div>
                        <div class="cell th">Dec</div>
                        <div class="cell" style="grid-row:2;">Course Name</div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:2;"></div>
                        <div class="cell" style="grid-row:3;">Course Name</div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:3;"></div>
                        <div class="cell" style="grid-row:4;">Course Name</div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:4;"></div>
                        <div class="cell" style="grid-row:5;">Course Name</div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:5;"></div>
                        <div class="cell" style="grid-row:6;">Course Name</div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:6;"></div>
                        <div class="cell" style="grid-row:7;">Course Name</div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <div class="cell" style="grid-row:7;"></div>
                        <section class="event row-plan2"> 4 Jan - 28 Feb </section>
                        <section class="event row-plan3"> 1 Mar - 31 Apr </section>
                        <section class="event row-plan4"> 01 May 2564 </section>
                        <section class="event row-plan5"> 01 Sep - 31 Dec </section>
                        <section class="event row-plan6"> 01 Jan - 31 Dec </section>
                        <section class="event row-plan7"> 01 Jan - 31 Sep </section>

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