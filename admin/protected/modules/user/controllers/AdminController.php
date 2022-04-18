<?php 
class AdminController extends Controller
{
     // public function filters()
  //   {
  //       return array(
  //           'accessControl', // perform access control for CRUD operations
  //       );
  //   }

  //   /**
  //    * Specifies the access control rules.
  //    * This method is used by the 'accessControl' filter.
  //    * @return array access control rules
  //    */


    public function init()
    {

        if(Yii::app()->user->id == null){
            $this->redirect(array('site/index'));
        }
        
    }
    public $defaultAction = 'admin';
    public $layout='//layouts/column2';

    private $_model;



    
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

    public function actionCheck_email(){
        $email = $_POST['email'];
        $User = User::model()->findAll(array('condition'=>'email = "'.$email.'"'));
        if(!empty($User)){
            echo 1;
        }else{
            echo 2;
        }
    }

    public function actionCheck_empid(){
        $emp_id = $_POST['emp_id'];
        $User = User::model()->findAll(array('condition'=>'username = "'.$emp_id.'"'));
        if(!empty($User)){
            echo 1;
        }else{
            echo 2;
        }
    }

    public function actionListPosition(){

        $model=Position::model()->findAll('department_id=:department_id',
            array(':department_id'=>$_POST['id']));

        $data=CHtml::listData($model,'id','position_title',array('empty' => 'ตำแหน่ง'));
        if ($data) {     
            $sub_list = 'เลือกตำแหน่ง';
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

        $model=Branch::model()->findAll('position_id=:position_id',
            array(':position_id'=>$_POST['id']));

        $data=CHtml::listData($model,'id','branch_name',array('empty' => 'สาขา'));
        if ($data) {  
            $sub_list = 'เลือกระดับ';
            $data = '<option value ="">'.$sub_list.'</option>';
            foreach ($model as $key => $value) {
                $data .= '<option value = "'.$value->id.'"'.'>'.$value->branch_name.'</option>';
            }
            echo ($data);
        }else{
            echo '<option value = "">ไม่พบข้อมูล</option>';

        }

    }

    public function actionListDepartment(){

        $model=Department::model()->findAll('type_employee_id=:type_employee_id',
            array(':type_employee_id'=>$_POST['id']));

        $data=CHtml::listData($model,'id','dep_title',array('empty' => 'แผนก'));
        $sub_list = 'เลือกแผนก';
        $data = '<option value ="">'.$sub_list.'</option>';
        foreach ($model as $key => $value) {
            $data .= '<option value = "'.$value->id.'"'.'>'.$value->dep_title.'</option>';
        }
        echo ($data);

    }

    public function actionApprove()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        $model->register_status = array(0);
        $model->status = array(1);
        $model->supper_user_status = false;

        if(isset($_GET['User'])){
            $model->attributes=$_GET['User'];
        }

        $this->render('approve',array(
            'model'=>$model,
        ));
    }


    public function loadDepartment($department_id){
        $data=OrgChart::model()->findAll('id=:id',
            array(':id'=>$department_id)
        );

        $data=CHtml::listData($data,'id','title');

        return $data;
    }

    public function actionAccess ()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        $model->register_status = array(1);
        $model->repass_status = array(1);
        $model->status = array(1);

