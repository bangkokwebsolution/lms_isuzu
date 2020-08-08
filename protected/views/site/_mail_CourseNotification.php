<html>
<head>
	<title></title>
	<style type="text/css">
</style>
</head>
<body>
	<h4>เรียน : <?= $model->profile->firstname.' '.$model->profile->lastname; ?></h4>
	<h4>แจ้งเตือนหลักสูตร <?= $nameCourse; ?>กำลังจะหมดอายุ ในอีก <?= $dayEnd; ?>วัน</h4>
	<h4>กรุณาทำการเข้าเรียนก่อนหลักสูตรจะปิด</h4>
	<br>
	<h4>จึงเรียนมาเพื่อทราบ</h4>

</body>
</html>