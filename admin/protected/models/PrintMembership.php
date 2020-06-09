<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $pic_user
 * @property string $orgchart_lv2
 * @property string $department_id
 * @property string $activkey
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $superuser
 * @property integer $status
 * @property integer $online_status
 * @property integer $online_user
 * @property string $last_ip
 * @property string $last_activity
 * @property integer $lastactivity
 * @property string $avatar
 * @property string $company_id
 * @property string $division_id
 * @property string $position_id
 * @property string $bookkeeper_id
 * @property string $pic_cardid
 * @property string $auditor_id
 * @property string $pic_cardid2
 * @property integer $del_status
 * @property string $group
 * @property string $identification
 *
 * The followings are the available model relations:
 * @property Profiles $profiles
 */
class PrintMembership extends CActiveRecord
{
	public $searchValue;
	public $news_per_page;
	public $supper_user_status;
	public $idensearch;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, create_at', 'required'),
			array('superuser, status, online_status, online_user, lastactivity, del_status', 'numerical', 'integerOnly'=>true),
			array('username, pic_user, orgchart_lv2, department_id, avatar, company_id, division_id, position_id, pic_cardid, pic_cardid2, group, identification', 'length', 'max'=>255),
			array('password, email, activkey', 'length', 'max'=>128),
			array('last_ip', 'length', 'max'=>100),
			array('bookkeeper_id', 'length', 'max'=>13),
			array('auditor_id', 'length', 'max'=>5),
			array('lastvisit_at, last_activity', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.

			array('id, username, password, email, pic_user, orgchart_lv2, department_id, activkey, create_at, lastvisit_at, superuser, status, online_status, online_user, last_ip, last_activity, lastactivity, avatar, company_id, division_id, position_id, bookkeeper_id, pic_cardid, auditor_id, pic_cardid2, del_status, group, identification, supper_user_status, idensearch;', 'safe', 'on'=>'search'),
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
			'profile' => array(self::HAS_ONE, 'Profiles', 'user_id'),
		    'position' => array(self::BELONGS_TO, 'Position','position_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'pic_user' => 'Pic User',
			'orgchart_lv2' => 'Orgchart Lv2',
			'department_id' => 'Department',
			'activkey' => 'Activkey',
			'create_at' => 'Create At',
			'lastvisit_at' => 'Lastvisit At',
			'superuser' => 'Superuser',
			'status' => 'Status',
			'online_status' => 'Online Status',
			'online_user' => 'Online User',
			'last_ip' => 'Last Ip',
			'last_activity' => 'Last Activity',
			'lastactivity' => 'Lastactivity',
			'avatar' => 'Avatar',
			'company_id' => 'Company',
			'division_id' => 'Division',
			'position_id' => 'Position',
			'bookkeeper_id' => 'Bookkeeper',
			'pic_cardid' => 'Pic Cardid',
			'auditor_id' => 'Auditor',
			'pic_cardid2' => 'Pic Cardid2',
			'del_status' => 'Del Status',
			'group' => '3=admin สูงสุด 2=adminดูแลระบบ',
			'identification' => 'เลขบัตรประชาชน',
			'position_id' => UserModule::t("ตำแหน่ง"),
			// 'searchValue' => 'ชื่อ นามสกุล/บัตรประชาชน'
			'searchValue' => 'ชื่อ นามสกุล',
			'supper_user_status' => 'สถานะ',
			'idensearch' => 'รหัสบัตรประชาชน',
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
	// public function search()
	// {
	// 	// @todo Please modify the following code to remove attributes that should not be searched.
	// 	$criteria = new CDbCriteria;
	// 	$criteria->select ='id,profiles.firstname,profiles.lastname';
	// 	$criteria->join = "INNER JOIN tbl_profiles AS profiles ON(t.id=profiles.user_id) 
	// 					   LEFT JOIN tbl_learn AS learn ON(t.id=learn.user_id)";
	// 	// $criteria->join = "INNER JOIN tbl_learn AS learn ON(t.id=learn.user_id)";
	// 	if($this->searchValue != null){
	// 		$criteria->compare('profiles.firstname',$this->searchValue,true);
	// 		$criteria->compare('profiles.lastname',$this->searchValue,true,'OR');
	// 	}
	// 	$criteria->group = 't.id';

	// 	//$criteria->with = array('profiles');
	// 	//$criteria->compare('id',$this->id);
	// 	$poviderArray = array('criteria' => $criteria);
 //        // Page
	// 	if (isset($this->news_per_page)) {
	// 		$poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
	// 	} else {
	// 		$poviderArray['pagination'] = array('pageSize' => intval(20));
	// 	}

	// 	return new CActiveDataProvider($this, $poviderArray);
	// }

 public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;

        $criteria->with = array('profile');

        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('pic_user',$this->pic_user);
        $criteria->compare('station_id',$this->station_id);
        $criteria->compare('department_id',$this->department_id);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('lastactivity',$this->lastactivity);
        // $criteria->compare('superuser',$this->superuser);
        if(empty($this->supper_user_status)){
        	$criteria->compare('superuser',1);
        }else{
        	$criteria->compare('superuser',0);
        }     
        $criteria->compare('status',$this->status);
        $criteria->compare('del_status',0);
 		$criteria->compare('online_status',$this->online_status);
 		$criteria->compare('online_user',$this->online_user);
 		$criteria->compare('group',$this->group);
 		$criteria->compare('identification',$this->identification);
 		$criteria->compare('pic_cardid2',$this->pic_cardid2);
 		$criteria->compare('register_status',$this->register_status);
 		$criteria->compare('profile.type_user',$this->typeuser);
 		// $criteria->compare('passport',$this->passport);

 		// $criteria->compare('profile.identification',$this->idensearch,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function searchmembership()
{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
	$criteria=new CDbCriteria;

	//$criteria->with = array('profile');
	$criteria->with = array('profile','position');
	$criteria->compare('id',$this->id);
	$criteria->compare('username',$this->username,true);
	$criteria->compare('password',$this->password);
	$criteria->compare('pic_user',$this->pic_user);
	$criteria->compare('department_id',$this->department_id);
	$criteria->compare('position_id',$this->position_id);
	$criteria->compare('email',$this->email,true);
	$criteria->compare('activkey',$this->activkey);
	//$criteria->compare('create_at',$this->create_at);
	$criteria->compare('lastvisit_at',$this->lastvisit_at);
	$criteria->compare('lastactivity',$this->lastactivity);
	$criteria->compare('superuser',$this->superuser);
	$criteria->compare('note',$this->note);
	$criteria->compare('status',0);
	$criteria->compare('del_status',0);
	$criteria->compare('online_status',$this->online_status);
	$criteria->compare('online_user',$this->online_user);
	//$criteria->compare('register_status',$this->register_status);		
	if (isset($this->register_status)) {
		if($this->register_status == null){
        $criteria->addIncondition('register_status',array(0,2));
		}else if($this->register_status == 2){
		    $criteria->compare('register_status', 2);
        }else if($this->register_status == 1){
        	$criteria->compare('register_status',0);
        }
        $criteria->addIncondition('register_status',array(0,2));
	}else{
         $criteria->addIncondition('register_status',array(0,2));
	}
	$criteria->compare('group',$this->group);
	$criteria->compare('profile.identification',$this->idensearch,true);
	$criteria->compare('profile.type_user',1);
	$criteria->order = 't.id DESC';
	if(empty($this->create_at)) {
		$criteria->compare('create_at',$this->create_at,true);
	}else {
		$start_date = substr($this->create_at,0,11);
		$end_date = substr($this->create_at,13);
	
		$date_start = date('Y-m-d 00:00:00', strtotime($start_date));
		$date_end = date('Y-m-d 23:59:59', strtotime($end_date));
			
		$criteria->addBetweenCondition('create_at', $date_start, $date_end, 'AND');
	}
	//var_dump($_REQUEST);exit();
	//$org = !empty($this->orgchart_lv2) ? '"'.$this->orgchart_lv2.'"' : '';
	//$criteria->compare('orgchart_lv2',$org,true);
	$dataProvider = new CActiveDataProvider(get_class($this), array(
		'criteria'=>$criteria,
		'pagination'=>array(
			'pageSize'=>Yii::app()->getModule('user')->user_page_size,
		),
	));
	return  $dataProvider;
}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
