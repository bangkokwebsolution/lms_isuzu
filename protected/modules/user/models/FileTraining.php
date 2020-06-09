<?php

/**
 * This is the model class for table "{{file_training}}".
 *
 * The followings are the available columns in table '{{file_training}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $file_name
 * @property string $filename
 * @property string $length
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class FileTraining extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{file_training}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('file_name, filename, length, expire_date, name_training', 'length', 'max'=>255),
			array('file_name, filename', 'file', 'types'=>'pdf,jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
			array('file_name, filename', 'file', 'types'=>'pdf,jpg, png, gif','allowEmpty' => true, 'on'=>'update'),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, file_name, filename, length, create_date, create_by, update_date, update_by, active, expire_date, name_training', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'file_name' => 'File Name',
			'filename' => 'Filename',
			'length' => 'Length',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'expire_date' => 'expire_date',
			'name_training'=>'name_training',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('expire_date',$this->expire_date,true);
		$criteria->compare('name_training',$this->name_training,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FileTraining the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
