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
					echo "Report";
				} else {
					echo "รายงาน";
				}
				?>
			</li>
		</ol>
	</nav>
</div>

<section id="report-main">
	<div class="container">

		<h2 class="text-center">
			<?php
			if (Yii::app()->session['lang'] == 1) {
				echo "Report";
			} else {
				echo "รายงาน";
			}
			?>
		</h2>

		<ul class="nav nav-tabs mt-1">
			<li <?php if(!isset($_GET["target"])){ echo 'class="active"'; } ?>><a data-toggle="tab" href="#first-report"><?php echo Yii::app()->session['lang'] == 1?'Register Report ':'รายงานการสมัครสมาชิก'; ?></a></li>
			<li <?php if(isset($_GET["target"]) && $_GET["target"] == "course"){ echo 'class="active"'; } ?>>
				<a data-toggle="tab" href="#second-report"><?php echo Yii::app()->session['lang'] == 1?'Training Report ':'รายงานการอบรม'; ?></a>
			</li>
			<li <?php if(isset($_GET["target"]) && $_GET["target"] == "assessment"){ echo 'class="active"'; } ?>><a data-toggle="tab" href="#third-report"><?php echo Yii::app()->session['lang'] == 1?'Training Assessment Report ':'รายงานแบบประเมินการอบรม'; ?></a></li>
		</ul>

		<div class="tab-content">

			<div id="first-report" class="tab-pane fade <?php if(!isset($_GET["target"])){ echo 'in active'; } ?>">
				<div class="row d-flex justify-content-center">
					<?php if($authority == 1 || $authority == 2 || $authority == 3){ ?>
					<div class="col-sm-4 col-md-3">
						<a href="<?= $this->createUrl("report/report_register") ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-1.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Register Overview Report ':'รายงานภาพรวมการสมัคร'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php if($authority == 1 || $type_em == 1){ ?>
					<div class="col-sm-4 col-md-3 ">
						<a href="<?= $this->createUrl("report/registership") ?>">  
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-2.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Register Staff Ship Report ':'รายงานภาพการสมัครสมาชิก
									คนประจำเรือ'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php
					}

					if($authority == 1 || $type_em == 2){
					?>
					<div class="col-sm-4 col-md-3">
						<a href="<?= $this->createUrl("report/registeroffice") ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-3.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Register Staff Office Report ':'รายงานภาพการสมัครสมาชิก
									คน Office'; ?>
								</div>
							</div>
						</a>
					</div>
				</div>
				<?php
					}
				}
				?>
			</div>
			<div id="second-report" class="tab-pane fade <?php if(isset($_GET["target"]) && $_GET["target"] == "course"){ echo 'in active'; } ?>">
				<div class="row d-flex justify-content-center">
					<?php if($authority == 1 || $authority == 2 || $authority == 3){ ?>

					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/course'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-4.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Training Overview Report ':'รายงานภาพรวมการฝึกอบรม'; ?>
								</div>
							</div>
						</a>
					</div>
					
					<?php if($authority == 1 || $type_em == 1){ ?>
					<div class="col-sm-4 col-md-3 ">
						<a href="<?php echo $this->createUrl('/report/courseCaptain'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-5.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Report of learners staff ship course ':'รายงานผู้เรียนตามรายหลักสูตรคนประจำเรือ'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php } ?>

					<?php if($authority == 1 || $type_em == 2){ ?>
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/courseOffice'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-6.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Report of learners staff office course ':'รายงานผู้เรียนตามรายหลักสูตรOffice'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php } ?>

					<?php } // if($authority == 1 || $authority == 2) ?>
				</div>

				<div class="row d-flex justify-content-center">
					<div class="col-sm-4 col-md-3">
							<a href="<?php echo $this->createUrl('/report/courseall'); ?>">
	

							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-7.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Course Overview Report ':'รายงานภาพรวมผลการสอบตามรายหลักสูตร'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php if($authority == 1 || $type_em == 1){ ?>
					<div class="col-sm-4 col-md-3 ">
						<a href="<?php echo $this->createUrl('/report/examShip'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-8.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Course Staff Ship Report ':'รายงานผลการสอบตามรายหลักสูตรคนประจำเรือ'; ?>
								</div>
							</div>
						</a>
					</div>
					<?php } ?>
					<?php if($authority == 1 || $type_em == 2){ ?>
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/examOffice'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-9.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Course Staff Office Report ':'รายงานผลการสอบตามรายหลักสูตรOffice'; ?>
								</div>
							</div>
						</a>
					</div>
				<?php } ?>
				</div>
			</div>

			<div id="third-report" class="tab-pane fade <?php if(isset($_GET["target"]) && $_GET["target"] == "assessment"){ echo 'in active'; } ?>" >

				<div class="row d-flex justify-content-center">
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/assessment'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-10.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									<?php echo Yii::app()->session['lang'] == 1?'Training assessment Report ':'รายงานภาพรวมแบบประเมินสอบถาม'; ?>
								</div>
							</div>
						</a>
					</div>
				</div>

			</div>

		</div> <!-- tab-content -->

	</div> <!-- container -->
</section>