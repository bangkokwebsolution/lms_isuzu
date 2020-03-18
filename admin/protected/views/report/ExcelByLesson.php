     <?php

         $strExcelFileName = "Export-Data-" . date('Ymd-His') . ".xls";
            header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
            header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
            header('Content-Type: text/plain; charset=UTF-8');
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Pragma:no-cache");

        $search = $_GET['Report'];
        $textsearch = ($search['search']!=null)?'and email like "%'.$search['search'].'%" or profile.firstname like "%'.$search['search'].'%" or profile.lastname like "%'.$search['search'].'%"':null;
        $searchLesson = $search['lesson_id'];
        $searchLessonArray = implode(',', $searchLesson);
        $sqlLessonQuery = ($searchLessonArray!='')?' and id in ('.$searchLessonArray.')':null;
        //generation
        $searchGeneration = $search['generation'];
        $gen = ($searchGeneration!='')?' and generation = "'. $searchGeneration . '"':null;

        //type_user
        $searchTyprUser = $search['type_user'];
        if( !empty($searchTyprUser)) {
                if($searchTyprUser == 1){ //General
                    $texttype .= " AND type_register != '3' ";
                }else if($searchTyprUser == 2){ //Staff
                    $texttype .= " AND type_register = '3' ";

                }
            }

        //Divsion
        if(!empty($search['division_id'])){
            $divisionInarray =  implode(",",$search['division_id']);
            $textsearch .= " and division_id IN ( ".$divisionInarray." )";
        }
            //Department
        if(!empty($search['department'])){
            $departmentInarray =  implode(",",$search['department']);
            $textsearch .= " and department_id IN ( ".$departmentInarray." )";
        }
            //Station
        if(!empty($search['station'])){
            $stationInarray =  implode(",",$search['station']);
            $textsearch .= " and station_id IN ( ".$stationInarray." )";
        }

        //period
        $period_start = ($search['period_start'])?date('Y-m-d 00:00:00', strtotime($search['period_start'])):null;
        $period_end = ($search['period_end'])?date('Y-m-d 23:59:59', strtotime($search['period_end'])):null;
        
        $startdate = ($period_start)?' and learn.create_date >= "'. $period_start .'"':null;
        $enddate = ($period_end)?' and learn.create_date <= "'. $period_end .'"':null;

        $lesson_online = Lesson::model()->findAll(array(
            'condition' => 'active = "y"' . $sqlLessonQuery,
            'order' => 'lesson_no ASC'
        ));
        $lesson_count = ($lesson_online)?count($lesson_online):0;
    ?>

<style type="text/css">
    body {
        font-family: 'kanit';
    }
</style>
    <!-- END HIGH SEARCH -->
        <div class="widget" id="export-table">
            <div class="widget-head">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายงานผู้เรียนตามหัวข้อวิชา</h4>
                </div>
            </div> 
            <div class="widget-body" style=" overflow-x: scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">ลำดับ</th>
                            <th rowspan="2">ชื่อ - สกุล</th>
                            <th rowspan="2">อีเมลล์</th>
                            <th colspan="<?= $lesson_count?>" class="center">สถานะผู้เรียนรายวิชา</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($lesson_online as $lesson) {
                                   ?>
                                <th style="writing-mode: tb-rl;"><?= $lesson['title'] ?></th>
                                   <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($_GET)){
                               $allUsers = User::model()->with('profile')->findAll(array(
                                'condition' => 'status ="1"' . $gen . $textsearch . $texttype,
                                ));
                            }
                           
                             $dataProvider=new CArrayDataProvider($allUsers, array(
                                'pagination'=>false
                        ));
                            $getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }
                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;
                            if($dataProvider->getData()) {
                                foreach($dataProvider->getData() as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?= $start_cnt+1 ?></td>
                                        <td><?= $user->profile->firstname . ' ' . $user->profile->lastname ?></td>
                                        <td><?= $user->email ?>&nbsp;</td>
                                        <?php
                                           if($lesson_online) {
                                                foreach($lesson_online as $lesson) {
                                                    $statusLearn = Learn::model()->with('les')->find(array(
                                                        'condition' => 'lesson_active = "y" and user_id ="'.$user['id'].'" and lesson_id ="'. $lesson['id'] .'"' . $startdate . $enddate ,
                                                        'alias' => 'learn'
                                                    ));
                                                    $statusArray = array('learning'=>'<b style="color: green;">กำลังเรียน</b>', 'pass' => '<b style="color: blue;">ผ่าน</b>','notlearn'=>'<b style="color: red;">ยังไม่เรียน</b>');
                                                    ?>
                                                    <td class="center"><?= ($statusLearn['lesson_status']==null)?$statusArray['notlearn']:$statusArray[$statusLearn['lesson_status']] ?></td>
                                                    <?php
                                                }
                                           }
                                        ?>
                                    </tr>
                                    <?php
                                    $start_cnt++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <strong>ไม่พบข้อมูล</strong>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>