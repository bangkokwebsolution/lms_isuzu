<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-main">
      <li class="breadcrumb-item">
        <a href="<?php echo $this->createUrl('/site/index'); ?>">
          <?php
          if (Yii::app()->session['lang'] == 1) {
            echo "Home";
          } else {
            echo "หน้าแรก";
          }
          ?>
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        <?php
        if (Yii::app()->session['lang'] == 1) {
          echo "e-Library";
        } else {
          echo "ห้องสมุดออนไลน์";
        }
        ?>
      </li>
    </ol>
  </nav>
</div>
<?php $arr_type_video = array("mp4", "mkv"); ?>
<section class="content" id="library-group">

  <div class="container">
   

    <div class="tab-content">

      <div id="lby-doc" class="tab-pane fade <?php if(isset($_GET['cate_2'])){ echo 'in active'; }elseif(!isset($_GET['cate_1'])){ echo 'in active'; } ?>">
        <div class="row">
          <div class="col-sm-4 col-md-3 col-xs-12">
            <h4 class="library-topic"><?php echo $label->label_list_docment ?></h4>

            <div class="type-menu gallery">
              <button class="tab-btn-cate-type btn btn-default filter-button btn-lg" data-filter="cate-all-2"><?php echo $label->label_all ?></button>
              <?php 
              foreach ($library_type_2 as $key => $value) {
                if (Yii::app()->session['lang'] == 1) {
                  $libra_type = $value->library_type_name_en;
                } else {
                  $libra_type = $value->library_type_name;
                }
                ?>
                <button style="white-space: normal;" class="tab-btn-cate-type btn btn-default filter-button btn-lg text-left" data-filter="cate_<?= $value->library_type_id ?>"><?= $libra_type ?></button>
        <?php } // foreach ($library_type_2 ?>
            </div>
          
            <a href="https://se-ed.belibcloud.com/login" target="_bank" class="se-ed-button">
              <img src="/lms_isuzu/themes/template2/images/se-ed-logo.png" alt="" srcset="">
              <span>SE-ED</span>&nbsp;Library
              </a>

          </div>

          <div class="col-sm-8 col-md-9 col-xs-12">
            <h3 class="text-h3"><!-- ชื่อกลุ่มของเอกสาร --></h3>
            <hr class="mt-1 mb-3">

            <div class="gallery_product  filter cate-all-2">  
                  <?php 

                    

                  foreach ($library_file_2 as $key => $value) {
                    if (Yii::app()->session['lang'] == 1) {
                  $libra_file = $value->library_name_en;
                } else {
                  $libra_file = $value->library_name;
                }

                

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if($value->status_ebook == 1){ // Ebook
                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile_ebook/".$value->library_id."/*");
                  if(!empty($check_file)){
                    foreach ($check_file as $keyy => $valuee) {                      
                      $ext = pathinfo($valuee, PATHINFO_EXTENSION);
                      if($ext == "html"){
                        $filename = basename($valuee);
                        ?>
                        <div class="col-sm-6 col-md-4 col-xs-12">
                          <div class=" text-center">
                            <div class="library-item">
                              <div class="item item-library-index">
                                <div class="library-card">
                                  <a target="blank_" href="<?= $this->createUrl('uploads/LibraryFile_ebook/'.$value->library_id.'/'.$filename) ?>" class="" library-id="<?= $value->library_id ?>">
                                    <span class="other-file">
                                      <i class="fas fa-file-word word"></i>&nbsp;<small>E-Book</small>
                                    </span>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                                    <div class="library-detail">
                                      <span><?= $libra_file ?></span>
                                    </div>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                    }
                  }
                }elseif (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class=" text-center">
                  <div class="library-item">
                    <div class="item item-library-index">
                      <div class="library-card">

                        <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                          <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp4'>
                          </video>

                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                              <div class="text-center">
                                  <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                <i class="fa fa-download"></i> <?= $text_status ?>
                              </button>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                    <?php
                    }
                  }
                } elseif ($extension == "mp3") {
                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");

                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
                    ?>
                  <div class="col-sm-6 col-md-4 col-xs-12" style="height: 285.6px;">
                    <div class=" text-center" style="height: 275.6px;">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='audio/mpeg'>
                              </video>

                              
                              <?= $libra_file ?>                                
                              </span>
                                <div class="text-center">
                                  <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                    <i class="fa fa-download"></i> <?= $text_status ?>
                                  </button>
                                </div>
                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  <?php
                    }
                  }
                } elseif ($extension == "doc" || $extension == "docx") {
                  ?>
                  <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class=" text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">
                            <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                              <span class="other-file">
                                <i class="fas fa-file-word word"></i>&nbsp;<small>Word</small>
                              </span>
                              <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                              <div class="library-detail">
                                <span><?= $libra_file ?></span>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                } elseif ($extension == "xls" || $extension == "xlsx") {
                ?>
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class=" text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-excel excel"></i>&nbsp;<small>Excel</small>
                            </span>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                            <div class="library-detail">
                              <span><?= $libra_file ?></span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                } elseif ($extension == "ppt" || $extension == "pptx") {
                ?>
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class=" text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-excel powerpoint"></i>&nbsp;<small>PowerPoint</small>
                            </span>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                            <div class="library-detail">
                              <span><?= $libra_file ?></span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                } elseif ($extension == "pdf") {
                ?>

                <!--pdf แสดงส่วน All -->
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class=" text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="../uploads/LibraryFile/<?php echo $value->library_filename ?>" target="_bank"> 
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
                            </span>
                            <?php if($value->library_picture!="" && file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/library/' . $value->library_id . '/thumb/' . $value->library_picture)){ ?>
                            <img src="<?php echo Yii::app()->baseUrl ?>/uploads/library/<?php echo $value->library_id ?>/thumb/<?php echo $value->library_picture; ?>" class="w-100" >
                            <?php }else{?>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                            <?php } ?>
                            <div class="library-detail">
                              <span><?= $libra_file ?></span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                }
              } // foreach ($library_file_2
                   ?>                
            </div> <!-- cate-all-2 -->


        


            <?php 
            foreach ($library_type_2 as $key_t => $value_t) {
                if (Yii::app()->session['lang'] == 1) {
                  $libra_type = $value_t->library_type_name_en;
                } else {
                  $libra_type = $value_t->library_type_name;
                }

             ?>
            <div class="gallery_product  filter cate_<?= $value_t->library_type_id ?>" style="display: none;">

              <?php 

                $library_file = libraryFile::model()->findAll(array(
                'condition' => 'active=:active AND library_type_id=:library_type_id',
                'params' => array(':active' => 'y', ':library_type_id' => $value_t->library_type_id),
                'order' => 'sortOrder ASC'
              ));
                // var_dump($library_file);

              foreach ($library_file as $key => $value) {
                
                if (Yii::app()->session['lang'] == 1) {
                  $libra_file = $value->library_name_en;
                } else {
                  $libra_file = $value->library_name;
                }

                

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if($value->status_ebook == 1){ // Ebook
                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile_ebook/".$value->library_id."/*");
                  if(!empty($check_file)){
                    foreach ($check_file as $keyy => $valuee) {                      
                      $ext = pathinfo($valuee, PATHINFO_EXTENSION);
                      if($ext == "html"){
                        $filename = basename($valuee);
                        ?>
                        <div class="col-sm-6 col-md-4 col-xs-12">
                          <div class=" text-center">
                            <div class="library-item">
                              <div class="item item-library-index">
                                <div class="library-card">
                                  <a target="blank_" href="<?= $this->createUrl('uploads/LibraryFile_ebook/'.$value->library_id.'/'.$filename) ?>" class="" library-id="<?= $value->library_id ?>">
                                    <span class="other-file">
                                      <i class="fas fa-file-word word"></i>&nbsp;<small>E-Book</small>
                                    </span>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                                    <div class="library-detail">
                                      <span><?= $libra_file ?></span>
                                    </div>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                    }
                  }
                }elseif (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  // var_dump($check_file); exit();
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class=" text-center">
                  <div class="library-item">
                    <div class="item item-library-index">
                      <div class="library-card">

                        <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                          <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp4'>
                          </video>

                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                                <div class="text-center">
                                  <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                <i class="fa fa-download"></i> <?= $text_status ?>
                              </button>
                                </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                    <?php
                    }
                  }
                } elseif ($extension == "mp3") {
                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");

                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
                    ?>
                  <div class="col-sm-6 col-md-4 col-xs-12" style="height: 285.6px;">
                    <div class=" text-center" style="height: 275.6px;">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='audio/mpeg'>
                              </video>

                              
                          <?= $libra_file ?>
                          <div class="text-center">
                              <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                <i class="fa fa-download"></i> <?= $text_status ?>
                              </button>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  <?php
                    }
                  }
                } elseif ($extension == "doc" || $extension == "docx") {
                  ?>
                  <div class="col-sm-6 col-md-3 col-xs-12">
                    <div class=" text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">
                            <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                              <span class="other-file">
                                <i class="fas fa-file-word word"></i>&nbsp;<small>Word</small>
                              </span>
                              <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                              <div class="library-detail">
                                <span><?= $libra_file ?></span>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                } elseif ($extension == "xls" || $extension == "xlsx") {
                ?>
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class=" text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-excel excel"></i>&nbsp;<small>Excel</small>
                            </span>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                            <div class="library-detail">
                              <span><?= $libra_file ?></span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                } elseif ($extension == "ppt" || $extension == "pptx") {
                ?>
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class=" text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-excel powerpoint"></i>&nbsp;<small>PowerPoint</small>
                            </span>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                            <div class="library-detail">
                              <span><?= $libra_file ?></span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                } elseif ($extension == "pdf") {
                ?>
                <!--PDF ที่แสดงหน้านี้ -->
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class=" text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="../uploads/LibraryFile/<?php echo $value->library_filename ?>"  class="" library-id="<?= $value->library_id ?>" >
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
                            </span>
                            <?php if($value->library_picture!="" && file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/library/' . $value->library_id . '/thumb/' . $value->library_picture) ){ ?>
                            
                            <img src="<?php echo Yii::app()->baseUrl ?>/uploads/library/<?php echo $value->library_id ?>/thumb/<?php echo $value->library_picture; ?>" class="w-100" >
                            <?php }else{?>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="w-100">
                            <?php } ?>
                            <div class="library-detail">
                              <span><?= $libra_file ?></span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                }
              } // foreach ($library_file type 2
               ?>




            </div> <!-- cate_  type2 --> 
          <?php } // foreach ($library_type_2 ?>

          </div>
        </div>






      </div> <!-- id="lby-doc" -->

      

    </div>

    <br>
    <br>
</section>

<script type="text/javascript">
  function downloadFile(val) {
    var library = val.getAttribute("library-id");
    if (library != "") {
      $.ajax({
        url: 'downloadFile',
        data: {
          library: library,
        },
        type: 'POST',
        success: function(data) {

          if (data != "error") {          
            var req = new XMLHttpRequest();
            req.open('HEAD', data, false);
            req.send();
            if (req.status==200) {
              filePath = data;
              var link = document.createElement('a');
              link.href = filePath;
              link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
              link.click();
            }else{
              if ("<?php echo Yii::app()->session['lang']; ?>" == "1") {
 
                  var text_title = 'Waiting';
                  var text_text = 'File not found!';
                } else {
  
                  var text_title = 'แจ้งเตือน';
                  var text_text = '!ไม่พบไฟล์';
                }
                swal({
                  title: text_title,
                  text: text_text,
                });
            }
          } else {
            alert("ทำรายการใหม่");
          }
        },
      });
    }
  }

  function downloadRequest(val) {
    var library = val.getAttribute("library-id");
    var class_btn = val.getAttribute("class");

    if (class_btn == "btn btn-warning") {
      if (<?= Yii::app()->session['lang'] ?> == 1) {
         var text_text = "Cancel";
      } else {
         var text_text = "ที่จะยกเลิกการขอดาวน์โหลด";
      }
      // var text_text = "ที่จะยกเลิกการขอดาวน์โหลด"
    } else {
      if (<?= Yii::app()->session['lang'] ?> == 1) {
         var text_text = "Download";
      } else {
         var text_text = "ที่จะขอดาวน์โหลด";
      }
      // var text_text = "ที่จะขอดาวน์โหลด";
    }

    if (<?= Yii::app()->session['lang'] ?> == 1) {
      var text_title = "Confirm";
      var text_btn_con = "Confirm";
      var text_btn_can = "Cancel";
    } else {
     var text_title = "ยืนยันใช่ไหม";
     var text_btn_con = "ยืนยัน";
     var text_btn_can = "ยกเลิก";
   }

    if (library != "") {
      swal({
        title: text_title,
        text: text_text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: text_btn_con,
        cancelButtonText: text_btn_can
      }, function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: 'downloadRequest',
            data: {
              library: library,
            },
            type: 'POST',
            success: function(data) {
              if (data == "error") {
                alert("ทำรายการใหม่");
              } else if (data == "request") {
                val.removeAttribute("class");
                val.setAttribute("class", "btn btn-warning");

                if ("<?php echo Yii::app()->session['lang']; ?>" == "1") {
                  val.innerHTML = '<i class="fa fa-download"></i> Waiting';
                  var text_title = 'Waiting';
                  var text_text = 'Admin';
                } else {
                  val.innerHTML = '<i class="fa fa-download"></i> รอการอนุมัติ';
                  var text_title = 'รอการอนุมัติ';
                  var text_text = 'จากผู้ดูแลระบบ';
                }

                swal({
                  title: text_title,
                  text: text_text,
                  type: 'info',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  // cancelButtonColor: '#d33',
                  confirmButtonText: text_btn_con,
                  // cancelButtonText: 'ยกเลิก'
                });

              } else if (data == "cancel") {
                val.removeAttribute("class");
                val.setAttribute("class", "btn btn-info");
                if ("<?php echo Yii::app()->session['lang']; ?>" == "1") {
                  val.innerHTML = '<i class="fa fa-download"></i> Request Download';
                } else {
                  val.innerHTML = '<i class="fa fa-download"></i> ขอดาวน์โหลด';
                }
              } else {
                var req = new XMLHttpRequest(); 
                req.open('HEAD', data, false);
                req.send();
                if (req.status==200) {
                  filePath = data;
                  var link = document.createElement('a');
                  link.href = filePath;
                  link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
                  link.click();
                }else{
                  if ("<?php echo Yii::app()->session['lang']; ?>" == "1") {
 
                  var text_title = 'Waiting';
                  var text_text = 'File not found!';
                } else {
  
                  var text_title = 'แจ้งเตือน';
                  var text_text = '!ไม่พบไฟล์';
                }
                swal({
                  title: text_title,
                  text: text_text,
                });
                }
            }
            },
          });
        }
      });

    }
  }



  $( document ).ready(function() {
    <?php if(isset($_GET['cate_1'])){
      ?>
      // $('button[data-filter="cate-all-1"]').click();
      $(".cate-all-1").hide();
      $(".text-h3").html("ค้นหา");
      $(".search-all-1").show();
      <?php
    }elseif(isset($_GET['cate_2'])){
      ?>
      // $('button[data-filter="cate-all-2"]').click();
      $(".cate-all-2").hide();
      $(".text-h3").html("ค้นหา");
      $(".search-all-2").show();
      <?php
    }else{
      ?>
      $('button[data-filter="cate-all-2"]').click();      
      <?php
    }
    ?>
  });

  function tab_cate(val, cate_type){
    $(".search-all-2").hide();
    $(".search-all-1").hide();
    if(cate_type == 1){
      $('button[data-filter="cate-all-1"]').click();
    }else if(cate_type == 2){
      $('button[data-filter="cate-all-2"]').click();
    }
  }

  $(".tab-btn-cate-type").click(function() {
    $(".search-all-2").hide();
    $(".search-all-1").hide();

    $('.filter-active').each(function(){
      $(this).removeClass("filter-active");

    });
    $(this).addClass("filter-active");
    $(".text-h3").html($(this).html());
    // console.log($(this).html());
  });
</script>