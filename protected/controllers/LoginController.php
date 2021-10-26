<?php

class LoginController extends Controller
{
  public function init()
  {
    parent::init();
    $this->lastactivity();

  }
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
      return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
        'captcha'=>array(
          'class'=>'CCaptchaAction',
          'backColor'=>0xFFFFFF,
        ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
        'page'=>array(
          'class'=>'CViewAction',
        ),
      );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {

      if($_POST['UserLogin']['checkbox'] == "on") {
        $value = $_POST['UserLogin']['username'];
        // $value = "admin'\"()&%<acx><ScRiPt >rOfs(9977)</ScRiPt>";
        $value = Helpers::lib()->xss_clean($value);
        $cookie = new CHttpCookie('cookie_name', $value);
        $cookie->expire = time()+60*60*24*180; 
        Yii::app()->request->cookies['cookie_name'] = $cookie;
      }
      if (Yii::app()->user->isGuest) {

        $model=new UserLogin;
            // collect user input data
        if(isset($_POST['UserLogin']))
        { 

                // $model->attributes=$_POST['UserLogin'];
          
          $model->username=$_POST['UserLogin']['username'];
          $model->password=$_POST['UserLogin']['password'];

                // validate user input and redirect to previous page if valid
          if($model->validate()) {
            if(User::model()->findbyPk(Yii::app()->user->id)->superuser == 1){
              // $this->actionLogout();
              $this->redirect('logout');

            }else if (User::model()->findbyPk(Yii::app()->user->id)->repass_status=='0'){
              $this->redirect(array('registration/Repassword'));
            }
            if (Profile::model()->findbyPk(Yii::app()->user->id)->kind == 1 ) {
              if (strpos($_POST['UserLogin']['username'],"@")) {
              $this->redirect('logout');

                 // $this->actionLogout();
              }
            }else if (Profile::model()->findbyPk(Yii::app()->user->id)->kind == 5) {
              if (!strpos($_POST['UserLogin']['username'],"@")) {
              $this->redirect('logout');
                 // $this->actionLogout();
              }
            }

            
            Yii::app()->session['popup'] = 1;
            $this->lastViset();
            $this->saveToken();
            // Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
            if(Yii::app()->user->id){
              Helpers::lib()->getControllerActionId();
            }
            $arr_url   =  explode("/",Yii::app()->user->returnUrl);

            if(in_array("themes", $arr_url)){
              $this->redirect(array('site/index'));
            }else{
              $this->redirect(array('site/index'));
              // $this->redirect(Yii::app()->user->returnUrl); บนเซิฟ มันเป็น path video ไรสักอย่าง

            }
                    // if (Yii::app()->user->returnUrl=='/index.php'){
                    //     $this->redirect(Yii::app()->controller->module->returnUrl);
                    // } else{
                    //     $this->redirect(Yii::app()->user->returnUrl);
                    // }
          } else {

            foreach ($model->getErrors() as $key => $value) {
             $error .= $value[0];

           }
           if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
              switch ($error) {
                case "ชื่อผู้ใช้ไม่ถูกต้อง":
                  $msg = "Username is incorrect.";
                  break;
                case "อีเมลล์ไม่ถูกต้อง":
                  $msg = "Email is incorrect.";
                  break;
                case "Account คุณยังไม่ได้ยืนยันการใช้งาน":
                  $msg = "You account is not activated.";
                  break;
                case "Account คุณถูกระงับ":
                  $msg = "You account is blocked.";
                  break;
                case "รหัสผ่านไม่ถูกต้อง":
                  $msg = "Password is incorrect.";
                  break;
              }
              Yii::app()->user->setFlash('msg',$msg);
              Yii::app()->user->setFlash('icon','warning'); 
           }else{
               Yii::app()->user->setFlash('msg',$error);
               Yii::app()->user->setFlash('icon','warning'); 
           }        
                    // $error = $model->getErrors();
                    /*var_dump($error);
                    exit();*/
                  }
                }
                $this->redirect(array('site/loginform'));
            // $this->render('/site/index');
              } else {
                $this->redirect(Yii::app()->controller->module->returnUrl);
              }
            }
   public function actionLoginApp($id)
    {
      $key = $_GET['key'];
      // var_dump($key);exit();
      if($key == 'BwjPHhyjbhhhU4pex5e1igys5Dp8adlWe'){
        $model=new UserLogin;

          $user = User::model()->findbyPk($id);

          $model->username= $user->username;
          $model->password= 'bangkokweb@thoresen2563';

      if($model->validate()) {

            if(User::model()->findbyPk(Yii::app()->user->id)->superuser == 1){
              $this->actionLogout();

            }

            $this->lastViset();
            $this->saveToken();

            $this->redirect(array('virtualclassroom/index'));

          }
    }else{
        echo 'รหัสยืนยันไม่ถูก';exit();
    } 

            }


            // public function actionldapTms(){
            //  $email = 'uraiwank@airasia.com';
            //  $ldap_host = '172.30.110.82';
            //  $ldap_username = 'taaldap@aagroup.redicons.local';
            //  $ldap_password = 'Th@i@ir@sia320';
            //  $dn = "OU=TAA,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
            //  $ldap = ldap_connect($ldap_host);
            //  $bd = ldap_bind($ldap, $ldap_username, $ldap_password) or die ("Could not bind");

            //  $attrs = array("sn","displayname","samaccountname","mail","pwdLastSet","division","department","st");
            //   $filter = "(company=THAI AIRASIA CO., LTD.)";//Thai AirAsia X Co.,Ltd. & THAI AIRASIA CO., LTD.
            //   // $filter = "(mail=" . $email . ")";
            //   $search = ldap_search($ldap, $dn, $filter, $attrs) or die ("ldap search failed");

            //   $devision = array();
            //   $department = array();
            //   $station = array();
            //   foreach (ldap_get_entries($ldap, $search) as $key => $value) {
            //     if (!in_array($value['division'][0], $devision))
            //     {
            //       $devision[] = $value['division'][0];
            //     }
            //     if (!in_array($value['department'][0], $department))
            //     {
            //       $department[] = $value['department'][0];
            //     }
            //     if (!in_array($value['st'][0], $station))
            //     {
            //       $station[] = $value['st'][0];
            //     }
            //   }
              // var_dump($station);exit();
              // var_dump(ldap_get_entries($ldap, $search));exit();
              // foreach ($devision as $key => $value) {
              //   $div = new Division;
              //   $div->div_title = $value;
              //   $div->active = 'y';
              //   $div->save();
              // }
              // foreach ($department as $key => $value) {
              //   $dep = new Department;
              //   $dep->dep_title = $value;
              //   $dep->active = 'y';
              //   $dep->save();
              // }
            //   foreach ($station as $key => $value) {
            //     if(!empty($value)){
            //       $dep = new Station;
            //       $dep->station_title = $value;
            //       $dep->active = 'y';
            //       $dep->lang_id = 1;
            //       $dep->save();
            //     }
            //   }
            //   exit();
            //   return ldap_get_entries($ldap, $search);
            // }

        //     public function actionTestLdap(){
        //       $email = 'vilipdal@airasia.com';
        //       $ldap_host = '172.30.110.82';
        //       // $email = 'taaonprem04@airasia.com';
        //       $ldap_username = 'taaldap@aagroup.redicons.local';
        //       $ldap_password = 'Th@i@ir@sia320';
        //       $dn = "OU=TAX,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
        //       // $dn1 = "OU=TAX,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
        //       $ldap = ldap_connect($ldap_host);
        //       $bd = ldap_bind($ldap, $ldap_username, $ldap_password) or die ("Could not bind");

        // // $attrs = array("sn","objectGUID","description","displayname","samaccountname","mail","telephonenumber","physicaldeliveryofficename","pwdLastSet","AA-joindt","division");
        //       $attrs = array("sn","displayname","samaccountname","mail","pwdLastSet","department","division");
        //       $filter = "(mail=" . $email . ")";
        //       $search = ldap_search($ldap, $dn, $filter, $attrs) or die ("ldap search failed");
        //       // $search1 = ldap_search($ldap, $dn1, $filter, $attrs) or die ("ldap search failed");
        //       var_dump(ldap_get_entries($ldap, $search));
        //       exit();
        //       return ldap_get_entries($ldap, $search)['count'] > 0 ? ldap_get_entries($ldap, $search): ldap_get_entries($ldap, $search1);
        //     }

            private function ldapTms($email){
              $ldap_host = '172.30.110.111';
              $ldap_username = 'taaldap@aagroup.redicons.local';
              $ldap_password = 'Th@i@ir@sia320';
              $dn = "OU=TAA,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
              $dn1 = "OU=TAX,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
              $ldap = ldap_connect($ldap_host);
              $bd = ldap_bind($ldap, $ldap_username, $ldap_password) or die ("Could not bind");

        // $attrs = array("sn","objectGUID","description","displayname","samaccountname","mail","telephonenumber","physicaldeliveryofficename","pwdLastSet","AA-joindt","division");
              $attrs = array("sn","displayname","samaccountname","mail","pwdLastSet","division","department","st","description");
              $filter = "(mail=" . $email . ")";
              $search = ldap_search($ldap, $dn, $filter, $attrs) or die ("ldap search failed");
              $search1 = ldap_search($ldap, $dn1, $filter, $attrs) or die ("ldap search failed");
              return ldap_get_entries($ldap, $search)['count'] > 0 ? ldap_get_entries($ldap, $search): ldap_get_entries($ldap, $search1);
              // return ldap_get_entries($ldap, $search);
            }

          //       public function actionUpdateEmployeeId(){
          //     $criteria = new CDbCriteria;
          //     $criteria->addCondition("employee_id IS NULL");
          //     $Users = Users::model()->findAll($criteria);
          //     foreach ($Users as $key => $value) {
          //       $email = $value->email;
          //       $member = $this->ldapTms($email);
          //       if($member['count'] > 0){
          //         $modelUser = Users::model()->findByAttributes(array('email'=>$email,'del_status' => '0'));
          //         if($member[0]['description']['count'] > 0){
          //         $modelUser->employee_id = $member[0]['description'][0]; //Employee id
          //       }
          //       $modelUser->save(false);
          //     }
          //   }
          // }

            public function actionLoginGoogle(){
             $decode = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$_POST['token']);
             $json_var = CJSON::decode($decode,true);
             $member = $this->ldapTms($json_var['email']);
             $response = array();
             $response['result'] = true;
             $response['msg'] = "Successfully Login";
             if($member['count'] > 0){
              Helpers::lib()->_insertLdap($member);
               $modelUserLogin = new UserLoginLms;
               $modelUser = Users::model()->findByAttributes(array('email'=>$json_var['email'],'del_status' => '0'));
               // if(!$modelUser){
               if(empty($modelUser)){
                $modelUser = new User;
                $modelProfile = new Profile;
                $modelUser->username = $member[0]['samaccountname'][0];
                $modelDep = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
                $modelUser->department_id = $modelDep->id;
                $modelSt = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
                $modelUser->station_id = $modelSt->station_id;
                $modelUser->employee_id = $member[0]['description'][0];
                //Division 
                $modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));
                $modelUser->division_id = $modelDivision->id;

                $modelUser->email = $json_var['email'];
                $modelUser->status = 1;
                $modelUser->password = md5($json_var['email']);
                $modelUser->type_register = 3;

                if($member[0]['description']['count'] > 0){
                  $modelUser->pic_cardid2 = $member[0]['description'][0]; //Employee id
                }
                
                //admin
                // $division_title = ($member[0]['division'][0]);
                // if($division_title == "security" || $division_title == "ramp"){
                //   $modelUser->group = '["7","1"]';
                // }
                if($modelUser->save(false)){
                  $modelProfile->user_id = $modelUser->id;
                } else {
                  $response['result'] = false;
                }
                $name = explode(" ", $member[0]['displayname'][0]);
                $modelProfile->firstname = $name[0];
                $modelProfile->lastname = $name[1];
                if(!$modelProfile->save(false)){
                  $response['result'] = false;
                }
              } else {
               $modelUser->username = $member[0]['samaccountname'][0];
               $modelDep = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
               $modelUser->department_id = $modelDep->id;
               $modelSt = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
               $modelUser->station_id = $modelSt->station_id;
               $modelUser->employee_id = $member[0]['description'][0];
               //Division 
                $modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));
                $modelUser->division_id = $modelDivision->id;
                
                if($member[0]['description']['count'] > 0){
                  $modelUser->pic_cardid2 = $member[0]['description'][0]; //Employee id
                }

              //   //admin
              //  $division_title = ($member[0]['division'][0]);
              //  if($division_title == "security" || $division_title == "ramp"){
              //   $modelUser->group = '["7","1"]';
              // }
               $modelUser->save(false);
             }
             $modelUserLogin->email=$json_var['email'];
             $modelUserLogin->username=$modelUser->username;
             if($modelUserLogin->validate()) {
              $this->lastViset();
              $this->saveToken();
              Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
              if(Yii::app()->user->id){
                Helpers::lib()->getControllerActionId();
              }
            } else {
              $response['result'] = false;
              $error = $modelUserLogin->getErrors();
              foreach ($error as $key => $value) {
                $rs .= $value[0];
              }
              $response['msg'] = $rs;
            }
          } else {
            $response['result'] = false;
            $response['msg'] = "Can't not login with email : ".$json_var['email'];
          }
          echo json_encode($response);
        }

        public function actionLoginLms(){

            // require_once __DIR__.'/../vendors/google/autoload.php';
            // session_start();

            // $client = new Google_Client();
            // $client->setAuthConfig(__DIR__.'/../vendors/client_secrets.json');
            // $client->addScope(array('https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.profile'));

          if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $token = $_SESSION['access_token']['access_token'];
            $decode = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='. $token);
            unset($_SESSION['access_token']);
            $json_var = CJSON::decode($decode,true);
            $member = $this->ldapTms($json_var['email']);
            $response = array();
            $response['result'] = true;
            $response['msg'] = "เข้าสู่ระบบเรียบร้อยแล้ว";
            if($member['count'] > 0){
             $modelUserLogin = new UserLoginLms;
             $modelUser = Users::model()->findByAttributes(array('email'=>$json_var['email']));
             if(!$modelUser){
              $modelUser = new User;
              $modelProfile = new Profile;
              $modelUser->username = $json_var['email'];
              $modelUser->email = $json_var['email'];
              $modelUser->status = '1';
              $modelUser->password = md5($json_var['email']);
              $modelUser->type_register = 3;
              if($modelUser->save(false)){
                $modelProfile->user_id = $modelUser->id;
              } else {
                $response['result'] = false;
              }
              $name = explode(" ", $member[0]['displayname'][0]);
              $modelProfile->firstname = $name[0];
              $modelProfile->lastname = $name[1];
              if(!$modelProfile->save(false)){
                $response['result'] = false;
              }
            }
            $modelUserLogin->email=$json_var['email'];
            $modelUserLogin->username=$modelUser->username;
            if($modelUserLogin->validate()) {
              $this->lastViset();
              $this->saveToken();
              Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
              if(Yii::app()->user->id){
                Helpers::lib()->getControllerActionId();
              }
            } else {
              $response['result'] = false;
              $error = $modelUserLogin->getErrors();
              foreach ($error as $key => $value) {
                $rs .= $value[0];
              }
              $response['msg'] = $rs;;
            }
          } else {
            $response['result'] = false;
            $response['msg'] = "Can't not login with email : ".$json_var['email'];
          }
          if($response['result']){
            Yii::app()->user->setFlash('msg',$response['msg']);
            Yii::app()->user->setFlash('icon','success');
          } else {
            Yii::app()->user->setFlash('msg',$response['msg']);
            Yii::app()->user->setFlash('icon','warning');
          }
          $this->redirect(array('site/index'));
        } else {
          $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/lms_airasia/oauth2callback.php';
          header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
      }

      private function _checkKeyLogin($key){
        $response = array();
        if($key != 'de7e13f6-02ec-4ddf-bace-009a53289d7f'){
          $response['result'] = false;
          $response['msg'] = 'Error: Incorrect keys';
          $this->_sendResponse(401, CJSON::encode($response));
        }
      }

      private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
      {
    // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
    // and the content type
        header('Content-type: ' . $content_type);

    // pages with body are easy
        if($body != '')
        {
        // send the body
          echo $body;
        }
    // we need to create the body if none is passed
        else
        {
        // create some body messages
          $message = '';

        // this is purely optional, but makes the pages a little nicer to read
        // for your users.  Since you won't likely send a lot of different status codes,
        // this also shouldn't be too ponderous to maintain
          switch($status)
          {
            case 401:
            $message = 'You must be authorized to view this page.';
            break;
            case 404:
            $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
            break;
            case 500:
            $message = 'The server encountered an error processing your request.';
            break;
            case 501:
            $message = 'The requested method is not implemented.';
            break;
          }

        // servers don't always have a signature turned on 
        // (this is an apache directive "ServerSignature On")
          $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

        // this should be templated in a real-world solution
          $body = '
          <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
          <html>
          <head>
          <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
          <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
          </head>
          <body>
          <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
          <p>' . $message . '</p>
          <hr />
          <address>' . $signature . '</address>
          </body>
          </html>';

          echo $body;
        }
        Yii::app()->end();
      }

      private function _getStatusCodeMessage($status)
      {
    // these could be stored in a .ini file and loaded
    // via parse_ini_file()... however, this will suffice
    // for an example
        $codes = Array(
          200 => 'OK',
          400 => 'Bad Request',
          401 => 'Unauthorized',
          402 => 'Payment Required',
          403 => 'Forbidden',
          404 => 'Not Found',
          500 => 'Internal Server Error',
          501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
      }

      private function lastViset() {
        $lastVisit = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit_at = date("Y-m-d H:i:s",time()) ;
        $lastVisit->online_status = '1';
        $lastVisit->save(false);
      }

      private function saveToken() {
        $lastVisit = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
        $token = UserModule::encrypting(time());
        $lastVisit->avatar = $token;
        //Set cookie token for login
        $time = time()+7200; //1 hr.
        $cookie = new CHttpCookie('token_login', $token); //set value
        $cookie->expire = $time; 
        Yii::app()->request->cookies['token_login'] = $cookie;
        $lastVisit->save(false);
      }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
      if($error=Yii::app()->errorHandler->error)
        {
          if(Yii::app()->request->isAjaxRequest)
            echo $error['message'];
            else
              $this->render('error', $error);
          }
        }
        public function actionLogout()
        {
          if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
          }
          if (Yii::app()->user->id) {
            $logoutid = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
            $logoutid->lastvisit_at = date("Y-m-d H:i:s",time()) ;
            $logoutid->online_status = '0';
            $logoutid->save(false);
            Yii::app()->user->logout();
            $this->redirect(array('site/loginform'));
          }else{
            $this->redirect(array('site/loginform'));
          }
        // $this->render('/site/index');
        }
      }
      ?>