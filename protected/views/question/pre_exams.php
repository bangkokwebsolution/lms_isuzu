		<!-- Header page -->
		<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php //echo Yii::app()->theme->baseUrl.'/images/bg-header-page.png'; ?>">
			<div class="container">
				<h1><?= $lesson->CourseOnlines->course_title; ?> 
					<small class="pull-right">
						<ul class="list-inline list-unstyled">
							<!-- <li><a href="#"><?= $labelCourse->label_homepage ?></a></li>/ -->
							<!-- <li><a href="#"><?= $label->label_courseName ?></a></li> -->
						</ul>
					</small>
				</h1>
			</div>
			<div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
		</div>

		<!-- Content -->
		<section class="content" id="pre-exams">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="well">
							<div class="exams-condition">
							<?php 
							// $isPreTest = Helpers::isPretestState($lesson->id);
							$isPreTest = ($testType == "pre") ? true : false;
							$typeText = $isPreTest ? $labelCourse->label_testPre : $labelCourse->label_testPost;

							?>
								<h2 class="text-center"><?= $typeText; ?></h2>
								<h4 class="text-center"><?= UserModule::t('lesson_name')  ?> : <?= $lesson->title;?></h4>
								<hr>
								<ul class="list-unstyled">
									<li><?= $labelCourse->label_totalTest  ?> <span class="pull-right"><?= $total_score; ?> <?= $labelCourse->label_list ?></span></li>
									<li><?= UserModule::t('timeTest') ?> <span class="pull-right"><?= $lesson->time_test; ?> <?= UserModule::t('minute') ?></span></li>
									<li><?= UserModule::t('totoal') ?> <span class="pull-right"><?= $total_score; ?> <?= $labelCourse->label_point ?></span></li>
								</ul>
								<div class="text-center">
									<a class="btn btn-warning" href="<?php echo $this->createUrl('/question/index',array('id' => $lesson->id,'type'=>$testType)); ?>" role="button"><?= $labelCourse->label_DoTest ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>		