<?php

/**
 * This is the model class for table "{{log_approve}}".
 *
 * The followings are the available columns in table '{{log_approve}}':
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
 * @property integer $user_id
 */
class LogApprove extends CActiveRecord
{
	public $news_per_page;
	public $search_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{log_approve}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position_id, confirm_user, create_by, update_by, user_id', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('register_date, confirm_date, create_date, update_date, news_per_page, search_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firstname, lastname, register_date, position_id, confirm_date, confirm_user, create_date, create_by, update_date, update_by, active, user_id, search_name, news_per_page', 'safe', 'on'=>'search'),
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
			'register_date' => 'วันที่เข้าสมัคร',
			'position_id' => 'ตำแหน่ง',
			'confirm_date' => 'วันที่กดยืนยันการสมัคร',
			'confirm_user' => 'Confirm User',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'user_id' => 'User',
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
		$criteria->compare('t.position_id',$this->position_id);
		$criteria->compare('confirm_date',$this->confirm_date,true);
		$criteria->compare('confirm_user',$this->confirm_user);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('user_id',$this->user_id);
        
		$poviderArray = array('criteria' => $criteria);

        if (isset($this->news_per_page)) {
            $poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
        } else {
            $poviderArray['pagination'] = array('pageSize' => intval(10));
        }

        return new CActiveDataProvider($this, $poviderArray);
	}
	public function searchapprove()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->with = array('user','position','profile');
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		//$criteria->compare('register_date',$this->register_date,true);
		$criteria->compare('t.position_id',$this->position_id);
		//$criteria->compare('confirm_date',$this->confirm_date,true);
		$criteria->compare('confirm_user',$this->confirm_user);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('user_id',$this->user_id);
		$regis_date = $this->register_date;
		if(!empty($regis_date)) {
		
		// $start_dates = substr($this->register_date,0,11);
		// $end_dates = substr($this->register_date,13);
	       $start_dates = $this->register_date;
		   $end_dates = $this->register_date;
    
		$date_starts = date('Y-m-d 00:00:00',strtotime($start_dates));
		$date_ends = date('Y-m-d 23:59:59', strtotime($end_dates));
		// $date_starts = date('Y-m-d 00:00:00',strtotime($this->$register_date));
		// $date_ends = date('Y-m-d 23:59:59', strtotime($this->$register_date));

		$criteria->addBetweenCondition('register_date', $date_starts, $date_ends, 'AND');
		
	     }else {

		$criteria->compare('register_date',$this->register_date,true);
	    }
        $firm_date = $this->confirm_date;
		if(!empty($firm_date)) {
		// $start_date = substr($this->confirm_date,0,11);
		// $end_date = substr($this->confirm_date,13);
		$start_date = $this->confirm_date;
		$end_date = $this->confirm_date;
 
		$date_start = date('Y-m-d 00:00:00',strtotime($start_date));
		$date_end = date('Y-m-d 23:59:59', strtotime($end_date));

		$criteria->addBetweenCondition('confirm_date', $date_start, $date_end, 'AND');
		
	     }else {

        $criteria->compare('confirm_date',$this->confirm_date,true);
		
	    }
        
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
	 * @return LogApprove the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
