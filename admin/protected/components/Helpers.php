<?php

Class Helpers
{
    public $resourceData;

    public static function lib()
    {
        return new Helpers();
    }

    public function getStatePermission($user){
        $dataPermissionGroup = array("1","7","15");
        $state = false;
        foreach ($dataPermissionGroup as $key => $value) {
            if(in_array($value,json_decode($user->group))){
                $state = true;
                break;
            }
        }
        return $state;
    }

    public function changeNameCourse($nameCourse){
        if (strpos($nameCourse, 'จรรยาบรรณ และมาตรฐาน') !== false) {
            return $nameCourse = 'จรรยาบรรณ และ มาตรฐาน';
        }
        return $nameCourse;
    }

    public function changeTypeUser($idTypeUser){
        switch ($idTypeUser) {
            case '1':
                $name = 'สมาชิกทั่วไป';
                break;

            case '2':
                $name = 'ผู้ทำบัญชี';
                break;

            case '3':
                $name = 'ผู้สอบ';
                break;

            case '4':
                $name = 'ผู้ทำและผู้สอบ';
                break;
            
            default:
                $name = 'ผิดพลาด';
                break;
        }
        return $name;
    }

    public function changethainum($num){
        return str_replace(array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ),
            array( "o" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ),
            $num);
    }
    public function changeFormatDateNew($date,$type=null)
    {
        if($type=='date' && $date != ''){
            $date = explode('-', $date);
            $day = $date[0];
            $month = $date[1];
            $year = $date[2]+543;
            if($year == '543' && $month == '00' && $day == '00'){
                return 'ยังไม่เข้าสู่ระบบ';
            }
            switch ($month) {
                case '01':
                    $month = 'มกราคม';
                    break;
                case '02':
                    $month = 'กุมภาพันธ์';
                    break;
                case '03':
                    $month = 'มีนาคม';
                    break;
                case '04':
                    $month = 'เมษายน';
                    break;
                case '05':
                    $month = 'พฤษภาคม';
                    break;
                case '06':
                    $month = 'มิถุนายน';
                    break;
                case '07':
                    $month = 'กรกฎาคม';
                    break;
                case '08':
                    $month = 'สิงหาคม';
                    break;
                case '09':
                    $month = 'กันยายน';
                    break;
                case '10':
                    $month = 'ตุลาคม';
                    break;
                case '11':
                    $month = 'พฤศจิกายน';
                    break;
                case '12':
                    $month = 'ธันวาคม';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $day.' '.$month.' '.$year;
        } else if($date != '') {
            if($date == '0000-00-00'){
            return '-';
            }else{
            $date = explode('-', $date);
            $day = $date[0];
            $month = $date[1];
            $year = $date[2]+543;
            switch ($month) {
                case '01':
                    $month = 'มกราคม';
                    break;
                case '02':
                    $month = 'กุมภาพันธ์';
                    break;
                case '03':
                    $month = 'มีนาคม';
                    break;
                case '04':
                    $month = 'เมษายน';
                    break;
                case '05':
                    $month = 'พฤษภาคม';
                    break;
                case '06':
                    $month = 'มิถุนายน';
                    break;
                case '07':
                    $month = 'กรกฎาคม';
                    break;
                case '08':
                    $month = 'สิงหาคม';
                    break;
                case '09':
                    $month = 'กันยายน';
                    break;
                case '10':
                    $month = 'ตุลาคม';
                    break;
                case '11':
                    $month = 'พฤศจิกายน';
                    break;
                case '12':
                    $month = 'ธันวาคม';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $day.' '.$month.' '.$year;
         }
        }
        return $date;
    }

    public function changeFormatDate($date,$type=null)
    {
        if($type=='datetime' && $date != ''){
            $date = explode('-', $date);
            $year = $date[0]+543;
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $days = $day[0];
            $time = explode(':', $day[1]);
            $hour = $time[0];
            $minute = $time[1];
            if($year == '543' && $month == '00' && $days == '00'){
                return 'ยังไม่เข้าสู่ระบบ';
            }
            switch ($month) {
                case '01':
                    $month = 'มกราคม';
                    break;
                case '02':
                    $month = 'กุมภาพันธ์';
                    break;
                case '03':
                    $month = 'มีนาคม';
                    break;
                case '04':
                    $month = 'เมษายน';
                    break;
                case '05':
                    $month = 'พฤษภาคม';
                    break;
                case '06':
                    $month = 'มิถุนายน';
                    break;
                case '07':
                    $month = 'กรกฎาคม';
                    break;
                case '08':
                    $month = 'สิงหาคม';
                    break;
                case '09':
                    $month = 'กันยายน';
                    break;
                case '10':
                    $month = 'ตุลาคม';
                    break;
                case '11':
                    $month = 'พฤศจิกายน';
                    break;
                case '12':
                    $month = 'ธันวาคม';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $days.' '.$month.' '.$year. ' '.$hour.':'.$minute.' น.';
        } else if($date != '') {
            $date = explode('-', $date);
            $year = $date[0]+543;
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $day = $day[0];
            switch ($month) {
                case '01':
                    $month = 'มกราคม';
                    break;
                case '02':
                    $month = 'กุมภาพันธ์';
                    break;
                case '03':
                    $month = 'มีนาคม';
                    break;
                case '04':
                    $month = 'เมษายน';
                    break;
                case '05':
                    $month = 'พฤษภาคม';
                    break;
                case '06':
                    $month = 'มิถุนายน';
                    break;
                case '07':
                    $month = 'กรกฎาคม';
                    break;
                case '08':
                    $month = 'สิงหาคม';
                    break;
                case '09':
                    $month = 'กันยายน';
                    break;
                case '10':
                    $month = 'ตุลาคม';
                    break;
                case '11':
                    $month = 'พฤศจิกายน';
                    break;
                case '12':
                    $month = 'ธันวาคม';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $day.' '.$month.' '.$year;
        }
        return $date;
    }



    public function StatusCourseGen($course_id, $gen_id,$user_id){ // สถานะของหลักสูตร pass learning notLearn
            // $course_id = $course;
            // $course_model = CourseOnline::model()->findByPk($course_id);
            // $gen_id = $course_model->getGenID($course_model->course_id);

            $user_id = $user_id;

            $passcourse = Passcours::model()->findAll(array( 
                'condition' => 'gen_id=:gen_id AND passcours_cours=:course_id AND passcours_user=:user_id',
                'params' => array(':gen_id'=>$gen_id, ':course_id'=>$course_id, ':user_id'=>$user_id),
            ));

            if(!empty($passcourse)){ // สามารถพิมเซอได้
                $status = "pass";
            }else{ // if(!empty($passcourse)
                $Learn = Learn::model()->findAll(array(
                    'condition' => 'gen_id=:gen_id AND course_id=:course_id AND user_id=:user_id AND lesson_active=:active',
                    'params' => array(':gen_id'=>$gen_id, ':course_id'=>$course_id, ':user_id'=>$user_id, ':active'=>'y'),
                ));
                // var_dump($course_id); 
                // var_dump($gen_id); 
                // var_dump($user_id); 
                // var_dump($Learn); 
                // exit();
                if(!empty($Learn)){
                    $status = "learning";
                }else{
                    $status = "notLearn";
                }
            } // if(!empty($passcourse)

            return $status;
        }

    public function ZoomCheckImage($imgMin, $imgMax)
    {
        $check = CHtml::link(CHtml::image($imgMin, '', array("class" => "thumbnail")), $imgMax, array("rel" => "prettyPhoto"));
        return $check;
    }

    public function ldapTms($email){
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

    public function SendMail($to, $subject, $message, $fromText = 'E-Learning System Isuzu')
    {

        require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/Exception.php";
        require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/PHPMailer.php";
        require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/SMTP.php";

        $SettingAll = Helpers::lib()->SetUpSetting();
        // $adminEmail = $SettingAll['USER_EMAIL'];
        // $adminEmailPass = $SettingAll['PASS_EMAIL'];

        // $adminEmail = 'imctisuzu@gmail.com';
        // $adminEmailPass = 'admindemo';
        $adminEmail = 'keng1155ker@gmail.com';
        $adminEmailPass = 'keng12345678';

        $mail =  new PHPMailer(true);

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // $mail =  new PHPMailer(true);
        // $mail->ClearAddresses();
        // $mail->CharSet = 'utf-8';
        // $mail->Host = '172.30.110.16'; // gmail server
        // $mail->Port = 25; // port number
        // $mail->SMTPKeepAlive = true;
        // $mail->Mailer = "smtp";
        // $mail->SMTPDebug  = false;
        // $mail->From =  $adminEmail;
        // $mail->Username = $adminEmail;
        // $mail->Password = $adminEmailPass;
        // $fromText = 'E-Learning System Thoresen';
        // $mail->SetFrom( $adminEmail, $fromText);
            
        // $mail->AddAddress($adminEmail, 'คุณ' . $to['firstname'] . ' ' . $to['lastname']);

        // $mail->Subject = $subject;
        // $mail->Body = $message;
        // $mail->IsHTML(true);
        // // $member = $this->ldapTms($to['email']);
        // // if($member['count'] <= 0){
        // //     Yii::app()->user->setFlash('mail',$to['email']);
        // // }
        // return $mail->Send();
        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        //$mail->Host = 'smtp.office365.com'; // gmail server
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587'; // port number
        $mail->SMTPSecure = "tls";
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $mail->SetFrom($adminEmail, $fromText);
        $mail->AddAddress($to['email'], 'คุณ' . $to['firstname'] . ' ' . $to['lastname']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);

       // $mail->SMTPSecure = 'tls';
        
        try {
                $mail->Send();
                return "pass";
            } catch (Exception $e) {
                return "fail";
            }
    }


    public function SendMailGroup($to,$subject,$message,$fromText='E-Learning System Thoresen'){
        $path = '../uploads/filemail/';
        $SettingAll = Helpers::lib()->SetUpSetting();
        $adminEmail = $SettingAll['USER_EMAIL'];
        $adminEmailPass = $SettingAll['PASS_EMAIL'];

        $mail = Yii::app()->mailer;
        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com'; // gmail server
        $mail->Port = '465'; // port number
        $mail->SMTPSecure = "ssl";
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $fromText = 'E-Learning System Thoresen';
        $mail->SetFrom($adminEmail, $fromText);

        $address = Mailuser::model()->findAll(array(
            'condition'=>'group_id='.$to,
        ));
        if($address){
            foreach($address as $data_email){
                $mail->AddAddress($data_email->user->email); // to destination
            }
        }
        $file = Mailfile::model()->findAll(array(
           'condition'=>'maildetail_id='.$to,
        ));
        if($file){
            foreach($file as $data_name){
                $mail->addAttachment($path.$data_name->file_name);
            }
        }
//        $mail->addAttachment($path);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);
        $mail->Send();
    }

    public function SetUpSetting()
    {
        $SetUpSetting = array();
        $Setting = Setting::model()->find();

        $SetUpSetting['USER_EMAIL'] = $Setting->settings_user_email;
        $SetUpSetting['PASS_EMAIL'] = $Setting->settings_pass_email;
        $SetUpSetting['SITE_TESTING'] = $Setting->settings_testing;
        $SetUpSetting['SITE_INTRO_STATUS'] = $Setting->settings_intro_status;
        $SetUpSetting['SITE_INSTITUTION'] = $Setting->settings_institution;
        $SetUpSetting['SITE_TEL'] = $Setting->settings_tel;
        $SetUpSetting['SITE_LINE'] = $Setting->settings_line;
        $SetUpSetting['SITE_EMAIL'] = $Setting->settings_email;
        $SetUpSetting['ACTIVE_OFFICE'] = $Setting->settings_register_office;
        $SetUpSetting['ACTIVE_PERSONAL'] = $Setting->settings_register_personal;

        return $SetUpSetting;
    }

    public function setDateTh($date)
    {
        //$temp = strtr($date, substr($date, -4), (substr($date, -4) + 543));
        $temp = str_replace(substr($date, -4), (substr($date, -4) + 543), $date);
        $temp = str_replace('ค.ศ.', 'พ.ศ.', $temp);
        return $temp;
    }

    public function PlusDate($givendate, $day = 0, $mth = 0, $yr = 0)
    {
        $cd = strtotime($givendate);
        $newdate = date('Y-m-d', mktime(date('h', $cd),
            date('i', $cd), date('s', $cd), date('m', $cd) + $mth,
            date('d', $cd) + $day, date('Y', $cd) + $yr));
        return $newdate;
    }

    public function compareDate($date1, $date2)
    {
        $arrDate1 = explode("-", $date1);
        $arrDate2 = explode("-", $date2);
        $timStmp1 = @mktime(0, 0, 0, $arrDate1[1], $arrDate1[2], $arrDate1[0]);
        $timStmp2 = @mktime(0, 0, 0, $arrDate2[1], $arrDate2[2], $arrDate2[0]);
        if ($timStmp1 == $timStmp2) {
            $Check = true;
        } else if ($timStmp1 > $timStmp2) {
            $Check = false;
        } else if ($timStmp1 < $timStmp2) {
            $Check = true;
        }
        return $Check;
    }

    //("true" return string) && ("false" return true or false)
    public function CheckBuyItem($id, $return = "")
    {
        $courseArray = array();
        if (!Yii::app()->user->isGuest) {
            $user = Yii::app()->getModule('user')->user();
            foreach ($user->ownerCourseOnline(array(
                'condition' => 'DATEDIFF(NOW(),date_expire)'
            )) as $resultCourse) {
                $courseArray[] = $resultCourse->course_id;
            }
        }
        $countReturn = tblReturn::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
            "lesson_id" => $id, "user_id" => Yii::app()->user->id
        ));

        $OrderDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
            'order' => ' OrderDetailonlines.order_id DESC ',
            'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
        ));
        if (!in_array($id, $courseArray)) {
            $get = 'cart';
            if ($return == "string")
                if ($this->CheckTestingPass($id, true) == 'new') {
                    if ($countReturn > 1) {
                        $new = 'renews';
                        $link = CHtml::link('เรียนใหม่', array($new, 'id' => $id), array(
                            'class' => 'btn btn-success btn-icon glyphicons ok_2',
                            'onclick' => 'if(confirm("ยืนยันการเรียนใหม่หรือไม่ ?")){ return true; }else{ return false;}'
                        ));
                    } else {
                        $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                            )) . '</div>';
                    }
                } else {
                    if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 0 && $OrderDetailonline->con_admin == 0) {
                        $link = '<span class="label label-important">กรุณาแจ้งชำระเงิน</span>';
                    } else if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 1 && $OrderDetailonline->con_admin == 0) {
                        $link = '<span class="label label-info">รอการตรวจสอบ</span>';
                    } else {
                        $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                            )) . '</div>';
                    }
                    // $link =  '<div style="margin-bottom:5px;">'.CHtml::link('สั่งซื้อ',array('cart','id'=>$id),array(
                    //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                    // )).'</div>'.CHtml::link('Point',array('point','id'=>$id),array(
                    //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                    // ));
                }
            else
                //$link = false;
                $link = true;
        } else {

            if ($OrderDetailonline->date_expire != null) {
                $d1 = new DateTime(date("Y-m-d H:i:s"));
                $d2 = new DateTime($OrderDetailonline->date_expire);
                if ($d1 > $d2) {
                    $CheckDate = false;
                } else {
                    $CheckDate = true;
                }
            } else {
                $CheckDate = false;
            }

            //$CheckDate = $this->compareDate(date("Y-m-d H:i:s"),$OrderDetailonline->CheckDateTime->date_expire);

            if ($return == "string")
                if ($this->CheckTestingPass($id, true) == 'new') {
                    if ($countReturn < 1) {
                        $new = 'renews';
                        $link = CHtml::link('เรียนใหม่', array($new, 'id' => $id), array(
                            'class' => 'btn btn-success btn-icon glyphicons ok_2',
                            'onclick' => 'if(confirm("ยืนยันการเรียนใหม่หรือไม่ ?")){ return true; }else{ return false;}'
                        ));
                    } else {
                        $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                            )) . '</div>';
                        // $link =  '<div style="margin-bottom:5px;">'.CHtml::link('สั่งซื้อ',array('cart','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // )).'</div>'.CHtml::link('Point',array('point','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // ));
                    }
                } else {
                    if ($CheckDate) {
                        $link = '<span class="label label-success">ซื้อเรียบร้อย</span>';
                    } else {
                        if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 0 && $OrderDetailonline->con_admin == 0) {
                            $link = '<span class="label label-important">กรุณาแจ้งชำระเงิน</span>';
                        } else if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 1 && $OrderDetailonline->con_admin == 0) {
                            $link = '<span class="label label-info">รอการตรวจสอบ</span>';
                        } else {
                            $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                    'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                                )) . '</div>';
                        }
                        // $link =  '<div style="margin-bottom:5px;">'.CHtml::link('สั่งซื้อ',array('cart','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // )).'</div>'.CHtml::link('Point',array('point','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // ));
                    }
                }
            else
                if ($CheckDate) {
                    $link = true;
                } else {
                    $link = false;
                }
        }
        return $link;
    }

    public function CalDate($time1, $time2)
    {
        $time1 = strtotime($time1);
        $time2 = strtotime($time2);
        $distanceInSeconds = round(abs($time2 - $time1));
        $distanceInMinutes = round($distanceInSeconds / 60);
        $days = floor(abs($distanceInMinutes / 1440));
        $hours = floor(fmod($distanceInMinutes, 1440) / 60);
        $minutes = floor(fmod($distanceInMinutes, 60));
        return $days . " วัน " . $hours . " ชั่วโมง " . $minutes . " นาที";
    }

    public function CheckDateTimeUser($id)
    {
        $CheckBuy = $this->CheckBuyItem($id);
        if ($CheckBuy == true) {
            //   $OrderDetailonline = OrderDetailonline::model()->find(array(
            //    "order" => "order_detail_id DESC",
            // 'condition'=>'shop_id=:shop_id AND active=:active',
            // 'params' => array(':shop_id' => $id, ':active' => 'y')
            //   ));
            $OrderDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
                'order' => ' OrderDetailonlines.order_detail_id DESC ',
                'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
            ));
            //$CheckDate = $this->compareDate(date("Y-m-d H:i:s"),$OrderDetailonline->CheckDateTime->date_expire);

            if ($OrderDetailonline->date_expire != null) {
                $text = $this->CalDate(date("Y-m-d H:i:s"), $OrderDetailonline->date_expire);
            } else {
                $text = '-';
            }
        } else {
            $text = '-';
        }
        return $text;
    }

    public function CheckLearning($check, $id)
    {
        if (Helpers::lib()->CheckBuyItem($check) == true)
            $learning = CHtml::link('เรียน', array('//courseOnline/learn', 'id' => $id));
        else
            $learning = '-';

        return $learning;
    }

    public function checkLessonFile($file)
    {
        $user = Yii::app()->getModule('user')->user();
        $learnFiles = $user->learnFiles(
            array(
                'condition' => 'file_id=:file_id',
                'params' => array(':file_id' => $file->id)
            )
        );
        if ($learnFiles) {
            if ($learnFiles[0]->learn_file_status != 's') {
                return "learning";
            } else {
                return "pass";
            }
        } else {
            return "notLearn";
        }
    }

    public static function isPretestState($lesson_id)
    {
        $lesson = Lesson::model()->findByPk($lesson_id);

        if (!$lesson) {
            return false;
        }

        if (self::lib()->checkLessonPass($lesson) != 'notLearn') {
            return false;
        }

        if (!self::checkHavePreTestInManage($lesson_id)) {
            return false;
        }

        $haveScore = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id));

        if (!$isExamAddToLessonForTest && !$haveScore) {
            return true;
        }

        return false;
    }

    public static function checkHavePreTestInManage($lesson_id)
    {
        // $isExamAddToLessonForTest = Manage::model()->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre', 'active' => 'y'));
        $isExamAddToLessonForTest = Manage::model()->with('group')->findAll("id = '" . $lesson_id . "' AND type = 'pre' AND manage.active='y' AND group.active ='y'");

        if (!$isExamAddToLessonForTest) {
            return false;
        }

        return true;
    }

     public static function checkHavePostTestInManage($lesson_id)
    {
        
        // $isExamAddToLessonForTest = Manage::model()->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre', 'active' => 'y'));
        $isExamAddToLessonForTest = Manage::model()->with('group')->findAll("id = '" . $lesson_id . "' AND type = 'post' AND manage.active='y' AND group.active ='y'");

        if (!$isExamAddToLessonForTest) {
            return false;
        }

        return true;
    }

    public function checkLessonPass($lesson)
    {
        $user = Yii::app()->getModule('user')->user();
        if ($user) {
            $learnLesson = $user->learns(
                array(
                    'condition' => 'lesson_id=:lesson_id',
                    'params' => array(':lesson_id' => $lesson->id)
                )
            );
            if ($lesson->fileCount == 0 && $learnLesson) {
                return "pass";
            } else if ($lesson->fileCount != 0 && $learnLesson) {

                $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\'',
                        'params' => array(':lesson_id' => $lesson->id)
                    )
                );
                if ($countLearnCompareTrueVdos != $lesson->fileCount) {
                    return "learning";
                } else {
                    return "pass";
                }

            } else {
                return "notLearn";
            }
        }
    }

    public function checkLessonPassById($lesson, $user_id, $date)
    {

        $user = Yii::app()->getModule('user')->user($user_id);
        if ($user) {
            if ($date == '') {
                $learnLesson = $user->learns(
                    array(
                        'condition' => 'lesson_id=:lesson_id',
                        'params' => array(':lesson_id' => $lesson->id)
                    )
                );
            } else {
                list($start, $end) = explode(" - ", $date);
                $start = date("Y-d-m", strtotime($start)) . " 00:00:00";
                $end = date("Y-d-m", strtotime($end)) . " 23:59:59";

                $learnLesson = $user->learns(
                    array(
                        'condition' => 'lesson_id=:lesson_id AND learn_date BETWEEN :start AND :end',
                        'params' => array(':lesson_id' => $lesson->id, ':start' => $start, ':end' => $end)
                    )
                );
            }

            if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                return "pass";
            } else {
                if ($lesson->fileCount == 0 && $learnLesson) {
                    return "pass";
                } else {
                    if ($lesson->fileCount != 0 && $learnLesson) {

                        $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                            array(
                                'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\'',
                                'params' => array(':lesson_id' => $lesson->id)
                            )
                        );
                        if ($countLearnCompareTrueVdos != $lesson->fileCount) {
                            return "learning";
                        } else {
                            return "pass";
                        }

                    } else {
                        return "notLearn";
                    }
                }
            }
        }
    }

    public function checkLessonPassByIdDate($lesson, $user_id, $startdate, $enddate)
    {

        $user = Yii::app()->getModule('user')->user($user_id);
        if ($user) {
            if ($startdate == '') {
                $learnLesson = $user->learns(
                    array(
                        'condition' => 'lesson_id=:lesson_id',
                        'params' => array(':lesson_id' => $lesson->id)
                    )
                );
            } else {
                $start = date("Y-d-m", strtotime($startdate)) . " 00:00:00";
                $end = date("Y-d-m", strtotime($enddate)) . " 23:59:59";

                $learnLesson = $user->learns(
                    array(
                        'condition' => 'lesson_id=:lesson_id AND learn_date BETWEEN :start AND :end',
                        'params' => array(':lesson_id' => $lesson->id, ':start' => $start, ':end' => $end)
                    )
                );
            }

            if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                return "pass";
            } else {
                if ($lesson->fileCount == 0 && $learnLesson) {
                    return "pass";
                } else {
                    if ($lesson->fileCount != 0 && $learnLesson) {

                        $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                            array(
                                'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\'',
                                'params' => array(':lesson_id' => $lesson->id)
                            )
                        );
                        if ($countLearnCompareTrueVdos != $lesson->fileCount) {
                            return "learning";
                        } else {
                            return "pass";
                        }

                    } else {
                        return "notLearn";
                    }
                }
            }
        }
    }

    //("true" return string) && ("false" return true or false)
    public function CheckTestCount($status, $id, $return = false, $check = true, $user_id = null)
    {
        if ($status == "notLearn" || $status == "learning") {
            if ($check == true) {
                if ($return == true)
                    $CheckTesting = '<font color="#E60000">ยังไม่มีสิทธิ์สอบ Post-Test</font>';
                else
                    $CheckTesting = false; //No Past
            } else {
                $CheckTesting = false;
            }
        } else if ($status == "pass") {
            $CheckTesting = "<font color='#00EC00'>ผ่าน</font>";

            $countManage = Manage::Model()->count("id=:id AND active=:active AND type = 'post' ", array(
                "id"=>$id,"active"=>"y"
            ));

            if(!empty($countManage)) { // ถ้ามีข้อสอบ
            
                $Lesson = Lesson::model()->find(array(
                    'condition'=>'id=:id','params' => array(':id' => $id)
                ));

                if($user_id == null){
                    $user_id = Yii::app()->user->id;
                }

                $countScore = Score::Model()->find("lesson_id=:lesson_id AND user_id=:user_id  AND type = 'post' ORDER BY score_id DESC", array(
                    "lesson_id"=>$id,"user_id"=> $user_id
                ));

                // $countScorePast = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND score_past=:score_past AND type='post'", array(
                //     "lesson_id"=>$id,"user_id"=>Yii::app()->user->id,"score_past"=>"y"
                // ));


                if($countScore != ""){
                    if($countScore->score_past == "y"){
                        $CheckTesting = '<font color="#008000">สอบผ่าน</font>';
                    }else{
                        $CheckTesting =  '<font color="#E60000">สอบไม่ผ่าน</font>';
                    }   
                }else{
                    $CheckTesting = '<font color="#E60000">ยังไม่สอบ</font>';  
                }


                // if(!empty($countScorePast))
                // {
                //     if($check == true)
                //     {
                //         if($return == true)
                //         {
                //             $CheckTesting = '<font color="#008000">สอบผ่าน</font>';
                //         }
                //         else
                //         {
                //             $CheckTesting =  true; //Past
                //         }
                //     }
                //     else
                //     {
                //         $CheckTesting =  true;
                //     }
                // } else {

                //     if($countScore == $Lesson->cate_amount)
                //     {
                //         if($check == true)
                //         {
                //             if($return == true)
                //             {
                //                 $CheckTesting =  '<font color="#E60000">สอบไม่ผ่าน</font>';
                //             } else {
                //                 $CheckTesting =  false; //No Past
                //             }

                //         } else {
                //             $CheckTesting =  true;
                //         }
                //     } else {
                //         if($check == true)
                //         {
                //             if($return == true)
                //             {
                //                 $CheckTesting = CHtml::link('สอบ Post-Test', array(
                //                     '//question/index',
                //                     'id'=>$id
                //                 ),array(
                //                     //'target'=>'_blank'
                //                 ));
                //             } else {
                //                 $CheckTesting =  false; //No Past
                //             }
                //         } else {
                //             $CheckTesting =  false;
                //         }
                //     }

                // }

            } else { // ไม่มีข้อสอบ
                  $CheckTesting = '<font>ไม่มีข้อสอบ Post Test</font>';  
                // if($check == true)
                // {
                //     if($return == true)
                //     {
                //         $CheckTesting = '-';
                //     } else {
                //         $CheckTesting =  true; //Past
                //     }
                // } else {
                //     $CheckTesting =  false;
                // }
            }






        } else {
            if ($check == true) {
                if ($return == true) {
                    $CheckTesting = '<font color="#E60000">ไม่ผ่าน</font>';
                } else {
                    $CheckTesting = false; //No Past
                }
            } else {
                $CheckTesting = false;
            }
        }
        return $CheckTesting;
    }




    public function CountTestIng($status, $id, $amount)
    {
        if ($status == "pass") {
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type='post'", array(
                "user_id" => Yii::app()->user->id,
                "lesson_id" => $id
            ));

            $sum = intval($amount - $countScore);

            if ($sum != 0 && $countScore <= $amount) {
                $num = 'เหลือ ' . $sum . ' ครั้ง';
            } else {
                $num = '<font color="#E60000">หมดสิทธิสอบ</font>';
            }
        } else {
            $num = '-';
        }

        return $num;
    }

    public function ScorePercent($id)
    {
        $criteria = new CDbCriteria;
        $criteria->select = '*,MAX(score_number) as score_number';
        $criteria->condition = ' type = "post" AND lesson_id="' . $id . '" AND user_id="' . Yii::app()->user->id . '"';
        $Score = Score::model()->find($criteria);

        if (!empty($Score->score_number)) {
            //$check = number_format(($Score->score_number/$Score->score_total)*100,2);
            $check = number_format(($Score->score_number));
        } else {
            $check = '0';
        }

        return $check;
    }

    public function ScoreToTal($id)
    {
        $criteria = new CDbCriteria;
        $criteria->select = '*,MAX(score_total) as score_total';
        $criteria->condition = ' type = "post" AND lesson_id="' . $id . '" AND user_id="' . Yii::app()->user->id . '"';
        $Score = Score::model()->find($criteria);

        if (!empty($Score->score_total)) {
            //$check = number_format(($Score->score_total/$Score->score_total)*100,2);
            $check = number_format(($Score->score_total));
        } else {
            $check = '0';
        }

        return $check;
    }

    public function CheckTestingPass($id, $return = false, $checkEvaluate = false)
    {
        $lessonModel = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id',
            'params' => array(':course_id' => $id)
        ));

        $_Score = 0;
        $scoreCheck = 0;
        $totalCheck = 0;
        $PassLearnCout = 0;

        foreach ($lessonModel as $key => $value) {
            $lessonStatus = $this->checkLessonPass($value);
            $scoreSum = $this->ScorePercent($value->id);
            $scoreToTal = $this->ScoreToTal($value->id);

            if (!empty($scoreSum)) {
                $CheckSumOK = $scoreSum;
            } else {
                $CheckSumOK = 0;
            }

            if (!empty($scoreToTal)) {
                $CheckToTalOK = $scoreToTal;
            } else {
                $CheckToTalOK = 0;
            }

            $totalCheck = $totalCheck + $CheckToTalOK;
            $scoreCheck = $scoreCheck + $CheckSumOK;

            if (Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false, false) == true) {
                $PassLearnCout = $PassLearnCout + 1;
            }

            //========== เช็คว่าสอบครบทุกบทหรือยัง ==========//
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
                "user_id" => Yii::app()->user->id,
                "lesson_id" => $value->id
            ));

            if ($countScore >= "1") {
                $_Score = $_Score + 1;
            }


            $CheckNoTesting = Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false);
        }

        if (count($lessonModel) == true) {
            $sumTotal = $scoreCheck * 100;
            if (!empty($totalCheck)) {
                $sumTotal = $sumTotal / $totalCheck;
            }

            if ($_Score === count($lessonModel) && $sumTotal >= 60) {
                $modelDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
                    'order' => ' OrderDetailonlines.order_id DESC ',
                    'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
                ));

                if (isset($modelDetailonline->con_admin) && $modelDetailonline->con_admin == 1) {
                    if ($checkEvaluate == false) {
                        $imageUrl = Yii::app()->request->baseUrl . '/images/icons/print.png';
                        $sumTestingTxt = CHtml::link(CHtml::image($imageUrl, 'Accept'), array(
                            'printpdf', 'id' => $id
                        ), array(
                            'class' => 'imageIcon',
                            'target' => '_blank'
                        ));
                    } else {
                        $sumTestingTxt = true;
                    }
                } else {
                    if (isset($modelDetailonline->con_user) && $modelDetailonline->con_user == 0) {
                        if ($checkEvaluate == false) {
                            $imageCoins = Yii::app()->request->baseUrl . '/images/icons/coins.png';
                            $sumTestingTxt = CHtml::link(CHtml::image($imageCoins, 'Accept'), array(
                                '//orderonline/update',
                                'id' => $modelDetailonline->order_id
                            ), array(
                                'class' => 'imageIcon',
                            ));
                        } else {
                            $sumTestingTxt = false;
                        }
                    } else {
                        if ($checkEvaluate == false) {
                            $imageCoinsOk = Yii::app()->request->baseUrl . '/images/icon_checkpast.png';
                            $sumTestingTxt = CHtml::image($imageCoinsOk, 'ยืนยันเรียบร้อย', array(
                                'title' => 'ยืนยันเรียบร้อย'
                            ));
                        } else {
                            $sumTestingTxt = false;
                        }
                    }
                }
            } else {
                if ($PassLearnCout == count($lessonModel)) {
                    if ($return == false) {
                        if ($checkEvaluate == false) {
                            $sumTestingTxt = '-';
                        } else {
                            $sumTestingTxt = false;
                        }
                    } else {
                        if ($checkEvaluate == false) {
                            $sumTestingTxt = 'new';
                        } else {
                            $sumTestingTxt = false;
                        }
                    }
                } else {
                    if ($CheckNoTesting == true) {
                        if ($checkEvaluate == false) {
                            if ($_Score === count($lessonModel)) {
                                $imageUrl = Yii::app()->request->baseUrl . '/images/icons/print.png';
                                $sumTestingTxt = CHtml::link(CHtml::image($imageUrl, 'Accept'), array(
                                    'printpdf',
                                    'id' => $id), array(
                                    'class' => 'imageIcon',
                                    'target' => '_blank'
                                ));
                            } else {
                                $sumTestingTxt = false;
                            }
                        } else {
                            $sumTestingTxt = true;
                        }
                    } else {
                        if ($checkEvaluate == false) {
                            $sumTestingTxt = '-';
                        } else {
                            $sumTestingTxt = false;
                        }
                    }
                }
            }

            return $sumTestingTxt;
        }
    }

    //INSERT PASS courseOnline
    public function CheckTestingPassCourseOnline($id, $return = false)
    {
        $lessonModel = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id',
            'params' => array(':course_id' => $id)
        ));

        $scoreCheck = 0;
        $PassLearnCout = 0;

        foreach ($lessonModel as $key => $value) {
            $lessonStatus = $this->checkLessonPass($value);
            $scoreSum = $this->ScorePercent($value->id);

            if (!empty($scoreSum)) {
                $CheckSumOK = $scoreSum;
            } else {
                $CheckSumOK = 0;
            }

            $scoreCheck = $scoreCheck + $CheckSumOK;

            if ($this->CheckTestCount($lessonStatus, $value->id, false, false) == true) {
                $PassLearnCout = $PassLearnCout + 1;
            }
        }


        foreach ($lessonModel as $key => $value) {
            $lessonStatus = $this->checkLessonPass($value);
            $scoreSum = $this->ScorePercent($value->id);

            if (!empty($scoreSum)) {
                $CheckSumOK = $scoreSum;
            } else {
                $CheckSumOK = $scoreSum;
            }

            $scoreCheck = $scoreCheck + $CheckSumOK;

            if (Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false, false) == true) {
                $PassLearnCout = $PassLearnCout + 1;
            }

            $CheckNoTesting = Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false);
        }


        if (count($lessonModel) == true) {
            $sumTestingOK = $scoreCheck / count($lessonModel);
            if ($sumTestingOK >= 60) {
                $modelDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
                    'order' => ' OrderDetailonlines.order_id DESC ',
                    'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
                ));
                if (isset($modelDetailonline->con_admin) && $modelDetailonline->con_admin == 1) {
                    $sumTestingTxt = true;
                } else {
                    $sumTestingTxt = false;
                }
            } else {
                $sumTestingTxt = false;
            }

            return $sumTestingTxt;
        }
    }

    /*

VS SCORM - IMS Manifest File Reader - subs.php 
Rev 2009-11-30-01
Copyright (C) 2009, Addison Robson LLC

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, 
Boston, MA 02110-1301, USA.

*/

