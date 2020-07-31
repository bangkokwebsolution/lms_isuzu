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
          echo "Library";
        } else {
          echo "ห้องสมุด";
        }
        ?>
      </li>
    </ol>
  </nav>
</div>
<?php $arr_type_video = array("mp4", "mkv"); ?>
<section class="content" id="library-group">

  <div class="container">
    <ul class="nav nav-tabs">
      <li <?php if(isset($_GET['cate_2'])){ echo 'class="active"'; }elseif(!isset($_GET['cate_1'])){ echo 'class="active"'; } ?>>
        <a data-toggle="tab" href="#lby-doc" onclick="tab_cate(this, 2);">ห้องสมุดประเภทเอกสาร</a>
      </li>
      <li <?php if(isset($_GET['cate_1'])){ echo 'class="active"'; } ?>>
        <a data-toggle="tab" href="#lby-multi" onclick="tab_cate(this, 1);">ห้องสมุดประเภทมัลติมีเดีย</a>
      </li>
    </ul>

    <div class="tab-content">

      <div id="lby-doc" class="tab-pane fade <?php if(isset($_GET['cate_2'])){ echo 'in active'; }elseif(!isset($_GET['cate_1'])){ echo 'in active'; } ?>">
        <div class="row">
          <div class="col-sm-4 col-md-3 col-xs-12">
            <h4 class="library-topic"><i class="fas fa-list"></i> รายการห้องสมุดเอกสาร </h4>
            <form id="searchForm" action="<?php echo $this->createUrl('video/library'); ?>" method="GET">
              <div class="input-group">
                <input type="text" class="form-control" name="cate_2" value="<?= $_GET['cate_2'] ?>" placeholder=' <?php if (Yii::app()->session['lang'] == 1) { echo "Search"; } else { echo "ค้นหา"; } ?>'>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                      echo "Search";
                    } else {
                      echo "ค้นหา";
                    }
                    ?>
                  </button>
                </span>
              </div>
            </form>

            <div class="type-menu gallery">
              <button class="tab-btn-cate-type btn btn-default filter-button btn-lg" data-filter="cate-all-2">ทั้งหมด</button>
              <?php 
              foreach ($library_type_2 as $key => $value) {
                if (Yii::app()->session['lang'] == 1) {
                  $libra_type = $value->library_type_name_en;
                } else {
                  $libra_type = $value->library_type_name;
                }
                ?>
                <button style="white-space: normal;" class="tab-btn-cate-type btn btn-default filter-button btn-lg" data-filter="cate_<?= $value->library_type_id ?>"><?= $libra_type ?></button>
                <?php } // foreach ($library_type_2 ?>              
            </div>
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

                $req_library = LibraryRequest::model()->find(array(
                  'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                  'params' => array(':active' => 'y', ':library_id' => $value->library_id, ':user_id' => Yii::app()->user->id),
                ));
                if ($req_library != "") {
                  if ($req_library->req_status == 1) {
                    $text_class = "btn btn-warning";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Waiting";
                    } else {
                      $text_status = "รอการอนุมัติ";
                    }
                  } elseif ($req_library->req_status == 2) {
                    $text_class = "btn btn-success";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Download";
                    } else {
                      $text_status = "ดาวน์โหลด";
                    }
                  }
                  if ($req_library->req_status == 3) {
                    $text_class = "btn btn-danger";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Reject";
                    } else {
                      $text_status = "ไม่อนุมัติ";
                    }
                  }
                } else {
                  $text_class = "btn btn-info";
                  if (Yii::app()->session['lang'] == 1) {
                    $text_status = "Request Download";
                  } else {
                    $text_status = "ขอดาวน์โหลด";
                  }
                }

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  // var_dump($check_file); exit();
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class="well text-center">
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
                  <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="well text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp3'>
                              </video>

                              <!-- <a href="" class=""> -->
                                <!-- <span class="other-file"> -->
                                  <!-- <i class="fas fa-file-audio audio"></i>&nbsp;<small>Audio</small> -->
                                  <!-- </span> -->
                          <!-- <img src="<?php //echo Yii::app()->theme->baseUrl; 
                          ?>/images/other-library.png" class="img-fluid "> -->
                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                                <div class="text-center">
                                  <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                    <i class="fa fa-download"></i> <?= $text_status ?>
                                  </button>
                                </div>
                          </div>
                          <!-- </a> -->
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
                    <div class="well text-center">
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
                  <div class="well text-center">
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
                  <div class="well text-center">
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
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class="well text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
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
              } // foreach ($library_file_2
                   ?>                
            </div> <!-- cate-all-2 -->


            <!-- search all 2 -->
            <?php if(isset($_GET['cate_2'])){ ?>
              <div class="gallery_product  filter search-all-2">  
                  <?php 
                  foreach ($library_file_search as $key => $value) {
                    if (Yii::app()->session['lang'] == 1) {
                  $libra_file = $value->library_name_en;
                } else {
                  $libra_file = $value->library_name;
                }

                $req_library = LibraryRequest::model()->find(array(
                  'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                  'params' => array(':active' => 'y', ':library_id' => $value->library_id, ':user_id' => Yii::app()->user->id),
                ));
                if ($req_library != "") {
                  if ($req_library->req_status == 1) {
                    $text_class = "btn btn-warning";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Waiting";
                    } else {
                      $text_status = "รอการอนุมัติ";
                    }
                  } elseif ($req_library->req_status == 2) {
                    $text_class = "btn btn-success";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Download";
                    } else {
                      $text_status = "ดาวน์โหลด";
                    }
                  }
                  if ($req_library->req_status == 3) {
                    $text_class = "btn btn-danger";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Reject";
                    } else {
                      $text_status = "ไม่อนุมัติ";
                    }
                  }
                } else {
                  $text_class = "btn btn-info";
                  if (Yii::app()->session['lang'] == 1) {
                    $text_status = "Request Download";
                  } else {
                    $text_status = "ขอดาวน์โหลด";
                  }
                }

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  // var_dump($check_file); exit();
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class="well text-center">
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
                  <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="well text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp3'>
                              </video>

                              <!-- <a href="" class=""> -->
                                <!-- <span class="other-file"> -->
                                  <!-- <i class="fas fa-file-audio audio"></i>&nbsp;<small>Audio</small> -->
                                  <!-- </span> -->
                          <!-- <img src="<?php //echo Yii::app()->theme->baseUrl; 
                          ?>/images/other-library.png" class="img-fluid "> -->
                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                                <div class="text-center">
                                  <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                    <i class="fa fa-download"></i> <?= $text_status ?>
                                  </button>
                                </div>
                          </div>
                          <!-- </a> -->
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
                    <div class="well text-center">
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
                  <div class="well text-center">
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
                  <div class="well text-center">
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
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class="well text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
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
              } // foreach ($library_file_2
                   ?>                
            </div> <!-- cate-all-2 -->
            <?php } ?>
            <!-- search all 2 -->


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

              foreach ($library_file as $key => $value) {
                    if (Yii::app()->session['lang'] == 1) {
                  $libra_file = $value->library_name_en;
                } else {
                  $libra_file = $value->library_name;
                }

                $req_library = LibraryRequest::model()->find(array(
                  'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                  'params' => array(':active' => 'y', ':library_id' => $value->library_id, ':user_id' => Yii::app()->user->id),
                ));
                if ($req_library != "") {
                  if ($req_library->req_status == 1) {
                    $text_class = "btn btn-warning";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Waiting";
                    } else {
                      $text_status = "รอการอนุมัติ";
                    }
                  } elseif ($req_library->req_status == 2) {
                    $text_class = "btn btn-success";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Download";
                    } else {
                      $text_status = "ดาวน์โหลด";
                    }
                  }
                  if ($req_library->req_status == 3) {
                    $text_class = "btn btn-danger";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Reject";
                    } else {
                      $text_status = "ไม่อนุมัติ";
                    }
                  }
                } else {
                  $text_class = "btn btn-info";
                  if (Yii::app()->session['lang'] == 1) {
                    $text_status = "Request Download";
                  } else {
                    $text_status = "ขอดาวน์โหลด";
                  }
                }

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  // var_dump($check_file); exit();
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class="well text-center">
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
                  <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="well text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp3'>
                              </video>

                              <!-- <a href="" class=""> -->
                                <!-- <span class="other-file"> -->
                                  <!-- <i class="fas fa-file-audio audio"></i>&nbsp;<small>Audio</small> -->
                                  <!-- </span> -->
                          <!-- <img src="<?php //echo Yii::app()->theme->baseUrl; 
                          ?>/images/other-library.png" class="img-fluid "> -->
                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                              <div class="text-center">
                                <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                  <i class="fa fa-download"></i> <?= $text_status ?>
                                </button>
                              </div>
                          </div>
                          <!-- </a> -->
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
                    <div class="well text-center">
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
                  <div class="well text-center">
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
                  <div class="well text-center">
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
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class="well text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
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
              } // foreach ($library_file type 2
               ?>




            </div> <!-- cate_  type2 --> 
          <?php } // foreach ($library_type_2 ?>

          </div>
        </div>






      </div> <!-- id="lby-doc" -->

      <div id="lby-multi" class="tab-pane fade <?php if(isset($_GET['cate_1'])){ echo 'in active'; } ?>">
        <div class="row">
          <div class="col-sm-4 col-md-3 col-xs-12">

            <h4 class="library-topic">
              <i class="fas fa-list"></i>
              รายการห้องสมุดมัลติมีเดีย
            </h4>

            <form id="searchForm" action="<?php echo $this->createUrl('video/library') ?>" method="GET">
              <div class="input-group">
                <input type="text" class="form-control" name="cate_1" value="<?= $_GET['cate_1'] ?>" placeholder=' <?php if (Yii::app()->session['lang'] == 1) { echo "Search"; } else { echo "ค้นหา"; } ?>'>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span>
                    <?php
                    if (Yii::app()->session['lang'] == 1) {
                      echo "Search";
                    } else {
                      echo "ค้นหา";
                    }
                    ?>
                  </button>
                </span>
              </div>
            </form>

            <div class="type-menu gallery">
              <button class="tab-btn-cate-type btn btn-default filter-button btn-lg" data-filter="cate-all-1">ทั้งหมด</button>
              <?php 
              foreach ($library_type_1 as $key => $value) {
                if (Yii::app()->session['lang'] == 1) {
                  $libra_type = $value->library_type_name_en;                  
                } else {
                  $libra_type = $value->library_type_name;
                }
                ?>
                <button style="white-space: normal;" class="tab-btn-cate-type btn btn-default filter-button btn-lg" data-filter="cate_<?= $value->library_type_id ?>"><?= $libra_type ?></button>
                <?php
              } // foreach ($library_type_1

               ?>
              
            </div>
            </div>




            <div class="col-sm-8 col-md-9 col-xs-12">
            <h3 class="text-h3"><!-- ชื่อกลุ่มของมัลติมีเดีย --></h3>
            <hr class="mt-1 mb-3">

            <div class="gallery_product  filter cate-all-1">  

                  <?php 
                  foreach ($library_file_1 as $key => $value) {
                    if (Yii::app()->session['lang'] == 1) {
                  $libra_file = $value->library_name_en;
                } else {
                  $libra_file = $value->library_name;
                }

                $req_library = LibraryRequest::model()->find(array(
                  'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                  'params' => array(':active' => 'y', ':library_id' => $value->library_id, ':user_id' => Yii::app()->user->id),
                ));
                if ($req_library != "") {
                  if ($req_library->req_status == 1) {
                    $text_class = "btn btn-warning";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Waiting";
                    } else {
                      $text_status = "รอการอนุมัติ";
                    }
                  } elseif ($req_library->req_status == 2) {
                    $text_class = "btn btn-success";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Download";
                    } else {
                      $text_status = "ดาวน์โหลด";
                    }
                  }
                  if ($req_library->req_status == 3) {
                    $text_class = "btn btn-danger";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Reject";
                    } else {
                      $text_status = "ไม่อนุมัติ";
                    }
                  }
                } else {
                  $text_class = "btn btn-info";
                  if (Yii::app()->session['lang'] == 1) {
                    $text_status = "Request Download";
                  } else {
                    $text_status = "ขอดาวน์โหลด";
                  }
                }

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  // var_dump($check_file); exit();
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class="well text-center">
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
                  <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="well text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp3'>
                              </video>

                              <!-- <a href="" class=""> -->
                                <!-- <span class="other-file"> -->
                                  <!-- <i class="fas fa-file-audio audio"></i>&nbsp;<small>Audio</small> -->
                                  <!-- </span> -->
                          <!-- <img src="<?php //echo Yii::app()->theme->baseUrl; 
                          ?>/images/other-library.png" class="img-fluid "> -->
                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                            <div class="text-center">
                              <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                              <i class="fa fa-download"></i> <?= $text_status ?>
                            </button>
                            </div>
                          </div>
                          <!-- </a> -->
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
                    <div class="well text-center">
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
                  <div class="well text-center">
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
                  <div class="well text-center">
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
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class="well text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
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
              } // foreach ($library_file_1
                   ?>                
            </div> <!-- cate-all-1 -->



            <!-- search cate1 -->
            <?php if(isset($_GET['cate_1'])){ ?>
            <div class="gallery_product  filter search-all-1">  

                  <?php 
                  foreach ($library_file_search as $key => $value) {
                    if (Yii::app()->session['lang'] == 1) {
                  $libra_file = $value->library_name_en;
                } else {
                  $libra_file = $value->library_name;
                }

                $req_library = LibraryRequest::model()->find(array(
                  'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                  'params' => array(':active' => 'y', ':library_id' => $value->library_id, ':user_id' => Yii::app()->user->id),
                ));
                if ($req_library != "") {
                  if ($req_library->req_status == 1) {
                    $text_class = "btn btn-warning";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Waiting";
                    } else {
                      $text_status = "รอการอนุมัติ";
                    }
                  } elseif ($req_library->req_status == 2) {
                    $text_class = "btn btn-success";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Download";
                    } else {
                      $text_status = "ดาวน์โหลด";
                    }
                  }
                  if ($req_library->req_status == 3) {
                    $text_class = "btn btn-danger";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Reject";
                    } else {
                      $text_status = "ไม่อนุมัติ";
                    }
                  }
                } else {
                  $text_class = "btn btn-info";
                  if (Yii::app()->session['lang'] == 1) {
                    $text_status = "Request Download";
                  } else {
                    $text_status = "ขอดาวน์โหลด";
                  }
                }

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  // var_dump($check_file); exit();
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class="well text-center">
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
                  <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="well text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp3'>
                              </video>

                              <!-- <a href="" class=""> -->
                                <!-- <span class="other-file"> -->
                                  <!-- <i class="fas fa-file-audio audio"></i>&nbsp;<small>Audio</small> -->
                                  <!-- </span> -->
                          <!-- <img src="<?php //echo Yii::app()->theme->baseUrl; 
                          ?>/images/other-library.png" class="img-fluid "> -->
                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                            <div class="text-center">
                              <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                              <i class="fa fa-download"></i> <?= $text_status ?>
                            </button>
                            </div>
                          </div>
                          <!-- </a> -->
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
                    <div class="well text-center">
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
                  <div class="well text-center">
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
                  <div class="well text-center">
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
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class="well text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
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
              } // foreach ($library_file_1
                   ?>                
            </div> <!-- cate-all-1 -->
          <?php } ?>
            <!-- search cate1 -->









            <?php 
            foreach ($library_type_1 as $key_t => $value_t) {
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

              foreach ($library_file as $key => $value) {
                    if (Yii::app()->session['lang'] == 1) {
                  $libra_file = $value->library_name_en;
                } else {
                  $libra_file = $value->library_name;
                }

                $req_library = LibraryRequest::model()->find(array(
                  'condition' => 'active=:active AND user_id=:user_id AND library_id=:library_id',
                  'params' => array(':active' => 'y', ':library_id' => $value->library_id, ':user_id' => Yii::app()->user->id),
                ));
                if ($req_library != "") {
                  if ($req_library->req_status == 1) {
                    $text_class = "btn btn-warning";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Waiting";
                    } else {
                      $text_status = "รอการอนุมัติ";
                    }
                  } elseif ($req_library->req_status == 2) {
                    $text_class = "btn btn-success";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Download";
                    } else {
                      $text_status = "ดาวน์โหลด";
                    }
                  }
                  if ($req_library->req_status == 3) {
                    $text_class = "btn btn-danger";
                    if (Yii::app()->session['lang'] == 1) {
                      $text_status = "Reject";
                    } else {
                      $text_status = "ไม่อนุมัติ";
                    }
                  }
                } else {
                  $text_class = "btn btn-info";
                  if (Yii::app()->session['lang'] == 1) {
                    $text_status = "Request Download";
                  } else {
                    $text_status = "ขอดาวน์โหลด";
                  }
                }

                $type_ex = explode(".", $value->library_filename);
                $extension = $type_ex[count($type_ex) - 1];

                if (in_array($extension, $arr_type_video)) {

                  $check_file = glob(Yii::app()->getUploadPath(null) . "../LibraryFile/*");
                  // var_dump($check_file); exit();
                  foreach ($check_file as $keyy => $valuee) {
                    if (basename($valuee) == $value->library_filename) {
              ?>
              <div class="col-sm-6 col-md-4 col-xs-12">
                <div class="well text-center">
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
                  <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="well text-center">
                      <div class="library-item">
                        <div class="item item-library-index">
                          <div class="library-card">

                            <video class="video-js" poster="" controls controlsList="nodownload" preload="auto" style="width: 100%; height: 150px;">
                              <source src="../uploads/LibraryFile/<?= $value->library_filename ?>" type='video/mp3'>
                              </video>

                              <!-- <a href="" class=""> -->
                                <!-- <span class="other-file"> -->
                                  <!-- <i class="fas fa-file-audio audio"></i>&nbsp;<small>Audio</small> -->
                                  <!-- </span> -->
                          <!-- <img src="<?php //echo Yii::app()->theme->baseUrl; 
                          ?>/images/other-library.png" class="img-fluid "> -->
                          <div class="library-detail">
                            <span><?= $libra_file ?></span>
                              <div class="text-center">
                                 <button class="<?= $text_class ?>"  onclick="downloadRequest(this)" library-id="<?= $value->library_id ?>">
                                <i class="fa fa-download"></i> <?= $text_status ?>
                              </button>
                            </div>
                          </div>
                          <!-- </a> -->
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
                    <div class="well text-center">
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
                  <div class="well text-center">
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
                  <div class="well text-center">
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
                <div class="col-sm-6 col-md-4 col-xs-12">
                  <div class="well text-center">
                    <div class="library-item">
                      <div class="item item-library-index">
                        <div class="library-card">
                          <a href="javascript:void(0)" onclick="downloadFile(this)" class="" library-id="<?= $value->library_id ?>">
                            <span class="other-file">
                              <i class="fas fa-file-pdf pdf"></i>&nbsp;<small>PDF</small>
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
              } // foreach ($library_file type 1
               ?>




            </div> <!-- cate_  type1 --> 
          <?php } // foreach ($library_type_1 ?>

          </div>






          </div>

      </div> <!-- id="lby-multi" -->

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
            filePath = data;
            var link = document.createElement('a');
            link.href = filePath;
            link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
            link.click();
            // window.open(data, 'Download');
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
      var text_text = "ที่จะยกเลิกการขอดาวน์โหลด"
    } else {
      var text_text = "ที่จะขอดาวน์โหลด";
    }

    if (library != "") {
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
                  val.innerHTML = '<i class="fa fa-download"></i> waiting';
                } else {
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

              } else if (data == "cancel") {
                val.removeAttribute("class");
                val.setAttribute("class", "btn btn-info");
                if ("<?php echo Yii::app()->session['lang']; ?>" == "1") {
                  val.innerHTML = '<i class="fa fa-download"></i> Request Download';
                } else {
                  val.innerHTML = '<i class="fa fa-download"></i> ขอดาวน์โหลด';
                }
              } else {
                filePath = data;
                var link = document.createElement('a');
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