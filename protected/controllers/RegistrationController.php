<?php

class RegistrationController extends Controller {
    public function init()
    {
        parent::init();
        $this->lastactivity();
        
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function resize_image($file, $destination, $w, $h) {
        //Get the original image dimensions + type
        list($source_width, $source_height, $source_type) = getimagesize($file);


        switch ($source_type) {
            case IMAGETYPE_GIF:
            $source_gdim = imagecreatefromgif($file);
            break;

            case IMAGETYPE_JPEG:
            $source_gdim = imagecreatefromjpeg($file);
            break;

            case IMAGETYPE_PNG:
            $source_gdim = imagecreatefrompng($file);
            break;
        }

        //Figure out if we need to create a new JPG, PNG or GIF
//    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
//    if ($ext == "jpg" || $ext == "jpeg") {
//        $source_gdim=imagecreatefromjpeg($file);
//    } elseif ($ext == "png") {
//        $source_gdim=imagecreatefrompng($file);
//    } elseif ($ext == "gif") {
//        $source_gdim=imagecreatefromgif($file);
//    } else {
//        //Invalid file type? Return.
//        return;
//    }
        //If a width is supplied, but height is false, then we need to resize by width instead of cropping
        if ($w && !$h) {
            $ratio = $w / $source_width;
            $temp_width = $w;
            $temp_height = $source_height * $ratio;

            $desired_gdim = imagecreatetruecolor($temp_width, $temp_height);
            imagecopyresampled(
                $desired_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height
            );
        } elseif (!$w && $h) {
            $ratio = $h / $source_height;
            $temp_width = $source_width * $ratio;
            $temp_height = $h;

            $desired_gdim = imagecreatetruecolor($temp_width, $temp_height);
            imagecopyresampled(
                $desired_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height
            );
        } else {
            $source_aspect_ratio = $source_width / $source_height;
            $desired_aspect_ratio = $w / $h;

            if ($source_aspect_ratio > $desired_aspect_ratio) {
                /*
                 * Triggered when source image is wider
                 */
                $temp_height = $h;
                $temp_width = (int) ($h * $source_aspect_ratio);
            } else {
                /*
                 * Triggered otherwise (i.e. source image is similar or taller)
                 */
                $temp_width = $w;
                $temp_height = (int) ($w / $source_aspect_ratio);
            }

            /*
             * Resize the image into a temporary GD image
             */

            $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
            imagecopyresampled(
                $temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height
            );

            /*
             * Copy cropped region from temporary image into the desired GD image
             */

            $x0 = ($temp_width - $w) / 2;
            $y0 = ($temp_height - $h) / 2;
            $desired_gdim = imagecreatetruecolor($w, $h);
            imagecopy(
                $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $w, $h
            );
        }

        /*
         * Render the image
         * Alternatively, you can save the image in file-system or database
         */


        switch ($source_type) {
            case IMAGETYPE_GIF:
            imagegif($desired_gdim, $destination);
            break;

            case IMAGETYPE_JPEG:
            imagejpeg($desired_gdim, $destination, 100);
            break;

            case IMAGETYPE_PNG:
            imagepng($desired_gdim, $destination);
            break;
        }

//    if ($ext == "jpg" || $ext == "jpeg") {
//        imagejpeg($desired_gdim,$destination.".jpg",100);
//    } elseif ($ext == "png") {
//        imagepng($desired_gdim,$destination.".png");
//    } elseif ($ext == "gif") {
//        imagegif($desired_gdim,$destination.".gif");
//    } else {
//        return;
//    }

        imagedestroy($desired_gdim);
    }

    // public function actionGetAjaxDivision(){
    //     if(isset($_GET['company_id']) && $_GET['company_id'] != ""){
    //         $datalist = Division::model()->findAll('active = "y" and company_id = '.$_GET['company_id']);
    //         if($datalist){
    //             echo "<option value=''> เลือกกอง</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->div_title."</option>";
    //             }
    //         }else{
    //             echo "<option value=''> ไม่พบกอง</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกกอง</option>";
    //     }
    // }

    // public function actionGetAjaxDepartment(){
    //     if(isset($_GET['division_id']) && $_GET['division_id'] != ""){
    //         $datalist = Department::model()->findAll('active = "y" and division_id = '.$_GET['division_id']);
    //         if($datalist){
    //             echo "<option value=''> เลือกแผนก</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->dep_title."</option>";
    //             }
    //         }else{
    //             echo "<option value=''> ไม่พบแผนก</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกแผนก</option>";
    //     }
    // }

    // public function actionGetAjaxPosition(){
    //     if(isset($_GET['department_id']) && $_GET['department_id'] != ""){
    //         $datalist = Position::model()->findAll('active = "y" and department_id = '.$_GET['department_id']);
    //         if($datalist){
    //             echo "<option value=''> เลือกตำแหน่ง</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->position_title."</option>";
    //             }
    //         }else{
    //             echo "<option value=''> ไม่พบตำแหน่ง</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกตำแหน่ง</option>";
    //     }
    // }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
// public function actionReport_problem()
//     {
//         $model=new ReportProblem;

//         if(isset($_POST['ReportProblem']))
//         {
//             $model->attributes=$_POST['ReportProblem'];
//             if($model->save())
//                 $this->redirect(array('index'));
//         }

//         $this->render('report_problem',array(
//             'model'=>$model,
//         ));
//     }
    private function RandomPassword(){

        $number="abcdefghijklmnopqrstuvwxyz0123456789";
        $i = '';
        $result = '';
        for($i==1;$i<6;$i++){ // จำนวนหลักที่ต้องการสามารถเปลี่ยนได้ตามใจชอบนะครับ จาก 5 เป็น 3 หรือ 6 หรือ 10 เป็นต้น
            $random=rand(0,strlen($number)-1); //สุ่มตัวเลข
            $cut_txt=substr($number,$random,1); //ตัดตัวเลข หรือ ตัวอักษรจากตำแหน่งที่สุ่มได้มา 1 ตัว
            $result.=substr($number,$random,1); // เก็บค่าที่ตัดมาแล้วใส่ตัวแปร
            $number=str_replace($cut_txt,'',$number); // ลบ หรือ แทนที่ตัวอักษร หรือ ตัวเลขนั้นด้วยค่า ว่าง
        }

        return $result;

    }
    // public function actionEdit($id){

    // $model = Profile::model()->findByPk($id);
    // $this->render('Edit',array('model'=>$model));

    // }

    public function actionShowForm(){

        $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
        $chk_status_reg = $SettingAll['ACTIVE_REGIS'];
        if (!$chk_status_reg) {
            $this->redirect(array('site/index'));
        }
        $con = $_POST['status'];
        if ($con == '1') {
            $this->redirect(array('registration/index'));
        } elseif ($con == '2') {
            $this->redirect(array('site/index'));
        } else {
            if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
            }
            $model = Conditions::model()->find(array(
                'condition'=>'lang_id=:lang_id AND active=:active',
                'params' => array(':lang_id' => $langId, ':active' => 'y')
            ));

            $label = MenuRegistration::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));

