<h3 style='margin-bottom: 10px;'><b>ข้อมูล</b></h3>

<div class='row' style='margin-bottom: 20px;'>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>หลักสูตร</p>
    </div>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>หมวด</p>
    </div>

    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->course_title ?>'>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->cates->cate_title ?>'>
    </div>
</div>

<div class='row' style='margin-bottom: 20px;'>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>รหัสหลักสูตร</p>
    </div>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>รายละเอียดย่อ</p>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->course_number ?>'>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->course_short_title ?>'>
    </div>
</div>
<div class='row' style='margin-bottom: 20px;'>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>วันที่เริ่มต้นการเรียน</p>
    </div>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>วันที่สิ้นสุดการเรียน</p>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->course_date_start ?>'>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->course_date_end ?>'>
    </div>
</div>
<div class='row' style='margin-bottom: 20px;'>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>จำนวนวันที่เข้าเรียนได้</p>
    </div>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>เกณฑ์การสอบผ่าน *เปอร์เซ็น</p>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->course_day_learn ?>'>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->percen_test ?>'>
    </div>
</div>
<div class='row' style='margin-bottom: 20px;'>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>จำนวนครั้งที่ทำข้อสอบได้</p>
    </div>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>เวลาในการทำข้อสอบ</p>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->cate_amount ?>'>
    </div>
    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->time_test ?>'>
    </div>
</div>

<div class='row' style='margin-bottom: 20px;'>
    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>สร้างโดย</p>
    </div>

    <div class='col-md-6'>
        <p class='pull-left' style='display: inline-block; font-size: 16px;'>Org Chart</p>
    </div>


    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->usernewcreate->profile->firstname ?> <?= $CourseOnline->usercreate->profile->lastname ?>'>
    </div>

    <div class='col-md-6'>
        <input class='form-control' style='height: 40px;' readonly type='text' value='<?= $CourseOnline->usernewcreate->orgchart->title ?>'>
    </div>
</div>
<div class='row' style='margin-bottom: 20px;'>
</div>