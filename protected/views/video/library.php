
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-main">
      <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">
        <?php 
        if(Yii::app()->session['lang'] == 1){
          echo "Library";
        }else{
          echo "ห้องสมุด";
        }
         ?>
    </li>
    </ol>
  </nav>
</div>

<section class="content" id="video-library">
  <?php 
  $arr_type_video = array("mp4", "mkv");

  foreach ($library_type as $key => $value) {
    if(Yii::app()->session['lang'] == 1){
      $libra_type = $value->library_type_name_en;
    }else{
      $libra_type = $value->library_type_name;
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <h3 class="">
               <?= $libra_type ?>
              </h3>
                <hr class="mt-1 mb-3">
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="library-main owl-carousel owl-theme">
                  <?php 
                  $library_file = libraryFile::model()->findAll(array(
                    'condition' => 'active=:active AND library_type_id=:library_type_id',
                    'params' => array(':active' => 'y', ':library_type_id'=>$value->library_type_id),
                    'order' => 'sortOrder ASC'
                  ));
                   foreach ($library_file as $key => $value) {
                    if(Yii::app()->session['lang'] == 1){
                      $libra_file = $value->library_name_en;
                    }else{
                      $libra_file = $value->library_name;
                    }

                    $req_library = LibraryRequest::model()->find(array(
                      'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                      'params' => array(':active' => 'y', ':library_id'=>$value->library_id, ':user_id'=>Yii::app()->user->id),
                    ));
                    if($req_library != ""){
                      if($req_library->req_status == 1){
                        $text_class = "btn btn-warning";
                        if(Yii::app()->session['lang'] == 1){
                          $text_status = "Waiting";
                        }else{
                          $text_status = "รอการอนุมัติ";
                        }
                      }elseif($req_library->req_status == 2){
                        $text_class = "btn btn-success";
                        if(Yii::app()->session['lang'] == 1){
                          $text_status = "Download";
                        }else{
                          $text_status = "ดาวน์โหลด";
                        }
                      }if($req_library->req_status == 3){
                        $text_class = "btn btn-danger";
                        if(Yii::app()->session['lang'] == 1){
                          $text_status = "Reject";
                        }else{
                          $text_status = "ไม่อนุมัติ";
                        }
                      }
                    }else{
                      $text_class = "btn btn-info";
                      if(Yii::app()->session['lang'] == 1){
                        $text_status = "Request Download";
                      }else{
                        $text_status = "ขอดาวน์โหลด";
                      }
                    }

                      $type_ex = explode(".", $value->library_filename);
                      $extension = $type_ex[count($type_ex)-1];

                      if(in_array($extension, $arr_type_video)){
                        ?>
                        <div class="library-item">
                          <div class="item item-library-index">
                            <div class="library-card">
                              <video class="video-js" poster="" controls preload="auto" style="width: 100%; height: 176px;">
                                <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp4'>
                                </video>
                                  <div class="library-detail">
                                    <span><?= $libra_file ?></span>
                                    <button class="<?= $text_class ?>" style="display: block; font-size: 12px;" onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                      <i class="fa fa-download"></i> <?= $text_status ?>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php
                      }elseif($extension == "mp3"){
                        ?>
                        <div class="library-item">
                          <div class="item item-library-index">
                            <div class="library-card">
                              <video class="video-js" poster="" controls preload="auto" style="width: 100%; height: 176px;">
                                <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp3'>
                                </video>
                              <!-- <a href="" class=""> -->
                                <!-- <span class="other-file"> -->
                                  <!-- <i class="fas fa-file-audio audio"></i>&nbsp;<small>Audio</small> -->
                                <!-- </span> -->
                                <!-- <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="img-fluid "> -->
                                <div class="library-detail">
                                  <span><?= $libra_file ?></span>
                                  <button class="<?= $text_class ?>" style="display: block; font-size: 12px;" onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                      <i class="fa fa-download"></i> <?= $text_status ?>
                                    </button>
                                </div>
                              <!-- </a> -->
                            </div>
                          </div>
                        </div>
                        <?php
                      }elseif($extension == "doc" || $extension == "docx"){
                        ?>
                        <div class="library-item">
                          <div class="item item-library-index">
                            <div class="library-card">
                              <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                                <span class="other-file">
                                  <i class="fas fa-file-word word"></i>&nbsp;<small>Word</small>
                                </span>
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="img-fluid ">
                                <div class="library-detail">
                                  <span><?= $libra_file ?></span>
                                </div>
                              </a>
                            </div>
                          </div>
                        </div>
                        <?php
                      }elseif($extension == "xls" || $extension == "xlsx"){
                        ?>
                        <div class="library-item">
                          <div class="item item-library-index">
                            <div class="library-card">
                              <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                                <span class="other-file">
                                  <i class="fas fa-file-excel excel"></i>&nbsp;<small>Excel</small>
                                </span>
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="img-fluid ">
                                <div class="library-detail">
                                  <span><?= $libra_file ?></span>
                                </div>
                              </a>
                            </div>
                          </div>
                        </div>
                        <?php
                      }elseif($extension == "ppt" || $extension == "pptx"){
                        ?>
                        <div class="library-item">
                          <div class="item item-library-index">
                            <div class="library-card">
                              <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                                <span class="other-file">
                                  <i class="fas fa-file-excel powerpoint"></i>&nbsp;<small>PowerPoint</small>
                                </span>
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="img-fluid ">
                                <div class="library-detail">
                                  <span><?= $libra_file ?></span>
                                </div>
                              </a>
                            </div>
                          </div>
                        </div>
                        <?php
                      }elseif($extension == "pdf"){
                        ?>
                        <div class="library-item">
                          <div class="item item-library-index">
                            <div class="library-card">
                              <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                                <span class="other-file">
                                  <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
                                </span>
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/other-library.png" class="img-fluid ">
                                <div class="library-detail">
                                  <span><?= $libra_file ?></span>
                                </div>
                              </a>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                       ?>                                
                                  
                                    


                    <?php
                   }

                   ?>
          
                </div>
            </div>
        </div>
    </div>
    <?php
  }
   ?>
</section>

<script type="text/javascript">
  function downloadFile(val){
    var library = val.getAttribute("library-id");
    if(library != ""){
          $.ajax({
            url : 'downloadFile',
            data : {
              library:library,
            },
            type : 'POST',
            success : function(data){
              if(data != "error"){
                filePath = data;
                var link=document.createElement('a');
                link.href = filePath;
                link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
                link.click();
                // window.open(data, 'Download');
              }else{
                alert("ทำรายการใหม่");
              }                 
            },              
          });
    }
  }

  function downloadRequest(val){
    var library = val.getAttribute("library-id");
    var class_btn = val.getAttribute("class");

    if(class_btn == "btn btn-warning"){
      var text_text = "ที่จะยกเลิกการขอดาวน์โหลด"
    }else{
      var text_text = "ที่จะขอดาวน์โหลด";
    }

    if(library != ""){
      swal({
        title: 'ยืนยันใช่ไหม',
        text: text_text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
      }, function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url : 'downloadRequest',
            data : {
              library:library,
            },
            type : 'POST',
            success : function(data){
              if(data == "error"){
                alert("ทำรายการใหม่");
              }else if(data == "request"){
                val.removeAttribute("class");
                val.setAttribute("class", "btn btn-warning");
                if("<?php echo Yii::app()->session['lang']; ?>" == "1"){
                  val.innerHTML = '<i class="fa fa-download"></i> waiting';                  
                }else{
                  val.innerHTML = '<i class="fa fa-download"></i> รอการอนุมัติ'; 
                }

                swal({
                  title: 'รอการอนุมัติ',
                  text: "จากผู้ดูแลระบบ",
                  type: 'info',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  // cancelButtonColor: '#d33',
                  confirmButtonText: 'ตกลง',
                  // cancelButtonText: 'ยกเลิก'
                });

              }else if(data == "cancel"){
                val.removeAttribute("class");
                val.setAttribute("class", "btn btn-info");
                if("<?php echo Yii::app()->session['lang']; ?>" == "1"){
                  val.innerHTML = '<i class="fa fa-download"></i> Request Download';                  
                }else{
                  val.innerHTML = '<i class="fa fa-download"></i> ขอดาวน์โหลด'; 
                }
              }else{
                filePath = data;
                var link=document.createElement('a');
                link.href = filePath;
                link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
                link.click();
              }                  
            },
          });
        }
      });

    }
  }


</script>
