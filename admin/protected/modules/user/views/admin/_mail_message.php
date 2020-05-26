<html>
<head>
	<title></title>
	<style type="text/css">
</style>
</head>
<?php $model->newpassword = $model->identification; ?>
<body>
	<h4>เรียน : <?= $model->profile->firstname.' '.$model->profile->lastname; ?></h4>
	<h4>ผู้ดูแลระบบได้ทำการอนุมัติสมาชิกเข้าใช้งาน e-Learning Thoresen เรียบร้อยแล้ว โดยมี ชื่อผู้ใช้งานและรหัสผ่านดังนี้ </h4>
	<h4>- User : <?= $model->username; ?></h4>
	<h4>- Password : <?= $genpass; ?></h4>
	<!-- <h4>หลักสูตรที่ท่านสามารถเข้าเรียน มีดังนี้ </h4> -->
	<?php 
	?>
	 <h4>ท่านสามารถเข้าสู่ระบบได้ ที่  <a href="http://thorconn.com">http://thorconn.com</a></h4>
</body>
</html>