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
			array('label_regis, label_homepage, label_identification,label_accept,label_reject, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_company, label_position, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber', 'length', 'max'=>255),
			array('label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_regis, label_homepage,label_accept,label_reject, label_identification, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_company, label_position, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber, label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs, lang_id, parent_id', 'safe', 'on'=>'search'),
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
