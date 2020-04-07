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
            array('identification, passport', 'numerical', 'integerOnly' => true),
            array('fax', 'numerical', 'integerOnly' => true),
            array('phone, phone1, phone2, phone3', 'numerical', 'integerOnly' => true),
           // array('tel', 'length', 'min' => 9),
            array('bussiness_model_id,bussiness_type_id,company,juristic,title_id, type_user, education, occupation, position, website, province, tel, phone, fax, advisor_email1, advisor_email2, generation, file,department, passport, date_of_expiry, race, nationality, religion, line_id, ship_name, ship_up_date, ship_down_date, address2, phone1, phone2, phone3', 'length', 'max' => 255),
            array('firstname, lastname', 'length', 'max' => 50),
            array('identification', 'length', 'max'=>13),
            // array('identification', 'length', 'min'=>13),
            array('sex, history_of_illness, status_sm, type_employee,type_card', 'length', 'max' => 6),
            array('passport', 'length', 'max' => 6),
             array('identification', 'validateIdCard'),
            array('identification', 'unique', 'message' => 'เลขบัตรประชาชนนี้มีในระบบแล้ว'),
            // The following rule is used by search(). 
            // Please remove those attributes that should not be searched. 
            array('bussiness_model_id,bussiness_type_id,company,juristic,user_id, title_id, firstname, lastname, active, generation, type_user, sex, birthday, age, education, occupation, position, website, address, province, tel, phone, fax, contactfrom, advisor_email1, advisor_email2, file, passport, date_of_expiry, race, nationality, religion, history_of_illness, status_sm, type_employee, type_card, line_id', 'safe', 'on' => 'search'),
            array('file_user', 'file', 'types' => 'pdf', 'allowEmpty' => true, 'on' => 'insert'),
            //array('ship_name, ship_up_date, ship_down_date, address2, phone1, phone2, phone3', 'allowEmpty' => true, 'on' => 'update'),
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
            'ProfilesTitle' => array(self::BELONGS_TO, 'ProfilesTitle', 'title_id'),
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
            // 'firstname_en' => 'Firstname',
            // 'lastname_en' => 'Lastname',
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
            'ship_name' => 'ชื่อเรือที่ขึ้น',
            'address2' => 'ที่อยู่ปัจจุบันที่สามารถติดต่อได้',
            'ship_up_date' => 'วันที่ขึ้นจากเรือ',
            'ship_down_date'=> 'วันที่กลับไปขึ้นเรือ',
            'phone1'=> 'เบอร์โทรศัพท์ที่สามารถติดต่อได้',
            'phone2' => 'เบอร์มือถือ',
            'phone3' => 'โทรศัพท์อื่นๆที่สามารถติดต่อได้'
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
        $criteria->compare('ship_name', $this->ship_name, true);
        $criteria->compare('ship_up_date', $this->ship_up_date, true);
        $criteria->compare('ship_down_date', $this->ship_down_date, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('phone1', $this->phone1, true);
        $criteria->compare('phone2', $this->phone2, true);
        $criteria->compare('phone3', $this->phone3, true);

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
