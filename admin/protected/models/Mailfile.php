<?php

/**
 * This is the model class for table "{{mailfile}}".
 *
 * The followings are the available columns in table '{{mailfile}}':
 * @property integer $id
 * @property integer $maildetail_id
 * @property string $file_name
 * @property string $create_date
 */
class Mailfile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mailfile the static model class
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
		return '{{mailfile}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, maildetail_id', 'numerical', 'integerOnly'=>true),
			array('file_name,file_type', 'length', 'max'=>255),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, maildetail_id, file_name, file_type, create_date', 'safe', 'on'=>'search'),
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
			'maildetail_id' => 'Maildetail',
			'file_name' => 'File Name',
			'file_type' => 'File Name',
			'create_date' => 'Create Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('maildetail_id',$this->maildetail_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_type',$this->file_type);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		$this->create_date = date("Y-m-d H:i:s");

		return parent::beforeSave();
	}
}