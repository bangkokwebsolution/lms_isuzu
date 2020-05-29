
<?php if(!empty($_GET['error_key'])){ ?>
    <script type="text/javascript">
        $( document ).ready(function() {
         swal({
            title: "<?php echo Yii::app()->session['lang'] == 1?'Verification code wrong!':'รหัสยืนยันผิดพลาด !'?>",
            text: "<?php echo Yii::app()->session['lang'] == 1?'Please try again ...':'กรุณาลองใหม่อีกครั้ง...'?>",
            type: "warning",

            confirmButtonText: "<?php echo Yii::app()->session['lang'] == 1?'OK':'ตกลง'?>",
            closeOnConfirm: false,
            closeOnCancel: false
        })
         .then((confirm) => {
            if (confirm) {
             window.location.href = "index"
         }
     });

     });
 </script>
<?php } ?>

<?php if(!empty($_GET['error_date']) || !empty($_GET['error_date_nokey'])){ ?>

<script type="text/javascript">
    $( document ).ready(function() {
       swal({
        title: "<?php echo Yii::app()->session['lang'] == 1?'This classroom has timed out!':'ห้องเรียนนี้ หมดเวลาเรียนแล้ว !'?>",
        text: "<?php echo Yii::app()->session['lang'] == 1?'Please try again ...':'กรุณาลองใหม่อีกครั้ง...'?>",
        type: "warning",

        confirmButtonText: "<?php echo Yii::app()->session['lang'] == 1?'OK':'ตกลง'?>",
        closeOnConfirm: false,
        closeOnCancel: false
    })
       .then((confirm) => {
        if (confirm) {
          <?php if(empty($_GET['error_date'])){ ?>
              window.close();
          <?php }else{ ?>
              window.location.href = "index"
          <?php } ?> 
      }
  });

    });
</script>
<?php } ?>


<?php if(!empty($_GET['error_num']) || !empty($_GET['error_num_nokey'])){ ?>
<script type="text/javascript">
    $( document ).ready(function() {
       swal({
        title: "<?php echo Yii::app()->session['lang'] == 1?'Full classroom !':'ห้องเรียนเต็ม !'?>",
        text: "<?php echo Yii::app()->session['lang'] == 1?'Please wait ...':'กรุณารอสักครู่...'?>",
        type: "warning",
        confirmButtonText: "<?php echo Yii::app()->session['lang'] == 1?'OK':'ตกลง'?>",
        closeOnConfirm: false,
        closeOnCancel: false
    })
       .then((confirm) => {
        if (confirm) {
           <?php if(empty($_GET['error_num'])){ ?>
              window.close();
          <?php }else{ ?>
              window.location.href = "index"
          <?php } ?>
      }
  });
   });
</script>
<?php } ?>


<?php if(!empty($_GET['erroruser'])){ ?>
<script type="text/javascript">
    $( document ).ready(function() {
       swal({
        title: "<?php echo Yii::app()->session['lang'] == 1?'You do not have permission to enter this classroom!':'คุณไม่มีสิทธิ์เข้าห้องเรียนนี้ !'?>",
        text: "<?php echo Yii::app()->session['lang'] == 1?'Please contact the system administrator ...':'กรุณาติดต่อผู้ดูแลระบบ...'?>",
        type: "warning",
        confirmButtonText: "<?php echo Yii::app()->session['lang'] == 1?'OK':'ตกลง'?>",
        closeOnConfirm: false,
        closeOnCancel: false
    })
       .then((confirm) => {
        if (confirm) {
           window.close();
       }
   });

   });
</script>
<?php } ?>

<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="margin-top:50px; height: 45px;"><i class="fa fa-fw fa-book"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-black margin-none"><?= Yii::app()->session['lang'] == 1?'Virtual Classroom':'ห้องเรียนเสมือน';?></h3>
                <p class="text-black text-subhead" style=" font-size: 1.6rem;"><?= Yii::app()->session['lang'] == 1?'Includes a list of virtual classrooms that are currently online':'รวมรายชื่อห้องเรียนเสมือนที่กำลัง ออนไลน์อยู่';?></p>
            </div>
        </div>
    </div>
