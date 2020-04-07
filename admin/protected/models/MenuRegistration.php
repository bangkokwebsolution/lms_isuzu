<?php

/**
 * This is the model class for table "{{menu_registration}}".
 *
 * The followings are the available columns in table '{{menu_registration}}':
 * @property integer $id
 * @property string $label_regis
 * @property string $label_homepage
 * @property string $label_identification
 * @property string $label_email
 * @property string $label_courseAll
 * @property string $label_placeholder_course
 * @property string $label_title
 * @property string $label_firstname
 * @property string $label_lastname
 * @property string $label_phone
 * @property string $label_company
 * @property string $label_position
 * @property string $label_placeholder_company
 * @property string $label_placeholder_position
 * @property string $label_save
 * @property string $label_alert_identification
 * @property string $label_alert_notNumber
 * @property string $label_dropdown_mr
 * @property string $label_dropdown_ms
 * @property string $label_dropdown_mrs
 * @property integer $lang_id
 * @property integer $parent_id
 * @property string $label_general_public
 * @property string $label_personnel
 * @property string $label_employee_id
 * @property string $label_passport
 * @property string $label_date_of_expiry
 * @property string $label_birthday
 * @property string $label_age
 * @property string $label_race
 * @property string $label_nationality
 * @property string $label_religion
 * @property string $label_sex
 * @property string $label_male
 * @property string $label_female
 * @property string $label_marital_status
 * @property string $label_single
 * @property string $label_marry
 * @property string $label_address
 * @property string $label_id_Line
 * @property string $label_history_of_severe_illness
 * @property string $label_never
 * @property string $label_ever
 * @property string $label_educational
 * @property string $label_education_level
 * @property string $label_academy
 * @property string $label_graduation_year
 * @property string $label_office
 * @property string $label_ship
 * @property string $label_branch
 * @property string $label_placeholder_branch
 * @property string $label_boat_person_report
 * @property string $label_boat_name
 * @property string $label_placeholder_boat_name
 * @property string $label_adress2
 * @property string $label_placeholder_address2
 * @property string $label_ship_up_date
 * @property string $label_ship_down_date
 * @property string $label_phone1
 * @property string $label_phone2
 * @property string $label_phone3
 */
