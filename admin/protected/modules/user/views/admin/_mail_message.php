<html>

<head>
  <title></title>
  <style type="text/css">
  </style>
</head>

<body>
  <h3><u>อนุมัติการสมัครสมาชิก\ Approval</u></h3>
  <h4>เรียน : <?= $model->profile->firstname . ' ' . $model->profile->lastname; ?></h4>
  <h4>ท่านได้ทำการสมัครเพื่อเข้าใช้บริการ elearning.imct.co.th และแอพพลิเคชั่น IMCT e-Leaning เรียบร้อยแล้ว </h4>
  <h4>โดยมีชื่อผู้ใช้และรหสัผ่านดังนี้</h4>
  <h4>- User : <?= $model->username; ?></h4>
  <h4>- Password : <?= $genpass; ?></h4>
  <h4><u>ข้อแนะนำในการตั้งรหัสผ่าน</u></h4>
  <h4>1. การตั้งรหัสผ่านควรจะมีจำนวน 6 ตัวอักษรขึ้นไป</h4>
  <h4>2. ไม่ควรใช้ข้อมูลส่วนตัว หรือข้อมูลที่คาดเดาได้ง่าย เช่น วันเดือนปีเกิดหรือเลขที่บัตรประชาชน มาตั้งรหัสผ่าน</h4>
  <h4>3. รายงานต่อเจ้าหน้าที่ดูแลระบบทันที เมื่อผู้ใช้งาน (user) คาดว่าชื่อผู้ใช้และรหัสผ่านของตนเองถูกผู้อื่นนำไปใช้งานโดยไม่ได้รับอนุญาต พร้อมกับเปลี่ยนรหัสผ่านโดยทันที</h4>
  <h4>4. ไม่กระทำการเปลี่ยนแปลงแก้ไข หรือทำลายระบบป้องกันของระบบ ที่จะเข้าไปเรียกใช้ข้อมูลในส่วนที่ตนเองไม่มีสิทธิ</h4>
  <h4>5. ท่านสามารถเข้าสู่ระบบของเราได้ที่<a href="https://elearning.imct.co.th/">https://elearning.imct.co.th/</a></h4>
  <br><br>
  <h3><u>Registered successfully</u></h3>
  <h4>Dear : <?= $model->profile->firstname_en . ' ' . $model->profile->lastname_en; ?></h4>
  <h4>You have successfully applied a member of elearning.imct.co.th and IMCT e-Leaning application</h4>
  <h4>Please see a username and password as follows.</h4>
  <h4>- Username : <?= $model->username; ?></h4>
  <h4>- Password : <?= $genpass; ?></h4>
  <h4>Tips for setting a password</h4>
  <h4>1. The password should be 6 characters or more.</h4>
  <h4>2. Do not use personal information. or easily guessable information such as date of birth or ID card number come set a password</h4>
  <h4>3. Report to the administrator immediately. When a user (user) expects his username and password to be used by others without permission. along with changing the password immediatelys</h4>
  <h4>4. Don't to alter, modify or destroy the web system's security to access information in the area that they don't have authority.</h4>
  <h4>5. You can login to our system at <a href="https://elearning.imct.co.th/">https://elearning.imct.co.th/</a></h4>
</body>

</html>