// ------------------------------------------------------------------------------------

    public function readIMSManifestFile($manifestfile)
    {

        // PREPARATIONS

        // central array for resource data

        // load the imsmanifest.xml file
        $xmlfile = new DomDocument;
        $xmlfile->preserveWhiteSpace = FALSE;
        $xmlfile->load($manifestfile);

        // adlcp namespace
        $manifest = $xmlfile->getElementsByTagName('manifest');
        $adlcp = $manifest->item(0)->getAttribute('xmlns:adlcp');

        // READ THE RESOURCES LIST

        // array to store the results
        $this->resourceData = array();

        // get the list of resource element
        $resourceList = $xmlfile->getElementsByTagName('resource');

        $r = 0;
        foreach ($resourceList as $rtemp) {

            // decode the resource attributes
            $identifier = $resourceList->item($r)->getAttribute('identifier');
            $this->resourceData[$identifier]['type'] = $resourceList->item($r)->getAttribute('type');
            $this->resourceData[$identifier]['scormtype'] = $resourceList->item($r)->getAttribute('adlcp:scormtype');
            $this->resourceData[$identifier]['href'] = $resourceList->item($r)->getAttribute('href');

            // list of files
            $fileList = $resourceList->item($r)->getElementsByTagName('file');

            $f = 0;
            foreach ($fileList as $ftemp) {
                $this->resourceData[$identifier]['files'][$f] = $fileList->item($f)->getAttribute('href');
                $f++;
            }

            // list of dependencies
            $dependencyList = $resourceList->item($r)->getElementsByTagName('dependency');

            $d = 0;
            foreach ($dependencyList as $dtemp) {
                $this->resourceData[$identifier]['dependencies'][$d] = $dependencyList->item($d)->getAttribute('identifierref');
                $d++;
            }

            $r++;

        }

        // resolve resource dependencies to create the file lists for each resource
        foreach ($this->resourceData as $identifier => $resource) {
            $this->resourceData[$identifier]['files'] = Helpers::lib()->resolveIMSManifestDependencies($identifier);
        }

        // READ THE ITEMS LIST

        // arrays to store the results
        $itemData = array();

        // get the list of resource element
        $itemList = $xmlfile->getElementsByTagName('item');

        $i = 0;
        foreach ($itemList as $itemp) {

            // decode the resource attributes
            $identifier = $itemList->item($i)->getAttribute('identifier');
            $itemData[$identifier]['identifierref'] = $itemList->item($i)->getAttribute('identifierref');
            $itemData[$identifier]['title'] = $itemList->item($i)->getElementsByTagName('title')->item(0)->nodeValue;
            $itemData[$identifier]['masteryscore'] = $itemList->item($i)->getElementsByTagNameNS($adlcp, 'masteryscore')->item(0)->nodeValue;
            $itemData[$identifier]['datafromlms'] = $itemList->item($i)->getElementsByTagNameNS($adlcp, 'datafromlms')->item(0)->nodeValue;

            $i++;

        }

        // PROCESS THE ITEMS LIST TO FIND SCOS

        // array for the results
        $SCOdata = array();

        // loop through the list of items
        foreach ($itemData as $identifier => $item) {

            // find the linked resource
            $identifierref = $item['identifierref'];

            // is the linked resource a SCO? if not, skip this item
            if (strtolower($this->resourceData[$identifierref]['scormtype']) != 'sco') {
                continue;
            }

            // save data that we want to the output array
            $SCOdata[$identifier]['title'] = $item['title'];
            $SCOdata[$identifier]['masteryscore'] = $item['masteryscore'];
            $SCOdata[$identifier]['datafromlms'] = $item['datafromlms'];
            $SCOdata[$identifier]['href'] = $this->resourceData[$identifierref]['href'];
            $SCOdata[$identifier]['files'] = $this->resourceData[$identifierref]['files'];

        }

        return $SCOdata;

    }

