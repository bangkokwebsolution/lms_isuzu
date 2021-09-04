<?php


class EmpClass extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{employee_class}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			array('title','required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('descrpition', 'length', 'max'=>255),
			array('title', 'length', 'max'=>255),
			array('create_date', 'safe'),
			// Please remove those attributes that should not be searched.
			array('id, title, creaete_date, create_by, descrpition,update_date , update_by, active', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	// public function relations()
	// {
	// 	// NOTE: you may need to adjust the relation name and the related
	// 	// class name for the relations automatically generated below.
	// 	return array(
	// 		'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
	// 		'Province' => array(self::HAS_ONE, 'Province', array('pv_id'=>'province')),
	// 		'Generation' => array(self::HAS_ONE, 'Generation', array('id_gen'=>'generation')),
	// 		'ProfilesTitle'=>array(self::BELONGS_TO, 'ProfilesTitle', 'title_id'),
	// 		'Type' => array(self::HAS_ONE, 'TypeUser', array('id' => 'type_user')),
	// 	);
	// }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'title' => 'ชื่อ Employee Class',
			'descrpition'=>'คำอธิบาย',
			'create_date' => 'วันที่สร้าง',
			'update_date' => 'วันที่แก้ไข',			
		);
	}
	public function beforeSave() 
    {

		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 1;
		}

		if($this->isNewRecord)
		{
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->active = 1;
		}
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

        return parent::beforeSave();
    }
    
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function loadModel($id)
	{
		$model=EmpClass::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;



		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('descrpition',$this->descrpition);

		

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			if(!is_numeric($this->news_per_page)){
				$this->news_per_page = 10;
			}

			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}else{
			$poviderArray['pagination'] = array( 'pageSize'=> intval(10) );

		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

}