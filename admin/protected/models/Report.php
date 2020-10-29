<?php

class Report extends CFormModel {

    public $typeOfUser;
    public $typeuser;
    public $university;
    public $company;
    public $categoryUniversity;
    public $categoryCompany;
    public $dateRang;
    public $period_start;
    public $period_end;
    public $course;
    public $department;
    public $nameSearch;
    public $user_id;
    public $company_id;
    public $division_id;
    public $position_id;
    public $courseArray;
    public $course_id;
    public $learnStatus;
    public $generation;
    public $search;
    public $lesson_id;
    public $station;
    public $schedule_id;
    public $type_user;
    public $type_register;
    public $gen_id;
    public $position;


    public function rules()
    {
        return array(
            array('period_start,period_end,typeOfUser,dateRang,course,nameSearch,university,company,categoryUniversity,categoryCompany,company_id,division_id,position_id,department,station,schedule_id,type_user,course_id, type_register, gen_id, position', 'safe'),
        );
    }


    public function attributeLabels(){
        return array(
            'typeOfUser' => 'ประเภทของสมาชิก',
            'dateRang' => 'เลือกระยะเวลา',
            'course' => 'หลักสูตร',
            'nameSearch' => 'ชื่อ - นามสกุล',
            'company_id' => 'หน่วยงาน',
            'division_id' => 'ฝ่าย',
            'position_id' => 'ตำแหน่ง',
            'search' => 'ค้นหา ชื่อ-นามสกุล ทั้งไทยและอังกฤษ',
            'period_start' => 'วันที่เริ่มต้น',
            'period_end' => 'วันที่สิ้นสุด',
            'generation' => 'เลือกรุ่น',
            'course_id' => 'เลือกหลักสูตร (บังคับ)',
            'lesson_id' => 'เลือกบทเรียน',
            'station' => 'สถานี',
            'schedule_id' => 'ตารางเรียน',
            'type_user' => 'ประเภทผู้ใช้งาน',

            'type_register'=>'ประเภทพนักงาน',
            'gen_id' => 'รุ่น  (บังคับ)',
            'department' => 'ฝ่าย',
            'position' => 'แผนก',
        );
    }

    /**
     * @return mixed
     */

    public function getAllOfUsers() {

        $sql = '';
        $sql .= 'select * from tbl_users';
        $sql .= ' inner join tbl_profiles on tbl_profiles.user_id = tbl_users.id';
        $sql .= ' left join tbl_profiles_title on tbl_profiles.title_id = prof_id';
        $sql .= ' left join tbl_type_user on tbl_type_user.id = tbl_profiles.type_user';
        $sql .= ' where tbl_users.superuser = "0" and tbl_users.status = "1"';
        $sql .= ' group by tbl_users.id';
        $sql .= ' order by tbl_profiles.firstname asc';

        $users = Yii::app()->db->createCommand($sql)->queryAll();

        return $users;

    }

    public function getTypeOfUserList()
    {
        $typeOfUserList = array(
            'company'=>'ผู้ประกอบวิชาชีพ',
            'university'=>'นิสิต/นักศึกษา'
        );
        return $typeOfUserList;
    }

    public function getUniversityList()
    {
        $university = TbUniversity::model()->findAll();
        $universityList = CHtml::listData($university,'id','name');

        return $universityList;
    }

    public function getCategoryUniiversityList()
    {
        $course = CourseOnline::model()->findAllByAttributes(array('active'=>'y'));
        $courseList = CHtml::listData($course,'course_id','course_title');

        return $courseList;
    }

    public function getDepartmentList()
    {
        $department = OrgChart::model()->findAll();
        $departmentList = CHtml::listData($department,'id','title');

        return $departmentList;
    }


    public function getCategoryCompanyList()
    {
        $category = Category::model()->findAllByAttributes(array('cate_type'=>'2'));
        $categoryList = CHtml::listData($category,'cate_id','cate_title');

        return $categoryList;
    }

    public function getCompanyList()
    {
        $companyList = Group::getList('company');

        return $companyList;
    }

    public function getCourseList()
    {
        $courseList = CHtml::listData(CourseOnline::model()->with('cates')->findAll('courseonline.active="y"'), 'course_id', 'CoursetitleConcat');
        return $courseList;
    }
    public function getCourseListFreedom()
    {
        $courseList = CHtml::listData(CourseOnline::model()->with('cates')->findAll('courseonline.active="y"'), 'course_id', 'course_title');
        return $courseList;
    }


