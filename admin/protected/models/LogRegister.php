<?php

/**
 * This is the model class for table "{{log_register}}".
 *
 * The followings are the available columns in table '{{log_register}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $register_date
 * @property integer $position_id
 * @property string $confirm_date
 * @property integer $confirm_user
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class LogRegister extends CActiveRecord
{
	public $news_per_page;
	public $search_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{log_register}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position_id, confirm_user, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('news_per_page,register_date, confirm_date, create_date, update_date, search_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firstname, lastname, register_date, position_id, confirm_date, confirm_user, create_date, create_by, update_date, update_by, active, user_id, news_per_page, search_name', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO, 'Users', 'user_id'),
			'profile'=>array(self::BELONGS_TO, 'Profiles', 'user_id'),
			'position'=>array(self::BELONGS_TO, 'Position', 'position_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'register_date' => 'Register Date',
			'position_id' => 'Position',
			'confirm_date' => 'Confirm Date',
			'confirm_user' => 'Confirm User',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'user_id' => 'user_id',
			'search_name' => 'ชื่อ - สกุล'
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
		$criteria->with = array('user','position','profile');
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('register_date',$this->register_date,true);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('confirm_date',$this->confirm_date,true);
		$criteria->compare('confirm_user',$this->confirm_user);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		$poviderArray = array('criteria' => $criteria);

        // Page
        if (isset($this->news_per_page)) {
            $poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
        } else {
            $poviderArray['pagination'] = array('pageSize' => intval(10));
        }

        return new CActiveDataProvider($this, $poviderArray);

		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogRegister the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
