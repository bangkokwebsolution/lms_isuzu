
<html>
<head>
  <title></title>
  <style type="text/css">
</style>
</head>

<body>
  <h4>เรียน : <?= $model->profile->firstname.' '.$model->profile->lastname; ?></h4>
  <h4>ท่านได้ทำการแก้ไขรหัสผ่านระบบ e-Learning AirAsia เรียบร้อยแล้ว โดยมี ชื่อผู้ใช้งานและรหัสผ่านดังนี้ </h4>
  <h4>- User : <?= $model->username; ?></h4>
  <h4>- Password : <?= $pass; ?></h4>

  <h4>ท่านสามารถเข้าสู่ระบบได้ ที่ <a href="http://lms.thaiairasia.co.th/lms_airasia">http://lms.thaiairasia.co.th/lms_airasia/</a></h4>
</body>
</html>