class MenuRegistration extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_registration}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_regis, label_homepage, label_identification, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_station, label_company, label_position, label_placeholder_station, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber, label_general_public, label_personnel, label_employee_id, label_passport, label_date_of_expiry, label_birthday, label_age, label_race, label_nationality, label_religion, label_sex, label_male, label_female, label_marital_status, label_single, label_marry, label_address, label_id_Line, label_history_of_severe_illness, label_never, label_ever, label_educational, label_education_level, label_academy, label_graduation_year, label_office, label_ship,  label_branch, label_placeholder_branch, label_boat_person_report, label_boat_name, label_placeholder_boat_name, label_adress2, label_placeholder_address2, label_ship_up_date, label_ship_down_date, label_phone1, label_phone2, label_phone3', 'length', 'max'=>255),
			array('label_accept, label_reject', 'length', 'max'=>100),
			array('label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_regis, label_homepage, label_accept, label_reject, label_identification, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_station, label_company, label_position, label_placeholder_station, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber, label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs, lang_id, parent_id, label_general_public, label_personnel, label_employee_id, label_passport, label_date_of_expiry, label_birthday, label_age, label_race, label_nationality, label_religion, label_sex, label_male, label_female, label_marital_status, label_single, label_marry, label_address, label_id_Line, label_history_of_severe_illness, label_never, label_ever, label_educational, label_education_level, label_academy, label_graduation_year, label_office, label_ship,  label_branch, label_placeholder_branch, label_boat_person_report, label_boat_name, label_placeholder_boat_name, label_adress2, label_placeholder_address2, label_ship_up_date, label_ship_down_date, label_phone1, label_phone2, label_phone3', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label_regis' => 'สมัครเรียน',
			'label_homepage' => 'หน้าแรก',
			'label_accept' => 'ยอมรับ',
			'label_reject' => 'ไม่ยอมรับ',
			'label_identification' => 'เลขบัตรประจำตัวพนักงาน',
			'label_email' => 'อีเมล',
			'label_courseAll' => 'เลือกหลักสูตร',
			'label_placeholder_course' => 'กรุณาเลือกหลักสูตร',
			'label_title' => 'คำนำหน้า',
			'label_firstname' => 'ชื่อ',
			'label_lastname' => 'นามสกุล',
			'label_phone' => 'เบอร์โทรศัพท์',
			'label_company' => 'ฝ่าย',
			'label_position' => 'ตำแหน่ง',
			'label_placeholder_company' => 'เลือกฝ่าย',
			'label_placeholder_position' => 'เลือกตำแหน่ง',
			'label_save' => 'บันทึกข้อมูล',
			'label_alert_identification' => 'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร',
			'label_alert_notNumber' => 'ต้องเป็นตัวเลขเท่านั้น... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...',
			'label_dropdown_mr' => 'นาย',
			'label_dropdown_ms' => 'นางสาว',
			'label_dropdown_mrs' => 'นาง',
			'lang_id' => 'ภาษา',
			'parent_id' => 'Parent',
			'label_general_public' => 'สำหรับบุคคลทั่วไป',
			'label_personnel' => 'สำหรับพนักงาน',
			'label_employee_id' => 'เลขประจำตัวพนักงาน',
			'label_passport' => 'เลขหนังสือเดินทาง',
			'label_date_of_expiry' => 'วันที่บัตรหมดอายุ',
			'label_birthday' => 'วันเดือนปีเกิด',
			'label_age' => 'อายุ',
			'label_race' => 'เชื้อชาติ',
			'label_nationality' => 'สัญชาติ',
			'label_religion' => 'ศาสนา',
			'label_sex' => 'เพศ',
			'label_male' => 'ชาย',
			'label_female' => 'หญิง',
			'label_marital_status' => 'สถานะภาพทางการสมรส',
			'label_single' => 'โสด',
			'label_marry' => 'สมรส',
			'label_address' => 'ที่อยู่',
			'label_id_Line' => 'ไอดีไลน์',
			'label_history_of_severe_illness' => 'ประวัติการเจ็บป่วยรุนแรง',
			'label_never' => 'ไม่เคย',
			'label_ever' => 'เคย',
			'label_educational' => 'ประวัติการศึกษา',
			'label_education_level' => 'ระดับการศึกษา',
			'label_academy' => 'สถานที่จบการศึกษา',
			'label_graduation_year' => 'ปีที่จบการศึกษา',
			'label_office' => 'ออฟฟิต',
			'label_ship' => 'เรือ',
			'label_branch' => 'สาขา',
			'label_placeholder_branch' => 'เลือกสาขา',
			'label_boat_person_report' => 'ใบรายงานตัวคนประจำเรือ',
			'label_boat_name' => 'ขึ้นจากเรือชื่อ',
			'label_placeholder_boat_name' => 'ขึ้นจากเรือชื่อ',
			'label_adress2' => 'ที่อยู่ปัจจุบันที่สามารถติดต่อได้',
			'label_placeholder_address2' => 'เขียนที่อยู่ตรงนี้',
			'label_ship_up_date' => 'เมื่อวันที่',
			'label_ship_down_date' => 'สามารถจะลงทำงานเรือครั้งต่อไป',
			'label_phone1' => 'เบอร์โทรศัพท์ที่สามารถติดต่อได้',
			'label_phone2' => 'เบอร์มือถือ',
			'label_phone3' => 'โทรศัพท์อื่นๆที่สามารถติดต่อได้',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('label_regis',$this->label_regis,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_accept',$this->label_accept,true);
		$criteria->compare('label_reject',$this->label_reject,true);
		$criteria->compare('label_identification',$this->label_identification,true);
		$criteria->compare('label_email',$this->label_email,true);
		$criteria->compare('label_courseAll',$this->label_courseAll,true);
		$criteria->compare('label_placeholder_course',$this->label_placeholder_course,true);
		$criteria->compare('label_title',$this->label_title,true);
		$criteria->compare('label_firstname',$this->label_firstname,true);
		$criteria->compare('label_lastname',$this->label_lastname,true);
		$criteria->compare('label_phone',$this->label_phone,true);
		$criteria->compare('label_company',$this->label_company,true);
		$criteria->compare('label_position',$this->label_position,true);
		$criteria->compare('label_placeholder_company',$this->label_placeholder_company,true);
		$criteria->compare('label_placeholder_position',$this->label_placeholder_position,true);
		$criteria->compare('label_save',$this->label_save,true);
		$criteria->compare('label_alert_identification',$this->label_alert_identification,true);
		$criteria->compare('label_alert_notNumber',$this->label_alert_notNumber,true);
		$criteria->compare('label_dropdown_mr',$this->label_dropdown_mr,true);
		$criteria->compare('label_dropdown_ms',$this->label_dropdown_ms,true);
		$criteria->compare('label_dropdown_mrs',$this->label_dropdown_mrs,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('label_general_public',$this->label_general_public,true);
		$criteria->compare('label_personnel',$this->label_personnel,true);
		$criteria->compare('label_employee_id',$this->label_employee_id,true);
		$criteria->compare('label_passport',$this->label_passport,true);
		$criteria->compare('label_date_of_expiry',$this->label_date_of_expiry,true);
		$criteria->compare('label_birthday',$this->label_birthday,true);
		$criteria->compare('label_age',$this->label_age,true);
		$criteria->compare('label_race',$this->label_race,true);
		$criteria->compare('label_nationality',$this->label_nationality,true);
		$criteria->compare('label_religion',$this->label_religion,true);
		$criteria->compare('label_sex',$this->label_sex,true);
		$criteria->compare('label_male',$this->label_male,true);
		$criteria->compare('label_female',$this->label_female,true);
		$criteria->compare('label_marital_status',$this->label_marital_status,true);
		$criteria->compare('label_single',$this->label_single,true);
		$criteria->compare('label_marry',$this->label_marry,true);
		$criteria->compare('label_address',$this->label_address,true);
		$criteria->compare('label_id_Line',$this->label_id_Line,true);
		$criteria->compare('label_history_of_severe_illness',$this->label_history_of_severe_illness,true);
		$criteria->compare('label_never',$this->label_never,true);
		$criteria->compare('label_ever',$this->label_ever,true);
		$criteria->compare('label_educational',$this->label_educational,true);
		$criteria->compare('label_education_level',$this->label_education_level,true);
		$criteria->compare('label_academy',$this->label_academy,true);
		$criteria->compare('label_graduation_year',$this->label_graduation_year,true);
		$criteria->compare('label_office',$this->label_office,true);
		$criteria->compare('label_ship',$this->label_ship,true);
		$criteria->compare('label_branch',$this->label_branch,true);
		$criteria->compare('label_placeholder_branch',$this->label_placeholder_branch,true);
		$criteria->compare('label_boat_person_report',$this->label_boat_person_report,true);
		$criteria->compare('label_boat_name',$this->label_boat_name,true);
		$criteria->compare('label_placeholder_boat_name',$this->label_placeholder_boat_name,true);
		$criteria->compare('label_adress2',$this->label_adress2,true);
		$criteria->compare('label_placeholder_address2',$this->label_placeholder_address2,true);
		$criteria->compare('label_ship_up_date',$this->label_ship_up_date,true);
		$criteria->compare('label_ship_down_date',$this->label_ship_down_date,true);
		$criteria->compare('label_phone1',$this->label_phone1,true);
		$criteria->compare('label_phone2',$this->label_phone2,true);
		$criteria->compare('label_phone3',$this->label_phone3,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuRegistration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