    public function search()
    {
        $sql = " SELECT * FROM tbl_users ";
        $sql .= ' left join tbl_profiles on tbl_profiles.user_id = tbl_users.id';
        $sql .= ' left join tbl_type_user on tbl_type_user.id = tbl_profiles.type_user';
        $sql .= ' right join tbl_learn on tbl_learn.user_id = tbl_users.id';
        $sql .= " where tbl_users.status = '1'";
        
        if($this->user_id != null) {
            $sql .= ' and tbl_users.id = "' . $this->user_id . '"';
        }
        // print_r($this);exit();
        if($this->nameSearch != null) {
            $sql .= ' and (tbl_profiles.firstname like "%' . $this->nameSearch . '%" or tbl_profiles.lastname = "%' . $this->nameSearch . '%")';
        }
        if($this->typeuser != null) {
            $sql .= ' and tbl_profiles.type_user = "' . $this->typeuser . '"';
        }
    
        $sql .= ' group by tbl_users.id';

//        if($this->dateRang !='') {
//            $sql .= " AND authitem_name = '" . $this->typeOfUser . "' ";
//        }
        $rawData = Yii::app()->db->createCommand($sql)->queryAll();
        //or use ->queryAll(); in CArrayDataProvider
//        $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); //the count
        //$poviderArray = array('criteria'=>$criteria);

        /*$poviderArray = array( //or $model=new CArrayDataProvider($rawData, array(... //using with querAll...
            'keyField' => 'id',
            'totalItemCount' => $count,

            //if the command above use PDO parameters
            //'params'=>array(
            //':param'=>$param,
            //),


            'sort' => array(
                'attributes' => array(
                    'id','username', 'email'
                ),
                'defaultOrder' => array(
                    'id' => CSort::SORT_ASC, //default sort value
                ),
            )
        );

        if(isset($this->news_per_page))
        {
            $poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
        }*/

//        $model = new CSqlDataProvider($rawData, $poviderArray);
        return new CArrayDataProvider($rawData, $poviderArray);
        //return $rawData;
    }

    public function ByStatus() {

        $sql = " SELECT * FROM tbl_users ";
        $sql .= ' join tbl_profiles on tbl_profiles.user_id = tbl_users.id';
        $sql .= ' join tbl_type_user on tbl_type_user.id = tbl_profiles.type_user';
        $sql .= ' right join tbl_learn on tbl_learn.user_id = tbl_users.id';
        $sql .= " where tbl_users.status = '1'";

        if($this->user_id != null) {
            $sql .= ' and tbl_users.id = "' . $this->user_id . '"';
        }
        if($this->nameSearch != null) {
            $sql .= ' and tbl_profiles.firstname like "%' . $this->nameSearch . '%" or tbl_profiles.lastname like "%' . $this->nameSearch . '%"';
        }
        if($this->typeuser != null) {
            $sql .= ' and tbl_profiles.type_user = "' . $this->typeuser . '"';
        }
    
        $sql .= ' group by tbl_users.id';

        $providerArray = array();

		// Page
		if(isset($this->news_per_page)) {
			$providerArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

        $query = Yii::app()->db->createCommand($sql)->queryAll();

        return new CArrayDataProvider($query, $poviderArray);
    }

    public function ByCourse() {

        $sql = " select * from tbl_course_online";
        $sql .= " where tbl_course_online.active = 'y'";

        if($this->course_id != null) {
            $sql .= " and tbl_course_online.course_id = '" . $this->course_id . "'";
        }

        if($this->nameSearch != null) {
            $sql .= " and tbl_course_online.course_title like '%" . $this->nameSearch. "%'";
        }

        $providerArray = array();

		// Page
		if(isset($this->news_per_page)) {
			$providerArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

        $query = Yii::app()->db->createCommand($sql)->queryAll();

        return new CArrayDataProvider($query, $providerArray);

    }

    public function ByPlatform() {

        $sql = "select * from tbl_platform";

        $sql .= " group by user_device";

        $query = Yii::app()->db->createCommand($sql)->queryAll();

        return new CArrayDataProvider($query, $providerArray);

    }

    public function ByPlatformBrowser() {

        $sql = "select * from tbl_platform";

        $sql .= " group by user_browser";

        $query = Yii::app()->db->createCommand($sql)->queryAll();

        return new CArrayDataProvider($query, $providerArray);
    }
}