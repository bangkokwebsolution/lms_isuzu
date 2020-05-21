<?php

/**
 * This is the model class for table "{{certificate}}".
 *
 * The followings are the available columns in table '{{certificate}}':
 * @property integer $cert_id
 * @property integer $sign_id
 * @property string $cert_number
 * @property string $cert_name
 * @property string $cert_background
 * @property integer $cert_hide
 * @property integer $cert_hour
 * @property integer $cert_display
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Certificate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{certificate}}';
	}

	public function beforeSave(){
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
        {
            $id = Yii::app()->user->id;
        }
        else
        {
            $id = 0;
        }

        if($this->isNewRecord)
        {
            $this->create_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
        } else {
        	$this->update_by = $id;
            $this->update_date = date("Y-m-d H:i:s");
        }

        return parent::beforeSave();
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sign_id', 'required'),
			// array('sign_id2', 'required'),
			array('sign_id , sign_id2, cert_hide, cert_hour, cert_display, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('cert_number', 'length', 'max'=>100),
			array('cert_name', 'length', 'max'=>250),
			array('active', 'length', 'max'=>1),
			array('cert_background, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cert_id, sign_id, sign_id2 , cert_course_number, cert_number,cert_name, cert_background, cert_hide, cert_hour, cert_display, create_date, create_by, update_date, update_by, active, cert_text', 'safe', 'on'=>'search'),
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
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'signature' => array(self::BELONGS_TO, 'Signature', 'sign_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cert_id' => 'รหัส ใบ cert',
			'sign_id' => 'ลายเซนต์',
			'cert_name' => 'ชื่อใบประกาศนียบัตร',
			'cert_number' => 'เลขที่ใบประกาศนียบัตร',
			'cert_background' => 'พื้นหลัง',
			'cert_hide' => 'แสดงผล',
			'cert_hour' => 'Cert Hour',
			'cert_display' => 'ประเภทแสดงผล',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'y=แสดงผล n=ไม่แสดงผล',
			'cert_text' => 'ข้อความ',

		);
	}

	public function afterFind()
	{
		$this->cert_name = CHtml::decode($this->cert_name);

		return parent::afterFind();
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
		$criteria->compare('cert_id',$this->cert_id);
		$criteria->compare('sign_id',$this->sign_id);
		$criteria->compare('cert_name',$this->cert_name,true);
		$criteria->compare('cert_background',$this->cert_background,true);
		$criteria->compare('cert_hide',$this->cert_hide);
		$criteria->compare('cert_hour',$this->cert_hour);
		$criteria->compare('cert_display',$this->cert_display);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('cert_text',$this->cert_text);

		$poviderArray = array('criteria'=>$criteria);

        // Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'certificate',
				'order' => ' certificate.cert_id DESC ',
				'condition' => ' certificate.active ="y"',
			);
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'certificate',
				'order' => ' certificate.cert_id DESC ',
			);
		}

		return $checkScopes;
	}

	public function scopes(){
		$Access = Controller::SetAccess( array("Certificate.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);

		if($Access == true)
		{
			$scopes =  array(
				'certificatecheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
				{
					$scopes =  array(
						'certificatecheck' => $this->checkScopes('scopes')
					);
				}
				else
				{
					if($user->superuser == 1){
						$scopes = array(
							'certificatecheck'=>array(
								'alias' => 'certificate',
								'condition' => 'certificate.active="y" ',
								'order' => ' certificate.cert_id DESC ',
							),
						);
					}else{
						$scopes = array(
							'certificatecheck'=>array(
								'alias' => 'certificate',
								'condition' => ' certificate.create_by = "'.Yii::app()->user->id.'" AND certificate.active="y" ',
								'order' => ' certificate.cert_id DESC ',
							),
						);
					}
					
				}
			}

			return $scopes;
		}

		public function defaultScope()
		{
			$defaultScope =  $this->checkScopes('defaultScope');

			return $defaultScope;
		}

		public function getStatus(){
			if($this->cert_hide == 1){
				return "แสดงผล";
			} else {
				return "ปิดการแสดงผล";
			}
		}

		public function getDisplay(){
			if($this->cert_display == 1){
				return "แสดงผลแนวตั้ง";
			} else {
				return "แสดงผลแนวนอน";
			}
		}

		public function getId()
		{
			return $this->cert_id;
		}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Certificate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
