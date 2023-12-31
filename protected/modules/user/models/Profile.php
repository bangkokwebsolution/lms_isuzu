<?php

class Profile extends CActiveRecord {

    /**
     * The followings are the available columns in table 'profiles':
     * @var integer $user_id
     * @var boolean $regMode
     */
    public $regMode = false;
    private $_model;
    private $_modelReg;
    private $_rules = array();
    public $file_user;
    public $id;

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{profiles}}';
    }

    public function getNameUser($id = null) {
        $model = Profile::model()->findByPk($id);
        return $model->firstname;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array(
            // array('title_id, firstname, lastname, identification', 'required'),
            array('firstname, lastname', 'required'),
            array('age', 'numerical', 'integerOnly' => true),
            array('tel', 'numerical', 'integerOnly' => true),
            array('identification', 'numerical', 'integerOnly' => true),
            array('fax', 'numerical', 'integerOnly' => true),
            array('phone, number_of_children', 'numerical', 'integerOnly' => true),
           // array('tel', 'length', 'min' => 9),
            array('bussiness_model_id,bussiness_type_id,company,juristic,title_id, type_user, education, occupation, position, website, province, tel, phone, fax, advisor_email1, advisor_email2, generation, file,department, passport, date_of_expiry, race, nationality, religion, line_id, ship_id, ship_up_date, ship_down_date, address2, phone1, phone2, phone3, seamanbook, seaman_expire, pass_expire, ss_card,firstname_en,lastname_en, tax_payer, place_of_birth, hight, weight, hair_color, eye_color, place_issued, blood, spouse_firstname, spouse_lastname, father_firstname, father_lastname, mother_firstname, mother_lastname, military, sickness, start_working, occupation_spouse, occupation_father, occupation_mother, address_parent, mouth_birth, passport_place_issued, passport_date_issued, name_emergency, relationship_emergency', 'length', 'max' => 255),
            array('firstname, lastname, expected_salary', 'length', 'max' => 50),
            // array('firstname, lastname', 'match', 'pattern'=>'/^[ก-๏\s]+$/','message' => 'กรอกข้อมูลภาษาไทยเท่านั้น'),
            // array('firstname_en, lastname_en', 'match', 'pattern'=>'/^[a-zA-Z]+$/','message' => 'Fill out information in English only.'),
            array('identification', 'length', 'max'=>13),
            // array('identification', 'length', 'min'=>13),
            array('sex, history_of_illness, status_sm, type_employee,type_card', 'length', 'max' => 6),
            array('accommodation', 'length', 'max' => 20),
           // array('passport', 'length', 'max' => 10),
            array('date_issued', 'safe'),
           //  array('identification', 'validateIdCard'),
           // array('identification', 'unique', 'message' => 'เลขบัตรประชาชนนี้มีในระบบแล้ว'),
            array('identification', 'length', 'max' => 13,'min'=>13),
            // array('identification', 'unique',
            //      'criteria' => array(
            //          'with' => 'user',
            //          'condition' => 'del_status= :del_status',
            //          'params' => array(':del_status' => 0))
            //  , 'message' => UserModule::t("identification_unique"),'on' => array('idcard')),         
            // The following rule is used by search(). 
            // Please remove those attributes that should not be searched. 
            array('bussiness_model_id,bussiness_type_id,company,juristic,user_id, title_id, firstname, lastname, active, generation, type_user, sex, birthday, age, education, occupation, position, website, address, province, tel, phone, fax, contactfrom, advisor_email1, advisor_email2, file, passport, date_of_expiry, race, nationality, religion, history_of_illness, status_sm, type_employee, type_card, line_id, seamanbook, seaman_expire, pass_expire, ss_card,firstname_en,lastname_en, tax_payer, place_of_birth, hight, weight, hair_color, eye_color, place_issued, blood, spouse_firstname, spouse_lastname, father_firstname, father_lastname, mother_firstname, mother_lastname, military, sickness, expected_salary, start_working, accommodation, date_issued, number_of_children, occupation_spouse, occupation_father, occupation_mother, address_parent, passport_date_issued, passport_place_issued, name_emergency, relationship_emergency', 'safe', 'on' => 'search'),
            array('file_user', 'file', 'types' => 'pdf', 'allowEmpty' => true, 'on' => 'insert'),
           // array('ship_id, ship_up_date, ship_down_date, address2, phone1, phone2, phone3', 'allowEmpty' => true, 'on' => 'update'),
            array('file_user', 'file', 'types' => 'pdf',
                'wrongType' => 'รองรับไฟล์ pdf เท่านั้น', 'allowEmpty' => true, // ข้อความเตือน
                'maxSize' => 1024 * 1024 * 5, // 5 MB
                'tooLarge' => 'ขนาดไฟล์ไม่เกิน 5MB' // ขนาดไฟล์
            ),
        );

        // if (!$this->_rules) {
        // 	$required = array();
        // 	$numerical = array();
        // 	$float = array();		
        // 	$decimal = array();
        // 	$rules = array();
        // 	$model=$this->getFields();
        // 	foreach ($model as $field) {
        // 		$field_rule = array();
        // 		if ($field->required==ProfileField::REQUIRED_YES_NOT_SHOW_REG||$field->required==ProfileField::REQUIRED_YES_SHOW_REG)
        // 			array_push($required,$field->varname);
        // 		if ($field->field_type=='FLOAT')
        // 			array_push($float,$field->varname);
        // 		if ($field->field_type=='DECIMAL')
        // 			array_push($decimal,$field->varname);
        // 		if ($field->field_type=='INTEGER')
        // 			array_push($numerical,$field->varname);
        // 		if ($field->field_type=='VARCHAR'||$field->field_type=='TEXT') {
        // 			$field_rule = array($field->varname, 'length', 'max'=>$field->field_size, 'min' => $field->field_size_min);
        // 			if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
        // 			array_push($rules,$field_rule);
        // 		}
        // 		if ($field->other_validator) {
        // 			if (strpos($field->other_validator,'{')===0) {
        // 				$validator = (array)CJavaScript::jsonDecode($field->other_validator);
        // 				foreach ($validator as $name=>$val) {
        // 					$field_rule = array($field->varname, $name);
        // 					$field_rule = array_merge($field_rule,(array)$validator[$name]);
        // 					if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
        // 					array_push($rules,$field_rule);
        // 				}
        // 			} else {
        // 				$field_rule = array($field->varname, $field->other_validator);
        // 				if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
        // 				array_push($rules,$field_rule);
        // 			}
        // 		} elseif ($field->field_type=='DATE') {
        // 			$field_rule = array($field->varname, 'type', 'type' => 'date', 'dateFormat' => 'yyyy-mm-dd', 'allowEmpty'=>true);
        // 			if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
        // 			array_push($rules,$field_rule);
        // 		}
        // 		if ($field->match) {
        // 			$field_rule = array($field->varname, 'match', 'pattern' => $field->match);
        // 			if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
        // 			array_push($rules,$field_rule);
        // 		}
        // 		if ($field->range) {
        // 			$field_rule = array($field->varname, 'in', 'range' => self::rangeRules($field->range));
        // 			if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
        // 			array_push($rules,$field_rule);
        // 		}
        // 	}
        // 	array_push($rules,array(implode(',',$required), 'required'));
        // 	array_push($rules,array(implode(',',$numerical), 'numerical', 'integerOnly'=>true));
        // 	array_push($rules,array(implode(',',$float), 'type', 'type'=>'float'));
        // 	array_push($rules,array(implode(',',$decimal), 'match', 'pattern' => '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'));
        // 	$this->_rules = $rules;
        // }
        // return $this->_rules;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $relations = array(
            'user' => array(self::HAS_ONE, 'User', 'id'),
            'type_name' => array(self::BELONGS_TO, 'TypeUser', 'type_user'),
            'ProfilesEdu' => array(self::BELONGS_TO, 'ProfilesEdu', 'user_id'),
            'ProfilesTitle' => array(self::BELONGS_TO, 'ProfilesTitle', 'title_id'),
            'EmpClass' => array(self::BELONGS_TO, 'employee_class', 'employee_class'),
        );
        if (isset(Yii::app()->getModule('user')->profileRelations))
            $relations = array_merge($relations, Yii::app()->getModule('user')->profileRelations);
        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => UserModule::t('User ID'),
            'title_id' => UserModule::t('Title id'),
            'firstname' => UserModule::t('First Name'),
            'lastname' => UserModule::t('Last Name'),
            'firstname_en' => 'Firstname',
            'lastname_en' => 'Lastname',
            'identification' => 'เลขบัตรประจำตัวประชาชน',
            'type_user' => UserModule::t('Type User'),
            'sex' => UserModule::t('Sex'),
            'birthday' => UserModule::t('Birthday'),
            'age' => UserModule::t('Age'),
            'education' => UserModule::t('Education'),
            'occupation' => UserModule::t('Occupation'),
            'position' => UserModule::t('Position'),
            'website' => UserModule::t('Website'),
            'address' => UserModule::t('Address'),
            'province' => 'จังหวัด',
            'tel' => UserModule::t('Tel'),
            'phone' => UserModule::t('Phone'),
            'fax' => UserModule::t('Fax'),
            'contactfrom' => UserModule::t('Contactfrom'),
            'advisor_email1' => UserModule::t('Advisor Email1'),
            'advisor_email2' => UserModule::t('Advisor Email2'),
            'file' => UserModule::t('File'),
            'bussiness_model_id' => 'รูปแบบธุรกิจ',
            'bussiness_type_id' => 'ประเภทของธุรกิจ',
            'company' => 'ชื่อหน่วยงาน/บริษัท',
            'juristic' => 'เลขทะเบียนนิติบุคคล',
            'department' => 'หน่วยงาน',
            'passport' => 'เลขหนังสือเดินทาง',
            'date_of_expiry' => 'วันที่บัตรหมดอายุ',
            'race' => 'เชื้อชาติ',
            'nationality' => 'สัญชาติ',
            'religion' => 'ศาสนา',
            'history_of_illness' => 'ประวัติเจ็บป่วยรุนแรง',
            'status_sm' => 'สถานภาพ',
            'type_employee'=> 'ประเภทพนักงาน',
            'type_card'=> 'ประเภทบัตร',
            'line_id' => 'ID Line',
            'ship_id' => 'ชื่อเรือที่ขึ้น',
            'address2' => 'ที่อยู่ปัจจุบันที่สามารถติดต่อได้',
            'ship_up_date' => 'วันที่ขึ้นจากเรือ',
            'ship_down_date'=> 'วันที่กลับไปขึ้นเรือ',
            'phone1'=> 'เบอร์โทรศัพท์ที่สามารถติดต่อได้',
            'phone2' => 'เบอร์มือถือ',
            'phone3' => 'โทรศัพท์อื่นๆที่สามารถติดต่อได้',
            'seamanbook'=> 'เลขหนังสือประจำลูกเรือ',
            'seaman_expire'=> 'วันหมดอายุ(หนังสือประจำลูกเรือ)',
            'pass_expire' => 'pass_expire',
            'ss_card' => 'บัตรประกันสังคมเลขที่',
            'tax_payer' => 'เลขที่บัตรประจำตัวผู้เสียภาษีอากร',
            'number_of_children'=>'จำนวนบุตร', 
            'place_of_birth'=>'สถานที่เกิด', 
            'hight'=>'ส่วนสูง', 
            'weight'=>'น้ำหนัก', 
            'hair_color'=>'สีผม', 
            'eye_color'=>'สีตา', 
            'place_issued'=>'สถานที่ออกบัตร',
            'date_issued'=>'วันที่ออกบัตร', 
            'blood'=>'กรุ๊ปเลือด', 
            'spouse_firstname'=>'ชื่อคู่สมรส', 
            'spouse_lastname'=>'นามสกุลคู่สมรส', 
            'father_firstname'=>'ชื่อบิดา', 
            'father_lastname'=>'นามสกุลบิดา',
            'mother_firstname'=>'ชื่อมารดา', 
            'mother_lastname'=>'นามสกุลมารดา', 
            'military'=>'สถานะการรับใช้ชาติ', 
            'sickness'=>'โรคที่เคยป่วย', 
            'expected_salary'=>'เงินเดือนที่คาดหวัง', 
            'start_working'=>'พร้อมที่จะเริ่มงานเมื่อ', 
            'accommodation'=>'ที่พัก', 
            'domicile_address'=>'ที่อยู่ตามภูมิลำเนา',
            'occupation_spouse'=>'อาชีพคู่สมรส',
            'occupation_father'=>'อาชีพบิดา',
            'occupation_mother'=>'อาชีพมารดา',
            'address_parent'=>'ที่อยู่อาศัยตามบัตรประชาชน',
            'mouth_birth'=>'เดือน',
            'passport_place_issued'=>'สถานที่ออกบัตร',
            'passport_date_issued'=>'วันที่ออกบัตร',
            'name_emergency'=>'ชือบุคคลติดต่อฉุกเฉิน',
            'relationship_emergency'=>'ความสัมพันธ์',
        );

        // $labels = array(
        // 	'user_id' => UserModule::t('User ID'),
        // );
        // $model=$this->getFields();
        // foreach ($model as $field)
        // 	$labels[$field->varname] = ((Yii::app()->getModule('user')->fieldsMessage)?UserModule::t($field->title,array(),Yii::app()->getModule('user')->fieldsMessage):UserModule::t($field->title));
        // return $labels;
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that 
        // should not be searched. 

        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('title_id', $this->title_id, true);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('firstname_en', $this->firstname_en, true);
        $criteria->compare('lastname_en', $this->lastname_en, true);
        $criteria->compare('identification', $this->identification, true);
        $criteria->compare('type_user', $this->type_user, true);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('birthday', $this->birthday, true);
        $criteria->compare('age', $this->age);
        $criteria->compare('education', $this->education, true);
        $criteria->compare('occupation', $this->occupation, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province', $this->province, true);
        $criteria->compare('tel', $this->tel, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('contactfrom', $this->contactfrom, true);
        $criteria->compare('advisor_email1', $this->advisor_email1, true);
        $criteria->compare('advisor_email2', $this->advisor_email2, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('passport', $this->passport, true);
        $criteria->compare('date_of_expiry', $this->date_of_expiry, true);
        $criteria->compare('race', $this->race, true);
        $criteria->compare('nationality', $this->nationality, true);
        $criteria->compare('religion', $this->religion, true);
        $criteria->compare('history_of_illness', $this->history_of_illness, true);
        $criteria->compare('status_sm', $this->status_sm, true);
        $criteria->compare('type_employee', $this->type_employee, true);
        $criteria->compare('type_card', $this->type_card, true);
        $criteria->compare('line_id', $this->line_id, true);
        $criteria->compare('ship_id', $this->ship_id, true);
        $criteria->compare('ship_up_date', $this->ship_up_date, true);
        $criteria->compare('ship_down_date', $this->ship_down_date, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('phone1', $this->phone1, true);
        $criteria->compare('phone2', $this->phone2, true);
        $criteria->compare('phone3', $this->phone3, true);
        $criteria->compare('seamanbook', $this->seamanbook, true);
        $criteria->compare('seaman_expire', $this->seaman_expire, true);
        $criteria->compare('pass_expire', $this->pass_expire, true);
        $criteria->compare('ss_card', $this->ss_card, true);

        $criteria->compare('tax_payer', $this->tax_payer, true);
        $criteria->compare('number_of_children', $this->number_of_children, true);
        $criteria->compare('place_of_birth', $this->place_of_birth, true); 
        $criteria->compare('hight', $this->hight, true);
        $criteria->compare('weight', $this->weight, true);
        $criteria->compare('hair_color', $this->hair_color, true);
        $criteria->compare('eye_color', $this->eye_color, true);
        $criteria->compare('place_issued', $this->place_issued, true);
        $criteria->compare('date_issued', $this->date_issued, true);
        $criteria->compare('blood', $this->blood, true);
        $criteria->compare('spouse_firstname', $this->spouse_firstname, true);
        $criteria->compare('spouse_lastname', $this->spouse_lastname, true);
        $criteria->compare('father_firstname', $this->father_firstname, true);
        $criteria->compare('father_lastname', $this->father_lastname, true);
        $criteria->compare('mother_firstname', $this->mother_firstname, true);
        $criteria->compare('mother_lastname', $this->mother_lastname, true);
        $criteria->compare('military', $this->military, true);
        $criteria->compare('sickness', $this->sickness, true);
        $criteria->compare('expected_salary', $this->expected_salary, true);
        $criteria->compare('start_working', $this->start_working, true);
        $criteria->compare('accommodation', $this->accommodation, true);
        $criteria->compare('domicile_address', $this->domicile_address, true);
        $criteria->compare('occupation_spouse', $this->occupation_spouse, true);
        $criteria->compare('occupation_father', $this->occupation_father, true);
        $criteria->compare('occupation_mother', $this->occupation_mother, true);
        $criteria->compare('passport_place_issued', $this->passport_place_issued, true);
        $criteria->compare('passport_date_issued', $this->passport_date_issued, true);
        $criteria->compare('name_emergency', $this->name_emergency, true);
        $criteria->compare('relationship_emergency', $this->relationship_emergency, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function validateIdCard($attribute,$params){
        $str = $this->identification;
        $chk = strlen($str);
        if($chk == "13"){
            $id = str_split(str_replace('-', '', $this->identification)); //ตัดรูปแบบและเอา ตัวอักษร ไปแยกเป็น array $id
            $sum = 0;
            $total = 0;
            $digi = 13;
            for ($i = 0; $i < 12; $i++) {
                $sum = $sum + (intval($id[$i]) * $digi);
                $digi--;
            }
            $total = (11 - ($sum % 11)) % 10;
            if ($total != $id[12]) { //ตัวที่ 13 มีค่าไม่เท่ากับผลรวมจากการคำนวณ ให้ add error
                $this->addError('identification', 'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร์*');
            }
        }
    }

    private function rangeRules($str) {
        $rules = explode(';', $str);
        for ($i = 0; $i < count($rules); $i++)
            $rules[$i] = current(explode("==", $rules[$i]));
        return $rules;
    }

    static public function range($str, $fieldValue = NULL) {
        $rules = explode(';', $str);
        $array = array();
        for ($i = 0; $i < count($rules); $i++) {
            $item = explode("==", $rules[$i]);
            if (isset($item[0]))
                $array[$item[0]] = ((isset($item[1])) ? $item[1] : $item[0]);
        }
        if (isset($fieldValue))
            if (isset($array[$fieldValue]))
                return $array[$fieldValue];
            else
                return '';
        else
            return $array;
    }

    public function widgetAttributes() {
        $data = array();
        $model = $this->getFields();

        foreach ($model as $field) {
            if ($field->widget)
                $data[$field->varname] = $field->widget;
        }
        return $data;
    }

   /* public function chkIdentification($id){
        for($i=0, $sum=0; $i < 12;$i++){
            $sum += floatval($id[$i]);
        }
        if((11-$sum%11)%10 != floatval($id[12]))
            return false;
        return true;
    }
*/
    public function widgetParams($fieldName) {
        $data = array();
        $model = $this->getFields();

        foreach ($model as $field) {
            if ($field->widget)
                $data[$field->varname] = $field->widgetparams;
        }
        return $data[$fieldName];
    }

    public function getFields() {
        if ($this->regMode) {
            if (!$this->_modelReg)
                $this->_modelReg = ProfileField::model()->forRegistration()->findAll();
            return $this->_modelReg;
        } else {
            if (!$this->_model)
                $this->_model = ProfileField::model()->forOwner()->findAll();
            return $this->_model;
        }
    }

}
