<?php

/**
 * This is the model class for table "{{imgslide}}".
 *
 * The followings are the available columns in table '{{imgslide}}':
 * @property integer $imgslide_id
 * @property string $imgslide_link
 * @property string $imgslide_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Imgslide extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Imgslide the static model class
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
		return '{{imgslide}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('imgslide_link', 'length', 'max'=>250),
			array('imgslide_picture', 'length', 'max'=>200),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('imgslide_id, imgslide_link, imgslide_picture, create_date, create_by, update_date, update_by, active , gallery_type_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'gType' => array(self::BELONGS_TO, 'GalleryType', 'gallery_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'imgslide_id' => 'Imgslide',
			'imgslide_link' => 'Imgslide Link',
			'imgslide_picture' => 'Imgslide Picture',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'gallery_type_id' => 'Gallery type id',
		);
	}

	public function defaultScope()
	{
	    return array(
	    	'order' => 'imgslide_id desc',
	    	'condition' => 'active = "y"',
	    );
	}

	public function getId()
	{
		return $this->imgslide_id;
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

		$criteria->compare('imgslide_id',$this->imgslide_id);
		$criteria->compare('imgslide_link',$this->imgslide_link,true);
		$criteria->compare('imgslide_picture',$this->imgslide_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('gallery_type_id',$this->gallery_type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}