<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	UserModule::t('Manage'),
);
//
// $this->menu=array(
//     array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
//     array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
//     array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//     array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
// );

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('user-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");

	?>
	<div id="user" class="innerLR">

		<div class="widget" style="margin-top: -1px;">
			<div class="widget-head">
				<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Confirm Registration"); ?></h4>
			</div>
			<div class="widget-body">
				<div>
					<?php echo Rights::t('core', 'ที่นี่คุณสามารถอนุมัติการสมัครสมาชิกให้กับผู้ใช้แต่ละราย'); ?>
				</div>
				<div class="spacer"></div>
				<div>

					<!--  < ?php echo CHtml::link(UserModule::t('ค้นหาขั้นสูง'),'#',array('class'=>'search-button')); ?>
					<div class="search-form" style="display:none">
						< ?php $this->renderPartial('_search',array(
							'model'=>$model,
							)); ?>
						</div> --><!-- search-form -->

						<?php 
						$this->widget('AGridView', array(
							'id'=>'user-grid',
							'dataProvider'=>$model->searchmembership(),
							'filter'=>$model,
							'columns'=>array(
								array(
									'header'=>'No.',
									'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
								),
			// 					array(
			// 						'name' => 'idensearch',
			// 						'type'=>'raw',
			// 						'value' => '$data->profile->identification',
			// //'value' => 'CHtml::link(UHtml::markSearch($data, ),array("admin/view","id"=>$data->id))',
			// 					),
								array(
						            'header' => 'ชื่อ - นามสกุล',
						            'type'=>'html',
						            'value'=>function($data){
						                return $data->profile->firstname . ' ' . $data->profile->lastname;
						            }
						        ),
						        array(
						            'header' => 'ตำแหน่งที่สมัคร',
						            'type'=>'html',
						            'value'=>function($data){
						                return $data->position->position_title;
						            }
						        ),
						        array(
						            'header' => 'สถานะ',
						            'type'=>'html',
						            'value'=>function($data){
						 
						                if($data->register_status == 0){
											//echo CHtml::button("ปิด",array("class"=>"btn btn-danger ","data-id" => $data->id));
											echo "รอการตรวจสอบ";
										} else if($data->register_status == 1){
											echo "อนุมัติ";
											//echo CHtml::button("รอการตรวจสอบ",array("class"=>"btn btn-success ","data-id" => $data->id));
										}else{
											echo "ไม่อนุมัติ";
										}
						            }
						        ),
								// array(
								// 	'name'=>'email',
								// 	'type'=>'raw',
								// 	'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
								// ),
		// 'create_at',
								array(
									'name'=>'create_at',
									'type'=>'html',
									'filter' => false,
			// 'value'=>'UHtml::markSearch($data,"create_at")'
									'value'=>function($data){
										return Helpers::changeFormatDate($data->create_at,'datetime');
									},
								),
			// 					array(
			// 						'name'=>'careersearch',
			// 						'type'=>'raw',
			// 						'filter'=>User::getListCareer(),
			// 						'value' => '$data->profile->Career->career',
			// //'value' => 'CHtml::link(UHtml::markSearch($data, ),array("admin/view","id"=>$data->id))',
			// 					),
								// array(
								// 	'name'=>'orgchart_lv2',
								// 	'type'=>'raw',
								// 	'filter' => User::getListOrgCourse(),
								// 	'value'=>function($data){
								// 		$orgCoruse = json_decode($data->orgchart_lv2);
								// 		$criteria=new CDbCriteria;
								// 		$criteria->addInCondition('id', $orgCoruse);
								// 		$org = OrgChart::model()->findAll($criteria);
								// 		foreach ($org as $key => $value) {
								// 			$courseName .= ($key+1).'. '.$value->title.'<br>';
								// 		}
								// 		return $courseName;
								// 	},
								// ),
		// 'lastvisit_at',
								// array(
								// 	'name'=>'superuser',
								// 	'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
								// 	'filter'=>User::itemAlias("AdminStatus"),
								// ),
								array(
									'type'=>'raw',
									'value'=>function($data){
										if($data->register_status == 1){
											echo CHtml::button("ปิด",array("class"=>"btn btn-danger changeStatus","data-id" => $data->id));
										} else {
											echo CHtml::button("รอการตรวจสอบ",array("class"=>"btn btn-success changeStatus","data-id" => $data->id));
										}
									},
									'header' => 'อนุมัติสมัครสมาชิก',
									'htmlOptions'=>array('style'=>'text-align: center;'),
									'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
								),
								array(
									'type'=>'raw',
									'value'=>function($data){	
											echo CHtml::button("ตรวจสอบ",array("class"=>"btn btn-success Check_information","data-id" => $data->id));
									},
									'header' => 'ตรวจสอบข้อมูลการสมัคร',
									'htmlOptions'=>array('style'=>'text-align: center;'),
									'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
								),
								// array(
								// 	'class'=>'AButtonColumn',
								// 	'visible'=>Controller::PButton(
								// 		array("Admin.*", "Admin.View", "Admin.Update", "Admin.Delete")
								// 	),
								// 	'buttons' => array(
								// 		'view'=> array(
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.View") )'
								// 		),
								// 		// 'update'=> array(
								// 		// 	'visible'=>'false'
								// 		// ),
								// 		'update'=> array( 
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.Update") )' 
								// 		),
								// 		'delete'=> array(
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.Delete") )'
								// 		),
								// 	),
								// ),
							),
						));

						?>
						<!-- modal message -->
							<div class="modal fade" tabindex="-1" role="dialog" id="selectModal1">
							    <div class="modal-dialog" role="document">
							        <div class="modal-content">

							        </div>
							    </div>
							</div>
							<!-- end modal -->

							<div class="modal fade" tabindex="-1" role="dialog" id="selectModal">
							    <div class="modal-dialog modal-lg" role="document">
							        <div class="modal-content">
							            <div class="modal-header" style="background-color: #3C8DBC;">
							                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;font-size: 22px;">&times;</span></button>
							                <h4 class="modal-title" style="font-size: 20px;color: #fff;padding: .3em;">ข้อความ</h4>
							            </div>
							            <div class="modal-body">
							            </div>
							            <div class="modal-footer" style="background-color: #eee;">
							                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
							                <button id="btnSubmit" type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
							            </div>
							        </div>
							    </div>
							</div>
<!-- 
						<div class="modal fade" id="modal-id-card">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										
										<h4 class="modal-title text-white"><i class="fa fa-lock" aria-hidden="true"></i>
										แก้ไขบัตรประชาชน สำหรับเรียนหลักสูตร CPD</h4>
									</div>
									<div class="modal-body"
									style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png"
									);
									">
								</div>
								<div class="modal-footer">
									<?php echo CHtml::submitButton('ยืนยัน', array('class' => 'btn btn-sm', 'style' => 'font-size:20px;')); ?>
									<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
								</div>
							</div>
						</div> -->
						<script>
									$( ".changeStatus" ).click(function() {
								var btn = $(this);
								var id = btn.attr("data-id");
								//var _items = ["อนุมัติ","ไม่อนุมัติ"];
								swal({
									title: "ต้องการอนุมัติการสมัครหรือไม่",
									text: "เลือก",
									type: "info",
									showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "อนุมัติ",
                                    cancelButtonText: "ไม่อนุมัติ",
                                    closeOnConfirm: false,
                                    closeOnCancel: false,
                                    showLoaderOnConfirm: true
								},
								function(isConfirm) {
								  if (isConfirm) {
								  	$.ajax({
									url: "<?= $this->createUrl('admin/confirm'); ?>", 
									type: "POST",
									data:  {id:id},
									success: function(result){
										if (result) {
											setTimeout(function () {
											swal("อนุมัติสำเร็จ!", "ระบบได้ทำการอนุมัติเรียบร้อยแล้ว", "success");
										     }, 5000);
                                            location.reload();
										}else{
											setTimeout(function () {
                                            swal("อนุมัติไม่สำเร็จ!", "ไม่สามารถอนุมัติได้)", "error");
                                            }, 5000);
                                            location.reload();
										}	
									}
								});
								    
								  } else {
								  	checkConfirminformation();    
								  }
								}
								);

								
							});

							$( ".Check_information" ).click(function() {
								var btn = $(this);
								var id = btn.attr("data-id");
								$.ajax({
									url: "<?= $this->createUrl('admin/Checkinformation'); ?>", 
									type: "POST",
									data:  {id:id},
									success: function(data){
										//console.log(data);
										 $('#selectModal .modal-title').html('ตรวจสอบข้อมูลการสมัคร');
                                         $('#selectModal .modal-body').html(data);
                                         $('#btnSubmit').css('display','none');
                                         $('#selectModal').modal('show');
										// if(result == 1) btn.addClass('btn-success').removeClass('btn-danger');
										// else btn.addClass('btn-danger').removeClass('btn-success');
										// btn.val(_items[result]);
										// location.reload();
										$(".save_data").click(function(){
											var val = $(".position_id").val();
											var id = $(".position_id").attr('id');
										if (val != '') {
											$.ajax({
									url: "<?= $this->createUrl('admin/Changeposition'); ?>", 
									type: "POST",
									data:  {id:id,
									        val:val},
									success: function(data){
										//console.log(data);
										location.reload();
									   }
										});
										}else{
											location.reload();
										}
									});
									}
								});
							});
			function checkConfirminformation() {
                swal({
                    title: "หมายเหตุ",
                    text: "ระบุสาเหตุที่ไม่อนุมัติ",
                    type: "input",
                    //inputType: "password",
                    inputPlaceholder: "ข้อความไม่อนุมัติ",
                    showCancelButton: true,
                    allowEnterKey: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "ตกลง",
                    cancelButtonText: "ยกเลิก",
                    animation: "slide-from-top",
                },
                function (inputValue) {
                    if(inputValue != false){
                    	var id = $('.changeStatus').attr("data-id");
                        $.ajax({
                            type : 'POST',
                            url : "<?= $this->createUrl('admin/Notapproved'); ?>",
                            data: { passInput:inputValue,
                                    id:id
                                 }
                            ,success:function(data){
                            	console.log(data);
                            	if (data) {
                            		setTimeout(function () {
                            	swal("สำเร็จ!", "ระบบได้ทำการส่งอีเมลล์แจ้งผู้สมัครเรียบร้อยแล้ว", "success");
                            	}, 5000);
                            	location.reload();

                            }else{
                            	setTimeout(function () {
                            	swal("ไม่สำเร็จ!", "ไม่สามารถแก้ไขข้อมูลได้)", "error");
                            	}, 5000);
                            	location.reload();
                            }
             
                            }
                        });
                    }
                }
                );
            }
						</script>
					</div>

				</div><!-- form -->
			</div>
		</div>
	</div>
	<!-- END innerLR -->