</div>
<div class="container" style="min-height: 250px;">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                <div class="row" data-toggle="isotope" style="margin-top:50px; min-height: 76vh;">
                <?php
                require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
                $bbb = new BigBlueButton();
               
                /* ___________ GET MEETINGS FROM BBB SERVER ______ */
                /* 
                */

                /* 
                ---DEBUG - useful for manually checking the raw xml results.
                $test = $bbb->getGetMeetingsUrl();
                echo $test;
                 ---END DEBUG 
                */

                $itsAllGood = true;
                try {$result = $bbb->getMeetingsWithXmlResponseArray();}
                    catch (Exception $e) {
                        echo 'Caught exception: ', $e->getMessage(), "\n";
                        $itsAllGood = false;
                    }
                if ($itsAllGood == true) {
                    // If it's all good, then we've interfaced with our BBB php api OK:

                    if ($result == null) {
                        // If we get a null response, then we're not getting any XML back from BBB.
                        if (Yii::app()->session['lang'] == 1) {
                             echo "Unable to contact Streaming Server.";    # code...
                            }else{
                             echo "ไม่สามารถติดต่อ Streaming Server ได้";
                            // print_r($result);
                            }
                    } else { 
                    // We got an XML response, so let's see what it says:
                      //var_dump($result['returncode']);exit();
                        if ($result['returncode'] == 'SUCCESS') {
                            // Then do stuff ...
                            // You can parse this array how you like. For now we just do this:
                            $messageKey = (array)$result['messageKey'];
                            if($messageKey[0] == 'noMeetings'){
                                if (Yii::app()->session['lang'] == 1) {
                                  echo "Can't find a classroom that is currently online.";    # code...
                                }else{
                                  echo "ไม่พบห้องเรียนที่ออนไลน์อยู่ตอนนี้";
                                }
                            }else{
                                unset($result['returncode']);
                                unset($result['messageKey']);
                                unset($result['message']);
                    foreach ($result as $room){
                        $meetingId = (array)$room['meetingId'];
                        $meetingName = (array)$room['meetingName'];
                    ?>

                    <div class="item col-xs-12 col-sm-6 col-lg-4">
                        <div class="panel panel-default paper-shadow" data-z="0.5">
                            <div class="cover overlay cover-image-full hover">
                            <span class="img icon-block height-150 bg-default bigblue-link "></span>

    
                               <!--  <a href="<?php echo $this->createUrl('virtualclassroom/join',array('id'=>$meetingId[0])); ?>"
                                   class="padding-none overlay overlay-full icon-block bg-default" target="_blank"> -->
                        <?php 

                        $room = Vroom::model()->findByPk($meetingId[0]); 
                        if(!empty($room->ckeck_key)){ ?>
                                <a href="#modal-ckeck-key<?=$meetingId[0]?>"
                                   class="padding-none overlay overlay-full icon-block bg-default bigblue-link" data-toggle="modal">
                                    <span class="v-center" style="margin-top:50px; height: 45px;">
                                        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/../../uploads/vroom/'.$room->id.'/thumb/'.$room->pic_vroom.'', 'No Image', array('width'=>'358px','height'=>'300px' )); 
                                        ?>
                                    </span>
                                </a>


                        <?php }else{?>
                                <a href="<?php echo $this->createUrl('virtualclassroom/joinid',array('id'=>$meetingId[0])); ?>"
                                   class="padding-none overlay overlay-full icon-block bg-default bigblue-link">
                                        <span class="v-center" style="margin-top:50px; height: 45px;">
                                        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/../../uploads/vroom/'.$room->id.'/thumb/'.$room->pic_vroom.'', 'No Image', array('width'=>'358px','height'=>'300px' )); ?>
                                    </span>
                                </a>
                             

                    <?php } ?>
                        </div>
                        <div class="panel-body height-100">
                            <h4 class="text-headline margin-v-0-10" style="font-size: 23px;">
                        <?php if(!empty($room->ckeck_key)){ ?>
                         <a href="#modal-ckeck-key<?=$meetingId[0]?>"  data-toggle="modal"><i class="fa fa-graduation-cap"></i> <?php 
                        if (Yii::app()->session['lang'] == 1) {
                                  echo $room->name_EN;    # code...
                                }else{
                                  echo $meetingName[0];
                                }
                          ?></a>

                        <?php }else{?>
                         <a href="<?php echo $this->createUrl('virtualclassroom/joinid',array('id'=>$meetingId[0])); ?>"><i class="fa fa-graduation-cap"></i> <?php if (Yii::app()->session['lang'] == 1) {
                                  echo $room->name_EN;    # code...
                                }else{
                                  echo $meetingName[0];
                                } ?></a>

                        <?php } ?>
                            </h4>
                        </div>
                        <div class="panel-body">
                         <?php 
                          $start_date = Helpers::lib()->changeFormatDate($room->start_learn_room,'datetime');
                          $end_date = Helpers::lib()->changeFormatDate($room->end_learn_room,'datetime');
                          if ($start_date && $end_date) {
                              echo $start_date;
                              echo " - ";
                              echo $end_date;
                          }
                         ?>
                        </div>
                    </div>
                </div>
                            <div class="modal fade" id="modal-ckeck-key<?=$meetingId[0]?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title modalhead"><i class="fa fa-sign-in" aria-hidden="true"></i> <?= Yii::app()->session['lang'] == 1?'Confirm entry to the classroom':'ยืนยันการเข้าห้องเรียน';?> </h4>
                                        </div>
                            <form  action="<?php echo Yii::app()->createUrl('virtualclassroom/joinkey'); ?>" method="post" enctype="multipart/form-data"  >
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2 text-center">
                                                <h3 class="font-weight-bold"><?= Yii::app()->session['lang'] == 1?'Please enter the key code to confirm identity.':'กรุณากรอกรหัส key เพื่อยืนยันตัวตน';?></h3>
                                        <input  type="hidden" name="id" class='form-control' value="<?=$meetingId[0]?>">
                                        <input  type="password" name="check_key" class='form-control' autocomplete="off">

                                                </div>
                                            </div>
                                        </div>
                                         <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><?= Yii::app()->session['lang'] == 1?'OK':'ตกลง';?></button>
                                            <button class="btn btn-warning" href="#" class="close" data-dismiss="modal" aria-hidden="true"><?= Yii::app()->session['lang'] == 1?'Cancel':'ยกเลิก';?></button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>

                <?php 
                                } 
                            }
                        }
                        else {
                            if (Yii::app()->session['lang'] == 1) {
                             echo "Can't find a classroom that is currently online.";    # code...
                            }else{
                             echo "ไม่พบห้องเรียนที่ออนไลน์อยู่ตอนนี้";
                            // print_r($result);
                            }
                        }
                    }
                }
                ?>
                </div>
            </div>

           
    </div>
</div>
</div>
