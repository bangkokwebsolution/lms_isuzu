<?php
$FormText = 'เพิ่ม สมาชิกจาก Excel';
$this->breadcrumbs = array('ระบบรายชื่อสมาชิก' => array('index'), $FormText,);
// echo Yii::getVersion();
//$this->renderPartial('_form', array('model'=>$model,'profile'=>$profile,'authassign'=>$authassign,'FormText'=>$FormText));
?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/theme/scripts/plugins/forms/dropzone/css/dropzone.css"
      rel="stylesheet">
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/theme/scripts/plugins/forms/dropzone/dropzone.min.js"></script>
<div class="innerLR">
    <div class="widget">
        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">นำเข้าจาก Excel</h4>
        </div>
        <!-- // Widget heading END -->

        <div class="widget-body">
            <div class="row-fluid">
                <form enctype="multipart/form-data" id="sutdent-form" method="post"
                      action="<?php echo Yii::app()->createUrl('user/admin/excel'); ?>">
                    <div class="span4">
                        <?php $form = $this->beginWidget('AActiveForm', array(
                            'id'=>'news-form',
                            'enableClientValidation'=>true,
                            'clientOptions'=>array(
                                'validateOnSubmit'=>true
                            ),
                            'errorMessageCssClass' => 'label label-important',
                            'htmlOptions' => array('enctype' => 'multipart/form-data')
                        )); ?>
                        <h4>นำเข้าไฟล์ สำหรับผู้เรียน <label>(ไฟล์ excel เท่านั้น)</label></h4>
                        <!-- <div class="fileupload fileupload-new" data-provides="fileupload">
							  	<span class="btn btn-default btn-file">
							  		<span class="fileupload-new">เลือกไฟล์</span>
							  		<span class="fileupload-exists">เปลี่ยน</span>
							  		<input id="excel_import_student"
                                           accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                           name="excel_import_student" type="file">
							  	</span>
                            <span class="fileupload-preview"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload"
                               style="float: none">×</a>
                        </div> -->
                        <!-- <span class="btn btn-default btn-file">เลือกไฟล์ -->
                            <?php echo $form->fileField($model,'excel_file',array('class'=>'form-control')); ?>
                            <!-- </span> -->
                            <?php echo $this->NotEmpty();?>
                            <?php echo $form->error($model,'excel_file'); ?>

                        <?php $this->endWidget(); ?>
                        <div class="form-actions">

                            <button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>นำเข้าไฟล์
                                excel
                            </button>
                            <!-- <button type="button" class="btn btn-icon btn-default glyphicons circle_remove"><i></i>Cancel</button> -->
                        </div>
                    </div>
                </form>
                <script type="text/javascript">
                    $('#sutdent-form').submit(function () {
                        // if ($('#excel_import_student').parent().next('.fileupload-preview').text() == '') {
                        //     alert('กรุณาเลือกไฟล์ Excel');
                        //     return false;
                        // }
                        // return true;
                        console.log();
                        if ($('#User_excel_file').val() == '') {
                            alert('กรุณาเลือกไฟล์ Excel');
                            return false;
                        }
                        return true;
                    });
                </script>
                <div class="span4">
                    <h4>แบบฟอร์มรูปแบบนำเข้าสมาชิก</h4>
                    <a href="<?php echo Yii::app()->getBaseUrl() . '/../uploads/templete_import_users.xlsx'; ?>"
                       class="glyphicons download_alt"><i></i>Download Excel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="widget">
        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">การทำงาน</h4>
        </div>
        <!-- // Widget heading END -->
        <div class="widget-body">
            <div class="row-fluid" id='print'>
                <div class="widget-body">
                    <!-- Table -->

                    <?php
                    // var_dump($HisImportErrorMessageArr);
                    // exit();
                    // foreach ($data as $key => $value) {
                    //     # code...
                    //     var_dump($value['email']);
                    // }
                    if (count($data) > 0):?>
                        <table class="table table-striped table-bordered ">
                            <!-- Table heading -->
                            <?php
                            $headTable = <<<HTB
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>email (ชื่อผู้ใช้)</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>เบอร์โทรศัพท์</th>
                                        <th>สภานะ</th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody>
