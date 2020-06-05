<?php

class Category extends AActiveRecord
{
	public $labelState = false;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{category}}';
	}

	public function rules()
	{
		return array(
			array('cate_show, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
//			array('cate_image', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('cate_title', 'required'),
			array('cate_short_detail, cate_detail, cate_image, create_date, update_date, news_per_page, special_category,lang_id,parent_id', 'safe'),
			array('cate_image, cate_id ,cate_type, cate_title, cate_short_detail, cate_detail, create_date, create_by, update_date, update_by, active, special_category,lang_id,parent_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'files' => array(self::HAS_MANY, 'Filecategory', 'category_id'),
			'fileCount'=>array(self::STAT, 'Filecategory', 'category_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		if(!$this->labelState){
            $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        }
		// $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'cate_id' => 'Cate',
			'cate_type'=>'ประเภทของหลักสูตร'.$label_lang,
			'cate_title' => 'ชื่อหมวดหลักสูตร'.$label_lang,
			'cate_short_detail' => 'รายละเอียดย่อ'.$label_lang,
			'cate_detail' => 'รายละเอียด'.$label_lang,
			'cate_image' => 'รูปภาพประกอบ'.$label_lang,
			'cate_show' => 'แสดงผล',
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล'.$label_lang,
			'active' => 'สถานะ'.$label_lang,
			'special_category' => 'หมวดหมู่หลักสูตรพิเศษ'.$label_lang,
			'filename'=>'วิดีโอตัวอย่างหลักสูตร (mp3,mp4)'.$label_lang,
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
		);
	}

	public function getCateName()
	{
		if($this->cate_type == 1)
			$name = '<font color="#009933"><b>นิสิต/นักศึกษา</b></font>';
		else
			$name = '<font color="#330099"><b>ผู้ประกอบวิชาชีพ</b></font>';

		return $name;
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('cate_id',$this->cate_id);
		$criteria->compare('cate_type',$this->cate_type,true);
		$criteria->compare('cate_title',$this->cate_title,true);
		$criteria->compare('cate_short_detail',$this->cate_short_detail,true);
		$criteria->compare('cate_detail',$this->cate_detail,true);
		$criteria->compare('cate_show',$this->cate_show,true);
		$criteria->compare('create_date',$this->create_date,true);

		////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
		$check_user = User::model()->findByPk(Yii::app()->user->id);
		$group = $check_user->group;
		$group_arr = json_decode($group);
		$see_all = 2;
		if(in_array("1", $group_arr) || in_array("7", $group_arr)){
			$see_all = 1;
		}
            //////////////////
		if($see_all != 1){
			$criteria->compare('create_by',Yii::app()->user->id);
		}else{
			$criteria->compare('create_by',$this->create_by);
		}
		
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id',0);
		$poviderArray = array('criteria'=>$criteria);


		



		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

   	public function beforeSave()
    {
    	$this->cate_title = CHtml::encode($this->cate_title);
    	$this->cate_short_detail = CHtml::encode($this->cate_short_detail);
    	$this->cate_detail = CHtml::encode($this->cate_detail);

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
			$this->update_by= $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->update_by= $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

        return parent::beforeSave();
    }

    public function afterFind()
    {
    	$this->cate_title = CHtml::decode($this->cate_title);
    	$this->cate_short_detail = CHtml::decode($this->cate_short_detail);
    	$this->cate_detail = CHtml::decode($this->cate_detail);

        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
			    'alias' => 'categorys',
			    'order' => ' categorys.cate_type ASC ',
		    	'condition' => ' categorys.active ="y" ',
		    );
    	}
    	else
    	{
		    $checkScopes =  array(
			    'alias' => 'categorys',
			    'order' => ' categorys.cate_type ASC ',
		    );
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Category.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);

		if($Access == true)
		{
			$scopes =  array(
				'categorycheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'categorycheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'categorycheck'=>array(
							'alias' => 'categorys',
							'condition' => ' categorys.active = "y"  ',
							'order' => ' categorys.cate_type ASC ',
						),
					);
				}else{
					$scopes = array(
						'categorycheck'=>array(
							'alias' => 'categorys',
							'condition' => ' categorys.create_by = "'.Yii::app()->user->id.'" AND categorys.active = "y"  ',
							'order' => ' categorys.cate_type ASC ',
						),
					);
				}
			    
			    // $scopes = array(
		     //        'categorycheck'=>array(
			    // 		'alias' => 'categorys',
			    // 		'condition' => ' categorys.active = "y"  ',
			    // 		'order' => ' categorys.cate_type ASC ',
		     //        ),
			    // );
			}
		}

		return $scopes;
    }

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

	public function getId()
	{
		return $this->cate_id;
	}

}
