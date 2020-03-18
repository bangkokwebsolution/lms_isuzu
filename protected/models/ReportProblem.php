<?php

/**
 * This is the model class for table "{{report_problem}}".
 *
 * The followings are the available columns in table '{{report_problem}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $tel
 * @property string $report_type
 * @property string $report_title
 * @property string $report_detail
 * @property string $report_pic
 */
class ReportProblem extends CActiveRecord
{
	public $file;
	public $tel2;
	public $report_type2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{report_problem}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, email, tel, report_type, report_title, report_detail', 'required'),
			array('firstname, lastname, email, tel, report_type, report_title, report_pic', 'length', 'max'=>255),
			array('email', 'email'),
			array('tel', 'numerical', 'integerOnly'=>true),
			array('tel','length','min'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firstname, lastname, email, tel, report_type, report_title, report_detail, report_pic,status,report_date', 'safe', 'on'=>'search'),
			array('file', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
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
			'firstname' => 'ชื่อ',
			'lastname' => 'นามสกุล',
			'email' => 'อีเมล์',
			'tel' => 'เบอร์โทรศัพท์',
			'report_type' => 'ประเภทปัญหา',
			'report_title' => 'หัวข้อ',
			'report_detail' => 'ข้อความ',
			'report_pic' => 'Report Pic',
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('report_type',$this->report_type,true);
		$criteria->compare('report_title',$this->report_title,true);
		$criteria->compare('report_detail',$this->report_detail,true);
		$criteria->compare('report_pic',$this->report_pic,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReportProblem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
