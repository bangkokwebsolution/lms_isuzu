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
        <div class="panel panel-default" style="padding: inherit ;background: whitesmoke;padding-top: 20px;">
        <h1 class="text-center" style="color:#010C65;font-size: 36px;" ><?= Yii::app()->session['lang'] == 1?'Thoresen & Co.,(Bangkok) Ltd. (TCB)':'บริษัท โทรีเซน (กรุงเทพ) จำกัด'; ?></h1>
            <div class="card-text" style="padding: 20px 20px 30px 20px;text-align: center;">
                <h4 style="font-size: 18px;"><?= Yii::app()->session['lang'] == 1?'Address : 26/32-34 Orakarn Building 10th Floor, Soi Chidlom, Lumpinee, Pathumwan Bangkok 10330, Thailand':' ที่ตั้งสำนักงาน : 26/32-34 อาคารอรกานต์ ชั้น 10 ซอยชิดลม ถนนเพลินจิต แขวงลุมพินี เขตปทุมวัน กรุงเทพฯ 10330 ประเทศไทย'; ?>
                
            </h4>
        </div>

    </div>
 <?php

 ?>
<!-- <div class="contact-map">
            <div class="well">
                <div class="mapouter"><div class="gmap_canvas"><iframe width="1300" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Thoresen%20Thai%20Agencies%20&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net">embed custom google maps</a></div><style>.mapouter{position:relative;text-align:right;height:500px;width:1300px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:1300px;}</style></div> 
            </div>
            <h4 class="text-center"><?= Yii::app()->session['lang'] == 1?'Map : THORESEN THAI AGENCIES PUBLIC COMPANY LIMITED (TTA)':'แผนที่ : บริษัท โทรีเซนไทย เอเยนต์ซีส์ จำกัด (มหาชน)'; ?></h4>
        </div> -->

        <h1 class="text-center" style="padding-top: 20px;padding-bottom: 20px;color:#010C65;font-size: 36px; " ><i class="fa fa-users" aria-hidden="true"style="padding-right: 20px;"></i><?= Yii::app()->session['lang'] == 1?'Administrator':'ผู้ดูแลระบบ'; ?></h1>

        <div class="row">
<?php
if ($ContactusNew_data) {
foreach ($ContactusNew_data as $key => $value) {
?>
            <div class="col-md-3 col-sm-4 col-xs-12 odd-even-contact">
                <?php 
                if ($key%2==0) {
                    echo '<div class="well contact-well contact-well-primary" style="border: 0px;">';
                }else{
                    echo '<div class="well contact-well contact-well-second" style="border: 0px;">';
                } ?>
                    <div class="card-img">
                         <?php
                            if ($value['con_image'] == null) {

                                $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                            } else {
                            
                                $img = Yii::app()->baseUrl . '/uploads/contactusnew/' . $value['id'] . '/thumb/' . $value['con_image'];
                            }
                          ?>
                        <img class="card-img-top" src="<?= $img ?>" alt="">
                    </div>
                    <div class="card-body">
                      <h4 class="card-title" >
                            <?php if (Yii::app()->session['lang'] == 1 || Yii::app()->session['lang'] == Null) {
                                echo $value['con_firstname_en'];?>&nbsp;&nbsp;
                            <?php
                                echo $value['con_lastname_en'];
                            }else{
                                echo $value['con_firstname'];
                                ?>&nbsp;&nbsp;
                            <?php
                                 echo $value['con_lastname'];
                            } ?>
                        </h4>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Position :':'ตำแหน่ง :'; ?></span>
                        <?php
                        echo $value['con_position'];
                        ?>   
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Telephone :':'เบอร์โทรติดต่อ :'; ?></span>
                          <?php
                        echo $value['con_tel'];
                        ?>
                         </div>
                         <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Email :':'อีเมล :'; ?></span>
                         <?php
                        echo $value['con_email'];
                        ?>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }
}
            ?>
        </div>
</div>
      
    </div>
</section>

