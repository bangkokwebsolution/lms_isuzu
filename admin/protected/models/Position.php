<?php

/**
 * This is the model class for table "{{position}}".
 *
 * The followings are the available columns in table '{{position}}':
 * @property integer $id
 * @property integer $department_id
 * @property string $position_title
 * @property string $create_date
 * @property string $active
 */
class Position extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{position}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('department_id', 'numerical', 'integerOnly'=>true),
			array('position_title', 'length', 'max'=>200),
			array('active', 'length', 'max'=>255),
			array('create_date,lang_id,parent_id', 'safe'),
			array('position_title, department_id ', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, department_id, position_title, create_date, active,lang_id,parent_id', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		if(empty($this->lang_id)){
			$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		}else{
			$this->lang_id = $this->lang_id;
		}
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'id' => 'ID',
			'department_id' => 'แผนก',
			'position_title' => 'ชื่อตำแหน่ง',
			'create_date' => 'สร้างวันที่',
			'active' => 'Active',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
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
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('position_title',$this->position_title,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('active',y);
		$criteria->compare('parent_id',0);
		$criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Position the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

		if($this->isNewRecord){
            // $this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
            // $this->update_by = $id;
            // $this->update_date = date("Y-m-d H:i:s");
		}else{
            // $this->update_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
		}
		return parent::beforeSave();
	}

	public function getPositionList(){
		$model = Position::model()->findAll();
		$list = CHtml::listData($model,'id','position_title');
		return $list;
	}
}
