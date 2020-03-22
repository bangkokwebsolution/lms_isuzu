<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script language="javascript" type="text/javascript">
    function check_number() {
        e_k=event.keyCode
    //if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
        if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
            event.returnValue = false;
            alert("<?= $label->label_alert_notNumber ?>");
        }
    }
    function chThai()
    {
        if (event.keyCode>=161) 
        {
            return true;
        }
        else
        {
            alert('<?= $label->label_alert_notDefault ?>');
            return false;
        }
    }
</script>
<?php 
$msg = Yii::app()->user->getFlash('contactus');
if(!empty($msg)){
    ?>
    <script type="text/javascript">
         swal({
      title: "System",
      text: "<?= $msg; ?>",
      dangerMode: true,
  });
  </script>
  <?php 
} ?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_contactus ?></li>
        </ol>
    </nav>
</div>

<!-- Content -->
<section class="content" id="contact-us">
    <div class="container">
<!-- 
        <div class="contact-map">
            <div class="well">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1937.1530680156468!2d100.51359305819234!3d13.820646952131426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29b9c2071065f%3A0xaad4af9da5efa4e5!2z4Lih4Lir4Liy4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li14Lie4Lij4Liw4LiI4Lit4Lih4LmA4LiB4Lil4LmJ4Liy4Lie4Lij4Liw4LiZ4LiE4Lij4LmA4Lir4LiZ4Li34Lit!5e0!3m2!1sth!2sth!4v1527240275564" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <h4 class="text-center">แผนที่ : มหาวิทยาลัยพระจอมเกล้าพระนครเหนือ</h4>
        </div> -->
        <?php
        $form = $this->beginWidget('CActiveForm');
        ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_firstname  ?></label><br>
                        <?php echo $form->textField($model, 'contac_by_name', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_name'); ?></font>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_lastname  ?></label>
                        <!--<input type="text" class="form-control input-lg" id="lastname" name="lastname">-->
                        <?php echo $form->textField($model, 'contac_by_surname', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_surname'); ?></font>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_phone  ?></label>
                        <!--<input type="text" class="form-control input-lg" id="tel" name="tel">-->
                        <?php echo $form->textField($model, 'contac_by_tel', array('class' => 'form-control input-lg', 'onKeyPress' => 'return check_number()', 'maxlength' => '15')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_tel'); ?></font>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_email  ?></label>
                        <!--<input type="text" class="form-control input-lg" id="email" name="email">-->
                        <?php echo $form->textField($model, 'contac_by_email', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_email'); ?></font>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for=""><?= $label->label_topic  ?></label>
                        <!--<input type="text" class="form-control input-lg" id="topics" name="topics">-->
                        <?php echo $form->textField($model, 'contac_subject', array('class' => 'form-control input-lg', 'maxlength' => '100')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_subject'); ?></font>
                    </div>
                </div>
                <?php
                // $criteria = new CDbCriteria;
                // $criteria->compare('active',y);
                // $ProblemType = ProblemType::model()->findAll($criteria);
                // $Problemdata = array();
                // foreach ($ProblemType as $key => $value) {
                //         $Problemdata[$value->id]=$value->Problem_title;
                //     }
                ?>
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">ประเภท</label>
                        <?php
                        $htmlOptions = array('class' => 'form-control input-lg');
                        echo $form->dropDownList($model, 'contac_type', $Problemdata, $htmlOptions);
                        ?>
                    </div>
                </div> -->
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">ประเภท</label>
                        <?php echo $form->textField($model, 'contac_type', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_type'); ?></font>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for=""><?= $label->label_detail  ?></label>
                        <!--<textarea name="detail" id="detail" class="form-control" rows="6" ></textarea>-->
                        <?php echo $form->textarea($model, 'contac_detail', array('class' => 'form-control', 'rows' => '6')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_detail'); ?></font>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div style="display: inline-block;" class="g-recaptcha" data-sitekey="6LdMXXcUAAAAAN1JhNtbE94ISS3JPEdP8zEuoJPD"></div>
                        <?php echo $form->error($model, 'captcha',array('class' => 'error2')); ?>
                    </div>
                </div>
            </div>          

            <div class="text-center">
                <!--<button type="submit" class="btn btn-warning btn-lg">ส่งข้อความ</button>-->
                <?php echo CHtml::submitButton($label->label_button, array('class' => 'btn btn-warning btn-lg')); ?>
            </div>
        </div>

        <?php $this->endWidget();
        ?>
    </div>
</section>
