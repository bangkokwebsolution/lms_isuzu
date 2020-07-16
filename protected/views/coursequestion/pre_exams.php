		<!-- Header page -->
		<!-- 		<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php //echo Yii::app()->theme->baseUrl.'/images/bg-header-page.png'; ?>"> -->
			<div class="container">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb breadcrumb-main">
						<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $labelCourse->label_course; ?></a>
							<li class="breadcrumb-item active" aria-current="page"><?= $course->course_title; ?></li>
						</ol>
					</nav>
				</div> 
<!-- 			<div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</div>  -->

<!-- Content -->
<section class="content" id="pre-exams">
	<div class="container">
		<div class="row mt-2">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2">
				<div class="well">
					<div class="exams-condition">
						<h2 class="text-center">Course Examination</h2>
						<h4 class="text-center"><?= $labelCourse->label_courseName ?> : <?= $course->course_title;?></h4>
						<hr>
						<ul class="list-unstyled">
							<li><?= $labelCourse->label_totalTest ?> <span class="pull-right"><?= $manage->manage_row; ?> <?= $labelCourse->label_list ?></span></li>
							<li><?= UserModule::t('timeTest') ?> <span class="pull-right"><?= $course->time_test; ?> <?= UserModule::t('minute') ?></span></li>
							<li><?= UserModule::t('totoal') ?> <span class="pull-right"><?= $total_score; ?> <?= $labelCourse->label_point ?></span></li>
						</ul>
						<div class="text-center">
							<a class="btn btn-warning" href="<?php echo $this->createUrl('/coursequestion/index',array('id' => $course->course_id, 'type'=>$type)); ?>" role="button"><?= $labelCourse->label_DoTest ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>		