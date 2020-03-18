
<?php

$title = 'จัดการ Captcha';

$this->breadcrumbs=array($title);
// $this->headerText = $title;

?>
<div class="innerLR">
<div class="separator bottom form-inline small">
    <div class="btn-group" role="group" aria-label="...">
         <a href="<?= Yii::app()->controller->createUrl('captcha/create'); ?>" type="button" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่มแคปช่า</a>
   </div>
</div>
<style type="text/css">
    .openstatus{
        color:#00a65a;
    }
    .closestatus{
        color:#dd4b39;
    }
</style>
<?php $this->widget('AGridView',array(
    'id'=>'Captcha-grid',
    'dataProvider' => $dataProvider,
    'selectableRows' => 2,
    'rowCssClassExpression' => '"items[]_{$data->capid}"',
    'htmlOptions' => array(
         'style' => "margin-top: -1px;",
         ),
            'summaryText' => false, // 1st way
            'columns'=>array(
     //            array(
					// 	'class' => 'CCheckBoxColumn',
    	// 				'id' => 'chk',
					// ),
            	array(
            		'header' => 'ลำดับ',
						// 'name' => 'capid',
            		'sortable' => false,
            		'htmlOptions' => array(
            			'width' => '40px',
            			'text-align' => 'center',
            			),
            		'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            		),
            	array(
            		'header' => 'ชื่อเงื่อนไข',
            		'name' => 'capt_name',
            		'sortable' => false,
            		'htmlOptions' => array(
							// 'width' => '200px',
            			),
            		),

            	/*array(
            		'header'=>'ชื่อหลักสูตร',
            		'value'=>function($data){
            			$model = CertificateNameRelations::model()->findAll(array(
            				'condition'=>'capid = "'.$data->capid.'"'
            				));
            			$coursename = '';
            			$arrayKeys = array_keys($model);
            			$lastArrayKey = array_pop($arrayKeys);
            			foreach ($model as $key => $value) {
            				$coursename .= $value->course_name;
            				if($key != $lastArrayKey) {
            					$coursename .= ', ';
            				}
            			}
            			return $coursename;
            		},
            		),*/
            	/*array(
            		'header'=>'เลือกหลักสูตร',
            		'type'=>'raw',
            		'value'=>function($data){
            				// return '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">เลือกหมวดหลักสูตร</button>';
            			return CHtml::link( '<i class="fa fa-fw fa-folder-open-o"></i> เลือกหลักสูตร', 'javascript:void(0)', array( 'class' => 'btn btn-info', 'onclick' => 'selectCourse(' . $data->capid . ')'));
            		},
            		),*/


            		array(
            			'header' => 'สถานะ',
            			'type'=>'raw',
            			//'htmlOptions'=>array('style'=>'text-align:center;'),
            			'value' => function($val){
            				if($val->capt_hide==0){
            					$value = '<i id="status_eye'.$val->capid.'" class="fa fa-close closestatus"  data-toggle=\'tooltip\' title="ปิด"></i>';
            				} else {
            					$value = '<i id="status_eye'.$val->capid.'" class="fa fa-check openstatus"  data-toggle=\'tooltip\' title="เปิด"></i>';
            				}
            				return '<button class="btn-link" id="status'.$val->capid.'" onClick="changeStatus('.$val->capid.')">'.$value.'</button>';
            			}
            			),

                array(
                  'header'=>'การจัดการ',
                  'class' => 'zii.widgets.grid.CButtonColumn',
                  'htmlOptions' => array('style' => 'white-space: nowrap'),
                  'afterDelete' => 'function(link,success,data) { if (success && data) alert(data); }',
                  'template' => '{view} {update} {delete}',
                  'buttons' => array(
                    'view' => array(
                      'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'View'),
                      'label' => '<button type="button" class="btn btn-primary"><i class="fa fa-list-alt"></i></button>',
                      'imageUrl' => false,
                      ),
                    'update' => array(
                      'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Update'),
                      'label' => '<button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>',
                      'imageUrl' => false,
                      ),
                    'delete' => array(
                      'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Delete'),
                      'label' => '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>',
                      'imageUrl' => false,
                      )
                    )
                  ),
            		/*array(
            			'class' => 'zii.widgets.grid.CButtonColumn',
            			'htmlOptions' => array('style' => 'white-space: nowrap'),
            			'afterDelete' => 'function(link,success,data) { if (success && data) alert(data); }',
            			'template' => '{update} {btn_delete}',
            			'buttons' => array(
            				
            				'update' => array(
            					'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Update'),
            					'label' => '<button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>',
            					'imageUrl' => false,
            					'url'=> function($data) {
            						return Yii::app()->controller->createUrl('configCaptcha/update', ['id' => $data->capid]);
            					}
            					),
            				'btn_delete' => array(
            					'options' => array(
            						'rel' => 'tooltip', 
            						'data-toggle' => 'tooltip', 
            						'title' => 'Delete',
            						'class' => 'btn_del'
            						), 
            					'url'=> function($data) {
            						return Yii::app()->controller->createUrl('configCaptcha/delete', ['id' => $data->capid]);
            					},
            					'label' => '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>',
            					'imageUrl' => false,
                            //'Url' => false,
            					)
            				)
                                 ),*/
                                 ),
                                 )); ?>