HTB;
                                    echo $headTable;
                            foreach ($data as $key => $valueRow) {

                                    $email = $valueRow['email'];
                                    $number = $key + 1;
                                    $fullname = $valueRow['fullname'];
                                    $phone = $valueRow['phone'];
                                    $identification = $valueRow['identification'];
                                    $msg = $valueRow['msg'];
                                    $BodyTable = <<<HTM
										<!-- Table row -->
										<tr class="gradeX">
											<td>$number</td>
                                            <td>$email</td>
											<td class="left">$fullname</td>
											<td class="left">$phone</td>
                                            <td class="left">$msg</td>
										</tr>	
HTM;
                                    echo $BodyTable;
                                }
                            ?>
                            </tbody>
                        </table>
                        <input type="button" value="Print" onclick="printDiv('print')">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="widget">
        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">รหัสที่ใช้ใน Excel</h4>
        </div>
        <!-- // Widget heading END -->

        <div class="widget-body">
            <div class="row-fluid">
                   <!--  <div class="span12" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. หลักสูตร</h5>
                        <?php
                        $criteria=new CDbCriteria;
                        $criteria->compare('active',y);

                        $dataProvider = new CActiveDataProvider('OrgChart', array(
                            'criteria'=>$criteria,
                            'pagination' => array(
                                'pageSize' => 10,
                            )));
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'dataProvider' => $dataProvider,
                            'columns' => array(
                                array(            // display 'author.username' using an expression
                                    'header' => 'รหัสหลักสูตร',
                                    'value' => '$data->id',
                                ),
                                array(            // display 'author.username' using an expression
                                    'header' => 'กลุ่มหลักสูตรย่อย',
                                    'value' => '$data->title',
                                ),
                            ),
                        ));
                        ?>
                    </div> -->
            <!-- <div class="span12" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. ฝ่าย</h5>
                            <?php
                            $dataProvider = new CActiveDataProvider('Company', array(
                            'criteria'=>$criteria,
                                'pagination' => array(
                                    'pageSize' => 10,
                                )));
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'columns' => array(
                                    array(            // display 'author.username' using an expression
                                        'header' => 'รหัสฝ่าย',
                                        'value' => '$data->company_id',
                                    ),
                                    array(            // display 'author.username' using an expression
                                        'header' => 'ชื่อฝ่าย',
                                        'value' => '$data->company_title',
                                    ),
                                ),
                            ));
                            ?>
                    </div>-->
              <!--   <?php $idx = 1; ?>
                    <div class="span12" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. กอง</h5>
                            <?php
                            $dataProvider = new CActiveDataProvider('Division', array(
                            'criteria'=>$criteria,
                                'pagination' => array(
                                    'pageSize' => 10,
                                )));
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'columns' => array(
                                    array(            // display 'author.username' using an expression
                                        'header' => 'รหัสกอง',
                                        'value' => '$data->id',
                                    ),
                                    array(            // display 'author.username' using an expression
                                        'header' => 'ชื่อกอง',
                                        'value' => '$data->div_title',
                                    ),
                                ),
                            ));
                            ?> 
                    </div>-->
                    <?php $idx = 1; ?>
                    <div class="span12" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. แผนก</h5>
                            <?php
                            $dataProvider = new CActiveDataProvider('Department', array(
                            'criteria'=>$criteria,
                                'pagination' => array(
                                    'pageSize' => 10,
                                )));
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'columns' => array(
                                    array(            // display 'author.username' using an expression
                                        'header' => 'รหัสแผนก',
                                        'value' => '$data->id',
                                    ),
                                    array(            // display 'author.username' using an expression
                                        'header' => 'ชื่อแผนก',
                                        'value' => '$data->dep_title',
                                    ),
                                ),
                            ));
                            ?>
                    </div>
                     <div class="span12" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. ตำแหน่ง</h5>
                            <?php
                            $dataProvider = new CActiveDataProvider('Position', array(
                            'criteria'=>$criteria,
                                'pagination' => array(
                                    'pageSize' => 10,
                                )));
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'columns' => array(
                                    array(            // display 'author.username' using an expression
                                        'header' => 'รหัสตำแหน่ง',
                                        'value' => '$data->id',
                                    ),
                                    array(            // display 'author.username' using an expression
                                        'header' => 'ชื่อตำแหน่ง',
                                        'value' => '$data->position_title',
                                    ),
                                ),
                            ));
                            ?>
                    </div>
                     <div class="span12" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. Lavel</h5>
                            <?php
                            $dataProvider = new CActiveDataProvider('Branch', array(
                            'criteria'=>$criteria,
                                'pagination' => array(
                                    'pageSize' => 10,
                                )));
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'columns' => array(
                                    array(            // display 'author.username' using an expression
                                        'header' => 'รหัส Lavel',
                                        'value' => '$data->id',
                                    ),
                                    array(            // display 'author.username' using an expression
                                        'header' => 'Lavel',
                                        'value' => '$data->branch_name',
                                    ),
                                ),
                            ));
                            ?>
                    </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>