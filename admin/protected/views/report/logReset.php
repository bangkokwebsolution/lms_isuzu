<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>

<?php
$title = 'รายงานการรีเซตหลักสูตร';
$currentModel = 'Report';

$this->breadcrumbs = array($title);

?>
<style type="text/css">
    .chosen-with-drop .chosen-drop{
    z-index:1000!important;
    position:static!important;
}
</style>
<div class="innerLR">  
    <!-- END HIGH SEARCH -->
        <div class="widget" id="export-table">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>
                    </h4>
                </div>
            </div> 

            <div id="form-search" style="margin-top: 20px;">
                <form action="logReset" method="GET">
                    <div class="row">
                        <div class="col-md-1 text-right">
                            <p>หลักสูตร <font color="red">*</font>: </p>
                        </div>
                        <div class="col-md-6">
                            <select name="Report[course]" id="report_course" class="form-control" onchange="getGen()">
                                <option value=""> กรุณาเลือก หลักสูตร</option>
                                <?php 
                                $criteria = new CDbCriteria;
                                $criteria->with=array('cates');
                                $criteria->compare('categorys.active','y');
                                $criteria->compare('courseonline.active','y');
                                $criteria->compare('courseonline.lang_id',1,true);
                                $criteria->order = 'sortOrder ASC';
                                $course_model = CourseOnline::model()->findAll($criteria);
                                foreach ($course_model as $key => $value) {
                                    ?>
                                    <option <?php if(isset($_GET['Report']['course']) && $_GET['Report']['course'] == $value->course_id){ echo "selected"; } ?> value="<?= $value->course_id ?>"><?= $value->course_title ?></option>
                                    <?php
                                }
                                 ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1 text-right">
                            <p>รุ่น <font color="red">*</font>: </p>
                        </div>
                        <div class="col-md-6">
                            <select name="Report[gen]" id="report_gen" class="form-control">                                
                                <?php if(isset($_GET['Report']['course']) && $_GET['Report']['course'] != ""){
                                    $criteria = new CDbCriteria;
                                    $criteria->compare('course_id',$_GET['Report']['course']);
                                    $criteria->compare('active','y');
                                    $criteria->order = 'gen_title ASC';
                                    $gen = CourseGeneration::model()->findAll($criteria);

                                    if(!empty($gen)){
                                        echo "<option value=''>กรุณา เลือกรุ่น</option>";
                                        foreach ($gen as $key => $value) {
                                            ?>
                                            <option <?php if($_GET['Report']['gen'] == $value->gen_id){ echo "selected"; } ?> value='<?= $value->gen_id ?>'><?= $value->gen_title ?></option>
                                            <?php
                                        }
                                    }else{
                                        echo "<option value='0'>ไม่มีรุุ่น</option>";
                                    }
                                }else{
                                    ?>
                                    <option value=""> กรุณา เลือกรุ่น</option>
                                    <?php
                                }
                                    ?>                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary mt-10 btn-icon glyphicons search"><i></i>ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php 
            if(!empty($_GET['Report']['course']) && !empty($_GET['Report']['gen'])){ ?>
            <!-- <div class="widget-body" style=" overflow-x: scroll;"> -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ - นามสกุล</th>
                            <th>รายการ</th>
                            <th>วันที่ทำรายการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $criteria = new CDbCriteria;
                        $criteria->compare('course_id', $_GET['Report']['course']);
                        $criteria->compare('gen_id', $_GET['Report']['gen']);
                        $criteria->order = 'reset_date DESC';
                        $model_reset = LogReset::model()->findAll($criteria);
                        // var_dump($model_reset); exit();
                        if(!empty($model_reset)){
                            $no = 1;
                        foreach ($model_reset as $key => $value) {
                            ?>
                            
                            <tr>
                                <td><?php echo $no; $no++; ?></td>
                                <td><?= $value->user_id ?></td>
                                <td><?= $value->reset_description ?></td>
                                <td><?= $value->reset_date ?></td>
                            </tr>

                            <?php
                        }
                    }else{
                        ?>
                        <tr colspan="4"> ไม่มีข้อมูล</tr>
                        <?php
                    }
                         ?>                        
                    </tbody>
                </table>
            <!-- </div> -->
        </div>
        <?php } else { ?>
        <!-- <div class="widget-body div-table" style="overflow: auto;"> -->
            <!-- Table -->
        <h4>กรุณาเลือกหลักสูตร หรือ ประเภทหลักสูตร หรือข้อมูลที่ต้องการ แล้วกด ปุ่มค้นหา</h4>
        <!-- </div> -->
    <?php } ?>
</div>

<script type="text/javascript">
    function getGen() {
        var course_id = $("#report_course option:selected").val();
        if(course_id != ""){
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("/report/loadgen"); ?>',
                data: ({
                    course_id: course_id
                }),
                success: function(data) {
                    $("#report_gen").html(data);
                }
            });
        }            
    }
</script>