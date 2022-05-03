<html>

<head>
  <title></title>
  <style type="text/css">
  </style>
</head>

<body>
  <h3><u>อนุมัติการเข้าใช้งานระบบ IMCT e-Learning</u></h3>
  <h4>เรียน : <?= $model->profile->firstname . ' ' . $model->profile->lastname; ?></h4>
  <h4>ท่านได้รับการอนุมัติเพื่อเข้าใช้งานระบบ IMCT e-Learning เรียบร้อยแล้ว </h4>
  <h4>โดยมีชื่อผู้ใช้และรหัสผ่านดังนี้</h4>
  <h4>- ผู้ใช้งาน : <?= $model->username; ?></h4>
  <h4>- รหัสผ่าน : <?= $genpass; ?></h4>
  <h4><u>ข้อแนะนำในการเข้าสู่ระบบและตั้งรหัสผ่าน</u></h4>
  <h4>1. หลังจากที่ได้รับการอนุมัติชื่อผู้ใช้และรหัสผ่าน ให้ท่านทำการเปลี่ยนรหัสผ่านทันทีหลังจากการเข้าสู่ระบบครั้งแรก </h4>
  <h4>2. การตั้งรหัสผ่านควรจะมีจำนวน 6 ตัวอักษรขึ้นไป</h4>
  <h4>3. ไม่ควรใช้ข้อมูลส่วนตัว หรือข้อมูลที่คาดเดาได้ง่าย เช่น วันเดือนปีเกิดหรือเลขที่บัตรประชาชน มาตั้งรหัสผ่าน</h4>
  <h4>4. รายงานต่อเจ้าหน้าที่ดูแลระบบทันที เมื่อผู้ใช้งาน (user) คาดว่าชื่อผู้ใช้และรหัสผ่านของตนเองถูกผู้อื่นนำไปใช้งานโดยไม่ได้รับอนุญาต พร้อมกับเปลี่ยนรหัสผ่านโดยทันที</h4>
  <h4>5. ไม่กระทำการเปลี่ยนแปลงแก้ไข หรือทำลายระบบป้องกันของระบบ เพื่อที่จะเข้าไปเรียกใช้ข้อมูลในส่วนที่ตนเองไม่มีสิทธิ</h4>
  <h4>6. ท่านสามารถเข้าสู่ระบบของเราได้ที่<a href="https://elearning.imct.co.th/">https://elearning.imct.co.th/</a></h4>
  <br><br>
  <h3><u>Approval for access IMCT e-learning system</u></h3>
  <h4>Dear : <?= $model->profile->firstname_en . ' ' . $model->profile->lastname_en; ?></h4>
  <h4>You have successfully approved a user of elearning.imct.co.th </h4>
  <h4>Please see a username and password as follows.</h4>
  <h4>- Username : <?= $model->username; ?></h4>
  <h4>- Password : <?= $genpass; ?></h4>
  <h4>Instructions for login system and setting password</h4>
  <h4>1. After got approve username and password please change your password immediately after the first login. </h4>
  <h4>2. The password should be 6 characters or more.</h4>
  <h4>3. Do not use personal information. or easily guessable information such as date of birth or ID card number come set a password</h4>
  <h4>4. Report to the asystem administrator immediately when user expect that his/her username and password was  used by others without permission. Along with changing the password immediately.</h4>
  <h4>5. Do not, modify or destroy the web system's security in order to access any information that not have authorized.</h4>
  <h4>6. You can login to  system at <a href="https://elearning.imct.co.th/">https://elearning.imct.co.th/</a></h4>
</body>

</html>