            if(!$label){
                $label = MenuRegistration::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                ));
            }

            // $model = Conditions::model()->findbyPk(1);
            if(!empty($_POST)){
             Yii::app()->user->setFlash('CheckQues','กรุณายืนยัน');
             Yii::app()->user->setFlash('checkClass', "warning");
         } 
         $this->render('Con_regis',array('model'=>$model,'label'=>$label));

     }
 }
 public function actionIndex() { 


   //  $gen = Generation::model()->find('active=1');
   //  $check = false;
   //  if ($gen) {
   //      $start_date = strtotime($gen->start_date);
   //      $end_date = strtotime($gen->end_date);
   //      $current_date = strtotime(date("Y-m-d"));
   //      if ($current_date >= $start_date) {
   //          if ($current_date >= $end_date) {
   //              $check = true;
   //              $msg = 'หมดระยะการลงทะเบียน';
   //              Yii::app()->user->setFlash('msg',$msg);
   //          }
   //      } else {
   //          $check = true;
   //          $msg = 'ยังไม่เปิดการลงทะเบียน';
   //          Yii::app()->user->setFlash('msg',$msg);
   //      }
   //  } else {
   //      $check = true;
   //      $msg = 'ปิดการลงทะเบียน';
   //      Yii::app()->user->setFlash('msg',$msg);
   //  }
   //  $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
   //  $chk_status_reg = $SettingAll['ACTIVE_REGIS'];
   //  if(!$chk_status_reg){
   //      $msg = 'ปิดการลงทะเบียน';
   //      Yii::app()->user->setFlash('msg',$msg);
   //  }
    $chk_status_email = $SettingAll['CONFIRM_MAIL'];
   //  if (!$chk_status_reg || $check) {
   //      // $this->redirect(array('site/index','msg'=>$msg));
   //     $this->redirect(array('site/index'));
   // }
    $users = new User;
    $profile = new Profile;
    $ProfilesEdu = new ProfilesEdu;
    $FileEdu = new FileEdu;
    $FileTraining = new FileTraining;
    $ProfilesWorkHistory = new ProfilesWorkHistory;
    $AttachFile = new AttachFile;
    $AttachName = new AttachName;
    $ProfilesTraining = new ProfilesTraining;
    $ProfilesLanguage = new ProfilesLanguage;

    $session = Yii::app()->session;

    $this->performAjaxValidation($ProfilesEdu);
    $this->performAjaxValidation($ProfilesWorkHistory);
    $this->performAjaxValidation($ProfilesTraining);
    $this->performAjaxValidation($ProfilesLanguage);

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
        Yii::app()->language = 'en';
    }else{
        $langId = Yii::app()->session['lang'];
        Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
    }

    $label = MenuRegistration::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
    if(!$label){
        $label = MenuRegistration::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }

    if (isset($_POST['Profile'])) {
   // var_dump($_POST['type_user']);exit();
    //var_dump($_POST);exit();
    // $memberLdap = Helpers::lib()->ldapTms($_POST['User'][email]);
    // if($memberLdap['count'] > 0){
    //     $msg = "Can't use this Email";
    //     Yii::app()->user->setFlash('msg',$msg);
    //     $this->redirect(array('site/index'));
    //     exit();
    // }

    /*$Neworg = $_POST['Orgchart'];         
    $Neworg = json_encode($Neworg);*/

    $users->identification = $_POST['idcard'];
    $profile->identification = $_POST['idcard'];
    $profile->passport = $_POST['passport'];

    $users->username = $_POST['User'][username];

    $users->email = $_POST['User'][email];
    $users->department_id = $_POST['User'][department_id];
    $users->branch_id = $_POST['User'][branch_id];

            // $users->password = $_POST['User'][password];
            // $passwordshow = $_POST['Users'][password];
    $type_card = $_POST['type_card'];

   // $genpass = ($type_card == 'p')?substr($profile->passport, -6):substr($profile->identification, -6);
    $genpass = $this->RandomPassword();
    $users->password = $genpass;
    $users->verifyPassword = $genpass;

           // $users->orgchart_lv2 = $Neworg;
   // $users->activkey = ($type_card == 'p')?UserModule::encrypting(microtime() . $profile->identification):UserModule::encrypting(microtime() . $profile->passport);
    $users->activkey = UserModule::encrypting(microtime() .$genpass);

    //$users->password = ($type_card == 'p')?UserModule::encrypting(microtime() . $profile->identification):UserModule::encrypting(microtime() . $profile->passport);
//$users->verifyPassword = ($type_card == 'p')?UserModule::encrypting(microtime() . $profile->identification):UserModule::encrypting(microtime() . $profile->passport);
// var_dump($users->activkey);exit();
//     $users->password = $_POST['idcard']; 
    $users->repass_status = 0;
    $passwordshow = $_POST['idcard'];
    $users->create_at = date("Y-m-d H:i:s");
//    $users->activkey = UserModule::encrypting(microtime() . $_POST['idcard']);
            //$users->activkey = UserModule::encrypting(microtime() . $users->password);
    //$users->orgchart_lv2 = $Neworg;

            //$users->verifyPassword = $_POST['User'][verifyPassword];
   // $users->verifyPassword = $_POST['idcard'];
    $users->type_register = 1;
    // $users->division_id = $_POST['User'][division_id];

    // $users->passport = $_POST['User'][passport];

    // $users->department_id = $_POST['User'][department_id];
    // $users->station_id = $_POST['User'][station_id];

        // var_dump($users->station_id);exit();
        // $users->company_id = $_POST['User'][company_id];
    $profile->address_parent = $_POST['address_parent'];
    if ($profile->address_parent == 'y') {
      $profile->address_parent = 'y';
  }else{
     $profile->address_parent = 'n'; 
 }

 $profile->occupation = $_POST['Profile'][occupation];
 $profile->type_user = $_POST['type_user']; 
 $profile->history_of_illness = $_POST['history_of_illness'];
 $profile->status_sm = $_POST['status_sm'];
 $profile->type_employee = $_POST['type_employee'];
 $profile->type_card = $_POST['type_card'];
 $profile->title_id = $_POST['Profile'][title_id]; 
 $profile->sex = ($profile->title_id == 1)? "Male":"Female";
 $profile->firstname = $_POST['Profile'][firstname];
 $profile->lastname = $_POST['Profile'][lastname];
 $profile->firstname_en = $_POST['Profile'][firstname_en];
 $profile->lastname_en = $_POST['Profile'][lastname_en];
 $profile->tel = $_POST['Profile'][tel];
 $profile->birthday = $_POST['Profile'][birthday];
 $profile->age = $_POST['Profile'][age];
 $profile->mouth_birth = $_POST['Profile'][mouth_birth];
 $profile->address = $_POST['Profile'][address];
 $profile->date_of_expiry = $_POST['Profile'][date_of_expiry];
 $profile->seamanbook = $_POST['Profile'][seamanbook];
 $profile->seaman_expire = $_POST['Profile'][seaman_expire];
 $profile->race = $_POST['Profile'][race];
 $profile->nationality = $_POST['Profile'][nationality];
 $profile->religion = $_POST['Profile'][religion];
 $profile->line_id = $_POST['Profile'][line_id];
 $profile->ship_id = $_POST['Profile'][ship_id];
 $profile->address2 = $_POST['Profile'][address2];
 $profile->ship_up_date = $_POST['Profile'][ship_up_date];
 $profile->ship_down_date = $_POST['Profile'][ship_down_date];
 $profile->phone1 = $_POST['Profile'][phone1];
 $profile->phone2 = $_POST['Profile'][phone2];
 $profile->phone3 = $_POST['Profile'][phone3];
 $profile->phone = $_POST['Profile'][phone];

 $profile->ss_card = $_POST['Profile'][ss_card];
 $profile->tax_payer = $_POST['Profile'][tax_payer];
 $profile->number_of_children = $_POST['Profile'][number_of_children];
 $profile->place_of_birth = $_POST['Profile'][place_of_birth];
 $profile->hight = $_POST['Profile'][hight];
 $profile->weight = $_POST['Profile'][weight];
 $profile->hair_color = $_POST['Profile'][hair_color];
 $profile->eye_color = $_POST['Profile'][eye_color];
 $profile->place_issued = $_POST['Profile'][place_issued];
 $profile->date_issued = $_POST['Profile'][date_issued];
 $profile->blood = $_POST['Profile'][blood];
 $profile->spouse_firstname = $_POST['Profile'][spouse_firstname];
 $profile->spouse_lastname = $_POST['Profile'][spouse_lastname];
 $profile->father_firstname = $_POST['Profile'][father_firstname];
 $profile->father_lastname = $_POST['Profile'][father_lastname];
 $profile->mother_firstname = $_POST['Profile'][mother_firstname];
 $profile->mother_lastname = $_POST['Profile'][mother_lastname];
 $profile->military = $_POST['military'];
 $profile->sickness = $_POST['Profile'][sickness];
 $profile->expected_salary = $_POST['Profile'][expected_salary];
 $profile->start_working = $_POST['Profile'][start_working];
 $profile->accommodation = $_POST['accommodation'];
 $profile->domicile_address = $_POST['Profile'][domicile_address];
 $profile->occupation_spouse = $_POST['Profile'][occupation_spouse];
 $profile->occupation_father = $_POST['Profile'][occupation_father];
 $profile->occupation_mother = $_POST['Profile'][occupation_mother];
 $profile->pass_expire = $_POST['Profile'][pass_expire];
 $profile->passport_place_issued = $_POST['Profile'][passport_place_issued];
 $profile->passport_date_issued = $_POST['Profile'][passport_date_issued];
 $profile->name_emergency = $_POST['Profile'][name_emergency];
 $profile->relationship_emergency = $_POST['Profile'][relationship_emergency];

    // if(!$chk_status_email){
    //     $users->status = 1;
    // } else {
    //     $users->status = 0;
    // }
if ($profile->type_user == 1) {
    $profile->type_employee = 1;
    $users->status = 0;
    $users->register_status = 0;
    $users->position_id = $_POST['position_gen'];
    $users->department_id = $_POST['department_gen'];
}else if($profile->type_user == 5){
    $users->username = $_POST['idcard'];
    $users->status = 0;
    $users->register_status = 0;
}else if($profile->type_user == 3){
    $profile->type_employee = 2;
    $users->register_status = 1;
    $users->status = 1;
    $users->position_id = $_POST['User'][position_id];
    $users->department_id = $_POST['User'][department_id];
}

    // $profile->generation = $gen->id_gen;

   /* $criteria=new CDbCriteria;
    $criteria->compare('department_id',$_POST['User'][department_id]);
    $criteria->compare('position_title',$_POST['User'][position_name]);
    $position = Position::model()->find($criteria);
    if(!$position){
        $position = new Position;
        $position->department_id = $_POST['User'][department_id];
        $position->position_title = $_POST['User'][position_name];
        $position->create_date = date("Y-m-d H:i:s");
        if(!empty($_POST['User'][department_id]) && !empty($_POST['User'][position_name]))$position->save();
    }
    $users->position_name = $_POST['User'][position_name];
    $users->position_id = $position->id;

    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secret = '6LdMXXcUAAAAAK76NVqqh5qMv05wg2QxbHoSrJMc';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if ($responseData->success)$users->captcha = $responseData->success;
    }*/
//     var_dump( $profile->validate());
// var_dump( $users->validate());
//  $errors = $users->getErrors();
//         var_dump($errors); //or print_r($errors);
//   //if (isset($_POST['PController']) && isset($_POST['PAction'])) {    
//     exit();
//    var_dump($_POST['ProfilesWorkHistory']);
//     if ($_POST['ProfilesWorkHistory']) {
//         foreach ($_POST['ProfilesWorkHistory'] as $key => $value) {
//            if (in_array("", $value)) {
//               echo "ok";
//            }else{
//               echo "ppp";
//            }
//         }
//         echo "oooo";
//     }else{
//         echo "no";
//     }
    // var_dump($POST['AttachName']);
    // var_dump(CUploadedFile::getInstance($AttachName, 'attach_crew_identification'));
    // var_dump(CUploadedFile::getInstance($AttachName, 'attach_identification'));
    // var_dump(CUploadedFile::getInstance($AttachName, 'attach_house_registration'));
//     var_dump($profile);
// exit();
    if ($profile->validate() && $users->validate()) {
//                    เข้ารหัสpassword
                    //$users->password = UserModule::encrypting($users->password);
                    //$users->verifyPassword = UserModule::encrypting($users->verifyPassword);
        $users->password = UserModule::encrypting($genpass);
        
                    // $users->department_id = 1; // fix ประเภทสมาชิกหน้าบ้านเป็นสมาชิกทั่วไป
    } 
    // else {
    //     //  $errors = $users->getErrors();
    //     // var_dump($errors); //or print_r($errors);
    //     // exit();
    // }

    // $uploadFile = CUploadedFile::getInstance($users, 'pic_user');
    // if (isset($uploadFile)) {
    //     $uglyName = strtolower($uploadFile->name);
    //     $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
    //     $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
    //     $users->pic_user = $beautifulName;
    // }
    

    if ($users->save()) {
        // บันทึกรูปภาพ crop
        if(isset($_POST['url_pro_pic']) && $_POST['url_pro_pic'] != ""){
            $uploadDir = Yii::app()->getUploadPath(null);
            $path1 = "user";
            $path2 = $users->id;
            $path3 = "thumb";
            if (!is_dir($uploadDir."../".$path1."/")) {
                mkdir($uploadDir."../".$path1."/", 0777, true);
            }
            if (!is_dir($uploadDir."../".$path1."/".$path2."/")) {
                mkdir($uploadDir."../".$path1."/".$path2."/", 0777, true);
            }
            if (!is_dir($uploadDir."../".$path1."/".$path2."/".$path3."/")) {
                mkdir($uploadDir."../".$path1."/".$path2."/".$path3."/", 0777, true);
            }else{ // ลบ file เก่า
                $files = glob($uploadDir."../".$path1."/".$path2."/".$path3.'/*');
                    foreach($files as $file){ // iterate files
                        if(is_file($file)){
                            unlink($file); // delete file
                        }             
                    }
            }

            $users->pic_user = date("YmdHis")."_.jpg";
            $uploadDir = $uploadDir."..\\".$path1."\\".$path2."\\".$path3."\\";
            $targetFile = $uploadDir.$users->pic_user;
            file_put_contents($targetFile,file_get_contents($_POST['url_pro_pic']));
            $users->save();
        }




                        // $findid = User::model()->notsafe()->findbyattributes(array('email'=>$_POST['User'][email]));

        $profile->user_id = $users->id;
        if (isset($_POST['ProfilesEdu'])){
            foreach ($_POST['ProfilesEdu'] as $action_index=>$action_value){
               if (!in_array("", $action_value)) {
                   $Edu = new ProfilesEdu;
                   $Edu->user_id = $users->id;
                   $Edu->created_date = date("Y-m-d H:i:s");
                   $Edu->created_by = $users->id;
                   $Edu->attributes = $action_value;
                   $Edu->save();
               }
           }
       }

       if (isset($_POST['ProfilesWorkHistory'])){
        foreach ($_POST['ProfilesWorkHistory'] as $action_work=>$action_value_work){
           if (!in_array("", $action_value_work)) {
               $WorkHistory = new ProfilesWorkHistory;
               $WorkHistory->user_id = $users->id;
               $WorkHistory->created_date = date("Y-m-d H:i:s");
               $WorkHistory->created_by = $users->id;
               $WorkHistory->attributes = $action_value_work;
               $WorkHistory->save();
           }
       }
   }

   if (isset($_POST['ProfilesTraining'])){
    foreach ($_POST['ProfilesTraining'] as $action_Training=>$action_value_Training){
       if (!in_array("", $action_value_Training)) {
           $ProfilesTraining = new ProfilesTraining;
           $ProfilesTraining->user_id = $users->id;
           $ProfilesTraining->create_date = date("Y-m-d");
           $ProfilesTraining->create_by = $users->id;
           $ProfilesTraining->attributes = $action_value_Training;
           $ProfilesTraining->save();
       }
   }
}
if (isset($_POST['ProfilesLanguage'])){   
    foreach ($_POST['ProfilesLanguage'] as $action_Language=>$action_value_Language){
       if (!in_array("", $action_value_Language)) {
           $ProfilesLanguage = new ProfilesLanguage;
           $ProfilesLanguage->user_id = $users->id;
           $ProfilesLanguage->create_date = date("Y-m-d");
           $ProfilesLanguage->create_by = $users->id;
           $ProfilesLanguage->attributes = $action_value_Language;
           $ProfilesLanguage->save(false);       
       }
   }
}

if (isset($_POST['FileTraining'])){ 
    $uploadDir = Yii::app()->getUploadPath(null);
    $path1 = $users->id;
    if ($path1) {
        mkdir($uploadDir."../Trainingfile/".$path1."/", 0777, true);
    } 
    $i=0 ;          
    foreach ($_POST['FileTraining'] as $key => $value) {
       $tmpFilePath = $_FILES['FileTraining']['tmp_name'][$i];
       if ($tmpFilePath != ""){
         $name_file = $_FILES['FileTraining']['name'][$i];
         $newFilePath = Yii::app()->basePath.'/../uploads/Trainingfile/'.$path1.'/'. $name_file['filename'];
         if(move_uploaded_file($tmpFilePath['filename'], $newFilePath)) {

            $fileTrain = new FileTraining;
            $fileTrain->user_id = $users->id;
            $fileTrain->create_date = date("Y-m-d ");
            $fileTrain->create_by = $users->id;
            $fileTrain->filename = $name_file['filename'];
            $fileTrain->file_name = $value['name_training'];
            $fileTrain->length = "2.00";
            $fileTrain->expire_date = $value['expire_date'];
            $fileTrain->name_training = $value['name_training'];
            $fileTrain->save(false);         

        }else{
            echo "Fill upload";
        }   

        $i++;
    }    

}
}

// if(isset($uploadFile))
// {
//     Yush::init($users);
//     $originalPath = Yush::getPath($users, Yush::SIZE_ORIGINAL, $users->pic_user);
//     $thumbPath = Yush::getPath($users, Yush::SIZE_THUMB, $users->pic_user);
//     $smallPath = Yush::getPath($users, Yush::SIZE_SMALL, $users->pic_user);
//                                 // Save the original resource to disk
//     $uploadFile->saveAs($originalPath);
//     $size = getimagesize($originalPath);
//                             /////////// SAVE IMAGE //////////
//     Yush::init($users);
//     $originalPath = Yush::getPath($users, Yush::SIZE_ORIGINAL, $users->pic_user);
//     $thumbPath = Yush::getPath($users, Yush::SIZE_THUMB, $users->pic_user);
//     $smallPath = Yush::getPath($users, Yush::SIZE_SMALL, $users->pic_user);
//                             // Save the original resource to disk
//     $uploadFile->saveAs($originalPath);
//     $size = getimagesize($originalPath);

//                                 // Create a small image
//     $smallImage = Yii::app()->phpThumb->create($originalPath);
//     $smallImage->resize(385, 220);
//     $smallImage->save($smallPath);
//                                 // Create a thumbnail
//     $thumbImage = Yii::app()->phpThumb->create($originalPath);
//     $thumbImage->resize(200, 200);
//     $thumbImage->save($thumbPath);
// }

$attach_passport  = CUploadedFile::getInstance($AttachName, 'attach_passport');
if (isset($attach_passport)) {
    $uglyName = strtolower($attach_passport->name); 
    $uploadDir = $webroot;
    $rnd = rand(0,9999999999);
    $fileName = trim($rnd). "." . $attach_passport->extensionName;
    $webroot = Yii::app()->basePath.'/../uploads/attach/'.$fileName;
    if(!empty($attach_passport))  
    {
        $attach_passport->saveAs($webroot);
    }
    $AttachName->attach_passport = 1;
    $AttachFile = new AttachFile;
    $AttachFile->user_id = $users->id;
    $AttachFile->file_data = $AttachName->attach_passport;
    $AttachFile->file_name = $fileName;
    $AttachFile->filename = $uglyName;
    $AttachFile->create_date = date("Y-m-d");
    $AttachFile->create_by = $users->id;
    $AttachName->user_id = $users->id;
    $AttachName->create_date = date("Y-m-d");
    $AttachName->create_by = $users->id;
    $AttachFile->save(false);
    $AttachName->save(false);
}
$attach_crew_identification  = CUploadedFile::getInstance($AttachName, 'attach_crew_identification');
if (isset($attach_crew_identification)) {
    $uglyName = strtolower($attach_crew_identification->name); 
    $uploadDir = $webroot;
    $rnd = rand(0,9999999999);
    $fileName = trim($rnd). "." . $attach_crew_identification->extensionName;
    $webroot = Yii::app()->basePath.'/../uploads/attach/'.$fileName;
    if(!empty($attach_crew_identification))  
    {
        $attach_crew_identification->saveAs($webroot);
    }
    $AttachName->attach_crew_identification = 2;
    $AttachFile = new AttachFile;
    $AttachFile->user_id = $users->id;
    $AttachFile->file_data = $AttachName->attach_crew_identification;
    $AttachFile->file_name = $fileName;
    $AttachFile->filename = $uglyName;
    $AttachFile->create_date = date("Y-m-d");
    $AttachFile->create_by = $users->id;
    $AttachName->user_id = $users->id;
    $AttachName->create_date = date("Y-m-d");
    $AttachName->create_by = $users->id;
    $AttachFile->save(false);
    $AttachName->save(false);
}
$attach_identification  = CUploadedFile::getInstance($AttachName, 'attach_identification');
if (isset($attach_identification)) {
    $uglyName = strtolower($attach_identification->name); 
    $uploadDir = $webroot;
    $rnd = rand(0,9999999999);
    $fileName = trim($rnd). "." . $attach_identification->extensionName;
    $webroot = Yii::app()->basePath.'/../uploads/attach/'.$fileName;
    if(!empty($attach_identification))  
    {
        $attach_identification->saveAs($webroot);
    }
    $AttachName->attach_identification = 3;
    $AttachFile = new AttachFile;
    $AttachFile->user_id = $users->id;
    $AttachFile->file_data = $AttachName->attach_identification;
    $AttachFile->file_name = $fileName;
    $AttachFile->filename = $uglyName;
    $AttachFile->create_date = date("Y-m-d");
    $AttachFile->create_by = $users->id;
    $AttachName->user_id = $users->id;
    $AttachName->create_date = date("Y-m-d");
    $AttachName->create_by = $users->id;
    $AttachFile->save(false);
    $AttachName->save(false);
}
$attach_house_registration  = CUploadedFile::getInstance($AttachName, 'attach_house_registration');
if (isset($attach_house_registration)) {
    $uglyName = strtolower($attach_house_registration->name); 
    $uploadDir = $webroot;
    $rnd = rand(0,9999999999);
    $fileName = trim($rnd). "." . $attach_house_registration->extensionName;
    $webroot = Yii::app()->basePath.'/../uploads/attach/'.$fileName;
    if(!empty($attach_house_registration))  
    {
        $attach_house_registration->saveAs($webroot);
    }
    $AttachName->attach_house_registration = 4;
    $AttachFile = new AttachFile;
    $AttachFile->user_id = $users->id;
    $AttachFile->file_data = $AttachName->attach_house_registration;
    $AttachFile->file_name = $fileName;
    $AttachFile->filename = $uglyName;
    $AttachFile->create_date = date("Y-m-d");
    $AttachFile->create_by = $users->id;
    $AttachName->user_id = $users->id;
    $AttachName->create_date = date("Y-m-d");
    $AttachName->create_by = $users->id;
    $AttachFile->save(false);
    $AttachName->save(false);
}
if(isset($session['filenameComDoc']) || count($session['filenameComDoc'])!=0)
{
    foreach ($session['filenameComDoc'] as $filenameComKey => $filenameComValue)
    {
        $filenameCheck = explode('.', $filenameComValue);
                            // if($filenameCheck[1] == 'pdf' or $filenameCheck[1] == 'docx' or $filenameCheck[1] == 'pptx')
                            // {
        $file = new FileEdu;
        $file->user_id = $users->id;
        $file->create_date = date("Y-m-d ");
        $file->create_by = $users->id;
        $file->filename = $filenameComValue;
        $file->file_name = $session['filenameOriComDoc'][$filenameComKey];
        $file->length = "2.00";
        $file->save(false);
                            // }
    }
}
    // if(isset($session['filenameComTrain']) || count($session['filenameComTrain'])!=0)
    // {
    //     foreach ($session['filenameComTrain'] as $filenameComKey => $filenameComValue)
    //     {
    //         $filenameCheck = explode('.', $filenameComValue);

    //         $fileTrain = new FileTraining;
    //         $fileTrain->user_id = $users->id;
    //         $fileTrain->create_date = date("Y-m-d ");
    //         $fileTrain->create_by = $users->id;
    //         $fileTrain->filename = $filenameComValue;
    //         $fileTrain->file_name = $session['filenameOriComTrain'][$filenameComKey];
    //         $fileTrain->length = "2.00";
    //         $fileTrain->save(false);
    //                         // }
    //     }
    // }
if ($profile->save()) {

        // if($chk_status_email){
                                //////////// send mail /////////
    if ($profile->type_user == 3) {

            //$activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $users->activkey, "email" => $users->email));

        $to = array(
         'email'=>$users->email,
         'firstname'=>$profile->firstname,
         'lastname'=>$profile->lastname,
     );
        $firstname = $profile->firstname;
        $lastname = $profile->lastname;
        $username = $users->username;
        $firstname_en = $profile->firstname_en;
        $lastname_en = $profile->lastname_en;
            //$message = $this->renderPartial('Form_mail',array('emailshow'=>$users->email,'passwordshow'=>$genpass,'nameshow'=>$profile->firstname,'activation_url'=>$activation_url),true);
        $message = $this->renderPartial('Form_mail',array('email'=>$users->email,'genpass'=>$genpass,'username'=>$username,'firstname'=>$firstname,'lastname'=>$lastname,'firstname_en'=>$firstname_en,'lastname_en'=>$lastname_en),true);
        $mail = Helpers::lib()->SendMail($to,'สมัครสมาชิกสำเร็จ\ Registered successfully',$message);
        Yii::app()->user->setFlash('profile',$profile->identification);
        Yii::app()->user->setFlash('msg', $users->email);
        Yii::app()->user->setFlash('icon', "success");
        $this->redirect(array('site/index'));

    }else if ($profile->type_user == 1){

        // $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $users->activkey, "email" => $users->email));

       $to = array(
         'email'=>$users->email,
         'firstname'=>$profile->firstname,
         'lastname'=>$profile->lastname,
     );
       $firstname = $profile->firstname;
       $lastname = $profile->lastname;
       $firstname_en = $profile->firstname_en;
       $lastname_en = $profile->lastname_en;
       $message = $this->renderPartial('Form_mail_Ship',array('firstname'=>$firstname,'lastname'=>$lastname,'firstname_en'=>$firstname_en,'lastname_en'=>$lastname_en),true);
       $mail = Helpers::lib()->SendMail($to,'สมัครสมาชิกสำเร็จ\ Registered successfully',$message);
       Yii::app()->user->setFlash('msg',"ท่านสมัครสมาชิกเรียบร้อยแล้ว รอการอนุมัติจากผู้ดูแลระบบผ่านทางอีเมล");
       Yii::app()->user->setFlash('icon', "success");
       $this->redirect(array('site/index'));
   }else if ($profile->type_user == 5) {

            //$activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $users->activkey, "email" => $users->email));

       $to = array(
         'email'=>$users->email,
         'firstname'=>$profile->firstname,
         'lastname'=>$profile->lastname,
     );
       $firstname = $profile->firstname;
       $lastname = $profile->lastname;
       $firstname_en = $profile->firstname_en;
       $lastname_en = $profile->lastname_en;
       $message = $this->renderPartial('Form_mail_General',array('firstname'=>$firstname,'lastname'=>$lastname,'firstname_en'=>$firstname_en,'lastname_en'=>$lastname_en),true);
       $mail = Helpers::lib()->SendMail($to,'สมัครสมาชิกสำเร็จ\ Registered successfully',$message);
       Yii::app()->user->setFlash('msg',"ท่านสมัครสมาชิกเรียบร้อยแล้ว รอการอนุมัติจากผู้ดูแลระบบผ่านทางอีเมล");
       Yii::app()->user->setFlash('icon', "success");
       $this->redirect(array('site/index'));

    }else{
    $login = '1';
    Yii::app()->user->setFlash('profile',$profile->identification);
    Yii::app()->user->setFlash('msg', $users->email);
    Yii::app()->user->setFlash('icon', "success");
    $this->redirect(array('site/index'));
}
        // }else{

        //     $login = '1';
        //                     // $this->redirect(array('site/index','profile' => $profile, 'users' => array(
        //                     //     'email'=>$users->email,
        //                     //     'password'=>$users->password),'login' => $login));
        //     Yii::app()->user->setFlash('profile',$profile->identification);
        //     Yii::app()->user->setFlash('users', $users->email);

        //                     // Yii::app()->user->setFlash('msg', "แก้ไขข้อมูลเรียบร้อย");
        //     Yii::app()->user->setFlash('icon', "success");
        //     $this->redirect(array('site/index'));
        //                     // $this->redirect(array('site/index','profile' => $profile->identification, 'users' => $users->email,'login' => $login));

        // }

} 
//else {
    // unset($session['idxDoc']);
    // unset($session['pathComDoc']);
    // unset($session['filenameComDoc']);
    // unset($session['filenameOriComDoc']);

    // unset($session['idxTrain']);
    // unset($session['pathComTrain']);
    // unset($session['filenameComTrain']);
    // unset($session['filenameOriComTrain']);
    // $this->render('index', array('profile' => $profile, 'users' => $users,'label'=> $label, 'ProfilesEdu' => $ProfilesEdu, 'FileEdu' => $FileEdu, 'FileTraining' => $FileTraining));
    // echo "okt";
//}
} 
//else {
    // unset($session['idxDoc']);
    // unset($session['pathComDoc']);
    // unset($session['filenameComDoc']);
    // unset($session['filenameOriComDoc']);

    // unset($session['idxTrain']);
    // unset($session['pathComTrain']);
    // unset($session['filenameComTrain']);
    // unset($session['filenameOriComTrain']);
    // $this->render('index', array('profile' => $profile, 'users' => $users,'label'=> $label, 'ProfilesEdu' => $ProfilesEdu, 'FileEdu' => $FileEdu, 'FileTraining' => $FileTraining));
    // echo "ok";
//}

}
unset($session['idxDoc']);
unset($session['pathComDoc']);
unset($session['filenameComDoc']);
unset($session['filenameOriComDoc']);

