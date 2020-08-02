<?php

/**
 * This is the model class for table "{{menu_library}}".
 *
 * The followings are the available columns in table '{{menu_library}}':
 * @property integer $id
 * @property string $label_library_document
 * @property string $label_library_media
 * @property integer $lang_id
 * @property integer $parent_id
 * @property string $label_list_docment
 * @property string $label_list_media
 * @property string $label_all
 */
class MenuLibrary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_library}}';
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
			array('label_library_document, label_library_media, label_list_docment, label_list_media, label_all', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_library_document, label_library_media, lang_id, parent_id, label_list_docment, label_list_media, label_all', 'safe', 'on'=>'search'),
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
			'label_library_document' => 'Label Library Document',
			'label_library_media' => 'Label Library Media',
			'lang_id' => 'Lang',
			'parent_id' => 'Parent',
			'label_list_docment' => 'Label List Docment',
			'label_list_media' => 'Label List Media',
			'label_all' => 'Label All',
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
		$criteria->compare('label_library_document',$this->label_library_document,true);
		$criteria->compare('label_library_media',$this->label_library_media,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('label_list_docment',$this->label_list_docment,true);
		$criteria->compare('label_list_media',$this->label_list_media,true);
		$criteria->compare('label_all',$this->label_all,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuLibrary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
