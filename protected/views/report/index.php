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
			<li class="active"><a data-toggle="tab" href="#first-report">รายงานการสมัครสมาชิก</a></li>
			<li><a data-toggle="tab" href="#second-report">รายงานการอบรม</a></li>
			<li><a data-toggle="tab" href="#third-report">รายงานแบบประเมินการอบรม</a></li>
		</ul>

		<div class="tab-content">

			<div id="first-report" class="tab-pane fade in active">
				<div class="row d-flex justify-content-center">
					<div class="col-sm-4 col-md-3">
						<a href="<?= $this->createUrl("report/report_register") ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-1.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานภาพรวมการสมัคร
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4 col-md-3 ">
						<a href="#">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-2.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานภาพการสมัครสมาชิก
									คนประจำเรือ
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4 col-md-3">
						<a href="#">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-3.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานภาพการสมัครสมาชิก
									คน Office
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div id="second-report" class="tab-pane fade">
				<div class="row d-flex justify-content-center">
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/course'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-4.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานภาพรวมการฝึกอบรบ
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4 col-md-3 ">
						<a href="<?php echo $this->createUrl('/report/courseCaptain'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-5.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานผู้เรียนตามรายหลักสูตร
									คนประจำเรือ
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4 col-md-3">
						<a href="<?php echo $this->createUrl('/report/courseOffice'); ?>">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-6.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานผู้เรียนตามรายหลักสูตร
									Office
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>

			<div id="third-report" class="tab-pane fade">

				<div class="row d-flex justify-content-center">
					<div class="col-sm-4 col-md-3">
						<a href="#">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-7.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานภาพรวมหลักสูตร
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4 col-md-3 ">
						<a href="#">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-8.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานหลักสูตร
									ของคนประจำเรือ
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-4 col-md-3">
						<a href="#">
							<div class="card-report">
								<div class="img-report">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/report-item-9.png" class="img-fluid ">
								</div>
								<div class="detail-report">
									รายงานหลักสูตร
									ของพนักงานออฟฟิศ
								</div>
							</div>
						</a>
					</div>
				</div>

			</div>

		</div> <!-- tab-content -->

	</div> <!-- container -->
</section>