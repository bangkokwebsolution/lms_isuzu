<?php
$titleName = 'รายชื่อผู้เรียน';
$this->breadcrumbs = array($titleName);

$url_form = $this->createUrl('Coursecontrol/Manageorguser/' . $_GET['id']);

$url_delAll = $this->createUrl('Coursecontrol/delAll/' . $_GET['id']);
?>
<style>
  .w-100 {
    width: 100% !important;
  }

  .dataTables_filter {
    text-align: right;
  }

  .head-sec2 {
    display: flex;
    justify-content: space-between;
    margin: 8px 0px 14px 0px;
  }

  .head-sec2 .wrap {
    display: flex;
    flex-direction: row-reverse;
    column-gap: 12px;
  }

  .head-sec2 .span6 {
    display: none !important;
  }
</style>
<div class="innerLR">

  <!-- <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName; ?></h4>
    </div>
    <div class="widget-body">
      <div class="clear-div"></div>
      <div class="overflow-table">
        <table class="table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable ui-sortable" id="table_datatable">
          <thead>
          <tr>
		  <th>ลำดับ</th>
            <th>ชือ-นามสกุล</th>
            <th>รหัสพนักงาน</th>
            <th>ลำดับชั้นงาน</th>
            <th>ตำแหน่งงาน</th>
            <th>section name</th>
            <th>จัดการ</th>
          </tr>
          </thead>
          <tbody>
           <tr>
            <td><input class="select-on-check-all" type="checkbox" value="1" name="chk_all" id="chk_all"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td></td>
            <td></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div> -->

  <!--  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายชื่อผู้เรียนทั้งหมด</h4>
    </div>
    <div class="widget-body">
      <div class="clear-div"></div>
      <div class="overflow-table">
        <table class="table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable ui-sortable" id="table_datatable">
          <thead>
          <tr>
		  <th>ลำดับ</th>
            <th>ชือ-นามสกุล</th>
            <th>รหัสพนักงาน</th>
            <th>ลำดับชั้นงาน</th>
            <th>ตำแหน่งงาน</th>
            <th>section name</th>
            <th>จัดการ</th>
          </tr>
          </thead>
          <tbody>
           <tr>
            <td><input class="select-on-check-all" type="checkbox" value="1" name="chk_all" id="chk_all"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td><input class="w-100" name="LibraryFile[library_name_en]" type="text" maxlength="255"></td>
            <td></td>
            <td></td>
           </tr>
           <tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr><tr>
           <td class="checkbox-column"><input class="select-on-check" value="120" id="chk_0" type="checkbox" name="chk[]"></td>
            <td>text</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td><a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ" href="/lms_isuzu/admin/index.php/libraryFile/delete/120"><i></i></a></td>
           </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="pull-left" style=margin-top:14px;>
      <a class="btn btn-icon btn-success" id="add-section"><i class="glyphicon glyphicon-plus"></i> เพิ่มสมาชิก</a>					
    </div>
					
  </div> -->

  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> หลักสูตร</h4>
    </div>

    <div class="widget-body">

      <div id="user_list_wrapper" class="dataTables_wrapper form-inline" role="grid">
        <div class="head-sec2">
          <button type="submit" class="btn btn-success">+ เพิ่มหลักสูตร</button>
          <div class="wrap">
            <div class="group">
              <div id="user_list_length" class="dataTables_length d-flex align-item-center"><label>แสดงแถว: </label><select size="1" name="user_list_length" aria-controls="user_list">
                  <option value="10" selected="selected">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                </select></div>
            </div>
            <div class="group">
              <div class="dataTables_filter" id="user_list_filter"><label>Search: <input type="text" aria-controls="user_list"></label></div>
            </div>
          </div>
        </div>

        <div class="clear-div"></div>
        <div class="overflow-table">
          <div style="margin-top: -1px;" id="Division-grid" class="grid-view">
            <table class="table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable ui-sortable">
              <thead>
                <tr role="row">
                  <th class="sorting" role="columnheader" rowspan="1" colspan="1" aria-label="ลำดับ" style="width: 70.4px;">รูปภาพ</th>
                  <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="ชื่อ - นามสกุล: activate to sort column ascending" style="width: 200.4px;">ชื่อหลักสูตรอบรมออนไลน์ (ภาษา EN)</th>
                  <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="รหัสพนักงาน: activate to sort column ascending" style="width: 191.4px;">หมวดอบรมออนไลน์ (ภาษา EN)</th>
                  <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="ลำดับชั้นงาน: activate to sort column ascending" style="width: 189.4px;">ย้าย</th>
                  <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="ตำแหน่งงาน: activate to sort column ascending" style="width: 183.4px;">เพิ่ม / ลบ ผู้เรียน</th>
                  <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="จัดการ: activate to sort column ascending" style="width: 43.4px;"></th>
                </tr>
                <tr class="filters">
                  <td></td>
                  <td><input name="OrgChart[id]" type="text" style="width: 100%;"></td>
                  <td><input name="OrgChart[title]" type="text" style="width: 100%;" maxlength="255"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </thead>
              <tbody>
                <tr class="items[]_2">
                  <td style="text-align:center;">
                    <img src="https://cdn.pixabay.com/photo/2023/05/14/17/46/ducklings-7993465_1280.jpg" alt="" srcset="">
                  </td>
                  <td>Lorem ipsum dolor sit amet.</td>
                  <td>Lorem ipsum dolor sit amet consectetur.</td>

                  <td style="text-align: center;">
                  </td>
                  <td class="text-center" style="text-align: center; "><button type="submit" class="btn btn-danger">+ เพิ่มหลักสูตร</button></td>
                  <td style="text-align: center;">
                    <a class="btn-action glyphicons bin btn-danger" title="แก้ไข" href="/lms_isuzu/admin/index.php/Orgmanage/Division_update/2"><i></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="keys" style="display:none" title="/lms_isuzu/admin/index.php/Orgmanage/Division"><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span></div>
            <input type="hidden" name="Division[news_per_page]" value="">
          </div>
        </div>

        <!--  <table class="table table-bordered dataTable-Orguser table-primary dataTable" id="user_list" aria-describedby="user_list_info">
          <thead>
            <tr role="row">
              <th class="sorting" role="columnheader" rowspan="1" colspan="1" aria-label="ลำดับ" style="width: 70.4px;">รูปภาพ</th>
              <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="ชื่อ - นามสกุล: activate to sort column ascending" style="width: 200.4px;">ชื่อหลักสูตรอบรมออนไลน์ (ภาษา EN)</th>
              <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="รหัสพนักงาน: activate to sort column ascending" style="width: 191.4px;">หมวดอบรมออนไลน์ (ภาษา EN)</th>
              <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="ลำดับชั้นงาน: activate to sort column ascending" style="width: 189.4px;">ย้าย</th>
              <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="ตำแหน่งงาน: activate to sort column ascending" style="width: 183.4px;">เพิ่ม / ลบ ผู้เรียน</th>
              <th class="sorting" role="columnheader" tabindex="0" aria-controls="user_list" rowspan="1" colspan="1" aria-label="จัดการ: activate to sort column ascending" style="width: 43.4px;"></th>
            </tr>
            <tr class="filters">
              <td></td>
              <td><input name="OrgChart[id]" type="text" style="width: 100%;"></td>
              <td><input name="OrgChart[title]" type="text" style="width: 100%;" maxlength="255"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </thead>

          <tbody role="alert" aria-live="polite" aria-relevant="all">
            <tr class="items[]_2">
              <td style="text-align:center;">
                <img src="https://cdn.pixabay.com/photo/2023/05/14/17/46/ducklings-7993465_1280.jpg" alt="" srcset="">
              </td>
              <td>Lorem ipsum dolor sit amet.</td>
              <td>Lorem ipsum dolor sit amet consectetur.</td>
              
              <td style="text-align: center;" >
              </td>
              <td class="text-center" style="text-align: center; "><button type="submit" class="btn btn-danger">+ เพิ่มหลักสูตร</button></td>
              <td style="text-align: center;" >
                <a class="btn-action glyphicons bin btn-danger" title="แก้ไข" href="/lms_isuzu/admin/index.php/Orgmanage/Division_update/2"><i></i></a>
              </td>
            </tr>
          
          </tbody>
        </table> -->

      </div>
    </div>

  </div>

  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName; ?></h4>
    </div>

    <div class="widget-body">

      <table class="table table-bordered dataTable-Orguser table-primary" id="user_list">
        <thead>
          <tr>
            <!-- <th width="5%"></th> -->
            <th width="5%">ลำดับ</th>
            <th>ชื่อ - นามสกุล</th>
            <th>รหัสพนักงาน</th>
            <th>ลำดับชั้นงาน</th>
            <th>ตำแหน่งงาน</th>
            <th>Section Name</th>
            <th width="5%">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $num = 1;
          foreach ($user as $key => $value) {
          ?>
            <tr>
              <!-- <td><input type="checkbox" name="user_list[]" value="<?= $value->id ?>"></td> -->
              <td style="text-align: center;"><?php echo $num++; ?></td>
              <td><?= $value->profile->firstname . " " . $value->profile->lastname ?></td>
              <td><?= $value->employee_id ?></td>
              <td><?= $value->profile->EmpClass->title ?></td>
              <td><?= $value->profile->EmpClass->descrpition ?></td>
              <td><?= $value->orgchart->title ?></td>
              <td>
                <button type="button" class="btn btn-danger" onclick="if(confirm('แน่ใจว่าต้องการลบ <?= $value->profile->firstname_en . " " . $value->profile->lastname_en ?> ?')){Deleteuser(<?= $value->id ?>);}else{ }">
                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
              </td>
            </tr>
          <?php
          }

          ?>


        </tbody>
      </table>
      <br>
      <a href="<?= $url_delAll ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการล้างข้อมูลทั้งหมดหรือไม่ ?')">- ล้างทั้งหมด</a>
    </div>

  </div>

  <div class="widget" style="margin-top: -1px;">
    <div class="widget-head">
      <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายชื่อผู้เรียนทั้งหมด</h4>
    </div>

    <div class="widget-body">
      <form action="<?= $url_form ?>" method="GET">
        <table class="table table-bordered dataTable-Orguser table-primary" id="user_list">
          <thead>
            <tr>
              <th width="5%" align="center"><input type="checkbox" id="chkAll" /></th>
              <th width="5%">ลำดับ</th>
              <th>ชื่อ - นามสกุล</th>
              <th>รหัสพนักงาน</th>
              <th>ลำดับชั้นงาน</th>
              <th>ตำแหน่งงาน</th>
              <th>Section Name</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $num = 1;
            foreach ($userAll as $key => $value) {
            ?>
              <tr>
                <td align="center"><input type="checkbox" class="chk" name="user_list[]" value="<?= $value->id ?>"></td>
                <td style="text-align: center;"><?php echo $num++; ?></td>
                <td><?= $value->profile->firstname . " " . $value->profile->lastname ?></td>
                <td><?= $value->employee_id ?></td>
                <td><?= $value->profile->EmpClass->title ?></td>
                <td><?= $value->profile->EmpClass->descrpition ?></td>
                <td><?= $value->orgchart->title ?></td>
              </tr>
            <?php
            }



            ?>
          </tbody>
        </table>
        <br>
        <button type="submit" class="btn btn-success">+ เพิ่มผู้เรียน</button>
      </form>
    </div>

  </div>







</div>




<script type="text/javascript">
  function Deleteuser(user) {
    if (user != "") {
      $.ajax({
        type: 'POST',
        url: '<?= $url_form ?>',
        data: ({
          user_id: user,
        }),
        success: function(data) {
          if (data == "success") {
            location.reload();
          }
        }
      });
    }
  }

  $(document).ready(function() {
    $('.dataTable-Orguser').DataTable({
      aoColumnDefs: [{
        bSortable: false,
        aTargets: [0]
      }]
    }); //datatable


    $("#chkAll").click(function() {
      $(".chk").prop("checked", $("#chkAll").prop("checked"))

    }); //chkall


  });
</script>