// ------------------------------------------------------------------------------------

// recursive function used to resolve the dependencies (see above)
    public function resolveIMSManifestDependencies($identifier)
    {


        $files = $this->resourceData[$identifier]['files'];

        $dependencies = $this->resourceData[$identifier]['dependencies'];
        if (is_array($dependencies)) {
            foreach ($dependencies as $d => $dependencyidentifier) {
                if (is_array($files)) {
                    $files = array_merge($files, resolveIMSManifestDependencies($dependencyidentifier));
                } else {
                    $files = resolveIMSManifestDependencies($dependencyidentifier);
                }
                unset($this->resourceData[$identifier]['dependencies'][$d]);
            }
            $files = array_unique($files);
        }

        return $files;

    }

    public function cleanVar($value)
    {
        $value = (trim($value) == "") ? "&nbsp;" : htmlentities(trim($value));
        return $value;
    }

    public function chk_type_img($path,$type)
    {
        if($type=="jpg" || $type=="gif" || $type=="png"){
            $data = '<img src="'.$path.'">';
        }elseif($type=="doc" || $type=="docx"){
            $data = '<img src="'.Yii::app()->theme->baseUrl.'/images/icon/word.png" style="width: 150px">';
        }elseif($type=="xls" || $type=="xlsx"){
            $data = '<img src="'.Yii::app()->theme->baseUrl.'/images/icon/excel.png" style="width: 150px">';
        }elseif($type=="pdf"){
            $data = '<img src="'.Yii::app()->theme->baseUrl.'/images/icon/pdf.png" style="width: 150px">';
        }else{
            $data = '<img src="'.Yii::app()->theme->baseUrl.'/images/icon/file.png" style="width: 150px">';
        }
        return $data;
    }
    
    
    public function learn_date_from_course($course_id,$user_id)
    {
        $date_start = '';
        $lessonModel = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id',
            'params' => array(':course_id' => $course_id,
//            'order' => 'create_date',
//            'limit' => '1'
            )
        ));