unset($session['idxTrain']);
unset($session['pathComTrain']);
unset($session['filenameComTrain']);
unset($session['filenameOriComTrain']);
$this->render('index', array('profile' => $profile, 'users' => $users,'label'=> $label, 'ProfilesEdu' => $ProfilesEdu, 'FileEdu' => $FileEdu, 'FileTraining' => $FileTraining, 'ProfilesWorkHistory' => $ProfilesWorkHistory, 'AttachFile' => $AttachFile,'AttachName'=> $AttachName,'ProfilesTraining'=>$ProfilesTraining,'ProfilesLanguage' => $ProfilesLanguage));

}
public function actionUpdate() {
    
     if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
            }

    $profile = Profiles::model()->findByPk(Yii::app()->user->id);
    $users = Users::model()->findByPk(Yii::app()->user->id);

    if(isset($_POST['sub-pro'])){
        // var_dump($_POST);exit();

        $fullnameTH = explode(' ',$_POST['fullnameTH']);
        $fullnameEN = explode(' ',$_POST['fullnameEN']);

        // $profile->firstname = $fullnameTH[0];
        // $profile->lastname = $fullnameTH[1];
        // $profile->firstname_en = $fullnameEN[0];
        // $profile->lastname_en = $fullnameEN[1];
        // $profile->employee_class = $_POST['employee_class'];
        // $profile->position_description = $_POST['position_description'];

        // $users->employee_id = $_POST['employee_id'];
        // $users->email = $_POST['email'];

        if(isset($_POST['url_pro_pic']) && $_POST['url_pro_pic'] != ""){
            $uploadDir = Yii::app()->getUploadPath(null);
            $path1 = "user";
            $path2 = $users->id;
            $path3 = "thumb";
            if (!is_dir($uploadDir."../".$path1."/")) {
                mkdir($uploadDir."../".$path1."/", 0777, true);
            }
            if (!is_dir($uploadDir."../".$path1."/".$path2."/")) {
                mkdir($uploadDir."../".$path1."/".$path2."/", 0777, true);
            }
            if (!is_dir($uploadDir."../".$path1."/".$path2."/".$path3."/")) {
                mkdir($uploadDir."../".$path1."/".$path2."/".$path3."/", 0777, true);
            }else{ // ลบ file เก่า
                $files = glob($uploadDir."../".$path1."/".$path2."/".$path3.'/*');
                    foreach($files as $file){ // iterate files
                        if(is_file($file)){
                            unlink($file); // delete file
                        }             
                    }
            }

            $users->pic_user = date("YmdHis")."_.jpg";
            $uploadDir = $uploadDir."..\\".$path1."\\".$path2."\\".$path3."\\";
            $targetFile = $uploadDir.$users->pic_user;
            file_put_contents($targetFile,file_get_contents($_POST['url_pro_pic']));
        }
        // $_POST['']
        if($profile->save(false) && $users->save(false)){
            $this->redirect('update');
        }
    }
    $label = MenuCourse::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
       if(!$label){
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }

