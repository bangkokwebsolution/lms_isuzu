<?php

class Profile extends UActiveRecord
{
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
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableProfiles;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array( 
            array('firstname, lastname,firstname_en,lastname_en', 'required'),
			array('employee_class', 'numerical', 'integerOnly'=>true),
            array('user_id, title_id, firstname, lastname,  sex', 'safe', 'on'=>'search'),
            array('file_user', 'file', 'types'=>'pdf','allowEmpty' => true, 'on'=>'insert'),
			array('file_user', 'file', 'types'=>'pdf',
				'wrongType' => 'รองรับไฟล์ pdf เท่านั้น', 'allowEmpty' => true, // ข้อความเตือน
                'maxSize' => 1024 * 1024 * 5, // 5 MB
                'tooLarge' => 'ขนาดไฟล์ไม่เกิน 5MB' // ขนาดไฟล์
                ),
        ); 
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'user'=>array(self::HAS_ONE, 'User', 'id'),
			'type_name'=>array(self::BELONGS_TO, 'TypeUser', 'type_user'),
			'ProfilesTitle'=>array(self::BELONGS_TO, 'ProfilesTitle', 'title_id'),
			'typeEmployee'=>array(self::BELONGS_TO, 'TypeEmployee', 'type_employee'),
			'EmpClass'=>array(self::BELONGS_TO, 'EmpClass', 'employee_class'),

		);
		if (isset(Yii::app()->getModule('user')->profileRelations)) $relations = array_merge($relations,Yii::app()->getModule('user')->profileRelations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */

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

	public function attributeLabels()
	{
		return array( 
            'user_id' => UserModule::t('User ID'),
            'title_id' => 'คำนำหน้าชื่อ',
            'firstname' => 'ชื่อ',
            'lastname' => 'นามสกุล',
            'firstname_en' => 'Firstname',
            'lastname_en' => 'Lastname',
            'employment_date' => 'วันเริ่มงาน',
            'kind' => 'ประเภทพนักงาน',
            'organization_unit' => 'รหัสส่วนงาน',
            'abbreviate_code' => 'ชื่อส่วนงาน',
            'location' => 'สถานที่ทำงาน',
            'group_name' => 'Group',
            'shift' => 'Shift',
            'employee_class' =>'Employee class',
            'position_description' => 'Position description',
            'sex' => 'เพศ',
        ); 
	}
	
	private function rangeRules($str) {
		$rules = explode(';',$str);
		for ($i=0;$i<count($rules);$i++)
			$rules[$i] = current(explode("==",$rules[$i]));
		return $rules;
	}
	
	static public function range($str,$fieldValue=NULL) {
		$rules = explode(';',$str);
		$array = array();
		for ($i=0;$i<count($rules);$i++) {
			$item = explode("==",$rules[$i]);
			if (isset($item[0])) $array[$item[0]] = ((isset($item[1]))?$item[1]:$item[0]);
		}
		if (isset($fieldValue)) 
			if (isset($array[$fieldValue])) return $array[$fieldValue]; else return '';
		else
			return $array;
	}
	
	public function widgetAttributes() {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widget;
		}
		return $data;
	}
	
	public function widgetParams($fieldName) {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widgetparams;
		}
		return $data[$fieldName];
	}

	public function getEmail(){
		return $this->user->email;
	}
	
	public function getFields() {
		if ($this->regMode) {
			if (!$this->_modelReg)
				$this->_modelReg=ProfileField::model()->forRegistration()->findAll();
			return $this->_modelReg;
		} else {
			if (!$this->_model)
				$this->_model=ProfileField::model()->forOwner()->findAll();
			return $this->_model;
		}
	}

	public function getFullname() {
		if(!empty($this->firstname) && !empty($this->lastname)){
			$str = $this->firstname . ' ' . $this->lastname;
		}
		return $str;
	}
}