//$lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
        if($lessonModel){
            foreach ($lessonModel as $key => $value) {
                $lesson_id[] = $value['id'];
            }
        }
        $lesson_id = implode(',',$lesson_id);
        $learnModel = Learn::model()->findAll(array(
            'condition' => 'lesson_id in ('.$lesson_id.') and user_id = '.$user_id,
//            'params' => array(':lesson_id' => $lesson_id,
            'order' => 'create_date',
            'limit' => 1
//            )
        ));
//$lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
        if($learnModel){
            foreach ($learnModel as $key => $value) {
                $date_start = $value['create_date'];
            }
        }
        return $date_start;
    }
    
    public function learn_end_date_from_course($course_id,$user_id)
    {
        $date_end = '';
        $lessonModel = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id',
            'params' => array(':course_id' => $course_id,
//            'order' => 'create_date',
//            'limit' => '1'
            )
        ));
//$lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
        if($lessonModel){
            foreach ($lessonModel as $key => $value) {
                $lesson_id[] = $value['id'];
            }
        }
        $lesson_id = implode(',',$lesson_id);
        $learnModel = Learn::model()->findAll(array(
            'condition' => 'lesson_id in ('.$lesson_id.') and user_id = '.$user_id,
//            'params' => array(':lesson_id' => $lesson_id,
            'order' => 'learn_date desc',
            'limit' => 1
//            )
        ));