$this->render('index', array('profile' => $profile, 'users' => $users, 'page'=>'update','label'=>$label));

}

//
//        $this->performAjaxValidation(array($model,$profile));
//        // collect user input data
//        if(isset($_POST['RegistrationForm']) && isset($_POST['Profile']))
//        {
//            $model->attributes=$_POST['RegistrationForm'];
//            $profile->attributes=$_POST['Profile'];
//            $rnd = rand(0,999);
//            $uploadFile = CUploadedFile::getInstance($model,'image_user');
//            $fileName = "{$rnd}-{$uploadFile->name}";
//            $path = Yii::app()->basePath.'/../uploads/user/';
//            $destination = $path.$fileName;
//            $w = 200;
//            $h = 200;
//
//            $soucePassword = $model->password;
//            $model->activkey=UserModule::encrypting(microtime().$model->password);
//            $model->password=UserModule::encrypting($model->password);
//            $model->lastvisit_at = date('Y-m-d H:i:s');
//            $model->image_user = $fileName;
////            var_dump($model->save(false));
////            exit();
//            // validate user input and redirect to the previous page if valid
//            if($model->save(false)){
//                $profile->user_id = $model->id;
//                $profile->gender = '0';
//                $profile->save(false);
//                $this->resize_image($uploadFile->tempName,$destination,$w,$h);
//
//                $AssignRole = new Authassignment;
//                $AssignRole->itemname = "Student";
//                $AssignRole->userid = $model->id;
//                $AssignRole->data = "N;";
//                $AssignRole->save(false);
////                if (Yii::app()->controller->module->sendActivationMail) {
////                    $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
////                    UserModule::sendMail($model->email,UserModule::t("??????????????? {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("???????????????????????? <br><br> {activation_url}",array('{activation_url}'=>$activation_url)));
////                    $this->redirect(array('/user/logout'));
////                }
////
////                if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
////                    $identity=new UserIdentity($model->username,$soucePassword);
////                    $identity->authenticate();
////                    Yii::app()->user->login($identity,0);
////                    $this->redirect(Yii::app()->controller->module->returnUrl);
////                } else {
////                    if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
////                        Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
////                    } elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
////                        Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
////                    } elseif(Yii::app()->controller->module->loginNotActiv) {
////                        Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
////                    } else {
////                        Yii::app()->user->setFlash('registration',UserModule::t("??????????????? ????????????????????????????????????"));
////                    }
////                    $this->refresh();
////                }
//            }
//        }
//
//        $this->render('index',array(
//            'model'=>$model,
//            'profile'=>$profile,
//        ));
public function actionUploadifiveEdu() {
    $session = Yii::app()->session;
    if(!isset($session['idxDoc'])){
        $session['idxDoc'] = 1;
    }
        // Set the uplaod directory
    $webroot = Yii::app()->getUploadPath('edufile');
    $uploadDir = $webroot;
        // Set the allowed file extensions
        $fileTypes = array('pdf','jpg','jpeg','png'); // Allowed file extensions  //

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

            $rnd = rand(0,9999999999);
            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = "{$rnd}-{$session['idxDoc']}.".strtolower($uploadedFile->getExtensionName());
            $session['idxDoc'] += 1;
            //$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
            $targetFile = $uploadDir . $fileName;
            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the filevar_dump($targetFile); exit();
                //  var_dump($session['pathComDoc']);exit();
                if (!isset($session['filenameComDoc']) || count($session['filenameComDoc'])==0)
                {
                    $session['filenameComDoc'] = array($fileName);
                }else{
                    $filenameComArr = $session['filenameComDoc'];
                    $filenameComArr[] = $fileName;
                    $session['filenameComDoc'] = $filenameComArr;
                }

                if (!isset($session['filenameOriComDoc']) || count($session['filenameOriComDoc'])==0)
                {
                    $session['filenameOriComDoc'] = array(str_replace(".".$fileParts,"",$_FILES['Filedata']['name']));
                }else{
                    $filenameOriComArr = $session['filenameOriComDoc'];
                    $filenameOriComArr[] = str_replace(".".$fileParts,"",$_FILES['Filedata']['name']);
                    $session['filenameOriComDoc'] = $filenameOriComArr;
                }

                if (!isset($session['pathComDoc']) || count($session['pathComDoc'])==0)
                {
                    $session['pathComDoc'] = array($uploadDir);
                }else{
                    $pathComArr = $session['pathComDoc'];
                    $pathComArr[] = $uploadDir;
                    $session['pathComDoc'] = $pathComArr;
                }
                move_uploaded_file($tempFile, $targetFile);
                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }

        }

    }

    public function actionUploadifiveTraining() {
        $session = Yii::app()->session;
        if(!isset($session['idxTrain'])){
            $session['idxTrain'] = 1;
        }
        // Set the uplaod directory
        $webroot = Yii::app()->getUploadPath('Trainingfile');
        $uploadDir = $webroot;
        // Set the allowed file extensions
        $fileTypes = array('pdf','jpg','jpeg','png'); // Allowed file extensions  //

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

            $rnd = rand(0,9999999999);
            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = "{$rnd}-{$session['idxTrain']}.".strtolower($uploadedFile->getExtensionName());
            $session['idxTrain'] += 1;
            //$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
            $targetFile = $uploadDir . $fileName;
             //var_dump($fileParts);exit();
            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the filevar_dump($targetFile); exit();
                //  var_dump($session['filenameComDoc']);exit();

              if (!isset($session['filenameComTrain']) || count($session['filenameComTrain'])==0)
              {
                $session['filenameComTrain'] = array($fileName);
            }else{
                $filenameComArr = $session['filenameComTrain'];
                $filenameComArr[] = $fileName;
                $session['filenameComTrain'] = $filenameComArr;
            }

            if (!isset($session['filenameOriComTrain']) || count($session['filenameOriComTrain'])==0)
            {
                $session['filenameOriComTrain'] = array(str_replace(".".$fileParts,"",$_FILES['Filedata']['name']));
            }else{
                $filenameOriComArr = $session['filenameOriComTrain'];
                $filenameOriComArr[] = str_replace(".".$fileParts,"",$_FILES['Filedata']['name']);
                $session['filenameOriComTrain'] = $filenameOriComArr;
            }

            if (!isset($session['pathComTrain']) || count($session['pathComTrain'])==0)
            {
                $session['pathComTrain'] = array($uploadDir);
            }else{
                $pathComArr = $session['pathComTrain'];
                $pathComArr[] = $uploadDir;
                $session['pathComTrain'] = $pathComArr;
            }
            move_uploaded_file($tempFile, $targetFile);
            echo 1;

        } else {

                // The file type wasn't allowed
            echo 'Invalid file type.';

        }

    }

}

