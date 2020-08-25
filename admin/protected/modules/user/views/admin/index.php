<?php
$this->breadcrumbs=array(
	// UserModule::t('Users')=>array('/user'),
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

					<?php $this->widget('AdvanceSearchForm', array(
						'data'=>$model,
						'route' => $this->route,
						'attributes'=>array( 
							array('name'=>'idensearch','type'=>'text'),
							array('name'=>'email','type'=>'text'),
							array('name'=>'activkey','type'=>'text'),
							array('name'=>'create_at','type'=>'text'),
							array('name'=>'lastvisit_at','type'=>'text'),
							array('name'=>'superuser','type'=>'list','query' => $model->itemAlias('AdminStatus')),
							array('name'=>'status','type'=>'list','query' => $model->itemAlias('UserStatus')),
						)
					));
					?>
					<div class="widget" style="margin-top: -1px;">
						<div class="widget-head">
							<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration"); ?></h4>
						</div>
						<div class="widget-body">
							<div>
								<?php echo Rights::t('core', 'ที่นี่คุณสามารถดูว่ามีการมอบหมายสิทธิ์ใดให้กับผู้ใช้แต่ละราย'); ?>
							</div>
								 <div class="separator bottom form-inline small">
								<span class="pull-right">
									<label class="strong">แสดงแถว:</label>
									<?php echo $this->listPageShow($formNameModel);?>
								</span>
							</div>
							<div class="spacer"></div>
							<div>

								<?php //echo CHtml::link(UserModule::t('ค้นหาขั้นสูง'),'#',array('class'=>'search-button')); ?>
								<div class="search-form" style="display:none">

								</div><!-- search-form -->

								<?php $this->widget('AGridView', array(
									'id'=>'user-grid',
									'dataProvider'=>$model->search(),
									'filter'=>$model,
									'columns'=>array(
										array(
											'header'=>'No.',
											'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
										),
			// 					array(
			// 						'name' => 'idensearch',
			// 						'type'=>'raw',
			// 						// 'value' => '$data->profile->identification',
			// 						'value'=>function($data){
			// 							if(!empty($data->identification)){
			// 								return $data->identification;
			// 							}else{
			// 								return 'ไม่มีข้อมูลบัตรประชาชน';
			// 							}
			// 						},
			// //'value' => 'CHtml::link(UHtml::markSearch($data, ),array("admin/view","id"=>$data->id))',
			// 					),
								// array(
								// 	'name' => 'pic_cardid2',
								// 	'type'=>'raw',
								// 	'value'=>function($data){
								// 		if(!empty($data->pic_cardid2)){
								// 			return $data->pic_cardid2;
								// 		}else{
								// 			return 'ไม่พบเลขประจำตัวพนักงาน';
								// 		}
								// 	},
								// ),
										// array(
										// 	'header' => 'ชื่อ - นามสกุล',
										// 	'type'=>'html',
										// 	'value'=>function($data){
										// 		return $data->profile->firstname . ' ' . $data->profile->lastname;

										// 	}
										// ),
										array(
											'name'=>'fullname',
											'type'=>'html',
											'value'=>'$data->fullnamee',
										),
										array(
											'header' => 'รหัสพนักงาน',
											'name'=>'username',
											'type'=>'html',
											'value'=>function($data){
												return $data->username;
						            	//var_dump($data->profile->type_user);
											}
										),
										array(
											'header' => 'แผนก',
											'type'=>'html',
											'value'=>function($data){
												return $data->department->dep_title;
											}
										),
										array(
											'header' => 'ตำแหน่ง',
											'type'=>'html',
											'value'=>function($data){
												return $data->position->position_title;
											}
										),
										array(
											'name'=>'email',
											'type'=>'raw',
											'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
										),
		// 'create_at',
										array(
											'name'=>'create_at',
											'type'=>'html',
			// 'value'=>'UHtml::markSearch($data,"create_at")'
											'filter' => false,
											'value'=>function($data){
												return Helpers::changeFormatDate($data->create_at,'datetime');
											},
										),
		// 'lastvisit_at',
										array(
											'name'=>'lastvisit_at',
											'type'=>'html',
			// 'value'=>'UHtml::markSearch($data,"lastvisit_at")'
											'filter' => false,
											'value'=>function($data){
												return Helpers::changeFormatDate($data->lastvisit_at,'datetime');
											},
										),
										array(
											'header' => 'สิทธิการใช้งาน',
											'type'=>'html',
											'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
									// 'filter'=>User::itemAlias("AdminStatus"),
										),
										array(
											'name'=>'status',
											'value'=>'User::itemAlias("UserStatus",$data->status)',
											'filter' => User::itemAlias("UserStatus"),
										),
										array(
											'name'=>'online_status',
											'value'=>'User::chk_online($data->id,$data->lastactivity,$data->online_status)',
											'filter' => User::itemAlias("Online"),
										),
										array(
											'type'=>'raw',
											'value'=>function($data){

												return  CHtml::button("เปลี่ยนรหัสผ่าน",array('onclick'=>'sendMsg('.$data->id.')','class' => 'btn btn-info','data-id' =>$data->id));


											},
											'header' => 'เปลี่ยนรหัสผ่าน',
											'htmlOptions'=>array('style'=>'text-align: center;'),
											'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
										),
								// array(
        //                                     'header' => 'พิมพ์ใบสมัคร',
        //                                     'type' => 'raw',
        //                                     'value' => function($data) {
        //                                        //var_dump($data->id);
        //                                        // return CHtml::button("พิมพ์",array('class' => 'btn btn btn-success print_pdf','data-id' => $data->id));
        //                                     	return CHtml::button('พิมพ์ใบสมัคร', array('submit' => array('admin/Printpdf', 'id'=> $data->id),'class' => 'btn btn btn-success'));
        //                                     },'htmlOptions' => array(
        //                                         'style'=> "text-align: center;",
        //                                     ),
        //                                 ),
										array(            
											'class'=>'AButtonColumn',
											'visible'=>Controller::PButton( 
												array("Admin.*", "Admin.View", "Admin.Update", "Admin.Delete") 
											),
											'buttons' => array(
												'view'=> array( 
													'visible'=>'Controller::PButton( array("Admin.*", "Admin.View") )' 
												),
												'update'=> array( 
													'visible'=>'Controller::PButton( array("Admin.*", "Admin.Update") )' 
												),
												'delete'=> array( 
													'visible'=>'Controller::PButton( array("Admin.*", "Admin.Delete") )' 
												),
											),
										),
									),
));


?>
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
				<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
				<button id="btnSubmit" type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
			</div>
		</div>
	</div>
</div>

</div><!-- form -->
</div>
</div>
</div>
<!-- END innerLR -->
<script type="text/javascript">
// $('.print_pdf').click(function(e){
// 		$.ajax({
// 			type: 'POST',
// 			url: "<?= $this->createUrl('admin/Printpdf'); ?>",
// 			data: {id: $(this).attr('data-id')},
// 			success: function(data){
// 				window.location.href = data;
// 				},
// 		});
// 		//return false;
// 	});
function sendMsg(id){

	swal({
		title: "คุณต้องการเปลี่ยนรหัสผ่านใช่หรือไม่",
		text: "เลือก",
		type: "info",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "ใช่",
		cancelButtonText: "ไม่",
		closeOnConfirm: true,
		closeOnCancel: false,
									//showLoaderOnConfirm: true
								},
								function(isConfirm) {
									if (isConfirm) {
										$.ajax({
											url: "<?= $this->createUrl('admin/ChangePassword'); ?>", 
											type: "POST",
											data:  {id:id},
											success: function(data){

												$('#selectModal .modal-title').html('กรุณากรอกรหัสผ่านใหม่');
												$('#selectModal .modal-body').html(data);
												$('#btnSubmit').css('display','none');
												$('#selectModal').modal('show');
												$(".save_data").click(function(){
													var password = $("#password").val();
													var verifyPassword = $("#verifyPassword").val();

													$.ajax({
														url: "<?= $this->createUrl('admin/ChangePasswordUser'); ?>", 
														type: "POST",
														data:  {id:id,
															password:password,
															verifyPassword:verifyPassword,

														},
														success: function(data){
															console.log(data);
															if (data) {
																setTimeout(function () {
																	swal("สำเร็จ", "เปลี่ยนรหัสผ่านสำเร็จ)", "success");
																}, 10000);
																location.reload();
															}else{
																setTimeout(function () {
																	swal("ไม่สำเร็จ!", "ไม่สามารถเปลี่ยนรหัสผ่านสำเร็จ)", "error");
																}, 10000);
																location.reload();
															}
														}
													});

												});
											}
										});
										
									} else {
										setTimeout(function () {
											swal("ไม่สำเร็จ!", "ไม่สามารถเปลี่ยนรหัสผ่านสำเร็จ)", "error");
										}, 2000);
										location.reload();
									}
								}
								);

}
</script>
