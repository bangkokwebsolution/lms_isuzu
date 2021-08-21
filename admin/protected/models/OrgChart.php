<?php

/**
 * This is the model class for table "{{orgchart}}".
 *
 * The followings are the available columns in table '{{orgchart}}':
 * @property integer $id
 * @property string $title
 * @property integer $parent_id
 * @property integer $level
 */
class OrgChart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	
	public $news_per_page;
	public $division_name;
	public $division_id;
	public $department_id;

	public function tableName()
	{
		return '{{orgchart}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('title,parent_id,division_id,department_id', 'required'),
			array('parent_id, level ,department_id,division_id ', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('created_date, updated_date,news_per_page', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, parent_id, level ,active, department_id, sortOrder, division_name,news_per_page', 'safe', 'on'=>'search'),
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
			'orgchart'=>array(self::BELONGS_TO, 'Orgchart', 'parent_id'),
			// 'orgchart'=>array(self::BELONGS_TO, 'Orgchart', 'department_id'),
			'div'=>array(self::BELONGS_TO, 'Orgchart', 'division_id'),
			'dep'=>array(self::BELONGS_TO, 'Orgchart', 'department_id'),
			'gro'=>array(self::BELONGS_TO, 'Orgchart', 'group_id'),	

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'parent_id' => 'Parent',
			'level' => 'Level',
			'active' => 'Active',
			'division_name'=>'Division',
			'division_id'=> 'Division',
			'department_name' => 'Department',
			'department_id' => 'Department',
			'section_name' => 'Section',
			'group_name' => 'Group',		
			'sortOrder' => 'sortOrder'
			

		);
	}
	public function defaultScope()
	{
	 	return array(
				// 'condition'=>"active='y'",
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('active',$this->active,true);

		if(!empty($this->division_name)){
			$div_name = $this->division_name;

			$Division = Orgchart::model()->find("title LIKE '%".$div_name."%' and level=2 ");

			$criteria->compare('division_id',$Division->id);



		}





		// $criteria->compare('department_id',$this->department_id,true);
		
		// $criteria->compare('sortOrder',$this->sortOrder,true);

		

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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orgchart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDivisionListNew(){
		$model = Orgchart::model()->findAll('level = "2" and active = "y" ORDER BY id ASC');
		$list = CHtml::listData($model,'id','title');
		return $list;
	}

	public function getDepartmentListNew(){
		$model = Orgchart::model()->findAll('level = "3" and active = "y" ORDER BY id ASC');
		$list = CHtml::listData($model,'id','title');
		return $list;
	}

	public function getGroupListNew(){
		$model = Orgchart::model()->findAll('level = "4" and active = "y" ORDER BY id ASC');
		$list = CHtml::listData($model,'id','title');
		return $list;
	}

}