public function actionEditName()
{
    $FileEdu = FileEdu::model()->findByPK($_GET['id']);
    if($FileEdu){
        $FileEdu->file_name = $_GET['name'];
        $FileEdu->update_date = date("Y-m-d");
        $FileEdu->update_by = Yii::app()->user->id;
        $FileEdu->save();
    }
}
public function actionDeleteFileDoc($id)
{
    $FileEdu = FileEdu::model()->findByPk($id);

    if($FileEdu->count()>0){

        $webroot = Yii::app()->basePath."/../uploads/edufile/";

        if(is_file($webroot.$FileEdu->filename)){
            unlink($webroot.$FileEdu->filename);
        }

        if($FileEdu->delete($id)){
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function actionEditNameTrain()
{
    $FileTraining = FileTraining::model()->findByPK($_GET['id']);
    if($FileTraining){
        $FileTraining->file_name = $_GET['name'];
        $FileTraining->update_date = date("Y-m-d");
        $FileTraining->update_by = Yii::app()->user->id;
        $FileTraining->save();
    }
}
public function actionDeleteFileTrain($id)
{
    $FileTraining = FileTraining::model()->findByPk($id);
    
    if($FileTraining->count()>0){

        $webroot = Yii::app()->basePath."/../uploads/Trainingfile/".$FileTraining->user_id."/";

        if(is_file($webroot.$FileTraining->filename)){
            unlink($webroot.$FileTraining->filename);
        }
        
        $FileTraining->filename = null;
        $FileTraining->file_name = $FileTraining->file_name;
        $FileTraining->update_date = date("Y-m-d");
        $FileTraining->update_by = Yii::app()->user->id;
        var_dump($FileTraining);
        $FileTraining->save();
     }
}
public function actionEditNamePassport()
{
    $AttachFile = AttachFile::model()->findByPK($_GET['id']);
    
    if($AttachFile){
        $AttachFile->filename = $_GET['name'];
        $AttachFile->update_date = date("Y-m-d");
        $AttachFile->update_by = Yii::app()->user->id;
        $AttachFile->save();
    }
}
public function actionDeleteFilePassport($id)
{
    $AttachFile = AttachFile::model()->findByPk($id);
    if($AttachFile->count()>0){

        $webroot = Yii::app()->basePath."/../uploads/attach/";

        if(is_file($webroot.$AttachFile->file_name)){
            unlink($webroot.$AttachFile->file_name);
        }

        if($AttachFile->delete($id)){
            echo 1;
        }else{
            echo 0;
        }
    }
}
    /**
     * This is the action to handle external exceptions.
     */

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionRepassword() {

        if (User::model()->findbyPk(Yii::app()->user->id)->repass_status == 0){
            $model = new RepassForm();
            if (isset($_POST['RepassForm'])) {

               // $user = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
                $repass = RepassForm::model()->findbyattributes(array('id'=>Yii::app()->user->id));
              
                $repass->password = $_POST['RepassForm']['password'];
                $repass->verifyPassword = $_POST['RepassForm']['verifyPassword'];
                    // var_dump($model->save());
                    // var_dump($model->getErrors());
                    // exit();
                if ($repass->validate()) {

                    $repass->password = UserModule::encrypting($repass->password);
                    $repass->verifyPassword = UserModule::encrypting($repass->verifyPassword);
                    $repass->repass_status = 1;
                

                    if ($repass->save(false)) {

                        // $to['email'] = $model->email;
                        // $to['firstname'] = $model->profile->firstname;
                        // $to['lastname'] = $model->profile->lastname;
                        // $pass = $_POST['Users']['password'];
                        // $message = $this->renderPartial('Form_mail',array('model' => $model,'pass'=>$pass),true);
                        // if($message){
                        //    // $send = Helpers::lib()->SendMailNotification($to,'แก้ไขรหัสผ่าน',$message);
                        //     $send = Helpers::lib()->SendMail($to,'แก้ไขรหัสผ่าน',$message);
                        // }   

                        $status = "เปลี่ยนรหัสผ่านสำเร็จ";
                        $type_status = "success";
                    } else {
                        $status = "เปลี่ยนรหัสผ่าน ไม่สำเร็จ";
                        $type_status = "error";
                    }
                    //$this->redirect(array('site/index','status' => $status,'type_status'=> $type_status));
                    $this->redirect(array('site/index'));
                }else{
                    // var_dump($repass->getErrors());
                }
            }
            $this->render('repassword',array('model'=>$model));
        }else {
            $this->redirect(array('site/index'));
        }
    }
    public function actionCheckMail(){

       $criteria= new CDbCriteria;
       $criteria->condition='email=:email';
       $criteria->params=array(':email'=>$_POST['text_mail']);
       $model = Users::model()->findAll($criteria);
       if ($model != null) {
        $data = false;
        echo ($data);
    }else{ 
     $data = true; 
     echo ($data);
 }

}

  public function actionCheckPassport(){

       $criteria= new CDbCriteria;
       $criteria->condition='passport=:passport';
       $criteria->params=array(':passport'=>$_POST['text_passport']);
       $model = Profile::model()->findAll($criteria);
       if ($model != null) {
        $data = false;
        echo ($data);
        }else{ 
             $data = true; 
             echo ($data);
       }

}

public function actionCheckIdcard(){
 $str = $_POST['idcard'];
 $chk = strlen($str);
 if($chk == "13"){
            $id = str_split(str_replace('-', '', $_POST['idcard'])); //ตัดรูปแบบและเอา ตัวอักษร ไปแยกเป็น array $id
            $sum = 0;
            $total = 0;
            $digi = 13;
            for ($i = 0; $i < 12; $i++) {
                $sum = $sum + (intval($id[$i]) * $digi);
                $digi--;
            }
            $total = (11 - ($sum % 11)) % 10;
            if ($total != $id[12]) { //ตัวที่ 13 มีค่าไม่เท่ากับผลรวมจากการคำนวณ ให้ add error
              //  $this->addError('identification', 'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร์*');
                $data = 'no';
                echo ($data);
            }else{
               $criteria= new CDbCriteria;
               $criteria->condition='user.identification=:identification';
               $criteria->params=array(':identification'=>$str);
               $model = Users::model()->findAll($criteria);
               foreach ($model as $key_u => $value_u) {
                $profile_chk = Profile::model()->findByPk($value_u->id);
                if($profile_chk == ""){
                    $addlog = new LogUsers;
                    $addlog->controller = "Registration";
                    $addlog->action = "CheckIdcardDelUser";
                    $addlog->parameter = $str;
                    $addlog->user_id = $value_u->id;
                    $addlog->create_date = date("Y-m-d H:i:s");
                    $addlog->save(false);
                    
                    $Users_del = Users::model()->findByPk($value_u->id);
                    $Users_del->delete();
                }
               }
               $criteria= new CDbCriteria;
               $criteria->condition='user.identification=:identification';
               $criteria->params=array(':identification'=>$str);
               $model = Users::model()->findAll($criteria);

               if ($model) {
                 $data = 'yes';
                 echo ($data);
             }else{ 
              $data = 'bool'; 
              echo ($data);
          }
      }
  }else{
    $data = 'little';
    echo ($data);
}

}

    // public function actionLdap(){
    //     $member = Helpers::lib()->ldapTms('taaonprem04@airasia.com');
    //     var_dump($member);exit();
    // }
public function actionListPosition(){

     // $model=Position::model()->findAll('department_id=:department_id',
     //    array(':department_id'=>$_POST['id']));
   $criteria= new CDbCriteria;
   $criteria->condition='department_id=:department_id AND active=:active';
   $criteria->params=array(':department_id'=>$_POST['id'],':active'=>'y');
   $criteria->order = 'sortOrder ASC';
   $model = Position::model()->findAll($criteria);

   $data=CHtml::listData($model,'id','position_title',array('empty' => 'ตำแหน่ง'));
   if ($data) {
    if ($_POST['type_users'] == "1") {
        $sub_list = Yii::app()->session['lang'] == 1?'Select Position ':'เลือกตำแหน่ง';
    }else{
        $sub_list = Yii::app()->session['lang'] == 1?'Select Department ':'เลือกแผนก';
    }
       
       $data = '<option value ="">'.$sub_list.'</option>';
       foreach ($model as $key => $value) {
        $data .= '<option value = "'.$value->id.'"'.'>'.$value->position_title.'</option>';
    }
    echo ($data);
}else{
    echo '<option value = "">ไม่พบข้อมูล</option>';

}

}

public function actionListBranch(){

 // $model=Branch::model()->findAll('position_id=:position_id',
 //    array(':position_id'=>$_POST['id']));
   $criteria= new CDbCriteria;
   $criteria->condition='position_id=:position_id AND active=:active';
   $criteria->params=array(':position_id'=>$_POST['id'],':active'=>'y');
   $criteria->order = 'sortOrder ASC';
   $model = Branch::model()->findAll($criteria);

   $data=CHtml::listData($model,'id','branch_name',array('empty' => 'สาขา'));
   $sub_list = Yii::app()->session['lang'] == 1?'Select Level ':'เลือกระดับ';
   $data = '<option value ="">'.$sub_list.'</option>';
   foreach ($model as $key => $value) {
    $data .= '<option value = "'.$value->id.'"'.'>'.$value->branch_name.'</option>';
}
echo ($data);

}

public function actionListDepartment(){

   $criteria= new CDbCriteria;
   $criteria->condition='type_employee_id=:type_employee_id AND active=:active';
   $criteria->params=array(':type_employee_id'=>$_POST['id'],':active'=>'y');
   $criteria->order = 'sortOrder ASC';
   $model = Department::model()->findAll($criteria);

   $data=CHtml::listData($model,'id','dep_title',array('empty' => 'แผนก'));
   $sub_list = Yii::app()->session['lang'] == 1?'Select Department ':'เลือกแผนก';
   $data = '<option value ="">'.$sub_list.'</option>';
   foreach ($model as $key => $value) {
    $data .= '<option value = "'.$value->id.'"'.'>'.$value->dep_title.'</option>';
}
echo ($data);

}

public function actionCalculateBirthday(){
 $birthdays = $_POST['item'];
 $Current = date('d-m-Y');
 $birthdayn = explode("-", $birthdays);
 $Current = explode("-", $Current);

 if ($birthdayn[2] < $Current[2]) {    

    $birthday = $birthdayn[2].'-'.$birthdayn[1].'-'.$birthdayn[0];
    $dob = new DateTime($birthday);
    $now = new DateTime();

    $difference = $now->diff($dob);

    $age = $difference->y;
    $mouth = $difference->m;
    $day = $difference->d;

    $data = $difference->y.'-'.$difference->m.'-'.$difference->d;
    echo $data;
}else{
    echo (0);
}
}

public function actionSaveImgProfile()
{
  if (isset($_POST['image']) && $_POST['image'] != "" && !empty($_POST['user'])) {

    // $img = str_replace('data:image/png;base64,', '', $_POST['image']);
    // $img = str_replace(' ', '+', $img);
    // $data = base64_decode($img);

    $img = trim($_POST['image']);
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace('data:image/jpg;base64,', '', $img);
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace('data:image/gif;base64,', '', $img);
    $img = str_replace(' ', '+', $img);

    $imageData = base64_decode($img);

    $users = Users::model()->findByPk($_POST['user']);
    $uploadDir = Yii::app()->getUploadPath(null);
    $path1 = "user";
    $path2 = $users->id;
    $path3 = "thumb";
    if (!is_dir($uploadDir . "../" . $path1 . "/")) {
      mkdir($uploadDir . "../" . $path1 . "/", 0777, true);
    }
    if (!is_dir($uploadDir . "../" . $path1 . "/" . $path2 . "/")) {
      mkdir($uploadDir . "../" . $path1 . "/" . $path2 . "/", 0777, true);
    }
    if (!is_dir($uploadDir . "../" . $path1 . "/" . $path2 . "/" . $path3 . "/")) {
      mkdir($uploadDir . "../" . $path1 . "/" . $path2 . "/" . $path3 . "/", 0777, true);
    } else { // ลบ file เก่า
      $files = glob($uploadDir . "../" . $path1 . "/" . $path2 . "/" . $path3 . '/*');
      foreach ($files as $file) { // iterate files
        if (is_file($file)) {
          unlink($file); // delete file
        }
      }
    }

    $users->pic_user = date("YmdHis") . "_.jpg";
    $uploadDir = $uploadDir . "..\\" . $path1 . "\\" . $path2 . "\\" . $path3 . "\\";
    $targetFile = $uploadDir . $users->pic_user;
    file_put_contents($targetFile, $imageData);
    if($users->save(false)){
        echo 'success';
    }else{
        echo 'try again';
    }
  }else{
    echo 'try again';
  }
}

}
