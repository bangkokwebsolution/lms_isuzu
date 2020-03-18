<?php
$columns=array(
    // array(
    //     'name'=>'report_date',
    //     'filter'=>CHtml::activeTextField($model,'report_date'),
    //     'type' => 'raw',
    //     'value'=>'$data->report_date',
    //     'htmlOptions' => array(
    //         'width'=>'120',
    //     ),
    // ),
    // array(
    //     'header'=>'ชื่อ - สกุล',
    //     'value'=>function($data){
    //         return $data->firstname.' '.$data->lastname;
    //     }
    // ),
    // array(
    //     'header'=>'บัตรประชาชน',
    //     'value'=>function($data){
    //         $user = User::model()->findByAttributes(array(
    //             'email' => $data->email,
    //         ));
    //         // var_dump($user);
    //         if($user){
    //             if($user->bookkeeper_id){
    //                 $name = $user->bookkeeper_id;
    //                 return $name.' ';
    //             } else {
    //                 $name = $user->username;
    //                 return $name.' ';
    //             }
    //         } else {
    //             $user = Profile::model()->findByAttributes(array(
    //                 'firstname' => $data->firstname,
    //             ));
    //             if($user){
    //                 if($user->user->bookkeeper_id){
    //                     $name = $user->user->bookkeeper_id;
    //                     return $name.' ';
    //                 } else {
    //                     $name = $user->user->username;
    //                     return $name.' ';
    //                 }
    //             } else {
    //                 return 'ไม่มีในระบบ';
    //             }
    //         }
            
    //     },
    // ),
    // array(
    //     'name'=>'report_title',
    //     'type'=>'html',
    //     'value'=>'UHtml::markSearch($data,"report_title")'
    // ),
    // array(
    //     'name'=>'accept_report_date',
    //     'type'=>'html',
    //     // 'value'=>'UHtml::markSearch($data,"accept_report_date")'
    //     'value'=>function($data){
    //         return Helpers::changeFormatDate($data->accept_report_date,'datetime');
    //     },
    // ),
    // array(
    //     'name'=>'status',
    //     'value'=>'ReportProblem::itemAlias("UserStatus",$data->status)',
    //     'filter' => ReportProblem::itemAlias("UserStatus"),
    // ),
    // array(
    //     'name'=>'answer',
    //     'type'=>'html',
    //     'value'=>function($data){
    //         if($data->answer != ''){
    //             return $data->answer;
    //         } else {
    //             return 'ยังไม่ตอบกลับ';
    //         }
    //     },
    //     'htmlOptions' => array(
    //         'width'=>'220',
    //     ),
    // ),
        array(
                        'name'=>'create_date',
                        'type'=>'html',
                        // 'value'=>'UHtml::markSearch($data,"report_date")'
                        'value'=>function($data){
                            return Helpers::changeFormatDate($data->create_date,'datetime');
                        },
                    ),      
                    array(
                        'header'=>'ชื่อ - สกุล',
                        'value'=>function($data){
                            return $data->contac_by_name.' '.$data->contac_by_surname;
                        }
                    ),
                    
                    array(
                        'header'=>'อีเมล์',
                        'value'=>function($data){
                            $user = User::model()->findByAttributes(array(
                                'email' => $data->contac_by_email,
                            ));
                            // var_dump($user);
                            if($user){
                                if($user->bookkeeper_id){
                                    return $user->bookkeeper_id;
                                } else {
                                    return $user->username;
                                }
                            } else {
                                $user = Profile::model()->findByAttributes(array(
                                    'firstname' => $data->contac_by_name,
                                ));
                                if($user){
                                    if($user->user->bookkeeper_id){
                                        return $user->user->bookkeeper_id;
                                    } else {
                                        return $user->user->username;
                                    }
                                } else {
                                    return 'ไม่มีในระบบ';
                                }
                            }
                            
                        },
                    ),
                    array(
                        'name'=>'contac_by_tel',
                        'type'=>'html',
                        'value'=>'UHtml::markSearch($data,"contac_by_tel")'
                    ),
                    
                    array(
                        'name'=>'contac_type',
                        'type'=>'html',
                        'value'=>'UHtml::markSearch($data,"contac_type")'
                    ),
                    
                    array(
                        'name'=>'contac_detail',
                        'type'=>'html',
                        // 'value'=>'UHtml::markSearch($data,"accept_report_date")'
                        'value'=>function($data){
                            $output = UHtml::markSearch($data,"contac_detail");
                                return $output;
                        },
                    ),
                    array(
                        'name'=>'contac_answer',
                        'type'=>'html',
                        'value'=>function($data){
                            if($data->contac_answer == 'y'){
                                $output = 'ตอบแกลับล้ว';
                                $color = 'green';
                            } else {
                                $color = 'red';
                                $output = 'ยังไม่ได้ตอบ';
                            }
                            return '<span style="color: '.$color.'">'.$output.'</span>';
                        },
                    ),
    // array(
    //     'name'=>'passcours_cours',
    //     'filter'=>CHtml::activeTextField($model,'cours_name'),
    //     'type' => 'raw',
    //     'value'=>'$data->CourseOnlines->course_title',
    // ),
    // array(
    //     'name'=>'passcours_date',
    //     'value'=>'ClassFunction::datethai($data->passcours_date)',
    //     'htmlOptions' => array(
    //         'width'=>'110',
    //         'style' => 'text-align:center;',
    //     ),
    //     'filter'=>$this->widget('zii.widgets.jui.CJuiDatepicker', array(
    //         'model'=>$model,
    //         'attribute'=>'passcours_date',
    //         'htmlOptions' => array(
    //             'id' => 'passcours_date',
    //         ),  
    //         'options' => array(
    //             'mode'=>'focus',
    //             'dateFormat'=>'dd/mm/yy',
    //             'showOn' => 'focus', 
    //             'showOtherMonths' => true,
    //             'selectOtherMonths' => true,
    //             'yearRange' => '-5+10', 
    //             'changeMonth' => true,
    //             'changeYear' => true,
    //             'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
    //             'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
    //                 'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
    // )), true)),
);
?>
<?php $this->widget('application.components.widgets.tlbExcelView', array(
    'id'                   => 'Passcours-grid',
    'dataProvider'         => $model->search(),
    'grid_mode'            => $production, // Same usage as EExcelView v0.33
    //'template'           => "{summary}\n{items}\n{exportbuttons}\n{pager}",
    'title'                => 'PrintReport - ' . date('d-m-Y - H-i-s'),
    'creator'              => 'Your Name',
    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
    'description'          => mb_convert_encoding('Etat de production généré à la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
    'lastModifiedBy'       => 'Some Name',
    'sheetTitle'           => 'Report on ' . date('m-d-Y H-i'),
    'keywords'             => '',
    'category'             => '',
    'landscapeDisplay'     => true, // Default: false
    'A4'                   => true, // Default: false - ie : Letter (PHPExcel default)
    'RTL'                  => false, // Default: false
    'pageFooterText'       => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
    'automaticSum'         => false, // Default: false
    'decimalSeparator'     => ',', // Default: '.'
    'thousandsSeparator'   => '.', // Default: ','
    //'displayZeros'       => false,
    //'zeroPlaceholder'    => '-',
    //'sumLabel'             => 'Column totals:', // Default: 'Totals'
    'rowHeight'            => 25, // Default: 15
    'headerHeight'         => 40, // Default: 20
    'footerHeight'         => 40, // Default: 20
    'columns'              => $columns, // an array of your CGridColumns
    // 'exportType'           => 'Excel2007',
)); ?>