</div>
                                 <div class="modal fade" id="selectApplyCourseToCertificate" role="dialog">
                                       <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                 <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">เลือกหลักสูตร</h4>
                                                </div>
                                                <div class="modal-body">
                                                      <!-- <p>Some text in the modal.</p> -->
                                                </div>
                                                <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                                      <button type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
                                                </div>
                                          </div>

                                    </div>
                              </div>


                              <div class="modal fade" tabindex="-1" role="dialog" id="">
                                 <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                           <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">เลือกลักสูตร</h4>
                                          </div>
                                          <div class="modal-body">
                                                <p>Loading.</p>
                                          </div>
                                          <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <script type="text/javascript">
                           function checkConfirm() {
                                console.log(this);
                          }


                          function saveModal() {
                                var certificateId = $('input[name="capid"]').val();
                                var courseCheckList = $('.courseCheckList');
                                var checkedList = [];

                                if(courseCheckList != undefined) {
                                     $.each(courseCheckList, function(i, checkbox) {
                                          if(checkbox.value != null && checkbox.checked == true) {
                                               checkedList.push(checkbox.value);
									// checkedList[i] = checkbox.value;
								}
								console.log(checkedList);
							});
                                     if(checkedList!=null) {
                                          $.post("<?= $this->createUrl('certificate/savecoursemodal') ?>", { checkedList: JSON.stringify(checkedList), certificateId: certificateId }, function(respon) {
                                               if(respon) {
                                                    $('#selectApplyCourseToCertificate').modal('hide');
                        					// $('#MtCourseType-grid').load(document.URL + ' #MtCourseType-grid');
                        					$.fn.yiiGridView.update('Certificate-grid');
                        				} else {
                        					alert('error');
                        				}
                        			});
                                    }
                              }
                        }

                        function changeStatus(val) {
                          var result = confirm("คุณต้องการเปลี่ยนสถานะใช่หรือไม่?");
                          if (result) {
                               $.ajax({
                                    type: "POST",
                                    url: '<?= $this->createUrl('captcha/create') ?>',
                                    data:'status_id='+val,
                                    success: function(data){
                                         if(data == 1){
                                              $("#status_eye"+val).removeClass('fa fa-close closestatus').addClass('fa fa-check openstatus');
                                        } else {
                                              $("#status_eye"+val).removeClass('fa fa-check openstatus').addClass('fa fa-close closestatus');
                                        }
                                  }
                            });
                         } 
                   }
                   function selectCourse(certificateId=null) {
                    if(certificateId != undefined && certificateId!=null) {
                         $.post("<?= $this->createUrl('certificate/coursemodal') ?>", { certificateId: certificateId }, function(respon) {
                              if(respon) {
                                   $('#selectApplyCourseToCertificate .modal-body').html(respon);
                                   setTimeout(function() {
                                        $('#selectApplyCourseToCertificate').modal({
                                             keyboard: false
                                       });
                                  }, 1000);
                             }
                       });
                   }
             }
       </script>

