<?php

/**
 * This is the model class for table "{{org_user}}".
 *
 * The followings are the available columns in table '{{org_user}}':
 * @property integer $id
 * @property integer $orgchart_id
 * @property integer $user_id
 * @property string $authority_id
 * @property string $active
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class OrgUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{org_user}}';
	}

	public function beforeSave() 
	{
		if($this->isNewRecord){
			$this->created_by =  Yii::app()->user->id;
			$this->created_date = date("Y-m-d H:i:s");
		} else{
			$this->updated_by = Yii::app()->user->id;
			$this->updated_date = date("Y-m-d H:i:s");
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
			array('orgchart_id, user_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('authority_id', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orgchart_id, user_id, authority_id, active, created_by, created_date, updated_by, updated_date', 'safe', 'on'=>'search'),
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
			'orgchart_id' => 'Orgchart',
			'user_id' => 'User',
			'authority_id' => 'Authority',
			'active' => 'Active',
			'created_by' => 'Created By',
			'created_date' => 'Created Date',
			'updated_by' => 'Updated By',
			'updated_date' => 'Updated Date',
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
		$criteria->compare('orgchart_id',$this->orgchart_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('authority_id',$this->authority_id,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_date',$this->updated_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrgUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
