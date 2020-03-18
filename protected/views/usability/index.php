<div class="header-page parallax-window" >
    <div class="container">
        <h1><?= $label->label_usability ?>
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage ?></a></li> /
                    <li><span class="text-bc"><?= $label->label_usability ?></span></li>
                </ul>
            </small>
        </h1>
    </div>
</div>

<!-- Content -->

<?php
// $usability_data = Usability::model()->findAll(array(
//     'order' => 'create_date ASC',
//     'condition' => 'active="y"',
//         ));
?>
<?php 

// echo '<pre>'; var_dump($usability_data) ?>

<section class="content" id="manual">
    <div class="container">
        <div class="row">
			
			<!--form search-->
		<!-- <form id="usabilityForm" class="col-sm-4 col-md-3" action="<?php echo $this->createUrl('usability/search') ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="text" placeholder="ใส่ข้อความที่ต้องการค้นหา...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">ค้นหา</button>
                                    </span>
                                </div>
                          </form> -->
        	<!--end form search-->
			<div class="col-sm-4 col-md-4">
			
			</div>

            <?php foreach ($usability_data as $usa) { ?>
                
            <div class="modal fade" id="modal-manual-detail-<?= $usa->usa_id ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                    <h4 class="modal-title"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo ($usa->usa_title); ?> </h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo htmlspecialchars_decode($usa->usa_detail) ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
            
           <?php } ?>

        </div>


        <div class="row">
        	<?php foreach ($usability_data as $usa) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="well">
							<a data-toggle="modal" href='#modal-manual-detail-<?= $usa->usa_id ?>'>
								<div class="manual-icon"><i class="fa fa-sign-in fa-3x" aria-hidden="true"></i></div>
								<h4><?php echo ($usa->usa_title); ?></h4>
							</a>
						</div>
					</div>

							<?php } ?>
		</div>
				
        <!-- Modal detail -->



    </div>
</section>
<!-- <div class="col-sm-4 col-md-3">
								<div class="well">
									<a data-toggle="modal" href='#modal-manual-detail-9'>
									<div class="manual-icon"><i class="fa fa-laptop fa-3x" aria-hidden="true"></i></div>
									<h4>การเข้าสู่ห้องเรียนออนไลน์</h4>
								</a>
								</div>
							</div>
							<div class="col-sm-4 col-md-3">
								<div class="well">
									<a data-toggle="modal" href='#modal-manual-detail-10'>
									<div class="manual-icon"><i class="fa fa-search fa-3x" aria-hidden="true"></i></div>
									<h4>การสอบและผลการสอบ</h4>
								</a>
								</div>
							</div>
							<div class="col-sm-4 col-md-3">
								<div class="well">
									<a data-toggle="modal" href='#modal-manual-detail-13'>
									<div class="manual-icon"><i class="fa fa-pencil-square-o fa-3x" aria-hidden="true"></i></div>
									<h4>การทำแบบสอบถาม</h4>
								</a>
								</div>
							</div>
							<div class="col-sm-4 col-md-3">
								<div class="well">
									<a data-toggle="modal" href='#modal-manual-detail-14'>
									<div class="manual-icon"><i class="fa fa-print fa-3x" aria-hidden="true"></i></div>
									<h4>การพิมพ์ใบประกาศนียบัตร</h4>
								</a>
								</div>
							</div>
							<div class="col-sm-4 col-md-3">
								<div class="well">
									<a data-toggle="modal" href='#modal-manual-detail-17'>
									<div class="manual-icon"><i class="fa fa-key fa-3x" aria-hidden="true"></i></div>
									<h4>การเปลี่ยนรหัสผ่าน หรือการลืมรหัสผ่าน</h4>
								</a>
								</div>
							</div>
							<div class="col-sm-4 col-md-3">
								<div class="well">
									<a data-toggle="modal" href='#modal-manual-detail-18'>
									<div class="manual-icon"><i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i></div>
									<h4>วิธีการแจ้งปัญหาการใช้งาน</h4>
								</a>
								</div>
							</div>
							<div class="col-sm-4 col-md-3">
								<div class="well">
									<a data-toggle="modal" href='#modal-manual-detail-19'>
									<div class="manual-icon"><i class="fa fa-mouse-pointer fa-3x" aria-hidden="true"></i></div>
									<h4>การใช้โปรแกรมในการเรียนผ่านระบบ (e-Learning)</h4>
								</a>
								</div>
							</div> -->