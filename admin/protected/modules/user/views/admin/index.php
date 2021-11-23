<?php
$this->breadcrumbs=array(
	// UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);
$formNameModel = 'User';

// 
// $this->menu=array(
//     array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
//     array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
//     array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//     array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
// );
$type_emp = 0;
$Department_ID = array();
if ($this->route === "user/admin/employeeShip") {
	$type_emp = 1;
	$Department = Department::model()->findAll('active = "y" AND lang_id = 1 AND type_employee_id = 1');
	foreach ($Department as $key => $value) {
	$Department_ID[] = $value->id;
	}
	  $criteria= new CDbCriteria;
	  $criteria->compare('active','y');
	  $criteria->compare('lang_id',1);
	  $criteria->addInCondition('department_id', $Department_ID);
	  $ListPosition = Position::model()->findAll($criteria);

}else if ($this->route === "user/admin/employee"){
	$type_emp = 2;
	$Department = Department::model()->findAll('active = "y" AND lang_id = 1 AND type_employee_id = 2');
	foreach ($Department as $key => $value) {
	$Department_ID[] = $value->id;
	}
	$criteria= new CDbCriteria;
	  $criteria->compare('active','y');
	  $criteria->compare('lang_id',1);
	  $criteria->addInCondition('department_id', $Department_ID);
	  $ListPosition = Position::model()->findAll($criteria);
}

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("User[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);

				?>
				<div id="user" class="innerLR">

					<!-- <?php $this->widget('AdvanceSearchForm', array(
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
					?> -->
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
							<div class="clear-div"></div>
							<div class="overflow-table">					
								<?php $this->widget('AGridView', array(

									'id'=>$formNameModel.'-grid',
									'dataProvider'=>$model->search(),
									'filter'=>$model,
									'selectableRows' => 2,
									//'rowCssClassExpression'=>'"items[]_{$data->id}"',
									'htmlOptions' => array(
										'style'=> "margin-top: -1px;width:200%;",
									),
									'afterAjaxUpdate'=>'function(id, data){
										$.appendFilter("User[news_per_page]");
										InitialSortTable();	
										jQuery("#course_date").datepicker({
											"dateFormat": "dd/mm/yy",
											"showAnim" : "slideDown",
											"showOtherMonths": true,
											"selectOtherMonths": true,
											"yearRange" : "-5+10", 
											"changeMonth": true,
											"changeYear": true,
											"dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
											"monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
											"ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
											})
										}',

									'columns'=>array(
										array(
											'header'=>'No.',
											'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
											'filterHtmlOptions'=>array('style'=>'width:30px;'), 
											'htmlOptions'=>array('style'=>'text-align: center;hight:5%;'),
										),
	
										array(
											'name'=>'fullname',
											'type'=>'html',
											// 'filter'=>false,
											'value'=>'$data->fullnamee',
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											'htmlOptions'=>array('style'=>'text-align: center;'),
										),
										
										


										array(
											'header' => 'Employee ID',
											'name'=>'employee_id',
											'type'=>'html',
											// 'filter'=>false,
											'visible' =>  $this->route === "user/admin/employee" ,
											'value'=>function($data){
												return $data->employee_id;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),
										array(
											'header' => 'Employee Class',
											'name'=>'empclass_title',
											'type'=>'html',
											// 'filter'=>false,
											// 'visible' => $this->route != "user/admin/General",
											// 'filter'=>CHtml::listData(Department::model()->findAll('active = "y" AND lang_id = 1 AND type_employee_id = "'.$type_emp.'" '),'id','dep_title'),
											'value'=>function($data){
												$class = '';
												if(isset($data->profile->EmpClass->title)){
													$class = $data->profile->EmpClass->title;
												}
												return $class ;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											
									
										),
										array(
											'header' => 'คำอธิบาย',
											'name'=>'empclass_descrpition',
											'type'=>'html',
											// 'filter'=>false,
											// 'visible' => $this->route != "user/admin/General",
											// 'filter'=>CHtml::listData($ListPosition,'id','position_title'),
											'value'=>function($data){
												$classdes = '';
												if(isset($data->profile->EmpClass->title)){
													$classdes = $data->profile->EmpClass->descrpition;
												}
												return $classdes ;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
									
										),
										array(
											'name'=>'email',
											'type'=>'raw',
											// 'filter'=>false,
											'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
											'filterHtmlOptions'=>array('style'=>'width:30px',),
											// 'htmlOptions'=>array('style'=>'width:300px'),
											'htmlOptions'=>array('width'=>'110px','style'=>'max-width:110px;overflow: hidden;')
			
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
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
											// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
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
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
											// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
										),
									// 	array(
									// 		'header' => 'สิทธิการใช้งาน',
									// 		'type'=>'html',
									//		'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
									// 		'filterHtmlOptions'=>array('style'=>'width:30px'),
									// 	//	'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
									// // 'filter'=>User::itemAlias("AdminStatus"),
									// 	),
										array(
											'name'=>'status',
											'type'=>'raw',
											'filter' => false,
											'value'=>'User::itemAlias("UserStatus",$data->status)',
											'filter' => User::itemAlias("UserStatus"),
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											//'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
										),
										array(
											'name'=>'online_status',
											'type'=>'raw',
											// 'filter' => false,
											'value'=>'User::chk_online($data->id,$data->lastactivity,$data->online_status)',
											'filter' => User::itemAlias("Online"),
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											//'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
										),
										array(
											'type'=>'raw',
											'value'=>function($data){

												return  '<button class="btn btn-info" onclick="sendMsg('.$data->id.')">เปลี่ยนรหัสผ่าน</button>';
												// CHtml::button("เปลี่ยนรหัสผ่าน",array('onclick'=>'sendMsg('.$data->id.')','class' => 'btn btn-info','data-id' =>$data->id));


											},
											'header' => 'เปลี่ยนรหัสผ่าน',
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											'htmlOptions'=>array('width'=>'100px','style'=>'max-width:100px;overflow: hidden;text-align: center;'),
											
											// 'htmlOptions'=>array('style'=>'text-align: center;'),
											// 'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:100%;'),
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
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											//'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
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
													if (password == verifyPassword) { 
														$.ajax({
															url: "<?= $this->createUrl('admin/ChangePasswordUser'); ?>", 
															type: "POST",
															data:  {id:id,
																password:password,
																verifyPassword:verifyPassword,

															},
															success: function(data){
																if (data) {
																	// setTimeout(function () {
																		swal("สำเร็จ", "เปลี่ยนรหัสผ่านสำเร็จ", "success");
																	// }, 3000);
																	setTimeout(function () {
																	location.reload();
																	},3000);
																}else{
																	// setTimeout(function () {
																		swal("ไม่สำเร็จ!", "ไม่สามารถเปลี่ยนรหัสผ่านสำเร็จ", "error");
																	// }, 10000);
																	setTimeout(function () {
																	location.reload();
																	}, 3000);

																}
															}
														});
													}else{
														swal("ไม่สำเร็จ!", "รหัสผ่านไม่ตรงกัน", "error");
													}
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
