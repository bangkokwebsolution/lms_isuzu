<html>
<head>
	<title></title>
	<style type="text/css">
</style>
</head>
<body>
	<h4>เรียน : <?= $User->profile->firstname.' '.$User->profile->lastname; ?></h4>
	<h4>กรุณาเข้าเรียนหลักสูตร <?= $CourseOnline->course_title; ?> ให้เสร็จภายในวันที่ <?= Helpers::lib()->changeFormatDate($CourseGeneration->gen_period_start,'datetime'); ?> ถึง <?= Helpers::lib()->changeFormatDate($CourseGeneration->gen_period_end,'datetime'); ?> </h4>

</body>
</html>