        if(isset($_GET['User'])){
            $model->attributes=$_GET['User'];
        }
        $this->render('access',array(
            'model'=>$model,
        ));
    }

    public function actionAccessPersonal ()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        $model->register_status = array(1);
        $model->repass_status = array(1);
        $model->status = array(1);

        if(isset($_GET['User'])){
            $model->attributes=$_GET['User'];
        }
        $this->render('accessPersonal',array(
            'model'=>$model,
        ));
    }

    public function actionEditTable(){
        $model = TypeUser::model()->findAll(array('condition'=>'active = 1'));
        foreach ($model as $key => $value) {
            if($value->id == 1){
                $value->name = 'ผู้ใช้งานทั่วไป(ลงทะเบียนหน้าบ้าน)';
            }else if($value->id == 2){
                $value->name = 'ผู้ใช้งานทั่วไป(ลงทะเบียนหลังบ้าน)';
            }else if($value->id == 3){
                $value->name = 'บุคลากรภายใน';
            }else{
                $value->active = 0;
            }
            $value->save();
        }

    }

    public function actionStatus()
    {
        $model=new ReportUser();
        $model->unsetAttributes();
        if(isset($_GET['ReportUser'])){

            $model->attributes=$_GET['ReportUser'];
        }

        $this->render('status',array('model'=>$model));
    }

    public function actionExport_excel(){
        $this->layout = FALSE;
        $model=new ReportUser();
        $model->unsetAttributes();
        if(isset($_GET['ReportUser'])){
            $model->attributes=$_GET['ReportUser'];
        }

        $contentView = $this->renderPartial('excel_export', array(
            'model'=>$model
        ));

        echo '<meta charset="UTF-8">';
        echo $contentView;
        exit();
    }

    public function actionEmployee()
    {
        $model=new User('search');
        $model->unsetAttributes();  // clear any default values
        $model->typeuser = array(3);
        $model->type_employee = array(2);
        $model->status = array(1);
        $model->register_status = array(1);
        $model->supper_user_status = true;
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];
        $this->render('index',array(
            'model'=>$model,
        ));
    }


    public function actionGeneral()
    {
        $model=new User('search');
        $model->unsetAttributes();  // clear any default values
        $model->typeuser = array(5);
        $model->status = array(1);
        $model->register_status = array(1);
        $model->supper_user_status = true;
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];
        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function actionActive(){
        $id = $_POST['id'];
        $model = User::model()->findByPk($id);
        $profile = Profile::model()->findByPk($id);

        if($model->status == 1 && $model->register_status == 0){
            $model->status = 1;
            $model->register_status = 1;
            $profile->type_user = 1;
            $profile->type_employee = 1;
            $profile->save(false);
        } else {
            $model->status = 0;
        }
        $model->username = $profile->passport;
        $model->save(false);
        if(Yii::app()->user->id){
            Helpers::lib()->getLogapprove($model);
        }

        $to['email'] = $model->email;
        $to['firstname'] = $model->profile->firstname;
        $to['lastname'] = $model->profile->lastname;
        $message = $this->renderPartial('_mail_membership',array('model' => $model),true);
        if($message){
            $send = Helpers::lib()->SendMail($to,'อนุมัติการเข้าใช้งานระบบ',$message);

        }
        $this->redirect(array('/user/admin/approve'));
    }

    public function actionConfirm()
    {

        $id = $_POST['id'];
        $model = User::model()->findByPk($id);
        $Profile = Profile::model()->findByPk($id);
        if($model->register_status == 0 && $model->status == 0){

            $model->status = 1;
        } else {
            $model->register_status = 0;
        }
        $genpass = $this->RandomPassword();
        $model->verifyPassword = $genpass;
        $model->password = UserModule::encrypting($genpass);
        $model->username = $Profile->passport;
        $model->save(false);
        if(Yii::app()->user->id){
            Helpers::lib()->getLogregister($model);
        }
        $to['email'] = $model->email;
        $to['firstname'] = $model->profile->firstname;
        $to['lastname'] = $model->profile->lastname;
        $message = $this->renderPartial('_mail_message',array('model' => $model,'genpass' => $genpass),true);
        if($message){
            $send = Helpers::lib()->SendMail($to,'อนุมัติการสมัครสมาชิก',$message);
        }
        $this->redirect(array('/user/admin/Membership'));
    }

    public function actionConfirm_personal()
    {

        $id = $_POST['id'];
        $model = User::model()->findByPk($id);
        if($model->register_status == 0 && $model->status == 0){
            $model->register_status = 1;
            $model->status = 1;
        } else {
            $model->register_status = 0;
        }
        $genpass = $this->RandomPassword();
        $model->verifyPassword = $genpass;
        $model->password = UserModule::encrypting($genpass);
        $model->username = $model->email;
        $model->save(false);
        if(Yii::app()->user->id){
            Helpers::lib()->getLogapprovePersonal($model);
        }
        $to['email'] = $model->email;
        $to['firstname'] = $model->profile->firstname;
        $to['lastname'] = $model->profile->lastname;
        $message = $this->renderPartial('_mail_message',array('model' => $model,'genpass' => $genpass),true);
        if($message){
            $send = Helpers::lib()->SendMail($to,'อนุมัติการสมัครสมาชิก',$message);
        }
        $this->redirect(array('/user/admin/Membership_personal'));
    }

    public function actionNotapproved()
    {

        $id = $_POST['id'];
        $passage = $_POST['passInput'];
        $model = User::model()->findByPk($id);
        if($model->register_status == 0 && $model->status == 1){
            $model->register_status = 2;
        } else {
            $model->register_status = 1;
        }
        $model->note = $passage;
        $model->save(false);
        $to['email'] = $model->email;
        $to['firstname'] = $model->profile->firstname;
        $to['lastname'] = $model->profile->lastname;

        $message = $this->renderPartial('_mail_Notapproved',array('model' => $model,'passage' => $passage),true);
        if($message){
            $send = Helpers::lib()->SendMail($to,'ไม่อนุมัติการสมัครสมาชิก',$message);
        }
        $this->redirect(array('/user/admin/Membership'));
    }

    public function actionNotapproved_personal()
    {

        $id = $_POST['id'];
        $passage = $_POST['passInput'];
        $model = User::model()->findByPk($id);
        if($model->register_status == 0 && $model->status == 1){
            $model->register_status = 2;
        } else {
            $model->register_status = 1;
        }
        $model->note = $passage;
        $model->save(false);
        $to['email'] = $model->email;
        $to['firstname'] = $model->profile->firstname;
        $to['lastname'] = $model->profile->lastname;

        $message = $this->renderPartial('_mail_Notapproved',array('model' => $model,'passage' => $passage),true);
        if($message){
            $send = Helpers::lib()->SendMail($to,'ไม่อนุมัติการสมัครสมาชิก',$message);
        }
        $this->redirect(array('/user/admin/Membership_personal'));
    }
    
    public function actionNotPassed()
    {

        $id = $_POST['id'];
        $passage = $_POST['passInput'];
        $model = User::model()->findByPk($id);
        if($model->status == 1 && $model->register_status == 0){
            $model->status = 1;
            $model->register_status = 0;
        } else {
            $model->status = 1;
        }
        $model->username = '';
        $model->not_passed = $passage;
        $model->save(false);
        $to['email'] = $model->email;
        $to['firstname'] = $model->profile->firstname;
        $to['lastname'] = $model->profile->lastname;

        $message = $this->renderPartial('_mail_NotPassed',array('model' => $model,'passage' => $passage),true);
        if($message){
            $send = Helpers::lib()->SendMail($to,'ไม่อนุมัติการเข้าใช้งานระบบ',$message);
        }
        $this->redirect(array('/user/admin/Membership'));
    }
    
    public function actionChangeposition()
    {

        $value  = $_POST['val'];
        $id = $_POST['id'];
        $model = User::model()->findByPk($id);
        if ($value != '') {
            $model->position_id = $value;
        }
        $model->save(false);

        $this->redirect(array('/user/admin/Membership'));
    }

    public function actionOpen_employee()
    {
        $id = $_POST['id'];
        $model = User::model()->findByPk($id);
        if ($model != '') {
            $model->del_status = 0;
        }
        $model->save(false);

        $this->redirect(array('/user/admin/access'));
    }

    public function actionDelete_employee()
    {
        $id = $_POST['id'];
        $model = User::model()->findByPk($id);
        if ($model != '') {
            $model->del_status = 1;
        }
        $model->save(false);

        $this->redirect(array('/user/admin/Membership_personal'));
    }

    public function actionChangePasswordUser()
    {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $verifyPassword = $_POST['verifyPassword'];
        $model = Users::model()->findbyattributes(array('id'=>$id));

        $model->password = $password;
        $model->verifyPassword = $verifyPassword;
        // if ($model->validate()) {
            $model->password = UserModule::encrypting($model->password);
            $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
            var_dump($model->save(false));

            $to['email'] = $model->email;
            $to['firstname'] = $model->profiles->firstname;
            $to['lastname'] = $model->profiles->lastname;

            $message = $this->renderPartial('_mail_ChangePassword',array('model' => $model, 'password' => $password),true);
            if($message){
                $send = Helpers::lib()->SendMail($to,'แจ้งเปลี่ยน Password',$message);
            }
        // }

        //$this->redirect(array('/user/admin/index'));
    }


    public function actionCheckinformation()
    {
        $id = $_POST['id'];
        $user = User::model()->findByPk($id);
        $profile = Profile::model()->findByPk($id);


        $this->renderPartial('Checkinformation',array('user' => $user,'profile' => $profile));
    }

    public function actionCheckinformation_personal()
    {
        $id = $_POST['id'];
        $user = User::model()->findByPk($id);
        $profile = Profile::model()->findByPk($id);


        $this->renderPartial('Checkinformation_personal',array('user' => $user,'profile' => $profile));
    }

    public function actionChangePassword()
    {
        $id = $_POST['id'];
        $user = User::model()->findByPk($id);

        $this->renderPartial('ChangePassword',array('user' => $user));
    }

    public function actionAttach_load()
    {

        $user_id = $_GET["id"];
        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id ="'.$user_id.'"');
        $criteria->addCondition("active ='y'");     
        $Attach_file = AttachFile::model()->findAll($criteria);

        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id ="'.$user_id.'"');
        $criteria->addCondition("active ='y'");     
        $Edu_file = FileEdu::model()->findAll($criteria);

        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id ="'.$user_id.'"');
        $criteria->addCondition("active ='y'");     
        $Training_file = FileTraining::model()->findAll($criteria);

        if ($user_id != '') {
            $profiles = Profile::model()->find(array(
                'condition' => 'user_id=:user_id ',
                'params' => array('user_id' => $user_id)
            ));
            $user = User::model()->find(array(
                'condition' => 'id=:id',
                'params' => array('id' => $user_id)
            ));
            $path_img = Yii::app()->baseUrl. '/images/head_print.png';

            $padding_left = 12.7;
            $padding_right = 12.7;
            $padding_top = 10;
            $padding_bottom = 20;

            Yii::import('application.extensions.*');
            require_once('THSplitLib/segment.php');
            $mPDF = Yii::app()->ePdf->mpdf('th', 'A4', '0', 'garuda', $padding_left, $padding_right, $padding_top, $padding_bottom);
            $mPDF->useDictionaryLBR = false;
            $mPDF->setDisplayMode('fullpage');
            $mPDF->autoLangToFont = true;
            $mPDF->autoPageBreak = true;
            $mPDF->SetTitle("ใบสมัครสมาชิก");
            $texttt= '
            <style>
            body { font-family: "garuda"; }
            </style>
            ';
            $mPDF->WriteHTML($texttt);
            $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('printpdf', array('profiles'=>$profiles,'user'=>$user), true), 'UTF-8', 'UTF-8'));

            $uploadDir = Yii::app()->getUploadPath(null);
            $path1 = "pdf_regis";
            $path2 = $user_id;  

            if (!is_dir($uploadDir."../".$path1."/")) {
                mkdir($uploadDir."../".$path1."/", 0777, true);
            }

            if (!is_dir($uploadDir."../".$path1."/".$path2."/")) {
                mkdir($uploadDir."../".$path1."/".$path2."/", 0777, true);
            }else{ // ลบ file เก่า
                $files = glob($uploadDir."../".$path1."/".$path2.'/*');
            foreach($files as $file){ // iterate files
                if(is_file($file)){
                        unlink($file); // delete file
                    }             
                }
            }

            $mPDF->Output($uploadDir.'../pdf_regis\\'.$user_id.'\เอกสารสมัครสมาชิก.pdf', 'F');
        //$mPDF->Output($uploadDir.'../pdf_regis/ใบสมัครสมาชิก.pdf', 'F');

        }
        $name_register_file = "เอกสารสมัครสมาชิก.pdf";
        $path_zip_attach = array();
        $name_file_attach = array();
        $nameold_file_attach = array();

        $path_zip_edu = array();
        $name_file_edu = array();
        $nameold_file_edu = array();

        $path_zip_training = array();
        $name_file_training = array();
        $nameold_file_training = array();

        $path_zip_register = array();
        $nameold_file_register = array();

        foreach ($Attach_file as $key => $value) {
            $attach_all  = glob(Yii::app()->getUploadPath('attach').$value->file_name);
            if(!empty($attach_all)){
                $path_zip_attach[] = "../uploads/attach/".basename($attach_all[0]); 
                $name_file_attach[] = basename($attach_all[0]);
                $nameold_file_attach[] = $value->filename;      
            }   
        }
        foreach ($Edu_file as $keyedu => $valueedu) {
            $edu_all  = glob(Yii::app()->getUploadPath('edufile').$valueedu->filename);
            if(!empty($edu_all)){
                $path_zip_edu[] = "../uploads/edufile/".basename($edu_all[0]);  
                $name_file_edu[] = basename($edu_all[0]);
                $nameold_file_edu[] = $valueedu->file_name;     
            }   
        }
        foreach ($Training_file as $keytn => $valuetn) {
            $Training_all  = glob(Yii::app()->getUploadPath(null)."..\\Trainingfile\\".$user_id."\\*");
            if(!empty($Training_all)){
                $path_zip_training[] = "../uploads/Trainingfile/".$user_id."/".basename($Training_all[0]);  
                $name_file_training[] = basename($Training_all[0]); 
                $nameold_file_training[] = $valuetn->filename;  
            }
        }
        $Register_all  = glob(Yii::app()->getUploadPath(null)."..\\pdf_regis\\".$user_id."\\*");
        if(!empty($Register_all)){
            $path_zip_register[] = "../uploads/pdf_regis/".$user_id."/".basename($Register_all[0]); 
            $nameold_file_register[] = basename($Register_all[0]);  
        }



        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id ="'.$user_id.'"');
        $Profile = Profile::model()->find($criteria);

        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id ="'.$user_id.'"');
        $user = User::model()->find($criteria);

        $criteria = new CDbCriteria;
        $criteria->addCondition('id ="'.$user->position_id.'"');
        $position = Position::model()->find($criteria);

        $firstname = $Profile->firstname;
        $positionName = $position->position_title;

        if(!empty($path_zip_attach) || !empty($path_zip_training) || !empty($path_zip_edu) || !empty($path_zip_register)){
            $zip = Yii::app()->zip;
            $path_in_zip = "..\uploads\attachZib\\";
            $name_zip = "$firstname"."-"."$positionName.zip";

            $name_attach = "เอกสารไฟล์แนบ.zip";
            $name_edu = "เอกสารไฟล์แนบการศึกษา.zip";
            $name_training = "เอกสารไฟล์แนบการฝึกอบรม.zip";
            $name_register = "เอกสารสมัครสมาชิก.zip";

            $file_in_folders = glob(Yii::app()->getUploadPath(null)."..\\attachZib\\*");        
            if(!empty($file_in_folders)){
                foreach($file_in_folders as $file){ // iterate files
                    if(is_file($file)){
                        unlink($file); // delete file
                    }             
                }                                       
            }


            foreach ($path_zip_attach as $key => $link_file) {

                $zip->makeZip_nn($link_file, $path_in_zip.$name_attach, $nameold_file_attach[$key]);
            }
            foreach ($path_zip_training as $keyt => $valuet) {
                $zip->makeZip_nn($valuet, $path_in_zip.$name_training, $nameold_file_training[$keyt]);
            }
            foreach ($path_zip_edu as $keye => $valuee) {
                $zip->makeZip_nn($valuee, $path_in_zip.$name_edu, $nameold_file_edu[$keye]);
            }   
            foreach ($path_zip_register as $keyrg => $valuerg) {
                $zip->makeZip_nn($valuerg, $path_in_zip.$name_register, $nameold_file_register[$keyrg]);
            }

            $path_zip =array();
            $name_file = array();

            $file_in = glob(Yii::app()->getUploadPath(null)."..\\attachZib\\*");

            if(isset($file_in)){
                $path_zip[] = "../uploads/attachZib/".basename($file_in[0]);
                $path_zip[] = "../uploads/attachZib/".basename($file_in[1]);
                $path_zip[] = "../uploads/attachZib/".basename($file_in[2]);
                $path_zip[] = "../uploads/attachZib/".basename($file_in[3]);    
                $name_file[] = basename($file_in[0]);
                $name_file[] = basename($file_in[1]);
                $name_file[] = basename($file_in[2]);
                $name_file[] = basename($file_in[3]);

            }          

            foreach ($path_zip as $keys => $val) {

                $zip->makeZip_nn($val, $path_in_zip.$name_zip, $name_file[$keys]);
            }
            $file_in_folder = glob(Yii::app()->getUploadPath(null)."..\\attachZib\\*");

            foreach($file_in_folder as $file_in){ // วนลบไฟล์ในโฟลเดอร์

                if(is_file($file_in)){
                    $file = basename($file_in);     
                    if($file == $name_zip){
                        $zip_susess = "..\uploads\attachZib\\$name_zip";

                        if(file_exists($zip_susess)) {  

                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            Header ("Content-disposition: attachment; filename=".basename($zip_susess).".zip");
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                            header('Pragma: public');
                            ob_clean();
                            flush();             
                // header('Content-Description: File Transfer');
                // header('Content-Type: application/octet-stream');
                // header('Content-Disposition: attachment; filename="'.basename($zip_susess).'"');
                // header('Expires: 0');
                // header('Cache-Control: must-revalidate');
                // header('Pragma: public');
                // header('Content-Length: ' . filesize($zip_susess));
                // flush(); // Flush system output buffer
                            readfile($zip_susess);
                            die();
                        } else {
                            http_response_code(404);
                            die();
                        }
                    }
                }
            }

        }
        
    }

    public function actionIdCard($id)
    {
        // var_dump($id);exit();
        $model= User::model()->findbyPk($id);
        $regis = new RegistrationForm;
        $regis->id = $model->id;
        $profile= $model->profile;

        if(isset($_POST['User']))
        {
            $uploadFile = CUploadedFile::getInstance($model,'pic_user');
            if(isset($uploadFile))
            {
                $uglyName = strtolower($uploadFile->name);
                $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
                $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
                $model->pic_cardid = $beautifulName;
                $model->save(false);
                Yii::app()->user->setFlash('registration','แก้ไขสำเร็จ');
                if(isset($uploadFile))
                {
                    /////////// SAVE IMAGE //////////
                    Yush::init($regis);
                    $originalPath = Yush::getPath($regis, Yush::SIZE_ORIGINAL, $model->pic_cardid);
                    $thumbPath = Yush::getPath($regis, Yush::SIZE_THUMB, $model->pic_cardid);
                    $smallPath = Yush::getPath($regis, Yush::SIZE_SMALL, $model->pic_cardid);
                    // Save the original resource to disk
                    $uploadFile->saveAs($originalPath);

                    // Create a small image
                    $smallImage = Yii::app()->phpThumb->create($originalPath);
                    $smallImage->resize(385, 220);
                    $smallImage->save($smallPath);

                    // Create a thumbnail
                    $thumbImage = Yii::app()->phpThumb->create($originalPath);
                    $thumbImage->resize(350, 200);
                    $thumbImage->save($thumbPath);

                }
            }
            // var_dump($model->pic_cardid);exit();
        }
        $this->render('id_card',array(
            'model'=>$model,
            'profile'=>$profile
        ));
        
    }



    public function actionExcelOld()
    {
        $HisImportArr = array();
        $HisImportErrorArr = array();
        $HisImportAttrErrorArr = array();
        $HisImportErrorMessageArr = array();
        $HisImportUserPassArr = array();
        //Student
        if (isset($_FILES['excel_import_student'])) {
            $extensionFile = pathinfo($_FILES['excel_import_student']['name'], PATHINFO_EXTENSION);
            $fullPath = Yii::app()->basePath.'/../../uploads/temp_excel.'.$extensionFile;
            if (!move_uploaded_file($_FILES["excel_import_student"]["tmp_name"],$fullPath)) {
                echo "Move File Error!!!";
                exit;
            }
            $file_path = $fullPath;
            $sheet_array = Yii::app()->yexcel->readActiveSheet($file_path);
            $HisImportArr = $sheet_array;
            
            foreach ($sheet_array as $key => $valueRow) {
                if ($key == 1) { // Header first row
                }else { // Data Row ALL 2 -

                    $modelUser = new User;
                    $modelUser->email = $valueRow['A'];
                    $modelUser->username = $valueRow['A'];
                    $modelUser->password = md5($valueRow['B']); // Random password
                    $modelUser->verifyPassword = $modelUser->password;
                    $modelUser->type_register = 2;
                    $modelUser->superuser = 0;

                    $member = Helpers::lib()->ldapTms($modelUser->email);
                    if($member['count'] > 0){ //TMS
                        $modelUser->type_register = 3;
                        Helpers::lib()->_insertLdap($member);
                        $modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
                        $modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
                        $modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

                        $modelUser->division_id = $modelDivision->id;
                        $modelUser->station_id = $modelStation->station_id;
                        $modelUser->department_id = $modelDepartment->id;
                        $modelUser->password = md5($model->email);
                        $modelUser->verifyPassword = $model->password;
                        $modelUser->status = 1; //bypass not confirm
                    }else{ //LMS
                        $modelUser->password = md5($valueRow['B']); // Random password
                        $modelUser->verifyPassword = $modelUser->password;
                        // $modelUser->department_id = 2;
                        $modelUser->department_id = 1;
                        $modelUser->status = 0;
                    }
                    
                    if ($modelUser->validate()) {
                        // insert right
                        $modelUser->save();
                        $modelProfile = new Profile;
                        $modelProfile->user_id = $modelUser->id;
                        $modelProfile->title_id = $valueRow['C'];
                        $modelProfile->firstname = $valueRow['D'];
                        $modelProfile->lastname = $valueRow['E'];
                        
                        $modelProfile->phone = $valueRow['F'];
                        
                        if($modelProfile->validate()){
                            $modelProfile->save();
                            $Insert_success[$key] = "สร้างชื่อผู้ใช้เรียบร้อย";
                        } else {
                            $HisImportErrorArr[] = $HisImportArr[$key];
                            $msgAllArr = array();
                            $attrAllArr = array();
                            foreach($modelProfile->getErrors() as $field => $msgArr){
                                $attrAllArr[] = $field;
                                $msgAllArr[] = $msgArr[0];
                            }

                            $HisImportErrorMessageArr[$key] = implode(", ",$msgAllArr);
                            $HisImportAttrErrorArr[] = $attrAllArr;
                            $HisImportArr = $sheet_array;
                            $deldata = User::model()->findbyPk($modelUser->id);
                            $deldata->delete();
                            $Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
                        }




                        
                    } else {



                        $HisImportErrorArr[] = $HisImportArr[$key];

                        $msgAllArr = array();
                        $attrAllArr = array();
                        foreach($modelUser->getErrors() as $field => $msgArr){
                            $attrAllArr[] = $field;
                            $msgAllArr[] = $msgArr[0];
                        }

                        $HisImportErrorMessageArr[$key] = implode(", ",$msgAllArr);
                        $HisImportAttrErrorArr[] = $attrAllArr;

//                      unset($HisImportArr[$key]);
                        $HisImportArr = $sheet_array;
                        $Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
                    }
//              }
                }
            }
            unlink($fullPath);
        }

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $this->render('excel',array('HisImportArr'=>$HisImportArr,'HisImportUserPassArr'=>$HisImportUserPassArr,'HisImportErrorArr'=>$HisImportErrorArr,'HisImportAttrErrorArr'=>$HisImportAttrErrorArr,'HisImportErrorMessageArr'=>$HisImportErrorMessageArr,'Insert_success'=>$Insert_success));
    }

    public function actionExcel()
    {
        $model=new User('import');
        $HisImportArr = array();
        $HisImportErrorArr = array();
        $HisImportAttrErrorArr = array();
        $HisImportErrorMessageArr = array();
        $HisImportUserPassArr = array();
        $data = array();
        // if(isset($_FILES['excel_import_student']))
        $model->excel_file = CUploadedFile::getInstance($model,'excel_file');

        if(!empty($model->excel_file))
        {      
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
            $model->excel_file = CUploadedFile::getInstance($model,'excel_file');

            //if ($model->excel_file && $model->validate()) {
                // $webroot = YiiBase::getPathOfAlias('webroot');
            $webroot = Yii::app()->basePath."/../..";
                // $filename = $webroot.'/uploads/' . $model->excel_file->name . '.' . $model->excel_file->extensionName;
            $filename = $webroot.'/uploads/' . $model->excel_file->name;
            $model->excel_file->saveAs($filename);

            $sheet_array = Yii::app()->yexcel->readActiveSheet($filename);
            $inputFileName = $filename;
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
            $headingsArray = $headingsArray[1];

            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    }//end foreach
                }//end if
            }//end for

            $index = 0;
            // var_dump($namedDataArray);exit();
            foreach($namedDataArray as $key => $result){
                $search_user = User::model()->find(array('condition'=>"username = '".$result["Employee ID."]."'"));
                if(empty($search_user)){
                    $model = new User;
                    $profile = new Profile;
                    $model->email = $result["Email"];
                    $model->username = $result["Employee ID."];
                    $model->employee_id = $result["Employee ID."];
                // $model->password = md5($model->username);
                // $model->verifyPassword = md5($result["Employee ID."]);
                    if($result["Status"]!="Active"){
                        $model->del_status = 1;
                    }

                    $model->type_register = 2;
                    $model->superuser = 0;
                    $model->repass_status = 0;

                    $model->create_at = date('Y-m-d H:i:s');
                    $model->status = 1;
                    $model->org_id  =$result["Org. Chat ID"];
                    $model->created_by = Yii::app()->user->id;

                // $genpass = $this->RandomPassword();
                    $genpass = md5($result["Employee ID."]);
                    $model->verifyPassword = $genpass;
                    $model->password = $genpass;
                    $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);

                    if ($model->validate()) {
                     $model->save(false);
                        //$data[$key]['msg'] = 'pass';

                     $modelProfile = new Profile;
                     $modelProfile->user_id = $model->id;
                     $modelProfile->firstname = $result["Firstname (TH)"];
                     $modelProfile->lastname = $result["Lastname (TH)"];
                     $modelProfile->firstname_en = $result["Firstname (Eng)"];
                     $modelProfile->lastname_en = $result["Lastname (Eng)"];
                     $modelProfile->sex = $result["Gender"];
                   // $modelProfile->tel = $result["tel"];
                     $modelProfile->kind = $result["KIND"];
                     $modelProfile->organization_unit = $result["Organization unit"];
                     $modelProfile->abbreviate_code = $result["Abbreviate code"];
                     $modelProfile->location = $result["Location"];
                     $modelProfile->group_name = $result["Group"];
                     $modelProfile->shift = $result["Shift"];
                     $EmpClass = EmpClass::model()->findByAttributes(array('title'=>$result["Employee class"]));

                        if(!empty($EmpClass)){
                            $modelProfile->employee_class = $EmpClass->id ;
                            $modelProfile->position_description = $EmpClass->descrpition;
                        }
                    

                                if($modelProfile->validate()){
                                  $modelProfile->save(false);
                                  $data[$key]['msg'] = 'สร้างชื่อผู้ใช้เรียบร้อย';
                                  $data[$key]['username'] = $result["Employee ID."];
                                  $data[$key]['fullname'] = $result["Firstname (Eng)"]." ".$result["Lastname (Eng)"];
                                  $data[$key]['email'] = $result["Email"];
                                  $Insert_success[$key] = "สร้างชื่อผู้ใช้เรียบร้อย";


                                  $message = '
                                  <strong>สวัสดี คุณ' . $modelProfile->firstname . ' ' . $modelProfile->lastname . '</strong><br /><br />

                                  <h4>ระบบได้ทำการอนุมัติสมาชิกเข้าใช้งาน e-Learning Isuzu เรียบร้อยแล้ว โดยมี ชื่อผู้ใช้งานและรหัสผ่านดังนี้ </h4>
                                  <h4>- User : '. $model->username.'</h4>
                                  <h4>- Password : '.$genpass.'</h4>

                                  โปรดคลิกลิงค์ต่อไปนี้ เพื่อดำเนินการเข้าสู่ระบบ<br />
                                  <a href="' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '">' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '</a><br />
                                  <strong>Email</strong> : ' . $model->email . '<br />

                                  ยินดีต้อนรับเข้าสู่ระบบ e-Learning Isuzu<br /><br />

                                  ';
                                  $subject = 'ยินดีต้อนรับเข้าสู่ระบบ e-Learning Isuzu';
                                  $to['email'] = $model->email;
                                  $to['firstname'] = $modelProfile->firstname;
                                  $to['lastname'] = $modelProfile->lastname;
                                    // try {
                                    //     $mail = Helpers::lib()->SendMail($to,$subject,$message);
                                    //     return "pass";
                                    // }catch (Exception $e) {
                                    //     return "fail";
                                    // }
                                }else{

                                  $HisImportErrorArr[] = $HisImportArr[$key];
                                  $msgAllArr = array();

                                  $attrAllArr = array();
                                    foreach($modelProfile->getErrors() as $field => $msgArr){
                                       $attrAllArr[] = $field;
                                       $msgAllArr[] = $msgArr[0];
                                    }//end foreach

                                   $HisImportErrorMessageArr[$key] = implode(", ",$msgAllArr);
                                   $data[$key]['msg'] = implode(", ",$msgAllArr);
                                   $HisImportAttrErrorArr[] = $attrAllArr;
                                   $HisImportArr = $sheet_array;
                                   $deldata = User::model()->findbyPk($model->id);
                                   $deldata->delete();
                                   $Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
                                }//end if Profile validate
            }else{
             $msgAllArr = array();
             $attrAllArr = array();
                foreach($model->getErrors() as $field => $msgArr){
                        $attrAllArr[] = $field;
                        $msgAllArr[] = $msgArr[0];
                }// end foreach
            $data[$key]['msg'] = implode(", ",$msgAllArr);
                        // var_dump($model->getErrors());
                        // exit();
            }//end if validate user
    
    }else{//ถ้ามี username ตรงกันให้ update
        
        if($result["Status"]!="Active"){
            $search_user->del_status = 1;
        }else{
            $search_user->del_status = 0;
        }
        $search_user->email = $result["Email"];
        
        // var_dump($search_user->id);exit();
       
        if ($search_user->validate()) {


                    $search_user->save(false);

                    $UpdateProfile = Profile::model()->find(array('condition'=>"user_id = '".$search_user->id."'"));
                    $UpdateProfile->firstname = $result["Firstname (TH)"];
                    $UpdateProfile->lastname = $result["Lastname (TH)"]; 
                    $UpdateProfile->firstname_en = $result["Firstname (Eng)"];
                    $UpdateProfile->lastname_en = $result["Lastname (Eng)"];
                    $UpdateProfile->kind = $result["KIND"];
                    $UpdateProfile->organization_unit = $result["Organization unit"];
                    $UpdateProfile->abbreviate_code = $result["Abbreviate code"];
                    $UpdateProfile->location = $result["Location"];
                    $UpdateProfile->group_name = $result["Group"];
                    $UpdateProfile->shift = $result["Shift"];
                    $EmpClass = EmpClass::model()->findByAttributes(array('title'=>$result["Employee class"]));
                 
                        if(!empty($EmpClass)){
                            $UpdateProfile->employee_class = $EmpClass->id;
                            $UpdateProfile->position_description = $EmpClass->descrpition;
                        }

                    
                    $UpdateProfile->sex = $result["Gender"];
                    
                    if($UpdateProfile->validate()){
                                  $UpdateProfile->save(false);
                                  $data[$key]['msg'] = 'แก้ไขชื่อผู้ใช้เรียบร้อย';
                                  $data[$key]['username'] = $result["Employee ID."];
                                  $data[$key]['fullname'] = $result["Firstname (Eng)"]." ".$result["Lastname (Eng)"];
                                  $data[$key]['email'] = $result["Email"];
                                  $Insert_success[$key] = "แก้ไขชื่อผู้ใช้เรียบร้อย";
                    }//end if
        }//end if

    }//end if เช็ค username

            } //end loop add user

                //if($model->save())
                // $this->redirect(array('import','id'=>$id));
                $this->render('excel',array('model'=>$model,'HisImportArr'=>$HisImportArr,'HisImportUserPassArr'=>$HisImportUserPassArr,'HisImportErrorArr'=>$HisImportErrorArr,'HisImportAttrErrorArr'=>$HisImportAttrErrorArr,'HisImportErrorMessageArr'=>$HisImportErrorMessageArr,'Insert_success'=>$Insert_success,'data' => $data));
                exit();
            
            }

        // $this->render('excel',array('model'=>$model));
            $this->render('excel',array('model'=>$model,'HisImportArr'=>$HisImportArr,'HisImportUserPassArr'=>$HisImportUserPassArr,'HisImportErrorArr'=>$HisImportErrorArr,'HisImportAttrErrorArr'=>$HisImportAttrErrorArr,'HisImportErrorMessageArr'=>$HisImportErrorMessageArr,'Insert_success'=>$Insert_success));
      
    
    }//end function

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $model = $this->loadModel();
        $this->render('view',array(
            'model'=>$model,
        ));
    }
    public function actionselectClass(){
        $Class = $_POST['Class'];
        // $data = Position::model()->findAll(array('condition'=>'class_id = '.$Class));

        // $output = '<option value="">-- กรุณาเลือก Position description --</option>';
        // foreach ($data as $row) {
        //     $output .= '<option value="' . $row->id . '">' . $row->position_title . '</option>';
        // }
        $empclass = EmpClass::model()->findbyPk($Class);
        echo $empclass->descrpition;
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        // $gen = Generation::model()->find('active=1');
        $model=new User;
        $profile=new Profile;
        

        if(isset($_POST['User']))
        {
            // var_dump($_POST['User']);exit();
            $model->employee_id = $_POST['User']['username'];
            $model->username = $_POST['User']['username'];
            $model->password = md5($_POST['User']['username']);
            $model->org_id = $_POST['User']['org_id'];
            $model->verifyPassword = $model->password;

            $model->email = $_POST['User']['email'];
            $model->create_at = date('Y-m-d H:i:s');
            $model->online_status = 1;



            $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
            if($model->save(false)) {
                if(isset($_POST['url_pro_pic']) && $_POST['url_pro_pic'] != ""){
                    $uploadDir = Yii::app()->getUploadPath(null);
                    $path1 = "user";
                    $path2 = $model->id;
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

                $model->pic_user = date("YmdHis")."_.jpg";
                $uploadDir = $uploadDir."..\\".$path1."\\".$path2."\\".$path3."\\";
                $targetFile = $uploadDir.$model->pic_user;
                file_put_contents($targetFile,file_get_contents($_POST['url_pro_pic']));
                $model->save(false);
            }
            if(Yii::app()->user->id){
              Helpers::lib()->getControllerActionId();
          }
          $profile->user_id=$model->id;
          $profile->firstname=$_POST['Profile']['firstname'];
          $profile->lastname=$_POST['Profile']['lastname'];
          $profile->firstname_en=$_POST['Profile']['firstname_en'];
          $profile->lastname_en=$_POST['Profile']['lastname_en'];
          $profile->employment_date=$_POST['Profile']['employment_date'];
          $profile->kind=$_POST['Profile']['kind'];
          $profile->organization_unit=$_POST['Profile']['organization_unit'];
          $profile->abbreviate_code=$_POST['Profile']['abbreviate_code'];
          $profile->location=$_POST['Profile']['location'];
          $profile->group_name=$_POST['Profile']['group_name'];
          $profile->shift=$_POST['Profile']['shift'];
          $profile->employee_class=$_POST['Profile']['employee_class'];
          $profile->position_description=$_POST['Profile']['position_description'];
          $profile->sex=$_POST['Profile']['sex'];
          $profile->save(false);
          $to['email'] = $model->email;
          $to['firstname'] = $profile->firstname;
          $to['lastname'] = $profile->lastname;
          $message = $this->renderPartial('_mail_message',array('model' => $model,'genpass'=>$_POST['User']['username']),true);
          if(($message) && ($model->email != null)){
            if(Helpers::lib()->SendMail($to,'สมัครสมาชิกสำเร็จ',$message)){
                $this->redirect(array('employee'));
            }
        }else{
            $this->redirect(array('employee'));
        }
    }
                // $this->redirect(array('view','id'=>$model->id));
    $this->redirect(array('create'));

}
$this->render('create',array(
   'model'=>$model,
   'profile'=>$profile,
));
}

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model=$this->loadModel();
        $profile=$model->profile;
        $model->verifyPassword = $model->password;
        // $this->performAjaxValidation(array($model,$profile));
        if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
        {
            echo UActiveForm::validate(array($model,$profile));
            Yii::app()->end();
        }
        if(isset($_POST['User']))
        {           
            // var_dump($_POST['User']);exit();
            // $model->attributes = $_POST['User'];
            // var_dump($model->attributes);
            // var_dump($_POST['User']);exit();
            // $model->username = $_POST['User']['username'];
            
            // $model->status = $_POST['User']['status'];
            
            // $model->email = $_POST['User']['email'];

            // $model->confirmpass = $model->password;
            // $model->department_id = $_POST['User']['department_id'];
            // $model->position_id = $_POST['User']['position_id'];
            // $model->branch_id = $_POST['User']['branch_id'];
            $model->email = $_POST['User']['email'];
            $model->username = $_POST['User']['username'];
            $model->org_id = $_POST['User']['org_id'];

            if(isset($_POST['url_pro_pic']) && $_POST['url_pro_pic'] != ""){
                $uploadDir = Yii::app()->getUploadPath(null);
                $path1 = "user";
                $path2 = $model->id;
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

                $model->pic_user = date("YmdHis")."_.jpg";
                $uploadDir = $uploadDir."..\\".$path1."\\".$path2."\\".$path3."\\";
                $targetFile = $uploadDir.$model->pic_user;
                file_put_contents($targetFile,file_get_contents($_POST['url_pro_pic']));
            }

            if($_POST['User']['newpassword'] != null ){
                $model->password=Yii::app()->controller->module->encrypting($_POST['User']['newpassword']);

                $model->confirmpass=UserModule::encrypting($_POST['User']['confirmpass']);
            }
            $model->scenario = 'general';
                // }

            $profile->attributes=$_POST['Profile'];


            // if($model->validate() &&  $profile->validate()) {
                // }

            $model->save(false);
            $profile->save(false);


            if(Yii::app()->user->id){
               Helpers::lib()->getControllerActionId($model->id);
           }
           $this->redirect(array('view','id'=>$model->id));
            // } 

       }

       $this->render('update',array(
         'model'=>$model,
         'profile'=>$profile,
     ));
   }
   public function actionPrintpdf(){

      $user_id =$_GET['id'];
      if ($user_id != '') {
         $profiles = Profile::model()->find(array(
            'condition' => 'user_id=:user_id ',
            'params' => array('user_id' => $user_id)
        ));
         $user = User::model()->find(array(
            'condition' => 'id=:id',
            'params' => array('id' => $user_id)
        ));
         $path_img = Yii::app()->baseUrl. '/images/head_print.png';

        // $padding_left = 12.7;
        // $padding_right = 12.7;
        // $padding_top = 10;
        // $padding_bottom = 20;

         require_once __DIR__ . '/../../../vendors/mpdf7/autoload.php';
         $mPDF = new \Mpdf\Mpdf();
        //$mPDF = Yii::app()->ePdf->mpdf('th', 'A4', '0', 'garuda', $padding_left, $padding_right, $padding_top, $padding_bottom);
         $mPDF->useDictionaryLBR = false;
         $mPDF->setDisplayMode('fullpage');
         $mPDF->autoLangToFont = true;
         $mPDF->autoPageBreak = true;
         $mPDF->SetTitle("ใบสมัครสมาชิก");
         $texttt= '
         <style>
         body { font-family: "garuda"; }
         </style>
         ';
         $mPDF->WriteHTML($texttt);
         $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('printpdf', array('profiles'=>$profiles,'user'=>$user), true), 'UTF-8', 'UTF-8'));
         $mPDF->Output('ใบสมัครสมาชิก.pdf', 'I');

     }
 }
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->loadModel();
            // $profile = Profile::model()->findByPk($model->id);
            // $profile->delete();
            // $model->status = '0';
            $model->del_status = '1';
            $model->save(false);
            if(Yii::app()->user->id){
                Helpers::lib()->getControllerActionId();
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_POST['ajax']))
                $this->redirect(array('/user/admin/employee'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }



    public function actionSub_category() {
        $data=OrgChart::model()->findAll('parent_id=:parent_id',
            array(':parent_id'=>(int) $_POST['orgchart_lv2']));

        $data=CHtml::listData($data,'id','title');
        echo CHtml::tag('option',
            array('value'=>''),"---กลุ่มหลักสูตรย่อย---",true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }

    }




    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if($this->_model===null)
        {
            if(isset($_GET['id']))
                $this->_model=User::model()->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

}