//$lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
        if($learnModel){
            foreach ($learnModel as $key => $value) {
                $date_end = $value['learn_date'];
            }
        }
        return $date_end;
    }
    
    public function title_name($id)
    {
        $title = '';
        $ProfilesTitle = ProfilesTitle::model()->findAll(array(
            'condition' => 'prof_id='.$id,
//            'params' => array(':prof_id' => $id,
//            'limit' => '1'
//            )
        ));
        
        if($ProfilesTitle){
            foreach ($ProfilesTitle as $key => $value) {
                $title = $value['prof_title'];
            }
        }
        return $title;
    }
    
    public function province_name($id)
    {
        $p_name = '';
        $province = Province::model()->findAll(array(
            'condition' => 'pv_id='.$id,
//            'params' => array(':prof_id' => $id,
//            'limit' => '1'
//            )
        ));
        
        if($province){
            foreach ($province as $key => $value) {
                $p_name = $value['pv_name_th'];
            }
        }
        return $p_name;
    }
    
    public function course_score_percent($num,$course_id,$user_id)
    {
        $sc = array();
        $Coursescore = Coursescore::model()->findAll(array(
            'condition' => 'course_id='.$course_id .' and user_id='.$user_id,
            'params' => array(
                'limit' => '2',
                'order' => 'create_date desc'
            )
        ));
        
        if($Coursescore){
            foreach ($Coursescore as $key => $value) {
                $score_number = $value['score_number'];
                $score_total = $value['score_total'];
                
                $sc[$key] = number_format($score_number*100/$score_total, 2, '.', '');
            }
        }
        if(count($Coursescore)>1){
            if($num==1){
            return $sc[1];
            }
            if($num==2){
            return $sc[0];
            }
        }
        if(count($Coursescore)==1){
            if($num==1){
            return $sc[0];
            }
            if($num==2){
            return '-';
            }
        }
        else{
            return '-';
        }
    }
    
    public function date_pass_60_percent($course_id,$user_id)
    {
        $date_pass = '';
        $Coursescore = Coursescore::model()->findAll(array(
            'condition' => 'course_id='.$course_id .' and user_id='.$user_id.' and score_past="y" ' ,
            'params' => array(
                'limit' => '1',
                'order' => 'create_date desc'
            )
        ));
        
        if($Coursescore){
            foreach ($Coursescore as $key => $value) {
                $date_pass = $value['create_date'];
            }
        }
        return $date_pass;
    }

     public function uploadImage($cate_image,$path){
        foreach ($cate_image as $image) {
            // save output data if set
            if (isset($image['output']['data'])) {
                // Save the file
                $name = $image['output']['name'];
                // We'll use the output crop data
                $data = $image['output']['data'];

                // If you want to store the file in another directory pass the directory name as the third parameter.
                // $file = Slim::saveFile($data, $name, 'my-directory/');

                // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
                // $file = Slim::saveFile($data, $name, 'tmp/', false);
                $output = Slim::saveFile($data, $name, $path);
                return $output['name'];
            }

            // save input data if set
            if (isset ($image['input']['data'])) {

                // Save the file
                $name = $image['input']['name'];
                // We'll use the output crop data
                $data = $image['input']['data'];

                // If you want to store the file in another directory pass the directory name as the third parameter.
                // $file = Slim::saveFile($data, $name, 'my-directory/');

                // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
                // $file = Slim::saveFile($data, $name, 'tmp/', false);
                $input = Slim::saveFile($data, $name, $path);
                return $input['name'];
            }

        }

    }

    public function getControllerActionId($parameter = null,$user_id = null)
{
    if(Yii::app()->controller->id != 'logAdmin' && !empty(Yii::app()->controller->action->id)){
        $model = new LogAdmin;
        $model->controller = Yii::app()->controller->id;
        $model->action = Yii::app()->controller->action->id;
        if(!empty($_GET['id'])){
            $model->parameter = $_GET['id'];
        }
        if($parameter != null){
            $model->parameter = $parameter;
        }
        if(Yii::app()->controller->module->id){
            $model->module = Yii::app()->controller->module->id;
        }
        $model->user_id = $user_id != null ? $user_id : Yii::app()->user->id;
        $model->create_date = date('Y-m-d H:i:s');
        $model->save();
    }
}

public function getLogregister($model)
{
    if ($model != null) {
        $modelLogRegister = LogRegister::model()->findByAttributes(array('user_id'=>$model->id));

        if (empty($modelLogRegister)) {
           $LogRegister = new LogRegister;
           $LogRegister->firstname = $model->profile->firstname;
           $LogRegister->lastname = $model->profile->lastname;
           $LogRegister->register_date = $model->create_at;
           $LogRegister->position_id = $model->position_id;
           $LogRegister->confirm_date = date("Y-m-d H:i:s");
           $LogRegister->confirm_user = Yii::app()->user->id;
           $LogRegister->create_date = date("Y-m-d H:i:s");
           $LogRegister->create_by = Yii::app()->user->id;
           $LogRegister->user_id = $model->id;
           $LogRegister->save();
        }
    }
}

public function getLogapprove($model)
{
    if ($model != null) {
        $modelLogApprove = LogApprove::model()->findByAttributes(array('user_id'=> $model->id));
        
        if (empty($modelLogApprove)) {
           $LogApprove = new LogApprove;
           $LogApprove->firstname = $model->profile->firstname;
           $LogApprove->lastname = $model->profile->lastname;
           $LogApprove->register_date = $model->create_at;
           $LogApprove->position_id = $model->position_id;
           $LogApprove->confirm_date = date("Y-m-d H:i:s");
           $LogApprove->confirm_user = Yii::app()->user->id;
           $LogApprove->create_date = date("Y-m-d H:i:s");
           $LogApprove->create_by = Yii::app()->user->id;
           $LogApprove->user_id = $model->id;
           $LogApprove->save();
        }
    }
}

public function getLogapprovePersonal($model)
{
    if ($model != null) {
        $modelLogApprovePersonal = LogApprovePersonal::model()->findByAttributes(array('user_id'=> $model->id));
       
        if (empty($modelLogApprovePersonal)) {

           $LogApprove = new LogApprovePersonal;
           $LogApprove->firstname = $model->profile->firstname;
           $LogApprove->lastname = $model->profile->lastname;
           $LogApprove->register_date = $model->create_at;
           $LogApprove->confirm_date = date("Y-m-d H:i:s");
           $LogApprove->confirm_user = Yii::app()->user->id;
           $LogApprove->create_date = date("Y-m-d H:i:s");
           $LogApprove->create_by = Yii::app()->user->id;
           $LogApprove->user_id = $model->id;
           $LogApprove->save();
       }
    }
}

