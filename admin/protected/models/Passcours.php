<?php

class Passcours extends AActiveRecord
{
	public $user_name;
	public $cours_name;
	public $cate_title;
	public $list_print;
	public $generation;
	public $memtype;
	public $search;
	public $period_start;
	public $period_end;
    public $cate_id;
    public $page_false;
    public $division_id;
    public $department;
    public $station;
    public $type_register;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{passcours}}';
	}

	public function rules()
	{
		return array(
			array('passcours_cours, passcours_user', 'numerical', 'integerOnly'=>true),
			array('passcours_date, user_name, cours_name, news_per_page,page_false', 'safe'),
			array('cate_title, cours_name, user_name, passcours_id, passcours_cours,passcours_cates, passcours_user, passcours_date,division_id,department,station,type_register', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Profiles'=>array(self::BELONGS_TO, 'Profiles', 'passcours_user'),
			'CourseOnlines'=>array(self::BELONGS_TO, 'CourseOnline', 'passcours_cours'),
			'Category'=>array(self::BELONGS_TO, 'Category', 'passcours_cates'),
			'user'=>array(self::BELONGS_TO, 'User', 'passcours_user'),
			'register'=>array(self::BELONGS_TO, 'RegistrationForm', 'passcours_user'),
			'Period' => array(self::HAS_MANY, 'CoursePeriod', array( 'id_course' => 'passcours_cours' )),
		);
	}

	public function attributeLabels()
	{
		return array(
			'passcours_id' => 'Passcours',
			'passcours_cours' => 'ชื่อหลักสูตร',
			'passcours_cates' => 'ชื่อหลักสูตร',
			'passcours_user' => 'ชื่อผู้อบรม',
			'passcours_date' => 'วันที่สอบผ่าน',
			'generation' => 'เลือกรุ่น',
			'search' => 'ค้นหา',
			'period_start' => 'วันที่เริ่มต้น',
			'period_end' => 'วันที่สิ้นสุด',
			'division_id' => 'ฝ่าย',
			'department' => 'แผนก',
			'station' => 'สถานี',
			'type_register' => 'ประเภทผู้ใช้งาน'

		);
	}

	public function highsearch() {
		$criteria = new CDbCriteria;
		//join with relations
		$criteria->with = array('Profiles', 'CourseOnlines', 'user');

		//check memtype
		if(isset($this->type_register) && $this->type_register != null) {
			if($this->type_register == 1){ //General
				$criteria->addIncondition('user.type_register',[1,2],false);
                }else if($this->type_register == 2){ //Staff
                	$criteria->compare('user.type_register', 3 , false);
                }
        }

		//search text
		if(isset($this->search) && $this->search != null) {
			$criteria->compare('Profiles.firstname', $this->search, true);
			$criteria->compare('Profiles.lastname', $this->search, true, 'OR');
			$criteria->compare('user.bookkeeper_id', $this->search, true, 'OR');
		}



                //check course category type
		if(isset($this->cate_id) && $this->cate_id != null) {
			$criteria->compare('courseonline.cate_id', $this->cate_id, false, 'AND');
		}
                
		//check generation
		if(isset($this->generation) && $this->generation != null) {
			$criteria->compare('Profiles.generation', $this->generation, true, 'OR');
		}
		//check memtype
		if(isset($this->memtype) && $this->memtype != null) {
			$criteria->compare('Profiles.type_user', $this->memtype, true, 'OR');
		}

		//check Divsion
		if(isset($this->division_id) && $this->division_id != null) {
			// $criteria->compare('user.division_id', $this->division_id, false, 'OR');
			$criteria->addIncondition('user.division_id',$this->division_id);
		}

		//check Department
		if(isset($this->department) && $this->department != null) {
			// $criteria->compare('user.department', $this->department, false, 'OR');
			$criteria->addIncondition('user.department_id',$this->department);
		}

		//check Station
		if(isset($this->station) && $this->station != null) {
			// $criteria->compare('user.station', $this->station, false, 'OR');
			$criteria->addIncondition('user.station_id',$this->station);
		}

		//check course id
		if(isset($this->passcours_cours) && $this->passcours_cours != null) {
			// $criteria->addInCondition('passcours_cours', $this->passcours_cours, 'AND');
			$criteria->compare('passcours_cours', $this->passcours_cours);
		}

		//check period start - end
		if(isset($this->period_start) && $this->period_start != null) {
			$criteria->addCondition('passcours_date >= "' . date('Y-m-d 00:00:00', strtotime($this->period_start)) . '"');
		}
		if(isset($this->period_end) && $this->period_end != null) {
			$criteria->addCondition('passcours_date <= "' . date('Y-m-d 23:59:59', strtotime($this->period_end)) . '"');
		}
		//provider array
		$poviderArray = array(
				'criteria' => $criteria
			);

		// Page
		if(isset($this->news_per_page)) {
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
                // Page
		if(isset($this->page_false)) {
			$poviderArray['pagination'] = FALSE;
		}
		//return
		return new CActiveDataProvider($this, $poviderArray);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->with=array('Profiles','CourseOnlines','user');

		if (!empty($this->user_name)) {
			$criteria->addSearchCondition( 'CONCAT( Profiles.firstname, " ", Profiles.lastname )', $this->user_name);
		} else {
			$criteria->compare('Profiles.firstname', $this->user_name, true);
		}

		if (!empty($this->passcours_date)) {
			$criteria->compare('passcours_date', ClassFunction::DateSearch($this->passcours_date), true);
		}

		$criteria->compare('course_title', $this->cours_name, true);
		$criteria->compare('passcours_id', $this->passcours_id, true);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page)) {
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

    public function getNameUser() 
    {
        return $this->Profiles->firstname.' '.$this->Profiles->lastname;
    } 

	public function getSaveFile()
	{

		//set variable
		$CourseSpecialType = $this->CourseOnlines->cates->special_category;
		$CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($CourseSpecialType === 'y') {
			$CertificateType = 'cpd';
		}

		//generate button
		echo CHtml::link('ดาวน์โหลด', 'javascript:void(0)',array(
				'submit' => array('//Passcours/PrintCertificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'UserId' => $this->passcours_user,
					'CertificateType' => $CertificateType,
					'Download' => true,
				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
			)); 
	}

	public function getPrintCertificate() {
		//set variable
		$CourseSpecialType = $this->CourseOnlines->cates->special_category;
		$CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($CourseSpecialType === 'y') {
			$CertificateType = 'cpd';
		}
		//generate button
		return CHtml::link('พิมพ์', 'javascript:void(0)', array(
				'submit' => array('//Passcours/PrintCertificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'UserId' => $this->passcours_user,
					'CertificateType' => $CertificateType,
				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
			));
	} 
        
        public function getPrintCertificatecpd() {
		//set variable
		$CourseSpecialType = $this->CourseOnlines->cates->special_category;
		$CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($CourseSpecialType === 'y') {
			$CertificateType = 'cpd';
		}
		//generate button
		return CHtml::link('พิมพ์', 'javascript:void(0)', array(
				'submit' => array('//PassCpd/PrintCertificate/'),
				'params' => array(
					'CourseId' => $this->passcours_cours,
					'UserId' => $this->passcours_user,
					'CertificateType' => $CertificateType,
				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
			));
	} 
        
        public function getDownloadIDCard() {		
		//check if this course is special (for cpd certificate)
		if($this->user->pic_cardid != '') {
                    $idcard = $this->user->pic_cardid;
                    //generate button
                    $id_user = $this->register->id;
                    $file = Yush::getUrl($this->register, Yush::SIZE_ORIGINAL, $idcard);
                    
//                    exit();
                    return CHtml::link('บัตรประชาชน', $file, array(
    //                                'download' => $id_user,
                                    'target' => '_blank',
                                    'class' => 'btn btn-warning',
                            ));
                }
                return '-';
	} 

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'passcours',
		    	'order' => ' passcours.passcours_id DESC ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'passcours',
		    	'order' => ' passcours.passcours_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Passcours.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'passcourscheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'passcourscheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'passcourscheck'=>array(
				    	'alias' => 'passcours',
				    	'condition' => 'lang_id = 1',
				    	'order' => ' passcours.passcours_id DESC ',
		            ),
			    );
			}
		}

		return $scopes;
    }

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

	public function PrintFileStatic() {

		$sql = " select * from tbl_passcours_log";

		//check period start - end
		if(isset($this->period_start) && $this->period_start != null) {
			$sql .= ' where pclog_date >= "' . date('Y-m-d 00:00:00', strtotime($this->period_start)) . '"';
		}
		if(isset($this->period_end) && $this->period_end != null) {
			$sql .= ' and pclog_date <= "' . date('Y-m-d 23:59:59', strtotime($this->period_end)) . '"';
		}

		$query = Yii::app()->db->createCommand($sql)->queryAll();

        return new CArrayDataProvider($query, $poviderArray);

	}
}
