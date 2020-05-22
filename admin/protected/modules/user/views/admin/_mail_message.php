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
	// $orgCoruse = json_decode($model->orgchart_lv2);
	// if(!empty($orgCoruse)){
		// $courseArray = array();
		// foreach ($orgCoruse as $key => $value) {
			// $data = OrgChart::getChilds($value);
			// if(!empty($data)){
				// foreach ($data as $key => $value) {
					// if(!in_array($value->courses->course_id, $courseArray)){
						// $courseArray[] = $value->courses->course_id;
						// echo '<h4>'.(++$idx).'. '.$value->courses->course_title.'</h4>'; 
					// }
				// }
			// }
		// }
	// } else {
		// echo 'ไม่มีหลักสูตร';
	// }

	
	// $data = OrgChart::getChilds($model->orgchart_lv2);
	// if(!empty($data)){
	// 	foreach ($data as $key => $value) {
	// 		echo '<h4>'.($key+1).'. '.$value->courses->course_title.'</h4>'; 
	// 	}
	// } else {
	// 	echo 'ไม่มีหลักสูตร';
	// }
	
	// if(!empty($model->orgchartlv2->orgcourse)){
	// 	foreach ($model->orgchartlv2->orgcourse as $key => $value) {
	// 		echo '<h4>'.($key+1).'. '.$value->courses->course_title.'</h4>'; 
	// 	}
	// } else {
	// 	echo 'ไม่มีหลักสูตร';
	// }


	?>
	 <h4>ท่านสามารถเข้าสู่ระบบได้ ที่ <a href="http://thorconn.com">http://thorconn.com</a></h4>
</body>
</html>