public function changeNameFunction($name)
{
    switch ($name){
        case 'create':
        $text = 'เพิ่ม';
        break;
        case 'update':
        $text = 'แก้ไข';
        break;
        case 'Update':
        $text = 'แก้ไข';
        break;
        case 'UpdateRefresh':
        $text = 'แก้ไขหลักสูตรแนะนำ';
        break;
        case 'createrefresh':
        $text = 'เพิ่มหลักสูตรแนะนำ';
        break;
        case 'excel':
        $text = 'นำเข้าไฟล์ excel';
        break;
        case 'savePriority':
        $text = 'จัดเรียงเนื้อหา';
        break;
        case 'display':
        $text = 'เปิด/ปิดแสดงผล';
        break;
        case 'savecoursemodal':
        $text = 'แก้ไขหลักสูตรผู้เรียน';
        break;
        case 'saveDate':
        $text = 'บันทึกเวลาสิ้นสุดการเรียนผู้เรียน';
        break;
        case 'click':
        $text = 'เตะ';
        break;
        case 'editcourse_teacher':
        $text = 'แก้ไขแบบสอบถามหลักสูตร';
        break;
        case 'login':
        $text = 'เข้าสู่ระบบ';
        break;
        case 'approvebeforeexams':
        $text = 'อนุมัติผลการเรียน';
        break;
        case 'deletes':
        $text = 'ลบ';
        break;
        case 'MultiDelete':
        $text = 'ลบ';
        break;
        case 'delete':
        $text = 'ลบ';
        break;
        case 'ResetPassword':
        $text = 'รีเซ็ตรหัสผ่าน';
        break;
        case 'settingRegis':
        $text = 'ตั้งค่าการลงทะเบียน';
        break;
        case 'answermessagereturn':
        $text = 'ตอบคำถาม';
        break;
        case 'UpdateNews':
        $text = 'แก้ไข';
        break;
        case 'delImg':
        $text = 'ลบรูปภาพ';
        break;
        case 'Profile':
        $text = 'แก้ไขโปรไฟล์ส่วนตัว';
        break;
        case 'EmailSendRegisCourse':
        $text = 'แจ้งเตือน รายงานสมัครเรียนหลักสูตร';
        break;
        case 'sort':
        $text = 'จัดเรียง';
        break;
        case 'deleteRefresh':
        $text = 'ลบหลักสูตรแนะนำ';
        break;

        case 'user':
        $text = 'ข้อมูลสมาชิก';
        break;
        case 'lesson':
        $text = 'ระบบบทเรียน';
        break;
        case 'courseOnline':
        $text = 'หลักสูตร';
        break;
        case 'courseonline':
        $text = 'หลักสูตร';
        break;
        case 'adminUser':
        $text = 'ข้อมูลผู้ดูแลระบบ';
        break;
        case 'configCamera':
        $text = 'ตั้งค่าแคปช่า';
        break;
        case 'filePdf':
        $text = 'เนื้อหา PDF';
        break;
        case 'authCourseName':
        $text = 'สิทธิ์ผู้เรียนหลักสูตร';
        break;
        case 'authcoursename':
        $text = 'สิทธิ์ผู้เรียนหลักสูตร';
        break;
        case 'clickUsers':
        $text = 'Kick Users';
        break;
        case 'grouptesting':
        $text = 'ระบบชุดข้อสอบบทเรียน';
        break;
        case 'questionnaire':
        $text = 'ระบบแบบประเมิน';
        break;
        case 'certificate':
        $text = 'ระบบประกาศนียบัตร';
        break;
        case 'signature':
        $text = 'ระบบลายเซ็นต์';
        break;
        case 'configCaptcha':
        $text = 'ตั้งค่าแคปช่า';
        break;
        case 'adminuser':
        $text = 'ข้อมูลผู้ดูแลระบบ';
        break;
        case 'approve':
        $text = 'ตรวจสอบผู้เรียน';
        break;
        case 'privatemessage':
        $text = 'ข้อความส่วนตัว';
        break;
        case 'coursegrouptesting':
        $text = 'ระบบชุดข้อสอบหลักสูตร';
        break;
        case 'file':
        $text = 'จัดการวิดีโอ';
        break;
        case 'courseGrouptesting':
        $text = 'ระบบชุดข้อสอบหลักสูตร';
        break;
        case 'courseOnlineRefresh':
        $text = 'หลักสูตรแนะนำ';
        break;
        case 'teacher':
        $text = 'ระบบรายชื่อวิทยากร';
        break;
        case 'configcaptcha':
        $text = 'ตั้งค่าแคปช่า';
        break;
        case 'category':
        $text = 'ระบบหมวดหลักสูตร';
        break;
        case 'news':
        $text = 'ระบบข่าวประกาศ';
        break;
        case 'questionnaireout':
        $text = 'ระบบแบบสอบถาม';
        break;
        case 'coursenotification':
        $text = 'ระบบแจ้งเตือนบนเรียน';
        break;
         case 'courseNotification':
        $text = 'ระบบแจ้งเตือนบนเรียน';
        break;
         case 'generation':
        $text = 'ระบบรุ่น';
        break;
         case 'orgchart':
        $text = 'ระดับชั้นการเรียน (Organization)';
        break;
        case 'imgslide':
        $text = 'ป้ายประชาสัมพันธ์';
        break;
        case 'vdo':
        $text = 'ระบบ VDO';
        break;
        case 'document':
        $text = 'ระบบเอกสาร';
        break;
        case 'faq':
        $text = 'ระบบคำถามที่พบบ่อย';
        break;
        case 'faqtype':
        $text = 'ระบบหมวดคำถาม';
        break;
        case 'usability':
        $text = 'ระบบวิธีการใช้งาน';
        break;
        case 'featuredlinks':
        $text = 'ระบบจัดการลิงค์แนะนำ';
        break;
        case 'position':
        $text = 'จัดการตำแหน่ง';
        break;
        case 'division':
        $text = 'กลุ่มงาน';
        break;
        case 'company':
        $text = 'หน่วยงาน';
        break;
        case 'reset':
        $text = 'ระบบรีเซ็ท';
        break;
        case 'popUp':
        $text = 'ระบบจัดการป๊อปอัพ';
        break;
        case 'contactus':
        $text = 'ติดต่อเรา';
        break;
        case 'conditions':
        $text = 'ระบบเงื่อนไขการใช้งาน';
        break;
        case 'about':
        $text = 'ระบบเกี่ยวกับเรา';
        break;
        case 'setting':
        $text = 'ตั้งค่าระบบพื้นฐาน';
        break;
        case 'saveresetexam':
        $text = 'บันทึกรีเซ็ทสอบ';
        break;
        case 'saveresetlearn':
        $text = 'บันทึกรีเซ็ทเรียน';
        break;
        case 'index':
        $text = 'หน้าหลัก';
        break;
        case 'saveorgchart':
        $text = 'บันทึกระดับชั้นการเรียน';
        break;
        case 'createtype':
        $text = 'บันทึกเอกสาร';
        break;
        case 'deletetype':
        $text = 'ลบเอกสาร';
        break;
        case 'update_type':
        $text = 'แก้ไขเอกสาร';
        break;
        case 'course':
        $text = 'หลักสูตร';
        break;
        case 'detail':
        $text = 'รายละเอียด';
        break;
        case 'courselearn':
        $text = 'หน้าเรียน';
        break;
        default:
        $text = $name;
    }
    return $text;
}

public function changeLink($link)
{

    if (strpos($link, 'user/admin/deletes') !== false) {
        $link = str_replace('user/admin/deletes','user/admin/admin',$link);
    } else if (strpos($link, 'authcoursename/savecoursemodal') !== false) {
        $link = str_replace('authcoursename/savecoursemodal','authCourseName/index',$link);
    } else if (strpos($link, 'authCourseName/saveDate') !== false) {
        $link = str_replace('authCourseName/saveDate','authCourseName/index',$link);
    } else if (strpos($link, 'privatemessage/answermessagereturn') !== false) {
        $link = str_replace('privatemessage/answermessagereturn','privatemessage/answermessage',$link);
    } else if (strpos($link, 'clickUsers/click') !== false) {
        $link = str_replace('clickUsers/click','ClickUsers/index',$link);
    } else if (strpos($link, 'filePdf/savePriority') !== false) {
        $link = str_replace('filePdf/savePriority','File/sortvdo',$link);
    } else if (strpos($link, 'file/savePriority') !== false) {
        $link = str_replace('file/savePriority','File/sortvdo',$link);
    } else if (strpos($link, 'lesson/display') !== false) {
        $link = str_replace('lesson/display','lesson/index',$link);
    } else if (strpos($link, 'approve/approvebeforeexams') !== false) {
        $link = str_replace('approve/approvebeforeexams','approve/index',$link);
    } else if (strpos($link, 'user/admin/ResetPassword') !== false) {
        $link = str_replace('user/admin/ResetPassword','user/admin',$link);
    } else if (strpos($link, 'courseGrouptesting/delete') !== false) {
        $link = str_replace('courseGrouptesting/delete','Coursegrouptesting/index',$link);
    } else if (strpos($link, 'grouptesting/delete') !== false) {
        $link = str_replace('grouptesting/delete','Grouptesting/index',$link);
    } else if (strpos($link, 'courseOnline/delImg') !== false) {
        $link = str_replace('courseOnline/delImg','CourseOnline/index',$link);
    }
    return $link;
}
    public function PeriodDate($dateStart,$full){
        $date = explode('-', $dateStart);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        $day = explode(' ', $day);
        $days = $day[0];
        switch ($month) {
                case '01':
                    $month = 'Jan';
                    break;
                case '02':
                    $month = 'Feb';
                    break;
                case '03':
                    $month = 'Mar';
                    break;
                case '04':
                    $month = 'Apr';
                    break;
                case '05':
                    $month = 'May';
                    break;
                case '06':
                    $month = 'Jun';
                    break;
                case '07':
                    $month = 'Jul';
                    break;
                case '08':
                    $month = 'Aug';
                    break;
                case '09':
                    $month = 'Sep';
                    break;
                case '10':
                    $month = 'Oct';
                    break;
                case '11':
                    $month = 'Nov';
                    break;
                case '12':
                    $month = 'Dec';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            if($full){
                return $strDate = $days." ".$month." ".$year;
            }else{
                return $strDate = $days." ".$month;
            }
            

    }

    public function SendMailNotification($to, $subject, $message, $fromText = 'E-Learning System Thoresen'){
        require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/Exception.php";
        require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/PHPMailer.php";
        require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/SMTP.php";

        $SettingAll = Helpers::lib()->SetUpSetting();
        $adminEmail = $SettingAll['USER_EMAIL'];
        $adminEmailPass = $SettingAll['PASS_EMAIL'];

        $adminEmail = 'thoresen.elearning@gmail.com';
        $adminEmailPass = 'lms@2020';

        $mail =  new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
        );
        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        //$mail->Host = '172.30.110.16'; // gmail server
        //$mail->Port = 25; // port number
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587'; // port number
        $mail->SMTPSecure = "tls";
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        // $mail->SMTPDebug  = 1;
        $mail->From = 'mailerbws@gmail.com';
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $fromText = 'E-Learning System Thoresen';
        $mail->SetFrom($adminEmail, $fromText);
        $mail->AddAddress($to['email'],'คุณ' . $to['firstname'] . ' ' . $to['lastname']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);
        $mail->Send();
    }

    public function SendMailNotification2($subject,$message,$depart_id){

            require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/Exception.php";
            require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/PHPMailer.php";
            require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/SMTP.php";

            $address = Users::model()->findAll(array(
                'condition'=>'department_id='.$depart_id,
            ));

            if($address){
                $SettingAll = Helpers::lib()->SetUpSetting();
                $adminEmail = $SettingAll['USER_EMAIL'];
                $adminEmailPass = $SettingAll['PASS_EMAIL'];

                $adminEmail = 'thoresen.elearning@gmail.com';
                $adminEmailPass = 'lms@2020';

                $mail =  new PHPMailer(true);
                $mail->ClearAddresses();
                $mail->CharSet = 'utf-8';
                
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = '587'; // port number

            // $mail->Host = '172.30.110.16'; // gmail server
            // $mail->Port = 25; // port number
            $mail->SMTPKeepAlive = true;
            $mail->Mailer = "smtp";
            // $mail->SMTPDebug  = 1;
            $mail->From = 'mailerbws@gmail.com';
            $mail->Username = $adminEmail;
            $mail->Password = $adminEmailPass;
            $fromText = 'E-Learning System Thoresen';
            $mail->SetFrom($adminEmail, $fromText);

            foreach($address as $data_email){
                $mail->AddAddress($data_email->email,'คุณ' . $data_email->profiles->firstname . ' ' . $data_email->profiles->lastname);
            }
            
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->IsHTML(true);
            $mail->Send();

        }

    }

    public function _insertLdap($member){
        if(!empty($member[0]['st'][0])){
            $modelStation = Station::model()->findByAttributes(array('station_title'=>($member[0]['st'][0])));
            if(!$modelStation){
                $modelStation = new Station;
                $modelStation->station_title = $member[0]['st'][0];
                $modelStation->lang_id = 1;
                $modelStation->active = 'y';
                $modelStation->parent_id = 0;
                $modelStation->save();
            }
        }
        
        if(!empty($member[0]['department'][0])){
              $modelDepartment = Department::model()->findByAttributes(array('dep_title'=>($member[0]['department'][0])));
            if(!$modelDepartment){
                $modelDepartment = new Department;
                $modelDepartment->dep_title = $member[0]['department'][0];
                $modelDepartment->active = 'y';
                $modelDepartment->lang_id = 1;
                $modelDepartment->parent_id = 0;
                $modelDepartment->save();
            }  
        }
        
        if(!empty($member[0]['division'][0])){
                $modelDivision = Division::model()->findByAttributes(array('div_title'=>($member[0]['division'][0])));
            if(!$modelDivision){
                $modelDivision = new Division;
                $modelDivision->div_title = $member[0]['division'][0];
                $modelDivision->active = 'y';
                $modelDivision->lang_id = 1;
                $modelDivision->parent_id = 0;
                $modelDivision->save();
            }
        }
        
    }












    public static function checkHaveCoursePreTestInManage($course_id)
    { // เช็ค ข้อสอบ ก่อนเรียน หลักสูตร
        $isExamAddToCourseForTest = Coursemanage::model()->with('group')->findAll("id = '" . $course_id . "' AND type = 'pre' AND manage.active='y' AND group.active ='y'");
        if (!$isExamAddToCourseForTest) {
            return false;
        }else{
            return true;
        }
    }

    public static function checkHaveCourseTestInManage($course_id)
    { // เช็ค ข้อสอบ final หลักสูตร
        $isExamAddToCourseForTest = Coursemanage::model()->with('group')->findAll("id = '" . $course_id . "' AND type = 'course' AND manage.active='y' AND group.active ='y'");
        if (!$isExamAddToCourseForTest) {
            return false;
        }else{
            return true;
        }
    }

    public static function checkHaveScoreCoursePreTest($course_id, $gen_id=null, $user_id){ 
     // // เช็คว่าสอบไปยัง      ข้อสอบ ก่อนเรียน หลักสูตร
        if($gen_id == null){
             $course_model = CourseOnline::model()->findByPk($course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);
        }

        $Course_Score = Coursescore::model()->find(array(
            'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND type=:type AND active=:active',
            'params' => array(':type'=>'pre', ':course_id'=>$course_id, ':gen_id'=>$gen_id, ':user_id'=>$user_id, ':active'=>'y')
        ));

        if($Course_Score == ""){ // ไม่มีคะแนนสอบ
            return true; //ยังไม่สอบ
        }else{
            return false;
        }
    }

    public function checkLessonFile_lear($file,$learn_id, $gen_id=null, $user_id)
    {
        // $user = Yii::app()->getModule('user')->user();

        $user = User::model()->findByPk($user_id);


        $learn_model = Learn::model()->findByPk($learn_id);
        if($learn_model != null){
            if($gen_id == null){                        
                $gen_id = $learn_model->LessonMapper->CourseOnlines->getGenID($learn_model->LessonMapper->course_id);
            }
        }
        $learnFiles = $user->learnFiles(
            array(
                'condition' => 'file_id=:file_id AND learns.learn_id=:learn_id AND lesson_active=:status AND learns.gen_id=:gen_id',
                'params' => array(':file_id' => $file->id,':learn_id'=>$learn_id,':status'=>'y', ':gen_id'=>$gen_id)
            )
        );
        if ($learnFiles) {
            if ($learnFiles[0]->learn_file_status != 's') {
                return "learning";
            } else {
                return "pass";
            }
        } else {
            return "notLearn";
        }
    }


    public function percent_CourseGen($course_id, $gen_id, $user_id){ // คำนวน % ของหลักสูตร ที่เรียนไป
            // สอบก่อนเรียนของบทเรียน จำนวนวิดีโอ สอบหลังเรียนของบทเรียน สอบfinalของหลักสูตร

            $course = CourseOnline::model()->find(array(
                'condition' => 'course_id=:course_id AND active=:active',
                'params' => array(':course_id'=>$course_id, ':active'=>'y'),
            ));
            $lesson = Lesson::model()->findAll(array(
                'condition' => 'course_id=:course_id AND active=:active',
                'params' => array(':course_id'=>$course_id, ':active'=>'y'),
            ));

            $num_step = 0; // สอบก่อนเรียน วิดีโอ สอบหลังเรียน สอบ final
            $step_pass = 0; // step ที่ผ่าน
            foreach ($lesson as $key => $lessonListValue) {
                $checkPreTest = Helpers::checkHavePreTestInManage($lessonListValue->id);
                if ($checkPreTest) { 
                    $num_step++; 
                    $score_pre = Score::model()->find(array(
                        'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND lesson_id=:lesson_id AND active=:active AND type=:type',
                        'params' => array(':course_id'=>$course->course_id, ':gen_id'=>$gen_id, ':user_id'=>$user_id, ':lesson_id'=>$lessonListValue->id, ':active'=>'y', ':type'=>'pre'),
                    ));
                    if($score_pre != ""){
                        $step_pass++;
                    }
                }
                $checkPostTest = Helpers::checkHavePostTestInManage($lessonListValue->id);
                if ($checkPostTest) { 
                    $num_step++; 
                    $score_post = Score::model()->find(array( // หลังเรียน ต้องผ่าน
                        'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND lesson_id=:lesson_id AND active=:active AND type=:type AND score_past=:score_past',
                        'params' => array(':course_id'=>$course->course_id, ':gen_id'=>$gen_id, ':user_id'=>$user_id, ':lesson_id'=>$lessonListValue->id, ':active'=>'y', ':type'=>'post', ':score_past'=>'y'),
                    ));
                    if($score_post != ""){
                        $step_pass++;
                    }
                }
                if($lessonListValue->type == 'vdo' || $lessonListValue->type == 'youtube'){
                    foreach ($lessonListValue->files as $les) { // วนไฟล์ วิดีโอ
                        $num_step++;
                        $learnModel = Learn::model()->find(array(
                            'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                            'params'=>array(':lesson_id'=>$lessonListValue->id,':user_id'=>$user_id,':status'=>'y', ':gen_id'=>$gen_id)
                        ));
                        $learnFiles = self::lib()->checkLessonFile_lear($les,$learnModel->learn_id, $gen_id, $user_id);
                        if($learnFiles == 'pass'){
                            $step_pass++;
                        }
                    }
                }elseif($lessonListValue->type == 'pdf'){
                    foreach ($lessonListValue->filePdf as $les) { // วนไฟล์ pdf
                        $num_step++;
                        $learnModel = Learn::model()->find(array(
                            'condition'=>'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                            'params'=>array(':lesson_id'=>$lessonListValue->id,':user_id'=>$user_id,':status'=>'y', ':gen_id'=>$gen_id)
                        ));
                        $learnFiles = self::lib()->checkLessonFile_lear($les,$learnModel->learn_id, $gen_id, $user_id);
                        if($learnFiles == 'pass'){
                            $step_pass++;
                        }
                    }
                }
            }
            $checkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
            if ($checkHaveCourseTest) { // สอบ final
                $num_step++; 
                $score_final = Coursescore::model()->find(array( // หลังเรียน ต้องผ่าน
                    'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND score_past=:score_past AND active=:active AND type=:type',
                    'params' => array(':course_id'=>$course->course_id, ':gen_id'=>$gen_id, ':user_id'=>$user_id, ':score_past'=>'y', ':active'=>'y', ':type'=>"post"),
                ));
                if($score_final != ""){
                    $step_pass++;
                }
            } 

             $checkHaveCoursePreTest = Helpers::lib()->checkHaveCoursePreTestInManage($course->course_id);
            if($checkHaveCoursePreTest){ // สอบ ก่อนเรียน course
                 $num_step++; 
                 $checkHaveScoreCoursePreTest = Helpers::lib()->checkHaveScoreCoursePreTest($course->course_id, $gen_id, $user_id);
                 if(!$checkHaveScoreCoursePreTest){
                    $step_pass++;
                 }
            }

            $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
            if($CourseSurvey){ // มี แบบสอบถาม
                foreach ($CourseSurvey as $key => $value) {
                     $num_step++; 
                     $passQuest = QQuestAns_course::model()->find(array(
                        'condition' => 'user_id = "' . $user_id . '" AND course_id ="' . $course->course_id . '"'." AND gen_id='".$gen_id."'",
                    ));
                     if ($passQuest) { //ตอบแบบสอบถามแล้ว
                        $step_pass++;
                     }
                 }
             }


            if($num_step != 0){
                $percent_average = 100/$num_step; // % แต่ละ step
            }
            $percent_pass = 0;
            if($step_pass != 0){
                $percent_pass = $step_pass*$percent_average;
            }


            // var_dump($num_step);
            // var_dump($step_pass);
            // exit();

            return round($percent_pass, 2);
        }  

        public function chk_status_course($course_id, $gen_id, $user_id){ // เช็คสถานะ course ถ้ามี passcourse ก็ผ่านแล้ว ประมาณนี้

            $passcourse = Passcours::model()->find("passcours_cours='".$course_id."' AND passcours_user='".$user_id."' AND gen_id='".$gen_id."' ");
            if($passcourse != ""){
                $statusLearn = "pass";
            }else{
                $statusLearn = Learn::model()->findAll(array(
                    'condition' => 'user_id ="'.$user_id.'" and course_id ="'. $course_id .'" AND gen_id="'.$gen_id.'" AND lesson_active="y"' ,
                ));
                if(!empty($statusLearn)){
                    $statusLearn = "learning";
                }else{
                    $statusLearn = "notlearn"; 
                }
            }

            return $statusLearn;
        } 

        public function chk_status_lesson($lesson_id, $gen_id, $user_id){ // เช็คสถานะ แต่ละบทเรียน ถ้ามี passcourse ก็ผ่านแล้ว ประมาณนี้

            $statusLearn = Learn::model()->find(array(
                'condition' => 'user_id ="'.$user_id.'" and lesson_id ="'. $lesson_id .'" AND gen_id="'.$gen_id.'" AND lesson_active="y"' ,
            ));

            if($statusLearn->lesson_status == "pass"){
                $statusLearn = "pass";
            }else{
                $statusLearn = "learning";
            }
            // elseif($statusLearn->lesson_status == "learning"){
            //     $statusLearn = "learning";
            // }
           

            return $statusLearn;
        }


        //New Report By P'Pee
        public function query_report_training($report, $course_id, $lesson_id=null){

            $report["course"] = $course_id;
            
            $criteria = new CDbCriteria;
            $criteria->with = array('course', 'user', 'user.profile');
            $criteria->select = 't.course_id, t.user_id, t.id, t.create_date';
            $criteria->compare('courseonline.active', "y");

            // if($report["category"] != ""){        
            //     $criteria->compare('courseonline.cate_id', $report["category"]);
            // }

            // if($report["course"] != ""){        
            //     $criteria->compare('courseonline.course_id', $report["course"]);
            // }


            if($report["name"] != ""){
                $criteria->compare('concat(profile.firstname," ",profile.lastname," ",profile.firstname_en," ",profile.lastname_en)',$report["name"],true);
                $model_result = LogStartcourse::model()->findAll($criteria);
                // var_dump($model_result);exit();

            }

            if($report["training_status"] != ""){
                $arr_user_pass = []; // คนที่เรียน pass แล้ว
                $arr_user_learning = []; // คนที่กำลังเรียน

                $arr_log_start_course = []; // id log start course ที่สมัครเข้ามา        
                $arr_user_coursescore = []; // คนที่สอบ pre course
                $arr_user_score = []; // คนที่สอบ pre lesson
                $arr_user_learn = []; // คนที่เรียน learn แล้ว

                $log_start_course = LogStartcourse::model()->findAll(array(
                    'select'=>'id, user_id',
                    'condition'=>'course_id="'.$report["course"].'" AND active="y" ',
                    'order'=>'id DESC',
                    'group'=>'user_id'
                ));        
                foreach ($log_start_course as $key => $value) {
                    $arr_log_start_course[] = $value->id;
                }

                if(!empty($arr_log_start_course)){
                    $sql_logstartcourse = " AND startcourse_id IN (" . implode(',', $arr_log_start_course) . ")";
                }else{
                    $sql_logstartcourse = "";
                }

                ////////////////////////////////

                $header_id = Helpers::lib()->chk_course_questionnaire($report["course"]); // มีแบบสอบถามไหม

                $Passcours = Passcours::model()->findAll(array(
                    'select'=>' passcours_user',
                    'condition'=>'passcours_cours="'.$report["course"].'" ',
                    'order'=>'passcours_id DESC',
                    'group'=>'passcours_user'
                )); 

                foreach ($Passcours as $key => $value) {
                    if($header_id != null){
                        if(Helpers::lib()->chk_course_questionnaire_do($header_id, $report["course"], $value->passcours_user, "")){
                            // ทำแบบสอบถามแล้ว
                            $arr_user_pass[] = $value->passcours_user;
                        }
                    }else{
                        $arr_user_pass[] = $value->passcours_user;
                    }
                }

                if($report["training_status"] == 4){ // pass
                    $criteria->addIncondition('t.user_id', $arr_user_pass);                  
                }else{
                    // notstart    learning

                    $course['course_id'] = $report["course"];

                    $score_course = Coursescore::model()->findAll(array(
                        'select'=>'user_id',
                        'condition'=>"active='y' AND type='pre' AND course_id='".$course['course_id']."' ".$sql_logstartcourse." ",
                        'group'=>'user_id'

                    ));
                    foreach ($score_course as $key => $value) {
                        $arr_user_coursescore[] = $value->user_id;
                    }

                    $score_lesson = Score::model()->findAll(array(
                        'select'=>'user_id',
                        'condition'=>"active='y' AND type='pre' AND course_id='".$course['course_id']."'  ".$sql_logstartcourse." ",
                        'group'=>'user_id'
                    ));
                    foreach ($score_lesson as $key => $value) {
                        $arr_user_score[] = $value->user_id;
                    }

                    $arr_user_learning = array_merge($arr_user_coursescore, $arr_user_score);
                    $arr_user_learning = array_unique($arr_user_learning);

                    $statusLearn = Learn::model()->findAll(array(
                        'select'=>'user_id',
                        'condition' => 'course_id ="'. $course['course_id'] .'"' . $sql_logstartcourse,
                        'group'=>'user_id'                
                    ));
                    foreach ($statusLearn as $key => $value) {
                        $arr_user_learn[] = $value->user_id;
                    }

                    $arr_user_learning = array_merge($arr_user_learning, $arr_user_learn);
                    $arr_user_learning = array_unique($arr_user_learning);


                    if($report["training_status"] == 1){ // notstart
                        $criteria->addNotIncondition('t.user_id', $arr_user_pass);    
                        $criteria->addNotIncondition('t.user_id', $arr_user_learning);    
                    }elseif($report["training_status"] == 2){ // learning
                        $criteria->addIncondition('t.user_id', $arr_user_learning);    
                        $criteria->addNotIncondition('t.user_id', $arr_user_pass);    
                    }
                }

            }

            if($report["start_date"] != "" && $report["end_date"] != ""){
                $criteria->addCondition("t.create_date>='".$report["start_date"]." 00:00:00"."'");
                $criteria->addCondition("t.create_date<='".$report["end_date"]." 23:59:59"."'");
            }

            $criteria->order = "profile.firstname_en ASC";
            $criteria->group = "t.user_id";
            $model_result = LogStartcourse::model()->findAll($criteria);
            $model_count = count($model_result);


            return $model_result;
        }

        public function chk_course_questionnaire($course_id){ // เช็คว่าหลักสูตรมีแบบสอบถามไหม return id header arr
            $header_id = null; // ไม่มีแบบสอบถาม
            $CourseTeacher = CourseTeacher::model()->findAll(array(
                'select'=>'survey_header_id',
                'condition'=>'course_id="'.$course_id.'" ',
                'order'=>'id DESC'
            ));
            if(!empty($CourseTeacher)){
                foreach ($CourseTeacher as $key => $value_t) {
                    $QHeader = QHeader::model()->findAll(array(
                        'select'=>'survey_header_id',
                        'condition'=>'survey_header_id="'.$value_t->survey_header_id.'" AND active="y" '
                    ));
                    if($QHeader){
                        foreach ($QHeader as $key => $value) {
                            $header_id = $value->survey_header_id; // มีแบบสอบถาม
                        }                    
                    }
                }
            }
            return $header_id;
        }


        public function chk_course_questionnaire_do($header_id, $course_id, $user_id, $startcourse_id){ // เช็คว่าทำแบบสอบถาม รึยัง

            // if($startcourse_id == null){
            //     $startcourse_id = Helpers::lib()->chk_logstartcourse($course_id);
            // }

            $status = false;

            $QQuestAns_course = QQuestAnsCourse::model()->find(array(
                'select'=>'id',
                'condition'=>'user_id="'.$user_id.'" AND course_id="'.$course_id.'" AND header_id="'.$header_id.'" '
            ));
            if($QQuestAns_course){
                $status = true; // ทำแบบสอบถามแล้ว
            }
            return $status;
        }

        public function checkLessonFile_learn_id($file ,$learn_id, $user_id)
        {
                        // $user = Yii::app()->getModule('user')->user();
                            /*$learnFiles = $user->learnFiles(
                                array(
                                    'condition' => 'file_id=:file_id',
                                    'params' => array(':file_id' => $file->id)
                                    )
                                );*/
                                //var_dump($user);exit();

                                $user = User::model()->findByPk($user_id);


                                $learnFiles = $user->learnFiles(
                                    array(
                                        'condition' => 'file_id=:file_id AND learns.learn_id=:learn_id AND learns.active=:status',
                                        'params' => array(':file_id' => $file->id,':learn_id'=>$learn_id,':status'=>'y')
                                    )
                                );
                                if ($learnFiles) {
                                    if ($learnFiles[0]->learn_file_status != 's') {
                                        return "learning";
                                    } else {
                                        return "pass";
                                    }
                                } else {
                                    return "notLearn";
                                }
        }//end function 

}
